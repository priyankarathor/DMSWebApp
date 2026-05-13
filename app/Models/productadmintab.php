<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\batchProductPrice as BatchProductPrice;
use App\Models\productPriceTable as ProductPriceTable;

class productadmintab extends Model
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
        'measurement',
        'totalamount',
        'boxquantity',
        'dp',
        'mop',
        'mrp',
        'link',
        'metatag',
        'metakeyword',
        'metadescription',
        'Action',
        'categoryid',
        'brandid',
        'brand'
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