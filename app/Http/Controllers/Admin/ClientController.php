<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\Category;
use App\Http\Models\Make;
use App\Http\Models\PartMake;
use App\Http\Models\Manufacture;
use App\Http\Models\Manufacturer_Discount;
use App\Http\Models\Mod_el;
use App\Http\Models\Modelyear;
use App\Http\Models\Order;
use App\Http\Models\PartDetails;
use App\Http\Models\PartImage;
use App\Http\Models\Parts;
use App\Http\Models\PartYear;
use App\Http\Models\Favorite;
use App\Http\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Http\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Http\Models\Assets;
use App\User;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Vtiful\Kernel\Excel;
use Illuminate\Http\UploadedFile;

class ClientController extends Controller
{

    protected function files_validator(array $data)
    {
        return Validator::make($data, [
            'attachment' => ['required'],
        ]);

    }

    public function client_list()
    {
       
        $partsInfo = PartDetails::where('is_delete', 'N')->orderBy('updated_at','DESC')->get();
        return view('admin.client.client_list', ['parts' => $partsInfo]);
    }

    public function deleteModel(Request $request)
    {
        $modelData = Mod_el::where('id', $request->id)->first();
        $modelData->is_delete = 'Y';
        $result = $modelData->update();
        return ['status' => $result];
    }

    public function deleteUser(Request $request)
    {
        if (Auth::user()->role != '1') {

            return redirect('/dashboard');

        }

        $id = $request->id;

        $user = User::findOrFail($id);
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

    public function searchBuyer(Request $request)
    {
        if ($request->userStatus == 'approved') {
           if ($request->usersname && !$request->value) {
           $users = User::where('role', 2)
           ->where('is_deleted', 'N')
           ->where('username', 'like', '%' . $request->usersname . '%')
           ->get();
           } elseif (!$request->usersname && $request->value) {
           $users = User::where('role', 2)
           ->where('is_deleted', 'N')
           ->where('phone', 'like', '%' . $request->value . '%')
           ->get();
           } elseif ($request->usersname && $request->value) {
           $users = User::where('role', 2)
           ->where('is_deleted', 'N')
           ->where('username', 'like', '%' . $request->usersname . '%')
           ->where('phone', 'like', '%' . $request->value . '%')
           ->get();
           }
            for ($i = 0; $i < count($users); $i++) {
                $file = public_path() . '/images/profile-pic/' . $users[$i]['image'];
                if (!empty($users[$i]['image']) && file_exists($file)) {
                    $users[$i]['image'] = getImageUrl($users[$i]['image'], 'images');
                } else {
                    $users[$i]['image'] = getImageUrl('user-icon.jpg', 'images12');
                }
                if (empty($users[$i]['phone'])) {
                    $users[$i]['phone'] = '';
                }
                // if (empty($users[$i]['customer_type'])) {
                //     $users[$i]['customer_type'] = '';
                // }
                if (Order::where('user_id', $users[$i]['id'])->exists()) {
                    $users[$i]['orderCount'] = Order::where('user_id', $users[$i]['id'])->count();
                } else {
                    $users[$i]['orderCount'] = 0;
                }
                if (Company::where('user_id', $users[$i]['id'])->exists()) {
                    $users[$i]['companyname'] = Company::where('user_id', $users[$i]['id'])->first()['name'];
                } else {
                    $users[$i]['companyname'] = "N/A";
                }
                $user[$i]['userstatus'] = $request->userStatus;
                $discount= array();
                $manufacture_name= array();
                $manufacture_id= array();

                $manufactDetails= Manufacturer_Discount::where('users_id', $users[$i]['id'])->get();
                if(count($manufactDetails) > 0){
                    for ($j = 0; $j < count($manufactDetails); $j++) {

                            array_push($discount, $manufactDetails[$j]->discount);
                            array_push($manufacture_id, $manufactDetails[$j]->manufacturer_id);
                            $manufactureDetails= Manufacture::select('manufacture')->where('id',$manufactDetails[$j]->manufacturer_id)->first();
                            array_push($manufacture_name, $manufactureDetails->manufacture);
                        }
                }else{
                    $manufactureId= Manufacture::get();
                    for($j = 0; $j < count($manufactureId); $j++ ){
                    array_push($manufacture_name, $manufactureId[$j]->manufacture);
                    array_push($manufacture_id, $manufactureId[$j]->id);
                    array_push($discount,0);
                    }
                }
                $users[$i]['discount']= $discount;
                $users[$i]['manufacturer_id']= $manufacture_id;
                $users[$i]['manufacturer_name']=$manufacture_name;
                $user[$i]['userstatus'] = $request->userStatus;
            }
        } elseif ($request->userStatus == 'pending') {
              if ($request->usersname && !$request->value) {
              $users = User::where('role', 2)
              ->where('is_deleted', 'N')
              ->where('username', 'like', '%' . $request->usersname . '%')
              ->get();
              } elseif (!$request->usersname && $request->value) {
              $users = User::where('role', 2)
              ->where('is_deleted', 'N')
              ->where('phone', 'like', '%' . $request->value . '%')
              ->get();
              } elseif ($request->usersname && $request->value) {
              $users = User::where('role', 2)
              ->where('is_deleted', 'N')
              ->where('username', 'like', '%' . $request->usersname . '%')
              ->where('phone', 'like', '%' . $request->value . '%')
              ->get();
              }
            for ($i = 0; $i < count($users); $i++) {
                $file = public_path() . '/images/profile-pic/' . $users[$i]['image'];
                if (!empty($users[$i]['image']) && file_exists($file)) {
                    $users[$i]['image'] = getImageUrl($users[$i]['image'], 'images');
                } else {
                    $users[$i]['image'] = getImageUrl('user-icon.jpg', 'images12');
                }
                if (empty($users[$i]['phone'])) {
                    $users[$i]['phone'] = '';
                }
                // if (empty($users[$i]['customer_type'])) {
                //     $users[$i]['customer_type'] = '';
                // }
                if (Order::where('user_id', $users[$i]['id'])->exists()) {
                    $users[$i]['orderCount'] = Order::where('user_id', $users[$i]['id'])->count();
                } else {
                    $users[$i]['orderCount'] = 0;
                }
                if (Company::where('user_id', $users[$i]['id'])->exists()) {
                    $users[$i]['companyname'] = Company::where('user_id', $users[$i]['id'])->first()['name'];
                } else {
                    $users[$i]['companyname'] = "N/A";
                }
                $user[$i]['userstatus'] = $request->userStatus;
                $discount= array();
                $manufacture_name= array();
                $manufacture_id= array();

                $manufactDetails= Manufacturer_Discount::where('users_id', $users[$i]['id'])->get();
                if(count($manufactDetails) > 0){
                    for ($j = 0; $j < count($manufactDetails); $j++) {

                            array_push($discount, $manufactDetails[$j]->discount);
                            array_push($manufacture_id, $manufactDetails[$j]->manufacturer_id);
                            $manufactureDetails= Manufacture::select('manufacture')->where('id',$manufactDetails[$j]->manufacturer_id)->first();
                            array_push($manufacture_name, $manufactureDetails->manufacture);
                        }
                }else{
                    $manufactureId= Manufacture::get();
                    for($j = 0; $j < count($manufactureId); $j++ ){
                    array_push($manufacture_name, $manufactureId[$j]->manufacture);
                    array_push($manufacture_id, $manufactureId[$j]->id);
                    array_push($discount,0);
                    }
                }
                $users[$i]['discount']= $discount;
                $users[$i]['manufacturer_id']= $manufacture_id;
                $users[$i]['manufacturer_name']=$manufacture_name;
                $user[$i]['userstatus'] = $request->userStatus;
            }
        } elseif ($request->userStatus == 'block') {
              if ($request->usersname && !$request->value) {
              $users = User::where('role', 2)
              ->where('is_deleted', 'N')
              ->where('username', 'like', '%' . $request->usersname . '%')
              ->get();
              } elseif (!$request->usersname && $request->value) {
              $users = User::where('role', 2)
              ->where('is_deleted', 'N')
              ->where('phone', 'like', '%' . $request->value . '%')
              ->get();
              } elseif ($request->usersname && $request->value) {
              $users = User::where('role', 2)
              ->where('is_deleted', 'N')
              ->where('username', 'like', '%' . $request->usersname . '%')
              ->where('phone', 'like', '%' . $request->value . '%')
              ->get();
              }
            for ($i = 0; $i < count($users); $i++) {
                $file = public_path() . '/images/profile-pic/' . $users[$i]['image'];
                if (!empty($users[$i]['image']) && file_exists($file)) {
                    $users[$i]['image'] = getImageUrl($users[$i]['image'], 'images');
                } else {
                    $users[$i]['image'] = getImageUrl('user-icon.jpg', 'images12');
                }
                if (empty($users[$i]['phone'])) {
                    $users[$i]['phone'] = '';
                }
                // if (empty($users[$i]['customer_type'])) {
                //     $users[$i]['customer_type'] = '';
                // }
                if (Order::where('user_id', $users[$i]['id'])->exists()) {
                    $users[$i]['orderCount'] = Order::where('user_id', $users[$i]['id'])->count();
                } else {
                    $users[$i]['orderCount'] = 0;
                }
                if (Company::where('user_id', $users[$i]['id'])->exists()) {
                    $users[$i]['companyname'] = Company::where('user_id', $users[$i]['id'])->first()['name'];
                } else {
                    $users[$i]['companyname'] = "N/A";
                }
                $discount= array();
                $manufacture_name= array();
                $manufacture_id= array();

                $manufactDetails= Manufacturer_Discount::where('users_id', $users[$i]['id'])->get();
                if(count($manufactDetails) > 0){
                    for ($j = 0; $j < count($manufactDetails); $j++) {

                            array_push($discount, $manufactDetails[$j]->discount);
                            array_push($manufacture_id, $manufactDetails[$j]->manufacturer_id);
                            $manufactureDetails= Manufacture::select('manufacture')->where('id',$manufactDetails[$j]->manufacturer_id)->first();
                            array_push($manufacture_name, $manufactureDetails->manufacture);
                        }
                }else{
                    $manufactureId= Manufacture::get();
                    for($j = 0; $j < count($manufactureId); $j++ ){
                    array_push($manufacture_name, $manufactureId[$j]->manufacture);
                    array_push($manufacture_id, $manufactureId[$j]->id);
                    array_push($discount,0);
                    }
                }
                $users[$i]['discount']= $discount;
                $users[$i]['manufacturer_id']= $manufacture_id;
                $users[$i]['manufacturer_name']=$manufacture_name;
                $user[$i]['userstatus'] = $request->userStatus;
            }
        }
        return ['data' => $users];
    }

    public function searchpart(Request $req)
    {
        $partsInfo = Parts::where('is_delete', 0)->where('is_active', 1)->where('ref_no', 'like', '%' . $req->value . '%')->paginate(10);
        for ($i = 0; $i < count($partsInfo); $i++) {
            $manufacturer = Manufacture::where('id', $partsInfo[$i]->manufacturer)->first();
            $partsInfo[$i]['manufactureName'] = $manufacturer->manufacture;
            $partsInfo[$i]['manufactureImage'] = getImageUrl($manufacturer->image, 'manufacture');
            $category = ProductCategory::where('id', $partsInfo[$i]['cat_id'])->first();
            $partsInfo[$i]['category'] = $category['category'];
            if (empty($category['image'])) {
                $category['image'] = 'xyz';
            }
            $file = public_path() . '/images/settings/' . $category['image'];
            if (!empty($category['image']) && file_exists($file)) {
                $partsInfo[$i]['categoryImage'] = getImageUrl($category['image'], 'settings');
            } else {
                $partsInfo[$i]['categoryImage'] = getImageUrl('parts.png', 'partss');
            }
            $make = Make::where('id', $partsInfo[$i]['make_id'])->first();
            if ($make) {
                $partsInfo[$i]['make'] = $make['make'];
            }
            if (empty($make['logo'])) {
                $make['logo'] = 'xyz';
            }
            $file = public_path() . '/images/settings/' . $make['logo'];
            if (!empty($make['logo']) && file_exists($file)) {
                $partsInfo[$i]['makeImage'] = getImageUrl($make['logo'], 'settings');
            } else {
                $partsInfo[$i]['makeImage'] = getImageUrl('parts.png', 'partss');
            }
            if (Modelyear::where('part_id', $partsInfo[$i]['id'])->exists()) {
                $partsInfo[$i]['model'] = Modelyear::where('part_id', $partsInfo[$i]['id'])->get();
                for ($k = 0; $k < count($partsInfo[$i]['model']); $k++) {
                    $partsInfo[$i]['model'][$k]['model'] = Mod_el::where('id', $partsInfo[$i]['model'][$k]['model_id'])->first()['model_name'];
                }
            } else {
                $partsInfo[$i]['model'] = [];
            }
            if (PartImage::where('part_id', $partsInfo[$i]['id'])->exists()) {
                $partsInfo[$i]['images'] = PartImage::where('part_id', $partsInfo[$i]['id'])->get();
                for ($l = 0; $l < count($partsInfo[$i]['images']); $l++) {
                    $file = public_path() . '/images/parts/' . $partsInfo[$i]['images'][$l]['image'];
                    if (!empty($partsInfo[$i]['images'][$l]['image']) && file_exists($file)) {
                        $partsInfo[$i]['images'][$l]['image'] = getImageUrl($partsInfo[$i]['images'][$l]['image'], 'parts');
                    } else {
                        $partsInfo[$i]['images'][$l]['image'] = getImageUrl('parts.png', 'partss');
                    }
                }

            } else {
                $partsInfo[$i]['images'] = [];
            }
        }
//        return $partsInfo;
        return ['parts' => $partsInfo];
    }

    public function customerlist(Request $request)
    {
        $users = User::where('role', 2)->where('is_deleted', 'N')->orderBy('created_at','Desc')->paginate(10, ["*"], "approved_users");
        for ($i = 0; $i < count($users); $i++) {
            $company = Company::where('user_id', $users[$i]['id'])->first();
            if ($company) {
                $users[$i]['companyname'] = $company->name;
                $users[$i]['companyimage'] = $company->image;
            } else {
                $users[$i]['companyname'] = "N/A";
                $users[$i]['companyimage'] = "";
            }
            $file = public_path() . '/images/profile-pic/' . $users[$i]['image'];
            if (!empty($users[$i]['image']) && file_exists($file)) {

                $users[$i]['image'] = getImageUrl($users[$i]['image'], 'images');
            } else {
                $users[$i]['image'] = getImageUrl('user-icon.jpg', 'images12');
            }
            if (Order::where('user_id', $users[$i]['id'])->exists()) {
                $users[$i]['orderCount'] = Order::where('user_id', $users[$i]['id'])->count();
            } else {
                $users[$i]['orderCount'] = 0;
            }
            $users[$i]['show_price'] = $users[$i]['show_price'] == 'Y' ? 1 : 0;

            $discount= array();
            $manufacture_name= array();
            $manufacture_id= array();

            $manufactDetails= Manufacturer_Discount::where('users_id', $users[$i]['id'])->get();
            if(count($manufactDetails) > 0){
                for ($j = 0; $j < count($manufactDetails); $j++) {

                        array_push($discount, $manufactDetails[$j]->discount);
                        array_push($manufacture_id, $manufactDetails[$j]->manufacturer_id);
                        $manufactureDetails= Manufacture::select('manufacture')->where('id',$manufactDetails[$j]->manufacturer_id)->first();
                        array_push($manufacture_name, $manufactureDetails->manufacture);
                    }
            }else{
                $manufactureId= Manufacture::get();
                for($j = 0; $j < count($manufactureId); $j++ ){
                array_push($manufacture_name, $manufactureId[$j]->manufacture);
                array_push($manufacture_id, $manufactureId[$j]->id);
                array_push($discount,0);
                }
            }
            $users[$i]['discount']= $discount;
            $users[$i]['manufacturer_id']= $manufacture_id;
            $users[$i]['manufacturer_name']=$manufacture_name;
        }
        // return $users;
        $pendingUsers = User::where('role', 2)->where('is_deleted', 'N')->orderBy('created_at','Desc')->paginate(10, ["*"], "pending_users");
        for ($i = 0; $i < count($pendingUsers); $i++) {
            $Pendingcompany = Company::where('user_id', $pendingUsers[$i]['id'])->first();
            if ($Pendingcompany) {
                $pendingUsers[$i]['companyname'] = $Pendingcompany->name;
                $pendingUsers[$i]['companyimage'] = $Pendingcompany->image;
            } else {
                $pendingUsers[$i]['companyname'] = "N/A";
                $pendingUsers[$i]['companyimage'] = "";
            }
            $file = public_path() . '/images/profile-pic/' . $pendingUsers[$i]['image'];
            if (!empty($pendingUsers[$i]['image']) && file_exists($file)) {

                $pendingUsers[$i]['image'] = getImageUrl($pendingUsers[$i]['image'], 'images');
            } else {
                $pendingUsers[$i]['image'] = getImageUrl('user-icon.jpg', 'images12');
            }
            if (Order::where('user_id', $pendingUsers[$i]['id'])->exists()) {
                $pendingUsers[$i]['orderCount'] = Order::where('user_id', $pendingUsers[$i]['id'])->count();
            } else {
                $pendingUsers[$i]['orderCount'] = 0;
            }
            $pendingUsers[$i]['show_price'] = $pendingUsers[$i]['show_price'] == 'Y' ? 1 : 0;
            $discount= array();
            $manufacture_name= array();
            $manufacture_id= array();

            $manufactDetails= Manufacturer_Discount::where('users_id', $pendingUsers[$i]['id'])->get();
            if(count($manufactDetails) > 0){
                for ($j = 0; $j < count($manufactDetails); $j++) {

                        array_push($discount, $manufactDetails[$j]->discount);
                        array_push($manufacture_id, $manufactDetails[$j]->manufacturer_id);
                        $manufactureDetails= Manufacture::select('manufacture')->where('id',$manufactDetails[$j]->manufacturer_id)->first();
                        array_push($manufacture_name, $manufactureDetails->manufacture);
                    }
            }else{
                $manufactureId= Manufacture::get();
                for($j = 0; $j < count($manufactureId); $j++ ){
                array_push($manufacture_name, $manufactureId[$j]->manufacture);
                array_push($manufacture_id, $manufactureId[$j]->id);
                array_push($discount,0);
                }
            }
            $pendingUsers[$i]['discount']= $discount;
            $pendingUsers[$i]['manufacturer_id']= $manufacture_id;
            $pendingUsers[$i]['manufacturer_name']=$manufacture_name;
        }
        $blockUsers = User::where('role', 2)->where('is_deleted', 'Y')->orderBy('updated_at','Desc')->paginate(10, ["*"], "blocked_users");
        for ($i = 0; $i < count($blockUsers); $i++) {
            $blockcompany = Company::where('user_id', $blockUsers[$i]['id'])->first();
            if ($blockcompany) {
                $blockUsers[$i]['companyname'] = $blockcompany->name;
                $blockUsers[$i]['companyimage'] = $blockcompany->image;
            } else {
                $blockUsers[$i]['companyname'] = "N/A";
                $blockUsers[$i]['companyimage'] = "";
            }
            $file = public_path() . '/images/profile-pic/' . $blockUsers[$i]['image'];
            if (!empty($blockUsers[$i]['image']) && file_exists($file)) {

                $blockUsers[$i]['image'] = getImageUrl($blockUsers[$i]['image'], 'images');
            } else {
                $blockUsers[$i]['image'] = getImageUrl('user-icon.jpg', 'images12');
            }
            if (Order::where('user_id', $blockUsers[$i]['id'])->exists()) {
                $blockUsers[$i]['orderCount'] = Order::where('user_id', $blockUsers[$i]['id'])->count();
            } else {
                $blockUsers[$i]['orderCount'] = 0;
            }
             $blockUsers[$i]['show_price'] = $blockUsers[$i]['show_price'] == 'Y' ? 1 : 0;
            $discount= array();
            $manufacture_name= array();
            $manufacture_id= array();

            $manufactDetails= Manufacturer_Discount::where('users_id', $blockUsers[$i]['id'])->get();
            if(count($manufactDetails) > 0){
                for ($j = 0; $j < count($manufactDetails); $j++) {

                        array_push($discount, $manufactDetails[$j]->discount);
                        array_push($manufacture_id, $manufactDetails[$j]->manufacturer_id);
                        $manufactureDetails= Manufacture::select('manufacture')->where('id',$manufactDetails[$j]->manufacturer_id)->first();
                        array_push($manufacture_name, $manufactureDetails->manufacture);
                    }
            }else{
                $manufactureId= Manufacture::get();
                for($j = 0; $j < count($manufactureId); $j++ ){
                array_push($manufacture_name, $manufactureId[$j]->manufacture);
                array_push($manufacture_id, $manufactureId[$j]->id);
                array_push($discount,0);
                }
            }
            $blockUsers[$i]['discount']= $discount;
            $blockUsers[$i]['manufacturer_id']= $manufacture_id;
            $blockUsers[$i]['manufacturer_name']=$manufacture_name;
        }
        if($request->has('type')){
             $type = "pending_user";
        }else{
            $type = "default";
        }
        // return $value;

        return view('admin.client.customer_list', ['users' => $users, 'pendingUsers' => $pendingUsers, 'blockUsers' => $blockUsers, 'type' => $type]);
    }


    public function approveCustomer(Request $request)
    {
        $users = User::where('id', $request->id)->first();
        $users->is_approved = 'Y';
        $result = $users->save();
        return ['status' => $result];
    }

    public function UnblockCustomer(Request $request)
    {
        if (Auth::user()->role != '1') {

            return redirect('/home');

        }

        $id = $request->id;

        $user = User::findOrFail($id);
        if ($user) {
            $user->is_deleted = 'N';
            $user->update();
        }

        if ($user) {

            return ['status' => true];

        } else {

            return ['status' => false];

        }
    }
    public function updateImages(){
        $imageFolder = public_path('images/Asuki');
        $imageFiles = scandir($imageFolder);
        $imageFiles = scandir($imageFolder);
        foreach ($imageFiles as $imageFile) {
            if ($imageFile !== "." && $imageFile !== "..") {
                $file = new UploadedFile($imageFolder . '/' . $imageFile, $imageFile,'blob', UPLOAD_ERR_OK, true);
                $imageName = $file->getClientOriginalName();
                $partRef = pathinfo($imageName, PATHINFO_FILENAME);
                $pattern = '/\(\d+\)$/';
                $trimCounter = preg_replace($pattern, '', $partRef);
                if(Parts::where('ref_no',$trimCounter)->exists()){
                    $getPart = Parts::where('ref_no',$trimCounter)->first();
                    if(PartImage::where('part_id',$getPart->id)->exists()){
                        $deleteAllIMages = PartImage::where('part_id',$getPart->id)->delete();

                        $profilePic = date("dmyHis.").'_' .$imageName;
                        $file->move(public_path('images/parts'), $profilePic);

                        $addNewImage = new PartImage();
                        $addNewImage->part_id = $getPart->id;
                        $addNewImage->image = $profilePic;
                        $addNewImage->save();

                    }
                    else{
                        $profilePic = date("dmyHis.").'_' .$imageName;
                        $file->move(public_path('images/parts'), $profilePic);
                            $partImage = new PartImage();
                            $partImage->part_id = $getPart->id;
                            $partImage->image = $profilePic;
                            $partImage->save();
                    }
                }
                else{
                $notexistent[] = $partRef;
                }
            }
        }
        return $notexistent;
    }
    public function customerlistDetail($userId){
        $favorites = Favorite::where('user_id',$userId)->first();
        dd($favorites);
        return view('admin.client.favorite_user', ['favorites' => $favorites]);
    }


}
