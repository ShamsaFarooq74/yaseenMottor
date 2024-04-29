<?php

namespace App\Http\Controllers;

use App\Http\Models\PartDetails;
use App\Http\Models\Make;
use App\Http\Models\TrendingParts;
use App\Http\Models\Feature;
use App\Http\Models\Mod_el;
use App\Http\Models\PartFeature;
use App\Http\Models\Country;
use App\Http\Models\City;
use App\Http\Models\Shipment;
use App\Http\Models\Favorite;
use App\Http\Models\ContactUs;
use App\Http\Models\Videolink;
use App\Http\Models\PartImage;
use App\Http\Models\Config;
use App\Http\Models\FuelType;
use App\Http\Models\PartInquire;
use App\Mail\OrderReceived;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mail;

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  // public function __construct()
  // {
  //     $this->middleware('auth');
  // }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */

  public function __construct()
  {
    // Fetch the country & city object
    $countries = Country::where('is_delete', 'N')->where('is_active', 1)->get();
    $cities = City::where('is_delete', 'N')->where('is_active', 1)->get();
    $make = Make::where('is_delete', 'N')->where('is_active', '1')->get();
    $models = Mod_el::where('is_delete', 'N')->where('is_active', '1')
    ->whereHas('make', function ($query) {
    $query->where('is_active', 1);
    })->get();
    $bodyTypes = DB::table('part_body_types')->where('is_delete', 'N')->where('is_active', '1')->get();
    $years = array_combine(range(date('Y'), 1910), range(date('Y'), 1910));
     
    View::share(['countries' => $countries, 'cities' => $cities,'make'=>$make,'models'=>$models, 'body_types' => $bodyTypes,'years' => $years,]);
  }
  public function index(Request $request)
  {
    $activePage = isset($request->type) ? $request->type : "new-arrival";
    $newArrival = PartDetails::where('is_delete', 'N')->where('is_active', 1)
    ->whereHas('make', function ($query) {
    $query->where('is_active', 1);
    })
    ->whereHas('model', function ($query) {
    $query->where('is_active', 1);
    })->paginate(9);
    foreach($newArrival as $arrival){
      $arrival['fuel'] = FuelType::where('id',$arrival->fuel_id)->first()->fuel_type;
    }
    $partImages = PartImage::whereIn('part_id', $newArrival->pluck('id'))->get()->groupBy('part_id');
    $favoriteId = Favorite::where('user_id', Auth::id())->pluck('part_id')->toArray();
    $partsCount = PartDetails::where('is_delete', 'N')->where('is_active', 1)->where('is_stock', 1)->count();
    $user = Auth::user();
    $favoriteCount = 0;
    if ($user) {
      $favoriteCount = Favorite::where('user_id', $user->id)->count();
    }
    $today = Carbon::now();
    $todayParts = PartDetails::where('is_delete', 'N')->where('is_active', 1)->whereDate('created_at', $today->toDateString())->count();

    $makes = DB::table('make')
      ->select('make.id', 'make.make', 'make.logo', DB::raw('COUNT(parts.make_id) as parts_count'))
      ->leftJoin('parts', 'make.id', '=', 'parts.make_id')
      ->where('make.is_delete', 'N')
      ->where('make.is_active', 1)
      ->groupBy('make.id', 'make.make', 'make.logo')->limit(18) 
      ->get();

   $now = now()->toDateString();
    $activeParts = PartDetails::where('is_delete', 'N')->where('is_active', 1)
    ->whereHas('make', function ($query) {
    $query->where('is_active', 1);
    })
    ->whereHas('model', function ($query) {
    $query->where('is_active', 1);
    })->pluck('id')->toArray();
   $featured = TrendingParts::whereIn('part_id',$activeParts)->where('start_date', '<=', $now) ->where('end_date', '>=', $now)
       ->where('is_trending', 'Y')
       ->paginate(9);
    $featuredImgs = PartImage::whereIn('part_id', $featured->pluck('part_id'))->get()->groupBy('part_id');
    $make = Make::where('is_delete', 'N')->where('is_active', '1')->get();
    $models = Mod_el::where('is_delete', 'N')->where('is_active', '1')
    ->whereHas('make', function ($query) {
    $query->where('is_active', 1);
    })->get();
    $bodyTypes = DB::table('part_body_types')->where('is_delete', 'N')->where('is_active', '1')->get();
    $years = array_combine(range(date('Y'), 1910), range(date('Y'), 1910));

    return view('home', ['activePage'=> $activePage,'models' => $models, 'body_types' => $bodyTypes, 'years' => $years, 'make' => $make, 'featuredImgs' => $featuredImgs, 'partImages' => $partImages, 'favoriteId' => $favoriteId, 'favoriteCount' => $favoriteCount, 'todayParts' => $todayParts, 'featured' => $featured, 'newArrival' => $newArrival, 'partsCount' => $partsCount, 'makes' => $makes]);
  }
  public function productDetail($id)
  {
     $shipment = Shipment::where('is_delete', 'N')->where('is_active', 1)
      ->first();
    
    
    $favoriteCount = 0;
    $user = Auth::user();
    if ($user) {
      $favoriteCount = Favorite::where('user_id', $user->id)->count();
    }
    $partsDetail = PartDetails::where('id', $id)->where('is_delete', 'N')->where('is_active', 1)->first();
   $favoriteId = Favorite::where('user_id', Auth::id())->pluck('part_id')->toArray();
    $partImages = PartImage::where('part_id', $id)->get();
    // return $partImages;
    $makes = Make::where('id', $partsDetail->make_id)->where('is_delete', 'N')->where('is_active', 1)->get();
    foreach ($makes as $make) {
      $partsInfo = PartDetails::where('id', '!=', $partsDetail->id)
      ->where('make_id', $make->id)
      ->where('is_delete', 'N')
      ->where('is_active', 1)
      ->whereHas('make', function ($query) {
      $query->where('is_active', 1);
      })
      ->whereHas('model', function ($query) {
      $query->where('is_active', 1);
      })
      ->get();
    }
    $videoLinks = Videolink::where('part_id', $partsDetail->id)->latest('id')->get();
    
    //  $videoLinks_main = Videolink::where('part_id', $partsDetail->id)->latest('id')->first();
    //  $videoLinks_sub_1 = Videolink::where('part_id', $partsDetail->id)->latest('id')->skip(1)->first();
    //  $videoLinks_sub_2 = Videolink::where('part_id', $partsDetail->id)->latest('id')->skip(2)->first();
    //  return $videoLinks_sub_2;
    $features = Feature::where('is_delete', 'N')->where('is_active', 1)->get();


    $partfeatures = PartFeature::where('part_id', $id)->get();
    $inquireCount = PartInquire::where('part_id',$partsDetail->id)->count();
    return view('user.product_detail', ['favoriteId'=> $favoriteId,'shipment'=> $shipment, 'partImages' => $partImages, 'inquireCount' => $inquireCount, 'videoLinks' => $videoLinks, 'favoriteCount' => $favoriteCount, 'partsInfo' => $partsInfo, 'partsDetail' => $partsDetail, 'features' => $features, 'partfeatures' => $partfeatures]);
  }
  public function stock()
  {
       $shipment = Shipment::where('is_delete', 'N')->where('is_active', 1)
       ->first();
    $favoriteCount = 0;
    $user = Auth::user();
    if ($user) {
      $favoriteCount = Favorite::where('user_id', $user->id)->count();
    }
    $partsDetail = PartDetails::where('is_delete', 'N')->where('is_active', 1)->where('is_stock',1)
     ->whereHas('make', function ($query) {
     $query->where('is_active', 1);
     })
     ->whereHas('model', function ($query) {
     $query->where('is_active', 1);
     })->paginate(10);
    $featuresByPart = [];
    $partIds = $partsDetail->pluck('id');
    foreach ($partIds as $partId) {
      $features = PartFeature::where('part_id', $partId)->join('features', 'part_features.feature_id', '=', 'features.id')->pluck('features.feature');
      $featuresByPart[$partId] = $features;
    }
    $partImages = PartImage::whereIn('part_id', $partsDetail->pluck('id'))->get()->groupBy('part_id');

    return view('user.stock', ['shipment'=> $shipment, 'featuresByPart' => $featuresByPart, 'partImages' => $partImages, 'partsDetail' => $partsDetail, 'favoriteCount' => $favoriteCount]);
  }
  public function favorites()
  {
    $favoriteCount = 0;
    $user = Auth::user();
    if ($user) {
      $favoriteCount = Favorite::where('user_id', $user->id)->count();
    }
    $favoriteParts = Favorite::where('user_id', $user->id)->get();
    $partIds = $favoriteParts->pluck('part_id')->toArray();
    $partsDetail = PartDetails::whereIn('id', $partIds)->where('is_delete', 'N')->where('is_active', 1)->paginate(10);
     foreach($partsDetail as $part){
       $part['images'] = PartImage::where('part_id',$part->id)->get();
     }
    $featuresByPart = [];
    $partIds = $partsDetail->pluck('id');
    foreach ($partIds as $partId) {
      $features = PartFeature::where('part_id', $partId)->join('features', 'part_features.feature_id', '=', 'features.id')->pluck('features.feature');
      $featuresByPart[$partId] = $features;
    }
    return view('user.favorites', ['featuresByPart' => $featuresByPart, 'favoriteCount' => $favoriteCount, 'partsDetail' => $partsDetail]);
  }
  public function contactStore(Request $request)
  {
    $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'phone' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'message' => 'required',
    ]);
    $user = new ContactUs();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->phone_no = $request->phone;
    $user->message = $request->message;
    $user->save();
    $mailData = [
      'title' => 'Viper Software House',
      'subject' => 'reply',
      'body' => $request->message,
    ];

    $email = Mail::to($user->email)->send(new OrderReceived($mailData));
    return response()->json(['success' => 'Your Message Recieved Successfully!']);
  }
  public function inquireStore(Request $request)
  {

    $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'address' => ['required', 'max:255'],
      'phone' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255'],
    ]);
    $inquire = PartInquire::where('email',$request->email)->where('part_id',$request->part_id)->first();
    if($inquire){
       $request->validate([
       'email' => ['required', 'string', 'email', 'max:255', 'unique:part_inquires']
       ]);
    }
    $user = new PartInquire();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->phone_no = $request->phone;
    $user->country_id = $request->country;
    $user->city_id = $request->city;
    $user->part_id = $request->part_id;
    $user->address = $request->address;
    $user->save();
    return response()->json(['success' => 'Your Message Recieved Successfully!']);
    
  }

  public function getShipmentDetails(Request $request)
  {
    $countryId = $request->input('countryId');
    $shipment = Shipment::where('country_id', $countryId)
      ->where('is_delete', 'N')
      ->where('is_active', 1)
      ->get();
    return response()->json($shipment);
  }
  public function addToFavorite($id)
  {
    $user = Auth::user();
    if ($user) {
      $favorite = Favorite::where('user_id', $user->id)->where('part_id', $id)->first();
      if ($favorite) {
        $favorite->delete();
      } else {
        $favorite = new Favorite();
        $favorite->part_id = $id;
        $favorite->user_id = $user->id;
        $favorite->save();
      }

      $favoriteCount = 0;
      $favoriteCount = Favorite::where('user_id', $user->id)->count();

      return response()->json(['success' => true, 'favoriteCount' => $favoriteCount]);
    }
    return response()->json(['success' => false, 'message' => 'User not authenticated']);
  }
  public function getmodelByMake(Request $request){
     $makeId = $request->input('makeId');
     $models = Mod_el::where('make_id',$makeId)->where('is_delete', 'N')->where('is_active', '1')
     ->whereHas('make', function ($query) {
     $query->where('is_active', 1);
     })->get();
      return response()->json($models);
  }
}
