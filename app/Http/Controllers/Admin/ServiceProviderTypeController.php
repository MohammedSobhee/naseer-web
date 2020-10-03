<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceProviderType\CreateRequest;
use App\Http\Requests\ServiceProviderType\UpdateRequest;
use App\Repositories\Eloquents\ServiceProviderTypeEloquent;
use App\ServiceProviderType;
use Illuminate\Http\Request;

class ServiceProviderTypeController extends Controller
{
    private $serviceProviderType;

    public function __construct(ServiceProviderTypeEloquent $serviceProviderType)
    {
//        parent::__construct();
        $this->serviceProviderType = $serviceProviderType;
    }

    public function index()
    {
        $data = [
            'title' => 'أنواع مزودي الخدمات',
            'icon' => 'icon-settings',
        ];
        return view(admin_vw() . '.constants.service_provider_types', $data);
    }

    public function anyData()
    {
        return $this->serviceProviderType->anyData();
    }

    public function edit($id)
    {

        $service_provider_type = $this->serviceProviderType->getById($id);

        $html = 'This service provider type does not exist';
        if (isset($service_provider_type)) {
            $view = view()->make(admin_vw() . '.modal', [
                'modal_id' => 'edit-service-provider-type',
                'modal_title' => 'تعديل نوع مزود الخدمة',

                'form' => [
                    'method' => 'PUT',
                    'url' => url(admin_constant_url() . '/service-provider-types/' . $id . '/edit'),
                    'form_id' => 'formEdit',

                    'fields' => [
                        'name' => 'text',
                    ],
                    'values' => [
                        'name' => $service_provider_type->name,

                    ],
                    'fields_ar' => [
                        'name' => 'نوع مزود الخدمة',
                    ]
                ]
            ]);

            $html = $view->render();
        }
        return $html;
    }

    public function update(UpdateRequest $request, $id)
    {
        return $this->serviceProviderType->update($request->all(), $id);
    }

    public function create()
    {
        $view = view()->make(admin_vw() . '.modal', [
            'modal_id' => 'add-service-provider-type',
            'modal_title' => 'اضافة نوع مزود خدمة جديد',
            'form' => [
                'method' => 'POST',
                'url' => url(admin_constant_url() . '/service-provider-types/create'),
                'form_id' => 'formAdd',
                'fields' => [
                    'name' => 'text',
                ],
                'fields_ar' => [
                    'name' => 'نوع مزود الخدمة',

                ]
            ]
        ]);

        $html = $view->render();

        return $html;
    }

    public function store(CreateRequest $request)
    {
        return $this->serviceProviderType->create($request->all());
    }

    public function delete($id)
    {

        return $this->serviceProviderType->delete($id);
    }
}
