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
                <span class="card-title mt-1">Product Details</span> &nbsp;&nbsp;
                <a href="{{route('product')}}"><button class="btn btn-outline-success mt-1" style="font-size:15px; border-radius:40px;">Add Product +</button></a>
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
        <th>Sr No.</th>
        <th>Product Name</th>
        <th>Product Category</th>
        {{-- <th>Product Price</th> --}}
        <th>Details</th>
        <th>Status</td>
        <th>Access</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($product as $index => $products)
                <tr>
                    <th scope="row">{{ $index + 1 }}</th> <!-- Display the row number -->
                    <td>{{ $products->productname }}</td>
                    <td>{{ $products->category }}</td>
                    {{-- <td>{{ $products->productprice }}</td> --}}
                    <td>
                      <!-- Button trigger modal -->
                      <a href="{{ url('productDetails/'.$products->id) }}" 
   class="btn btn-outline-success rounded-circle">
    <i class="bi bi-eye-fill"></i>
</a>
                    
                    </td>
                    <td>
                      <label class="switch" id="statusid{{$products->id}}">
                          <input type="checkbox" onchange="updateStatus({{$products->id}})" {{$products->Action ? 'checked' : ''}}>
                          <span class="slider round"></span>
                      </label>
                  </td>
                  
                    <td>
                        {{-- <span class="badge badge-boxed badge-outline-success">Business</span> --}}
                        <div class="btn-group dropstart">
                            <button type="button" class="btn btn-outline-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                              Action
                            </button>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item" href="{{url('/productedit/'.$products->id)}}">Edit</a></li>
                              <li><a class="dropdown-item" href="{{url('/delproduct/'.$products->id)}}">Delete</a></li>
                            </ul>
                          </div>
                    </td>

                   <div class="modal fade" id="exampleModal{{ $products->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content shadow-lg rounded-4">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="exampleModalLabel">Product Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="text-center mb-3">
                    <img src="{{ asset('image/' . $products->file) }}" alt="Product Image" class="img-fluid rounded shadow-sm" style="max-height: 300px;">
                </div>

                <div class="mb-3">
                    <h6 class="fw-semibold text-secondary">Description:</h6>
                    <div>{!! $products->description !!}</div>
                </div>

                <div class="row g-3 mb-3">
                    @foreach($productprice as $price)
                        @if($products->id == $price->pid)
                            <div class="col-md-4">
                                <div class="border p-2 rounded">
                                    <strong>Price Per Pcs:</strong><br> ₹{{$price->price}}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border p-2 rounded">
                                    <strong>Measurement Per Pcs:</strong><br> {{$price->Measurement}}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border p-2 rounded">
                                    <strong>Total Price:</strong><br> ₹{{$price->totalprice}}
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <div class="border p-2 rounded">
                            <strong>Total PCS:</strong><br> {{$products->quantity}}
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <div class="border p-2 rounded">
                            <strong>Box Quantity:</strong><br> {{$products->boxquantity}}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="border p-2 rounded">
                            <strong>Vehicle:</strong><br> {{$products->vehicle}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

                  
                </tr>
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