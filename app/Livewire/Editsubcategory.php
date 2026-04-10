<?php

namespace App\Livewire;
use App\Models\categorytable;
use Illuminate\Http\Request;
use Livewire\Component;

class Editsubcategory extends Component
{
    public $mastercate;
    public function mount($id){
        $this->mastercate = categorytable::where('id',$id)->first();
    }

    public function render()
    {
        $alldata = categorytable::where('type','master')->get(); 
        return view('livewire.editsubcategory',['tabs'=>$alldata])->layout('layouts.header');
    }
    
  public function editsubcategorydatas(Request $data, $id)
{
    $editcategory = categorytable::where('id', $id)->first();

    $editcategory->type = $data->type;
    $editcategory->value = $data->value;
    $editcategory->active = $data->active;

    // Handle file only if uploaded
    if ($data->hasFile('file')) {
        $imageName = time() . '.' . $data->file('file')->extension();
        $data->file('file')->move(public_path('images/'), $imageName);
        $editcategory->image = $imageName;
    }

    $editcategory->save();

    return redirect('/subcategorydata');
}

}
