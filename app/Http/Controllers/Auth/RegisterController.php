<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Api\ResponseController;
use App\Http\Controllers\Controller;
use App\Http\Models\UserDevice;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class RegisterController extends ResponseController
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */

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
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'max:255'],
            'username' => ['required', 'unique:users', 'max:255'],
            'phone' => ['required', 'max:255', 'unique:phone'],
            'role' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:6', 'confirmed'],
            'file' => 'required',
            'serial' => 'required',
        ]);
    }

    public function register(Request $request)
    {
//        $validator = $this->validator($request->all())->validate();
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255'],
            'username' => ['required', 'unique:users', 'max:255'],
            'phone' => ['required', 'max:255', 'unique:phone'],
            'role' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:6', 'confirmed'],
            'file' => 'required',
            'serial' => 'required',

        ]);
        if ($validator->fails()) {

            return redirect()->back()->with('error', $validator->errors()->first());

        }

        $request['phone'] = strip_tags($request['phone']);
        $request['phone'] = substr($request['phone'], -10);
        if (strlen($request['phone']) != 10) {
            return $this->sendError('error', 'Invalid phone number!');
        }
        $image = $request->file('file');
        $name = date("dmyHis.") . gettimeofday()["usec"] . '_' . 'tracker' . $image->getClientOriginalName();
        $image->move(public_path() . '/assets/trackers/', $name);


//        $result = User::create([
//            'name' => $request['name'],
//            'username' => $request['username'],
//            'email' => $request['email'],
//            'phone' => $request['phone'],
//            'role' => $request['role'],
//            'password' => Hash::make($request['password']),
//            'image' =>$name
//        ]);
        $user = new User();
        $user->username = $request['username'];
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = Hash::make($request['password']);
        $user->role = $request['role'];
        $user->phone = $request['phone'];
        $result = $user->save();
        if ($result) {
            $this->addUserDeviceInfo($request, $user->id);
        }


        return redirect()->back()->with('success', 'Tracker added successfully!');

    }

    public
    function addUserDeviceInfo(Request $request, $userId)
    {
        $userDeviceInfo = UserDevice::updateOrCreate(["serial" => $request['serial']], array_merge($request->except(['name', 'phone', 'password', 'login_with']), ['status' => 'A', 'user_id' => $userId]));
        return $userDeviceInfo;
    }
    public function signUpSettings()
    {
        return 'okkk';
    }
}
