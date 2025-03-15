<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'address_title',
        'address_type',
        'address_line_1',
        'address_line_2',
        'city',
        'state_id',
        'country_id',
        'zip_code',
        'phone',
        'addressable_id',
        'addressable_type',
        'latitude',
        'longitude',
        'email'
    ];

}
