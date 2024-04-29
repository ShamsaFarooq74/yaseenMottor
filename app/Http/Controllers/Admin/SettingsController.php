<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Models\Make;
use App\Http\Models\Mod_el;
use App\Http\Models\Parts;
use App\Http\Models\Feature;
use App\Http\Models\ProductCategory;
use App\Http\Models\Modelyear;
use App\Http\Models\PartYear;
use App\Http\Models\Order;
use App\Http\Models\Orderitem;
use App\Http\Models\FuelType;
use App\Http\Models\PartDetails;
use App\Http\Models\PartImage;
use App\Http\Models\Manufacture;
use App\Http\Models\Ads;
use App\Http\Models\Country;
use App\Http\Models\Shipment;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use File;
use Illuminate\Support\Facades\Storage;
class SettingsController extends Controller
{
    function replaceDuplicateModel(){
        $check=[];
        $GetDuplicateModel = Mod_el::groupBy('model_name')->having(DB::raw('count(*)'), ">", "1")->select('model_name','id')->get();
//return $GetDuplicateModel;
            foreach ($GetDuplicateModel as $key=> $duplicate){
//                return $duplicate;

            $models = Mod_el::where('model_name',$duplicate->model_name)->pluck('id');
//                return $models;
            for($i=0; $i <= count(array($models)); $i++){

                if($i == 0){

                    $values=array('model_id'=> $models[$i]);
                    PartYear::whereIn('model_id',$models)->update($values);

                }else{
                    array_push($check, $models[$i]);
                    $models = Mod_el::where('id',$models[$i])->delete();
                }

            }

        }

        return "Duplicate Model Deleted";
    }
    function replaceImageExtension(){


        $partsData = array();

        $parts = PartDetails::get();
        for ($i = 0; $i < count($parts); $i++) {
            $partImage = PartImage::where('part_id', $parts[$i]['id'])->first();

            if ($partImage) {
                $string = substr($partImage['image'],  -3);
                if($string == "JPG"){

                    $imageName = substr($partImage['image'],  0,-3);
                    $partImageName = $imageName."jpg";
                    $partImage->image = $partImageName;
                    $partImage->save();

//                    if (file_exists(public_path() . '/images/parts/' . $partImageName)) {
//
//                        $val = '/images/parts/' .$partImage['image'];
//                        $rval =  '/images/parts/' .$partImageName;
//                        Storage::move($rval, $val);
//                        return "moved";
//                    }
                }
            }
//            return "ooo";
        }
        return "Done ";
    }
    public function category($categoryId = '')
    {
         $countries = Country::where('is_delete', 'N')->where('is_active', 1)->get();
       
        $shipments = Shipment::where('is_delete', 'N')->where('is_active', 1)->orderBy('created_at', 'DESC')->get();
        // for ($i = 0; $i < count($category); $i++) {
        //     if (empty($category[$i]['image'])) {
        //         $category[$i]['image'] = 'xyz';
        //     }
        //     $file = public_path() . '/images/settings/' . $category[$i]['image'];
        //     if (!empty($category[$i]['image']) && file_exists($file)) {
        //         $category[$i]['image'] = getImageUrl($category[$i]['image'], 'settings');
        //     } else {
        //         $category[$i]['image'] = getImageUrl('parts.png', 'default-category');
        //     }
        // }
        return view('admin.settings.category', ['shipments' => $shipments, 'categoryId' => $categoryId , 'countries' => $countries]);
    }
    public function feature($featureId = '')
    {
        $feature = Feature::where('is_delete', 'N')->orderBy('created_at', 'DESC')->get();
        return view('admin.settings.feature', ['features' => $feature, 'featureId' => $featureId]);
    }
    public function fuel($fuelId = '')
    {
        $fuels = FuelType::where('is_delete', 'N')->orderBy('created_at', 'DESC')->get();
        return view('admin.settings.fuel-type', ['fuels' => $fuels, 'fuelId' => $fuelId]);
    }
    

    public function make($makeId = '')
    {
        $make = Make::where('is_delete', 'N')->orderBy('created_at', 'DESC')->get();
        for ($i = 0; $i < count($make); $i++) {
            if (empty($make[$i]['image'])) {
                $make[$i]['image'] = 'xyz';
            }
            $file = public_path() . '/images/settings/' . $make[$i]['logo'];
            if (!empty($make[$i]['logo']) && file_exists($file)) {
                $make[$i]['logo'] = getImageUrl($make[$i]['logo'], 'settings');
            } else {
                $make[$i]['logo'] = getImageUrl('parts.png', 'partss');
            }
        }
        return view('admin.settings.make', ['makes' => $make, 'makeId' => $makeId]);
    }

    public function addMake(Request $request, $makeId = '')
    {
        if (Auth::user()->role != '1') {

            return redirect('/home');
        }
        if ($makeId) {
            $validator = Validator::make($request->all(), [

                'make' => 'required|string',
                'status' => 'required|string',

            ]);

            if ($validator->fails()) {

                return redirect()->back()->with('error', $validator->errors()->first());
            }
            $make = Make::where('id', $makeId)->first();
            $make->make = $request->make;
            $make->is_active = $request->status;
            if ($request->file('make_image')) {
                $file = $request->file('make_image');
                $makeImage = date("dmyHis.") . gettimeofday()["usec"] . '_' . $file->getClientOriginalName();
                $file->move(public_path() . '/images/settings/', $makeImage);
                $make->logo = $makeImage;
            }
            $make->update();
            if ($make) {

                return redirect()->back()->with('success', 'Make updated successfully');
            } else {

                Session::flash('error', 'Sorry! Make not updated');

                Session::flash('alert-class', 'alert-danger');

                return redirect()->back()->with('error', 'Sorry! Make not updated');
            }
        } else {
            $validator = Validator::make($request->all(), [

                'make' => 'required|string',
                'status' => 'required|string',

            ]);


            if ($validator->fails()) {

                return redirect()->back()->with('error', $validator->errors()->first());
            }
            $checkIfDeleted = Make::where('make', $request->make)->first();
            if($checkIfDeleted !="" && $checkIfDeleted->is_delete == 1){
                $checkIfDeleted->is_delete = 'N';
                $checkIfDeleted->update();
                return redirect()->back()->with('success', 'Make added successfully');
            }
           if($checkIfDeleted !="" && $checkIfDeleted->is_delete == 'N'){
            return redirect()->back()->with('error', 'Make Name is Already Taken!');
           }
           $getModel =  Mod_el::where('make_id', $request->make_id)->where('model_name',$request->model_name)->first();
           if($getModel !=""){

            return redirect()->back()->with('error', 'Model Name is Already Taken!');
           }

            $make = new Make();
            $make->make = $request->make;
            $make->is_active = $request->status;
            if ($request->file('make_image')) {
                $file = $request->file('make_image');
                $makeImage = date("dmyHis.") . gettimeofday()["usec"] . '_' . $file->getClientOriginalName();
                $file->move(public_path() . '/images/settings/', $makeImage);
                $make->logo = $makeImage;
            }
            $make->save();
            if ($make) {

                return redirect()->back()->with('success', 'Make added successfully');
            } else {

                Session::flash('error', 'Sorry! Make not added');

                Session::flash('alert-class', 'alert-danger');

                return redirect()->back()->with('error', 'Sorry! Make not added');
            }
        }
    }
    public function addfeature(Request $request, $featureId = '')
    { 
        // dd($featureId);
        if (Auth::user()->role != '1') {

            return redirect('/home');
        }
        if ($featureId) {
            $validator = Validator::make($request->all(), [
                'feature' => 'required|string',
                'status' => 'required|string',

            ]);

            if ($validator->fails()) {

                return redirect()->back()->with('error', $validator->errors()->first());
            }
            $feature = Feature::where('id', $featureId)->first();

            $feature->feature = $request->feature;
            $feature->is_active = $request->status;
         
            $feature->update();
            if ($feature) {

                return redirect()->back()->with('success', 'Feature updated successfully');
            } else {

                Session::flash('error', 'Sorry! Feature not updated');

                Session::flash('alert-class', 'alert-danger');

                return redirect()->back()->with('error', 'Sorry! Feature not updated');
            }
        } else {
            $validator = Validator::make($request->all(), [

                'feature' => 'required|string',
                'status' => 'required|string',

            ]);


            if ($validator->fails()) {

                return redirect()->back()->with('error', $validator->errors()->first());
            }
            $checkIfDeleted = Feature::where('feature', $request->feature)->first();
            if($checkIfDeleted !="" && $checkIfDeleted->is_delete == 1){
                $checkIfDeleted->is_delete = 'N';
                $checkIfDeleted->update();
                return redirect()->back()->with('success', 'Feature added successfully');
            }
           if($checkIfDeleted !="" && $checkIfDeleted->is_delete == 'N'){
            return redirect()->back()->with('error', 'Feature is Already Taken!');
           }
          
            $feature = new Feature();
            $feature->feature = $request->feature;
            $feature->is_active = $request->status;
           
            $feature->save();
            if ($feature) {

                return redirect()->back()->with('success', 'Feature added successfully');
            } else {

                Session::flash('error', 'Sorry! Feature not added');

                Session::flash('alert-class', 'alert-danger');

                return redirect()->back()->with('error', 'Sorry! Feature not added');
            }
        }
    }
    public function addfuel(Request $request, $fuelId = '')
    { 
      
        if (Auth::user()->role != '1') {

            return redirect('/home');
        }
        if ($fuelId) {
            $validator = Validator::make($request->all(), [
               'fuel' => 'required|string',
                'status' => 'required|string',

            ]);

            if ($validator->fails()) {

                return redirect()->back()->with('error', $validator->errors()->first());
            }
            $fuel = FuelType::where('id', $fuelId)->first();

            $fuel->fuel_type = $request->fuel;
            $fuel->is_active = $request->status;
         
            $fuel->update();
            if ($fuel) {

                return redirect()->back()->with('success', 'Fuel updated successfully');
            } else {

                Session::flash('error', 'Sorry! Fuel not updated');

                Session::flash('alert-class', 'alert-danger');

                return redirect()->back()->with('error', 'Sorry! Fuel not updated');
            }
        } else {
            $validator = Validator::make($request->all(), [

                'fuel' => 'required|string',
                'status' => 'required|string',

            ]);


            if ($validator->fails()) {

                return redirect()->back()->with('error', $validator->errors()->first());
            }
            $checkIfDeleted = FuelType::where('fuel_type', $request->fuelType)->first();
            if($checkIfDeleted !="" && $checkIfDeleted->is_delete == 1){
                $checkIfDeleted->is_delete = 'N';
                $checkIfDeleted->update();
                return redirect()->back()->with('success', 'Fuel added successfully');
            }
           if($checkIfDeleted !="" && $checkIfDeleted->is_delete == 'N'){
            return redirect()->back()->with('error', 'Fuel is Already Taken!');
           }
          
            $fuel = new FuelType();
              $fuel->fuel_type = $request->fuel;
            $fuel->is_active = $request->status;
           
            $fuel->save();
            if ($fuel) {

                return redirect()->back()->with('success', 'Fuel added successfully');
            } else {

                Session::flash('error', 'Sorry! Fuel not added');

                Session::flash('alert-class', 'alert-danger');

                return redirect()->back()->with('error', 'Sorry! Fuel not added');
            }
        }
    }

    public function settings($modelId = '')
    {
        $make = Make::where('is_delete', 'N')->where('is_active', '1')->get();
        // $model = Mod_el::where('is_delete', 'N')->orderBy('created_at', 'DESC')->get();
        $model = Mod_el::whereHas('make', function ($query) {
        $query->where('is_delete', 'N')->where('is_active', '1');})->where('is_delete', 'N')->orderBy('created_at', 'DESC')->get();
        for ($i = 0; $i < count($model); $i++) {
            $model[$i]['make'] = Make::where('id', $model[$i]['make_id'])->first()['make'];
            if (empty($model[$i]['image'])) {
                $model[$i]['image'] = 'xyz';
            }
            $file = public_path() . '/images/settings/' . $model[$i]['image'];
            if (!empty($model[$i]['image']) && file_exists($file)) {
                $model[$i]['image'] = getImageUrl($model[$i]['image'], 'settings');
            } else {
                $model[$i]['image'] = getImageUrl('parts.png', 'partss');
            }
        }
        return view('admin.settings.settings', ['make' => $make, 'modelId' => $modelId, 'model' => $model]);
    }

    function searchModel(Request $request)
    {


        $model = Mod_el::where('model_name', 'like', '%' . $request->value . '%')->where('is_delete', '0')->where('is_active', '1')->get();
        for ($i = 0; $i < count($model); $i++) {
            $model[$i]['make'] = Make::where('id', $model[$i]['make_id'])->first()['make'];
            if (empty($model[$i]['image'])) {
                $model[$i]['image'] = 'xyz';
            }
            $file = public_path() . '/images/settings/' . $model[$i]['image'];
            if (!empty($model[$i]['image']) && file_exists($file)) {
                $model[$i]['image'] = getImageUrl($model[$i]['image'], 'settings');
            } else {
                $model[$i]['image'] = getImageUrl('parts.png', 'partss');
            }
        }
        return ['data' => $model];
    }

    public function deleteMake(Request $request)
    {
        if (Auth::user()->role != '1') {

            return redirect('/home');
        }

        $subCategory = Make::where('id', $request->id)->first();
        $subCategory->is_delete = 'Y';
        $subCategory->update();
        $deleteModels = Mod_el::where('make_id',$request->id)->update(['is_delete'=>'Y','is_active'=>0]);

        if ($subCategory) {

            return ['status' => true];
        } else {

            return ['status' => false];
        }
    }

    public function deleteFeature(Request $request)
    {
        if (Auth::user()->role != '1') {

            return redirect('/home');
        }

       $feature = Feature::where('id', $request->id)->first();
        $feature->is_delete = 'Y';
        $feature->update();

        if ($feature) {

            return ['status' => true];
        } else {

            return ['status' => false];
        }
    }
    public function deleteFuel(Request $request)
    {
        if (Auth::user()->role != '1') {

            return redirect('/home');
        }

       $fuel = FuelType::where('id', $request->id)->first();
        $fuel->is_delete = 'Y';
        $fuel->update();

        if ($fuel) {

            return ['status' => true];
        } else {

            return ['status' => false];
        }
    }

    public function addSettings(Request $request, $modelId = '')
    {
        if (Auth::user()->role != '1') {

            return redirect('/home');
        }

        if ($modelId) {
            $validator = Validator::make($request->all(), [

                'make_id' => 'required',
                'model_name' => 'required|string',
                'model_code' => 'required',
                'status' => 'required|string',

            ]);

            if ($validator->fails()) {

                return redirect()->back()->with('error', $validator->errors()->first());
            }
            $model = Mod_el::where('id', $modelId)->first();
            $model->make_id = $request->make_id;
            $model->model_name = $request->model_name;
            $model->model_code = $request->model_code;
            $model->is_active = $request->status;
            if ($request->file('model_image')) {
                $file = $request->file('model_image');
                $makeImage = date("dmyHis.") . gettimeofday()["usec"] . '_' . $file->getClientOriginalName();
                $file->move(public_path() . '/images/settings/', $makeImage);
                $model->image = $makeImage;
            }
            $model->update();
            if ($model) {

                return redirect()->back()->with('success', 'Model updated successfully');
            } else {

                Session::flash('error', 'Sorry! Model not updated');

                Session::flash('alert-class', 'alert-danger');

                return redirect()->back()->with('error', 'Sorry! Model not updated');
            }
        } else {
            $validator = Validator::make($request->all(), [

                'make_id' => 'required',
                'model_name' => 'required|string',
                 'model_code' => 'required',
                'status' => 'required|string',

            ]);

            if ($validator->fails()) {

                return redirect()->back()->with('error', $validator->errors()->first());
            }
            $getModel =  Mod_el::where('make_id', $request->make_id)->where('model_name',$request->model_name)->first();
            if($getModel !=""){

                return redirect()->back()->with('error', 'Model Name is Already Taken!');
            }

            $model = new Mod_el();
            $model->make_id = $request->make_id;
            $model->model_name = $request->model_name;
            $model->model_code = $request->model_code;
            $model->is_active = $request->status;
            if ($request->file('model_image')) {
                $file = $request->file('model_image');
                $makeImage = date("dmyHis.") . gettimeofday()["usec"] . '_' . $file->getClientOriginalName();
                $file->move(public_path() . '/images/settings/', $makeImage);
                $model->image = $makeImage;
            }
            $model->save();
            if ($model) {

                return redirect()->back()->with('success', 'Model added successfully');
            } else {

                Session::flash('error', 'Sorry! Model not added');

                Session::flash('alert-class', 'alert-danger');

                return redirect()->back()->with('error', 'Sorry! Model not added');
            }
        }
    }

    public function deleteModel(Request $request)
    {
        if (Auth::user()->role != '1') {

            return redirect('/home');
        }

        $model = Mod_el::where('id', $request->id)->first();
        $model->is_delete = 'Y';
        $model->update();

        if ($model) {

            return ['status' => true];
        } else {

            return ['status' => false];
        }
    }
    public function deleterecord()
    {
        if (Auth::user()->role != '1') {

            return redirect('/home');
        }
        Make::select('*')->delete();
        Mod_el::select('*')->delete();
        Parts::select('*')->delete();
        Order::select('*')->delete();
        Orderitem::select('*')->delete();
        PartImage::select('*')->delete();
        Modelyear::select('*')->delete();
        ProductCategory::select('*')->delete();
        Ads::select('*')->delete();
        return ['status' => true];
    }

    public function addCategory(Request $request, $shipmentId = '')
    {
        if (Auth::user()->role != '1') {

            return redirect('/home');
        }

        if ($shipmentId) {
            $validator = Validator::make($request->all(), [

                // 'category' => 'required|string',
                'country' => 'required',
                'portname' => 'required',
                'price' => 'required',
                'insurance' =>  ['nullable'],
                'warranty' =>  ['nullable'],
                'roro' =>  ['nullable'],
                'portcontainer' =>  ['nullable'],
                'insurance-price' =>  ['nullable'],
                'warranty-price'=>  ['nullable'],
            ]);
            

            if ($validator->fails()) {

                return redirect()->back()->with('error', $validator->errors()->first());
            }
            $shipment = Shipment::where('id', $shipmentId)->first();
            $shipment->country_id = $request->country;
            $shipment->portname = $request->portname;
            $shipment->price = $request->price;
            $shipment->insurance_price = $request->insurancePrice;
            $shipment->warranty_price = $request->warrantyPrice;
            $shipment->insurance = $request->insurance == TRUE ? '1' : '0';
            $shipment->warranty = $request->warranty == TRUE ? '1' : '0';
            $shipment->roro = $request->roro == TRUE ? '1' : '0';
            $shipment->portcontainer = $request->portcontainer == TRUE ? '1' : '0';
           
    
            $shipment->update();
            if ($shipment) {

                return redirect()->back()->with('success', 'Shipment updated successfully');
            } else {

                Session::flash('error', 'Sorry! Shipment not updated');

                Session::flash('alert-class', 'alert-danger');

                return redirect()->back()->with('error', 'Sorry! Shipment not updated');
            }
        } else {
            $validator = Validator::make($request->all(), [
            
                // 'category' => 'required|unique:product_categories',
                'country' => 'required',
                'portname' => 'required',
                'price' => 'required',
                'insurance' =>  ['nullable'],
                'warranty' =>  ['nullable'],
                'roro' =>  ['nullable'],
                'portcontainer' =>  ['nullable'],
                'insurance-price' =>  ['nullable'],
                'warranty-price'=>  ['nullable'],

            ]);


            if ($validator->fails()) {

                return redirect()->back()->with('error', $validator->errors()->first());
            }
        //   dd($request);
            $shipment = new Shipment();
            $shipment->country_id = $request->country;
            $shipment->portname = $request->portname;
            $shipment->price = $request->price;
            $shipment->insurance_price = $request->insurancePrice;
            $shipment->warranty_price = $request->warrantyPrice;
            $shipment->insurance = $request->insurance == TRUE ? '1' : '0';
            $shipment->warranty = $request->warranty == TRUE ? '1' : '0';
            $shipment->roro = $request->roro == TRUE ? '1' : '0';
            $shipment->portcontainer = $request->portcontainer == TRUE ? '1' : '0';
       
            $shipment->save();
            if ($shipment) {

                return redirect()->back()->with('success', 'Shipment added successfully');
            } else {

                Session::flash('error', 'Sorry! Shipment not added');

                Session::flash('alert-class', 'alert-danger');

                return redirect()->back()->with('error', 'Sorry! Shipment not added');
            }
        }
    }

}