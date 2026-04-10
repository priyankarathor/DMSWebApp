<div>
    <div class="container mt-3">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <div class="row mt-2">
                        <div class="col-md-8">
                            <span class="card-title">Order List</span> &nbsp;&nbsp;

                            <button onclick="exportTableToExcel('myTable', 'InvoicesData')" class="btn btn-outline-success" style="font-size:15px; border-radius:40px;">Excel</button>
                            <button onclick="downloadPDF()" class="btn btn-outline-success" style="font-size:15px; border-radius:40px;">PDF</button>
                            <a href="#"><button class="btn btn-outline-success" style="font-size:15px; border-radius:40px;">All</button></a>
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
                                    <th>User Register Id</th>
                                    <th>User Name</th>
                                    <th>User Contact</th>
                                    <th>Date\time</th>
                                    <th>Access</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                function fetchHierarchy($tab, $parentId) {
                                    $result = [];
                                    foreach ($tab as $user) {
                                        if ($user->assignid == $parentId) {
                                            $result[] = $user;
                                            $result = array_merge($result, fetchHierarchy($tab, $user->id));
                                        }
                                    }
                                    return $result;
                                }
                                @endphp

                                @foreach ($users as $usertab)
                                    @foreach ($tab as $tables)
                                        @if($usertab->ragisternum == $tables->id)
                                            @php
                                                $hierarchy = fetchHierarchy($tab, $tables->id);
                                            @endphp

                                            @foreach ($hierarchy as $child)
                                                @if(in_array($child->roleid, explode(',', $usertab->userregisterid)))
                                                    @php
                                                    $userOrders = $orderdata->where('userid', $child->id);
                                                    @endphp

                                                    @if($userOrders->isNotEmpty())
                                                        @foreach ($userOrders as $item)
                                                            <tr>
                                                                <td>{{ $child->registerid }}</td>
                                                                <td>{{ $child->username }}</td>
                                                                <td>{{ $child->contactno }}</td>
                                                                <td>{{ $item->created_at }}</td>
                                                                <td>
                                                                    <a href="{{ url('/orderproduct/'.$item->id) }}">
                                                                        <p class="btn btn-success">Product</p>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr class="no-products-row">
                                                            <td>{{ $child->registerid }}</td>
                                                            <td>{{ $child->username }}</td>
                                                            <td>{{ $child->contactno }}</td>
                                                            <td colspan="2">No Products</td>
                                                        </tr>
                                                    @endif
                                                @endif
                                            @endforeach
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

<!-- Search functionality -->
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

<!-- Optional: PDF Export (you can plug in jsPDF or other library) -->
<script>
    function downloadPDF() {
        alert("PDF export functionality to be implemented.");
    }
</script>
