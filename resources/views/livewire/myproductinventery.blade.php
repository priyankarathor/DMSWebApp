<div>
    <div class="container mt-3">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <div class="row mt-2">
                        <div class="col-md-8">
                            <span class="card-title">Inventory List</span> &nbsp;&nbsp;

                            <button onclick="exportTableToExcel('myTable', 'InvoicesData')" class="btn btn-outline-success" style="font-size:15px; border-radius:40px;">Excel</button>
                            <button onclick="downloadPDF()" class="btn btn-outline-success" style="font-size:15px; border-radius:40px;">PDF</button>
                            <a href="#"><button class="btn btn-outline-success" style="font-size:15px; border-radius:40px;">All</button></a>
                        </div>

                        <div class="col-md-4">
                            <div class="row justify-content-end">
                                <div class="d-flex align-items-center">
                                    <span for="search" class="form-label me-2">Search:</span>
                                    <input type="text" class="form-control" name="search" id="search" placeholder="Search table data...">
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
                                    <th>Product Name</th>
                                    <th>Batch No</th>
                                    <th>Product Price</th>
                                    <th class="d-none">Product Quantity</th>
                                    <th>HSN Code</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $item)
                                    <tr>
                                        <td>{{ $item->productname ?? 'N/A' }}</td>
                                        <td>{{ $item->batchno ?? 'N/A' }}</td>
                                        <td>{{ $item->productprice ?? 'N/A' }}</td>
                                        <td class="d-none">
                                            {{ $item->weightnum ?? '' }} {{ $item->weihgtclass ?? '' }}
                                        </td>
                                        <td>{{ $item->hsncode ?? 'N/A' }}</td>
                                        <td>{{ $item->inventery ?? 0 }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No inventory found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function updateStatus(id) {
                var checkbox = document.querySelector('#status' + id + ' input[type="checkbox"]');
                var status = checkbox.checked ? 'Active' : 'Disable';

                fetch('/viewstatus', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ id: id, status: status })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        alert('Status updated to ' + data.status);
                    }
                })
                .catch(error => console.error('Error:', error));
            }

            function deletefun(id) {
                let check = confirm("Are you sure to delete this data?");
                if (check) {
                    window.location.href = '/deleteslide/' + id;
                }
            }
        </script>

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

    </div>
</div>