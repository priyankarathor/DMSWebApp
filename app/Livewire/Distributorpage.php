<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\userhierarchytab;
use App\Models\userroletab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class Distributorpage extends Component
{
    public $user;
    public $userId;
    public $role;
    public $userrole;

    public function mount()
    {
        $this->user = Auth::user();

        $this->userId = $this->user ? $this->user->id : null;
        $this->role = $this->user ? $this->user->role : null;

        // ✅ FIX HERE
        $this->userrole = $this->user ? $this->user->userrole : null;

        // dd($this->userId);
    }


    public function render()
    {
        $usercategory = userroletab::get();
        $userhierarchy = userhierarchytab::get();

        return view('livewire.distributorpage', [
            'usercategory' => $usercategory,
            'hierarchy' => $userhierarchy
        ])->layout('layouts.header');
    }

    public function getRegisterId($roleId)
    {
        $role = userroletab::find($roleId);

        if (!$role) {
            return response()->json([
                'status' => false,
                'message' => 'Role not found'
            ], 404);
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

        if (!isset($prefixMap[$roleName])) {
            return response()->json([
                'status' => false,
                'message' => 'Prefix not defined for this role'
            ], 400);
        }

        $prefix = $prefixMap[$roleName];

        $lastUser = userhierarchytab::where('registerid', 'like', $prefix . '-%')
            ->orderByRaw("CAST(SUBSTRING_INDEX(registerid, '-', -1) AS UNSIGNED) DESC")
            ->first();

        if ($lastUser && !empty($lastUser->registerid)) {
            $parts = explode('-', $lastUser->registerid);
            $lastNumber = isset($parts[1]) ? (int) $parts[1] : 0;
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        $registerId = $prefix . '-' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);

        return response()->json([
            'status' => true,
            'registerid' => $registerId
        ]);
    }

    public function distributerdata(Request $request)
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

        if ($lastUser && !empty($lastUser->registerid)) {
            $parts = explode('-', $lastUser->registerid);
            $lastNumber = isset($parts[1]) ? (int) $parts[1] : 0;
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        $registerId = $prefix . '-' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);

        $userdeatil = new userhierarchytab();
        $userdeatil->zonalId = $request->zonalId;
        $userdeatil->rgid = $request->distributorId;
        $userdeatil->registerid = $registerId;
        $userdeatil->assignid = $request->assignid;
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

        $userdeatil->active = 'deactivate';

        $userdeatil->userId = $request->userId;

        if ($request->hasFile('file')) {
            $imageName = time() . '.' . $request->file('file')->extension();
            $request->file('file')->move(public_path('image'), $imageName);
            $userdeatil->file = $imageName;
        }

        $userdeatil->save();

        return back()->with('success', 'User created successfully');
    }

    public function distributer()
    {
        $distributer = userhierarchytab::get();

        if ($distributer) {
            return response()->json([
                'Aboutsection List' => $distributer,
                'Status' => 'Success'
            ], 200);
        } else {
            return response()->json([
                'Status' => 'Failed'
            ], 200);
        }
    }

    /**
     * GET /api/get_hierarchy/{id}
     * Returns full nested tree from a given user ID
     */
    public function getHierarchy($id)
    {
        $user = UserHierarchyTab::find($id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
            ], 404);
        }

        $tree = $this->buildTree($user);

        return response()->json([
            'status' => true,
            'data' => $tree,
        ]);
    }

    /**
     * GET /api/get_all_descendants/{id}
     * Returns a flat list of ALL descendants (all levels deep)
     */
    public function getAllDescendants($id)
    {
        // ✅ Find the user by ID only (no active filter on parent)
        $user = UserHierarchyTab::find($id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
            ], 404);
        }

        $descendants = [];
        $this->collectDescendants($id, $descendants);

        return response()->json([
            'status' => true,
            'total' => count($descendants),
            'data' => $descendants,
        ]);
    }

    // -------------------------------------------------------
    // PRIVATE HELPERS
    // -------------------------------------------------------

    /**
     * Recursively build a nested tree for a given user node
     */
    private function buildTree(UserHierarchyTab $user): array
    {
        $children = UserHierarchyTab::where('assignid', $user->id)
            ->where('active', '!=', 'deactivate') // ✅ Skip deactivated
            ->get();

        $childNodes = [];
        foreach ($children as $child) {
            $childNodes[] = $this->buildTree($child);
        }

        return [
            'id' => $user->id,
            'username' => $user->username,
            'role' => $user->framname,
            'roleid' => $user->roleid,
            'email' => $user->email,
            'contact' => $user->contactno,
            'city' => $user->city,
            'state' => $user->state,
            'active' => $user->active,
            'children' => $childNodes,
        ];
    }

    /**
     * Recursively collect all descendants into a flat array
     */
    private function collectDescendants(int $parentId, array &$result): void
    {
        $children = UserHierarchyTab::where('zonalId', $parentId)
            ->where('active', '!=', 'deactivate') // ✅ Skip deactivated users
            ->get();

        foreach ($children as $child) {
            $result[] = [
                'id' => $child->id,
                'username' => $child->username,
                'role' => $child->framname,
                'roleid' => $child->roleid,
                'zonalId' => $child->zonalId,
                'email' => $child->email,
                'contact' => $child->contactno,
                'city' => $child->city,
                'state' => $child->state,
                'active' => $child->active,
            ];
            $this->collectDescendants($child->id, $result);
        }
    }
}