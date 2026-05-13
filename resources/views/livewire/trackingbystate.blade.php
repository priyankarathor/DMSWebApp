<div class="tracking-page">

    <style>
    .tracking-page {
        background: #f6f8fc;
        min-height: 100vh;
        padding: 30px 20px;
    }

    .tracking-container {
        width: 100%;
        max-width: 1450px;
        margin: 0 auto;
    }

    .tracking-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .page-title {
        font-size: 30px;
        font-weight: 700;
        color: #111a5b;
        margin: 0;
    }

    .page-subtitle {
        margin: 6px 0 0;
        color: #7b84b2;
        font-size: 15px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
        margin-bottom: 25px;
    }

    .stat-card {
        background: #ffffff;
        border-radius: 18px;
        padding: 22px;
        box-shadow: 0 8px 24px rgba(18, 38, 63, 0.08);
        border: 1px solid #edf1f7;
    }

    .stat-label {
        color: #7a84b0;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .stat-value {
        color: #10185c;
        font-size: 30px;
        font-weight: 800;
    }

    .filter-section {
        display: grid;
        grid-template-columns: 1.2fr 1fr 1fr 0.8fr;
        gap: 18px;
        margin-bottom: 25px;
        align-items: end;
    }

    .filter-box {
        display: flex;
        flex-direction: column;
    }

    .filter-box label {
        font-size: 14px;
        font-weight: 600;
        color: #6d76a8;
        margin-bottom: 8px;
    }

    .filter-box input,
    .filter-box select {
        height: 48px;
        border: 1px solid #dfe5f1;
        border-radius: 12px;
        padding: 0 14px;
        font-size: 15px;
        color: #10185c;
        background: #fff;
        outline: none;
    }

    .filter-box input:focus,
    .filter-box select:focus {
        border-color: #9dcfc2;
        box-shadow: 0 0 0 3px rgba(157, 207, 194, 0.18);
    }

    .btn-box button {
        height: 48px;
        border: none;
        border-radius: 12px;
        background: #111a5b;
        color: white;
        font-weight: 700;
        font-size: 15px;
        cursor: pointer;
    }

    /* ✅ SCROLL FIX HERE */
    .table-wrapper {
        background: #fff;
        border-radius: 18px;
        overflow-x: auto;  /* horizontal scroll */
        overflow-y: auto;  /* vertical scroll */
        max-height: 500px;
        box-shadow: 0 8px 24px rgba(18, 38, 63, 0.08);
        border: 1px solid #edf1f7;
    }

    .custom-tracking-table {
        width: 100%;
        min-width: 1200px; /* force horizontal scroll */
        border-collapse: collapse;
    }

    /* Sticky Header */
    .custom-tracking-table thead th {
        position: sticky;
        top: 0;
        background: #cfe6dd;
        z-index: 2;
        text-align: left;
        padding: 22px 36px;
        color: #7d84b6;
        font-size: 17px;
        font-weight: 600;
        white-space: nowrap;
    }

    .custom-tracking-table tbody tr:nth-child(odd) {
        background: #f3f3f7;
    }

    .custom-tracking-table tbody tr:nth-child(even) {
        background: #ffffff;
    }

    .custom-tracking-table tbody td {
        padding: 26px 36px;
        color: #111a5b;
        font-size: 18px;
        font-weight: 700;
        white-space: nowrap;
    }

    .no-data {
        text-align: center;
        color: #999;
        padding: 30px !important;
    }

    /* Scrollbar styling */
    .table-wrapper::-webkit-scrollbar {
        height: 8px;
        width: 8px;
    }

    .table-wrapper::-webkit-scrollbar-thumb {
        background: #9dcfc2;
        border-radius: 10px;
    }

    </style>

    <div class="tracking-container">

        {{-- Header --}}
        <div class="tracking-header">
            <div>
                <h2 class="page-title">Product Holding Tracking</h2>
                <p class="page-subtitle">Track stock details batch-wise with qty and pricing</p>
            </div>
        </div>

        {{-- Stats --}}
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Total Batches</div>
                <div class="stat-value">{{ $this->totalRecords }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Total Box Qty</div>
                <div class="stat-value">{{ $this->totalBoxQty }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Total PCS Qty</div>
                <div class="stat-value">{{ $this->totalPcsQty }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Product Holding</div>
                <div class="stat-value">{{ $this->totalProductHolding }}</div>
            </div>
        </div>

        {{-- Filters --}}
        <div class="filter-section">
            <div class="filter-box">
                <label>Search</label>
                <input type="text" wire:model.live="search">
            </div>

            <div class="filter-box">
                <label>Batch</label>
                <select wire:model.live="batchFilter">
                    <option value="">All</option>
                    @foreach($batchList as $batch)
                        <option value="{{ $batch }}">{{ $batch }}</option>
                    @endforeach
                </select>
            </div>

            <div class="filter-box">
                <label>State</label>
                <select wire:model.live="stateFilter">
                    <option value="">All</option>
                    @foreach($stateList as $state)
                        <option value="{{ $state }}">{{ $state }}</option>
                    @endforeach
                </select>
            </div>

            <div class="filter-box btn-box">
                <button type="button"
                    wire:click="$set('search',''); $set('batchFilter',''); $set('stateFilter','')">
                    Reset
                </button>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="table-wrapper">
            <table class="custom-tracking-table">
                <thead>
                    <tr>
                        <th>Sr No.</th>
                        <th>Batch No</th>
                        <th>Box Qty</th>
                        <th>PCS Qty</th>
                        <th>Total Pcs</th>
                        <th>Inventory</th>
                        <th>State</th>
                        <th>CNDF Price</th>
                        <th>Distributor Price</th>
                        <th>Dealer Price</th>
                        <th>SubDealer Price</th>
                        <th>Retailer Price</th>
                        <th>Action</th> {{-- ✅ FIXED --}}
                    </tr>
                </thead>

                <tbody>
                    @forelse($tableData as $index => $row)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $row['batch_no'] }}</td>
                            <td>{{ $row['box_qty'] }}</td>
                            <td>{{ $row['pcs_qty'] }}</td>
                            <td>{{ $row['total_pcs'] }}</td>
                               <td>{{ $row['inventoryqty']}}</td>
                            <td>{{ $row['state'] }}</td>
                           <td>{{ $row['pricecndf'] }}</td>
                        <td>{{ $row['pricedistributor'] }}</td>
                        <td>{{ $row['pricedealer'] }}</td>
                        <td>{{ $row['pricesubdealer'] }}</td>
                        <td>{{ $row['priceretialer'] }}</td>
                            <td>
                                <a href="{{ route('BatchRole', $row['id']) }}" style="color:#111a5b;">
    View
</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="no-data">No data found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>