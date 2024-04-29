<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController as LoginController;
use App\Http\Controllers\RegisterController as RegisterController;
use App\Http\Controllers\LogoutController as LogoutController;
use App\Http\Controllers\ApiController\DisplayMake as displaymake;
use App\Http\Controllers\ApiController\Displaymodel as displaymodel;
use App\Http\Controllers\ApiController\Yearcontroller as displayyear;
use App\Http\Controllers\ApiController\Categorycontroller as category;
use App\Http\Controllers\ApiController\PartController as parts;
use App\Http\Controllers\ApiController\OrderController as order;
use App\Http\Controllers\ApiController\PaymentmethodController as paymethod;
use App\Http\Controllers\ApiController\AddpaydetailController as addpaydetail;
use App\Http\Controllers\ApiController\ProfileController as profile;
use App\Http\Controllers\ApiController\CompanyController as company;
use App\Http\Controllers\ApiController\forgetpasswordApi as forgetpassword;
use App\Http\Controllers\ApiController\NotificationApiController as NotiController;
use App\Http\Controllers\ApiController\DashboardDataController as DashboardData;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//--------------NTC Api's Routes-----------
Route::group(['middleware' => ['guest:api']], function () {

    Route::post('/login', [LoginController::Class, 'login'])->name('login');
    Route::post('/register', [RegisterController::Class, 'register'])->name('register');
    Route::get('/verifynumber', [forgetpassword::Class, 'verifynumber'])->name('verify.number');
    Route::post('/forgetpassword', [forgetpassword::Class, 'forgetpassword'])->name('forget.password');

});


Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/Dashboard-Data', [DashboardData::Class, 'Dashboard']);
    Route::get('/about-us', [DashboardData::Class, 'outlets']);
    Route::get('/signup-settings', [parts::Class, 'signUpSettings']);
    Route::get('/make', [displaymake::Class, 'display']);
    Route::get('search-make', [displaymake::Class, 'searchMakeModel']);
    Route::get('/model', [displaymodel::Class, 'display']);
    Route::get('/year', [displayyear::Class, 'year']);
    Route::get('/category', [category::Class, 'display']);
    Route::get('/categories', [category::Class, 'categories']);
    //old without make images
    Route::get('/parts', [parts::Class, 'displayparts']);
    //latest with Make Images
    Route::get('/part-detail', [parts::Class, 'partDetail']);
    //old without pagination
    Route::get('/searchparts', [parts::Class, 'searchparts']);
    //latest with pagination
    Route::get('/searchpart', [parts::Class, 'searchPart']);
    Route::post('/addorder', [order::Class, 'addorder']);
    //latest
    Route::post('/add-order', [order::Class, 'addOrders']);
    Route::get('/ongoingorder', [order::Class, 'ongoingorder']);
    Route::get('/ongoingorderdetail', [order::Class, 'ongoingorderdetail']);
    Route::get('/pastorder', [order::Class, 'pastorder']);
    Route::get('/pastorderdetail', [order::Class, 'pastorderdetail']);
    Route::get('/paymentmethod', [paymethod::Class, 'displaypaymethod']);
    Route::post('/addpaydetail', [addpaydetail::Class, 'addpaydetail']);
    Route::get('/displayprofile', [profile::Class, 'displayprofile']);
    Route::post('/updateprofile', [profile::Class, 'updateprofile']);
    Route::post('/changepass', [profile::Class, 'changepass']);
    Route::post('/addcompanydetail', [company::Class, 'addcompanydetail']);
    Route::get('/displaycompanydetail', [company::Class, 'displaycompanydetail']);
    Route::get('/homepage-parts', [parts::Class, 'homepageParts']);
    Route::get('/order', [order::Class, 'order']);
    //latest
    Route::get('/order-detail', [order::Class, 'orderDetail']);
    Route::post('/orderstatus', [order::Class, 'cancelorder']);
    Route::get('/send-app-noti', [NotiController::Class, 'sendAppNoti']);
    Route::post('/delete-user', [profile::Class, 'deleteUser']);
    Route::post('/logout', [LogoutController::Class, 'logout'])->name('logout');

});