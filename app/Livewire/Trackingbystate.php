<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\batchProductPrice as BatchProductPrice;
use App\Models\productPriceTable as ProductPriceTable;

class Trackingbystate extends Component
{
    use WithPagination;

    public $search = '';
    public $batchFilter = '';
    public $stateFilter = '';
    public $perPage = 10;
    public $productId;

    protected $paginationTheme = 'bootstrap';

    public function mount($id)
    {
        $this->productId = $id;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingBatchFilter()
    {
        $this->resetPage();
    }

    public function updatingStateFilter()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->batchFilter = '';
        $this->stateFilter = '';
        $this->perPage = 10;
        $this->resetPage();
    }

    private function baseQuery()
    {
        $batchTable = (new BatchProductPrice)->getTable();
        $priceTable = (new ProductPriceTable)->getTable();

        return BatchProductPrice::query()
            ->leftJoin($priceTable, "$batchTable.priceid", '=', "$priceTable.id")
            ->where("$batchTable.pid", $this->productId)
            ->select(
                "$batchTable.id",
                "$batchTable.batchno",
                "$batchTable.boxqty",
                "$batchTable.pcsqty",
                "$batchTable.totalqty",
                "$batchTable.inventoryqty",
                "$batchTable.priceid",
                "$priceTable.state as state",
                "$priceTable.pricecndf",
                "$priceTable.pricedistributor",
                "$priceTable.pricedealer",
                "$priceTable.pricesubdealer",
                "$priceTable.priceretialer"
            );
    }

    private function filteredQuery()
    {
        $batchTable = (new BatchProductPrice)->getTable();
        $priceTable = (new ProductPriceTable)->getTable();

        return $this->baseQuery()
            ->when($this->search, function ($query) use ($batchTable, $priceTable) {
                $search = '%' . trim($this->search) . '%';

                $query->where(function ($q) use ($search, $batchTable, $priceTable) {
                    $q->where("$batchTable.batchno", 'like', $search)
                        ->orWhere("$priceTable.state", 'like', $search);
                });
            })
            ->when($this->batchFilter, function ($query) use ($batchTable) {
                $query->where("$batchTable.batchno", $this->batchFilter);
            })
            ->when($this->stateFilter, function ($query) use ($priceTable) {
                $query->where("$priceTable.state", $this->stateFilter);
            });
    }

    public function render()
    {
        $batchTable = (new BatchProductPrice)->getTable();

        $batchList = BatchProductPrice::where('pid', $this->productId)
            ->whereNotNull('batchno')
            ->pluck('batchno')
            ->unique()
            ->values();

        $stateList = $this->baseQuery()
            ->get()
            ->pluck('state')
            ->filter()
            ->unique()
            ->values();

        $totalData = $this->filteredQuery()->get();

        $tableData = $this->filteredQuery()
            ->orderBy("$batchTable.id", 'desc')
            ->paginate($this->perPage);

        return view('livewire.trackingbystate', [
            'tableData' => $tableData,
            'batchList' => $batchList,
            'stateList' => $stateList,
            'totalRecords' => $totalData->count(),
            'totalBoxQty' => $totalData->sum('boxqty'),
            'totalPcsQty' => $totalData->sum('pcsqty'),
            'totalProductHolding' => $totalData->sum('totalqty'),
        ])->layout('layouts.header');
    }
}