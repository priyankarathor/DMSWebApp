<?php

namespace App\Livewire;

use App\Models\productadmintab;
use App\Models\pricetable;
use Livewire\Component;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Productpagelist extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function render()
    {
        $productprice = pricetable::get();

        $product = productadmintab::query()
            ->where(function ($query) {
                $query->where('productname', 'like', '%' . $this->search . '%')
                    ->orWhere('category', 'like', '%' . $this->search . '%')
                    ->orWhere('brand', 'like', '%' . $this->search . '%')
                    ->orWhere('hsncode', 'like', '%' . $this->search . '%')
                    ->orWhere('measurement', 'like', '%' . $this->search . '%')
                    ->orWhere('vehicle', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        return view('livewire.productpagelist', [
            'product' => $product,
            'productprice' => $productprice
        ])->layout('layouts.header');
    }

    public function deleteproduct($id)
    {
        $delete = productadmintab::find($id);

        if ($delete) {
            $delete->delete();
            session()->flash('success', 'Product deleted successfully.');
        } else {
            session()->flash('error', 'Product not found.');
        }
    }

    public function downloadCsv(): StreamedResponse
    {
        $fileName = 'products_' . date('Y-m-d_H-i-s') . '.csv';

        $products = productadmintab::query()
            ->where(function ($query) {
                $query->where('productname', 'like', '%' . $this->search . '%')
                    ->orWhere('category', 'like', '%' . $this->search . '%')
                    ->orWhere('brand', 'like', '%' . $this->search . '%')
                    ->orWhere('hsncode', 'like', '%' . $this->search . '%')
                    ->orWhere('measurement', 'like', '%' . $this->search . '%')
                    ->orWhere('vehicle', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$fileName}",
        ];

        $callback = function () use ($products) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'ID',
                'Product Name',
                'Description',
                'Product Cost Price',
                'Category',
                'File',
                'Image',
                'Quantity',
                'Gross Weight',
                'Weight Class',
                'HSN Code',
                'Link',
                'Meta Tag',
                'Meta Keyword',
                'Meta Description',
                'Action',
                'Vehicle',
                'Measurement',
                'Total Amount',
                'Box Quantity',
                'Brand',
                'DP',
                'MOP',
                'MRP',
                'Category ID',
                'Brand ID',
                'Created At',
                'Updated At',
            ]);

            foreach ($products as $item) {
                fputcsv($file, [
                    $item->id,
                    $item->productname,
                    strip_tags($item->description),
                    $item->productprice,
                    $item->category,
                    $item->file,
                    $item->image,
                    $item->quantity,
                    $item->weightnum,
                    $item->weightclass,
                    $item->hsncode,
                    $item->link,
                    $item->metatag,
                    $item->metakeyword,
                    $item->metadescription,
                    $item->Action,
                    $item->vehicle,
                    $item->measurement,
                    $item->totalamount,
                    $item->boxquantity,
                    $item->brand,
                    $item->dp,
                    $item->mop,
                    $item->mrp,
                    $item->categoryid,
                    $item->brandid,
                    $item->created_at,
                    $item->updated_at,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function updateStatus($id, $status)
    {
        $product = productadmintab::find($id);

        if ($product) {
            // $status comes as true/false boolean from JS
            $product->Action = $status ? 'Active' : 'Disable';
            $product->save();
            // No flash here — avoids page jump on every toggle
        } else {
            session()->flash('error', 'Product not found.');
        }
    }
}