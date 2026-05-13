<div>
    <div class="container py-4">

        <form id="form-validation-2" action="{{ url('/insertorder/'.$value->id) }}" method="post">
            @csrf

            {{-- INVOICE DETAILS --}}
            <div class="card shadow-sm mb-4 border-0" style="border-radius: 16px;">
                <div class="card-header bg-white border-0">
                    <h4 class="mb-0" style="color:#115e0f;">Invoice Details</h4>
                </div>

                <div class="card-body">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Invoice Number</label>
                            <input type="text"
                                   class="form-control"
                                   name="invoicenum"
                                   id="invoicenumber"
                                   readonly
                                   required
                                   data-invoiceno="{{ $lastnum->invoiceno ?? '' }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Invoice Date</label>
                            <input type="date"
                                   class="form-control"
                                   id="invoicedate"
                                   name="invoicedate"
                                   required>
                        </div>

                    </div>
                </div>
            </div>

            {{-- BILL TO --}}
            <div class="card shadow-sm mb-4 border-0" style="border-radius: 16px;">
                <div class="card-header bg-white border-0">
                    <h4 class="mb-0" style="color:#115e0f;">Bill To</h4>
                </div>

                <div class="card-body">
                    <div class="row g-3">

                        <input type="hidden" id="userid" name="userid" value="{{ $userid->id ?? '' }}">
                        <input type="hidden" id="adminid" name="adminid" value="{{ $users->ragisternum ?? '' }}">

                        <div class="col-md-6">
                            <label class="form-label">Farm Name</label>
                            <input type="text" class="form-control" name="framname" value="{{ $userid->framname ?? '' }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">GST Number</label>
                            <input type="text" class="form-control" name="gstnumber" value="{{ $userid->gstcode ?? '' }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">User Name</label>
                            <input type="text" class="form-control" name="username" value="{{ $userid->username ?? '' }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Contact No.</label>
                            <input type="text" class="form-control" name="contactno" value="{{ $userid->contactno ?? '' }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Role</label>

                            @foreach ($tab as $item)
                                @if ($item->id == ($userid->roleid ?? null))
                                    <input type="hidden" name="roleid" id="roleid" value="{{ $item->id }}">
                                    <input type="hidden" name="userrole" id="userrole" value="{{ $item->role }}">

                                    <input type="text" class="form-control" value="{{ $item->role }}" readonly>
                                    @break
                                @endif
                            @endforeach
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Discount</label>
                            <div class="input-group">
                                <input type="number"
                                       class="form-control"
                                       id="discount"
                                       name="discount"
                                       value="{{ $discountRate ?? 0 }}"
                                       readonly>
                                <span class="input-group-text">%</span>
                            </div>
                            <small class="text-success">
                                {{ ucfirst($discountType ?? 'no') }} discount applied
                            </small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" name="email" value="{{ $userid->email ?? '' }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Region</label>
                            <input type="text" class="form-control" name="region" value="{{ $userid->region ?? '' }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Udyam Card Number</label>
                            <input type="text" class="form-control" name="udyamno" value="{{ $userid->udyamcard ?? '' }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <input type="text" class="form-control" name="status" value="Approve" readonly>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Address</label>
                            <textarea class="form-control" name="address" rows="3">{{ $userid->address ?? '' }}</textarea>
                        </div>

                    </div>
                </div>
            </div>

            {{-- DISPATCH DETAILS --}}
            <div class="card shadow-sm mb-4 border-0" style="border-radius: 16px;">
                <div class="card-header bg-white border-0">
                    <h4 class="mb-0" style="color:#115e0f;">Dispatch Through</h4>
                </div>

                <div class="card-body">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Driver Company <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control onlyText"
                                   name="drivercompany"
                                   required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Vehicle Number <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control"
                                   name="vehicleno"
                                   required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Driver Name <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control onlyText"
                                   name="drivername"
                                   required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Driver Contact <span class="text-danger">*</span></label>
                            <input type="tel"
                                   class="form-control onlyNumber"
                                   name="drivercontact"
                                   maxlength="10"
                                   required>
                        </div>

                    </div>
                </div>
            </div>

            {{-- AMOUNT DETAILS --}}
            <div class="card shadow-sm mb-4 border-0" style="border-radius: 16px;">
                <div class="card-header bg-white border-0">
                    <h4 class="mb-0" style="color:#115e0f;">Amount Details</h4>
                </div>

                <div class="card-body">

                    @if (count($products) > 0)

                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead style="background:#115e0f; color:white;">
                                    <tr>
                                        <th>Product</th>
                                        <th>HSN</th>
                                        <th>Rate</th>
                                        <th>Bulk Qty</th>
                                        <th>Measurement</th>
                                        <th>Total Qty</th>
                                        <th>Total Amount</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($products as $index => $product)
                                        <tr class="product-row">

                                            <td>
                                                <input type="hidden" name="prid[]" value="{{ $product->id }}">
                                                <input type="hidden" name="gstrate[]" value="18%">
                                                <input type="hidden" name="sgst[]" value="0">
                                                <input type="hidden" name="cgst[]" value="0">
                                                <input type="hidden" name="igst[]" value="0">
                                                <input type="hidden" name="selectgst[]" value="GST">

                                                <input type="text"
                                                       class="form-control"
                                                       name="productname[]"
                                                       value="{{ $product->productname }}"
                                                       readonly>
                                            </td>

                                            <td>
                                                <input type="text"
                                                       class="form-control"
                                                       name="hsn[]"
                                                       value="{{ $product->hsncode }}"
                                                       readonly>
                                            </td>

                                            <td>
                                                <input type="number"
                                                       step="0.01"
                                                       class="form-control amountField"
                                                       name="totalamount[]"
                                                       value="{{ $product->bulk_price }}"
                                                       readonly>
                                            </td>

                                            <td>
                                                <input type="number"
                                                       step="0.01"
                                                       class="form-control productbulk"
                                                       name="productbulk[]"
                                                       value="{{ $product->bulk_quantity }}">
                                            </td>

                                            <td>
                                                <input type="text"
                                                       class="form-control bulkmasurment"
                                                       name="bulkmasurment[]"
                                                       value="{{ $product->bulk_masurment }}">
                                            </td>

                                            <td>
                                                <input type="number"
                                                       step="0.01"
                                                       class="form-control bulktotalqty"
                                                       name="bulktotalqty[]"
                                                       value="{{ $product->bulk_total }}">
                                            </td>

                                            <td>
                                                <input type="number"
                                                       step="0.01"
                                                       class="form-control totalAmount"
                                                       name="amount[]"
                                                       value="{{ (float)$product->bulk_price * (float)$product->bulk_total }}"
                                                       readonly>
                                            </td>
<input type="text"
       name="productquantity[]"
       value="{{ $product->product_quantity }}">
                                            <input type="hidden" name="weightclass[]" value="{{ $product->weihgtclass }}">

                                        </tr>
                                    @endforeach
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <th colspan="6" class="text-end">Sub Total</th>
                                        <th>
                                            <input type="text" class="form-control" id="subTotal" readonly>
                                        </th>
                                    </tr>

                                    <tr>
                                        <th colspan="6" class="text-end">Discount Amount</th>
                                        <th>
                                            <input type="text" class="form-control" id="discountAmount" readonly>
                                        </th>
                                    </tr>

                                    <tr>
                                        <th colspan="6" class="text-end">Grand Total</th>
                                        <th>
                                            <input type="text" class="form-control fw-bold" id="grandTotal" readonly>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit"
                                    class="btn btn-success px-5 py-2"
                                    style="border-radius: 10px; font-size:18px;">
                                Submit Invoice
                            </button>
                        </div>

                    @else
                        <div class="alert alert-info">
                            No approved products found.
                        </div>
                    @endif

                </div>
            </div>

        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    setInvoiceNumber();
    setCurrentDate();
    calculateAllTotals();

    document.querySelectorAll('.amountField, .bulktotalqty, .productbulk').forEach(input => {
        input.addEventListener('input', calculateAllTotals);
    });

    document.querySelectorAll('.onlyText').forEach(input => {
        input.addEventListener('input', function () {
            this.value = this.value.replace(/[^A-Za-z\s]/g, '');
        });
    });

    document.querySelectorAll('.onlyNumber').forEach(input => {
        input.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });

});

function setInvoiceNumber() {
    const currentDate = new Date();
    const currentYearFull = currentDate.getFullYear();
    const currentYearShort = currentYearFull.toString().slice(-2);
    const nextYearShort = (currentYearFull + 1).toString().slice(-2);

    const invoiceInput = document.getElementById('invoicenumber');
    const lastInvoiceNum = invoiceInput.getAttribute('data-invoiceno');

    let lastInvoiceNumber = 0;
    let lastInvoiceYear = null;

    if (lastInvoiceNum && lastInvoiceNum.includes('/')) {
        const parts = lastInvoiceNum.split('/');
        lastInvoiceYear = parts[1]?.split('-')[0];
        lastInvoiceNumber = parseInt(parts[2]) || 0;
    }

    if (!lastInvoiceNum || lastInvoiceYear !== currentYearShort) {
        lastInvoiceNumber = 1;
    } else {
        lastInvoiceNumber += 1;
    }

    const invoiceNumberFormatted = lastInvoiceNumber.toString().padStart(2, '0');
    invoiceInput.value = `VML/${currentYearShort}-${nextYearShort}/${invoiceNumberFormatted}`;
}

function setCurrentDate() {
    const dateInput = document.getElementById('invoicedate');

    if (!dateInput) return;

    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const dd = String(today.getDate()).padStart(2, '0');

    dateInput.value = `${yyyy}-${mm}-${dd}`;
}

function calculateAllTotals() {
    let subTotal = 0;

    document.querySelectorAll('.product-row').forEach(row => {
        const price = parseFloat(row.querySelector('.amountField')?.value) || 0;
        const totalQty = parseFloat(row.querySelector('.bulktotalqty')?.value) || 0;

        const rowTotal = price * totalQty;

        row.querySelector('.totalAmount').value = rowTotal.toFixed(2);

        subTotal += rowTotal;
    });

    const discountRate = parseFloat(document.getElementById('discount')?.value) || 0;
    const discountAmount = subTotal * discountRate / 100;
    const grandTotal = subTotal - discountAmount;

    document.getElementById('subTotal').value = subTotal.toFixed(2);
    document.getElementById('discountAmount').value = discountAmount.toFixed(2);
    document.getElementById('grandTotal').value = grandTotal.toFixed(2);
}
</script>