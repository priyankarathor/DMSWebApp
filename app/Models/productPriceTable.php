<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class productPriceTable extends Model
{
    protected $fillable = [
        'pid',
        'state',
        'pricecndf',
        'pricedistributor',
        'pricedealer',
        'pricesubdealer',
        'priceretialer',
        'batchnos',
    ];



    public function product()
    {
        return $this->belongsTo(productadmintab::class, 'pid');
    }
}