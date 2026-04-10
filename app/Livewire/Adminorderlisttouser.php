<?php

namespace App\Livewire;
use App\Models\orderlisttab;
use App\Models\userhierarchytab;
use App\Models\userroletab;
use App\Models\productadmintab;
use Illuminate\Http\Request;
use Livewire\Component;

class Adminorderlisttouser extends Component
{
    public function render()
    {
        $product = productadmintab::get();
        $users = userhierarchytab::get();
        $data =  orderlisttab::get();
        
        $role = userroletab::get();
        return view('livewire.adminorderlisttouser',['tab'=>$data,'products'=>$product,'userdata'=>$users,'userrole'=>$role])->layout('layouts.header');
    }
public function getapporder(Request $data)
{
    $orderdata = new orderlisttab();

    // Directly assign the values from the request since they are already comma-separated strings
    if ($data->productname != null) {
        $orderdata->productname = $data->productname;
    }

    if ($data->productquantity != null) {
        $orderdata->productquantity = $data->productquantity;
    }

    if ($data->productexpected != null) {
        $orderdata->productexpected = $data->productexpected;
    }

    if ($data->productbulk != null) {
        $orderdata->productbulk = $data->productbulk;
    }

    if ($data->orderstatus != null) {
        $orderdata->orderstatus = $data->orderstatus;
    }

    if ($data->productprice != null) {
        $orderdata->productprice = $data->productprice;
    }

    // Assign remaining fields directly from the request
    $orderdata->productdeliveryadd = $data->productdeliveryadd; 
    $orderdata->userid = $data->userid;
    $orderdata->userregisterid = $data->userregisterid;
    $orderdata->username = $data->username;
    $orderdata->useremail = $data->useremail;
    $orderdata->userphone = $data->userphone;
    $orderdata->userrole = $data->userrole;

    // Save the order data
    $orderdata->save();

    return back()->with('success', 'Order saved successfully');
}   
}