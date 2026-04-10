<?php

namespace App\Livewire;
use App\Models\userroletab;
use Illuminate\Http\Request;
use Livewire\Component;

class Userroleedit extends Component
{
    public $roledata;
    public function mount($id){
        $this->roledata = userroletab::where('id',$id)->first();
    }
    public function render()
    {
        return view('livewire.userroleedit')->layout('layouts.header');
    }
    public function roledefineedit(Request $data,$id){
        $roleinsert =  userroletab::where('id',$id)->first();
        $roleinsert->role = $data->role;
        $roleinsert->save();
        return redirect('role');
    }
}
