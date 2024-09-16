<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GbTrnInquiry extends Model
{
    use HasFactory;

    protected $table = 'gb_trn_inquiries';

    // The attributes that are mass assignable
    protected $fillable = [
        'ad_id',
        'user_id',
    ];

    // Disable auto-incrementing ID if you're not using the default ID field
    // public $incrementing = true;

    // The data type of the primary key ID (if not the default)
    // protected $keyType = 'bigint';

    // Enable timestamps (created_at and updated_at)
    public $timestamps = true;
}
