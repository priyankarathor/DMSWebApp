<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class batchProductPrice extends Model
{
    protected $fillable = [
        'pid',
        'batchno',
        'boxqty',
        'pcsqty',
        'totalqty',
        'inventoryqty',
        'priceid',
        'state'
    ];

    public function product()
    {
        return $this->belongsTo(productadmintab::class, 'pid');
    }

    public function priceTable()
    {
        return $this->belongsTo(productPriceTable::class, 'priceid', 'id');
    }
}