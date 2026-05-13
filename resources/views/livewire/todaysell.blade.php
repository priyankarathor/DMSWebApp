<div class="container-fluid py-4 sales-page">

    <style>
        .sales-page {
            background: #f4f7fb;
            min-height: 100vh;
        }

        .main-card {
            border: none;
            border-radius: 24px;
            box-shadow: 0 12px 35px rgba(15, 23, 42, 0.08);
            overflow: hidden;
        }

        .main-header {
            background: linear-gradient(135deg, #0f172a, #1d4ed8);
            color: white;
            padding: 28px;
        }

        .header-icon {
            width: 56px;
            height: 56px;
            border-radius: 18px;
            background: rgba(255,255,255,.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
        }

        .filter-box {
            background: white;
            border-radius: 20px;
            padding: 22px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
        }

        .form-control {
            border-radius: 14px;
            padding: 12px 15px;
            border: 1px solid #dbe3ef;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, .12);
        }

        .btn-filter {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            border: none;
            color: white;
            border-radius: 14px;
            padding: 12px;
            font-weight: 700;
        }

        .btn-download {
            background: linear-gradient(135deg, #16a34a, #22c55e);
            border: none;
            color: white;
            border-radius: 14px;
            padding: 12px 22px;
            font-weight: 700;
            box-shadow: 0 8px 20px rgba(34,197,94,.35);
        }

        .stat-card {
            border: none;
            border-radius: 22px;
            padding: 22px;
            color: white;
            box-shadow: 0 10px 25px rgba(15, 23, 42, .12);
        }

        .stat-green {
            background: linear-gradient(135deg, #059669, #10b981);
        }

        .stat-blue {
            background: linear-gradient(135deg, #2563eb, #60a5fa);
        }

        .stat-purple {
            background: linear-gradient(135deg, #7c3aed, #a78bfa);
        }

        .stat-orange {
            background: linear-gradient(135deg, #ea580c, #fb923c);
        }

        .analytics-card {
            border: none;
            border-radius: 22px;
            box-shadow: 0 8px 26px rgba(15, 23, 42, .07);
            overflow: hidden;
        }

        .analytics-card .card-header {
            background: white;
            border-bottom: 1px solid #eef2f7;
            padding: 18px 22px;
        }

        .modern-table {
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        .modern-table thead th {
            background: #0f172a;
            color: white;
            font-size: 13px;
            padding: 13px 14px;
            white-space: nowrap;
            border: none;
        }

        .modern-table tbody tr {
            background: white;
            box-shadow: 0 5px 18px rgba(15, 23, 42, .06);
        }

        .modern-table tbody td {
            padding: 14px;
            border: none;
            vertical-align: middle;
            white-space: nowrap;
            font-size: 14px;
        }

        .modern-table tbody tr td:first-child {
            border-radius: 14px 0 0 14px;
        }

        .modern-table tbody tr td:last-child {
            border-radius: 0 14px 14px 0;
        }

        .pill {
            padding: 7px 12px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 12px;
        }

        .pill-blue {
            background: #eff6ff;
            color: #1d4ed8;
        }

        .pill-green {
            background: #ecfdf5;
            color: #059669;
        }

        .pill-red {
            background: #fef2f2;
            color: #dc2626;
        }

        .pill-dark {
            background: #111827;
            color: white;
        }

        .amount {
            color: #059669;
            font-weight: 800;
        }

        .section-title {
            font-weight: 800;
            color: #0f172a;
        }

        .small-muted {
            color: #64748b;
            font-size: 13px;
        }
    </style>

    <div class="card main-card">

        <div class="main-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div class="d-flex align-items-center gap-3">
                    <div class="header-icon">
                        <i class="fa fa-chart-line"></i>
                    </div>

                    <div>
                        <h3 class="mb-1 fw-bold">Sales Analytics Dashboard</h3>
                        <p class="mb-0 opacity-75">
                            Product demand, region demand, top buyers and role wise sales report
                        </p>
                    </div>
                </div>

                <button wire:click="downloadCSV" class="btn btn-download">
                    <i class="fa fa-download me-1"></i>
                    Download Full CSV
                </button>

            </div>
        </div>

        <div class="card-body p-4">

            <div class="filter-box mb-4">

                <div class="row g-3 align-items-end">

                    <div class="col-md-3">
                        <label class="fw-bold mb-2 text-muted">Start Date</label>
                        <input type="date" wire:model="startDate" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label class="fw-bold mb-2 text-muted">End Date</label>
                        <input type="date" wire:model="endDate" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold mb-2 text-muted">Search Anything</label>
                        <input type="text"
                               wire:model.live="search"
                               class="form-control"
                               placeholder="Invoice, product, region, user, role...">
                    </div>

                    <div class="col-md-2">
                        <button wire:click="filterData" class="btn btn-filter w-100">
                            <i class="fa fa-filter me-1"></i>
                            Filter
                        </button>
                    </div>

                </div>

            </div>

            <div class="row g-3 mb-4">

                <div class="col-md-3">
                    <div class="stat-card stat-green">
                        <p class="mb-1 opacity-75">Total Sales</p>
                        <h3 class="fw-bold mb-0">
                            ₹ {{ number_format((float) $totalSell, 2) }}
                        </h3>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stat-card stat-blue">
                        <p class="mb-1 opacity-75">Total Invoices</p>
                        <h3 class="fw-bold mb-0">
                            {{ $totalOrders }}
                        </h3>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stat-card stat-purple">
                        <p class="mb-1 opacity-75">Total Products</p>
                        <h3 class="fw-bold mb-0">
                            {{ count($productSummary) }}
                        </h3>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stat-card stat-orange">
                        <p class="mb-1 opacity-75">Active Regions</p>
                        <h3 class="fw-bold mb-0">
                            {{ count($regionSummary) }}
                        </h3>
                    </div>
                </div>

            </div>

            <div class="row g-4 mb-4">

                <div class="col-lg-6">
                    <div class="card analytics-card h-100">

                        <div class="card-header">
                            <h5 class="section-title mb-0">
                                <i class="fa fa-box text-primary me-2"></i>
                                Product Wise Sales
                            </h5>
                            <span class="small-muted">Konse product kitni quantity mein sale hue</span>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table modern-table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Orders</th>
                                            <th>Qty</th>
                                            <th>Bulk</th>
                                            <th>PCS</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($productSummary as $item)
                                            <tr>
                                                <td class="fw-bold">{{ $item['product'] }}</td>
                                                <td><span class="pill pill-blue">{{ $item['orders'] }}</span></td>
                                                <td class="fw-bold">{{ number_format((float) $item['quantity'], 2) }}</td>
                                                <td>{{ number_format((float) $item['bulk'], 2) }}</td>
                                                <td>{{ number_format((float) $item['pcs'], 2) }}</td>
                                                <td class="amount">₹ {{ number_format((float) $item['amount'], 2) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-4">
                                                    No product data found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card analytics-card h-100">

                        <div class="card-header">
                            <h5 class="section-title mb-0">
                                <i class="fa fa-location-dot text-danger me-2"></i>
                                Region Wise Demand
                            </h5>
                            <span class="small-muted">Kis region mein demand zyada hai</span>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table modern-table">
                                    <thead>
                                        <tr>
                                            <th>Region</th>
                                            <th>Orders</th>
                                            <th>Qty</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($regionSummary as $item)
                                            <tr>
                                                <td class="fw-bold">{{ $item['region'] }}</td>
                                                <td><span class="pill pill-blue">{{ $item['orders'] }}</span></td>
                                                <td class="fw-bold">{{ number_format((float) $item['quantity'], 2) }}</td>
                                                <td class="amount">₹ {{ number_format((float) $item['amount'], 2) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-4">
                                                    No region data found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="row g-4 mb-4">

                <div class="col-lg-6">
                    <div class="card analytics-card h-100">

                        <div class="card-header">
                            <h5 class="section-title mb-0">
                                <i class="fa fa-user-check text-success me-2"></i>
                                Top Buyers
                            </h5>
                            <span class="small-muted">Konsa person sabse zyada buy kar raha hai</span>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table modern-table">
                                    <thead>
                                        <tr>
                                            <th>Buyer</th>
                                            <th>Region</th>
                                            <th>Orders</th>
                                            <th>Qty</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($buyerSummary as $item)
                                            <tr>
                                                <td>
                                                    <div class="fw-bold">{{ $item['buyer'] }}</div>
                                                    <small class="text-muted">{{ $item['contact'] }}</small>
                                                </td>
                                                <td>{{ $item['region'] }}</td>
                                                <td><span class="pill pill-green">{{ $item['orders'] }}</span></td>
                                                <td class="fw-bold">{{ number_format((float) $item['quantity'], 2) }}</td>
                                                <td class="amount">₹ {{ number_format((float) $item['amount'], 2) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-4">
                                                    No buyer data found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card analytics-card h-100">

                        <div class="card-header">
                            <h5 class="section-title mb-0">
                                <i class="fa fa-users text-warning me-2"></i>
                                Role Wise Buying
                            </h5>
                            <span class="small-muted">Konsa role sabse zyada product buy kar raha hai</span>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table modern-table">
                                    <thead>
                                        <tr>
                                            <th>Role</th>
                                            <th>Orders</th>
                                            <th>Qty</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($roleSummary as $item)
                                            <tr>
                                                <td><span class="pill pill-dark">{{ $item['role'] }}</span></td>
                                                <td>{{ $item['orders'] }}</td>
                                                <td class="fw-bold">{{ number_format((float) $item['quantity'], 2) }}</td>
                                                <td class="amount">₹ {{ number_format((float) $item['amount'], 2) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-4">
                                                    No role data found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="card analytics-card mb-4">

                <div class="card-header">
                    <h5 class="section-title mb-0">
                        <i class="fa fa-chart-simple text-primary me-2"></i>
                        Product Demand By Region
                    </h5>
                    <span class="small-muted">
                        Kis product ki kis region mein zyada demand hai
                    </span>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table modern-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Region</th>
                                    <th>Orders</th>
                                    <th>Quantity</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($productRegionSummary as $item)
                                    <tr>
                                        <td class="fw-bold">{{ $item['product'] }}</td>
                                        <td><span class="pill pill-blue">{{ $item['region'] }}</span></td>
                                        <td>{{ $item['orders'] }}</td>
                                        <td class="fw-bold">{{ number_format((float) $item['quantity'], 2) }}</td>
                                        <td class="amount">₹ {{ number_format((float) $item['amount'], 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            No product region demand found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                </div>

            </div>

            <div class="card analytics-card mb-4">

                <div class="card-header">
                    <h5 class="section-title mb-0">
                        <i class="fa fa-layer-group text-success me-2"></i>
                        Product Demand By Role
                    </h5>
                    <span class="small-muted">
                        Kis role ne kaunsa product zyada buy kiya
                    </span>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table modern-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Role</th>
                                    <th>Orders</th>
                                    <th>Quantity</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($productRoleSummary as $item)
                                    <tr>
                                        <td class="fw-bold">{{ $item['product'] }}</td>
                                        <td><span class="pill pill-dark">{{ $item['role'] }}</span></td>
                                        <td>{{ $item['orders'] }}</td>
                                        <td class="fw-bold">{{ number_format((float) $item['quantity'], 2) }}</td>
                                        <td class="amount">₹ {{ number_format((float) $item['amount'], 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            No product role demand found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                </div>

            </div>

            <div class="card analytics-card">

                <div class="card-header">
                    <h5 class="section-title mb-0">
                        <i class="fa fa-file-invoice text-primary me-2"></i>
                        Invoice Wise Details
                    </h5>
                    <span class="small-muted">
                        Complete filtered invoice records
                    </span>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table modern-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Invoice</th>
                                    <th>Date</th>
                                    <th>Company</th>
                                    <th>User</th>
                                    <th>Role</th>
                                    <th>Region</th>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Total Amount</th>
                                    <th>Seller ID</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($orders as $key => $order)
                                    <tr>
                                        <td class="fw-bold">{{ $orders->firstItem() + $key }}</td>

                                        <td>
                                            <span class="pill pill-blue">
                                                {{ $order->invoiceno }}
                                            </span>
                                        </td>

                                        <td>{{ $order->invoicedate }}</td>

                                        <td>
                                            <div class="fw-bold">{{ $order->framname }}</div>
                                            <small class="text-muted">GST: {{ $order->gstnumber ?? 'N/A' }}</small>
                                        </td>

                                        <td>
                                            <div class="fw-bold">{{ $order->username }}</div>
                                            <small class="text-muted">{{ $order->contactno }}</small>
                                        </td>

                                        <td>
                                            <span class="pill pill-dark">
                                                {{ $order->userrole }}
                                            </span>
                                        </td>

                                        <td>{{ $order->region }}</td>

                                        <td class="fw-bold">{{ $order->productname }}</td>

                                        <td>{{ $order->productquantity }}</td>

                                        <td class="amount">
                                            ₹ {{ number_format((float) $order->totalamount, 2) }}
                                        </td>

                                        <td>
                                            <span class="pill pill-red">
                                                {{ $order->sellerid }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center text-muted py-5">
                                            <i class="fa fa-folder-open fs-1 mb-3"></i>
                                            <h5 class="fw-bold">No Sales Data Found</h5>
                                            <p class="mb-0">Please change date filter or search keyword.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2">
                        <div class="text-muted fw-semibold">
                            Showing {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }}
                            of {{ $orders->total() }} records
                        </div>

                        <div>
                            {{ $orders->links() }}
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>