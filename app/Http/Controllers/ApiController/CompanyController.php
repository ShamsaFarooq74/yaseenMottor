<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Company;
use App\Http\Models\User;
use DB;
use Auth;
use Validator;

class CompanyController extends Controller
{
    function addcompanydetail(Request $req)
    {
        // return $req->all();

        $userid = Auth::user()->id;
        $companyexist = Company::where('user_id',$userid)->first();
        if(! $companyexist){
            $validator = Validator::make($req->all(), [
                'name' => 'required',
                'image' => 'required',
            ]);

            if ($validator->fails()) {

                return response()->json(['success'=> 0, 'message'=>$validator->errors()->first()]);

            }
            $data=new Company;
            $data->name=$req->name;
            if($req->hasFile('image')){
                $image =$req->image;
                $filename = time() . '.' . $image->getClientOriginalName();
                $image->move(public_path('assets/profile/companyimage/'), $filename);
                $data->image = $filename;
                }
            $data->user_id=$userid;
            $result=$data->save();
            if($result){
                return response()->json(['success'=>1,'message'=>'Company detail added successfully']);
            }
            else{
                return response()->json(['success'=>0,'message'=>'Please fill field carefully']);
            }
        } if($companyexist) {
            $companyexist->name = $req->name;
            if ($req->hasFile('image')) {
                $image = $req->image;
                $filename = time() . '.' . $image->getClientOriginalName();
                $image->move(public_path('assets/profile/companyimage/'), $filename);
                $companyexist->image = $filename;
            }
            $companyexist->user_id = $userid;
            $update = $companyexist->save();
            if($update){
                return response()->json(['success'=>1,'message'=>'Company detail updated successfully']);
            }
            else{
                return response()->json(['success'=>0,'message'=>'Please fill field carefully']);
            }

        }
        else{
            return response()->json(['success'=>0,'message'=>'Company Already Added']);
        }
    }
    function displaycompanydetail(Request $req)
    {
        $userid = Auth::user()->id;
        $companyDetail=Company::select('name','image')->where('user_id',$userid)->get();
        if(count($companyDetail) > 0){
        return response()->json(['success'=> 1,'message'=>'company detail display successfully','data'=>$companyDetail]);
        }
        else{
        return response()->json(['success'=> 0,'message'=>"No company detail"]);
        }
    }
}
