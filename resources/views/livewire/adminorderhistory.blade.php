<div>
    <div>
        <style>
            .modal-body {
                max-height: 70vh;
                overflow-y: auto;
            }

            .table th,
            .table td {
                white-space: nowrap;
                vertical-align: middle;
            }

            .table td[rowspan] {
                vertical-align: middle;
                /* or top, your preference */
            }
        </style>

        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">

                    <div class="card">

                        <div class="card-header">
                            <div class="row align-items-center">

                                <div class="col-md-5 col-12">
                                    <span class="card-title mt-1">Approved Order Details</span>

                                    <button onclick="exportTableToExcel('myTable', 'InvoicesData')"
                                        class="btn btn-outline-success mt-1"
                                        style="font-size:15px; border-radius:40px;">
                                        Excel
                                    </button>

                                    <button onclick="downloadCSV()" class="btn btn-outline-success mt-1"
                                        style="font-size:15px; border-radius:40px;">
                                        CSV
                                    </button>
                                </div>

                                <div class="col-md-3 mt-1">
                                    <select wire:model.live="perPage" class="form-control">
                                        <option value="10">10 Records</option>
                                        <option value="20">20 Records</option>
                                        <option value="50">50 Records</option>
                                        <option value="100">100 Records</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mt-1">
                                    <input type="text" wire:model.live.debounce.500ms="search" class="form-control"
                                        placeholder="Search invoice/user/product...">
                                </div>

                            </div>
                        </div>

                        <div class="card-body">

                            <div class="mb-2">
                                <strong>Total Records:</strong> {{ $approve->total() }}
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped mb-0" id="myTable">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Invoice No</th>
                                            <th>Invoice Date</th>
                                            <th>Firm Name</th>
                                            <th>GST No</th>
                                            <th>User Name</th>
                                            <th>Contact</th>
                                            <th>Email</th>
                                            <th>Region</th>
                                            <th>Address</th>
                                            <th>GST Rate</th>
                                            <th>GST Type</th>
                                            <th>SGST</th>
                                            <th>CGST</th>
                                            <th>Approved Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse ($approve as $products)
                                            @php
                                                $serial = $loop->iteration + (($approve->currentPage() - 1) * $approve->perPage());
                                            @endphp
                                            <tr>
                                                <td>{{ $serial }}</td>
                                                <td>{{ $products->invoiceno ?? 'N/A' }}</td>
                                                <td>{{ $products->invoicedate ?? 'N/A' }}</td>
                                                <td>{{ $products->framname ?? 'N/A' }}</td>
                                                <td>{{ $products->gstnumber ?? 'N/A' }}</td>
                                                <td>{{ $products->username ?? 'N/A' }}</td>
                                                <td>{{ $products->contactno ?? 'N/A' }}</td>
                                                <td>{{ $products->email ?? 'N/A' }}</td>
                                                <td>{{ $products->region ?? 'N/A' }}</td>
                                                <td>{{ $products->address ?? 'N/A' }}</td>
                                                <td>{{ $products->gstrate ?? 'N/A' }}</td>
                                                <td>{{ $products->selectgst ?? 'N/A' }}</td>
                                                <td>{{ $products->sgst ?? 'N/A' }}</td>
                                                <td>{{ $products->cgst ?? 'N/A' }}</td>
                                                <td>{{ $products->created_at ?? 'N/A' }}</td>
                                                <td>
                                                    {{-- Use onclick to set data, then open a SINGLE shared modal --}}
                                                    <button type="button" class="btn btn-outline-success btn-sm"
                                                        onclick="openOrderModal({{ $products->id }})">
                                                        <i class="bi bi-eye-fill"></i> View Products
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="16" class="text-center">No approved order found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    Showing {{ $approve->firstItem() ?? 0 }} to {{ $approve->lastItem() ?? 0 }}
                                    of {{ $approve->total() }} records
                                </div>
                                <div>{{ $approve->links() }}</div>
                            </div>

                        </div>

                        {{-- Hidden order data for JS --}}
                        @foreach ($approve as $products)
                            @php
                                $productNames = explode(',', $products->productname ?? '');
                                $productquantity = explode(',', $products->productquantity ?? '');
                                $productbulk = explode(',', $products->productbulk ?? '');
                                $amount = explode(',', $products->amount ?? '');
                                $totalamount = explode(',', $products->totalamount ?? '');

                                $productList = [];
                                foreach ($productNames as $i => $name) {
                                    $productList[] = [
                                        'name' => trim($name),
                                        'qty' => $productquantity[$i] ?? 'N/A',
                                        'bulk' => $productbulk[$i] ?? 'N/A',
                                        'amount' => $amount[$i] ?? 'N/A',
                                        'total' => $totalamount[$i] ?? 'N/A',
                                    ];
                                }
                            @endphp

                            <div id="orderData{{ $products->id }}" style="display:none;"
                                data-invoiceno="{{ $products->invoiceno }}" data-invoicedate="{{ $products->invoicedate }}"
                                data-firmname="{{ $products->framname }}" data-gstnumber="{{ $products->gstnumber }}"
                                data-username="{{ $products->username }}" data-contact="{{ $products->contactno }}"
                                data-email="{{ $products->email }}" data-region="{{ $products->region }}"
                                data-address="{{ $products->address }}" data-gstrate="{{ $products->gstrate }}"
                                data-gsttype="{{ $products->selectgst }}" data-sgst="{{ $products->sgst }}"
                                data-cgst="{{ $products->cgst }}" data-products='{{ json_encode($productList) }}'></div>
                        @endforeach

                        {{-- Single Shared Modal --}}
                        <div class="modal fade" id="sharedOrderModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalInvoiceTitle">Order Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        {{-- Common Info --}}
                                        <div class="row mb-3" id="modalCommonInfo"></div>

                                        <hr>

                                        {{-- Products Table --}}
                                        <h6 class="mb-2"><b>Product Details</b></h6>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Product Name</th>
                                                        <th>Quantity</th>
                                                        <th>Bulk (Box/BKT)</th>
                                                        <th>Amount</th>
                                                        <th>Total Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="modalProductBody"></tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <script>
            function downloadCSV() {
                let table = document.getElementById("myTable");
                let rows = table.querySelectorAll("tr");
                let csv = [];

                rows.forEach(row => {
                    let cols = row.querySelectorAll("td, th");
                    let rowData = [];

                    cols.forEach(col => {
                        rowData.push('"' + col.innerText.replace(/"/g, '""') + '"');
                    });

                    csv.push(rowData.join(","));
                });

                let csvFile = new Blob([csv.join("\n")], { type: "text/csv" });
                let downloadLink = document.createElement("a");

                downloadLink.download = "approved_order_details.csv";
                downloadLink.href = window.URL.createObjectURL(csvFile);
                downloadLink.style.display = "none";

                document.body.appendChild(downloadLink);
                downloadLink.click();
                document.body.removeChild(downloadLink);
            }

            function exportTableToExcel(tableID, filename = '') {
                let table = document.getElementById(tableID);
                let html = table.outerHTML.replace(/ /g, '%20');

                filename = filename ? filename + '.xls' : 'excel_data.xls';

                let downloadLink = document.createElement("a");
                document.body.appendChild(downloadLink);

                downloadLink.href = 'data:application/vnd.ms-excel,' + html;
                downloadLink.download = filename;
                downloadLink.click();

                document.body.removeChild(downloadLink);
            }
        </script>

        <script>
            function openOrderModal(id) {
                const el = document.getElementById('orderData' + id);
                if (!el) return;

                // Fill title
                document.getElementById('modalInvoiceTitle').innerText =
                    'Order Details — ' + (el.dataset.invoiceno || 'N/A');

                // Fill common info
                const fields = [
                    ['Invoice No', el.dataset.invoiceno],
                    ['Invoice Date', el.dataset.invoicedate],
                    ['Firm Name', el.dataset.firmname],
                    ['GST Number', el.dataset.gstnumber],
                    ['User Name', el.dataset.username],
                    ['Contact No', el.dataset.contact],
                    ['Email', el.dataset.email],
                    ['Region', el.dataset.region],
                    ['GST Rate', el.dataset.gstrate],
                    ['GST Type', el.dataset.gsttype],
                    ['SGST', el.dataset.sgst],
                    ['CGST', el.dataset.cgst],
                ];

                let commonHtml = '';
                fields.forEach(([label, value]) => {
                    commonHtml += `<div class="col-md-6 mb-2"><b>${label}:</b> ${value || 'N/A'}</div>`;
                });
                commonHtml += `<div class="col-md-12 mb-2"><b>Address:</b> ${el.dataset.address || 'N/A'}</div>`;
                document.getElementById('modalCommonInfo').innerHTML = commonHtml;

                // Fill products table
                const products = JSON.parse(el.dataset.products || '[]');
                let rows = '';
                products.forEach((p, i) => {
                    rows += `<tr>
        <td>${i + 1}</td>
        <td>${p.name || 'N/A'}</td>
        <td>${p.qty || 'N/A'}</td>
        <td>${p.bulk || 'N/A'}</td>
        <td>${p.amount || 'N/A'}</td>
        <td>${p.total || 'N/A'}</td>
    </tr>`;
                });
                document.getElementById('modalProductBody').innerHTML = rows;

                // Open modal
                const modal = new bootstrap.Modal(document.getElementById('sharedOrderModal'));
                modal.show();
            }
        </script>
    </div>
</div>