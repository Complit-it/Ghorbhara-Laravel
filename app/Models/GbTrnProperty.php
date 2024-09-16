<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GbTrnProperty extends Model
{
    use HasFactory;

    protected $hidden = [
        'created_at',
        'updated_at',
        // 'location'
    ];

    protected $fillable = [
        'title',
        'rooms',
        'address',
        'area',
        'user_id',
        'about',
        'property_type_id',
        'location',
        'price'
    ];

    public function images()
    {
        return $this->hasMany(GbTrnPropertyImage::class, 'prop_id', 'id');
    }
    public function image()
    {
        return $this->hasone(GbTrnPropertyImage::class, 'prop_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function propertyType()
    {
        return $this->belongsTo(GbMstPropertyType::class, 'property_type_id');
    }
    public function homeFacilities()
    {
        return $this->hasMany(GbTrnPropertyHomeFacility::class, 'prop_id');
    }

    public function favorites()
    {
        return $this->hasMany(GbTrnFavProperty::class, 'property_id');
    }

    public function location()
    {
        return $this->hasOne(GbTrnPropLocation::class, 'prop_id');
    }
    public function propLocation()
    {
        return $this->hasOne(GbTrnPropLocation::class, 'prop_id');
    }

    public function bookings()
    {
        return $this->hasMany(GbTrnBookingDetail::class, 'prop_id');
    }
}
