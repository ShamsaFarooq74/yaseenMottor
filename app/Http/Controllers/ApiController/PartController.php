<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Api\ResponseController;
use App\Http\Controllers\Controller;
use App\Http\Models\Configuration;
use App\Http\Models\Manufacture;
use App\Http\Models\Mod_el;
use App\Http\Models\Orderitem;
use App\Http\Models\PartDetails;
use App\Http\Models\PartImage;
use App\Http\Models\Parts;
use App\Http\Models\PartYear;
use App\Http\Models\ProductCategory;
use App\Http\Models\User;
use Elementor\Core\Settings\Base\Model;
use Illuminate\Http\Request;
use App\Http\Models\Year;
use App\Http\Models\Modelyear;
use App\Http\Models\Category;
use App\Http\Models\Make;
use App\Http\Models\PartMake;
//use App\http\Models\Parts;

use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PartController extends ResponseController
{
    function displayparts(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'ref_number' => 'required',
        ]);
        if (!PartDetails::where('ref_no', 'LIKE','%'.$req->ref_number.'%')->where('is_active',1)->where('is_delete',0)->exists()) {
           return $this->sendError(0, 'Reference number not exist');
}

        if ($validator->fails()) {
            return $this->sendError(0, $validator->errors()->first());
        }
        $PartsCategoryIDs = PartDetails::where('ref_no', 'LIKE','%'.$req->ref_number.'%')->where('is_active',1)->where('is_delete',0)->pluck("cat_id");
        $Categories = ProductCategory::whereIn('id', $PartsCategoryIDs)->where('is_deleted',"N")->pluck('id');
        $displayParts = PartDetails::where('ref_no', 'LIKE','%'.$req->ref_number.'%')->where('is_active',1)->where('is_delete',0)->whereIn("cat_id",$Categories)->first();
//        $displayParts = PartDetails::where('ref_no', $req->ref_number)->where('is_active',1)->where('is_delete',0)->first();
        if($displayParts) {
            $file = public_path() . '/images/settings/' . $displayParts['image'];
            if (!empty($displayParts['image']) && file_exists($file)) {
                $displayParts['image'] = getImageUrl($displayParts['image'], 'settings');
            } else {
                $displayParts['image'] = getImageUrl('parts.png', 'partss');
            }
            $category = ProductCategory::where('id', $displayParts['cat_id'])->first();
            $manufacturer = Manufacture::where('id', $displayParts->manufacturer)->first();
            if ($manufacturer) {
                $displayParts['manufactureName'] = $manufacturer->manufacture;
            }
            if ($manufacturer && $manufacturer->image) {

                $displayParts['manufactureImage'] = getImageUrl($manufacturer->image, 'manufacture');
            } else {
                $displayParts['manufactureImage'] = getImageUrl('manufacture.png', 'default-images');
            }
            $displayParts['category'] = $category['category'];
            if (empty($category['image'])) {
                $category['image'] = 'xyz';
            }
            $file = public_path() . '/images/settings/' . $category['image'];
            if (!empty($category['image']) && file_exists($file)) {
                $displayParts['categoryImage'] = getImageUrl($category['image'], 'settings');
            } else {
                $displayParts['categoryImage'] = getImageUrl('parts.png', 'partss');
            }
            $makeID = PartMake::where('part_id',$displayParts['id'])->first()['make_id'];
            $make = Make::where('id', $makeID)->select('make','logo')->first();
            $displayParts['make'] = $make['make'];
            if (empty($make['logo'])) {
                $make['logo'] = 'xyz';
            }
            $file = public_path() . '/images/settings/' . $make['logo'];
            if (!empty($make['logo']) && file_exists($file)) {
                $displayParts['makeImage'] = getImageUrl($make['logo'], 'settings');
            } else {
                $displayParts['makeImage'] = getImageUrl('parts.png', 'partss');
            }
            if (Modelyear::where('part_id', $displayParts['id'])->exists()) {
            $displayParts['model'] = DB::table('part_years')->join('model','part_years.model_id','=','model.id')->where('part_years.part_id','=',$displayParts['id'])->where('model.is_active','=','1')->where('is_delete','=','0')->select('part_years.*')->groupBy('part_years.model_id')->get();
                for ($k = 0; $k < count($displayParts['model']); $k++) {
                        $displayParts['model'][$k]->model= Mod_el::where('id', $displayParts['model'][$k]->model_id)->where('is_delete',0)->where('is_active',1)->first()['model_name'];

                }
            } else {
                $displayParts['model'] = [];
            }
            if (PartImage::where('part_id', $displayParts['id'])->exists()) {
                $displayParts['images'] = PartImage::where('part_id', $displayParts['id'])->get();
                for ($l = 0; $l < count($displayParts['images']); $l++) {
                    $file = public_path() . '/images/parts/' . $displayParts['images'][$l]['image'];
                    if (!empty($displayParts['images'][$l]['image']) && file_exists($file)) {
                        $displayParts['images'][$l]['image'] = getImageUrl($displayParts['images'][$l]['image'], 'parts');
                    } else {
                        $displayParts['images'][$l]['image'] = getImageUrl('parts.png', 'partss');
                    }
                }

            } else {
                $displayPart= getImageUrl('parts.png', 'partss');
                $display = ['image'=>$displayPart];
                $displayParts['images'] = array($display);
            }
            return $this->sendResponse(1, 'success', $displayParts);

        }
        else
        {
            $PartsCategoryIDs = PartDetails::where('ref_no', 'LIKE','%'.$req->ref_number.'%')->where('is_active',1)->where('is_delete',0)->pluck("cat_id");
            $Categories = ProductCategory::whereIn('id', $PartsCategoryIDs)->where('is_deleted',"N")->pluck('id');
            $displayParts12 = PartDetails::where('ref_no', 'LIKE','%'.$req->ref_number.'%')->where('is_active',1)->where('is_delete',0)->whereIn("cat_id",$Categories)->get();

//            return $displayPa;
            foreach ( $displayParts12 as $key => $displayParts) {
                $file = public_path() . '/images/settings/' . $displayParts['image'];
                if (!empty($displayParts['image']) && file_exists($file)) {
                    $displayParts['image'] = getImageUrl($displayParts['image'], 'settings');
                } else {
                    $displayParts['image'] = getImageUrl('parts.png', 'partss');
                }
                $category = ProductCategory::where('id', $displayParts['cat_id'])->first();
                $manufacturer = Manufacture::where('id', $displayParts->manufacturer)->first();
                if ($manufacturer) {
                    $displayParts['manufactureName'] = $manufacturer->manufacture;
                }
                if ($manufacturer && $displayParts['manufactureImage']) {
                    $displayParts['manufactureImage'] = getImageUrl($manufacturer->image, 'manufacture');
                } else {
                    $displayParts['manufactureImage'] = getImageUrl('manufacture.png', 'default-images');
                }
                $displayParts['category'] = $category['category'];
                if (empty($category['image'])) {
                    $category['image'] = 'xyz';
                }
                $file = public_path() . '/images/settings/' . $category['image'];
                if (!empty($category['image']) && file_exists($file)) {
                    $displayParts['categoryImage'] = getImageUrl($category['image'], 'settings');
                } else {
                    $displayParts['categoryImage'] = getImageUrl('parts.png', 'partss');
                }
                $makeID = PartMake::where('part_id',$displayParts['id'])->first()['make_id'];
                $make = Make::where('id', $makeID)->select('make','logo')->first();
                $displayParts['make'] = $make['make'];
                if (empty($make['logo'])) {
                    $make['logo'] = 'xyz';
                }
                $file = public_path() . '/images/settings/' . $make['logo'];
                if (!empty($make['logo']) && file_exists($file)) {
                    $displayParts['makeImage'] = getImageUrl($make['logo'], 'settings');
                } else {
                    $displayParts['makeImage'] = getImageUrl('parts.png', 'partss');
                }

                if (Modelyear::where('part_id', $displayParts['id'])->exists()) {
                    $displayParts['model'] = DB::table('part_years')->join('model','part_years.model_id','=','model.id')->where('part_years.part_id','=',$displayParts['id'])->where('model.is_active','=','1')->where('is_delete','=','0')->select('part_years.*')->groupBy('part_years.model_id')->get();
                    for ($k = 0; $k < count($displayParts['model']); $k++) {
                            $displayParts['model'][$k]->model= Mod_el::where('id', $displayParts['model'][$k]->model_id)->where('is_delete',0)->where('is_active',1)->first()['model_name'];

                    }
                } else {
                    $displayParts['model'] = [];
                }
                if (PartImage::where('part_id', $displayParts['id'])->exists()) {
                    $displayParts['images'] = PartImage::where('part_id', $displayParts['id'])->get();
                    for ($l = 0; $l < count($displayParts['images']); $l++) {
                        $file = public_path() . '/images/parts/' . $displayParts['images'][$l]['image'];
                        if (!empty($displayParts['images'][$l]['image']) && file_exists($file)) {
                            $displayParts['images'][$l]['image'] = getImageUrl($displayParts['images'][$l]['image'], 'parts');
                        } else {
                            $displayParts['images'][$l]['image'] = getImageUrl('parts.png', 'partss');
                        }
                    }

                } else {
                    $displayPart= getImageUrl('parts.png', 'partss');
                    $display = ['image'=>$displayPart];
                    $displayParts['images'] = array($display);
                }
            }
            return $this->sendResponse(1, 'success', $displayParts12);

        }
//        }
    }
//old without pagination
    function searchparts(Request $req)
    {

        // return  $req->all();

        $all_parts = array();
        $where = array();
        $where_array = [];
        $modelaArray = [];

        if ($req->category) {
            $where_array['parts.cat_id'] = $req->category;
        }
        if ($req->model) {
            $modelaArray['part_years.model_id'] = $req->model;
        }
        if ($req->year) {
            $modelaArray['part_years.min_year'] = $req->year;
        }
        if($req->make){
            $partIds = PartMake::where("make_id",$req->make)->pluck('part_id');
            // $partIds = Parts::where("make_id",$req->make)->pluck('id');
        }
        if ( $req->ref_no || $req->make || !empty($modelaArray)) {
            // return $modelaArray['part_years.min_year'];
            // $partIds = Modelyear::where($modelaArray)->pluck('part_id');
            if($req->make){
                $getParts = PartMake::where("make_id",$req->make)->pluck('part_id');
                $getModelId = PartYear::whereIn('part_id',$getParts)->pluck('model_id');
                $getActiveModels = Mod_el::where('make_id', $req->make)->whereIn('id',$getModelId)->where('is_active',1)->where('is_delete',0)->pluck('id');
                $partIds = PartYear::whereIn('model_id',$getActiveModels)->pluck('part_id');
                // $partIds = Parts::where("make_id",$req->make)->pluck('id');
            }
            if($req->get('model')){

                $partIds = Modelyear::where('model_id',$req->model)->pluck('part_id');
                }
            if($req->get('year')){
            $partIds = Modelyear::where('min_year', '<=', $req['year'])->where('max_year', '>=', $req['year'])->pluck('part_id');
            }
            if($req->ref_no){
                $partIds = Parts::where('ref_no', 'LIKE','%'.$req->ref_no.'%')->pluck('id');
            }
            if(($req->get('model')) && ($req->get('year')) )
            {
            $partIds = Modelyear::where('min_year', '<=', $req['year'])->where('max_year', '>=', $req['year'])->where('model_id',$modelaArray['part_years.model_id'])->pluck('part_id');

            }
            // $partIds = Modelyear::where('min_year', '<=', $req['year'])->where('max_year', '>=', $req['year'])->pluck('part_id');
            $CategoriesIDS = PartDetails::where($where_array)->whereIn('id', $partIds)->where('is_active',1)->where('is_delete',0)->pluck('cat_id');
            $Categories = ProductCategory::whereIn('id', $CategoriesIDS)->where('is_deleted',"N")->pluck('id');
            $parts = PartDetails::where($where_array)->whereIn('id', $partIds)->where('is_active',1)->where('is_delete',0)->whereIn("cat_id",$Categories)->get();

        } elseif (!empty($where_array)) {

            $Categories = ProductCategory::where('is_deleted','N')->where('id',$req->category)->pluck('id');
            $parts = PartDetails::where('is_delete', 0)->where('is_active', 1)->whereIn('cat_id',$Categories)->get();
        } else {
            $parts = [];
        }
        if ($parts) {
            for ($i = 0; $i < count($parts); $i++) {
                $manufacturer = Manufacture::where('id', $parts[$i]->manufacturer)->first();
                $parts[$i]['manufactureName'] = $manufacturer->manufacture;
                $parts[$i]['manufactureImage'] = getImageUrl($manufacturer->image, 'manufacture');
                $category = ProductCategory::where('id', $parts[$i]['cat_id'])->first();
                $parts[$i]['category'] = $category['category'];
                if (empty($category['image'])) {
                    $category['image'] = 'xyz';
                }
                $file = public_path() . '/images/settings/' . $category['image'];
                if (!empty($category['image']) && file_exists($file)) {
                    $parts[$i]['categoryImage'] = getImageUrl($category['image'], 'settings');
                } else {
                    $parts[$i]['categoryImage'] = getImageUrl('parts.png', 'partss');
                }
                $makeID = PartMake::where('part_id',$parts[$i]['id'])->first()['make_id'];
                $make = Make::where('id', $makeID)->select('make','logo')->first();
                // $make = Make::where('id', $displayParts['make_id'])->first();
                $parts[$i]['make'] = $make['make'];
                if (empty($make['logo'])) {
                    $make['logo'] = 'xyz';
                }
                $file = public_path() . '/images/settings/' . $make['logo'];
                if (!empty($make['logo']) && file_exists($file)) {
                    $parts[$i]['makeImage'] = getImageUrl($make['logo'], 'settings');
                } else {
                    $parts[$i]['makeImage'] = getImageUrl('parts.png', 'partss');
                }
                if (PartImage::where('part_id', $parts[$i]['id'])->exists()) {
                    $parts[$i]['image'] = PartImage::where('part_id', $parts[$i]['id'])->first()['image'];
                    $string = substr($parts[$i]['image'],  -3);
                    if($string == "JPG"){
                        $imageName = substr($parts[$i]['image'],  0,-3);
                        $parts[$i]['image'] = $imageName."jpg";
                    }
//                    for ($l = 0; $l < count($parts[$i]['images']); $l++) {
                    $file = public_path() . '/images/parts/' . $parts[$i]['image'];
                    if (!empty($parts[$i]['image']) && file_exists($file)) {
                        $parts[$i]['image'] = getImageUrl($parts[$i]['image'], 'parts');
                    } else {
                        $parts[$i]['image'] = getImageUrl('parts.png', 'partss');
                    }
//                    }

                } else {
                    $parts[$i]['image'] = '';
                }
                $Modelid = Modelyear::where('part_id',$parts[$i]['id'])->first();
                if($Modelid){
                    $modelDetail = Mod_el::where('id',$Modelid->model_id)->first();
                    $parts[$i]['model_name'] = $modelDetail->model_name;
                }else{
                    $parts[$i]['model_name'] = "N/A";
                }

            }
        }
        // return $req;
        // Model
//        if (($req->get('model')) && !($req->get('year')) && !($req->get('category'))) {
//            $where['model_id'] = $req->model;
//            $data = Modelyear::select('part_id')->where('model_id', $where['model_id'])->get();
//            // return $data;
//            foreach ($data as $d) {
//                $all_parts = Parts::where('id', $d->part_id)->where('is_active', '1')->where('is_delete', '0')->get();
//                foreach ($all_parts as $dat) {
//                    $dat['image'] = getImageUrl($dat->image, 'parts');
//                }
//            }
//        }
//        // Year
//        if (!($req->get('model')) && ($req->get('year')) && !($req->get('category'))) {
//            $where['id'] = $req->year;
//            $data = Modelyear::select('part_id')->where('min_year', '<=', $where['id'])->where('max_year', '>=', $where['id'])->get();
//            foreach ($data as $d) {
//                $all_parts = Parts::where('id', $d->part_id)->where('is_active', '1')->where('is_delete', '0')->get();
//                foreach ($all_parts as $dat) {
//                    $dat['image'] = getImageUrl($dat->image, 'parts');
//                }
//            }
//        }
//        // Category
//        if (!($req->get('model')) && !($req->get('year')) && ($req->get('category'))) {
//            $where['cat_id'] = $req->category;
//            $all_parts = Parts::where('cat_id', $where['cat_id'])->where('is_active', '1')->where('is_delete', '0')->get();
//            foreach ($all_parts as $dat) {
//                $dat['image'] = getImageUrl($dat->image, 'parts');
//            }
//        }
//        // Model || Year
//        if (($req->get('model')) && ($req->get('year')) && !($req->get('category'))) {
//            $where['model_id'] = $req->model;
//            $where['id'] = $req->year;
//            $data = Modelyear::select('part_id')->where('model_id', $where['model_id'])->where('min_year', '<=', $where['id'])->where('max_year', '>=', $where['id'])->get();
//            foreach ($data as $d) {
//                $all_parts = Parts::where('id', $d->part_id)->where('is_active', '1')->where('is_delete', '0')->get();
//                foreach ($all_parts as $dat) {
//                    $dat['image'] = getImageUrl($dat->image, 'parts');
//                }
//            }
//        }
//        // Model || Category
//        if (($req->get('model')) && !($req->get('year')) && ($req->get('category'))) {
//            $where['model_id'] = $req->model;
//            $where['cat_id'] = $req->category;
//            $data = Modelyear::select('part_id')->where('model_id', $where['model_id'])->get();
//            $cat_part_ids = Parts::select('id')->where('cat_id', $where['cat_id'])->get();
//            foreach ($data as $d) {
//                foreach ($cat_part_ids as $d2) {
//                    if ($d->part_id == $d2->id)
//                        $all_parts = Parts::where('id', $d->part_id)->where('is_active', '1')->where('is_delete', '0')->get();
//                    foreach ($all_parts as $dat) {
//                        $dat['image'] = getImageUrl($dat->image, 'parts');
//                    }
//                }
//            }
//        }
//        // Year || Category
//        if (!($req->get('model')) && ($req->get('year')) && ($req->get('category'))) {
//            $where['id'] = $req->year;
//            $where['cat_id'] = $req->category;
//            $data = Modelyear::select('part_id')->where('min_year', '<=', $where['id'])->where('max_year', '>=', $where['id'])->get();
//            $cat_part_ids = Parts::select('id')->where('cat_id', $where['cat_id'])->get();
//            foreach ($data as $d) {
//                foreach ($cat_part_ids as $d2) {
//                    if ($d->part_id == $d2->id)
//                        $all_parts = Parts::where('id', $d->part_id)->where('is_active', '1')->where('is_delete', '0')->get();
//                    foreach ($all_parts as $dat) {
//                        $dat['image'] = getImageUrl($dat->image, 'parts');
//                    }
//                }
//            }
//        }
//        // Model || Year || Category
//        if (($req->get('model')) && ($req->get('year')) && ($req->get('category'))) {
//            $where['model_id'] = $req->model;
//            $where['id'] = $req->year;
//            $where['cat_id'] = $req->category;
//            $data = Modelyear::select('part_id')->where('model_id', $where['model_id'])->where('min_year', '<=', $where['id'])->where('max_year', '>=', $where['id'])->get();
//            $cat_part_ids = Parts::select('id')->where('cat_id', $where['cat_id'])->get();
//            foreach ($data as $d) {
//                foreach ($cat_part_ids as $d2) {
//                    if ($d->part_id == $d2->id)
//                        $all_parts = Parts::where('id', $d->part_id)->where('is_active', '1')->where('is_delete', '0')->get();
//                    foreach ($all_parts as $dat) {
//                        $dat['image'] = getImageUrl($dat->image, 'parts');
//                    }
//                }
//            }
//        }
        return response()->json(['success' => 1, 'message' => 'parts display successfully', 'data' => $parts]);
    }
//latest with pagination
    function searchPart(Request $req)
    {

        // return  $req->all();

        $all_parts = array();
        $where = array();
        $where_array = [];
        $modelaArray = [];

        if ($req->category) {
            $where_array['parts.cat_id'] = $req->category;
        }
        if ($req->model) {
            $modelaArray['part_years.model_id'] = $req->model;
        }
        if ($req->year) {
            $modelaArray['part_years.min_year'] = $req->year;
        }
        if($req->make){
            $partIds = PartMake::where("make_id",$req->make)->pluck('part_id');
        }
        if ( $req->ref_no || $req->make || !empty($modelaArray)) {
            // return $modelaArray['part_years.min_year'];
            // $partIds = Modelyear::where($modelaArray)->pluck('part_id');
            if($req->make){
                $getParts = PartMake::where("make_id",$req->make)->pluck('part_id');
                $getModelId = PartYear::whereIn('part_id',$getParts)->pluck('model_id');
                $getActiveModels = Mod_el::where('make_id', $req->make)->whereIn('id',$getModelId)->where('is_active',1)->where('is_delete',0)->pluck('id');
                $partIds = PartYear::whereIn('model_id',$getActiveModels)->pluck('part_id');
            }
            if($req->get('model')){
                $partIds = Modelyear::where('model_id',$req->model)->pluck('part_id');
            }
            if($req->get('year')){
                $partIds = Modelyear::where('min_year', '<=', $req['year'])->where('max_year', '>=', $req['year'])->pluck('part_id');
            }
            if($req->ref_no){
                $partIds = Parts::where('ref_no', 'LIKE','%'.$req->ref_no.'%')->pluck('id');
            }
            if(($req->get('model')) && ($req->get('year')) )
            {
                $partIds = Modelyear::where('min_year', '<=', $req['year'])->where('max_year', '>=', $req['year'])->where('model_id',$modelaArray['part_years.model_id'])->pluck('part_id');

            }
            if(($req->get('model')) && ($req->get('make')) )
            {
                // $models = Mod_el::where("make_id",$req->make)->pluck('id');
                $parts = Modelyear::where('model_id',$req->model)->pluck('part_id');
                $partIds = PartMake::whereIn('part_id',$parts)->where('make_id', $req->make)->pluck('part_id');
                // $make = PartMake::where("make_id",$req->make)->pluck('part_id');
                // $partIds = Parts::where("make_id",$req->make)->whereIn('id', $modelIds)->pluck('id');
            }
            // $partIds = Modelyear::where('min_year', '<=', $req['year'])->where('max_year', '>=', $req['year'])->pluck('part_id');
            $CategoriesIDS = PartDetails::where($where_array)->whereIn('id', $partIds)->where('is_active',1)->where('is_delete',0)->pluck('cat_id');
            $Categories = ProductCategory::whereIn('id', $CategoriesIDS)->where('is_deleted',"N")->pluck('id');
            $parts = PartDetails::where($where_array)->whereIn('id', $partIds)->where('is_active',1)->where('is_delete',0)->whereIn("cat_id",$Categories)->paginate(10);

        } elseif (!empty($where_array)) {

            $Categories = ProductCategory::where('is_deleted','N')->where('id',$req->category)->pluck('id');
            $parts = PartDetails::where('is_delete', 0)->where('is_active', 1)->whereIn('cat_id',$Categories)->paginate(10);
        } else {
            $parts = [];
        }
        if ($parts) {
            for ($i = 0; $i < count($parts); $i++) {
                $manufacturer = Manufacture::where('id', $parts[$i]->manufacturer)->first();
                $parts[$i]['manufactureName'] = $manufacturer->manufacture;
                $parts[$i]['manufactureImage'] = getImageUrl($manufacturer->image, 'manufacture');
                $munufactureDiscount = DB::table("manufacture_discount")->where('users_id',Auth::user()->id)->where('manufacturer_id',$manufacturer->id)->first();
                if($munufactureDiscount ){
                    $parts[$i]['manufactureDiscount'] = isset($munufactureDiscount->discount) ? $munufactureDiscount->discount : 0;
                }else{
                    $parts[$i]['manufactureDiscount'] = 0;
                }
                $category = ProductCategory::where('id', $parts[$i]['cat_id'])->first();
                $parts[$i]['category'] = $category['category'];
                if (empty($category['image'])) {
                    $category['image'] = 'xyz';
                }
                $file = public_path() . '/images/settings/' . $category['image'];
                if (!empty($category['image']) && file_exists($file)) {
                    $parts[$i]['categoryImage'] = getImageUrl($category['image'], 'settings');
                } else {
                    $parts[$i]['categoryImage'] = getImageUrl('parts.png', 'partss');
                }
                // $makeID = PartMake::where('part_id',$parts[$i]->id)->pluck('make_id');
                // $make = Make::whereIn('id', $makeID)->select('make','logo')->get();
                // $makeNames = array();
                // foreach($make as $makes){
                //     $makes['make'] = $makes->make;
                //     if (empty($makes['logo'])) {
                //         $makes['makeImage'] = 'xyz';
                //     }
                //     $file = public_path() . '/images/settings/' . $makes['logo'];
                //     if (!empty($makes['logo']) && file_exists($file)) {
                //         $makes['makeImage'] = getImageUrl($makes['logo'], 'settings');
                //     } else {
                //         $makes['makeImage'] = getImageUrl('parts.png', 'partss');
                //     }
                //     array_push($makeNames,$makes);
                // }
                // $parts[$i]['make'] = $makeNames;
                $makeID = PartMake::where('part_id',$parts[$i]['id'])->first()['make_id'];
                $make = Make::where('id', $makeID)->select('make','logo')->first();
                $parts[$i]['make'] = $make['make'];
                if (empty($make['logo'])) {
                    $make['logo'] = 'xyz';
                }
                $file = public_path() . '/images/settings/' . $make['logo'];
                if (!empty($make['logo']) && file_exists($file)) {
                    $parts[$i]['makeImage'] = getImageUrl($make['logo'], 'settings');
                } else {
                    $parts[$i]['makeImage'] = getImageUrl('parts.png', 'partss');
                }
                if (PartImage::where('part_id', $parts[$i]['id'])->exists()) {
                    $parts[$i]['image'] = PartImage::where('part_id', $parts[$i]['id'])->first()['image'];
//                    $string = substr($parts[$i]['image'],  -3);
//                    if($string == "JPG"){
//                        $imageName = substr($parts[$i]['image'],  0,-3);
//                        $parts[$i]['image'] = $imageName."jpg";
//                    }
//                    for ($l = 0; $l < count($parts[$i]['images']); $l++) {
                    $file = public_path() . '/images/parts/' . $parts[$i]['image'];
                    if (!empty($parts[$i]['image']) && file_exists($file)) {
                        $parts[$i]['image'] = getImageUrl($parts[$i]['image'], 'parts');
                    } else {
                        $parts[$i]['image'] = getImageUrl('parts.png', 'partss');
                    }
//                    }

                } else {
                    $parts[$i]['image'] = '';
                }
                $Modelid = Modelyear::where('part_id',$parts[$i]['id'])->first();
                if($Modelid){
                    $modelDetail = Mod_el::where('id',$Modelid->model_id)->first();
                    $parts[$i]['model_name'] = $modelDetail->model_name;
                }else{
                    $parts[$i]['model_name'] = "N/A";
                }

            }
        }
        // return $req;
        // Model
//        if (($req->get('model')) && !($req->get('year')) && !($req->get('category'))) {
//            $where['model_id'] = $req->model;
//            $data = Modelyear::select('part_id')->where('model_id', $where['model_id'])->get();
//            // return $data;
//            foreach ($data as $d) {
//                $all_parts = Parts::where('id', $d->part_id)->where('is_active', '1')->where('is_delete', '0')->get();
//                foreach ($all_parts as $dat) {
//                    $dat['image'] = getImageUrl($dat->image, 'parts');
//                }
//            }
//        }
//        // Year
//        if (!($req->get('model')) && ($req->get('year')) && !($req->get('category'))) {
//            $where['id'] = $req->year;
//            $data = Modelyear::select('part_id')->where('min_year', '<=', $where['id'])->where('max_year', '>=', $where['id'])->get();
//            foreach ($data as $d) {
//                $all_parts = Parts::where('id', $d->part_id)->where('is_active', '1')->where('is_delete', '0')->get();
//                foreach ($all_parts as $dat) {
//                    $dat['image'] = getImageUrl($dat->image, 'parts');
//                }
//            }
//        }
//        // Category
//        if (!($req->get('model')) && !($req->get('year')) && ($req->get('category'))) {
//            $where['cat_id'] = $req->category;
//            $all_parts = Parts::where('cat_id', $where['cat_id'])->where('is_active', '1')->where('is_delete', '0')->get();
//            foreach ($all_parts as $dat) {
//                $dat['image'] = getImageUrl($dat->image, 'parts');
//            }
//        }
//        // Model || Year
//        if (($req->get('model')) && ($req->get('year')) && !($req->get('category'))) {
//            $where['model_id'] = $req->model;
//            $where['id'] = $req->year;
//            $data = Modelyear::select('part_id')->where('model_id', $where['model_id'])->where('min_year', '<=', $where['id'])->where('max_year', '>=', $where['id'])->get();
//            foreach ($data as $d) {
//                $all_parts = Parts::where('id', $d->part_id)->where('is_active', '1')->where('is_delete', '0')->get();
//                foreach ($all_parts as $dat) {
//                    $dat['image'] = getImageUrl($dat->image, 'parts');
//                }
//            }
//        }
//        // Model || Category
//        if (($req->get('model')) && !($req->get('year')) && ($req->get('category'))) {
//            $where['model_id'] = $req->model;
//            $where['cat_id'] = $req->category;
//            $data = Modelyear::select('part_id')->where('model_id', $where['model_id'])->get();
//            $cat_part_ids = Parts::select('id')->where('cat_id', $where['cat_id'])->get();
//            foreach ($data as $d) {
//                foreach ($cat_part_ids as $d2) {
//                    if ($d->part_id == $d2->id)
//                        $all_parts = Parts::where('id', $d->part_id)->where('is_active', '1')->where('is_delete', '0')->get();
//                    foreach ($all_parts as $dat) {
//                        $dat['image'] = getImageUrl($dat->image, 'parts');
//                    }
//                }
//            }
//        }
//        // Year || Category
//        if (!($req->get('model')) && ($req->get('year')) && ($req->get('category'))) {
//            $where['id'] = $req->year;
//            $where['cat_id'] = $req->category;
//            $data = Modelyear::select('part_id')->where('min_year', '<=', $where['id'])->where('max_year', '>=', $where['id'])->get();
//            $cat_part_ids = Parts::select('id')->where('cat_id', $where['cat_id'])->get();
//            foreach ($data as $d) {
//                foreach ($cat_part_ids as $d2) {
//                    if ($d->part_id == $d2->id)
//                        $all_parts = Parts::where('id', $d->part_id)->where('is_active', '1')->where('is_delete', '0')->get();
//                    foreach ($all_parts as $dat) {
//                        $dat['image'] = getImageUrl($dat->image, 'parts');
//                    }
//                }
//            }
//        }
//        // Model || Year || Category
//        if (($req->get('model')) && ($req->get('year')) && ($req->get('category'))) {
//            $where['model_id'] = $req->model;
//            $where['id'] = $req->year;
//            $where['cat_id'] = $req->category;
//            $data = Modelyear::select('part_id')->where('model_id', $where['model_id'])->where('min_year', '<=', $where['id'])->where('max_year', '>=', $where['id'])->get();
//            $cat_part_ids = Parts::select('id')->where('cat_id', $where['cat_id'])->get();
//            foreach ($data as $d) {
//                foreach ($cat_part_ids as $d2) {
//                    if ($d->part_id == $d2->id)
//                        $all_parts = Parts::where('id', $d->part_id)->where('is_active', '1')->where('is_delete', '0')->get();
//                    foreach ($all_parts as $dat) {
//                        $dat['image'] = getImageUrl($dat->image, 'parts');
//                    }
//                }
//            }
//        }
        return response()->json(['success' => 1, 'message' => 'parts display successfully', 'data' => $parts]);
    }
    public function homepageParts(Request $request)
    {
        $latestAdded = PartDetails::latest()->take(5)->get();
        for ($i = 0; $i < count($latestAdded); $i++) {
            $manufacturer = Manufacture::where('id', $latestAdded[$i]->manufacturer)->first();
            $latestAdded[$i]['manufactureName'] = $manufacturer->manufacture;
            $latestAdded[$i]['manufactureImage'] = getImageUrl($manufacturer->image, 'manufacture');
            $category = Category::where('id', $latestAdded[$i]['cat_id'])->first();
            $latestAdded[$i]['category'] = $category['category_name'];
            if (empty($category['image'])) {
                $category['image'] = 'xyz';
            }
            $file = public_path() . '/images/settings/' . $category['image'];
            if (!empty($category['image']) && file_exists($file)) {
                $latestAdded[$i]['categoryImage'] = getImageUrl($category['image'], 'settings');
            } else {
                $latestAdded[$i]['categoryImage'] = getImageUrl('parts.png', 'partss');
            }
            $makeID = PartMake::where('part_id',$latestAdded[$i]['id'])->first()['make_id'];
            $make = Make::where('id', $makeID)->select('make','logo')->first();
            $latestAdded[$i]['make'] = $make['make'];
            if (empty($make['logo'])) {
                $make['logo'] = 'xyz';
            }
            $file = public_path() . '/images/settings/' . $make['logo'];
            if (!empty($make['logo']) && file_exists($file)) {
                $latestAdded[$i]['makeImage'] = getImageUrl($make['logo'], 'settings');
            } else {
                $latestAdded[$i]['makeImage'] = getImageUrl('parts.png', 'partss');
            }
//            if (Modelyear::where('part_id', $latestAdded[$i]['id'])->exists()) {
//                $latestAdded[$i]['model'] = Modelyear::where('part_id', $latestAdded[$i]['id'])->get();
//                for ($k = 0; $k < count($latestAdded[$i]['model']); $k++) {
//                    $latestAdded[$i]['model'][$k]['model'] = Mod_el::where('id', $latestAdded[$i]['model'][$k]['model_id'])->first()['model_name'];
//                }
//            } else {
//                $latestAdded[$i]['model'] = [];
//            }
            if (PartImage::where('part_id', $latestAdded[$i]['id'])->exists()) {
                $latestAdded[$i]['image'] = PartImage::where('part_id', $latestAdded[$i]['id'])->first()['image'];
//                for ($l = 0; $l < count($latestAdded[$i]['images']); $l++) {
                $file = public_path() . '/images/parts/' . $latestAdded[$i]['image'];
                if (!empty($latestAdded[$i]['image']) && file_exists($file)) {
                    $latestAdded[$i]['image'] = getImageUrl($latestAdded[$i]['image'], 'parts');
                } else {
                    $latestAdded[$i]['image'] = getImageUrl('parts.png', 'partss');
                }
//                }

            } else {
                $latestAdded[$i]['image'] = '';
            }
        }
        $orderItem = Orderitem::groupBy('part_id')->havingRaw('COUNT(*) >= 5')->pluck('part_id');
        $topTrending = PartDetails::whereIn('id', $orderItem)->where('is_delete', '0')->get();
        for ($i = 0; $i < count($topTrending); $i++) {
            $manufacturer = Manufacture::where('id', $topTrending[$i]->manufacturer)->first();
            $topTrending[$i]['manufactureName'] = $manufacturer->manufacture;
            $topTrending[$i]['manufactureImage'] = getImageUrl($manufacturer->image, 'manufacture');
            $category = Category::where('id', $topTrending[$i]['cat_id'])->first();
            $topTrending[$i]['category'] = $category['category_name'];
            if (empty($category['image'])) {
                $category['image'] = 'xyz';
            }
            $file = public_path() . '/images/settings/' . $category['image'];
            if (!empty($category['image']) && file_exists($file)) {
                $topTrending[$i]['categoryImage'] = getImageUrl($category['image'], 'settings');
            } else {
                $topTrending[$i]['categoryImage'] = getImageUrl('parts.png', 'partss');
            }
            $makeID = PartMake::where('part_id',$topTrending[$i]['id'])->first()['make_id'];
            $make = Make::where('id', $makeID)->select('make','logo')->first();
            $topTrending[$i]['make'] = $make['make'];
            if (empty($make['logo'])) {
                $make['logo'] = 'xyz';
            }
            $file = public_path() . '/images/settings/' . $make['logo'];
            if (!empty($make['logo']) && file_exists($file)) {
                $topTrending[$i]['makeImage'] = getImageUrl($make['logo'], 'settings');
            } else {
                $topTrending[$i]['makeImage'] = getImageUrl('parts.png', 'partss');
            }
//            if (Modelyear::where('part_id', $topTrending[$i]['id'])->exists()) {
//                $topTrending[$i]['model'] = Modelyear::where('part_id', $topTrending[$i]['id'])->get();
//                for ($k = 0; $k < count($topTrending[$i]['model']); $k++) {
//                    $topTrending[$i]['model'][$k]['model'] = Mod_el::where('id', $topTrending[$i]['model'][$k]['model_id'])->first()['model_name'];
//                }
//            } else {
//                $topTrending[$i]['model'] = [];
//            }
            if (PartImage::where('part_id', $topTrending[$i]['id'])->exists()) {
                $topTrending[$i]['image'] = PartImage::where('part_id', $topTrending[$i]['id'])->first()['image'];
//                for ($l = 0; $l < count($topTrending[$i]['images']); $l++) {
                $file = public_path() . '/images/parts/' . $topTrending[$i]['image'];
                if (!empty($topTrending[$i]['image']) && file_exists($file)) {
                    $topTrending[$i]['image'] = getImageUrl($topTrending[$i]['image'], 'parts');
                } else {
                    $topTrending[$i]['image'] = getImageUrl('parts.png', 'partss');
                }
//                }

            }
        }
        $data =
            [
                'latestAddedParts' => $latestAdded,
                'topTrending' => $topTrending
            ];
        return $this->sendResponse(1, 'success', $data);
    }

    public function signUpSettings()
    {
        $latestAdded = PartDetails::where('is_delete','0')->latest()->take(5)->get();
        for ($i = 0; $i < count($latestAdded); $i++) {
            $manufacturer = Manufacture::where('id', $latestAdded[$i]->manufacturer)->first();
            $latestAdded[$i]['manufactureName'] = $manufacturer->manufacture;
            $latestAdded[$i]['manufactureImage'] = getImageUrl($manufacturer->image, 'manufacture');
            $category = ProductCategory::where('id', $latestAdded[$i]['cat_id'])->first();
            $latestAdded[$i]['category'] = $category['category'];
            if (empty($category['image'])) {
                $category['image'] = 'xyz';
            }
            $file = public_path() . '/images/settings/' . $category['image'];
            if (!empty($category['image']) && file_exists($file)) {
                $latestAdded[$i]['categoryImage'] = getImageUrl($category['image'], 'settings');
            } else {
                $latestAdded[$i]['categoryImage'] = getImageUrl('parts.png', 'partss');
            }
            $makeID = PartMake::where('part_id',$latestAdded[$i]['id'])->select('make_id')->first();
            if($makeID != null) {
                $make = Make::where('id', $makeID->make_id)->select('make','logo')->first();
                // $make = Make::where('id', $latestAdded[$i]['make_id'])->first();
                $latestAdded[$i]['make'] = $make->make;
                if (empty($make['logo'])) {
                    $make['logo'] = 'xyz';
                }
                $file = public_path() . '/images/settings/' . $make['logo'];
                if (!empty($make['logo']) && file_exists($file)) {
                    $latestAdded[$i]['makeImage'] = getImageUrl($make['logo'], 'settings');
                } else {
                    $latestAdded[$i]['makeImage'] = getImageUrl('parts.png', 'partss');
                }
            }
//            if (Modelyear::where('part_id', $latestAdded[$i]['id'])->exists()) {
//                $latestAdded[$i]['model'] = Modelyear::where('part_id', $latestAdded[$i]['id'])->get();
//                for ($k = 0; $k < count($latestAdded[$i]['model']); $k++) {
//                    $latestAdded[$i]['model'][$k]['model'] = Mod_el::where('id', $latestAdded[$i]['model'][$k]['model_id'])->first()['model_name'];
//                }
//            } else {
//                $latestAdded[$i]['model'] = [];
//            }
            if (PartImage::where('part_id', $latestAdded[$i]['id'])->exists()) {
                $latestAdded[$i]['image'] = PartImage::where('part_id', $latestAdded[$i]['id'])->first()['image'];
//                for ($l = 0; $l < count($latestAdded[$i]['images']); $l++) {
                $file = public_path() . '/images/parts/' . $latestAdded[$i]['image'];
                if (!empty($latestAdded[$i]['image']) && file_exists($file)) {
                    $latestAdded[$i]['image'] = getImageUrl($latestAdded[$i]['image'], 'parts');
                } else {
                    $latestAdded[$i]['image'] = getImageUrl('parts.png', 'partss');
                }
//                }

            } else {
                $latestAdded[$i]['image'] = '';
            }
        }
        $orderItem = Orderitem::groupBy('part_id')->havingRaw('COUNT(*) >= 5')->pluck('part_id');
        $topTrending = PartDetails::whereIn('id', $orderItem)->where('is_delete', '0')->get();
        for ($i = 0; $i < count($topTrending); $i++) {
            $manufacturer = Manufacture::where('id', $topTrending[$i]->manufacturer)->first();
            $topTrending[$i]['manufactureName'] = $manufacturer->manufacture;
            $topTrending[$i]['manufactureImage'] = getImageUrl($manufacturer->image, 'manufacture');
            $category = ProductCategory::where('id', $topTrending[$i]['cat_id'])->first();
            $topTrending[$i]['category'] = $category['category'];
            if (empty($category['image'])) {
                $category['image'] = 'xyz';
            }
            $file = public_path() . '/images/settings/' . $category['image'];
            if (!empty($category['image']) && file_exists($file)) {
                $topTrending[$i]['categoryImage'] = getImageUrl($category['image'], 'settings');
            } else {
                $topTrending[$i]['categoryImage'] = getImageUrl('parts.png', 'partss');
            }
            $makeID = PartMake::where('part_id',$topTrending[$i]['id'])->first()['make_id'];
            $make = Make::where('id', $makeID)->select('make','logo')->first();
            $topTrending[$i]['make'] = $make['make'];
            if (empty($make['logo'])) {
                $make['logo'] = 'xyz';
            }
            $file = public_path() . '/images/settings/' . $make['logo'];
            if (!empty($make['logo']) && file_exists($file)) {
                $topTrending[$i]['makeImage'] = getImageUrl($make['logo'], 'settings');
            } else {
                $topTrending[$i]['makeImage'] = getImageUrl('parts.png', 'partss');
            }
//            if (Modelyear::where('part_id', $topTrending[$i]['id'])->exists()) {
//                $topTrending[$i]['model'] = Modelyear::where('part_id', $topTrending[$i]['id'])->get();
//                for ($k = 0; $k < count($topTrending[$i]['model']); $k++) {
//                    $topTrending[$i]['model'][$k]['model'] = Mod_el::where('id', $topTrending[$i]['model'][$k]['model_id'])->first()['model_name'];
//                }
//            } else {
//                $topTrending[$i]['model'] = [];
//            }
            if (PartImage::where('part_id', $topTrending[$i]['id'])->exists()) {
                $topTrending[$i]['image'] = PartImage::where('part_id', $topTrending[$i]['id'])->first()['image'];
//                for ($l = 0; $l < count($topTrending[$i]['images']); $l++) {
                $file = public_path() . '/images/parts/' . $topTrending[$i]['image'];
                if (!empty($topTrending[$i]['image']) && file_exists($file)) {
                    $topTrending[$i]['image'] = getImageUrl($topTrending[$i]['image'], 'parts');
                } else {
                    $topTrending[$i]['image'] = getImageUrl('parts.png', 'partss');
                }
//                }

            }
        }
        $fromYear = Configuration::where('key', 'from_year')->first();
        $gst = Configuration::where('key', 'gst')->first();
        $make = Make::where('is_delete', 0)->get();
        $category = ProductCategory::where('is_deleted', 'N')->get();
        $data = ['year' => $fromYear->value, 'latestAddedParts' => $latestAdded,
            'topTrending' => $topTrending, 'make' => $make, 'category' => $category, 'gst' => $gst->value];
        return $this->sendResponse(1, 'success', $data);
    }
    function partDetail(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'ref_number' => 'required',
        ]);
        if (!PartDetails::where('ref_no', 'LIKE','%'.$req->ref_number.'%')->where('is_active',1)->where('is_delete',0)->exists()) {
           return $this->sendError(0, 'Reference number not exist');
}

        if ($validator->fails()) {
            return $this->sendError(0, $validator->errors()->first());
        }
        $PartsCategoryIDs = PartDetails::where('ref_no', 'LIKE',$req->ref_number)->where('is_active',1)->where('is_delete',0)->pluck("cat_id");
        $Categories = ProductCategory::whereIn('id', $PartsCategoryIDs)->where('is_deleted',"N")->pluck('id');
        $displayParts = PartDetails::where('ref_no', 'LIKE',$req->ref_number)->where('is_active',1)->where('is_delete',0)->whereIn("cat_id",$Categories)->first();
//        $displayParts = PartDetails::where('ref_no', $req->ref_number)->where('is_active',1)->where('is_delete',0)->first();
        if($displayParts) {
            $file = public_path() . '/images/settings/' . $displayParts['image'];
            if (!empty($displayParts['image']) && file_exists($file)) {
                $displayParts['image'] = getImageUrl($displayParts['image'], 'settings');
            } else {
                $displayParts['image'] = getImageUrl('parts.png', 'partss');
            }
            $category = ProductCategory::where('id', $displayParts['cat_id'])->first();
            $manufacturer = Manufacture::where('id', $displayParts->manufacturer)->first();
            if ($manufacturer) {
                $displayParts['manufactureName'] = $manufacturer->manufacture;
            }
            if ($manufacturer && $manufacturer->image) {

                $displayParts['manufactureImage'] = getImageUrl($manufacturer->image, 'manufacture');
            } else {
                $displayParts['manufactureImage'] = getImageUrl('manufacture.png', 'default-images');
            }

            $munufactureDiscount = DB::table("manufacture_discount")->where('users_id',Auth::user()->id)->where('manufacturer_id',$displayParts->manufacturer)->first();
            if($munufactureDiscount ){
                $displayParts['manufactureDiscount'] = isset($munufactureDiscount->discount) ? $munufactureDiscount->discount : 0;
            }else{
                $displayParts['manufactureDiscount'] = 0;
            }
            $displayParts['category'] = $category['category'];
            if (empty($category['image'])) {
                $category['image'] = 'xyz';
            }
            $file = public_path() . '/images/settings/' . $category['image'];
            if (!empty($category['image']) && file_exists($file)) {
                $displayParts['categoryImage'] = getImageUrl($category['image'], 'settings');
            } else {
                $displayParts['categoryImage'] = getImageUrl('parts.png', 'partss');
            }
//            $make = Make::where('id', $displayParts['make_id'])->first();
            $makeID = PartMake::where('part_id',$displayParts->id)->first()['make_id'];
            $make = Make::where('id', $makeID)->select('make','logo')->first();
            $displayParts['make'] = $make['make'];
            if (empty($make['logo'])) {
                $make['logo'] = 'xyz';
            }
            $file = public_path() . '/images/settings/' . $make['logo'];
            if (!empty($make['logo']) && file_exists($file)) {
                $displayParts['makeImage'] = getImageUrl($make['logo'], 'settings');
            } else {
                $displayParts['makeImage'] = getImageUrl('parts.png', 'partss');
            }
            $displayParts['model'] = DB::table('part_years')->join('model','part_years.model_id','=','model.id')->where('part_years.part_id','=',$displayParts['id'])->where('model.is_active','=','1')->where('is_delete','=','0')->select('part_years.*')->groupBy('part_years.model_id')->get();
            if (Modelyear::where('part_id', $displayParts['id'])->exists()) {
                // $displayParts['model'] = Modelyear::where('part_id', $displayParts['id'])->get();
                for ($k = 0; $k < count($displayParts['model']); $k++) {
                    // if(Mod_el::where('id', $displayParts['model'][$k]['model_id'])->where('is_delete','0')->where('is_active','1')->exists()){
                        $displayParts['model'][$k]->model= Mod_el::where('id', $displayParts['model'][$k]->model_id)->where('is_delete',0)->where('is_active',1)->first()['model_name'];
                        $getMake = Mod_el::where('id', $displayParts['model'][$k]->model_id)->first()['make_id'];
                        $makeImage = Make::where('id',$getMake)->first()['logo'];
                        $file = public_path() . '/images/settings/' . $makeImage;
                        $displayParts['model'][$k]->make_image = getImageUrl($makeImage, 'settings');
                }
            } else {
                $displayParts['model'] = [];
            }
            if (PartImage::where('part_id', $displayParts['id'])->exists()) {
                $displayParts['images'] = PartImage::where('part_id', $displayParts['id'])->get();
                for ($l = 0; $l < count($displayParts['images']); $l++) {
                    $file = public_path() . '/images/parts/' . $displayParts['images'][$l]['image'];
                    if (!empty($displayParts['images'][$l]['image']) && file_exists($file)) {
                        $displayParts['images'][$l]['image'] = getImageUrl($displayParts['images'][$l]['image'], 'parts');
                    } else {
                        $displayParts['images'][$l]['image'] = getImageUrl('parts.png', 'partss');
                    }
                }

            } else {
                $displayPart= getImageUrl('parts.png', 'partss');
                $display = ['image'=>$displayPart];
                $displayParts['images'] = array($display);
            }
            return $this->sendResponse(1, 'success', $displayParts);

        }
        else
        {
            $PartsCategoryIDs = PartDetails::where('ref_no', 'LIKE','%'.$req->ref_number.'%')->where('is_active',1)->where('is_delete',0)->pluck("cat_id");
            $Categories = ProductCategory::whereIn('id', $PartsCategoryIDs)->where('is_deleted',"N")->pluck('id');
            $displayParts12 = PartDetails::where('ref_no', 'LIKE','%'.$req->ref_number.'%')->where('is_active',1)->where('is_delete',0)->whereIn("cat_id",$Categories)->get();

//            return $displayPa;
            foreach ( $displayParts12 as $key => $displayParts) {
                $file = public_path() . '/images/settings/' . $displayParts['image'];
                if (!empty($displayParts['image']) && file_exists($file)) {
                    $displayParts['image'] = getImageUrl($displayParts['image'], 'settings');
                } else {
                    $displayParts['image'] = getImageUrl('parts.png', 'partss');
                }
                $category = ProductCategory::where('id', $displayParts['cat_id'])->first();
                $manufacturer = Manufacture::where('id', $displayParts->manufacturer)->first();
                if ($manufacturer) {
                    $displayParts['manufactureName'] = $manufacturer->manufacture;
                }
                if ($manufacturer && $displayParts['manufactureImage']) {
                    $displayParts['manufactureImage'] = getImageUrl($manufacturer->image, 'manufacture');
                } else {
                    $displayParts['manufactureImage'] = getImageUrl('manufacture.png', 'default-images');
                }
                $displayParts['category'] = $category['category'];
                if (empty($category['image'])) {
                    $category['image'] = 'xyz';
                }
                $file = public_path() . '/images/settings/' . $category['image'];
                if (!empty($category['image']) && file_exists($file)) {
                    $displayParts['categoryImage'] = getImageUrl($category['image'], 'settings');
                } else {
                    $displayParts['categoryImage'] = getImageUrl('parts.png', 'partss');
                }
                $makeID = PartMake::where('part_id',$displayParts['id'])->first()['make_id'];
                $make = Make::where('id', $makeID)->select('make','logo')->first();
                $displayParts['make'] = $make['make'];
                if (empty($make['logo'])) {
                    $make['logo'] = 'xyz';
                }
                $file = public_path() . '/images/settings/' . $make['logo'];
                if (!empty($make['logo']) && file_exists($file)) {
                    $displayParts['makeImage'] = getImageUrl($make['logo'], 'settings');
                } else {
                    $displayParts['makeImage'] = getImageUrl('parts.png', 'partss');
                }
                if (Modelyear::where('part_id', $displayParts['id'])->exists()) {
                    $displayParts['model'] = Modelyear::where('part_id', $displayParts['id'])->get();
                    for ($k = 0; $k < count($displayParts['model']); $k++) {
                        $displayParts['model'][$k]['model'] = Mod_el::where('id', $displayParts['model'][$k]['model_id'])->where('is_active',1)->where('is_delete',0)->first()['model_name'];
                        $getMake = Mod_el::where('id', $displayParts['model'][$k]['model_id'])->first()['make_id'];
                        $makeImage = Make::where('id',$getMake)->first()['logo'];
                        $file = public_path() . '/images/settings/' . $makeImage;
                        $displayParts['model'][$k]['make_image'] = getImageUrl($makeImage, 'settings');
                    }
                } else {
                    $displayParts['model'] = [];
                }
                if (PartImage::where('part_id', $displayParts['id'])->exists()) {
                    $displayParts['images'] = PartImage::where('part_id', $displayParts['id'])->get();
                    for ($l = 0; $l < count($displayParts['images']); $l++) {
                        $file = public_path() . '/images/parts/' . $displayParts['images'][$l]['image'];
                        if (!empty($displayParts['images'][$l]['image']) && file_exists($file)) {
                            $displayParts['images'][$l]['image'] = getImageUrl($displayParts['images'][$l]['image'], 'parts');
                        } else {
                            $displayParts['images'][$l]['image'] = getImageUrl('parts.png', 'partss');
                        }
                    }

                } else {
                    $displayPart= getImageUrl('parts.png', 'partss');
                    $display = ['image'=>$displayPart];
                    $displayParts['images'] = array($display);
                }
            }
            return $this->sendResponse(1, 'success', $displayParts12);

        }
//        }
    }
}
