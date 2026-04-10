<?php

namespace App\Livewire;
use App\Models\manageaccounttable;
use App\Models\orderapprovedtable;
use App\Models\User;
use Livewire\Component;

class Myproducthistory extends Component
{
    public $manage;
    public function render()
    {
        $user = auth()->User();
        $this->manage = manageaccounttable::where('email', $user->email)->first();        
        $ordertable = orderapprovedtable::get();

        return view('livewire.myproducthistory',['order'=>$ordertable])->layout('layouts.header');
    }
}
