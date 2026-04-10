<?php

namespace App\Livewire;
use App\Models\orderlisttab;
use App\Models\userroletab;
use Livewire\Component;

class Disstocklist extends Component
{
    public function render()
    {
        $data =  orderlisttab::get();
        return view('livewire.disstocklist',['tab'=>$data])->layout('layouts.header');
    }
}