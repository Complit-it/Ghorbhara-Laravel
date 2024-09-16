<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GbMstPropertyType extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_type',
        'color',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function properties()
    {
        return $this->hasMany(GbTrnProperty::class, 'property_type_id');
    }
}
