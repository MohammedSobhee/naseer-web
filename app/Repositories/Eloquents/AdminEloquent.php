<?php
/**
 * Created by PhpStorm.
 * UserRequest: mohammedsobhei
 * Date: 5/2/18
 * Time: 11:43 PM
 */

namespace App\Repositories\Eloquents;

use App\Admin;
use App\Repositories\Interfaces\Repository;

class AdminEloquent implements Repository
{

    private $model;

    public function __construct(Admin $model)
    {
        $this->model = $model;
    }

    function anyData()
    {
        $admins = $this->model->orderByDesc('created_at')->where('id', '<>', 1);

        return datatables()->of($admins)
            ->filter(function ($query) {

                if (request()->filled('name')) {
                    $query->where('name', 'LIKE', '%' . request()->get('name') . '%');
                }

                if (request()->filled('email')) {
                    $query->where('email', 'LIKE', '%' . request()->get('email') . '%');
                }

                if (request()->filled('level')) {
                    $query->where('level', request()->get('level'));
                }

            })
            ->editColumn('level', function ($admin) {

                return ($admin->level == 'admin') ? 'Admin' : 'Player';
            })
            ->editColumn('is_active', function ($admin) {
                return ($admin->is_active == 1) ? '<span class="m-badge m-badge--success m-badge--wide">active</span>' : '<span class="m-badge m-badge--danger m-badge--wide">inactive</span>';
            })
            ->addColumn('action', function ($admin) {

//                $delete = '';
//                if ($admin->level != 'super_admin')
//                    $delete = '<a href="' . url(admin_manage_url() . '/admin/' . $admin->id) . '" class="btn btn-danger  m-btn m-btn--icon m-btn--icon-only m-btn--pill delete "> <i class="fa fa-trash"></i></a>';
////
//                $checked='';
//                if($admin->is_active)
//                    $checked='checked="checked"';
//                $activate= '<span class="m-switch m-switch m-switch--outline m-switch--icon m-switch--success" style="margin-left:3px;margin-top: 10px;vertical-align: middle;"><label><input type="checkbox"'.$checked .' name="is_active" class="is_active" data-id="'.$admin->id.'"><span></span></label></span>';
//
//                return $activate . '<a href="' . url(admin_manage_url() . '/admin/' . $admin->id . '/edit') . '" class="btn btn-primary m-btn m-btn--icon m-btn--icon-only m-btn--pill margin-right edit-admin-mdl"><i class="fa fa-edit"></i></a>' .  $delete ;
            })->addIndexColumn()
            ->rawColumns(['action', 'is_active'])->toJson();
    }

    function export()

    {


    }

    function getAll(array $attributes)
    {
        // TODO: Implement getAll() method.
        return $this->model->all();
    }

    function getById($id)
    {
        // TODO: Implement getById() method.
        return $this->model->find($id);
    }

    function create(array $attributes)
    {
        // TODO: Implement create() method.
        $admin = new Admin();
        $admin->username = $attributes['username'];
        $admin->email = $attributes['email'];
        $admin->name = $attributes['name'];
        $admin->password = bcrypt($attributes['password']);
        if ($admin->save()) {

            $admin = $this->model->find($admin->id);

//            if ($admin->level == 'admin') {
//                // user has one roles in my case
//                if (count($admin->roles) > 0) {
//                    $admin->detachRoles($admin->roles);
//                }
//
//                foreach ($attributes['role'] as $role)
//                    $admin->attachRole($role);
//            }


            return response_api(true, 200, trans('app.admin_created'), $admin);

        }
        return response_api(false, 422, trans('app.not_created'));
    }

    function update(array $attributes, $id = null)
    {
        // TODO: Implement update() method.

        $admin = $this->model->find($id);

        if (isset($attributes['username']))
            $admin->username = $attributes['username'];
        if (isset($attributes['name']))
            $admin->name = $attributes['name'];

        if (isset($attributes['email']))
            $admin->email = $attributes['email'];

        if (isset($attributes['mobile']) && $attributes['mobile'] != '')
            $admin->mobile = $attributes['mobile'];
//        if (isset($attributes['password']))
//            $admin->password = bcrypt($attributes['password']);

        if ($admin->save()) {

//            if ($admin->level == 'admin') {
//                // user has one roles in my case
//                if (count($admin->roles) > 0) {
//                    $admin->detachRoles($admin->roles);
//                }
//
//                foreach ($attributes['role'] as $role)
//                    $admin->attachRole($role);
//            }
            return response_api(true, 200, trans('app.updated'), $admin);

        }
        return response_api(false, 422, trans('app.not_updated'));
    }

    function delete($id)
    {
        // TODO: Implement delete() method.
        $admin = $this->model->where('level', 'admin')->find($id);

        if (isset($admin) && $admin->delete())
            return response_api(true, 200, trans('app.admin_deleted'), []);
        return response_api(false, 422, null, []);

    }

    function adminActivate($id){
        $admin = $this->model->find($id['admin_id']);
        if (isset($admin)) {
            $admin->is_active = !$admin->is_active;

            if ($admin->save()) {
                if (!$admin->is_active) {
                    $action = 'admin_deactivated';
                    return response_api(true, 200);

                }
                return response_api(true, 200);
            }
        }
        return response_api(false, 422);
    }

    function count()
    {
        return $this->model->count();
    }


}
