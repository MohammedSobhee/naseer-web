<?php

namespace App\Http\Controllers\Admin;

use App\Exports\RatesExport;
use App\Http\Controllers\Controller;
use App\Rate;
use App\Repositories\Eloquents\RateEloquent;
use App\Service;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
        $services = Service::all();
        $data = [
            'title' => 'التقييمات',
            'icon' => 'icon-star',
            'services' => $services,
        ];
        return view(admin_vw() . '.rates.index', $data);
    }


    public function anyData()
    {
        return $this->rate->anyData();
    }


    public function rateApproved(Request $request)
    {
        return $this->rate->rateApproved($request->only('rate_id'));
    }

    public function export()
    {
        return Excel::download(new RatesExport(), 'rates.xlsx');
    }
}
