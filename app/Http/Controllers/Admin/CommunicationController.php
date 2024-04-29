<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\UserDevice;
use App\Mail\OrderReceived;
use Mail;
use App\User;
use App\Http\Models\Setting;
use App\Http\Models\Plant;
use App\Http\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Models\NotificationSMS;
use App\Http\Models\NotificationEmail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\ResponseController;

class CommunicationController extends Controller

{
    public function index()
    {
        return view('admin.Communication.communication');
    }
    public function __construct()
    {
        date_default_timezone_set("Asia/Karachi");

    }
    public function storeEmail(Request $request)
    {

        $compaign_entry_no = NotificationEmail::max('campaign_entry');
        $allUsers = User::where('role',2)->get();

        if (!empty($allUsers)) {
            foreach ($allUsers as $key => $usr_email) {
                $noti_email = new NotificationEmail();
                $noti_email->user_id = $usr_email->id;
                $noti_email->to_email = $usr_email->email;
                $noti_email->email_subject = $request->email_subject;
                $noti_email->email_body = $request->email_body;

                if ($request->email_option_schedule == 'email_schedule') {

                    $noti_email->schedule_date = date('Y-m-d H:i:s', (strtotime(($request->schedule_date) . ' ' . $request->schedule_time) - 18000));
                } else {

                    $noti_email->schedule_date = date('Y-m-d H:i:s');
                }

                $noti_email->email_sent_status = 'N';
                $noti_email->campaign_entry = isset($compaign_entry_no)?$compaign_entry_no:'1';

                $noti_email->save();
            }
        }


//       $this->send_comm_email();

        return redirect()->back()->with('success', 'Email sent successfully!');
    }

    public function storeSMS(Request $request)
    {

        $compaign_entry_no = NotificationSMS::max('campaign_entry');
        $allUsers = User::where('role',2)->get();

        if (!empty($allUsers)) {
            foreach ($allUsers as $key => $usr_phone) {
                $noti_sms = new NotificationSMS();
                $noti_sms->user_id = $usr_phone->id;
                $noti_sms->phone_number = $usr_phone->phone;
                $noti_sms->sms_body = $request->sms_body;

                if ($request->sms_option_schedule == 'sms_schedule') {

                    $noti_sms->sms_schedule_date = $request->schedule_date . ' ' . $request->schedule_time . ':00';
                } else {

                    $noti_sms->sms_schedule_date = date('Y-m-d H:i:s');
                }

                $noti_sms->sms_sent_status = 'N';
                $noti_sms->campaign_entry = isset($compaign_entry_no)?$compaign_entry_no:'1';

                $noti_sms->save();
            }
        }

//        $this->send_comm_sms();

        return redirect()->back()->with('success', 'SMS sent successfully!');
    }

    public function storeAppNotification(Request $request)
    {
                $validator = Validator::make($request->all(), [
            'notification_title' => 'required',
            'notification_body' => 'required',
            'devices' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
        $compaign_entry_no = Notification::max('campaign_entry');
        $devices_arr = $request->devices;
        $device = '';

        $target = array('iOS', 'android');

        if(count(array_intersect($devices_arr, $target)) == count($target)){

            $device = 'all';
        }

        else {

            $device = $devices_arr[0];
        }
//        $userDetails = $request->to;
//        $riders = [];
//        $client = [];
//        for ($i = 0; $i < count($userDetails); $i++) {
//            if ($userDetails[$i] == '2') {
//                $riders = User::where('role_id', $userDetails[$i])->where('is_deleted', 'N')->get();
//            } else if ($userDetails[$i] == '3') {
//                $client = User::where('role_id', $userDetails[$i])->where('is_deleted', 'N')->get();
//            }
//        }
        $allUsers = User::where('role',2)->get();
        if (!empty($allUsers)) {
            foreach ($allUsers as $key => $usr) {

                $noti_app = new Notification();
                $noti_app->user_id = $usr->id;
                //                $noti_app->plant_id = $usr->plant_id;
                $noti_app->description = $request->notification_body;
                $noti_app->title = $request->notification_title;
                $noti_app->notification_type = 'Custom';
                $noti_app->device_type = $device;

                if ($request->noti_option_schedule == 'noti_schedule') {

                    $noti_app->schedule_date = $request->schedule_date . ' ' . $request->schedule_time . ':00';
                } else {

                    $noti_app->schedule_date = date('Y-m-d H:i:s');
                }

                $noti_app->sent_status = 'N';
                $noti_app->is_msg_app = 'Y';
                $noti_app->is_notification_required = 'Y';
                $noti_app->campaign_entry = isset($compaign_entry_no)?$compaign_entry_no:'1';

                $noti_app->save();
            }
        }

        $this->send_comm_app_notification();

        return redirect()->back()->with('success', 'Notification sent successfully!');
    }

    public function send_comm_email()
    {

        Artisan::call('config:clear');
        $number_email = 100;

        $currentDate = date('Y-m-d H:i:s');

        $setting_comm_email = Setting::where('perimeter', 'communication_email')->first();
        $setting_comm_email_name = Setting::where('perimeter', 'communication_email_name')->first();

        $noti = NotificationEmail::where('email_sent_status', 'N')->where('schedule_date', '<=', $currentDate)->orderBy('schedule_date', 'DESC')->limit($number_email)->get();
        if (count($noti) > 0) {
            foreach ($noti as $key => $element) {
                $to_email = $element->to_email;
                $email_subject = $element->email_subject;
                $email_body = $element->email_body;
                $cc_email = $element->cc_email;
                $bcc_email = $element->bcc_email;

                $OrderDetail = DB::table('order')->where('order.id',$element->order_id)
                    ->join('orderitem', 'orderitem.order_id', '=', 'order.id')
                    ->join('parts', 'parts.id', '=', 'orderitem.part_id')
                    ->join('users', 'users.id', '=', 'order.user_id')
                    ->select('order.*','users.username','users.phone','orderitem.quantity','orderitem.part_id','orderitem.quantity','parts.ref_no','parts.price')
                    ->get();

                  Mail::to($to_email)->send(new OrderReceived($OrderDetail));
//                Mail::send([], [], function ($message) use (
//                    $setting_comm_email, $setting_comm_email_name,
//                    $to_email, $email_subject, $email_body, $cc_email, $bcc_email
//                ) {
//                    $message->from($setting_comm_email->value, $setting_comm_email_name->value)
//                        ->to($to_email)
//                        ->subject($email_subject ? $email_subject : '')
//                        ->setBody($email_body, 'text/html');
//                });

                if (count(Mail::failures()) > 0) {

                    $mail_err = '';

                    foreach (Mail::failures as $email_address) {
                        $mail_err .= $email_address . '=>';
                    }

                    NotificationEmail::where('id', $element->id)->update(array('response' => $mail_err));
                } else {

                    NotificationEmail::where('id', $element->id)->update(array('from_email' => $setting_comm_email->value, 'from_name' => $setting_comm_email_name->value, 'response' => 'sent successfully!', 'email_sent_status' => 'Y', 'sent_date' => $currentDate));
                }
            }

            //return redirect()->back()->with('success', 'Emails send successfully!');
        }
        /*else
        {
            return redirect()->back()->with('error', 'No emails to send!');
        }*/

    }

    public function send_comm_sms()
    {
        $number_sms = 10;

        $currentDate = date('Y-m-d H:i:s');

        $setting_comm_sms_username = Setting::where('perimeter', 'communication_sms_username')->first();
        $setting_comm_sms_password = Setting::where('perimeter', 'communication_sms_password')->first();
        $setting_comm_sms_sender_id = Setting::where('perimeter', 'communication_sms_sender_id')->first();

        $noti = NotificationSMS::where('sms_sent_status', 'N')->where('sms_schedule_date', '<=', $currentDate)->orderBy('sms_schedule_date', 'DESC')->limit($number_sms)->get();

        if (count($noti) > 0) {
            foreach ($noti as $key => $element) {
                $username = $setting_comm_sms_username->value;
                $password = $setting_comm_sms_password->value;
                $mobile = $element->phone_number;
                $sender = $setting_comm_sms_sender_id->value;
                $message = $element->sms_body;

                ////sending sms

                $post = "user=" . $username . "&pwd=" . $password . "&sender=" . urlencode($sender) . "&reciever=" . urlencode($mobile) . "&msg-data=" . urlencode($message) . "&response=string";
                $url = "https://pk.eocean.us/API/RequestAPI?" . $post;
                $ch = curl_init();
                $timeout = 10; // set to zero for no timeout
                curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)');
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                $result = curl_exec($ch);

                if (strpos($result, 'Message Id') === false) {

                    NotificationSMS::where('id', $element->id)->update(array('response' => $result));
                } else {

                    NotificationSMS::where('id', $element->id)->update(array('from_phone_number' => $setting_comm_sms_sender_id->value, 'response' => $result, 'sms_sent_status' => 'Y', 'sent_date' => $currentDate));
                }
            }

            //return redirect()->back()->with('success', 'SMS send successfully!');
        }
        /*else
        {
            return redirect()->back()->with('error', 'No sms to send!');
        }*/

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

        $noti = Notification::where(('sent_status'), '=', "N")->where("schedule_date", "<=", $currentDate)->where("is_notification_required", "Y")->orderBy('schedule_date', 'DESC')->limit($number_noti)->get();

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

