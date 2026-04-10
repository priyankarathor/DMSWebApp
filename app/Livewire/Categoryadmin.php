<?php

namespace App\Livewire;
use App\Models\categorytable;
use Illuminate\Http\Request;
use Livewire\Component;

class Categoryadmin extends Component
{
    public function render()
    {
        $data = categorytable::where('type','master')->get();
        return view('livewire.categoryadmin',['tab'=>$data])->layout('layouts.header');
    }
    public function insertdata(Request $data){
        $insertcategory = new  categorytable;
        $insertcategory->type = $data->type;
        $insertcategory->value = $data->mastercategory;
        $insertcategory->active = $data->active;
     
        
              if ($data->file) { // Check if the file exists
                $image = time() . '.' . $data->file->extension(); 
                $data->file->move(public_path('images/'), $image);
                $insertcategory->image = $image; 
            } else {
                // Handle the case where no file is uploaded, e.g., set a default value or return an error
                return back()->withErrors(['file' => 'Please upload an image.']);
            }

        $insertcategory->save();
        return back();
    }
      public function categorydelete($id){
        $deletecategory = categorytable::where('id',$id)->first();
       
        $deletecategorysub = categorytable::where('type', $deletecategory->value)->get();
        $deletecategory->delete();
        foreach($deletecategorysub as $deletesub){
        $deletesub->delete();
        }
        return back();
    }
  
}