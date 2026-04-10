<?php

namespace App\Livewire;
use App\Models\distributoradmintab;
use App\Models\dealertable;
use App\Models\subdealertable;
use App\Models\retailertable;
use App\Models\employeetable;
use App\Models\categorytable;
use Illuminate\Http\Request;
use Livewire\Component;

class Dstributereditlist extends Component
{
    public $alltabledata;

public function mount($id) {
    // Based on the role, query the respective table
    // switch ($role) {
    //     case 'Distributor':
    //         $this->alltabledata = distributoradmintab::where('id', $id)->first();
    //         break;
    //     case 'Dealer':
    //         $this->alltabledata = dealertable::where('id', $id)->first();
    //         break;
    //     case 'Sub Dealer':
    //         $this->alltabledata = subdealertable::where('id', $id)->first();
    //         break;
    //     case 'Retailer':
    //         $this->alltabledata = retailertable::where('id', $id)->first();
    //         // dd( $this->alltabledata);
    //         break;
    //     case 'Employee':
    //         $this->alltabledata = employeetable::where('id', $id)->first();
    //         break;
    //     default:
    //         // Handle cases where the role is not found
    //         $this->alltabledata = null;
    //         break;
    // }

    $this->alltabledata = distributoradmintab::where('id', $id)->first();

}


    public function render()
    {
        $usercategory = categorytable::where('type', 'User')->get();
        $alldata = distributoradmintab::all(); // Assuming these are your distributors
        $dealerData = dealertable::all(); // Assuming these are your dealers
        $subdealerdata = subdealertable::all(); // Sub Dealers data
        $retailers = retailertable::all();
        return view('livewire.dstributereditlist',[
           'usercategory' => $usercategory,
            'alldata' => $alldata,
            'dealerData' => $dealerData,
            'subdealer' => $subdealerdata,
            'retailer' => $retailers,
        ])->layout('layouts.header');
    }

    public function distributinputdataedit(Request $request,$id){
        
            $userdeatil =  distributoradmintab::where('id',$id)->first();

                $userdeatil->registerId = $request->registerid;
                $userdeatil->distributername = $request->username;
                $userdeatil->companyname = $request->companyname;
                $userdeatil->contactno = $request->contactno;
                $userdeatil->email = $request->email;
                $userdeatil->address = $request->address;
                $userdeatil->region = $request->region;
                $userdeatil->tehsils = $request->tehsils;
                $userdeatil->role = $request->role;
                $userdeatil->alternativenum = $request->alternativenum;
                $userdeatil->date = $request->insertdate;
                $userdeatil->postalcode = $request->postalcode;
                $userdeatil->gstcode = $request->gstcode;
                $userdeatil->pincode = $request->pincode;
                $userdeatil->city = $request->city;
                $userdeatil->state = $request->state;
                $userdeatil->bankname = $request->bankname;
                $userdeatil->accountnum = $request->accountnumber;
                $userdeatil->ifsccode = $request->ifsccode;
                $userdeatil->holdername = $request->holdername;
                $userdeatil->accounttype = $request->accounttype;
               
                $image = time().'.'.$request->file->extension();
                $request->file->move(public_path('/image').$image);
                $userdeatil->file = $image;
    
                $userdeatil->save();
                    
                return back();
        }

}
