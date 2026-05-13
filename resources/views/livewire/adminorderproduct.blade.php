<div>
    <div class="container mt-3">
        <div class="row">
            <form action="{{url('/orderstatus/'.$orderproduct->id)}}" method="post">

                @csrf
            <div class="card">
                <div class="card-header">
                    <div class="row mt-2">
                       
                        <div class="col-md-8">
                            <span class="card-title">Product List</span> &nbsp;&nbsp;

                            <button onclick="exportTableToExcel('myTable', 'InvoicesData')"
                                class="btn btn-outline-success" style="font-size:15px; border-radius:40px;">Excel</button>
                            <button onclick="downloadPDF()" class="btn btn-outline-success"
                                style="font-size:15px; border-radius:40px;">PDF</button>

                            {{-- <a href="#"> <button  class="btn btn-outline-success" style="font-size:15px; border-radius:40px;">All</button></a> --}}
                            <a > <button
                                    class="btn btn-outline-success"
                                    style="font-size:15px; border-radius:40px;">Approve</button></a>

                        </div>

                        <div class="col-md-4">
                            <div class="row justify-content-end">
                                <div class=" d-flex align-items-center">
                                    <span for="search" class="form-label me-2">Search:</span>
                                    <input type="text" class="form-control" name="search" id="search"
                                        placeholder="Search table data...">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0" id="myTable">
                            <thead class="thead-light">
                                <tr>
                                    {{-- <th>#</th> --}}
                                    <th>Product Name</th>
                                    <th>Product Quantity</th>
                                    <th>Product Bulk</th>
                                    <th>Product Status</th>
                                    {{-- <th>Access</th> --}}
                                </tr>
                            </thead>
                          <tbody>
@php
    $orderProductIds    = array_map('trim', explode(',', $orderproduct->pid));
    $productBulkValues  = array_map('trim', explode(',', $orderproduct->productbulk));
    $totalqtyvalue  = array_map('trim', explode(',', $orderproduct->totalqty));
    $qtyMeasurements    = array_map('trim', explode(',', $orderproduct->qtymasurment));
    $orderStatuses      = array_map('trim', explode(',', $orderproduct->orderstatus));
@endphp

@foreach ($orderProductIds as $index => $pid)
    @php
        $item = $products->where('id', (int)$pid)->first();
        
        $bulkValue   = $productBulkValues[$index] ?? 'N/A';
        $totalvalue = $totalqtyvalue[$index] ?? 'N/A';
        $quantity    = $qtyMeasurements[$index] ?? 'N/A';
        $orderStatus = $orderStatuses[$index] ?? 'Pending';
    @endphp

    @if($item)
        <tr>
            <th scope="row">{{ $item->productname }}</th>

            <td>{{ $bulkValue }}</td>

            <td> {{$totalvalue}} {{ $quantity }}</td>

            <td>
                <select name="orderstatus[]" style="width:100px; padding:5px; border-radius:10px;">
                    <option value="Pending" {{ strtolower($orderStatus) == 'pending' ? 'selected' : '' }}>
                        Pending
                    </option>
                    <option value="Approve" {{ strtolower($orderStatus) == 'approve' ? 'selected' : '' }}>
                        Approve
                    </option>
                    <option value="Cancel" {{ strtolower($orderStatus) == 'cancel' ? 'selected' : '' }}>
                        Cancel
                    </option>
                </select>
            </td>
        </tr>
    @endif
@endforeach
</tbody>
                            
                            
                        </table>
                        
                 
                        
                    </div>
                </div>
            </div>
            </form>
        </div>
          </div>
