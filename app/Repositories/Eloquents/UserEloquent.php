<?php
/**
 * Created by PhpStorm.
 * UserRequest: mohammedsobhei
 * Date: 5/2/18
 * Time: 11:43 PM
 */

namespace App\Repositories\Eloquents;

use App\DeviceToken;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProfileResource;
use App\Offer;
use App\Repositories\Interfaces\UserRepository;
use App\Repositories\Uploader;
use App\Service;
use App\ServiceProvider;
use App\ServiceProviderType;
use App\User;
use Carbon\Carbon;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Lcobucci\JWT\Parser;
use Mail;

class UserEloquent extends Uploader implements UserRepository
{

    private $model, $deviceToken, $notificationSystem, $serviceProvider;

    public function __construct(User $model, ServiceProvider $serviceProvider, DeviceToken $deviceToken, NotificationSystemEloquent $notificationSystemEloquent)
    {
        $this->model = $model;
        $this->deviceToken = $deviceToken;
        $this->notificationSystem = $notificationSystemEloquent;
        $this->serviceProvider = $serviceProvider;
    }

// generate access token
    public function access_token()
    {
        $proxy = Request::create(
            'oauth/token',
            'POST'
        );

        $response = Route::dispatch($proxy);

        $token_obj = json_decode($response->getContent());

//        $statusCode = json_decode($response->getStatusCode());

        if (isset($token_obj->error)) {

            return [
                'status' => false,
                'statusCode' => 401,
                'message' => __('app.unauthorized'),
                'items' => empObj()
            ];
        }
        if (!isset($token_obj->access_token))
            return [
                'status' => false,
                'statusCode' => 422,
                'message' => __('app.unauthorized'),
                'items' => empObj()
            ];

        \request()->headers->set('Accept', 'application/json');
        \request()->headers->set('Authorization', 'Bearer ' . $token_obj->access_token);
//
        $request = \request()->create(
            'api/v1/profile',
            'GET'
        );
        $response = Route::dispatch($request);

        $data = json_decode($response->getContent());
        $statusCode = json_decode($response->getStatusCode());

        if ($statusCode == 200) {
            $user = $data->items;
        }

//        $token = empObj();

        if (!isset($user)) {
            return response_api(false, 422, __('auth.failed'), empObj());
        }
        if (!$user->is_active) {
            return response_api(false, 407, 'تم ايقاف حسابك', empObj());
        }
        if (!$user->is_verify) {
            return response_api(false, 405, 'تحقق من كود التحقق', ['token' => empObj(), 'user' => $user]);
        }

        $token = empObj();
//
        $token->token_type = $token_obj->token_type;
        $token->expires_in = $token_obj->expires_in;
        $token->access_token = $token_obj->access_token;
        $token->refresh_token = $token_obj->refresh_token;


        if (\request()->filled('device_type')) {
            $device = $this->deviceToken->where('user_id', $user->id)->where('device_id', \request()->get('device_id'))->first();
            if (!isset($device))
                // register device token
                $device = new DeviceToken();
            $device->user_id = $user->id;

            if (\request()->filled('device_id'))
                $device->device_id = \request()->get('device_id');
            $device->device_token = \request()->get('device_token');
            $device->type = \request()->get('device_type');
            $device->status = 'on';

            $device->save();

        }
        return [
            'status' => true,
            'statusCode' => 200,
            'message' => trans('app.success'),
            'items' => ['token' => $token, 'user' => $user]
        ];

    }

    // generate refresh token
    public function refresh_token()
    {

        $proxy = Request::create(
            'oauth/token',
            'POST'
        );

        $response = Route::dispatch($proxy);

        $token_obj = json_decode($response->getContent());
        $statusCode = json_decode($response->getStatusCode());

        if (isset($token_obj->error)) {
            return [
                'status' => false,
                'statusCode' => $statusCode,
                'message' => $token_obj->message,
                'items' => empObj()
            ];
        }

        \request()->headers->set('Accept', 'application/json');
        \request()->headers->set('Authorization', 'Bearer ' . $token_obj->access_token);
//
        $request = \request()->create(
            'api/v1/profile',
            'GET'
        );
//
        $token = empObj();
//
        $token->token_type = $token_obj->token_type;
        $token->expires_in = $token_obj->expires_in;
        $token->access_token = $token_obj->access_token;
        $token->refresh_token = $token_obj->refresh_token;

        $response = Route::dispatch($request);

        $data = json_decode($response->getContent());
        $statusCode = json_decode($response->getStatusCode());

        if ($statusCode == 200) {
            $user = $data->items;
        }

        return [
            'status' => true,
            'statusCode' => 200,
            'message' => trans('app.success'),
            'items' => [
                'token' => $token, 'user' => $user
            ]
        ];
    }

    function userActive($id)
    {

        $user = $this->model->find($id['user_id']);

        if (isset($user)) {
            $user->is_active = !$user->is_active;

            if ($user->save()) {
                if (!$user->is_active) {
//                    $action = 'user_deactivate';
//                    $this->notificationSystem->sendNotification(null, $user->id, $user->id, $action);
                    $this->logout($user->id);
                    return response_api(true, 200);

                }
                return response_api(true, 200);
            }
        }
        return response_api(false, 422);

    }

    function anyData($type)
    {
        $users_id = $this->model->whereNotNull('master_id')->pluck('master_id')->toArray();
        $users_id = implode(',', $users_id);

        if (isset($users_id) && $users_id != '') {
            $users = $this->model->with('City')->where('type', $type)->whereNull('master_id')->orderByRaw("FIELD(id, $users_id) DESC");//->orderByDesc('created_at');
        } else
            $users = $this->model->with('City')->where('type', $type)->whereNull('master_id')->orderByDesc('updated_at');

        return datatables()->of($users)
            ->filter(function ($query) {

                if (request()->filled('name')) {
                    $query->where('name', 'LIKE', '%' . request()->get('name') . '%');
                }

                if (request()->filled('email')) {
                    $query->where('email', 'LIKE', '%' . request()->get('email') . '%');
                }

                if (request()->filled('phone')) {
                    $query->where('phone', 'LIKE', '%' . request()->get('phone') . '%');
                }

                if (request()->filled('is_active')) {
                    $query->where('is_active', request()->get('is_active'));
                }
                if (request()->filled('is_verify')) {
                    $query->where('is_verify', request()->get('is_verify'));
                }

            })
            ->editColumn('gender', function ($user) {
                if ($user->gender == 'male')
                    return 'ذكر';
                if ($user->gender == 'female')
                    return 'انثى';
                return 'غير محدد';

            })
            ->editColumn('city.name', function ($user) {
                return isset($user->City) ? $user->City->name : '-';
            })->editColumn('phone', function ($user) {
                return $user->country_code . $user->phone;
            })
            ->editColumn('photo', function ($user) {
                return '<img src="' . $user->photo100 . '" width="70" class="img-circle">';
            })
            ->editColumn('is_verify', function ($user) {
                if ($user->is_verify)
                    return '<input type="checkbox" class="make-switch verify" data-on-text="&nbsp;مفعّل&nbsp;" data-off-text="&nbsp;معطّل&nbsp;" name="is_verify" data-id="' . $user->id . '" checked  data-on-color="success" data-size="mini" data-off-color="warning">';
                return '<input type="checkbox" class="make-switch verify" data-on-text="&nbsp;مفعّل&nbsp;" data-off-text="&nbsp;معطّل&nbsp;" name="is_verify" data-id="' . $user->id . '" data-on-color="success" data-size="mini" data-off-color="warning">';

            })
            ->editColumn('is_active', function ($user) {
                if ($user->is_active)
                    return '<input type="checkbox" class="make-switch is_active" data-on-text="&nbsp;مفعّل&nbsp;" data-off-text="&nbsp;معطّل&nbsp;" name="is_active" data-id="' . $user->id . '" checked  data-on-color="success" data-size="mini" data-off-color="warning">';
                return '<input type="checkbox" class="make-switch is_active" data-on-text="&nbsp;مفعّل&nbsp;" data-off-text="&nbsp;معطّل&nbsp;" name="is_active" data-id="' . $user->id . '" data-on-color="success" data-size="mini" data-off-color="warning">';
            })
            ->addColumn('action', function ($user) {
//                return '<a href="' . url(admin_vw() . '/users/' . $user->id . '/edit') . '" class="btn btn-sm btn-success purple btn-circle btn-icon-only edit-user-mdl"
//                                                                                   title="Edit">
//                                                                                    <i class="fa fa-edit"></i>
//                                                                                </a>
//                                                                                <a href="' . url(admin_vw() . '/users/' . $user->id) . '" class="btn btn-circle btn-icon-only red delete">
//                                        <i class="fa fa-trash"></i>
//                                    </a>';
                $action = '';
                if (isset($user->Slave)) {

                    $action = '<div class="btn-group">
                                                        <button class="btn btn-sm btn-success green btn-circle dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> معّدل
                                                            <i class="fa fa-angle-down"></i>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li>
                                                                <a href="' . url(admin_vw() . '/users/approval-provider-edits/' . $user->id) . ' " class="approval-edits">
                                                                    <i class="fa fa-check"></i> اعتماد التعديل </a>
                                                            </li>
                                                            <li>
                                                                <a href="' . url(admin_vw() . '/users/reject-provider-edits/' . $user->id) . '" class="reject-edits">
                                                                    <i class="fa fa-times"></i> رفض التعديل </a>
                                                            </li>

                                                        </ul>
                                                    </div>';
//                    $action = '<a href="' . url(admin_vw() . '/users/approval-provider-edits/' . $user->id) . '" class="btn btn-sm btn-success green btn-circle approval-edits"
//                                                                                   title="اعتماد التعديل">
//                                                                                    <i class="fa fa-check"></i>
//                                                                                    اعتماد التعديل
//                                                                                </a><a href="' . url(admin_vw() . '/users/reject-provider-edits/' . $user->id) . '" class="btn btn-sm btn-danger red btn-circle reject-edits"
//                                                                                   title="رفض الاعتماد">
//                                                                                    <i class="fa fa-times"></i>
//                                                                                     رفض الاعتماد
//                                                                                </a>';
                }
                return '<a href="' . url(admin_vw() . '/users/' . $user->id . '/view') . '" class="btn btn-sm btn-success blue btn-circle"
                                                                                   title="عرض">
                                                                                    <i class="fa fa-eye"></i>
                                                                                    عرض
                                                                                </a>' . $action;
            })->addIndexColumn()
            ->rawColumns(['action', 'photo', 'is_active', 'is_verify'])->toJson();
    }


    function verifyEmail($id)
    {

        $user = $this->model->find($id['user_id']);

        if (isset($user)) {

            if (!isset($user->email_verified_at))
                $user->email_verified_at = Carbon::now();
            else
                $user->email_verified_at = null;

            if ($user->save()) {
                return response_api(true, 200);
            }
        }
        return response_api(false, 422);

    }

    function verifyPhone($id)
    {

        $user = $this->model->find($id['user_id']);

        if (isset($user)) {
            $user->is_verify = !$user->is_verify;
            if ($user->save()) {
                if (!$user->is_verify) {
                    $this->logout($user->id);
                }
                return response_api(true, 200);
            }
        }
        return response_api(false, 422);

    }


    // get all users
    function getAll(array $attributes)
    {
        // TODO: Implement getAll() method.
        $page_size = isset($attributes['page_size']) ? $attributes['page_size'] : max_pagination(10);
        $page_number = isset($attributes['page_number']) ? $attributes['page_number'] : 1;

        $collection = $this->model;

//        if (auth()->user()->type == 'service_provider') {
//            $orders = Offer::where('user_id', auth()->user()->id)->where('status', 'accepted')->pluck('request_id');
//            $clients = \App\Request::whereIn('id', $orders)->orderByDesc('created_at')->pluck('user_id');
//
//            $ids_clients = implode(',', $clients);
//            $collection = $collection->whereIn('id', $clients)->orderByRaw("FIELD(id, $ids_clients)");
//        }
        $count = $collection->count();

        $page_count = page_count($count, $page_size);
        $page_number = $page_number - 1;
        $page_number = $page_number > $page_count ? $page_number = $page_count - 1 : $page_number;
        $object = $collection->take($page_size)->skip((int)$page_number * $page_size)->get();
        if (request()->segment(1) == 'api' || request()->ajax()) {
            return response_api(true, 200, null, ProfileResource::collection($object), $page_count, $page_number, $count);
        }
        return $object;
    }

    // Service Providers list
    function getServiceProviders(array $attributes)
    {
        // TODO: Implement getAll() method.
        $page_size = isset($attributes['page_size']) ? $attributes['page_size'] : max_pagination(10);
        $page_number = isset($attributes['page_number']) ? $attributes['page_number'] : 1;

        $collection = $this->model->where('type', 'service_provider')->where('is_completed', 1)->where('is_active', 1);

        if (isset($attributes['name'])) {
            $collection = $collection->where('name', 'LIKE', '%' . $attributes['name'] . '%');
        }
        if (isset($attributes['service_provider_type_id'])) {
            $collection = $collection->whereHas('ServiceProvider', function ($query) use ($attributes) {
                $query->where('service_provider_type_id', $attributes['service_provider_type_id']);
            });
        }
        if (isset($attributes['service_id'])) {

            $service = Service::find($attributes['service_id']);
            $collection = $collection->whereHas('ServiceProvider', function ($query) use ($service) {
                $query->where('service_provider_type_id', $service->service_provider_type_id);
            });
        }

        if (isset($attributes['city_id'])) {
            $collection = $collection->where('city_id', $attributes['city_id']);
        }
        if (isset($attributes['rate'])) {

            $providerIds = DB::table('users')
                ->join('rates', 'users.id', '=', 'rates.service_provider_id')
                ->select('rates.service_provider_id')
                ->selectRaw('AVG(rates.rate) AS average_rating')
                ->where('is_approved', 1)
                ->groupBy('rates.service_provider_id')
                ->havingRaw('AVG(rates.rate) >= ' . $attributes['rate'])
                ->havingRaw('AVG(rates.rate) < ' . ($attributes['rate'] + 1))
                ->pluck('rates.service_provider_id');

            $collection = $collection->whereIn('id', $providerIds);
        }

        $count = $collection->count();

        $page_count = page_count($count, $page_size);
        $page_number = $page_number - 1;
        $page_number = $page_number > $page_count ? $page_number = $page_count - 1 : $page_number;
        $object = $collection->take($page_size)->skip((int)$page_number * $page_size)->get();


        if (request()->segment(1) == 'api' || request()->ajax()) {
            return response_api(true, 200, null, ProfileResource::collection($object), $page_count, $page_number, $count);
        }
        return $object;
    }


    // get user by email
    function getByEmail($email)
    {
        // TODO: Implement getAll() method.
        return $this->model->where('email', $email)->first();
    }

    //user profile view
    function getById($id)
    {
        // TODO: Implement getById() method.
        $user = (!isset($id) && auth()->check()) ? auth()->user() : $this->model->find($id);

        if (\request()->segment(1) == 'api' || \request()->ajax()) {
            if (isset($user)) {
                return response_api(true, 200, null, new ProfileResource($user));
            }
            return response_api(false, 422, trans('app.not_data_found'), new \stdClass());
        }
        return $user;
    }

    // sign up user
    function create(array $attributes)
    {
        // TODO: Implement create() method.
        $code = generateVerificationCode(4);

        $user = User::create([
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'password' => bcrypt($attributes['password']),
//            'gender' => $attributes['gender'],
            'verification_code' => '1234',//$code,
            'phone' => $attributes['phone'],
            'country_code' => $attributes['country_code'],
            'type' => $attributes['type'],
        ]);

        $user = $this->model->find($user->id);
        return response_api(true, 200, trans('app.user_created'), new ProfileResource($user));// . ',' . trans('app.sent_email_verification')
    }

    function completeServiceProvider(array $attributes)
    {
        if (isset($attributes['photo'])) {
            auth()->user()->photo = $this->storeImageThumb('user', auth()->user()->id, $attributes['photo']);
            auth()->user()->save();
            sleep(1);
        }
        $service_provider = $this->serviceProvider->where('user_id', auth()->user()->id)->first();

        $service_provider_type = ServiceProviderType::find($attributes['service_provider_type_id']);
        if (!isset($service_provider))
            $service_provider = new ServiceProvider();
        $service_provider->user_id = auth()->user()->id;
        $service_provider->service_provider_type_id = $attributes['service_provider_type_id'];

        $service_provider->idno = $attributes['idno'];
        if (isset($attributes['skill']))
            $service_provider->skill = $attributes['skill'];
        if (isset($attributes['licensed']))
            $service_provider->licensed = $attributes['licensed'];
        if (isset($attributes['bio']))
            $service_provider->bio = $attributes['bio'];
        if (isset($attributes['address']))
            $service_provider->address = $attributes['address'];
        if (isset($attributes['latitude']))
            $service_provider->latitude = $attributes['latitude'];
        if (isset($attributes['longitude']))
            $service_provider->longitude = $attributes['longitude'];

        $service_provider->license_type = $service_provider_type->is_licensed ? 'licensed' : 'unlicensed';

        if ($service_provider->save()) {

            auth()->user()->is_completed = 1;
            auth()->user()->save();

            if (isset($attributes['idno_file'])) {
                $service_provider->idno_file = $this->upload($attributes, 'idno_file');
                sleep(1);
                $service_provider->save();

            }
            if (isset($attributes['skill_file'])) {
                $service_provider->skill_file = $this->upload($attributes, 'skill_file');
                sleep(1);
                $service_provider->save();

            }
            if (isset($attributes['licensed_file'])) {
                $service_provider->licensed_file = $this->upload($attributes, 'licensed_file');
                sleep(1);
                $service_provider->save();

            }
            return response_api(true, 200, trans('app.complete-service-provider'), [
                'token' => null,
                'user' => new ProfileResource(auth()->user())
            ]);// . ',' . trans('app.sent_email_verification')
        }
    }

    function update(array $attributes, $id = null)
    {
        $message = 'تم حفظ البيانات بنجاح';
        $user = auth()->user();

        if (isset($attributes['name']))
            $user->name = $attributes['name'];
        if (isset($attributes['email']))
            $user->email = $attributes['email'];
        if (isset($attributes['gender']))
            $user->gender = $attributes['gender'];
        if (isset($attributes['phone']))
            $user->phone = $attributes['phone'];
        if (isset($attributes['country_code']))
            $user->country_code = $attributes['country_code'];
        if (isset($attributes['city_id']))
            $user->city_id = $attributes['city_id'];

        if (isset($attributes['photo'])) {

            if (isset($user->photo) && $user->photo != '') {
                $this->deleteImage('users', $user->id, $user->getOriginal('photo'));
            }
            $user->photo = $this->storeImageThumb('users', $user->id, $attributes['photo']);
        }

        if (isset($attributes['password'])) {

            if (Hash::check($attributes['old_password'], $user->password)) {
                $user->password = bcrypt($attributes['password']);
                $message = 'تم تغير كلمة المرور بنجاح';
            } else {
                return response_api(false, 422, 'كلمة المرور القديمة غير صحيحة', []);
            }

        }
        $user->save();

        return response_api(true, 200, $message, new ProfileResource($user));
    }

    function rejectUpdateProvider(array $attributes, $id = null)
    {
        $user = User::find($id);
        $user->is_edit = 0;
        $user->save();

        $tmp = User::where('master_id', $user->id)->first();

        if (isset($tmp) && $tmp->forceDelete()) {
            $tmp_provider = ServiceProvider::where('master_id', $user->ServiceProvider->id)->first();

            if (isset($tmp_provider) && $tmp_provider->forceDelete()) {
                return response_api(true, 200, 'تم رفض اعتماد البيانات بنجاح', []);

            }

        }

        return response_api(false, 422, 'لم يتم رفض الاعتماد', []);

    }

    function confirmUpdateProvider(array $attributes, $id = null)
    {
        $user = User::find($id);
        $tmp = User::where('master_id', $user->id)->first();
        $user->name = $tmp->name;
        $user->phone = $tmp->phone;
        $user->country_code = $tmp->country_code;
        $user->email = $tmp->email;
        $user->email_verified_at = $tmp->email_verified_at;
        $user->password = $tmp->password;
        $user->verification_code = $tmp->verification_code;
        $user->is_verify = $tmp->is_verify;
        $user->photo = $tmp->getAttributes()['photo'];
        $user->gender = $tmp->gender;
        $user->type = $tmp->type;
        $user->city_id = $tmp->city_id;
        $user->is_completed = $tmp->is_completed;
        $user->is_edit = 0;
        $user->save();


        $provider = ServiceProvider::where('user_id', $user->id)->whereNull('master_id')->first();
        $tmp_provider = ServiceProvider::where('master_id', $user->ServiceProvider->id)->first();

        //`user_id`, `idno`, `idno_file`, `skill`, `skill_file`, `bio`, `address`, `latitude`,
        // `longitude`, `service_provider_type_id`, `license_type`, `licensed`, `licensed_file`
        $provider->idno = $tmp_provider->idno;
        $provider->idno_file = $tmp_provider->getAttributes()['idno_file'];
        $provider->skill = $tmp_provider->skill;
        $provider->skill_file = $tmp_provider->getAttributes()['skill_file'];
        $provider->licensed = $tmp_provider->licensed;
        $provider->licensed_file = $tmp_provider->getAttributes()['licensed_file'];
        $provider->bio = $tmp_provider->bio;
        $provider->address = $tmp_provider->address;
        $provider->latitude = $tmp_provider->latitude;
        $provider->longitude = $tmp_provider->longitude;
        $provider->service_provider_type_id = $tmp_provider->service_provider_type_id;
        $provider->license_type = $tmp_provider->license_type;
        $provider->save();

        $tmp->forceDelete();
        $tmp_provider->forceDelete();
        return response_api(true, 200, 'تم اعتماد البيانات بنجاح', []);

    }

    function editProvider(array $attributes, $id = null)
    {
        $message = 'تم حفظ البيانات بنجاح، بانتظار اعتماد ادارة النظام.';
        $user = auth()->user();

        // api change password
        if (isset($attributes['password'])) {

            if (Hash::check($attributes['old_password'], $user->password)) {
                $user->password = bcrypt($attributes['password']);
                $message = 'تم تغير كلمة المرور بنجاح';
            } else {
                return response_api(false, 422, 'كلمة المرور القديمة غير صحيحة', []);
            }

            $user->save();
            return response_api(true, 200, $message, new ProfileResource($user));

        }

        if ($user->is_edit) {
            return response_api(false, 422, 'تم ارسال التعديلات الى الادارة، الرجاء الانتظار.', empObj());
        }

        $user_tmp = new User();
        $user_tmp->master_id = $user->id;
        if (!isset($attributes['password'])) {
            $user_tmp->password = $user->password;
        }
        if (!isset($attributes['verification_code'])) {
            $user_tmp->verification_code = $user->verification_code;
            $user_tmp->is_verify = $user->is_verify;
        }
        $user_tmp->type = $user->type;
        $user_tmp->is_active = $user->is_active;
        $user_tmp->is_completed = $user->is_completed;
        $user_tmp->email_verified_at = $user->email_verified_at;
        if (isset($attributes['name']))
            $user_tmp->name = $attributes['name'];
        else
            $user_tmp->name = $user->name;

        if (isset($attributes['email']))
            $user_tmp->email = $attributes['email'];
        else
            $user_tmp->email = $user->email;

        if (isset($attributes['gender']))
            $user_tmp->gender = $attributes['gender'];
        else
            $user_tmp->gender = $user->gender;
        if (isset($attributes['phone']))
            $user_tmp->phone = $attributes['phone'];
        else
            $user_tmp->phone = $user->phone;

        if (isset($attributes['country_code']))
            $user_tmp->country_code = $attributes['country_code'];
        else
            $user_tmp->country_code = $user->country_code;

        if (isset($attributes['city_id']))
            $user_tmp->city_id = $attributes['city_id'];
        else
            $user_tmp->city_id = $user->city_id;

        if (isset($attributes['photo'])) {
            $user_tmp->photo = $this->storeImageThumb('users', $user->id, $attributes['photo']);
        } else
            $user_tmp->photo = $user->getAttributes()['photo'];

        $user->is_edit = 1;

        if ($user->save() && $user_tmp->save()) {
            $service_provider = ServiceProvider::where('user_id', auth()->user()->id)->first();

            $service_provider_tmp = new ServiceProvider();
            $service_provider_tmp->master_id = $service_provider->id;
            $service_provider_tmp->user_id = $user->id;

            if (isset($attributes['service_provider_type_id']))
                $service_provider_tmp->service_provider_type_id = $attributes['service_provider_type_id'];
            else
                $service_provider_tmp->service_provider_type_id = $service_provider->service_provider_type_id;


            $service_provider_type = ServiceProviderType::find($service_provider_tmp->service_provider_type_id);
            $service_provider_tmp->license_type = $service_provider_type->is_licensed ? 'licensed' : 'unlicensed';

            if (isset($attributes['idno']))
                $service_provider_tmp->idno = $attributes['idno'];
            else
                $service_provider_tmp->idno = $service_provider->idno;

            if (isset($attributes['skill']))
                $service_provider_tmp->skill = $attributes['skill'];
            else
                $service_provider_tmp->skill = $service_provider->skill;

            if (isset($attributes['licensed']))
                $service_provider_tmp->licensed = $attributes['licensed'];
            else
                $service_provider_tmp->licensed = $service_provider->licensed;

//            if (isset($attributes['license_type']))
//                $service_provider_tmp->license_type = $attributes['license_type'];
//            else
//                $service_provider_tmp->license_type = $service_provider->license_type;

            if (isset($attributes['bio']))
                $service_provider_tmp->bio = $attributes['bio'];
            else
                $service_provider_tmp->bio = $service_provider->bio;

            if (isset($attributes['address']))
                $service_provider_tmp->address = $attributes['address'];
            else
                $service_provider_tmp->address = $service_provider->address;

            if (isset($attributes['latitude']))
                $service_provider_tmp->latitude = $attributes['latitude'];
            else
                $service_provider_tmp->latitude = $service_provider->latitude;

            if (isset($attributes['longitude']))
                $service_provider_tmp->longitude = $attributes['longitude'];
            else
                $service_provider_tmp->longitude = $service_provider->longitude;

            if (isset($attributes['idno_file'])) {

//                if (isset($service_provider->idno_file)) {
//                    unlink(base_path('assets/upload/' . $service_provider->getOriginal()['idno_file']));
//                }
                $service_provider_tmp->idno_file = $this->upload($attributes, 'idno_file');
                sleep(1);

            } else
                $service_provider_tmp->idno_file = $service_provider->getAttributes()['idno_file'];

            if (isset($attributes['skill_file'])) {
                $service_provider_tmp->skill_file = $this->upload($attributes, 'skill_file');
                sleep(1);

            } else
                $service_provider_tmp->skill_file = $service_provider->getAttributes()['skill_file'];

            if (!$service_provider_type->is_licensed) {
                $service_provider_tmp->licensed_file = null;
                $service_provider_tmp->licensed = null;
            } else
                if (isset($attributes['licensed_file'])) {
                    $service_provider_tmp->licensed_file = $this->upload($attributes, 'licensed_file');
                    sleep(1);

                } else
                    $service_provider_tmp->licensed_file = $service_provider->getAttributes()['licensed_file'];


            $service_provider->save();
            $service_provider_tmp->save();


        }

        return response_api(true, 200, $message, new ProfileResource($user));
    }

    // delete user
    function delete($id)
    {
        // TODO: Implement delete() method.
        $user = $this->model->find($id);
        return isset($user) && $user->delete();
    }

    //confirm code
    public function confirm_code(array $attributes)
    {
        $user = $this->model->find($attributes['user_id']);

        $userByMobile = $this->model->where('id', '<>', $attributes['user_id'])->where('phone', $attributes['phone'])->first();
        //update mobile
        if (isset($user)) {

            if (isset($userByMobile)) {
                return response_api(false, 422, trans('app.mobile_token'), []);
            }
            if ($user->verification_code == $attributes['confirm_code']) {
                $user->phone = $attributes['phone'];
                $user->is_verify = true;
//                $user->step = 3;
                $user->save();
                \request()->request->add([
                    'username' => $user->email,
                    'password' => $attributes['password'],

                ]);

                return $this->access_token();
            } else {                                        //'There is an error in confirmation code'
                return response_api(false, 422, trans('app.error_confirmation'), []);
            }

        }

    }

    //resend confirm code
    public function resend_confirm_code(array $attributes)
    {
        $user = $this->model->find($attributes['user_id']);
        $userByMobile = $this->model->where('id', '<>', $attributes['user_id'])->where('phone', $attributes['phone'])->first();
        if (isset($userByMobile)) {
            return response_api(false, 422, trans('app.mobile_token'));
        }
        if (isset($user)) {
            // send SMS

            $confirm_code = generateVerificationCode();
            $user->verification_code = '1234';//$confirm_code;
            if ($user->save()) {
                try {
                    //SMS::Send($attributes['mobile'], ' Delivery code: ' . $confirm_code);
                    return response_api(true, 200, trans('app.resend_code_success'), new ProfileResource($user));
                } catch (\Exception $e) {

                }
            }
        }
        return response_api(false, 422, null, []);

    }

    // edit mobile from profile
    function putMobile(array $attributes)
    {
        $user = auth()->user();
        if ($user) {
            if ($user->verification_code != $attributes['code'])
                return response_api(false, 422, trans('app.code'), []);

            $user->phone = $attributes['phone'];
            $user->country_code = $attributes['country_code'];
            $user->is_verify = 1;
            $user->save();
            return response_api(true, 200, trans('app.updated'), new ProfileResource($user));//

        } else {
            return response_api(false, 422, trans('app.not_data_found'), []);
        }
    }

    public function forget(array $attributes)
    {

        $response = Password::sendResetLink($attributes);

        switch ($response) {
            case Password::RESET_LINK_SENT:
                return response_api(true, 200, 'Email was sent', new \stdClass());
            case Password::INVALID_USER:
                return response_api(false, 422, 'Send reset password was failed', new \stdClass());
        }
        return response_api(false, 422, 'Send reset password was failed', new \stdClass());
    }

    //logout
    public function logout($user_id = null)
    {
        if (!isset($user_id)) {
            $user_id = auth()->user()->id;

            $accessToken = auth()->user()->token();

            $token = DB::table('oauth_access_tokens')
                ->where('user_id', '=', $user_id)
                ->update(['revoked' => true]);

            DB::table('oauth_refresh_tokens')
                ->where('access_token_id', $accessToken->id)
                ->update(['revoked' => true]);
        } else {
            $access_token_id = DB::table('oauth_access_tokens')
                ->where('user_id', '=', $user_id)->pluck('id');

            $token = DB::table('oauth_access_tokens')
                ->where('user_id', '=', $user_id)
                ->update(['revoked' => true]);

            DB::table('oauth_refresh_tokens')
                ->whereIn('access_token_id', $access_token_id)
                ->update(['revoked' => true]);
        }

        // token device
        // turn off mobile // registerId : mac address code
        $device_reset = false;
        if (\request()->filled('device_id'))
            $device_reset = $this->deviceToken->where('user_id', $user_id)->where('device_id', \request()->get('device_id'))->update(['status' => 'off']);
        if (\request()->filled('device_type'))
            $device_reset = $this->deviceToken->where('user_id', $user_id)->where('device_type', \request()->get('device_type'))->update(['status' => 'off']);

        if (!$device_reset)
            $this->deviceToken->where('user_id', $user_id)->update(['status' => 'off']);


        if ($token)
            return response_api(true, 200, null, []);
        return response_api(false, 422, null, []);
    }

    // count users
    function count()
    {
        return $this->model->count();
    }

}
