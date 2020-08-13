<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Request;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $data = [
            'users_count' => User::where('type', 'user')->count(),
            'service_providers_count' => User::where('type', 'service_provider')->count(),
            'orders_new_count' => Request::where('status', 'new')->count(),
            'orders_completed_count' => Request::where('status', 'completed')->count(),
        ];
        return view('admin.home', $data);
    }
}
