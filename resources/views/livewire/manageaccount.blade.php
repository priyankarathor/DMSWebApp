<div class="container">
    <div class="row">
                    @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <form id="form-validation-2" class="form" action="{{ route('insertaccdata') }}" method="post">
            @csrf
            <div class="row mt-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mt-1 mb-1" style="color:green; font-size:20px;">User Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Select Dependence Dropdown -->
                            

                            <div class="mb-2 col-md-3">
                                <label for="dependence" class="mb-2">Select Dependence</label>
                                <select class="form-control" id="dependence" name="dependence" onchange="filterDistributors()">
                                    <option class="text-center" value="">----Select Dependence----</option>
                                    @foreach ($usercategory as $item)
                                        <option value="{{ $item->id }}">{{ $item->role }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="mb-2 col-md-3" id="distributorIdDiv">
                                <label for="assignid" class="mb-2">User ID</label>
                                <select class="form-control" id="assignid" name="assignid" onchange="updateUsernameAndRegion()">
                                    <option class="text-center" value="">----Select User ID----</option>
                                    @foreach ($hierarchy as $data)
                                        <option value="{{ $data->id }}" data-roleid="{{ $data->roleid }}" data-username="{{ $data->username }}" data-region="{{ $data->region }}">
                                            {{ $data->registerid }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <script>
                                function filterDistributors() {
                                    var dependenceId = document.getElementById("dependence").value;
                                    var userIdDropdown = document.getElementById("assignid");
                                    var userOptions = userIdDropdown.getElementsByTagName("option");
                                
                                    // Filter User ID dropdown options based on selected Dependence
                                    for (var i = 0; i < userOptions.length; i++) {
                                        var roleId = userOptions[i].getAttribute("data-roleid");
                                        if (roleId == dependenceId || userOptions[i].value === "") {
                                            userOptions[i].style.display = "";
                                        } else {
                                            userOptions[i].style.display = "none";
                                        }
                                    }
                                }
                                
                                function updateUsernameAndRegion() {
                                    var userIdDropdown = document.getElementById("assignid");
                                    var selectedOption = userIdDropdown.options[userIdDropdown.selectedIndex];
                                
                                    // Get username and region from the selected User ID
                                    var username = selectedOption.getAttribute("data-username");
                                    var region = selectedOption.getAttribute("data-region");
                                
                                    // Update and enable the Username dropdown
                                    var usernameDropdown = document.getElementById("username");
                                    usernameDropdown.innerHTML = "<option>" + (username ? username : "----Dependence Username----") + "</option>";
                                    usernameDropdown.disabled = !username;
                                
                                    // Update and enable the Region dropdown
                                    var regionDropdown = document.getElementById("region");
                                    regionDropdown.innerHTML = "<option>" + (region ? region : "----Dependence Region----") + "</option>";
                                    regionDropdown.disabled = !region;
                                }
                                </script>
                            <!-- User Details Display -->
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="id" class="mb-2">User Id</label>
                                    <input type="text" name="id" id="id" class="form-control" readonly />
                                </div>

                                <div class="col-md-4">
                                    <label for="name" class="mb-2">User Name</label>
                                    <input type="text" name="name" id="name" class="form-control" readonly />
                                </div>

                                <div class="col-md-4">
                                    <label for="role" class="mb-2">User Role</label>
                                    <input type="text" name="role" id="role" class="form-control" readonly />
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="role" class="mb-2">User Role Id</label>
                                    <input type="text" name="roleid" id="roleid" class="form-control" readonly />
                                </div>

<div class="col-md-6">
    <label for="email" class="mb-2">User Email</label>
    <input type="email" name="email" id="email" class="form-control" required />
</div>

<div class="mb-3 col-md-6">
    <label for="password" class="form-label">Password</label>
    <input type="password" name="password" id="password" class="form-control" required />
    <div id="passwordError" class="text-danger mt-1" style="display: none;">
        ❌ Password cannot be the same as Email
    </div>
</div>

<script>
document.getElementById("password").addEventListener("input", function () {
    const email = document.getElementById("email").value;
    const password = this.value;
    const errorDiv = document.getElementById("passwordError");

    if (email && email === password) {
        this.classList.add("is-invalid");  // Bootstrap red border
        errorDiv.style.display = "block"; // Show error
    } else {
        this.classList.remove("is-invalid");
        errorDiv.style.display = "none";  // Hide error
    }
});
</script>


                                <div class="col-md-4" style="display: none;">
                                    <label for="role" class="mb-2">User</label>
                                    <input type="text" name="userrole" id="userrole" class="form-control" value="2" readonly />
                                </div>
                            </div>

                            <!-- Checkboxes for roles -->
                            <div class="row">
                                @foreach ($usercategory as $item)
                                <div class="mb-3 form-check col-md-2">
                                    <input type="checkbox" name="regid[]" value="{{$item->id}}" class="form-check-input" id="distributerCheck">
                                    <label class="form-check-label" for="distributerCheck">{{$item->role}}</label>
                                </div>
                                @endforeach
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </div>


        </form>

        <div class="card">
            
            <div class="card-row">
                <h2 class="mt-2">User Details</h2>
                <div class="mb-3 mt-2 d-flex col-5 " style="text-align:right">
                    <label style="padding:10px">Search </label>
                    <input type="text" id="searchInput" class="form-control" placeholder="Search by username, email, or role...">
                </div>
        <table class="table">
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
            <tbody id="table-body">
                @foreach ($tab as $item)
                <tr> 
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->password }}</td>
                    <td>{{ $item->role }}</td>

                   <td>
                    <select name="userrole[]">
                        @foreach ($usercategory as $data)
                            <!-- Check if $data->id exists in the array created from userregisterid -->
                            @if(in_array($data->id, explode(',', $item->userregisterid)))
                                <option value="{{ $data->id }}" selected>{{ $data->role }}</option>
                            @endif
                        @endforeach
                    </select>
                </td>
                
                    {{-- <td>{{ $item->userregisterid }}</td> --}}
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton{{ $item->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class='bx bxs-show'></i> Action
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $item->id }}">
                                <li>
                                    {{-- Uncomment the edit link if needed --}} 
                                    <a class="dropdown-item" href="{{ url('/manageaccountdata/'.$item->id) }}" onclick="showToast('edit')">
                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                    </a>
                                </li>
                                <li>
                                    {{-- Uncomment the delete link if needed --}}
                                    <a class="dropdown-item" href="{{ url('/deletedata/'.$item->id) }}" onclick="deleteItem('{{ url('/deleteinvoice/'.$item->id) }}')">
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
        </div>  
    </div>
</div>

<script>
    document.getElementById("searchInput").addEventListener("keyup", function () {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll("#table-body tr");

        rows.forEach(function (row) {
            let username = row.children[0].textContent.toLowerCase();
            let email = row.children[1].textContent.toLowerCase();
            let role = row.children[3].textContent.toLowerCase();

            if (username.includes(filter) || email.includes(filter) || role.includes(filter)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
</script>


<script>
    // Create a mapping of role IDs to role names
const roles = @json($usercategory->pluck('role', 'id'));

// Add event listener to assignid element
document.getElementById('assignid').addEventListener('change', function () {
    // Get the selected user id
    var selectedUserId = this.value;

    // Find the selected user's data from the hierarchy array
    var selectedUser = @json($hierarchy).find(user => user.id == selectedUserId);

    if (selectedUser) {
        document.getElementById('id').value = selectedUser.id;
        document.getElementById('name').value = selectedUser.username;
        document.getElementById('email').value = selectedUser.email;

        // Set the role name based on the selected user's roleid using the roles mapping
        document.getElementById('role').value = roles[selectedUser.roleid] || '';
          document.getElementById('roleid').value = selectedUser.roleid;
    } else {
        // Clear fields if no user is selected
        document.getElementById('id').value = '';
        document.getElementById('name').value = '';
        document.getElementById('role').value = '';
        document.getElementById('email').value = '';
        document.getElementById('roleid').value = '';
    }
});

    </script>