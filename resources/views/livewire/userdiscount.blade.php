<div>
    <style>
        .discount-wrapper {
            padding: 20px;
        }

        .discount-card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            background: #fff;
        }

        .discount-card-header {
            background: linear-gradient(135deg, #0F172A, #0F172A);
            color: #fff;
            padding: 16px 22px;
        }

        .discount-card-header h4 {
            margin: 0;
            font-size: 20px;
            font-weight: 600;
        }

        .discount-card-body {
            padding: 24px;
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 7px;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            padding: 10px 12px;
            border: 1px solid #d9d9d9;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #0F172A;
            box-shadow: 0 0 0 0.15rem rgba(25, 135, 84, 0.15);
        }

        .btn-main {
            background: #0F172A;
            color: #fff;
            border-radius: 8px;
            padding: 10px 22px;
            border: none;
            font-weight: 600;
        }

        .btn-main:hover {
            background: #0F172A;
            color: #fff;
        }

        .table-card {
            margin-top: 28px;
            border: none;
            border-radius: 14px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            background: #fff;
        }

        .table-card-header {
            padding: 16px 22px;
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-card-header h5 {
            margin: 0;
            color: #198754;
            font-weight: 700;
        }

        .custom-table {
            margin-bottom: 0;
            vertical-align: middle;
        }

        .custom-table thead {
            background: #0F172A;
            color: #fff;
        }

        .custom-table thead th {
            font-size: 14px;
            white-space: nowrap;
            padding: 13px; 
        }

        .custom-table tbody td {
            padding: 12px;
            font-size: 14px;
            white-space: nowrap;
        }

        .badge-role {
            background: #d1e7dd;
            color: #0F172A;
            padding: 6px 10px;
            border-radius: 20px;
            font-weight: 600;
        }

        .badge-user {
            background: #fff3cd;
            color: #664d03;
            padding: 6px 10px;
            border-radius: 20px;
            font-weight: 600;
        }

        .discount-rate {
            font-weight: 700;
            color: #198754;
        }

        .btn-edit {
            border: 1px solid #198754;
            color: #198754;
            background: #fff;
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 13px;
        }

        .btn-edit:hover {
            background: #0F172A;
            color: #fff;
        }

        .btn-delete {
            border: 1px solid #dc3545;
            color: #dc3545;
            background: #fff;
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 13px;
        }

        .btn-delete:hover {
            background: #dc3545;
            color: #fff;
        }

        .empty-box {
            padding: 30px;
            text-align: center;
            color: #888;
            font-weight: 600;
        }

        .alert {
            border-radius: 10px;
        }

        .pagination-wrapper {
            padding: 16px 20px;
            border-top: 1px solid #e9ecef;
            background: #fff;
            display: flex;
            justify-content: flex-end;
        }

        .pagination {
            margin-bottom: 0;
        }

        .page-link {
            color: #0F172A;
        }

        .page-item.active .page-link {
            background-color: #0F172A;
            border-color: #0F172A;
            color: #fff;
        }

        .edit-modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.55);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .edit-modal-card {
            width: 100%;
            max-width: 850px;
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 35px rgba(0, 0, 0, 0.25);
        }

        .edit-modal-header {
            background: linear-gradient(135deg, #0F172A, #0F172A);
            color: white;
            padding: 16px 22px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .edit-modal-header h5 {
            margin: 0;
            font-weight: 700;
        }

        .edit-close {
            background: transparent;
            border: none;
            color: #fff;
            font-size: 28px;
            line-height: 1;
            cursor: pointer;
        }

        .edit-modal-body {
            padding: 24px;
            max-height: 70vh;
            overflow-y: auto;
        }

        .edit-modal-footer {
            padding: 16px 24px;
            border-top: 1px solid #e9ecef;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        @media (max-width: 768px) {
            .table-card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .pagination-wrapper {
                justify-content: center;
            }
        }
    </style>

    <div class="discount-wrapper">

        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Add Discount Form --}}
        <div class="discount-card">
            <div class="discount-card-header">
                <h4 style="color: #d1e7dd;">Add Discount</h4>
            </div>

            <div class="discount-card-body">
                <form wire:submit.prevent="discount">
                    <div class="row">

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Discount Apply On</label>
                            <select class="form-select" wire:model.live="discount_type">
                                <option value="role">Whole Role</option>
                                <option value="user">Only One User</option>
                            </select>
                            @error('discount_type')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Role</label>
                            <select class="form-select" wire:model.live="role_id">
                                <option value="">--------- Select Role ---------</option>
                                @foreach ($tab as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->role }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        @if ($discount_type === 'user')
                            <div class="mb-3 col-md-6">
                                <label class="form-label">State</label>
                                <select class="form-select" wire:model.live="state">
                                    <option value="">--------- Select State ---------</option>
                                    @foreach ($states as $item)
                                        <option value="{{ $item->state }}">
                                            {{ $item->state }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('state')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">User</label>
                                <select class="form-select" wire:model="user_id">
                                    <option value="">--------- Select User ---------</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">
                                            {{ $user->username }}
                                            -
                                            {{ $user->registerid }}
                                            -
                                            {{ $user->email }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        @endif

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Discount Rate (%)</label>
                            <input 
                                class="form-control" 
                                type="number" 
                                step="0.01" 
                                min="0"
                                max="100"
                                wire:model="rate"
                                placeholder="Enter discount rate"
                            >
                            @error('rate')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-12 mt-3">
                            <button type="submit" class="btn-main">
                                Submit Discount
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        {{-- Discount List --}}
        <div class="table-card">
            <div class="table-card-header">
                <h5>Discount List</h5>
                <span>Total: {{ $disocunt->total() }}</span>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table custom-table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Discount Type</th>
                                <th>Role</th>
                                <th>State</th>
                                <th>Username</th>
                                <th>Register ID</th>
                                <th>Email</th>
                                <th>Discount</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($disocunt as $index => $item)
                                <tr>
                                    <td>{{ $disocunt->firstItem() + $index }}</td>

                                    <td>
                                        @if ($item->discount === 'role')
                                            <span class="badge-role">Whole Role</span>
                                        @else
                                            <span class="badge-user">Single User</span>
                                        @endif
                                    </td>

                                    <td>
                                        @php
                                            $roleName = $tab->where('id', $item->role)->first();
                                        @endphp

                                        {{ $roleName->role ?? 'N/A' }}
                                    </td>

                                    <td>{{ $item->state ?? '-' }}</td>
                                    <td>{{ $item->username ?? '-' }}</td>
                                    <td>{{ $item->registerid ?? '-' }}</td>
                                    <td>{{ $item->email ?? '-' }}</td>

                                    <td>
                                        <span class="discount-rate">
                                            {{ $item->rate }}%
                                        </span>
                                    </td>

                                    <td>
                                        <button 
                                            type="button"
                                            wire:click="editDiscount({{ $item->id }})"
                                            class="btn-edit">
                                            Edit
                                        </button>

                                        <button 
                                            type="button"
                                            wire:click="deletediscountdata({{ $item->id }})"
                                            onclick="return confirm('Are you sure you want to delete this discount?')"
                                            class="btn-delete ms-1">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9">
                                        <div class="empty-box">
                                            No discount data found.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

                @if ($disocunt->hasPages())
                    <div class="pagination-wrapper">
                        {{ $disocunt->links() }}
                    </div>
                @endif
            </div>
        </div>

    </div>

    {{-- Edit Popup Card --}}
    @if ($isEdit)
        <div class="edit-modal-backdrop" wire:key="edit-discount-modal">
            <div class="edit-modal-card">

                <div class="edit-modal-header">
                    <h5>Edit Discount</h5>

                    <button 
                        type="button"
                        class="edit-close"
                        wire:click="cancelEdit">
                        &times;
                    </button>
                </div>

                <form wire:submit.prevent="discount">
                    <div class="edit-modal-body">
                        <div class="row">

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Discount Apply On</label>
                                <select class="form-select" wire:model.live="discount_type">
                                    <option value="role">Whole Role</option>
                                    <option value="user">Only One User</option>
                                </select>
                                @error('discount_type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Role</label>
                                <select class="form-select" wire:model.live="role_id">
                                    <option value="">--------- Select Role ---------</option>
                                    @foreach ($tab as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->role }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            @if ($discount_type === 'user')
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">State</label>
                                    <select class="form-select" wire:model.live="state">
                                        <option value="">--------- Select State ---------</option>
                                        @foreach ($states as $item)
                                            <option value="{{ $item->state }}">
                                                {{ $item->state }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('state')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label">User</label>
                                    <select class="form-select" wire:model="user_id">
                                        <option value="">--------- Select User ---------</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">
                                                {{ $user->username }}
                                                -
                                                {{ $user->registerid }}
                                                -
                                                {{ $user->email }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            @endif

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Discount Rate (%)</label>
                                <input 
                                    class="form-control" 
                                    type="number" 
                                    step="0.01" 
                                    min="0"
                                    max="100"
                                    wire:model="rate"
                                    placeholder="Enter discount rate"
                                >
                                @error('rate')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <div class="edit-modal-footer">
                        <button 
                            type="button"
                            class="btn btn-secondary"
                            wire:click="cancelEdit">
                            Cancel
                        </button>

                        <button 
                            type="submit"
                            class="btn btn-success">
                            Update Discount
                        </button>
                    </div>
                </form>

            </div>
        </div>
    @endif

</div>