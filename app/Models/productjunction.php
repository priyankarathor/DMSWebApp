<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class productjunction extends Model
{
    protected $fillable = [
        'uid',
        'rid', // add this
        'pid',
        'batchid',
        'priceid',
        'inventery',
        'sellerid'
    ];
}