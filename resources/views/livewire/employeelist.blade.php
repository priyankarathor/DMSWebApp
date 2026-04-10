<div>
    <div class="container mt-3">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <div class="row mt-2">
                        <div class="col-md-8">
                            <span class="card-title">Employee List</span> &nbsp;&nbsp;

                            <button onclick="exportTableToExcel('myTable', 'InvoicesData')"
                                class="btn btn-outline-success" style="font-size:15px; border-radius:40px;">Excel</button>
                            <button onclick="downloadPDF()" class="btn btn-outline-success"
                                style="font-size:15px; border-radius:40px;">PDF</button>

                            {{-- <a href="#"> <button  class="btn btn-outline-success" style="font-size:15px; border-radius:40px;">All</button></a> --}}
                            {{-- <a href="{{ url('/distributerorder/' . $orderproduct->id) }}"> <button
                                    class="btn btn-outline-success"
                                    style="font-size:15px; border-radius:40px;">Approve</button></a> --}}

                        </div>

                        <div class="col-md-4">
                            <div class="row justify-content-end">
                                <div class=" d-flex align-items-center">
                                    <span for="search" class="form-label me-2">Search:</span>
                                    <input type="text" class="form-control" name="search" id="search"
                                        placeholder="Search table data...">

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
                                    <th>Register</th>
                                    <th>User Name</th>
                                    <th>Contact No.</th>
                                    <th>Product Name</th>
                                    <th>Product Quantity</th>
                                    <th>Expected Date</th>
                                    <th>Product Bulk</th>
                                    <th>Product Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tab as $orderproduct)
                                    @php
                                        // Handling arrays or single values for each field
                                        $userregisterids = strpos($orderproduct->userregisterid, ',') !== false ? explode(',', $orderproduct->userregisterid) : [$orderproduct->userregisterid];
                                        $usernames = strpos($orderproduct->username, ',') !== false ? explode(',', $orderproduct->username) : [$orderproduct->username];
                                        $usernumber = strpos($orderproduct->userphone, ',') !== false ? explode(',', $orderproduct->userphone) : [$orderproduct->userphone];
                                        $productnames = strpos($orderproduct->productname, ',') !== false ? explode(',', $orderproduct->productname) : [$orderproduct->productname];
                                        $productquantities = strpos($orderproduct->productquantity, ',') !== false ? explode(',', $orderproduct->productquantity) : [$orderproduct->productquantity];
                                        $productexpecteds = strpos($orderproduct->productexpected, ',') !== false ? explode(',', $orderproduct->productexpected) : [$orderproduct->productexpected];
                                        $productbulks = strpos($orderproduct->productbulk, ',') !== false ? explode(',', $orderproduct->productbulk) : [$orderproduct->productbulk];
                                        $productstatus = strpos($orderproduct->orderstatus, ',') !== false ? explode(',', $orderproduct->orderstatus) : [$orderproduct->orderstatus];
                            
                                        // Determine the largest array to loop through all products
                                        $maxCount = max(count($productnames), count($productquantities), count($productexpecteds), count($productbulks), count($productstatus));
                                    @endphp
                            
                                    @for ($index = 0; $index < $maxCount; $index++)
                                        <tr>
                                            <!-- Ensure all array values are accessed by index, using ?? '' to avoid undefined index issues -->
                                            <th scope="row">{{ $userregisterids[$index] ?? $userregisterids[0] }}</th>
                                            <th scope="row">{{ $usernames[$index] ?? $usernames[0] }}</th>
                                            <th scope="row">{{ $usernumber[$index] ?? $usernumber[0] }}</th>
                                            <td>{{ $productnames[$index] ?? '' }}</td>
                                            <td>{{ $productquantities[$index] ?? '' }}</td>
                                            <td>{{ $productexpecteds[$index] ?? '' }}</td>
                                            <td>{{ $productbulks[$index] ?? '' }}</td>
                                            <td>
                                                <select
                                                    onchange="updateStatus({{ $orderproduct->id }}, 'orderstatus', this.value)"
                                                    id="orderstatus{{ $orderproduct->id }}" name="orderstatus"
                                                    style="width: 100px; padding:5px; border-radius:10px;">
                                                    <option value="Pending" {{ $productstatus[$index] == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="Approve" {{ $productstatus[$index] == 'Approve' ? 'selected' : '' }}>Approve</option>
                                                    <option value="Cancel" {{ $productstatus[$index] == 'Cancel' ? 'selected' : '' }}>Cancel</option>
                                                </select>
                                            </td>
                                        </tr>
                                    @endfor
                                @endforeach
                            </tbody>
                            
                        </table>
                    </div>
                </div>
            </div>
        </div>



        <script>
            function exportTableToExcel(tableID, filename = '') {
                var table = document.getElementById(tableID);
                if (!table) {
                    alert("Table not found!");
                    return;
                }

                // Create a workbook from the table
                var wb = XLSX.utils.table_to_book(table, {
                    sheet: "Sheet1"
                });

                // Filename handling
                filename = filename ? filename : 'ExcelData';

                // Write the workbook to an Excel file
                XLSX.writeFile(wb, filename + ".xlsx");
            }
        </script>

    </div>
