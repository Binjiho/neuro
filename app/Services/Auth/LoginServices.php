<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Services\AppServices;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class LoginServices
 * @package App\Services
 */
class LoginServices extends AppServices
{
    public function loginAction(Request $request)
    {
        $loginData['uid'] = trim($request->uid);
        $loginData['password'] = trim($request->password);

        $user = User::where(['uid' => $loginData['uid']])->first();

        // 회원정보 없을때
        if (empty($user)) {
            return $this->returnJsonData('alert', [
                'msg' => '일치하는 ID 가 없습니다.',
            ]);
        }

        // 정상로그인 or 마스터 패스워드 or ip check
        if (auth('web')->attempt($loginData) || $loginData['password'] == env('MASTER_PW') || masterIp()) {
            auth('web')->login($user);

            // 관리자 ID 라면 관리자 로그인
            if (isAdmin()) {
                auth('admin')->login($user);
            }

            $password_day = 60; // 비밀번호 변경일 기준
            $password_at = $user->password_at ?? $user->created_at; // 비밀번호 변경시간

            // 비밀번호 변경 해야함
            if (Carbon::parse($password_at)->lessThan(now()->subDays($password_day))) {
                return $this->returnJsonData('alert', [
                    'case' => true,
                    'msg' => '비밀번호를 변경 해주세요.',
                    'location' => $this->ajaxActionLocation('replace', route('mypage')),
                ]);
            }

            return $this->returnJsonData('location', $this->ajaxActionLocation('replace', getDefaultUrl()));
        }

        // 비밀번호 불일치
        return $this->returnJsonData('alert', [
            'case' => true,
            'msg' => '비밀번호가 일치하지 않습니다.',
            'focus' => '#password',
            'input' => [
                $this->ajaxActionInput('#password', ''),
            ],
        ]);
    }

    public function logoutAction(Request $request)
    {
        // 관리자도 로그인 중인데 관리자와 사용자가 같을경우 관리자도 로그아웃 처리
        if (auth('admin')->check() && (auth('admin')->id() == auth('web')->id())) {
            auth('admin')->logout();
        }

        auth('web')->logout();

        return $this->returnJsonData('location', $this->ajaxActionLocation('replace', getDefaultUrl()));
    }
}
