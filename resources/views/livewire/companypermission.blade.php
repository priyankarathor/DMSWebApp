<div>
    <div class="container mt-3">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <div class="row mt-2">
                       
                        <div class="col-md-3">
                            <div class="row justify-content-end">
                                <div class="d-flex align-items-center">
                                    <span for="search" class="form-label me-2">Search:</span>
                                    <input type="text" class="form-control" name="search" id="search"
                                        placeholder="Search table data...">
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- end card-header -->

                <table class="table">
                    <thead>
                        <tr>
                            <th>Register ID</th>
                            <th>Zonal </th>
                             <th>Z's Role </th>
                            <th>Username</th>
                            <th>Contact No</th>
                            <th>Region</th>
                            <th>Role</th>
                            <th>Insert Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        @foreach ($tab as $item)
                        <tr> <!-- Hide rows where roleid != 1 -->
                           
                            <td>{{ $item->registerid }}</td>
                           
                           @foreach($zonalcheck as $check)
                           @if($check->id == $item->zonalId)
                           <td style="color:green;">{{ $check->username }}</td>
                            @foreach ($category as $roleid)
                                @if($roleid->id == $check->roleid) <!-- Correct comparison -->
                                    <td style="color:green;">{{ $roleid->role }}</td>
                                @endif
                            @endforeach
                           @endif
                            @endforeach

                            <td><a  style="color:blue;" href="{{ url('/allhierarchydata/' . $item->id) }}">{{ $item->username }}</a></td>
                            <td>{{ $item->contactno }}</td>
                            <td>{{ $item->region }}</td>
                            
                            @foreach ($category as $roleid)
                                @if($roleid->id == $item->roleid) <!-- Correct comparison -->
                                    <td>{{ $roleid->role }}</td>
                                @endif
                            @endforeach
                    
                            <td>{{ $item->insertdate }}</td>
                            <td>
                                <a href="{{ route('manageaccountlist', $item->id) }}">
                                    <button class="btn btn-outline-success">Permission</button>
                                </a>
                             
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="pagination-container mt-3">
                    <button onclick="prevPage()" id="btn_prev" class="btn btn-outline-success"
                        style="display:none;">Prev</button>
                    &nbsp;&nbsp;&nbsp;<span id="page-info"></span>&nbsp;&nbsp;&nbsp;
                    <button onclick="nextPage()" id="btn_next" class="btn btn-outline-success"
                        style="display:none;">Next</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function checkDependence(selectedRoleId) {
            // Get all table rows
            let rows = document.querySelectorAll('#table-body tr');

            // Loop through rows and show/hide based on selected roleid
            rows.forEach(row => {
                let rowRoleId = row.getAttribute('data-roleid');

                if (selectedRoleId === "" || rowRoleId === selectedRoleId) {
                    row.style.display = ""; // Show row
                } else {
                    row.style.display = "none"; // Hide row
                }
            });
        }
    </script>

    <script>
        // Search Functionality
        document.getElementById('search').addEventListener('input', function() {
            let searchValue = this.value.toLowerCase(); // Get the search input and convert to lowercase
            let rows = document.querySelectorAll('#table-body tr'); // Get all table rows

            rows.forEach(row => {
                let rowText = row.textContent
            .toLowerCase(); // Get the text content of the row and convert to lowercase

                // Check if the row contains the search value
                if (rowText.includes(searchValue)) {
                    row.style.display = ""; // Show row
                } else {
                    row.style.display = "none"; // Hide row
                }
            });
        });
    </script>

    <style>
        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .btn {
            margin: 5px;
        }
    </style>
</div>