<?php

namespace App\Livewire;
use App\Models\productadmintab;
use App\Models\categorytable;
use App\Models\userroletab;
use App\Models\pricetable;
use Illuminate\Http\Request;
use Livewire\Component;

class Productpage extends Component
{
    public function render()
    {
        $data = categorytable::get();
        $roles = userroletab::get();
        return view('livewire.productpage',['productcate'=>$data,'userrole'=>$roles])->layout('layouts.header');
    }

    public function productdata(Request $data)
    {
        $insertproduct = new productadmintab;
            $insertproduct->productname = $data->productname;
            $insertproduct->description = $data->description;
            $insertproduct->category = $data->category;
            $insertproduct->quantity = $data->quantity;
            $insertproduct->weightnum = $data->weightnum;
            $insertproduct->weihgtclass = $data->weightclass;
            $insertproduct->hsncode = $data->hsncode;
            $insertproduct->link = $data->link;
            $insertproduct->metatag = $data->metatag;
            $insertproduct->metadescription = $data->metadescription;
            $insertproduct->metakeyword = $data->metakeyword;
            $insertproduct->Action = $data->action;
            $insertproduct->measurement = $data->measurement;
            
            $insertproduct->boxquantity = $data->box;

            
        $vehicleCategories = implode(',', $data->vehicle); // Assuming 'vehicle' is an array from the multi-pick list
        $insertproduct->vehicle = $vehicleCategories;

            
    
           
        $image = time().'.'.$data->file->extension();
        $data->file->move(public_path('image/'),$image);
        $insertproduct->file = $image;
            

        $imagePaths = [];

    // Handle multiple image uploads
    if ($data->hasFile('image')) {
        foreach ($data->file('image') as $image) {
            if ($image->isValid()) {
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);
                $imagePaths[] = 'images/' . $imageName;
            }
        }
    }

    // Save multiple image paths as a comma-separated string
    $imagePathString = implode(',', $imagePaths);
    $insertproduct->image = $imagePathString;
        
        $insertproduct->save();


        //price table 

        if (isset($data->price) && is_array($data->price)) {
            foreach ($data->price as $key => $price) {
                $pricetable = new pricetable();
                $pricetable->pid = $insertproduct->id;
                $pricetable->role = $data->role[$key] ?? null;
                $pricetable->price = $price;
                $pricetable->Measurement = $data->measurement;
                $pricetable->totalprice = $data->totalprice[$key] ?? null;
                $pricetable->save();
            }
        } else {
            $pricetable = new pricetable();
            $pricetable->pid = $insertproduct->id;
            $pricetable->role = $data->role;
            $pricetable->price = $data->price;
            $pricetable->Measurement = $data->Measurement;
            $pricetable->totalprice = $data->totalprice;
            $pricetable->save();
        }
        

        return redirect('productlist');

    }

    public function getproduct(){
        $product = productadmintab::get();

        if($product){
            return response()->json(['Aboutsection List' => $product,'Status' => 'Success',200]);
        }else{
            return response()->json([ 'Status' => 'Failed',200]);
        }
    }
    
    public function getprice(){
        $productprice = pricetable::get();
        
        if($productprice){
            return response()->json(['price List' => $productprice,'status'=>'success',200]);
        }
        else{
            return responce()->json(['status'=>'Failed',200]);
        }
    }
    
    public function getrandomproduct(){
        $randomProducts = productadmintab::inRandomOrder()->take(3)->get();

        if($randomProducts){
            return response()->json(['rendomproduct' => $randomProducts,'Status' => 'Success',200]);
        }else{
            return response()->json([ 'Status' => 'Failed',200]);
        }
    }
    
}