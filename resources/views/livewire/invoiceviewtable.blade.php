<div>
    <div class="container mt-3">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <div class="row mt-2">
                        <div class="col-md-8">
                            <span class="card-title">Offline Invoice History</span> &nbsp;&nbsp;

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
                                <div class="d-flex align-items-center">
                                    <span for="search" class="form-label me-2">Search:</span>
                                    <input type="text" class="form-control" id="search" placeholder="Search table data..." onkeyup="searchTable()">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0" id="myTable">
                            <thead class="thead-light">

                                {{-- <th>#</th> --}}
                                <th>Invoice No.</th>
                                <th>Date</th>
                                <th>companyname</th>
                                <th>Print</th>
                                <th>Access</th>
                                </tr>
                            </thead>
                            @foreach ($tab as $item)        
                        <tbody>
                        <tr>
                           
                                <td>{{ $item->invoicenum }}</td>
                                <td>{{ $item->invoicedate }}</td>
                                <td>{{ $item->companyname }}</td>
                          

                           <td><a href="{{url('/invoiceget/'.$item->id)}}"><i class="fab fa-wpforms" style="border: 1px solid blue; padding:10px; border-radius:100%; color:green; font-size:22px; cursor: pointer;" ></i></a></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton{{ $item->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class='bx bxs-show'></i> Action
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $item->id }}">
                                            <li>
                                                {{-- Uncomment the edit link if needed --}} 
                                                <a class="dropdown-item" href="{{ url('/invoicedataeditpage/'.$item->id) }}" onclick="showToast('edit')">
                                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                {{-- Uncomment the delete link if needed --}}
                                                <a class="dropdown-item" href="{{ url('/deleteinvoice/'.$item->id) }}" onclick="deleteItem('{{ url('/deleteinvoice/'.$item->id) }}')">
                                                    <i class="bx bx-trash me-1"></i> Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                        </tr>
              
            </tbody>
            @endforeach
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

<script>
    function searchTable() {
        // Get the search input value
        const input = document.getElementById("search");
        const filter = input.value.toLowerCase();
        const table = document.getElementById("myTable");
        const rows = table.getElementsByTagName("tr");

        // Loop through all table rows, except for the header
        for (let i = 1; i < rows.length; i++) {
            let row = rows[i];
            let cells = row.getElementsByTagName("td");
            let match = false;

            // Check each cell in the row
            for (let j = 0; j < cells.length; j++) {
                if (cells[j]) {
                    let cellValue = cells[j].textContent || cells[j].innerText;
                    if (cellValue.toLowerCase().includes(filter)) {
                        match = true;
                        break;
                    }
                }
            }

            // Show or hide the row based on the search match
            row.style.display = match ? "" : "none";
        }
    }
</script>

    </div>
