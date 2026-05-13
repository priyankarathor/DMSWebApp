<?php

namespace App\Livewire;
use App\Models\manageaccounttable;
use App\Models\userhierarchytab;
use App\Models\userroletab;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Livewire\Component;

class Mangeaccountedit extends Component
{
    public  $editmanage;
    public function mount($id){
        $this->editmanage = manageaccounttable::where('id',$id)->first();
    }
    public function render()
    {
        $usercategory = userroletab::get();
        $userhierarchy = userhierarchytab::get();
        return view('livewire.mangeaccountedit',['usercategory' => $usercategory,'hierarchy'=>$userhierarchy])->layout('layouts.header');
    }
    public function editaccountdata(Request $data , $id){
        $managedata = manageaccounttable::where('id',$id)->first();
        // $managedata->ragisternum = $data->id; 
        $managedata->name = $data->name;
        $managedata->role = $data->role; 
        $managedata->email = $data->email;
        $managedata->password = $data->password; 
   
        $regid = $data->input('regid', []);  
        $managedata->userregisterid = implode(',', $regid);
        $managedata->save();
       
    
        $user =  User::where('email',$managedata->email)->first();
        $user->name = $data->name;
        $user->email = $data->email;
        $user->password = Hash::make($data->password); 
        $user->role = 2; 
        $user->save();

        session()->flash('success', 'User data saved successfully!');
        return redirect('manageaccount');
    }
}