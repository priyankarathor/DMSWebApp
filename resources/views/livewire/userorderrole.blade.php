<div>
    <div class="container mt-3">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <div class="row mt-2">
                        <div class="col-md-8">
                            <span class="card-title">User Stock List</span> &nbsp;&nbsp;
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
                                    <th>User Register Id</th>
                                    <th>User Name</th>
                                    <th>User Contact</th>
                                    <th>Role</th>
                                    <th>Product Name</th>
                                    <th>Weight</th>
                                    <th>Class</th>
                                    <th>Hsn Code</th>
                                    <th>Inventory</th>
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
                                                    @php $productsDetails = []; @endphp

                                                    @foreach ($junstiontab as $jtrole)
                                                        @if ($jtrole->uid == $child->id)
                                                            @foreach ($products as $pro)
                                                                @if ($pro->id == $jtrole->pid)
                                                                    @php
                                                                        $productsDetails[] = [
                                                                            'id' => $pro->id,
                                                                            'name' => $pro->productname,
                                                                            'weightnum' => $pro->weightnum,
                                                                            'weightclass' => $pro->weihgtclass,
                                                                            'hsncode' => $pro->hsncode,
                                                                            'inventory' => $jtrole->inventery
                                                                        ];
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endforeach

                                                    <tr>
                                                        <td>{{ $child->registerid }}</td>
                                                        <td>{{ $child->username }}</td>
                                                        <td>{{ $child->contactno }}</td>
                                                        <td>{{ $child->roleid }}</td>
                                                        <td>
                                                            <select onchange="updateDetails(this)" class="form-control">
                                                                <option value="">Select Product</option>
                                                                @foreach ($productsDetails as $product)
                                                                    <option value="{{ $product['id'] }}"
                                                                        data-weightnum="{{ $product['weightnum'] }}"
                                                                        data-weightclass="{{ $product['weightclass'] }}"
                                                                        data-hsncode="{{ $product['hsncode'] }}"
                                                                        data-inventory="{{ $product['inventory'] }}">
                                                                        {{ $product['name'] }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td class="weightnum"></td>
                                                        <td class="weightclass"></td>
                                                        <td class="hsncode"></td>
                                                        <td class="inventory"></td>
                                                    </tr>
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

        <!-- JS: Update product details -->
        <script>
            function updateDetails(selectElement) {
                const selectedOption = selectElement.options[selectElement.selectedIndex];
                const weightnum = selectedOption.getAttribute('data-weightnum');
                const weightclass = selectedOption.getAttribute('data-weightclass');
                const hsncode = selectedOption.getAttribute('data-hsncode');
                const inventory = selectedOption.getAttribute('data-inventory');

                const row = selectElement.closest('tr');
                row.querySelector('.weightnum').textContent = weightnum;
                row.querySelector('.weightclass').textContent = weightclass;
                row.querySelector('.hsncode').textContent = hsncode;
                row.querySelector('.inventory').textContent = inventory;
            }
        </script>

        <!-- JS: Search functionality -->
        <script>
            document.getElementById("search").addEventListener("keyup", function () {
                var input = this.value.toLowerCase();
                var rows = document.querySelectorAll("#myTable tbody tr");

                rows.forEach(function (row) {
                    var rowText = row.textContent.toLowerCase();
                    row.style.display = rowText.includes(input) ? "" : "none";
                });
            });
        </script>

        <!-- JS: Excel Export (optional, only if needed) -->
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
    </div>
</div>
