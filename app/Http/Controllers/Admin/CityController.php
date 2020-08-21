<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Http\Controllers\Controller;
use App\Http\Requests\City\CreateRequest;
use App\Http\Requests\City\UpdateRequest;
use App\Repositories\Eloquents\CityEloquent;
use Illuminate\Http\Request;

class CityController extends Controller
{
    private $city;

    public function __construct(CityEloquent $city)
    {
//        parent::__construct();
        $this->city = $city;
    }

    public function index()
    {
        $data = [
            'title' => 'المدينة',
            'icon' => 'icon-settings',
        ];
        return view(admin_vw() . '.constants.cities', $data);
    }

    public function anyData()
    {
        return $this->city->anyData();
    }

    public function edit($id)
    {

        $city = $this->city->getById($id);

        $html = 'This city does not exist';
        if (isset($city)) {
            $view = view()->make(admin_vw() . '.modal', [
                'modal_id' => 'edit-city',
                'modal_title' => 'تعديل المدينة',

                'form' => [
                    'method' => 'PUT',
                    'url' => url(admin_constant_url() . '/cities/' . $id . '/edit'),
                    'form_id' => 'formEdit',

                    'fields' => [
                        'name' => 'text',
                    ],
                    'values' => [
                        'name' => $city->name,

                    ],
                    'fields_ar' => [
                        'name' => 'المدينة',
                    ]
                ]
            ]);

            $html = $view->render();
        }
        return $html;
    }

    public function update(UpdateRequest $request, $id)
    {
        return $this->city->update($request->all(), $id);
    }

    public function create()
    {
        $view = view()->make(admin_vw() . '.modal', [
            'modal_id' => 'add-city',
            'modal_title' => 'اضافة مدينة جديد',
            'form' => [
                'method' => 'POST',
                'url' => url(admin_constant_url() . '/cities/create'),
                'form_id' => 'formAdd',
                'fields' => [
                    'name' => 'text',
                ],
                'fields_ar' => [
                    'name' => 'المدينة',

                ]
            ]
        ]);

        $html = $view->render();

        return $html;
    }

    public function store(CreateRequest $request)
    {
        return $this->city->create($request->all());
    }

    public function delete($id)
    {

        return $this->city->delete($id);
    }
}
