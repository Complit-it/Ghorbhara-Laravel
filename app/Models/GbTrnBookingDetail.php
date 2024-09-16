<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GbTrnBookingDetail extends Model
{
    use HasFactory;

    protected $table = 'gb_trn_booking_details';

    protected $fillable = [
        'user_id',
        'prop_id',
        'order_id',
        'payment_id',
        'amount',
        'booking_date'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function property(){
        return $this->belongsTo(GbTrnProperty::class, 'prop_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    
}
