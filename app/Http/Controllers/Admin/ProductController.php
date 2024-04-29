<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Ads;
use App\Http\Models\Feedback;
use App\Http\Models\ProductAttachment;
use App\Http\Models\Manufacturer_Discount;
use App\Http\Models\Manufacture;
use App\Http\Models\ProductCategory;
use App\Http\Models\ProductRating;
use App\Http\Models\Products;
use App\Http\Models\Company;
use App\Http\Models\Shipment;
use App\Http\Models\Order;
use App\User;
use Exception;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

//use Symfony\Component\Console\Input\Input;

class ProductController extends Controller
{
    public function addUnit(Request $request, $unitId = '')
    {
        if (Auth::user()->role != '1') {

            return redirect('/home');

        }
        if ($unitId) {
            $validator = Validator::make($request->all(), [

                'unit' => 'required',

                'status' => 'required',

            ]);

            if ($validator->fails()) {

                return redirect()->back()->with('error', $validator->errors()->first());

            }

            $unit = Unit::where('id', $unitId)->first();
            $unit->unit = $request->unit;
            $unit->status = $request->status;
            $unit->update();
            if ($unit) {

                return redirect()->back()->with('success', 'Unit updated successfully');

            } else {

                Session::flash('error', 'Sorry! Unit not updated');

                Session::flash('alert-class', 'alert-danger');

                return redirect()->back()->with('error', 'Sorry! Unit not updated');

            }
        } else {
            $validator = Validator::make($request->all(), [

                'unit' => 'required|unique:units',

                'status' => 'required',


            ]);


            if ($validator->fails()) {

                return redirect()->back()->with('error', $validator->errors()->first());

            }

            $unit = new Unit();
            $unit->unit = $request->unit;
            $unit->status = $request->status;
            $unit->save();
            if ($unit) {

                return redirect()->back()->with('success', 'Unit added successfully');

            } else {

                Session::flash('error', 'Sorry! Unit not added');

                Session::flash('alert-class', 'alert-danger');

                return redirect()->back()->with('error', 'Sorry! Unit not added');

            }
        }
    }

    public function addCategory(Request $request, $categoryId = '')
    {
        if (Auth::user()->role != '1') {

            return redirect('/home');

        }

        $validator = Validator::make($request->all(), [

            'category' => 'required|unique:product_categories',

        ]);


        if ($validator->fails()) {

            return redirect()->back()->with('error', $validator->errors()->first());

        }
        if ($categoryId) {
            $category = ProductCategory::where('id', $categoryId)->first();
            $category->category = $request->category;
            $category->created_by = $request->user()->id;
            $category->update();
            if ($category) {

                return redirect()->back()->with('success', 'Category updated successfully');

            } else {

                Session::flash('error', 'Sorry! Category not updated');

                Session::flash('alert-class', 'alert-danger');

                return redirect()->back()->with('error', 'Sorry! Category not updated');

            }
        } else {
            $category = new ProductCategory();
            $category->category = $request->category;
            $category->created_by = $request->user()->id;
            $category->save();
            if ($category) {

                return redirect()->back()->with('success', 'Category added successfully');

            } else {

                Session::flash('error', 'Sorry! Category not added');

                Session::flash('alert-class', 'alert-danger');

                return redirect()->back()->with('error', 'Sorry! Category not added');

            }
        }
    }

    public function getCategoryDetails()
    {
        return ['status' => true, 'data' => ProductCategory::where('is_deleted', 'N')->get()];
    }

    public function addSubCategory(Request $request, $subCategoryId = '')
    {
        if (Auth::user()->role != '1') {

            return redirect('/home');

        }
        if ($subCategoryId) {
            $validator = Validator::make($request->all(), [

                'category' => 'required',
                'sub_category' => 'required',
                'status' => 'required'

            ]);


            if ($validator->fails()) {

                return redirect()->back()->with('error', $validator->errors()->first());

            }

            $subCategory = SubCategory::where('id', $subCategoryId)->first();
            $subCategory->category_id = $request->category;
            $subCategory->sub_category = $request->sub_category;
            $subCategory->created_by = $request->user()->id;
            $subCategory->status = $request->status;
            $subCategory->update();
            if ($subCategory) {

                return redirect()->back()->with('success', 'Sub-category updated successfully');

            } else {

                Session::flash('error', 'Sorry! Sub-category not updated');

                Session::flash('alert-class', 'alert-danger');

                return redirect()->back()->with('error', 'Sorry! Sub-category not updated');

            }
        } else {

            $validator = Validator::make($request->all(), [

                'category' => 'required',
                'sub_category' => 'required|unique:sub_categories',
                'status' => 'required'

            ]);


            if ($validator->fails()) {

                return redirect()->back()->with('error', $validator->errors()->first());

            }

            $subCategory = new SubCategory();
            $subCategory->category_id = $request->category;
            $subCategory->sub_category = $request->sub_category;
            $subCategory->created_by = $request->user()->id;
            $subCategory->status = $request->status;
            $subCategory->save();
            if ($subCategory) {

                return redirect()->back()->with('success', 'Sub-category added successfully');

            } else {

                Session::flash('error', 'Sorry! Sub-category not added');

                Session::flash('alert-class', 'alert-danger');

                return redirect()->back()->with('error', 'Sorry! Sub-category not added');

            }
        }
    }

    public function addAds(Request $request, $addId = '')
    {
        if (Auth::user()->role != '1') {

            return redirect('/home');

        }

        if ($addId) {
            // return $request->all();
            $validator = Validator::make($request->all(), [
                'start_date' => 'required|before_or_equal:end_date',
                'end_date' => 'required|after_or_equal:start_date',
            ]);


            if ($validator->fails()) {

                return redirect()->back()->with('error', $validator->errors()->first());

            }
            if ($request->file('banner-image')) {
                $files = $request->file('banner-image');
                $adsImage = date("dmyHis.") . gettimeofday()["usec"] . '_' . str_replace(" ",'-',$files->getClientOriginalName());
                $files->move(public_path() . '/ads/', $adsImage);
            }
            $ads = Ads::where('id', $addId)->first();
            if ($request->file('banner-image') && $adsImage) {
                $ads->image = isset($adsImage) && !empty($adsImage) ? $adsImage : NULL;
            }
            $ads->start_date = $request->start_date;
            $ads->end_date = $request->end_date;
            $result = $ads->update();
            if ($result) {

                return redirect()->back()->with('success', 'Ads edited successfully');

            } else {

                Session::flash('error', 'Sorry! Ads not edited');

                Session::flash('alert-class', 'alert-danger');

                return redirect()->back()->with('error', 'Sorry! Ads not edited');

            }

        } else {
            $validator = Validator::make($request->all(), [
                'start_date' => 'required|before_or_equal:end_date',
                'end_date' => 'required|after_or_equal:start_date',
                'banner-image' => 'required'

            ]);


            if ($validator->fails()) {

                return redirect()->back()->with('error', $validator->errors()->first());

            }

            if ($request->file('banner-image')) {
                $files = $request->file('banner-image');
                $adsImage = date("dmyHis.") . gettimeofday()["usec"] . '_' . str_replace(" ",'-',$files->getClientOriginalName());
                $files->move(public_path() . '/ads/', $adsImage);
            }

            $ads = new Ads();
            $ads->image = isset($adsImage) && !empty($adsImage) ? $adsImage : NULL;
            $ads->start_date = $request->start_date;
            $ads->end_date = $request->end_date;
            $result = $ads->save();
            if ($result) {

                return redirect()->back()->with('success', 'Ads added successfully');

            } else {

                Session::flash('error', 'Sorry! Ads not added');

                Session::flash('alert-class', 'alert-danger');

                return redirect()->back()->with('error', 'Sorry! Ads not added');

            }
        }
    }

    public function getSubCategoryDetails(Request $request)
    {
        $subCategory = SubCategory::where('status', 'Active')->where('is_deleted', 'N')->where('category_id', $request->id)->get();
        if ($subCategory) {
            return ['status' => true, 'data' => $subCategory];
        } else {
            return ['status' => false];
        }
    }


    public function addProducts(Request $request, $userId, $productId = '')
    {

        if (Auth::user()->role != '1') {

            return redirect('/home');

        }
//        return [$request->user()->id,$request->product_name];


        if ($request->status == 'Active') {
            $request->status = 'Y';
        } else {
            $request->status = 'N';
        }
        $request->category = ProductCategory::where('id', $request->category)->first()['category'];
        if ($productId == '') {
            if (Products::where('user_id', $request->id)->where('products_name', $request->product_name)->exists()) {
                return back()->withErrors('Product of this name already exists.Please choose another name')->withInput();
            }
            $validator = Validator::make($request->all(), [

                'product_name' => 'required',
                'price' => 'required',
                'category' => 'required',
                'sub_category' => 'required',
                'unit' => 'required',
                'status' => 'required',
                'productImage' => 'required',

            ]);


            if ($validator->fails()) {
                return back()->withErrors($validator->errors()->first())->withInput();
            }
            $product = new Products();
            $product->products_name = $request->product_name;
            $product->price = $request->price;
            $product->category = $request->category;
            $product->sub_category = $request->sub_category;
            $product->unit = $request->unit;
            $product->description = $request->description;
            $product->user_id = $request->id;
            $product->is_active = $request->status;
            $result = $product->save();
            if ($result && $request->file('productImage')) {
                for ($i = 0; $i < count($request->file('productImage')); $i++) {
                    $files = $request->file('productImage')[$i];
                    $productFiles = date("dmyHis.") . gettimeofday()["usec"] . '_' . $files->getClientOriginalName();
                    $files->move(public_path('/product-attachments'), $productFiles);
                    $productImage = new ProductAttachment();
                    $productImage->products_id = $product->id;
                    $productImage->image = $productFiles;
                    $productImage->save();
                }
            }
            if ($result) {

                return redirect()->route('company.product', ['id' => $request->id])->with('success', 'Product edited successfully');

            } else {

                Session::flash('error', 'Sorry! Product not added');

                Session::flash('alert-class', 'alert-danger');

                return redirect()->back()->with('error', 'Sorry! Product not added');

            }
        } else {
            $validator = Validator::make($request->all(), [

                'product_name' => 'required',
                'price' => 'required',
                'category' => 'required',
                'sub_category' => 'required',
                'unit' => 'required',
                'status' => 'required',

            ]);


            if ($validator->fails()) {

                return back()->withErrors($validator->errors()->first())->withInput();

            }
            $product = Products::where('id', $productId)->first();
            $product->products_name = $request->product_name;
            $product->price = $request->price;
            $product->category = $request->category;
            $product->sub_category = $request->sub_category;
            $product->unit = $request->unit;
            $product->description = $request->description;
            $product->user_id = $request->id;
            $product->is_active = $request->status;
            $result = $product->update();
            if ($result) {

                if ($result && $request->file('productImage')) {
                    $productAttachments = ProductAttachment::where('products_id', $productId)->delete();
                    for ($i = 0; $i < count($request->file('productImage')); $i++) {
                        $files = $request->file('productImage')[$i];
                        $productFiles = date("dmyHis.") . gettimeofday()["usec"] . '_' . $files->getClientOriginalName();
                        $files->move(public_path('/product-attachments'), $productFiles);
                        $productImage = new ProductAttachment();
                        $productImage->products_id = $productId;
                        $productImage->image = $productFiles;
                        $productImage->save();
                    }
                }
            }
        }
        if ($product) {

            return redirect()->route('company.product.detail', ['id' => $productId])->with('success', 'Product edited successfully');

        } else {

            Session::flash('error', 'Sorry! Product not added');

            Session::flash('alert-class', 'alert-danger');

            return redirect()->back()->with('error', 'Sorry! Product not added');

        }
    }


    public function deleteSellerProduct(Request $request)
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

    public function deleteFeaturedProduct(Request $request)
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

    public function approveProduct(Request $request)
    {
        if (Auth::user()->role != '1') {

            return redirect('/home');

        }

        $id = $request->id;

        $user = Products::findOrFail($id);
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

    public function deleteAds(Request $request)
    {
        if (Auth::user()->role != '1') {

            return redirect('/home');

        }

        $id = $request->id;

        $user = Ads::findOrFail($id)->delete();

        if ($user) {

            return ['status' => true];

        } else {

            return ['status' => false];

        }
    }

    public function markFeatured(Request $request, $id)
    {
        $products = Products::where('id', $id)->first();
        if($products) {
            $products->featured = $request->type;
            $result = $products->update();
        }else{
            $result = false;
        }
        return ['status' => $result];
    }

    public function markInactive(Request $request, $id)
    {
        $products = Products::where('id', $id)->first();
        if ($products) {
            $products->is_active = $request->type;
            $result = $products->update();
        } else {
            $result = false;
        }
        return ['status' => $result];
    }

//     public function editProduct(Request $request)
//     {
// //        return $request->id;
//         $products = Products::where('id', $request->id)->first();
//         $products['unit'] = Unit::where('id', $products->unit)->first()['unit'];
//         $products['categoryId'] = ProductCategory::where('category', $products->category)->first()['id'];
//         if (ProductAttachment::where('products_id', $request->id)->exists()) {
//             $products['attachments'] = ProductAttachment::where('products_id', $request->id)->get();
//             for ($i = 0; $i < count($products['attachments']); $i++) {
//                 $products['attachments'][$i]['image'] = getImageUrl($products['attachments'][$i]['image'], 'product-attachments');
//             }
//         } else {
//             $products['attachments'] = [];
//         }
//         return ['status' => true, 'data' => $products];
//     }

    public function searchorder(Request $request)
    {
        // return $request;
        if ($request->type == 'active') {

            $userRequirements = Order::where('status', 'accepted')->where('is_delete', 0)->orderBy('created_at', 'DESC')->paginate(10, ["*"], "approved_order");
            for ($i = 0; $i < count($userRequirements); $i++) {

                // $userRequirements[$i]['username'] = User::where('id', $userRequirements[$i]['user_id'])->first()['username'];
//                $userRequirements[$i]['username'] = User::where('id', $userRequirements[$i]['user_id'])->where('username', 'like', '%' . $request->value . '%')->first()['username'];
                $usernameData = User::where('id', $userRequirements[$i]['user_id'])->where('username', 'like', '%' . $request->value . '%')->first();
                if($usernameData)
                {
                    $userRequirements[$i]['username'] = $usernameData['username'];
                }
                else
                {
                    $userRequirements[$i]['username'] = '';
                }
                $delta = Order::select('total_amount')->where('id', $userRequirements[$i]['id'])->first();
                if (!empty($delta->total_amount) || ($delta->total_amount != null)) {
                    $userRequirements[$i]['total_amount'] = $delta->total_amount;
                } else {
                    $userRequirements[$i]['total_amount'] = 0;
                }
                $userRequirements[$i]['orderDate'] = date_format($userRequirements[$i]['created_at'], "Y-m-d");
            }
        }
        if ($request->type == 'cancel') {

            $userRequirements = Order::where('status', 'cancel')->where('is_delete', 0)->orderBy('created_at', 'DESC')->paginate(10, ["*"], "cancel_order");
            for ($i = 0; $i < count($userRequirements); $i++) {

                // $userRequirements[$i]['username'] = User::where('id', $userRequirements[$i]['user_id'])->first()['username'];
//                $userRequirements[$i]['username'] = User::where('id', $userRequirements[$i]['user_id'])->where('username', 'like', '%' . $request->value . '%')->first()['username'];
                $usernameData = User::where('id', $userRequirements[$i]['user_id'])->where('username', 'like', '%' . $request->value . '%')->first();
                if($usernameData)
                {
                    $userRequirements[$i]['username'] = $usernameData['username'];
                }
                else
                {
                    $userRequirements[$i]['username'] = '';
                }
                $delta = Order::select('total_amount')->where('id', $userRequirements[$i]['id'])->first();
                if (!empty($delta->total_amount) || ($delta->total_amount != null)) {
                    $userRequirements[$i]['total_amount'] = $delta->total_amount;
                } else {
                    $userRequirements[$i]['total_amount'] = 0;
                }
                $userRequirements[$i]['orderDate'] = date_format($userRequirements[$i]['created_at'], "Y-m-d");
            }
        }
        if ($request->type == 'dispatch') {

            $userRequirements = Order::where('status', 'dispatched')->where('is_delete', 0)->orderBy('created_at', 'DESC')->paginate(10, ["*"], "dispatch_order");
            for ($i = 0; $i < count($userRequirements); $i++) {

                // $userRequirements[$i]['username'] = User::where('id', $userRequirements[$i]['user_id'])->first()['username'];
                $usernameData = User::where('id', $userRequirements[$i]['user_id'])->where('username', 'like', '%' . $request->value . '%')->first();
                if($usernameData)
                {
                    $userRequirements[$i]['username'] = $usernameData['username'];
                }
                else
                {
                    $userRequirements[$i]['username'] = '';
                }
                $delta = Order::select('total_amount')->where('id', $userRequirements[$i]['id'])->first();
                if (!empty($delta->total_amount) || ($delta->total_amount != null)) {
                    $userRequirements[$i]['total_amount'] = $delta->total_amount;
                } else {
                    $userRequirements[$i]['total_amount'] = 0;
                }
                $userRequirements[$i]['orderDate'] = date_format($userRequirements[$i]['created_at'], "Y-m-d");
            }

        }
        if ($request->type == 'pending') {

            $userRequirements = Order::where('status', 'pending')->where('is_delete', 0)->orderBy('created_at', 'DESC')->paginate(10, ["*"], "pending_order");
//             return $userRequirements;
            for ($i = 0; $i < count($userRequirements); $i++) {

                $usernameData = User::where('id', $userRequirements[$i]['user_id'])->where('username', 'like', '%' . $request->value . '%')->first();
                if($usernameData)
                {
                    $userRequirements[$i]['username'] = $usernameData['username'];
                }
                else
                {
                    $userRequirements[$i]['username'] = '';
                }
//                $userRequirements[$i]['username'] = User::where('id', $userRequirements[$i]['user_id'])->where('username', 'like', '%' . $request->value . '%')->first()['username'];
                $totalAmount = Order::select('total_amount')->where('id', $userRequirements[$i]['id'])->where('status', 'pending')->where('is_delete', 0)->first();
                if (!empty($totalAmount->total_amount) || ($totalAmount->total_amount != null)) {
                    $userRequirements[$i]['total_amount'] = $totalAmount->total_amount;
                } else {
                    $userRequirements[$i]['total_amount'] = 0;
                }
                $userRequirements[$i]['orderDate'] = date('Y-m-d', strtotime($userRequirements[$i]['created_at']));
            }
        }

        return ['data' => $userRequirements];
    }

    public function categoryProducts(Request $request)
    {
        $category = ProductCategory::where('id', $request->categoryId)->first()['category'];
        $categoryProducts = Products::where('category', $category)->where('is_approved', 'Y')->where('is_deleted', 'N')->where('is_active', 'Y')->get();
        $categoryProducts = $categoryProducts->map(function ($products) {
            $sellerImage = User::where('id', $products->user_id)->first()['image'];
            if ($sellerImage) {
                $products['image'] = getImageUrl($sellerImage, 'images');
            } else {
                $products['image'] = getImageUrl('profile.png', 'images12');
            }
            $products['categoryId'] = ProductCategory::where('category', $products->category)->first()['id'];
            $products['currency'] = Currency::first()['currency'];
            if (ProductRating::where('product_id', $products->id)->exists()) {
                $productRating = ProductRating::where('product_id', $products->id)->get();
                $rating = 0;
                for ($k = 0; $k < count($productRating); $k++) {
                    $rating += (int)$productRating[$k]['rating'];
                }
                $count = count($productRating);
                $products['rating'] = $rating / $count;

            } else {
                $products['rating'] = 0;
            }
//                    if ($products['attachments']) {
//                        for ($i = 0; $i < count($products['attachments']); $i++) {
//                            $products['attachments'][$i]['image'] = getImageUrl($products['attachments'][$i]['image'], 'product-attachments');
//                        }
//                    }
            $products['unit'] = Unit::where('id', $products->unit)->first()['unit'];
            $name = User::where('id', $products->user_id)->first()['username'];
            $location = User::where('id', $products->user_id)->first()['address'];
            $email = User::where('id', $products->user_id)->first()['email'];
            $phone = User::where('id', $products->user_id)->first()['phone'];
            $products['sellerName'] = isset($name) ? $name : '';
            $products['sellerLocation'] = isset($location) ? $location : '';
            $products['sellerEmail'] = isset($email) ? $email : '';
            $products['sellerPhone'] = isset($phone) ? $phone : '';
            $products['categoryId'] = ProductCategory::where('category', $products->category)->first()['id'];
//                $products['products'] = $products['products']->map(function ($products) {
////                    $products['attachments'] = ProductAttachment::where('products_id', $products->id)->get();
//
//                    return $products;
//                });
            return $products;
        });
        return ['data' => $categoryProducts];
    }

    public function userRating(Request $request)
    {
        if (ProductRating::where('user_id', $request->id)->exists()) {
            $data = ProductRating::where('user_id', $request->id)->get();
            $data = $data->map(function ($products) {
                $products['userName'] = User::where('id', $products->user_id)->first()['username'];
                return $products;
            });
            return ['status' => true, 'data' => $data];
        } else {
            return ['status' => false];
        }
    }

    public function editUser(Request $request)
    {
        // return $request->all();
        if (Auth::user()->role != '1') {

            return redirect('/home');

        }
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            // 'email' => 'required|string',
            'phone' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors()->first());
        }
        if (!preg_match('/^((\+92)|(0092))-{0,1}\d{3}-{0,1}\d{7}$|^\d{11}$|^\d{4}-\d{7}$/', $request['phone'])) {
            return redirect()->back()->with('error', 'Invalid phone number!');
        }

        if ($request->status == 'Active') {
            $request->status = 'Y';
        } else {
            $request->status = 'N';
        }

        $user = User::findorfail($request->id);
        $user->name = $request->username;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->is_active = $request->status;
        $user->role = $request->user_role;
        if ($request->file('admin-image')) {
            $files = $request->file('admin-image');
            $profilePic = date("dmyHis.") . gettimeofday()["usec"] . '_' . $files->getClientOriginalName();
            $files->move(public_path() . '/images/profile-pic/', $profilePic);
            $user['image'] = $profilePic;
        }
        if($request->checkedStatus == 'true')
        {
            if (!empty($request->password))
            {
                $validator = Validator::make($request->all(), [
                    'password' => 'required',
                    'confirm_password' => 'required|same:password',
                ]);
                if ($validator->fails()) {
                    return back()->withErrors($validator->errors()->first())->withInput();
                }
                $user['password'] = Hash::make($request['password']);
            }
        }

        $user->save();

        if ($user->save()) {

            return redirect()->route('customer.list')->with('success', 'User edited successfully!!!');
        }
        else {
            return redirect()->back()->with('error', 'Sorry! User not updated');
        }
    }

    public function getUserData(Request $request)
    {
        return ['status' => true, 'data' => User::where('id', $request->id)->first()];

    }

    public function readFeedback(Request $request)
    {
        $feedback = Feedback::where('id', $request->id)->first();
        $feedback->is_read = 'Y';
        $feedback->save();

    }

    public function deleteCategory(Request $request)
    {
        if (Auth::user()->role != '1') {

            return redirect('/home');

        }
    
        $user = Shipment::where('id', $request->id)->first();
        $user->is_delete = 'Y';
        $user->update();

        if ($user) {
//            $subCategory = SubCategory::where('category_id',$request->id)->get();
//            if(!empty($subCategory))
//            {
//                for($k=0;$k<count($subCategory);$k++)
//                {
//                    $subCategory[$k]->is_deleted = 'Y';
//                    $subCategory[$k]->update();
//                }

//            }

            return ['status' => true];

        } else {

            return ['status' => false];

        }
    }

    public function deleteUnit(Request $request)
    {
        if (Auth::user()->role != '1') {

            return redirect('/home');

        }

        $user = Unit::where('id', $request->id)->first();
        $user->is_deleted = 'Y';
        $user->update();

        if ($user) {

            return ['status' => true];

        } else {

            return ['status' => false];

        }
    }

}
