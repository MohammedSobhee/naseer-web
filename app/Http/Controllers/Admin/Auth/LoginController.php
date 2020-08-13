<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
       |--------------------------------------------------------------------------
       | Login Controller
       |--------------------------------------------------------------------------
       |
       | This controller handles authenticating users for the application and
       | redirecting them to your home screen. The controller uses a trait
       | to conveniently provide its functionality to your applications.
       |
       */
//    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    public function __construct()
    {
//        $this->middleware('guest:admin')->except('logout');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function showLoginForm()
    {
        if (auth()->viaRemember()) {
            //
            return redirect()->intended(admin_dashboard_url());
        }
        return view(admin_vw() . '.login');
    }

    public function loginAdmin(Request $request)
    {
        // Attempt to log the user in
        if (auth()->guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            // if successful, then redirect to their intended location
            return redirect()->intended(admin_dashboard_url());
        }
        // if unsuccessful, then redirect back to the login with the form data
        return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public
    function logout()
    {
        auth()->guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
