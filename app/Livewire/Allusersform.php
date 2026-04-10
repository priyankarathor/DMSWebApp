<?php

namespace App\Livewire;
use App\Models\categorytable;
use App\Models\allemplaoyeetab;
use App\Models\User;
use App\Models\distributoradmintab;
use Illuminate\Http\Request;
use Livewire\Component;
use Auth;

class Allusersform extends Component
{
    public function render()
    {
        $data = categorytable::where('type','User')->get();
        return view('livewire.allusersform',['usercategory'=>$data])->layout('layouts.header');
    }

    public function insertdata(Request $request){
        $userdeatil = new allemplaoyeetab();
        
        $distributor = distributoradmintab::where('email', Auth::user()->email)->first();
    
        if ($distributor) {
            $userdeatil->userid = $distributor->id;
        }
    
        // Set the remaining fields from the request
        $userdeatil->distributername = $request->distributername;
        $userdeatil->companyname = $request->companyname;
        $userdeatil->contactno = $request->contactno;
        $userdeatil->email = $request->email;
        $userdeatil->address = $request->address;
        $userdeatil->region = $request->region;
        $userdeatil->role = $request->role;
        $userdeatil->alternativenum = $request->alternativenum;
        $userdeatil->insertdate = $request->insertdate;
        $userdeatil->postalcode = $request->postalcode;
        $userdeatil->gstcode = $request->gstcode;
        $userdeatil->pincode = $request->pincode;
        $userdeatil->city = $request->city;
        $userdeatil->state = $request->state;
        $userdeatil->bankname = $request->bankname;
        $userdeatil->accountname = $request->accountnumber;
        $userdeatil->ifsccode = $request->ifsccode;
        $userdeatil->holdername = $request->holdername;
        $userdeatil->accounttype = $request->accounttype;
       
        // Handle the file upload
        if ($request->hasFile('file')) {
            $image = time().'.'.$request->file->extension();
            $request->file->move(public_path('/image'), $image); // Fixed the path concatenation
            $userdeatil->file = $image;
        }
    
        // Save the record
        $userdeatil->save();
        
        return back();
    }
    
    
    }
