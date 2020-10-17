<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Eloquents\SettingEloquent;
use App\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $setting;

    public function __construct(SettingEloquent $setting)
    {
//        parent::__construct();
        $this->setting = $setting;
    }

    public function index()
    {
        //
        $setting = Setting::first();
        $data = [
            'title' => 'الاعدادات',
            'icon' => 'fa fa-cogs',
            'setting' => $setting
        ];
        return view(admin_settings_vw() . '.index', $data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Setting $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        return $this->setting->update($request->all());

    }

}
