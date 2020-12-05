<?php

namespace App\Http\Controllers\Admin;

use App\Exports\RequestsExport;
use App\Http\Controllers\Controller;
use App\Repositories\Eloquents\OrderEloquent;
use App\Request;
use App\Service;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class RequestController extends Controller
{
    private $order;

    public function __construct(OrderEloquent $order)
    {
//        parent::__construct();
        $this->order = $order;
    }

    public function index()
    {
        $data = [
            'title' => 'الطلبات',
            'icon' => 'icon-basket',
            'services' => Service::all(),
        ];
        return view(admin_vw() . '.requests.index', $data);
    }

    public function anyData()
    {
        return $this->order->anyData();
    }

    public function requestDet($order_id)
    {
        $data = [
            'title' => 'تفاصيل الطلب',
            'icon' => 'icon-users',
            'order_id' => $order_id,
            'order' => Request::with('City')->find($order_id),
        ];
        return view(admin_vw() . '.requests.offers', $data);
    }

    public function getContract($order_id)
    {
        $order = $this->order->getById($order_id);

        $data = [
            'title' => 'عقد اتفاق',
            'content' => $order->contract
        ];
        $pdf = PDF::loadView('admin.contracts.pdf', $data);
        return $pdf->stream('document.pdf');
    }

    public function export()
    {
        return Excel::download(new RequestsExport(), 'requests.xlsx');
    }
}
