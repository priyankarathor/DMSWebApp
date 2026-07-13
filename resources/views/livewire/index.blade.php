<div class="container mt-4">
    <!-- Welcome Header -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 mb-4 shadow-sm"
                style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border-radius: 16px;">
                <div class="card-body p-4 text-white">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="fw-bold mb-1 text-white">Welcome back, {{ Auth::user()->name }}!</h2>
                            <p class="text-white-50 mb-0 font-14">
                                You are logged in as <span class="badge bg-primary px-3 py-2 font-12 fw-semibold"
                                    style="border-radius: 30px; text-transform: uppercase; letter-spacing: 0.5px;">{{ $data['roleName'] }}</span>.
                                Here is your overview for today.
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <span class="text-white-50 font-13"><i class="bi bi-clock-fill me-1"></i>
                                {{ date('F d, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($isAdmin)
        <!-- ==========================================
                 ADMINISTRATOR DASHBOARD
                 ========================================== -->

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-6 col-lg-3 mb-3 mb-lg-0">
                <div class="card border-0 text-white shadow-sm overflow-hidden h-100"
                    style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); border-radius: 16px;">
                    <div class="card-body p-4 position-relative">
                        <div class="position-absolute end-0 bottom-0 opacity-25 me-3 mb-2"
                            style="font-size: 5rem; line-height: 1;">
                            <i class="bi bi-currency-rupee"></i>
                        </div>
                        <span class="text-white-50 text-uppercase fw-bold font-12">Total Revenue</span>
                        <h3 class="fw-extrabold text-white mt-1 mb-0 font-26">₹{{ number_format($data['totalRevenue'], 2) }}
                        </h3>
                        <p class="text-white-50 font-12 mt-2 mb-0"><i class="bi bi-graph-up-arrow me-1"></i> Cumulative
                            Sales Volume</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-3 mb-lg-0">
                <div class="card border-0 text-white shadow-sm overflow-hidden h-100"
                    style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); border-radius: 16px;">
                    <div class="card-body p-4 position-relative">
                        <div class="position-absolute end-0 bottom-0 opacity-25 me-3 mb-2"
                            style="font-size: 5rem; line-height: 1;">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <span class="text-white-50 text-uppercase fw-bold font-12">Registered Users</span>
                        <h3 class="fw-extrabold text-white mt-1 mb-0 font-26">{{ number_format($data['totalUsers']) }}</h3>
                        <p class="text-white-50 font-12 mt-2 mb-0"><i class="bi bi-check-circle-fill me-1"></i> Active
                            downline members</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-3 mb-lg-0">
                <div class="card border-0 text-white shadow-sm overflow-hidden h-100"
                    style="background: linear-gradient(135deg, #ff9966 0%, #ff5e62 100%); border-radius: 16px;">
                    <div class="card-body p-4 position-relative">
                        <div class="position-absolute end-0 bottom-0 opacity-25 me-3 mb-2"
                            style="font-size: 5rem; line-height: 1;">
                            <i class="bi bi-cart-fill"></i>
                        </div>
                        <span class="text-white-50 text-uppercase fw-bold font-12">Pending Orders</span>
                        <h3 class="fw-extrabold text-white mt-1 mb-0 font-26">{{ number_format($data['pendingOrders']) }}
                        </h3>
                        <p class="text-white-50 font-12 mt-2 mb-0"><i class="bi bi-exclamation-circle-fill me-1"></i>
                            Awaiting verification</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-3 mb-lg-0">
                <div class="card border-0 text-white shadow-sm overflow-hidden h-100"
                    style="background: linear-gradient(135deg, #8A2387 0%, #E94057 50%, #F27121 100%); border-radius: 16px;">
                    <div class="card-body p-4 position-relative">
                        <div class="position-absolute end-0 bottom-0 opacity-25 me-3 mb-2"
                            style="font-size: 5rem; line-height: 1;">
                            <i class="bi bi-box-seam-fill"></i>
                        </div>
                        <span class="text-white-50 text-uppercase fw-bold font-12">Products Catalog</span>
                        <h3 class="fw-extrabold text-white mt-1 mb-0 font-26">{{ number_format($data['totalProducts']) }}
                        </h3>
                        <p class="text-white-50 font-12 mt-2 mb-0"><i class="bi bi-tags-fill me-1"></i> Catalog active SKUs
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts and Details Grid -->
        <div class="row">
            <!-- Left Side: Sales Trend Chart & Recent Orders -->
            <div class="col-xl-8 mb-4">
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
                    <div
                        class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-bold mb-0">Sales Revenue Trend</h5>
                            <span class="text-muted font-12">Approved sales monthly performance for {{ date('Y') }}</span>
                        </div>
                    </div>
                    <div class="card-body px-4 pb-4 pt-0">
                        <div id="salesTrendChart" style="min-height: 300px;"></div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                    <div
                        class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-bold mb-0">Recent Order Placements</h5>
                            <span class="text-muted font-12">Latest orders requiring attention or status checks</span>
                        </div>
                        <a href="{{ route('orderlistadmin') }}" class="btn btn-sm btn-outline-primary px-3"
                            style="border-radius: 30px;">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle table-hover mb-0">
                                <thead class="table-light text-muted uppercase font-11">
                                    <tr>
                                        <th class="px-4">Order ID</th>
                                        <th>Buyer / User</th>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Total Price</th>
                                        <th>Status</th>
                                        <th class="text-end px-4">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data['recentOrders'] as $order)
                                        <tr>
                                            <td class="px-4 font-13 fw-semibold text-primary">#{{ $order->id }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <h6 class="mb-0 font-13 fw-semibold">{{ $order->buyer_name }}</h6>
                                                        <span class="text-muted font-11">{{ $order->buyer_role }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="font-13">{{ Str::limit($order->product_display, 25) }}</td>
                                            <td class="font-13 fw-semibold">{{ $order->totalqty }} <span
                                                    class="text-muted font-11">{{ $order->qtymasurment }}</span></td>
                                            <td class="font-13 fw-extrabold text-dark">
                                                ₹{{ number_format($order->grandTotal, 2) }}</td>
                                            <td>
                                                @if(str_contains(strtolower($order->orderstatus), 'approve'))
                                                    <span class="badge bg-soft-success text-success px-2 py-1 rounded"
                                                        style="font-size: 11px;">Approved</span>
                                                @else
                                                    <span class="badge bg-soft-warning text-warning px-2 py-1 rounded"
                                                        style="font-size: 11px;">Pending</span>
                                                @endif
                                            </td>
                                            <td class="text-end px-4">
                                                <a href="{{ route('orderproductadmin', $order->id) }}"
                                                    class="btn btn-sm btn-light font-12 px-2"
                                                    style="border-radius: 30px;">Details</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4 text-muted">No recent orders found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Product Catalog Distribution & Stock Alerts -->
            <div class="col-xl-4 mb-4">
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0">Product Catalog Distribution</h5>
                        <span class="text-muted font-12">Product volume grouped by category</span>
                    </div>
                    <div class="card-body d-flex flex-column align-items-center p-4">
                        <div id="productDistributionChart" style="width: 100%; min-height: 250px;"></div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                    <div
                        class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-bold mb-0">Stock Alert Status</h5>
                            <span class="text-muted font-12">Products with low catalog quantities</span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div
                            class="px-4 py-3 border-bottom d-flex align-items-center justify-content-between text-muted uppercase font-11 fw-bold">
                            <span>Product SKU</span>
                            <span>Stock Status</span>
                        </div>
                        <div style="max-height: 380px; overflow-y: auto;">
                            @forelse($data['lowStockProducts'] as $prod)
                                <div
                                    class="px-4 py-3 border-bottom d-flex align-items-center justify-content-between hover-bg-light transition-all">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-soft-warning rounded-circle me-3 d-flex align-items-center justify-content-center text-warning font-14"
                                            style="width: 40px; height: 40px;">
                                            <i class="bi bi-exclamation-triangle-fill"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 font-13 fw-semibold text-dark">{{ $prod->productname }}</h6>
                                            <span
                                                class="text-muted font-11 d-block">{{ $prod->category ?? 'No Category' }}</span>
                                            <span class="text-muted font-11">Price:
                                                ₹{{ number_format($prod->productprice, 2) }}</span>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <span
                                            class="d-block fw-bold font-13 {{ $prod->quantity <= 5 ? 'text-danger' : 'text-warning' }}">
                                            {{ $prod->quantity }} pcs
                                        </span>
                                        @if($prod->quantity == 0)
                                            <span class="badge bg-soft-danger text-danger font-10">Out of Stock</span>
                                        @elseif($prod->quantity <= 5)
                                            <span class="badge bg-soft-danger text-danger font-10">Critical</span>
                                        @else
                                            <span class="badge bg-soft-warning text-warning font-10">Low Stock</span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 text-muted">All products have sufficient stock levels.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @else
        <!-- ==========================================
                 REGULAR USER DASHBOARD (Distributor / Dealer / Retailer / Employee)
                 ========================================== -->

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-6 col-lg-3 mb-3 mb-lg-0">
                <div class="card border-0 text-white shadow-sm overflow-hidden h-100"
                    style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); border-radius: 16px;">
                    <div class="card-body p-4 position-relative">
                        <div class="position-absolute end-0 bottom-0 opacity-25 me-3 mb-2"
                            style="font-size: 5rem; line-height: 1;">
                            <i class="bi bi-currency-rupee"></i>
                        </div>
                        <span class="text-white-50 text-uppercase fw-bold font-12">Total Sales</span>
                        <h3 class="fw-extrabold text-white mt-1 mb-0 font-26">
                            ₹{{ number_format($data['totalSalesRevenue'], 2) }}</h3>
                        <p class="text-white-50 font-12 mt-2 mb-0"><i class="bi bi-receipt-cutoff me-1"></i> From
                            {{ $data['completedSalesCount'] }} approved orders</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-3 mb-lg-0">
                <div class="card border-0 text-white shadow-sm overflow-hidden h-100"
                    style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); border-radius: 16px;">
                    <div class="card-body p-4 position-relative">
                        <div class="position-absolute end-0 bottom-0 opacity-25 me-3 mb-2"
                            style="font-size: 5rem; line-height: 1;">
                            <i class="bi bi-box-seam-fill"></i>
                        </div>
                        <span class="text-white-50 text-uppercase fw-bold font-12">Stock Valuation</span>
                        <h3 class="fw-extrabold text-white mt-1 mb-0 font-26">
                            ₹{{ number_format($data['inventoryValue'], 2) }}</h3>
                        <p class="text-white-50 font-12 mt-2 mb-0"><i class="bi bi-box-seam me-1"></i>
                            {{ number_format($data['totalInventoryQty']) }} total stock items</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-3 mb-lg-0">
                <div class="card border-0 text-white shadow-sm overflow-hidden h-100"
                    style="background: linear-gradient(135deg, #ff9966 0%, #ff5e62 100%); border-radius: 16px;">
                    <div class="card-body p-4 position-relative">
                        <div class="position-absolute end-0 bottom-0 opacity-25 me-3 mb-2"
                            style="font-size: 5rem; line-height: 1;">
                            <i class="bi bi-cart-dash-fill"></i>
                        </div>
                        <span class="text-white-50 text-uppercase fw-bold font-12">Incoming Orders</span>
                        <h3 class="fw-extrabold text-white mt-1 mb-0 font-26">
                            {{ number_format($data['pendingSalesCount']) }}</h3>
                        <p class="text-white-50 font-12 mt-2 mb-0"><i class="bi bi-arrow-down-left-circle-fill me-1"></i>
                            Orders from downline</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-3 mb-lg-0">
                <div class="card border-0 text-white shadow-sm overflow-hidden h-100"
                    style="background: linear-gradient(135deg, #8A2387 0%, #E94057 50%, #F27121 100%); border-radius: 16px;">
                    <div class="card-body p-4 position-relative">
                        <div class="position-absolute end-0 bottom-0 opacity-25 me-3 mb-2"
                            style="font-size: 5rem; line-height: 1;">
                            <i class="bi bi-cart-plus-fill"></i>
                        </div>
                        <span class="text-white-50 text-uppercase fw-bold font-12">Outgoing Purchases</span>
                        <h3 class="fw-extrabold text-white mt-1 mb-0 font-26">
                            ₹{{ number_format($data['totalPurchasesSpend'], 2) }}</h3>
                        <p class="text-white-50 font-12 mt-2 mb-0"><i class="bi bi-cart-check-fill me-1"></i>
                            {{ $data['completedPurchasesCount'] }} completed purchases</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Downstream list & Orders lists -->
        <div class="row">
            <!-- Left Side: Recent Sales Orders & Downstream Members -->
            <div class="col-xl-8 mb-4">
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
                    <div
                        class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-bold mb-0">Incoming Orders from Downline (Sales)</h5>
                            <span class="text-muted font-12">Verify and process purchases requested by lower tiers</span>
                        </div>
                        <a href="{{ route('getuserorder') }}" class="btn btn-sm btn-outline-primary px-3"
                            style="border-radius: 30px;">Process Orders</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle table-hover mb-0">
                                <thead class="table-light text-muted uppercase font-11">
                                    <tr>
                                        <th class="px-4">Order ID</th>
                                        <th>Customer</th>
                                        <th>Product Details</th>
                                        <th>Qty</th>
                                        <th>Total Value</th>
                                        <th>Status</th>
                                        <th class="text-end px-4">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data['recentIncomingOrders'] as $order)
                                        <tr>
                                            <td class="px-4 font-13 fw-semibold text-primary">#{{ $order->id }}</td>
                                            <td>
                                                <h6 class="mb-0 font-13 fw-semibold">{{ $order->username }}</h6>
                                                <span class="text-muted font-11">{{ $order->userrole }}</span>
                                            </td>
                                            <td class="font-13 text-dark">{{ Str::limit($order->productname, 30) }}</td>
                                            <td class="font-13 fw-semibold">{{ $order->totalqty }} <span
                                                    class="text-muted font-11">{{ $order->qtymasurment }}</span></td>
                                            <td class="font-13 fw-extrabold text-dark">
                                                ₹{{ number_format($order->grandTotal, 2) }}</td>
                                            <td>
                                                @if(str_contains(strtolower($order->orderstatus), 'approve'))
                                                    <span class="badge bg-soft-success text-success px-2 py-1 rounded"
                                                        style="font-size: 11px;">Approved</span>
                                                @else
                                                    <span class="badge bg-soft-warning text-warning px-2 py-1 rounded"
                                                        style="font-size: 11px;">Pending Approval</span>
                                                @endif
                                            </td>
                                            <td class="text-end px-4">
                                                <a href="{{ route('productapprove', $order->id) }}"
                                                    class="btn btn-sm btn-success text-white font-12 px-3"
                                                    style="border-radius: 30px;">Process</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4 text-muted">No pending incoming orders
                                                found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                    <div
                        class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-bold mb-0">My Downstream Team Channels</h5>
                            <span class="text-muted font-12">Direct team members connected under your hierarchy node</span>
                        </div>
                        <a href="{{ route('rolehierarchylist') }}" class="btn btn-sm btn-outline-primary px-3"
                            style="border-radius: 30px;">View Hierarchy</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle table-hover mb-0">
                                <thead class="table-light text-muted uppercase font-11">
                                    <tr>
                                        <th class="px-4">Register ID</th>
                                        <th>Name</th>
                                        <th>Role Type</th>
                                        <th>Location</th>
                                        <th>Contact</th>
                                        <th class="text-end px-4">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data['downstreamUsers'] as $ds)
                                        <tr>
                                            <td class="px-4 font-13 fw-semibold text-primary">{{ $ds->registerid }}</td>
                                            <td>
                                                <h6 class="mb-0 font-13 fw-semibold">{{ $ds->username }}</h6>
                                                <span class="text-muted font-11">{{ $ds->framname }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-soft-info text-info px-2 py-1 font-11"
                                                    style="border-radius: 20px;">{{ $ds->role_name }}</span>
                                            </td>
                                            <td class="font-13 text-muted"><i
                                                    class="bi bi-geo-alt-fill me-1 text-primary"></i>{{ $ds->city }},
                                                {{ $ds->state }}</td>
                                            <td class="font-13">{{ $ds->contactno }}</td>
                                            <td class="text-end px-4">
                                                @if(strtolower($ds->active) == 'active')
                                                    <span class="badge bg-success text-white px-2 py-1 font-10"
                                                        style="border-radius: 20px;">Active</span>
                                                @else
                                                    <span class="badge bg-secondary text-white px-2 py-1 font-10"
                                                        style="border-radius: 20px;">Deactive</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-muted">No downstream team members
                                                assigned yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Outgoing Orders (Purchases) & Quick Actions -->
            <div class="col-xl-4 mb-4">
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0">Recent Purchase Placements</h5>
                        <span class="text-muted font-12">Recent orders placed to your upstream supplier</span>
                    </div>
                    <div class="card-body p-0">
                        <div
                            class="px-4 py-3 border-bottom d-flex align-items-center justify-content-between text-muted uppercase font-11 fw-bold">
                            <span>Product & Amount</span>
                            <span>Status</span>
                        </div>
                        <div style="max-height: 380px; overflow-y: auto;">
                            @forelse($data['recentOutgoingOrders'] as $order)
                                <div
                                    class="px-4 py-3 border-bottom d-flex align-items-center justify-content-between hover-bg-light transition-all">
                                    <div>
                                        <h6 class="mb-0 font-13 fw-semibold">{{ Str::limit($order->productname, 25) }}</h6>
                                        <span class="text-muted font-11 d-block">{{ $order->totalqty }}
                                            {{ $order->qtymasurment }}</span>
                                        <span
                                            class="font-12 fw-extrabold text-primary">₹{{ number_format($order->grandTotal, 2) }}</span>
                                    </div>
                                    <div>
                                        @if(str_contains(strtolower($order->orderstatus), 'approve'))
                                            <span class="badge bg-soft-success text-success font-11">Approved</span>
                                        @else
                                            <span class="badge bg-soft-warning text-warning font-11">Pending</span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 text-muted">No recent purchase orders placed.</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm" style="border-radius: 16px; background: #fafbfc;">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0">Quick Shortcut Actions</h5>
                        <span class="text-muted font-12">Access important sections instantly</span>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-grid gap-2">
                            <a href="{{ route('productinventery') }}"
                                class="btn btn-outline-primary py-2 text-start font-13 fw-semibold border-2"
                                style="border-radius: 12px;">
                                <i class="bi bi-box-seam me-2 font-16"></i> Manage My Inventory
                            </a>
                            <a href="{{ route('userorder') }}"
                                class="btn btn-outline-success py-2 text-start font-13 fw-semibold border-2"
                                style="border-radius: 12px;">
                                <i class="bi bi-file-earmark-spreadsheet me-2 font-16"></i> View Stock Reports
                            </a>
                            <a href="{{ route('getuserorder') }}"
                                class="btn btn-outline-warning py-2 text-start font-13 fw-semibold border-2"
                                style="border-radius: 12px;">
                                <i class="bi bi-cart me-2 font-16"></i> Manage Incoming Orders
                            </a>
                            <a href="{{ route('history') }}"
                                class="btn btn-outline-indigo py-2 text-start font-13 fw-semibold border-2"
                                style="border-radius: 12px; color: #6f42c1; border-color: #6f42c1;">
                                <i class="bi bi-cash-coin me-2 font-16"></i> Sales & Earnings History
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- ==========================================
     ApexCharts Widget Scripts
     ========================================== -->
@if($isAdmin)
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // 1. Sales Trend Area Chart
            var salesTrendData = @json($data['salesTrend']);
            var months = salesTrendData.map(function (item) { return item.month; });
            var amounts = salesTrendData.map(function (item) { return item.amount; });

            var salesOptions = {
                series: [{
                    name: 'Monthly Revenue',
                    data: amounts
                }],
                chart: {
                    height: 320,
                    type: 'area',
                    toolbar: {
                        show: false
                    },
                    fontFamily: 'Fira Sans, sans-serif'
                },
                colors: ['#38ef7d'],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                xaxis: {
                    categories: months,
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    }
                },
                yaxis: {
                    labels: {
                        formatter: function (val) {
                            return "₹" + val.toLocaleString('en-IN');
                        }
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.45,
                        opacityTo: 0.05,
                        stops: [0, 90, 100]
                    }
                },
                grid: {
                    borderColor: '#eef2f6',
                    strokeDashArray: 4,
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return "₹" + val.toLocaleString('en-IN');
                        }
                    }
                }
            };

            var salesChart = new ApexCharts(document.querySelector("#salesTrendChart"), salesOptions);
            salesChart.render();

            // 2. Product Distribution by Category Donut Chart
            var productDistribution = @json($data['productDistribution']);
            var prodLabels = productDistribution.map(function (item) { return item.label; });
            var prodValues = productDistribution.map(function (item) { return item.value; });

            var prodOptions = {
                series: prodValues,
                chart: {
                    height: 280,
                    type: 'donut',
                    fontFamily: 'Fira Sans, sans-serif'
                },
                labels: prodLabels,
                colors: ['#1e3c72', '#2a5298', '#11998e', '#ff9966', '#ff5e62', '#8A2387', '#E94057'],
                legend: {
                    position: 'bottom',
                    fontSize: '12px'
                },
                dataLabels: {
                    enabled: true,
                    formatter: function (val, opts) {
                        return opts.w.config.series[opts.seriesIndex];
                    }
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '70%',
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Total Products',
                                    fontSize: '14px',
                                    fontWeight: 'bold',
                                    color: '#6c757d',
                                    formatter: function (w) {
                                        return w.globals.seriesTotals.reduce(function (a, b) {
                                            return a + b;
                                        }, 0);
                                    }
                                }
                            }
                        }
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            var prodChart = new ApexCharts(document.querySelector("#productDistributionChart"), prodOptions);
            prodChart.render();
        });
    </script>
@endif