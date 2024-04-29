<?php

namespace App\Http\Controllers\User;

use App\User;
use App\Http\Models\Favorite;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Http\Models\Country;
use App\Http\Models\City;
use App\Http\Models\Feature;
use App\Http\Models\Parts;
use App\Http\Models\Make;
use App\Http\Models\Currency;
use App\Http\Models\Mod_el;
use App\Http\Models\PartFeature;
use App\Http\Models\PartImage;
use App\Http\Models\PartDetails;
use App\Http\Models\Config;
use App\Http\Models\TrendingParts;
use App\Http\Models\Shipment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
  public function __construct() 
  {
      // Fetch the country & city object
       $setting = Config::first(['key', 'values']);
        $countries = Country::where('is_delete', 'N')->where('is_active', 1)->get();
      $cities = City::where('is_delete', 'N')->where('is_active', 1)->get();
      View::share(['setting'=> $setting,'countries'=>$countries,'cities'=> $cities]);
  }

  public function userLogin()
  {
    return view('user.user_login');
  }
  public function userSignup()
  {
    return view('user.user_signup');
  }
  public function userStore(Request $request)
  {
    $request->validate([
      'username' => ['required', 'string', 'max:255'],
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'password' => 'required',
      'confirm_password' => 'required|same:password',
    ]);

    $user = new User();
    $user->name = $request->name;
    $user->username = $request->username;
    $user->email = $request->email;
    $user->password = bcrypt($request->password);
    $user->role = 2;
    $user->is_approved = "Y";
    $user->save();
    return response()->json([
      'success' => 'You are registered successfully!',
      'redirect' => route('user.login')
    ]);
  }
  public function contactus()
  {
    $favoriteCount = 0;
    $user = Auth::user();
    if ($user) {
      $favoriteCount = Favorite::where('user_id', $user->id)->count();
    }
    return view('user.contact_us', ['favoriteCount' => $favoriteCount]);
  }
  public function payment()
  {
    $favoriteCount = 0;
    $user = Auth::user();
    if ($user) {
      $favoriteCount = Favorite::where('user_id', $user->id)->count();
    }
    return view('user.payment', ['favoriteCount' => $favoriteCount]);
  }
  public function aboutUs()
  {
    $favoriteCount = 0;
    $user = Auth::user();
    if ($user) {
      $favoriteCount = Favorite::where('user_id', $user->id)->count();
    }
    return view('user.about_us', ['favoriteCount' => $favoriteCount]);
  }

  public function services()
  {
    $favoriteCount = 0;
    $user = Auth::user();
    if ($user) {
      $favoriteCount = Favorite::where('user_id', $user->id)->count();
    }
    return view('user.services', ['favoriteCount' => $favoriteCount]);
  }

  public function advanceSearch(Request $request)
  {
   
  //  dd($request->features);
    $make_id = $request->make_id ?? null;
    $model_id = $request->model_id ?? null;
    $fuel_types = $request->fuel_types ?? null;
    $body_type_id = $request->body_type_id ?? null;
    $steering = $request->steering ?? null;
    $transmission = $request->transmission ?? null;
    $min_mileage = $request->min_mileage ?? null;
    $max_mileage = $request->max_mileage ?? null;
    $min_engine = $request->min_engine ?? null;
    $max_engine = $request->max_engine ?? null;
    $price = $request->price ?? null;
    $drivetrain = $request->drivetrain ?? null;
    $color = $request->color ?? null;
    $max_pass = $request->max_pass ?? null;
    $min_pass = $request->min_pass ?? null;
    $min_load = $request->min_load ?? null;
    $max_load = $request->max_load ?? null;
    $country_id = $request->country_id ?? null;
    $filterfeatures = $request->features ?? [];
    $active_tab = $request->active_tab;
    $city_id = $request->city_id ?? null;
    $from_year = $request->from_year ?? null;
    $to_year = $request->to_year ?? null;

    $minPrice = null;
    $maxPrice = null;
    if($price !== null){
      if($price != '500000' && $price != '5000001'){
        // Convert values to integers
        $priceValues = explode('-', $price);
        $minPrice = intval($priceValues[0]);
        $minPrice = $minPrice-1;
        $maxPrice = intval($priceValues[1]);
      }else{
        if($price != '5000001'){
          $minPrice = null;
          $maxPrice = $price;
        }else{
          $minPrice = $price-1;
          $maxPrice = null;
        }
      }
    }else{
      $minPrice = intval($request->min_price);
      $maxPrice = intval($request->max_price);
    }

    $requested_data = [];
    $requested_data['make_id'] = $make_id;
    $requested_data['model_id'] = $model_id;
    $requested_data['fuel_types'] = $fuel_types;
    $requested_data['body_type_id'] = $body_type_id;
    $requested_data['steering'] = $steering;
    $requested_data['transmission'] = $transmission;
    $requested_data['min_mileage'] = $min_mileage;
    $requested_data['max_mileage'] = $max_mileage;
    $requested_data['min_engine'] = $min_engine;
    $requested_data['max_engine'] = $max_engine;
    $requested_data['drivetrain'] = $drivetrain;
    $requested_data['color'] = $color;
    $requested_data['max_pass'] = $max_pass;
    $requested_data['min_pass'] = $min_pass;
    $requested_data['min_load'] = $min_load;
    $requested_data['max_load'] = $max_load;
    $requested_data['minPrice'] = $minPrice;
    $requested_data['maxPrice'] = $maxPrice;
    $requested_data['city_id'] = $city_id;
    $requested_data['country_id'] = $country_id;
    $requested_data['filterfeatures'] = $filterfeatures;
    $requested_data['from_year'] = $from_year;
    $requested_data['to_year'] = $to_year;
    $requested_data['active_tab'] = $active_tab;
   
    $isStockRequested = $request->is_stock;
 
    $query = Parts::query();

    // if ($isStockRequested) {
    //     $query->where('is_stock', 1);
    // }
    if ($make_id !== null) {
      $query->where('make_id', $make_id);
    }
    if ($body_type_id !== null) {
      $query->where('body_type_id', $body_type_id);
    }
    if ($model_id !== null) {
      $query->where('model_id', $model_id);
    }
    if ($steering !== null) {
      $query->where('steering', $steering);
    }
    if ($transmission !== null) {
      $query->where('transmission', $transmission);
    }
    //start mileage
    if ($min_mileage !== null) {
      $query->where('mileage','>=',$min_mileage);
    }
    if ($max_mileage !== null) {
      $query->where('mileage','<=',$max_mileage);
    }
    if ($max_mileage !== null && $min_mileage !== null) {
      $query->whereBetween('mileage',[$min_mileage,$max_mileage]);
    }
    //end mileage

    //start passenger
    if ($min_pass !== null) {
      $query->where('seats','>=',$min_pass);
    }
    if ($max_pass !== null) {
      $query->where('seats','<=',$max_pass);
    }
    if ($min_pass !== null && $max_pass !== null) {
      $query->whereBetween('seats',[$min_pass,$max_pass]);
    }
    //end passenger

    //start load cap
    if ($min_load !== null) {
      $query->where('load_cap','>=',$min_load);
    }
    if ($max_load !== null) {
      $query->where('load_cap','<=',$max_load);
    }
    if ($min_load !== null && $max_load !== null) {
      $query->whereBetween('load_cap',[$min_load,$max_load]);
    }
    //end load cap

    if ($drivetrain !== null) {
      $query->where('drivetrain',$drivetrain);
    }
    if ($color !== null) {
      $query->where('color',$color);
    }
    if ($country_id !== null) {
      $query->where('country_id',$country_id);
    }
    if ($city_id !== null) {
      $query->where('city_id',$city_id);
    }

    //start engine
    if ($min_engine !== null) {
      $query->where('engine_size','>=',$min_engine);
    }
    if ($max_engine !== null) {
      $query->where('engine_size','<=',$max_engine);
    }
    if ($min_engine !== null && $max_engine !== null) {
      $query->whereBetween('engine_size',[$min_engine,$max_engine]);
    }
    //end engine

    if ($fuel_types !== null) {
      $query->where('fuel_id', $fuel_types);
    }

    //start price
    if ($minPrice != null) {
      $query->where('price', '>=', $minPrice);
    }
    if ($maxPrice != null) {
      $query->where('price', '<=', $maxPrice);
    }
    if ($maxPrice != null && $minPrice != null) {
      $query->whereBetween('price', [$minPrice, $maxPrice]);
    }
    //end price

    //start years
    if ($from_year !== null && $to_year == null) {
        $query->whereYear('manufacturer', '>=', $from_year)
              ->whereYear('manufacturer', '<=', Carbon::now()->format('Y'));
    }
    if ($from_year !== null && $to_year !== null) {
        $query->whereYear('manufacturer', '>=', $from_year)
              ->whereYear('manufacturer', '<=', $to_year);
    }
    //end years
     $makeId = Make::where('is_delete', 'N')->where('is_active', '1')->pluck('id')->toArray();
     $modelId = Mod_el::where('is_delete', 'N')->where('is_active', '1')->pluck('id')->toArray();
    if($active_tab == 'newArrival'){
      if ($filterfeatures) {
          $featuresData = Feature::leftjoin('part_features','features.id','=','part_features.feature_id')
            ->whereIn('features.id',$filterfeatures)
            ->select('part_features.part_id')
            ->where('features.is_active',1)
            ->where('features.is_delete','N')
            ->get();

          $parts =
          $query->whereIn('id',$featuresData)->whereIn('make_id',$makeId)->whereIn('model_id',$modelId)->where('is_delete',
          'N')->where('is_active', 1)->latest('parts.id')->get();
      }else{
      $parts = $query->latest('parts.id')->whereIn('make_id',$makeId)->whereIn('model_id',$modelId)->where('is_delete',
      'N')->where('is_active',
      1)->get();
    }
    }elseif($active_tab == 'featured'){
     
       $featuredParts = TrendingParts::where('is_trending','Y')->select('part_id')->get();
       $parts = $query->whereIn('id',$featuredParts)->where('is_delete', 'N')->where('is_active', 1)->latest('parts.id')->get();
    }else{
      $parts = $query->latest('parts.id')->where('is_delete', 'N')->where('is_active', 1)->get();
    }
    
    foreach($parts as $part){
      $model = Mod_el::where('id',$part->model_id)->first();
      $part['model'] = $model ? $model->model_name : '';
      $currency = Currency::where('id',$part->currency_id)->first();
      $part['currency'] = $currency ? $currency->currency : '';
      $part['model_code'] = $model ? $model->model_code : '';
      $make = Make::where('id',$part->make_id)->first();
      $part['make'] = $make ? $make->make : '';
      $features = PartFeature::with('features')->where('part_id',$part->id)->get();
      $part['features'] = $features ? $features : '';
      $fuel_type = DB::table('fuel_types')->where('id',$part->fuel_id)->where('is_delete', 'N')->where('is_active', '1')->first();
      $part['fuel_type'] = $fuel_type ? $fuel_type->fuel_type : '';
      $country = Country::where('id',$part->country_id)->first();
      $part['country_name'] = $country?$country->country_name:'';
      $part['images'] = PartImage::where('part_id',$part->id)->get();
    }

    $make = Make::where('is_delete', 'N')->where('is_active', '1')->get();
    $countries = Country::where('is_delete', 'N')->where('is_active', '1')->get();
    $models = Mod_el::where('is_delete', 'N')->where('is_active', '1')->whereHas('make', function ($query) {
    $query->where('is_active', 1);
    })->get();
    $fuel_types = DB::table('fuel_types')->where('is_delete', 'N')->where('is_active', '1')->get();
    $featuresArray = Feature::where('is_delete', 'N')->where('is_active', '1')->get();
    $bodyTypes = DB::table('part_body_types')->where('is_delete', 'N')->where('is_active', '1')->get();
    $years = array_combine(range(date("Y"), 1910), range(date("Y"), 1910));
    $sumUp = 500000;
    $priceUnits = [];
    for ($i = 0; $i <= 5000000; $i += $sumUp) {
        $priceUnits[] = $i + $sumUp;
    }
    $newArrival = PartDetails::where('is_delete', 'N')->where('is_active', 1)->simplePaginate(10);
    $featuresByPart = [];
    $partIds = $newArrival->pluck('id');
    foreach ($partIds as $partId) {
      $features = PartFeature::where('part_id', $partId)->join('features', 'part_features.feature_id', '=', 'features.id')->pluck('features.feature');
      if($features){
        $featuresByPart[$partId] = $features;
      }
    }
    $partImages = PartImage::whereIn('part_id', $newArrival->pluck('id'))->get()->groupBy('part_id');
    $favoriteCount = 0;
    $user = Auth::user();
    if ($user) {
      $favoriteCount = Favorite::where('user_id', $user->id)->count();
    }
      $activeParts = PartDetails::where('is_delete', 'N')->where('is_active', 1)
      ->whereHas('make', function ($query) {
      $query->where('is_active', 1);
      })
      ->whereHas('model', function ($query) {
      $query->where('is_active', 1);
      })->pluck('id')->toArray();
    $now = now()->toDateString();
    $featured = TrendingParts::whereIn('part_id',$activeParts)->where('start_date', '<=', $now) ->where('end_date',
        '>=', $now)
        ->where('is_trending', 'Y')
        ->paginate(10);
    $featuredImgs = PartImage::whereIn('part_id', $featured->pluck('part_id'))->get()->groupBy('part_id');
     $shipment = Shipment::where('is_delete', 'N')->where('is_active', 1)
     ->first();
    return view('user.advance_search', ['featuredImgs'=> $featuredImgs, 'featured'=>$featured, 'featuresByPart' =>
    $featuresByPart,'partImages'=>$partImages,'newArrival'=>
    $newArrival,'body_types'=>$bodyTypes,'featuresArray'=>$featuresArray,'fuel_types'=>$fuel_types,'countries'=>$countries,'favoriteCount'
    => $favoriteCount,'minPrice'=>$minPrice,'maxPrice'=>$maxPrice,'priceUnits'=>$priceUnits,'years'=>$years ,'models' =>
    $models,'requested_data'=>$requested_data,'makes' => $make, 'partsData' => $parts,'shipment'=> $shipment]);
  }

  public function getCities(Request $request)
  {
    $cities = City::where('country_id',$request->country_id)->where('is_active',1)->where('is_delete','N')->get();
    return response()->json(['status'=>'true','data'=>$cities]);

  }
}
