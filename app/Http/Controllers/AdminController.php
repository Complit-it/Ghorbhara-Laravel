<?php

namespace App\Http\Controllers;

use App\Models\AuditTrail;
use App\Models\Banners;
use App\Models\Options;
use App\Models\ProblemQuestions;
use App\Models\PushNotifications;
use App\Models\Services;
use App\Models\ServicesProviderType;
use App\Models\User;
use App\Models\VehicleBrand;
use App\Models\VehicleCategory;
use App\Models\VehicleModel;
use App\Models\VehicleService;
use App\Models\worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Validator;

class AdminController extends Controller
{
    //

    // Get Audit Trail
    public function auditTrail()
    {
        $auditTrail = AuditTrail::select('id', 'task', 'IP', 'userId', 'userName', 'created_at')->limit(500)->get();
        return view('adminPages.auditTrail', [
            'title' => 'AdminPortal |  Audirt Trail',
            'auditTrails' => $auditTrail,
        ]);
    }

    public static function updateAuditTrail($task)
    {
        $userId = auth()->user()->id;
        $userName = auth()->user()->name;
        $ipAddress = $_SERVER['REMOTE_ADDR'];

        $auditTrail = new AuditTrail();

        $auditTrail->task = $task;
        $auditTrail->IP = $ipAddress;
        $auditTrail->userId = $userId;
        $auditTrail->userName = $userName;
        $auditTrail->save();
    }

    // Get Service
    public function service()
    {
        $cities = ServicesProviderType::select()->get();
        return view('adminPages.addCategory', [
            'title' => 'AdminPortal | Add Category',
            'cities' => $cities,
            'selectCatId' => null,
            // 'alertDescription' => 'Invalid OTP',
            // 'alertTitle' => 'Error',
            // 'alertIcon' => 'error'
        ]);
    }

    public function servicePost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1',
            'preliminaryService' => 'required',

        ]);
        if ($validator->fails()) {
            $cities = ServicesProviderType::select()->get();
            return view('adminPages.addCategory', [
                'title' => 'AdminPortal | Add Category',
                'cities' => $cities,
                'selectCatId' => null,
                'alertDescription' => 'Service name and the Preliminary Service Filed is required',
                'alertTitle' => 'Error',
                'alertIcon' => 'error',
            ]);
        }
        $addCity = ServicesProviderType::create([
            'name' => $request->name,
            'preliminaryService' => $request->preliminaryService,
        ]);

        $cities = ServicesProviderType::select()->get();

        return view('adminPages.addCategory', [
            'title' => 'AdminPortal | Add Category',
            'cities' => $cities,
            'selectCatId' => null,

            'alertDescription' => 'Service added successfully',
            'alertTitle' => 'Success',
            'alertIcon' => 'success',
        ]);
    }

    //Delete service
    public function deleteService($id)
    {
        $getDatafromModels = Services::where('serviceproviderId_fk', $id)->first();
        if ($getDatafromModels) {
            return back()->with('message', 'Service Provider cannot be deleted as it is associated with some Service.');
        }

        $delete = ServicesProviderType::where('id', $id)->delete();
        if ($delete) {
            $cities = ServicesProviderType::select()->get();
            //return to the previous page with message Please do not change the url
            return back()->with('message', 'Service Deleted.');

        }
    }

    //Edit service
    public function editService($id)
    {

        $selectCatId = ServicesProviderType::where('id', $id)->first();

        $cities = ServicesProviderType::select()->get();
        return view('adminPages.addCategory', [
            'title' => 'AdminPortal | Add Category',
            'cities' => $cities,
            'selectCatId' => $selectCatId,
            // 'alertDescription' => 'Service added successfully',
            // 'alertTitle' => 'Success',
            // 'alertIcon' => 'success',
        ]);
    }

    //Update service
    public function updateService(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1',
            'preliminaryService' => 'required',

        ]);
        if ($validator->fails()) {
            $cities = ServicesProviderType::select()->get();
            return view('adminPages.addCategory', [
                'title' => 'AdminPortal | Add Category',
                'cities' => $cities,
                'selectCatId' => null,
                'alertDescription' => 'Service name required',
                'alertTitle' => 'Error',
                'alertIcon' => 'error',
            ]);
        }
        $update = ServicesProviderType::where('id', $request->id)->update([
            'name' => $request->name,
            'preliminaryService' => $request->preliminaryService,
        ]);
        if ($update) {
            // return back()->with('message', 'Service Updated.');
            $cities = ServicesProviderType::select()->get();
            return view('adminPages.addCategory', [
                'title' => 'AdminPortal | Add Category',
                'cities' => $cities,
                'selectCatId' => null,
                'alertDescription' => 'Service updated successfully',
                'alertTitle' => 'Success',
                'alertIcon' => 'success',
            ]);

        }
    }

    public function vBrand()
    {
        $cities = VehicleBrand::select()->get();
        return view('adminPages.addBrand', [
            'title' => 'AdminPortal | Add Category',
            'cities' => $cities,
            'selectCatId' => null,
            // 'alertDescription' => 'Invalid OTP',
            // 'alertTitle' => 'Error',
            // 'alertIcon' => 'error'
        ]);
    }

    public function vBrandPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1',
            'image' => 'required',
        ]);
        if ($validator->fails()) {
            $cities = ServicesProviderType::select()->get();
            return view('adminPages.addBrand', [
                'title' => 'AdminPortal | Add Vehicle Brand',
                'cities' => $cities,
                'selectCatId' => null,
                'alertDescription' => 'Vehicle Brand name required',
                'alertTitle' => 'Error',
                'alertIcon' => 'error',
            ]);
        }

        $image = $request->file('image');
        $pathName = time() . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('/images/brands/');
        $image->move($destinationPath, $pathName);

        $addCity = VehicleBrand::create([
            'name' => $request->name,
            'image' => '/images/brands/' . $pathName,
        ]);

        $cities = VehicleBrand::select()->get();

        return view('adminPages.addBrand', [
            'title' => 'AdminPortal | Add Vehicle Brand',
            'cities' => $cities,
            'selectCatId' => null,

            'alertDescription' => 'Vehicle Brand added successfully',
            'alertTitle' => 'Success',
            'alertIcon' => 'success',
        ]);
    }

    //Delete service
    public function deleteVBrand($id)
    {
        $getDatafromModels = VehicleCategory::where('vehicleBrandId_fk', $id)->first();
        if ($getDatafromModels) {
            return back()->with('message', 'Vehicle Brand cannot be deleted as it is associated with some Category.');
        }

        $delete = VehicleBrand::where('id', $id)->first();
        if ($delete) {
            $this->deleteExistingFile($delete->image);
            // Delete the record
            $delete->delete();
            // Return to the previous page with a message
            return back()->with('message', 'Vehicle Model Deleted.');
        }
    }

    // Get Service Sub Category
    public function sscategory()
    {
        $allSubcategories = Services::with('service')->get();

        // $allSubcategories = Services::select()->get();
        $allcategories = ServicesProviderType::select()->get();

        return view('adminPages.addSubCategory', [
            'title' => 'AdminPortal | Add Service Sub Category',
            'allSubcategories' => $allSubcategories,
            'allcategories' => $allcategories,
            'selectSubCatId' => null,
            'editId' => null,

            // 'alertDescription' => 'Invalid OTP',
            // 'alertTitle' => 'Error',
            // 'alertIcon' => 'error'
        ]);
    }

    //Add Service Sub Category
    public function sscategoryPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'categoryId' => 'required|min:1',
            'name' => 'required|min:1',

        ]);
        if ($validator->fails()) {
            $allcategories = ServicesProviderType::select()->get();

            $allSubcategories = Services::with('service')->get();
            return view('adminPages.addSubCategory', [
                'title' => 'AdminPortal |  Add Servcie Sub Category',
                'allSubcategories' => $allSubcategories,
                'selectSubCatId' => null,
                'allcategories' => $allcategories,
                'editId' => null,

                'alertDescription' => 'Vehicle Brand name required',
                'alertTitle' => 'Error',
                'alertIcon' => 'error',
            ]);
        }
        $allcategories = ServicesProviderType::select()->get();

        $allSubcategories = Services::with('service')->get();

        $addCity = Services::create([
            'name' => $request->name,
            'serviceproviderId_fk' => $request->categoryId,
        ]);

        $allSubcategories = Services::with('service')->get();

        return view('adminPages.addSubCategory', [
            'title' => 'AdminPortal | Add Servcie Sub Category',
            'allSubcategories' => $allSubcategories,
            'selectSubCatId' => null,
            'editId' => null,
            'allcategories' => $allcategories,

            'alertDescription' => 'Service Sub Category added successfully',
            'alertTitle' => 'Success',
            'alertIcon' => 'success',
        ]);
    }

    public function dscategory($id)
    {

        $getDatafromModels = VehicleService::where('vehicleServiceId_fk', $id)->first();
        if ($getDatafromModels) {
            return back()->with('message', 'Services cannot be deleted as it is associated with some Vehicle Service.');
        }
        $delete = Services::where('id', $id)->delete();
        if ($delete) {
            $allSubcategories = Services::with('service')->get();
            //return to the previous page with message Please do not change the url
            return back()->with('message', 'Service Sub Category Deleted.');

        }
    }

    //Edit Service Sub Category
    public function editscategory($id)
    {
        $allSubcategories = Services::with('service')->get();

        $allcategories = ServicesProviderType::select()->get();

        $selectSubCatId = Services::where('id', $id)->first();

        return view('adminPages.addSubCategory', [
            'title' => 'AdminPortal | Add Service Sub Category',
            'allSubcategories' => $allSubcategories,
            'allcategories' => $allcategories,
            'selectSubCatId' => $selectSubCatId,
            'editId' => $selectSubCatId->serviceproviderId_fk,
            // 'alertDescription' => 'Invalid OTP',
            // 'alertTitle' => 'Error',
            // 'alertIcon' => 'error'
        ]);
    }

    //Update Service Sub Category
    public function updatescategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'categoryId' => 'required|min:1',
            'name' => 'required|min:1',

        ]);
        if ($validator->fails()) {
            $allcategories = ServicesProviderType::select()->get();

            $allSubcategories = Services::with('service')->get();
            return view('adminPages.addSubCategory', [
                'title' => 'AdminPortal |  Add Servcie Sub Category',
                'allSubcategories' => $allSubcategories,
                'selectSubCatId' => null,
                'allcategories' => $allcategories,
                'editId' => null,

                'alertDescription' => 'Vehicle Brand name required',
                'alertTitle' => 'Error',
                'alertIcon' => 'error',
            ]);
        }
        $allcategories = ServicesProviderType::select()->get();

        $allSubcategories = Services::with('service')->get();

        $addCity = Services::where('id', $request->id)->update([
            'name' => $request->name,
            'serviceproviderId_fk' => $request->categoryId,
        ]);

        $allSubcategories = Services::with('service')->get();

        return view('adminPages.addSubCategory', [
            'title' => 'AdminPortal | Add Servcie Sub Category',
            'allSubcategories' => $allSubcategories,
            'selectSubCatId' => null,
            'allcategories' => $allcategories,
            'editId' => null,

            'alertDescription' => 'Service Sub Category added successfully',
            'alertTitle' => 'Success',
            'alertIcon' => 'success',
        ]);
    }

    //Add vehicle-model
    public function vmodel()
    {
        $allSubcategories = VehicleModel::with('vehicleCategory')
            ->join('vehicle_categories', 'vehicle_categories.id', '=', 'vehicle_models.vehicleCategoryId_fk')
            ->join('vehicle_brands', 'vehicle_brands.id', '=', 'vehicle_categories.vehicleBrandId_fk')
            ->select('vehicle_models.*', 'vehicle_categories.name as categoryName', 'vehicle_brands.name as brandName')
            ->get();

        // $allSubcategories = Services::select()->get();
        $allcategories = VehicleCategory::with('vehicleBrand')->get();

        return view('adminPages.vehicleModel', [
            'title' => 'AdminPortal | Add Vehicle Model',
            'allSubcategories' => $allSubcategories,
            'allcategories' => $allcategories,
            'selectSubCatId' => null,
            'editId' => null,
            // 'alertDescription' => 'Invalid OTP',
            // 'alertTitle' => 'Error',
            // 'alertIcon' => 'error'
        ]);
    }

    //Add vehicle-model
    public function vModelPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brandId' => 'required|min:1',
            'name' => 'required|min:1',
            'year' => 'required|min:1',
            'image' => 'required',

        ]);
        if ($validator->fails()) {
            $allSubcategories = VehicleModel::with('vehicleCategory')
                ->join('vehicle_categories', 'vehicle_categories.id', '=', 'vehicle_models.vehicleCategoryId_fk')
                ->join('vehicle_brands', 'vehicle_brands.id', '=', 'vehicle_categories.vehicleBrandId_fk')
                ->select('vehicle_models.*', 'vehicle_categories.name as categoryName', 'vehicle_brands.name as brandName')
                ->get();

            // $allSubcategories = Services::select()->get();
            $allcategories = VehicleCategory::with('vehicleBrand')->get();

            return view('adminPages.vehicleModel', [
                'title' => 'AdminPortal | Add Vehicle Model',
                'allSubcategories' => $allSubcategories,
                'selectSubCatId' => null,
                'allcategories' => $allcategories,

                'alertDescription' => 'Vehicle Brand name required',
                'alertTitle' => 'Error',
                'alertIcon' => 'error',
            ]);
        }

        $image = $request->file('image');
        $pathName = time() . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('/images/vehicle-model/');
        $image->move($destinationPath, $pathName);

        $addCity = VehicleModel::create([
            'name' => $request->name,
            'vehicleCategoryId_fk' => $request->brandId,
            'year' => $request->year,
            'image' => '/images/vehicle-model/' . $pathName,
        ]);
        $allSubcategories = VehicleModel::with('vehicleCategory')
            ->join('vehicle_categories', 'vehicle_categories.id', '=', 'vehicle_models.vehicleCategoryId_fk')
            ->join('vehicle_brands', 'vehicle_brands.id', '=', 'vehicle_categories.vehicleBrandId_fk')
            ->select('vehicle_models.*', 'vehicle_categories.name as categoryName', 'vehicle_brands.name as brandName')
            ->get();

        // $allSubcategories = Services::select()->get();
        $allcategories = VehicleCategory::with('vehicleBrand')->get();

        return view('adminPages.vehicleModel', [
            'title' => 'AdminPortal | Add Vehicle Model',
            'allSubcategories' => $allSubcategories,
            'selectSubCatId' => null,
            'allcategories' => $allcategories,
            'editId' => null,

            'alertDescription' => 'Vehicle Model added successfully',
            'alertTitle' => 'Success',
            'alertIcon' => 'success',
        ]);
    }

    public function deleteVModel($id)
    {
        $getDatafromModels = VehicleService::where('vehicleModelId_fk', $id)->first();
        if ($getDatafromModels) {
            return back()->with('message', 'Vehicle Model cannot be deleted as it is associated with some Vehicle Service.');
        }

        $delete = VehicleModel::where('id', $id)->first();

        if ($delete) {
            $imagePath = $delete->image; // Assuming 'image' is the column name in your table

            // Check if the image file exists
            if (Storage::disk('public')->exists($imagePath)) {
                // The image file exists
                // Delete the image file
                Storage::disk('public')->delete($imagePath);
            }
            // Delete the record
            $delete->delete();
            return back()->with('message', 'Vehiicle Model Deleted.');

        } else {
            // Deletion failed or record not found
            return back()->with('message', 'Could not delete try again later.');
        }
    }

    //Edit VBrand Model
    public function editVBrand($id)
    {

        $allcategories = VehicleBrand::select()->get();
        return view('adminPages.addBrand', [
            'title' => 'AdminPortal | Add Vehicle Model',
            'selectSubCatId' => null,
            'cities' => $allcategories,
            'selectCatId' => VehicleBrand::where('id', $id)->first(),

            // 'alertDescription' => 'Vehicle Model added successfully',
            // 'alertTitle' => 'Success',
            // 'alertIcon' => 'success',
        ]);

    }

    //Update Vehicle Brand
    public function updateVBrand(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1',
        ]);
        if ($validator->fails()) {
            $allcategories = VehicleBrand::select()->get();
            return view('adminPages.addBrand', [
                'title' => 'AdminPortal | Add Vehicle Model',
                'selectSubCatId' => null,
                'cities' => $allcategories,
                'selectCatId' => VehicleBrand::where('id', $id)->first(),

                'alertDescription' => 'Vehicle Brand name required',
                'alertTitle' => 'Error',
                'alertIcon' => 'error',
            ]);
        }

        if ($request->hasFile('image')) {
            //delete existing file from folder
            // $delete = VehicleBrand::where('id', $request->id)->first();
            // $imagePath = $delete->image; // Assuming 'image' is the column name in your table
            $delete = VehicleBrand::where('id', $request->id)->first();
            if ($delete) {
                $this->deleteExistingFile($delete->image);
            }

            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/brands');
            $image->move($destinationPath, $name);
            $imagePath = 'images/brands/' . $name;
            $addCity = VehicleBrand::where('id', $request->id)->update([
                'name' => $request->name,
                'image' => $imagePath,
            ]);
        } else {

            $addCity = VehicleBrand::where('id', $request->id)->update([
                'name' => $request->name,
            ]);
        }

        $allcategories = VehicleBrand::select()->get();
        return view('adminPages.addBrand', [
            'title' => 'AdminPortal | Add Vehicle Model',
            'selectCatId' => null,
            'cities' => $allcategories,
            'editId' => null,

            'alertDescription' => 'Vehicle Brand updated successfully',
            'alertTitle' => 'Success',
            'alertIcon' => 'success',
        ]);
    }

    // delete existing file
    public function deleteExistingFile($imagePath)
    {
        if (File::exists(public_path($imagePath))) {
            File::delete(public_path($imagePath));
        }
    }

    //Edit VModel Model
    public function editVModel($id)
    {

        $allSubcategories = VehicleModel::with('vehicleCategory')
            ->join('vehicle_categories', 'vehicle_categories.id', '=', 'vehicle_models.vehicleCategoryId_fk')
            ->join('vehicle_brands', 'vehicle_brands.id', '=', 'vehicle_categories.vehicleBrandId_fk')
            ->select('vehicle_models.*', 'vehicle_categories.name as categoryName', 'vehicle_brands.name as brandName')
            ->get();

        // $allSubcategories = Services::select()->get();
        $allcategories = VehicleCategory::with('vehicleBrand')->get();

        $vehicleData = VehicleModel::where('id', $id)->first();

        return view('adminPages.vehicleModel', [
            'title' => 'AdminPortal | Add Vehicle Model',
            'allSubcategories' => $allSubcategories,
            'selectSubCatId' => $vehicleData,
            'allcategories' => $allcategories,
            'editId' => VehicleCategory::where('id', $vehicleData->vehicleCategoryId_fk)->first()->id,
        ]);

    }

    // Update Vehicle Model
    public function updateVModel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brandId' => 'required|min:1',
            'name' => 'required|min:1',
            'year' => 'required|min:1',

        ]);
        if ($validator->fails()) {

            $allSubcategories = VehicleModel::with('vehicleCategory')
                ->join('vehicle_categories', 'vehicle_categories.id', '=', 'vehicle_models.vehicleCategoryId_fk')
                ->join('vehicle_brands', 'vehicle_brands.id', '=', 'vehicle_categories.vehicleBrandId_fk')
                ->select('vehicle_models.*', 'vehicle_categories.name as categoryName', 'vehicle_brands.name as brandName')
                ->get();

            // $allSubcategories = Services::select()->get();
            $allcategories = VehicleCategory::with('vehicleBrand')->get();

            return view('adminPages.vehicleModel', [
                'title' => 'AdminPortal |  Add Vehicle Model',
                'allSubcategories' => $allSubcategories,
                'selectSubCatId' => null,
                'allcategories' => $allcategories,
                'editId' => null,
                'alertDescription' => 'Vehicle Brand name required',
                'alertTitle' => 'Error',
                'alertIcon' => 'error',
            ]);
        }
        if ($request->hasFile('image')) {
            //delete existing file from folder
            // $delete = VehicleBrand::where('id', $request->id)->first();
            // $imagePath = $delete->image; // Assuming 'image' is the column name in your table
            $delete = VehicleBrand::where('id', $request->id)->first();
            if ($delete) {
                $this->deleteExistingFile($delete->image);
            }

            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/vehicle-model');
            $image->move($destinationPath, $name);
            $imagePath = 'images/vehicle-model/' . $name;

            $addCity = VehicleModel::where('id', $request->id)->update([
                'name' => $request->name,
                'vehicleCategoryId_fk' => $request->brandId,
                'year' => $request->year,
                'image' => $imagePath,

            ]);

        } else {

            $addCity = VehicleModel::where('id', $request->id)->update([
                'name' => $request->name,
                'vehicleCategoryId_fk' => $request->brandId,
                'year' => $request->year,

            ]);
        }

        $allSubcategories = VehicleModel::with('vehicleCategory')
            ->join('vehicle_categories', 'vehicle_categories.id', '=', 'vehicle_models.vehicleCategoryId_fk')
            ->join('vehicle_brands', 'vehicle_brands.id', '=', 'vehicle_categories.vehicleBrandId_fk')
            ->select('vehicle_models.*', 'vehicle_categories.name as categoryName', 'vehicle_brands.name as brandName')
            ->get();

        // $allSubcategories = Services::select()->get();
        $allcategories = VehicleCategory::with('vehicleBrand')->get();

        return view('adminPages.vehicleModel', [
            'title' => 'AdminPortal |  Add Vehicle Model',
            'allSubcategories' => $allSubcategories,
            'selectSubCatId' => null,
            'editId' => null,
            'allcategories' => $allcategories,
            'alertDescription' => 'Vehicle Model added successfully',
            'alertTitle' => 'Success',
            'alertIcon' => 'success',
        ]);
    }

    public function sendnotification()
    {
        return view('adminPages.addNotification', [
            'title' => 'AdminPortal |  Add Vehicle Model',

            // 'alertDescription' => 'Vehicle Model added successfully',
            // 'alertTitle' => 'Success',
            // 'alertIcon' => 'success',
        ]);
    }

    public function sendnotificationPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:1',
            'sendTo' => 'required|min:1',
            'description' => 'required|min:1',
        ]);
        if ($validator->fails()) {
            return view('adminPages.addNotification', [
                'title' => 'AdminPortal |  Add Vehicle Model',
                'alertDescription' => 'Title and Description required',
                'alertTitle' => 'Error',
                'alertIcon' => 'error',
            ]);
        }

        if ($request->sendTo == '2') {
            $allUsers = worker::select('fcm_token')->get();

        } else {
            return view('adminPages.addNotification', [
                'title' => 'AdminPortal |  Add Vehicle Model',
                'alertDescription' => 'Notification can only be sent to vendors',
                'alertTitle' => 'Error',
                'alertIcon' => 'error',
            ]);
        }
        $tokens = array();
        foreach ($allUsers as $key => $value) {
            array_push($tokens, $value->fcm_token);
        }
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'key=AAAARilr3uk:APA91bHUrPmGkIE_CctexWu2qrhIu4DH-Hm45g5FBIBNQOn239MU4NJ_2OvaEzMAz154trtnQDGROiMp7MkZwAQJsAUYAb3548_knDcspRfUyj9r41K69TsOi44NxYX06tHBMxqkZG3o',
        ])->post('https://fcm.googleapis.com/fcm/send', [
            'registration_ids' => $tokens,
            'notification' => [
                'title' => $request->title,
                'body' => $request->description,
                'mutable_content' => true,
                'sound' => 'Tri-tone',
            ],
            'data' => [
                'url' => '<url of media image>',
                'dl' => '<deeplink action on tap of notification>',
            ],
        ]);

        if ($response->ok()) {
            $result = $response->json();
            // handle successful response
        } else {
            $error = $response->throw()->getMessage();
            // handle error
        }
        usleep(50000);

        // send notification to all token

        $addCity = PushNotifications::create([
            'sendTo' => $request->sendTo,
            'title' => $request->title,
            'body' => $request->description,
            'image' => '',
        ]);

        return view('adminPages.addNotification', [
            'title' => 'AdminPortal |  Add Vehicle Model',
            'alertDescription' => 'Notification added successfully',
            'alertTitle' => 'Success',
            'alertIcon' => 'success',
        ]);
    }

    private function send_notification_FCM($notification_id, $title, $message, $id, $type)
    {

        $accesstoken = env('FCM_KEY');

        $URL = 'https://fcm.googleapis.com/fcm/send';

        $post_data = '{
                "to" : "' . $notification_id . '",
                "data" : {
                  "body" : "",
                  "title" : "' . $title . '",
                  "type" : "' . $type . '",
                  "id" : "' . $id . '",
                  "message" : "' . $message . '",
                },
                "notification" : {
                     "body" : "' . $message . '",
                     "title" : "' . $title . '",
                      "type" : "' . $type . '",
                     "id" : "' . $id . '",
                     "message" : "' . $message . '",
                    "icon" : "new",
                    "sound" : "default"
                    },

              }';
        // print_r($post_data);die;

        $crl = curl_init();

        $headr = array();
        $headr[] = 'Content-type: application/json';
        $headr[] = 'Authorization: ' . $accesstoken;
        curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($crl, CURLOPT_URL, $URL);
        curl_setopt($crl, CURLOPT_HTTPHEADER, $headr);

        curl_setopt($crl, CURLOPT_POST, true);
        curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);

        $rest = curl_exec($crl);

        if ($rest === false) {
            // throw new Exception('Curl error: ' . curl_error($crl));
            //print_r('Curl error: ' . curl_error($crl));
            $result_noti = 0;
        } else {

            $result_noti = 1;
        }

        //curl_close($crl);
        //print_r($result_noti);die;
        return $result_noti;
    }

    public function vServices()
    {
        $vehicleBrand = VehicleBrand::select()->get();
        $ssptype = ServicesProviderType::select()->get();
        return view('adminPages.vehicleServices', [
            'title' => 'AdminPortal | Add Vehicle Model',
            'vehicleBrand' => $vehicleBrand,
            'ssptype' => $ssptype,
            'selectSubCatId' => null,
            'editId' => null,
        ]);

    }

    public function vServicesPost(Request $request)
    {

        $vehicleBrand = VehicleBrand::select()->get();
        $ssptype = ServicesProviderType::select()->get();

        $validator = Validator::make($request->all(), [
            'modelId' => 'required|min:1',
            'serviceId' => 'required|min:1',
        ]);

        if ($validator->fails()) {

            return view('adminPages.vehicleServices', [
                'title' => 'AdminPortal | Add Vehicle Model',
                'vehicleBrand' => $vehicleBrand,
                'ssptype' => $ssptype,
                // 'previousEntries' => $previousEntries,
                // 'services' => $services,
                // 'allcategory' => $allcategory,
                'selectSubCatId' => null,
                'editId' => null,
                'alertDescription' => 'Field all the fields correctly',
                'alertTitle' => 'Error',
                'alertIcon' => 'error',
            ]);
        }

        $checkDuplication = VehicleService::where('vehicleModelId_fk', $request->modelId)
            ->where('vehicleServiceId_fk', $request->serviceId)
            ->first();

        if ($checkDuplication) {

            return view('adminPages.vehicleServices', [
                'title' => 'AdminPortal | Add Vehicle Model',
                'vehicleBrand' => $vehicleBrand,
                'ssptype' => $ssptype,
                // 'previousEntries' => $previousEntries,
                // 'services' => $services,
                // 'allcategory' => $allcategory,
                'selectSubCatId' => null,
                'editId' => null,
                'alertDescription' => 'This relationship is already added to the system',
                'alertTitle' => 'Error',
                'alertIcon' => 'error',
            ]);
        }
        $addCity = VehicleService::create([
            'vehicleModelId_fk' => $request->modelId,
            'vehicleServiceId_fk' => $request->serviceId,
        ]);

        return view('adminPages.vehicleServices', [
            'title' => 'AdminPortal | Add Vehicle Model',
            'vehicleBrand' => $vehicleBrand,
            'ssptype' => $ssptype,
            // 'previousEntries' => $previousEntries,
            // 'services' => $services,
            // 'allcategory' => $allcategory,
            'selectSubCatId' => null,
            'editId' => null,
            'alertDescription' => 'Vehicle Service added successfully',
            'alertTitle' => 'Successfull',
            'alertIcon' => 'success',
        ]);
    }

    public function deleteVServices($id)
    {
        $delete = VehicleService::where('id', $id)->delete();
        if ($delete) {
            return back()->with('message', 'Vehiicle Service Deleted.');
        }
    }

    public function vCategory()
    {
        $allSubcategories = VehicleCategory::select()->get();
        $allcategories = VehicleBrand::select()->get();
        return view('adminPages.vehicleCategory', [
            'title' => 'AdminPortal | Add Vehicle Category',
            'allSubcategories' => $allSubcategories,
            'allcategories' => $allcategories,
            'selectSubCatId' => null,
            'editId' => null,
            'alertDescription' => null,
            'alertTitle' => null,
            'alertIcon' => null,
        ]);
    }

    public function vCategorysPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brandId' => 'required|min:1',
            'name' => 'required|min:1',
            'image' => 'required',
        ]);
        if ($validator->fails()) {
            $allcategories = VehicleBrand::select()->get();

            $allSubcategories = VehicleCategory::with('vehicleBrand')->get();
            return view('adminPages.vehicleCategory', [
                'title' => 'AdminPortal |  Add Vehicle Category',
                'allSubcategories' => $allSubcategories,
                'selectSubCatId' => null,
                'allcategories' => $allcategories,

                'alertDescription' => 'Vehicle Category name or Image required',
                'alertTitle' => 'Error',
                'alertIcon' => 'error',
            ]);
        }

        $image = $request->file('image');
        $pathName = time() . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('/images/vehicle-category/');
        $image->move($destinationPath, $pathName);

        $addCity = VehicleCategory::create([
            'name' => $request->name,
            'image' => 'images/vehicle-category/' . $pathName,
            'vehicleBrandId_fk' => $request->brandId,

        ]);
        $allcategories = VehicleBrand::select()->get();
        $allSubcategories = VehicleCategory::with('vehicleBrand')->get();

        return view('adminPages.vehicleCategory', [
            'title' => 'AdminPortal | Add Vehicle Category',
            'allSubcategories' => $allSubcategories,
            'selectSubCatId' => null,
            'allcategories' => $allcategories,
            'editId' => null,

            'alertDescription' => 'Vehicle Category added successfully',
            'alertTitle' => 'Success',
            'alertIcon' => 'success',
        ]);
    }

    public function deleteVCategory($id)
    {
        $getDatafromModels = VehicleModel::where('vehicleCategoryId_fk', $id)->first();
        if ($getDatafromModels) {
            return back()->with('message', 'Vehicle Category cannot be deleted as it is associated with some models.');
        }
        $delete = VehicleCategory::where('id', $id)->first();
        if ($delete) {
            $this->deleteExistingFile($delete->image);
            // Delete the record
            $delete->delete();
            // Return to the previous page with a message
            return back()->with('message', 'Vehicle Model Deleted.');
        }
    }

    public function editVCategory($id)
    {
        $allSubcategories = VehicleCategory::with('vehicleBrand')->get();
        $allcategories = VehicleBrand::select()->get();
        $selectSubCatId = VehicleCategory::where('id', $id)->first();
        return view('adminPages.vehicleCategory', [
            'title' => 'AdminPortal | Add Vehicle Category',
            'allSubcategories' => $allSubcategories,
            'allcategories' => $allcategories,
            'selectSubCatId' => $selectSubCatId,
            'editId' => VehicleBrand::where('id', $selectSubCatId->vehicleBrandId_fk)->first()->id,
            'alertDescription' => null,
            'alertTitle' => null,
            'alertIcon' => null,
        ]);
    }

    public function updateVCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brandId' => 'required|min:1',
            'name' => 'required|min:1',

        ]);
        if ($validator->fails()) {
            $allcategories = VehicleBrand::select()->get();
            $allSubcategories = VehicleCategory::with('vehicleBrand')->get();
            return view('adminPages.vehicleCategory', [
                'title' => 'AdminPortal |  Add Vehicle Category',
                'allSubcategories' => $allSubcategories,
                'selectSubCatId' => null,
                'allcategories' => $allcategories,
                'editId' => null,
                'alertDescription' => 'Vehicle Category name required',
                'alertTitle' => 'Error',
                'alertIcon' => 'error',
            ]);
        }

        if ($request->hasFile('image')) {
            //delete existing file from folder
            // $delete = VehicleBrand::where('id', $request->id)->first();
            // $imagePath = $delete->image; // Assuming 'image' is the column name in your table
            $delete = VehicleCategory::where('id', $request->id)->first();
            if ($delete) {
                $this->deleteExistingFile($delete->image);
            }

            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/vehicle-category/');
            $image->move($destinationPath, $name);
            $imagePath = 'images/vehicle-category/' . $name;
            $addCity = VehicleCategory::where('id', $request->id)->update([
                'name' => $request->name,
                'vehicleBrandId_fk' => $request->brandId,
                'image' => $imagePath,
            ]);

        } else {

            $addCity = VehicleCategory::where('id', $request->id)->update([
                'name' => $request->name,
                'vehicleBrandId_fk' => $request->brandId,
            ]);

        }

        $allcategories = VehicleBrand::select()->get();

        $allSubcategories = VehicleCategory::with('vehicleBrand')->get();
        return view('adminPages.vehicleCategory', [
            'title' => 'AdminPortal |  Add Vehicle Category',
            'allSubcategories' => $allSubcategories,
            'selectSubCatId' => null,
            'editId' => null,
            'allcategories' => $allcategories,
            'alertDescription' => 'Vehicle Category added successfully',
            'alertTitle' => 'Success',
            'alertIcon' => 'success',
        ]);
    }

    public function editVServices($id)
    {

        $vehicleBrand = VehicleBrand::select()->get();
        $ssptype = ServicesProviderType::select()->get();

        $vehicleModelId = VehicleService::where('id', $id)->first();

        return view('adminPages.vehicleServices', [
            'title' => 'AdminPortal | Add Vehicle Model',
            'vehicleBrand' => $vehicleBrand,
            'ssptype' => $ssptype,
            'selectSubCatId' => null,
            'editId' => null,
        ]);

        return view('adminPages.vehicleServices', [
            'title' => 'AdminPortal | Add Vehicle Model',
            'vehicleModel' => $vehicleModel,
            'previousEntries' => $previousEntries,
            'services' => $services,
            'selectSubCatId' => $vehicleModelId['vehicleServiceId_fk'],
            'editId' => $vehicleModelId['vehicleModelId_fk'],
            // 'alertDescription' => 'Invalid OTP',
            // 'alertTitle' => 'Error',
            // 'alertIcon' => 'error'
        ]);

    }

    public function vendorServiceDetails($id)
    {

        $worker = worker::where('id', $id)->first();
        $serviceData = $worker->servics;

        if ($serviceData == null) {
            $serviceNames = ['No Services'];
        } else {
            $data = $worker->servics;
            $data = json_decode($data, true);

            $serviceNames = [];
            foreach ($data as $item) {
                if ($item['bool'] === true) {
                    $serviceNames[] = $item['servics'];
                }
            }
        }

        return view('adminPages.viewVendorsService', [
            'title' => 'AdminPortal | Add Vehicle Model',
            'worker' => $worker,
            'serviceNames' => $serviceNames,
            // 'vehicleModel' => $vehicleModel,
            // 'previousEntries' => $previousEntries,
            // 'services' => $services,
            'selectSubCatId' => null,
            'editId' => null,
            // 'alertDescription' => 'Invalid OTP',
            // 'alertTitle' => 'Error',
            // 'alertIcon' => 'error'
        ]);
    }

    public function appBanner()
    {
        $allBanners = Banners::select()->get();
        return view('adminPages.banner', [
            'title' => 'AdminPortal | Add Vehicle Model',
            'allBanners' => $allBanners,
            'singleOffer' => null,
            'catagories' => array(),
            'allOffers' => array(),
            'selectSubCatId' => null,
            'editId' => null,
        ]);

    }

    public function appBannerPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'scheduledfrom' => 'required|min:5',
            'scheduledto' => 'required|min:1',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:10240',

        ]);
        if ($validator->fails()) {
            return back()->with('message', 'Please fill all the fields');
        }

        $newImage = "images/banners/" . time() . "." . $request->image->extension();
        $path = $request->image->move(public_path('images/banners'), $newImage);

        $addNewOffer = Banners::create([
            'imageUrl' => urlencode($newImage),
            'scheduledto' => $request->scheduledto,
            'scheduledfrom' => $request->scheduledfrom,
            'status' => $request->status,
        ]);

        return back()->with('message', 'Bannner added successfully');

    }

    public function editAppBanner(Request $request)
    {
        $id = $request->id;
        $allBanners = Banners::select()->get();
        $singleOffer = Banners::where('id', $id)->first();

        return view('adminPages.banner', [
            'title' => 'AdminPortal | Add Vehicle Model',
            'allBanners' => $allBanners,
            'singleOffer' => $singleOffer,
            'catagories' => array(),
            'allOffers' => array(),
            'selectSubCatId' => null,
            'editId' => null,
        ]);

    }

    public function editAppBannerPost(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'scheduledfrom' => 'required|min:5',
            'scheduledto' => 'required|min:1',
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('message', 'First two fields are important');
        }

        //get previous data
        $previousData = Banners::where('id', $request->id)->first();

        if ($request->hasFile('image')) {
            //delete previous images
            $this->deleteExistingFile($previousData->imageUrl);
            $newImage = "images/banners/" . time() . "." . $request->image->extension();
            $path = $request->image->move(public_path('images/banners'), $newImage);
            $imageUrl = urlencode($newImage);
        } else {
            $imageUrl = $previousData->imageUrl;
        }

        $addNewOffer = Banners::where('id', $request->id)->update([
            'imageUrl' => $imageUrl,
            'scheduledto' => $request->scheduledto,
            'scheduledfrom' => $request->scheduledfrom,
            'status' => $request->status,
        ]);

        return back()->with('message', 'Bannner updated successfully');

    }

    public function deleteAppBanner(Request $request)
    {
        $id = $request->id;
        $delete = Banners::where('id', $id)->first();
        if ($delete) {
            $this->deleteExistingFile($delete->imageUrl);
            // Delete the record
            $delete->delete();
            // Return to the previous page with a message
            return back()->with('message', 'Banner Deleted.');
        }
    }

    public function problemQuestionaire()
    {

        $vehicleBrand = VehicleBrand::select()->get();
        $ssptype = ServicesProviderType::select()->get();
        // $getCategory = VehicleCategory::where('vehicleBrandId_fk', $selectCatId->brandId)->get();
        // $getModel = VehicleModel::where('vehicleCategoryId_fk', $selectCatId->categoryId)->get();

        return view('adminPages.problemQuestionaire', [
            'title' => 'AdminPortal | Problem Questionaire',
            'allBanners' => array(),
            'vehicleBrand' => $vehicleBrand,
            'ssptype' => $ssptype,

            'selectCatId' => null,
            'getCategory' => null,
            // 'getBrand' => $getBrand,
            'getModel' => null,
            'options' => null,
            'getCategory' => array(),
            'getModel' => array(),

            'singleOffer' => array(),
            'catagories' => array(),
            'allOffers' => array(),
            'selectSubCatId' => null,
            'editId' => null,
        ]);
    }

    public function problemQuestionairePost(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'brandId' => 'required|min:1',
            'categoryId' => 'required|min:1',
            'modelId' => 'required|min:1',
            'question' => 'required',
            'question_type' => 'required',
            'priority' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('message', $validator->errors());
        }

        $questionId = ProblemQuestions::create([
            'brandId' => $request->brandId,
            'categoryId' => $request->categoryId,
            'modelId' => $request->modelId,
            'question' => $request->question,
            'question_type' => $request->question_type,
            'total_options' => $request->total_options,
            'priority' => $request->priority,
        ])->id;

        // echo $questionId;
        // die;

        for ($i = 1; $i <= $request->total_options; $i++) {
            $servicecategory = "servicecategory" . $i;
            $optionname = "option" . $i;
            $servicerequired = "servicerequired" . $i;

            $options = Options::create([
                'question_id' => $questionId,
                'option' => $request->$optionname,
                'service_category_id' => $request->$servicecategory,
                'service_id' => $request->$servicerequired,
            ]);
        }

        return back()->with('success', 'Question added successfully');
    }

    public function deleteQuestion(Request $request)
    {
        $id = $request->id;
        $delete = ProblemQuestions::where('id', $id)->first();
        if ($delete) {
            //delete options
            $options = Options::where('question_id', $delete->id)->delete();
            // Delete the record
            $delete->delete();
            // Return to the previous page with a message
            // redirect to /problem-questionaire with message laravel
            return redirect('/problem-questionaire')->with('danger', 'Question Deleted.');

            // ('/problem-questionaire')->with('danger', 'Question Deleted.');
            return back()->with('danger', 'Question Deleted.');
        }
    }

    public function editQuestion(Request $request)
    {
        $id = $request->id;
        $selectCatId = ProblemQuestions::where('id', $id)->first();
        $vehicleBrand = VehicleBrand::select()->get();
        $getCategory = VehicleCategory::where('vehicleBrandId_fk', $selectCatId->brandId)->get();
        $getModel = VehicleModel::where('vehicleCategoryId_fk', $selectCatId->categoryId)->get();

        $ssptype = ServicesProviderType::select()->get();

        $options = Options::where('question_id', $id)->get();

        foreach ($options as $i => $option) {
            $options[$i]['service_id'] = Services::where('id', $option->service_id)->first();
            $options[$i]['service_category'] = ServicesProviderType::where('id', $option->service_category_id)->first();
        }

        // echo "<pre>";
        // print_r($ssptype);

        return view('adminPages.problemQuestionaire', [
            'title' => 'AdminPortal | Problem Questionaire',
            'allBanners' => array(),
            'vehicleBrand' => $vehicleBrand,
            'ssptype' => $ssptype,
            'selectCatId' => $selectCatId,
            'getCategory' => $getCategory,
            'getModel' => $getModel,
            'options' => $options,

            'singleOffer' => array(),
            'catagories' => array(),
            'allOffers' => array(),
            'editId' => $id,
        ]);

    }

}
