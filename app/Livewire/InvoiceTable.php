<?php

namespace App\Livewire;
use App\Models\orderapprovedtable;
use Livewire\Component;

class InvoiceTable extends Component
{
    public function render()
    {
        $data =  orderapprovedtable::orderby('id','desc')->get();
        return view('livewire.invoice-table',['tab'=>$data])->layout('layouts.header');;
    }
     public function deleteonlineinvoicedata($id){
        $datadelete = orderapprovedtable::where('id',$id)->first();
        $datadelete->delete();
        return back();
    }
}
