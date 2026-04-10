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

        input:checked + .slider {
            background-color: #115e0f;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #115e0f;
        }

        input:checked + .slider:before {
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

                        <div class="d-flex gap-2">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary rounded-pill px-4">
                                Back
                            </a>

                            <a href="{{ url('/productedit/'.$product->id) }}" class="btn btn-outline-success rounded-pill px-4">
                                Edit
                            </a>

                            <button type="button"
                                class="btn btn-outline-danger rounded-pill px-4"
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
                            <img src="{{ asset('image/' . $product->file) }}"
                                alt="Product Image"
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

                                <div class="col-md-6">
                                    <div class="detail-card">
                                        <strong>Box Quantity:</strong><br>
                                        {{ $product->boxquantity }}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="detail-card">
                                        <strong>Vehicle:</strong><br>
                                        {{ $product->vehicle ?? 'N/A' }}
                                    </div>
                                </div>

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

                    <hr class="my-4">

                    <div class="mb-4">
                        <h5 class="section-title">Batch-wise Stock Details</h5>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <thead class="table-success">
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Batch No</th>
                                        <th>Qty</th>
                                        <th>Max Qty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($product->batches as $batch)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $batch->batchno }}</td>
                                            <td>{{ $batch->qty }}</td>
                                            <td>{{ $batch->maxqty }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">No batch data found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5 class="section-title">State-wise Product Price Details</h5>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <thead class="table-success">
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Batch No</th>
                                        <th>State</th>
                                        <th>CNDF</th>
                                        <th>Distributor</th>
                                        <th>Dealer</th>
                                        <th>Sub Dealer</th>
                                        <th>Retailer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($product->prices as $price)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $price->batchno ?? 'N/A' }}</td>
                                            <td>{{ $price->state }}</td>
                                            <td>₹{{ $price->pricecndf }}</td>
                                            <td>₹{{ $price->pricedistributor }}</td>
                                            <td>₹{{ $price->pricedealer }}</td>
                                            <td>₹{{ $price->pricesubdealer }}</td>
                                            <td>₹{{ $price->priceretialer }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted">No price data found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mb-2">
                        <h5 class="section-title">Batch-wise Price Mapping</h5>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <thead class="table-success">
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Batch No</th>
                                        <th>Qty</th>
                                        <th>Max Qty</th>
                                        <th>State</th>
                                        <th>CNDF Price</th>
                                        <th>Distributor Price</th>
                                        <th>Dealer Price</th>
                                        <th>Sub Dealer Price</th>
                                        <th>Retailer Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($product->batches as $batch)
                                        @php
                                            $matchedPrices = $product->prices->where('batchno', $batch->batchno);
                                        @endphp

                                        @if($matchedPrices->count() > 0)
                                            @foreach($matchedPrices as $matchedPrice)
                                                <tr>
                                                    <td>{{ $loop->parent->iteration }}</td>
                                                    <td>{{ $batch->batchno }}</td>
                                                    <td>{{ $batch->qty }}</td>
                                                    <td>{{ $batch->maxqty }}</td>
                                                    <td>{{ $matchedPrice->state ?? 'N/A' }}</td>
                                                    <td>₹{{ $matchedPrice->pricecndf ?? 0 }}</td>
                                                    <td>₹{{ $matchedPrice->pricedistributor ?? 0 }}</td>
                                                    <td>₹{{ $matchedPrice->pricedealer ?? 0 }}</td>
                                                    <td>₹{{ $matchedPrice->pricesubdealer ?? 0 }}</td>
                                                    <td>₹{{ $matchedPrice->priceretialer ?? 0 }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $batch->batchno }}</td>
                                                <td>{{ $batch->qty }}</td>
                                                <td>{{ $batch->maxqty }}</td>
                                                <td colspan="6" class="text-center text-muted">
                                                    No price found for this batch
                                                </td>
                                            </tr>
                                        @endif
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center text-muted">
                                                No batch details found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
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
</div>