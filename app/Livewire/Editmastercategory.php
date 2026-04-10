<?php

namespace App\Livewire;
use App\Models\categorytable;
use Illuminate\Http\Request;
use Livewire\Component;

class Editmastercategory extends Component
{
    public $mastercate;
    public function mount($id){
        $this->mastercate = categorytable::where('id',$id)->first();
    }

    public function render()
    {
        return view('livewire.editmastercategory')->layout('layouts.header');
    }
   public function editmastercategorydata(Request $data, $id)
    {
    $editcategory = categorytable::where('id', $id)->first();

    $editcategory->type = $data->type;
    $editcategory->value = $data->value;
    $editcategory->active = $data->active;
    $image=time(). $data->file('file')->extension();
    $data->file->move(public_path('images/'), $image);
    $editcategory->image=$image;

    $editcategory->save();

    return redirect('/categorydata');
}

}
