<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\rolediscount;
use App\Models\userroletab;
use App\Models\userhierarchytab;

class Userdiscount extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $discount_type = 'role';
    public $role_id;
    public $state;
    public $user_id;
    public $rate;

    public $users = [];

    public $edit_id = null;
    public $isEdit = false;

    public function updatedDiscountType()
    {
        $this->resetPage();
        $this->reset(['role_id', 'state', 'user_id', 'rate', 'users']);
    }

    public function updatedRoleId()
    {
        $this->resetPage();
        $this->state = null;
        $this->user_id = null;
        $this->users = [];
    }

    public function updatedState()
    {
        $this->resetPage();
        $this->user_id = null;
        $this->loadUsers();
    }

    public function loadUsers()
    {
        $this->users = [];

        if ($this->discount_type === 'user' && !empty($this->role_id) && !empty($this->state)) {
            $this->users = userhierarchytab::where('roleid', $this->role_id)
                ->whereRaw('TRIM(state) = ?', [trim($this->state)])
                ->orderBy('username')
                ->get();
        }
    }

    public function discount()
    {
        $rules = [
            'discount_type' => 'required|in:role,user',
            'role_id' => 'required',
            'rate' => 'required|numeric|min:0|max:100',
        ];

        if ($this->discount_type === 'user') {
            $rules['state'] = 'required';
            $rules['user_id'] = 'required';
        }

        $this->validate($rules);

        $user = null;

        if ($this->discount_type === 'user') {
            $user = userhierarchytab::where('id', $this->user_id)
                ->where('roleid', $this->role_id)
                ->whereRaw('TRIM(state) = ?', [trim($this->state)])
                ->first();

            if (!$user) {
                $this->addError('user_id', 'Selected user not found for this role and state.');
                return;
            }
        }

        if ($this->isEdit && $this->edit_id) {
            $discount = rolediscount::findOrFail($this->edit_id);
        } else {
            $discount = new rolediscount();
        }

        $discount->discount = $this->discount_type;
        $discount->role = $this->role_id;
        $discount->state = $this->discount_type === 'user' ? trim($this->state) : null;

        if ($this->discount_type === 'user') {
            $discount->username = $user->username ?? null;

            // IMPORTANT:
            // registerid column me selected user ka table id save hoga
            $discount->registerid = $user->id ?? null;

            $discount->email = $user->email ?? null;
        } else {
            $discount->username = null;
            $discount->registerid = null;
            $discount->email = null;
        }

        $discount->rate = $this->rate;
        $discount->save();

        session()->flash(
            'success',
            $this->isEdit ? 'Discount updated successfully.' : 'Discount added successfully.'
        );

        $this->resetForm();
    }

    public function editDiscount($id)
    {
        $data = rolediscount::findOrFail($id);

        $this->edit_id = $data->id;
        $this->isEdit = true;

        $this->discount_type = $data->discount ?? 'role';
        $this->role_id = $data->role;
        $this->state = $data->state;
        $this->rate = $data->rate;

        $this->loadUsers();

        if ($this->discount_type === 'user') {
            // registerid column me userhierarchytab ka id saved hai
            // isliye edit time wahi selected user dropdown me selected hoga
            $this->user_id = userhierarchytab::where('id', $data->registerid)
                ->where('roleid', $data->role)
                ->whereRaw('TRIM(state) = ?', [trim($data->state)])
                ->value('id');
        }
    }

    public function cancelEdit()
    {
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset([
            'role_id',
            'state',
            'user_id',
            'rate',
            'users',
            'edit_id',
            'isEdit',
        ]);

        $this->discount_type = 'role';
    }

    public function deletediscountdata($id)
    {
        $data = rolediscount::find($id);

        if ($data) {
            $data->delete();
            session()->flash('success', 'Discount deleted successfully.');
        }

        if ($this->edit_id == $id) {
            $this->resetForm();
        }
    }

    public function render()
    {
        return view('livewire.userdiscount', [
            'tab' => userroletab::orderBy('role')->get(),

            'states' => userhierarchytab::select('state')
                ->whereNotNull('state')
                ->where('state', '!=', '')
                ->distinct()
                ->orderBy('state')
                ->get(),

            'disocunt' => rolediscount::latest()->paginate(10),
        ])->layout('layouts.header');
    }
}