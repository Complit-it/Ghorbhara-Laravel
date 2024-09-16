<?php

namespace App\Http\Controllers;

use App\Models\Banners;
use App\Models\GbTrnProperty;
use App\Models\OTPVerification;
use App\Models\User;
use App\Models\Property;
use App\Models\GbMstPropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\password;

class CustomerApiController extends Controller
{
    //

    public function getnotsupported()
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Get Method Not Supported',
        ], $status = 500);
    }

    public function otp(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone_no' => 'required|digits:10',
        ]);
        if ($validator->fails()) {
            $messages = $validator->messages();

            return response()->json([
                'status' => 'error',
                'message' => $messages,
            ], 422);
        }
        $numbers = array((int) $request->phone_no);
        $sender = urlencode('CMPLIT');
        $otp = rand(100000, 999999);
        // insertOTP
        $otpVerification = OTPVerification::where('phone_no', $request->phone_no)->first();

        //check for test phone

        if (in_array($request->phone_no, TestPhone::testPhone())) {
            $otp = 123456;

            if ($otpVerification) {
                $otpVerification->otp = SHA1($otp);
                $otpVerification->valid_upto = now()->addMinutes(5);
                $otpVerification->status = 0;
                $otpVerification->save();
            } else {

                $addOTP = OTPVerification::updateOrCreate([
                    'phone_no' => $request->phone_no,
                    'otp' => SHA1($otp),
                    'valid_upto' => date('Y-m-d H:i:s', strtotime('+5 minutes')),
                    'status' => 0,
                ]);
            }
        } else {
            if ($otpVerification) {
                $otpVerification->otp = SHA1($otp);
                $otpVerification->valid_upto = now()->addMinutes(5);
                $otpVerification->status = 0;
                $otpVerification->save();
            } else {

                $addOTP = OTPVerification::updateOrCreate([
                    'phone_no' => $request->phone_no,
                    'otp' => SHA1($otp),
                    'valid_upto' => date('Y-m-d H:i:s', strtotime('+5 minutes')),
                    'status' => 0,
                ]);
            }

            $message = 'Your OTP for logging into GhorBhara is ' . $otp . '. Please do not share your OTP with anyone.';

            $numbers = implode(',', $numbers);
            $apiKey = 'NjY1MjM3MzI0NDc4NDk0ZjMzNDE2MzU2NmI2ODZiNDU=';
            // Prepare data for POST request
            $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);

            // Send the POST request with cURL
            $ch = curl_init('https://api.textlocal.in/send/');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'OTP sent Successfully',
        ], $status = 200);
    }

    public function checkOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_no' => 'required|digits:10',
            'otp' => 'required|digits:6',
        ]);
        if ($validator->fails()) {
            $messages = $validator->messages();

            return response()->json([
                'status' => 'error',
                'message' => $messages,
            ], 422);
        }
        $phone_no = $request->phone_no;
        $otp = $request->otp;

        //Check OTP
        $checkifOTPPresent = OTPVerification::where('phone_no', $phone_no)
            ->where('valid_upto', '>', NOW())
            ->where('status', '0')->first();

        if (!$checkifOTPPresent) {
            return response()->json([
                'status' => 'error',
                'message' => 'OTP is expired.',
            ], $status = 410);
        }

        if ($checkifOTPPresent->otp != SHA1($otp)) {
            return response()->json([
                'status' => 'error',
                'message' => 'OTP is invalid.',
            ], $status = 410);
        }

        if ($checkifOTPPresent->otp == SHA1($otp)) {
            $checkifOTPPresent->status = 1;
            $checkifOTPPresent->save();

            return response()->json([
                'status' => 'success',
                'message' => 'OTP verified successfully.',
            ], $status = 200);
        }
    }

    public function register(Request $request)
    {
        // print($request->phone_no);exit;
        $validator = Validator::make($request->json()->all(), [
            'name' => 'required',
            // 'phone_no' => 'required',
            // 'phone_no' => 'required|digits:12',
            'email' => 'required|email',
            'password' => 'required',
            // 'device_id' => 'required',
            // 'device_type' => 'required',
            // 'fcm_token' => 'required',
        ]);
        // return response()->json([
        //     'status' => $request->userType,
        //     'message' => 'User already registered.',
        // ], $status = 410);


        if ($validator->fails()) {
            $messages = $validator->messages();
            return response()->json([
                'status' => 'error',
                'message' => $messages,
            ], 422);
        }

        // ------------------------------------------DEVELOPMENT PHASE IF-------------------------------------------------
        if ($request->phone_no != '8099444024') {
            if ($request->has('phone_no')) {
                $checkifUserPresent = User::where('phone', $request->phone_no)->first();
                if ($checkifUserPresent) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'User already registered.',
                    ], $status = 410);
                }
            }
        }


        $checkifUserPresent = User::where('email', $request->email)->first();
        if ($checkifUserPresent) {
            return response()->json([
                'status' => 'error',
                'message' => 'User already registered.',
            ], $status = 410);
        }

        // error_log($request->name);
        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'userType' => $request->userType,
            'password' => Hash::make($request->password),
            'google_id' => $request->google_id,
            // 'device_id' => $request->device_id,
            // 'device_type' => $request->device_type,
            // 'fcm_token' => $request->fcm_token,
        ]);

        // $user1 =array(
        //     'name' => "asd",
        //     'phone' => "asd",
        //     'email' => "asd",
        //     'password' => Hash::make($request->password),
        // );
        // print('sdfsd');exit;
        $token = $user->createToken('authToken')->accessToken;

        return response()->json([
            'status' => 'success',
            'message' => 'User registered successfully.',
            'token' => $token,
            'user' => $user,
        ], $status = 200);
    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->json()->all(), [
            'phone_no' => 'required|digits:10',
            'password' => 'required',
            "fcm_token" => "required",
        ]);

        if ($validator->fails()) {
            $messages = $validator->messages();
            return response()->json([array(
                'status' => 'error',
                'message' => $messages,
            )], 200);
        }

        $user = User::where('phone', $request->phone_no)->first();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not registered.',
            ], $status = 200);
        }

        if (Hash::check($request->password, $user->password)) {
            // $user->fcm_token = $request->fcm_token;
            // $user->save();

            // $user->addRole('customer');

            $token = $user->createToken('authToken')->accessToken;
            // return ($user);
            return response()->json([
                'status' => 'success',
                'message' => 'User logged in successfully.',
                'token' => $token,
                'user' => $user,
            ], $status = 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid Credentials.',
            ], $status = 200);
        }
    }

    public function loginwithOTP(Request $request)
    {
        $validator = Validator::make($request->json()->all(), [
            'phone_no' => 'required|digits:12',
            'otp' => 'required|digits:6',
            "fcm_token" => "required",
        ]);

        if ($validator->fails()) {
            $messages = $validator->messages();
            return response()->json([array(
                'status' => 'error',
                'message' => $messages,
            )], 200);
        }

        $user = User::where('phone', $request->phone_no)->first();
        if (!$user) {
            //create a user
            $user = User::create([
                'name' => '',
                'email' => $request->phone_no,
                'phone' => $request->phone_no,
                'photo_url' => '',
                'phone_otp' => '',
                'email_otp' => '',
                'fcm_token' => $request->fcm_token,
                'password' => Hash::make($request->phone_no),

            ]);
            $user->addRole('customer');
        }

        //Check OTP
        $checkifOTPPresent = OTPVerification::where('phone_no', $request->phone_no)
            ->where('valid_upto', '>', NOW())
            ->where('status', '0')->first();

        if (!$checkifOTPPresent) {
            return response()->json([
                'status' => 'error',
                'message' => 'OTP is expired.',
            ], $status = 200);
        }

        if (SHA1($request->otp) == $checkifOTPPresent->otp) {

            $checkifOTPPresent->status = 1;
            $checkifOTPPresent->save();

            $user->fcm_token = $request->fcm_token;
            $user->save();

            $token = $user->createToken('authToken')->accessToken;
            return response()->json([
                'status' => 'success',
                'message' => 'User logged in successfully.',
                'token' => $token,
                'user' => $user,
            ], $status = 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid Credentials.',
            ], $status = 200);
        }
    }

    public function getBannersforHome()
    {
        $banners = Banners::where('status', 1)
            ->where('scheduledfrom', '<', NOW())
            ->where('scheduledto', '>', NOW())
            ->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Banners fetched successfully.',
            'banners' => $banners,
        ], $status = 200);
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->json()->all(), [
            'userId' => 'required',
            'email' => 'required',
            'phone' => 'required|digits:12',
            'dob' => 'required',
            'gender' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = $validator->messages();
            return response()->json([array(
                'status' => 'error',
                'message' => $messages,
            )], 200);
        }

        $user = User::find($request->userId);
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.',
            ], $status = 200);
        }
        //check for duplicate phone
        $existinguser = User::where('phone', $request->phone)->first();

        if ($existinguser && $existinguser->id != $request->userId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Phone number already registered.',
            ], $status = 200);
        }

        $user->email = $request->email;
        $user->phone = $request->phone;
    }


    //singnin by Nitin
    public function signin(Request $request)

    {

        $validator = Validator::make($request->json()->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = $validator->messages();

            return response()->json([
                'status' => 'error',
                'message' => $messages
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User not registered'], $status = 401);
        }
        // 

        if (Hash::check($request->password, $user->password)) {
            // $user->fcm_token = $request->fcm_token;
            // $user->save();

            // $user->addRole('customer');

            $token = $user->createToken('authToken')->accessToken;
            return response()->json([
                'token' => $token,
                'status' => 'successs',
                'message' => 'User logged in succeffullly.',
                'user' => $user,
            ], $status = 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Invalid credentials.'], $status = 401);
        }
    }

    public function test()
    {

        $properties = GbMstPropertyType::all();
        print($properties);
        exit;
        //  php artisan make:migration create_gb_trn_properties_table



    }

    //function to save user details, who logins usign google signin
    public function register_forGoogleSignin(Request $request)
    {

        // ------------------------------------------DEVELOPMENT PHASE IF-------------------------------------------------
        if ($request->phone_no != '8099444024') {
            if ($request->has('phone_no')) {
                $checkifUserPresent = User::where('phone', $request->phone_no)->first();
                if ($checkifUserPresent) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'User already registered.',
                        
                    ], $status = 410);
                }
            }
        }


        $checkifUserPresent = User::where('email', $request->email)->first();
        if ($checkifUserPresent) {
            return response()->json([
                'status' => 'success',
                'message' => 'User already registered.',
                'user'=>$checkifUserPresent
            ], $status = 200);
        }


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'google_id' => $request->google_id,
            'password' => Hash::make('GhorbharaUser@123'),

        ]);


        return response()->json([
            'status' => 'success',
            'message' => 'User registered successfully.',
            'user'=> $user,
        ], $status = 200);
    }
}
