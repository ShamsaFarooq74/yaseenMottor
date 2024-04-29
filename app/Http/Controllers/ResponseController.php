<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResponseController extends Controller
{
    public function sendResponse($status,$message,$result)
    {
    	$response = [
            'success' => $status,
            'message' => $message,
            'data'    => $result,
        ];


        return response()->json($response, 200);
    }
    public function sendError($error, $errorMessages = [], $code = 200)
    {
    	$response = [
            'success' => 0 ,
            'message' => $error,
        ];


        // if(!empty($errorMessages)){
        //     $response['data'] = $errorMessages;
        // }


        return response()->json($response, $code);
    }
}
