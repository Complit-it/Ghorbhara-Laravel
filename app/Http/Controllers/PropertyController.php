<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GbMstPropertyType;
use App\Models\GbTrnProperty;
use Illuminate\Support\Facades\Validator;

class PropertyController extends Controller
{
//     public function save_property(Request $request){
        
//     //     $properties = GbMstPropertyType::all();
//     //     print($properties);exit;
//     //    //  php artisan make:migration create_gb_trn_properties_table

//    }

public function save_property(Request $request)
{

    $validator = Validator::make($request->json()->all(), [
        'title' => 'required|string|max:255',
        'rooms' => 'required|integer',
        'address' => 'required|string',
        'area' => 'required|numeric',
        'user_id' => 'required|integer',
        'about' => 'nullable|string',
        'property_type_id' => 'required|integer',
    ]);
 
    if ($validator->fails()) {
        $messages = $validator->messages();

        return response()->json([
            'status' => 'error',
            'message' => $messages,
        ], 422);}

        $data = [
            'title' => $request->title,
            'rooms' => $request->rooms,
            'address' => $request->address,
            'area' => $request->area,
            'user_id' => $request->user_id,
            'about' => $request->about,
            'property_type_id' => $request->property_type_id,
        ];



    $property = GbTrnProperty::create($data);

    return response()->json([
        'message' => 'Property created successfully!',
        'property' => $property, // Optional: Return the created property data
    ], 200);
}

}
