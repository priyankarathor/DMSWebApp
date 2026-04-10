<?php

namespace App\Livewire;
use App\Models\invoicetable;
use Livewire\Component;
use App\Models\User;
use Auth;
class Invoicedata extends Component
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
            $this->productdata = invoicetable::find($this->invoiceId);
        } else {
            $this->productdata = invoicetable::latest()->first();
        }
        $table = invoicetable::latest()->get();

        
        
        return view('livewire.invoicedata',['tab' => $table])->layout('layouts.header');
    }
}
