<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\userhierarchytab;
use App\Models\userroletab;
use App\Models\manageaccounttable;

class Userorderrole extends Component
{
    public function render()
    {
        $userdata = auth()->user();

        if (!$userdata) {
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }

        $manageuser = manageaccounttable::where('email', $userdata->email)->get();
        $roles = userroletab::get();
        $tab = userhierarchytab::get();

        return view('livewire.userorderrole', [
            'users' => $manageuser,
            'roles' => $roles,
            'tab' => $tab,
        ])->layout('layouts.header');
    }
}