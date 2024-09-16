<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ProfileControler;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerApiController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::get('/', function () {
    return view('welcome');
});

// Route::view('admin', 'Admin');
Route::get('/admintable', [UserController::class, 'admintable'])->name('admintable');
Route::get('/admintable_users', [UserController::class, 'admintable_users'])->name('admintable_users');
Route::get('/admin', [UserController::class, 'admin'])->name('admin');
Route::get('/add_prop_type', [UserController::class, 'add_prop_type'])->name('prop_type');

Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

Route::get('/property-type/create', [UserController::class, 'add_prop_type'])->name('add_prop_type');
Route::post('/property-type', [UserController::class, 'store_property_type'])->name('store_property_type');

Route::post('test', [CustomerApiController::class, 'test']);
Route::get('/owners.php', function () {
    return view('owners');
});

Route::get('/provider.php', function () {
    return view('provider');
});

Route::get('/journey.php', function () {
    return view('journey');
});

Route::get('/gov-info.php', function () {
    return view('gov-info');
});

Route::get('/safety.php', function () {
    return view('safety');
});

Route::get('/about.php', function () {
    return view('about');
});

Route::get('/government-services', 'App\Http\Controllers\PublicController@gservices')->name('government-services');
Route::get('/road-safety', 'App\Http\Controllers\PublicController@roadSafety')->name('road-safety');
Route::get('/before-journey', 'App\Http\Controllers\PublicController@beforeJourney')->name('before-journey');

Route::get('/admin/login', [AuthController::class, 'getLogin'])->name('getLogin');
Route::get('/admin/login', [AuthController::class, 'getLogin'])->name('login');
Route::post('/admin/login', [AuthController::class, 'loginpost'])->name('loginpost');

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::group(['middleware' => ['auth']], function () {

    Route::get('/suspend-vendor/{id}', 'App\Http\Controllers\Admin\ProfileControler@suspendVendor')->name('suspend-vendor');
    Route::get('/revive-vendor/{id}', 'App\Http\Controllers\Admin\ProfileControler@reviveVendor')->name('revive-vendor');

    Route::get('/dashboard', [ProfileControler::class, 'dashboard'])->name('dashboard');
    Route::get('/viewVendors', 'App\Http\Controllers\Admin\ProfileControler@viewVendors')->name('viewVendors');
    Route::post('/editVendorPost', 'App\Http\Controllers\Admin\ProfileControler@editVendorPost')->name('editVendorPost');
    Route::post('/editVendor', 'App\Http\Controllers\Admin\ProfileControler@editVendor')->name('editVendor');

    Route::get('/auditTrail', 'App\Http\Controllers\AdminController@auditTrail')->name('auditTrail');

    Route::get('/service', 'App\Http\Controllers\AdminController@service')->name('service');
    Route::post('/service', 'App\Http\Controllers\AdminController@servicePost')->name('service');
    Route::get('/edit-service/{id}', 'App\Http\Controllers\AdminController@editService')->name('edit-service');
    Route::post('/edit-service', 'App\Http\Controllers\AdminController@updateService')->name('edit-service');
    Route::get('/edit-service', 'App\Http\Controllers\AdminController@service')->name('edit-service');
    Route::get('/delete-service/{id}', 'App\Http\Controllers\AdminController@deleteService')->name('delete-service');

    // vehicle-brand
    Route::get('/vehicle-brand', 'App\Http\Controllers\AdminController@vBrand')->name('vehicle-brand');
    Route::post('/vehicle-brand', 'App\Http\Controllers\AdminController@vBrandPost')->name('vehicle-brand');
    Route::get('/delete-vehicle-brand/{id}', 'App\Http\Controllers\AdminController@deleteVBrand')->name('delete-vehicle-brand');
    Route::get('/edit-vehicle-brand/{id}', 'App\Http\Controllers\AdminController@editVBrand')->name('edit-vehicle-brand');
    Route::post('/edit-vehicle-brand', 'App\Http\Controllers\AdminController@updateVBrand')->name('edit-vehicle-brand');
    Route::get('/edit-vehicle-brand', 'App\Http\Controllers\AdminController@vBrand')->name('edit-vehicle-brand');

    Route::get('/service-sub-category', 'App\Http\Controllers\AdminController@sscategory')->name('service-sub-category');
    Route::post('/service-sub-category', 'App\Http\Controllers\AdminController@sscategoryPost')->name('service-sub-category');
    Route::get('/delete-sub-category/{id}', 'App\Http\Controllers\AdminController@dscategory')->name('delete-sub-category');
    Route::get('/edit-sub-category/{id}', 'App\Http\Controllers\AdminController@editscategory')->name('edit-sub-category');
    Route::post('/edit-sub-category', 'App\Http\Controllers\AdminController@updatescategory')->name('edit-sub-category');
    Route::get('/edit-sub-category', 'App\Http\Controllers\AdminController@sscategory')->name('edit-sub-category');

    //Add Vehicle model
    Route::get('/vehicle-model', 'App\Http\Controllers\AdminController@vModel')->name('vehicle-model');
    Route::post('/vehicle-model', 'App\Http\Controllers\AdminController@vModelPost')->name('vehicle-model');
    Route::get('/delete-vehicle-model/{id}', 'App\Http\Controllers\AdminController@deleteVModel')->name('delete-vehicle-model');
    Route::get('/edit-vehicle-model/{id}', 'App\Http\Controllers\AdminController@editVModel')->name('edit-vehicle-model');
    Route::post('/edit-vehicle-model', 'App\Http\Controllers\AdminController@updateVModel')->name('edit-vehicle-model');
    Route::get('/edit-vehicle-model', 'App\Http\Controllers\AdminController@vModel')->name('edit-vehicle-model');

    Route::get('/add-notification', 'App\Http\Controllers\AdminController@sendnotification')->name('add-notification');
    Route::post('/add-notification', 'App\Http\Controllers\AdminController@sendnotificationPost')->name('add-notification');

    // vehicle-services
    Route::get('/vehicle-services', 'App\Http\Controllers\AdminController@vServices')->name('vehicle-services');
    Route::post('/vehicle-services', 'App\Http\Controllers\AdminController@vServicesPost')->name('vehicle-services');
    Route::get('/delete-vehicle-services/{id}', 'App\Http\Controllers\AdminController@deleteVServices')->name('delete-vehicle-services');
    Route::get('/edit-vehicle-services/{id}', 'App\Http\Controllers\AdminController@editVServices')->name('edit-vehicle-services');
    Route::post('/edit-vehicle-services', 'App\Http\Controllers\AdminController@updateVServices')->name('edit-vehicle-services');

    // vehicle-category
    Route::get('/vehicle-category', 'App\Http\Controllers\AdminController@vCategory')->name('vehicle-category');
    Route::post('/vehicle-category', 'App\Http\Controllers\AdminController@vCategorysPost')->name('vehicle-category');
    Route::get('/delete-vehicle-category/{id}', 'App\Http\Controllers\AdminController@deleteVCategory')->name('delete-vehicle-category');
    Route::get('/edit-vehicle-category/{id}', 'App\Http\Controllers\AdminController@editVCategory')->name('edit-vehicle-category');
    Route::post('/edit-vehicle-category', 'App\Http\Controllers\AdminController@updateVCategory')->name('edit-vehicle-category');

    // vehicle-services
    Route::get('/view-vendor-services/{id}', 'App\Http\Controllers\AdminController@vendorServiceDetails')->name('view-vendor-services');
    Route::get('/view-vendor-services', 'App\Http\Controllers\AdminController@viewVendors')->name('view-vendor-services');

    // app-banner
    Route::get('/app-banner', 'App\Http\Controllers\AdminController@appBanner')->name('app-banner');
    Route::post('/app-banner', 'App\Http\Controllers\AdminController@appBannerPost')->name('app-banner');
    Route::post('/delete-app-banner', 'App\Http\Controllers\AdminController@deleteAppBanner')->name('delete-app-banner');
    Route::post('/edit-app-banner', 'App\Http\Controllers\AdminController@editAppBanner')->name('edit-app-banner');
    Route::post('/edit-app-banner-post', 'App\Http\Controllers\AdminController@editAppBannerPost')->name('edit-app-banner-post');
    Route::get('/delete-app-banner', 'App\Http\Controllers\AdminController@appBanner')->name('delete-app-banner');
    Route::get('/edit-app-banner', 'App\Http\Controllers\AdminController@appBanner')->name('edit-app-banner');
    Route::get('/edit-app-banner-post', 'App\Http\Controllers\AdminController@appBanner')->name('edit-app-banner-post');
    Route::get('/problem-questionaire', 'App\Http\Controllers\AdminController@problemQuestionaire')->name('problem-questionaire');
    Route::post('/problem-questionaire', 'App\Http\Controllers\AdminController@problemQuestionairePost')->name('problem-questionaire');

    // delete-question
    Route::get('/delete-question/{id}', 'App\Http\Controllers\AdminController@deleteQuestion')->name('delete-question');
    Route::get('/edit-question/{id}', 'App\Http\Controllers\AdminController@editQuestion')->name('edit-question');



});

//Routes for users which have auth access
// Route::group(['middleware' => ['auth', 'role:administrator']], function () {
    Route::get('/dashboard', [ProfileControler::class, 'dashboard'])->name('dashboard');
    Route::get('/viewVendors', 'App\Http\Controllers\Admin\ProfileControler@viewVendors')->name('viewVendors');
    Route::post('/editVendorPost', 'App\Http\Controllers\Admin\ProfileControler@editVendorPost')->name('editVendorPost');
    Route::post('/editVendor', 'App\Http\Controllers\Admin\ProfileControler@editVendor')->name('editVendor');

    Route::get('/auditTrail', 'App\Http\Controllers\AdminController@auditTrail')->name('auditTrail');

    Route::get('/sendnotification', 'App\Http\Controllers\Admin\ProfileControler@sendnotification')->name('sendnotification');
// });

Route::get('/admin/dashboard',[ProfileControler::class,'data'])->name('data');

Route::post('/register', [SignupController::class, 'register']);
