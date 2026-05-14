<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\userhierarchytab;
use App\Models\productjunction;
use App\Models\productadmintab;
use App\Models\batchProductPrice;
use App\Models\productPriceTable;

class UserProductDetails extends Component
{
    public $userId;
    public $user;
    public $productDetails = [];

    public function mount($userId)
    {
        $this->userId = $userId;

        $this->user = userhierarchytab::findOrFail($userId);

        $junctions = productjunction::where('uid', $userId)->get();

        foreach ($junctions as $junction) {
            $product = productadmintab::find($junction->pid);
            $batch = batchProductPrice::find($junction->batchid);
            $price = productPriceTable::find($junction->priceid);

            if ($product) {
                $this->productDetails[] = [
                    'product_name' => $product->productname,
                    'description' => $product->description,
                    'category' => $product->category,
                    'weight' => $product->weightnum,
                    'weight_class' => $product->weihgtclass,
                    'hsncode' => $product->hsncode,
                    'batch_no' => $batch->batchno ?? 'N/A',
                    'boxqty' => $batch->boxqty ?? 'N/A',
                    'pcsqty' => $batch->pcsqty ?? 'N/A',
                    'totalqty' => $batch->totalqty ?? 'N/A',
                    'inventory' => $junction->inventery ?? 0,
                    'state' => $price->state ?? 'N/A',
                    'cndf_price' => $price->pricecndf ?? 0,
                    'distributor_price' => $price->pricedistributor ?? 0,
                    'dealer_price' => $price->pricedealer ?? 0,
                    'subdealer_price' => $price->pricesubdealer ?? 0,
                    'retailer_price' => $price->priceretialer ?? 0,
                ];
            }
        }
    }

    public function render()
    {
        return view('livewire.user-product-details')->layout('layouts.header');
    }
}
