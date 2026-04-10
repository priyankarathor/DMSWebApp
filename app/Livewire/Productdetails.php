<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Productadmintab;

class Productdetails extends Component
{
    public $product;

    public function mount($id)
    {
        $this->product = Productadmintab::with(['batches', 'prices'])
            ->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.productdetails', [
            'product' => $this->product
        ])->layout('layouts.header');
    }

    public function deleteproduct($id)
    {
        $product = Productadmintab::find($id);

        if ($product) {
            $product->delete();
            session()->flash('success', 'Product deleted successfully.');
            return redirect()->to('/productlist');
        }

        session()->flash('error', 'Product not found.');
        return redirect()->back();
    }
}