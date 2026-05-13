<?php

namespace App\Livewire;

use App\Models\brand;
use Illuminate\Http\Request;
use Livewire\Component;

class Brandadd extends Component
{
    public function render()
    {

        $discountdata = brand::get();
        return view('livewire.brandadd',['disocunt'=>$discountdata])->layout('layouts.header');
    }
    public function  branddata(Request $data){
        $discountdata = new brand();
        $discountdata->brandName = $data->brandName;
        $discountdata->save();
        return back();
    }
  
    
}
