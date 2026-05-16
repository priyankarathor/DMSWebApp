<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserHierarchyTab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    // ─────────────────────────────────────────────────────────────────────────
    // GET /api/get-parent-details/{parentId}
    //
    // Called by frontend on form load.
    // Returns parent + grandparent details to auto-fill the two hierarchy rows.
    // Also returns all available roles from userroletabs for the role dropdown.
    // ─────────────────────────────────────────────────────────────────────────
    public function getParentDetails($parentId)
    {
        // ── Parent user (joined with role table) ──────────────────────────
        $parent = DB::table('userhierarchytabs as u')
            ->leftJoin('userroletabs as r', 'r.id', '=', 'u.roleid')
            ->where('u.id', $parentId)
            ->select(
                'u.id',
                'u.username',
                'u.framname as full_name',   // user's full name
                'u.email',
                'u.contactno',
                'u.zonalId',
                'u.roleid',
                'u.rgid',
                'u.region',
                'u.city',
                'u.state',
                'r.id   as role_id',
                'r.role as role_name'        // role label from userroletabs
            )
            ->first();

        if (!$parent) {
            return response()->json([
                'status' => false,
                'message' => 'Parent user not found.',
            ], 404);
        }

        // ── Grandparent user (joined with role table) ─────────────────────
        $grandParent = null;
        if ($parent->zonalId) {
            $grandParent = DB::table('userhierarchytabs as u')
                ->leftJoin('userroletabs as r', 'r.id', '=', 'u.roleid')
                ->where('u.id', $parent->zonalId)
                ->select(
                    'u.id',
                    'u.username',
                    'u.framname as full_name',
                    'u.roleid',
                    'u.region',
                    'u.city',
                    'u.state',
                    'r.id   as role_id',
                    'r.role as role_name'
                )
                ->first();
        }

        // ── Only roles AFTER the parent's role (for the dropdown) ───────────
        // Since userroletabs.id follows hierarchy order, we fetch roles
        // where id > parent's roleid so user can only assign a lower role.
        $roles = DB::table('userroletabs')
            ->select('id', 'role')
            ->where('id', '>', $parent->roleid)
            ->orderBy('id')
            ->get();

        return response()->json([
            'status' => true,
            'data' => [
                'grand_parent' => $grandParent ? [
                    'id' => $grandParent->id,
                    'username' => $grandParent->username,
                    'full_name' => $grandParent->full_name,
                    'roleid' => $grandParent->role_id,
                    'role_name' => $grandParent->role_name,
                    'region' => $grandParent->region,
                    'city' => $grandParent->city,
                    'state' => $grandParent->state,
                ] : null,

                'parent' => [
                    'id' => $parent->id,
                    'username' => $parent->username,
                    'full_name' => $parent->full_name,
                    'roleid' => $parent->role_id,
                    'role_name' => $parent->role_name,
                    'region' => $parent->region,
                    'city' => $parent->city,
                    'state' => $parent->state,
                ],

                // Dropdown options for "Select Role"
                'roles' => $roles,
            ],
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // POST /api/create-employee
    // ─────────────────────────────────────────────────────────────────────────
    public function createEmployee(Request $request)
    {
        // ── 1. Validate ───────────────────────────────────────────────────
        $validator = Validator::make($request->all(), [
            // Required
            'parent_id' => 'required|integer|exists:userhierarchytabs,id',
            'username' => 'required|string|max:255',                // user's full name
            'roleid' => 'required|integer|exists:userroletabs,id', // FK to userroletabs
            'email' => 'required|email|unique:userhierarchytabs,email',
            'contactno' => 'required|string|max:15',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            // Optional
            'alternativenum' => 'nullable|string|max:15',
            'udyamcard' => 'nullable|string|max:255',
            'file' => 'nullable|string|max:255',
            'registerid' => 'nullable|string|max:255',
            'insertdate' => 'nullable|date',
            'gstcode' => 'nullable|string|max:20',
            'tehsils' => 'nullable|string|max:255',
            'pincode' => 'nullable|string|max:10',
            'postalcode' => 'nullable|string|max:10',
            'bankname' => 'nullable|string|max:255',
            'accountnum' => 'nullable|string|max:255',
            'ifsccode' => 'nullable|string|max:20',
            'holdername' => 'nullable|string|max:255',
            'accounttype' => 'nullable|string|in:current,savings',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        // ── 2. Load parent to inherit hierarchy values ────────────────────
        $parent = userhierarchytab::find($request->parent_id);

        // ── 3. Create employee ────────────────────────────────────────────
        $employee = userhierarchytab::create([
            // Hierarchy
            'zonalId' => $parent->id,
            'userId' => $parent->userId ?? $parent->id,
            'assignid' => $parent->id,
            'rgid' => $parent->rgid,
            'roleid' => $request->roleid,    // directly from frontend (userroletabs.id)
            'username' => $request->username,  // new user's full name

            // Personal
            'email' => $request->email,
            'contactno' => $request->contactno,
            'alternativenum' => $request->alternativenum,
            'udyamcard' => $request->udyamcard,
            'file' => $request->file,

            // Company
            'registerid' => $request->registerid,
            'insertdate' => $request->insertdate ?? now()->format('Y-m-d'),
            'gstcode' => $request->gstcode,
            'city' => $request->city,
            'state' => $request->state,
            'tehsils' => $request->tehsils,
            'region' => $request->region,
            'pincode' => $request->pincode,
            'postalcode' => $request->postalcode,
            'address' => $request->address,

            // Bank
            'bankname' => $request->bankname,
            'accountnum' => $request->accountnum,
            'ifsccode' => strtoupper($request->ifsccode ?? ''),
            'holdername' => $request->holdername,
            'accounttype' => $request->accounttype ?? 'current',

            // Status
            'active' => 'active',
        ]);

        // ── 4. Fetch saved role name for the response ─────────────────────
        $roleName = DB::table('userroletabs')
            ->where('id', $request->roleid)
            ->value('role');

        return response()->json([
            'status' => true,
            'message' => 'Employee created successfully.',
            'data' => [
                'id' => $employee->id,
                'username' => $employee->username,
                'email' => $employee->email,
                'roleid' => $employee->roleid,
                'role_name' => $roleName,
                'zonalId' => $employee->zonalId,
                'active' => $employee->active,
            ],
        ], 201);
    }


    // ─────────────────────────────────────────────────────────────────────────
    // POST /api/set-password
    //
    // Sets or resets password for a user in manageaccounttables.
    // Matches record using userid, roleid, ragisternum, name, email — all must
    // correspond to the same row to prevent setting password on wrong user.
    //
    // JSON body:
    // {
    //   "userid"     : 115,                  // required — userhierarchytabs.id
    //   "roleid"     : 4,                    // required — userroletabs.id (role column in manageaccounttables)
    //   "ragisternum": "113",                // required — manageaccounttables.ragisternum
    //   "name"       : "RK gupta",           // required — manageaccounttables.name
    //   "email"      : "Rk12@gmail.com",     // required — manageaccounttables.email
    //   "password"   : "newpassword123"      // required — min 6 characters
    // }
    // ─────────────────────────────────────────────────────────────────────────
    // ─────────────────────────────────────────────────────────────────────────
    // POST /api/set-password/{userId}
    //
    // userId in URL = userhierarchytabs.id
    // Finds the user from userhierarchytabs, then creates or updates their
    // record in manageaccounttables with the password.
    // ragisternum in manageaccounttables = userhierarchytabs.id
    //
    // JSON body:
    // {
    //   "password" : "newpassword123"   // required — min 6 characters
    // }
    // ─────────────────────────────────────────────────────────────────────────
    public function setPassword(Request $request, $userId)
    {
        // ── 1. Validate ───────────────────────────────────────────────────
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        // ── 2. Find user in userhierarchytabs ─────────────────────────────
        $hierarchyUser = DB::table('userhierarchytabs as u')
            ->leftJoin('userroletabs as r', 'r.id', '=', 'u.roleid')
            ->where('u.id', $userId)
            ->select(
                'u.id',
                'u.username',
                'u.email',
                'u.roleid',
                'u.framname',
                'r.role as role_name'
            )
            ->first();

        if (!$hierarchyUser) {
            return response()->json([
                'status' => false,
                'message' => 'User not found.',
            ], 404);
        }

        // ── 3. Check if already exists in manageaccounttables ─────────────
        // ragisternum = userhierarchytabs.id (used as the link between tables)
        $existing = DB::table('manageaccounttables')
            ->where('ragisternum', $hierarchyUser->id)
            ->first();

        $rawPassword = $request->password;
        $hashedPassword = Hash::make($rawPassword);

        // ── 4. Upsert manageaccounttables (raw password) ──────────────────
        if ($existing) {
            DB::table('manageaccounttables')
                ->where('ragisternum', $hierarchyUser->id)
                ->update([
                    'password' => $rawPassword,       // plain text
                    'updated_at' => now(),
                ]);

            $message = 'Password updated successfully.';
        } else {
            DB::table('manageaccounttables')->insert([
                'ragisternum' => $hierarchyUser->id,    // userhierarchytabs.id
                'name' => $hierarchyUser->username,
                'email' => $hierarchyUser->email,
                'role' => $hierarchyUser->role_name,
                'roleid' => $hierarchyUser->roleid,
                'password' => $rawPassword,          // plain text
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $message = 'Password set successfully.';
        }

        // ── 5. Upsert users table (hashed password) ───────────────────────
        $existingUser = DB::table('users')
            ->where('email', $hierarchyUser->email)
            ->first();

        if ($existingUser) {
            DB::table('users')
                ->where('email', $hierarchyUser->email)
                ->update([
                    'password' => $hashedPassword,    // hashed
                    'userrole' => $hierarchyUser->roleid,  // ← add this
                    'userId' => $hierarchyUser->id,      // ← add this
                    'updated_at' => now(),
                ]);
        } else {
            DB::table('users')->insert([
                'name' => $hierarchyUser->username,
                'email' => $hierarchyUser->email,
                'userrole' => $hierarchyUser->roleid,
                'userId' => $hierarchyUser->id,
                'password' => $hashedPassword,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => [
                'ragisternum' => $hierarchyUser->id,
                'name' => $hierarchyUser->username,
                'email' => $hierarchyUser->email,
                'role' => $hierarchyUser->role_name,
            ],
        ]);
    }
}