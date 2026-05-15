<div>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            margin-left: 0px;
            height: 27px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #115e0f;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #115e0f;
        }

        input:checked+.slider:before {
            transform: translateX(22px);
        }

        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        .detail-card {
            border: 1px solid #e9ecef;
            border-radius: 14px;
            padding: 16px;
            background: #f8f9fa;
            height: 100%;
        }

        .section-title {
            color: #198754;
            font-weight: 700;
            margin-bottom: 14px;
        }

        .product-image {
            max-height: 320px;
            width: 100%;
            object-fit: cover;
            border-radius: 16px;
            border: 1px solid #ddd;
        }

        .table thead th {
            white-space: nowrap;
        }
    </style>

    <div class="container mt-4">

        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if($product)
            <div class="card shadow-sm border-0 rounded-4">

                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <h4 class="mb-0 fw-bold text-success">Product Full Details</h4>

                        <div class="d-flex gap-2 flex-wrap">
                            <a href="{{ url('/batchtracking/' . $product->id) }}" class="btn btn-outline-secondary rounded-pill px-4">
                                Batch No Tracking
                            </a>

                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary rounded-pill px-4">
                                Back
                            </a>

                            <a href="{{ url('/batchedit/' . $product->id) }}" class="btn btn-outline-success rounded-pill px-4">
                                Edit
                            </a>

                            <div class="d-flex gap-2 flex-wrap">

    <button type="button"
        class="btn btn-success rounded-pill px-4"
        wire:click="downloadFullProductCsv">
        Download Full Product CSV
    </button>

</div>

                            <button type="button" class="btn btn-outline-danger rounded-pill px-4"
                                wire:click="deleteproduct({{ $product->id }})"
                                onclick="return confirm('Are you sure you want to delete this product?')">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">

                    <div class="row g-4 mb-4">
                        <div class="col-md-4 text-center">
                            <img src="{{ asset('image/' . $product->file) }}" alt="Product Image"
                                class="product-image shadow-sm">
                        </div>

                        <div class="col-md-8">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="detail-card">
                                        <strong>Product Name:</strong><br>
                                        {{ $product->productname }}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="detail-card">
                                        <strong>Category:</strong><br>
                                        {{ $product->category }}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="detail-card">
                                        <strong>Total PCS:</strong><br>
                                        {{ $product->quantity }}
                                    </div>
                                </div>

                                <!-- <div class="col-md-6">
                                    <div class="detail-card">
                                        <strong>Box Quantity:</strong><br>
                                        {{ $product->boxquantity }}
                                    </div>
                                </div> -->

                                <!-- <div class="col-md-6">
                                    <div class="detail-card">
                                        <strong>Vehicle:</strong><br>
                                        {{ $product->vehicle ?? 'N/A' }}
                                    </div>
                                </div> -->

                                <div class="col-md-6">
                                    <div class="detail-card">
                                        <strong>Status:</strong><br>
                                        {{ $product->Action ? 'Active' : 'Inactive' }}
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="detail-card">
                                        <strong>Description:</strong><br>
                                        {!! $product->description !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

               

                    <div class="mb-3">
                        <h5 class="section-title">Batch-wise Price Mapping</h5>

                       <div class="row g-3 mb-3">
    <div class="col-md-4">
        <label class="form-label fw-bold">Filter Batch No</label>
        <input type="text"
            class="form-control"
            wire:model.live.debounce.500ms="batchNoFilter"
            placeholder="Filter batch no">
    </div>

    <div class="col-md-4">
        <label class="form-label fw-bold">Filter State</label>
        <input type="text"
            class="form-control"
            wire:model.live.debounce.500ms="batchStateFilter"
            placeholder="Filter state">
    </div>

    <div class="col-md-4 d-flex align-items-end">
        <button type="button"
            class="btn btn-success w-100"
            wire:click="downloadCsv">
            Download CSV
        </button>
    </div>
</div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <thead class="table-success">
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
                                        <th>Sub Dealer Price</th>
                                        <th>Retailer Price</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($filteredBatchRows as $index => $row)
                                        <tr>
                                            <td>{{ $filteredBatchRows->firstItem() + $index }}</td>
                                            <td>{{ $row['batchno'] }}</td>
                                            <td>{{ $row['boxqty'] }}</td>
                                            <td>{{ $row['pcsqty'] }}</td>
                                            <td>{{ $row['totalqty'] }}</td>
                                            <td>{{ $row['inventoryqty'] ?? '' }}</td>
                                            <td>{{ $row['state'] }}</td>
                                            <td>₹{{ $row['pricecndf'] }}</td>
                                            <td>₹{{ $row['pricedistributor'] }}</td>
                                            <td>₹{{ $row['pricedealer'] }}</td>
                                            <td>₹{{ $row['pricesubdealer'] }}</td>
                                            <td>₹{{ $row['priceretialer'] }}</td>
                                            <td>
                                                <button type="button"
                                                    wire:click="editPrice({{ $row['price_id'] }})"
                                                    class="btn btn-sm btn-primary">
                                                    Edit
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="13" class="text-center text-muted">
                                                No batch details found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            {{ $filteredBatchRows->links() }}
                        </div>
                    </div>

                </div>
            </div>
        @else
            <div class="alert alert-danger">
                Product not found.
            </div>
        @endif
    </div>

    <div wire:ignore.self class="modal fade" id="editPriceModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Edit State & Batch Price</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <form wire:submit.prevent="updatePrice">
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">State</label>
                                <input type="text" wire:model="editState" class="form-control">
                                @error('editState') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Batch No</label>
                                <input type="text" wire:model="editBatchNo" class="form-control">
                                <small class="text-muted">Example: 1-Feb,2-Feb,3-Feb</small>
                                @error('editBatchNo') <small class="text-danger d-block">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">CNDF Price</label>
                                <input type="number" step="0.01" wire:model="editCndf" class="form-control">
                                @error('editCndf') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Distributor Price</label>
                                <input type="number" step="0.01" wire:model="editDistributor" class="form-control">
                                @error('editDistributor') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Dealer Price</label>
                                <input type="number" step="0.01" wire:model="editDealer" class="form-control">
                                @error('editDealer') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sub Dealer Price</label>
                                <input type="number" step="0.01" wire:model="editSubDealer" class="form-control">
                                @error('editSubDealer') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Retailer Price</label>
                                <input type="number" step="0.01" wire:model="editRetailer" class="form-control">
                                @error('editRetailer') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>

                        <button type="submit" class="btn btn-success">
                            Update Price
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:init', function () {
            Livewire.on('open-edit-price-modal', function () {
                const modalElement = document.getElementById('editPriceModal');
                const modal = new bootstrap.Modal(modalElement);
                modal.show();
            });

            Livewire.on('close-edit-price-modal', function () {
                const modalElement = document.getElementById('editPriceModal');
                const modal = bootstrap.Modal.getInstance(modalElement);

                if (modal) {
                    modal.hide();
                }
            });
        });
    </script>
</div>