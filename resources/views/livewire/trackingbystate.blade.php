<div class="tracking-page">

    <style>
        .tracking-page {
            background: #f5f7fb;
            min-height: 100vh;
            padding: 30px 18px;
        }

        .tracking-container {
            max-width: 1500px;
            margin: auto;
        }

        .tracking-header {
            background: linear-gradient(135deg, #111a5b, #1f3b6d);
            padding: 26px 30px;
            border-radius: 22px;
            margin-bottom: 24px;
            color: white;
            box-shadow: 0 12px 35px rgba(17, 26, 91, 0.22);
        }

        .page-title {
            margin: 0;
            font-size: 30px;
            font-weight: 800;
        }

        .page-subtitle {
            margin: 7px 0 0;
            color: #dbe4ff;
            font-size: 15px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: #fff;
            border-radius: 18px;
            padding: 22px;
            border: 1px solid #edf1f7;
            box-shadow: 0 8px 26px rgba(18, 38, 63, 0.08);
        }

        .stat-label {
            color: #7883a8;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .stat-value {
            color: #111a5b;
            font-size: 30px;
            font-weight: 900;
        }

        .filter-card {
            background: #fff;
            padding: 20px;
            border-radius: 20px;
            margin-bottom: 22px;
            border: 1px solid #edf1f7;
            box-shadow: 0 8px 26px rgba(18, 38, 63, 0.08);
        }

        .filter-section {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 0.7fr 0.7fr;
            gap: 15px;
            align-items: end;
        }

        .filter-box label {
            font-size: 13px;
            font-weight: 700;
            color: #657199;
            margin-bottom: 7px;
            display: block;
        }

        .filter-box input,
        .filter-box select {
            width: 100%;
            height: 46px;
            border: 1px solid #dfe5f1;
            border-radius: 12px;
            padding: 0 14px;
            outline: none;
            font-size: 14px;
            color: #111a5b;
            background: #fff;
        }

        .filter-box input:focus,
        .filter-box select:focus {
            border-color: #111a5b;
            box-shadow: 0 0 0 3px rgba(17, 26, 91, 0.10);
        }

        .reset-btn {
            width: 100%;
            height: 46px;
            border: none;
            border-radius: 12px;
            background: #111a5b;
            color: white;
            font-weight: 800;
            cursor: pointer;
        }

        .table-card {
            background: #fff;
            border-radius: 20px;
            border: 1px solid #edf1f7;
            box-shadow: 0 8px 26px rgba(18, 38, 63, 0.08);
            overflow: hidden;
        }

        .table-wrapper {
            overflow-x: auto;
            max-height: 540px;
        }

        .custom-tracking-table {
            width: 100%;
            min-width: 1350px;
            border-collapse: collapse;
        }

        .custom-tracking-table thead th {
            position: sticky;
            top: 0;
            z-index: 2;
            background: #eef4ff;
            color: #111a5b;
            padding: 16px 18px;
            font-size: 14px;
            font-weight: 800;
            white-space: nowrap;
            border-bottom: 1px solid #dfe5f1;
        }

        .custom-tracking-table tbody td {
            padding: 16px 18px;
            color: #111a5b;
            font-size: 14px;
            font-weight: 650;
            white-space: nowrap;
            border-bottom: 1px solid #edf1f7;
        }

        .custom-tracking-table tbody tr:hover {
            background: #f7f9ff;
        }

        .view-btn {
            padding: 8px 15px;
            border-radius: 10px;
            background: #111a5b;
            color: white !important;
            text-decoration: none;
            font-weight: 800;
            font-size: 13px;
        }

        .no-data {
            text-align: center;
            color: #8a8a8a !important;
            padding: 35px !important;
        }

        .pagination-box {
            padding: 18px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        @media(max-width: 992px) {
            .stats-grid,
            .filter-section {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media(max-width: 576px) {
            .stats-grid,
            .filter-section {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="tracking-container">

        <div class="tracking-header">
            <h2 class="page-title">Product Holding Tracking</h2>
            <p class="page-subtitle">Track batch-wise stock, state, inventory and role pricing</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Total Batches</div>
                <div class="stat-value">{{ number_format($totalRecords) }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Total Box Qty</div>
                <div class="stat-value">{{ number_format($totalBoxQty) }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Total PCS Qty</div>
                <div class="stat-value">{{ number_format($totalPcsQty) }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Product Holding</div>
                <div class="stat-value">{{ number_format($totalProductHolding) }}</div>
            </div>
        </div>

        <div class="filter-card">
            <div class="filter-section">
                <div class="filter-box">
                    <label>Search Batch / State</label>
                    <input type="text" wire:model.live.debounce.400ms="search" placeholder="Search here...">
                </div>

                <div class="filter-box">
                    <label>Batch No</label>
                    <select wire:model.live="batchFilter">
                        <option value="">All Batches</option>
                        @foreach($batchList as $batch)
                            <option value="{{ $batch }}">{{ $batch }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-box">
                    <label>State</label>
                    <select wire:model.live="stateFilter">
                        <option value="">All States</option>
                        @foreach($stateList as $state)
                            <option value="{{ $state }}">{{ $state }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-box">
                    <label>Per Page</label>
                    <select wire:model.live="perPage">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                    </select>
                </div>

                <div class="filter-box">
                    <button type="button" class="reset-btn" wire:click="resetFilters">
                        Reset
                    </button>
                </div>
            </div>
        </div>

        <div class="table-card">
            <div class="table-wrapper">
                <table class="custom-tracking-table">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Batch No</th>
                            <th>Box Qty</th>
                            <th>PCS Qty</th>
                            <th>Total PCS</th>
                            <th>Inventory</th>
                            <th>State</th>
                            <th>CNDF Price</th>
                            <th>Distributor Price</th>
                            <th>Dealer Price</th>
                            <th>Sub Dealer Price</th>
                            <th>Retailer Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($tableData as $index => $row)
                            <tr>
                                <td>{{ $tableData->firstItem() + $index }}</td>
                                <td>{{ $row->batchno ?? 'N/A' }}</td>
                                <td>{{ $row->boxqty ?? 0 }}</td>
                                <td>{{ $row->pcsqty ?? 0 }}</td>
                                <td>{{ $row->totalqty ?? 0 }}</td>
                                <td>{{ $row->inventoryqty ?? 0 }}</td>
                                <td>{{ $row->state ?? 'N/A' }}</td>
                                <td>{{ $row->pricecndf ?? 0 }}</td>
                                <td>{{ $row->pricedistributor ?? 0 }}</td>
                                <td>{{ $row->pricedealer ?? 0 }}</td>
                                <td>{{ $row->pricesubdealer ?? 0 }}</td>
                                <td>{{ $row->priceretialer ?? 0 }}</td>
                                <td>
                                    <a href="{{ route('BatchRole', $row->id) }}" class="view-btn">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="13" class="no-data">No tracking data found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-box">
                <div>
                    Showing {{ $tableData->firstItem() ?? 0 }}
                    to {{ $tableData->lastItem() ?? 0 }}
                    of {{ $tableData->total() }} records
                </div>

                <div>
                    {{ $tableData->links() }}
                </div>
            </div>
        </div>

    </div>
</div>