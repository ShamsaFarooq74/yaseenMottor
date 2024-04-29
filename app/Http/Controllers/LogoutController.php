<?php

namespace App\Http\Controllers;

use App\Http\Models\UserDevice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;
use DB;
use Session;
use App\Models\User;
class LogoutController extends Controller
{

    public function logout(Request $request) {
        if($request->has("serial")){
            UserDevice::where("serial",$request["serial"])->update(["status" => "D"]);
        }
        $request->user()->token()->revoke();

        return  response()->json(['success'=> true,'message'=>'Successfully logged out']);
    }

}