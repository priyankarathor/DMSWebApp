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
            background: linear-gradient(135deg, #111a5b, #243b8f);
            color: white;
            border-radius: 24px;
            padding: 28px 30px;
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            gap: 18px;
            align-items: center;
            flex-wrap: wrap;
            box-shadow: 0 14px 35px rgba(17, 26, 91, 0.22);
        }

        .page-title {
            margin: 0;
            font-size: 30px;
            font-weight: 900;
        }

        .page-subtitle {
            margin: 8px 0 0;
            color: #dce4ff;
            font-size: 15px;
        }

        .top-badge {
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.22);
            border-radius: 16px;
            padding: 14px 18px;
            font-weight: 800;
            color: white;
        }

        .filter-card,
        .stats-card-wrap,
        .table-card {
            background: white;
            border-radius: 22px;
            border: 1px solid #edf1f7;
            box-shadow: 0 8px 28px rgba(18, 38, 63, 0.08);
            margin-bottom: 24px;
        }

        .filter-card {
            padding: 22px;
        }

        .filter-section {
            display: grid;
            grid-template-columns: 1.3fr 1fr 1fr 1fr auto;
            gap: 16px;
            align-items: end;
        }

        .filter-box label {
            font-size: 13px;
            font-weight: 800;
            color: #657199;
            margin-bottom: 8px;
            display: block;
        }

        .filter-box input,
        .filter-box select {
            width: 100%;
            height: 48px;
            border: 1px solid #dfe5f1;
            border-radius: 14px;
            padding: 0 14px;
            font-size: 14px;
            color: #111a5b;
            background: #fff;
            outline: none;
        }

        .filter-box input:focus,
        .filter-box select:focus {
            border-color: #111a5b;
            box-shadow: 0 0 0 3px rgba(17, 26, 91, 0.10);
        }

        .btn-group-custom {
            display: flex;
            gap: 10px;
        }

        .btn-reset,
        .btn-download {
            height: 48px;
            border-radius: 14px;
            padding: 0 18px;
            font-weight: 800;
            border: none;
            cursor: pointer;
            white-space: nowrap;
        }

        .btn-reset {
            background: #eef3ff;
            color: #111a5b;
            border: 1px solid #dce5ff;
        }

        .btn-download {
            background: #0f8f68;
            color: white;
        }

        .stats-card-wrap {
            padding: 20px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }

        .stat-card {
            background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
            border-radius: 18px;
            padding: 22px;
            border: 1px solid #edf1f7;
        }

        .stat-label {
            color: #7781b2;
            font-size: 14px;
            font-weight: 800;
        }

        .stat-value {
            color: #111a5b;
            font-size: 32px;
            font-weight: 900;
            margin-top: 10px;
        }

        .table-card {
            padding: 18px;
        }

        .table-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            gap: 12px;
            flex-wrap: wrap;
        }

        .section-title {
            font-size: 22px;
            font-weight: 900;
            color: #111a5b;
            margin: 0;
        }

        .table-subtext {
            color: #7b84b2;
            font-size: 14px;
            font-weight: 600;
            margin-top: 5px;
        }

        .table-wrapper {
            overflow: auto;
            max-height: 520px;
            border: 1px solid #edf1f7;
            border-radius: 18px;
        }

        .custom-tracking-table {
            width: 100%;
            min-width: 1100px;
            border-collapse: collapse;
        }

        .custom-tracking-table thead th {
            position: sticky;
            top: 0;
            background: #eef4ff;
            z-index: 2;
            padding: 16px 18px;
            color: #111a5b;
            font-size: 14px;
            font-weight: 900;
            text-align: left;
            white-space: nowrap;
            border-bottom: 1px solid #dfe5f1;
        }

        .custom-tracking-table tbody td {
            padding: 16px 18px;
            color: #111a5b;
            font-size: 14px;
            font-weight: 700;
            border-bottom: 1px solid #edf1f7;
            white-space: nowrap;
        }

        .custom-tracking-table tbody tr:hover {
            background: #f8faff;
        }

        .role-badge {
            display: inline-block;
            min-width: 92px;
            text-align: center;
            padding: 8px 13px;
            border-radius: 30px;
            background: #edf2ff;
            color: #111a5b;
            font-size: 12px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .number-pill {
            display: inline-block;
            background: #f3f5fb;
            padding: 8px 12px;
            border-radius: 12px;
            font-weight: 900;
            min-width: 60px;
            text-align: center;
        }

        .stock-btn {
            display: inline-block;
            background: #111a5b;
            color: white !important;
            padding: 8px 13px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 800;
        }

        .no-data {
            text-align: center;
            color: #8b93b7 !important;
            padding: 34px !important;
            font-weight: 800;
        }

        @media (max-width: 1200px) {
            .filter-section {
                grid-template-columns: 1fr 1fr;
            }

            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {

            .filter-section,
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .btn-group-custom {
                width: 100%;
                flex-wrap: wrap;
            }

            .btn-reset,
            .btn-download {
                flex: 1;
            }
        }
    </style>

    <div class="tracking-container">

        <div class="tracking-header">
            <div>
                <h2 class="page-title" style="color: #dce4ff;">Batch Role Tracking</h2>
                <p class="page-subtitle">
                    Product-wise batch stock tracking with role, state and person-wise holding details.
                </p>
            </div>

            <div class="top-badge">
                Batch: {{ $selectedBatchNo ?: 'All' }} |
                State: {{ $selectedState ?: 'All' }} |
                Role: {{ $selectedRole ?: 'All' }}
            </div>
        </div>

        <div class="filter-card">
            <div class="filter-section">

                <div class="filter-box">
                    <label>Search</label>
                    <input type="text" wire:model.live.debounce.400ms="search"
                        placeholder="Search user, name, state, role, batch...">
                </div>

                <div class="filter-box">
                    <label>Batch No</label>
                    <select wire:model.live="selectedBatchNo">
                        <option value="">All Batches</option>
                        @foreach($batches as $batch)
                            <option value="{{ $batch->id }}">{{ $batch->batch_number }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-box">
                    <label>State</label>
                    <select wire:model.live="selectedState">
                        <option value="">All States</option>
                        @foreach($states as $state)
                            <option value="{{ $state }}">{{ $state }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-box">
                    <label>Role</label>
                    <select wire:model.live="selectedRole">
                        <option value="">All Roles</option>
                        @foreach($roles as $role)
                            <option value="{{ $role }}">{{ $role }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="btn-group-custom">
                    <button type="button" class="btn-reset" wire:click="resetFilters">
                        Reset
                    </button>

                    <button type="button" class="btn-download" wire:click="downloadCsv">
                        CSV
                    </button>
                </div>

            </div>
        </div>

        <div class="stats-card-wrap">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-label">Total Users</div>
                    <div class="stat-value">{{ number_format($this->totalUsers) }}</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">Total PCS Qty</div>
                    <div class="stat-value">{{ number_format($this->totalPcs) }}</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">Grand Total PCS</div>
                    <div class="stat-value">{{ number_format($this->grandTotalPcs) }}</div>
                </div>
            </div>
        </div>

        <div class="table-card">
            <div class="table-head">
                <div>
                    <h3 class="section-title">Role Wise Summary</h3>
                    <div class="table-subtext">Role-wise total users and stock quantity.</div>
                </div>
            </div>

            <div class="table-wrapper">
                <table class="custom-tracking-table">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Role</th>
                            <th>Total Users</th>
                            <th>Stock PCS Qty</th>
                            <th>Total PCS</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($rows as $index => $row)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><span class="role-badge">{{ $row['role'] }}</span></td>
                                <td><span class="number-pill">{{ $row['users'] }}</span></td>
                                <td>{{ number_format($row['pcs_qty']) }}</td>
                                <td>{{ number_format($row['total_pcs']) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="no-data">No summary data found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="table-card">
            <div class="table-head">
                <div>
                    <h3 class="section-title">Person Wise Detail</h3>
                    <div class="table-subtext">User-wise stock holding details from product junction.</div>
                </div>
            </div>

            <div class="table-wrapper">
                <table class="custom-tracking-table">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>User ID</th>
                            <th>Role</th>
                            <th>Person Name</th>
                            <th>State</th>
                            <th>Batch No</th>
                            <th>PCS Stock Qty</th>
                            <th>Total PCS</th>
                            <th>Stock Holder</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($detailRows as $index => $detail)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $detail['user_id'] }}</td>
                                <td><span class="role-badge">{{ $detail['role'] }}</span></td>
                                <td>{{ $detail['name'] }}</td>
                                <td>{{ $detail['state'] }}</td>
                                <td>{{ $detail['batchno'] }}</td>
                                <td>{{ number_format($detail['pcs_qty']) }}</td>
                                <td>{{ number_format($detail['total_pcs']) }}</td>
                                <td>
                                    <a href="{{ route('stockholder', $detail['user_id']) }}" class="stock-btn">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="no-data">No person-wise detail found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>