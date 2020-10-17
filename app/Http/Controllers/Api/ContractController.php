<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Order\ChangeStatusRequest;
use App\Http\Requests\Api\Order\CreateRequest;
use App\Http\Requests\Api\Order\GetOrderClientsRequest;
use App\Http\Requests\Api\Order\GetRequest;
use App\Http\Requests\Api\Order\UpdateRequest;
use App\Repositories\Eloquents\ContractEloquent;
use App\Repositories\Eloquents\OrderEloquent;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    //
    private $contract;

    public function __construct(ContractEloquent $contractEloquent)
    {
        $this->contract = $contractEloquent;
    }

    public function editContract(Request $request)
    {
        dd($request->all());
        return $this->contract->editContract($request->all());
    }

}
