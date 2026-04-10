<?php

namespace App\Livewire;
use App\Models\userroletab;
use Illuminate\Http\Request;
use Livewire\Component;

class Userrolepage extends Component
{
    public function render()
    {
        $data = userroletab::get();
        return view('livewire.userrolepage',['tab'=>$data])->layout('layouts.header');
    }

    public function roledefine(Request $data){
        $roleinsert = new userroletab();
        $roleinsert->role = $data->role;
        $roleinsert->save();
        return back();
    }
    public function deletedata($id){
        $delete = userroletab::where('id',$id)->first();
        $delete->delete();
        return back();
    }
    
    public function userrole() {
        $advertismentsec = userroletab::get();
    
        if($advertismentsec->isNotEmpty()) {
            return response()->json([
                'role List' => $advertismentsec,
                'Status' => 'Success'
            ], 200);
        } else {
            return response()->json([
                'Status' => 'Failed',
                'Message' => 'No data found'
            ], 200);
        }
    }
}
