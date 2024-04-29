<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/dump', function()
{
    exec('php artisan cache:clear');
//    shell_exec('composer require maatwebsite/excel');
//    exec('composer dump-autoload -o');
//    exec('composer require maatwebsite/excel');
    echo 'composer dump-autoload complete';
});
   Route::post('/model-by-make', 'HomeController@getmodelByMake')->name('model.by.make');
Route::get('/user-login', 'User\UserController@userLogin')->name('user.login');
Route::get('/user-signup', 'User\UserController@userSignup')->name('user.signup');
Route::post('/user-store', 'User\UserController@userStore')->name('user.store');
Route::get('/contactus', 'User\UserController@contactus')->name('contactus');
Route::get('/user-payment', 'User\UserController@payment')->name('user.payment');
Route::get('/aboutus', 'User\UserController@aboutUs')->name('aboutus');
Route::get('/product-details/{id}', 'HomeController@productDetail')->name('product.details');
Route::get('/services', 'User\UserController@services')->name('services');
Route::get('/stock', 'HomeController@stock')->name('stock');
Route::post('/contactUs-store', 'HomeController@contactStore')->name('contactUs.store');
Route::post('/partInquire-store', 'HomeController@inquireStore')->name('partInquire.store');
Route::get('/get-cities', 'User\UserController@getCities')->name('get-cities');
Route::post('/advance-search', 'User\UserController@advanceSearch')->name('advance.search');
Route::get('/advance-search', 'User\UserController@advanceSearch')->name('advance.search');
Route::post('/get-shipment-details', 'HomeController@getShipmentDetails');

  
Route::get('/admin-login', function () {
    return view('user.login');
});
Route::get('/{type?}', 'HomeController@index')->where('type', 'new-arrival|featured')->name('/');

Route::get('/clear-cache', function() {
    \Artisan::call('optimize:clear');
});

Route::get('/migrate', function() {
    \Artisan::call('migrate');
});

Auth::routes();
Route::get('/index', 'Admin\ClientController@welcome');


Route::get('/replace-duplicate-model', 'Admin\SettingsController@replaceDuplicateModel');
Route::get('/replace-image-extension', 'Admin\SettingsController@replaceImageExtension');
Route::get('/send-communication-app', 'Admin\NotificationController@send_comm_app_notification')->name('admin.send.communication.app');
Route::group(['middleware' => 'auth'], function () {

    Route::get('/admin-login', function() {

        return redirect()->route('dashboard');
    });

    Route::get('/home', 'HomeController@index')->name('home');
 
    Route::get('/update-images', 'Admin\ClientController@updateImages')->name('update.images');

    Route::get('/client-profile', 'Admin\ClientController@client_profile')->name('client.profile');

    Route::delete('/delete-image/{id}', 'Admin\PartController@deleteImage');

     Route::post('/get-location-by-country', 'Admin\PartController@getlocationBycountry')->name('getlocationBycountry');
    Route::get('/parts', 'Admin\ClientController@client_list')->name('sellers.parts');
    Route::get('top-trending/parts', 'Admin\PartController@showTrendingParts')->name('trends.parts');
    Route::get('/add-parts/{partId?}', 'Admin\PartController@addParts')->name('sellers.parts.add');
    Route::get('/parts/part-details/{partId}', 'Admin\PartController@partDetails')->name('sellers.parts.details');
    Route::get('/parts/make/model', 'Admin\PartController@makeModel')->name('parts.make.model');
    Route::post('/parts/add/{partId?}', 'Admin\PartController@addPart')->name('parts.add');
    Route::get('/parts/edit', 'Admin\PartController@editPart')->name('part.edit');
    Route::post('/parts/delete', 'Admin\PartController@deletePart')->name('delete.parts');
    Route::post('/part/model/delete', 'Admin\PartController@removePartModel')->name('delete.part.modal');
    Route::post('/Model/delete', 'Admin\ClientController@deleteModel')->name('delete.model');
    Route::get('/customer-list', 'Admin\ClientController@customerlist')->name('customer.list');
    Route::get('/customer/list/detail/{userId}', 'Admin\ClientController@customerlistDetail')->name('customer.list.detail');
    Route::get('/customer-list/approve', 'Admin\ClientController@approveCustomer')->name('approve.user');
    Route::get('/order-list', 'Admin\OrderController@Orders')->name('order.list');
    Route::get('/order-detail', 'Admin\OrderController@orderDetail')->name('order.detail');
    Route::get('/edit-order-detail', 'Admin\OrderController@editOrderDetail')->name('edit.order.detail');
    Route::post('/update-order-detail', 'Admin\OrderController@updateOrderDetail')->name('update.order.detail');
    Route::post('/order-list/approve', 'Admin\PartController@approveOrder')->name('order.approve');
    // Route::get('/order-list/approve', 'Admin\PartController@approveOrder')->name('order.approves');
    Route::post('/order-list/delete', 'Admin\PartController@deleteOrder')->name('orders.delete');
    Route::post('/order-list/cancel', 'Admin\OrderController@cancelOrder')->name('orders.cancel');
    Route::post('/order-list/dispatch', 'Admin\OrderController@dispatchOrder')->name('orders.dispatch');
    Route::post('/order-list/paystatus', 'Admin\OrderController@Paystatus')->name('pay.status');
    Route::get('/today-order', 'Admin\OrderController@todayOrder')->name('today.order');
    Route::get('/update-parts-prices-in-orderItem', 'Admin\OrderController@updatePartsPrices')->name('update.parts.prices');


    // tracking
    Route::get('/sourcing-leads', 'Admin\TrackingController@sourcingLeads')->name('sourcing.leads');
    Route::get('/adds/{addId?}', 'Admin\TrackingController@adds')->name('adds');
    Route::get('/membership', 'Admin\TrackingController@membership')->name('membership');
    Route::get('/settings/{modelId?}', 'Admin\SettingsController@settings')->name('settings');
    Route::post('/settings/add/{modelId?}', 'Admin\SettingsController@addSettings')->name('add.settings');
    Route::get('/tracking-list/user/seller/detail', 'Admin\ProductController@getUserData')->name('user.details');
    Route::get('/tracking-list/company-profile/{id}', 'Admin\TrackingController@companyProfile')->name('company.profile');
    Route::post('/tracking-list/add-product/{id}/{productId?}', 'Admin\ProductController@addProducts')->name('products.add');
     Route::get('/tracking-list/add-product/edit-product/details', 'Admin\ProductController@editProduct')->name('product.edit');
    Route::get('/tracking-list/company-product/details/{id}', 'Admin\TrackingController@productDetails')->name('company.product.detail');
    Route::get('/tracking-list/user/{id}', 'Admin\TrackingController@user')->name('company.user');
    Route::post('/tracking-list/user-detail/edit/{id}', 'Admin\ProductController@editUser')->name('user.edit');
    Route::get('/admin/{adminId?}', 'Admin\TrackingController@admin')->name('admin');
    Route::post('/add-admin/{adminId?}', 'Admin\TrackingController@addAdmin')->name('admin.add');
    Route::get('/feedback', 'Admin\TrackingController@feedback')->name('feedback');
    Route::get('/manufacturers', 'Admin\TrackingController@manufacturer')->name('manufacturer');
    Route::post('/update-manufacturer', 'Admin\TrackingController@updateManufacturer')->name('manufacturer.update');
    Route::get('/fetch-manufacturer', 'Admin\TrackingController@getManufacturer')->name('manufacturer.fetch');

    // trackers
    Route::post('/delete-users', 'Admin\TrackersController@deleteUser');
    Route::post('/unblock-user', 'Admin\ClientController@UnblockCustomer')->name('unblock.user');
    Route::get('/search-parts', 'Admin\ClientController@searchpart')->name('parts.search');
    Route::get('/search-buyer', 'Admin\ClientController@searchBuyer')->name('buyer.search');
    Route::get('/search-model', 'Admin\SettingsController@searchModel')->name('model.search');
    Route::get('/tracker-detail', 'Admin\TrackersController@tracker_detail');
    Route::post('/update_tracker_status', 'Admin\TrackersController@update_tracker_status')->name('update.tracker.status');
    Route::get('/tracker-profile', 'Admin\TrackersController@tracker_detail')->name('tracker.profile');
    Route::post('/update-tracker', 'Admin\TrackersController@update_trackers')->name('update.tracker');

    Route::get('/dashboard', 'Admin\DashboardController@dashboard')->name('dashboard');
    Route::post('/approve-leads', 'Admin\DashboardController@approveLeads');
    Route::post('/delete-leads', 'Admin\DashboardController@deleteLeads');
    Route::post('/delete-pending-products', 'Admin\DashboardController@deletePendingProducts');
    Route::get('/settings/category/details/{categoryId?}', 'Admin\SettingsController@category')->name('settings.category');
    Route::get('/settings/feature/details/{featureId?}', 'Admin\SettingsController@feature')->name('settings.feature');
    Route::get('/settings/fuel/details/{fuelId?}', 'Admin\SettingsController@fuel')->name('settings.fuel');
    Route::get('/settings/make/details/{makeId?}', 'Admin\SettingsController@make')->name('settings.make');
    Route::get('/settings/files/view', 'Admin\PartController@userFiles')->name('settings.files');
    Route::post('/settings/files/add', 'Admin\PartController@addPartsData')->name('parts.data.add');
    Route::post('/settings/files/update', 'Admin\PartController@updatePartsData')->name('parts.data.update');
    Route::get('remove-parts-withs-deleted-cats', 'Admin\PartController@removePartswithDeletedCats')->name('remove.duplicate.parts');
    // Route::get('remove-parts-withs-deleted-catss', 'Admin\PartController@removePartswithDeletedCatss')->name('remove.duplicate.partss');
    Route::post('/settings/add-category/details/{categoryId?}', 'Admin\SettingsController@addCategory')->name('settings.add.category');
   Route::post('/settings/delete-all-record' , 'Admin\SettingsController@deleterecord')->name('settings.delete');
    Route::get('/add/category-details', 'Admin\ProductController@getCategoryDetails')->name('settings.category.detail');

    Route::post('/settings/make/{makeId?}', 'Admin\SettingsController@addMake')->name('make.add');
    Route::post('/settings/feature/{featureId?}', 'Admin\SettingsController@addfeature')->name('feature.add');
    Route::post('/settings/fuel/{fuelId?}', 'Admin\SettingsController@addfuel')->name('fuel.add');
    Route::post('/adds/add/{addId?}', 'Admin\ProductController@addAds')->name('add.ads');
    Route::post('/membership/add', 'Admin\ProductController@addMembership')->name('membership.add');
    Route::post('/delete-user', 'Admin\ClientController@deleteUser');
    Route::post('/approve-product', 'Admin\ProductController@approveProduct');
    Route::post('/delete-ads', 'Admin\ProductController@deleteAds');
    Route::post('/settings/delete-category', 'Admin\ProductController@deleteCategory')->name('admin.category.delete');
    Route::post('/delete-model', 'Admin\SettingsController@deleteModel')->name('settings.model.delete');
    Route::post('/delete-admin', 'Admin\TrackingController@deleteAdmin');
    Route::post('/settings/delete-make', 'Admin\SettingsController@deleteMake')->name('settings.make.delete');
     Route::post('/settings/delete-feature', 'Admin\SettingsController@deleteFeature')->name('settings.feature.delete');
     Route::post('/settings/delete-fuel', 'Admin\SettingsController@deletefuel')->name('settings.fuel.delete');
    Route::get('/search-orders', 'Admin\ProductController@searchorder')->name('search.order');
    Route::post('/tracking-list/company-profile/category-products', 'Admin\ProductController@categoryProducts')->name('category.products');
    Route::get('/feedback/mark-read', 'Admin\ProductController@readFeedback')->name('feedback.read');
    Route::get('/payment', 'Admin\TrackingController@payment')->name('payment');
    Route::post('/delete-payment', 'Admin\TrackingController@deletePayment')->name('payment.delete');
    Route::get('/approve-payment', 'Admin\TrackingController@approvePayment')->name('payment.approve');
    Route::post('/admin/change-password', 'Admin\TrackingController@changePassword')->name('password.change');

    // Communication Urls
    Route::get('/communication/index', 'Admin\CommunicationController@index')->name('index.communication');
    Route::post('/communication/storeSms', 'Admin\CommunicationController@storeSMS')->name('admin.communication.sms.store');
    Route::post('/communication/storeEmail', 'Admin\CommunicationController@storeEmail')->name('admin.communication.email.store');
    Route::post('/communication/storeAppNotification', 'Admin\CommunicationController@storeAppNotification')->name('admin.communication.app-notification.store');

//  Send-noti-url
    Route::get('/send-communication', 'Admin\NotificationController@send_comm_app_notification')->name('admin.send.communication.app');
    Route::get('/send-email-notification', 'Admin\CommunicationController@send_comm_email')->name('admin.communication.send-email');
    Route::get('/export-parts-data', 'Admin\PartController@exportPartsData')->name('sellers.parts.export');

    Route::get('/export-csv-test', 'Admin\PartController@getPartsData')->name('sellers.parts.export.csv');
    Route::get('/export-csv-data', 'Admin\PartController@exportCsvData')->name('sellers.parts.export.csv');
    Route::get('model-details/{id}', 'Admin\PartController@ModelDetail');
    Route::get('top-trending/parts', 'Admin\PartController@showTrendingParts')->name('trends.parts');
    Route::POST('add-trending/', 'Admin\PartController@addTrendingParts')->name('add.trends');
    Route::POST('remove-trending/', 'Admin\PartController@deleteTrendingParts')->name('delete.trends');
    Route::POST('/top-trending/part/edit/{id}', 'Admin\PartController@editTopTrending')->name('trending.edit');
    Route::get('/part-makes', 'Admin\PartController@addMakes')->name('parts.make');

    Route::get('/export-csv', 'Admin\TrackingController@exportCSV');
    // Route::get('/export-toyota-csv', 'Admin\TrackingController@exportToyotaModelCSVs');
    Route::get('/favorites', 'HomeController@favorites')->name('favorites');
    Route::post('/add-to-favorite/{id}', 'HomeController@addToFavorite')->name('add.to.favorite');


});