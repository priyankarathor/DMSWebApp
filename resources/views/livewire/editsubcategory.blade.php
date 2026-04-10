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
            <form id="form-validation-2" class="form " action="{{url('/editsubcategorydata/'.$mastercate->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="col-lg-12 ">
                    <h4 class="card-title mt-5 mb-3" style="color:green; font-size:30px;">Category Edit</h4>

                    <div id="amount-rows">
                        <div class="row amount-row">
                            <div class="col-md-12">
                         <div class="card">
                        <div class="card-header">
                        </div><!--end card-header-->
                       
                        <div class="card-body">
                            <div class="row">
<div class="mb-2 col-md-6">
    <label for="masterType" class="mb-2">Subcategory Type</label>
    <select id="masterType" class="form-control">
        <option value="" disabled>Select Master Type</option>
        @foreach($tabs as $data)
        <option value="{{$data->id}}" 
                {{ $data->id == $mastercate->type ? 'selected' : '' }}>
            {{$data->value}}
        </option>
        @endforeach
    </select>
</div>
<div class="mb-2 col-md-6">
    <label for="masterId" class="mb-2">Master ID</label>
    <select id="masterId" class="form-control" name="type">
        <option value="" disabled>Select Master ID</option>
        @foreach($tabs as $data)
        @if($data->id == $mastercate->type)
        <option value="{{$data->id}}" 
                {{ $data->id == $mastercate->id ? 'selected' : '' }}>
            {{$data->id}}
        </option>
        @endif
        @endforeach
    </select>
</div>

                                
                                <div class="mb-2 col-md-6" style="display:none;">
                                    <label for="username" class="mb-2">status</label>
                                    <input class="form-control" type="text" id="active" name="active"  value="{{$mastercate->active}}">
                                </div>

                                <div class="mb-2 col-md-6">
                                    <label for="username" class="mb-2">Sub Category</label>
                                    <input class="form-control" type="text" id="mastercategory" name="value" value="{{$mastercate->value}}">
                                </div>

                                <div class="mb-2 col-md-6">
                                    <label for="username" class="mb-2">Sub Category Image</label>
                                    <input class="form-control" type="file" id="file" name="file" value="{{$mastercate->image}}">
                                </div>

                                <div class="col-md-12 mb-4 mt-3">
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
          <script>
    document.addEventListener("DOMContentLoaded", () => {
    const masterTypeSelect = document.getElementById("masterType");
    const masterIdSelect = document.getElementById("masterId");

    // Master data passed from the backend
    const masterData = @json($tabs);

    masterTypeSelect.addEventListener("change", () => {
        const selectedType = masterTypeSelect.value;

        // Clear previous options in Master ID
        masterIdSelect.innerHTML = `<option value="" disabled>Select Master ID</option>`;

        // Filter and populate Master ID options based on selected Master Type
        masterData.forEach((data) => {
            if (data.id == selectedType) {
                const option = document.createElement("option");
                option.value = data.id;
                option.textContent = data.id;
                // Pre-select if it matches the current Master ID
                if (data.id == "{{ $mastercate->id }}") {
                    option.selected = true;
                }
                masterIdSelect.appendChild(option);
            }
        });
    });

    // Trigger the change event to populate the second dropdown on page load
    masterTypeSelect.dispatchEvent(new Event("change"));
});

          </script>
    </div>
</div>