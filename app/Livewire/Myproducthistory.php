<?php

namespace App\Livewire;
use App\Models\manageaccounttable;
use App\Models\orderapprovedtable;
use App\Models\batchProductPrice;
use App\Models\User;
use Livewire\Component;

class Myproducthistory extends Component
{
   public $manage;

public function render()
{
    $user = auth()->user();

    $this->manage = null;

   if ($user) {
    $this->manage = manageaccounttable::where('email', $user->email)->first();
}


    $batchtabledata = batchProductPrice::get();

// 👇 yaha lagao
// dd($this->manage);

    $ordertable = orderapprovedtable::get();

    return view('livewire.myproducthistory', [
        'order' => $ordertable,
        'manage' => $this->manage,
        'batchtable' => $batchtabledata
    ])->layout('layouts.header');
}

}
