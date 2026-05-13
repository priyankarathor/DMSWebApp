<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\productadmintab as Productadmintab;
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

    protected $queryString = [
        'stateSearch'      => ['except' => ''],
        'batchSearch'      => ['except' => ''],
        'statusFilter'     => ['except' => ''],
        'vehicleFilter'    => ['except' => ''],
        'batchStateFilter' => ['except' => ''],
        'batchNoFilter'    => ['except' => ''],
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
        $this->stateSearch = '';
        $this->batchSearch = '';
        $this->statusFilter = '';
        $this->vehicleFilter = '';
        $this->batchStateFilter = '';
        $this->batchNoFilter = '';

        $this->resetAllPages();
    }

    private function paginateCollection($items, $perPage = 10, $pageName = 'page')
    {
        $collection = collect($items);
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

    private function getFilteredData()
    {
        $prices = collect($this->product->prices);
        $batches = collect($this->product->batches);

        if (!empty($this->statusFilter)) {
            $isActive = $this->product->Action == 1;

            if ($this->statusFilter === 'active' && !$isActive) {
                $prices = collect([]);
                $batches = collect([]);
            }

            if ($this->statusFilter === 'inactive' && $isActive) {
                $prices = collect([]);
                $batches = collect([]);
            }
        }

        if (!empty($this->vehicleFilter)) {
            if (stripos($this->product->vehicle ?? '', $this->vehicleFilter) === false) {
                $prices = collect([]);
                $batches = collect([]);
            }
        }

        if (!empty($this->stateSearch)) {
            $prices = $prices->filter(function ($price) {
                return stripos($price->state ?? '', $this->stateSearch) !== false;
            });
        }

        if (!empty($this->batchSearch)) {
            $batches = $batches->filter(function ($batch) {
                return stripos($batch->batchno ?? '', $this->batchSearch) !== false;
            });
        }

        $batchMappedRows = [];

        foreach ($batches as $batch) {
            $matchedPrices = [];

            foreach ($prices as $price) {
                $batchNosArray = array_filter(array_map(
                    'trim',
                    explode(',', str_replace("'", '', $price->batchnos ?? ''))
                ));

                if (in_array(trim($batch->batchno), $batchNosArray)) {
                    $matchedPrices[] = $price;
                }
            }

            if (count($matchedPrices) > 0) {
                foreach ($matchedPrices as $matchedPrice) {
                    $batchMappedRows[] = [
                        'product_id'       => $this->product->id,
                        'product_name'     => $this->product->productname ?? '',
                        'category'         => $this->product->category ?? '',
                        'vehicle'          => $this->product->vehicle ?? '',
                        'description'      => strip_tags($this->product->description ?? ''),
                        'total_pcs'        => $this->product->quantity ?? '',
                        'box_quantity'     => $this->product->boxquantity ?? '',
                        'status'           => $this->product->Action ? 'Active' : 'Inactive',

                        'batchno'          => $batch->batchno ?? '',
                        'boxqty'           => $batch->boxqty ?? '',
                        'pcsqty'           => $batch->pcsqty ?? '',
                        'totalqty'         => $batch->totalqty ?? '',
                        'inventoryqty'     => $batch->inventoryqty ?? '',

                        'state'            => $matchedPrice->state ?? 'N/A',
                        'pricecndf'        => $matchedPrice->pricecndf ?? 0,
                        'pricedistributor' => $matchedPrice->pricedistributor ?? 0,
                        'pricedealer'      => $matchedPrice->pricedealer ?? 0,
                        'pricesubdealer'   => $matchedPrice->pricesubdealer ?? 0,
                        'priceretialer'    => $matchedPrice->priceretialer ?? 0,
                        'batchnos'         => $matchedPrice->batchnos ?? '',
                    ];
                }
            } else {
                $batchMappedRows[] = [
                    'product_id'       => $this->product->id,
                    'product_name'     => $this->product->productname ?? '',
                    'category'         => $this->product->category ?? '',
                    'vehicle'          => $this->product->vehicle ?? '',
                    'description'      => strip_tags($this->product->description ?? ''),
                    'total_pcs'        => $this->product->quantity ?? '',
                    'box_quantity'     => $this->product->boxquantity ?? '',
                    'status'           => $this->product->Action ? 'Active' : 'Inactive',

                    'batchno'          => $batch->batchno ?? '',
                    'boxqty'           => $batch->boxqty ?? '',
                    'pcsqty'           => $batch->pcsqty ?? '',
                    'totalqty'         => $batch->totalqty ?? '',
                    'inventoryqty'     => $batch->inventoryqty ?? '',

                    'state'            => 'No price found for this batch',
                    'pricecndf'        => '',
                    'pricedistributor' => '',
                    'pricedealer'      => '',
                    'pricesubdealer'   => '',
                    'priceretialer'    => '',
                    'batchnos'         => '',
                ];
            }
        }

        $batchMappedRows = collect($batchMappedRows);

        if (!empty($this->batchStateFilter)) {
            $batchMappedRows = $batchMappedRows->filter(function ($row) {
                return stripos($row['state'] ?? '', $this->batchStateFilter) !== false;
            });
        }

        if (!empty($this->batchNoFilter)) {
            $batchMappedRows = $batchMappedRows->filter(function ($row) {
                return stripos($row['batchno'] ?? '', $this->batchNoFilter) !== false;
            });
        }

        return [
            'prices' => $prices->values(),
            'batchMappedRows' => $batchMappedRows->values(),
        ];
    }

    public function downloadCsv()
    {
        $data = $this->getFilteredData();
        $rows = $data['batchMappedRows'];
        $productId = $this->product->id;

        return response()->streamDownload(function () use ($rows) {
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
                'Batch No',
                'Box Qty',
                'PCS Qty',
                'Total Qty',
                'Inventory',
                'State',
                'CNDF Price',
                'Distributor Price',
                'Dealer Price',
                'Sub Dealer Price',
                'Retailer Price',
            ]);

            foreach ($rows as $row) {
                fputcsv($handle, [
                    $row['product_id'] ?? '',
                    $row['product_name'] ?? '',
                    $row['category'] ?? '',
                    $row['vehicle'] ?? '',
                    $row['description'] ?? '',
                    $row['total_pcs'] ?? '',
                    $row['box_quantity'] ?? '',
                    $row['status'] ?? '',
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
        }, 'batch_wise_filtered_details_' . $productId . '_' . now()->format('Ymd_His') . '.csv');
    }

    public function render()
    {
        $data = $this->getFilteredData();

        $filteredPrices = $this->paginateCollection($data['prices'], 10, 'pricesPage');
        $filteredBatchRows = $this->paginateCollection($data['batchMappedRows'], 10, 'batchesPage');

        return view('livewire.productdetails', [
            'product' => $this->product,
            'filteredPrices' => $filteredPrices,
            'filteredBatchRows' => $filteredBatchRows,
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