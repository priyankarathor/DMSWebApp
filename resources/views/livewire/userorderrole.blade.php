<div>
    <div class="container mt-3">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h5 class="mb-0">User Stock List</h5>
                    </div>

                    <div class="col-md-4">
                        <input type="text" class="form-control" id="search" placeholder="Search user...">
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="myTable">
                        <thead class="table-light">
                            <tr>
                                <th>User Register Id</th>
                                <th>User Name</th>
                                <th>User Contact</th>
                                <th>Role</th>
                                <th>Product Details</th>
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
                                                <tr>
                                                    <td>{{ $child->registerid }}</td>
                                                    <td>{{ $child->username }}</td>
                                                    <td>{{ $child->contactno }}</td>
                                                    <td>{{ $child->roleid }}</td>
                                                    <td>
                                                        <a href="{{ route('user.product.details', $child->id) }}"
                                                           class="btn btn-sm btn-primary">
                                                            <i class="fa fa-eye"></i> View
                                                        </a>
                                                    </td>
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

    <script>
        document.getElementById("search").addEventListener("keyup", function () {
            let input = this.value.toLowerCase();
            let rows = document.querySelectorAll("#myTable tbody tr");

            rows.forEach(function (row) {
                row.style.display = row.textContent.toLowerCase().includes(input) ? "" : "none";
            });
        });
    </script>
</div>