<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Http\Resources\CountryResource;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\SubServiceResource;
use App\Intro;
use App\Repositories\Eloquents\CityEloquent;
use App\Repositories\Eloquents\CountryEloquent;
use App\Service;
use App\ServiceProvider;
use App\ServiceProviderType;
use App\Setting;
use App\SubService;
use Illuminate\Http\Request;

class LookUpController extends Controller
{
    //
    private $city, $country, $providerType, $intro, $service, $sub_service;

    public function __construct(CityEloquent $city, CountryEloquent $country, ServiceProviderType $providerType, Intro $intro, Service $service, SubService $subService)
    {
        $this->city = $city;
        $this->country = $country;
        $this->providerType = $providerType;
        $this->intro = $intro;
        $this->service = $service;
        $this->sub_service = $subService;
    }

    function getLookUps($type = null)
    {
        $data = [];
        if (isset($type)) {
            if ($type == 'service_provider_types') {
                $data = $this->providerType->all();
            }
            if ($type == 'intros') {
                $data = $this->intro->all();
            }
            if ($type == 'countries') {
                $data = CountryResource::collection($this->country->getAll([]));
            }
            if ($type == 'cities') {
                $data = CityResource::collection($this->city->getAll([]));
            }
            if ($type == 'terms') {

                $data = ['terms' => Setting::where('key', 'terms')->first()->value];
            }
        } else {

            $service_provider_types = $this->providerType->all();
            $intro = $this->intro->all();

            $data = [
                'service_provider_types' => $service_provider_types,
                'intros' => $intro,
                'countries' => CountryResource::collection($this->country->getAll([])),
                'cities' => CityResource::collection($this->city->getAll([])),
                'terms' => Setting::where('key', 'terms')->first()->value,
            ];
        }
        return response_api(true, 200, null, $data);
    }

    function getCities()
    {
        return response_api(true, 200, null, CityResource::collection($this->city->getAll([])));
    }

    function getCountries()
    {
        return response_api(true, 200, null, CountryResource::collection($this->country->getAll([])));
    }

    function getServices($service_type_id = null)
    {
        if (isset($service_type_id))
            return response_api(true, 200, null, ServiceResource::collection($this->service->where('service_provider_type_id', $service_type_id)->get()));
        return response_api(true, 200, null, ServiceResource::collection($this->service->all()));
    }

    function getSubServices($service_id)
    {
        return response_api(true, 200, null, SubServiceResource::collection($this->sub_service->where('service_id', $service_id)->get()));
    }

    // unused
    function getSubService($id)
    {
        return response_api(true, 200, null, $this->sub_service->find($id));
    }
}
