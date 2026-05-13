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

                                <button onclick="downloadCSV()"
                                        class="btn btn-outline-success mt-1"
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
                                <input type="text"
                                       wire:model.live.debounce.500ms="search"
                                       class="form-control"
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
                                        <th>Product Name</th>
                                        <th>Product Quantity</th>
                                        <th>Bulk(Box/BKT)</th>
                                        <th>Amount</th>
                                        <th>Total Amount</th>
                                        <th>GST Rate</th>
                                        <th>GST Type</th>
                                        <th>SGST</th>
                                        <th>CGST</th>
                                        <th>Approved Date</th>
                                        <th>Access</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($approve as $products)

                                        @php
                                            $productNames = explode(',', $products->productname ?? '');
                                            $productquantity = explode(',', $products->productquantity ?? '');
                                            $productbulk = explode(',', $products->productbulk ?? '');
                                            $amount = explode(',', $products->amount ?? '');
                                            $totalamount = explode(',', $products->totalamount ?? '');
                                        @endphp

                                        @foreach ($productNames as $index => $productName)
                                            <tr>
                                                <td>{{ $loop->parent->iteration + (($approve->currentPage() - 1) * $approve->perPage()) }}</td>

                                                <td>{{ $products->invoiceno ?? 'N/A' }}</td>
                                                <td>{{ $products->invoicedate ?? 'N/A' }}</td>
                                                <td>{{ $products->framname ?? 'N/A' }}</td>
                                                <td>{{ $products->gstnumber ?? 'N/A' }}</td>
                                                <td>{{ $products->username ?? 'N/A' }}</td>
                                                <td>{{ $products->contactno ?? 'N/A' }}</td>
                                                <td>{{ $products->email ?? 'N/A' }}</td>
                                                <td>{{ $products->region ?? 'N/A' }}</td>
                                                <td>{{ $products->address ?? 'N/A' }}</td>

                                                <td>{{ trim($productName) ?: 'N/A' }}</td>
                                                <td>{{ $productquantity[$index] ?? 'N/A' }}</td>
                                                <td>{{ $productbulk[$index] ?? 'N/A' }}</td>
                                                <td>{{ $amount[$index] ?? 'N/A' }}</td>
                                                <td>{{ $totalamount[$index] ?? 'N/A' }}</td>

                                                <td>{{ $products->gstrate ?? 'N/A' }}</td>
                                                <td>{{ $products->selectgst ?? 'N/A' }}</td>
                                                <td>{{ $products->sgst ?? 'N/A' }}</td>
                                                <td>{{ $products->cgst ?? 'N/A' }}</td>
                                                <td>{{ $products->created_at ?? 'N/A' }}</td>

                                                <td>
                                                    <button type="button"
                                                            class="btn btn-outline-success btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#exampleModal{{ $products->id }}{{ $index }}">
                                                        <i class="bi bi-eye-fill"></i>
                                                    </button>
                                                </td>
                                            </tr>

                                            <div class="modal fade"
                                                 id="exampleModal{{ $products->id }}{{ $index }}"
                                                 tabindex="-1"
                                                 aria-hidden="true"
                                                 wire:ignore.self>
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">

                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Order Full Details</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <div class="row">

                                                                <div class="col-md-6 mb-2"><b>Invoice No:</b> {{ $products->invoiceno ?? 'N/A' }}</div>
                                                                <div class="col-md-6 mb-2"><b>Invoice Date:</b> {{ $products->invoicedate ?? 'N/A' }}</div>

                                                                <div class="col-md-6 mb-2"><b>Firm Name:</b> {{ $products->framname ?? 'N/A' }}</div>
                                                                <div class="col-md-6 mb-2"><b>GST Number:</b> {{ $products->gstnumber ?? 'N/A' }}</div>

                                                                <div class="col-md-6 mb-2"><b>User Name:</b> {{ $products->username ?? 'N/A' }}</div>
                                                                <div class="col-md-6 mb-2"><b>Contact No:</b> {{ $products->contactno ?? 'N/A' }}</div>

                                                                <div class="col-md-6 mb-2"><b>Email:</b> {{ $products->email ?? 'N/A' }}</div>
                                                                <div class="col-md-6 mb-2"><b>Region:</b> {{ $products->region ?? 'N/A' }}</div>

                                                                <div class="col-md-12 mb-2"><b>Address:</b> {{ $products->address ?? 'N/A' }}</div>

                                                                <hr>

                                                                <div class="col-md-6 mb-2"><b>Product Name:</b> {{ trim($productName) ?: 'N/A' }}</div>
                                                                <div class="col-md-6 mb-2"><b>Product Quantity:</b> {{ $productquantity[$index] ?? 'N/A' }}</div>

                                                                <div class="col-md-6 mb-2"><b>Bulk:</b> {{ $productbulk[$index] ?? 'N/A' }}</div>
                                                                <div class="col-md-6 mb-2"><b>Amount:</b> {{ $amount[$index] ?? 'N/A' }}</div>

                                                                <div class="col-md-6 mb-2"><b>Total Amount:</b> {{ $totalamount[$index] ?? 'N/A' }}</div>
                                                                <div class="col-md-6 mb-2"><b>GST Rate:</b> {{ $products->gstrate ?? 'N/A' }}</div>

                                                                <div class="col-md-6 mb-2"><b>GST Type:</b> {{ $products->selectgst ?? 'N/A' }}</div>
                                                                <div class="col-md-6 mb-2"><b>SGST:</b> {{ $products->sgst ?? 'N/A' }}</div>

                                                                <div class="col-md-6 mb-2"><b>CGST:</b> {{ $products->cgst ?? 'N/A' }}</div>

                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                                Close
                                                            </button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                    @empty
                                        <tr>
                                            <td colspan="21" class="text-center">No approved order found.</td>
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

                            <div>
                                {{ $approve->links() }}
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
</div>