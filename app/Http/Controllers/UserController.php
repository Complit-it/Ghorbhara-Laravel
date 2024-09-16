<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ProductImage;
use App\Models\GbMstHomeFacility;
use App\Models\GbTrnProperty;
use App\Models\GbTrnPropertyImage;
use App\Models\GbTrnPropertyHomeFacility;
use App\Models\GbTrnFavProperty;
use App\Models\SearchLocation;
use App\Models\GbTrnAd;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\GbMstPropertyType;

class UserController extends Controller
{

    /**
     * Gets users except yourself
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = User::where('id', '!=', auth()->user()->id)->get();
        return $this->success($users);
    }
    public function admintable()
    {
        // Query all properties from GbTrnProperty
        $properties = GbTrnProperty::all();
        // dd($properties);
        // Pass the properties data to the view
        return view('admintable', ['properties' => $properties]);
    }

    public function admin()
    {
        // Query all properties from GbTrnProperty
        $properties = GbTrnProperty::count();
    
        // Query the total number of users
        $totalUsers = User::count();
    
        // Pass the properties data and total users to the view
        return view('Admin', [
            'properties' => $properties,
            'totalUsers' => $totalUsers
        ]);
    }

    public function admintable_users()
    {
        // Query all properties from GbTrnProperty
        $users = User::all();
        // dd($users);
        // Pass the properties data to the view
        return view('admintable_users', ['users' => $users]);
    }

    public function add_prop_type(){
        return view('add_prop_type');
    }

    public function create_property_type()
    {
        return view('add_prop_type');
    }

    public function store_property_type(Request $request)
    {
        $request->validate([
            'property_type' => 'required|string|max:255',
            'color' => 'required|string|max:7', // Assuming color is in hex format (e.g., #FFFFFF)
        ]);

        GbMstPropertyType::create([
            'property_type' => $request->property_type,
            'color' => $request->color,
        ]);

        return redirect()->route('prop_type')->with('success', 'Property type created successfully.');
    }
    
}