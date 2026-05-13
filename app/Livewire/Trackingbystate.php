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

    public $productId;
    public $rows = [];

    protected $paginationTheme = 'bootstrap';

    public function mount($id)
    {
        $this->productId = $id;

        $batches = BatchProductPrice::where('pid', $id)->get();

        $this->rows = $batches->map(function ($batch) {

            $price = ProductPriceTable::where('id', $batch->priceid)->first();

            return [
                'id' => $batch->id,
                'batch_no' => $batch->batchno,
                'state' => $batch->state ?? ($price->state ?? 'N/A'),

                'box_qty' => (int) ($batch->boxqty ?? 0),
                'pcs_qty' => (int) ($batch->pcsqty ?? 0),
                'total_pcs' => (int) ($batch->totalqty ?? 0),
                'inventoryqty' => (int) ($batch->inventoryqty ?? 0),

                'priceid' => $batch->priceid,

                'pricecndf' => $price->pricecndf ?? 0,
                'pricedistributor' => $price->pricedistributor ?? 0,
                'pricedealer' => $price->pricedealer ?? 0,
                'pricesubdealer' => $price->pricesubdealer ?? 0,
                'priceretialer' => $price->priceretialer ?? 0,
            ];
        })->toArray();
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

    public function getFilteredRowsProperty()
    {
        $data = collect($this->rows);

        if ($this->search) {
            $search = strtolower($this->search);

            $data = $data->filter(function ($row) use ($search) {
                return str_contains(strtolower($row['batch_no']), $search)
                    || str_contains(strtolower($row['state']), $search);
            });
        }

        if ($this->batchFilter) {
            $data = $data->where('batch_no', $this->batchFilter);
        }

        if ($this->stateFilter) {
            $data = $data->where('state', $this->stateFilter);
        }

        return $data->values();
    }

    public function getTotalRecordsProperty()
    {
        return $this->filteredRows->count();
    }

    public function getTotalBoxQtyProperty()
    {
        return $this->filteredRows->sum('box_qty');
    }

    public function getTotalPcsQtyProperty()
    {
        return $this->filteredRows->sum('pcs_qty');
    }

    public function getTotalProductHoldingProperty()
    {
        return $this->filteredRows->sum('total_pcs');
    }

    public function render()
    {
        $batchList = collect($this->rows)->pluck('batch_no')->unique()->values();
        $stateList = collect($this->rows)->pluck('state')->unique()->values();

        return view('livewire.trackingbystate', [
            'tableData' => $this->filteredRows,
            'batchList' => $batchList,
            'stateList' => $stateList,
        ])->layout('layouts.header');
    }
}