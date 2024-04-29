<?php


namespace App\Http\Controllers\Api;

use App\Http\Models\Cities;
use App\Http\Models\Role;
use App\Http\Models\Unit;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Models\UserDevice;
use App\Http\Models\Tracking;
use App\Rules\PhoneNumberExist;
use App\Rules\PhoneNumberNotExist;
use App\Rules\OldPasswordMatch;
use App\Http\Models\Assets;

class AuthController extends ResponseController
{
    public function test(){
        return "hy";
    }
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'location' => 'required',
            'username' => 'required|string|unique:users',
            'email' => 'required|string|email|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            return $this->sendError(0,"Something went wrong! Please try again", $validator->errors()->all());
        }

        $request['password'] = Hash::make($request['password']);
        // dd($request->except(["confirm_password"]));
        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->location = $request->location;
        $user->password = $request->password;
        $user->role = $request->role;
        $user->phone = $request->phone;
        $user->save();
        if($user){
            $user['token'] =  $user->createToken('token')->accessToken;
            $message = "Registration successful";
            $user = User::find($user->id);
            $this->addUserDeviceInfo($request,$user->id);
            return $this->sendResponse(1,$message,$user);
        }
        else{
            $error = "Something went wrong! Please try again";
            return $this->sendError(0,$error,null ,401);
        }

    }
    public function addUserDeviceInfo(Request $request,$userId)
    {
        $userDeviceInfo = UserDevice::updateOrCreate(["serial" => $request['serial']],array_merge($request->except(['name', 'phone', 'password', 'login_with']),['status' => 'A','user_id' => $userId]));
        return $userDeviceInfo;
    }

    //login
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required',
            'platform' => 'required',
        ]);

//        $request['phone'] = strip_tags($request['phone']);
//        $request['phone'] = substr($request['phone'], -10);

        $platform = $request['platform'];

        if($platform == 'iOS'){
            $validator = Validator::make($request->all(), [
                'app_version' => 'required',
            ]);
        }elseif($platform == 'android'){
            $validator = Validator::make($request->all(), [
                'app_version' => 'required',
            ]);
        }

        // dd($request->all());
        if($validator->fails()){
            return $this->sendError(0,"Sorry! Might be required fields are not found or empty.", $validator->errors()->all());
        }

        $status = $this->check_version($request->all());


        if(!User::where('email', $request['phone'])->exists())
        {
            $error = "Invalid mobile number";
            return $this->sendResponse(0, $error, null);
        }
        else
        {
            $request['email'] = User::where('email', $request['phone'])->first()['email'];
        }
        $credentials = request(['email','password']);
        if (!Auth::attempt($credentials)) {

                $error = "Invalid credentials! Please try again";
                return $this->sendResponse(0, $error, null);
        }

            $user = $request->user();
        $user['token'] =  $user->createToken('token')->accessToken;
        $this->addUserDeviceInfo($request,$user->id);
        if($user){
            // dd($user);
            if($user->role == 1 || $user->role == 2 || $user->role == 3){

                Auth::logout();
                $status = -1;
                $message = "Sorry! You cant logged in.";
//                return $this->sendError($status,$message);
                return $this->sendResponse($status,$message,null);
            }else{
                if($status != 1) {
                    $message="New features and services are added, please update the app";
                }else{
                    $message = "Login successful";
                }
                $user['assets_count']=Tracking::where('user_id', $user->id)->count();
                return $this->sendResponse($status,$message,$user);
            }

        }else{
            $message = "Login unsuccessful";
            return $this->sendResponse(0,$message,null);
//            return $this->sendError(0,$message);
        }
    }

//    function getImageUrl($image_name) {
//
//        $url_scheme = '';
//        $domain = '';
//
//        $full_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//        $url_scheme = parse_url($full_url, PHP_URL_SCHEME);
//
//        $domain = request()->getHttpHost();
//return $domain;
//        return $url_scheme.'://'.$domain.'/assets/company_files/'.$image_name;
//    }

    private function check_version($request)
    {
        $platform = $request['platform'];
        $version='';
        if($platform == 'iOS'){
            $version = $request['app_version'];
        }elseif($platform == 'android'){
            $version = $request['app_version'];
        }
        // dd($platform,$version);
        $get_data = DB::select("SELECT * FROM platform_version WHERE platform = '".$platform."'");
        $from_version = $get_data[0]->from_version;
        $to_version = $get_data[0]->to_version;

        if($version < $from_version && $version >= $to_version){
            return -4;
        } else if($version < $to_version){
            return -5;
        }else{
            return 1;
        }
    }

    public function updateProfile(Request $request)
    {
        $userID = $request->user()->id;
        $user = User::find($userID);
        if($userID) {
            // get user details
            $user  = User::where('id', $userID)->first();

            $data=array();
            // checks on each param
            if($request['new_password']) {
                if (Hash::check($request['password'], $user->password)) {
                    //password is correct use your logic here
                    $data = array();
                    $data['password'] = Hash::make($request['new_password']);
                } else{
                    return $this->sendResponse(0,'Password does not match!',null);

                }
            }
            if($request['name']){
                $data['name']=$request['name'];
            }
            if($request['phone']){
                $data['phone']=$request['phone'];
            }

            // updating data
            $user->update($data);

            // pic updation
            if ($request->has('profile_pic')) {
                $format = '.png';
                $entityBody = $request->file('profile_pic');// file_get_contents('php://input');

                $imageName = $user->id . time() . $format;
                $directory = "/user_photo/";
                $path = base_path() . "/public" . $directory;

                $entityBody->move($path, $imageName);

                $response = $directory . $imageName;

                $user->profile_pic = $response;
                $user->save();
            }

            $message = "Profile updated successfully";
            return $this->sendResponse(1, $message, $user);

        }else{
            return $this->sendError(0,"User Id not found!", null);
        }
    }

    //logout
    public function logout(Request $request)
    {
        $isUser = $request->user()->token()->revoke();
        if($isUser){
            if($request->has("serial")){
                UserDevice::where("serial",$request["serial"])->update(["status" => "D"]);
            }
            return $this->sendResponse(1,'Successfully logged out',null);
        }
        else{
            return $this->sendError(0,"Something went wrong!", null);
        }


    }

    public function phoneVerify(Request $request) {

        $validator = Validator::make($request->all(), [
            'phone' => ['required', new PhoneNumberExist],
        ]);

        if($validator->fails()){

            return $this->sendError(0,$validator->errors()->first());
        }

        else {

            $message = 'Phone number exist';
            return $this->sendResponse(1, $message, null);
        }
    }

    public function passwordReset(Request $request) {

        try {

            $validator = Validator::make($request->all(), [
                'phone' => ['required', new PhoneNumberExist],
                'password' => 'required',
            ]);

            if($validator->fails()){

                return $this->sendError(0,$validator->errors()->first());
            }

            $request['password'] = Hash::make($request['password']);
            $request['phone'] = strip_tags($request['phone']);
            $request['phone'] = substr($request['phone'], -10);

            $user =  User::where('phone', 'LIKE', '%'.$request['phone'])->update(['password' => $request['password']]);

           $message = 'Password changed successfully';
           return $this->sendResponse(1,$message,null);
        }

        catch(Exception $e) {

            return $this->sendError(0, $e->getMessage());
        }
    }

    public function changePassword(Request $request) {

        try {

            $validator = Validator::make($request->all(), [
                'old_password' => ['required', new OldPasswordMatch],
                'new_password' => 'required',
                'confirm_password' => 'required|same:new_password',
            ]);

            if($validator->fails()){

                return $this->sendError(0,$validator->errors()->first());
            }

            $request['password'] = Hash::make($request['new_password']);

            $user =  User::where('id', $request->user()->id)->update(['password' => $request['password']]);

           $message = 'Password changed successfully';
           return $this->sendResponse(1,$message,null);
        }

        catch(Exception $e) {

            return $this->sendError(0, $e->getMessage());
        }
    }
    public function roles()
    {
     return ['roles' => Role::all()];
    }
    public function addUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:users',
            'email' => 'required|string|email|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]);

        if($validator->fails()){
            return $this->sendError(0,"Something went wrong! Please try again", $validator->errors()->all());
        }

        $request['password'] = Hash::make($request['password']);
        $request['role'] = 1;
        $user = User::create($request->except(["confirm_password"]));
        if($user){
            $user['token'] =  $user->createToken('token')->accessToken;
            $message = "Registration successful";
            $user = User::find($user->id);
            //inserting user device record
            UserDevice::updateOrCreate(["serial" => $request['serial']],array_merge($request->except(['name', 'phone', 'password', 'login_with']),['status' => 'A','user_id' => $user->id]));
            return $this->sendResponse(1,$message,$user);
        }
        else{
            $error = "Something went wrong! Please try again";
            return $this->sendError(0,$error,null ,401);
        }
    }
    public function adminList()
    {
        try {
            return ['data' => User::where('role','1')->get()];

        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return json_encode(["status" => false, "message" => $exception->getMessage()]);
        }
    }
    public function signUpSettings()
    {

            $cities = Cities::Select('city_id','city_name','state_id')->where('state_id',2728)->get();
            $units =  Unit::all();
            $data = ['cities' => $cities,'unit' => $units];
            return $this->sendResponse(1, 'success', $data);
    }
}