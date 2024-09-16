<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GbTrnPropertyHomeFacility extends Model
{
    use HasFactory;

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function homeFacility()
    {
        return $this->belongsTo(GbMstHomeFacility::class, 'home_facility_id');

        
    }

    // protected $table = 'gb_trn_property_home_facilities'; // Assuming your table name is gb_trn_property_home_facilities

    // public function property()
    // {
    //     return $this->belongsTo(GbTrnProperty::class, 'prop_id'); // Belongs to GbTrnProperty
    // }

    // public function homeFacility()
    // {
    //     return $this->belongsTo(GbMstHomeFacility::class, 'home_facility_id'); // Belongs to GbMstHomeFacility
    // }
}
