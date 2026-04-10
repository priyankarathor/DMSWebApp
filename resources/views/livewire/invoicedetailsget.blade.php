<div>
    <style>
        *{
             font-family: "Lato", sans-serif;
             font-weight: <weight>;
             font-style: normal;
             font-size:10px;
        }
    </style>
    <div class="page-wrapper">

            <div class="container-fluid mt-4" style="padding: 60px;" >
                <div class="row">
                    <div class="col-lg-12 mx-auto">
                        <div class="card">
                            <div class="card-body invoice-head">
                                <div class="row">
                                    <meta charset="UTF-8">
                                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                    <title>Invoice</title>
                                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
                                        rel="stylesheet"
                                        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
                                        crossorigin="anonymous">
                                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                                        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
                                    </script>
                                    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
                                        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
                                    </script>
                                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
                                        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
                                    </script>

                                    <body class="border border-2 m-5">
                                        <div class="container">
                                            <div class="invoice-box">
                                                <div class="row">

                                                    <header>
                                                        <div class="container border border-2 border-dark">
                                                            <div class="row">
                                                                <div class="col-4 border-end border-2 border-dark text-center py-3">
                                                                    <img src="{{ asset('image/vmlogo.png') }}"
                                                                        alt="logo-small"
                                                                        style="width: 38%; height:auto; text-align: center !important;"
                                                                        class="mb-1 mt-1">
                                                                </div>
                                                                <div class="col-8 text-center py-5" style="background-color:rgb(116, 201, 50);color:rgb(255,255,255)">
                                                                     <span><b class="display-6 fw-bold "> RM Ture Petroleum Ltd.</b> 
                                                                     <p style="font-size:12px;">Near TTC Industrial Area ,MIDC, North Central Road,Navi Mumbai - 400701.</p></span>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-4 fs-6 border-top border-end border-2 border-dark p-3">
                                                                    <span><b>Contact : </b></span>+91 7300428880
                                                                </div>
                                                                 <div class="col-4 fs-6 border-top border-end border-2 border-dark p-3">
                                                                    <span><b>Email : </b></span>account@vandemileagerlubricant.com 
                                                                </div>
                                                                 <div class="col-4 fs-6 border-top border-2 border-dark p-3">
                                                                    <span><b>GST No. : </b></span>08AHHPC4356M1Z4
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12 border-top border-2 border-dark p-3">
                                                                    <span><b>Address : </b></span>Near TTC Industrial Area, MIDC, North Central Road, Navi Mumbai - 400701
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </header>

                                                    <section>
                                                        <div class="container-fluid px-3 my-3">
                                                            <div class="row pb-0">
                                                                <div class="col-3 ps-2 pt-3">
                                                                    <span>
                                                                        <b class="fs-5"> Invoice No. : </b> 
                                                                            {{ $productdata->invoiceno }}
                                                                    </span> 
                                                                </div>
                                                                <div class="col-6 text-center">
                                                                    <h5 class="display-4 fw-bold">GST INVOICE</h5>
                                                                </div>
                                                                <div class="col-3 ps-0 text-end pe-3 pt-3">
                                                                    <span>
                                                                        <b class="fs-5"> Date : </b> {{ $productdata->invoicedate }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                               <div class="row border border-bottom-0 border-2 border-dark py-2 px-2">
                                                                    <div class="col-12 ps-2 mt-3">
                                                                          <h5><u class="fw-bolder fs-5">SUPPLIER TO</u></h5>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <span>
                                                                                <b>Consignee : </b> {{ $productdata->username }}
                                                                        </span><br>
                                                                        <span>
                                                                            <b>Address : </b>    {{$productdata->address}}
                                                                                {{$productdata->region}}
                                                                        </span><br>
                                                                        <span>
                                                                            <b>GST NO. : </b>{{$productdata->gstnumber}}
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <span>
                                                                                <b >Distributor Name : </b> {{ strtoupper($productdata->username) }}
                                                                        </span><br>
                                                                         <span>
                                                                            <b>Address : </b>    {{$productdata->address}}
                                                                                {{$productdata->region}}
                                                                        </span><br>
                                                                        <span>
                                                                            <b>GST NO. : </b>{{$productdata->gstnumber}}
                                                                        </span>
                                                                       
                                                                    </div>
                                                                    
                                                               </div>
                                                               
                                                                <div class="row">
                                                                    <div class="col-6 border border-end-0 border-2 border-dark p-3">
                                                                        <h5><u class="fw-bolder fs-5">INVOICE TO</u></h5>
                                                                        <!--<h5><b class="fs-5">{{ $productdata->companyname }}</b></h5>-->
                                                                        <div class="row">
                                                                            <div class="col-4">
                                                                                <b>Company Name</b>
                                                                            </div>
                                                                            <div class="col-1">
                                                                                <b>:</b> 
                                                                            </div>
                                                                            <div class="col-7">
                                                                                {{ $productdata->framname }}
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-4">
                                                                                <b>Phone No. </b>
                                                                            </div>
                                                                            <div class="col-1">
                                                                                <b>:</b> 
                                                                            </div>
                                                                            <div class="col-7">
                                                                                +91 {{ $productdata->contactno }}
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-4">
                                                                                <b>Email </b>
                                                                            </div>
                                                                            <div class="col-1">
                                                                                <b>:</b> 
                                                                            </div>
                                                                            <div class="col-7">
                                                                                {{ $productdata->email }}
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-4">
                                                                                <b>GST No. </b>
                                                                            </div>
                                                                            <div class="col-1">
                                                                                <b>:</b> 
                                                                            </div>
                                                                            <div class="col-7">
                                                                               {{ $productdata->gstnumber }}
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-4">
                                                                                <b>Udyam Card No. </b>
                                                                            </div>
                                                                            <div class="col-1">
                                                                                <b>:</b> 
                                                                            </div>
                                                                            <div class="col-7">
                                                                               {{ $productdata->udyamno }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                     <div class="col-6 p-3 border border-2 border-dark">
                                                                        <h5><u class="fw-bolder fs-5">TRANSPORTATION DETAILS</u></h5>
                                                                        <div class="row">
                                                                            <div class="col-5">
                                                                                <b>Buyer Order No. </b>
                                                                            </div>
                                                                            <div class="col-1">
                                                                                <b>:</b> 
                                                                            </div>
                                                                            <div class="col-6">
                                                                                S.S Rathore
                                                                            </div>
                                                                        </div>
                                                                       
                                                                        <div class="row">
                                                                            <div class="col-5">
                                                                                <b>Destination</b>
                                                                            </div>
                                                                            <div class="col-1">
                                                                                <b>:</b> 
                                                                            </div>
                                                                            <div class="col-6">
                                                                                 {{ $productdata->region }}
                                                                            </div>
                                                                        </div>
                                                                      
                                                                      <!-- <div class="row">
                                                                            <div class="col-5">
                                                                                <b>Bill of Loading/R R No.</b>
                                                                            </div>
                                                                            <div class="col-1">
                                                                                <b>:</b> 
                                                                            </div>
                                                                            <div class="col-6">
                                                                                54563566
                                                                            </div>
                                                                        </div>-->
                                                                        
                                                                        <div class="row">
                                                                            <div class="col-5">
                                                                                <b>Dispatch Through</b>
                                                                            </div>
                                                                            <div class="col-1">
                                                                                <b>:</b> 
                                                                            </div>
                                                                            <div class="col-6">
                                                                                {{ $productdata->drivercompany }}
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-5">
                                                                                <b>Contact Person</b>
                                                                            </div>
                                                                            <div class="col-1">
                                                                                <b>:</b> 
                                                                            </div>
                                                                            <div class="col-6">
                                                                               {{ $productdata->drivername }}
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-5">
                                                                                <b>Vehicle No.</b>
                                                                            </div>
                                                                            <div class="col-1">
                                                                                <b>:</b> 
                                                                            </div>
                                                                            <div class="col-6">
                                                                                {{ $productdata->vehicleno }}
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-5">
                                                                                <b>Contact No.</b>
                                                                            </div>
                                                                            <div class="col-1">
                                                                                <b>:</b> 
                                                                            </div>
                                                                            <div class="col-6">
                                                                                +91 {{ $productdata->drivercontact }}
                                                                            </div>
                                                                        </div>
                                                                        
                                                                </div>
                                                                </div>
                                                            </div>
                                                            <div class="row py-2">
                                                                <div class="col-12">
                                                                    <table class="table ">
                                                                        <thead>
                                                                            <tr class="text-center">
                                                                                <th scope="col"
                                                                                    class="col-1 text-white fs-6 ps-2 py-3 pe-0 border-right border-1 rounded-0"
                                                                                    style="background-color:rgb(75,139,252)">
                                                                                    Sr No.</th>
                                                                                <th scope="col"
                                                                                    class="col-4 text-white fs-6 ps-2 py-3 pe-0 border-right border-white border-1 rounded-0"
                                                                                    style="background-color:rgb(116, 201, 50)">
                                                                                    Item Description</th>
                                                                                <th scope="col"
                                                                                    class="text-white fs-6 px-2 py-3 border-right border-white border-1 rounded-0"
                                                                                    style="background-color:rgb(75,139,252)">
                                                                                    HSN</th>
                                                                                <th scope="col"
                                                                                    class="text-white fs-6 px-2 py-3 border-right border-white border-1 rounded-0"
                                                                                    style="background-color:rgb(75,139,252)">
                                                                                    GST RATE%</th>
                                                                                <th scope="col"
                                                                                    class="text-white fs-6 px-2 py-3  border-right border-white border-1 rounded-0"
                                                                                    style="background-color:rgb(75,139,252)">
                                                                                    QNTY</th>
                                                                                <th scope="col"
                                                                                    class="text-white fs-6 px-2 py-3 border-right border-white border-1 rounded-0"
                                                                                    style="background-color:rgb(75,139,252)">
                                                                                    RATES</th>
                                                                                <th scope="col"
                                                                                    class="text-white fs-6 px-2 py-3 border-right border-white border-1 rounded-0"
                                                                                    style="background-color:rgb(75,139,252)">
                                                                                    BOX / BKT</th>
                                                                                <th scope="col"
                                                                                    class="text-white fs-6 px-2 py-3 border-right border-white border-1 rounded-0"
                                                                                    style="background-color:rgb(75,139,252)">
                                                                                    Total</th>
                                                                            </tr>
                                                                        </thead>    
                                                                    <tbody>
                                                                        @php
                                                                            // Check if productdata contains values before exploding
                                                                            $productNames = $productdata->productname
                                                                                ? explode(
                                                                                    ',',
                                                                                    $productdata->productname,
                                                                                )
                                                                                : [];
                                                                            $hsncode = $productdata->hsnno
                                                                                ? explode(',', $productdata->hsnno)
                                                                                : [];
                                                                            $Productqty = $productdata->productquantity
                                                                                ? explode(
                                                                                    ',',
                                                                                    $productdata->productquantity,
                                                                                )
                                                                                : [];
                                                                            $amounts = $productdata->amount
                                                                                ? explode(',', $productdata->amount)
                                                                                : [];
                                                                            $productBulks = $productdata->productbulk
                                                                                ? explode(
                                                                                    ',',
                                                                                    $productdata->productbulk,
                                                                                )
                                                                                : [];
                                                                            $productmeasurement = $productdata->measurement
                                                                                ? explode(
                                                                                    ',',
                                                                                    $productdata->measurement,
                                                                                )
                                                                                : [];
                                                                            $totalAmounts = $productdata->totalamount
                                                                                ? explode(
                                                                                    ',',
                                                                                    $productdata->totalamount,
                                                                                )
                                                                                : [];
                                                                        @endphp

                                                                        @foreach ($productNames as $index => $productName)
                                                                            <tr class="text-center">

                                                                                <td>{{ $index + 1 }}</td>
                                                                                <td scope="row"
                                                                                    class="ps-2 pt-3 fs-5">
                                                                                    <b>{{ $productName }}</b>
                                                                                </td>
                                                                                <td class="ps-2 pt-4" scope="row"
                                                                                    style="background-color:rgb(241, 241, 241)">
                                                                                    {{ $hsncode[$index] ?? '' }}
                                                                                </td>
                                                                                <td class="ps-2 pt-4"
                                                                                    style="background-color:rgb(241, 241, 241)">
                                                                                    18 %</td>
                                                                                <td class="ps-2 pt-4" scope="row"
                                                                                    style="background-color:rgb(241, 241, 241)">
                                                                                    {{ $Productqty[$index] ?? '' }}
                                                                                </td>
                                                                                <td class="ps-2 pt-4"
                                                                                    style="background-color:rgb(241, 241, 241)">
                                                                                    {{ $totalAmounts[$index] ?? '' }}
                                                                                </td>

                                                                                <td class="ps-2 pt-4 "
                                                                                    style="background-color:rgb(241, 241, 241)">
                                                                                    {{ $productBulks[$index] ?? '' }}-  {{ $productmeasurement[$index] ?? '' }}
                                                                                </td>
                                                                              
                                                                                <td class="ps-2 pt-4" scope="row"
                                                                                    style="background-color:rgb(241, 241, 241)">
                                                                                    {{ $amounts[$index] ?? '' }}
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                               
@php
    // Explode and convert to float
    $totalAmountsArray = array_map('floatval', explode(',', $productdata->amount));
    $totalDue = array_sum($totalAmountsArray);

    // Calculate CGST, SGST, IGST
    $cgst = $totalDue * 0.09;
    $sgst = $totalDue * 0.09;
    $igst = $totalDue * 0.18;

    // Calculate Total After Tax
    $totalAfterTax = $totalDue + $cgst + $sgst;

    // Apply discount (force discount to float)
    $discount = floatval($productdata->discount);
    $discountedTotal = $totalAfterTax - ($totalAfterTax * ($discount / 100));

    // Round-off calculations
    $roundedTotal = round($discountedTotal);
    $roundOffValue = $discountedTotal - $roundedTotal;

    // Explode arrays again with float conversion
    $totalAmountsArray = array_map('floatval', explode(',', $productdata->amount));
    $totalDue = array_sum($totalAmountsArray);

    $cgstArray = array_map('floatval', explode(',', $productdata->cgst));
    $sgstArray = array_map('floatval', explode(',', $productdata->sgst));
    $igstArray = array_map('floatval', explode(',', $productdata->igst));

    // Sum of taxes
    $totalCgst = array_sum($cgstArray);
    $totalSgst = array_sum($sgstArray);
    $totalIgst = array_sum($igstArray);

    // Grand Totals
    $grandTotal = $totalCgst + $totalSgst + $totalIgst;
    $grandTotales = $totalDue + $totalCgst + $totalSgst + $totalIgst;
@endphp


                                                                    <tr class="border-bottom border-top"
                                                                        style="border-bottom-width: 20px;border-top-width: 20px;">
                                                                        <td class=" py-3" rowspan="4"
                                                                            colspan="3">
                                                                            <span class="fs-5 fw-bold">Amount In Words</span>
                                                                            <h4 class="fw-bold" style="color:rgb(116, 201, 50)"
                                                                                id="amountInWords"></h4>
                                                                            <!-- Display the total sum -->
                                                                        </td><br />
<script>
    function convertToWords(num) {
        const ones = ["", "one", "two", "three", "four", "five", "six", "seven", "eight", "nine", "ten", "eleven",
            "twelve", "thirteen", "fourteen", "fifteen", "sixteen", "seventeen", "eighteen", "nineteen"
        ];
        const tens = ["", "", "twenty", "thirty", "forty", "fifty", "sixty", "seventy", "eighty", "ninety"];

        function twoDigitWord(n) {
            if (n < 20) {
                return ones[n];
            } else {
                return tens[Math.floor(n / 10)] + (n % 10 !== 0 ? " " + ones[n % 10] : "");
            }
        }

        function threeDigitWord(n) {
            const hundredPart = Math.floor(n / 100);
            const remainder = n % 100;
            const hundredText = hundredPart > 0 ? ones[hundredPart] + " hundred" : "";
            const remainderText = remainder > 0 ? " " + twoDigitWord(remainder) : "";
            return hundredText + remainderText;
        }

        function numToWords(n) {
            if (n === 0) return "zero";

            let crore = Math.floor(n / 10000000);
            n %= 10000000;
            let lakh = Math.floor(n / 100000);
            n %= 100000;
            let thousand = Math.floor(n / 1000);
            n %= 1000;
            let hundred = n;

            let result = "";

            if (crore > 0) result += `${twoDigitWord(crore)} crore `;
            if (lakh > 0) result += `${twoDigitWord(lakh)} lakh `;
            if (thousand > 0) result += `${twoDigitWord(thousand)} thousand `;
            if (hundred > 0) result += threeDigitWord(hundred);

            return result.trim() + " only";
        }

        return numToWords(Math.floor(num));
    }

    document.addEventListener("DOMContentLoaded", function () {
        const totalAmount = parseFloat("{{ $discountedTotal }}"); // Pass from Blade
        const amountInWords = convertToWords(totalAmount);
        document.getElementById("amountInWords").textContent = amountInWords.charAt(0).toUpperCase() + amountInWords.slice(1);
    });
</script>

                                                                    </tr>
                                                                    
                                                                    
                                                                    <tr class="text-center">
                                                                        <td colspan="5"
                                                                            style="background-color:rgb(196, 192, 192)">
                                                                            <div class="row justify-content-center py-2">
                                                                               <div class="col-4">
                                                                                    Total Amount 
                                                                               </div>
                                                                               <div class="col-1"> : </div>
                                                                               <div class="col-2">
                                                                                   {{ $totalDue }}
                                                                               </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>

                                                                    <tr class="text-center">
                                                                        <td colspan="5"
                                                                            style="background-color:rgb(196, 192, 192)">
                                                                             <div class="row justify-content-center py-2">
                                                                               <div class="col-4">
                                                                                    CGST (9%) 
                                                                            
                                                                               </div>
                                                                               <div class="col-1"> : </div>
                                                                               <div class="col-2">
                                                                                   {{ number_format($totalDue * 0.09, 2) }}
                                                                               </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>

                                                                    <tr class="text-center">
                                                                        <td colspan="5"
                                                                            style="background-color:rgb(196, 192, 192)">
                                                                             <div class="row justify-content-center py-2">
                                                                               <div class="col-4">
                                                                                    SGST (9%) 
                                                                               </div>
                                                                                <div class="col-1"> : </div>
                                                                               <div class="col-2">
                                                                                   {{ number_format($totalDue * 0.09, 2) }}
                                                                               </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                      
                                                                     <tr>
                                                                        <td class="align-top" rowspan="4" colspan="3" style="border-bottom:5px solid rgb(116, 201, 50)">
                                                                           <div class="row py-2">
                                                                               <span class="fs-5 fw-bold">Company Account Details</span>
                                                                           </div>
                                                                           <div class="row">
                                                                               <div class="col-3">
                                                                                   <b>Company Name </b>
                                                                               </div>
                                                                               <div class="col-1">
                                                                                  <b>:</b> 
                                                                               </div>
                                                                                <div class="col-8">
                                                                                   RM TRUE PATROLEUM LTD 
                                                                               </div>
                                                                           </div>
                                                                           <div class="row">
                                                                               <div class="col-3">
                                                                                   <b>Bank Name </b>
                                                                               </div>
                                                                               <div class="col-1">
                                                                                  <b>:</b> 
                                                                               </div>
                                                                                <div class="col-8">
                                                                                 ICICI BANK A/C No. 441405000022 
                                                                               </div>
                                                                           </div>
                                                                           <div class="row">
                                                                               <div class="col-3">
                                                                                   <b>A/C No. </b>
                                                                               </div>
                                                                               <div class="col-1">
                                                                                  <b>:</b> 
                                                                               </div>
                                                                                <div class="col-8">
                                                                                    441405000022 
                                                                               </div>
                                                                           </div>
                                                                            <div class="row">
                                                                               <div class="col-3">
                                                                                   <b>IFSC CODE </b>
                                                                               </div>
                                                                               <div class="col-1">
                                                                                  <b>:</b> 
                                                                               </div>
                                                                                <div class="col-8">
                                                                                   ICIC0004414
                                                                               </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                     
                                                                    <tr class="text-center">
                                                                        <td colspan="5"
                                                                            style="background-color:rgb(196, 192, 192)">
                                                                            <div class="row justify-content-center">
                                                                               <div class="col-4">
                                                                                    IGST (18%) 
                                                                               </div>
                                                                               <div class="col-1"> : </div>
                                                                               <div class="col-2">
                                                                                   {{ number_format($totalDue * 0.18, 2) }}
                                                                               </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>

                                                                    
                                                                    <tr class="text-center">
                                                                        <td colspan="6" style="background-color:rgb(196, 192, 192)">
                                                                            <span>Total After Tax</span>:
                                                                            <span>{{ number_format($totalAfterTax, 2) }}</span>
                                                                        </td>
                                                                    </tr>
                                                                    
                                                                    <tr class="text-center">
                                                                        <td colspan="6" style="background-color:rgb(196, 192, 192)">
                                                                            <span>Discount</span>:
                                                                            <span>{{ $productdata->discount }} %</span>
                                                                        </td>
                                                                    </tr>
                                                                   
                                                                    <tr class="text-center">
                                                                        <td colspan="3">
                                                                           
                                                                        </td>
                                                                        <td colspan="5" style="background-color:rgb(196, 192, 192)">
                                                                            <span>Discounted Total</span>:
                                                                            <span>{{ number_format($discountedTotal,2) }}</span>
                                                                        </td>
                                                                    </tr>
                                                                 
                                                                    {{-- <tr class="text-center">
                        <td colspan="5" style="background-color:rgb(196, 192, 192)">
                            <span><b>Total GST Amount</b></span>:
                            <span><b>{{ number_format(($totalDue * 0.09 * 2) + ($totalDue * 0.18), 2) }}</b></span>
                        </td>
                    </tr> --}}

                                                                    @php
                                                                        $roundedTotal = round($grandTotal); // Calculate the rounded value of the total amount
                                                                        $roundOffValue =
                                                                            $grandTotal - $roundedTotal; // Calculate the round off value
                                                                        $grandTotalWithRoundOff = $roundedTotal; // Use the rounded total in Grand Total
                                                                    @endphp
                                                                    <tr class="text-center">
                                                                        <td colspan="3">
                                                                           
                                                                        </td>
                                                                        <td colspan="5"
                                                                            style="background-color:rgb(196, 192, 192)">
                                                                            <div class="row justify-content-center">
                                                                               <div class="col-4">
                                                                                    Round Off 
                                                                               </div>
                                                                                <div class="col-1"> : </div>
                                                                               <div class="col-2">
                                                                                   {{ number_format(fmod(round($totalDue * 0.18 + $totalDue, 2), 1), 2) }}

                                                                               </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    {{-- <tr class="text-center">
                                                                        <td colspan="5"
                                                                            style="background-color:rgb(196, 192, 192)">
                                                                            <div class="row justify-content-center">
                                                                               <div class="col-4">
                                                                                    Grand Total 
                                                                               </div>
                                                                                <div class="col-1"> : </div>
                                                                               <div class="col-2">
                                                                                {{ number_format($discountedTotal,2) }}
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr> --}}
                                                                    <tr>
                                                                    <td style="border:none" class="pt-3"
                                                                        colspan="3">
                                                                        <h4 class="ps-2 fw-bold" style="color:rgb(75,139,252)">Thank you
                                                                            for your business</h4>
                                                                        <h5 class="ps-4 fw-bold pt-3">Terms & conditions
                                                                        </h5>
                                                                    </td>
                                                                    <td colspan="5"
                                                                        class="text-center p-0 align-top"
                                                                        >
                                                                        <div class="p-2" style="background-color:rgb(75,139,252);color:rgb(255,255,255)">
                                                                            <span class="fs-2 fw-bold">GRAND
                                                                            TOTAL</span>
                                                                        <span class="fs-2 fw-bold"> : </span>
                                                                        <span class="fs-2 fw-bold">
                                                                            ₹{{ number_format($discountedTotal,2) }} /-
                                                                        </span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                            <!--<table style="width: 100%">-->
                                                            <!--    <tr>-->
                                                            <!--        <td style="border:none" class="pt-3"-->
                                                            <!--            colspan="5">-->
                                                            <!--            <h4 class="text-info ps-2">Thank you-->
                                                            <!--                for your business</h4>-->
                                                            <!--            <h6 class="ps-2">Terms & conditions-->
                                                            <!--            </h6>-->
                                                            <!--        </td>-->
                                                            <!--        <td colspan="9"-->
                                                            <!--            class="text-center pt-3"-->
                                                            <!--            style="background-color:rgb(75,139,252);color:rgb(116, 201, 50)">-->
                                                            <!--            <span class="fs-3 fw-bold">GRAND-->
                                                            <!--                TOTAL</span>-->
                                                            <!--            <span class="fs-3 fw-bold"> : </span>-->
                                                            <!--            <span class="fs-3 fw-bold">-->
                                                            <!--                {{ $grandTotales }}-->
                                                            <!--            </span>-->
                                                            <!--        </td>-->
                                                            <!--    </tr>-->
                                                            <!--</table>-->
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>

                                            <footer>
                                                <!--<div
                                                    class="container-fluid p-4 border-top border-dark border-2">
                                                    <div class="row">
                                                        <div class="col-4 pt-3">
                                                            <h3 class="fs-4 fw-bold"><u>PAYMENT METHODS</u></h3>
                                                            <span class="fw-bold">Paypal :</span>
                                                            <span>info@bizzgrow@company.email.com</span><br>
                                                            <span class="fw-bold">Payment :</span>
                                                            <span>Visa Master card we accept cheque</span>
                                                        </div>
                                                        <div class="col-4">

                                                        </div>
                                                        <div class="col-4">
                                                            <u class="fs-3"><i>Mic Johnson</i></u>
                                                            <h3 class="fw-bold">Michale Johnson</h3>
                                                            <span>
                                                                Managing Director , Company Name INC.
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-5" style="color:rgb(116, 201, 50);">
                                                        <div class="col-4 text-center mt-4">
                                                            <h5 class="py-2 fw-bold">Customer's Signature</h5>
                                                        </div>
                                                        <div class="col-4">
                                                        </div>
                                                        <div class="col-4 text-center mt-4">
                                                            <h5 class="py-2 fw-bold">Manager's Signature</h5>
                                                        </div>
                                                    </div>
                                                </div>-->
                                            </footer>


                                        </div>

                                    </div>
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button id="download-btn"
                                                    class="btn btn-outline-success mt-5 mb-5"
                                                    style="float:right;">Download PDF</button>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        document.getElementById("download-btn").addEventListener("click", function() {
                                            var element = document.querySelector(".invoice-box");
                                            html2pdf(element, {
                                                margin: 10,
                                                filename: 'Vande Mileager Lubricant Pvt Ltd.pdf',
                                                image: {
                                                    type: 'jpeg',
                                                    quality: 0.98
                                                },
                                                html2canvas: {
                                                    scale: 2
                                                },
                                                jsPDF: {
                                                    unit: 'mm',
                                                    format: 'a4',
                                                    orientation: 'portrait'
                                                }
                                            });
                                        });
                                    </script>
                                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
                            </body>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

