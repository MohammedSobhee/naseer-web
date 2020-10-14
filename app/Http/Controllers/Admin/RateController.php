<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Rate;
use App\Repositories\Eloquents\RateEloquent;
use Illuminate\Http\Request;

class RateController extends Controller
{

    private $rate;

    public function __construct(RateEloquent $rate)
    {
//        parent::__construct();
        $this->rate = $rate;
    }

    public function index()
    {
        $data = [
        ];
        return view(admin_vw() . '.rates.index', $data);
    }


    public function anyData()
    {
        return $this->rate->anyData();
    }
}
