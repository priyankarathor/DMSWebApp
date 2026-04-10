<div>
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

    <div class="container">
        <div class="row">
            <form id="form-validation-2" class="form " action="{{route('subcategoryinsert')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="col-lg-12 ">
                    <h4 class="card-title mt-5 mb-3" style="color:green; font-size:30px;">Sub-Category Add</h4>

                    <div id="amount-rows">
                        <div class="row amount-row">
                            <div class="col-md-12">
                         <div class="card">
                        <div class="card-header">
                        </div><!--end card-header-->
                       
                        <div class="card-body">
                            <div class="row">
                                
                                <div class="mb-2 col-md-6" style="display:none;">
                                    <label for="username" class="mb-2">status</label>
                                    <input class="form-control" type="text" id="active" name="active" value="1">
                                </div>

                               <div class="mb-2 col-md-6">
                                <label for="type" class="mb-2">Master Category</label>
                                <select class="form-control" id="type" onchange="updateCategoryId()">
                                    <option value="" data-id="" style="text-align: center;">---- Select Master Category ---</option>
                                    @foreach ($tab as $item)
                                        <option value="{{ $item->value }}" data-id="{{ $item->id }}">{{ $item->value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6" style="display:none">
                                <input type="text" name="type" id="category-id" value="" readonly />
                            </div>

                                <div class="mb-2 col-md-6">
                                    <label for="username" class="mb-2">Sub Category</label>
                                    <input class="form-control" type="text" id="mastercategory" name="mastercategory">
                                </div>

                                <div class="mb-2 col-md-6">
                                    <label for="username" class="mb-2">Image</label>
                                    <input class="form-control" type="file" id="file" name="file">
                                </div>

                                <div class="col-md-6 mt-4">
                                    <input type="submit" style="font-size:18px;  border-radius:10px;" class="btn btn-outline-success" value="Submit" />
                                </div>
                            </div>
 
 
                        </div><!--end card-body-->
                            </div>
                            </div>
                            
                            
                            
                    </div>
                </div> 
                </div>
            </form><!--end form-->
        </div>
      </div>

    <div class="container mt-3">
        <div class="row">
        <div class="card">
            <div class="card-header">
                <div class="row mt-2">
                    <div class="col-md-8">
                    <span class="card-title">Sub category</span> &nbsp;&nbsp;
                          
                </div>
    
                    <div class="col-md-4">
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
              <table class="table mb-0"  id="myTable">
        <thead class="thead-light ">
        <tr>
        <th>Sr No.</th>
        <th>Image</th>
        <th>Master Category</th>
        <th>Category</th>
        <!--<th>Status</th>-->
        <th>Action</th>
        </tr>
        </thead>
        <tbody class="">
            @foreach ($categery as $item)
            <tr>
                <th scope="row">{{$item->id}}</th>
                <td><img src="{{ asset('images/'.$item->image) }}" style="width:50px; height:50px;"/></td>
                <td>
             @foreach($tab as $masterdata)
             
             @if($masterdata->id == $item->type)
               {{$masterdata->value}}
              @endif 
             
               @endforeach
              </td>
                <td>{{$item->value}}</td>
                <!--<td>-->
                <!--    <label class="switch" id="status{{ $item->id }}">-->
                <!--        <input type="checkbox" onchange="updateStatus({{ $item->id }})" {{ $item->	active ? 'checked' : '' }}>-->
                <!--        <span class="slider round"></span>-->
                <!--    </label>-->
                <!--</td>-->
               <td>
                <a href="{{url('/editsubmaster/'.$item->id)}}"  class="btn btn-outline-success">Edit</a>&nbsp;&nbsp;&nbsp;
                    <a href="{{ url('/subcategorydelete/delete/'.$item->id) }}" class="btn btn-outline-danger">Delete</a>

               </td>
                </tr>
            @endforeach
        </tbody>
        </table>
        </div>
        <div class="pagination-container mt-3">
            <button onclick="prevPage()" id="btn_prev"  class="btn btn-outline-success">Prev</button>
            &nbsp;&nbsp;&nbsp;<span id="page-info"></span>&nbsp;&nbsp;&nbsp;
            <button onclick="nextPage()" id="btn_next"  class="btn btn-outline-success">Next</button>
        </div>
        </div>
        </div>
        <script>
    function updateCategoryId() {
        const selectElement = document.getElementById('type');
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const categoryId = selectedOption.getAttribute('data-id'); // Get the ID from the data attribute
        document.getElementById('category-id').value = categoryId; // Set the value in the input
    }
</script>
        </div>
</div>
</div>