<?php

namespace App\Livewire;
use App\Models\orderlisttab;
use App\Models\productadmintab;
use Illuminate\Http\Request;
use Livewire\Component;

class Disproduct extends Component
{
    public function render()
    {
        $data = productadmintab::get();
        return view('livewire.disproduct',['product'=>$data])->layout('layouts.header');
    }
    public function distributerdata(Request $data){
        $order = new orderlisttab();
        $order->productname = $data->ordername;
        $order->productquantity = $data->productquantity;
        $order->productdelivery = $data->quantity;
        $order->productexpected = $data->productexpected;
        $order->productprice = $data->productprice;
        $order->dealerid = $data->dealerid;
        $order->save();
        return back();
    }
}