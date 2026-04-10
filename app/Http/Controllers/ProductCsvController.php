<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ProductCsvImport;
use Maatwebsite\Excel\Facades\Excel;

class ProductCsvController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt,xlsx,xls'
        ]);

        Excel::import(new ProductCsvImport, $request->file('file'));

        return back()->with('success', 'CSV imported successfully.');
    }
}