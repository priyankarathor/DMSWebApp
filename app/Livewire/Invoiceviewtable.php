<?php

namespace App\Livewire;
use App\Models\invoicetable;
use Livewire\Component;

class Invoiceviewtable extends Component
{
    public function render()
    {
        $data =  invoicetable::orderby('id','desc')->get();
        return view('livewire.invoiceviewtable',['tab'=>$data])->layout('layouts.header');
    }
    public function deleteinvoicedata($id){
        $datadelete = invoicetable::where('id',$id)->first();
        $datadelete->delete();
        return back();
    }
}
