<div>
    <div class="container">
        <div class="row">
            <form id="form-validation-2" class="form " action="{{ url('/insertorder/'.$value->id) }}" method="post">
                @csrf
                <div class="col-lg-12 mt-3">
                    <div class="card">
                        {{-- <div class="card-header">
                            <h4 class="card-title" style="color:#115e0f; font-size:20px;">Invoice Details</h4>

                        </div><!--end card-header--> --}}
                        <div class="card-body">
                            <div class="row">
                            
                                <div class="col-md-6 mb-3">
                                    <label for="invoicenum" class="form-label">Invoice Number</label>
                                    <input type="text" class="form-control" name="invoicenum" id="invoicenumber" required readonly data-invoiceno="<?php echo htmlspecialchars($lastnum->invoiceno ?? ''); ?>">
                                </div>
                                
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        setInvoiceNumber();
                                    });
                                
                                
                                  function setInvoiceNumber() {
                                        const currentDate = new Date();
                                        const currentYearFull = currentDate.getFullYear();           // e.g., 2025
                                        const currentYearShort = currentYearFull.toString().slice(-2); // "25"
                                        const nextYearShort = (currentYearFull + 1).toString().slice(-2); // "26"
                                    
                                        // Retrieve the last invoice number from the backend (using data-invoiceno attribute)
                                        const invoiceInput = document.getElementById('invoicenumber');
                                        const lastInvoiceNum = invoiceInput.getAttribute('data-invoiceno');
                                    
                                        const lastInvoiceYear = lastInvoiceNum ? lastInvoiceNum.split('/')[1].split('-')[0] : null;
                                        let lastInvoiceNumber = lastInvoiceNum ? parseInt(lastInvoiceNum.split('/')[2]) : 0;
                                    
                                        if (!lastInvoiceNum) {
                                            lastInvoiceNumber = 1;
                                        } else if (lastInvoiceYear !== currentYearShort) {
                                            lastInvoiceNumber = 1;
                                        } else {
                                            lastInvoiceNumber += 1;
                                        }
                                    
                                        const invoiceNumberFormatted = lastInvoiceNumber.toString().padStart(2, '0');
                                        invoiceInput.value = `VML/${currentYearShort}-${nextYearShort}/${invoiceNumberFormatted}`;
                                    }

                                
                                    document.querySelector('form').addEventListener('submit', function(e) {
                                        setInvoiceNumber(); // Set and display the incremented invoice number on form submission
                                    });
                                </script>
                                
                                <div class="mb-2 col-md-6">
                                    <label for="email" class="mb-2">Invoice Date</label>
                                    <input type="date" class="form-control" id="invoicedate" name="invoicedate"
                                        aria-describedby="emailHelp">
                                </div>
                                <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                        // Get the current date
                                        var today = new Date();

                                        // Format the date as YYYY-MM-DD
                                        var yyyy = today.getFullYear();
                                        var mm = String(today.getMonth() + 1).padStart(2, '0'); // Months are zero-based
                                        var dd = String(today.getDate()).padStart(2, '0');

                                        var formattedDate = yyyy + '-' + mm + '-' + dd;

                                        // Set the value of the date input field
                                        document.getElementById('invoicedate').value = formattedDate;
                                    });
                                </script>
                            </div>


                        </div><!--end card-body-->
                    </div><!--end card-->
                </div> <!-- end col -->

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" style="color:#115e0f; font-size:20px;">Bill To</h4>

                        </div><!--end card-header-->
                        <div class="card-body">

                            <div class="row">
                                <div class="mb-2 col-md-6" style="display: none;">
                                    <label for="username" class="mb-2">id</label>
                                    <input class="form-control" type="text" id="userid" name="userid"
                                        value="{{ $userid->id }}">
                                </div>

                                <div class="mb-2 col-md-6 d-none">
                                    <label for="userid" class="mb-2">User ID</label>
                                    <input class="form-control" type="text" id="adminid" name="adminid"
                                           value="{{ $users->ragisternum ?? '' }}">
                                </div>

                                <div class="mb-2 col-md-6">
                                    <label for="username" class="mb-2">Farm Name </label>
                                    <input class="form-control" type="text" id="framname" name="framname"
                                        value="{{ $userid->framname }}">
                                </div>
                                <div class="mb-2 col-md-6">
                                    <label for="email" class="mb-2">Invoice Date</label>
                                    <input type="date" class="form-control" id="crdate" name="invoicedate"
                                        aria-describedby="emailHelp">
                                </div>
                                <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                        // Get the current date
                                        var today = new Date();

                                        // Format the date as YYYY-MM-DD
                                        var yyyy = today.getFullYear();
                                        var mm = String(today.getMonth() + 1).padStart(2, '0'); // Months are zero-based
                                        var dd = String(today.getDate()).padStart(2, '0');

                                        var formattedDate = yyyy + '-' + mm + '-' + dd;

                                        // Set the value of the date input field
                                        document.getElementById('crdate').value = formattedDate;
                                    });
                                </script>
                                <div class="mb-2 col-md-6">
                                    <label for="username" class="mb-2">Gst Number </label>
                                    <input class="form-control" type="text" id="gstnumber" name="gstnumber"
                                        value="{{ $userid->gstcode }}">
                                </div>

                                <div class="mb-2 col-md-6">
                                    <label for="username" class="mb-2">User Name </label>
                                    <input class="form-control" type="text" id="username" name="username"
                                        value="{{ $userid->username }}">
                                </div>

                                <div class="mb-2 col-md-6">
                                    <label for="username" class="mb-2">Contact No.</label>
                                    <input class="form-control" type="text" id="contactno" name="contactno"
                                        value="{{ $userid->contactno }}">
                                </div>
                                
                                <div class="mb-2 col-md-6">
                                    <label for="username" class="mb-2">Role</label>
                                
                                    @foreach ($tab as $item)
                                        @if ($item->id == $userid->roleid)
                                            <input class="form-control" type="hidden" id="roleid" name="roleid" value="{{ $item->id }}">
                                            <input class="form-control d-none" type="text" id="userrole" name="userrole" value="{{ $item->role }}" readonly>
                                
                                            @php
                                                // Find the discount for this specific role
                                                $roleDiscount = $rolediscounts->firstWhere('role', $item->id);
                                            @endphp
                                            
                                            @if ($roleDiscount)
                                                <input class="form-control" type="text" id="discount" name="discount" value="{{ $roleDiscount->rate }}" readonly>
                                            @else
                                                <input class="form-control" type="text" id="discount" name="discount" value="No discount available" readonly>
                                            @endif
                                
                                            @break  <!-- Exit the loop after finding the role -->
                                        @endif
                                    @endforeach
                                </div>
                                
                                
                                <div class="mb-2 col-md-6">
                                    <label for="username" class="mb-2">Email Address</label>
                                    <input class="form-control" type="text" id="email" name="email"
                                        value="{{ $userid->email }}">
                                </div>

                                <div class="mb-2 col-md-6">
                                    <label for="email" class="mb-2">Region</label>
                                    <input class="form-control" type="text" id="region" name="region"
                                        value="{{ $userid->region }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="companyemail" class="mb-2">udyam card Number </label>
                                    <input type="text" class="form-control" name="udyamno" id="udyamno" 
                                        value="{{ $userid->udyamcard }}">
                                </div>

                                <div class="mb-2 col-md-6" >
                                    <label for="username" class="mb-2">status</label>
                                    <input class="form-control" type="text" id="status" name="status"
                                        value="Approve">
                                </div>

                                <div class="mb-2 col-md-12">
                                    <label for="email" class="mb-2">Address</label>
                                    <textarea class="form-control" type="text" id="address" name="address" value="{{ $userid->address }}">{{ $userid->address }}</textarea>
                                </div>



                            </div>

                        </div><!--end card-body-->
                    </div><!--end card-->
                </div> <!-- end col -->

                <div class="card shadow-lg" style="border-radius: 15px;">
                    <div class="card-body">
                        <div class="row">
                            <h3 style="color:#115e0f;">Dispatch Through</h3>

                            <div class="col-md-6 mb-3">
                                <label for="companyemail" class="form-label">Driver Company<span style="color:red">*</span></label>
                                  <input type="text" class="form-control" name="drivercompany" id="drivercompany"
                                         required pattern="[A-Za-z\s]+" title="Only letters and spaces allowed">
                                </div>


                            <div class="col-md-6 mb-3">
                                <label for="companyemail" class="form-label">Vehicle Number<span style="color:red">*</span></label>
                                <input type="text" class="form-control" name="vehicleno" id="vehicleno" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="companyemail" class="form-label">Driver Name<span style="color:red">*</span></label>
                                <input type="text" class="form-control" name="drivername" id="drivername"
                                    required   pattern="[A-Za-z\s]+" title="Only letters and spaces allowed">
                            </div>
                                                            
                                <script>
                                document.getElementById('drivername').addEventListener('input', function () {
                                    this.value = this.value.replace(/[^A-Za-z\s]/g, '');
                                  });
                                  document.getElementById('drivercompany').addEventListener('input', function () {
                                    this.value = this.value.replace(/[^A-Za-z\s]/g, '');
                                  });
                                </script>
                            
                                <div class="col-md-6 mb-3">
                                  <label for="drivercontact" class="form-label">Driver Contact <span style="color:red">*</span></label>
                                  <input type="tel" class="form-control" name="drivercontact" id="drivercontact"
                                         required pattern="[0-9]{10}" inputmode="numeric" maxlength="10"
                                         title="Please enter exactly 10 digits">
                                </div>
                                
                                <script>
                                  document.getElementById('drivercontact').addEventListener('input', function (e) {
                                    // Remove all non-digit characters
                                    this.value = this.value.replace(/[^0-9]/g, '');
                                  });
                                </script>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="row ">
                        <div class="col-lg-12">
                            <div class="card ">
                                <div class="card-header">
                                    <h4 class="card-title" style="color:#115e0f; font-size:20px;">Amount Details</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                       
                                        <div class="container">
                                            @if (count($products) > 0)
                                                <form action="{{ route('distributerinvoicedata') }}" method="POST">
                                                    @csrf <!-- CSRF Token -->
                                        
                                                    <div id="amount-rows">
                                                        @foreach ($products as $index => $product)
                                                            <div class="row amount-row product-row">
                                                                <!-- Hidden Product ID and GStrate -->
                                                                <input type="hidden" name="prid[]" value="{{ $product['id'] }}">
                                                                <input type="hidden" name="gstrate[]" value="18%">
                                        
                                                                <!-- Product Name -->
                                                                <div class="col-md-3 mt-3">
                                                                    <label for="description" class="form-label">Product Name</label>
                                                                    <input type="text" class="form-control" name="productname[]" value="{{ $product['productname'] }}">
                                                                </div>
                                        
                                                                <!-- HSN Code -->
                                                                <div class="col-md-2 mt-3">
                                                                    <label for="hsn" class="form-label">HSN Code</label>
                                                                    <input type="text" class="form-control" name="hsn[]" value="{{ $product['hsncode'] }}">
                                                                </div>
                                        
                                                                <!-- Amount -->
                                                                <div class="col-md-2 mt-3">
                                                                    <label for="amount" class="form-label">Amount</label>
                                                                    <input type="text" class="form-control amountField" name="totalamount[]" value="{{ $product['bulk_price'] }}" Readonly>
                                                                </div>
                                        
                                                                <!-- Bulk Quantity -->
                                                                <div class="col-md-1 mt-3">
                                                                    <label for="qty" class="form-label">Bulk Qty</label>
                                                                    <input type="text" class="form-control productbulk" name="productbulk[]" value="{{ $product['bulk_quantity'] }}">
                                                                </div>

                                                              
                                                                <div class="col-md-2 mt-3" >
                                                                    <label for="qty" class="form-label">MS Qty</label>
                                                                    <input type="text" class="form-control bulkmasurment" name="bulkmasurment[]" value="{{ $product->bulk_masurment }}">
                                                                </div>
                                                                <div class="col-md-1 mt-3">
                                                                    <label for="qty" class="form-label">Total Qty</label>
                                                                    <input type="text" class="form-control bulktotalqty" name="bulktotalqty[]" value="{{ $product->bulk_total }}">
                                                                </div>
                                                                
                                                                

                                                                <!-- Bulk Quantity -->
                                                               
                                        
                                                                <!-- Weight and Class -->
                                                                <div class="col-md-1 mt-3"  style="display: none;">
                                                                    <label for="weight" class="form-label">Weight</label>
                                                                    <input type="text" class="form-control" name="productquantity[]" value="{{ $product['weightnum'] }}">
                                                                </div>
                                        
                                                                <div class="col-md-1 mt-3"  style="display: none;">
                                                                    <label for="weightclass" class="form-label">Class</label>
                                                                    <input type="text" class="form-control" name="weightclass[]" value="{{ $product['weihgtclass'] }}">
                                                                </div>
                                        
                                                                <!-- Total Amount (Hidden) -->
                                                                <input type="hidden" class="totalAmount" name="amount[]" value="{{ $product['bulk_price'] * ($product->bulk_total ?? 0) }}" readonly>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                        
                                                    <!-- Submit Button -->
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <input type="submit" class="btn btn-outline-success" style="font-size:18px; border-radius:10px;" value="Submit" />
                                                        </div>
                                                    </div>
                                                </form>
                                            @else
                                                <div class="alert alert-info mt-3">No products to display for this order status.</div>
                                            @endif
                                        </div>
                                        
                                        
                                        
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                // Function to calculate total amount for each row
                                                function calculateTotalAmount(row) {
                                                    const amount = parseFloat(row.querySelector('.amountField').value) || 0;
                                                    const bulk = parseFloat(row.querySelector('.productbulk').value) || 0;
                                                    row.querySelector('.totalAmount').value = (amount * bulk).toFixed(2);
                                                }
                                        
                                                // Attach event listeners to a row
                                                function attachEventListeners(row) {
                                                    const amountField = row.querySelector('.amountField');
                                                    const bulkField = row.querySelector('.productbulk');
                                        
                                                    amountField.addEventListener('input', () => calculateTotalAmount(row));
                                                    bulkField.addEventListener('input', () => calculateTotalAmount(row));
                                                }
                                        
                                                // Attach listeners to existing rows
                                                document.querySelectorAll('.product-row').forEach(attachEventListeners);
                                        
                                                // Handle adding new rows
                                                document.getElementById('add-row')?.addEventListener('click', () => {
                                                    const newRow = document.querySelector('.product-row').cloneNode(true);
                                                    newRow.querySelectorAll('input').forEach(input => input.value = ''); // Clear inputs
                                                    document.getElementById('amount-rows').appendChild(newRow);
                                                    attachEventListeners(newRow); // Attach listeners to new row
                                                });
                                            });
                                        </script>
                                        
                                        


{{-- <script>
    document.addEventListener('DOMContentLoaded', () => {
        const amountRowsContainer = document.getElementById('amount-rows');
        const addRowButton = document.getElementById('add-row');

        // Function to clone a row
        function cloneRow(row) {
            const newRow = row.cloneNode(true);
            const inputs = newRow.querySelectorAll('input, select');
            inputs.forEach(input => input.value = ''); // Clear the values
            return newRow;
        }

        // Add event listener to the 'Add Row' button
        addRowButton.addEventListener('click', () => {
            const firstRow = amountRowsContainer.querySelector('.amount-row');
            if (firstRow) {
                const newRow = cloneRow(firstRow);
                amountRowsContainer.appendChild(newRow);
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
        });
    });
</script> --}}
</div>
</div>

</div>
