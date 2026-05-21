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

        input:checked+.slider {
            background-color: #115e0f;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #115e0f;
        }

        input:checked+.slider:before {
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
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
            right: 0;
            /* Align the dropdown content to the right */
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
            <form id="form-validation-2" class="form " action="{{route('userlocationdata')}}" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="col-lg-12 ">
                    <div id="amount-rows">
                        <div class="row amount-row">
                            <div class="col-md-12">
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h4 class="card-title" style="color:green; font-size:20px;">Add Location
                                        </h4>
                                    </div><!--end card-header-->

                                    <div class="card-body">
                                        <div class="row">

                                            <div class="mb-2 col-md-12">
                                                <label for="username" class="mb-2">Location Name</label>
                                                <input class="form-control" type="text" id="rate" name="location_name">
                                            </div>

                                            <div class="col-md-2 mb-4 mt-4">
                                                <input type="submit" style="font-size:18px;  border-radius:10px;"
                                                    class="btn btn-outline-success" value="Submit" />
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
                            <span class="card-title">Location List</span> &nbsp;&nbsp;
                        </div>

                        <div class="col-md-4">
                            <div class="row justify-content-end">
                                <div class=" d-flex align-items-center">
                                    <span for="search" class="form-label me-2">Search:</span>
                                    <input type="text" class="form-control" name="search" id="search"
                                        placeholder="Search table data...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0" id="myTable">
                            <thead class="thead-light ">
                                <tr>
                                    <th>#</th>
                                    <th>Location Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="" style="width: 100%;">
                                @foreach ($disocunt as $item)
                                    <tr>
                                        <th scope="row">{{$item->id}}</th>

                                        <td>{{$item->location_name}}</td>
                                        <td>
                                            <a href="{{url('/locationedit/' . $item->id)}}"><button
                                                    class="btn btn-outline-success">Edit</button>&nbsp;&nbsp;&nbsp;</a>
                                            <a href="{{url('/userlocationdelete/' . $item->id)}}"><button
                                                    class="btn btn-outline-danger">Delete</button></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination-container mt-3">
                        <button onclick="prevPage()" id="btn_prev" class="btn btn-outline-success">Prev</button>
                        &nbsp;&nbsp;&nbsp;<span id="page-info"></span>&nbsp;&nbsp;&nbsp;
                        <button onclick="nextPage()" id="btn_next" class="btn btn-outline-success">Next</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>