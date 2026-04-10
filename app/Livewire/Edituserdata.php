<?php
namespace App\Livewire;
use App\Models\userhierarchytab;
use App\Models\userroletab;
use App\Models\productjunction;
use App\Models\manageaccounttable;
use Illuminate\Http\Request;
use Livewire\Component;

class Edituserdata extends Component
{
    public $userdata;
    public function mount($id){
        $this->userdata = userhierarchytab::where('id',$id)->first();
    }
    public function render()
    {
        $usercategory = userroletab::get();
        $userhierarchy = userhierarchytab::get();
        return view('livewire.edituserdata', ['usercategory' => $usercategory,'hierarchy'=>$userhierarchy])->layout('layouts.header');
    }
   
    public function edituser(Request $request, $id)
{
    $userdeatil = userhierarchytab::where('id', $id)->first();

    $userdeatil->rgid = $request->distributorId;
    $userdeatil->registerid = $request->registerid;
    $userdeatil->assignid = $request->assignid;
    $userdeatil->username = $request->username;
    $userdeatil->framname = $request->companyname;   
    $userdeatil->contactno = $request->contactno;
    $userdeatil->email = $request->email;
    $userdeatil->address = $request->address;
    $userdeatil->region = $request->region;
    $userdeatil->tehsils = $request->tehsils;
    $userdeatil->roleid = $request->roleid;
    $userdeatil->alternativenum = $request->alternativenum;
    $userdeatil->insertdate = $request->insertdate;
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
    $userdeatil->udyamcard = $request->udyamcard;

    if ($request->hasFile('file')) {
        $image = time() . '.' . $request->file->extension();
        $request->file->move(public_path('images/'), $image);
        $userdeatil->file = $image;
    }

    $userdeatil->save();

    // Update the product junction table
    productjunction::where('uid', $userdeatil->id)->update(['rid' => $request->roleid]);

    // Update the manage account table
    $manageaccount = manageaccounttable::where('ragisternum', $id)->first();
    $manageaccount->role = $request->roleid;
    $manageaccount->save();

    return redirect('distributorlist');
}

}