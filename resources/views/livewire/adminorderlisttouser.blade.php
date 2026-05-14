<div>
    <script src="{{asset('assets/js/custom.js')}}"></script>
    <div class="container mt-3">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <div class="row mt-2">
                        <div class="col-md-8">
                            <span class="card-title">Order List</span> &nbsp;&nbsp;
                        </div>
                        <div class="col-md-4 mt-1">
                            <div class="row justify-content-end">
                                <div class="d-flex align-items-center">
                                    <span for="search" class="form-label me-2">Search:</span>
                                    <input type="text" class="form-control" id="search" placeholder="Search table data..." onkeyup="searchTable()">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table mb-0" id="myTable">
                    <thead>
                        <tr>
                            <th>User Register Id</th>
                            <th>User Name</th>
                            <th>User Email</th>
                            <th>State</th>
                            <th>User Role</th>
                            <th>User Contact</th>
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
                 
                            <td>{{$item->region}}</td>
                            @foreach ($userrole as $tabrole)
                            @if($tabrole->id == $item->roleid)
                            <td>{{$tabrole->role}}</td>
                            @endif
                            @endforeach
                            <td>{{$item->contactno}}</td>
                            <td>Pending</td>
                            <td>{{$item->created_at}}</td>
                            <td>
                                <a href="{{url('/orderproductadmin/'.$tabdata->id)}}"><button class="btn btn-outline-success">Product</button></a>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                        @endforeach
                    </tbody>
                </table>
                            <div class="pagination-container mt-3">
            <button onclick="prevPage()" id="btn_prev"  class="btn btn-outline-success">Prev</button>
            &nbsp;&nbsp;&nbsp;<span id="page-info"></span>&nbsp;&nbsp;&nbsp;
            <button onclick="nextPage()" id="btn_next"  class="btn btn-outline-success">Next</button>
        </div>
            </div>

        </div>
    </div>
</div>

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
