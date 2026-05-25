<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product_batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'batch_number'
    ];

    public function product()
    {
        return $this->belongsTo(productadmintab::class, 'product_id');
    }

    public function prices()
    {
        return $this->hasMany(BatchProductPrice::class, 'batchnos');
    }

    public function godowns()
    {
        return $this->hasMany(Godown::class, 'batchnos');
    }

    public function retailers()
    {
        return $this->hasMany(product_retailer::class, 'batchnos');
    }
}
