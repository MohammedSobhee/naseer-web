<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Request;
use App\Repositories\Eloquents\OfferEloquent;

class OfferController extends Controller
{

    private $offer;

    public function __construct(OfferEloquent $offer)
    {
//        parent::__construct();
        $this->offer = $offer;
    }

    public function index($order_id)
    {
        $data = [
            'title' => 'العروض ( رقم الطلب - ' . $order_id . ')',
            'icon' => 'icon-users',
            'order_id' => $order_id,
            'order' => Request::with('City')->find($order_id),
        ];
        return view(admin_vw() . '.requests.offers', $data);
    }


    public function anyData($order_id)
    {
        return $this->offer->anyData($order_id);
    }
}
