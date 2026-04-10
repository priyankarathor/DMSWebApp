<?php

namespace App\Livewire;
    use App\Models\invoicetable;
    use Illuminate\Http\Request;
    use Livewire\Component;
    use App\Models\productadmintab;

    class Invoiceform extends Component
    {
        public $lastnum;
        public function render()
        {
            $this->lastnum = invoicetable::latest()->first();
            $data = productadmintab::get();
            return view('livewire.invoiceform',['tab'=>$data])->layout('layouts.header');
        }

        public function uploadinvoice(Request $data)
        {
            $insertdata = new invoicetable();
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
            $prepcsamount = $data->input('prepcsamount', []);  
            $insertdata->prepcsamount = implode(',', $prepcsamount);

            $boxpcsqty = $data->input('boxpcsqty', []);  
            $insertdata->boxpcsqty = implode(',', $boxpcsqty);

            $description = $data->input('description', []);  
            $insertdata->description = implode(',', $description);

            $hsncode = $data->input('hsncode', []);  
            $insertdata->hsncode = implode(',', $hsncode);
            
            $gstrate = $data->input('gstrate', []);  
            $insertdata->gstrate = implode(',', $gstrate);
        
            $bulk = $data->input('bulk', []);  
          
           
            $pcs = $data->input('pcs', []);

            $actualqty = [];
            foreach($bulk as $index => $q) {
                // Concatenate qty and weight for each index
                $actualqty[] = $q . '-' . ($pcs[$index] ?? '');
            }

            $insertdata->qty = implode(',', $actualqty);

            // Concatenate qty and weight
            // $qty = $data->input('qty', []);  // Retrieve qty array
            $weight = $data->input('wight', []);  // Retrieve weight array

            
            $qty = $data->input('qty', []);
            
            $measurement = $data->input('measurement', []);
            $actualqty = [];
            foreach($qty as $index => $q) {
                // Concatenate qty and weight for each index
                $actualqty[] = $q . '-' . ($measurement[$index] ?? '');
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
            return redirect('invoicedata');
        }
        

        public function getCompanyAddress(Request $request)
        {
            $companyName = $request->input('companyname');
            $company = Invoicetable::where('companyname', $companyName)->first();

            if ($company) {
                return response()->json([
                    'companyaddress' => $company->companyaddress,
                    'companygsn' => $company->companygsn,
                    'companypan' => $company->companypan,
                    'companyemail' => $company->companyemail,
                ]);
            } else {
                return response()->json(['error' => 'Company not found'], 404);
            }
        }

    
    }
