<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Admin\CommunicationController;
use App\Http\Controllers\Controller;
use App\Http\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Models\Parts;
use App\Http\Models\ProductCategory;
use App\Http\Models\Manufacturer_Discount;
use App\Http\Models\Manufacture;
use App\Http\Models\payments;
use App\Http\Models\Orderitem;
use App\Http\Models\Configuration;
use App\Http\Models\Setting;
use App\Http\Models\NotificationEmail;
use App\Http\Models\Order;
use App\User;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    function addorder(Request $req)
    {

        $addItems = json_decode($req->items);
//			   return response()->json(['success'=>'1','message'=>"Request Params:  ".$req->items]);
        $data=json_decode(json_encode($addItems->item),true);
        $user=Auth::id();
        $data1=new Order;
        // $totalAmount= 0;
        $Netamount= 0;
        $Discount = 0;
        $totalDiscount=0;
        $data1->user_id=$user;
        $allPartsDiscount = 0;
        // $userDiscount = Auth::user()->discount;
        if($req->pay_id){
            $data1->pay_id=$req->pay_id;
        }
        $data1->save();
        if($data1->save()){
            $finalAmount=array();
            foreach($data as $d)
            {
            $getPrice = Parts::select('price')->where('id', $d['part_id'])->first();
            $getManufacture = Parts::select('manufacturer')->where('id', $d['part_id'])->first();
            $getDiscount = Manufacturer_Discount::select('discount')->where('manufacturer_id',$getManufacture->manufacturer)->where('users_id', $user)->first();
            if(!empty($getDiscount))
            {
                $Discount = $getDiscount->discount;
            }
            $sumitemPrice = $getPrice->price * $d['quantity'];
            $totalAmount =$sumitemPrice;
            $gst = Configuration::select('value')->where('key', 'gst')->first();
            // discount amount
            $CalDiscount = $Discount/100 * $totalAmount;
            // after discount amount is applied
            $AfterDiscount = $totalAmount - $CalDiscount;
            // $AfterDiscount = $totalAmount;
            $Addgst = $AfterDiscount * $gst->value/100;
            $Netamount+= $AfterDiscount + $Addgst;
            $allPartsDiscount+= $CalDiscount;
            $data=new Orderitem;
            $data->order_id=$data1->id;
            $data->quantity=$d['quantity'];
            $data->part_id=$d['part_id'];
            $data->discount_per = $Discount;
            $data->part_price = $getPrice->price;
            $data->save();

            }
            // $discountper = $userDiscount/100 * $Netamount;
            $addAmount=Order::where('id',$data1->id)->first();
            $addAmount->total_amount=$Netamount;
            $addAmount->gst=$gst->value;
            $addAmount->gst_amount=$Addgst;
            $addAmount->discount_per=$Discount;
-            $addAmount->discount_amount=$allPartsDiscount;
            $addAmount->save();
            if($data->save()){
                $userid=Auth::id();
                $OrderID = $data1->id;
                $data1 = Orderitem::select('part_id','quantity','created_at','order_id')->where('order_id',$data1->id)->get();
                if(!is_null($data1)) {
                    $OrderData = "";
                    $totalAmount = 0;

                    foreach ($data1 as $key => $Orderitem) {
                        $orderStatus = Order::where('id', $Orderitem->order_id)->first();
                        $OrderData = $orderStatus['status'];
                        $gst_per = $orderStatus['gst'];
                        $gst_Amount = $orderStatus['gst_amount'];
                        $discount_per = $orderStatus['discount_per'];
                        $discount_Amounts = $orderStatus['discount_amount'];

                        $partsData = Parts::where('id', $Orderitem->part_id)->first();
                        $Orderitem['order_date'] = date("Y-m-d", strtotime($Orderitem->created_at));
                        $Orderitem['ref_no'] = $partsData['ref_no'];
                        $Orderitem['description'] = $partsData['description'];
                        $Orderitem['category'] = ProductCategory::where('id', $partsData->cat_id)->first()['category'];
                        $Orderitem['currency'] = Setting::where('perimeter', 'currency')->first()['value'];
                        $Orderitem['price'] = $partsData['price'];
                        $sumitemPrice = $Orderitem['price'] * $Orderitem['quantity'];
                        $totalAmount += $sumitemPrice;

                    }
                }
                    $compaign_entry_no = NotificationEmail::max('campaign_entry');
                    $setting_comm_email = Setting::where('perimeter', 'communication_email')->first();
                    $noti_email = new NotificationEmail();
                    $noti_email->user_id = Auth::user()->id;
                    $noti_email->to_email = "muhammad.fahad@viiontech.com";
//                    $noti_email->to_email = isset($setting_comm_email) ? $setting_comm_email->value : "muhammad.fahad@viiontech.com";
                    $noti_email->email_subject = "New Order, Order Id #".$OrderID;
                    $noti_email->order_id = $OrderID;
                    $noti_email->email_body = "New Order is placed
                    Order # ".$OrderID."
                    Order Date ". date('Y-m-d H:i:s').
                    "
                    Order Amount PKR".round($addAmount->total_amount).
                    "
                    Order Placed By ".Auth::user()->username;
                    $noti_email->schedule_date = date('Y-m-d H:i:s');
                    $noti_email->email_sent_status = 'N';
                    $noti_email->campaign_entry = isset($compaign_entry_no) ? $compaign_entry_no : '1';
                    $noti_email->save();

                // $notification_controller = new CommunicationController();
                // $notification_controller->send_comm_email();

                return response()->json(['success'=> 1,'message'=>"order added", "Order" => ['detail'=>$data1,'status'=>$OrderData,'gst_amount'=>$gst_Amount,'discount_per'=>$discount_per,'discount_Amounts'=>$discount_Amounts,'total_Item_Price'=>$totalAmount]]);
            }
            else {
            return response()->json(['success'=> 0 ,'error'=>"please place order carefully"]);
            }
        }
    }
    function ongoingorder()
    {
        $Dataarray=[];
        $userid=Auth::id();
        $data=Order::select('id','status')->where('user_id',$userid)->whereIn('status',['pending','accepted'])->get();
        if(! is_null($data))
        {
            foreach($data as $key=>$orderId){

            $OrderAmount =Order::select('id','status','total_amount','pay_id')->where('id',$orderId->id)->first();
            if($OrderAmount->pay_id == null || empty($OrderAmount->pay_id) ){
                $OrderAmount["payment"] = "Add payment";
            }
            elseif ($OrderAmount->pay_id){
                $pay_Status= Payment::where('id',$OrderAmount->pay_id)->first();
                $OrderAmount["payment_Status"] = $pay_Status->status;
                $OrderAmount["payment"]="";
            }
                $OrderAmount['total_amount'] = $OrderAmount->total_amount + $OrderAmount->discount_amount;
             array_push($Dataarray,$OrderAmount);
            }
            if($Dataarray)
            {
                return response()->json(['success'=> 1,'message'=>'Ongoing Orders displayed','data'=>$Dataarray]);
            }
            else {
                return response()->json(['success'=> 1 ,'message'=>'No ongoing orders','data'=>$Dataarray]);
            }
        }


    }

    function ongoingorderdetail(Request $req)
    {
        $data1 = Orderitem::select('part_id')->where('order_id',$req['order_id'])->get();
        if(! is_null($data1))
        {
            $data2 = $data1->map(function ($Orderitem) {
                $Orderitem['parts']=Parts::where('id',$Orderitem->part_id)->get();
                return $Orderitem;
            });
            // return $data1;
            if($data1)
            {
                return response()->json(['success'=> 1 ,'message'=>'Ongoing order detail displayed',$data1]);
            }
            else
            {
                return response()->json(['success'=> 0 ,'message'=>'Ongoing orders details are not avaiable']);
            }
        }

    }
    // function ongoingorderdetail(Request $req)
    // {
    //     $data1 = Orderitem::select('part_id')->where('order_id',$req['order_id'])->get();
    //     if(! is_null($data1))
    //     {
    //         $data2 = $data1->map(function ($Orderitem) {
    //             $Orderitem['parts']=Parts::where('id',$Orderitem->part_id)->get();
    //             return $Orderitem;
    //         });
    //         // return $data1;
    //         if($data2)
    //         {
    //             return response()->json(['success'=>'1','message'=>'Ongoing Orderdetail displayed',$data1]);
    //         }
    //     }
    //     else
    //     {
    //         return response()->json(['success'=>'0','message'=>'No Ongoing Orderdetail']);
    //     }
    // }

    function pastorder(Request $req)
    {
        $Dataarray=[];
        $userid=Auth::id();
        // return $userid;
        $data=Order::select('id')->where('user_id',$userid)->where('status','dispatched')->get();
        // return $data;
        // if(count($data) > 0)
        // {
            // return  $data;
            foreach($data as $key=>$orderId){
                // return $orderId->id;
            // $data1 = Orderitem::select('order_id','part_id')->where('order_id',$orderId->id)->get();
            $OrderAmount =Order::select('id','total_amount')->where('id',$orderId->id)->first();
            // return $OrderAmount;
                // if($OrderAmount){
                array_push($Dataarray,$OrderAmount);
                // }
                // else{
                //    return response()->json(['success'=> 0,'message'=>'No past Orders']);
                // }
            }

            // return $Dataarray;
            if($Dataarray)
            {
                return response()->json(['success'=> 1,'message'=>'Past Orders displayed','data'=>$Dataarray]);
            }
            else {
                return response()->json(['success'=> 1,'message'=>'Past Orders displayed','data'=>$Dataarray]);
            }
        // }

    }
    function pastorderdetail(Request $req)
    {
        $data1 = Orderitem::select('part_id')->where('order_id',$req['order_id'])->get();
        if(! is_null($data1))
        {
            $data2 = $data1->map(function ($Orderitem) {
                $Orderitem['parts']=Parts::where('id',$Orderitem->part_id)->get();
                return $Orderitem;
            });
            // return $data1;
            if($data2)
            {
                return response()->json(['success'=> 1,'message'=>'Past Orderdetail displayed',$data1]);
            }
        }
        else
        {
            return response()->json(['success'=> 0,'message'=>'No past order details avaiable']);
        }
    }
    function cancelorder(Request $req){
        $changestatus=Order::where('id',$req->order_id)->first();
        // return $data;
        $changestatus->status=$req->status;
       $savestatus=$changestatus->save();
        if($savestatus){
            return response()->json(['success'=> 1,'message'=>'order status change successfully']);
        }
        else{
            return response()->json(['success'=> 0 ,'message'=>"order status doesn't change"]);
        }
    }

    // function order(Request $req){

    //     $where=array();

    //     if(($req->get('user_id')) && !($req->get('order')) && !($req->get('orderdetail')))
    //     {
    //     $where['user_id']=$req->user_id;
    //     $data = payments::where('user_id',$where['user_id'])->get();
    //     if($data){
    //         return response()->json(['success'=>'1','message'=>'payments detail display according to user id','data'=>$data]);
    //         }
    //         else{
    //         return response()->json(['success'=>'0','message'=>'No payments detail exist']);
    //         }
    //     }
    //     if(!($req->get('user_id')) && ($req->get('order')) && !($req->get('orderdetail')))
    //     {
    //     $where['user_id']=$req->order;
    //     $data = Orderitem::with('order')->where('id',$where['user_id'])->get();
    //     // $data = order::where('user_id',$where['user_id'])->get();
    //     return $data;
    //     return response()->json(['success'=>'1','message'=>'payments detail display according to user id','data'=>$data]);
    //     }
    //     if(($req->get('user_id')) && ($req->get('order')) && !($req->get('orderdetail')))
    //     {
    //     $where['user_id']=$req->user_id;
    //     $where['order']=$req->order;
    //     $data=Order::select('*')->where('user_id',$where['user_id'])->where('orderdetail_id',$where['order'])->get();
    //     // foreach($data as $d){
    //     //   $all_orders = payments::where('user_id',$d->user_id)->get();
    //     // }
    //     // $data = order::where('user_id',$where['user_id'])->get();
    //     return $data;
    //     return response()->json(['data'=>$data]);
    //     }
    // }
    function order(Request $req){

        // $data1 = Orderitem::where('order_id',$req->order_id)->pluck('part_id');
        // $paydetail = Order::where('id',$req->order_id)->pluck('pay_id');
        // return $data1;
        $userid=Auth::id();
        $data1 = Orderitem::select('part_id','quantity','dispatched_quantity','created_at','order_id')->where('order_id',$req['order_id'])->get();
//         return $data1;
        if(!is_null($data1))
        {
            // $gst= Configuration::select('value')->where('key', 'gst')->first()['value'];
            // $Discount = User::select('discount')->where('id',$req->user()->id)->first()['discount'];
            $OrderData = "";
            $totalAmount =0;
            // $TotalItemPrice = "";
            // $data2 = $data1->map(function ($Orderitem) {
            //    n retur $data1;
                foreach($data1 as $key => $Orderitem)
                {
//                    return "in loop";
                $orderStatus = Order::where('id',$Orderitem->order_id)->first();
                $OrderData = $orderStatus['status'];
                $gst_per = $orderStatus['gst'];
                $gst_Amount = $orderStatus['gst_amount'];
                // $discount_per = $orderStatus['discount_per'];
                // $discount_Amounts = $orderStatus['discount_amount'];
                if($orderStatus->pay_id){
                    $pay_detail = Payment::where('id',$orderStatus->pay_id)->first();
                    if($pay_detail->paymethod_id == 4){
                        if($pay_detail->status){
                            $payment_Status = $pay_detail['status'];
                        }
                    }
                    if($pay_detail->paymethod_id == 3){
                            $payment_Status = "Cash On Delivery";
                    }
                    if($pay_detail->paymethod_id == 5){
                            $payment_Status = "Account Receivable";
                    }

                }
                else{
                    $payment_Status ="N/A";

                }

                $partsData = Parts::where('id',$Orderitem->part_id)->first();
                $Orderitem['order_date']= date("Y-m-d", strtotime($Orderitem->created_at));
                // $Orderitem['status']= $orderStatus['status'];
                $Orderitem['ref_no'] = $partsData['ref_no'];
                $Orderitem['description'] = $partsData['description'];
                $Orderitem['category'] = ProductCategory::where('id',$partsData->cat_id)->first()['category'];
                $Orderitem['currency'] = Setting::where('perimeter','currency')->first()['value'];
                $Orderitem['price'] = $partsData['price'];
                $sumitemPrice=$Orderitem['price']  * $Orderitem['quantity'];
                $totalAmount += $sumitemPrice;
                // return [$sumitemPrice,$Orderitem['price'],$Orderitem['quantity']];
                // $data3 = $Orderitem['data']->map(function ($Parts) {
                //     $Parts['category'] = ProductCategory::where('id',$Parts->cat_id)->first()['category'];
                //     return $Parts;
                // });
            //     return $Orderitem;
            // });
                }
                $discountAmount = 0;
                $manufactureArray = [];
                $Manufacturer = Orderitem::where('order_id',$req['order_id'])->select('part_id','quantity','dispatched_quantity','discount_per','part_price')->get();
                $checkOrderStatus = Order::where('id',$req['order_id'])->select('status')->first();
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
            if($data1 || $OrderData || $gst_per)
            {
                return response()->json(['success'=> 1,'message'=>'Orderdetail displayed','data'=>['detail'=>$data1,'discount_per'=> $discountManufacture,'status'=>$OrderData,'gst'=>$gst_per,'gst_amount'=>$gst_Amount,'discount'=>$discountAmount,'payment_Status' => $payment_Status,'total_Item_Price'=>$totalAmount,'discount_Amounts'=>$totalAmount-$discountAmount]]);
            } else
            {
                return response()->json(['success'=> 1,'message'=>'No order details avaiable']);
            }

        }
        else
        {
            return response()->json(['success'=> 1,'message'=>'No order details Avaiable']);
        }



    }
    function updateDispatchedQuantity(){
        $partId = Orderitem::all();
       foreach($partId as $part){
        $part->dispatched_quantity = $part->quantity;
        $part->update();
       }
       return response()->json(['success'=> 1,'message'=>'Dispatched quantity updated']);
    }

}
