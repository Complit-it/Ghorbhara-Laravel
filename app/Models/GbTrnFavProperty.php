<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GbTrnFavProperty extends Model
{
    use HasFactory;
    // protected $table = 'gb_trn_fav_property';

    protected $hidden = ['created_at', 'updated_at'];

    // The attributes that are mass assignable.
    protected $fillable = ['user_id', 'property_id'];

    /**
     * Get the user that owns the favorite property.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the property that is favorited.
     */
    public function property()
    {
        return $this->belongsTo(GbTrnProperty::class);
    }
}
