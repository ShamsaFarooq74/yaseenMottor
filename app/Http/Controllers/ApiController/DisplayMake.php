<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Models\Make;
use App\Http\Models\Mod_el;
use DB;

class DisplayMake extends Controller
{
    function display(Request $request)
    {
        $value = array();
        if($request->value == null){
//            $data = Make::where('is_active', '1')->where('is_delete', '0')->get()->sortBy('make');
//            $data = Make::whereIn('id', [98,113]) // Replace [2, 5, 3] with the specific IDs you want to fetch
//            ->where('is_active', '1')
//                ->where('is_delete', '0')
//                ->orderByRaw('FIELD(id, 98, 113, 3)') // Replace [2, 5, 3] with the specific IDs you want to fetch
//                ->orderBy('make')
//                ->get();
            $specificIds = [98,113,112]; // IDs of the records you want to fetch first

            $data = Make::where('is_active', '1')
                ->where('is_delete', '0')
                ->orderByRaw("FIELD(id, " . implode(',', $specificIds) . ") DESC")
                ->orderBy('make')
                ->get();


            foreach ($data as $dat) {
                if (empty($dat['logo'])) {
                    $dat['logo'] = 'xyz';
                }
                $file = public_path() . '/images/settings/' . $dat['logo'];
                if (!empty($dat['logo']) && file_exists($file)) {
                    $dat['logo'] = getImageUrl($dat->logo,'settings');
                } else {
                    $dat['logo'] = getImageUrl('parts.png', 'partss');
                }
                $dat['type'] = "make";
                array_push($value , $dat);
            }
            if ($data) {
                return response()->json(['success' => 1, 'message' => 'make display successfully', 'make' => $value]);
            } else {
                return response()->json(['success' => 1, 'message' => "make didn't display", 'make' => $value]);
            }
        }
        else{
            $searchMake = Make::where('make','LIKE','%'.$request->value.'%')->where('is_active', '1')->where('is_delete', '0')->get()->sortBy('make');
            if(count($searchMake) != 0){
                foreach($searchMake as $make){
                    $file = public_path() . '/images/settings/' . $make->logo;
                    if (!empty($make->logo) && file_exists($file)) {
                        $make['logo'] = getImageUrl($make->logo,'settings');
                    } else {
                        $make['logo'] = getImageUrl('parts.png', 'partss');
                    }
                    $make['type'] = "make";
                }
            }
            if(count($searchMake) == 0){
                $searchMake = Mod_el::where('model_name','LIKE','%'.$request->value.'%')->where('is_active', '1')->where('is_delete','0')->get()->makeHidden(['model_name','image']);
                if(count($searchMake) != 0){
                        foreach($searchMake as $make){
                            if (empty($make['image'])) {
                                $make['logo'] = 'xyz';
                            }
                            $file = public_path() .'/images/settings/'. $make['image'];
                            if ($make['image'] !=null && file_exists($file)) {
                                $make['logo'] = getImageUrl($make->image,'model');
                            } else {
                                $make['logo'] = getImageUrl('parts.png', 'partss');
                            }
                            $make['make'] = $make->model_name;
                            $make['type'] = "model";
                        }
                    return response()->json(['success' => 1, 'message' => 'model display successfully', 'make' => $searchMake]);
                }
                else{
                    return response()->json(['success' => 1, 'message' => "NO such data found", 'make' => $searchMake]);
                }
            }
            else{
                return response()->json(['success' => 1, 'message' => "make display successfully", 'make' => $searchMake]);
            }
        }
    }
}
