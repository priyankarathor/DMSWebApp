<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\rolediscount;
use App\Models\userroletab;
use App\Models\userhierarchytab;

class Userdiscount extends Component
{
    public $discount_type = 'role'; // role or user

    public $role_id;
    public $state;
    public $user_id;
    public $rate;

    public $users = [];

    public function updatedRoleId()
    {
        $this->loadUsers();
    }

    public function updatedState()
    {
        $this->loadUsers();
    }

    public function updatedDiscountType()
    {
        $this->reset(['role_id', 'state', 'user_id', 'rate', 'users']);
    }

    public function loadUsers()
    {
        if ($this->discount_type === 'user' && $this->role_id && $this->state) {
            $this->users = userhierarchytab::where('roleid', $this->role_id)
                ->where('state', $this->state)
                ->get();
        } else {
            $this->users = [];
        }
    }

    public function discount()
    {
        $this->validate([
            'discount_type' => 'required',
            'role_id' => 'required',
            'rate' => 'required|numeric',
        ]);

        if ($this->discount_type === 'user') {
            $this->validate([
                'state' => 'required',
                'user_id' => 'required',
            ]);
        }

        $user = null;

        if ($this->discount_type === 'user') {
            $user = userhierarchytab::where('id', $this->user_id)
                ->where('roleid', $this->role_id)
                ->where('state', $this->state)
                ->first();
        }

        rolediscount::create([
            'discount' => $this->discount_type,
            'role' => $this->role_id,
            'state' => $this->discount_type === 'user' ? $this->state : null,
            'username' => $user->username ?? null,
            'registerid' => $user->id ?? null,
            'email' => $user->email ?? null,
            'rate' => $this->rate,
        ]);

        session()->flash('success', 'Discount added successfully.');

        $this->reset(['role_id', 'state', 'user_id', 'rate', 'users']);
        $this->discount_type = 'role';
    }

    public function deletediscountdata($id)
    {
        $data = rolediscount::find($id);

        if ($data) {
            $data->delete();
            session()->flash('success', 'Discount deleted successfully.');
        }
    }

    public function render()
    {
        $roles = userroletab::get();

        $states = userhierarchytab::select('state')
            ->whereNotNull('state')
            ->distinct()
            ->get();

        $discountdata = rolediscount::latest()->get();

        return view('livewire.userdiscount', [
            'tab' => $roles,
            'states' => $states,
            'disocunt' => $discountdata,
        ])->layout('layouts.header');
    }
}