<?php

namespace App\Services\Admin\Member;

use App\Models\User;
use App\Exports\MemberExcel;
use App\Services\AppServices;
use App\Services\CommonServices;
use Illuminate\Http\Request;

/**
 * Class MemberServices
 * @package App\Services
 */
class MemberServices extends AppServices
{
    public function indexService(Request $request)
    {
        $query = User::orderByDesc('created_at');

        if ($request->uid) {
            $query->where('uid', 'like', "%{$request->uid}%");
        }

        // 엑셀 다운로드 할때
        if ($request->excel) {
            $this->data['total'] = $query->count();
            $this->data['collection'] = $query->lazy();
            return (new CommonServices())->excelDownload(new MemberExcel($this->data), '회원정보');
        }

        $list = $query->paginate(20);
        $this->data['list'] = setListSeq($list);

        return $this->data;
    }

    public function upsertService(Request $request)
    {
        $this->data['user'] = User::findOrFail($request->sid);

        return $this->data;
    }

    public function dataAction(Request $request)
    {
        switch ($request->case) {
            case 'user-update':
                return $this->dataAction($request);
                
            default:
                return notFoundRedirect();
        }
    }

    private function userUpdate(Request $request)
    {
//        $captchaResult = (new CommonServices())->captchaCheckService($request->captcha);
//
//        if ($captchaResult != 'suc') {
//            return $captchaResult;
//        }

        $this->transaction();

        try {
            $user = User::findOrFail($request->sid);
            $user->setByData($request);
            $user->update();

            $this->dbCommit('관리자 - 회원정보 수정');

            return $this->returnJsonData('alert', [
                'case' => true,
                'msg' => '회원정보가 수정 되었습니다.',
                'winClose' => $this->ajaxActionWinClose(true),
            ]);
        } catch (\Exception $e) {
            return $this->dbRollback($e);
        }
    }
}
