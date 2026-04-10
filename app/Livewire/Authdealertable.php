<?php

namespace App\Livewire;
use App\Models\dealertable;
use App\Models\employeetable;
use App\Models\manageaccounttable;
use Livewire\Component;

class Authdealertable extends Component
{
    public function render()
    {
        $datamange = manageaccounttable::first(); // Get the first record
        if ($datamange) {
            $data = dealertable::where('disid', $datamange->ragisternum)->get();
        }
        
        return view('livewire.authdealertable',['tab'=>$data])->layout('layouts.header');
    }
}
