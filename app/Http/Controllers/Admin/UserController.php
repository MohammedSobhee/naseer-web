<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Eloquents\UserEloquent;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //

    private $user;

    public function __construct(UserEloquent $user)
    {
        parent::__construct();
        $this->user = $user;
    }

    public function index()
    {
        $data = [
            'title' => 'المستخدمين',
            'icon' => 'icon-users',
        ];
        return view(admin_vw() . '.users.index', $data);
    }

    public function anyData()
    {
//        return $this->user->anyData();
    }

//    public function userDet($id)
//    {
//        $user = $this->user->getById($id);
//        $data = [
//            'title' => 'المستخدمين',
//            'sub_title' => 'تفاصيل المستخدم',
//            'icon' => 'icon-users',
//            'user' => $user,
//            'back_url' => url(admin_vw() . '/users')
//        ];
//
//
//        return view(admin_vw() . '.users.view', $data);
//    }


    public function userActive(Request $request)
    {
        return $this->user->userActive($request->only('user_id'));
    }


    public function verifyEmail(Request $request)
    {
        return $this->user->verifyEmail($request->only('user_id'));
    }
    public function export()
    {
//        return $this->user->export();
    }
}
