<div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12 col-lg-12 mb-5">
                <form action="{{ url('/invoicedataedit/'.$datatable->id) }}" method="post">
                    @csrf
                    
                    <div class="card shadow-lg" style="border-radius: 15px;">
                        <div class="card-body">

                            <h1 style="text-align:center; color:#2677ff;" class="mb-2">Insert Invoice Details</h1>

                            <!-- Invoice Section -->

                            {{-- <div class="col-md-6 mb-3">
                                    <label for="invoicenum" class="form-label">Invoice Number</label>
                                    <input type="text" class="form-control" name="invoicenum" id="invoicenumber"
                                        required readonly>
                                </div>

                                <script>
                                    document.addEventListener('DOMContentLoaded', incrementfun); // Trigger the function when the document loads

                                    function incrementfun() {
                                        const currentYear = new Date().getFullYear(); // Get the current year
                                        let lastInvoiceNumber = localStorage.getItem('lastInvoiceNumber') ||
                                        1; // Check for last invoice number in local storage, default to 1

                                        // Set the invoice number in the input field
                                        document.getElementById('invoicenumber').value = `VML/${currentYear}/${lastInvoiceNumber}`;

                                        // Increment the invoice number for the next invoice and store it
                                        localStorage.setItem('lastInvoiceNumber', parseInt(lastInvoiceNumber) + 1);
                                    }
                                </script> --}}


                            <!-- Bill To Section -->
                            <h3 style="color:#2677ff;">Bill To</h3>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="companyname" class="form-label">Company Name</label>
                                    <input list="companyList" id="companyname" name="companyname" class="form-control"
                                        onchange="fetchCompanyDetails(this.value)" value="{{$datatable->companyname}}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="crdate" class="form-label">Invoice Date</label>
                                    <input type="date" class="form-control" id="crdate" name="invoicedate"
                                        required value="{{$datatable->invoicedate}}">
                                </div>


                            


                                <div class="col-md-6 mb-3">
                                    <label for="companygsn" class="form-label">Company GSTIN</label>
                                    <input type="text" class="form-control" name="companygsn" id="companygsn"
                                        required  value="{{$datatable->companygsn}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="companypan" class="form-label">Company Contact No.</label>
                                    <input type="text" class="form-control" name="companycontact" id="companycontact"
                                        required value="{{$datatable->companycontact}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="companyemail" class="form-label">Company Email</label>
                                    <input type="email" class="form-control" name="companyemail" id="companyemail"
                                        required value="{{$datatable->companyemail}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="companyemail" class="form-label">udyam card Number </label>
                                    <input type="text" class="form-control" name="udyamno" id="udyamno" required  value="{{$datatable->udyamno}}">
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="companyaddress" class="form-label">Company Address</label>
                                    <textarea type="text" id="companyaddress" class="form-control" name="companyaddress" required value="{{$datatable->companyaddress}}">{{$datatable->companyaddress}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-lg" style="border-radius: 15px;">
                        <div class="card-body">
                            <div class="row">
                                <h3 style="color:#2677ff;">Dispatch Through</h3>

                                <div class="col-md-6 mb-3">
                                    <label for="companyemail" class="form-label">Throgh</label>
                                    <input type="text" class="form-control" name="drivercompany" id="drivercompany" value="{{$datatable->drivercompany}}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="companyemail" class="form-label">Vehicle Number</label>
                                    <input type="text" class="form-control" name="vehicleno" id="vehicleno" value="{{$datatable->vehicleno}}"
                                        required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="companyemail" class="form-label">Driver Name</label>
                                    <input type="text" class="form-control" name="drivername" id="drivername" required value="{{$datatable->drivername}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="companyemail" class="form-label">Driver Contact</label>
                                    <input type="text" class="form-control" name="drivercontact" id="drivercontact" required value="{{$datatable->drivercontact}}">
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card shadow-lg" style="border-radius: 15px;">
                        <div class="card-body addproduct">
                            <!-- Amount Details Section -->
                            <h3 style="color:#2677ff;">Amount Details</h3>
                            <div class="row">
                                <div class="col-md-3 mb-3" style="display: none;">
                                    <label for="gstrate" class="form-label">GST Rate</label>
                                    <input type="text" class="form-control" value="18" name="gstrate[]" required>
                                </div>
                            </div>
                    
                            @foreach(explode(',', $datatable->amount) as $index => $amount)
                            <div class="row product-row">
                                <div class="col-md-3 mb-3">
                                    <label for="description" class="form-label">Select Product</label>
                                    <select name="description[]" class="form-control productSelect" required>
                                        <option value="">Select Product</option>
                                        @foreach ($tab as $item)
                                            <option value="{{ $item->productname }}" 
                                                    data-hsn="{{ $item->hsncode }}" 
                                                    data-amount="{{ $item->productprice }}"
                                                    data-quantity="{{ $item->quantity }}"
                                                    data-weight="{{ $item->weihgtclass }}"
                                                    @if(explode(',', $datatable->description)[$index] == $item->productname) selected @endif
                                                    >
                                                {{ $item->productname }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                        
                        
                                <div class="col-md-2 mb-3">
                                    <label for="hsncode" class="form-label">Product HSN Code</label>
                                    <input type="text" name="hsncode[]" class="form-control hsncodeField"  value="{{ explode(',', $datatable->hsncode)[$index] }}"  required>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="totalamount" class="form-label">Amount</label>
                                    <input type="text" class="form-control amountField" name="totalamount[]" value="{{ explode(',', $datatable->amount)[$index] }}" required>
                                </div>
                                <div class="col-md-1 mb-3">
                                    <label for="qty" class="form-label">Quantity</label>
                                    <input type="text" class="form-control productqty" name="qty[]" value="{{ explode(',', $datatable->qty)[$index] }}"  required>
                                </div>
                                <div class="col-md-1 mb-3">
                                    <label for="wight" class="form-label">Weight</label>
                                    <input type="text" class="form-control productwight" name="wight[]"  value="{{ explode(',', $datatable->actualqty)[$index] }}" required>
                                </div>
                                <div class="col-md-1 mb-3">
                                    <label for="bulk" class="form-label">Bulk</label>
                                    <input type="text" class="form-control productbulk" name="bulk[]" required value="{{ explode(',', $datatable->qty)[$index] }}" >
                                </div>
                                <div class="col-md-6 mb-3" style="display:none;">
                                    <label for="amount" class="form-label">Total Amount</label>
                                    <input type="text" class="form-control totalAmount" name="amount[]" readonly required  value="{{ explode(',', $datatable->amount)[$index] }}" >
                                </div>
                                <div class="col-md-1 d-flex align-items-center">
                                    <button type="button" class="btn btn-danger remove-row" style="margin-right: 10px;">-</button>
                                    <button type="button" class="btn btn-primary add-row" style="background-color: #2677ff; color:#fff; border-radius:10px;">+</button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="col-md-11  text-end" style="margin: 10px;">
                            <input type="submit" class="btn btn-primary "
                            style="background-color: #2677ff; color:#fff; border-radius:10px;" value="Submit">  
                        </div>
                    </div>
                </form>
                <!-- Add Row Button -->

            </div>
        </div>
    </div>
</div>
</div>



<script>
document.addEventListener('DOMContentLoaded', function() {
    // Function to calculate total amount for a specific row
    function calculateTotalAmount(row) {
        const amountField = row.querySelector('.amountField');
        const bulkField = row.querySelector('.productbulk');
        const totalAmountField = row.querySelector('.totalAmount');
        
        const amount = parseFloat(amountField.value) || 0;
        const bulk = parseFloat(bulkField.value) || 0;
        
        totalAmountField.value = (amount * bulk).toFixed(2);
    }

    // Function to add new row
    function addRow() {
        const productRow = document.querySelector('.product-row');
        const newRow = productRow.cloneNode(true);
        
        // Clear inputs in the new row
        newRow.querySelectorAll('input').forEach(input => input.value = ''); 
        document.querySelector('.addproduct').appendChild(newRow);
        
        // Reattach event listeners to the newly added row
        attachEventListeners(newRow);  
    }

    // Function to remove row
    function removeRow(button) {
        const row = button.closest('.product-row');
        row.remove();
    }

    // Attach event listeners to a specific row
    function attachEventListeners(row) {
        // Product selection change
        row.querySelector('.productSelect').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const hsnCode = selectedOption.getAttribute('data-hsn');
            const amount = selectedOption.getAttribute('data-amount');
            const quantity = selectedOption.getAttribute('data-quantity');
            const weight = selectedOption.getAttribute('data-weight');

            // Set values in the respective fields
            row.querySelector('.hsncodeField').value = hsnCode;
            row.querySelector('.amountField').value = amount;
            row.querySelector('.productqty').value = quantity;
            row.querySelector('.productwight').value = weight;

            // Recalculate total amount whenever a new product is selected
            calculateTotalAmount(row);
        });

        // Quantity change event
        row.querySelector('.productqty').addEventListener('input', function() {
            calculateTotalAmount(row);
        });

        // Bulk change event
        row.querySelector('.productbulk').addEventListener('input', function() {
            calculateTotalAmount(row);
        });

        // Remove row event
        row.querySelector('.remove-row').addEventListener('click', function() {
            removeRow(this);
        });

        // Add row event
        row.querySelector('.add-row').addEventListener('click', function() {
            addRow();
        });
    }

    // Initialize event listeners for the first row
    document.querySelectorAll('.product-row').forEach(row => attachEventListeners(row));
});

</script>
 


</div>
</div>

</div>
