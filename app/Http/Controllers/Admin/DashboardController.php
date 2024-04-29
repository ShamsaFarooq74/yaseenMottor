<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Category;
use App\Http\Models\Make;
use App\Http\Models\Manufacture;
use App\Http\Models\Mod_el;
use App\Http\Models\Modelyear;
use App\Http\Models\Order;
use App\Http\Models\Orderitem;
use App\Http\Models\PartDetails;
use App\Http\Models\PartImage;
use App\Http\Models\Parts;
use App\Http\Models\ProductAttachment;
use App\Http\Models\ProductCategory;
use App\Http\Models\Products;
use App\Http\Models\UserRequirement;
use App\Http\Models\UserDevice;
use App\Http\Models\PartMake;
use App\User;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Models\Assets;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\Admin\TrackingController;

class DashboardController extends Controller
{

    public function dashboard()
    {
        $Categories = ProductCategory::where('is_deleted','N')->pluck('id');
        $products = PartDetails::latest()->where('is_delete','N')->where('is_active', 1)->take(5)->get();
        for ($i = 0; $i < count($products); $i++) {
            $manufacturer = Manufacture::where('id', $products[$i]->manufacturer)->first();
            if($manufacturer){
            $products[$i]['manufactureName'] = $manufacturer->manufacture;
            $products[$i]['manufactureImage'] = getImageUrl($manufacturer->image, 'manufacture');
            }
            $category = ProductCategory::where('id', $products[$i]['cat_id'])->where('is_deleted','N')->first();
            if($category && $category['category']){
            $products[$i]['category'] = $category['category'];
            }
            if (empty($category['image'])) {
                $category['image'] = 'xyz';
            }
            $file = public_path() . '/images/settings/' . $category['image'];
            if (!empty($category['image']) && file_exists($file)) {
                $products[$i]['categoryImage'] = getImageUrl($category['image'], 'settings');
            } else {
                $products[$i]['categoryImage'] = getImageUrl('parts.png', 'partss');
            }
            // $makeID = PartMake::where('part_id',$products[$i]['id'])->pluck('make_id');
            // $make = Make::whereIn('id', $makeID)->select('make')->get();
            // $makeNames = array();
            // foreach($make as $makes){
            //     $allMakes = $makes['make'];
            //     array_push($makeNames,$allMakes);
            // }
            // $products[$i]['make'] = $makeNames;
            if (Modelyear::where('part_id', $products[$i]['id'])->exists()) {
                $products[$i]['model'] = Modelyear::where('part_id', $products[$i]['id'])->get();
                // dd($products[$i]['model']);
                for ($k = 0; $k < count($products[$i]['model']); $k++) {
                    $products[$i]['model'][$k]['model'] = Mod_el::where('id', $products[$i]['model'][$k]['model_id'])->first(['model_name']);
                    // return $products[$i]['model'][$k]['model'];
                }
            } else {
                $products[$i]['model'] = [];
            }
            if (PartImage::where('part_id', $products[$i]['id'])->exists()) {
                $products[$i]['images'] = PartImage::where('part_id', $products[$i]['id'])->get();
                for ($l = 0; $l < count($products[$i]['images']); $l++) {
                    $file = public_path() . '/images/parts/' . $products[$i]['images'][$l]['image'];
                    if (!empty($products[$i]['images'][$l]['image']) && file_exists($file)) {
                        $products[$i]['images'][$l]['image'] = getImageUrl($products[$i]['images'][$l]['image'], 'parts');
                    } else {
                        $products[$i]['images'][$l]['image'] = getImageUrl('parts.png', 'partss');
                    }
                }

            }
        }
//        $pendingOrder = Order::where('status', 'pending')->where('is_delete', 0)->paginate(10, ["*"], "pending_order");
//        for ($i = 0; $i < count($pendingOrder); $i++) {
//            $pendingOrder[$i]['username'] = User::where('id', $pendingOrder[$i]['user_id'])->first()['username'];
//            // return $pendingOrder[$i]['username'];
//
//            $deltaa = Orderitem::where('order_id', $pendingOrder[$i]['id'])->first();
//            if($deltaa)
//            {
//                $pendingOrder[$i]['quantity'] = $deltaa->quantity;
//            }
//            else
//            {
//                $pendingOrder[$i]['quantity'] = 0;
//            }
//            $pendingOrder[$i]['orderDate'] = date('Y-m-d', strtotime($pendingOrder[$i]['created_at']));
//        }


        $totalInquires = DB::table('part_inquires')->count();
        $approvedCustomers = User::where('role',2)->where('is_deleted','N')->count();
        $totalParts = Parts::where('is_delete','N')->where('is_active',1)->count();
        $totalMake = Make::where('is_active',1)->where('is_delete','N')->count();
        $carInStock = Parts::where('is_stock',1)->where('is_delete','N')->where('is_active',1)->count();
        $data =
            [
                'parts' => $products,
                'totalInquires' => $totalInquires,
                'approvedCustomers' => $approvedCustomers,
                'totalParts' => $totalParts,
                'totalMake' => $totalMake,
                'carInStock' => $carInStock

            ];
        return view('admin.dashboard', $data);
    }

    public function approveLeads(Request $request)
    {
        if (Auth::user()->role != '1') {

            return redirect('/home');

        }

        $id = $request->id;

        $user = Leads::findOrFail($id);
        if ($user) {
            $user->is_approved = 'Y';
            $user->update();
        }

        if ($user) {

            return ['status' => true];

        } else {

            return ['status' => false];

        }
    }

    public function deleteLeads(Request $request)
    {
        if (Auth::user()->role != '1') {

            return redirect('/home');

        }

        $id = $request->id;

        $user = Leads::findOrFail($id);
        if ($user) {
            $user->is_deleted = 'Y';
            $user->update();
        }

        if ($user) {

            return ['status' => true];

        } else {

            return ['status' => false];

        }
    }

    public function deletePendingProducts(Request $request)
    {
        if (Auth::user()->role != '1') {

            return redirect('/home');

        }

        $id = $request->id;

        $user = Products::findOrFail($id);
        if ($user) {
            $user->is_deleted = 'Y';
            $user->update();
        }

        if ($user) {

            return ['status' => true];

        } else {

            return ['status' => false];

        }
    }

    public function searchLeads(Request $request)
    {
        if ($request->type == 'active') {
            $activeProducts = Leads::where('is_approved', 'Y')->where('is_deleted', 'N')->orderBy('id', 'DESC')->get();
            if ($activeProducts) {
                for ($i = 0; $i < count($activeProducts); $i++) {
                    $date = date('Y-m-d', strtotime($activeProducts[$i]['created_at']));
                    $activeProducts[$i]['buyerName'] = User::where('id', $activeProducts[$i]->created_by)->first()['username'];
                    $activeProducts[$i]['date'] = $date;
                    $activeProducts[$i]['product'] = Products::where('id', 'LIKE', '%' . $request->value)->where('is_deleted', 'N')->first();
                    if ($activeProducts[$i]['product']) {
                        $activeProducts[$i]['unit'] = Unit::where('id', $activeProducts[$i]['product']->unit)->where('status', 'active')->first()['unit'];
                        $activeProducts[$i]['currency'] = Currency::first()['currency'];
                    }
                }
                return ['status' => true, 'data' => $activeProducts];
            }
        } else if ($request->type == 'pending') {
            $activeProducts = Leads::where('is_approved', 'N')->where('is_deleted', 'N')->orderBy('id', 'DESC')->get();
            if ($activeProducts) {
                for ($i = 0; $i < count($activeProducts); $i++) {
                    $date = date('Y-m-d', strtotime($activeProducts[$i]['created_at']));
                    $activeProducts[$i]['buyerName'] = User::where('id', $activeProducts[$i]->created_by)->first()['username'];
                    $activeProducts[$i]['date'] = $date;
                    $activeProducts[$i]['product'] = Products::where('id', 'LIKE', '%' . $request->value)->where('is_deleted', 'N')->first();
                    if ($activeProducts[$i]['product']) {
                        $activeProducts[$i]['unit'] = Unit::where('id', $activeProducts[$i]['product']->unit)->where('status', 'active')->first()['unit'];
                        $activeProducts[$i]['currency'] = Currency::first()['currency'];
                    }
                }
                return ['status' => true, 'data' => $activeProducts];
            }
        }
        return ['status' => false];

    }

}