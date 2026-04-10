<div>
    <div class="container mt-3">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <div class="row mt-2">
                        <div class="col-md-8">
                            <span class="card-title">User's Inventory List</span> &nbsp;&nbsp;

                            <button onclick="exportTableToExcel('myTable', 'InvoicesData')" class="btn btn-outline-success" style="font-size:15px; border-radius:40px;">Excel</button>
                            <button onclick="downloadPDF()" class="btn btn-outline-success" style="font-size:15px; border-radius:40px;">PDF</button>
                        </div>

                        <div class="col-md-4">
                            <div class="row justify-content-end">
                                <div class="d-flex align-items-center">
                                    <span class="form-label me-2">Search:</span>
                                    <input type="text" class="form-control" id="search" placeholder="Search table data...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0" id="myTable">
                            <thead class="thead-light">
                                <tr>
                                    <th>Register ID</th>
                                    <th>Username</th>
                                    <th>Contact No</th>
                                    <th>Region</th>
                                    <th>Product Name</th>
                                    <th>Inventory</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($getroleid as $tabdata)
                                    @foreach ($junctiontab->where('uid', $tabdata->id) as $item)
                                        @php
                                            $product = $products->firstWhere('id', $item->pid);
                                        @endphp
                                        @if ($product)
                                            <tr>
                                                <td>{{ $tabdata->registerid }}</td>
                                                <td>{{ $tabdata->username }}</td>
                                                <td>{{ $tabdata->contactno }}</td>
                                                <td>{{ $tabdata->region }}</td>
                                                <td>{{ $product->productname }}</td>
                                                <td>{{ $item->inventery }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 🔍 Search Functionality -->
<script>
    document.getElementById("search").addEventListener("keyup", function () {
        var input = this.value.toLowerCase();
        var rows = document.querySelectorAll("#myTable tbody tr");

        rows.forEach(function (row) {
            var text = row.textContent.toLowerCase();
            row.style.display = text.includes(input) ? "" : "none";
        });
    });
</script>

<!-- Optional: Excel Export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
    function exportTableToExcel(tableID, filename = '') {
        var table = document.getElementById(tableID);
        if (!table) {
            alert("Table not found!");
            return;
        }

        var wb = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });
        filename = filename ? filename : 'ExcelData';
        XLSX.writeFile(wb, filename + ".xlsx");
    }
</script>

<!-- Optional: PDF Export (Placeholder) -->
<script>
    function downloadPDF() {
        alert("PDF download feature is not implemented yet.");
    }
</script>
