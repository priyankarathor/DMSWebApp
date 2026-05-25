<?php

namespace App\Livewire;

use App\Models\location;
use Illuminate\Http\Request;
use Livewire\Component;

class Locationadd extends Component
{
    public function render()
    {
        $discountdata = location::get();
        return view('livewire.locationadd', ['disocunt' => $discountdata])->layout('layouts.header');
    }

    public function locationdata(Request $data)
    {
        $discountdata = new location();
        $discountdata->location_name = $data->location_name;
        $discountdata->save();
        return back();
    }

    public function deletediscountdata($id)
    {
        $delete = location::find($id);
        $delete->delete();
        return back();
    }

    public function locationdataedit($id, Request $data)
    {

        $user = location::find($id);
        $user->location_name = $data->location_name;

        $user->save();
        return back();
    }
}
