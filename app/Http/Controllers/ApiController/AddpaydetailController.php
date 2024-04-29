<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use App\Http\Models\Order;
use App\Http\Models\Paymentmethod;
use Illuminate\Http\Request;
use App\Http\Models\payments;
use Illuminate\Support\Facades\Auth;
use Validator;

class AddpaydetailController extends Controller
{
    function addpaydetail(Request $req)
    {

        $getPayMethod = Paymentmethod::where('id',$req->paymethod_id)->first();
        $order =Order::where('id',$req->order_id)->first();

        if($getPayMethod->method == 'Bank Transfer'){
            $validator = Validator::make($req->all(), [
                'date' => 'required',
                'amount' => 'required',
                'receiptno' => 'required',
                'paymethod_id' => 'required',
                'bank_name' => 'required',
                'image' => 'required',
            ]);

            if ($validator->fails()) {

                return response()->json(['success'=> 0, 'message'=>$validator->errors()->first()]);

            }
            $addpaydetail = new payments;
            $addpaydetail->paymethod_id = $req->paymethod_id;
            $addpaydetail->user_id = Auth::user()->id;
            $addpaydetail->date = $req->date;
            $addpaydetail->bank_name = $req->bank_name;
            $addpaydetail->amount = $req->amount;
            $addpaydetail->receiptno = $req->receiptno;
            if ($req->hasFile('image')) {
                $image = $req->image;
                $filename = time() . '.' . $image->getClientOriginalName();
                $image->move(public_path('assets/Ordersdetail/'), $filename);
                $addpaydetail->image = $filename;
            }
//            $order =Order::where('id',$req->order_id)->first();
//            $order->pay_id = $addpaydetail->id;
//            $order->update();
            $addpaydetail->save();
        }
        else {

            $addpaydetail = new payments;
            $addpaydetail->paymethod_id = $req->paymethod_id;
            $addpaydetail->user_id = Auth::user()->id;
            $addpaydetail->date = date("Y-m-d h:i:s");
            $addpaydetail->amount = $order->total_amount;
            $addpaydetail->save();

        }
		if($addpaydetail->save()){
            $order->pay_id = $addpaydetail->id;
            $order->update();
            if($order) {
                return response()->json(['sucsess' => 1, 'message' => "Payment added successfully"]);
            }
		}
		else{
			return response()->json(['success'=>1,'message'=>"please fill field carefully"]);
		}
    }

}
