<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\productjunction;
use App\Models\userhierarchytab;
use App\Models\productadmintab;
use App\Models\batchProductPrice;
use App\Models\productPriceTable;
use App\Models\userroletab;

class Stockholder extends Component
{
    public $sellerid;
    public $stockData = [];

    public $search = '';
    public $selectedState = '';
    public $selectedRole = '';
    public $selectedProduct = '';

    public function mount($sellerid)
    {
        $this->sellerid = $sellerid;
        $this->loadStockData();
    }

    public function updated($field)
    {
        if (in_array($field, ['search', 'selectedState', 'selectedRole', 'selectedProduct'])) {
            $this->loadStockData();
        }
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->selectedState = '';
        $this->selectedRole = '';
        $this->selectedProduct = '';
        $this->loadStockData();
    }

    public function loadStockData()
    {
        $junctions = productjunction::where('sellerid', $this->sellerid)->get();

        $rows = [];

        foreach ($junctions as $junction) {
            $user = userhierarchytab::where('id', $junction->uid)
                ->orWhere('registerid', $junction->uid)
                ->orWhere('userId', $junction->uid)
                ->first();

            $role = userroletab::find($junction->rid);
            $product = productadmintab::find($junction->pid);
            $batch = batchProductPrice::find($junction->batchid);
            $price = productPriceTable::find($junction->priceid);

            $rows[] = [
                'junction_id' => $junction->id,
                'sellerid' => $junction->sellerid,

                'uid' => $junction->uid,
                'user_name' => $user->username ?? $user->name ?? 'N/A',
                'email' => $user->email ?? 'N/A',
                'contact' => $user->contactno ?? $user->phone ?? 'N/A',
                'state' => $user->state ?? $user->region ?? 'N/A',

                'role_id' => $junction->rid,
                'role_name' => $role->role ?? $user->role ?? $user->userrole ?? 'N/A',

                'product_id' => $junction->pid,
                'product_name' => $product->productname ?? 'N/A',
                'hsn_code' => $product->hsncode ?? 'N/A',
                'category' => $product->category ?? 'N/A',

                'inventory' => (int) ($junction->inventery ?? 0),

                'batch_id' => $junction->batchid,
                'batch_no' => $batch->batchno ?? 'N/A',
                'batch_qty' => $batch->qty ?? $batch->totalqty ?? 'N/A',
                'batch_inventory' => $batch->inventoryqty ?? 'N/A',

                'price_id' => $junction->priceid,
                'price_state' => $price->state ?? 'N/A',
                'cndf_price' => $price->pricecndf ?? 'N/A',
                'distributor_price' => $price->pricedistributor ?? 'N/A',
                'dealer_price' => $price->pricedealer ?? 'N/A',
                'subdealer_price' => $price->pricesubdealer ?? 'N/A',
                'retailer_price' => $price->priceretialer ?? 'N/A',
            ];
        }

        $collection = collect($rows);

        if ($this->search) {
            $search = strtolower(trim($this->search));

            $collection = $collection->filter(function ($item) use ($search) {
                return str_contains(strtolower($item['user_name']), $search)
                    || str_contains(strtolower($item['uid']), $search)
                    || str_contains(strtolower($item['role_name']), $search)
                    || str_contains(strtolower($item['state']), $search)
                    || str_contains(strtolower($item['product_name']), $search)
                    || str_contains(strtolower($item['batch_no']), $search);
            });
        }

        if ($this->selectedState) {
            $collection = $collection->filter(fn($item) =>
                strtolower($item['state']) === strtolower($this->selectedState)
            );
        }

        if ($this->selectedRole) {
            $collection = $collection->filter(fn($item) =>
                strtolower($item['role_name']) === strtolower($this->selectedRole)
            );
        }

        if ($this->selectedProduct) {
            $collection = $collection->filter(fn($item) =>
                strtolower($item['product_name']) === strtolower($this->selectedProduct)
            );
        }

        $this->stockData = $collection->values()->toArray();
    }

    public function getTotalUsersProperty()
    {
        return collect($this->stockData)->pluck('uid')->unique()->count();
    }

    public function getTotalProductsProperty()
    {
        return collect($this->stockData)->pluck('product_id')->unique()->count();
    }

    public function getTotalInventoryProperty()
    {
        return collect($this->stockData)->sum('inventory');
    }

    public function getStatesProperty()
    {
        return collect($this->stockData)->pluck('state')->filter()->unique()->values();
    }

    public function getRolesProperty()
    {
        return collect($this->stockData)->pluck('role_name')->filter()->unique()->values();
    }

    public function getProductsProperty()
    {
        return collect($this->stockData)->pluck('product_name')->filter()->unique()->values();
    }

    public function render()
    {
        return view('livewire.stockholder')->layout('layouts.header');
    }
}