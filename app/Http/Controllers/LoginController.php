<?php

namespace App\Http\Controllers;

use App\Http\Models\Ads;
use App\Http\Models\Category;
use App\Http\Models\Company;
use App\Http\Models\Configuration;
use App\Http\Models\Make;
use App\Http\Models\Manufacture;
use App\Http\Models\Order;
use App\Http\Models\Orderitem;
use App\Http\Models\PartImage;
use App\Http\Models\Parts;
use App\Http\Models\ProductCategory;
use App\Http\Models\UserDevice;
use App\Http\Models\PlatformVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ResponseController as ResponseController;
use Illuminate\Support\Facades\Hash;

use Validator;
use DB;
use Session;
use App\User;


class LoginController extends ResponseController
{
    public function Login(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'phone' => 'required|min:10',
            'password' => 'required',
        ]);

        if ($validator->passes()) {
            $req['phone'] = substr($req['phone'], -10);

            $userPhone = User::where('phone', 'LIKE', '%' . $req['phone'])->where('is_active','Y')->where('is_deleted','N')->first();
            if($userPhone)
            {
                $req['phone'] = $userPhone->phone;
            }
            else
            {
                return response()->json(['success' => 0, 'message' => "Phone doesn't exist. Please try again!"]);
            }
            $response = $this->check_version($req->all());

            $credentials = request(['phone', 'password']);
            if ((Auth::attempt($credentials))) {

                $user = User::select('id', 'discount', 'username', 'phone', 'image', 'location','show_price','is_active', 'is_approved', 'is_deleted')->where('phone', $req->phone)->first();

                $user['total_order']= Order::where('user_id',$user->id)->count();
                $getcompanyName = Company::where('user_id',$user->id)->first();
                if($getcompanyName){
                    $user['company_name']=$getcompanyName->name;
                }else{
                    $user['company_name']=" ";
                }
                $user['image']= asset('assets/profile/ProfileImage').'/'.$user->image;
                $this->addUserDeviceInfo($req, $user->id);

                if ($user->is_approved == 'Y') {
                    $user['token'] = $user->createToken('token')->accessToken;

                    $fromYear = Configuration::where('key', 'from_year')->first();
                    $gst = Configuration::where('key', 'gst')->first();

                    $data = ['user' => $user, 'year' => (integer)$fromYear->value,  'gst' => (integer)$gst->value];
//                    return $this->sendResponse('User login successfully.', $data);
//                    return $this->sendResponse($response['status'],$response['message'], $user);

                    return $this->sendResponse($response['status'],$response['message'], $data);
                } else {
                    $data = Auth::user()->tokens->each(function ($token, $key) {
                        $token->delete();
                    });
                    return response()->json(['success' => 1, 'message' => "User is not approved."]);
                }
            } else {
                return $this->sendError('Phone Number or password is incorrect.', ['success' => 1, 'error' => 'User unauthorised']);

            }
        } else {
            return $this->sendError('Invalid mobile number.', ['success' => 1, 'error' => 'Invalid mobile number']);

        }

    }
     public function logout(Request $request)
    {
        $userRole = Auth::user()->role;
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        if ($userRole == 1) {
            return redirect('/admin-login');
        } else {  
            return redirect('/user.login');
        }
    }

    private function check_version($request)
    {

        $response = array();

        $platform = strtolower($request['platform']);

        $version = $request['app_version'];
        $version = str_replace(".", "", $version);

        $data = PlatformVersion::where('platform', $platform)->first();

        $min_optional = $data['min_optional'];
        $min_optional = str_replace(".", "", $min_optional);
        $max_optional = $data['max_optional'];
        $max_optional = str_replace(".", "", $max_optional);
        $min_force = $data['min_force'];
        $min_force = str_replace(".", "", $min_force);
        $max_force = $data['max_force'];
        $max_force = str_replace(".", "", $max_force);
        // dd( $from_version, $to_version,$min_version, $max_version);
        if ($version <= $max_force && $version >= $min_force) {
            $response['status'] = -5;
            $response['message'] = "Please update app to latest version";
            return $response;
        } elseif ($version <= $max_optional && $version >= $min_optional) {
            $response['status'] = -4;
            $response['message'] = "Please update app to latest version";
            return $response;
        } else {
            $response['status'] = 1;
            $response['message'] = "Login Successful";
            return $response;
        }
    }
    public function addUserDeviceInfo(Request $request, $userId)
    {
        if (!$request->status) {
            $request->status = 'A';
        }
        $userDeviceInfo = UserDevice::updateOrCreate(["serial" => $request['serial']], array_merge($request->except(['name', 'phone', 'password', 'login_with']), ['status' => $request->status, 'user_id' => $userId]));
        return $userDeviceInfo;
    }
}