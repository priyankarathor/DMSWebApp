<?php

namespace App\Livewire;
use App\Models\retailertable;
use Illuminate\Http\Request;
use Livewire\Component;

class Retailerpage extends Component
{
    public function render()
    {
        return view('livewire.retailerpage')->layout('layouts.header');
    }
    public function retailerdata(Request $request)
    {
        // Validation for bulk product data
        $data = $request->validate([
            'retailername' => 'required|array',
            'contactno' => 'required|array',
            'email' => 'required|array',
            'address' => 'required|array',
            'product' => 'required|array',
            'quantity' => 'required|array',
            'region' => 'required|array',
            'file' => 'required|array',
            'retailername.*' => 'required|string|max:255',
            'contactno.*' => 'required|string|max:255',
            'email.*' => 'required|string|max:255',
            'address.*' => 'required|string|max:255',
            'product.*' => 'required|string|max:255',
            'quantity.*' => 'required|string|max:255',
            'region.*' => 'required|string|max:255',
            'file.*' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);
    
        $bulkData = [];
        
        foreach ($data['retailername'] as $index => $retailername) {
            $filePath = null;
            // Handle file upload for each product
            if ($request->hasFile('file.' . $index)) {
                $file = $request->file('file.' . $index);
                $fileName = time() . '_' . $index . '.' . $file->getClientOriginalExtension();
                $filePath = $file->move(public_path('images'), $fileName); // Move the file to the 'images' folder
                $filePath = 'images/' . $fileName; // Store the relative path
            }
    
            // Prepare data for bulk insertion
            $bulkData[] = [
                'retailername' => $retailername,
                'contactno' => $data['contactno'][$index],
                'email' => $data['email'][$index],
                'address' => $data['address'][$index],
                'product' => $data['product'][$index],
                'quantity' => $data['quantity'][$index],
                'region' => $data['region'][$index],
                'file' => $filePath, 
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
    
        // Bulk insert the product data into the table
        retailertable::insert($bulkData);
    
        return back()->with('success', 'Bulk data inserted successfully with images.');
    }
}
