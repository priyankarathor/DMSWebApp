<?php

namespace App\Livewire;
use App\Models\retailertable;
use Livewire\Component;

class Retailerlistpage extends Component
{
    public function render()
    {
        $data = retailertable::get();
        return view('livewire.retailerlistpage',['tab'=>$data])->layout('layouts.header');
    }
}
