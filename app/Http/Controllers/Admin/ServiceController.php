<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ServicesExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Service\UpdateRequest;
use App\Repositories\Eloquents\ServiceEloquent;
use App\Service;
use App\ServiceProviderType;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ServiceController extends Controller
{

    private $service;

    public function __construct(ServiceEloquent $service)
    {
//        parent::__construct();
        $this->service = $service;
    }

    public function index()
    {
        $data = [
            'title' => 'الخدمات المزودة',
            'icon' => 'icon-layers',
            'service_provider_types' => ServiceProviderType::all(),
        ];
        return view(admin_vw() . '.services.index', $data);
    }

    public function anyData()
    {
        return $this->service->anyData();
    }

    public function edit($id)
    {

        $service = $this->service->getById($id);

        $html = 'This service does not exist';
        if (isset($service)) {
            $view = view()->make(admin_vw() . '.modal', [
                'modal_id' => 'edit-service',
                'modal_title' => 'تعديل الخدمة',
//                'roles_id' => Role::all()->pluck('id')->toArray(),

                'form' => [
                    'method' => 'PUT',
                    'url' => url(admin_vw() . '/services/' . $id . '/edit'),
                    'form_id' => 'formEdit',

                    'fields' => [
                        'name' => 'text',
                        'service_provider_type_id' => ServiceProviderType::all(),
                    ],
                    'values' => [
                        'name' => $service->name,
                        'service_provider_type_id' => $service->service_provider_type_id,

                    ],
                    'fields_ar' => [
                        'name' => 'الخدمة',
                        'service_provider_type_id' => 'نوع مزود الخدمة',
                    ]
                ]
            ]);

            $html = $view->render();
        }
        return $html;
    }

    public function update(UpdateRequest $request, $id)
    {
        return $this->service->update($request->all(), $id);
    }

    public function export()
    {
        return Excel::download(new ServicesExport(), 'services.xlsx');
    }
}
