<div>
    <div class="container mt-4">

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Product Details</h5>
                    <small>
                        User: {{ $user->username }} |
                        Register ID: {{ $user->registerid }}
                    </small>
                </div>

                <a href="{{ route('userorder') }}" class="btn btn-sm btn-secondary">
                    Back
                </a>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Weight</th>
                                <th>HSN</th>
                                <th>Batch</th>
                                <th>Box Qty</th>
                                <th>Pcs Qty</th>
                                <th>Total Qty</th>
                                <th>Inventory</th>
                                <th>State</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($productDetails as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong>{{ $item['product_name'] }}</strong><br>
                                        <small>{{ $item['description'] }}</small>
                                    </td>
                                    <td>{{ $item['category'] }}</td>
                                    <td>{{ $item['weight'] }} {{ $item['weight_class'] }}</td>
                                    <td>{{ $item['hsncode'] }}</td>
                                    <td>{{ $item['batch_no'] }}</td>
                                    <td>{{ $item['boxqty'] }}</td>
                                    <td>{{ $item['pcsqty'] }}</td>
                                    <td>{{ $item['totalqty'] }}</td>
                                    <td>
                                        <span class="badge bg-success">
                                            {{ $item['inventory'] }}
                                        </span>
                                    </td>
                                    <td>{{ $item['state'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="13" class="text-center text-danger">
                                        No product found for this user.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>