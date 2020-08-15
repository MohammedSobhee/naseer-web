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
//        parent::__construct();
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

    public function providers()
    {
        $data = [
            'title' => 'مقدمو الخدمات',
            'icon' => 'icon-users',
        ];
        return view(admin_vw() . '.users.providers', $data);
    }

    public function anyData($type)
    {
        return $this->user->anyData($type);
    }
    public function userActive(Request $request)
    {
        return $this->user->userActive($request->only('user_id'));
    }

    public function verifyPhone(Request $request)
    {
        return $this->user->verifyPhone($request->only('user_id'));
    }

    public function export()
    {
//        return $this->user->export();
    }
}
