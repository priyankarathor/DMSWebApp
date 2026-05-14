<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\userhierarchytab;
use App\Models\userroletab;

class Edituserdata extends Component
{
    use WithFileUploads;

    public $editId;
    public $usercategory;
    public $hierarchy;

    public $zonalId, $assignid, $username, $companyname, $contactno, $email;
    public $address, $region, $tehsils, $dependence, $alternativenum;
    public $insertdate, $postalcode, $gstcode, $pincode, $city, $state;
    public $bankname, $accountnumber, $ifsccode, $holdername, $accounttype;
    public $udyamcard, $file, $oldFile;

    public function mount($id)
    {
        $this->editId = $id;

        $user = userhierarchytab::findOrFail($id);

        $this->zonalId = $user->zonalId;
        $this->assignid = $user->assignid;
        $this->username = $user->username;
        $this->companyname = $user->framname;
        $this->contactno = $user->contactno;
        $this->email = $user->email;
        $this->address = $user->address;
        $this->region = $user->region;
        $this->tehsils = $user->tehsils;
        $this->dependence = $user->roleid;
        $this->alternativenum = $user->alternativenum;
        $this->insertdate = $user->insertdate;
        $this->postalcode = $user->postalcode;
        $this->gstcode = $user->gstcode;
        $this->pincode = $user->pincode;
        $this->city = $user->city;
        $this->state = $user->state;
        $this->bankname = $user->bankname;
        $this->accountnumber = $user->accountnum;
        $this->ifsccode = $user->ifsccode;
        $this->holdername = $user->holdername;
        $this->accounttype = $user->accounttype;
        $this->udyamcard = $user->udyamcard;
        $this->oldFile = $user->file;

        $this->usercategory = userroletab::get();
        $this->hierarchy = userhierarchytab::get();
    }

    public function updateUser()
    {
        $this->validate([
            'dependence' => 'required',
            'username' => 'required',
            'contactno' => 'required',
            'email' => 'required|email',
            'city' => 'required',
            'state' => 'required',
            'region' => 'required',
            'address' => 'required',
            'file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = userhierarchytab::findOrFail($this->editId);

        $user->zonalId = $this->zonalId;
        $user->assignid = $this->assignid;
        $user->username = $this->username;
        $user->framname = $this->companyname;
        $user->contactno = $this->contactno;
        $user->email = $this->email;
        $user->address = $this->address;
        $user->region = $this->region;
        $user->tehsils = $this->tehsils;
        $user->roleid = $this->dependence;
        $user->alternativenum = $this->alternativenum;
        $user->insertdate = $this->insertdate;
        $user->postalcode = $this->postalcode;
        $user->gstcode = $this->gstcode;
        $user->pincode = $this->pincode;
        $user->city = $this->city;
        $user->state = $this->state;
        $user->bankname = $this->bankname;
        $user->accountnum = $this->accountnumber;
        $user->ifsccode = $this->ifsccode;
        $user->holdername = $this->holdername;
        $user->accounttype = $this->accounttype;
        $user->udyamcard = $this->udyamcard;

        if ($this->file) {
            if ($user->file && file_exists(public_path('image/' . $user->file))) {
                unlink(public_path('image/' . $user->file));
            }

            $imageName = time() . '.' . $this->file->extension();
            $this->file->storeAs('', $imageName, 'custom_public_image');
            $user->file = $imageName;
        }

        $user->save();

        session()->flash('success', 'User updated successfully.');
    }

    public function render()
    {
        return view('livewire.edituserdata')->layout('layouts.header');
    }
}