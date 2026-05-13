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


<div>
    <div class="container mt-3">

        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h4 style="color:green; font-size:20px;">Add Discount</h4>
            </div>

            <div class="card-body">
                <form wire:submit.prevent="discount">
                    <div class="row">

                        <div class="mb-3 col-md-6">
                            <label class="mb-2">Discount Apply On</label>
                            <select class="form-control" wire:model.live="discount_type">
                                <option value="role">Whole Role</option>
                                <option value="user">Only One User</option>
                            </select>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="mb-2">Role</label>
                            <select class="form-control" wire:model.live="role_id">
                                <option value="">--------- Select Role ---------</option>
                                @foreach ($tab as $item)
                                    <option value="{{ $item->id }}">{{ $item->role }}</option>
                                @endforeach
                            </select>
                            @error('role_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        @if ($discount_type === 'user')
                            <div class="mb-3 col-md-6">
                                <label class="mb-2">State</label>
                                <select class="form-control" wire:model.live="state">
                                    <option value="">--------- Select State ---------</option>
                                    @foreach ($states as $item)
                                        <option value="{{ $item->state }}">{{ $item->state }}</option>
                                    @endforeach
                                </select>
                                @error('state') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="mb-2">User</label>
                                <select class="form-control" wire:model="user_id">
                                    <option value="">--------- Select User ---------</option>

                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">
                                            {{ $user->username }}
                                            -
                                            {{ $user->registerid }}
                                            -
                                            {{ $user->email }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        @endif

                        <div class="mb-3 col-md-6">
                            <label class="mb-2">Discount Rate (%)</label>
                            <input class="form-control" type="number" step="0.01" wire:model="rate">
                            @error('rate') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-2 mt-4">
                            <button type="submit" class="btn btn-outline-success">
                                Submit
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <span class="card-title">Discount List</span>
            </div>

            <div class="card-body">
                <div class="table-responsive">

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Discount Type</th>
                                <th>Role</th>
                                <th>State</th>
                                <th>Username</th>
                                <th>Register ID</th>
                                <th>Email</th>
                                <th>Discount</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($disocunt as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>

                                    <td>
                                        @if ($item->discount_type === 'role')
                                            Whole Role
                                        @else
                                            Single User
                                        @endif
                                    </td>

                                    <td>
                                        @php
                                            $roleName = $tab->where('id', $item->role)->first();
                                        @endphp

                                        {{ $roleName->role ?? 'N/A' }}
                                    </td>

                                    <td>{{ $item->state ?? '-' }}</td>
                                    <td>{{ $item->username ?? '-' }}</td>
                                    <td>{{ $item->registerid ?? '-' }}</td>
                                    <td>{{ $item->email ?? '-' }}</td>
                                    <td>{{ $item->rate }}%</td>

                                    <td>
                                        <button 
                                            wire:click="deletediscountdata({{ $item->id }})"
                                            onclick="return confirm('Are you sure?')"
                                            class="btn btn-outline-danger btn-sm">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">
                                        No discount data found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>

                </div>
            </div>
        </div>
    </div>
</div>


    <div class="container mt-3">
        <div class="row">
        <div class="card">
            <div class="card-header">
                <div class="row mt-2">
                    <div class="col-md-8">
                    <span class="card-title">User Role</span> &nbsp;&nbsp;          
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
            </div>
            
            <div class="card-body">
            <div class="table-responsive">
              <table class="table mb-0"  id="myTable">
        <thead class="thead-light ">
        <tr>
        <th>#</th>
        <th>Role</th>
        <th>Commission Rate</th>  
        <th>Action</th>
        </tr>
        </thead>
        <tbody class="" style="width: 100%;">
            @foreach ($disocunt as $item)
            <tr>
                <th scope="row">{{$item->id}}</th>
                @foreach ($tab as $roledata)
                @if($roledata->id == $item->role)
                <td>{{$roledata->role}}</td>
                @endif
                @endforeach
                <td>{{$item->rate}} %</td>
               <td>
                <a href="{{url('/userdiscountdata/'.$item->id)}}"><button class="btn btn-outline-success">Edit</button>&nbsp;&nbsp;&nbsp;</a>
                <a href="{{url('/discountdel/'.$item->id)}}"><button class="btn btn-outline-danger">Delete</button></a>
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
        </div>
</div>
</div>