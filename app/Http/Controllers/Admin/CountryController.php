<?php

namespace App\Http\Controllers\Admin;

use App\Exports\Constant\CountriesExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Country\CreateRequest;
use App\Http\Requests\Country\UpdateRequest;
use App\Repositories\Eloquents\CountryEloquent;
use Maatwebsite\Excel\Facades\Excel;

class CountryController extends Controller
{

    private $country;

    public function __construct(CountryEloquent $country)
    {
//        parent::__construct();
        $this->country = $country;
    }

    public function index()
    {
        $data = [
            'title' => 'الدولة',
            'icon' => 'icon-settings',
        ];
        return view(admin_vw() . '.constants.countries', $data);
    }

    public function anyData()
    {
        return $this->country->anyData();
    }

    public function edit($id)
    {

        $country = $this->country->getById($id);

        $html = 'This country does not exist';
        if (isset($country)) {
            $view = view()->make(admin_vw() . '.modal', [
                'modal_id' => 'edit-country',
                'modal_title' => 'تعديل الدولة',

                'form' => [
                    'method' => 'PUT',
                    'url' => url(admin_constant_url() . '/countries/' . $id . '/edit'),
                    'form_id' => 'formEdit',

                    'fields' => [
                        'name' => 'text',
                    ],
                    'values' => [
                        'name' => $country->name,

                    ],
                    'fields_ar' => [
                        'name' => 'الدولة',
                    ]
                ]
            ]);

            $html = $view->render();
        }
        return $html;
    }

    public function update(UpdateRequest $request, $id)
    {
        return $this->country->update($request->all(), $id);
    }

    public function create()
    {
        $view = view()->make(admin_vw() . '.modal', [
            'modal_id' => 'add-country',
            'modal_title' => 'اضافة مدينة جديد',
            'form' => [
                'method' => 'POST',
                'url' => url(admin_constant_url() . '/countries/create'),
                'form_id' => 'formAdd',
                'fields' => [
                    'name' => 'text',
                ],
                'fields_ar' => [
                    'name' => 'الدولة',

                ]
            ]
        ]);

        $html = $view->render();

        return $html;
    }

    public function store(CreateRequest $request)
    {
        return $this->country->create($request->all());
    }

    public function delete($id)
    {

        return $this->country->delete($id);
    }

    public function export()
    {
        return Excel::download(new CountriesExport(), 'countries.xlsx');
    }
}
