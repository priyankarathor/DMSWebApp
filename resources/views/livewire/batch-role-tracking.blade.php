<div class="tracking-page">
    <style>
        .tracking-page {
            background: linear-gradient(180deg, #f6f8fc 0%, #eef3fb 100%);
            min-height: 100vh;
            padding: 30px 20px;
        }

        .tracking-container {
            max-width: 1450px;
            margin: auto;
        }

        .tracking-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .page-title {
            font-size: 30px;
            font-weight: 800;
            color: #111a5b;
            margin: 0;
        }

        .page-subtitle {
            color: #6f7aa8;
            margin-top: 8px;
        }

        .top-badge {
            background: white;
            border: 1px solid #e8edf7;
            border-radius: 14px;
            padding: 12px 16px;
            font-weight: 700;
            color: #111a5b;
        }

        .filter-card,
        .stats-card-wrap,
        .table-card {
            background: white;
            border-radius: 22px;
            border: 1px solid #edf1f7;
            box-shadow: 0 10px 30px rgba(18, 38, 63, 0.08);
            margin-bottom: 24px;
        }

        .filter-card {
            padding: 22px;
        }

        .filter-section {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr auto;
            gap: 18px;
            align-items: end;
        }

        .filter-box {
            display: flex;
            flex-direction: column;
        }

        .filter-box label {
            font-size: 14px;
            font-weight: 700;
            color: #6d76a8;
            margin-bottom: 8px;
        }

        .filter-box select {
            height: 50px;
            border: 1px solid #dfe5f1;
            border-radius: 14px;
            padding: 0 14px;
            font-size: 15px;
            color: #10185c;
            outline: none;
        }

        .btn-group {
            display: flex;
            gap: 10px;
        }

        .btn-primary,
        .btn-secondary,
        .btn-success {
            height: 50px;
            border-radius: 14px;
            padding: 0 18px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            white-space: nowrap;
        }

        .btn-primary {
            background: #111a5b;
            color: white;
        }

        .btn-secondary {
            background: #eef3ff;
            color: #111a5b;
            border: 1px solid #dde6ff;
        }

        .btn-success {
            background: #0f8f68;
            color: white;
        }

        .stats-card-wrap {
            padding: 20px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
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
            font-weight: 700;
        }

        .stat-value {
            color: #10185c;
            font-size: 30px;
            font-weight: 800;
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
            font-weight: 800;
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
            max-height: 500px;
            border: 1px solid #edf1f7;
            border-radius: 18px;
        }

        .custom-tracking-table {
            width: 100%;
            min-width: 1100px;
            border-collapse: separate;
            border-spacing: 0;
        }

        .custom-tracking-table thead th {
            position: sticky;
            top: 0;
            background: #cfe6dd;
            z-index: 2;
            padding: 18px 20px;
            color: #5f6996;
            font-size: 15px;
            font-weight: 800;
            text-align: left;
            white-space: nowrap;
        }

        .custom-tracking-table tbody tr:nth-child(odd) {
            background: #f8f9fd;
        }

        .custom-tracking-table tbody tr:nth-child(even) {
            background: white;
        }

        .custom-tracking-table tbody td {
            padding: 18px 20px;
            color: #111a5b;
            font-size: 15px;
            font-weight: 700;
            border-bottom: 1px solid #edf1f7;
            white-space: nowrap;
        }

        .role-badge {
            display: inline-block;
            min-width: 100px;
            text-align: center;
            padding: 9px 14px;
            border-radius: 30px;
            background: #edf2ff;
            color: #111a5b;
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .number-pill {
            display: inline-block;
            background: #f3f5fb;
            padding: 8px 12px;
            border-radius: 12px;
            font-weight: 800;
            min-width: 60px;
            text-align: center;
        }

        .no-data {
            text-align: center;
            color: #8b93b7;
            padding: 30px !important;
            font-weight: 700;
        }

        @media (max-width: 1200px) {
            .filter-section {
                grid-template-columns: 1fr 1fr;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .filter-section,
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .btn-group {
                width: 100%;
                flex-wrap: wrap;
            }

            .btn-primary,
            .btn-secondary,
            .btn-success {
                flex: 1;
            }
        }
    </style>

    <div class="tracking-container">

        <div class="tracking-header">
            <div>
                <h2 class="page-title">Batch Role Tracking</h2>
                <p class="page-subtitle">
                    Junction table ke according unique user stock tracking with state, role and CSV download.
                </p>
            </div>

            <div class="top-badge">
                Batch: <strong>{{ $selectedBatchNo ?: 'All' }}</strong> |
                State: <strong>{{ $selectedState ?: 'All' }}</strong> |
                Role: <strong>{{ $selectedRole ?: 'All' }}</strong>
            </div>
        </div>

        <div class="filter-card">
            <div class="filter-section">

                <div class="filter-box">
                    <label>Batch No</label>
                    <select wire:model.live="selectedBatchNo">
                        <option value="">All Batches</option>
                        @foreach($batches as $batch)
                            <option value="{{ $batch }}">{{ $batch }}</option>
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

                <div class="btn-group">
                    <button type="button" class="btn-secondary" wire:click="resetFilters">
                        Reset
                    </button>

                    <button type="button" class="btn-success" wire:click="downloadCsv">
                        Download CSV
                    </button>
                </div>

            </div>
        </div>

        <div class="stats-card-wrap">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-label">Total Users</div>
                    <div class="stat-value">{{ $this->totalUsers }}</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">Total PCS Qty</div>
                    <div class="stat-value">{{ $this->totalPcs }}</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">Grand Total PCS</div>
                    <div class="stat-value">{{ $this->grandTotalPcs }}</div>
                </div>
            </div>
        </div>

        <div class="table-card">
            <div class="table-head">
                <div>
                    <h3 class="section-title">Role Wise Summary</h3>
                    <div class="table-subtext">Filtered role-wise total users and quantity.</div>
                </div>
            </div>

            <div class="table-wrapper">
                <table class="custom-tracking-table">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Role</th>
                            <th>Total Users</th>
                            <th>Stock PCS  Qty</th>
                            <th>Total PCS</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($rows as $index => $row)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><span class="role-badge">{{ $row['role'] }}</span></td>
                                <td><span class="number-pill">{{ $row['users'] }}</span></td>
                                
                                <td>{{ $row['pcs_qty'] }}</td>
                                <td>{{ $row['total_pcs'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="no-data">No summary data found.</td>
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
                    <div class="table-subtext">Duplicate orderapprovedtable data removed. Data comes according to productjunction.</div>
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
                            <th>Stock holder</th>
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
                                <td>{{ $detail['pcs_qty'] }}</td>
                               <td> <a href="{{ route('stockholder', $detail['user_id'] ) }}" class="btn btn-sm btn-primary">
                                        Stock Holder
                                    </a> <td>
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