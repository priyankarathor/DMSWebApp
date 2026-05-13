<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rolediscount extends Model
{
    use HasFactory;

    protected $fillable = [
        'discount',
        'userole',
        'state',
        'registerid',
        'username',
        'roleid',
        'email',
        'rate',
        'role'
    ];
}