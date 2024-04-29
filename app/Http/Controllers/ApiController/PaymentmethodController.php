<?php

namespace App\Http\Controllers\ApiController;

use DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Paymentmethod;

class PaymentmethodController extends Controller
{
    function displaypaymethod()
    {
        $data = Paymentmethod::where('is_active', '1')->get();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['image'] = getImageUrl($data[$i]['image'], 'payment');
        }
        return response()->json(['success' => 1, 'message' => 'payment method display successfully', 'data' => $data]);

    }
}
