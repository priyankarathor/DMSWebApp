<?php

namespace App\Livewire;

use App\Models\userhierarchytab;
use App\Models\userroletab;
use App\Models\User;
use App\Models\manageaccounttable;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class ManageAccount extends Component
{
    public function render()
    {
        $mange = manageaccounttable::latest()->get();
        $usercategory = userroletab::get();
        $userhierarchy = userhierarchytab::get();

        return view('livewire.manageaccount', [
            'usercategory' => $usercategory,
            'hierarchy' => $userhierarchy,
            'tab' => $mange
        ])->layout('layouts.header');
    }

    public function manageData(Request $data)
    {
        if (User::where('email', $data->email)->exists()) {
            return back()->with('error', 'Email already exists in the user table.');
        }

        $managedata = new manageaccounttable();
        $managedata->ragisternum = $data->id;
        $managedata->name = $data->name;
        $managedata->role = $data->role;
        $managedata->email = $data->email;
        $managedata->password = $data->password;
        $managedata->roleid = $data->roleid;

        $regid = $data->input('regid', []);
        $managedata->userregisterid = implode(',', $regid);
        $managedata->save();

        $user = new User();
        $user->name = $data->name;
        $user->email = $data->email;
        $user->password = Hash::make($data->password);
        $user->role = $data->userrole;
        $user->userId = $data->id;
        $user->userrole = $data->roleid;
        $user->save();

        $hierarchy = userhierarchytab::where('id', $data->id)->first();

        if ($hierarchy) {
            $hierarchy->userId = $user->id;
            $hierarchy->active = 'Active';
            $hierarchy->save();
        }

        return back()->with('success', 'User data saved successfully!');
    }

    public function deleteuserdata($id)
    {
        $datadelete = manageaccounttable::find($id);

        if (!$datadelete) {
            return back()->with('error', 'Account not found.');
        }

        $datadeleteuser = User::where('email', $datadelete->email)->first();

        if ($datadeleteuser) {
            $datadeleteuser->delete();
        }

        $datadelete->delete();

        return back()->with('success', 'Account and user deleted successfully.');
    }


    public function getuseraccountdata()
    {
        $advertismentsec = manageaccounttable::get();

        if ($advertismentsec->isNotEmpty()) {
            return response()->json([
                'account List' => $advertismentsec,
                'Status' => 'Success'
            ], 200);
        } else {
            return response()->json([
                'Status' => 'Failed',
                'Message' => 'No data found'
            ], 200);
        }
    }


    public function userlogindata()
    {
        $advertismentsec = User::get();

        if ($advertismentsec->isNotEmpty()) {
            return response()->json([
                'Login List' => $advertismentsec,
                'Status' => 'Success'
            ], 200);
        } else {
            return response()->json([
                'Status' => 'Failed',
                'Message' => 'No data found'
            ], 200);
        }
    }

    public function userroledata()
    {
        $role = userroletab::get();

        if ($role->isNotEmpty()) {
            return response()->json([
                'role' => $role,
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