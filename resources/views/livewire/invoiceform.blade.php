<div>
    <style>
        .hidden {
    display: none !important;
}

        </style>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12 col-lg-12 mb-5">
<!-- START OF FORM -->
<form action="{{ route('insertdata') }}" method="post">
    @csrf

    <!-- Invoice Number Section -->
    <div class="card shadow-lg mb-4" style="border-radius: 15px;">
        <div class="card-body">
            <h1 class="text-center text-primary mb-4">Insert Invoice Details</h1>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="invoicenumber" class="form-label">Invoice Number</label>
                    <input type="text" class="form-control" name="invoicenum" id="invoicenumber" required readonly
                        data-lastnum="{{ $lastnum->invoicenum }}">
                </div>
            </div>
        </div>
    </div>

    <!-- Bill To Section -->
    <div class="card shadow-lg mb-4" style="border-radius: 15px;">
        <div class="card-body">
            <h3 class="text-primary">Bill To</h3>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="companyname" class="form-label">Company Name</label>
                    <input list="companyList" id="companyname" name="companyname" class="form-control"
                        onchange="fetchCompanyDetails(this.value)">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="crdate" class="form-label">Invoice Date</label>
                    <input type="date" class="form-control" id="crdate" name="invoicedate" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="companygsn" class="form-label">Company GSTIN</label>
                    <input type="text" class="form-control" name="companygsn" id="companygsn" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="companycontact" class="form-label">Company Contact No.</label>
                    <input type="text" class="form-control" name="companycontact" id="companycontact" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="companyemail" class="form-label">Company Email</label>
                    <input type="email" class="form-control" name="companyemail" id="companyemail" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="udyamno" class="form-label">Udyam Card Number</label>
                    <input type="text" class="form-control" name="udyamno" id="udyamno" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="companyaddress" class="form-label">Company Address</label>
                    <textarea class="form-control" name="companyaddress" id="companyaddress" required></textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- Dispatch Section -->
    <div class="card shadow-lg mb-4" style="border-radius: 15px;">
        <div class="card-body">
            <h3 class="text-primary">Dispatch Through</h3>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Through</label>
                    <input type="text" class="form-control" name="drivercompany" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Vehicle Number</label>
                    <input type="text" class="form-control" name="vehicleno" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Driver Name</label>
                    <input type="text" class="form-control" name="drivername" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Driver Contact</label>
                    <input type="text" class="form-control" name="drivercontact" required>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Entry Section -->
    <div class="card shadow-lg mb-4" style="border-radius: 15px;">
        <div class="card-body addproduct">
            <h3 class="text-primary mb-4">Amount Details</h3>
            <div class="row product-row">
                <!-- Product Select -->
                <div class="col-md-2 mb-3">
                    <label class="form-label">Select Product</label>
                    <select name="description[]" class="form-control productSelect" required>
                        <option value="">Select</option>
                        @foreach ($tab as $item)
                            <option value="{{ $item->productname }}"
                                data-hsn="{{ $item->hsncode }}"
                                data-perpcs="{{ $item->productprice }}"
                                data-amount="{{ $item->totalamount }}"
                                data-quantity="{{ $item->quantity }}"
                                data-weight="{{ $item->weihgtclass }}"
                                data-box="{{ $item->boxquantity }}"
                                data-perpcsamount="{{ $item->totalamount }}"
                                data-measurement="{{ $item->measurement }}">
                                {{ $item->productname }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- HSN Code -->
                <div class="col-md-2 mb-3">
                    <label class="form-label">HSN Code</label>
                    <input type="text" name="hsncode[]" class="form-control hsncodeField" readonly required>
                </div>

                <!-- Unit Type -->
                <div class="col-md-1 mb-3">
                    <label class="form-label">Unit</label>
                    <select name="pcs[]" class="form-control productpcs" required>
                        <option value="">Select</option>
                        <option value="Pcs">Pcs</option>
                        <option value="Box">Box</option>
                    </select>
                </div>

                <!-- Quantity Pcs -->
                <div class="col-md-1 mb-3 pcs-field hidden">
                    <label class="form-label">Qty (Pcs)</label>
                    <input type="text" class="form-control productqty" name="qty[]">
                </div>

                <!-- Quantity Box -->
                <div class="col-md-1 mb-3 box-field hidden">
                    <label class="form-label">Qty (Box)</label>
                    <input type="text" class="form-control productqtybox" name="qty[]">
                </div>

                <!-- Amount in Pcs -->
                <div class="col-md-2 mb-3 amount-field-pcs hidden">
                    <label class="form-label">Amount/Pcs</label>
                    <input type="text" class="form-control amountFieldpcs" name="totalamount[]">
                </div>

                <!-- Amount in Box -->
                <div class="col-md-2 mb-3 amount-field-box hidden">
                    <label class="form-label">Amount/Box</label>
                    <input type="text" class="form-control amountField" name="totalamount[]">
                </div>

                <!-- Bulk -->
                <div class="col-md-1 mb-3">
                    <label class="form-label">Bulk</label>
                    <input type="text" class="form-control productbulk" name="bulk[]">
                </div>

                <!-- Row Actions -->
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger remove-row me-2">-</button>
                    <button type="button" class="btn btn-primary add-row">+</button>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="text-end p-3">
            <input type="submit" class="btn btn-primary" value="Submit">
        </div>
    </div>
</form>

<!-- STYLE FOR HIDDEN FIELDS -->
<style>
    .hidden {
        display: none !important;
    }
</style>

<!-- SCRIPT SECTION -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const dd = String(today.getDate()).padStart(2, '0');
        document.getElementById('crdate').value = `${yyyy}-${mm}-${dd}`;

        const invoiceField = document.getElementById('invoicenumber');
        const lastInvoice = invoiceField.getAttribute('data-lastnum');
        const lastYear = lastInvoice?.split('/')[1];
        let lastNum = parseInt(lastInvoice?.split('/')[2]) || 0;
        if (lastYear !== String(yyyy)) lastNum = 0;
        invoiceField.value = `VML/${yyyy}/${String(++lastNum).padStart(2, '0')}`;
    });

    document.addEventListener('DOMContentLoaded', function () {
        function calculateTotal(row) {
            const unit = row.querySelector('.productpcs').value;
            const bulk = parseFloat(row.querySelector('.productbulk').value) || 0;
            let rate = 0;

            if (unit === 'Pcs') {
                rate = parseFloat(row.querySelector('.amountFieldpcs').value) || 0;
            } else if (unit === 'Box') {
                rate = parseFloat(row.querySelector('.amountField').value) || 0;
            }

            const total = rate * bulk;
            row.querySelector('.amountFieldpcs').required = (unit === 'Pcs');
            row.querySelector('.amountField').required = (unit === 'Box');
        }

        function toggleFields(row) {
            const unit = row.querySelector('.productpcs').value;
            const pcsField = row.querySelector('.amount-field-pcs');
            const boxField = row.querySelector('.amount-field-box');
            const pcsQty = row.querySelector('.pcs-field');
            const boxQty = row.querySelector('.box-field');

            if (unit === 'Pcs') {
                pcsField.classList.remove('hidden');
                pcsQty.classList.remove('hidden');
                boxField.classList.add('hidden');
                boxQty.classList.add('hidden');
            } else if (unit === 'Box') {
                boxField.classList.remove('hidden');
                boxQty.classList.remove('hidden');
                pcsField.classList.add('hidden');
                pcsQty.classList.add('hidden');
            } else {
                pcsField.classList.add('hidden');
                boxField.classList.add('hidden');
                pcsQty.classList.add('hidden');
                boxQty.classList.add('hidden');
            }
        }

        function addRow() {
            const template = document.querySelector('.product-row');
            const clone = template.cloneNode(true);
            clone.querySelectorAll('input').forEach(i => i.value = '');
            clone.querySelectorAll('select').forEach(s => s.selectedIndex = 0);
            document.querySelector('.addproduct').appendChild(clone);
            initRow(clone);
        }

        function initRow(row) {
            row.querySelector('.productSelect').addEventListener('change', function () {
                const opt = this.selectedOptions[0];
                row.querySelector('.hsncodeField').value = opt.dataset.hsn || '';
                row.querySelector('.amountField').value = opt.dataset.amount || '';
                row.querySelector('.amountFieldpcs').value = opt.dataset.perpcs || '';
            });

            row.querySelector('.productpcs').addEventListener('change', () => {
                toggleFields(row);
                calculateTotal(row);
            });

            row.querySelector('.productbulk').addEventListener('input', () => calculateTotal(row));
            row.querySelector('.add-row').addEventListener('click', addRow);
            row.querySelector('.remove-row').addEventListener('click', () => row.remove());

            toggleFields(row);
        }

        document.querySelectorAll('.product-row').forEach(initRow);
    });
</script>

            </div>
        </div>
    </div>
</div>
</div>



<script>

  document.addEventListener('DOMContentLoaded', function () {
    // Function to calculate total amount based on unit (Pcs or Box)
    function calculateTotalAmount(row) {
        const unit = row.querySelector('.productpcs').value; // Get selected unit
        const bulk = parseFloat(row.querySelector('.productbulk').value) || 0;
        const totalAmountField = row.querySelector('.totalAmount');
    
        const totalpcsField = row.querySelector('.totalpcs');

        let quantitypcs = document.getElementById('quantitypcs').value;
        let quantitybulk = document.getElementById('bulk').value;

        let totalAmount = 0;

        if (unit === "Pcs") {
            const amountInPcs = parseFloat(row.querySelector('.amountFieldpcs').value) || 0;
            totalAmount = amountInPcs * bulk; // Calculate total for Pcs
        } else if (unit === "Box") {
            const amountInBox = parseFloat(row.querySelector('.amountField').value) || 0;
            totalAmount = amountInBox * bulk; // Calculate total for Box
 
            Totalpcs = quantitypcs * quantitybulk;
        }

        totalAmountField.value = totalAmount; // Update total amount
        totalpcsField.value = Totalpcs;
    }

function toggleFields(row) {
    const unit = row.querySelector('.productpcs').value; // Get selected unit
    const pcsField = row.querySelector('.amount-field-pcs'); // "Amount In Pcs" container
    const boxField = row.querySelector('.amount-field-box'); // "Amount In Box" container
    const boxFielddata = row.querySelector('.box-field');
    const pcsFielddata = row.querySelector('.pcs-field');



    if (unit === "Pcs") {
        pcsField.classList.remove('hidden'); // Show Pcs fields
        boxField.classList.add('hidden');   // Hide Box fields
        pcsFielddata.classList.remove('hidden'); // Show Pcs fields
        boxFielddata.classList.remove('hidden'); // Show Pcs fields
    } else if (unit === "Box") {
        pcsField.classList.add('hidden');   // Hide Pcs fields
        boxField.classList.remove('hidden'); // Show Box fields
        pcsFielddata.classList.remove('hidden'); // Show Pcs fields
        boxFielddata.classList.remove('hidden'); // Show Pcs fields
    } else {
        pcsField.classList.add('hidden');   // Hide Pcs fields
        boxField.classList.add('hidden');   // Hide Box fields
        pcsFielddata.classList.add('hidden'); // Show Pcs fields
        boxFielddata.classList.add('hidden'); // Show Pcs fields
    }
}


    // Function to add new row
    function addRow() {
        const productRow = document.querySelector('.product-row');
        const newRow = productRow.cloneNode(true);
        newRow.querySelectorAll('input').forEach(input => input.value = ''); // Clear inputs
        document.querySelector('.addproduct').appendChild(newRow);
        attachEventListeners(newRow); // Reattach event listeners
    }

    // Function to remove row
    function removeRow(button) {
        const row = button.closest('.product-row');
        row.remove();
    }

    // Attach event listeners to fields
    function attachEventListeners(row) {
        // Product selection change
        row.querySelector('.productSelect').addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const hsnCode = selectedOption.getAttribute('data-hsn');
            const amount = selectedOption.getAttribute('data-amount');
            const quantity = selectedOption.getAttribute('data-quantity');
            const weight = selectedOption.getAttribute('data-weight');
            const masurment = selectedOption.getAttribute('data-masurment');
            const perpcs = selectedOption.getAttribute('data-perpcs');
            const perbox = selectedOption.getAttribute('data-box');

            const totalpcsamount = selectedOption.getAttribute('data-perpcsamount');
            const measurement = selectedOption.getAttribute('data-measurement');


            // Set values in the respective fields
            row.querySelector('.hsncodeField').value = hsnCode;
            row.querySelector('.amountField').value = amount;
            row.querySelector('.productqty').value = quantity;
            row.querySelector('.productwight').value = weight;
            row.querySelector('.amountFieldpcs').value = perpcs;
            row.querySelector('.productqtybox').value = perbox;
            row.querySelector('.prepcsamount').value = totalpcsamount;
            row.querySelector('.measurement').value = measurement;

            calculateTotalAmount(row); // Recalculate total amount
        });

        // Unit change event (Pcs/Box)
        row.querySelector('.productpcs').addEventListener('change', function () {
            toggleFields(row); // Show/Hide fields
            calculateTotalAmount(row); // Recalculate total amount
        });

        // Bulk change event
        row.querySelector('.productbulk').addEventListener('input', function () {
            calculateTotalAmount(row); // Recalculate total amount
        });

        // Remove row event
        row.querySelector('.remove-row').addEventListener('click', function () {
            removeRow(this);
        });

        // Add row event
        row.querySelector('.add-row').addEventListener('click', function () {
            addRow();
        });
    }

    // Initialize first row
    const initialRow = document.querySelector('.product-row');
    toggleFields(initialRow); // Set initial visibility of fields
    attachEventListeners(initialRow);
});

// Initialize first row visibility
document.addEventListener('DOMContentLoaded', function () {
    const initialRows = document.querySelectorAll('.product-row');

    initialRows.forEach(row => {
        toggleFields(row); // Set initial visibility
        attachEventListeners(row); // Attach events
    });
});

</script>



</div>
</div>

</div>
