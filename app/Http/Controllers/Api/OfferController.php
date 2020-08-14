<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Offer\CreateRequest;
use App\Http\Resources\OfferResource;
use App\Repositories\Eloquents\OfferEloquent;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    //

    private $offer;

    public function __construct(OfferEloquent $offerEloquent)
    {
        $this->offer = $offerEloquent;
    }

    public function create(CreateRequest $request)
    {
        return $this->offer->create($request->all());
    }

    public function show($id)
    {
        return $this->offer->getById($id);
    }
}
