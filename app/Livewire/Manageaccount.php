<?php

namespace App\Livewire;

use App\Models\userhierarchytab;
use App\Models\userroletab;
use App\Models\User;
use App\Models\manageaccounttable;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Mail;
use App\Mail\UserEmail;
use Illuminate\Http\Request;

class ManageAccount extends Component
{

    public function getuseraccountdata() {
        $advertismentsec = manageaccounttable::get();
    
        if($advertismentsec->isNotEmpty()) {
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
    
    
     public function userlogindata() {
        $advertismentsec = User::get();
    
        if($advertismentsec->isNotEmpty()) {
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
    
     public function userroledata() {
        $role = userroletab::get();
    
        if($role->isNotEmpty()) {
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

    public $selectedDependence; // Store the selected dependence
    public $selectedDistributorId, $selectedDealerId, $selectedSubdealerId, $selectedRetailerId;
    public $userData;

    public function updatedSelectedDistributorId($value)
    {
        $this->getUserData('distributor', $value);
    }

    public function getUserData($type, $id)
    {
        switch ($type) {
            case 'distributor':
                $this->userData = userhierarchytab::find($id);
                break;           
        }
    }

    public function render()
    {
        $mange = manageaccounttable::get(); 
        $usercategory = userroletab::get();
        $userhierarchy = userhierarchytab::get();
        return view('livewire.manageaccount', ['usercategory' => $usercategory,'hierarchy'=>$userhierarchy,'tab'=>$mange])->layout('layouts.header');
    }

    public function manageData(Request $data)
{
    // Check if the email already exists in the users table
    if (User::where('email', $data->email)->exists()) {
        // If email exists, return with an error message
        return back()->with('error', 'Email already exists in the user table.');
    }

    // Save to manageaccounttable
    $managedata = new manageaccounttable();
    $managedata->ragisternum = $data->id; // Assuming this links with another table
    $managedata->name = $data->name;
    $managedata->role = $data->role;
    $managedata->email = $data->email;
    $managedata->password = $data->password; // Optional: can hash if needed
    $managedata->roleid = $data->roleid;

    $regid = $data->input('regid', []);
    $managedata->userregisterid = implode(',', $regid);
    $managedata->save();

    // Save to users table
    $user = new User();
    $user->name = $data->name;
    $user->email = $data->email;
    $user->password = Hash::make($data->password); // Always hash password
    $user->role = $data->userrole; // Adjust as per form data
    $user->save();

    // Flash success message
    session()->flash('success', 'User data saved successfully!');
    return back();
}


    public function deleteuserdata($id)
    {
        // Find the manageaccounttable entry by ID
        $datadelete = manageaccounttable::find($id);
    
        // Check if the record exists in the manageaccounttable
        if (!$datadelete) {
            return back()->with('error', 'Account not found.');
        }
    
        // Find the User associated with the email in manageaccounttable
        $datadeleteuser = User::where('email', $datadelete->email)->first();
    
        // Check if the User record exists and delete it if found
        if ($datadeleteuser) {
            $datadeleteuser->delete();
        }
    
        // Delete the manageaccounttable entry
        $datadelete->delete();
    
        return back()->with('success', 'Account and user deleted successfully.');
    }
    

    protected function sendEmailNotification($email, $password)
    {
        $content = [
            'subject' => 'Your Invoice ID and Password Have Been Created Successfully',
            'dear' => 'Dear Customer',
            'companyName' => 'Vande Bharat Infrastructure Private Limited',
            'msg' => 'We are pleased to inform you that your invoice ID and password have been successfully created.',
            'Your Invoice ID' => $email,
            'Password' => $password,
            'note' => 'For your security, please keep your password confidential.',
            'contact' => 'If you have any questions, feel free to contact our support team.',
            'regards' => 'Best regards,',
            'serve' => 'Customer Service Team',
            'name' => 'Vande Bharat Infrastructure Private Limited',
        ];

        $view = 'admin'; // The view for your email
        Mail::to($email)->send(new UserEmail($content, $view));
    }   
}
