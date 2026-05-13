<div class="container">
    <div class="row">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form wire:submit.prevent="managedatalist" class="form">
            <div class="row mt-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mt-1 mb-1" style="color:green; font-size:20px;">
                            User Details
                        </h4>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <div class="mb-2 col-md-3">
                                <label for="dependence" class="mb-2">Select Dependence</label>
                                <select class="form-control" id="dependence" wire:model.live="selectedDependence">
                                    <option value="">----Select Dependence----</option>
                                    @foreach ($usercategory as $item)
                                        <option value="{{ $item->id }}">{{ $item->role }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-2 col-md-3">
                                <label for="assignid" class="mb-2">User ID</label>
                                <select class="form-control" id="assignid" wire:model.live="selectedAssignId">
                                    <option value="">----Select User ID----</option>
                                    @foreach ($hierarchy as $data)
                                        <option value="{{ $data->id }}">
                                            {{ $data->registerid }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-2 col-md-3">
                                <label for="username" class="mb-2">Dependence Username</label>
                                <input type="text" id="username" class="form-control" value="{{ $usernameDisplay }}" readonly>
                            </div>

                            <div class="mb-2 col-md-3">
                                <label for="region" class="mb-2">Dependence Region</label>
                                <input type="text" id="region" class="form-control" value="{{ $regionDisplay }}" readonly>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label for="id" class="mb-2">User Id</label>
                                    <input type="text" wire:model="id" name="id" id="id" class="form-control" readonly />
                                </div>

                                <div class="col-md-4">
                                    <label for="name" class="mb-2">User Name</label>
                                    <input type="text" wire:model="name" name="name" id="name" class="form-control" readonly />
                                </div>

                                <div class="col-md-4">
                                    <label for="role" class="mb-2">User Role</label>
                                    <input type="text" wire:model="role" name="role" id="role" class="form-control" readonly />
                                </div>

                                <div class="col-md-4">
                                    <label for="roleid" class="mb-2">User Role Id</label>
                                    <input type="text" wire:model="roleid" name="roleid" id="roleid" class="form-control" readonly />
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="mb-2">User Email</label>
                                    <input type="email" wire:model="email" name="email" id="email" class="form-control" required />
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" wire:model="password" name="password" id="password" class="form-control" required />

                                    @if($email && $password && $email === $password)
                                        <div class="text-danger mt-1">
                                            ❌ Password cannot be the same as Email
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-4" style="display: none;">
                                    <label for="userrole" class="mb-2">User</label>
                                    <input type="text" wire:model="userrole" name="userrole" id="userrole" class="form-control" value="2" readonly />
                                </div>
                            </div>

                            <div class="row mt-3">
                                @foreach ($usercategory as $item)
                                    <div class="mb-3 form-check col-md-2">
                                        <input type="checkbox"
                                               wire:model="regid"
                                               value="{{ $item->id }}"
                                               class="form-check-input"
                                               id="distributerCheck{{ $item->id }}">
                                        <label class="form-check-label" for="distributerCheck{{ $item->id }}">
                                            {{ $item->role }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>