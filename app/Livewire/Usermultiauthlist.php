<?php

namespace App\Livewire;
use App\Models\userroletab;
use App\Models\userhierarchytab;
use Livewire\Component;

class Usermultiauthlist extends Component
{
    public function render()
    {
        $data = userhierarchytab::get();
        $role = userroletab::get();
        return view('livewire.usermultiauthlist', [
            'tab'=>$data, 'category'=>$role ])->layout('layouts.header');
    }
}
