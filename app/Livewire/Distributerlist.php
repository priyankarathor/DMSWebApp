<?php

namespace App\Livewire;
use App\Models\userroletab;
use App\Models\userhierarchytab;
use Livewire\Component;

class Distributerlist extends Component
{
    public $selectedCategory;
    public function render()
    {
        $data = userhierarchytab::get();
        $role = userroletab::get();
        return view('livewire.distributerlist', [
            'tab'=>$data, 'category'=>$role ])->layout('layouts.header');
    }

    
    // public function deleteinputdata($id) {
    //     // Check if the record is a distributor
    //     $deletedistributor = distributoradmintab::where('id', $id)->first();
    //     if ($deletedistributor) {
    //         $deletedistributor->delete();
    //         return back()->with('success', 'Distributor deleted successfully');
    //     }
    
    //     // Check if the record is a dealer
    //     $deletedelaer = dealertable::where('id', $id)->first();
    //     if ($deletedelaer) {
    //         $deletedelaer->delete();
    //         return back()->with('success', 'Dealer deleted successfully');
    //     }
    
    //     // Check if the record is a sub-dealer
    //     $deletesubdealer = subdealertable::where('id', $id)->first();
    //     if ($deletesubdealer) {
    //         $deletesubdealer->delete();
    //         return back()->with('success', 'Sub-dealer deleted successfully');
    //     }
    
    //     // Check if the record is a retailer
    //     $deleteretailer = retailertable::where('id', $id)->first();
    //     if ($deleteretailer) {
    //         $deleteretailer->delete();
    //         return back()->with('success', 'Retailer deleted successfully');
    //     }
    
    //     // Check if the record is an employee
    //     $deleteemployee = employeetable::where('id', $id)->first();
    //     if ($deleteemployee) {
    //         $deleteemployee->delete();
    //         return back()->with('success', 'Employee deleted successfully');
    //     }
    
    //     // If no matching record found, return with error
    //     return back()->with('error', 'Record not found in any category');
    // }
    
   
}