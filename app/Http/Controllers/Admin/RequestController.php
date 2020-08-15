<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Eloquents\OrderEloquent;
use App\Request;
use App\Service;

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
            'icon' => 'icon-users',
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

}
