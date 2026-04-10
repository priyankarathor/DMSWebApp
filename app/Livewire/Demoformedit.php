<?php

namespace App\Livewire;
use App\Models\demotable;
use Illuminate\Http\Request;
use Livewire\Component;

class Demoformedit extends Component
{
    public $demodetail;
    public function mount($id){
        $this->demodetail = demotable::where('id',$id)->first();
    }
    public function render()
    {
        return view('livewire.demoformedit')->layout('layouts.header');
    }
    public function demoformdataedit(Request $data, $id){
        $editdemodata = demotable::where('id',$id)->first();
        $editdemodata->username = $data->username;
        $editdemodata->conatctno = $data->conatctno;
        $editdemodata->email = $data->email;
        $editdemodata->password = $data->password;
        $editdemodata->save();
        return redirect('demo');
    }
}
