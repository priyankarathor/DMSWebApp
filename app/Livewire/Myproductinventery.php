<?php

namespace App\Livewire;
use App\Models\productadmintab;
use App\Models\productjunction;
use App\Models\manageaccounttable;
use Livewire\Component;
use Auth;

class Myproductinventery extends Component
{
    public function render()
    {
        $product = productadmintab::get();
        $user = auth()->User();
        
        $manage = manageaccounttable::where('email', $user->email)->first();
    
        $junction = [];
        if ($manage) {
            $junction = productjunction::where('uid', $manage->ragisternum)->get();
        }
    
        // Pass the data to the view
        return view('livewire.myproductinventery', ['data' => $junction,'products'=>$product])
                ->layout('layouts.header');
    }
    
}
