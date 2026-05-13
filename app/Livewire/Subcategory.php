<?php

namespace App\Livewire;
use App\Models\categorytable;
use Illuminate\Http\Request;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Subcategory extends Component
{
    public function render()
    {
        $data = categorytable::where('type', 'master')->get();
        $subcategory = CategoryTable::where('type', '!=', 'master')->get();

        return view('livewire.subcategory', ['tab' => $data, 'categery' => $subcategory])->layout('layouts.header');
    }
    public function subinsertdata(Request $data)
    {
        $insertcategory = new categorytable;
        $insertcategory->type = $data->type;
        $insertcategory->value = $data->mastercategory;
        $insertcategory->active = $data->active;


        $image = time() . '.' . $data->file->extension();
        $data->file->move(public_path('images/'), $image);
        $insertcategory->image = $image;

        $insertcategory->save();
        return back();
    }


    public function getcategory()
    {
        $category = categorytable::where('type', 'product')->get();

        if ($category) {
            return response()->json(['categoryList' => $category, 'Status' => 'Success', 200]);
        } else {
            return response()->json(['Status' => 'Failed', 200]);
        }
    }


    public function getcategoryvehicle()
    {
        $categorydata = categorytable::where('type', 'vehicle')->get();

        if ($categorydata) {
            return response()->json(['categoryList vehicle' => $categorydata, 'Status' => 'Success', 200]);
        } else {
            return response()->json(['Status' => 'Failed', 200]);
        }
    }

    public function deletesubcategory($id)
    {
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


    public function get_category_brand()
    {

        $baseUrl = config('https://managementsystem.concentics.in/images/') . 'https://managementsystem.concentics.in/images/'; // or hardcode your image path
        // Get all master (main) categories
        $masterCategories = DB::table('categorytables')
            ->where('type', 'master')
            ->where('active', 1)
            ->get();

        // For each master category, fetch its subcategories
        $categories = $masterCategories->map(function ($category) use ($baseUrl) {
            $subcategories = DB::table('categorytables')
                ->where('type', (string) $category->id)
                ->where('active', 1)
                ->get(['id', 'type', 'value', 'active', 'image']);

            // Add full image URL to subcategories too
            $subcategories = $subcategories->map(function ($sub) use ($baseUrl) {
                $sub->image = $baseUrl . $sub->image;
                return $sub;
            });

            return [
                'id' => $category->id,
                'name' => $category->value,
                'image' => $baseUrl . $category->image,  // ✅ Full URL here
                'subcategories' => $subcategories,
            ];
        });

        // Get all brands
        $brands = DB::table('brands')
            ->whereNotNull('brandName')
            ->get(['id', 'brandName']);

        return response()->json([
            'success' => true,
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }

}
