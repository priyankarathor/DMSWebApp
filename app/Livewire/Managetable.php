<?php

namespace App\Livewire;
use App\Models\manageaccounttable;
use Livewire\Component;

class Managetable extends Component
{
    public function render()
    {
        $data = manageaccounttable::get();
        return view('livewire.managetable',['table'=>$data])->layout('layouts.header');
    }
}
