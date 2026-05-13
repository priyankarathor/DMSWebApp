<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\userhierarchytab as Userhierarchytab  ;
use App\Models\userroletab;
use App\Models\User;
use App\Models\manageaccounttable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserEmail;
use Illuminate\Http\Request;

class Managepermission extends Component
{
    public $selectedDependence = '';
    public $selectedAssignId = '';

    public $id = '';
    public $name = '';
    public $role = '';
    public $roleid = '';
    public $email = '';
    public $password = '';
    public $userrole = 2;
    public $regid = [];

    public $usernameDisplay = '';
    public $regionDisplay = '';

    public $selectedUser = null;

    public function mount($id = null)
    {
        if ($id) {
            $user = Userhierarchytab::find($id);

            if ($user) {
                $this->selectedUser = $user;
                $this->selectedAssignId = $user->id;
                $this->selectedDependence = $user->roleid;

                $this->fillUserData($user);
            }
        }
    }

    public function fillUserData($user)
    {
        $roles = userroletab::pluck('role', 'id');

        $this->id = $user->id ?? '';
        $this->name = $user->username ?? '';
        $this->roleid = $user->roleid ?? '';
        $this->role = $roles[$user->roleid] ?? '';
        $this->email = $user->email ?? '';
        $this->usernameDisplay = $user->username ?? '';
        $this->regionDisplay = $user->region ?? '';
    }

    public function updatedSelectedAssignId($value)
    {
        $user = Userhierarchytab::find($value);

        if ($user) {
            $this->fillUserData($user);
            $this->selectedDependence = $user->roleid;
        } else {
            $this->resetUserFields();
        }
    }

    public function updatedSelectedDependence($value)
    {
        // optional: reset selected assign id if dependence changes
        $this->selectedAssignId = '';
        $this->resetUserFields();
    }

    public function resetUserFields()
    {
        $this->id = '';
        $this->name = '';
        $this->role = '';
        $this->roleid = '';
        $this->email = '';
        $this->usernameDisplay = '';
        $this->regionDisplay = '';
    }

    public function managedatalist()
{
        // dd($this->id); 
    $this->validate([
        'id'       => 'required',
        'name'     => 'required',
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    if ($this->email === $this->password) {
        session()->flash('error', 'Password cannot be the same as Email.');
        return;
    }

    if (User::where('email', $this->email)->exists()) {
        session()->flash('error', 'Email already exists in the user table.');
        return;
    }

    // manageaccounttable save
    $managedata = new manageaccounttable();
    $managedata->ragisternum = $this->id;
    $managedata->name = $this->name;
    $managedata->role = $this->role;
    $managedata->email = $this->email;
    $managedata->password = $this->password;
    $managedata->roleid = $this->roleid;
    $managedata->userregisterid = !empty($this->regid) ? implode(',', $this->regid) : null;
    $managedata->save();


   // user table save
    $user = new User();
    $user->name = $this->name;
    $user->email = $this->email;
    $user->password = Hash::make($this->password);
    $user->role = $this->userrole;
    $user->userId = $this->id;
    $user->userrole = $this->roleid;
    $user->save();

    // dd($this->Id);

    $hierarchy = Userhierarchytab::where('id', $this->id)->first();

    if ($hierarchy) {
        $hierarchy->userId = $user->id;
        $hierarchy->active = 'Active';
        $hierarchy->save();
    } 

    session()->flash('success', 'User created & hierarchy updated successfully!');

    return redirect()->route('permissionlist');
}

    public function manageaccounteditlist(Request $request, $id)
    {
        $account = manageaccounttable::find($id);

        if (!$account) {
            return redirect()->back()->with('error', 'Account not found.');
        }

        $account->name = $request->name;
        $account->role = $request->role;
        $account->email = $request->email;
        $account->roleid = $request->roleid;

        if (!empty($request->password)) {
            $account->password = $request->password;
        }

        $account->userregisterid = $request->has('regid') ? implode(',', $request->regid) : null;
        $account->save();

        $user = User::where('email', $account->email)->first();
        if ($user) {
            $user->name = $request->name;
            $user->email = $request->email;

            if (!empty($request->password)) {
                $user->password = Hash::make($request->password);
            }

            $user->save();
        }

        return redirect()->back()->with('success', 'Account updated successfully.');
    }

    public function deleteuserdata($id)
    {
        $datadelete = manageaccounttable::find($id);

        if (!$datadelete) {
            session()->flash('error', 'Account not found.');
            return;
        }

        $datadeleteuser = User::where('email', $datadelete->email)->first();

        if ($datadeleteuser) {
            $datadeleteuser->delete();
        }

        $datadelete->delete();

        session()->flash('success', 'Account and user deleted successfully.');
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

        $view = 'admin';
        Mail::to($email)->send(new UserEmail($content, $view));
    }

    public function render()
    {
        $mange = manageaccounttable::get();
        $usercategory = userroletab::get();

        $userhierarchy = Userhierarchytab::when($this->selectedDependence, function ($query) {
            $query->where('roleid', $this->selectedDependence);
        })->get();

        return view('livewire.managepermission', [
            'usercategory' => $usercategory,
            'hierarchy' => $userhierarchy,
            'tab' => $mange
        ])->layout('layouts.header');
    }
}