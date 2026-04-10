<?php

namespace App\Livewire;
use App\Models\demotable;
use Illuminate\Http\Request;
use Livewire\Component;

class Demoform extends Component
{
    public function render()
    {
        $data = demotable::get();
        return view('livewire.demoform',['tab'=>$data])->layout('layouts.header');
    }
    public function insertalldata(Request $data){
        $insertdata = new demotable;
        $insertdata->username = $data->username;
        $insertdata->conatctno = $data->contactno;
        $insertdata->email = $data->email;
        $insertdata->password = $data->password;
        $insertdata->save();
        return back();
    }
    public function demodelete($id){
        $datadelete = demotable::where('id',$id)->first();
        $datadelete->delete();
        return back();
    }
    public function getDemo(){
        $aboutsect = demotable::get();

        if($aboutsect){
            return response()->json(['Aboutsection List' => $aboutsect,'Status' => 'Success',200]);
        }else{
            return response()->json([ 'Status' => 'Failed',200]);
        }
    }
}