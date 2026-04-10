<?php

namespace App\Livewire;
use App\Models\orderlisttab;
use App\Models\userhierarchytab;
use App\Models\productadmintab;
use App\Models\productjunction;
use Illuminate\Http\Request;
use Livewire\Component;

class Userstocklist extends Component
{   public $getroleid;
    public $junctiontab;
    public $products;
    
    public function mount($id)
    {
        // Fetch data related to the specific role
        $this->getroleid = userhierarchytab::where('roleid', $id)->get();
    
        // Get product junction records for the given role ID
        $this->junctiontab = productjunction::where('rid', $id)->get();
    
        // Fetch all products to cross-check with the `productjunction` entries
        $this->products = productadmintab::all();
    }
    public function render()
    {
          // Retrieve data for `productadmintab`, `userhierarchytab`, and `orderlisttab`
          $product = productadmintab::all();
          $users = userhierarchytab::all();
          $data = orderlisttab::all();
        return view('livewire.userstocklist', [
            'tab' => $data,
            'products' => $product,
            'userdata' => $users
        ])->layout('layouts.header');
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
