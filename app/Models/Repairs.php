<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Repairs extends Model
{
//    use softDeletes;

    protected $fillable = [
        'client_name',
        'user_id',
        'client_phone',
        'device',
        'issue',
        'notes',
        'staff',
        'cost',
        'status',
        'images',
        'pickup_pin',
    ];
}
