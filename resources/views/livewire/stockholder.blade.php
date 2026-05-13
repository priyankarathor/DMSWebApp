<div class="container-fluid py-4">

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">

            <h3 class="fw-bold text-primary mb-1">
                Stock Holder Details
            </h3>

            <p class="text-muted mb-4">
                Showing all users and product stock where Seller ID is 
                <strong>{{ $sellerid }}</strong>
            </p>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-success">
                        <tr>
                            <th>Sr No.</th>
                            <th>Seller ID</th>
                            <th>User ID</th>
                            <th>User Name</th>
                            <th>Role ID</th>
                            <th>State</th>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Inventory</th>
                            <th>Batch ID</th>
                            <th>Batch No</th>
                            <th>Price ID</th>
                            <th>CNDF Price</th>
                            <th>Distributor Price</th>
                            <th>Dealer Price</th>
                            <th>Sub Dealer Price</th>
                            <th>Retailer Price</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($stockData as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $sellerid }}</td>
                                <td>{{ $item['uid'] }}</td>
                                <td>{{ $item['user_name'] }}</td>
                                <td>{{ $item['role_id'] }}</td>
                                <td>{{ $item['state'] }}</td>
                                <td>{{ $item['product_id'] }}</td>
                                <td>{{ $item['product_name'] }}</td>
                                <td>
                                    <span class="badge bg-primary">
                                        {{ $item['inventory'] }}
                                    </span>
                                </td>
                                <td>{{ $item['batch_id'] }}</td>
                                <td>{{ $item['batch_no'] }}</td>
                                <td>{{ $item['price_id'] }}</td>
                                <td>{{ $item['cndf_price'] }}</td>
                                <td>{{ $item['distributor_price'] }}</td>
                                <td>{{ $item['dealer_price'] }}</td>
                                <td>{{ $item['subdealer_price'] }}</td>
                                <td>{{ $item['retailer_price'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="17" class="text-center text-danger fw-bold py-4">
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