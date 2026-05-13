<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\productjunction;
use App\Models\userhierarchytab;
use App\Models\productadmintab;
use App\Models\batchProductPrice;
use App\Models\productPriceTable;

class Stockholder extends Component
{
    public $sellerid;
    public $stockData = [];

    public function mount($sellerid)
    {
        $this->sellerid = $sellerid;

        $junctions = productjunction::where('sellerid', $sellerid)->get();

        foreach ($junctions as $junction) {
            $user = userhierarchytab::find($junction->uid);
            $product = productadmintab::find($junction->pid);
            $batch = batchProductPrice::find($junction->batchid);
            $price = productPriceTable::find($junction->priceid);

            $this->stockData[] = [
                'junction_id' => $junction->id,
                'uid' => $junction->uid,
                'user_name' => $user->username ?? 'N/A',
                'role_id' => $junction->rid,
                'state' => $user->state ?? 'N/A',
                'product_name' => $product->productname ?? 'N/A',
                'product_id' => $junction->pid,
                'inventory' => $junction->inventery,
                'batch_no' => $batch->batchno ?? 'N/A',
                'batch_id' => $junction->batchid,
                'price_id' => $junction->priceid,
                'cndf_price' => $price->pricecndf ?? 'N/A',
                'distributor_price' => $price->pricedistributor ?? 'N/A',
                'dealer_price' => $price->pricedealer ?? 'N/A',
                'subdealer_price' => $price->pricesubdealer ?? 'N/A',
                'retailer_price' => $price->priceretialer ?? 'N/A',
            ];
        }
    }

    public function render()
    {
        return view('livewire.stockholder')->layout('layouts.header');
    }
}