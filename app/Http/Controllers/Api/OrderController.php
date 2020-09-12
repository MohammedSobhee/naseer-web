<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Order\ChangeStatusRequest;
use App\Http\Requests\Api\Order\CreateRequest;
use App\Http\Requests\Api\Order\GetOrderClientsRequest;
use App\Http\Requests\Api\Order\GetRequest;
use App\Repositories\Eloquents\OrderEloquent;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    private $order;

    public function __construct(OrderEloquent $orderEloquent)
    {
        $this->order = $orderEloquent;
    }

    public function postOrder(CreateRequest $request)
    {
        return $this->order->create($request->all());
    }

    public function getOrders(GetRequest $request)
    {
        return $this->order->getAll($request->all());
    }

    public function getOrderClients(GetOrderClientsRequest $request)
    {
        return $this->order->getOrderClients($request->all());
    }

    public function getOrder($order_id)
    {
        return $this->order->getById($order_id);
    }

    public function getEditOrder($order_id)
    {
        return $this->order->getEditOrder($order_id);
    }

    public function changeStatus(ChangeStatusRequest $request)
    {
        return $this->order->changeStatus($request->all());
    }
    public function delete($id)
    {
        return $this->order->delete($id);
    }
}
