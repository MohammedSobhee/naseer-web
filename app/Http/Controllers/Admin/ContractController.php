<?php

namespace App\Http\Controllers\Admin;

use App\Contract;
use App\ContractService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Contract\CreateFieldRequest;
use App\Http\Requests\Contract\CreateRequest;
use App\Repositories\Eloquents\ContractEloquent;
use App\Service;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    private $contract;

    public function __construct(ContractEloquent $contract)
    {
//        parent::__construct();
        $this->contract = $contract;
    }

    public function index()
    {
        $data = [
            'title' => 'العقود',
            'icon' => 'icon-book-open',
        ];
        return view(admin_vw() . '.contracts.index', $data);
    }

    public function anyData()
    {
        return $this->contract->anyData();
    }

    public function create()
    {
        $selected_services = ContractService::pluck('service_id')->unique()->toArray();

        $data = [
            'title' => 'اضافة عقد جديد',
            'icon' => 'icon-book-open',
            'services' => Service::whereNotIn('id', $selected_services)->get(),
        ];
        return view(admin_vw() . '.contracts.add', $data);
    }

    public function store(CreateRequest $request)
    {
        return $this->contract->create($request->all());
    }

    public function completeContract($id)
    {
        $contract = $this->contract->getById($id);

        $selected_services = $contract->Services->pluck('service_id')->toArray();

        dd($selected_services);
        $contract_services = ContractService::whereNotIn('id', $selected_services)->pluck('service_id')->unique()->toArray();
        $data = [
            'title' => 'اكمال العقد',
            'icon' => 'icon-book-open',
            'services' => Service::whereNotIn('id', $contract_services)->get(),
            'selected_services' => $selected_services,
            'contract' => $contract,
        ];
        return view(admin_vw() . '.contracts.edit', $data);
    }

    public function edit($id)
    {
        $contract = $this->contract->getById($id);

        $selected_services = $contract->Services->pluck('service_id')->toArray();
        $contract_services = ContractService::whereNotIn('id', $selected_services)->pluck('service_id')->unique()->toArray();
        $data = [
            'title' => 'اكمال العقد',
            'icon' => 'icon-book-open',
            'services' => Service::whereNotIn('id', $contract_services)->get(),
            'selected_services' => $selected_services,
            'contract' => $contract,
        ];
        return view(admin_vw() . '.contracts.edit', $data);
    }

    public function update(CreateRequest $request, $id)
    {
        return $this->contract->update($request->all(), $id);
    }

    public function addField(CreateFieldRequest $request, $id)
    {
        return $this->contract->addField($request->all(), $id);
    }
}
