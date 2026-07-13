<?php

namespace App\Livewire;

use App\Models\productjunction;
use Livewire\Component;
use App\Models\User;
use App\Models\userroletab;
use App\Models\userhierarchytab;
use App\Models\productadmintab;
use App\Models\orderlisttab;
use App\Models\orderapprovedtable;
use App\Models\manageaccounttable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    public function render()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $isAdmin = ($user->role != 2);
        $dashboardData = [];

        if ($isAdmin) {
            // --- ADMIN DASHBOARD DATA ---
            $dashboardData['roleName'] = 'Administrator';
            $dashboardData['totalProducts'] = productadmintab::count();
            $dashboardData['totalUsers'] = userhierarchytab::where('active', '!=', 'deactivate')->count();

            // Pending Orders (from orderlisttabs)
            $dashboardData['pendingOrders'] = orderlisttab::count();

            // Completed Sales (from orderapprovedtables)
            $approvedOrdersList = orderapprovedtable::get();
            $dashboardData['completedSales'] = $approvedOrdersList->count();

            // Revenue calculation
            $totalRevenue = 0;
            foreach ($approvedOrdersList as $ord) {
                if (!empty($ord->totalamount)) {
                    foreach (explode(',', $ord->totalamount) as $amt) {
                        $totalRevenue += (float) trim($amt);
                    }
                }
            }
            $dashboardData['totalRevenue'] = $totalRevenue;

            // Product distribution by category for chart
            $productDistribution = DB::table('productadmintabs')
                ->select('category', DB::raw('count(*) as count'))
                ->whereNotNull('category')
                ->where('category', '!=', '')
                ->groupBy('category')
                ->get()
                ->map(function($p) {
                    return [
                        'label' => $p->category,
                        'value' => (int)$p->count
                    ];
                })
                ->toArray();
            $dashboardData['productDistribution'] = $productDistribution;

            // Monthly sales trends for chart
            $monthlySales = DB::table('orderapprovedtables')
                ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(CAST(REPLACE(totalamount, ",", "") AS DECIMAL(10,2))) as total'))
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->orderBy('month')
                ->get()
                ->pluck('total', 'month')
                ->toArray();

            $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            $salesTrend = [];
            foreach (range(1, 12) as $m) {
                $salesTrend[] = [
                    'month' => $months[$m - 1],
                    'amount' => $monthlySales[$m] ?? 0
                ];
            }
            $dashboardData['salesTrend'] = $salesTrend;

            // Recent Registered Users
            $dashboardData['recentUsers'] = userhierarchytab::leftJoin('userroletabs', 'userhierarchytabs.roleid', '=', 'userroletabs.id')
                ->select('userhierarchytabs.*', 'userroletabs.role as role_name')
                ->orderBy('userhierarchytabs.id', 'desc')
                ->limit(5)
                ->get();

            // Recent Orders - enriched with buyer name and product name
            $recentOrders = orderlisttab::orderBy('id', 'desc')->limit(5)->get()->map(function ($order) {
                // Resolve buyer name from userhierarchytabs
                $buyer = DB::table('userhierarchytabs')
                    ->leftJoin('userroletabs', 'userhierarchytabs.roleid', '=', 'userroletabs.id')
                    ->where('userhierarchytabs.id', $order->userid)
                    ->select('userhierarchytabs.username', 'userroletabs.role as userrole')
                    ->first();
                $order->buyer_name = $buyer->username ?? 'N/A';
                $order->buyer_role = $buyer->userrole ?? 'N/A';

                // Resolve product names from pid (comma-separated product IDs)
                if (!empty($order->pid)) {
                    $pidArray = explode(',', $order->pid);
                    $productNames = DB::table('productadmintabs')
                        ->whereIn('id', array_map('trim', $pidArray))
                        ->pluck('productname')
                        ->toArray();
                    $order->product_display = implode(', ', $productNames);
                } else {
                    $order->product_display = $order->productname ?? 'N/A';
                }

                return $order;
            });
            $dashboardData['recentOrders'] = $recentOrders;

            // Low Stock Products Alert
            $dashboardData['lowStockProducts'] = productadmintab::orderBy('quantity', 'asc')->limit(5)->get();

        } else {
            // --- REGULAR USER DASHBOARD DATA (Distributor, Dealer, Subdealer, Retailer, Employee) ---
            $manageUser = manageaccounttable::where('email', $user->email)->first();
            $roleTab = userroletab::find($user->userrole);
            $roleName = $roleTab ? $roleTab->role : 'User';
            $dashboardData['roleName'] = $roleName;
            $dashboardData['manageUser'] = $manageUser;

            if ($manageUser) {
                $uid = $manageUser->ragisternum; // Hierarchy user ID

                // 1. Inventory Analytics
                $inventoryItems = productjunction::leftJoin('productadmintabs', 'productjunctions.pid', '=', 'productadmintabs.id')
                    ->where('productjunctions.uid', $uid)
                    ->get();

                $dashboardData['totalInventoryQty'] = $inventoryItems->sum('inventery');

                $inventoryValue = 0;
                foreach ($inventoryItems as $item) {
                    $inventoryValue += ((float) $item->inventery * (float) ($item->productprice ?? 0));
                }
                $dashboardData['inventoryValue'] = $inventoryValue;
                $dashboardData['distinctProducts'] = $inventoryItems->count();

                // 2. Sales Analytics (Orders placed to this user as seller)
                $pendingSalesCount = orderlisttab::where('sellerid', $uid)->count();
                $dashboardData['pendingSalesCount'] = $pendingSalesCount;

                $completedSalesList = orderapprovedtable::where('sellerid', $uid)->get();
                $dashboardData['completedSalesCount'] = $completedSalesList->count();

                $totalSalesRevenue = 0;
                foreach ($completedSalesList as $sale) {
                    if (!empty($sale->totalamount)) {
                        foreach (explode(',', $sale->totalamount) as $amt) {
                            $totalSalesRevenue += (float) trim($amt);
                        }
                    }
                }
                $dashboardData['totalSalesRevenue'] = $totalSalesRevenue;

                // 3. Purchase Analytics (Orders placed by this user as buyer)
                $pendingPurchasesCount = orderlisttab::where('userid', $uid)->count();
                $dashboardData['pendingPurchasesCount'] = $pendingPurchasesCount;

                $completedPurchasesList = orderapprovedtable::where('userid', $uid)->get();
                $dashboardData['completedPurchasesCount'] = $completedPurchasesList->count();

                $totalPurchasesSpend = 0;
                foreach ($completedPurchasesList as $purchase) {
                    if (!empty($purchase->totalamount)) {
                        foreach (explode(',', $purchase->totalamount) as $amt) {
                            $totalPurchasesSpend += (float) trim($amt);
                        }
                    }
                }
                $dashboardData['totalPurchasesSpend'] = $totalPurchasesSpend;

                // 4. Downstream Downline Accounts (Children in Hierarchy)
                $downstreamUsers = userhierarchytab::leftJoin('userroletabs', 'userhierarchytabs.roleid', '=', 'userroletabs.id')
                    ->where(function($query) use ($uid) {
                        $query->where('userhierarchytabs.assignid', $uid)
                              ->orWhere('userhierarchytabs.zonalId', $uid);
                    })
                    ->where('userhierarchytabs.active', '!=', 'deactivate')
                    ->select('userhierarchytabs.*', 'userroletabs.role as role_name')
                    ->get();

                $dashboardData['downstreamCount'] = $downstreamUsers->count();
                $dashboardData['downstreamUsers'] = $downstreamUsers;

                // Recent Incoming Orders (Sales)
                $dashboardData['recentIncomingOrders'] = orderlisttab::where('sellerid', $uid)
                    ->orderBy('id', 'desc')
                    ->limit(5)
                    ->get();

                // Recent Outgoing Orders (Purchases)
                $dashboardData['recentOutgoingOrders'] = orderlisttab::where('userid', $uid)
                    ->orderBy('id', 'desc')
                    ->limit(5)
                    ->get();
            } else {
                $dashboardData['totalInventoryQty'] = 0;
                $dashboardData['inventoryValue'] = 0;
                $dashboardData['distinctProducts'] = 0;
                $dashboardData['pendingSalesCount'] = 0;
                $dashboardData['completedSalesCount'] = 0;
                $dashboardData['totalSalesRevenue'] = 0;
                $dashboardData['pendingPurchasesCount'] = 0;
                $dashboardData['completedPurchasesCount'] = 0;
                $dashboardData['totalPurchasesSpend'] = 0;
                $dashboardData['downstreamCount'] = 0;
                $dashboardData['downstreamUsers'] = collect();
                $dashboardData['recentIncomingOrders'] = collect();
                $dashboardData['recentOutgoingOrders'] = collect();
            }
        }

        return view('livewire.index', [
            'isAdmin' => $isAdmin,
            'data' => $dashboardData,
        ])->layout('layouts.header');
    }
}

