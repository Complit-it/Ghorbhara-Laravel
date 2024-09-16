<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerApiController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\ChatMessageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SignupnewController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */
Route::post('signin', [CustomerApiController::class, 'signin']);
Route::post('test', [CustomerApiController::class, 'test']);
// Route::post('test', [PropertyController::class, 'test']);
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('getotp', [CustomerApiController::class, 'otp']);
// Route::get('get-otp', [CustomerApiController::class, 'getnotsupported']);

Route::post('check-customer-otp', [CustomerApiController::class, 'checkOtp']);
// Route::get('check-customer-otp', [CustomerApiController::class, 'getnotsupported']);

Route::post('login', [CustomerApiController::class, 'login']);
// Route::get('login', [CustomerApiController::class, 'getnotsupported']);


// Route::get('login', [CustomerApiController::class, 'getnotsupported']);

Route::post('loginwithOTP', [CustomerApiController::class, 'loginwithOTP']);
// Route::get('loginwithOTP', [CustomerApiController::class, 'getnotsupported']);

// Route::post('forgot-password', [CustomerApiController::class, 'forgotPassword']);
// Route::get('forgot-password', [CustomerApiController::class, 'getnotsupported']);

// Route::post('reset-password', [CustomerApiController::class, 'resetPassword']);
// Route::get('reset-password', [CustomerApiController::class, 'getnotsupported']);
// Route::get('get-models-by-brand', [CustomerApiController::class, 'getnotsupported']);
// Route::post('get-questions-by-brand', [ApiController::class, 'getQuestionsByBrand']);


// Route::post('/register', function(){
//    return response([
//     'message' => 'api working'
//    ]);
// });

// Route::post('/register', [SignupnewController::class, 'register']);
Route::post('/register', [CustomerApiController::class, 'register']);
Route::post('/register_google_user', [CustomerApiController::class, 'register_forGoogleSignin']);



//save property route
Route::post('save_prop', [PropertyController::class, 'save_property']);

Route::post('/upload_property', [ProductController::class,'upload_property']);
Route::get('/get_home_facility', [ProductController::class,'get_home_fac']);
Route::get('/get_property_type', [ProductController::class,'get_property_type']);
Route::get('/get_fav', [ProductController::class,'getUserFavoriteProperties']);
Route::get('/get_all_property', [ProductController::class,'get_all_property']);
Route::get('/get_all_ads', [ProductController::class,'get_all_ads']);
Route::get('/get_ad', [ProductController::class,'get_ad']);
Route::get('/get_user_props', [ProductController::class,'get_user_props']);
Route::get('/get_one_prop', [ProductController::class,'get_one_property']);
Route::post('/add_fav_prop', [ProductController::class,'add_favourite_prop']);
Route::post('/remove_fav_prop', [ProductController::class,'remove_favourite_prop']);
Route::post('/search_properties', [ProductController::class, 'searchProperties']);
Route::post('/test', [ProductController::class, 'test']);
// In your routes file (web.php or api.php)
Route::get('/get_one_prop/{prop_id}', [ProductController::class, 'get_one_property']);
Route::get('/get_search_locations', [ProductController::class, 'get_search_locations']);
Route::get('/get_booked_props', [ProductController::class, 'getUserBookedProperties']);
Route::get('/getBookedPropertiesByUser', [ProductController::class, 'getBookedPropertiesByUser']);

Route::apiResource('chat', ChatController::class)->only(['index','store','show']);
Route::post('/create-order', [RazorpayController::class, 'createOrder']);
Route::post('/verify-payment', [RazorpayController::class, 'verifyPayment']);
Route::post('/save_booking_details', [ProductController::class, 'save_booking_details']);
Route::post('/update_profile', [ProductController::class, 'updateProfile']);
Route::post('/save_inquiry', [ProductController::class, 'save_inquiry']);
// Route::apiResource('chat_message', ChatMessageController::class)->only(['index','store']);
// Route::apiResource('user', UserController::class)->only(['index']);

