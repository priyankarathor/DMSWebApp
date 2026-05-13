<div>
    <div class="container">
        <div class="row">
            <form id="form-validation-2" class="form " action="{{route('distrinuterinserthierarchy')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row mt-3">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mt-1 mb-1" style="color:green; font-size:20px;">User Details</h4>
                        </div>
                        <div class="row">


                            <div class="card-body">
                        <div class="card-body">

                        
            <div class="card">
                <div class="card-body">

                {{-- FIRST DEPENDENCE: only for userrole <= 7 --}}
        {{-- FIRST DEPENDENCE --}}
<div class="row mb-4">

    <div class="mb-2 col-md-3">
        <label for="dependence1" class="mb-2">Select User Dependence</label>

        <select class="form-control" id="dependence1" name="dependence1"
            onchange="filterUsersByRole('dependence1','zonalId','userid1','username1','region1')">

            <option value="">----Select Dependence----</option>

            @foreach ($usercategory as $item)
                @if($item->category == 'second role')
                    <option value="{{ $item->id }}"
                        {{ (string)($firstRoleId ?? '') === (string)$item->id ? 'selected' : '' }}>
                        {{ $item->role }}
                    </option>
                @endif
            @endforeach
        </select>
    </div>

    <div class="mb-2 col-md-3">
        <label for="zonalId" class="mb-2">User ID</label>

        <select class="form-control" id="zonalId" name="zonalId"
            onchange="updateUserDetails('zonalId','userid1','username1','region1')">

            <option value="">----Select User ID----</option>

            @foreach ($hierarchy as $data)
                <option value="{{ $data->id }}"
                    data-id="{{ $data->id }}"
                    data-roleid="{{ $data->roleid }}"
                    data-username="{{ $data->username }}"
                    data-region="{{ $data->state }}"
                    data-registerid="{{ $data->registerid }}"
                    {{ (string)($firstUserId ?? '') === (string)$data->id ? 'selected' : '' }}>
                    {{ $data->registerid }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-2 col-md-3 d-none">
        <label for="userid1" class="mb-2">User Details Id</label>
        <input type="text" class="form-control" id="userid1" name="userid" readonly
            value="{{ $firstUserId ?? '' }}">
    </div>

    <div class="mb-2 col-md-3">
        <label for="username1" class="mb-2">Dependence Username</label>
        <input type="text" class="form-control" id="username1" name="username1" readonly
            value="{{ $firstUsername ?? '' }}">
    </div>

    <div class="mb-2 col-md-3">
        <label for="region1" class="mb-2">Dependence Region</label>
        <input type="text" class="form-control" id="region1" name="region1" readonly
            value="{{ $firstState ?? '' }}">
    </div>

</div>


{{-- SECOND DEPENDENCE --}}
<div class="row mb-4">

    <div class="mb-2 col-md-3">
        <label for="dependence2" class="mb-2">Select Dependence</label>

        <select class="form-control" id="dependence2" name="dependence"
            onchange="filterUsersByRole('dependence2','assignid2','userid2','username2','region2')">

            <option value="">----Select Dependence----</option>

            @foreach ($usercategory as $item)
                <option value="{{ $item->id }}"
                    {{ ((int)($userrole ?? 0) > 7 && (string)($secondRoleId ?? '') === (string)$item->id) ? 'selected' : '' }}>
                    {{ $item->role }}
                </option>
            @endforeach

        </select>
    </div>

    <div class="mb-2 col-md-3">
        <label for="assignid2" class="mb-2">User ID</label>

        <select class="form-control" id="assignid2" name="assignid"
            onchange="updateUserDetails('assignid2','userid2','username2','region2')">

            <option value="">----Select User ID----</option>

            @foreach ($hierarchy as $data)
                <option value="{{ $data->id }}"
                    data-id="{{ $data->id }}"
                    data-roleid="{{ $data->roleid }}"
                    data-username="{{ $data->username }}"
                    data-region="{{ $data->state }}"
                    data-registerid="{{ $data->registerid }}"
                    {{ ((int)($userrole ?? 0) > 7 && (string)($secondUserId ?? '') === (string)$data->id) ? 'selected' : '' }}>
                    {{ $data->registerid }}
                </option>
            @endforeach

        </select>
    </div>

    <div class="mb-2 col-md-3 d-none">
        <label for="userid2" class="mb-2">User Details Id</label>
        <input type="text" class="form-control" id="userid2" name="assign_userid" readonly
            value="{{ ((int)($userrole ?? 0) > 7) ? ($secondUserId ?? '') : '' }}">
    </div>

    <div class="mb-2 col-md-3">
        <label for="username2" class="mb-2">Dependence Username</label>
        <input type="text" class="form-control" id="username2" name="username2" readonly
            value="{{ ((int)($userrole ?? 0) > 7) ? ($secondUsername ?? '') : '' }}">
    </div>

    <div class="mb-2 col-md-3">
        <label for="region2" class="mb-2">Dependence Region</label>
        <input type="text" class="form-control" id="region2" name="region2" readonly
            value="{{ ((int)($userrole ?? 0) > 7) ? ($secondState ?? '') : '' }}">
    </div>

<script>
    function updateUserDetails(userSelectId, hiddenUserId, usernameId, regionId) {
        const userSelect = document.getElementById(userSelectId);
        const hiddenInput = document.getElementById(hiddenUserId);
        const usernameInput = document.getElementById(usernameId);
        const regionInput = document.getElementById(regionId);

        if (!userSelect) return;

        const selectedOption = userSelect.options[userSelect.selectedIndex];

        if (!selectedOption || selectedOption.value === "") {
            if (hiddenInput) hiddenInput.value = "";
            if (usernameInput) usernameInput.value = "";
            if (regionInput) regionInput.value = "";
            return;
        }

        const id = selectedOption.getAttribute("data-id") || selectedOption.value;
        const username = selectedOption.getAttribute("data-username") || "";
        const region = selectedOption.getAttribute("data-region") || "";

        if (hiddenInput) hiddenInput.value = id;
        if (usernameInput) usernameInput.value = username;
        if (regionInput) regionInput.value = region;
    }

    function filterUsersByRole(roleSelectId, userSelectId, hiddenUserId, usernameId, regionId) {
        const roleSelect = document.getElementById(roleSelectId);
        const userSelect = document.getElementById(userSelectId);

        if (!roleSelect || !userSelect) return;

        const selectedRoleId = roleSelect.value;
        const options = userSelect.querySelectorAll("option");

        options.forEach(option => {
            const optionRoleId = option.getAttribute("data-roleid");

            if (option.value === "") {
                option.style.display = "";
                return;
            }

            if (selectedRoleId === "") {
                option.style.display = "";
                return;
            }

            option.style.display = optionRoleId == selectedRoleId ? "" : "none";
        });

        const selectedOption = userSelect.options[userSelect.selectedIndex];

        if (!selectedOption || selectedOption.style.display === "none") {
            userSelect.value = "";

            for (let option of options) {
                if (option.value !== "" && option.style.display !== "none") {
                    userSelect.value = option.value;
                    break;
                }
            }
        }

        updateUserDetails(userSelectId, hiddenUserId, usernameId, regionId);
    }

    document.addEventListener("DOMContentLoaded", function () {
        const userrole = parseInt(@json($userrole ?? 0));

        /*
        |--------------------------------------------------------------------------
        | FIRST DEPENDENCE
        |--------------------------------------------------------------------------
        | First row me zonalId wali ID ka data direct show hoga.
        | Isme role filter force nahi karna.
        */
        updateUserDetails('zonalId', 'userid1', 'username1', 'region1');

        /*
        |--------------------------------------------------------------------------
        | SECOND DEPENDENCE
        |--------------------------------------------------------------------------
        | Sirf role > 7 par second dependence auto-fill hoga.
        */
        if (userrole > 7) {
            filterUsersByRole('dependence2', 'assignid2', 'userid2', 'username2', 'region2');
        } else {
            const userid2 = document.getElementById('userid2');
            const username2 = document.getElementById('username2');
            const region2 = document.getElementById('region2');

            if (userid2) userid2.value = "";
            if (username2) username2.value = "";
            if (region2) region2.value = "";
        }
    });
</script>


                            <div class="mb-2 col-md-3 d-none">
                                <label for="registerid" class="mb-2">User Register Id</label>
                                <span style="color:red;">*</span>
                                <input class="form-control" type="text" id="registerid" name="registerid" readonly required>
                            </div>

                            <div class="mb-2 col-md-3">
                                <label for="username" class="mb-2">User Name </label>
                                <span style="color:red;">*</span>
                                <input class="form-control" type="text" id="username" name="username" required>
                            </div>

                            <div class="mb-2 col-md-3">
                                <label for="dependence" class="mb-2">Select Role</label>
                                <span style="color:red;">*</span>
                                <select class="form-control" id="dependence" name="dependence" required>
                                    <option class="text-center" value="">----select Dependence---</option>
                                    @foreach ($usercategory as $item)
                                    <option value="{{ $item->id }}">{{ $item->role }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <script>
document.addEventListener('DOMContentLoaded', function () {
    const roleSelect = document.getElementById('dependence');
    const registerIdInput = document.getElementById('registerid');

    if (roleSelect) {
        roleSelect.addEventListener('change', function () {
            let roleId = this.value;

            if (roleId) {
                fetch(`/get-register-id/${roleId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.status) {
                            registerIdInput.value = data.registerid;
                        } else {
                            registerIdInput.value = '';
                            // alert(data.message || 'Unable to generate Register ID');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        registerIdInput.value = '';
                        // alert('Something went wrong while generating Register ID');
                    });
            } else {
                registerIdInput.value = '';
            }
        });
    }
});
</script>

                            <div class="mb-2 col-md-3">
                                <label for="username" class89="mb-2">Contact NO.</label>
                                <span style="color:red;">*</span>
                                <!--<input class="form-control" type="text" id="contactno" name="contactno" required>-->

                                <input
                                    class="form-control"
                                    type="text"
                                    id="contactno"
                                    name="contactno"
                                    maxlength="10"
                                    pattern="\d{10}"
                                    title="Please enter exactly 10 digits"
                                    required>
                            </div>

                            <script>
                                const contactInput = document.getElementById('contactno');

                                contactInput.addEventListener('input', function() {
                                    // Remove non-numeric characters
                                    this.value = this.value.replace(/[^0-9]/g, '');
                                });
                            </script>

                            <div class="mb-2 col-md-3">
                                <label for="email" class="mb-2">Alternative Number</label>
                                <input
                                    class="form-control"
                                    type="number"
                                    id="alternativenum"
                                    name="alternativenum"
                                    maxlength="10"
                                    pattern="\d{10}"
                                    title="Please enter exactly 10 digits">

                                <script>
                                    const contactInput = document.getElementById('alternativenum');

                                    contactInput.addEventListener('input', function() {
                                        // Remove non-numeric characters
                                        this.value = this.value.replace(/[^0-9]/g, '');
                                    });
                                </script>
                            </div>

                            <div class="mb-2 col-md-3">
                                <label for="username" class="mb-2">Email Address</label>
                                <span style="color:red;">*</span>
                                <input class="form-control" type="email" id="email" name="email" required>
                            </div>


                            <div class="mb-2 col-md-3">
                                <label for="image" class="mb-2">Upload Image</label>
                                <input class="form-control"
                                    type="file"
                                    name="file"
                                    accept="image/*">
                            </div>


                            <div class="mb-2 col-md-3">
                                <label for="username" class="mb-2">Udyam Card</label>
                                <input class="form-control" type="text" id="udyamcard" name="udyamcard">
                            </div>
                        </div>
                    </div>
                </div><!--end card-body-->
        </div>

        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mt-1 mb-1" style="color:green; font-size:20px;">Company Details</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="mb-2 col-md-6">
                            <label for="username" class="mb-2">Firm Name</label>
                            <input class="form-control" type="text" id="companyname" name="companyname">
                        </div>



                        <div class="mb-2 col-md-6">
                            <label for="insertdate" class="mb-2">Date</label>
                            <input class="form-control" type="date" id="insertdate" name="insertdate">
                        </div>

                        <script>
                            // Set the current date
                            const dateInput = document.getElementById('insertdate');
                            const today = new Date();

                            // Format the date as YYYY-MM-DD
                            const formattedDate = today.toISOString().split('T')[0];
                            dateInput.value = formattedDate;
                        </script>


                        <div class="mb-2 col-md-4">
                            <label for="email" class="mb-2">GST Number</label>
                            <input class="form-control" type="text" id="gstcode" name="gstcode">
                        </div>

                        <div class="mb-2 col-md-4" style="display:none;">
                            <label for="email" class="mb-2">PIN Code</label>
                            <input class="form-control" type="text" id="pincode" name="pincode">
                        </div>


                        <div class="mb-2 col-md-4">
                            <label for="email" class="mb-2">City</label>
                            <span style="color:red;">*</span>
                            <input class="form-control" type="text" id="city" name="city" required>
                        </div>
                        <div class="mb-2 col-md-4">
                            <label for="email" class="mb-2">State</label>
                            <span style="color:red;">*</span>
                            <input class="form-control" type="text" id="state" name="state" required>
                        </div>

                        <div class="mb-2 col-md-4">
                            <label for="email" class="mb-2">tehsils</label>
                            <input class="form-control" type="text" id="tehsils" name="tehsils">
                        </div>


                        <div class="mb-2 col-md-4">
                            <label for="email" class="mb-2">Region</label>
                            <span style="color:red;">*</span>
                            <input class="form-control" type="text" id="region" name="region" required>
                        </div>


                        <div class="mb-2 col-md-4">
                            <label for="email" class="mb-2">Postal / Zip Code</label>
                            <input class="form-control" type="text" id="postalcode" name="postalcode">
                        </div>


                        <div class="mb-2 col-md-12">
                            <label for="email" class="mb-2">Address</label>
                            <span style="color:red;">*</span>
                            <textarea class="form-control" type="text" id="address" name="address" required></textarea>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!--start bank details-->
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mt-1 mb-1" style="color:green; font-size:20px;">Bank Details</h4>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="mb-2 col-md-6">
                            <label for="email" class="mb-2">Bank Name</label>
                            <input class="form-control" type="text" id="bankname" name="bankname">
                        </div>

                        <div class="mb-2 col-md-6">
                            <label for="email" class="mb-2">Bank Account Number</label>
                            <input class="form-control" type="text" id="accountnumber" name="accountnumber">
                        </div>

                        <div class="mb-2 col-md-6">
                            <label for="email" class="mb-2">Account IFSC Code</label>
                            <input class="form-control" type="text" id="ifsccode" name="ifsccode">
                        </div>

                        <div class="mb-2 col-md-3">
                            <label for="email" class="mb-2">Account Holder Name</label>
                            <input class="form-control" type="text" id="holdername" name="holdername">
                        </div>

                        <div class="mb-2 col-md-3">
                            <label for="email" class="mb-2">Account type</label>
                            <select class="form-control" type="text" id="accounttype" name="accounttype">
                                <option value="Current">Current</option>
                                <option value="Saving">Saving</option>

                            </select>
                        </div>

                        <div class="col-md-12 my-3">
                            <input type="submit" style="font-size:18px;  border-radius:10px;" class="btn btn-success" value="Submit" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end bank details-->

    </div>
    </form><!--end form-->
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const amountRowsContainer = document.getElementById('amount-rows');
        const addRowButton = document.getElementById('add-row');

        // Function to clone a row
        function cloneRow(row) {
            const newRow = row.cloneNode(true);
            const inputs = newRow.querySelectorAll('input, select, textarea');
            inputs.forEach(input => input.value = ''); // Clear the values

            // Show the 'Remove' button on cloned rows
            const removeButton = newRow.querySelector('.remove-row');
            if (removeButton) {
                removeButton.style.display = 'inline-block'; // Make sure the 'Remove' button is visible on new rows
            }

            return newRow;
        }

        // Add event listener to the 'Add Row' button
        addRowButton.addEventListener('click', () => {
            const firstRow = amountRowsContainer.querySelector('.amount-row');
            if (firstRow) {
                const newRow = cloneRow(firstRow);
                amountRowsContainer.appendChild(newRow);

                // Ensure the 'Remove' button is hidden for the first row
                const firstRemoveButton = firstRow.querySelector('.remove-row');
                if (firstRemoveButton) {
                    firstRemoveButton.style.display = 'none'; // Hide 'Remove' button on the first row
                }
            }
        });

        // Add event delegation to handle 'Remove' button clicks
        amountRowsContainer.addEventListener('click', (event) => {
            if (event.target.classList.contains('remove-row')) {
                const row = event.target.closest('.amount-row');
                if (row && amountRowsContainer.children.length > 1) {
                    row.remove();
                }
            }

            // Ensure the 'Remove' button is hidden for the first row after a row is removed
            const firstRow = amountRowsContainer.querySelector('.amount-row');
            if (firstRow) {
                const firstRemoveButton = firstRow.querySelector('.remove-row');
                if (firstRemoveButton) {
                    firstRemoveButton.style.display = 'none'; // Always hide 'Remove' button on the first row
                }
            }
        });

        // Hide 'Remove' button for the first row on page load
        const firstRemoveButton = amountRowsContainer.querySelector('.amount-row .remove-row');
        if (firstRemoveButton) {
            firstRemoveButton.style.display = 'none'; // Hide 'Remove' button on the first row initially
        }
    });
</script>
</div>
</div>

</div>