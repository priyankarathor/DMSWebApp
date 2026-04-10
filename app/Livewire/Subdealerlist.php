<?php

namespace App\Livewire;
use App\Models\orderlisttab;
use Livewire\Component;

class Subdealerlist extends Component
{
    public function render()
    {
        $data = orderlisttab::where('userrole','Sub Dealer')->get();
        return view('livewire.subdealerlist',['tab'=>$data])->layout('layouts.header');
    }
}
