<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;
use Validator;

class forgetpasswordApi extends Controller
{
    function verifynumber(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'number' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => 0, 'message' => $validator->errors()->first()]);
        }
        $req['number'] = substr($req['number'], -10);
        $verifyNumber = User::where('phone', 'LIKE', '%' . $req['number'])->first();
        if ($verifyNumber) {
            return response()->json(['success' => 1, 'message' => 'Valid Number', 'data' => $verifyNumber]);
        } else {
            return response()->json(['success' => 0, 'message' => "Invalid Number!",'data' => ['Name'=> "Mehbob"] ]);
        }
    }
    function forgetpassword(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password',
            'user_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => 0, 'message' => $validator->errors()->first()]);
        }
        $verifyNumber = User::where('id',$req->user_id)->first();
        $req['new_password'] = Hash::make($req['new_password']);
        $verifyNumber->password = $req['new_password'];
        $verifyNumber->save();
        if ($verifyNumber) {
            return response()->json(['success' => 1, 'message' => 'Password changed successfully', 'data' => $verifyNumber]);
        } else {
            return response()->json(['success' => 0, 'message' => "Something went wrong!, Password doesn't change"]);
        }
    }
}
