<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Models\Ads;
use App\Http\Models\Category;
use App\Http\Models\Company;
use App\Http\Models\Configuration;
use App\Http\Models\Make;
use App\Http\Models\PartMake;
use App\Http\Models\Manufacture;
use App\Http\Models\TrendingParts;
use App\Http\Models\Order;
use App\Http\Models\Orderitem;
use App\Http\Models\Modelyear;
use App\Http\Models\Mod_el;
use App\Http\Models\Outlet;
use App\Http\Models\PartImage;
use App\Http\Models\Parts;
use App\Http\Models\ProductCategory;
use App\Http\Models\UserDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ResponseController as ResponseController;
use Illuminate\Support\Facades\Hash;

use Validator;
use DB;
use Session;
use App\User;


class DashboardDataController extends ResponseController
{
    public function Dashboard(Request $req)
    {

        $user = User::select('id', 'discount', 'username', 'phone', 'image', 'location', 'is_active', 'is_approved', 'is_deleted')->where('phone', Auth::user()->phone)->first();
        $user['total_order'] = Order::where('user_id', $user->id)->count();
        $getcompanyName = Company::where('user_id', $user->id)->first();
        if ($getcompanyName) {
            $user['company_name'] = $getcompanyName->name;
        } else {
            $user['company_name'] = " ";
        }

        if ($user->is_approved == 'Y') {
            $latestAdded = Parts::latest()->where('is_active', 1)->where('is_delete', 0)->take(5)->get();
            for ($i = 0; $i < count($latestAdded); $i++) {
                $manufacturer = Manufacture::where('id', $latestAdded[$i]->manufacturer)->where('is_active', 'Y')->where('is_deleted', 'N')->first();
                if ($manufacturer && $manufacturer->manufacture) {
                    $latestAdded[$i]['manufactureName'] = $manufacturer->manufacture;
                }
                if ($manufacturer && $manufacturer->image) {
                    $latestAdded[$i]['manufactureImage'] = getImageUrl($manufacturer->image, 'manufacture');
                } else {
                    $latestAdded[$i]['manufactureImage'] = getImageUrl('manufacture.png', 'default-images');
                }
                $category = ProductCategory::where('id', $latestAdded[$i]['cat_id'])->where('is_deleted', 'N')->first();
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
//                $make = Make::where('id', $latestAdded[$i]['make_id'])->where('is_active', 1)->where('is_delete', 0)->first();
                $makeID = PartMake::where('part_id',$latestAdded[$i]['id'])->first()['make_id'];
                $make = Make::where('id', $makeID)->select('make','logo')->first();
                if($make && $make['make']){
                    $latestAdded[$i]['make'] = $make['make'] ? $make['make'] : 0;
                }
                if (empty($make['logo'])) {
                    $make['logo'] = 'xyz';
                }
                $file = public_path() . '/images/settings/' . $make['logo'];
                if (!empty($make['logo']) && file_exists($file)) {
                    $latestAdded[$i]['makeImage'] = getImageUrl($make['logo'], 'settings');
                } else {
                    $latestAdded[$i]['makeImage'] = getImageUrl('parts.png', 'partss');
                }
                if (PartImage::where('part_id', $latestAdded[$i]['id'])->exists()) {
                    $latestAdded[$i]['image'] = PartImage::where('part_id', $latestAdded[$i]['id'])->first()['image'];
                    $file = public_path() . '/images/parts/' . $latestAdded[$i]['image'];
                    if (!empty($latestAdded[$i]['image']) && file_exists($file)) {
                        $latestAdded[$i]['image'] = getImageUrl($latestAdded[$i]['image'], 'parts');
                    } else {
                        $latestAdded[$i]['image'] = getImageUrl('parts.png', 'partss');
                    }

                } else {
                    $latestAdded[$i]['image'] = getImageUrl('parts.png', 'partss');
                }

                $Modelid = Modelyear::where('part_id',$latestAdded[$i]['id'])->first();
                if($Modelid){
                    $modelDetail = Mod_el::where('id',$Modelid->model_id)->first();
                    $latestAdded[$i]['model_name'] = $modelDetail->model_name;
                }else{
                    $latestAdded[$i]['model_name'] = "N/A";
                }
            }


            $trendingPartsid = TrendingParts::where('is_trending','Y')->where('start_date', '<=', Date("Y-m-d"))->where('end_date', '>=', Date("Y-m-d"))->pluck('part_id')->sortBy('created_at');
            $topTrending = Parts::whereIn('id', $trendingPartsid)->where('is_delete', 0)->where('is_active', 1)->get();
            for ($i = 0; $i < count($topTrending); $i++) {

                if ($topTrending[$i]['image'] == null) {
                    $topTrending[$i]['image'] = getImageUrl('parts.png', 'partss');
                } else {
                    $topTrending[$i]['image'] = getImageUrl($topTrending[$i]['image'], 'partss');
                }
                $trendingPartDetail= TrendingParts::where('part_id', $topTrending[$i]->id)->first();
                $topTrending[$i]['start_date'] = $trendingPartDetail->start_date;
                $topTrending[$i]['end_date'] = $trendingPartDetail->end_date;
                $manufacturer = Manufacture::where('id', $topTrending[$i]->manufacturer)->first();
                if ($manufacturer) {
                    $topTrending[$i]['manufactureName'] = $manufacturer->manufacture;
                }
                if ($manufacturer && $manufacturer->image) {
                    $topTrending[$i]['manufactureImage'] = getImageUrl($manufacturer->image, 'manufacture');
                } else {
                    $topTrending[$i]['manufactureImage'] = getImageUrl('manufacture.png', 'manufacture');
                }
                $category = ProductCategory::where('id', $topTrending[$i]['cat_id'])->where('is_deleted', 'N')->first();
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
//                $make = Make::where('id', $topTrending[$i]['make_id'])->where('is_active', 1)->where('is_delete', 0)->first();
                $makeID = PartMake::where('part_id',$topTrending[$i]['id'])->first()['make_id'];
                $make = Make::where('id', $makeID)->select('make','logo')->first();
                if ($make && $make['make']) {
                    $topTrending[$i]['make'] = $make['make'];
                }
                if (empty($make['logo'])) {
                    $make['logo'] = 'xyz';
                }
                $file = public_path() . '/images/settings/' . $make['logo'];
                if (!empty($make['logo']) && file_exists($file)) {
                    $topTrending[$i]['makeImage'] = getImageUrl($make['logo'], 'settings');
                } else {
                    $topTrending[$i]['makeImage'] = getImageUrl('parts.png', 'partss');
                }

                if (PartImage::where('part_id', $topTrending[$i]['id'])->exists()) {
                    $topTrending[$i]['image'] = PartImage::where('part_id', $topTrending[$i]['id'])->first()['image'];

                    $file = public_path() . '/images/parts/' . $topTrending[$i]['image'];
                    if (!empty($topTrending[$i]['image']) && file_exists($file)) {
                        $topTrending[$i]['image'] = getImageUrl($topTrending[$i]['image'], 'parts');
                    } else {
                        $topTrending[$i]['image'] = getImageUrl('parts.png', 'partss');
                    }
                }
                $Modelid = Modelyear::where('part_id',$topTrending[$i]['id'])->first();
                if($Modelid){
                    $modelDetail = Mod_el::where('id',$Modelid->model_id)->first();
                    $topTrending[$i]['model_name'] = $modelDetail->model_name;
                }else{
                    $topTrending[$i]['model_name'] = "N/A";
                }
            }
            $fromYear = Configuration::where('key', 'from_year')->first();
            $gst = Configuration::where('key', 'gst')->first();

            $make = Make::where('is_delete', 0)->where('is_active', 1)->get();
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
            $category = ProductCategory::where('is_deleted', 'N')->get();
            for ($i = 0; $i < count($category); $i++) {
                if (empty($category[$i]['image'])) {
                    $category[$i]['image'] = 'xyz';
                }
                $file = public_path() . '/images/settings/' . $category[$i]['image'];
                if (!empty($category[$i]['image']) && file_exists($file)) {
                    $category[$i]['image'] = getImageUrl($category[$i]['image'], 'settings');
                } else {
                    $category[$i]['image'] = getImageUrl('parts.png', 'partss');
                }
            }
            $ads = Ads::where('is_deleted', 'N')->get();
            for ($i = 0; $i < count($ads); $i++) {
                if (empty($ads[$i]['image'])) {
                    $ads[$i]['image'] = 'xyz';
                }
                $file = public_path() . '/ads/' . $ads[$i]['image'];
                if (!empty($ads[$i]['image']) && file_exists($file)) {
                    $ads[$i]['image'] = getImageUrl($ads[$i]['image'], 'ads');
                } else {
                    $ads[$i]['image'] = '';
                }
            }
            $data = [ 'latestAddedParts' => $latestAdded,
                'topTrending' => $topTrending, 'make' => $make, 'category' => $category,  'banner' => $ads];
            return $this->sendResponse(1,'User login successfully.', $data);
        } else {
            $data = Auth::user()->tokens->each(function ($token, $key) {
                $token->delete();
            });
            $default_response = DB::table('responses')->where('response_title', 'not_verified')->first();

            return response()->json(['success' => 0, 'message' => $default_response->response_text]);
        }


    }
    public function outlets(){
        $getOutlets = Outlet::all();
        foreach($getOutlets as $outlet){
            $outlet->image = asset('images/outlet_image/'.$outlet->image);
        }
        return response()->json(['success' => 1, 'data' => $getOutlets]);
    }


}
