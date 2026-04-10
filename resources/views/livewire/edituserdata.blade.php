<div>
    <div class="container">
        <div class="row">
            <form id="form-validation-2" class="form " action="{{ url('/editdistributer/' . $userdata->id) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="row mt-3">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mt-1 mb-1" style="color:green; font-size:20px;">User Details</h4>
                        </div>
                        <div class="row">
                            <div class="card-body">
                       <div class="row">
                        <div class="row">
                            <!-- Select Dependence Dropdown -->
                            <div class="mb-2 col-md-3">
                                <label for="dependence" class="mb-2">Select Dependence</label>
                                <select class="form-control" id="dependence" name="dependence" onchange="filterDistributors()">
                                    <option class="text-center" value="">----Select Dependence----</option>
                                    @foreach ($usercategory as $item)
                                        @php
                                            $isSelected = false;
                                            foreach ($hierarchy as $data) {
                                                if ($userdata->assignid == $data->id && $data->roleid == $item->id) {
                                                    $isSelected = true;
                                                    break;
                                                }
                                            }
                                        @endphp
                                        <option value="{{ $item->id }}" data-roleid="{{ $item->role }}" {{ $isSelected ? 'selected' : '' }}>
                                            {{ $item->role }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <!-- User ID Dropdown -->
                            <div class="mb-2 col-md-3">
                                <label for="assignid" class="mb-2">User ID</label>
                                <select class="form-control" id="assignid" name="assignid" onchange="updateUsernameAndRegion()">
                                    <option class="text-center" value="">----Select User ID----</option>
                                    @foreach ($hierarchy as $data)
                                        <option value="{{ $data->id }}" data-roleid="{{ $data->roleid }}" 
                                                data-username="{{ $data->username }}" data-region="{{ $data->region }}"
                                                {{ $userdata->assignid == $data->id ? 'selected' : '' }}>
                                            {{ $data->registerid }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <!-- Username Dropdown -->
                            <div class="mb-2 col-md-3">
                                <label for="username" class="mb-2">Dependence Username</label>
                                <select class="form-control" id="username" name="username" disabled>
                                    <option value="">----Dependence Username----</option>
                                    @foreach ($hierarchy as $data)
                                    <option value="{{ $data->id }}" data-roleid="{{ $data->roleid }}" 
                                            data-username="{{ $data->username }}" data-region="{{ $data->region }}"
                                            {{ $userdata->assignid == $data->id ? 'selected' : '' }}>
                                        {{ $data->username }}
                                    </option>
                                @endforeach
                                </select>
                            </div>
                        
                            <!-- Region Dropdown -->
                            <div class="mb-2 col-md-3">
                                <label for="region" class="mb-2">Dependence Region</label>
                                <select class="form-control" id="region" name="region" disabled>
                                    <option value="">----Dependence Region----</option>
                                    @foreach ($hierarchy as $data)
                                    <option value="{{ $data->id }}" data-roleid="{{ $data->roleid }}" 
                                            data-username="{{ $data->username }}" data-region="{{ $data->region }}"
                                            {{ $userdata->assignid == $data->id ? 'selected' : '' }}>
                                        {{ $data->region }}
                                    </option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <script>
                            function filterDistributors() {
                                const dependenceId = document.getElementById("dependence").value;
                                const userIdDropdown = document.getElementById("assignid");
                                const options = userIdDropdown.getElementsByTagName("option");
                        
                                // Filter User ID options
                                for (let i = 0; i < options.length; i++) {
                                    const roleId = options[i].getAttribute("data-roleid");
                                    if (roleId === dependenceId || options[i].value === "") {
                                        options[i].style.display = "";
                                    } else {
                                        options[i].style.display = "none";
                                    }
                                }
                        
                                // Reset dependent fields
                                userIdDropdown.value = "";
                                updateUsernameAndRegion();
                            }
                        
                            function updateUsernameAndRegion() {
                                const userIdDropdown = document.getElementById("assignid");
                                const selectedOption = userIdDropdown.options[userIdDropdown.selectedIndex];
                        
                                const username = selectedOption ? selectedOption.getAttribute("data-username") : "";
                                const region = selectedOption ? selectedOption.getAttribute("data-region") : "";
                        
                                // Update Username dropdown
                                const usernameDropdown = document.getElementById("username");
                                usernameDropdown.innerHTML = `<option>${username || "----Dependence Username----"}</option>`;
                                usernameDropdown.disabled = !username;
                        
                                // Update Region dropdown
                                const regionDropdown = document.getElementById("region");
                                regionDropdown.innerHTML = `<option>${region || "----Dependence Region----"}</option>`;
                                regionDropdown.disabled = !region;
                            }
                        </script>
                        


                        </div>


                            </div>

                           


                            <div class="mb-2 col-md-3">
                                <label for="username" class="mb-2">User Register Id</label>
                                <input class="form-control" type="text" id="registerid" name="registerid"
                                    value="{{ $userdata->registerid }}">
                            </div>

                            <div class="mb-2 col-md-3">
                                <label for="username" class="mb-2">User Name </label>
                                <input class="form-control" type="text" id="username" name="username"
                                    value="{{ $userdata->username }}">
                            </div>
                            <div class="mb-2 col-md-3">
                                <label for="username" class="mb-2">Select Role</label>
                                <select class="form-control" name="roleid">
                                    @foreach ($usercategory as $item)
                                        <option value="{{ $item->id }}" 
                                            @if($item->id == $userdata->roleid) selected @endif>
                                            {{ $item->role }}
                                        </option>
                                    @endforeach
                                </select>
                                
                            </div>

                            <div class="mb-2 col-md-3">
                                <label for="username" class89="mb-2">Contact NO.</label>
                                <input class="form-control" type="text" id="contactno" name="contactno"
                                    value="{{ $userdata->contactno }}">
                            </div>

                            <div class="mb-2 col-md-3">
                                <label for="email" class="mb-2">Alternative Number</label>
                                <input class="form-control" type="text" id="alternativenum" name="alternativenum"
                                    value="{{ $userdata->alternativenum }}">
                            </div>

                            <div class="mb-2 col-md-3">
                                <label for="username" class="mb-2">Email Address</label>
                                <input class="form-control" type="text" id="email" name="email"
                                    value="{{ $userdata->email }}">
                            </div>


                            <div class="mb-2 col-md-3">
                                <label for="email" class="mb-2">Upload Image</label>
                                <input class="form-control" type="file" name="file"
                                    value="{{ $userdata->file }}">
                            </div>
                          
                          <div class="mb-2 col-md-3">
                                    <label for="username" class="mb-2">Udyam Card</label>
                                    <input class="form-control" type="text" id="udyamcard" name="udyamcard" value="{{ $userdata->udyamcard }}">
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
                        <label for="username" class="mb-2">Farm Name</label>
                        <input class="form-control" type="text" id="companyname" name="companyname"
                            value="{{ $userdata->framname }}">
                    </div>

                    <div class="mb-2 col-md-6">
                        <label for="email" class="mb-2">Date</label>
                        <input class="form-control" type="date" id="insertdate" name="insertdate"
                            value="{{ $userdata->insertdate }}">
                    </div>


                    <div class="mb-2 col-md-4">
                        <label for="email" class="mb-2">GST Number</label>
                        <input class="form-control" type="text" id="gstcode" name="gstcode"
                            value="{{ $userdata->gstcode }}">
                    </div>

                    <div class="mb-2 col-md-4">
                        <label for="email" class="mb-2">PIN Code</label>
                        <input class="form-control" type="text" id="pincode" name="pincode"
                            value="{{ $userdata->pincode }}">
                    </div>


                    <div class="mb-2 col-md-4">
                        <label for="email" class="mb-2">City</label>
                        <input class="form-control" type="text" id="city" name="city"
                            value="{{ $userdata->city }}">
                    </div>
                    <div class="mb-2 col-md-3">
                        <label for="email" class="mb-2">State</label>
                        <input class="form-control" type="text" id="state" name="state"
                            value="{{ $userdata->state }}">
                    </div>

                    <div class="mb-2 col-md-3">
                        <label for="email" class="mb-2">tehsils</label>
                        <input class="form-control" type="text" id="tehsils" name="tehsils"
                            value="{{ $userdata->tehsils }}">
                    </div>


                    <div class="mb-2 col-md-3">
                        <label for="email" class="mb-2">Region</label>
                        <input class="form-control" type="text" id="region" name="region"
                            value="{{ $userdata->region }}">
                    </div>


                    <div class="mb-2 col-md-3">
                        <label for="email" class="mb-2">Postal / Zip Code</label>
                        <input class="form-control" type="text" id="postalcode" name="postalcode"
                            value="{{ $userdata->postalcode }}">
                    </div>


                    <div class="mb-2 col-md-12">
                        <label for="email" class="mb-2">Address</label>
                        <textarea class="form-control" type="text" id="address" name="address" value="{{ $userdata->address }}">{{ $userdata->address }}</textarea>
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
                        <input class="form-control" type="text" id="bankname" name="bankname"
                            value="{{ $userdata->bankname }}">
                    </div>

                    <div class="mb-2 col-md-6">
                        <label for="email" class="mb-2">Bank Account Number</label>
                        <input class="form-control" type="text" id="accountnumber" name="accountnumber"
                            value="{{ $userdata->accountnum }}">
                    </div>

                    <div class="mb-2 col-md-6">
                        <label for="email" class="mb-2">Account IFSC Code</label>
                        <input class="form-control" type="text" id="ifsccode" name="ifsccode"
                            value="{{ $userdata->ifsccode }}">
                    </div>

                    <div class="mb-2 col-md-3">
                        <label for="email" class="mb-2">Account Holder Name</label>
                        <input class="form-control" type="text" id="holdername" name="holdername"
                            value="{{ $userdata->holdername }}">
                    </div>

                    <div class="mb-2 col-md-3">
                        <label for="email" class="mb-2">Account type</label>
                        <select class="form-control" type="text" id="accounttype" name="accounttype">
                            <option value="Current" value="{{ $userdata->accounttype }}">Current</option>
                            <option value="Saving" value="{{ $userdata->accounttype }}">Saving</option>

                        </select>
                    </div>

                    <div class="col-md-12 my-3">
                        <input type="submit" style="font-size:18px;  border-radius:10px;" class="btn btn-success"
                            value="Submit" />
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
    const container = document.getElementById('amount-rows');
    const addBtn = document.getElementById('add-row');

    function calculateAmount(row) {
        const quantityInput = row.querySelector('.quantity');
        const priceInput = row.querySelector('.price');
        const amountInput = row.querySelector('.amount');

        const quantity = parseFloat(quantityInput.value) || 0;
        const price = parseFloat(priceInput.value) || 0;
        const total = quantity * price;
        amountInput.value = total.toFixed(2);
    }

    function attachEventListeners(row) {
        const quantityInput = row.querySelector('.quantity');
        const priceInput = row.querySelector('.price');

        quantityInput.addEventListener('input', () => calculateAmount(row));
        priceInput.addEventListener('input', () => calculateAmount(row));
    }

    // Attach to first row
    attachEventListeners(container.querySelector('.amount-row'));

    addBtn.addEventListener('click', () => {
        const firstRow = container.querySelector('.amount-row');
        const newRow = firstRow.cloneNode(true);

        // Reset values
        newRow.querySelectorAll('input').forEach(input => {
            if (input.type !== 'button') input.value = '';
            if (input.classList.contains('amount')) input.readOnly = true;
        });

        // Show remove button
        const removeBtn = newRow.querySelector('.remove-row');
        removeBtn.style.display = 'inline-block';

        container.appendChild(newRow);
        attachEventListeners(newRow);
    });

    // Remove row
    container.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-row')) {
            const row = e.target.closest('.amount-row');
            if (container.children.length > 1) row.remove();
        }
    });

    // Initially hide remove button for the first row
    const firstRemove = container.querySelector('.remove-row');
    if (firstRemove) firstRemove.style.display = 'none';
});
</script>

</div>
</div>

</div>