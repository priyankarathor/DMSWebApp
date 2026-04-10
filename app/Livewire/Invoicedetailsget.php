<?php

namespace App\Livewire;
use App\Models\orderapprovedtable;
use Livewire\Component;
use App\Models\User;
use Auth;


class Invoicedetailsget extends Component
{
     public $productdata;
   
    public $data;
    public $dataArray;
    public $invoiceId; 

    public function mount($id = null)
    {
        $this->invoiceId = $id;
    }
    public function render()
    {
         if ($this->invoiceId) {
            $this->productdata = orderapprovedtable::find($this->invoiceId);
        } else {
            $this->productdata = orderapprovedtable::latest()->first();
        }
        $table = orderapprovedtable::latest()->get();

        return view('livewire.invoicedetailsget',['tab' => $table])->layout('layouts.header');;
    }
}
