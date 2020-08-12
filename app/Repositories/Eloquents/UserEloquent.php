<?php
/**
 * Created by PhpStorm.
 * UserRequest: mohammedsobhei
 * Date: 5/2/18
 * Time: 11:43 PM
 */

namespace App\Repositories\Eloquents;

use App\DeviceToken;
use App\Http\Resources\ProfileResource;
use App\Repositories\Interfaces\UserRepository;
use App\Repositories\Uploader;
use App\ServiceProvider;
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
                    $action = 'user_deactivate';
//                    $this->notificationSystem->sendNotification(null, $user->id, $user->id, $action);
                    $this->logout($user->id);
                    return response_api(true, 200);

                }
                return response_api(true, 200);
            }
        }
        return response_api(false, 422);

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


    // get all users
    function getAll(array $attributes)
    {
        // TODO: Implement getAll() method.
        return $this->model->all();
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
        if (!isset($service_provider))
            $service_provider = new ServiceProvider();
        $service_provider->user_id = auth()->user()->id;
        $service_provider->service_provider_type_id = $attributes['service_provider_type_id'];
        $service_provider->idno = $attributes['idno'];
        if (isset($attributes['skill']))
            $service_provider->skill = $attributes['skill'];
        if (isset($attributes['bio']))
            $service_provider->bio = $attributes['bio'];
        if (isset($attributes['address']))
            $service_provider->address = $attributes['address'];
        if (isset($attributes['latitude']))
            $service_provider->latitude = $attributes['latitude'];
        if (isset($attributes['longitude']))
            $service_provider->longitude = $attributes['longitude'];
        if ($service_provider->save()) {
            if ($attributes['idno_file']) {
                $service_provider->idno_file = $this->upload($attributes, 'idno_file');
                sleep(1);
                $service_provider->save();

            }
            if ($attributes['skill_file']) {
                $service_provider->skill_file = $this->upload($attributes, 'skill_file');
                sleep(1);
                $service_provider->save();

            }
            return response_api(true, 200, trans('app.user_created'), []);// . ',' . trans('app.sent_email_verification')
        }
    }

    function update(array $attributes, $id = null)
    {
        $message = trans('app.user_updated');
        $user = auth()->user();

        if (isset($attributes['name']))
            $user->name = $attributes['name'];
        if (isset($attributes['email']))
            $user->email = $attributes['email'];
        if (isset($attributes['gender']))
            $user->gender = $attributes['gender'];
        if (isset($attributes['country_id']))
            $user->country_id = $attributes['country_id'];
        if (isset($attributes['city_id']))
            $user->city_id = $attributes['city_id'];
        if (isset($attributes['school_id']))
            $user->school_id = $attributes['school_id'];
        if (isset($attributes['grade_id']))
            $user->grade_id = $attributes['grade_id'];
        if (isset($attributes['avatar'])) {

            if (isset($user->avatar) && $user->avatar != '') {
                $this->deleteImage('users', $user->id, $user->getOriginal('avatar'));
            }
            $user->avatar = $this->storeImageThumb('users', $user->id, $attributes['avatar']);
        }

        if (isset($attributes['password'])) {

            if (Hash::check($attributes['old_password'], $user->password)) {
                $user->password = bcrypt($attributes['password']);
                $message = trans('app.password_updated');
            } else {
                return response_api(false, 422, trans('app.password_not_match'), []);
            }

        }
        $user->save();

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
