<div>
    <script src="{{asset('assets/js/custom.js')}}"></script>
  <style>
          .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            margin-left: 0px;
            height: 27px;
          }
          
          .switch input { 
            opacity: 0;
            width: 0;
            height: 0;
          }
          
          .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
          }
          
          .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
          }
          
          input:checked + .slider {
            background-color: #115e0f;
          }
          
          input:focus + .slider {
            box-shadow: 0 0 1px #115e0f;
          }
          
          input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
          }
          
          /* Rounded sliders */
          .slider.round {
            border-radius: 34px;
          }
          
          .slider.round:before {
            border-radius: 50%;
          }
      
            .modal-body {
              width: 100%;
              max-width: 100%;
              overflow: hidden;
            }
          
            .modal-body p {
              word-wrap: break-word;
              word-break: break-all;
              overflow: hidden;
            }
          
          .modal-body {
          max-height: 70vh; 
          overflow-y: auto; 
          }
      
          .section p {
              word-wrap: break-word; 
              white-space: normal; 
          }
          .dropbtn {
                background-color: #fff;
                color: #000;
                padding: 16px;
                font-size: 16px;
                border: none;
                cursor: pointer;
              }
              .dropdown-content {
                display: none;
                position: absolute;
                background-color: #f9f9f9;
                min-width: 100px;
                box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
                z-index: 1;
                right: 0; /* Align the dropdown content to the right */
              }
              
              .dropdown-content a {
                color: black;
                padding: 12px 16px;
                text-decoration: none;
                display: block;
              }
              
              .dropdown-content a:hover {
                background-color: #f1f1f1;
              }
              
              .dropdown:hover .dropdown-content {
                display: block;
              }
              
              .dropdown:hover .dropbtn {
                background-color: #23650a;
              }
          </style>
      <div class="container mt-4">
          <div class="row">
              <div class="col-md-12">
      <div class="card">
         
          <div class="card-header">
              <div class="row ">
                  <div class="col-md-8 col-12" >
                  <span class="card-title mt-1">Purchase History Details</span> &nbsp;&nbsp;
                  
                  <button onclick="exportTableToExcel('myTable', 'InvoicesData')" class="btn btn-outline-success mt-1" style="font-size:15px; border-radius:40px;">Excel</button>
                    <button onclick="downloadPDF()" class="btn btn-outline-success mt-1" style="font-size:15px; border-radius:40px;">PDF</button>
                 
                   <a href="{{route('allproductlist')}}"> <button  class="btn btn-outline-success mt-1" style="font-size:15px; border-radius:40px;">All</button></a>
                  </div>
  
                  <div class="col-md-4 mt-1">
                    <div class="row justify-content-end">
                          <div class=" d-flex align-items-center">
                              <span for="search" class="form-label me-2">Search:</span>
                              <input type="text" class="form-control" name="search" id="search" placeholder="Search table data...">
                          
                      </div>
                  </div>
                  </div>
              </div>
          </div><!--end card-header-->
          
          <div class="card-body">
          <div class="table-responsive">
            <table class="table mb-0"  id="myTable" >
          <thead class="thead-light">
          <tr>
          <th>Product Name</th>
          <th>Batch </th>
          <th>Product Quantity</th>
          <th>Product Bulk</th>
          <th>Product Amount</th>
          <th>Total Amount</td>
          <th>Access</th>
          </tr>
          </thead>
          <tbody>
            @foreach ($order as $products)
           @if($manage && $products->userid == $manage->ragisternum)
                @php
                    // Split comma-separated values into arrays
                    $productNames = explode(',', $products->productname);
                    $productquantity = explode(',', $products->productquantity);
                    $productbulk = explode(',', $products->productbulk);
                    $amount = explode(',', $products->amount);
                    $totalamount = explode(',', $products->totalamount);
                    $batchid = explode(',', $products->	batchid);
                @endphp
        
                @foreach($productNames as $index => $productName)
                    <tr>
                        <td>{{ $productName }}</td>
                        @foreach($batchtable as $batch)
                        @if($batch->id == $batchid[$index] )
                        <td>{{ $batch->batchno ?? '0' }}</td>
                        @endif
                        @endforeach
                        <td>{{ $productquantity[$index] ?? '' }}</td>
                        <td>{{ $productbulk[$index] ?? '' }}</td>
                        <td>{{ $totalamount[$index] ?? '' }}</td>
                        <td>{{ $amount[$index] ?? '' }}</td>

                        
                        <td>
                            <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $products->id . $index }}">
                                <i class="bi bi-eye-fill"></i>
                            </button>
                        </td>
        
        
                        <div class="modal fade" id="exampleModal{{ $products->id . $index }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">Product Details</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                      <div class="table-responsive">
                                          <!-- Vertical Table Layout -->
                                          <div class="border p-2 mb-2">
                                              <strong>HSN No:</strong> <span>{{ $products->hsnno }}</span>
                                          </div>
                                          <div class="border p-2 mb-2">
                                              <strong>Driver Company:</strong> <span>{{ $products->drivercompany }}</span>
                                          </div>
                                          <div class="border p-2 mb-2">
                                              <strong>Driver Name:</strong> <span>{{ $products->drivername }}</span>
                                          </div>
                                          <div class="border p-2 mb-2">
                                              <strong>Vehicle No:</strong> <span>{{ $products->vehicleno }}</span>
                                          </div>
                                          <div class="border p-2 mb-2">
                                              <strong>Driver Contact:</strong> <span>{{ $products->drivercontact }}</span>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                      <button type="button" class="btn btn-success">Save changes</button>
                                  </div>
                              </div>
                          </div>
                      </div>
                      
                      
                    </tr>
                @endforeach
            @endif
        @endforeach
        
          </tbody>        
            <!-- Modal -->
           
      
          </table><!--end /table-->
          </div><!--end /tableresponsive-->
          <div class="pagination-container mt-3">
            <button onclick="prevPage()" id="btn_prev"  class="btn btn-outline-success">Prev</button>
            &nbsp;&nbsp;&nbsp;<span id="page-info"></span>&nbsp;&nbsp;&nbsp;
            <button onclick="nextPage()" id="btn_next"  class="btn btn-outline-success">Next</button>
        </div>
          </div><!--end card-body-->
          </div>
      
      </div>
          </div>
      </div>
      <script>
        // JavaScript function to handle status updates
        function updateStatus(id) {
      // Find the checkbox using the product ID
      var checkbox = document.querySelector('#statusid' + id + ' input[type="checkbox"]');
      
      // Set status to 'Active' or 'Disable' based on the checkbox state
      var status = checkbox.checked ? 'Active' : 'Disable';
  
      // Send the updated status to the server using Fetch API
      fetch('{{ route("viewstatus") }}', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ensure CSRF token is sent
          },
          body: JSON.stringify({ id: id, Action: status }) // Use 'Action' to match with the controller
      })
      .then(response => response.json()) // Parse the JSON response
      .then(data => {
          if (data.error) {
              alert(data.error); // Show error message if there's an issue
          } else {
              alert('Status updated to ' + data.status); // Success message with the new status
          }
      })
      .catch(error => console.error('Error:', error)); // Log any errors in the console
  }
  
    </script>  
    
  </div> 