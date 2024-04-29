<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Models\Configuration;
use Illuminate\Http\Request;
use App\Http\Models\Notification;
use App\Models\Category;
use Auth;
use DB;
use Illuminate\Support\Carbon;

class NotificationApiController extends Controller
{

    function sendAppNoti(){
        $notifications = Notification::where('sent_status', 'Y')->where('user_id', Auth::user()->id)->paginate(10);
        $notification = $notifications->map(function ($noti) {
            return collect($noti->toArray())
                ->only(['id', 'user_id', 'title','description','schedule_date','read_status','app_sent_date','type_id','notification_type'])
                ->all();
        });
        return response(['status'=>1,'message'=>'Notification Received','notification'=>$notification]);
    }
}
