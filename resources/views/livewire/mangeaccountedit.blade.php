<div class="container">
    <div class="row">
        <form id="form-validation-2" class="form" action="{{ url('/manageaccountedit/'.$editmanage->id) }}" method="post">
            @csrf
            <div class="row mt-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mt-1 mb-1" style="color:green; font-size:20px;">User Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Select Dependence Dropdown -->
                            <div class="mb-2 col-md-3">
                                <label for="dependence" class="mb-2">Select Dependence</label>
                                <select class="form-control" id="dependence" name="dependence">
                                    <option class="text-center" value="">----Select User ID----</option>
                                    @foreach ($usercategory as $item)
                                        <option value="{{ $item->id }}" data-roleid="{{ $item->role }}">
                                            {{ $item->role }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- User ID Dropdown -->
                            <div class="mb-2 col-md-3" id="distributorIdDiv">
                                <label for="assignid" class="mb-2">User ID</label>
                                <select class="form-control" id="assignid" name="assignid">
                                    <option class="text-center" value="">---- Select User ID ----</option>
                                    @foreach ($hierarchy as $item)
                                        <option value="{{ $item->id }}">{{ $item->registerid }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- User Details Display -->
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="id" class="mb-2">User Id</label>
                                    <input type="text" name="id" id="id" class="form-control" readonly value="{{$editmanage->ragisternum}}"/>
                                </div>

                                <div class="col-md-4">
                                    <label for="name" class="mb-2">User Name</label>
                                    <input type="text" name="name" id="name" class="form-control" readonly value="{{$editmanage->name}}"/>
                                </div>

                                <div class="col-md-4">
                                    <label for="role" class="mb-2">User Role</label>
                                    <input type="text" name="role" id="role" class="form-control" readonly value="{{$editmanage->role}}"/>
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="mb-2">User Email</label>
                                    <input type="text" name="email" id="email" class="form-control" value="{{$editmanage->email}}"/>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="exampleInputPassword1" class="form-label">Password</label>
                                    <input type="text" name="password" class="form-control" id="exampleInputPassword1" value="{{$editmanage->password}}">
                                </div>

                                {{-- <div class="col-md-4" style="display: none;">
                                    <label for="role" class="mb-2">User Role</label>
                                    <input type="text" name="userrole" id="userrole" class="form-control" value="2"  value="{{$editmanage->role}}"/>
                                </div> --}}
                            </div>

                            <!-- Checkboxes for roles -->
                            <div class="row">
                                @foreach ($usercategory as $item)
                                <div class="mb-3 form-check col-md-2">
                                    <input type="checkbox" name="regid[]" value="{{$item->id}}" class="form-check-input" id="distributerCheck_{{$item->id}}" 
                                        @if(in_array($item->id, explode(',', $editmanage->userregisterid))) checked @endif>
                                    <label class="form-check-label" for="distributerCheck_{{$item->id}}">{{$item->role}}</label>
                                </div>
                                @endforeach
                            </div>
                            

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
 
    </div>
</div>

<!-- JavaScript Logic -->
<script>
    document.getElementById('assignid').addEventListener('change', function () {
        // Get selected user id
        var selectedUserId = this.value;

        // Find the selected user's data from the hierarchy array
        var selectedUser = @json($hierarchy).find(user => user.id == selectedUserId);

        if (selectedUser) {
            // Fill the form fields with the selected user's data
            document.getElementById('id').value = selectedUser.id;
            document.getElementById('name').value = selectedUser.username;
            document.getElementById('role').value = selectedUser.role;
            document.getElementById('email').value = selectedUser.email;
        } else {
            // Clear the fields if no user is found
            document.getElementById('id').value = '';
            document.getElementById('name').value = '';
            document.getElementById('role').value = '';
            document.getElementById('email').value = '';
        }
    });
</script>