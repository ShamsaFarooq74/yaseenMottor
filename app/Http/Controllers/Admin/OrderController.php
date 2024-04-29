<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Category;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Models\Make;
use App\Http\Models\Manufacture;
use App\Http\Models\Mod_el;
use App\Http\Models\Modelyear;
use App\Http\Models\Order;
use App\Http\Models\PartInquire;
use App\Http\Models\Country;
use App\Http\Models\City;
use App\Http\Models\Orderitem;
use App\Http\Models\PartDetails;
use App\Http\Models\PartImage;
use App\Http\Models\Configuration;
use App\Http\Models\Parts;
use App\Http\Models\PartMake;
use App\Http\Models\Payment;
use App\Http\Models\Notification;
use App\Http\Models\Paymentmethod;
use App\Http\Models\ProductAttachment;
use App\Http\Models\ProductCategory;
use App\Http\Models\Products;
use App\Http\Models\UserRequirement;
use App\Http\Models\UserDevice;
use App\User;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Models\Client_company;
use App\Http\Models\Assets;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\Admin\TrackingController;

class OrderController extends Controller
{

    public function __construct()
    {
        date_default_timezone_set("Asia/Karachi");

    }
    // public function Orders()
    // {
    //     $products = PartDetails::latest()->where('is_delete', 0)->take(5)->get();
    //     for ($i = 0; $i < count($products); $i++) {
    //         $manufacturer = Manufacture::where('id', $products[$i]->manufacturer)->first();
    //         if($manufacturer){
    //         $products[$i]['manufactureName'] = $manufacturer->manufacture;
    //         $products[$i]['manufactureImage'] = getImageUrl($manufacturer->image, 'manufacture');
    //         }
    //         $category = ProductCategory::where('id', $products[$i]['cat_id'])->first();
    //         $products[$i]['category'] = $category['category'];
    //         if (empty($category['image'])) {
    //             $category['image'] = 'xyz';
    //         }
    //         $file = public_path() . '/images/settings/' . $category['image'];
    //         if (!empty($category['image']) && file_exists($file)) {
    //             $products[$i]['categoryImage'] = getImageUrl($category['image'], 'settings');
    //         } else {
    //             $products[$i]['categoryImage'] = getImageUrl('parts.png', 'partss');
    //         }
    //         $makeID = PartMake::where('part_id',$products[$i]->id)->pluck('make_id');
    //         $make = Make::whereIn('id', $makeID)->select('make','logo')->get();
    //         $makeNames = array();
    //         foreach($make as $makes){
    //             $makes['make'] = $makes->make;
    //             if (empty($makes['logo'])) {
    //                 $makes['logo'] = 'xyz';
    //             }
    //             $file = public_path() . '/images/settings/' . $makes['logo'];
    //             if (!empty($makes['logo']) && file_exists($file)) {
    //                 $makes['logo'] = getImageUrl($makes['logo'], 'settings');
    //             } else {
    //                 $makes['logo'] = getImageUrl('parts.png', 'partss');
    //             }
    //             array_push($makeNames,$makes);
    //         }
    //         $products[$i]['make'] = $makeNames;
    //         // $make = Make::where('id', $products[$i]['make_id'])->first();
    //         // $products[$i]['make'] = $make['make'];
    //         // if (empty($make['logo'])) {
    //         //     $make['logo'] = 'xyz';
    //         // }
    //         // $file = public_path() . '/images/settings/' . $make['logo'];
    //         // if (!empty($make['logo']) && file_exists($file)) {
    //         //     $products[$i]['makeImage'] = getImageUrl($make['logo'], 'settings');
    //         // } else {
    //         //     $products[$i]['makeImage'] = getImageUrl('parts.png', 'partss');
    //         // }
    //         if (Modelyear::where('part_id', $products[$i]['id'])->exists()) {
    //             $products[$i]['model'] = Modelyear::where('part_id', $products[$i]['id'])->get();
    //             // dd($products[$i]['model']);
    //             for ($k = 0; $k < count($products[$i]['model']); $k++) {
    //                 $products[$i]['model'][$k]['model'] = Mod_el::where('id', $products[$i]['model'][$k]['model_id'])->first(['model_name']);
    //                 // return $products[$i]['model'][$k]['model'];
    //             }
    //         } else {
    //             $products[$i]['model'] = [];
    //         }
    //         if (PartImage::where('part_id', $products[$i]['id'])->exists()) {
    //             $products[$i]['images'] = PartImage::where('part_id', $products[$i]['id'])->get();
    //             for ($l = 0; $l < count($products[$i]['images']); $l++) {
    //                 $file = public_path() . '/images/parts/' . $products[$i]['images'][$l]['image'];
    //                 if (!empty($products[$i]['images'][$l]['image']) && file_exists($file)) {
    //                     $products[$i]['images'][$l]['image'] = getImageUrl($products[$i]['images'][$l]['image'], 'parts');
    //                 } else {
    //                     $products[$i]['images'][$l]['image'] = getImageUrl('parts.png', 'partss');
    //                 }
    //             }

    //         }
    //     }
    //     $pendingOrder = Order::where('status', 'pending')->where('is_delete', 0)->orderBy('created_at', 'DESC')->paginate(10, ["*"], "pending_order");
    //     // return $pendingOrder;
    //     for ($i = 0; $i < count($pendingOrder); $i++) {
    //         $pendingOrder[$i]['username'] = User::where('id', $pendingOrder[$i]['user_id'])->first()['username'];
    //         $totalAmount = Order::select('total_amount')->where('id',$pendingOrder[$i]['id'])->first();
    //         if(!empty($totalAmount->total_amount) || ($totalAmount->total_amount != null) )
    //         {
    //             $pendingOrder[$i]['total_amount'] = $totalAmount->total_amount;
    //         }
    //         else
    //         {
    //             $pendingOrder[$i]['total_amount'] = 0;
    //         }
    //         $pendingOrder[$i]['orderDate'] = date('Y-m-d', strtotime($pendingOrder[$i]['created_at']));
    //     }
    //     // return $pendingOrder[$i]['total_amount'];
    //     $approvedOrder = Order::where('status', 'accepted')->where('is_delete', 0)->orderBy('created_at', 'DESC')->paginate(10, ["*"], "approved_order");
    //     // return $approvedOrder;
    //     for ($i = 0; $i < count($approvedOrder); $i++) {
    //         $approvedOrder[$i]['username'] = User::where('id', $approvedOrder[$i]['user_id'])->first()['username'];
    //         // $approvedOrder[$i]['quantity'] = Orderitem::where('order_id', $approvedOrder[$i]['id'])->first()['quantity'];
    //         $delta = Order::select('total_amount')->where('id',$approvedOrder[$i]['id'])->first();
    //         if(!empty($delta->total_amount) || ($delta->total_amount != null))
    //         {
    //             $approvedOrder[$i]['total_amount'] = $delta->total_amount;
    //         }
    //         else
    //         {
    //             $approvedOrder[$i]['total_amount'] = 0;
    //         }
    //         $approvedOrder[$i]['orderDate'] = date_format($approvedOrder[$i]['created_at'],"Y-m-d");
    //     }

    //     $dispatchOrder = Order::where('status', 'dispatched')->where('is_delete', 0)->orderBy('created_at', 'DESC')->paginate(10, ["*"], "delivered_order");
    //     for ($i = 0; $i < count($dispatchOrder); $i++) {
    //         $dispatchOrder[$i]['username'] = User::where('id', $dispatchOrder[$i]['user_id'])->first()['username'];
    //         // $approvedOrder[$i]['quantity'] = Orderitem::where('order_id', $approvedOrder[$i]['id'])->first()['quantity'];
    //         $delta = Order::select('total_amount')->where('id',$dispatchOrder[$i]['id'])->first();
    //         if(!empty($delta->total_amount) || ($delta->total_amount != null))
    //         {
    //             $dispatchOrder[$i]['total_amount'] = $delta->total_amount;
    //         }
    //         else
    //         {
    //             $dispatchOrder[$i]['total_amount'] = 0;
    //         }
    //         $dispatchOrder[$i]['orderDate'] = date_format($dispatchOrder[$i]['created_at'],"Y-m-d");
    //     }
    //     $cancelOrder = Order::where('status', 'cancel')->where('is_delete', 0)->orderBy('created_at', 'DESC')->paginate(10, ["*"], "cancel_order");
    //     for ($i = 0; $i < count($cancelOrder); $i++) {
    //         $cancelOrder[$i]['username'] = User::where('id', $cancelOrder[$i]['user_id'])->first()['username'];
    //         // $approvedOrder[$i]['quantity'] = Orderitem::where('order_id', $approvedOrder[$i]['id'])->first()['quantity'];
    //         $delta = Order::select('total_amount')->where('id',$cancelOrder[$i]['id'])->first();
    //         if(!empty($delta->total_amount) || ($delta->total_amount != null))
    //         {
    //             $cancelOrder[$i]['total_amount'] = $delta->total_amount;
    //         }
    //         else
    //         {
    //             $cancelOrder[$i]['total_amount'] = 0;
    //         }
    //         $cancelOrder[$i]['orderDate'] = date_format($cancelOrder[$i]['created_at'],"Y-m-d");
    //     }
    //     $pendingCustomers = User::where('role',2)->where('is_approved','N')->where('is_deleted','N')->count();
    //     $approvedCustomers = User::where('role',2)->where('is_approved','Y')->where('is_deleted','N')->count();
    //     $totalParts = Parts::where('is_delete',0)->where('is_active',1)->count();
    //     $todayOrders = Order::where('is_delete',0)->whereDate('created_at',date('Y-m-d'))->count();
    //     $totalDevices = UserDevice::where('status','A')->count();
    //     $data =
    //         [
    //             'parts' => $products,
    //             'pendingOrders' => $pendingOrder,
    //             'approvedOrders' => $approvedOrder,
    //             'dispatchOrders' => $dispatchOrder,
    //             'cancelOrders' => $cancelOrder,
    //             'pendingCustomers' => $pendingCustomers,
    //             'approvedCustomers' => $approvedCustomers,
    //             'totalParts' => $totalParts,
    //             'todayOrders' => $todayOrders,
    //             'totalDevices' => $totalDevices

    //         ];
    //         // return $data;

    //     return view('admin.order.order_list', $data); 
    // }
    
    public function Orders(){
    $inquires = PartInquire::where('is_active',1)->where('is_delete', 'N')->get();
    // $Country = Country::where('id',$inquires->country_id)->where('is_active',1)->where('is_delete', 'N')->get();
    // $city = City::where('id',$inquires->city_id)->where('is_active',1)->where('is_delete', 'N')->get();
   
     $data =
            [
                'inquires' => $inquires,
                // 'cities'=> $city,
                // 'country' =>$Country,
            ];
      return view('admin.order.order_list',$data);
    }



    function todayOrder(){

        $todayOrders = Order::whereDate('created_at', Date('Y-m-d'))->where('is_delete', 0)->orderBy('created_at', 'DESC')->paginate(10, ["*"], "pending_order");
        for ($i = 0; $i < count($todayOrders); $i++) {
            $todayOrders[$i]['username'] = User::where('id', $todayOrders[$i]['user_id'])->first()['username'];
            $totalAmount = Order::select('total_amount')->where('id',$todayOrders[$i]['id'])->first();
            if(!empty($totalAmount->total_amount) || ($totalAmount->total_amount != null) )
            {
                $todayOrders[$i]['total_amount'] = $totalAmount->total_amount;
            }
            else
            {
                $todayOrders[$i]['total_amount'] = 0;
            }
            $todayOrders[$i]['orderDate'] = date('Y-m-d', strtotime($todayOrders[$i]['created_at']));
        }
        $todayOrdersss= Order::where('is_delete',0)->whereDate('created_at',date('Y-m-d'))->count();
        $data =
            [
                'approvedOrders' => $todayOrders,
            ];
        return view('admin.order.today_order', $data);
    }
    public function Paystatus(Request $request)
    {
        $Getpayid = Payment::where('id',$request->id)->first();
        if($Getpayid){

//            if($Getpayid->status == "clear")
//            {
                $Getpayid->status = $request->status;
                $Getpayid->save();
                $getOrderId = Order::where('pay_id',$Getpayid->id)->first();
            if($Getpayid){
                $notification = new Notification();
                $notification->user_id = $Getpayid->user_id;
                $notification->product_id = $getOrderId->id;
                $notification->schedule_date = date('Y-m-d H:i:s');
                $notification->is_msg_app = 'Y';
                $notification->is_notification_required = 'Y';
                $notification->notification_type = 'Payment';
                $notification->title = 'Payment Status';
                if($Getpayid->status == "clear") {
                    $notification->description = 'Your Payment against this Order ID # ' . $getOrderId->id . ' is Approved' ;
                }
                elseif($Getpayid->status == "cancel"){
                    $notification->description = 'Your Payment against this Order ID # ' . $getOrderId->id . ' is Rejected' ;
                }
                $notification->save();
                $notification_controller = new NotificationController;
                $notification_controller->send_comm_app_notification();
            }
                return ['status' => true];

//            }
//            if($Getpayid->status == "cancel"){
//                $Getpayid->status = $request->status;
//                $Getpayid->save();
//                return ['status' => true];
//
//            }
        }

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
    public function cancelOrder(Request $request)
    {
        $order = Order::where('id', $request->id)->where('is_delete', 0)->first();
        $order->status = "cancel";
        $result = $order->save();
        if($result){
            $notification = new Notification();
            $notification->user_id = $order->user_id;
            $notification->product_id = $order->id;
            $notification->schedule_date = date('Y-m-d H:i:s');
            $notification->is_msg_app = 'Y';
            $notification->is_notification_required = 'Y';
            $notification->notification_type = 'Order';
            $notification->title = 'Order Cancelled';
            $notification->description = 'Sorry! Your Order against this Order ID # '.$order->id .' has been Cancelled';
            $notification->save();
            $notification_controller = new NotificationController;
            $notification_controller->send_comm_app_notification();
        }
        return ['status' => $result];
    }
    public function dispatchOrder(Request $request)
    {
        $order = Order::where('id', $request->id)->where('is_delete', 0)->first();
        $order->status = "dispatched";
        $result = $order->save();
        if($result){
            $notification = new Notification();
            $notification->user_id = $order->user_id;
            $notification->product_id = $order->id;
            $notification->schedule_date = date('Y-m-d H:i:s');
            $notification->is_msg_app = 'Y';
            $notification->is_notification_required = 'Y';
            $notification->notification_type = 'Order';
            $notification->title = 'Order Dispatched';
            $notification->description = 'Congratulations! Your Order against this Order ID # '.$order->id .' has been Dispatched';
            $notification->save();
            $notification_controller = new NotificationController;
            $notification_controller->send_comm_app_notification();
        }
        return ['status' => $result];
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
    public function orderDetail(Request $req){
        $orderInfo =  Order::where('id',$req->id)->first();
        $payDetail = Payment::where('id',$orderInfo->pay_id)->first();
        if($payDetail) {
            $payMethod = Paymentmethod::where('id', $payDetail->paymethod_id)->first();
            $payDetail['paymethod'] = $payMethod->method;
        }
        else
        {
            $payDetail['paymethod'] = "N/A";
            $payDetail['status'] = "Pending";
            $payDetail['id'] = 0;
        }

        $partId = Orderitem::select('quantity','part_id','dispatched_quantity','part_price','discount_per')->where('order_id',$req->id)->get();
        // return $partId;
        foreach($partId as $key => $part_Id)
        {
            $partsDetail= Parts::where('id',$part_Id->part_id)->first();
            $part_Id['ref_no']=$partsDetail['ref_no'];
            $part_Id['price']=$partsDetail['price'];
            $part_Id['category'] = ProductCategory::where('id',$partsDetail['cat_id'])->first()['category'];
        }
        $discountAmount = 0;
        $manufactureArray = [];
        $Manufacturer = Orderitem::where('order_id',$req->id)->select('part_id','quantity','dispatched_quantity','discount_per','part_price')->get();
        $checkOrderStatus = Order::where('id',$req->id)->select('status')->first();
        foreach($Manufacturer as $part){
            $partManufacturer = Parts::where('id',$part->part_id)->first()['manufacturer'];
            $part['discount_per'] = $part->discount_per;
            $part['manufacturer_name'] = Manufacture::where('id',$partManufacturer)->first()['manufacture'];
            array_push($manufactureArray,['manufacture_name'=>$part['manufacturer_name'], 'discount_per'=>$part['discount_per']]);
            $part['discount_amount'] = $checkOrderStatus->status == 'dispatched' ? round((($part['discount_per']/100) * $part->part_price) * $part->dispatched_quantity) : round((($part['discount_per']/100) * $part->part_price) * $part->quantity);
            $discountAmount+=$part['discount_amount'];
        }
        $discountManufacture = []; 
        $input = array_map("unserialize", array_unique(array_map("serialize", $manufactureArray)));
        $manufactureArray = array_values($input);
        foreach($manufactureArray as $key11=> $manufacture_name){
            $sumPartPrice = 0;
            foreach ($Manufacturer as $object) {
                // return [$manufacture_name,$object];
                if($manufacture_name['manufacture_name'] == $object->manufacturer_name ){
                        $sumPartPrice += $object->discount_amount; 
                        $discountPer = $object->discount_per;
                }
            }
            array_push($discountManufacture, ["manufacture_name" => $manufacture_name['manufacture_name'] , "Discounted_amount"=> $sumPartPrice  ,"discount_per" => $manufacture_name['discount_per']]);
        }

        $data =
                [
                'totalDiscount' => round($discountAmount),
                'orderCalculation' =>$discountManufacture,
                'orderInformation' => $orderInfo,
                'OrderDetail' => $partId,
                'paymentDetail' => $payDetail
                ];
        // return $data;
        return view('admin.order.order_detail', $data);
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
    public function editOrderDetail(Request $req){
        $orderInfo =  Order::where('id',$req->id)->first();
        $payDetail = Payment::where('id',$orderInfo->pay_id)->first();
        if($payDetail) {
            $payMethod = Paymentmethod::where('id', $payDetail->paymethod_id)->first();
            $payDetail['paymethod'] = $payMethod->method;
        }
        else
        {
            $payDetail['paymethod'] = "N/A";
            $payDetail['status'] = "Pending";
            $payDetail['id'] = 0;
        }

        $partId = Orderitem::select('quantity','part_id')->where('order_id',$req->id)->get();
        // return $partId;
        foreach($partId as $key => $part_Id)
        {
            $partsDetail= Parts::where('id',$part_Id->part_id)->first();
            $part_Id['ref_no']=$partsDetail['ref_no'];
            $part_Id['price']=$partsDetail['price'];
            $part_Id['category'] = ProductCategory::where('id',$partsDetail['cat_id'])->first()['category'];
        }
        $data =
                [
                'orderInformation' => $orderInfo,
                'OrderDetail' => $partId,
                'paymentDetail' => $payDetail 
                ];
        // return $data;
        return view('admin.order.edit_order_detail', $data);
    }
    public function updateOrderDetail(Request $request){
        // return $request->all();
        $Netamount= 0;
        $partId = Orderitem::where('order_id',$request->orderId)->get();
        $order = Order::where('id', $request->orderId)->where('is_delete', 0)->first();
        $gst = Configuration::select('value')->where('key', 'gst')->first();
        foreach($partId as $part){
            $id = $part->part_id;
            $part->dispatched_quantity = (int)$request->$id;
            $part->update();

            //update prices
            $getPrice = Parts::select('price')->where('id', $part->part_id)->first();
            $AfterDiscount = $getPrice->price * $part->dispatched_quantity;
            $Addgst = $AfterDiscount * $gst->value/100;
            $Netamount+= $AfterDiscount + $Addgst;
        }

        $discountper = $order->discount_per/100 * $Netamount;
        $order->discount_amount = $discountper;
        $order->total_amount = round($Netamount - $discountper);
        $order->update();
        // return $order;

        return redirect()->back();
    }
    function updatePartsPrices(){
        $partId = Orderitem::all();
        foreach($partId as $part){
            if(Parts::where('id',$part->part_id)->exists()){
                $part->part_price = Parts::where('id',$part->part_id)->first()['price'];
                $part->update();  
            }
            else{
                Parts::where('id',$part->part_id)->first();
            }
           }
           return "Updated";
    }

}
