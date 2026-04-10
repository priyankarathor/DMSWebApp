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
            <form id="form-validation-2" class="form " action="{{url('/roledataedite/'.$roledata->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="col-lg-12 ">
                   

                    <div id="amount-rows">
                        <div class="row amount-row">
                            <div class="col-md-12">
                         <div class="card mt-3">
                        <div class="card-header">
                            <h4 class="card-title" style="color:green; font-size:20px;">Add User's Role</h4>
                        </div><!--end card-header-->
                       
                        <div class="card-body">
                            <div class="row">
                                
                                <div class="mb-2 col-md-10" >
                                    <label for="username" class="mb-2">Role</label>
                                    <input class="form-control" type="text" id="role" name="role" value="{{$roledata->role}}">
                                </div>
                                <div class="col-md-2 mb-4 mt-4">
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

</div>