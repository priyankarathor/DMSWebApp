<?php

namespace App\Livewire;
use App\Models\userroletab;
use App\Models\userhierarchytab;
use Livewire\Component;

class Companypermission extends Component
{
    
    public $selectedCategory;
    public function render()
    {
        $data = userhierarchytab::where('active','deactivate')->get();
        $wholedata = userhierarchytab::where('active','Active')->get();
        $role = userroletab::get();
        return view('livewire.companypermission', [
            'tab'=>$data, 'category'=>$role, 'zonalcheck'=>$wholedata ])->layout('layouts.header');
    }

}