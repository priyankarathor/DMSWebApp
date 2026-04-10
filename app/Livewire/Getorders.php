<?php

namespace App\Livewire;
use App\Models\userroletab;
use App\Models\manageaccounttable;
use App\Models\productjunction;
use App\Models\productadmintab;
use App\Models\userhierarchytab;
use App\Models\orderlisttab;
use Livewire\Component;

class Getorders extends Component
{
    public function render()
    {
       
        $userdata = auth()->user(); 

        if ($userdata) {
            // Fetch user-related data
            $manageuser = manageaccounttable::where('email', $userdata->email)->get(); 
            $userrole = userroletab::get();
            $data = userhierarchytab::get();
            $junstion = productjunction::get();
            $product = productadmintab::get();
            $usermange = manageaccounttable::get();
            $order = orderlisttab::get();
        
            // Debugging
            // dd($manageuser, $order); // Check what is being retrieved
        
            return view('livewire.getorders', [
                'tab' => $data,
                'users' => $manageuser,
                'userid' => $usermange,
                'roles' => $userrole,
                'products' => $product,
                'junstiontab' => $junstion,
                'orderdata' => $order
            ])->layout('layouts.header');
        } else {
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }
        
    }
}