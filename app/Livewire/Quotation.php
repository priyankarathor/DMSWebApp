<?php

namespace App\Livewire;
use App\Models\orderapprovedtable;
use App\Models\rolediscount;
use Livewire\Component;

class Quotation extends Component
{
    public $productdata;
    public function render()
    {
        $roles = rolediscount::get();
        $this->productdata = orderapprovedtable::latest()->first();
        return view('livewire.quotation',['rolesdata'=>$roles])->layout('layouts.header');
    }
}
