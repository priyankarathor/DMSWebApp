<?php

namespace App\Livewire;
use App\Models\userhierarchytab;
use App\Models\manageaccounttable;
use App\Models\userroletab;
use Livewire\Component;

class Userprofile extends Component
{
    public $authentication;
    public $users;
    public function mount($id){
        $this->authentication =  manageaccounttable::where('id',$id)->first();
        $this->users =  userhierarchytab::where('id', $this->authentication->ragisternum)->first();
    }
    public function render()
    {
        $data = userroletab::get();
        return view('livewire.userprofile',['roles'=>$data])->layout('layouts.header');
    }
}
