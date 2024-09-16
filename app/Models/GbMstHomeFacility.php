<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GbMstHomeFacility extends Model
{
    use HasFactory;

    // public function propertyHomeFacilities()
    // {
    //     return $this->hasMany(GbTrnPropertyHomeFacility::class, 'home_facility_id');
    // }
    // protected $table = 'gb_mst_home_facilities'; // Assuming your table name is gb_mst_home_facilities

    // public function properties()
    // {
    //     return $this->belongsToMany(GbTrnProperty::class, 'gb_trn_property_home_facilities', 'home_facility_id', 'prop_id'); // Many-to-Many with GbTrnProperty through gb_trn_property_home_facilities pivot table
    // }
}
