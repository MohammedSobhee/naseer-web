<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\CompleteServiceProviderRequest;
use App\Http\Requests\Api\User\ConfirmCodeRequest;
use App\Http\Requests\Api\User\GetRequest;
use App\Http\Requests\Api\User\LoginRequest;
use App\Http\Requests\Api\User\ResendConfirmCodeRequest;
use App\Http\Requests\Api\User\SignUpRequest;
use App\Http\Requests\Api\User\UpdateUserMobileRequest;
use App\Repositories\Eloquents\UserEloquent;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    private $user;

    public function __construct(UserEloquent $userEloquent)
    {
        $this->user = $userEloquent;
    }

    // generate access token
    public function access_token(LoginRequest $request)
    {
        return $this->user->access_token();
    }

    // generate refresh token
    public function refresh_token()
    {
        return $this->user->refresh_token();
    }

    // Sign up
    public function postUser(SignUpRequest $request)
    {
        return $this->user->create($request->all());
    }

    public function completeServiceProvider(CompleteServiceProviderRequest $request)
    {
        return $this->user->completeServiceProvider($request->all());
    }

    //     get User by id
    public function getProfile($id = null)
    {
        return $this->user->getById($id);
    }

    // post confirm code
    public function postConfirmCode(ConfirmCodeRequest $request)
    {
        return $this->user->confirm_code($request->all());
    }

//     resent confirm code
    public function resendConfirmCode(ResendConfirmCodeRequest $request)
    {
        return $this->user->resend_confirm_code($request->all());
    }

    public function putUserMobile(UpdateUserMobileRequest $request)
    {
        return $this->user->putMobile($request->all());
    }


    public function getClients(GetRequest $request)
    {
        return $this->user->getAll($request->all());
    }
    // logout user
    public function logout(Request $request)
    {
        return $this->user->logout();
    }

}
