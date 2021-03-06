<?php
/**
 * Created by PhpStorm.
 * UserRequest: mohammedsobhei
 * Date: 5/2/18
 * Time: 11:43 PM
 */

namespace App\Repositories\Eloquents;

use App\City;
use App\Intro;
use App\Repositories\Interfaces\Repository;
use App\Repositories\Uploader;


class IntroEloquent extends Uploader implements Repository
{

    private $model;

    public function __construct(Intro $model)
    {
        $this->model = $model;

    }

    function anyData()
    {
        $data = $this->model->orderByDesc('id');
        return datatables()->of($data)
            ->filter(function ($query) {
                if (request()->filled('title')) {
                    $query->where('title', 'LIKE', '%' . request()->get('title') . '%');
                }
            })
            ->editColumn('image', function ($intro) {
                return '<img src="' . $intro->image . '" width="70%">';
            })
            ->addColumn('action', function ($intro) {
                return '<a href="' . url(admin_constant_url() . '/intros/' . $intro->id . '/edit') . '" class="btn btn-sm btn-success purple btn-circle btn-icon-only edit-intro-mdl"
                                                                                   title="تعديل">
                                                                                    <i class="fa fa-edit"></i>
                                                                                </a><a href="' . url(admin_constant_url() . '/intros/' . $intro->id) . '" class="btn btn-sm btn-danger red btn-circle btn-icon-only delete"
                                                                                   title="حذف">
                                                                                    <i class="fa fa-trash"></i>
                                                                                </a>';
            })->addIndexColumn()
            ->rawColumns(['action', 'image'])->toJson();
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
        if (request()->segment(1) == 'api') {
            // TODO: Implement getById() method.
            $obj = $this->model->find($id);
            if (isset($obj))
                return response_api(true, 200, null, $obj);
            return response_api(false, 422, trans('app.not_data_found'), []);
        }
        return $this->model->find($id);

    }

    function create(array $attributes)
    {
        // TODO: Implement create() method.
        $intro = new Intro();
        $intro->title = $attributes['title'];
        $intro->description = $attributes['description'];

        if ($intro->save()) {
            if (isset($attributes['image'])) {
                $intro->image = $this->storeImageThumb('intros', $intro->id, $attributes['image']);
                $intro->save();

            }

            return response_api(true, 200, trans('app.created'), $intro);

        }
        return response_api(false, 422, trans('app.not_created'));

    }

    function update(array $attributes, $id = null)
    {
        // TODO: Implement update() method.
        $intro = $this->model->find($id);
        $intro->title = $attributes['title'];
        $intro->description = $attributes['description'];

        if ($intro->save()) {
            if (isset($attributes['image'])) {
                $intro->image = $this->storeImageThumb('intros', $intro->id, $attributes['image']);
                $intro->save();
            }

            return response_api(true, 200, trans('app.updated'), $intro);

        }
        return response_api(false, 422, trans('app.not_updated'));


    }

    function delete($id)
    {
        // TODO: Implement delete() method.
        $obj = $this->model->find($id);
        if (isset($obj) && $obj->delete()) {
            return response_api(true, 200, trans('app.deleted'), []);
        }
        return response_api(false, 422, null, []);

    }
}
