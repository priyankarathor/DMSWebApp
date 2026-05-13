<div>
    <div class="container mt-3">
        <div class="card">
            <div class="card-header">
                <div class="row mt-2">
                    <div class="col-md-8">
                        <span class="card-title">User's Inventory List</span>
                    </div>

                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <span class="form-label me-2">Search:</span>
                            <input type="text" class="form-control" id="search" placeholder="Search user...">
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
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $user->registerid }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->contactno }}</td>
                                    <td>{{ $user->region }}</td>
                                    <td>
                                        <a href="{{ route('user.stock.details', $user->id) }}" 
                                           class="btn btn-outline-primary btn-sm rounded-circle"
                                           title="View Stock">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-danger">
                                        No users found.
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
        let rows = document.querySelectorAll("#myTable tbody tr");

        rows.forEach(function (row) {
            let text = row.textContent.toLowerCase();
            row.style.display = text.includes(input) ? "" : "none";
        });
    });
</script>