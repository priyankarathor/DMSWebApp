<?php
namespace App\Livewire;

use App\Models\orderlisttab;
use Illuminate\Http\Request;
use App\Models\productadmintab;
use Livewire\Component;

class Adminorderproduct extends Component
{
    public $orderproduct;
    public $filterStatus = '';
    public $orderId; // Variable for the ID

    // Mount the component with the order ID
    public function mount($id)
    {       
        $this->orderId = $id;
        $this->orderproduct = orderlisttab::where('id', $id)->first();
    }

    public function render()
    {    
        $product = productadmintab::get();
        return view('livewire.adminorderproduct',['products'=>$product])->layout('layouts.header');
    }

    public function orderupload(Request $data,$id){
        $statusupdate = orderlisttab::where('id', $id)->first();

        $orderstatus = implode(',', $data->orderstatus); 
        $statusupdate->orderstatus = $orderstatus;

        $statusupdate->save();
        return redirect('distributerorder/' . $statusupdate->id);
    }

    // Livewire method to handle status update
    public function updateStatus(Request $request, $id)
    {
        $orderProduct = OrderProduct::find($id);
        $orderProduct->status = $request->status;
        $orderProduct->save();
    
        return response()->json(['success' => true]);
    }
    
}