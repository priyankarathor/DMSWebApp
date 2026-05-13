<div>
    <div class="container mt-3">
        <div class="card">

            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h5 class="mb-0">Stock Details</h5>
                        <small>
                            {{ $user->username }} | {{ $user->registerid }} | {{ $user->region }}
                        </small>
                    </div>

                    <div class="col-md-4 text-end">
                        <a href="javascript:history.back()" class="btn btn-outline-secondary btn-sm">
                            Back
                        </a>

                        <button onclick="exportTableToExcel('stockTable', 'UserStockData')" 
                                class="btn btn-outline-success btn-sm">
                            Excel
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body">

                <div class="mb-3">
                    <input type="text" class="form-control" id="search" placeholder="Search stock...">
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="stockTable">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Register ID</th>
                                <th>Username</th>
                                <th>Contact No</th>
                                <th>Region</th>
                                <th>Product Name</th>
                                <th>Inventory</th>
                                <th>Qty</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($stocks as $index => $stock)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $user->registerid }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->contactno }}</td>
                                    <td>{{ $user->region }}</td>
                                    <td>{{ $stock['productname'] }}</td>
                                    <td>{{ $stock['inventory'] }}</td>
                                    <td>Pcs</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-danger">
                                        No stock found for this user.
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

<script>
    document.getElementById("search").addEventListener("keyup", function () {
        let input = this.value.toLowerCase();
        let rows = document.querySelectorAll("#stockTable tbody tr");

        rows.forEach(function (row) {
            let text = row.textContent.toLowerCase();
            row.style.display = text.includes(input) ? "" : "none";
        });
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script>
    function exportTableToExcel(tableID, filename = '') {
        let table = document.getElementById(tableID);

        if (!table) {
            alert("Table not found!");
            return;
        }

        let wb = XLSX.utils.table_to_book(table, { sheet: "StockData" });
        filename = filename ? filename : 'ExcelData';
        XLSX.writeFile(wb, filename + ".xlsx");
    }
</script>