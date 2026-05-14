<div>
    <div class="container">

        @if (session()->has('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        <form wire:submit.prevent="updateUser" enctype="multipart/form-data">
            <div class="row mt-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mt-1 mb-1" style="color:green; font-size:20px;">
                            Edit User Details
                        </h4>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <div class="mb-2 col-md-3">
                                <label class="mb-2">Parent User ID</label>
                                <select class="form-control" wire:model="zonalId">
                                    <option value="">----Select User ID----</option>
                                    @foreach ($hierarchy as $data)
                                        <option value="{{ $data->id }}">
                                            {{ $data->registerid }} - {{ $data->username }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-2 col-md-3">
                                <label class="mb-2">Assign User ID</label>
                                <select class="form-control" wire:model="assignid">
                                    <option value="">----Select Assign User----</option>
                                    @foreach ($hierarchy as $data)
                                        <option value="{{ $data->id }}">
                                            {{ $data->registerid }} - {{ $data->username }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-2 col-md-3">
                                <label class="mb-2">User Name</label>
                                <span style="color:red;">*</span>
                                <input class="form-control" type="text" wire:model="username">
                                @error('username') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-2 col-md-3">
                                <label class="mb-2">Select Role</label>
                                <span style="color:red;">*</span>
                                <select class="form-control" wire:model="dependence">
                                    <option value="">----Select Role----</option>
                                    @foreach ($usercategory as $item)
                                        <option value="{{ $item->id }}">{{ $item->role }}</option>
                                    @endforeach
                                </select>
                                @error('dependence') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-2 col-md-3">
                                <label class="mb-2">Contact No.</label>
                                <span style="color:red;">*</span>
                                <input class="form-control" type="text" maxlength="10" wire:model="contactno">
                                @error('contactno') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-2 col-md-3">
                                <label class="mb-2">Alternative Number</label>
                                <input class="form-control" type="text" maxlength="10" wire:model="alternativenum">
                            </div>

                            <div class="mb-2 col-md-3">
                                <label class="mb-2">Email Address</label>
                                <span style="color:red;">*</span>
                                <input class="form-control" type="email" wire:model="email">
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-2 col-md-3">
                                <label class="mb-2">Upload Image</label>
                                <input class="form-control" type="file" wire:model="file">

                                @if ($file)
                                    <img src="{{ $file->temporaryUrl() }}"
                                         style="width:80px;height:80px;border-radius:8px;margin-top:8px;">
                                @elseif ($oldFile)
                                    <img src="{{ asset('image/' . $oldFile) }}"
                                         style="width:80px;height:80px;border-radius:8px;margin-top:8px;">
                                @endif

                                @error('file') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-2 col-md-3">
                                <label class="mb-2">Udyam Card</label>
                                <input class="form-control" type="text" wire:model="udyamcard">
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- Company Details --}}
            <div class="row mt-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mt-1 mb-1" style="color:green; font-size:20px;">
                            Company Details
                        </h4>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <div class="mb-2 col-md-6">
                                <label class="mb-2">Firm Name</label>
                                <input class="form-control" type="text" wire:model="companyname">
                            </div>

                            <div class="mb-2 col-md-6">
                                <label class="mb-2">Date</label>
                                <input class="form-control" type="date" wire:model="insertdate">
                            </div>

                            <div class="mb-2 col-md-4">
                                <label class="mb-2">GST Number</label>
                                <input class="form-control" type="text" wire:model="gstcode">
                            </div>

                            <div class="mb-2 col-md-4">
                                <label class="mb-2">PIN Code</label>
                                <input class="form-control" type="text" wire:model="pincode">
                            </div>

                            <div class="mb-2 col-md-4">
                                <label class="mb-2">City</label>
                                <span style="color:red;">*</span>
                                <input class="form-control" type="text" wire:model="city">
                                @error('city') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-2 col-md-4">
                                <label class="mb-2">State</label>
                                <span style="color:red;">*</span>
                                <input class="form-control" type="text" wire:model="state">
                                @error('state') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-2 col-md-4">
                                <label class="mb-2">Tehsils</label>
                                <input class="form-control" type="text" wire:model="tehsils">
                            </div>

                            <div class="mb-2 col-md-4">
                                <label class="mb-2">Region</label>
                                <span style="color:red;">*</span>
                                <input class="form-control" type="text" wire:model="region">
                                @error('region') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-2 col-md-4">
                                <label class="mb-2">Postal / Zip Code</label>
                                <input class="form-control" type="text" wire:model="postalcode">
                            </div>

                            <div class="mb-2 col-md-12">
                                <label class="mb-2">Address</label>
                                <span style="color:red;">*</span>
                                <textarea class="form-control" wire:model="address"></textarea>
                                @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- Bank Details --}}
            <div class="row mt-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mt-1 mb-1" style="color:green; font-size:20px;">
                            Bank Details
                        </h4>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <div class="mb-2 col-md-6">
                                <label class="mb-2">Bank Name</label>
                                <input class="form-control" type="text" wire:model="bankname">
                            </div>

                            <div class="mb-2 col-md-6">
                                <label class="mb-2">Bank Account Number</label>
                                <input class="form-control" type="text" wire:model="accountnumber">
                            </div>

                            <div class="mb-2 col-md-6">
                                <label class="mb-2">Account IFSC Code</label>
                                <input class="form-control" type="text" wire:model="ifsccode">
                            </div>

                            <div class="mb-2 col-md-3">
                                <label class="mb-2">Account Holder Name</label>
                                <input class="form-control" type="text" wire:model="holdername">
                            </div>

                            <div class="mb-2 col-md-3">
                                <label class="mb-2">Account Type</label>
                                <select class="form-control" wire:model="accounttype">
                                    <option value="">Select Account Type</option>
                                    <option value="Current">Current</option>
                                    <option value="Saving">Saving</option>
                                </select>
                            </div>

                            <div class="col-md-12 my-3">
                                <button type="submit"
                                        style="font-size:18px; border-radius:10px;"
                                        class="btn btn-success">
                                    Update User
                                </button>

                                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                                    Back
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>