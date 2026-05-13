<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\orderapprovedtable;
use App\Models\productjunction;
use App\Models\batchProductPrice as BatchProductPrice;

class BatchRoleTracking extends Component
{
    public $batchId;
    public $selectedBatchNo = '';
    public $selectedState = '';
    public $selectedRole = '';

    public $data = [];
    public $batch;

    public function mount($id)
    {
        $this->batchId = $id;
        $this->batch = BatchProductPrice::find($id);

        $this->selectedBatchNo = $this->batch->batchno ?? '';

        $this->loadData();
    }

    public function loadData()
    {
        $batchQuery = BatchProductPrice::query();

        if ($this->selectedBatchNo) {
            $batchQuery->where('batchno', $this->selectedBatchNo);
        }

        $batchIds = $batchQuery->pluck('id')->toArray();

        $junctionRows = productjunction::whereIn('batchid', $batchIds)
            ->get()
            ->groupBy(function ($item) {
                return $item->uid . '_' . $item->batchid;
            });

        $this->data = $junctionRows->map(function ($items) {
            $first = $items->first();

            $inventoryQty = $items->sum(function ($row) {
                return (int) ($row->inventery ?? 0);
            });

            $batch = BatchProductPrice::find($first->batchid);

            $order = orderapprovedtable::where('userid', $first->uid)
                ->where('batchid', $first->batchid)
                ->latest('id')
                ->first();

            return [
                'user_id' => $first->uid,
                'batch_id' => $first->batchid,
                'batchno' => $batch->batchno ?? 'N/A',
                'state' => $order->region ?? 'N/A',
                'role' => $order->userrole ?? 'N/A',
                'name' => $order->username ?? 'N/A',
                'box_qty' => 1,
                'pcs_qty' => $inventoryQty,
                'total_pcs' => $inventoryQty,
            ];
        })->values()->toArray();
    }

    public function updatedSelectedBatchNo()
    {
        $this->loadData();
    }

    public function resetFilters()
    {
        $this->selectedBatchNo = $this->batch->batchno ?? '';
        $this->selectedState = '';
        $this->selectedRole = '';

        $this->loadData();
    }

    public function getFilteredDataProperty()
    {
        return collect($this->data)
            ->filter(function ($item) {
                $matchState = $this->selectedState
                    ? strtolower($item['state']) === strtolower($this->selectedState)
                    : true;

                $matchRole = $this->selectedRole
                    ? strtolower($item['role']) === strtolower($this->selectedRole)
                    : true;

                return $matchState && $matchRole;
            })
            ->values();
    }

    public function getDetailRowsProperty()
    {
        return $this->filteredData;
    }

    public function getRowsProperty()
    {
        return $this->filteredData
            ->groupBy('role')
            ->map(function ($items, $role) {
                return [
                    'role' => $role,
                    'users' => $items->count(),
                    'box_qty' => $items->sum('box_qty'),
                    'pcs_qty' => $items->sum('pcs_qty'),
                    'total_pcs' => $items->sum('total_pcs'),
                ];
            })
            ->values();
    }

    public function getTotalUsersProperty()
    {
        return $this->filteredData->count();
    }

    public function getTotalBoxProperty()
    {
        return $this->filteredData->sum('box_qty');
    }

    public function getTotalPcsProperty()
    {
        return $this->filteredData->sum('pcs_qty');
    }

    public function getGrandTotalPcsProperty()
    {
        return $this->filteredData->sum('total_pcs');
    }

    public function downloadCsv()
    {
        $rows = $this->detailRows;

        $fileName = 'batch-role-tracking-' . now()->format('Y-m-d-H-i-s') . '.csv';

        return response()->streamDownload(function () use ($rows) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Sr No',
                'User ID',
                'Role',
                'Person Name',
                'State',
                'Batch No',
                'Box Qty',
                'PCS Qty',
                'Total PCS',
            ]);

            foreach ($rows as $index => $row) {
                fputcsv($file, [
                    $index + 1,
                    $row['user_id'],
                    $row['role'],
                    $row['name'],
                    $row['state'],
                    $row['batchno'],
                    $row['box_qty'],
                    $row['pcs_qty'],
                    $row['total_pcs'],
                ]);
            }

            fclose($file);
        }, $fileName);
    }

    public function render()
    {
        $batches = BatchProductPrice::select('batchno')
            ->whereNotNull('batchno')
            ->distinct()
            ->orderBy('batchno')
            ->pluck('batchno');

        $states = collect($this->data)
            ->pluck('state')
            ->filter()
            ->unique()
            ->values();

        $roles = collect($this->data)
            ->pluck('role')
            ->filter()
            ->unique()
            ->values();

        return view('livewire.batch-role-tracking', [
            'batches' => $batches,
            'states' => $states,
            'roles' => $roles,
            'rows' => $this->rows,
            'detailRows' => $this->detailRows,
        ])->layout('layouts.header');
    }
}