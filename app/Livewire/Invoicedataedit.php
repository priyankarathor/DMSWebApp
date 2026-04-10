<?php

namespace App\Livewire;
use App\Models\invoicetable;
use App\Models\productadmintab;
use Illuminate\Http\Request;
use Livewire\Component;

class Invoicedataedit extends Component
{
    public $datatable;
    public function mount($id){
        $this->datatable = invoicetable::where('id',$id)->first();
    }
    public function render()
    {
        $data = productadmintab::get();
        return view('livewire.invoicedataedit',['tab'=>$data])->layout('layouts.header');
    }
    public function invoiceeditdata(Request $data,$id){
        $insertdata =invoicetable::where('id',$id)->first();
        $insertdata->invoicenum = $data->invoicenum;
        $insertdata->invoicedate = $data->invoicedate;
        $insertdata->companyname = $data->companyname;
        $insertdata->companyaddress = $data->companyaddress;
        $insertdata->companygsn = $data->companygsn;
        $insertdata->companycontact = $data->companycontact;
        $insertdata->companyemail = $data->companyemail;
        $insertdata->udyamno = $data->udyamno;
        $insertdata->vehicleno = $data->vehicleno;
        $insertdata->drivername = $data->drivername;
        $insertdata->drivercompany = $data->drivercompany;
        $insertdata->drivercontact = $data->drivercontact;
    
        // Handle description, gstrate, bulk, etc.
        $description = $data->input('description', []);  
        $insertdata->description = implode(',', $description);

        $hsncode = $data->input('hsncode', []);  
        $insertdata->hsncode = implode(',', $hsncode);
        
        $gstrate = $data->input('gstrate', []);  
        $insertdata->gstrate = implode(',', $gstrate);
    
        $bulk = $data->input('bulk', []);  
        $insertdata->qty = implode(',', $bulk);
    
        // Concatenate qty and weight
        $qty = $data->input('qty', []);  // Retrieve qty array
        $weight = $data->input('wight', []);  // Retrieve weight array
    
        $actualqty = [];
        foreach($qty as $index => $q) {
            // Concatenate qty and weight for each index
            $actualqty[] = $q . '-' . ($weight[$index] ?? '');
        }
    
        $insertdata->actualqty = implode(',', $actualqty);  // Insert concatenated qty-weight into actualqty
    
        // Handle other fields
        $sgst = $data->input('sgst', []);  
        $insertdata->sgst = implode(',', $sgst);
    
        $cgst = $data->input('cgst', []);  
        $insertdata->cgst = implode(',', $cgst);
    
        $igst = $data->input('igst', []);  
        $insertdata->igst = implode(',', $igst);
    
        $amount= $data->input('amount', []);  
        $insertdata->amount = implode(',', $amount);
    
        $selectgst = $data->input('selectgst', []);  
        $insertdata->selectgst = implode(',', $selectgst);
    
        $totalamount = $data->input('totalamount', []);  
        $insertdata->totalamount = implode(',', $totalamount);
    
        // Save the current row to the database
        $insertdata->save();
    
        // Redirect after saving
        return redirect('invoicedatatable');
    }
}
