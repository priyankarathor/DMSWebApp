<?php

namespace App\Livewire;
use App\Models\orderlisttab;
use App\Models\userhierarchytab;
use App\Models\productadmintab;
use App\Models\productjunction;
use App\Models\orderapprovedtable;
use App\Models\userroletab;
use Illuminate\Http\Request;
use Livewire\Component;

class Distributerorderlist extends Component
{
    public function render()
    {
        $product = productadmintab::get();
        $users = userhierarchytab::get();
        $data =  orderlisttab::get();
        $roles = userroletab::get();
        return view('livewire.distributerorderlist',['tab'=>$data,'products'=>$product,'userdata'=>$users,'roles'=>$roles])->layout('layouts.header');
    }

public function getapporder(Request $data)
{
    $orderdata = new orderlisttab();

    $orderdata->userid = $data->userid; 
    $orderdata->orderstatus = $data->orderstatus;
    $orderdata->productbulk = $data->productbulk;
    $orderdata->qtymasurment = $data->qtymasurment;
    $orderdata->totalqty = $data->totalqty;
    $orderdata->pid = $data->pid;
    $orderdata->price = $data->price;
    $orderdata->totalPrice = $data->totalPrice;
    $orderdata->grandTotal = $data->grandTotal;
    $orderdata->priceId = $data->priceId;
    $orderdata->batchId = $data->batchId;
    $orderdata->sellerid = $data->sellerid;

    // Save the order data
    $orderdata->save();

    // Return a JSON response with inserted order details and success message
    return response()->json([
        'success' => true,
        'message' => 'Order saved successfully',
        'data' => $orderdata  // include the saved order data in the response
    ], 200);
}

  public function productjunctiondata() {
        $advertismentsec = productjunction::get();
    
        if($advertismentsec->isNotEmpty()) {
            return response()->json([
                'inventory List' => $advertismentsec,
                'Status' => 'Success'
            ], 200);
        } else {
            return response()->json([
                'Status' => 'Failed',
                'Message' => 'No data found'
            ], 200);
        }
    }
    
    
     public function orderhistorydata() {
        $orderhistory = orderapprovedtable::get();
    
        if($orderhistory->isNotEmpty()) {
            return response()->json([
                'order history List' => $orderhistory,
                'Status' => 'Success'
            ], 200);
        } else {
            return response()->json([
                'Status' => 'Failed',
                'Message' => 'No data found'
            ], 200);
        }
    }
    
      public function productorderdata() {
        $ordersec = orderlisttab::get();
    
        if($ordersec->isNotEmpty()) {
            return response()->json([
                'order List' => $ordersec,
                'Status' => 'Success'
            ], 200);
        } else {
            return response()->json([
                'Status' => 'Failed',
                'Message' => 'No data found'
            ], 200);
        }
    }
    
      
}