<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pricetable extends Model
{
    use HasFactory;

    protected $table = 'pricetables';

    protected $fillable = [
        'pid',
        'role',
        'price',
        'Measurement',
        'totalprice',
    ];
}