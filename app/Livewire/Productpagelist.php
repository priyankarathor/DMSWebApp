<?php

namespace App\Livewire;

use App\Models\productadmintab;
use App\Models\pricetable;
use Livewire\Component;

class Productpagelist extends Component
{
    public function render()
    {
        $allpricedata = pricetable::get();
        $data = productadmintab::orderBy('id', 'desc')->get();

    

        return view('livewire.productpagelist', [
            'product' => $data,
            'productprice' => $allpricedata
        ])->layout('layouts.header');
    }

    public function deleteproduct($id)
    {
        $delete = productadmintab::find($id);

        if ($delete) {
            $delete->delete();
        }

        return back();
    }
}