<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\StoreProviderRequest;
use App\Http\Requests\Admin\User\UpdateProviderRequest;
use App\Http\Resources\ProfileResource;
use App\Repositories\Eloquents\UserEloquent;
use App\ServiceProviderType;
use http\Client\Curl\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //

    private $user;

    public function __construct(UserEloquent $user)
    {
//        parent::__construct();
        $this->user = $user;
    }

    public function index()
    {
        $data = [
            'title' => 'المستخدمين',
            'icon' => 'icon-users',
        ];
        return view(admin_vw() . '.users.index', $data);
    }

    public function providers()
    {
        $data = [
            'title' => 'مزودي الخدمات',
            'icon' => 'icon-users',
        ];
        return view(admin_vw() . '.users.providers', $data);
    }

    public function anyData($type)
    {
        return $this->user->anyData($type);
    }

    public function userActive(Request $request)
    {
        return $this->user->userActive($request->only('user_id'));
    }

    public function verifyPhone(Request $request)
    {
        return $this->user->verifyPhone($request->only('user_id'));
    }

    public function createProvider()
    {

        $cities = City::all();
        $service_provider_types = ServiceProviderType::all();
        $data = [
            'title' => 'مزود خدمة جديد',
            'icon' => 'fa fa-user-plus',
            'cities' => $cities,
            'service_provider_types' => $service_provider_types,
        ];
        return view(admin_vw() . '.users.add-provider', $data);
//        return $this->user->provider_create_mdl();
    }

    public function editProvider($id)
    {

        $user = User::find($id);
        $cities = City::all();
        $service_provider_types = ServiceProviderType::all();
        $data = [
            'user' => $user,
            'title' => 'مزود خدمة',
            'icon' => 'fa fa-user-plus',
            'cities' => $cities,
            'service_provider_types' => $service_provider_types,
        ];
        return view(admin_vw() . '.users.edit-provider', $data);
//        return $this->user->provider_create_mdl();
    }

    public function storeProvider(StoreProviderRequest $request)
    {
        return $this->user->storeProvider($request->all());
    }

    public function updateProvider(UpdateProviderRequest $request, $id)
    {
        return $this->user->updateProvider($request->all(), $id);
    }

    public function profile($id)
    {
        $user = $this->user->getById($id);

        if ($user->type == 'service_provider') {
            $data = [
                'title' => 'عرض تفاصيل مزود الخدمة',
                'icon' => 'icon-users',
                'user' => $user,
            ];
            return view(admin_vw() . '.users.view-provider', $data);
        } else {
            $data = [
                'title' => 'عرض تفاصيل المستخدم',
                'icon' => 'icon-users',
                'user' => $user,
            ];
            return view(admin_vw() . '.users.view-user', $data);

        }

    }

    public function confirmUpdateProvider(Request $request, $id)
    {
        return $this->user->confirmUpdateProvider($request->all(), $id);
    }

    public function rejectUpdateProvider(Request $request, $id)
    {
        return $this->user->rejectUpdateProvider($request->all(), $id);
    }

    public function export()
    {
//        return $this->user->export();
    }
}
