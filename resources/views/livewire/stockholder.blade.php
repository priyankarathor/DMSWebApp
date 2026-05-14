<div class="stock-page">
    <style>
        .stock-page {
            background: #f4f7fb;
            min-height: 100vh;
            padding: 28px 18px;
        }

        .stock-container {
            max-width: 1600px;
            margin: auto;
        }

        .stock-header {
            background: linear-gradient(135deg, #101a5b, #233d91);
            border-radius: 24px;
            padding: 28px;
            color: #fff;
            margin-bottom: 22px;
            box-shadow: 0 14px 35px rgba(16, 26, 91, 0.22);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .stock-title {
            font-size: 30px;
            font-weight: 900;
            margin: 0;
        }

        .stock-subtitle {
            margin: 8px 0 0;
            color: #dce5ff;
            font-size: 15px;
        }

        .seller-badge {
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.25);
            padding: 14px 18px;
            border-radius: 16px;
            font-weight: 800;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin-bottom: 22px;
        }

        .summary-card {
            background: #fff;
            border: 1px solid #edf1f7;
            border-radius: 22px;
            padding: 22px;
            box-shadow: 0 8px 26px rgba(18, 38, 63, 0.08);
        }

        .summary-label {
            color: #727da8;
            font-size: 14px;
            font-weight: 800;
        }

        .summary-value {
            color: #101a5b;
            font-size: 34px;
            font-weight: 900;
            margin-top: 8px;
        }

        .filter-card {
            background: #fff;
            border-radius: 22px;
            border: 1px solid #edf1f7;
            padding: 22px;
            margin-bottom: 22px;
            box-shadow: 0 8px 26px rgba(18, 38, 63, 0.08);
        }

        .filter-grid {
            display: grid;
            grid-template-columns: 1.4fr 1fr 1fr 1fr auto;
            gap: 14px;
            align-items: end;
        }

        .filter-box label {
            display: block;
            font-size: 13px;
            font-weight: 800;
            color: #657199;
            margin-bottom: 8px;
        }

        .filter-box input,
        .filter-box select {
            width: 100%;
            height: 48px;
            border: 1px solid #dfe5f1;
            border-radius: 14px;
            padding: 0 14px;
            color: #101a5b;
            outline: none;
            font-size: 14px;
            font-weight: 600;
        }

        .filter-box input:focus,
        .filter-box select:focus {
            border-color: #101a5b;
            box-shadow: 0 0 0 3px rgba(16, 26, 91, 0.10);
        }

        .reset-btn {
            height: 48px;
            border-radius: 14px;
            border: none;
            background: #eef3ff;
            color: #101a5b;
            font-weight: 900;
            padding: 0 22px;
            cursor: pointer;
        }

        .table-card {
            background: #fff;
            border-radius: 22px;
            border: 1px solid #edf1f7;
            padding: 18px;
            box-shadow: 0 8px 26px rgba(18, 38, 63, 0.08);
        }

        .table-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 16px;
        }

        .section-title {
            font-size: 22px;
            font-weight: 900;
            color: #101a5b;
            margin: 0;
        }

        .section-subtitle {
            font-size: 14px;
            color: #7a84ad;
            font-weight: 600;
            margin-top: 5px;
        }

        .table-wrapper {
            overflow: auto;
            border-radius: 18px;
            border: 1px solid #edf1f7;
            max-height: 620px;
        }

        .stock-table {
            width: 100%;
            min-width: 1650px;
            border-collapse: collapse;
        }

        .stock-table thead th {
            position: sticky;
            top: 0;
            z-index: 2;
            background: #eef4ff;
            color: #101a5b;
            padding: 15px 16px;
            font-size: 13px;
            font-weight: 900;
            white-space: nowrap;
            border-bottom: 1px solid #dfe5f1;
            text-align: left;
        }

        .stock-table tbody td {
            padding: 15px 16px;
            color: #101a5b;
            font-size: 14px;
            font-weight: 700;
            border-bottom: 1px solid #edf1f7;
            white-space: nowrap;
        }

        .stock-table tbody tr:hover {
            background: #f8fbff;
        }

        .role-badge {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 30px;
            background: #edf2ff;
            color: #101a5b;
            font-size: 12px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .inventory-pill {
            display: inline-block;
            min-width: 70px;
            text-align: center;
            padding: 8px 12px;
            border-radius: 12px;
            background: #0f8f68;
            color: #fff;
            font-weight: 900;
        }

        .id-pill {
            display: inline-block;
            padding: 7px 11px;
            border-radius: 10px;
            background: #f2f5fb;
            color: #101a5b;
            font-weight: 900;
        }

        .no-data {
            text-align: center;
            padding: 35px !important;
            color: #d62828 !important;
            font-size: 15px;
            font-weight: 900;
        }

        @media (max-width: 1200px) {
            .summary-grid {
                grid-template-columns: 1fr 1fr;
            }

            .filter-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .summary-grid,
            .filter-grid {
                grid-template-columns: 1fr;
            }

            .stock-title {
                font-size: 24px;
            }
        }
    </style>

    <div class="stock-container">

        <div class="stock-header">
            <div>
                <h2 class="stock-title" style="color: #dce5ff;">Stock Holder Details</h2>
                <p class="stock-subtitle">
                    Complete seller-wise stock holding report with user, role, state, product, batch and price details.
                </p>
            </div>

            <div class="seller-badge">
                Seller ID: {{ $sellerid }}
            </div>
        </div>

        <div class="summary-grid">
            <div class="summary-card">
                <div class="summary-label">Total Users</div>
                <div class="summary-value">{{ number_format($this->totalUsers) }}</div>
            </div>

            <div class="summary-card">
                <div class="summary-label">Total Products</div>
                <div class="summary-value">{{ number_format($this->totalProducts) }}</div>
            </div>

            <div class="summary-card">
                <div class="summary-label">Total Inventory</div>
                <div class="summary-value">{{ number_format($this->totalInventory) }}</div>
            </div>
        </div>

        <div class="filter-card">
            <div class="filter-grid">

                <div class="filter-box">
                    <label>Search</label>
                    <input type="text"
                           wire:model.live.debounce.400ms="search"
                           placeholder="Search user, role, state, product, batch...">
                </div>

                <div class="filter-box">
                    <label>State</label>
                    <select wire:model.live="selectedState">
                        <option value="">All States</option>
                        @foreach($this->states as $state)
                            <option value="{{ $state }}">{{ $state }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-box">
                    <label>Role</label>
                    <select wire:model.live="selectedRole">
                        <option value="">All Roles</option>
                        @foreach($this->roles as $role)
                            <option value="{{ $role }}">{{ $role }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-box">
                    <label>Product</label>
                    <select wire:model.live="selectedProduct">
                        <option value="">All Products</option>
                        @foreach($this->products as $product)
                            <option value="{{ $product }}">{{ $product }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="button" class="reset-btn" wire:click="resetFilters">
                    Reset
                </button>

            </div>
        </div>

        <div class="table-card">
            <div class="table-top">
                <div>
                    <h3 class="section-title">Stock Holder Report</h3>
                    <div class="section-subtitle">
                        Showing {{ count($stockData) }} records for Seller ID {{ $sellerid }}
                    </div>
                </div>
            </div>

            <div class="table-wrapper">
                <table class="stock-table">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Seller ID</th>
                            <th>User ID</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Role ID</th>
                            <th>Role Name</th>
                            <th>State</th>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>HSN Code</th>
                            <th>Inventory</th>
                            <th>Batch ID</th>
                            <th>Batch No</th>
                            <th>Batch Qty</th>
                            <th>Batch Inventory</th>
                            <th>Price ID</th>
                            <th>Price State</th>
                            <th>CNDF</th>
                            <th>Distributor</th>
                            <th>Dealer</th>
                            <th>Sub Dealer</th>
                            <th>Retailer</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($stockData as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><span class="id-pill">{{ $item['sellerid'] }}</span></td>
                                <td><span class="id-pill">{{ $item['uid'] }}</span></td>
                                <td>{{ $item['user_name'] }}</td>
                                <td>{{ $item['email'] }}</td>
                                <td>{{ $item['contact'] }}</td>
                                <td>{{ $item['role_id'] }}</td>
                                <td><span class="role-badge">{{ $item['role_name'] }}</span></td>
                                <td>{{ $item['state'] }}</td>
                                <td>{{ $item['product_id'] }}</td>
                                <td>{{ $item['product_name'] }}</td>
                                <td>{{ $item['category'] }}</td>
                                <td>{{ $item['hsn_code'] }}</td>
                                <td><span class="inventory-pill">{{ number_format($item['inventory']) }}</span></td>
                                <td>{{ $item['batch_id'] }}</td>
                                <td>{{ $item['batch_no'] }}</td>
                                <td>{{ $item['batch_qty'] }}</td>
                                <td>{{ $item['batch_inventory'] }}</td>
                                <td>{{ $item['price_id'] }}</td>
                                <td>{{ $item['price_state'] }}</td>
                                <td>{{ $item['cndf_price'] }}</td>
                                <td>{{ $item['distributor_price'] }}</td>
                                <td>{{ $item['dealer_price'] }}</td>
                                <td>{{ $item['subdealer_price'] }}</td>
                                <td>{{ $item['retailer_price'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="25" class="no-data">
                                    No stock data found for this seller.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>