<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Rate\CreateRequest;
use App\Repositories\Eloquents\RateEloquent;
use Illuminate\Http\Request;

class RateController extends Controller
{
    //

    private $rate;

    public function __construct(RateEloquent $rateEloquent)
    {
        $this->rate = $rateEloquent;
    }

    public function create(CreateRequest $request)
    {
        return $this->rate->create($request->all());
    }

}
