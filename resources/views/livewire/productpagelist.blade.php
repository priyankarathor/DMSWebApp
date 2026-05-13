<div>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

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
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #115e0f;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #115e0f;
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }

        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        .modal-body {
            width: 100%;
            max-width: 100%;
            max-height: 70vh;
            overflow-y: auto;
        }

        .modal-body p {
            word-wrap: break-word;
            word-break: break-all;
            overflow: hidden;
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
            box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
            z-index: 1;
            right: 0;
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

                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="card">

                    <div class="card-header">
                        <div class="row align-items-center">

                            <div class="col-md-8 col-12">
                                <span class="card-title mt-1">Product Details</span>

                                <!--<a href="{{ route('product') }}">-->
                                <!--    <button class="btn btn-outline-success mt-1" style="font-size:15px; border-radius:40px;">-->
                                <!--        Add Product +-->
                                <!--    </button>-->
                                <!--</a>-->

                                <a href="{{ route('product-import') }}">
                                    <button class="btn btn-outline-success mt-1" style="font-size:15px; border-radius:40px;">
                                        Add Product By CSV +
                                    </button>
                                </a>

                                <button wire:click="downloadCsv" class="btn btn-outline-success mt-1" style="font-size:15px; border-radius:40px;">
                                    CSV Download
                                </button>
                            </div>

                            <div class="col-md-4 mt-1">
                                <div class="row justify-content-end">
                                    <div class="d-flex align-items-center">
                                        <span class="form-label me-2">Search:</span>
                                        <input
                                            type="text"
                                            class="form-control"
                                            wire:model.live="search"
                                            placeholder="Search table data..."
                                        >
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row mt-3">
                            <div class="col-md-3 d-flex align-items-center">
                                <span class="me-2">Show:</span>
                                <select wire:model.live="perPage" class="form-control" style="width:100px;">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                     <option value="50">50</option>
                                      <option value="100">100</option>
                                </select>
                                <span class="ms-2">records</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table mb-0" id="myTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Product Name</th>
                                        <th>Product Category</th>
                                        <th>Brand</th>
                                        <th>MRP</th>
                                        <th>Details</th>
                                        <th>Status</th>
                                        <th>Access</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($product as $index => $products)
                                        <tr>
                                            <th scope="row">
                                                {{ ($product->currentPage() - 1) * $product->perPage() + $index + 1 }}
                                            </th>

                                            <td>{{ $products->productname }}</td>
                                            <td>{{ $products->category }}</td>
                                            <td>{{ $products->brand ?? 'N/A' }}</td>
                                            <td>{{ $products->mrp ?? 'N/A' }}</td>

                                            <td>
                                                <a href="{{ url('productDetails/' . $products->id) }}"
                                                   class="btn btn-outline-success rounded-circle">
                                                    <i class="bi bi-eye-fill"></i>
                                                </a>
                                            </td>

                                            <td>
                                                <label class="switch" id="statusid{{ $products->id }}">
                                                    <input
                                                        type="checkbox"
                                                        onchange="updateStatus({{ $products->id }})"
                                                        {{ $products->Action == 'Active' ? 'checked' : '' }}
                                                    >
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>

                                            <td>
                                                <div class="btn-group dropstart">
                                                    <button type="button"
                                                            class="btn btn-outline-success dropdown-toggle"
                                                            data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                        Action
                                                    </button>

                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ url('/productedit/' . $products->id) }}">
                                                                Edit
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <button
                                                                type="button"
                                                                class="dropdown-item"
                                                                onclick="confirm('Are you sure you want to delete this product?') || event.stopImmediatePropagation()"
                                                                wire:click="deleteproduct({{ $products->id }})">
                                                                Delete
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center text-danger">
                                                No product found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            {{ $product->links() }}
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function updateStatus(id) {
            let checkbox = document.querySelector('#statusid' + id + ' input[type="checkbox"]');
            let status = checkbox.checked ? 'Active' : 'Disable';

            fetch('{{ route("viewstatus") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    id: id,
                    Action: status
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                } else {
                    alert('Status updated to ' + data.status);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Something went wrong.');
            });
        }
    </script>
</div>