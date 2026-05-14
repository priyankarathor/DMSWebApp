<div class="container mt-4">

    <div class="card shadow-sm border-0 rounded-4 p-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
            <div>
                <h4 class="mb-1 text-success fw-bold">Upload Batch Price CSV</h4>

                @if($product)
                    <p class="mb-0 text-muted">
                        Product:
                        <strong>{{ $product->productname }}</strong>
                        | Product ID:
                        <strong>{{ $product->id }}</strong>
                    </p>
                @endif
            </div>

            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary rounded-pill px-4">
                Back
            </a>
        </div>

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

        <form wire:submit.prevent="importCsv">

            <div class="mb-3">
                <label class="form-label fw-bold">Select CSV File</label>

                <input type="file"
                    wire:model="csvFile"
                    class="form-control"
                    accept=".csv,.txt">

                @error('csvFile')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                <small class="text-muted d-block mt-2">
                    Required columns: Product ID, Batch No, State, Box Qty, PCS Qty,
                    Total Qty, Inventory, CNDF Price, Distributor Price,
                    Dealer Price, Sub Dealer Price, Retailer Price
                </small>
            </div>

            <button type="submit" class="btn btn-primary rounded-pill px-4">
                Upload & Update Batch Price
            </button>

            <div wire:loading wire:target="csvFile,importCsv" class="mt-2 text-info">
                Processing CSV...
            </div>

        </form>
    </div>

    @if($product)
        <div class="card shadow-sm border-0 rounded-4 p-4 mt-4">

            <h5 class="text-success fw-bold mb-3">Current Batch Details</h5>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-success">
                        <tr>
                            <th>Batch ID</th>
                            <th>Batch No</th>
                            <th>Box Qty</th>
                            <th>PCS Qty</th>
                            <th>Total Qty</th>
                            <th>Inventory</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($product->batches as $batch)
                            <tr>
                                <td>{{ $batch->id }}</td>
                                <td>{{ $batch->batchno }}</td>
                                <td>{{ $batch->boxqty ?? 0 }}</td>
                                <td>{{ $batch->pcsqty ?? 0 }}</td>
                                <td>{{ $batch->totalqty ?? 0 }}</td>
                                <td>{{ $batch->inventoryqty ?? 0 }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    No batch data found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <h5 class="text-success fw-bold mt-4 mb-3">Current Price Details</h5>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-success">
                        <tr>
                            <th>Price ID</th>
                            <th>State</th>
                            <th>Batch ID</th>
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
                                <td>{{ $price->id }}</td>
                                <td>{{ $price->state }}</td>
                                <td>{{ $price->batchnos }}</td>
                                <td>₹{{ $price->pricecndf ?? 0 }}</td>
                                <td>₹{{ $price->pricedistributor ?? 0 }}</td>
                                <td>₹{{ $price->pricedealer ?? 0 }}</td>
                                <td>₹{{ $price->pricesubdealer ?? 0 }}</td>
                                <td>₹{{ $price->priceretialer ?? 0 }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">
                                    No price data found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    @endif

</div>