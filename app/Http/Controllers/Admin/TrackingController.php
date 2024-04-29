<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Make;
use App\Http\Models\Manufacturer_Discount;
use App\Http\Models\Manufacture;
use App\Http\Models\Parts;
use App\Http\Models\Ads;
use App\Http\Models\Mod_el;
use App\Http\Models\Feedback;
use App\Http\Models\Membership;
use App\Http\Models\Payment;
use App\Http\Models\ProductAttachment;
use App\Http\Models\ProductCategory;
use App\Http\Models\PartYear;
use App\Http\Models\Products;
use App\Rules\OldPasswordMatch;
use Carbon\Carbon;
use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
use App\Http\Models\Tracking;
use App\Http\Models\ConfigParams;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Http\Models\Client_company;
use App\Http\Models\Assets;
use App\User;

class TrackingController extends Controller
{
    public function __construct()
    {

    }

    // will be use in future
    public function insert_notification($request)

    {
        DB::table('function_emails')->insert(array(

            "event_id" => $request['id'], "user_id" => $request['user_id'], 'is_msg_app' => 'Y', "title" => $request['title'],

            "description" => $request['description'], "notification_type" => $request['notification_type'],

            "schedule_date" => date('y-m-d H:i:s'), "entry_date" => date('y-m-d H:i:s')));


        return true;

    }

    public function adds($addId = '')
    {
        $ads = Ads::where('is_deleted', 'N')->orderBy('created_at','DESC')->paginate(10);
        for ($i = 0; $i < count($ads); $i++) {
            $file = public_path() . '/ads/' . $ads[$i]['image'];
            if (!empty($ads[$i]['image']) && file_exists($file)) {
                $ads[$i]['image'] = getImageUrl($ads[$i]['image'], 'ads');
            } else {
                $ads[$i]['image'] = getImageUrl('profile.png', 'images12');
            }
        }
        return view('admin.tracking.adds', ['ads' => $ads, 'id' => $addId]);
    }

    public function admin($adminId = '')
    {
        $users = User::where('is_deleted', 'N')->where('role', 1)->orderBy('created_at','Desc')->paginate(10, ["*"], "admin-list");
        for ($i = 0; $i < count($users); $i++) {
            $file = public_path() . '/images/profile-pic/' . $users[$i]['image'];
            if (!empty($users[$i]['image']) && file_exists($file)) {
                $users[$i]['image'] = getImageUrl($users[$i]['image'], 'images');
            } else {
                $users[$i]['image'] = getImageUrl('user-icon.jpg', 'images12');
            }
        }
        $customers = User::where('is_deleted', 'N')->where('role', 2)->orderBy('created_at','Desc')->paginate(10, ["*"], "customer-list");
        for ($i = 0; $i < count($customers); $i++) {
            $file = public_path() . '/images/profile-pic/' . $customers[$i]['image'];
            if (!empty($customers[$i]['image']) && file_exists($file)) {
                $customers[$i]['image'] = getImageUrl($customers[$i]['image'], 'images');
            } else {
                $customers[$i]['image'] = getImageUrl('user-icon.png', 'images12');
            }
        }
        $manufacture = Manufacture::Select('id', 'manufacture','discount_per')->where('is_active', 'Y')->where('is_deleted', 'N')->get();
        return view('admin.tracking.admin', ['users' => $users, 'adminId' => $adminId,'customers' => $customers, 'manufacturer'=> $manufacture]);
    }

    public function feedback()
    {
        $feedback = Feedback::paginate(10);
        if ($feedback) {
            for ($i = 0; $i < count($feedback); $i++) {
                $feedback[$i]['username'] = User::where('id', $feedback[$i]['user_id'])->first()['username'];
                $profilePic = User::where('id', $feedback[$i]['user_id'])->first()['image'];
                $file = public_path() . '/images/profile-pic/' . $profilePic;
                if ($profilePic && file_exists($file)) {
                    $feedback[$i]['image'] = getImageUrl($profilePic, 'images');
                } else {
                    $feedback[$i]['image'] = getImageUrl('profile.png', 'images12');
                }
            }
        }

        return view('admin.tracking.feedback', ['data' => $feedback]);
    }

    public function user(Request $request)
    {
        return view('admin.tracking.user', ['id' => $request->id]);
    }


    public function addAdmin(Request $request, $adminId = '')
    {
        if (Auth::user()->role != '1') {

            return redirect('/dashboard');

        }
        if ($adminId) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required','email', 'max:255', 'unique:users',
                'phone' => 'required|numeric|min:10|max:99999999999999',

            ]);

            if ($request->password) {
                $validator = Validator::make($request->all(), [

                    'password' => 'required',
                    'confirm_password' => 'required|same:password',

                ]);
            }


            if ($validator->fails()) {

                return redirect()->back()->with('error', $validator->errors()->first());

            }
        $existingUserWithSameEmail = User::where('email', $request->email)->where('id', '!=', $adminId)->first();
       if ($existingUserWithSameEmail) {
        return redirect()->back()->with('error', 'The email has already been taken.');
        }
            $input = $request->all();
            $checkNumber['phone'] = substr($input['phone'], -10);
            $userPhone = User::where('phone', 'LIKE', '%' . $checkNumber['phone'])->where('id','!=',$adminId)->first();
            if(!$userPhone){
                // if (preg_match('/^((\+92)|(0092))-{0,1}\d{3}-{0,1}\d{7}$|^\d{11}$|^\d{4}-\d{7}$/', $input['phone'])) {
                    $input['password'] = Hash::make($input['password']);
                    if ($input['status'] == 'Active') {
                        $input['is_active'] = 'Y';
                    } else {
                        $input['is_active'] = 'N';
                    }
                    //            $input['role'] = '1';
                    $user = User::where('id', $adminId)->first();
                    $user->username = $input['name'];
                    $user->name = $input['name'];
                    if ($request->password) {
                    $user->password = $input['password'];
                    }
                    $user->phone = $input['phone'];
                    // $user->customer_type = $input['customer-type'];
                    // if($input['customer-type'] == 'Retailer'){
                    //     $user->show_price = 'N';
                    // }
                    // else{
                    //     $user->show_price = 'Y';
                    // }
                    $user->role = $request->type;
                    $user->email = $request->email;
                    $user->is_approved = "Y";
                    // $user->discount = isset($request->discount) && !empty($request->discount) ? $request->discount : 0;
                    $user->is_active = $input['is_active'];
                    if ($request->file('admin-image')) {
                        $files = $request->file('admin-image');
                        $profilePic = date("dmyHis.") . gettimeofday()["usec"] . '_' . $files->getClientOriginalName();
                        $files->move(public_path() . '/images/profile-pic/', $profilePic);
                        $user->image = $profilePic;
                    }
                    
                    $user->update();
                    if ($user) {

                        return redirect()->back()->with('success', 'User updated successfully');

                    } else {

                        Session::flash('error', 'Sorry! User not updated');

                        Session::flash('alert-class', 'alert-danger');

                        return redirect()->back()->with('error', 'Sorry! User not updated');

                    }
                // }
                // else{
                //     // Session::flash('error', 'Please Enter Valid Number');
                //     return redirect()->back()->with('error', 'Sorry! User not updated');

                // }
            }
            else{
                return redirect()->back()->with('error', 'Number Already Exist');

            }
        } else {
            $validator = Validator::make($request->all(), [

                'name' => 'required',

                'phone' => 'required|numeric|min:10|max:99999999999999',

                'email' => 'required|email|max:255|unique:users',

                'password' => 'required',

                'type' => 'required',

                'confirm_password' => 'required|same:password',

            ]);


            if ($validator->fails()) {

                return redirect()->back()->with('error', $validator->errors()->first());

            }
            if ($files = $request->file('admin-image')) {
                $profilePic = date("dmyHis.") . gettimeofday()["usec"] . '_' . $files->getClientOriginalName();
                $files->move(public_path() . '/images/profile-pic/', $profilePic);
            }

            $input = $request->all();
            $checkNumber['phone'] = substr($input['phone'], -10);
            $userPhone = User::where('phone', 'LIKE', '%' . $checkNumber['phone'])->first();
            if(!$userPhone){
                $input['password'] = Hash::make($input['password']);
                if ($input['status'] == 'Active') {
                    $input['is_active'] = 'Y';
                } else {
                    $input['is_active'] = 'N';
                }
                $input['role'] = '1';
                $user = new User();
                $user->username = $input['name'];
                $user->name = $input['name'];
                $user->password = $input['password'];
                 $user->email =$input['email'];
                $user->phone = $input['phone'];
                // $user->customer_type = $input['customer-type'];
                // if($input['customer-type'] == 'Retailer'){
                //     $user->show_price = 'N';
                // }
                // else{
                //     $user->show_price = 'Y';
                // }
                $user->role = $request->type;
                $user->is_approved = "Y";
                $user->is_active = $input['is_active'];
                $user->discount = isset($request->discount) && !empty($request->discount) ? $request->discount : 0;
                $user->image = isset($profilePic) && !empty($profilePic) ? $profilePic : NULL;
                $user->is_approved = 'Y';

                $user->save();
                $manufacture= Manufacture::pluck('id');

                foreach($manufacture as $manufacturer){
                    $manufactDiscount= new Manufacturer_Discount;
                    $manufactDiscount->users_id=$user->id;
                    $manufactDiscount->manufacturer_id= $manufacturer;
                    $manufactDiscount->discount= isset($request->$manufacturer) ? $request->$manufacturer : 0;
                    $manufactDiscount->save();
                }
                if ($user) {

                    return redirect()->back()->with('success', 'User added successfully');

                } else {

                    Session::flash('error', 'Sorry! User not added');

                    Session::flash('alert-class', 'alert-danger');

                    return redirect()->back()->with('error', 'Sorry! User not added');

                }


            }
            else{
                return redirect()->back()->with('error', 'Phone Number already Exists');
            }
        }
    }

    public function category($categoryId = '')
    {
        $category = ProductCategory::where('is_deleted', 'N')->paginate(10);
        return view('admin.tracking.category', ['productCategory' => $category, 'categoryId' => $categoryId]);
    }

    public function subCategory($makeId = '')
    {
        $make = Make::where('is_delete', 0)->paginate(10);
        return view('admin.tracking.sub-category', ['make' => $make, 'makeId' => $makeId]);
    }


    public function payment()
    {
        $approvedPayment = Payment::where(['is_deleted' => 'N', 'is_approved' => 'Y'])->paginate(10, ["*"], "approved-products");
        for ($i = 0; $i < count($approvedPayment); $i++) {
            $file = public_path() . '/images/receipt/' . $approvedPayment[$i]['receipt'];
            if ($approvedPayment[$i]['receipt'] && file_exists($file)) {
                $approvedPayment[$i]['receipt'] = getImageUrl($approvedPayment[$i]['receipt'], 'receipt');
            } else {
                $approvedPayment[$i]['receipt'] = getImageUrl('profile.png', 'images12');
            }
            $approvedPayment[$i]['userName'] = User::where('id', $approvedPayment[$i]['user_id'])->first()['username'];
            if (!empty($approvedPayment[$i]['lead_id'])) {
                $lead = Leads::where('id', $approvedPayment[$i]['lead_id'])->first();
                $product = Products::where('id', $lead->product_id)->first()['products_name'];
                $approvedPayment[$i]['leads'] = $product . ' / ' . $lead->quantity;
            } else {
                $approvedPayment[$i]['leads'] = '';
            }
        }
        $pendingPayment = Payment::where(['is_deleted' => 'N', 'is_approved' => 'N'])->paginate(10, ["*"], "pending-products");
        for ($i = 0; $i < count($pendingPayment); $i++) {
            $file = public_path() . '/images/receipt/' . $pendingPayment[$i]['receipt'];
            if ($pendingPayment[$i]['receipt'] && file_exists($file)) {
                $pendingPayment[$i]['receipt'] = getImageUrl($pendingPayment[$i]['receipt'], 'receipt');
            } else {
                $pendingPayment[$i]['receipt'] = getImageUrl('profile.png', 'images12');
            }
            $pendingPayment[$i]['userName'] = User::where('id', $pendingPayment[$i]['user_id'])->first()['username'];
            if (!empty($pendingPayment[$i]['lead_id'])) {
                $lead = Leads::where('id', $pendingPayment[$i]['lead_id'])->first();
                $product = Products::where('id', $lead->product_id)->first()['products_name'];
                $pendingPayment[$i]['leads'] = $product . ' / ' . $lead->quantity;
            } else {
                $pendingPayment[$i]['leads'] = '';
            }
        }
        return view('admin.tracking.payment', ['approvedPayment' => $approvedPayment, 'pendingPayment' => $pendingPayment]);
    }

    public function deleteAdmin(Request $request)
    {
        if (Auth::user()->role != '1') {

            return redirect('/home');

        }

        $id = $request->id;

        $user = User::where('id', $id)->first();
        $user->is_deleted = 'Y';
        $user->update();

        if ($user) {

            return ['status' => true];

        } else {

            return ['status' => false];

        }
    }

    public function deleteSubCategory(Request $request)
    {
        if (Auth::user()->role != '1') {

            return redirect('/home');

        }

        $subCategory = SubCategory::where('id', $request->id)->first();
        $subCategory->is_deleted = 'Y';
        $subCategory->update();

        if ($subCategory) {

            return ['status' => true];

        } else {

            return ['status' => false];

        }
    }

    // public function chats(Request $request)
    // {
    //     return view('admin.tracking.chats', ['id' => $request->id]);
    // }

    public function deletePayment(Request $request)
    {
        if (Auth::user()->role != '1') {

            return redirect('/home');

        }
        $payment = Payment::where('id', $request->id)->first();
        $payment->is_deleted = 'Y';
        $payment->update();

        if ($payment) {

            return ['status' => true];

        } else {

            return ['status' => false];

        }
    }

    public function approvePayment(Request $request)
    {
        if (Auth::user()->role != '1') {

            return redirect('/home');

        }
        $payment = Payment::where('id', $request->id)->first();
        $payment->is_approved = 'Y';
        $payment->update();

        if ($payment) {

            return ['status' => true];

        } else {

            return ['status' => false];

        }
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => ['required', new OldPasswordMatch],
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password',
        ]);

        if ($validator->fails()) {

            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $request['password'] = Hash::make($request['new_password']);

        $user = User::where('id', $request->user()->id)->update(['password' => $request['password']]);
        if ($user) {

            return redirect()->back()->with('success', 'Password changed successfully');

        } else {

            Session::flash('error', 'Sorry! Password could not be changed');

            Session::flash('alert-class', 'alert-danger');

            return redirect()->back()->with('error', 'Sorry! Password could not be changed');

        }

    }
    public function manufacturer(){
        $allManufacturer = Manufacture::where('is_deleted','N')->get();
        return view('admin.tracking.manufacturer',compact('allManufacturer'));
    }
    public function updateManufacturer(Request $request){
      $getManufacturer= Manufacture::find($request->manufacturer_id);
    //   $getManufacturer->discount_per = $request->discount ?? '0';
    //   $getManufacturer->is_active = $request->manufacture_status;
      $getManufacturer->manufacture = $request->manufacturerName;
      $result = $getManufacturer->update();
      if($result){
        // $customers = User::where('is_deleted', 'N')->where('role', 2)->orderBy('created_at','Desc')->get();
        // foreach($customers as $customer){
        //     $getCustomerDiscount = Manufacturer_Discount::where('users_id',$customer->id)->where('manufacturer_id',$request->manufacturer_id)->first();
        //     if($getCustomerDiscount != "" && $getCustomerDiscount != null){
        //         $getCustomerDiscount->discount = $request->discount;
        //         $getCustomerDiscount->update();
        //     }
        //     else{
        //         $addCustomerDiscount = new Manufacturer_Discount();
        //         $addCustomerDiscount->users_id = $customer->id;
        //         $addCustomerDiscount->manufacturer_id = $request->manufacturer_id;
        //         $addCustomerDiscount->discount = $request->discount;
        //         $addCustomerDiscount->save();

        //     }
        // }
        Session::flash('success', 'Manufacturer Updated Successfully!');
        // Session::flash('alert-class', 'alert-danger');
        return redirect()->back()->with('Success', 'Manufacturer Updated Successfully!');
      }

    }
    public function getManufacturer(Request $request){
        $getManufacturer = Manufacture::find($request->id);
        return ['status' => true, 'data' => $getManufacturer];
    }
    public function exportCSV(){
        {
            $fileName = 'NTC_Models.csv';
            $getModel = Mod_el::where('is_delete',0)->orderBy('model_name','asc')->get();
            foreach($getModel as $getMod){
                $getMod['make']= Make::where('id',$getMod->make_id)->first()['make'];
            }
            $count = 0;

                 $headers = array(
                     "Content-type"        => "text/csv",
                     "Content-Disposition" => "attachment; filename=$fileName",
                     "Pragma"              => "no-cache",
                     "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                     "Expires"             => "0"
                 );

                 $columns = array('Sr', 'Model', 'Make', 'status');

                 $callback = function() use($getModel, $columns) {
                     $file = fopen('php://output', 'w');
                     fputcsv($file, $columns);

                     foreach ($getModel as $key=>$task) {
                         $row['Sr']  = $key+1;
                         $row['Model']    = $task->model_name;
                         $row['make']    = $task->make;
                         $row['status']    = $task->is_active == 1 ? "Active": "InActive";


                         fputcsv($file, array($row['Sr'], $row['Model'], $row['make'],$row['status']));
                     }

                     fclose($file);
                 };

                 return response()->stream($callback, 200, $headers);
             }
    }
    // public function exportToyotaModelCSV(){
    //     {

    //         $partas = [];
    //         $fileName = 'NTC_Toyota_BreakShoe.csv';
    //         $getModels = Mod_el::where('make_id', 113)->where('is_active',1)->where('is_delete',0)->pluck('id');
    //         $partIds = PartYear::whereIn('model_id',$getModels)->select('part_id','model_id')->groupBy('part_id')->get();
    //         foreach($partIds as $abc){
    //             $getPart = Parts::where('id',$abc->part_id)->where('cat_id',294)->where('is_active',1)->where('is_delete',0)->first();
    //             if($getPart != "" && $getPart !=null){
    //                     $partas[] = $getPart;
    //             }
    //         }
    //         foreach($partas as $part){
    //             $model = PartYear::where('part_id',$part->id)->pluck('model_id');
    //             $modelId = Mod_el::whereIn('id',$model)->where('make_id',113)->where('is_active',1)->where('is_delete',0)->pluck('model_name')->toArray();
    //             $part['model']= implode(",",$modelId);
    //         }
    //         $count = 0;

    //              $headers = array(
    //                  "Content-type"        => "text/csv",
    //                  "Content-Disposition" => "attachment; filename=$fileName",
    //                  "Pragma"              => "no-cache",
    //                  "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
    //                  "Expires"             => "0"
    //              );

    //              $columns = array('Sr','ref_no','description','currency','price','model');

    //              $callback = function() use($partas, $columns) {
    //                  $file = fopen('php://output', 'w');
    //                  fputcsv($file, $columns);

    //                  foreach ($partas as $key=>$task) {
    //                      $row['Sr']  = $key+1;
    //                      $row['ref_no']    = $task->ref_no;
    //                      $row['description']    = $task->description;
    //                      $row['currency']    = $task->currency;
    //                      $row['price']    = $task->price;
    //                      $row['model']    = $task->model;


    //                      fputcsv($file, array($row['Sr'],$row['ref_no'],$row['description'],$row['currency'],$row['price'],$row['model']));
    //                  }

    //                  fclose($file);
    //              };

    //              return response()->stream($callback, 200, $headers);
    //          }
    // }
    // public function exportToyotaModelCSVs(){
    //     {

    //         $partas = [];
    //         $fileName = 'NTC_Toyota_BreakShoe.csv';
    //         $getModels = Mod_el::where('make_id', 113)->where('is_active',1)->where('is_delete',0)->pluck('id');
    //         $partIds = PartYear::whereIn('model_id',$getModels)->select('part_id','model_id')->groupBy('part_id')->get();
    //         foreach($partIds as $abc){
    //             $getPart = Parts::where('id',$abc->part_id)->where('cat_id',294)->where('is_active',1)->where('is_delete',0)->first();
    //             if($getPart != "" && $getPart !=null){
    //                     $partas[] = $getPart;
    //             }
    //         }
    //         foreach($partas as $part){
    //             $category =  ProductCategory::where('id',$part->cat_id)->first();
    //             $part['cat_id'] = $category->category;
    //             $model = PartYear::where('part_id',$part->id)->pluck('model_id');
    //             $part['model'] = Mod_el::whereIn('id',$model)->where('make_id',113)->where('is_active',1)->where('is_delete',0)->pluck('model_name')->toArray();
    //             // $part['model']= implode(",",$modelId);
    //         }
    //         $count = 0;

    //              $headers = array(
    //                  "Content-type"        => "text/csv",
    //                  "Content-Disposition" => "attachment; filename=$fileName",
    //                  "Pragma"              => "no-cache",
    //                  "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
    //                  "Expires"             => "0"
    //              );
    //             //  return $partas;
    //              $columns = array('Name','PART NO.','Regular_price','Categories','Tags');
    //             // foreach ($partas as $key=>$task) {
    //             //     foreach($task->model as $tas){
    //             //         $row['Name']  = $tas;
    //             //          $row['PART_NO']    = $task->ref_no;
    //             //          $row['Regular_price']    = $task->price;
    //             //          $row['Categories']    = $task->cat_id;
    //             //          $row['Tags']    = 'TOYOTA';
    //             //          return $row;
    //             //     }
    //             // }

    //              $callback = function() use($partas, $columns) {
    //                  $file = fopen('php://output', 'w');
    //                  fputcsv($file, $columns);
    //                  foreach ($partas as $key=>$tasks) {
    //                     foreach($tasks->model as $task){
    //                      $row['Name']  = $task;
    //                      $row['PART_NO']    = $tasks->ref_no;
    //                      $row['Regular_price']    = $tasks->price;
    //                      $row['Categories']    = $tasks->cat_id;
    //                      $row['Tags']    = 'TOYOTA';
    //                     //  $row['model']    = $task->model;

    //                      fputcsv($file, array($row['Name'],$row['PART_NO'],$row['Regular_price'],$row['Categories'],$row['Tags']));
    //                  }
    //                 }

    //                  fclose($file);
    //              };

    //              return response()->stream($callback, 200, $headers);
    //          }
    // }

}
