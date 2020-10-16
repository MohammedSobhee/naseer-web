<?php

namespace App\Http\Controllers\Admin;

use App\Contract;
use App\Http\Controllers\Controller;
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
        $data = [
            'title' => 'اضافة عقد جديد',
            'icon' => 'icon-book-open',
            'services' => Service::all(),
        ];
        return view(admin_vw() . '.contracts.add', $data);
    }
}
