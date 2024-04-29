<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Api\ResponseController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Controller;
use App\Http\Models\Category;
use App\Http\Models\CompanyUser;
use App\Http\Models\Country;
use App\Http\Models\FuelType;
use App\Http\Models\City;
use App\Http\Models\Videolink;
use App\Http\Models\Configuration;
use App\Http\Models\PartMake;
use App\Http\Models\PartBodyType;
use App\Http\Models\Currency;
use App\Http\Models\Feature;
use App\Http\Models\PartFeature;
use App\Http\Models\Make;
use App\Http\Models\PartCSVRecord;
use App\Http\Models\TrendingParts;
use App\Http\Models\PartYear;
use App\Http\Models\Manufacture;
use App\Http\Models\Mod_el;
use App\Http\Models\Modelyear;
use App\Http\Models\Notification;
use App\Http\Models\Order;
use App\Http\Models\PartDetails;
use App\Http\Models\PartImage;
use App\Http\Models\Parts;
use App\Http\Models\ProductCategory;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PartController extends ResponseController
{
    public function __construct()
    {
        date_default_timezone_set("Asia/Karachi");

    }
  public function deleteImage($id){
     $image = PartImage::find($id);
    if ($image) {
    $image->delete();
    $imagePath = public_path('images/parts/' . $image->image);
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }
      return response()->json(['message' => 'Image deleted successfully']);
   } else {
    return response()->json(['message' => 'Image not found'], 404);
    }

}
    public function partDetails(Request $request)
    {
        $partsInfo = PartDetails::where('is_delete', 'N')->where('id', $request->partId)->first();
//        for ($i = 0; $i < count($partsInfo); $i++) {
        $manufacturer = Manufacture::where('id', $partsInfo->manufacturer)->first();
        if ($manufacturer) {
            $partsInfo['manufactureName'] = $manufacturer->manufacture;
            $partsInfo['manufactureImage'] = getImageUrl($manufacturer->image, 'manufacture');
        }
    
        $makedata = PartDetails::with('make')->where('is_delete', 'N')->where('is_active', 1)->where('id', $request->partId)->first();
        $modeldata = PartDetails::with('model')->where('is_delete', 'N')->where('is_active', 1)->where('id', $request->partId)->first();
      
        // $category = ProductCategory::where('id', $partsInfo['cat_id'])->first();
        // $partsInfo['category'] = $category['category'];
        // if (empty($category['image'])) {
        //     $category['image'] = 'xyz';
        // }
        // $file = public_path() . '/images/settings/' . $category['image'];
        // if (!empty($category['image']) && file_exists($file)) {
        //     $partsInfo['categoryImage'] = getImageUrl($category['image'], 'settings');
        // } else {
        //     $partsInfo['categoryImage'] = getImageUrl('parts.png', 'partss');
        // }
        $makeID = PartMake::where('part_id',$request->partId)->pluck('make_id');
        if($makeID){
        $make = Make::whereIn('id', $makeID)->select('make','logo')->get();
        $makeNames = array();
        foreach($make as $makes){
            $makes['make'] = $makes->make;
            if (empty($makes['logo'])) {
                $makes['logo'] = 'xyz';
            }
            $file = public_path() . '/images/settings/' . $makes['logo'];
            if (!empty($makes['logo']) && file_exists($file)) {
                $makes['logo'] = getImageUrl($makes['logo'], 'settings');
            } else {
                $makes['logo'] = getImageUrl('parts.png', 'partss');
            }
            array_push($makeNames,$makes);
        }
        $partsInfo['make'] = $makeNames;
    }else{
        $partsInfo['make'] = [];
    }
        if (Modelyear::where('part_id', $partsInfo['id'])->exists()) {
            $partsInfo['model'] = Modelyear::where('part_id', $partsInfo['id'])->get();
            for ($k = 0; $k < count($partsInfo['model']); $k++) {
                if(Mod_el::where('id', $partsInfo['model'][$k]['model_id'])->where('is_delete','N')->where('is_active','1')->exists()){
                    $partsInfo['model'][$k]['model'] = Mod_el::where('id', $partsInfo['model'][$k]['model_id'])->first()['model_name'];
                } else{
                    $partsInfo['model'][$k]['model'] = "";
                }
            }
        } else {
            $partsInfo['model'] = [];
        }
        if (PartImage::where('part_id', $partsInfo['id'])->exists()) {
            $partsInfo['images'] = PartImage::where('part_id', $partsInfo['id'])->get();
            for ($l = 0; $l < count($partsInfo['images']); $l++) {
                $file = public_path() . '/images/parts/' . $partsInfo['images'][$l]['image'];
                if (!empty($partsInfo['images'][$l]['image']) && file_exists($file)) {
                    $partsInfo['images'][$l]['image'] = getImageUrl($partsInfo['images'][$l]['image'], 'parts');
                } else {
                    $partsInfo['images'][$l]['image'] = getImageUrl('parts.png', 'partss');
                }
            }

        } else {
            $partsInfo['images'] = [];
        }
//        }
//        return $partsInfo;
// if($modeldata){
//     dd($modeldata->model->model_name);
// }  

        $data =
            [
                'partId' => $request->partId,
                'partData' => $partsInfo,
                'makedata' => $makedata,
                'modeldata' =>$modeldata,
            ];
            // return $data;
        return view('admin.part.details', $data);
    }

    public function addParts(Request $request, $partId = '')
    {
        $currency = Currency::all();
        $make = Make::where('is_delete', 'N')->where('is_active', 1)->get();
        $countries = Country::where('is_delete', 'N')->where('is_active', 1)->get();
        $bodyTypes = PartBodyType::where('is_delete', 'N')->where('is_active', 1)->get();
        $cities = City::where('is_delete', 'N')->where('is_active', 1)->get();
        $model = Mod_el::where('is_delete', 'N')->where('is_active', 1)->get();
        $feature = Feature::where('is_delete', 'N')->where('is_active', 1)->get();
        $fuelTypes = FuelType::where('is_delete', 'N')->where('is_active', 1)->get();
        return view('admin.client.add-parts', ['fuelTypes'=> $fuelTypes,'bodyTypes'=> $bodyTypes,'features'=> $feature,'partId' => $request->partId, 'cities'=> $cities, 'currency' => $currency, 'countries'=> $countries, 'make' => $make,  'model' => $model]);
    }

    public function makeModel(Request $request)
    {
        $makeCount = $request->makeId;
        $getModels = Mod_el::whereIn('make_id', $makeCount)->where('is_delete', 'N')->where('is_active', 1)->get();
        return response()->json(["status" => true, "data" => $getModels]);
    }

    public function addPart(Request $request, $partId = '')
    { 
            $partArrayData = json_decode($request->videoData, true);
            $validator = Validator::make($request->all(), [
                'features'=>'required',
                'ref_no' => 'required',
                'reg_no' => 'required',
                'manufacturer'=>'required',
                'engine_size'=>'required',
                'sub_ref_no'=>'required',
                'modelcode'=>'required',
                'country'=>'required',
                'location'=>'required',
                'body_type_id'=>'required',
                'transmission'=>'required',
                'steering'=>'required',
                'engine'=>'required',
                'color'=>'required',
                'chasis'=>'required',
                'version'=>'required',
                'pM3'=>'required',
                'dimension'=>'required',
                'fuel'=>'required',
                'weight'=>'required',
                'mileage'=>'required',
                'loadcap'=>'required',
                'seats'=>'required',
                'doors'=>'required',
                'drive'=>'required',
                'make'=>'required',
                'currency' => 'required',
                'price' => 'required',
                // 'description' => 'required',
                'status' => 'required',
                'isStock' => ['nullable'],
                'priceoff' => ['nullable'],
            ]);
          
            if ($validator->fails()) {
                return ['status' => false, 'message' => $validator->errors()->first()];
            } elseif (empty($request->file('files')) && $partId == null) {
                return ['status' => false, 'message' => 'Car images can not be empty'];
            }elseif (empty($partArrayData)) {
                return ['status' => false, 'message' => 'Videolink data cannot be empty'];
            }
        $partId = $request->partId;     
        $monthYear = $request->reg_no; 
       list($month, $year) = explode('-', $monthYear);
       $regNo = Carbon::createFromDate($year, $month, 1);
       $regNoformate = $regNo->format('Y-m-d'); 
        $monthYears = $request->manufacturer; 
       list($month, $year) = explode('-', $monthYears);
       $manufacturerDate = Carbon::createFromDate($year, $month, 1);
       $manufacturerformate = $manufacturerDate->format('Y-m-d'); 

        if ($partId == null) {
            $partfeatures =$request->features;
            $partfeatures = array_map('intval', explode(',', $partfeatures));

             $parts = new PartDetails();
             $parts->ref_no = $request->ref_no;
             $parts->reg_no = $regNoformate;
             $parts->make_id = $request->make;
             $parts->model_id= $request->modelcode;
             $parts->engine_size= $request->engine_size;
             $parts->sub_ref_no= $request->sub_ref_no;
             $parts->manufacturer= $manufacturerformate;
             $parts->city_id= $request->location;
             $parts->country_id= $request->country;
             $parts->body_type_id =$request->body_type_id;
             $parts->steering= $request->steering;
             $parts->engine_code= $request->engine;
             $parts->color= $request->color;
             $parts->price_off= $request->priceoff;
             $parts->chasis= $request->chasis;
             $parts->version= $request->version;
             $parts->m3= $request->pM3;
             $parts->dimension= $request->dimension;
             $parts->fuel_id= $request->fuel;
             $parts->mileage= $request->mileage;
             $parts->weight= $request->weight;
             $parts->load_cap= $request->loadcap;
             $parts->seats= $request->seats;
             $parts->door = $request->doors;
             $parts->drivetrain= $request->drive;
             $parts->transmission= $request->transmission;
             $parts->price = $request->price;
             $parts->currency_id = $request->currency;
            // $parts->description = $request->description;
            $parts->is_active = $request->status;
            $parts->is_stock = $request->isStock == TRUE ? '1' : '0';
            $result = $parts->save();
            $data = [];
            if ($result) {
                for ($i = 0; $i < count($request->file('files')); $i++) {
                    $files = $request->file('files')[$i];
                    $profilePic = date("dmyHis.") . gettimeofday()["usec"] . '_' . $files->getClientOriginalName();
                    $files->move(public_path() . '/images/parts/', $profilePic);
                    $partImage = new PartImage();
                    $partImage->part_id = $parts->id;
                    $partImage->image = $profilePic;
                    $partImage->save();
                }
                for ($k = 0; $k < count($partArrayData); $k++) {
                    if(in_array($partArrayData[$k]['videolink'],$data)){
                        continue;
                    }
                    else{
                        $videolink = new Videolink();
                        $videolink->part_id = $parts->id;
                        $videolink->videolink = $partArrayData[$k]['videolink']; 
                        $videolink->save();
                        $data[] =  $partArrayData[$k]['videolink'];
                    }
                }
                for($j = 0; $j < count($partfeatures); $j++){
                    $partfeature = new PartFeature();
                    $partfeature->part_id = $parts->id;
                    $partfeature->feature_id = $partfeatures[$j];
                    $partfeature->save();
                }
            }
            if ($result) {

                return ['status' => true, 'message' => 'Car added successfully'];

            } else {

                return ['status' => false, 'message' => 'Car could not be added.Please try again'];

            }
        } else {
        
            $partfeatures =$request->features;
            $partfeatures = array_map('intval', explode(',', $partfeatures));
            
            $parts = PartDetails::where('id', $partId)->first();
            
            $parts->ref_no = $request->ref_no;
             $parts->reg_no = $regNoformate;
             $parts->make_id = $request->make;
             $parts->price_off= $request->priceoff;
             $parts->engine_size= $request->engine_size;
             $parts->sub_ref_no= $request->sub_ref_no;
             $parts->model_id= $request->modelcode;
             $parts->body_type_id =$request->body_type_id;
             $parts->manufacturer= $manufacturerformate;;
             $parts->city_id= $request->location;
             $parts->country_id= $request->country;
             $parts->steering= $request->steering;
             $parts->engine_code= $request->engine;
             $parts->color= $request->color;
             $parts->chasis= $request->chasis;
             $parts->version= $request->version;
             $parts->m3= $request->pM3;
             $parts->dimension= $request->dimension;
             $parts->fuel_id= $request->fuel;
             $parts->mileage= $request->mileage;
             $parts->weight= $request->weight;
             $parts->load_cap= $request->loadcap;
             $parts->seats= $request->seats;
             $parts->door = $request->doors;
             $parts->drivetrain= $request->drive;
             $parts->transmission= $request->transmission;
             $parts->price = $request->price;
            $parts->currency_id = $request->currency;
            // $parts->description = $request->description;
            $parts->price = $request->price;
            $parts->is_delete = 'N';
            $parts->is_active = $request->status;
            
            $parts->is_stock = $request->isStock === 'true' ? '1' : '0';
              
            $result = $parts->update();
            if ($result) {
                if ($request->file('files')) {
                    for ($i = 0; $i < count($request->file('files')); $i++) {
                        $files = $request->file('files')[$i];
                        $profilePic = date("dmyHis.") . gettimeofday()["usec"] . '_' . $files->getClientOriginalName();
                        $files->move(public_path() . '/images/parts/', $profilePic);
                        $partImage = new PartImage();
                        $partImage->part_id = $partId;
                        $partImage->image = $profilePic;
                        $partImage->save();
                    }
                }
                if (!empty($request->imagesArrayData)) {
                    $explode = json_decode($request->imagesArrayData, true);
                    PartImage::whereIn('id', $explode)->delete();
                }
                 if ($partArrayData) {
                    Videolink::where('part_id', $partId)->delete();
                    for ($k = 0; $k < count($partArrayData); $k++) {
                        $videolink = new Videolink();
                        $videolink->videolink = $partArrayData[$k]['videolink']; 
                        $videolink->part_id = $parts->id;
                        $videolink->save();
                    }
                }
                 $deletePrevious = PartFeature::where('part_id',$partId)->get();
                foreach($deletePrevious as $delete){
                    $delete->delete();
                }
                for($j = 0; $j < count($partfeatures); $j++){
                    $partfeature = new PartFeature();
                    $partfeature->part_id = $parts->id;
                    $partfeature->feature_id = $partfeatures[$j];
                    $partfeature->save();
                }
            }
            if ($result) {

                return ['status' => true, 'message' => 'Car Update successfully'];

            } else {

                return ['status' => false, 'message' => 'Car could not be Update.Please try again'];

            }

        }
    }
    public function editPart(Request $request)
    {
        $partsInfo = PartDetails::where('is_delete', 'N')->where('id', $request->id)->first();
        if (PartImage::where('part_id', $partsInfo['id'])->exists()) {
            $partsInfo['images'] = PartImage::where('part_id', $partsInfo['id'])->get();
            for ($l = 0; $l < count($partsInfo['images']); $l++) {
                $file = public_path() . '/images/parts/' . $partsInfo['images'][$l]['image'];
                if (!empty($partsInfo['images'][$l]['image']) && file_exists($file)) {
                    $partsInfo['images'][$l]['image'] = getImageUrl($partsInfo['images'][$l]['image'], 'parts');
                } else {
                    $partsInfo['images'][$l]['image'] = getImageUrl('parts.png', 'partss');
                }
            }

        } else {
            $partsInfo['images'] = [];
        }
      

    
        if (Videolink::where('part_id', $partsInfo['id'])->exists()) {
    
            $partsInfo['videolink'] = Videolink::where('part_id', $partsInfo['id'])->get();
          
        } 
        else {
            $partsInfo['videolink'] = [];
        }



         $featureID = PartFeature::where('part_id',$request->id)->pluck('feature_id');
        $feature = Feature::whereIn('id', $featureID)->select('feature')->get();
        $featureNames = array();
       
        foreach($feature as $features){
            $allfeature = $features['feature'];
            array_push($featureNames,$allfeature);
        }
        $partsInfo['feature'] = $featureNames;
     
        return ['status' => true, 'data' => $partsInfo];
    }
    public function deletePart(Request $request)
    {
        $partData = PartDetails::where('id', $request->id)->first();
        $partData->is_delete = 'Y';
        $result = $partData->update();
        return ['status' => $result];
    }
    public function removePartModel(Request $request){
        $getAllModals = PartYear::where('part_id',$request->id)->get();
        $countModals = $getAllModals->count();
        if($countModals > 1){
            $partData = PartYear::where('model_id', $request->modelID)->where('part_id',$request->id)->first();
            $result = $partData->delete();
            return ['status' => true];
        }
        else{
            return ['status' => false];
        }
    }
    public function userFiles()
    {
        $partsPriceCSV = getImageUrl('update-parts-price.csv','file');
        $fileToDownload = getImageUrl('ntc-sample.csv', 'file');
        $data =
            [
                'path' => $fileToDownload,
                'fileName' => 'ntc-sample.csv',
                'partPrice' =>$partsPriceCSV,
                'partCSVName' => 'update-parts-price.csv'
            ];
        return view('admin.settings.csv-files', $data);
    }

    public function addPartsData(Request $request)
    {
        if ($request->file('partFile')) {
            $file = $request->file('partFile');
            $newfilename = str_replace($file->getClientOriginalName(), "ntc-import" . Date("Ymd_His") . ".csv", $file->getClientOriginalName());
            // return $newfilename;
            $file->move(public_path() . '/csvdata/', $newfilename);
            $fileData = public_path('csvdata/' . $newfilename);
            $ntcPartsData = $this->csvToArray($fileData);

            //insert date into the table
            $addFileRecord = new PartCSVRecord();
            $addFileRecord->file_name = $newfilename;
            $addFileRecord->csv_type = "Upload New Parts";
            $addFileRecord->save();

            //test
            $header = false;
            $data = [];
            $file = fopen($fileData, 'r');
            while (!feof($file)) {
                $row = fgetcsv($file, 0, ',');
                if ($row == [NULL] || $row === FALSE) {
                    continue;
                }
                if (!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($file);
            $count = 0;
            foreach ($header as $word) {
                $match = strripos($word, "Name");
                if ($match) {
                    $count++;
                }
            }
//            dd($ntcPartsData);
            for ($i = 0; $i < count($ntcPartsData); $i++) {

                if ((!empty($ntcPartsData[$i]['Model1_Name']) && strtolower($ntcPartsData[$i]['Model1_Name']) != "null" && !empty($ntcPartsData[$i]['Model1_Year']) && strtolower($ntcPartsData[$i]['Model1_Year']) != "null")) {
                    $omitmanuspace = ltrim($ntcPartsData[$i]['Manufacturer']);
                    if (Manufacture::where('manufacture', $omitmanuspace)->exists()) {
                        $manufacturer = Manufacture::where('manufacture', $omitmanuspace)->first()['id'];
                    } else {
                        $manufacturerTable = new Manufacture();
                        $manufacturerTable->manufacture = ltrim($ntcPartsData[$i]['Manufacturer']);
                        $manufacturerTable->image = $ntcPartsData[$i]['Manufacturer_image'];
                        $manufacturerTable->save();
                        $manufacturer = $manufacturerTable->id;

                    }
                    $omitcategSpace = ltrim($ntcPartsData[$i]['Category']);
                    if (ProductCategory::where('category', $omitcategSpace)->exists()) {
                        $catergory = ProductCategory::where('category', $omitcategSpace)->first()['id'];
                    } else {
                        $catergoryTable = new ProductCategory();
                        $catergoryTable->category = ltrim($ntcPartsData[$i]['Category']);
                        $catergoryTable->image = $ntcPartsData[$i]['Category_image'];
                        $catergoryTable->created_by = $request->user()->id;
                        $catergoryTable->save();
                        $catergory = $catergoryTable->id;

                    }
                    $omitMakeSpace = ltrim($ntcPartsData[$i]['Make']);
                    if (Make::where('make', $omitMakeSpace)->exists()) {
                        $make = Make::where('make', $omitMakeSpace)->first()['id'];
                    } else {
                        $makeTable = new Make();
                        $makeTable->make = ltrim($ntcPartsData[$i]['Make']);
                        $makeTable->logo = $ntcPartsData[$i]['Make_image'];
                        $makeTable->save();
                        $make = $makeTable->id;
                    }
                    if (!Parts::where('ref_no', $ntcPartsData[$i]['Part Number'])->where('cat_id', $catergory)->where('make_id', $make)->exists()) {
                        $parts = new Parts();
                        $parts->ref_no = $ntcPartsData[$i]['Part Number'];

                        $parts->cat_id = $catergory;
                        $parts->make_id = $make;
                        $parts->manufacturer = $manufacturer;
                        $parts->description = $ntcPartsData[$i]['Description'];
                        $parts->price = (float)str_replace(',', '', $ntcPartsData[$i]['Price']);
                        $result = $parts->save();

                        if (strpos($ntcPartsData[$i]['Part_images'], ',') !== false) {
                            $partsImages = explode(',', $ntcPartsData[$i]['Part_images']);
                            for ($l = 0; $l < count($partsImages); $l++) {
                                $imageTable = new PartImage();
                                $imageTable->image = $partsImages[$l];
                                $imageTable->part_id = $parts->id;
                                $imageTable->save();
                            }
                        } else {
                            $imageTable = new PartImage();
                            $imageTable->image = $ntcPartsData[$i]['Part_images'];
                            $imageTable->part_id = $parts->id;
                            $imageTable->save();
                        }
                        if ($result) {
//                            if(! empty($ntcPartsData[$i]['Model'.$i.'_Name'])) {
//                        dd($count);
                            for ($j = 1; $j <= $count; $j++) {
//                          return  $ntcPartsData[0]['Model1_Name'];
                                $omitspace = ltrim($ntcPartsData[$i]['Model' . $j . '_Name']);
                                if (Mod_el::where('model_name', $omitspace)->where('make_id', $make)->exists()) {

                                    if (!empty($ntcPartsData[$i]['Model' . $j . '_Name']) && strtolower($ntcPartsData[$i]['Model' . $j . '_Name']) != "null" && !empty($ntcPartsData[$i]['Model' . $j . '_Year']) && strtolower($ntcPartsData[$i]['Model' . $j . '_Year']) != "null") {
                                        $modelId = Mod_el::where('model_name', $omitspace)->where('make_id', $make)->first()['id'];
                                        $model = new Modelyear();
                                        $model->model_id = $modelId;
                                        if (strpos($ntcPartsData[$i]['Model' . $j . '_Year'], '-') !== false) {
                                            $pieces = explode("-", $ntcPartsData[$i]['Model' . $j . '_Year']);
                                            $min = $pieces[0];
                                            if (strtolower($pieces[1]) == "on" || strtolower($pieces[1]) == "continue") {
                                                $max = "continue";
                                            } else {
                                                $max = $pieces[1];
                                            }
                                        } else {
                                            $min = $ntcPartsData[$i]['Model' . $j . '_Year'];
                                            if (strtolower($ntcPartsData[$i]['Model' . $j . '_Year']) == "on" || strtolower($ntcPartsData[$i]['Model' . $j . '_Year']) == "continue") {
                                                $max = "contiune";
                                            } else {
                                                $max = $ntcPartsData[$i]['Model' . $j . '_Year'];
                                            }
                                        }
                                        $model->min_year = $min;
                                        $model->max_year = $max;
                                        $model->part_id = $parts->id;
                                        $model->save();
                                    }
                                } else {
//   ;                              return "not ok";
                                    if ($ntcPartsData[$i]['Model' . $j . '_Name']) {
                                        if (!empty($ntcPartsData[$i]['Model' . $j . '_Name']) && strtolower($ntcPartsData[$i]['Model' . $j . '_Name']) != "null" && !empty($ntcPartsData[$i]['Model' . $j . '_Year']) && strtolower($ntcPartsData[$i]['Model' . $j . '_Year']) != "null") {

                                            $modelTable = new Mod_el();
                                            $modelTable->model_name = ltrim($ntcPartsData[$i]['Model' . $j . '_Name']);
                                            $modelTable->make_id = $make;
                                            $modelTable->image = $ntcPartsData[$i]['Model' . $j . '_image'];
                                            $modelTable->save();
                                            $modelId = $modelTable->id;
                                            $model = new Modelyear();
                                            $model->model_id = $modelId;
                                            if (strpos($ntcPartsData[$i]['Model' . $j . '_Year'], '-') !== false) {
                                                $pieces = explode("-", $ntcPartsData[$i]['Model' . $j . '_Year']);
                                                $min = $pieces[0];
                                                if (strtolower($pieces[1]) == "on" || strtolower($pieces[1]) == "continue") {
                                                    $max = "continue";
                                                } else {
                                                    $max = $pieces[1];
                                                }
                                            } else {
                                                $min = $ntcPartsData[$i]['Model' . $j . '_Year'];
                                                if (strtolower($ntcPartsData[$i]['Model' . $j . '_Year']) == "on" || strtolower($ntcPartsData[$i]['Model' . $j . '_Year']) == "continue") {
                                                    $max = "continue";
                                                } else {
                                                    $max = $ntcPartsData[$i]['Model' . $j . '_Year'];
                                                }
                                            }
                                            $model->min_year = $min;
                                            $model->max_year = $max;
                                            $model->part_id = $parts->id;
                                            $model->save();
                                        }
                                    }
                                }


                            }

                        }
                    }
                    //                    } else{
                    //                        $partExsist= Parts::where('ref_no', $ntcPartsData[$i]['Part Number'])->where('cat_id', $catergory)->where('make_id', $make)->first();
                    //
                    //                        $partExsist->ref_no = $ntcPartsData[$i]['Part Number'];
                    //
                    //                        $partExsist->cat_id = $catergory;
                    //                        $partExsist->make_id = $make;
                    //                        $partExsist->manufacturer = $manufacturer;
                    //                        $partExsist->description = $ntcPartsData[$i]['Description'];
                    //                        $partExsist->price = (float)str_replace(',', '', $ntcPartsData[$i]['Price']);
                    //                        $result = $partExsist->save();
                    //                    }
                }
            }
        }
        return ['status' => true];
    }
    public function updatePartsData(Request $request)
    {
        if ($request->file('partFile1')) {
            $file = $request->file('partFile1');
            $newfilename = str_replace($file->getClientOriginalName(), "ntc-parts-price-update" . Date("Ymd_His") . ".csv", $file->getClientOriginalName());
            // return $newfilename;
            $file->move(public_path() . '/partpricedata/', $newfilename);
            $fileData = public_path('partpricedata/' . $newfilename);
            $ntcPartsData = $this->csvToArray($fileData);
            //test
            $header = false;
            $data = [];
            $file = fopen($fileData, 'r');
            while (!feof($file)) {
                $row = fgetcsv($file, 0, ',');
                if ($row == [NULL] || $row === FALSE) {
                    continue;
                }
                if (!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($file);
            $count = 0;
            foreach ($header as $word) {
                $match = strripos($word, "Name");
                if ($match) {
                    $count++;
                }
            }
        //    dd($ntcPartsData);
            for ($i = 0; $i < count($ntcPartsData); $i++) {

                if (!empty($ntcPartsData[$i]['Part Number']) && !empty($ntcPartsData[$i]['Price'])) {
                    // dd($ntcPartsData[$i]);
                    $omitRefspace = trim($ntcPartsData[$i]['Part Number']," ");
                    $omitPriceSpace = trim($ntcPartsData[$i]['Price']," ");
                    $part = Parts::where('ref_no',$omitRefspace)->first();
                    if($part != "" && $part != null){
                        $part->price =str_replace(',', '', $omitPriceSpace);
                            $part->update();
                        }
                    else{
                        continue;
                    }
                }
                else{
                    continue;
                }
            }
            //insert date into the table
            $addFileRecord = new PartCSVRecord();
            $addFileRecord->file_name = $newfilename;
            $addFileRecord->csv_type = "Update Parts Price";
            $addFileRecord->save();
        }
        return ['status' => true];
    }
    public function removePartswithDeletedCats(){
        $getDuplicateParts = DB::select(DB::raw("SELECT *  FROM `parts` GROUP BY ref_no HAVING COUNT(ref_no) > 1"));
        foreach($getDuplicateParts as $part){
            $getParts = Parts::where('ref_no',$part->ref_no)->where('is_delete',0)->get();
                foreach($getParts as $part){
                    $checkDelete = ProductCategory::where('id',$part->cat_id)->first();
                    if($checkDelete->is_deleted == 'Y'){
                    DB::table('parts')->where('id', $part->id)->update(['is_delete' => 1]);
                }
            }
        }
        // $getDuplicateParts = DB::select(DB::raw("SELECT *  FROM `parts` GROUP BY ref_no HAVING COUNT(ref_no) > 2"));
        // foreach($getDuplicateParts as $part){
        //     $getParts = Parts::where('ref_no',$part->ref_no)->where('is_delete',0)->get();
        //         foreach($getParts as $part){
        //             $checkDelete = ProductCategory::where('id',$part->cat_id)->first();
        //             if($checkDelete->is_deleted == 'Y'){
        //             DB::table('parts')->where('id', $part->id)->update(['is_delete' => 1]);
        //         }
        //     }
        // }
        return "Duplicate parts with deleted categories are removed now";
    }

    public function removePartswithDeletedCatss(){
        $parts = [];
            $fileName = 'Parts.csv';
            $getDuplicateParts = DB::select(DB::raw("SELECT *  FROM `parts` WHERE is_delete = 0 GROUP BY ref_no HAVING COUNT(ref_no) > 1"));
            foreach($getDuplicateParts as $part){
                $getDuplicate = Parts::where('ref_no',$part->ref_no)->where('is_delete',0)->get()->toArray();
                foreach($getDuplicate as $pt){
                    // return $pt;
                    $cat_id = ProductCategory::where('id',$pt['cat_id'])->first();
                    $pt['cat_name'] = $cat_id->category;
                    array_push($parts,$pt);
                }
            }
            $count = 0;

                 $headers = array(
                     "Content-type"        => "text/csv",
                     "Content-Disposition" => "attachment; filename=$fileName",
                     "Pragma"              => "no-cache",
                     "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                     "Expires"             => "0"
                 );

                 $columns = array('id', 'cat_id', 'ref_no', 'description', 'currency', 'make_id', 'manufacturer','price','is_active','is_delete','cat_name');

                 $callback = function() use($parts, $columns) {
                     $file = fopen('php://output', 'w');
                     fputcsv($file, $columns);

                     foreach ($parts as $key=>$task) {
                        // return $task['id'];
                         $row['id']  = $task['id'];
                         $row['cat_id']    = $task['cat_id'];
                         $row['ref_no']    = $task['ref_no'];
                         $row['description']    = $task['description'];
                         $row['currency']  = $task['currency'];
                         $row['make_id']    = $task['make_id'];
                         $row['manufacturer']    = $task['manufacturer'];
                         $row['price']    = $task['price'];
                         $row['is_active']  = $task['is_active'];
                         $row['is_delete']    = $task['is_delete'];
                         $row['cat_name']    = $task['cat_name'];
// return $row;

                         fputcsv($file, array($row['id'], $row['cat_id'], $row['ref_no'],$row['description'],$row['currency'], $row['make_id'], $row['manufacturer'],$row['price'],$row['is_active'], $row['is_delete'], $row['cat_name']));
                     }

                     fclose($file);
                 };

                 return response()->stream($callback, 200, $headers);
    }

    function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
    }

    public function approveOrder(Request $request)
    {
        $order = Order::where('id', $request->orderId)->first();
        $order->status = 'accepted';
        $result = $order->save();
        if ($result) {
            // $notification = new Notification();
            // $notification->user_id = $order->user_id;
            // $notification->product_id = $order->id;
            // $notification->schedule_date = date('Y-m-d H:i:s');
            // $notification->is_msg_app = 'Y';
            // $notification->is_notification_required = 'Y';
            // $notification->notification_type = 'Order';
            // $notification->title = 'Order Approved';
            // $notification->description = 'Congratulations! Your Order against this Order ID # ' . $order->id . ' has been Approved';
            // $notification->save();
            // $notification_controller = new NotificationController;
            // $notification_controller->send_comm_app_notification();
        }
        return ['status' => $result];
    }

    public function deleteOrder(Request $request)
    {
        $order = Order::where('id', $request->id)->first();
        $order->is_delete = 1;
        $result = $order->save();
        return ['status' => $result];
    }

    public function exportPartsData()
    {
        return view('admin.part.export_parts_data');
    }

    public function exportCsvData(Request $request)
    {

        $posts = $request->all();


        $file_name = 'non_image_parts_' . date('Y/m/d') . '.csv';


        header("Content-Description:File Transfer");


        header("Content-Disposition: attachment; filename=$file_name");


        header("Content-Type: application/csv;");


        $partsData = $this->getPartsData();


        $file = fopen('php://output', 'w');


        fputcsv($file, array('Ref No# ', 'Manufacturer Name', 'Category', 'Make'));


        foreach ($partsData as $row) {


            fputcsv($file, array($row['ref_no'], $row['manufactureName'], $row['category'], $row['make']));


        }


        fclose($file);


        exit;
    }

    public function getPartsData()
    {
        $partsData = array();
        $parts = PartDetails::where('is_active',1)->where('is_delete','N')->get();
        for ($i = 0; $i < count($parts); $i++) {
            $partImage = PartImage::where('part_id', $parts[$i]['id'])->first();
            if ($partImage) {
                if (!file_exists(public_path() . '/images/parts/' . $partImage['image'])) {
                    array_push($partsData, $parts[$i]);
                }
            }else{
                array_push($partsData, $parts[$i]);
            }
        }
        $partsInfo = $partsData;
        for ($i = 0; $i < count($partsInfo); $i++) {
            $manufacturer = Manufacture::where('id', $partsInfo[$i]->manufacturer)->first();
            if ($manufacturer && $manufacturer->manufacture) {
                $partsInfo[$i]['manufactureName'] = $manufacturer->manufacture;
            } else {
                $partsInfo[$i]['manufactureName'] = "N/A";
            }
            $category = ProductCategory::where('id', $partsInfo[$i]['cat_id'])->first();
            if ($category && $category['category']) {
                $partsInfo[$i]['category'] = $category['category'];
            }
            $make = Make::where('id', $partsInfo[$i]['make_id'])->first();
            if ($make) {
                $partsInfo[$i]['make'] = $make['make'];
            }
        }
        return $partsInfo;
    }

    public function showTrendingParts(){
        $partsInfo=Parts::where('is_active', 1)->where('is_delete', 'N')->get();
        for ($i = 0; $i < count($partsInfo); $i++)
        {
            // $manufacturer = Manufacture::where('id', $partsInfo[$i]->manufacturer)->first();
            // if($manufacturer && $manufacturer->manufacture){
            // $partsInfo[$i]['manufactureName'] = $manufacturer->manufacture;
            // }else
            // {
            // $partsInfo[$i]['manufactureName'] = "N/A";
            // }

            $category = ProductCategory::where('id', $partsInfo[$i]['cat_id'])->first();
            if($category && $category['category']){
            $partsInfo[$i]['category'] = $category['category'];
            }
            $make = Make::where('id', $partsInfo[$i]['make_id'])->first();
            if($make){
            $partsInfo[$i]['make'] = $make['make'];
            }
            if (Modelyear::where('part_id', $partsInfo[$i]['id'])->exists()) {
                $partsInfo[$i]['model'] = Modelyear::where('part_id', $partsInfo[$i]['id'])->get();
                for ($k = 0; $k < count($partsInfo[$i]['model']); $k++) {
                    if(Mod_el::where('id', $partsInfo[$i]['model'][$k]['model_id'])->exists()){
                    $partsInfo[$i]['model'][$k]['model'] = Mod_el::where('id', $partsInfo[$i]['model'][$k]['model_id'])->first()['model_name'];
                    }
                }
            } else {
                $partsInfo[$i]['model'] = [];
            }
        }

        $trendingPartsid=TrendingParts::where('is_trending','Y')->pluck('part_id')->sortBy('created_at');
        //  dd($trendingPartsid);
        $trendingParts=Parts::whereIn('id',$trendingPartsid)->where('is_active', 1)->where('is_delete', 'N')->get();
        for ($i = 0; $i < count($trendingParts); $i++)
        {
            $trendingPartDetail= TrendingParts::where('part_id', $trendingParts[$i]->id)->where('is_trending','Y')->first();
            $trendingParts[$i]['start_date'] = $trendingPartDetail->start_date;
            $trendingParts[$i]['end_date'] = $trendingPartDetail->end_date;
            $manufacturer = Manufacture::where('id', $trendingParts[$i]->manufacturer)->first();
            if($manufacturer && $manufacturer->manufacture){
            $trendingParts[$i]['manufactureName'] = $manufacturer->manufacture;
            }else
            {
            $trendingParts[$i]['manufactureName'] = "N/A";
            }
            $make = Make::where('id', $trendingParts[$i]['make_id'])->first();
            if($make){
            $trendingParts[$i]['make'] = $make['make'];
            }
        }

         return view('admin.client.top-trending-parts', ['parts' => $partsInfo , "featuredParts" => $trendingParts]);
    }
    function addTrendingParts(Request $req){

        foreach($req->id as $data) {
            $topTrending=TrendingParts::where('part_id',$data)->where('is_trending','Y')->first();
                if($topTrending)
                {

                    $topTrending->start_date = $req->startDate;
                    $topTrending->end_date = $req->endDate;
                    $topTrending->save();
                    return true;
                }
                else{
                    $topTrending = new TrendingParts();
                    $topTrending->part_id = $data;
                    $topTrending->start_date = $req->startDate;
                    $topTrending->end_date = $req->endDate;
                    $topTrending->is_trending = 'Y';
                    $topTrending->save();


                }
        }
            return true;
    }
    function deleteTrendingParts(Request $req){
        $topTrending= TrendingParts::where('part_id',$req->id)->where('is_trending', 'Y')->first();
        if($topTrending){
            $topTrending->is_trending= 'N';
            $topTrending->save();
            return true;
        }
        else{
            return false;
        }

    }
    function ModelDetail($id)
    {
        $data=PartYear::where('model_id',$id)->pluck('part_id');
        $partsInfo=Parts::whereIn('id',$data)->where('is_active',1)->where('is_delete','N')->get();
        for ($i = 0; $i < count($partsInfo); $i++)
        {
            $manufacturer = Manufacture::where('id', $partsInfo[$i]->manufacturer)->first();
            if($manufacturer && $manufacturer->manufacture){
            $partsInfo[$i]['manufactureName'] = $manufacturer->manufacture;
            }else
            {
            $partsInfo[$i]['manufactureName'] = "N/A";
            }
            if($manufacturer && $manufacturer->image){
            $partsInfo[$i]['manufactureImage'] = getImageUrl($manufacturer->image, 'manufacture');
            }else{
                $partsInfo[$i]['manufactureImage'] = getImageUrl('manufacture.png', 'manufacture');
            }
            $category = ProductCategory::where('id', $partsInfo[$i]['cat_id'])->first();
            if($category && $category['category']){
            $partsInfo[$i]['category'] = $category['category'];
            }
            if (empty($category['image'])) {
                $category['image'] = 'xyz';
            }
            $file = public_path() . '/images/settings/' . $category['image'];
            if (!empty($category['image']) && file_exists($file)) {
                $partsInfo[$i]['categoryImage'] = getImageUrl($category['image'], 'settings');
            } else {
                $partsInfo[$i]['categoryImage'] = getImageUrl('parts.png', 'partss');
            }
//            $make = Make::where('id', $partsInfo[$i]['make_id'])->first();
            $makeID = PartMake::where('part_id',$partsInfo[$i]['id'])->first();
            if($makeID){
                $make= Make::where('id',$makeID['make_id'])->first();
                if ($make) {
                    $partsInfo[$i]['make'] = $make->make;
                }
            }
            if (empty($make['logo'])) {
                $make['logo'] = 'xyz';
            }
            $file = public_path() . '/images/settings/' . $make['logo'];
            if (!empty($make['logo']) && file_exists($file)) {
                $partsInfo[$i]['makeImage'] = getImageUrl($make['logo'], 'settings');
            } else {
                $partsInfo[$i]['makeImage'] = getImageUrl('parts.png', 'partss');
            }
            if (Modelyear::where('part_id', $partsInfo[$i]['id'])->exists()) {
                $partsInfo[$i]['model'] = Modelyear::where('part_id', $partsInfo[$i]['id'])->get();
                for ($k = 0; $k < count($partsInfo[$i]['model']); $k++) {
                    if(Mod_el::where('id', $partsInfo[$i]['model'][$k]['model_id'])->exists()){
                    $partsInfo[$i]['model'][$k]['model'] = Mod_el::where('id', $partsInfo[$i]['model'][$k]['model_id'])->first()['model_name'];
                    }
                }
            } else {
                $partsInfo[$i]['model'] = [];
            }
            if (PartImage::where('part_id', $partsInfo[$i]['id'])->exists()) {
                $partsInfo[$i]['images'] = PartImage::where('part_id', $partsInfo[$i]['id'])->get();
                for ($l = 0; $l < count($partsInfo[$i]['images']); $l++) {
                    $file = public_path() . '/images/parts/' . $partsInfo[$i]['images'][$l]['image'];
                    if (!empty($partsInfo[$i]['images'][$l]['image']) && file_exists($file)) {
                        $partsInfo[$i]['images'][$l]['image'] = getImageUrl($partsInfo[$i]['images'][$l]['image'], 'parts');
                    } else {
                        $partsInfo[$i]['images'][$l]['image'] = getImageUrl('parts.png', 'partss');
                    }
                }

            } else {
                $partsInfo[$i]['images'] = [];
            }
        }
        return view('admin.settings.parts-detail', ['parts' => $partsInfo, 'model_id' =>$id]);
    }
    function editTopTrending(Request $request){

        $topTrending= TrendingParts::where('part_id', $request->id)->where('is_trending', 'Y')->first();
        $topTrending->start_date= $request->StartDate;
        $topTrending->end_date= $request->EndDate;
        $topTrending->save();
        if($topTrending->save()){
        return redirect()->route('trends.parts')->with('success', 'Top Trending Car Updated successfully!!!');
        }
        else {
            return redirect()->back()->with('error', 'Sorry! There was an issue in updating the car');
        }

    }
    public function addMakes(){
        $getParts = PartDetails::where('is_delete', 'N')->where('is_active',1)->get();
        foreach($getParts as $part){
            $getModels = PartYear::where('part_id', $part->id)->pluck('model_id');
            // return $getModels;
            $getMakes = Mod_el::whereIn('id',$getModels)->where('is_active',1)->groupBy('make_id')->get();
            foreach($getMakes as $makes){

                $addPartMake = new PartMake();
                $addPartMake->make_id = $makes->make_id;
                $addPartMake->part_id = $part->id;
                $result = $addPartMake->save();
            }
        }
        if($result){
            return "Parts Makes added successfully";
        }
    }
     public function getlocationBycountry(Request $request)
    {
        $countryId = $request->input('county_id');
        $location = City::where('country_id', $countryId)->get();
        return response()->json($location);
    }

}