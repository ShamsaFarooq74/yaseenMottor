<?php

namespace App\Http\Controllers;

use App\Http\Models\PartDetails;
use App\Http\Models\UserDevice;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    function register(Request $req)
    {
        // return $req->all();
//        $req->validate([
//
//        ]);
        $validator = Validator::make($req->all(), [
            'phone'=>'required|unique:users|numeric',
            'password'=>'required',
            'name'=>'required',
            'location'=>'required',
        ]);

        if ($validator->fails()) {
//            return $this->sendError(0, $validator->errors()->first());
            return response()->json(['success' => 0, 'message' => $validator->errors()->first()]);
        }
        // $data=User::where('id',$id)->first();
        if (!preg_match('/^((\+92)|(0092))-{0,1}\d{3}-{0,1}\d{7}$|^\d{11}$|^\d{4}-\d{7}$/', $req['phone'])) {
            return response()->json(['success' => 0, 'message' => "Invalid mobile number"]);
        }
        // return $req;
        $data=new User;
        if($req->has('phone')){
        $data->phone=$req->phone;
        }
        $data->password=Hash::make($req->password);
        $data->username=$req->name;
        $data->location=$req->location;
        $data->role=2;
        if($req->hasFile('image')){
        $image =$req->image;
        $filename = time() . '.' . $image->getClientOriginalName();
		$image->move(public_path('assets/profile/ProfileImage/'), $filename);
        $data->image = $filename;
        }
       $result= $data->save();
        if($result){
            $this->addUserDeviceInfo($req, $data->id);
			return response()->json(['success' => 1,'message'=>"User Registered Successfully"]);
		}
		else{
			return response()->json(['success' => 0,'message'=>"Please fill field carefully"]);
		}

    }
    public function addUserDeviceInfo(Request $request, $userId)
    {
        if(!$request->status)
        {
            $request->status = 'A';
        }
        $userDeviceInfo = UserDevice::updateOrCreate(["serial" => $request['serial']], array_merge($request->except(['name', 'phone', 'password', 'login_with']), ['status' => $request->status, 'user_id' => $userId]));
        return $userDeviceInfo;
    }
}
