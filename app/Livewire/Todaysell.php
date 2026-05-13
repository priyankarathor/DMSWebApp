<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\orderapprovedtable;
use Carbon\Carbon;

class Todaysell extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $startDate;
    public $endDate;
    public $search = '';

    public function mount()
    {
        $this->startDate = Carbon::today()->format('Y-m-d');
        $this->endDate = Carbon::today()->format('Y-m-d');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function filterData()
    {
        $this->resetPage();
    }

    private function baseQuery()
    {
        return orderapprovedtable::query()
            ->when($this->startDate && $this->endDate, function ($query) {
                $query->whereBetween('invoicedate', [
                    $this->startDate,
                    $this->endDate
                ]);
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('invoiceno', 'like', '%' . $this->search . '%')
                        ->orWhere('framname', 'like', '%' . $this->search . '%')
                        ->orWhere('username', 'like', '%' . $this->search . '%')
                        ->orWhere('productname', 'like', '%' . $this->search . '%')
                        ->orWhere('region', 'like', '%' . $this->search . '%')
                        ->orWhere('userrole', 'like', '%' . $this->search . '%');
                });
            });
    }

    private function toArrayValue($value)
    {
        if ($value === null || $value === '') {
            return [];
        }

        return array_map('trim', explode(',', $value));
    }

    private function numberValue($value)
    {
        return (float) str_replace(',', '', $value ?? 0);
    }

    private function calculateAnalytics($records)
    {
        $productSummary = [];
        $regionSummary = [];
        $productRegionSummary = [];
        $buyerSummary = [];
        $roleSummary = [];
        $productRoleSummary = [];

        foreach ($records as $row) {

            $products = $this->toArrayValue($row->productname);
            $quantities = $this->toArrayValue($row->productquantity);
            $bulks = $this->toArrayValue($row->productbulk);
            $pcsValues = $this->toArrayValue($row->totalpcs);
            $amounts = $this->toArrayValue($row->totalamount);

            if (count($products) === 0) {
                $products = ['Unknown Product'];
            }

            foreach ($products as $index => $productName) {

                $productName = $productName ?: 'Unknown Product';

                $quantity = $this->numberValue($quantities[$index] ?? $quantities[0] ?? 0);
                $bulk = $this->numberValue($bulks[$index] ?? $bulks[0] ?? 0);
                $pcs = $this->numberValue($pcsValues[$index] ?? $pcsValues[0] ?? 0);
                $amount = $this->numberValue($amounts[$index] ?? $row->totalamount ?? 0);

                $region = $row->region ?: 'Unknown Region';
                $buyer = $row->username ?: 'Unknown Buyer';
                $role = $row->userrole ?: 'Unknown Role';

                if (!isset($productSummary[$productName])) {
                    $productSummary[$productName] = [
                        'product' => $productName,
                        'orders' => 0,
                        'quantity' => 0,
                        'bulk' => 0,
                        'pcs' => 0,
                        'amount' => 0,
                    ];
                }

                $productSummary[$productName]['orders']++;
                $productSummary[$productName]['quantity'] += $quantity;
                $productSummary[$productName]['bulk'] += $bulk;
                $productSummary[$productName]['pcs'] += $pcs;
                $productSummary[$productName]['amount'] += $amount;

                if (!isset($regionSummary[$region])) {
                    $regionSummary[$region] = [
                        'region' => $region,
                        'orders' => 0,
                        'quantity' => 0,
                        'amount' => 0,
                    ];
                }

                $regionSummary[$region]['orders']++;
                $regionSummary[$region]['quantity'] += $quantity;
                $regionSummary[$region]['amount'] += $amount;

                $productRegionKey = $productName . '|' . $region;

                if (!isset($productRegionSummary[$productRegionKey])) {
                    $productRegionSummary[$productRegionKey] = [
                        'product' => $productName,
                        'region' => $region,
                        'orders' => 0,
                        'quantity' => 0,
                        'amount' => 0,
                    ];
                }

                $productRegionSummary[$productRegionKey]['orders']++;
                $productRegionSummary[$productRegionKey]['quantity'] += $quantity;
                $productRegionSummary[$productRegionKey]['amount'] += $amount;

                if (!isset($buyerSummary[$buyer])) {
                    $buyerSummary[$buyer] = [
                        'buyer' => $buyer,
                        'contact' => $row->contactno,
                        'email' => $row->email,
                        'region' => $region,
                        'orders' => 0,
                        'quantity' => 0,
                        'amount' => 0,
                    ];
                }

                $buyerSummary[$buyer]['orders']++;
                $buyerSummary[$buyer]['quantity'] += $quantity;
                $buyerSummary[$buyer]['amount'] += $amount;

                if (!isset($roleSummary[$role])) {
                    $roleSummary[$role] = [
                        'role' => $role,
                        'orders' => 0,
                        'quantity' => 0,
                        'amount' => 0,
                    ];
                }

                $roleSummary[$role]['orders']++;
                $roleSummary[$role]['quantity'] += $quantity;
                $roleSummary[$role]['amount'] += $amount;

                $productRoleKey = $productName . '|' . $role;

                if (!isset($productRoleSummary[$productRoleKey])) {
                    $productRoleSummary[$productRoleKey] = [
                        'product' => $productName,
                        'role' => $role,
                        'orders' => 0,
                        'quantity' => 0,
                        'amount' => 0,
                    ];
                }

                $productRoleSummary[$productRoleKey]['orders']++;
                $productRoleSummary[$productRoleKey]['quantity'] += $quantity;
                $productRoleSummary[$productRoleKey]['amount'] += $amount;
            }
        }

        $sortAmount = function (&$array) {
            usort($array, function ($a, $b) {
                return $b['amount'] <=> $a['amount'];
            });
        };

        $productSummary = array_values($productSummary);
        $regionSummary = array_values($regionSummary);
        $productRegionSummary = array_values($productRegionSummary);
        $buyerSummary = array_values($buyerSummary);
        $roleSummary = array_values($roleSummary);
        $productRoleSummary = array_values($productRoleSummary);

        $sortAmount($productSummary);
        $sortAmount($regionSummary);
        $sortAmount($productRegionSummary);
        $sortAmount($buyerSummary);
        $sortAmount($roleSummary);
        $sortAmount($productRoleSummary);

        return compact(
            'productSummary',
            'regionSummary',
            'productRegionSummary',
            'buyerSummary',
            'roleSummary',
            'productRoleSummary'
        );
    }

    public function downloadCSV()
    {
        $fileName = 'sales_analytics_report_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $records = $this->baseQuery()->latest()->get();
        $analytics = $this->calculateAnalytics($records);

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () use ($analytics) {

            $file = fopen('php://output', 'w');

            fputcsv($file, ['Product Wise Sales']);
            fputcsv($file, ['Product', 'Orders', 'Quantity', 'Bulk', 'PCS', 'Amount']);

            foreach ($analytics['productSummary'] as $item) {
                fputcsv($file, [
                    $item['product'],
                    $item['orders'],
                    $item['quantity'],
                    $item['bulk'],
                    $item['pcs'],
                    $item['amount'],
                ]);
            }

            fputcsv($file, []);
            fputcsv($file, ['Region Wise Demand']);
            fputcsv($file, ['Region', 'Orders', 'Quantity', 'Amount']);

            foreach ($analytics['regionSummary'] as $item) {
                fputcsv($file, [
                    $item['region'],
                    $item['orders'],
                    $item['quantity'],
                    $item['amount'],
                ]);
            }

            fputcsv($file, []);
            fputcsv($file, ['Top Buyers']);
            fputcsv($file, ['Buyer', 'Contact', 'Email', 'Region', 'Orders', 'Quantity', 'Amount']);

            foreach ($analytics['buyerSummary'] as $item) {
                fputcsv($file, [
                    $item['buyer'],
                    $item['contact'],
                    $item['email'],
                    $item['region'],
                    $item['orders'],
                    $item['quantity'],
                    $item['amount'],
                ]);
            }

            fputcsv($file, []);
            fputcsv($file, ['Role Wise Buying']);
            fputcsv($file, ['Role', 'Orders', 'Quantity', 'Amount']);

            foreach ($analytics['roleSummary'] as $item) {
                fputcsv($file, [
                    $item['role'],
                    $item['orders'],
                    $item['quantity'],
                    $item['amount'],
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function render()
    {
        $orders = $this->baseQuery()->latest()->paginate(10);

        $allRecords = $this->baseQuery()->latest()->get();

        $analytics = $this->calculateAnalytics($allRecords);

        $totalSell = $allRecords->sum(function ($row) {
            return $this->numberValue($row->totalamount);
        });

        $totalOrders = $allRecords->count();

        return view('livewire.todaysell', [
            'orders' => $orders,
            'totalSell' => $totalSell,
            'totalOrders' => $totalOrders,
            'productSummary' => $analytics['productSummary'],
            'regionSummary' => $analytics['regionSummary'],
            'productRegionSummary' => $analytics['productRegionSummary'],
            'buyerSummary' => $analytics['buyerSummary'],
            'roleSummary' => $analytics['roleSummary'],
            'productRoleSummary' => $analytics['productRoleSummary'],
        ])->layout('layouts.header');
    }
}