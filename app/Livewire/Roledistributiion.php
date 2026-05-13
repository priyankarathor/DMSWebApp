<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\userhierarchytab;
use App\Models\userroletab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Roledistributiion extends Component
{
    public $user;

    public $authUserHierarchyId;
    public $authRoleId;
    public $userrole;

    public $firstUserId;
    public $firstRoleId;
    public $firstRegisterId;
    public $firstUsername;
    public $firstState;

    public $secondUserId;
    public $secondRoleId;
    public $secondRegisterId;
    public $secondUsername;
    public $secondState;

    public function mount()
    {
        $this->resetAutoFillData();

        $this->user = Auth::user();

        if (!$this->user) {
            return;
        }

        $this->authUserHierarchyId = $this->user->userId;
        $this->authRoleId = $this->user->role;
        $this->userrole = $this->user->userrole;

        $authHierarchy = userhierarchytab::find($this->authUserHierarchyId);

        if (!$authHierarchy) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | FIRST DEPENDENCE LOGIC
        |--------------------------------------------------------------------------
        | Agar auth user ke zonalId me kisi user ki id hai,
        | to uska data first row me show hoga WITHOUT role check.
        */
        if (!empty($authHierarchy->zonalId)) {
            $firstParent = userhierarchytab::find($authHierarchy->zonalId);

            if ($firstParent) {
                $this->firstUserId = $firstParent->id;
                $this->firstRoleId = $firstParent->roleid;
                $this->firstRegisterId = $firstParent->registerid;
                $this->firstUsername = $firstParent->username;
                $this->firstState = $firstParent->state;
            }
        } else {
            $this->firstUserId = $authHierarchy->id;
            $this->firstRoleId = $authHierarchy->roleid;
            $this->firstRegisterId = $authHierarchy->registerid;
            $this->firstUsername = $authHierarchy->username;
            $this->firstState = $authHierarchy->state;
        }

        /*
        |--------------------------------------------------------------------------
        | SECOND DEPENDENCE LOGIC
        |--------------------------------------------------------------------------
        | Agar login user ka role 7 se jyada hai,
        | to current auth user ka data second dependence me auto-fill hoga.
        */
        if ((int) $this->userrole > 7) {
            $this->secondUserId = $authHierarchy->id;
            $this->secondRoleId = $authHierarchy->roleid;
            $this->secondRegisterId = $authHierarchy->registerid;
            $this->secondUsername = $authHierarchy->username;
            $this->secondState = $authHierarchy->state;
        }
    }

    private function resetAutoFillData()
    {
        $this->authUserHierarchyId = null;
        $this->authRoleId = null;
        $this->userrole = null;

        $this->firstUserId = null;
        $this->firstRoleId = null;
        $this->firstRegisterId = null;
        $this->firstUsername = null;
        $this->firstState = null;

        $this->secondUserId = null;
        $this->secondRoleId = null;
        $this->secondRegisterId = null;
        $this->secondUsername = null;
        $this->secondState = null;
    }

    public function render()
    {
        return view('livewire.roledistributiion', [
            'usercategory' => userroletab::orderBy('id', 'asc')->get(),
            'hierarchy' => userhierarchytab::orderBy('id', 'asc')->get(),
        ])->layout('layouts.header');
    }

    public function distributerdatainsert(Request $request)
    {
        $request->validate([
            'dependence' => 'required',
            'username' => 'required',
            'contactno' => 'required',
            'file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $role = userroletab::find($request->dependence);

        if (!$role) {
            return back()->with('error', 'Selected role not found');
        }

        $prefixMap = [
            'company' => 'CO',
            'national head' => 'NH',
            'state head' => 'SH',
            'zonal sales head' => 'ZSH',
            'area sales head' => 'ASM',
            'terriory sales manager' => 'TSM',
            'territory sales manager' => 'TSM',
            'cndf' => 'CD',
            'distributor' => 'D',
            'distributer' => 'D',
            'dealer' => 'DE',
            'sub dealer' => 'SD',
            'retailer' => 'R',
        ];

        $roleName = strtolower(trim($role->role));
        $prefix = $prefixMap[$roleName] ?? 'USR';

        $lastUser = userhierarchytab::where('registerid', 'like', $prefix . '-%')
            ->orderByRaw("CAST(SUBSTRING_INDEX(registerid, '-', -1) AS UNSIGNED) DESC")
            ->first();

        $nextNumber = 1;

        if ($lastUser && !empty($lastUser->registerid)) {
            $parts = explode('-', $lastUser->registerid);
            $nextNumber = isset($parts[1]) ? ((int) $parts[1] + 1) : 1;
        }

        $registerId = $prefix . '-' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);

        $userdeatil = new userhierarchytab();

        $userdeatil->rgid = $request->distributorId;
        $userdeatil->registerid = $registerId;
        $userdeatil->assignid = $request->assignid ?? null;

        $userdeatil->username = $request->username;
        $userdeatil->framname = $request->companyname;
        $userdeatil->contactno = $request->contactno;
        $userdeatil->email = $request->email;
        $userdeatil->address = $request->address;
        $userdeatil->region = $request->region;
        $userdeatil->tehsils = $request->tehsils;
        $userdeatil->roleid = $request->dependence;
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

        /*
        |--------------------------------------------------------------------------
        | PARENT ID LOGIC
        |--------------------------------------------------------------------------
        | assignid available hai to second dependence parent.
        | warna userid first dependence parent.
        */
        if (!empty($request->assignid)) {
            $parentUser = userhierarchytab::find($request->assignid);

            $userdeatil->zonalId = $parentUser->zonalId ?? $request->assignid;
            $userdeatil->userId = $parentUser->userId ?? $request->assignid;
        } elseif (!empty($request->userid)) {
            $userdeatil->zonalId = $request->userid;
            $userdeatil->userId = $request->userid;
        } else {
            $userdeatil->zonalId = null;
            $userdeatil->userId = null;
        }

        $userdeatil->active = 'deactivate';

        if ($request->hasFile('file')) {
            $imageName = time() . '.' . $request->file('file')->extension();
            $request->file('file')->move(public_path('image'), $imageName);
            $userdeatil->file = $imageName;
        } else {
            $userdeatil->file = '';
        }

        $userdeatil->save();

        return back()->with('success', 'User created successfully');
    }
}