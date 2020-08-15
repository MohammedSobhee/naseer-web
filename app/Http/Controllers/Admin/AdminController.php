<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateAdminRequest;
use App\Http\Requests\Admin\UpdateRequest;
use App\Repositories\Eloquents\AdminEloquent;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $admin;

    public function __construct(AdminEloquent $adminEloquent)
    {
        $this->admin = $adminEloquent;
    }

    public function index()
    {
        //
        $data = [
            'title' => 'مديرو النظام',
            'icon' => 'fa fa-users',
        ];
        return view('admin.admins.index', $data);
    }

    public function anyData()
    {
        return $this->admin->anyData();
    }

    public function adminStatus(Request $request)
    {
        return $this->admin->adminStatus($request->only('admin_id'));
    }


    public function edit($id)
    {

        $admin = $this->admin->getById($id);

        $html = 'This admin does not exist';
        if (isset($admin)) {
            $view = view()->make(admin_vw() . '.modal', [
                'modal_id' => 'edit-admin',
                'modal_title' => 'تعديل مستخدم النظام',
//                'roles_id' => Role::all()->pluck('id')->toArray(),

                'form' => [
                    'method' => 'PUT',
                    'url' => url(admin_vw() . '/admins/' . $id . '/edit'),
                    'form_id' => 'formEdit',

                    'fields' => [
                        'name' => 'text',
                        'username' => 'text',
                        'phone' => 'text',
                        'email' => 'email',
                        'password' => 'password',
//                        'roles[]' => Role::all(),
                    ],
                    'values' => [
                        'name' => $admin->name,
                        'username' => $admin->username,
                        'phone' => $admin->phone,
                        'email' => $admin->email,
                        'password' => '',
//                        'roles[]' => $admin->roles()->get(),
//                        'role_res[]' => $admin->roles()->pluck('role_id')->toArray(),

                    ],
                    'fields_ar' => [
                        'name' => 'الاسم كامل',
                        'username' => 'اسم المستخدم',
                        'phone' => 'رقم الهاتف',
                        'email' => 'البريد الالكتروني',
                        'password' => 'كلمة المرور',
//                        'roles[]' => 'الصلاحيات',
                    ]
                ]
            ]);

            $html = $view->render();
        }
        return $html;
    }

    public function update(UpdateRequest $request, $id)
    {
        return $this->admin->update($request->all(), $id);
    }

    public function create()
    {
        // `name`, `username`, `phone`, `email`, `password`, `logo`, `type`, `status`
        $view = view()->make(admin_vw() . '.modal', [
            'modal_id' => 'add-admin',
            'modal_title' => 'اضافة مدير نظام جديد',
            'form' => [
                'method' => 'POST',
                'url' => url(admin_vw() . '/admins/create'),
                'form_id' => 'formAdd',
                'fields' => [
                    'name' => 'text',
                    'username' => 'text',
                    'phone' => 'text',
                    'email' => 'email',
                    'password' => 'password',
                ],
                'fields_ar' => [
                    'name' => 'الاسم كامل',
                    'username' => 'اسم المستخدم',
                    'phone' => 'رقم الهاتف',
                    'email' => 'البريد الالكتروني',
                    'password' => 'كلمة المرور',
                ]
            ]
        ]);

        $html = $view->render();

        return $html;
    }

    public function store(CreateAdminRequest $request)
    {
        return $this->admin->create($request->all());
    }

    public function delete($id)
    {

        return $this->admin->delete($id);
    }

}
