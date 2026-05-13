<?php

namespace App\Livewire;

use App\Models\productadmintab;
use App\Models\categorytable;
use App\Models\pricetable;
use App\Models\userroletab;
use Livewire\Component;
use Illuminate\Http\Request;

class Producteditpage extends Component
{
    public $productedit;
    public $productprice;
    public $selectedVehicles = [];

    public function mount($id)
    {
        $this->productedit = productadmintab::findOrFail($id);
        $this->productprice = pricetable::where('pid', $id)->get();

        $this->selectedVehicles = $this->productedit->vehicle
            ? explode(',', $this->productedit->vehicle)
            : [];
    }

    public function render()
    {
        return view('livewire.producteditpage', [
            'productcate' => categorytable::get(),
            'category' => categorytable::all(),
            'userrole' => userroletab::all(),
            'selectedVehicles' => $this->selectedVehicles,
        ])->layout('layouts.header');
    }

    public function editproductdata(Request $request, $id)
    {
        $product = productadmintab::findOrFail($id);

        $product->productname = $request->productname;
        $product->description = $request->description;
        // $product->category = $request->category;

        $product->vehicle = is_array($request->vehicle)
            ? implode(',', $request->vehicle)
            : $request->vehicle;

        $product->quantity = $request->quantity;
        $product->measurement = $request->measurement;
        $product->boxquantity = $request->boxquantity;

        $product->weightnum = $request->weightnum;
        $product->weihgtclass = $request->weightclass;
        $product->hsncode = $request->hsncode;

        $product->brand = $request->brand;
        $product->dp = $request->dp;
        $product->mop = $request->mop;
        $product->mrp = $request->mrp;
        $product->totalamount = $request->totalamount;

        $product->link = $request->link;
        $product->metatag = $request->metatag;
        $product->metadescription = $request->metadescription;
        $product->metakeyword = $request->metakeyword;
        $product->productprice = $request->productprice;
        $product->Action = $request->action ?? 'Active';

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('image'), $filename);
            $product->file = $filename;
        }

        if ($request->hasFile('image')) {
            $imagePaths = [];

            foreach ($request->file('image') as $image) {
                if ($image->isValid()) {
                    $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('images'), $imageName);
                    $imagePaths[] = 'images/' . $imageName;
                }
            }

            if (!empty($imagePaths)) {
                $product->image = implode(',', $imagePaths);
            }
        }

        $product->save();

        if (is_array($request->price)) {
            foreach ($request->price as $key => $price) {
                $role = $request->role[$key] ?? null;

                if ($role === null) {
                    continue;
                }

                $priceRow = pricetable::firstOrNew([
                    'pid' => $product->id,
                    'role' => $role,
                ]);

                $priceRow->pid = $product->id;
                $priceRow->role = $role;
                $priceRow->price = $price;
                $priceRow->Measurement = $request->measurement;
                $priceRow->totalprice = $request->totalprice[$key] ?? 0;
                $priceRow->save();
            }
        }

        return redirect('productlist')->with('success', 'Product updated successfully.');
    }
}