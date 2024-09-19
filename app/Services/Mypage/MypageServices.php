<?php

namespace App\Services\Mypage;

use App\Models\User;
use App\Services\AppServices;
use App\Services\CommonServices;
use App\Services\Auth\AuthServices;
use Illuminate\Http\Request;

/**
 * Class MypageServices
 * @package App\Services
 */
class MypageServices extends AppServices
{
    public function indexService(Request $request)
    {
        return $this->data;
    }

    public function upsertService(Request $request)
    {
        $this->data['user'] = thisUser();
        $this->data['captcha'] = (new CommonServices())->captchaMakeService();

        return $this->data;
    }

    public function dataAction(Request $request)
    {
        switch ($request->case) {
            default:
                return notFoundRedirect();
        }
    }
}
