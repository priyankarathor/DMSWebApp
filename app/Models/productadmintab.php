<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Productadmintab extends Model
{
    protected $fillable = [
        'productname',
        'description',
        'productprice',
        'category',
        'file',
        'image',
        'quantity',
        'weightnum',
        'weihgtclass',
        'hsncode',
        'link',
        'metatag',
        'metakeyword',
        'metadescription',
        'Action',
    ];

    public function batches()
    {
        return $this->hasMany(BatchProductPrice::class, 'pid');
    }

    public function prices()
    {
        return $this->hasMany(ProductPriceTable::class, 'pid');
    }
}