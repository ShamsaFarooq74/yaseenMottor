<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use App\Http\Models\ProductCategory;
use App\Http\Models\Parts;
use App\Http\Models\PartYear;
use App\Http\Models\Mod_el;
use App\Http\Models\PartMake;
use Illuminate\Http\Request;
use DB;

class Categorycontroller extends Controller
{
    function display()
    {
        $data = ProductCategory::where('is_deleted', 'N')->get();
        foreach ($data as $dat) {
            if (empty($dat['image'])) {
                $dat['image'] = 'xyz';
            }
            $file = public_path() . '/assets/category/' . $dat['image'];
            if (!empty($dat['image']) && file_exists($file)) {
                $dat['image'] = getImageUrl($dat->image, 'category');
            } else {
                $dat['image'] = getImageUrl('parts.png', 'partss');
            }

        }
        if ($data) {
            return response()->json(['success' => 1, 'message' => 'categories display successfully', 'data' => $data]);
        } else {
            return response()->json(['success' => 0, 'message' => "categories does't display"]);
        }
    }
    // latest
    function categories(Request $req)
    {
        if($req->make_id == null && $req->model_id == null){
            $data = ProductCategory::where('is_deleted', 'N')->get();
        }
        else if($req->make_id !=null && $req->model_id == null){
            $getMake = PartMake::where('make_id', $req->make_id)->pluck('part_id');
            $getModelId = PartYear::whereIn('part_id',$getMake)->pluck('model_id');
            $getActiveModels = Mod_el::where('make_id', $req->make_id)->whereIn('id',$getModelId)->where('is_active',1)->where('is_delete',0)->pluck('id');
            $getModelId = PartYear::whereIn('model_id',$getActiveModels)->pluck('part_id');

            $getCatId = Parts::whereIn('id',$getModelId)->where('is_active',1)->where('is_delete',0)->groupBy('cat_id')->pluck('cat_id');
            $data = ProductCategory::whereIn('id',$getCatId)->where('is_deleted', 'N')->get();
        }
        else if(($req->make_id == null || $req->make_id == "null") && $req->model_id != null){
            $makeId = Mod_el::where('id',$req->model_id)->first()['make_id'];
            $getMakes = PartMake::where('make_id', $makeId)->pluck('part_id');
            $getModelId = PartYear::where('model_id',$req->model_id)->whereIn('part_id',$getMakes)->pluck('part_id');
            $getMakeId = Parts::whereIn('id',$getModelId)->where('is_active',1)->where('is_delete',0)->groupBy('cat_id')->pluck('cat_id');
            $data = ProductCategory::whereIn('id',$getMakeId)->where('is_deleted', 'N')->get();
        }
        else{
            $getMakes = PartMake::where('make_id', $req->make_id)->pluck('part_id');
            $getModelId = PartYear::where('model_id',$req->model_id)->whereIn('part_id',$getMakes)->pluck('part_id');
            $getMakeId = Parts::whereIn('id',$getModelId)->where('is_active',1)->where('is_delete',0)->groupBy('cat_id')->pluck('cat_id');
            $data = ProductCategory::whereIn('id',$getMakeId)->where('is_deleted', 'N')->get();
        }
        foreach ($data as $dat) {
            if (empty($dat['image'])) {
                $dat['image'] = 'xyz';
            }
            $file = public_path() . '/images/settings/' . $dat['image'];
            if (!empty($dat['image']) && file_exists($file)) {
                $dat['image'] = getImageUrl($dat->image, 'settings');
            } else {
                $dat['image'] = getImageUrl('parts.png', 'partss');
            }
        }
        if ($data) {
            return response()->json(['success' => 1, 'message' => 'categories display successfully', 'data' => $data]);
        } else {
            return response()->json(['success' => 0, 'message' => "categories does't display"]);
        }
    }
}
