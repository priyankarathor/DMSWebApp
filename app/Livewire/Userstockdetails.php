<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\userhierarchytab;
use App\Models\productjunction;
use App\Models\productadmintab;

class Userstockdetails extends Component
{
    public $userId;
    public $user;
    public $stocks = [];

    public function mount($id)
    {
        $this->userId = $id;

        $this->user = userhierarchytab::findOrFail($id);

        $junctions = productjunction::where('uid', $id)->get();

        $this->stocks = $junctions->map(function ($item) {
            $product = productadmintab::where('id', $item->pid)->first();

            return [
                'productname' => $product->productname ?? 'N/A',
                'inventory'   => $item->inventery ?? 0,
                'pid'         => $item->pid,
            ];
        });
    }

    public function render()
    {
        return view('livewire.userstockdetails')->layout('layouts.header');
    }
}