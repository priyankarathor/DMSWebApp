<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatchProductPrice extends Model
{
    protected $fillable = [
        'pid',
        'batchno',
        'qty',
        'maxqty',
    ];

    public function product()
    {
        return $this->belongsTo(Productadmintab::class, 'pid');
    }
}