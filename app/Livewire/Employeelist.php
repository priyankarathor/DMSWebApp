<?php

namespace App\Livewire;
use App\Models\orderlisttab;
use Livewire\Component;

class Employeelist extends Component
{
    public function render()
    {
        $data = orderlisttab::where('userrole','Employee')->get();
        return view('livewire.employeelist',['tab'=>$data])->layout('layouts.header');
    }
}
