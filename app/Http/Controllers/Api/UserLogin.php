<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\manageaccounttable;
use App\Models\userhierarchytab;
use App\Models\userroletab;
use App\Models\Userroletabs;
use App\Models\Userhierarchytabs;
use Illuminate\Http\Request;

class UserLogin extends Controller
{
    public function userlogin(Request $request)
    {
        $user = manageaccounttable::where('email', $request->email)->first();

        if ($user) {
            if ($request->password == $user->password) {

                // Fetch role details from userroletabs using userregisterid
                $roleDetails = userroletab::where('id', $user->userregisterid)->first();

                // Fetch hierarchy details from userhierarchytabs using ragisternum
                $hierarchyDetails = userhierarchytab::where('id', $user->ragisternum)->first();

                return response()->json([
                    'status' => 200,
                    'message' => 'User logged in successfully!',
                    'user' => $user,
                    'role_details' => $roleDetails,
                    'employee_details' => $hierarchyDetails,
                ]);

            } else {
                return response()->json([
                    'status' => 401,
                    'message' => 'Invalid credentials'
                ]);
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'User not found'
            ]);
        }
    }
}