<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Rules\OldPasswordMatch;

class ProfileController extends Controller
{
    // function addprofile(Request $req)
    // {
    //     // return $req->;
    //     $req->validate([
    //         'name'=>'required',
    //         'city'=>'required',
    //     ]);
    //     // $data=User::where('id',$id)->first();
    //     $data=new User;
    //     $data->name=$req->name;
    //     $data->city=$req->city;
    //     if($req->hasFile('image')){
    //     $image =$req->image;
    //     $filename = time() . '.' . $image->getClientOriginalExtension();
	// 	$image->move(public_path('assets/profile/ProfileImage/'), $filename);
    //     $data->image = $image;
    //     }
    //    $result= $data->save();
    //     if($result){
	// 		return response()->json(["Profile updated"]);
	// 	}
	// 	else{
	// 		return response()->json(["Please fill field carefully"]);
	// 	}

    // }
    function displayprofile(Request $req)
    {
        $data=User::select('*')->where('id',$req->user_id)->get();
        // return $data;
			return response()->json(['data'=>$data]);
    }
    function updateprofile(Request $req)
    {
        $req->validate([
            // 'name'=>'required',
        ]);
        $data=User::where('id',$req->user_id)->first();
        if($req->get('name')){
        $data->username=$req->name;
        }
        if($req->get('city')){
        $data->location=$req->city;
        }
        if($req->get('number')){
            $data->phone=$req->phone;
        }
        if($req->hasFile('image')){
        $image =$req->image;
        $filename = time() . '.' . $image->getClientOriginalName();
		$image->move(public_path('assets/profile/ProfileImage/'), str_replace(' ', '', $filename));
        $data->image = $filename;
        }
        $data->save();
        if($data->save()){
			return response()->json(['success'=>true, 'message'=>'Profile updated']);
		}
		else{
			return response()->json(['success'=>true, 'message'=>'Please fill field carefully']);
		}

    }
    public function changepass(Request $request){
        // $userid=Auth::id();
        // $currentPass = Hash::make($req->current_pass);
        // $verifyuser=User::where('id',$userid)->where('password',$currentPass)->first();
        $validator = Validator::make($request->all(), [
            'current_pass' => ['required', new OldPasswordMatch],
            'new_pass' => 'required',
            'confirm_pass' => 'required|same:new_pass',
        ]);

        if ($validator->fails()) {

            return response()->json(['success'=> 0, 'message'=>$validator->errors()->first()]);

        }

        $request['new_pass'] = Hash::make($request['new_pass']);

        $user = User::where('id', $request->user()->id)->update(['password' => $request['new_pass']]);
        if ($user) {

            return response()->json(['success'=> 1, 'message'=>'Password change successfully']);

        }
    }
    function deleteUser(){

        $userDetail = User::where('id',Auth::user()->id)->first();
        $userDetail->is_deleted = 'Y';
        $user = $userDetail->save();
        if($user){
            return response()->json(['success'=> 1, 'message'=>'User deleted successfully']);
        }else{
            return response()->json(['success'=> 0, 'message'=>"User didn't delete successfully"]);
        }
    }

}
