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
                        </div>
                        <div class="col-md-4">
                            <div class="row justify-content-end">
                                <div class="d-flex align-items-center">
                                    <span for="search" class="form-label me-2">Search:</span>
                                    <input type="text" class="form-control" name="search" id="search" placeholder="Search table data..." onkeyup="searchTable()">
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
                                    <th>User Email</th>
                                    <th>User Contact</th>
                                    <th>Role</th>
                                    <th>Product status</th>
                                    <th>Date/Time</th>
                                    <th>Access</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tab as $tabdata)
                                    @foreach ($userdata as $item)
                                        @if($tabdata->userid == $item->id)
                                            <tr>
                                                <th scope="row">{{$item->registerid}}</th>
                                                <td>{{$item->username}}</td>
                                                <td>{{$item->email}}</td>
                                                <td>{{$item->contactno}}</td>
                                                
                                                @foreach ($roles as $roledata)
                                                    @if($roledata->id == $item->roleid)
                                                        <td>{{$roledata->role}}</td>
                                                    @endif
                                                @endforeach
                                                
                                                <td>Pending</td>
                                                <td>{{$item->created_at}}</td>
                                                <td>
                                                    <a href="{{url('/orderproduct/'.$tabdata->id)}}"> 
                                                        <button class="btn btn-outline-success">Product</button>
                                                    </a>
                                                </td> 
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

<script>
    function searchTable() {
        const input = document.getElementById("search").value.toLowerCase();
        const table = document.getElementById("myTable");
        const rows = table.getElementsByTagName("tr");

        for (let i = 1; i < rows.length; i++) { // Start at 1 to skip header row
            const cells = rows[i].getElementsByTagName("td");
            let rowContainsText = false;

            for (let cell of cells) {
                if (cell.textContent.toLowerCase().includes(input)) {
                    rowContainsText = true;
                    break;
                }
            }

            rows[i].style.display = rowContainsText ? "" : "none";
        }
    }
</script>
