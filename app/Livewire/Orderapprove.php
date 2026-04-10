<?php

namespace App\Livewire;
use App\Models\orderlisttab;
use App\Models\productjunction;
use App\Models\userroletab;
use App\Models\userhierarchytab;
use App\Models\productadmintab;
use App\Models\manageaccounttable;
use App\Models\orderapprovedtable;
use App\Models\rolediscount;
use Illuminate\Http\Request;
use Livewire\Component;

class Orderapprove extends Component
{
    public $value;
    public $data;
    public $userid;
    public $productid;
    public $products;
 

    public function mount($id)
    {
        $this->value = orderlisttab::where('id', $id)->first();
    
        if (!$this->value) {
            return;
        }
    
        $this->userid = userhierarchytab::where('id', $this->value->userid)->first();
    
        // Retrieve product IDs, statuses, and other fields
        $productIds = explode(',', $this->value->pid);
        $statuses = explode(',', $this->value->orderstatus);
        $bulkQuantities = explode(',', $this->value->productbulk); // Bulk quantities
        $bulktotalqty = explode(',', $this->value->totalqty); // Total quantities
        $bulkmasurment = explode(',', $this->value->qtymasurment); // Measurements
        $bulkPrice = explode(',', $this->value->price); // Price
    
        $this->products = [];
    
        // Filter for "Approve" products only
        foreach ($productIds as $index => $pid) {
            if (isset($statuses[$index]) && trim($statuses[$index]) === 'Approve') {
                $product = productadmintab::where('id', trim($pid))->first();
                if ($product) {
                    // Assign corresponding values
                    $product->bulk_quantity = $bulkQuantities[$index] ?? '';
                    $product->bulk_total = $bulktotalqty[$index] ?? ''; // Assign total quantity
                    $product->bulk_masurment = $bulkmasurment[$index] ?? ''; // Assign measurement
                     $product->bulk_price = $bulkPrice[$index] ?? '';
                    $this->products[] = $product;
                }
            }
        }
    }
    
    
    public $lastnum;
    public function render()
    {
        $userdata = auth()->user();
    
      
        if ($userdata) {
            // Retrieve the first record matching the authenticated user's email
            $manageuser = manageaccounttable::where('email', $userdata->email)->first(); 
            $userRoles = userroletab::all();
            $userHierarchyData = userhierarchytab::all();
        }
    

        $this->lastnum = orderapprovedtable::latest()->first();
       

        $discount = rolediscount::get();
        return view('livewire.orderapprove', [
            'tab' => $userRoles,
            'userdata' => $userHierarchyData,
            'users' => $manageuser,
            'roles' => $userRoles,
            'rolediscounts' => $discount
        ])->layout('layouts.header');
    }

    public function insertdistributerdata(Request $data,$id) {
        // Create a new order
        $ordervalue = new orderapprovedtable();
        
        // Assigning form data to $ordervalue fields
        $ordervalue->discount = $data->discount;
        $ordervalue->approveuserid = $data->adminid;
        $ordervalue->invoiceno = $data->invoicenum;
        $ordervalue->invoicedate = $data->invoicedate;
        $ordervalue->framname = $data->framname;
        $ordervalue->gstnumber = $data->gstnumber;
        $ordervalue->username = $data->username;
        $ordervalue->contactno = $data->contactno;  
        $ordervalue->email = $data->email;
        $ordervalue->region = $data->region;
        $ordervalue->address = $data->address;
        $ordervalue->userrole = $data->userrole;
        $ordervalue->drivername = $data->drivername;
        $ordervalue->drivercompany = $data->drivercompany;
        $ordervalue->vehicleno = $data->vehicleno;
        $ordervalue->drivercontact = $data->drivercontact;
        $ordervalue->udyamno = $data->udyamno;
        $ordervalue->roleid = $data->roleid;
        $ordervalue->userid = $data->userid;
    
        // Combine product IDs, names, quantities and other details as required
        $ordervalue->productid = implode(',', $data->input('prid', []));
        $ordervalue->productname = implode(',', $data->input('productname', []));
    
        // Combine product quantity and weight
        $productquantity = $data->input('productquantity', []);
        $weightclass = $data->input('weightclass', []);
        $combinedValues = [];
    
        foreach ($productquantity as $index => $quantity) {
            $combinedValues[] = $quantity . ' ' . ($weightclass[$index] ?? '');
        }
        $ordervalue->productquantity = implode(',', $combinedValues);
    
        // Continue assigning other fields
        $ordervalue->measurement = implode(',', $data->input('bulkmasurment', []));
        $ordervalue->totalpcs = implode(',', $data->input('bulktotalqty', []));

        $ordervalue->productbulk = implode(',', $data->input('productbulk', []));
        $ordervalue->gstrate = implode(',', $data->input('gstrate', []));
        $ordervalue->sgst = implode(',', $data->input('sgst', []));
        $ordervalue->cgst = implode(',', $data->input('cgst', []));
        $ordervalue->igst = implode(',', $data->input('igst', []));
        $ordervalue->amount = implode(',', $data->input('amount', []));
        $ordervalue->hsnno = implode(',', $data->input('hsn', []));
        $ordervalue->selectgst = implode(',', $data->input('selectgst', []));
        $ordervalue->totalamount = implode(',', $data->input('totalamount', []));
    
        // Save the order
        $ordervalue->save();
    
        $pridList = $data->input('prid', []);
        $productbulkList = $data->input('productbulk', []);
        $roleid = $data->roleid;
        $userid = $data->userid;
        
        foreach ($pridList as $index => $prid) {
            $adminid = $data->adminid;
        
            // Check if the product junction for the admin with 'ho' UID and matching PID exists
            $existingAdminProduct = productjunction::where('uid',  $adminid)
                ->where('pid', $prid)
                ->first();
        
            // Check if a product junction exists for the current role and user with the same PID
            $existingRecord = productjunction::where('rid', $roleid)
                ->where('uid', $userid)
                ->where('pid', $prid)
                ->first();
        
            if ($existingRecord) {
                // Update the inventories
                if ($existingAdminProduct) {
                    $existingAdminProduct->inventery -= $productbulkList[$index] ?? 0;
                    $existingAdminProduct->save(); // Save the updated inventory for the admin
                }
                
                $existingRecord->inventery += $productbulkList[$index] ?? 0;
                $existingRecord->save(); // Save the updated record for the current user
            } else {
                // If no record exists, create a new one for the current user
                $productjunction = new productjunction();
                $productjunction->rid = $roleid;
                $productjunction->uid = $userid;
                $productjunction->pid = $prid;
                $productjunction->inventery = $productbulkList[$index] ?? 0;
                $productjunction->save();
        
                // Reduce admin's inventory if it's a new record for the current user
                if ($existingAdminProduct) {
                    $existingAdminProduct->inventery -= $productbulkList[$index] ?? 0;
                    $existingAdminProduct->save();
                }
            }
        }

//delete comma data
// Retrieve the order by ID
$deletedata = orderlisttab::where('id', $id)->first();

if ($deletedata) {
    // Split comma-separated fields into arrays
    $pids = explode(',', $deletedata->pid);
    $statuses = explode(',', $deletedata->orderstatus);
    $bulkQuantities = explode(',', $deletedata->productbulk);

    // Arrays to hold non-approve data
    $filteredPids = [];
    $filteredBulkQuantities = [];
    $filteredStatuses = [];

    // Loop through statuses and filter out only the 'Approve' entries
    foreach ($statuses as $index => $status) {
        if (trim($status) !== 'Approve') {
            $filteredPids[] = $pids[$index] ?? '';
            $filteredBulkQuantities[] = $bulkQuantities[$index] ?? '';
            $filteredStatuses[] = $status;
        }
    }

    // Check if there's any data left after filtering
    if (!empty($filteredPids)) {
        // Update the fields with remaining non-approve data
        $deletedata->pid = implode(',', $filteredPids);
        $deletedata->productbulk = implode(',', $filteredBulkQuantities);
        $deletedata->orderstatus = implode(',', $filteredStatuses);
        $deletedata->save();
    } else {
        // If no data left, delete the entire row
        $deletedata->delete();
    }
}

//end delete data
        
        
        return redirect('Quotationinvoicedata');
    }

    public function deletedata($id){
        $deletedata = orderapprovedtable::where('id',$id)->first();
        $deletedata->delete();
        return back();
    }

}
