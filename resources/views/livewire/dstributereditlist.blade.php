<div>
    <div class="container">
        <div class="row">
            <form id="form-validation-2" class="form " action="{{ url('/distributeredit/' . $alltabledata->id . '/' . $alltabledata->role) }}" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="row mt-3">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mt-1 mb-1" style="color:green; font-size:20px;">User Details</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                  <!-- Select Dependence -->
                        
                                    <!-- Select Dependence -->
                                    <div class="mb-2 col-md-3">
                                        <label for="dependence" class="mb-2">Select Dependence</label>
                                        <select class="form-control" id="dependence" name="dependence" onchange="checkDependence()">
                                            <option class="text-center" value="">----select Dependence---</option>
                                            @foreach ($usercategory as $item)
                                                <option value="{{ $item->value }}" {{ $alltabledata->dependence == $item->value ? 'selected' : '' }}>
                                                    {{ $item->value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                <!-- Distributor User Id Dropdown -->
                                <div class="mb-2 col-md-3" id="distributorIdDiv" style="display:none;">
                                    <label for="distributorId" class="mb-2">Distributor User Id</label>
                                    <select class="form-control" id="distributorId" name="distributorId">
                                        <option class="text-center" value="">----select Distributor User Id---</option>
                                        @foreach ($alldata as $item)
                                            <option value="{{ $item->registerId }}" {{ $alltabledata->registerId == $item->registerId ? 'selected' : '' }}>
                                                {{ $item->registerId }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                @if($alltabledata->role == 'Dealer')   
                                <!-- Dealer User Id Dropdown -->
                                <div class="mb-2 col-md-3" id="dealerIdDiv" style="display:none;">
                                    <label for="dealerId" class="mb-2">Dealer User Id</label>
                                    <select class="form-control" id="dealerId" name="dealerId">
                                        <option class="text-center" value="">----select Dealer User Id---</option>
                                        @foreach ($dealerData as $item)
                                            <option value="{{ $item->registerId }}" {{ $alltabledata->registerId == $item->registerId ? 'selected' : '' }}>
                                                {{ $item->registerId }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif

                                <!-- Sub Dealer User Id Dropdown -->
                                <div class="mb-2 col-md-3" id="subdealerIdDiv" style="display:none;">
                                    <label for="subdealerId" class="mb-2">Sub Dealer User Id</label>
                                    <select class="form-control" id="subdealerId" name="subdealerId">
                                        <option class="text-center" value="">----select Sub Dealer User Id---</option>
                                        @foreach ($subdealer as $item)
                                            <option value="{{ $item->registerId }}" {{ $alltabledata->registerId == $item->registerId ? 'selected' : '' }}>
                                                {{ $item->registerId }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Retailer User Id Dropdown -->
                                <div class="mb-2 col-md-3" id="retailerIdDiv" style="display:none;">
                                    <label for="retailerid" class="mb-2">Retailer Id</label>
                                    <select class="form-control" id="retailerid" name="retailerid">
                                        <option class="text-center" value="">----select Retailer Id---</option>
                                        @foreach ($retailer as $item)
                                            <option value="{{ $item->registerId }}" {{ $alltabledata->registerId == $item->registerId ? 'selected' : '' }}>
                                                {{ $item->registerId }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                                <script>
                                                    function checkDependence() {
                                                        var dependence = document.getElementById('dependence').value;
                                                        var distributorIdDiv = document.getElementById('distributorIdDiv');
                                                        var dealerIdDiv = document.getElementById('dealerIdDiv');
                                                        var subdealerIdDiv = document.getElementById('subdealerIdDiv');
                                                        var retailerIdDiv = document.getElementById('retailerIdDiv');

                                                        // Hide all dropdowns by default
                                                        distributorIdDiv.style.display = 'none';
                                                        dealerIdDiv.style.display = 'none';
                                                        subdealerIdDiv.style.display = 'none';
                                                        retailerIdDiv.style.display = 'none';

                                                        // Show the correct dropdown based on the selected dependence
                                                        if (dependence === 'Distributor') {
                                                            distributorIdDiv.style.display = 'block';
                                                        } else if (dependence === 'Dealer') {
                                                            dealerIdDiv.style.display = 'block';
                                                        } else if (dependence === 'Sub Dealer') {
                                                            subdealerIdDiv.style.display = 'block';
                                                        } else if (dependence === 'Retailer') {
                                                            retailerIdDiv.style.display = 'block';
                                                        }
                                                    }

                                                    // Check dependence on page load to set the correct dropdown visibility if editing
                                                    document.addEventListener('DOMContentLoaded', function() {
                                                        checkDependence();
                                                    });
                                                </script>



                                 {{-- @if($alltabledata->role == 'Dealer')   
                                <div class="mb-2 col-md-3">
                                    <label for="username" class="mb-2">Dependence Select Id</label>
                                    <input class="form-control" type="text" id="distributeriddata" name="distributeriddata" value="{{$alltabledata->distributerid}}">
                                </div>
                                @endif
                                @if($alltabledata->role == 'Sub Dealer')   
                                <div class="mb-2 col-md-3">
                                    <label for="username" class="mb-2">Dependence Select Id</label>
                                    <input class="form-control" type="text" id="dealeriddata" name="dealeriddata" value="{{$alltabledata->dealerreg}}">
                                </div>
                                @endif
                                @if($alltabledata->role == 'Retailer')   
                                <div class="mb-2 col-md-3">
                                    <label for="username" class="mb-2">Dependence Select Id</label>
                                    <input class="form-control" type="text" id="subdealeriddata" name="subdealeriddata" value="{{$alltabledata->subregid}}">
                                </div>
                                @endif
                                @if($alltabledata->role == 'Employee')   
                                <div class="mb-2 col-md-3">
                                    <label for="username" class="mb-2">Dependence Select Id</label>
                                    <input class="form-control" type="text" id="reregisteriddata" name="reregisteriddata" value="{{$alltabledata->reregister}}">
                                </div>
                                @endif
                                 --}}





                                    <div class="mb-2 col-md-3">
                                        <label for="username" class="mb-2">User Register Id</label>
                                        <input class="form-control" type="text" id="registerid" name="registerid" value="{{$alltabledata->registerId}}">
                                    </div>

                                    <div class="mb-2 col-md-3">
                                        <label for="username" class="mb-2">User Name </label>
                                        <input class="form-control" type="text" id="username" name="username"  value="{{$alltabledata->username}}">
                                    </div>
                                <div class="mb-2 col-md-3">
                                    <label for="username" class="mb-2">Select Role</label>
                                    <select class="form-control" type="text" id="role" name="role">
                                        <option class="text-center" value=" ">----select Role---</option>
                                        @foreach ($usercategory as $item)
                                        <option value="{{$item->value}}" <?php if($alltabledata->role == $item->value){echo 'selected';}?>>{{$item->value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            
                                <div class="mb-2 col-md-3">
                                    <label for="username" class89="mb-2">Contact NO.</label>
                                    <input class="form-control" type="text" id="contactno" name="contactno" value="{{$alltabledata->contactno}}">
                                </div>

                                <div class="mb-2 col-md-3">
                                    <label for="email" class="mb-2">Alternative Number</label>
                                    <input class="form-control" type="text" id="alternativenum" name="alternativenum" value="{{$alltabledata->alternativenum}}">
                                </div>

                                <div class="mb-2 col-md-3">
                                    <label for="username" class="mb-2">Email Address</label>
                                    <input class="form-control" type="text" id="email" name="email" value="{{$alltabledata->email}}">
                                </div>

                               
                                <div class="mb-2 col-md-3">
                                    <label for="email" class="mb-2">Upload Image</label>
                                    <input class="form-control" type="file" name="file" multiple value="{{$alltabledata->file}}">
                                </div>
                                

                            </div>
 
                        </div><!--end card-body-->
                            </div>
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
                                            <input class="form-control" type="text" id="companyname" name="companyname" value="{{$alltabledata->companyname}}">
                                        </div>

                                        <div class="mb-2 col-md-6">
                                            <label for="email" class="mb-2">Date</label>
                                            <input class="form-control" type="date" id="insertdate" name="insertdate" value="{{$alltabledata->insertdate}}">
                                        </div>

                                       
                                        <div class="mb-2 col-md-4">
                                            <label for="email" class="mb-2">GST Number</label>
                                            <input class="form-control" type="text" id="gstcode" name="gstcode" value="{{$alltabledata->gstcode}}">
                                        </div>
        
                                        <div class="mb-2 col-md-4">
                                            <label for="email" class="mb-2">PIN Code</label>
                                            <input class="form-control" type="text" id="pincode" name="pincode" value="{{$alltabledata->pincode}}">
                                        </div>

                                        
                                        <div class="mb-2 col-md-4">
                                            <label for="email" class="mb-2">City</label>
                                            <input class="form-control" type="text" id="city" name="city" value="{{$alltabledata->city}}">
                                        </div>
                                        <div class="mb-2 col-md-3">
                                            <label for="email" class="mb-2">State</label>
                                            <input class="form-control" type="text" id="state" name="state" value="{{$alltabledata->state}}">
                                        </div>
        
                                        <div class="mb-2 col-md-3">
                                            <label for="email" class="mb-2">tehsils</label>
                                            <input class="form-control" type="text" id="tehsils" name="tehsils" value="{{$alltabledata->tehsils}}">
                                        </div>


                                        <div class="mb-2 col-md-3">
                                            <label for="email" class="mb-2">Region</label>
                                            <input class="form-control" type="text" id="region" name="region" value="{{$alltabledata->region}}">
                                        </div>


                                        <div class="mb-2 col-md-3">
                                            <label for="email" class="mb-2">Postal / Zip Code</label>
                                            <input class="form-control" type="text" id="postalcode" name="postalcode" value="{{$alltabledata->postalcode}}">
                                        </div>
        

                                        <div class="mb-2 col-md-12">
                                            <label for="email" class="mb-2">Address</label>
                                            <textarea class="form-control" type="text" id="address" name="address">{{$alltabledata->address}}</textarea>
                                        </div>
                                       
                                        </div>
                                    </div>
                                </div></div>

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
                    <input class="form-control" type="text" id="bankname" name="bankname" value="{{$alltabledata->bankname}}">
                </div>

                <div class="mb-2 col-md-6">
                    <label for="email" class="mb-2">Bank Account Number</label>
                    <input class="form-control" type="text" id="accountnumber" name="accountnumber" value="{{$alltabledata->bankname}}">
                </div>

                <div class="mb-2 col-md-6">
                    <label for="email" class="mb-2">Account IFSC Code</label>
                    <input class="form-control" type="text" id="ifsccode" name="ifsccode" value="{{$alltabledata->ifsccode}}">
                </div>

                <div class="mb-2 col-md-3">
                    <label for="email" class="mb-2">Account Holder Name</label>
                    <input class="form-control" type="text" id="holdername" name="holdername" value="{{$alltabledata->holdername}}">
                </div>

                <div class="mb-2 col-md-3">
                    <label for="email" class="mb-2">Account type</label>
                <select class="form-control" type="text" id="accounttype" name="accounttype" value="{{$alltabledata->accounttype}}">
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