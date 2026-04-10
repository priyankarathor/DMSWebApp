<?php

namespace App\Livewire;

use App\Models\productadmintab;
use Illuminate\Http\Request;
use App\Models\categorytable;
use App\Models\pricetable;
use Livewire\Component;
use App\Models\userroletab;

class Producteditpage extends Component
{
    public $productedit;
    public $productprice;

    public function mount($id)
    {
        $this->productedit = productadmintab::find($id);
        $this->productprice = pricetable::where('pid', $id)->get();
    }

    public function render()
    {
        $productCategories = categorytable::get();
        $allCategories = categorytable::all();
        $roles = userroletab::all();

        return view('livewire.producteditpage', [
            'productcate' => $productCategories,
            'category' => $allCategories,
            'userrole' => $roles,
        ])->layout('layouts.header');
    }

    public function editproductdata(Request $request, $id)
    {
        $product = productadmintab::findOrFail($id);

        $product->productname = $request->productname;
        $product->description = $request->description;
        $product->category = $request->category;
        $product->quantity = $request->quantity;
        $product->weightnum = $request->weightnum;
        $product->weihgtclass = $request->weightclass;
        $product->hsncode = $request->hsncode;
        $product->link = $request->link;
        $product->metatag = $request->metatag;
        $product->metadescription = $request->metadescription;
        $product->metakeyword = $request->metakeyword;
        $product->productprice = $request->productprice;
        $product->Action = $request->action;
        $product->measurement = $request->measurement;

        // Handle single file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('image/'), $filename);
            $product->file = $filename;
        }

        // Handle multiple images
        $imagePaths = [];
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                if ($image->isValid()) {
                    $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('images'), $imageName);
                    $imagePaths[] = 'images/' . $imageName;
                }
            }
        }

        $product->image = implode(',', $imagePaths);
        $product->save();

        // Handle price table update
        if (is_array($request->price)) {
            foreach ($request->price as $key => $price) {
                $priceRow = pricetable::firstOrNew([
                    'pid' => $id,
                    'role' => $request->role[$key] ?? null
                ]);
                $priceRow->pid = $product->id;
                $priceRow->role = $request->role[$key] ?? null;
                $priceRow->price = $price;
                $priceRow->Measurement = $request->measurement;
                $priceRow->totalprice = $request->totalprice[$key] ?? null;
                $priceRow->save();
            }
        } else {
            $priceRow = new pricetable();
            $priceRow->pid = $product->id;
            $priceRow->role = $request->role;
            $priceRow->price = $request->price;
            $priceRow->Measurement = $request->measurement;
            $priceRow->totalprice = $request->totalprice;
            $priceRow->save();
        }

        return redirect('productlist');
    }
}
