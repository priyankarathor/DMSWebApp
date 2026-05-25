<?php

namespace App\Livewire;

use App\Models\location;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Godown;
use App\Models\productadmintab;

class GodownInventory extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    // Tabs
    public $activeTab = 'godowns';

    // Godown Form
    public $godownLocation = '';
    public $godownRetailer = '';
    public $godownProductId = '';

    // Search & Filters
    public $searchProduct = '';
    public $searchBatch = '';

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function addGodown()
    {
        $this->validate([
            'godownProductId' => 'required|exists:productadmintabs,id',
            'godownLocation' => 'required|string|max:255',
            'godownRetailer' => 'required|string|max:255',
        ]);

        Godown::create([
            'pid' => $this->godownProductId,
            'locationid' => $this->godownLocation,
            'retailer_name' => $this->godownRetailer,
        ]);

        $this->reset(['godownProductId', 'godownLocation', 'godownRetailer']);
        session()->flash('success', 'Godown entry added successfully.');
        $this->dispatch('close-add-godown-modal');
    }

    public function deleteGodown($id)
    {
        $godown = Godown::findOrFail($id);
        $godown->delete();
        session()->flash('success', 'Godown entry deleted.');
    }

    private function getInventoryData()
    {
        $query = productadmintab::with(['batches', 'prices']);

        if ($this->searchProduct) {
            $query->where('productname', 'like', '%' . $this->searchProduct . '%')
                ->orWhere('id', 'like', '%' . $this->searchProduct . '%');
        }

        $products = $query->get();
        $inventoryRows = [];

        foreach ($products as $product) {
            foreach ($product->batches as $batch) {
                // Apply batch search if provided
                if ($this->searchBatch && stripos($batch->batchno ?? '', $this->searchBatch) === false) {
                    continue; // Skip this batch if it doesn't match
                }

                foreach ($product->prices as $price) {
                    // Check if price batchnos contains the batch id or batch no
                    $batchNosArray = collect(explode(',', str_replace(["'", '"'], '', $price->batchnos ?? '')))
                        ->map(fn($item) => trim($item))->filter();

                    $batchId = (string) ($batch->id ?? '');
                    $batchNo = trim((string) ($batch->batchno ?? ''));

                    if ($batchNosArray->contains($batchId) || $batchNosArray->contains($batchNo)) {
                        $inventoryRows[] = [
                            'product_id' => $product->id,
                            'product_name' => $product->productname,
                            'category' => $product->category,
                            'batch_id' => $batch->id,
                            'batchno' => $batch->batchno ?? 'N/A',
                            'boxqty' => $batch->boxqty ?? $batch->qty ?? 0,
                            'pcsqty' => $batch->pcsqty ?? $batch->maxqty ?? 0,
                            'totalqty' => $batch->totalqty ?? 0,
                            'inventoryqty' => $batch->inventoryqty ?? 0,
                            'state' => $price->state ?? 'N/A',
                            'pricecndf' => $price->pricecndf ?? 0,
                            'pricedistributor' => $price->pricedistributor ?? 0,
                            'pricedealer' => $price->pricedealer ?? 0,
                            'pricesubdealer' => $price->pricesubdealer ?? 0,
                            'priceretialer' => $price->priceretialer ?? 0,
                        ];
                    }
                }
            }
        }

        return collect($inventoryRows);
    }

    public function render()
    {
        $godowns = Godown::with('product')->latest()->paginate(10, ['*'], 'godownPage');
        $allProducts = productadmintab::orderBy('id', 'desc')->get();
        $location = location::orderBy('location_name', 'asc')->get();
        $inventoryCollection = $this->getInventoryData();
        // Simple manual pagination for the collected array
        $perPage = 15;
        $page = request()->get('inventoryPage', 1);
        $inventoryPaginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $inventoryCollection->forPage($page, $perPage),
            $inventoryCollection->count(),
            $perPage,
            $page,
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(), 'pageName' => 'inventoryPage']
        );

        return view('livewire.godown-inventory', [
            'godowns' => $godowns,
            'allProducts' => $allProducts,
            'inventory' => $inventoryPaginator,
            'locations' => $location
        ])->layout('layouts.header');

    }
}
