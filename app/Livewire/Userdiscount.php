<?php

namespace App\Livewire;

use App\Models\rolediscount;
use App\Models\userroletab;
use Illuminate\Http\Request;
use Livewire\Component;

class Userdiscount extends Component
{
    public function render()
    {
        $data = userroletab::get();

        $discountdata = rolediscount::get();
        return view('livewire.userdiscount',['tab'=>$data,'disocunt'=>$discountdata])->layout('layouts.header');
    }
    public function  discount(Request $data){
        $discountdata = new rolediscount();
        $discountdata->role = $data->role;
        $discountdata->rate = $data->rate;
        $discountdata->save();
        return back();
    }
    public function deletediscountdata($id){
        $deletedata = rolediscount::where('id',$id)->first();
        $deletedata->delete();
        return back();
    }
}
