<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\ProductImage;
use App\Models\GbMstHomeFacility;
use App\Models\GbTrnProperty;
use App\Models\GbTrnPropertyImage;
use App\Models\GbTrnPropertyHomeFacility;
use App\Models\GbTrnFavProperty;
use App\Models\SearchLocation;
use App\Models\GbTrnAd;
use App\Models\GbTrnBookingDetail;
use App\Models\GbTrnPropLocation;
use App\Models\GbTrnAdImage;
use App\Models\GbMstPropertyType;
use App\Models\User;
use App\Models\GbTrnInquiry;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


use App\Models\Product;
use DateTime;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function upload_property(Request $request)
    {
        try {
            $title = $request->input('title');
            $address = $request->input('address');
            $area = $request->input('area');
            $about = $request->input('about');
            $propertyTypeId = $request->input('property_type_id');
            $roomId = $request->input('room_id');
            $selectedFacIds = $request->input('selectedFac');
            $location = $request->input('location');
            $price = $request->input('price');
            $userId = $request->input('userId');
            $lat = $request->input('lat');
            $long = $request->input('long');

            // return response()->json(['success' => true, 'message' => 'Prodcut Created Successfully', 'image_urls' =>  [
            //     'title' => $title,
            //     'address' => $address,
            //     'area' => $area,
            //     'about' => $about,
            //     'property_type_id' => $propertyTypeId,
            //     'room_id' => $roomId,
            //     'selected_fac_ids' => $selectedFacIds,
            //     // 'propidnw' => $propertyId,
            //     'lat' => $lat,
            //     'long' => $long,
            // ]], 200);

            $property = new GbTrnProperty;
            $property->title = $title;
            $property->address = $address;
            $property->area = $area;
            $property->about = $about;
            $property->rooms = $roomId;
            $property->property_type_id = $propertyTypeId;

            $property->user_id = $userId;
            $property->price = $price;

            $property->save();
            $propertyId = $property->id;

            //  try{ 
            $loc = new GbTrnPropLocation;
            $loc->prop_id = $property->id;
            $loc->latitude = $lat;
            $loc->longitude = $long;
            $loc->location_name = $location;
            $loc->save();
            // }catch (\Exception $e) {
            //         return response()->json(['error' => 'An error occurred while creating product: ' . $e->getMessage()], 400);
            //     }
            $imageUrls = [];

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $filename = $image->store('prop_images', 'public');

                    $productImage = new GbTrnPropertyImage();
                    $productImage->prop_id = $property->id;
                    $productImage->image_path = $filename;
                    $productImage->save();

                    $imageUrls[] = $filename;
                }
            }

            $var = json_decode($request->selectedFac);
            if (!empty($request->selectedFac)) {
                $selectedFacIds = explode(',', $request->selectedFac);
                foreach ($var as $facId) {
                    // $filename = $image->store('prop_images', 'public');

                    $productImage = new GbTrnPropertyHomeFacility();
                    $productImage->prop_id = $property->id;
                    $productImage->home_facility_id = $facId;
                    $productImage->save();
                }
            }

            try {
                return response()->json(['success' => true, 'message' => 'Prodcut Created Successfully', 'image_urls' =>  [
                    'title' => $title,
                    'address' => $address,
                    'area' => $area,
                    'about' => $about,
                    'property_type_id' => $propertyTypeId,
                    'room_id' => $roomId,
                    'selected_fac_ids' => $selectedFacIds,
                    'propidnw' => $propertyId,
                    'lat' => $lat,
                    'long' => $long,
                ]], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => 'An error occurred while creating product: ' . $e->getMessage()], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while creating product: ' . $e->getMessage()], 400);
        }
    }

    public function get_home_fac()
    {

        if ($data = GbMstHomeFacility::select('id', 'facility')->get()) {
            return response()->json(['success' => true, 'data' => $data], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'db error'], 500);
        }
    }
    public function get_property_type()
    {

        if ($data = GbMstPropertyType::select('id', 'property_type', 'color')->get()) {
            return response()->json(['success' => true, 'data' => $data], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'db error'], 500);
        }
    }

    public function get_all_property(Request $request)
    {
        $userId = $request->input('user_id');
        $properties = GbTrnProperty::with('image', 'location', 'propertyType')
            ->leftJoin('gb_trn_fav_properties', function ($join) use ($userId) {
                $join->on('gb_trn_properties.id', '=', 'gb_trn_fav_properties.prop_id')
                    ->where('gb_trn_fav_properties.user_id', '=', $userId);
            })
            ->where('gb_trn_properties.user_id', '!=', $userId)
            ->select('gb_trn_properties.*', DB::raw('CASE WHEN gb_trn_fav_properties.id IS NULL THEN false ELSE true END as is_fav'))
            ->latest()
            ->get();

        $properties->transform(function ($property) {
            $property->is_fav = (bool) $property->is_fav;
            return $property;
        });

        return response()->json($properties);
    }

    public function get_one_property(Request $request, $prop_id = null)
    {
        $userID = $request->query('userID');
        $property = GbTrnProperty::with(['user:id,name,userType,google_id,email', 'propertyType:id,property_type', 'homeFacilities.homeFacility:id,facility', 'images:id,prop_id,image_path', 'location'])
            ->find($prop_id);


        if ($property) {
            $isFavorite = GbTrnFavProperty::where('user_id', $userID)
                ->where('prop_id', $prop_id)
                ->exists();
            $property->is_fav = $isFavorite;
            if ($property->homeFacilities) {
                $property->homeFacilities = $property->homeFacilities->map(function ($facility) {
                    return $facility->homeFacility;
                });
            }
            return response()->json([
                'success' => true,
                'property' => $property,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Property not found',
            ], 404);
        }
    }

    public function add_favourite_prop(Request $request)
    {
        $prop_id = $request->input('prop_id');
        $user_id = $request->input('user_id');

        $fav = new GbTrnFavProperty;
        $fav->prop_id = $prop_id;
        $fav->user_id = $user_id;

        if ($fav->save()) {
            return response()->json(['success' => true], 200);
        } else {
            return response()->json(['success' => false], 400);
        }
    }

    public function remove_favourite_prop(Request $request)
    {
        $prop_id = $request->input('prop_id');
        $user_id = $request->input('user_id');

        $fav = GbTrnFavProperty::where('prop_id', $prop_id)->where('user_id', $user_id)->first();

        if ($fav) {
            if ($fav->delete()) {
                return response()->json(['success' => true], 200);
            } else {
                return response()->json(['success' => false], 400);
            }
        } else {

            //sending 200 as status to avoid error on client side
            return response()->json(['success' => false, 'message' => 'Record not found'], 200);
        }
    }

    public function get_search_locations()
    {
        $locations = SearchLocation::pluck('locations');

        // Return the data, you might want to return it as a JSON response
        return response()->json($locations);
    }

    public function searchProperties(Request $request)
    {
        // Validate the search query
        // $request->validate([
        //     'query' => 'required|string',
        // ]);

        // Get the search query from the request
        $query = $request->input('query');

        // Perform the search on the GbTrnProperty model
        $properties = GbTrnProperty::where('address', 'LIKE', '%' . $query . '%')->with(['user:id,name,userType', 'propertyType:id,property_type', 'homeFacilities.homeFacility:id,facility', 'image:id,prop_id,image_path', 'location'])
            ->get();

        // Return the search results
        return response()->json($properties, 200);
    }

    public function getUserFavoriteProperties(Request $request)
    {
        // $user_id = $request->input('user_id');
        $user_id = $request->query('userID');

        // Using Eloquent to replicate the raw SQL query
        $properties = GbTrnProperty::with('image', 'propertyType') // Eager load the image relationship
            ->join('gb_trn_fav_properties', 'gb_trn_fav_properties.prop_id', '=', 'gb_trn_properties.id')
            ->where('gb_trn_fav_properties.user_id', $user_id)
            ->select('gb_trn_properties.*')
            ->get();

        return response()->json($properties);
    }

    public function get_all_ads()
    {
        $ads = GbTrnAd::with(['mainImage'])->get();
        return response()->json($ads);
    }

    public function get_ad(Request $request)
    {
        $id = $request->query('id');

        $ad = GbTrnAd::with('allImages')->find($id);

        return response()->json($ad);
    }

    //function to get all props uploaded by the user
    public function get_user_props(Request $request)
    {
        $userId = $request->query('userId');

        $properties = GbTrnProperty::with(['image' => function ($query) {
            $query->select('id', 'prop_id', 'image_path');
        }, 'propLocation', 'propertyType'])
            ->where('user_id', $userId)
            ->select('id', 'title', 'rooms', 'area', 'location', 'price')
            ->get();

        $transformedProperties = $properties->map(function ($property) {
            return [
                'id' => $property->id,
                'title' => $property->title,
                'rooms' => $property->rooms,
                'area' => $property->area,
                'location' => $property->propLocation ? [
                    'location_name' => $property->propLocation->location_name
                ] : null,
                'price' => $property->price,
                'image' => $property->image ? [
                    'id' => $property->image->id,
                    'prop_id' => $property->image->prop_id,
                    'image_path' => $property->image->image_path,
                ] : null,
            ];
        });

        return response()->json($transformedProperties);
    }


    // public function save_booking_details(Request $request)
    // {
    //     $userId = $request->input('userId');
    //     $propId = $request->input('propId');
    //     $orderId = $request->input('orderId');
    //     $paymentId = $request->input('paymentId');
    //     $amount = $request->input('amount');

    //     $bookingDetails = new GbTrnBookingDetail();

    //     $bookingDetails->user_id = $userId;
    //     $bookingDetails->prop_id = $propId;
    //     $bookingDetails->order_id = $orderId;
    //     $bookingDetails->payment_id = $paymentId;
    //     $bookingDetails->amount = $amount;
    //     $bookingDetails->booking_date = Carbon::now()->format('Y-m-d');
    //     $bookingDetails->save();

    //     return response()->json(['status' => 'success'], 200);
    // }

    public function save_booking_details(Request $request)
    {
        // Retrieve required inputs
        $userId = $request->input('userId');
        $propId = $request->input('propId');
        $amount = $request->input('amount');

        // Retrieve optional inputs
        $orderId = $request->input('orderId', null);  // Default to null if not provided
        $paymentId = $request->input('paymentId', null);  // Default to null if not provided

        $bookingDetails = new GbTrnBookingDetail();

        // Assign values to the booking details object
        $bookingDetails->user_id = $userId;
        $bookingDetails->prop_id = $propId;
        $bookingDetails->amount = $amount;
        $bookingDetails->booking_date = Carbon::now()->format('Y-m-d');

        // Conditionally assign orderId and paymentId if provided
        if ($orderId !== null) {
            $bookingDetails->order_id = $orderId;
        }
        if ($paymentId !== null) {
            $bookingDetails->payment_id = $paymentId;
        }

        // Save the booking details
        $bookingDetails->save();

        return response()->json(['status' => 'success'], 200);
    }


    public function getUserBookedProperties(Request $request)
    {
        $userId = $request->query('userId');

        // Get all properties uploaded by the user
        $properties = GbTrnProperty::where('user_id', $userId)->select('id', 'title', 'price')
            ->with([
                'bookings' => function ($query) {
                    $query->select('prop_id', 'user_id', 'booking_date'); // Only select necessary fields
                },
                'bookings.user' => function ($query) {
                    $query->select('id', 'name', 'email', 'google_id'); // Only select necessary fields for user
                },
                'propLocation' => function ($query) {
                    $query->select('prop_id', 'location_name');
                },
                'image' => function ($query) {
                    $query->select('prop_id', 'image_path');
                }
            ])
            ->get();

        $bookedProperties = $properties->filter(function ($property) {
            return $property->bookings->isNotEmpty();
        })->values();

        if ($bookedProperties->isEmpty()) {
            return response()->json(['booked' => false, 'message' => 'No properties have been booked.', 'properties' => []]);
        }

        // Modify the key from prop_location to location
        $bookedProperties = $bookedProperties->map(function ($property) {
            if (isset($property->propLocation)) {
                $property->location = $property->propLocation; // Rename key
                unset($property->propLocation); // Remove old key
            }
            return $property;
        });

        return response()->json([
            'booked' => $bookedProperties->isNotEmpty(),
            'properties' => $bookedProperties
        ]);
    }

    public function getBookedPropertiesByUser(Request $request)
    {
        $userId = $request->input('userId');

        // Get all properties booked by the user
        $bookedProperties = GbTrnProperty::whereHas('bookings', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->with([
                'bookings' => function ($query) use ($userId) {
                    $query->where('user_id', $userId)
                        ->select('id', 'prop_id', 'user_id', 'booking_date');
                },
                // 'bookings.user' => function ($query) {
                //     $query->select('id', 'name', 'email');
                // },
                'propLocation' => function ($query) {
                    $query->select('prop_id', 'location_name');
                },
                'image' => function ($query) {
                    $query->select('prop_id', 'image_path');
                }
            ])
            // ->select('id', 'title')
            ->get();



        if ($bookedProperties->isEmpty()) {
            return response()->json([
                'booked' => false,
                'message' => 'No properties found for this user.',
                'properties' => []
            ]);
        }

        $bookedProperties = $bookedProperties->map(function ($property) {
            $property->location = $property->propLocation;
            unset($property->propLocation);
            return $property;
        });

        return response()->json([
            'booked' => true,
            'properties' => $bookedProperties
        ]);
    }

    public function updateProfile(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'userId' => 'required|integer|exists:users,id',
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15',
        ]);
        try {
            // Find the user by ID
            $user = User::findOrFail($validatedData['userId']);

            // Update user information
            if ($request->has('name')) {
                $user->name = $validatedData['name'];
            }

            if ($request->has('phone')) {
                $user->phone = $validatedData['phone'];
            }
            // $user->email = $validatedData['email'];

            // Handle profile image upload if provided
            if ($request->hasFile('photo_url')) {
                // Delete the old image if exists
                if ($user->photo_url) {
                    Storage::delete('public/' . $user->photo_url);
                }

                // Store the new image and update the path in the database
                $path = $request->file('photo_url')->store('profile_images', 'public');
                $user->photo_url = $path;
            }

            // Save the changes to the database
            $user->save();

            // Return a success response
            return response()->json(['success' => 'Profile updated successfully', 'data' => $user], 200);
        } catch (\Exception $e) {
            // Handle any errors and return an error response

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    //to create add
    public function create()
    {
        return view('gb_trn_ads.create');
    }

    // Store the form data from create
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'desc' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
        ]);

        $filename = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = $image->store('ads', 'public');
        }

        // Create the ad
        $ad = GbTrnAd::create([
            'title' => $request->title,
            'desc' => $request->desc,
            'active_flag' => 'Y',
            'from_date' => $request->from_date,
            'to_date' => $request->to_date
        ]);

        if ($filename) {
            GbTrnAdImage::create([
                'ad_id' => $ad->id,
                'image_path' => $filename,
                'is_main' => 'Y'
            ]);
        }

        return redirect()->route('products.create')->with('success', 'Ad created successfully!');
    }

    public function save_inquiry(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'ad_id' => 'required|integer',
            'user_id' => 'required|integer',
        ]);

        // Try to save the inquiry and return success response
        try {
            GbTrnInquiry::create([
                'ad_id' => $validated['ad_id'],
                'user_id' => $validated['user_id'],
            ]);

            // If the save was successful, return success: true
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // If there was an error, return success: false
            return response()->json(['success' => false], 500);
        }
    }
}
