<div class="container">
    <div class="row">

        @if (session('success'))
            <div class="alert alert-success mt-2">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger mt-2">{{ session('error') }}</div>
        @endif

        <form id="form-validation-2" class="form" action="{{ route('insertaccdata') }}" method="post">
            @csrf

            <div class="row mt-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mt-1 mb-1" style="color:green; font-size:20px;">
                            User Details
                        </h4>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <div class="mb-2 col-md-3">
                                <label for="dependence" class="mb-2">Select Dependence</label>
                                <select class="form-control" id="dependence" name="dependence" onchange="filterDistributors()">
                                    <option class="text-center" value="">----Select Dependence----</option>
                                    @foreach ($usercategory as $item)
                                        <option value="{{ $item->id }}">{{ $item->role }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-2 col-md-3">
                                <label for="assignid" class="mb-2">User ID</label>
                                <select class="form-control" id="assignid" name="assignid">
                                    <option class="text-center" value="">----Select User ID----</option>
                                    @foreach ($hierarchy as $data)
                                        <option value="{{ $data->id }}"
                                            data-roleid="{{ $data->roleid }}"
                                            data-username="{{ $data->username }}"
                                            data-region="{{ $data->region }}"
                                            data-email="{{ $data->email }}">
                                            {{ $data->registerid }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <label class="mb-2">User Id</label>
                                    <input type="text" name="id" id="id" class="form-control" readonly>
                                </div>

                                <div class="col-md-4">
                                    <label class="mb-2">User Name</label>
                                    <input type="text" name="name" id="name" class="form-control" readonly>
                                </div>

                                <div class="col-md-4">
                                    <label class="mb-2">User Role</label>
                                    <input type="text" name="role" id="role" class="form-control" readonly>
                                </div>

                                <div class="col-md-4 mt-2">
                                    <label class="mb-2">User Role Id</label>
                                    <input type="text" name="roleid" id="roleid" class="form-control" readonly>
                                </div>

                                <div class="col-md-4 mt-2">
                                    <label class="mb-2">User Email</label>
                                    <input type="email" name="email" id="email" class="form-control" required>
                                </div>

                                <div class="col-md-4 mt-2">
                                    <label class="mb-2">Password</label>
                                    <input type="password" name="password" id="password" class="form-control" required>
                                    <div id="passwordError" class="text-danger mt-1" style="display:none;">
                                        ❌ Password cannot be the same as Email
                                    </div>
                                </div>

                                <div class="col-md-4" style="display:none;">
                                    <input type="text" name="userrole" id="userrole" class="form-control" value="2" readonly>
                                </div>
                            </div>

                            <div class="row mt-3">
                                @foreach ($usercategory as $item)
                                    <div class="mb-3 form-check col-md-2">
                                        <input type="checkbox"
                                            name="regid[]"
                                            value="{{ $item->id }}"
                                            class="form-check-input"
                                            id="roleCheck{{ $item->id }}">
                                        <label class="form-check-label" for="roleCheck{{ $item->id }}">
                                            {{ $item->role }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <button type="submit" class="btn btn-primary mt-2">Submit</button>

                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="card mt-4">
            <div class="card-body">

                <div class="row align-items-end mb-3">
                    <div class="col-md-3">
                        <h2>User Details</h2>
                    </div>

                    <div class="col-md-2">
                        <label class="mb-1">Show Records</label>
                        <select id="recordsPerPage" class="form-control">
                            <option value="10" selected>10 Records</option>
                            <option value="20">20 Records</option>
                          <option value="50">50 Records</option>
                          <option value="50">100 Records</option>
                        </select>
                    </div>

                    <div class="col-md-5">
                        <label class="mb-1">Search</label>
                        <input type="text"
                            id="searchInput"
                            class="form-control"
                            placeholder="Search by username, email, password, role...">
                    </div>

                    <div class="col-md-2">
                        <button type="button" class="btn btn-success w-100" onclick="downloadCSV()">
                            CSV Download
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="userTable">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Password</th>
                                <th>Role</th>
                                <th>Define Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody id="tableBody">
                            @foreach ($tab as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->password }}</td>
                                    <td>{{ $item->role }}</td>

                                    <td>
                                        <select name="userrole[]" class="form-control">
                                            @foreach ($usercategory as $data)
                                                @if(in_array($data->id, explode(',', $item->userregisterid)))
                                                    <option value="{{ $data->id }}" selected>
                                                        {{ $data->role }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </td>

                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-primary btn-sm dropdown-toggle"
                                                type="button"
                                                data-bs-toggle="dropdown">
                                                <i class='bx bxs-show'></i> Action
                                            </button>

                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="{{ url('/manageaccountdata/'.$item->id) }}">
                                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                                    </a>
                                                </li>

                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ url('/deletedata/'.$item->id) }}"
                                                        onclick="return confirm('Are you sure you want to delete this user?')">
                                                        <i class="bx bx-trash me-1"></i> Delete
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div id="tableInfo" class="text-muted"></div>

                    <div>
                        <button type="button" class="btn btn-outline-primary btn-sm" id="prevBtn">
                            Previous
                        </button>

                        <span id="pageNumbers" class="mx-2"></span>

                        <button type="button" class="btn btn-outline-primary btn-sm" id="nextBtn">
                            Next
                        </button>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<script>
    function filterDistributors() {
        let dependenceId = document.getElementById("dependence").value;
        let userIdDropdown = document.getElementById("assignid");
        let userOptions = userIdDropdown.getElementsByTagName("option");

        for (let i = 0; i < userOptions.length; i++) {
            let roleId = userOptions[i].getAttribute("data-roleid");

            if (roleId == dependenceId || userOptions[i].value === "") {
                userOptions[i].style.display = "";
            } else {
                userOptions[i].style.display = "none";
            }
        }

        userIdDropdown.value = "";
        clearUserFields();
    }

    const roles = @json($usercategory->pluck('role', 'id'));
    const hierarchy = @json($hierarchy);

    document.getElementById('assignid').addEventListener('change', function () {
        let selectedUserId = this.value;
        let selectedUser = hierarchy.find(user => user.id == selectedUserId);

        if (selectedUser) {
            document.getElementById('id').value = selectedUser.id ?? '';
            document.getElementById('name').value = selectedUser.username ?? '';
            document.getElementById('email').value = selectedUser.email ?? '';
            document.getElementById('role').value = roles[selectedUser.roleid] ?? '';
            document.getElementById('roleid').value = selectedUser.roleid ?? '';
        } else {
            clearUserFields();
        }
    });

    function clearUserFields() {
        document.getElementById('id').value = '';
        document.getElementById('name').value = '';
        document.getElementById('role').value = '';
        document.getElementById('email').value = '';
        document.getElementById('roleid').value = '';
    }

    document.getElementById("password").addEventListener("input", function () {
        const email = document.getElementById("email").value;
        const password = this.value;
        const errorDiv = document.getElementById("passwordError");

        if (email && email === password) {
            this.classList.add("is-invalid");
            errorDiv.style.display = "block";
        } else {
            this.classList.remove("is-invalid");
            errorDiv.style.display = "none";
        }
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let currentPage = 1;
        let recordsPerPage = 10;

        const searchInput = document.getElementById("searchInput");
        const recordsPerPageSelect = document.getElementById("recordsPerPage");
        const tableBody = document.getElementById("tableBody");
        const tableInfo = document.getElementById("tableInfo");
        const prevBtn = document.getElementById("prevBtn");
        const nextBtn = document.getElementById("nextBtn");
        const pageNumbers = document.getElementById("pageNumbers");

        if (!searchInput || !recordsPerPageSelect || !tableBody) {
            console.log("Search elements not found");
            return;
        }

        let rows = Array.from(tableBody.querySelectorAll("tr"));

        function getFilteredRows() {
            let searchValue = searchInput.value.toLowerCase().trim();

            return rows.filter(row => {
                let rowText = row.innerText.toLowerCase();
                return rowText.includes(searchValue);
            });
        }

        function renderTable() {
            let filteredRows = getFilteredRows();
            let totalRecords = filteredRows.length;
            let totalPages = Math.ceil(totalRecords / recordsPerPage);

            if (totalPages < 1) totalPages = 1;
            if (currentPage > totalPages) currentPage = totalPages;

            rows.forEach(row => {
                row.style.display = "none";
            });

            let startIndex = (currentPage - 1) * recordsPerPage;
            let endIndex = startIndex + recordsPerPage;

            filteredRows.slice(startIndex, endIndex).forEach(row => {
                row.style.display = "";
            });

            if (totalRecords === 0) {
                tableInfo.innerText = "No records found";
            } else {
                tableInfo.innerText =
                    `Showing ${startIndex + 1} to ${Math.min(endIndex, totalRecords)} of ${totalRecords} records`;
            }

            prevBtn.disabled = currentPage === 1;
            nextBtn.disabled = currentPage === totalPages;

            renderPageNumbers(totalPages);
        }

        function renderPageNumbers(totalPages) {
            pageNumbers.innerHTML = "";

            for (let i = 1; i <= totalPages; i++) {
                let button = document.createElement("button");
                button.type = "button";
                button.innerText = i;

                button.className = i === currentPage
                    ? "btn btn-primary btn-sm mx-1"
                    : "btn btn-outline-primary btn-sm mx-1";

                button.addEventListener("click", function () {
                    currentPage = i;
                    renderTable();
                });

                pageNumbers.appendChild(button);
            }
        }

        searchInput.addEventListener("input", function () {
            currentPage = 1;
            renderTable();
        });

        recordsPerPageSelect.addEventListener("change", function () {
            recordsPerPage = parseInt(this.value);
            currentPage = 1;
            renderTable();
        });

        prevBtn.addEventListener("click", function () {
            if (currentPage > 1) {
                currentPage--;
                renderTable();
            }
        });

        nextBtn.addEventListener("click", function () {
            let totalPages = Math.ceil(getFilteredRows().length / recordsPerPage);

            if (currentPage < totalPages) {
                currentPage++;
                renderTable();
            }
        });

        renderTable();
    });
</script>