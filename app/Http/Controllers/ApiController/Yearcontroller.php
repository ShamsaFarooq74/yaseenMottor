<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use App\Http\Models\Configuration;
use Illuminate\Http\Request;
use App\Models\Year;
use App\Models\Category;
use DB;
use Illuminate\Support\Carbon;

class Yearcontroller extends Controller
{

    function year(){
//        $data=DB::table('year')->get();
        $fromYear = Configuration::where('key', 'from_year')->first();
        $years = range(Carbon::now()->year, $fromYear->value);
//        if($data){
        return response()->json(['success'=>1,'message'=>'year display successfully','data'=>$years]);
//        }
//        else{
//        return response()->json(['success'=>'0','message'=>"year didn't display"]);
//        }
    }
}
