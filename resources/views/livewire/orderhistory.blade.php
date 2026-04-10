<div>
    <script src="{{asset('assets/js/custom.js')}}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
                  <span class="card-title mt-1">Sales History Details</span> &nbsp;&nbsp;
                  
                    <button onclick="exportTableToExcel('myTable', 'InvoicesData')" class="btn btn-outline-success mt-1" style="font-size:15px; border-radius:40px;">Excel</button>
                    <button onclick="downloadPDF()" class="btn btn-outline-success mt-1" style="font-size:15px; border-radius:40px;">PDF</button>
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
          {{-- <th>#</th> --}}
          <th>Username</th>
          <th>Contact No.</th>
          <th>Product Name</th>
          <th>Product Quantity</th>
          <!--<th>Amount</th>-->
          <th>Bulk</th>
          <th>Total Amount</th>
          <th>Date/Time</th>
          <th>Details</th>
          <th>Access</th>
          </tr>
          </thead>
          <tbody>
            @foreach ($tab as $products)
            @foreach($users as $use)
                @if(optional($use)->ragisternum == $products->approveuserid)
                    @php
                        // Split comma-separated values
                        $productNames = explode(',', $products->productname);
                        $productQuantities = explode(',', $products->productquantity);
                        $totalAmounts = explode(',', $products->totalamount);
                        $productBulks = explode(',', $products->productbulk);
                        $amounts = explode(',', $products->amount);
                        $rowCount = max(count($productNames), count($productQuantities), count($totalAmounts), count($productBulks), count($amounts));
                    @endphp
        
                    @for($i = 0; $i < $rowCount; $i++)
                        <tr>
                            <td>{{ $products->username }}</td>
                            <td>{{ $products->contactno }}</td>
                            <td>{{ $productNames[$i] ?? '' }}</td>
                            <td>{{ $productQuantities[$i] ?? '' }}</td>
                            <!--<td>{{ $totalAmounts[$i] ?? '' }}</td>-->
                            <td>{{ $productBulks[$i] ?? '' }}</td>
                            <td>{{ $amounts[$i] ?? '' }}</td>
                            <td>{{ $products->created_at }}</td>
                            <td>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal{{$products->id}}">
                                    <i class="bi bi-bookmark-star"></i>
                                </button>
                            </td>
                            <td>
                                <div class="btn-group dropstart">
                                    <button type="button" class="btn btn-outline-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        Action
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ url('/productedit/'.$products->id) }}">Edit</a></li>
                                        <li><a class="dropdown-item" href="{{ url('/delproduct/'.$products->id) }}">Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endfor
              
        
            <!-- Modal -->
<div class="modal fade" id="exampleModal{{$products->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-6 fw-bold border-bottom py-2">Invoice No</div>
            <div class="col-6 border-bottom py-2">{{ $products->invoiceno }}</div>
            
            <div class="col-6 fw-bold border-bottom py-2">Invoice Date</div>
            <div class="col-6 border-bottom py-2">{{ $products->invoicedate }}</div>
            
            <div class="col-6 fw-bold border-bottom py-2">Farm Name</div>
            <div class="col-6 border-bottom py-2">{{ $products->framname }}</div>
            
            <div class="col-6 fw-bold border-bottom py-2">GST Number</div>
            <div class="col-6 border-bottom py-2">{{ $products->gstnumber }}</div>
            
            <div class="col-6 fw-bold border-bottom py-2">Email</div>
            <div class="col-6 border-bottom py-2">{{ $products->email }}</div>
            
            <div class="col-6 fw-bold border-bottom py-2">Region</div>
            <div class="col-6 border-bottom py-2">{{ $products->region }}</div>
            
            <div class="col-6 fw-bold border-bottom py-2">Address</div>
            <div class="col-6 border-bottom py-2">{{ $products->address }}</div>
            
            <div class="col-6 fw-bold border-bottom py-2">Driver Name</div>
            <div class="col-6 border-bottom py-2">{{ $products->drivername }}</div>
            
            <div class="col-6 fw-bold border-bottom py-2">Driver Company</div>
            <div class="col-6 border-bottom py-2">{{ $products->drivercompany }}</div>
            
            <div class="col-6 fw-bold border-bottom py-2">Vehicle No</div>
            <div class="col-6 border-bottom py-2">{{ $products->vehicleno }}</div>
            
            <div class="col-6 fw-bold py-2">Driver Contact</div>
            <div class="col-6 py-2">{{ $products->drivercontact }}</div>
        </div>
    </div>
</div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <!--<button type="button" class="btn btn-primary">Save changes</button>-->
        </div>
      </div>
    </div>
  </div>
        @endif
    @endforeach
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
      var checkbox = document.querySelector('#statusid' + id + ' input[type="checkbox"]');
      
      var status = checkbox.checked ? 'Active' : 'Disable';
  
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