<div>
    <div class="container mt-4">
        @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h4 class="mb-0 fw-bold text-success">Godown & Inventory Management</h4>
                </div>
            </div>
            <div class="card-body p-4">
                <!-- Nav Tabs -->
                <ul class="nav nav-tabs mb-4" id="godownTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $activeTab === 'godowns' ? 'active' : '' }}"
                            wire:click="setTab('godowns')" type="button" role="tab">
                            <i class="bi bi-building me-2"></i>Godown Management
                        </button>
                    </li>
                    <!-- <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $activeTab === 'inventory' ? 'active' : '' }}"
                            wire:click="setTab('inventory')" type="button" role="tab">
                            <i class="bi bi-box-seam me-2"></i>Product Inventory
                        </button>
                    </li> -->
                </ul>

                <!-- Tab Content -->
                <div class="tab-content">

                    <!-- Godown Management Tab -->
                    @if($activeTab === 'godowns')
                        <div class="tab-pane fade show active">
                            <div class="d-flex justify-content-end mb-3">
                                <button class="btn btn-success rounded-pill px-4" data-bs-toggle="modal"
                                    data-bs-target="#addGodownModal">
                                    <i class="bi bi-plus-circle me-1"></i> Add Godown Entry
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle table-hover">
                                    <thead class="table-success">
                                        <tr>
                                            <th>ID</th>
                                            <th>Product Name</th>
                                            <th>Location ID</th>
                                            <th>Retailer Name</th>
                                            <th>Added On</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($godowns as $godown)
                                            <tr>
                                                <td>{{ $godown->id }}</td>
                                                <td>{{ $godown->product->productname ?? 'N/A' }}</td>
                                                <td>{{ App\Models\location::where('id', $godown->locationid)->first()->location_name ?? 'N/A' }}
                                                </td>
                                                <td>{{ $godown->retailer_name }}</td>
                                                <td>{{ $godown->created_at->format('d M Y') }}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-outline-danger"
                                                        wire:click="deleteGodown({{ $godown->id }})"
                                                        onclick="return confirm('Are you sure you want to delete this Godown entry?')">
                                                        <i class="bi bi-trash"></i> Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-4">No Godown entries found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                {{ $godowns->links() }}
                            </div>
                        </div>
                    @endif

                    <!-- Product Inventory Tab -->
                    @if($activeTab === 'inventory')
                        <div class="tab-pane fade show active">

                            <div class="row g-3 mb-4">
                                <div class="col-md-5">
                                    <label class="form-label fw-bold text-secondary">Search Product</label>
                                    <input type="text" class="form-control" wire:model.live.debounce.500ms="searchProduct"
                                        placeholder="Product name or ID...">
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label fw-bold text-secondary">Search Batch No</label>
                                    <input type="text" class="form-control" wire:model.live.debounce.500ms="searchBatch"
                                        placeholder="Batch No...">
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle table-hover">
                                    <thead class="table-success text-nowrap">
                                        <tr>
                                            <th>Prod ID</th>
                                            <th>Product Name</th>
                                            <th>Category</th>
                                            <th>Batch No</th>
                                            <th>Box Qty</th>
                                            <th>PCS Qty</th>
                                            <th>Total Qty</th>
                                            <th>Inventory</th>
                                            <th>State</th>
                                            <th>CNDF</th>
                                            <th>Distributor</th>
                                            <th>Dealer</th>
                                            <th>Sub Dealer</th>
                                            <th>Retailer Price</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-nowrap">
                                        @forelse($inventory as $row)
                                            <tr>
                                                <td>{{ $row['product_id'] }}</td>
                                                <td class="fw-bold">{{ $row['product_name'] }}</td>
                                                <td>{{ $row['category'] }}</td>
                                                <td><span class="badge bg-secondary">{{ $row['batchno'] }}</span></td>
                                                <td>{{ $row['boxqty'] }}</td>
                                                <td>{{ $row['pcsqty'] }}</td>
                                                <td>{{ $row['totalqty'] }}</td>
                                                <td class="fw-bold text-primary">{{ $row['inventoryqty'] }}</td>
                                                <td>{{ $row['state'] }}</td>
                                                <td>₹{{ $row['pricecndf'] }}</td>
                                                <td>₹{{ $row['pricedistributor'] }}</td>
                                                <td>₹{{ $row['pricedealer'] }}</td>
                                                <td>₹{{ $row['pricesubdealer'] }}</td>
                                                <td class="text-success fw-bold">₹{{ $row['priceretialer'] }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="14" class="text-center text-muted py-4">No inventory matching the
                                                    filters.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                {{ $inventory->links() }}
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- Add Godown Modal -->
    <div wire:ignore.self class="modal fade" id="addGodownModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header bg-success text-white rounded-top-4">
                    <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle me-2"></i>Add Godown Entry</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <form wire:submit.prevent="addGodown">
                    <div class="modal-body p-4">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Product <span class="text-danger">*</span></label>
                            <select wire:model="godownProductId" class="form-select">
                                <option value="">Select a Product</option>
                                @foreach($allProducts as $prod)
                                    <option value="{{ $prod->id }}">{{ $prod->productname }} (ID: {{ $prod->id }})</option>
                                @endforeach
                            </select>
                            @error('godownProductId') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Location / Godown ID <span
                                    class="text-danger">*</span></label>
                            <select wire:model="godownLocation" class="form-select">
                                <option value="">Select a Location</option>
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}">{{ $location->location_name }}
                                        (ID: {{ $location->id }})</option>
                                @endforeach
                            </select>
                            @error('godownLocation') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Retailer Name (External) <span
                                    class="text-danger">*</span></label>
                            <input type="text" wire:model="godownRetailer" class="form-control"
                                placeholder="e.g. Acme Supplies Ltd">
                            @error('godownRetailer') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                    </div>

                    <div class="modal-footer bg-light rounded-bottom-4">
                        <button type="button" class="btn btn-outline-secondary px-4 rounded-pill"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success px-4 rounded-pill">
                            <span wire:loading.remove wire:target="addGodown">Save Entry</span>
                            <span wire:loading wire:target="addGodown">Saving...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts to handle modal -->
    <script>
        document.addEventListener('livewire:init', function () {
            Livewire.on('close-add-godown-modal', function () {
                const modalElement = document.getElementById('addGodownModal');
                const modal = bootstrap.Modal.getInstance(modalElement);
                if (modal) {
                    modal.hide();
                }
            });
        });
    </script>
</div>