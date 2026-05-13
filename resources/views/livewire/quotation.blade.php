<div>
<style>
@media print {
    .no-print { display: none !important; }
    body { margin: 0; background: #fff !important; }
    .invoice-wrapper { margin: 0 auto !important; box-shadow: none !important; }
}

* {
    box-sizing: border-box;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 10px;
}

body {
    background: #eef1f4;
}

.invoice-wrapper {
    width: 794px;
    margin: 20px auto;
    background: #fff;
    border: 1.5px solid #000;
    color: #000;
}

.invoice-title {
    text-align: center;
    font-weight: 700;
    font-size: 12px;
    padding: 2px 0;
    border-bottom: 1.5px solid #000;
}

.top-section {
    display: grid;
    grid-template-columns: 58% 42%;
    border-bottom: 1.5px solid #000;
}

.left-info {
    border-right: 1.5px solid #000;
}

.party-box {
    padding: 4px 6px;
    min-height: 96px;
    border-bottom: 1.5px solid #000;
    line-height: 13px;
}

.party-box:last-child {
    border-bottom: none;
}

.company-name {
    font-weight: 800;
    text-transform: uppercase;
}

.right-grid {
    display: grid;
    grid-template-columns: 50% 50%;
}

.invoice-field {
    min-height: 34px;
    padding: 3px 5px;
    border-right: 1px solid #000;
    border-bottom: 1px solid #000;
    line-height: 13px;
}

.invoice-field:nth-child(2n) {
    border-right: none;
}

.invoice-field.full {
    grid-column: span 2;
    min-height: 70px;
}

.label {
    font-weight: 700;
    display: block;
}

.goods-table,
.tax-table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
}

.goods-table th,
.goods-table td {
    border-right: 1px solid #000;
    padding: 3px 4px;
    vertical-align: top;
}

.goods-table th {
    text-align: center;
    font-weight: 700;
    border-bottom: 1px solid #000;
}

.goods-table th:last-child,
.goods-table td:last-child {
    border-right: none;
}

.item-row td {
    height: 34px;
}

.item-name {
    font-weight: 800;
}

.serial-text {
    font-size: 9px;
    font-weight: 500;
    line-height: 11px;
    margin-left: 8px;
}

.blank-space td {
    height: 125px;
}

.tax-line td {
    height: 18px;
    font-weight: 700;
}

.total-row td {
    border-top: 1.5px solid #000;
    border-bottom: 1.5px solid #000;
    height: 24px;
    font-weight: 800;
}

.words-box {
    padding: 4px 6px;
    border-bottom: 1.5px solid #000;
    line-height: 14px;
}

.tax-table th,
.tax-table td {
    border-right: 1px solid #000;
    border-bottom: 1px solid #000;
    padding: 2px 4px;
    text-align: right;
}

.tax-table th {
    text-align: center;
    font-weight: 700;
}

.tax-table th:last-child,
.tax-table td:last-child {
    border-right: none;
}

.bottom-section {
    display: grid;
    grid-template-columns: 52% 48%;
    min-height: 82px;
}

.declaration-box {
    padding: 5px 6px;
    border-right: 1.5px solid #000;
    line-height: 13px;
}

.signature-box {
    padding: 5px 6px;
    position: relative;
    line-height: 13px;
}

.sign-company {
    text-align: right;
    font-weight: 800;
}

.sign-text {
    position: absolute;
    right: 8px;
    bottom: 6px;
    font-weight: 700;
}

.footer-note {
    text-align: center;
    border-top: 1.5px solid #000;
    padding: 3px;
    font-weight: 700;
}

.text-right { text-align: right; }
.text-center { text-align: center; }
.text-left { text-align: left; }
.bold { font-weight: 800; }

.print-btn {
    display: block;
    margin: 20px auto;
    padding: 9px 20px;
    border: none;
    background: #111;
    color: #fff;
    border-radius: 4px;
    cursor: pointer;
}
</style>

@php
function invArr($value) {
    if (!$value) return [];
    return array_map('trim', explode(',', $value));
}

function moneyFmt($amount) {
    return number_format((float)$amount, 2);
}

function indianWords($number) {
    $number = round((float)$number);

    $words = [
        0 => '', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four',
        5 => 'Five', 6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
        10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen',
        14 => 'Fourteen', 15 => 'Fifteen', 16 => 'Sixteen',
        17 => 'Seventeen', 18 => 'Eighteen', 19 => 'Nineteen',
        20 => 'Twenty', 30 => 'Thirty', 40 => 'Forty', 50 => 'Fifty',
        60 => 'Sixty', 70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
    ];

    $two = function($n) use ($words) {
        if ($n == 0) return '';
        if ($n < 20) return $words[$n];

        return trim($words[floor($n / 10) * 10] . ' ' . $words[$n % 10]);
    };

    if ($number == 0) return 'Zero Only';

    $out = '';

    $crore = floor($number / 10000000);
    $number %= 10000000;

    $lakh = floor($number / 100000);
    $number %= 100000;

    $thousand = floor($number / 1000);
    $number %= 1000;

    $hundred = floor($number / 100);
    $number %= 100;

    if ($crore) $out .= $two($crore) . ' Crore ';
    if ($lakh) $out .= $two($lakh) . ' Lakh ';
    if ($thousand) $out .= $two($thousand) . ' Thousand ';
    if ($hundred) $out .= $words[$hundred] . ' Hundred ';
    if ($number) $out .= $two($number) . ' ';

    return trim($out) . ' Only';
}

$productNames = invArr($productdata->productname ?? '');
$hsnCodes     = invArr($productdata->hsnno ?? '');
$quantities   = invArr($productdata->productquantity ?? '');
$rates        = invArr($productdata->rate ?? $productdata->totalamount ?? '');
$amounts      = invArr($productdata->amount ?? '');
$measurements = invArr($productdata->measurement ?? '');
$serials      = invArr($productdata->serialno ?? '');

$subTotal = array_sum(array_map('floatval', $amounts));

$cgstRate = 9;
$sgstRate = 9;

$cgst = ($subTotal * $cgstRate) / 100;
$sgst = ($subTotal * $sgstRate) / 100;

$totalTax = $cgst + $sgst;

$totalIncludingTax = $subTotal + $totalTax;

$userDiscountRate = (float)($productdata->user_discount_rate ?? 0);
$roleDiscountRate = (float)($productdata->role_discount_rate ?? 0);

$userDiscountAmount = ($totalIncludingTax * $userDiscountRate) / 100;

$afterUserDiscount = $totalIncludingTax - $userDiscountAmount;

$roleDiscountAmount = ($afterUserDiscount * $roleDiscountRate) / 100;

$totalDiscount = $userDiscountAmount + $roleDiscountAmount;

$finalBeforeRound = $totalIncludingTax - $totalDiscount;
$finalTotal = round($finalBeforeRound);
$roundOff = $finalTotal - $finalBeforeRound;

$totalQty = array_sum(array_map('floatval', $quantities));
@endphp

<div class="invoice-wrapper" id="invoiceArea">

    <div class="invoice-title">Tax Invoice</div>

    <div class="top-section">
        <div class="left-info">
            <div class="party-box">
                <div class="company-name">JAJOT MARKETING PVT LTD</div>
                <div>BA/F, FOYSAGAR ROAD</div>
                <div>AJMER</div>
                <div>Rajasthan - 305001, India</div>
                <div><b>GSTIN/UIN:</b> 08AAFCJ9229C1ZJ</div>
                <div><b>State Name:</b> Rajasthan, Code : 08</div>
                <div><b>CIN:</b> U74999RJ2018PTC062266</div>
            </div>

            <div class="party-box">
                <div><b>Consignee (Ship to)</b></div>
                <div class="company-name">{{ strtoupper($productdata->username ?? 'N/A') }}</div>
                <div>{{ $productdata->address ?? '' }}</div>
                <div>{{ $productdata->city ?? '' }} {{ $productdata->pincode ?? '' }}</div>
                <div><b>GSTIN/UIN:</b> {{ $productdata->gstnumber ?? 'N/A' }}</div>
                <div><b>State Name:</b> {{ $productdata->region ?? 'Rajasthan' }}, Code : 08</div>
            </div>

            <div class="party-box">
                <div><b>Buyer (Bill to)</b></div>
                <div class="company-name">{{ strtoupper($productdata->framname ?? $productdata->username ?? 'N/A') }}</div>
                <div>{{ $productdata->address ?? '' }}</div>
                <div>{{ $productdata->city ?? '' }} {{ $productdata->pincode ?? '' }}</div>
                <div><b>GSTIN/UIN:</b> {{ $productdata->gstnumber ?? 'N/A' }}</div>
                <div><b>State Name:</b> {{ $productdata->region ?? 'Rajasthan' }}, Code : 08</div>
                <div><b>Place of Supply:</b> {{ $productdata->region ?? 'Rajasthan' }}</div>
            </div>
        </div>

        <div class="right-grid">
            <div class="invoice-field">
                <span class="label">Invoice No.</span>
                {{ $productdata->invoiceno ?? 'N/A' }}
            </div>

            <div class="invoice-field">
                <span class="label">Dated</span>
                {{ $productdata->invoicedate ?? date('d-M-y') }}
            </div>

            <div class="invoice-field">
                <span class="label">Delivery Note</span>
                {{ $productdata->deliverynote ?? '' }}
            </div>

            <div class="invoice-field">
                <span class="label">Mode/Terms of Payment</span>
                {{ $productdata->paymentterms ?? '' }}
            </div>

            <div class="invoice-field">
                <span class="label">Reference No. & Date.</span>
                {{ $productdata->referenceno ?? '' }}
            </div>

            <div class="invoice-field">
                <span class="label">Other References</span>
                {{ $productdata->otherreferences ?? '' }}
            </div>

            <div class="invoice-field">
                <span class="label">Buyer Order No.</span>
                {{ $productdata->buyerorderno ?? '' }}
            </div>

            <div class="invoice-field">
                <span class="label">Dated</span>
                {{ $productdata->buyerorderdate ?? '' }}
            </div>

            <div class="invoice-field">
                <span class="label">Dispatch Doc No.</span>
                {{ $productdata->dispatchdocno ?? '' }}
            </div>

            <div class="invoice-field">
                <span class="label">Delivery Note Date</span>
                {{ $productdata->deliverynotedate ?? '' }}
            </div>

            <div class="invoice-field">
                <span class="label">Dispatched through</span>
                {{ $productdata->drivercompany ?? '' }}
            </div>

            <div class="invoice-field">
                <span class="label">Destination</span>
                {{ $productdata->destination ?? $productdata->region ?? '' }}
            </div>

            <div class="invoice-field full">
                <span class="label">Terms of Delivery</span>
                {{ $productdata->termsofdelivery ?? '' }}
            </div>
        </div>
    </div>

    <table class="goods-table">
        <thead>
            <tr>
                <th style="width:4%;">Sl<br>No.</th>
                <th style="width:37%;">Description of Goods</th>
                <th style="width:9%;">HSN/SAC</th>
                <th style="width:9%;">Quantity</th>
                <th style="width:9%;">Rate<br><small>(Incl. of Tax)</small></th>
                <th style="width:9%;">Rate</th>
                <th style="width:5%;">per</th>
                <th style="width:5%;">Disc. %</th>
                <th style="width:13%;">Amount</th>
            </tr>
        </thead>

        <tbody>
            @foreach($productNames as $index => $productName)
                @php
                    $qty = (float)($quantities[$index] ?? 0);
                    $amt = (float)($amounts[$index] ?? 0);

                    $rateWithoutTax = $qty > 0 ? $amt / $qty : 0;

                    $lineTax = $amt * 18 / 100;
                    $lineAmountWithTax = $amt + $lineTax;

                    $rateInclTax = $qty > 0 ? $lineAmountWithTax / $qty : 0;
                @endphp

                <tr class="item-row">
                    <td class="text-center">{{ $index + 1 }}</td>

                    <td>
                        <div class="item-name">{{ $productName }}</div>

                        @if(!empty($serials[$index]))
                            <div class="serial-text">{{ $serials[$index] }}</div>
                        @endif
                    </td>

                    <td class="text-center">{{ $hsnCodes[$index] ?? '' }}</td>

                    <td class="text-right bold">
                        {{ $quantities[$index] ?? '' }}
                    </td>

                    <td class="text-right">{{ moneyFmt($rateInclTax) }}</td>

                    <td class="text-right">{{ moneyFmt($rateWithoutTax) }}</td>

                    <td class="text-center">{{ $measurements[$index] ?? 'Pcs.' }}</td>

                    <td class="text-center"></td>

                    <td class="text-right bold">{{ moneyFmt($amt) }}</td>
                </tr>
            @endforeach

            <tr class="blank-space">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr class="tax-line">
                <td></td>
                <td class="text-right">Original Amount</td>
                 <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                <td class="text-right">{{ moneyFmt($subTotal) }}</td>
            </tr>

            <tr class="tax-line">
                <td></td>
                <td class="text-right">CGST</td>
                <td></td>
                <td></td>
                <td></td>
                <td class="text-right">{{ $cgstRate }}</td>
                <td class="text-center">%</td>
                <td></td>
                <td class="text-right">{{ moneyFmt($cgst) }}</td>
            </tr>

            <tr class="tax-line">
                <td></td>
                <td class="text-right">SGST</td>
                <td></td>
                <td></td>
                <td></td>
                <td class="text-right">{{ $sgstRate }}</td>
                <td class="text-center">%</td>
                <td></td>
                <td class="text-right">{{ moneyFmt($sgst) }}</td>
            </tr>

            <tr class="tax-line">
                <td></td>
                <td class="text-right">Total Value Including Tax</td>
                <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                <td class="text-right bold">{{ moneyFmt($totalIncludingTax) }}</td>
            </tr>

            @if($userDiscountRate > 0)
                <tr class="tax-line">
                    <td></td>
                    <td class="text-right">User Discount </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="padding:5px;">{{ moneyFmt($userDiscountRate) }}% </td>
                    <td class="text-right">- {{ moneyFmt($userDiscountAmount) }}</td>
                </tr>
            @endif

            @if($roleDiscountRate > 0)
                <tr class="tax-line">
                    <td></td>
                    <td class="text-right">Role Discount</td>
                     <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="padding:5px;"> {{ moneyFmt($roleDiscountRate) }}%</td>
                    <td class="text-right">- {{ moneyFmt($roleDiscountAmount) }}</td>
                </tr>
            @endif

            @if($totalDiscount > 0)
                <tr class="tax-line">
                    <td></td>
                    <td class="text-right">Total Discount</td>
                      <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-right">- {{ moneyFmt($totalDiscount) }}</td>
                </tr>
            @endif

            <tr class="tax-line">
                <td></td>
                <td class="text-right">Round Off</td>
                  <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                <td class="text-right">{{ moneyFmt($roundOff) }}</td>
            </tr>

            <tr class="total-row">
                <td></td>
                <td class="text-right">Final Total</td>
                <td></td>
                <td class="text-right">{{ $totalQty }} Pcs.</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="text-right">₹ {{ moneyFmt($finalTotal) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="words-box">
        <div>
            Amount Chargeable (in words)
            <span style="float:right;">E. &amp; O.E</span>
        </div>
        <div class="bold">INR {{ indianWords($finalTotal) }}</div>
    </div>

    <table class="tax-table">
        <thead>
            <tr>
                <th style="width:25%;">HSN/SAC</th>
                <th style="width:15%;">Taxable<br>Value</th>
                <th style="width:10%;">CGST<br>Rate</th>
                <th style="width:15%;">CGST<br>Amount</th>
                <th style="width:10%;">SGST/UTGST<br>Rate</th>
                <th style="width:15%;">SGST/UTGST<br>Amount</th>
                <th style="width:10%;">Total<br>Tax Amount</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td class="text-left">{{ $hsnCodes[0] ?? '85171400' }}</td>
                <td>{{ moneyFmt($subTotal) }}</td>
                <td>{{ $cgstRate }}%</td>
                <td>{{ moneyFmt($cgst) }}</td>
                <td>{{ $sgstRate }}%</td>
                <td>{{ moneyFmt($sgst) }}</td>
                <td>{{ moneyFmt($totalTax) }}</td>
            </tr>

            <tr class="bold">
                <td>Total</td>
                <td>{{ moneyFmt($subTotal) }}</td>
                <td></td>
                <td>{{ moneyFmt($cgst) }}</td>
                <td></td>
                <td>{{ moneyFmt($sgst) }}</td>
                <td>{{ moneyFmt($totalTax) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="words-box">
        <div>
            Tax Amount (in words) :
            <b>INR {{ indianWords($totalTax) }}</b>
        </div>
    </div>

    <div class="bottom-section">
        <div class="declaration-box">
            <div><b>Company's PAN</b> : AAFCJ9229C</div>
            <br>
            <div><b>Declaration</b></div>
            <div>
                Goods once sold will not be taken back. Subject to Ajmer Jurisdiction.
                Interest @18% p.a. will be charged if the payment is not made within due date.
            </div>
        </div>

        <div class="signature-box">
            <div class="sign-company">for JAJOT MARKETING PVT LTD</div>
            <div class="sign-text">Authorised Signatory</div>
        </div>
    </div>

    <div class="footer-note">
        This is a Computer Generated Invoice
    </div>
</div>

<button class="print-btn no-print" onclick="window.print()">
    Print / Download Invoice
</button>

</div>