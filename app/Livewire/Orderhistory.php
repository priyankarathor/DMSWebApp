<?php

namespace App\Livewire;

use App\Models\userroletab;
use App\Models\manageaccounttable;
use App\Models\orderapprovedtable;
use App\Models\userhierarchytab;
use Livewire\Component;

class Orderhistory extends Component
{
    public function render()
    {
        $userdata = auth()->user();
        $manageuser = collect(); // Initialize as an empty collection
        $userrole = collect();
        $data = collect();
        $historypro = collect();
    
        if ($userdata) {
            // Retrieve the user's account info as a collection
            $manageuser = manageaccounttable::where('email', $userdata->email)->get();
            $userrole = userroletab::all();
            $data = userhierarchytab::all();
        }
    
        $historypro = orderapprovedtable::orderby('id', 'desc')->get();

    
        return view('livewire.orderhistory', [
            'tab' => $historypro,
            'users' => $manageuser,
            'roles' => $userrole,
        ])->layout('layouts.header');
    }
    
}
