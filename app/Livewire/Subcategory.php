<?php

namespace App\Livewire;
use App\Models\categorytable;
use Illuminate\Http\Request;
use Livewire\Component;

class Subcategory extends Component
{
    public function render()
    {
        $data = categorytable::where('type','master')->get();
        $subcategory = CategoryTable::where('type', '!=', 'master')->get();

        return view('livewire.subcategory',['tab'=>$data,'categery'=>$subcategory])->layout('layouts.header');
    }
    public function subinsertdata(Request $data){
        $insertcategory = new  categorytable;
        $insertcategory->type = $data->type;
        $insertcategory->value = $data->mastercategory;
        $insertcategory->active = $data->active;
     
        
        $image = time().'.'.$data->file->extension();
        $data->file->move(public_path('images/'),$image);
        $insertcategory->image = $image;

        $insertcategory->save();
        return back();
    }
    
    
       public function getcategory(){
        $category = categorytable::where('type','product')->get();

        if($category){
            return response()->json(['categoryList' => $category,'Status' =>'Success',200]);
        }else{
            return response()->json([ 'Status' => 'Failed',200]);
        }
    }
    
    
     public function getcategoryvehicle(){
        $categorydata = categorytable::where('type','vehicle')->get();

        if($categorydata){
            return response()->json(['categoryList vehicle' => $categorydata,'Status' =>'Success',200]);
        }else{
            return response()->json([ 'Status' => 'Failed',200]);
        }
    }
    
    public function deletesubcategory($id){
    $deletecategory = categorytable::where('id', $id)->first();
    if ($deletecategory) {
        $deletecategory->delete();
    }
    return back();
}
    
    //  public function deletesubcategory($id){
    //     $deletecategory = categorytable::where('id',$id)->first();
       
    //     $deletecategorysub = categorytable::where('type', $deletecategory->value)->get();
    //     $deletecategory->delete();
    //     foreach($deletecategorysub as $deletesub){
    //     $deletesub->delete();
    //     }
    //     return back();
    // }
    
}
