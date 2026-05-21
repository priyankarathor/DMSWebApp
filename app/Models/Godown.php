<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Godown extends Model
{
    protected $fillable = [
        'pid',
        'locationid',
        'retailer_name',
    ];

    public function product()
    {
        return $this->belongsTo(productadmintab::class, 'pid');
    }
}
