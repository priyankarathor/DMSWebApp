<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\orderapprovedtable;
use App\Models\productjunction;
use App\Models\batchProductPrice as BatchProductPrice;
use App\Models\userhierarchytab;

class BatchRoleTracking extends Component
{
    public $batchId, $productId, $batch;
    public $search = '', $selectedBatchNo = '', $selectedState = '', $selectedRole = '';
    public $data = [];

    public function mount($id)
    {
        $this->batchId = $id;
        $this->batch = BatchProductPrice::findOrFail($id);
        $this->productId = $this->batch->pid;
        $this->selectedBatchNo = $this->batch->batchno ?? '';
        $this->loadData();
    }

    public function updated($field)
    {
        if (in_array($field, ['search', 'selectedBatchNo', 'selectedState', 'selectedRole'])) {
            $this->loadData();
        }
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->selectedBatchNo = $this->batch->batchno ?? '';
        $this->selectedState = '';
        $this->selectedRole = '';
        $this->loadData();
    }

    public function loadData()
    {
        $batchIds = BatchProductPrice::where('pid', $this->productId)
            ->when($this->selectedBatchNo, fn($q) => $q->where('batchno', $this->selectedBatchNo))
            ->pluck('id')
            ->toArray();

        if (empty($batchIds)) {
            $this->data = [];
            return;
        }

        $junctionGroups = productjunction::whereIn('batchid', $batchIds)
            ->get()
            ->groupBy(fn($item) => $item->uid . '_' . $item->batchid);

        $rows = $junctionGroups->map(function ($items) {
            $first = $items->first();

            $batch = BatchProductPrice::find($first->batchid);

            $inventoryQty = $items->sum(fn($row) => (int) ($row->inventery ?? 0));

            $order = orderapprovedtable::where(function ($q) use ($first) {
                    $q->where('userid', $first->uid)
                      ->orWhere('approveuserid', $first->uid)
                      ->orWhere('sellerid', $first->uid);
                })
                ->whereRaw("FIND_IN_SET(?, REPLACE(batchid, ' ', ''))", [(string) $first->batchid])
                ->latest('id')
                ->first();

            $user = userhierarchytab::where(function ($q) use ($first) {
                    $q->where('id', $first->uid)
                      ->orWhere('registerid', $first->uid)
                      ->orWhere('userId', $first->uid);
                })
                ->first();

            return [
                'user_id'   => $first->uid,
                'batch_id'  => $first->batchid,
                'batchno'   => $batch->batchno ?? 'N/A',
                'state'     => $order->region ?? $user->region ?? $user->state ?? 'N/A',
                'role'      => $order->userrole ?? $user->role ?? $user->userrole ?? 'N/A',
                'name'      => $order->username ?? $user->username ?? $user->name ?? 'N/A',
                'pcs_qty'   => $inventoryQty,
                'total_pcs' => $inventoryQty,
            ];
        })->values();

        if ($this->search) {
            $search = strtolower(trim($this->search));
            $rows = $rows->filter(fn($row) =>
                str_contains(strtolower($row['user_id']), $search) ||
                str_contains(strtolower($row['name']), $search) ||
                str_contains(strtolower($row['role']), $search) ||
                str_contains(strtolower($row['state']), $search) ||
                str_contains(strtolower($row['batchno']), $search)
            )->values();
        }

        if ($this->selectedState) {
            $rows = $rows->filter(fn($row) =>
                strtolower($row['state']) === strtolower($this->selectedState)
            )->values();
        }

        if ($this->selectedRole) {
            $rows = $rows->filter(fn($row) =>
                strtolower($row['role']) === strtolower($this->selectedRole)
            )->values();
        }

        $this->data = $rows->toArray();
    }

    public function getDetailRowsProperty()
    {
        return collect($this->data);
    }

    public function getRowsProperty()
    {
        return $this->detailRows
            ->groupBy('role')
            ->map(fn($items, $role) => [
                'role' => $role,
                'users' => $items->count(),
                'pcs_qty' => $items->sum('pcs_qty'),
                'total_pcs' => $items->sum('total_pcs'),
            ])
            ->values();
    }

    public function getTotalUsersProperty()
    {
        return $this->detailRows->count();
    }

    public function getTotalPcsProperty()
    {
        return $this->detailRows->sum('pcs_qty');
    }

    public function getGrandTotalPcsProperty()
    {
        return $this->detailRows->sum('total_pcs');
    }

    public function downloadCsv()
    {
        $rows = $this->detailRows;

        return response()->streamDownload(function () use ($rows) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['Sr No', 'User ID', 'Role', 'Person Name', 'State', 'Batch No', 'PCS Stock Qty', 'Total PCS']);

            foreach ($rows as $index => $row) {
                fputcsv($file, [
                    $index + 1,
                    $row['user_id'],
                    $row['role'],
                    $row['name'],
                    $row['state'],
                    $row['batchno'],
                    $row['pcs_qty'],
                    $row['total_pcs'],
                ]);
            }

            fclose($file);
        }, 'batch-role-tracking-' . now()->format('Y-m-d-H-i-s') . '.csv');
    }

    public function render()
    {
        $batches = BatchProductPrice::where('pid', $this->productId)
            ->whereNotNull('batchno')
            ->orderBy('batchno')
            ->pluck('batchno')
            ->unique()
            ->values();

        $states = collect($this->data)->pluck('state')->filter()->unique()->values();
        $roles = collect($this->data)->pluck('role')->filter()->unique()->values();

        return view('livewire.batch-role-tracking', [
            'batches' => $batches,
            'states' => $states,
            'roles' => $roles,
            'rows' => $this->rows,
            'detailRows' => $this->detailRows,
        ])->layout('layouts.header');
    }
}