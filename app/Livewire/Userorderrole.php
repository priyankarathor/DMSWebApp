<?php

namespace App\Livewire;
use App\Models\userhierarchytab;
use App\Models\userroletab;
use App\Models\manageaccounttable;
use App\Models\productadmintab;
use App\Models\productjunction;
use App\Models\orderlisttab;
use App\Models\User;
use Livewire\Component;

class Userorderrole extends Component
{
    public function render()
    {
            $userdata = auth()->user(); 
    
            if ($userdata) {
                $manageuser = manageaccounttable::where('email', $userdata->email)->get(); 
                $userrole = userroletab::get();
                $data = userhierarchytab::get();
                $junstion = productjunction::get();
                $product = productadmintab::get();
                $order = orderlisttab::get();
            
                return view('livewire.userorderrole', [
                    'tab' => $data,
                    'users' => $manageuser,
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