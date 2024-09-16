<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GbTrnPropLocation extends Model
{
    use HasFactory;

    protected $table = 'gb_trn_prop_locations';

    protected $hidden = [
        'created_at',
        'updated_at',
        'prop_id',
        'description',
        'id'
    ];

    protected $fillable = [
        'prop_id',
        'location_name',
        'description',
        'latitude',
        'longitude',
    ];

    public function property()
    {
        return $this->belongsTo(GbTrnProperty::class, 'prop_id');
    }
}
