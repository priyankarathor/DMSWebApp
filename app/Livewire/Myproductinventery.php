<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\productadmintab;
use App\Models\productjunction;
use App\Models\manageaccounttable;
use App\Models\batchProductPrice;
use Illuminate\Support\Facades\Auth;

class Myproductinventery extends Component
{
    public $manage;

    public function render()
    {
        $user = Auth::user();

        $this->manage = null;
        $inventoryData = collect();

        if ($user) {
            $this->manage = manageaccounttable::where('email', $user->email)->first();

            if ($this->manage) {
                /*
                productjunction.batchid ko batch_product_prices.id se match kar rahe hain
                aur pid ko productadmintab.id se match kar rahe hain
                */
                $inventoryData = productjunction::leftJoin('productadmintabs', 'productjunctions.pid', '=', 'productadmintabs.id')
                    ->leftJoin('batch_product_prices', 'productjunctions.batchid', '=', 'batch_product_prices.id')
                    ->where('productjunctions.uid', $this->manage->ragisternum)
                    ->select(
                        'productjunctions.id',
                        'productjunctions.uid',
                        'productjunctions.pid',
                        'productjunctions.batchid',
                        'productjunctions.inventery',

                        'productadmintabs.productname',
                        'productadmintabs.productprice',
                        'productadmintabs.weightnum',
                        'productadmintabs.weihgtclass',
                        'productadmintabs.hsncode',

                        'batch_product_prices.batchno'
                    )
                    ->get();
            }
        }

        return view('livewire.myproductinventery', [
            'data' => $inventoryData,
        ])->layout('layouts.header');
    }
}