<div>
<style>
@page { size: A4; margin: 8mm; }

*{
    box-sizing: border-box;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 10px;
}

.invoice-wrapper{
    max-width: 780px;
    margin: auto;
    background: #fff;
}

.invoice{
    border: 1.5px solid #000;
}

table{
    width: 100%;
    border-collapse: collapse;
}

td, th{
    border: 1px solid #000;
    padding: 4px 5px;
    vertical-align: top;
}

.title{
    text-align:center;
    font-weight:bold;
    padding:5px;
    border-bottom:1px solid #000;
}

.text-center{ text-align:center; }
.text-right{ text-align:right; }
.text-bold{ font-weight:bold; }
.small{ font-size:9px; }

.goods-table th{
    text-align:center;
    font-weight:bold;
}

.goods-row td{
    height:250px;
}

.summary-line{
    display:flex;
    justify-content:space-between;
    margin-bottom:8px;
}

.print-btn{
    margin:20px auto;
    display:block;
    padding:8px 18px;
    background:#111;
    color:#fff;
    border:0;
    cursor:pointer;
}

@media print{
    .print-btn{ display:none; }
}
</style>

@php
    $productNames = !empty($productdata->productname) ? explode(',', $productdata->productname) : [];
    $hsnCodes = !empty($productdata->hsnno) ? explode(',', $productdata->hsnno) : [];
    $qtyList = !empty($productdata->productquantity) ? explode(',', $productdata->productquantity) : [];
    $amountList = !empty($productdata->amount) ? explode(',', $productdata->amount) : [];
    $measurementList = !empty($productdata->measurement) ? explode(',', $productdata->measurement) : [];

    $items = [];
    $taxableTotal = 0;
    $totalQty = 0;

    foreach ($productNames as $index => $name) {
        $qty = (float)($qtyList[$index] ?? 0);
        $amount = (float)($amountList[$index] ?? 0);
        $rate = $qty > 0 ? ($amount / $qty) : 0;

        $cgst = $amount * 9 / 100;
        $sgst = $amount * 9 / 100;

        $items[] = [
            'name' => trim($name),
            'hsn' => trim($hsnCodes[$index] ?? ''),
            'qty' => $qty,
            'rate' => $rate,
            'amount' => $amount,
            'cgst' => $cgst,
            'sgst' => $sgst,
            'measurement' => trim($measurementList[$index] ?? 'Pcs'),
        ];

        $taxableTotal += $amount;
        $totalQty += $qty;
    }

    $cgstTotal = $taxableTotal * 9 / 100;
    $sgstTotal = $taxableTotal * 9 / 100;
    $totalTax = $cgstTotal + $sgstTotal;
    $grandTotal = $taxableTotal + $totalTax;
    $roundOff = round($grandTotal) - $grandTotal;
    $finalTotal = round($grandTotal);

    function numberToIndianWordsInvoice($number)
    {
        $number = (int) round($number);

        $words = [
            0 => '', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four',
            5 => 'Five', 6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
            10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen',
            14 => 'Fourteen', 15 => 'Fifteen', 16 => 'Sixteen',
            17 => 'Seventeen', 18 => 'Eighteen', 19 => 'Nineteen',
            20 => 'Twenty', 30 => 'Thirty', 40 => 'Forty', 50 => 'Fifty',
            60 => 'Sixty', 70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
        ];

        $convert = function ($num) use (&$convert, $words) {
            $str = '';

            if ($num >= 10000000) {
                $str .= $convert((int)($num / 10000000)) . ' Crore ';
                $num %= 10000000;
            }

            if ($num >= 100000) {
                $str .= $convert((int)($num / 100000)) . ' Lakh ';
                $num %= 100000;
            }

            if ($num >= 1000) {
                $str .= $convert((int)($num / 1000)) . ' Thousand ';
                $num %= 1000;
            }

            if ($num >= 100) {
                $str .= $convert((int)($num / 100)) . ' Hundred ';
                $num %= 100;
            }

            if ($num > 0) {
                if ($num < 20) {
                    $str .= $words[$num];
                } else {
                    $str .= $words[(int)($num / 10) * 10] . ' ' . $words[$num % 10];
                }
            }

            return trim($str);
        };

        return 'INR ' . trim($convert($number)) . ' Only';
    }
@endphp

<div class="invoice-wrapper">
    <div class="invoice">

        <div class="title">Tax Invoice</div>

        <table>
            <tr>
                <td rowspan="3" style="width:58%;">
                    <b>JAJOT MARKETING PVT LTD</b><br>
                    BA/F, FOYSAGAR ROAD<br>
                    AJMER<br>
                    Rajasthan - 305001, India<br>
                    <b>GSTIN/UIN:</b> 08AAFCJ9229C1ZJ<br>
                    <b>State Name:</b> Rajasthan, Code : 08<br>
                    <b>CIN:</b> U74999RJ2018PTC062266
                </td>
                <td style="width:21%;">
                    <b>Invoice No.</b><br>
                    {{ $productdata->invoiceno }}
                </td>
                <td style="width:21%;">
                    <b>Dated</b><br>
                    {{ $productdata->invoicedate }}
                </td>
            </tr>
            <tr>
                <td><b>Delivery Note</b></td>
                <td><b>Mode/Terms of Payment</b></td>
            </tr>
            <tr>
                <td><b>Reference No. & Date.</b></td>
                <td><b>Other References</b></td>
            </tr>

            <tr>
                <td rowspan="2">
                    <b>Consignee (Ship to)</b><br>
                    <b>{{ strtoupper($productdata->username ?? '') }}</b><br>
                    {{ $productdata->address ?? '' }}<br>
                    <b>GSTIN/UIN:</b> {{ $productdata->gstnumber ?: 'N/A' }}<br>
                    <b>State Name:</b> Rajasthan, Code : 08
                </td>
                <td><b>Buyer Order No.</b></td>
                <td><b>Dated</b></td>
            </tr>
            <tr>
                <td><b>Dispatch Doc No.</b></td>
                <td><b>Delivery Note Date</b></td>
            </tr>

            <tr>
                <td rowspan="2">
                    <b>Buyer (Bill to)</b><br>
                    <b>{{ strtoupper($productdata->username ?? '') }}</b><br>
                    {{ $productdata->address ?? '' }}<br>
                    <b>GSTIN/UIN:</b> {{ $productdata->gstnumber ?: 'N/A' }}<br>
                    <b>State Name:</b> Rajasthan, Code : 08<br>
                    <b>Place of Supply:</b> Rajasthan
                </td>
                <td>
                    <b>Dispatched through</b><br>
                    {{ $productdata->drivercompany ?? '' }}
                </td>
                <td>
                    <b>Destination</b><br>
                    {{ $productdata->region ?? '' }}
                </td>
            </tr>
            <tr>
                <td colspan="2" style="height:55px;"><b>Terms of Delivery</b></td>
            </tr>
        </table>

        <table class="goods-table">
            <thead>
                <tr>
                    <th style="width:4%;">Sl<br>No.</th>
                    <th style="width:38%;">Description of Goods</th>
                    <th style="width:10%;">HSN/SAC</th>
                    <th style="width:8%;">Quantity</th>
                    <th style="width:10%;">Rate<br><span class="small">(Incl. of Tax)</span></th>
                    <th style="width:10%;">Rate</th>
                    <th style="width:5%;">per</th>
                    <th style="width:5%;">Disc.<br>%</th>
                    <th style="width:10%;">Amount</th>
                </tr>
            </thead>

            <tbody>
                @foreach($items as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td><b>{{ $item['name'] }}</b></td>
                        <td class="text-center">{{ $item['hsn'] }}</td>
                        <td class="text-right"><b>{{ $item['qty'] }}</b></td>
                        <td class="text-right">{{ number_format($item['rate'] * 1.18, 2) }}</td>
                        <td class="text-right">{{ number_format($item['rate'], 2) }}</td>
                        <td class="text-center">{{ $item['measurement'] ?: 'Pcs' }}</td>
                        <td></td>
                        <td class="text-right"><b>{{ number_format($item['amount'], 2) }}</b></td>
                    </tr>
                @endforeach

                <tr class="goods-row">
                    <td></td>
                    <td class="text-right">
                        <div style="margin-top:170px;">
                            <b>Original Amount</b><br><br>
                            <b>CGST</b><br><br>
                            <b>SGST</b><br><br>
                            <b>Total Value Including Tax</b><br><br>
                            <b>Round Off</b>
                        </div>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-right">
                        <div style="margin-top:195px;">
                            9<br><br>
                            9
                        </div>
                    </td>
                    <td class="text-center">
                        <div style="margin-top:195px;">
                            %<br><br>
                            %
                        </div>
                    </td>
                    <td></td>
                    <td class="text-right">
                        <div style="margin-top:170px;">
                            <b>{{ number_format($taxableTotal, 2) }}</b><br><br>
                            <b>{{ number_format($cgstTotal, 2) }}</b><br><br>
                            <b>{{ number_format($sgstTotal, 2) }}</b><br><br>
                            <b>{{ number_format($grandTotal, 2) }}</b><br><br>
                            <b>{{ number_format($roundOff, 2) }}</b>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td></td>
                    <td colspan="2" class="text-right"><b>Final Total</b></td>
                    <td class="text-right"><b>{{ $totalQty }} Pcs.</b></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-right"><b>₹ {{ number_format($finalTotal, 2) }}</b></td>
                </tr>
            </tbody>
        </table>

        <table>
            <tr>
                <td>
                    Amount Chargeable (in words)
                    <span style="float:right;">E. & O.E</span><br>
                    <b>{{ numberToIndianWordsInvoice($finalTotal) }}</b>
                </td>
            </tr>
        </table>

        <table>
            <tr>
                <th>HSN/SAC</th>
                <th>Taxable<br>Value</th>
                <th>CGST<br>Rate</th>
                <th>CGST<br>Amount</th>
                <th>SGST/UTGST<br>Rate</th>
                <th>SGST/UTGST<br>Amount</th>
                <th>Total<br>Tax Amount</th>
            </tr>

            @foreach($items as $item)
                <tr>
                    <td class="text-right">{{ $item['hsn'] }}</td>
                    <td class="text-right">{{ number_format($item['amount'], 2) }}</td>
                    <td class="text-right">9%</td>
                    <td class="text-right">{{ number_format($item['cgst'], 2) }}</td>
                    <td class="text-right">9%</td>
                    <td class="text-right">{{ number_format($item['sgst'], 2) }}</td>
                    <td class="text-right">{{ number_format($item['cgst'] + $item['sgst'], 2) }}</td>
                </tr>
            @endforeach

            <tr>
                <td class="text-right"><b>Total</b></td>
                <td class="text-right"><b>{{ number_format($taxableTotal, 2) }}</b></td>
                <td></td>
                <td class="text-right"><b>{{ number_format($cgstTotal, 2) }}</b></td>
                <td></td>
                <td class="text-right"><b>{{ number_format($sgstTotal, 2) }}</b></td>
                <td class="text-right"><b>{{ number_format($totalTax, 2) }}</b></td>
            </tr>
        </table>

        <table>
            <tr>
                <td>
                    Tax Amount (in words) :
                    <b>{{ numberToIndianWordsInvoice($totalTax) }}</b>
                </td>
            </tr>
        </table>

        <table>
            <tr>
                <td style="width:52%; height:80px;">
                    <b>Company's PAN :</b> AAFCJ9229C<br><br>
                    <b>Declaration</b><br>
                    Goods once sold will not be taken back. Subject to Ajmer Jurisdiction.
                    Interest @18% p.a. will be charged if the payment is not made within due date.
                </td>
                <td style="width:48%; height:80px;" class="text-right">
                    <b>for JAJOT MARKETING PVT LTD</b><br><br><br><br>
                    <b>Authorised Signatory</b>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="text-center">
                    <b>This is a Computer Generated Invoice</b>
                </td>
            </tr>
        </table>

    </div>

    <button onclick="window.print()" class="print-btn">Download / Print PDF</button>
</div>
</div>