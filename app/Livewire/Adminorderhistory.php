<?php

namespace App\Livewire;
use App\Models\orderapprovedtable;
use Livewire\Component;

class Adminorderhistory extends Component
{
    public function render()
    {
        $approvedata = orderapprovedtable::get();
        return view('livewire.adminorderhistory',['approve'=>$approvedata])->layout('layouts.header');
    }
}
