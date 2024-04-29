<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\User;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Models\ConfigParams;
use App\Http\Models\Client_company;

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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    public function username()
    {
        return 'email';
    }

    protected function authenticated(Request $request, $user)
    {

        // return redirect()->to('/dashboard');
        if(Auth::user()) {
            if (Auth::user()->role == 3) {
                $company = Client_company::where('id', $user->company_id)->first();
            }
            if(Auth::user()->is_active == 'N' || (isset($company->is_active) && !empty($company->is_active) &&  $company->is_active == 'N')) {

                $this->guard()->logout();

                $request->session()->invalidate();

                $request->session()->regenerateToken();

                return redirect()->back()->with('error', 'Sorry you cant login,You are blocked by admin!');
            }
            else {
                //storing value important details in session
                Session::put('user_id', $user->id);
                Session::put('username', $user->username);
                Session::put('email', $user->email);
                Session::put('role', $user->role);

                // putting all config params into session
                $ConfigParams = ConfigParams::all();
                foreach ($ConfigParams as $param) {
//                echo $param['text'];
                    Session::put($param['param'], $param['text']);
                }
                if (Auth::user()->role == 1) {
                    return redirect()->to('/dashboard');
                }else if(Auth::user()->role == 2) {
                    return redirect()->to('/');
                }else if (Auth::user()->role == 3) {
                    $company = Client_company::where('id', $user->company_id)->first();
                    Session::put('client_id', $user->company_id);
                    Session::put('client_name', $company->company_name);
                    return redirect()->to('/dashboard');
//                return redirect()->to('/client-profile?info='.$user->company_id);
                }
            }
       }
       else {

           $this->guard()->logout();

           $request->session()->invalidate();

           $request->session()->regenerateToken();

           return redirect()->back()->with('error', 'You have no permission to access this portal!');
       }
    }
    public function login(Request $request)
    {
        // $phone_number = substr($request['phone'], -10);
        $userPhone = User::where('email', $request['email'])->whereIn('role',[1,2])->first();
        if($userPhone){
            if($userPhone->is_deleted == "Y"){
            return redirect()->back()->with('error', 'Your Account is Deleted');
            }
            $userNumber = $userPhone->email;
            if($userNumber){
                $request['email'] = $userNumber;
                $this->validateLogin($request);

                // If the class is using the ThrottlesLogins trait, we can automatically throttle
                // the login attempts for this application. We'll key this by the username and
                // the IP address of the client making these requests into this application.
                if (method_exists($this, 'hasTooManyLoginAttempts') &&
                    $this->hasTooManyLoginAttempts($request)) {
                    $this->fireLockoutEvent($request);

                    return $this->sendLockoutResponse($request);
                }

                if ($this->attemptLogin($request)) {
                    return $this->sendLoginResponse($request);
                }

                // If the login attempt was unsuccessful we will increment the number of attempts
                // to login and redirect the user back to the login form. Of course, when this
                // user surpasses their maximum number of attempts they will get locked out.
                $this->incrementLoginAttempts($request);

                return $this->sendFailedLoginResponse($request);
            }
        }
        else {
            $this->incrementLoginAttempts($request);
            return $this->sendFailedLoginResponse($request);
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}