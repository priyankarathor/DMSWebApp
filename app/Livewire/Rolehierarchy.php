<?php

namespace App\Livewire;

use App\Models\userroletab;
use App\Models\userhierarchytab;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Rolehierarchy extends Component
{
    public $selectedCategory;

    public function render()
    {
        $user = Auth::user();
        $userId = $user->id;

        $data = userhierarchytab::where('userId', $userId)->get();
        $role = userroletab::all();

        return view('livewire.rolehierarchy', [
            'tab' => $data,
            'category' => $role
        ])->layout('layouts.header');
    }
}