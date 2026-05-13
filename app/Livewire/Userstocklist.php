<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\userhierarchytab;

class Userstocklist extends Component
{
    public $roleId;
    public $users;

    public function mount($id)
    {
        $this->roleId = $id;

        $this->users = userhierarchytab::where('roleid', $id)->get();
    }

    public function render()
    {
        return view('livewire.userstocklist')->layout('layouts.header');
    }
}