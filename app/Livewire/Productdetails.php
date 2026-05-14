<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Productadmintab;
use App\Models\ProductPriceTable;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class Productdetails extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $product;

    public $stateSearch = '';
    public $batchSearch = '';
    public $statusFilter = '';
    public $vehicleFilter = '';
    public $batchStateFilter = '';
    public $batchNoFilter = '';

    public $editPriceId;
    public $editState;
    public $editBatchNo;
    public $editCndf;
    public $editDistributor;
    public $editDealer;
    public $editSubDealer;
    public $editRetailer;

    protected $queryString = [
        'stateSearch' => ['except' => ''],
        'batchSearch' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'vehicleFilter' => ['except' => ''],
        'batchStateFilter' => ['except' => ''],
        'batchNoFilter' => ['except' => ''],
    ];

    public function mount($id)
    {
        $this->product = Productadmintab::with(['batches', 'prices'])->findOrFail($id);
    }

    public function updatingStateSearch() { $this->resetAllPages(); }
    public function updatingBatchSearch() { $this->resetAllPages(); }
    public function updatingStatusFilter() { $this->resetAllPages(); }
    public function updatingVehicleFilter() { $this->resetAllPages(); }
    public function updatingBatchStateFilter() { $this->resetAllPages(); }
    public function updatingBatchNoFilter() { $this->resetAllPages(); }

    private function resetAllPages()
    {
        $this->resetPage('pricesPage');
        $this->resetPage('batchesPage');
    }

    public function resetFilters()
    {
        $this->reset([
            'stateSearch',
            'batchSearch',
            'statusFilter',
            'vehicleFilter',
            'batchStateFilter',
            'batchNoFilter',
        ]);

        $this->resetAllPages();
    }

    private function paginateCollection($items, $perPage = 10, $pageName = 'page')
    {
        $collection = collect($items)->values();
        $currentPage = Paginator::resolveCurrentPage($pageName);

        $currentItems = $collection
            ->slice(($currentPage - 1) * $perPage, $perPage)
            ->values();

        return new LengthAwarePaginator(
            $currentItems,
            $collection->count(),
            $perPage,
            $currentPage,
            [
                'path' => Paginator::resolveCurrentPath(),
                'pageName' => $pageName,
            ]
        );
    }

    private function cleanBatchNos($batchNos)
    {
        return collect(explode(',', str_replace(["'", '"'], '', $batchNos ?? '')))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->unique()
            ->values();
    }

    private function batchMatched($batch, $price)
    {
        $batchNosArray = $this->cleanBatchNos($price->batchnos);

        $batchId = (string) ($batch->id ?? '');
        $batchNo = trim((string) ($batch->batchno ?? ''));

        return $batchNosArray->contains($batchId) || $batchNosArray->contains($batchNo);
    }

    private function getFilteredData()
    {
        $prices = collect($this->product->prices);
        $batches = collect($this->product->batches);

        if ($this->statusFilter !== '') {
            $isActive = (int) $this->product->Action === 1;

            if ($this->statusFilter === 'active' && !$isActive) {
                $prices = collect([]);
                $batches = collect([]);
            }

            if ($this->statusFilter === 'inactive' && $isActive) {
                $prices = collect([]);
                $batches = collect([]);
            }
        }

        if ($this->vehicleFilter !== '') {
            if (stripos($this->product->vehicle ?? '', $this->vehicleFilter) === false) {
                $prices = collect([]);
                $batches = collect([]);
            }
        }

        if ($this->stateSearch !== '') {
            $prices = $prices->filter(function ($price) {
                return stripos($price->state ?? '', $this->stateSearch) !== false;
            });
        }

        if ($this->batchSearch !== '') {
            $batches = $batches->filter(function ($batch) {
                return stripos($batch->batchno ?? '', $this->batchSearch) !== false
                    || stripos((string) $batch->id, $this->batchSearch) !== false;
            });

            $prices = $prices->filter(function ($price) {
                return stripos($price->batchnos ?? '', $this->batchSearch) !== false;
            });
        }

        $batchMappedRows = [];

        foreach ($batches as $batch) {
            foreach ($prices as $price) {
                if ($this->batchMatched($batch, $price)) {
                    $batchMappedRows[] = [
                        'price_id' => $price->id,
                        'batch_id' => $batch->id,
                        'product_id' => $this->product->id,

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

        $batchMappedRows = collect($batchMappedRows);

        if ($this->batchStateFilter !== '') {
            $batchMappedRows = $batchMappedRows->filter(function ($row) {
                return stripos($row['state'] ?? '', $this->batchStateFilter) !== false;
            });
        }

        if ($this->batchNoFilter !== '') {
            $batchMappedRows = $batchMappedRows->filter(function ($row) {
                return stripos($row['batchno'] ?? '', $this->batchNoFilter) !== false
                    || stripos((string) $row['batch_id'], $this->batchNoFilter) !== false;
            });
        }

        return [
            'prices' => $prices->values(),
            'batchMappedRows' => $batchMappedRows->values(),
        ];
    }

    public function editPrice($id)
    {
        $price = ProductPriceTable::where('pid', $this->product->id)
            ->where('id', $id)
            ->firstOrFail();

        $this->editPriceId = $price->id;
        $this->editState = $price->state ?? '';
        $this->editBatchNo = $this->cleanBatchNos($price->batchnos)->implode(',');
        $this->editCndf = $price->pricecndf ?? 0;
        $this->editDistributor = $price->pricedistributor ?? 0;
        $this->editDealer = $price->pricedealer ?? 0;
        $this->editSubDealer = $price->pricesubdealer ?? 0;
        $this->editRetailer = $price->priceretialer ?? 0;

        $this->dispatch('open-edit-price-modal');
    }

    public function updatePrice()
    {
        $this->validate([
            'editPriceId' => 'required|exists:product_price_tables,id',
            'editState' => 'required|string|max:255',
            'editBatchNo' => 'required|string|max:255',
            'editCndf' => 'required|numeric|min:0',
            'editDistributor' => 'required|numeric|min:0',
            'editDealer' => 'required|numeric|min:0',
            'editSubDealer' => 'required|numeric|min:0',
            'editRetailer' => 'required|numeric|min:0',
        ]);

        $batchNos = $this->cleanBatchNos($this->editBatchNo)->implode(',');

        $price = ProductPriceTable::where('pid', $this->product->id)
            ->where('id', $this->editPriceId)
            ->firstOrFail();

        $price->update([
            'state' => $this->editState,
            'batchnos' => $batchNos,
            'pricecndf' => $this->editCndf,
            'pricedistributor' => $this->editDistributor,
            'pricedealer' => $this->editDealer,
            'pricesubdealer' => $this->editSubDealer,
            'priceretialer' => $this->editRetailer,
        ]);

        $this->product = Productadmintab::with(['batches', 'prices'])->findOrFail($this->product->id);

        $this->reset([
            'editPriceId',
            'editState',
            'editBatchNo',
            'editCndf',
            'editDistributor',
            'editDealer',
            'editSubDealer',
            'editRetailer',
        ]);

        session()->flash('success', 'Price updated successfully.');
        $this->dispatch('close-edit-price-modal');
    }
    public function downloadCsv()
{
    $data = $this->getFilteredData();
    $rows = $data['batchMappedRows'];

    return response()->streamDownload(function () use ($rows) {
        $handle = fopen('php://output', 'w');

        fputcsv($handle, [
            'Sr No',
            'Batch ID',
            'Product ID',
            'Batch No',
            'Box Qty',
            'PCS Qty',
            'Total PCS',
            'Inventory',
            'State',
            'CNDF Price',
            'Distributor Price',
            'Dealer Price',
            'Sub Dealer Price',
            'Retailer Price',
        ]);

        foreach ($rows as $index => $row) {
            fputcsv($handle, [
                $index + 1,
                $row['batch_id'] ?? '',
                $row['product_id'] ?? '',
                $row['batchno'] ?? '',
                $row['boxqty'] ?? '',
                $row['pcsqty'] ?? '',
                $row['totalqty'] ?? '',
                $row['inventoryqty'] ?? '',
                $row['state'] ?? '',
                $row['pricecndf'] ?? '',
                $row['pricedistributor'] ?? '',
                $row['pricedealer'] ?? '',
                $row['pricesubdealer'] ?? '',
                $row['priceretialer'] ?? '',
            ]);
        }

        fclose($handle);
    }, 'batch_wise_price_mapping_' . now()->format('Ymd_His') . '.csv');
}

public function downloadFullProductCsv()
{
    $product = Productadmintab::with(['batches', 'prices'])
        ->findOrFail($this->product->id);

    return response()->streamDownload(function () use ($product) {

        $handle = fopen('php://output', 'w');

        fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

        fputcsv($handle, [
            'Product ID',
            'Product Name',
            'Category',
            'Vehicle',
            'Description',
            'Total PCS',
            'Box Quantity',
            'Status',

            'Batch ID',
            'Batch No',
            'Box Qty',
            'PCS Qty',
            'Total Qty',
            'Inventory Qty',

            'State',
            'CNDF Price',
            'Distributor Price',
            'Dealer Price',
            'Sub Dealer Price',
            'Retailer Price',
        ]);

        foreach ($product->batches as $batch) {

            foreach ($product->prices as $price) {

                $batchNosArray = collect(
                    explode(',', str_replace(["'", '"'], '', $price->batchnos ?? ''))
                )->map(fn ($item) => trim($item))
                 ->filter()
                 ->values();

                $batchId = (string) ($batch->id ?? '');
                $batchNo = trim((string) ($batch->batchno ?? ''));

                $matched = $batchNosArray->contains($batchId)
                    || $batchNosArray->contains($batchNo);

                if ($matched) {

                    fputcsv($handle, [

                        $product->id,
                        $product->productname ?? '',
                        $product->category ?? '',
                        $product->vehicle ?? '',
                        strip_tags($product->description ?? ''),
                        $product->quantity ?? '',
                        $product->boxquantity ?? '',
                        $product->Action ? 'Active' : 'Inactive',

                        $batch->id ?? '',
                        $batch->batchno ?? '',
                        $batch->boxqty ?? $batch->qty ?? 0,
                        $batch->pcsqty ?? $batch->maxqty ?? 0,
                        $batch->totalqty ?? 0,
                        $batch->inventoryqty ?? 0,

                        $price->state ?? '',
                        $price->pricecndf ?? 0,
                        $price->pricedistributor ?? 0,
                        $price->pricedealer ?? 0,
                        $price->pricesubdealer ?? 0,
                        $price->priceretialer ?? 0,
                    ]);
                }
            }
        }

        fclose($handle);

    }, 'full_product_details_' . $product->id . '_' . now()->format('Ymd_His') . '.csv');
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
    }

    public function render()
    {
        $data = $this->getFilteredData();

        return view('livewire.productdetails', [
            'product' => $this->product,
            'filteredPrices' => $this->paginateCollection($data['prices'], 10, 'pricesPage'),
            'filteredBatchRows' => $this->paginateCollection($data['batchMappedRows'], 10, 'batchesPage'),
        ])->layout('layouts.header');
    }
}