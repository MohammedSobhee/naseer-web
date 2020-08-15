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

                if (request()->filled('username')) {
                    $query->where('username', 'LIKE', '%' . request()->get('username') . '%');
                }

                if (request()->filled('email')) {
                    $query->where('email', 'LIKE', '%' . request()->get('email') . '%');
                }

                if (request()->filled('status')) {
                    $query->where('status', request()->get('status'));
                }

            })
            ->editColumn('status', function ($user) {
                if ($user->status)
                    return '<input type="checkbox" class="make-switch" data-on-text="&nbsp;مفعّل&nbsp;" data-off-text="&nbsp;معطّل&nbsp;" name="is_active" data-id="' . $user->id . '" checked  data-on-color="success" data-size="mini" data-off-color="warning">';
                return '<input type="checkbox" class="make-switch" data-on-text="&nbsp;مفعّل&nbsp;" data-off-text="&nbsp;معطّل&nbsp;" name="is_active" data-id="' . $user->id . '" data-on-color="success" data-size="mini" data-off-color="warning">';
            })
            ->addColumn('action', function ($admin) {
                return '<a href="' . url(admin_vw() . '/admins/' . $admin->id . '/edit') . '" class="btn btn-sm btn-success purple btn-circle btn-icon-only edit-admin-mdl"
                                                                                   title="Edit">
                                                                                    <i class="fa fa-edit"></i>
                                                                                </a><a href="' . url(admin_vw() . '/admins/' . $admin->id) . '" class="btn btn-circle btn-icon-only red delete">
                                        <i class="fa fa-trash"></i>
                                    </a>';
            })->addIndexColumn()
            ->rawColumns(['action', 'status'])->toJson();
    }

    function adminStatus($id)
    {

        $admin = $this->model->find($id['admin_id']);

        if (isset($admin)) {
            $admin->status = !$admin->status;
            if ($admin->save()) {
//                if (!$admin->is_active) {
//                }
                return response_api(true, 200, null, $admin);
            }
        }
        return response_api(false, 422);

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

        $attributes['password'] = bcrypt($attributes['password']);
        $admin = Admin::create($attributes);
        return response_api(true, 200, trans('app.admin_created'), $admin);

//        return response_api(false, 422, trans('app.not_created'));
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

        if (isset($attributes['phone']) && $attributes['phone'] != '')
            $admin->phone = $attributes['phone'];
        if (isset($attributes['password']))
            $admin->password = bcrypt($attributes['password']);

        if ($admin->save()) {
            return response_api(true, 200, trans('app.updated'), $admin);

        }
        return response_api(false, 422, trans('app.not_updated'));
    }

    function delete($id)
    {
        // TODO: Implement delete() method.
        $admin = $this->model->where('type', 'admin')->find($id);

        if (isset($admin) && $admin->delete())
            return response_api(true, 200, trans('app.admin_deleted'), []);
        return response_api(false, 422, null, []);

    }

    function adminActivate($id)
    {
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
