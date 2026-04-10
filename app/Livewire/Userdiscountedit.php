<?php

namespace App\Livewire;
use App\Models\rolediscount;
use App\Models\userroletab;
use Illuminate\Http\Request;
use Livewire\Component;

class Userdiscountedit extends Component
{
    public $discount;
    public function mount($id){
        $this->discount = rolediscount::where('id',$id)->first();
    }
    public function render()
    {
        $data = userroletab::get();
        return view('livewire.userdiscountedit',['tab'=>$data])->layout('layouts.header');
    }
    public function discountdataedit(Request $request, $id) {
        $editdata = rolediscount::where('id', $id)->first();
    
        if ($editdata) {
            // Assign the form values
            $editdata->role = $request->role;
            $editdata->rate = $request->rate;
            $editdata->save();
        }
    
        return redirect('userdiscount');
    }
    
}