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
                                $orderProductIds = explode(',', $orderproduct->pid);
                                $productBulkValues = explode(',', $orderproduct->productbulk);
                                $productquantity = explode(',', $orderproduct->qtymasurment);
                                $orderStatuses = explode(',', $orderproduct->orderstatus);
                            @endphp
                            
                            @foreach ($products as $item)
                                @if(in_array($item->id, $orderProductIds))
                                    @php
                                        // Find the index of the current product ID in the array
                                        $index = array_search($item->id, $orderProductIds);
                                        // Get the corresponding bulk value, quantity, and order status using the same index
                                        $bulkValue = $productBulkValues[$index] ?? 'N/A';
                                        $quantity = $productquantity[$index] ?? 'N/A';
                                        $orderStatus = $orderStatuses[$index] ?? 'Pending'; // Default to 'Pending' if not found
                                    @endphp
                                    <tr>
                                        <th scope="row">{{ $item->productname }}</th>
                                        <td>{{ $item->weightnum }}{{ $item->weihgtclass }}</td>
                                        <td>{{ $bulkValue }} {{ $quantity }}</td>
                                        <td>
                                            <select id="orderstatus" name="orderstatus[]" style="width: 100px; padding:5px; border-radius:10px;">
                                                <option value="Pending" style="color:#000 !important;" {{ $orderStatus == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="Approve" style="color:#000 !important;" {{ $orderStatus == 'Approve' ? 'selected' : '' }}>Approve</option>
                                                <option value="Cancel" style="color:#000 !important;" {{ $orderStatus == 'Cancel' ? 'selected' : '' }}>Cancel</option>
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
