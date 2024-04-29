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
use App\Http\Models\Payment;
use App\Http\Models\Paymentmethod;
use App\Http\Models\ProductAttachment;
use App\Http\Models\ProductCategory;
use App\Http\Models\Notification;
//use App\Http\Models\UserDevices;
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

class NotificationController extends Controller
{

    public function __construct()
    {
        date_default_timezone_set("Asia/Karachi");

    }
    public function send_comm_app_notification()
    {
        $number_noti = 1000;
        /*api_key available in:
        Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key*/
        $server_key = 'AAAAh4WKo8Y:APA91bGg7cZLIv57N-UZsGOMz_jXTj5qbedONZzvwwu27nMp2Kvg-qYjSfjy2nTGZUOG_AjqcDbqm7ZcZjAGHxWeslAAb5RVjaJmiuKHodlpl1mGUBM8pGNQ01nleKO0Ou_YN7wncqYQ';
        //API URL of FCM
        $url = 'https://fcm.googleapis.com/fcm/send';
        $currentDate = date('Y-m-d H:i:s');

        $noti = Notification::where(('sent_status'), '=', "N")->whereBetween("schedule_date",[Date('Y-m-d H:i:s',strtotime('-1 days')),$currentDate])->where("is_notification_required", "Y")->orderBy('schedule_date', 'DESC')->limit($number_noti)->get();

        if (count($noti) > 0) {
            foreach ($noti as $element) {
                #send App notification
                if (($element->is_msg_app) == 'Y') {
                    $title = $element->title;
                    $description = $element->description;
                    $user_id = $element->user_id;
//                    return [$user_id,$element->device_type];
                    if ($element->device_type == 'all') {

                        $q = UserDevice::where('user_id', $user_id)->where('status', '=', 'A')->get();
                    } else {

                        $q = UserDevice::where('user_id', $user_id)->where('status', '=', 'A')->where('platform', $element->device_type)->get();
                    }
//                    return $q;
                    if (!empty($q) && count($q) > 0) {
                        foreach ($q as $row) {
                            // dd($row);

                            if(is_null($row->token)){
                                DB::table('notification')
                                    ->where('id', '=', $element->id)
                                    ->update(array('message_error' => "Device token is null"));
                                continue;
                            }
                            $key = $row->token;
                            $headers = array(
                                'Authorization:key=' . $server_key,
                                'Content-Type:application/json'
                            );
                            $fields = array(
                                'to' => $key,
                                'notification' => array('title' => $title, 'body' => $description, 'sound' => 1, 'vibrate' => 1),
                                'data' => array('notification_type' => $element->notification_type, 'title' => $title, 'body' => $description)
                            );

                            $payload = json_encode($fields);
                            $curl_session = curl_init();
                            curl_setopt($curl_session, CURLOPT_URL, $url);
                            curl_setopt($curl_session, CURLOPT_POST, true);
                            curl_setopt($curl_session, CURLOPT_HTTPHEADER, $headers);
                            curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($curl_session, CURLOPT_SSL_VERIFYPEER, false);
                            curl_setopt($curl_session, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
                            curl_setopt($curl_session, CURLOPT_POSTFIELDS, $payload);
                            $curlResult = curl_exec($curl_session);

                            if ($curlResult === FALSE) {
                                die('FCM Send Error: ' . curl_error($curl_session));
                            }
                            curl_close($curl_session);


                            $res = json_decode($curlResult, true);

//                               return $res;
                            if ($res["failure"]) {
                                $array = $res['results'];
                                $error = $array[0]['error'];
                                DB::table('notification')
                                    ->where('id', '=', $element->id)
                                    ->update(array('message_error' => $error));
                            } else {
                                DB::table('notification')
                                    ->where('id', '=', $element->id)
                                    ->update(array('message_error' => '', 'sent_status' => 'Y', 'app_sent_date' => $currentDate));
                            }
                        }
                    }
                }
            }
            //return response(['success' => 1, 'message' => 'Sending all notifications', 'result' =>true], 200);
            // return true;
        }
    }

}
