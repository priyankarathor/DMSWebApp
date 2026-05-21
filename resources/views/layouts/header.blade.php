<?php
use App\Models\User;
use App\Models\manageaccounttable;
use App\Models\userroletab;
use App\Models\userhierarchytab;

$user = Auth::user();
$authen = [];
$userhierarchy = userhierarchytab::get();
$profiledata = manageaccounttable::get();
$getrole = userroletab::get();
if ($user->role == 2) {
    $authen = manageaccounttable::where('email', $user->email)->get();
} else {
    $authen = User::where('role', '!=', '2')->get();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Dealer Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('image/vmlogo.png') }}')}}" />

    <!-- App css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>



</head>

<body id="body" class="dark-sidebar">
    <!-- leftbar-tab-menu -->
    <!-- leftbar-tab-menu -->
    <div class="left-sidebar">
        <!-- LOGO -->
        <div class="brand">

            <a href="{{ url('/') }}" class="logo mt-4 mb-2"
                style="display:flex; align-items:center; justify-content:center; gap:0;">
                <span style="display:none;">
                    <img src="{{ asset('assets/images/dmsLogo.png') }}" alt="logo-small" class="logo-sm"
                        style="display:none;">
                </span>

                <span style="display:flex; align-items:center; justify-content:center;">
                    <img src="{{ asset('assets/images/dmsLogo.png') }}" alt="logo-large" class="logo-lg logo-light"
                        style="height:45px; width:auto; display:block; object-fit:contain;">

                    <img src="{{ asset('assets/images/dmsLogo.png') }}" alt="logo-dark" class="logo-lg logo-dark"
                        style="display:none;">
                </span>
            </a>
        </div>
        <!-- Tab panes -->

        <!--end logo-->
        <div class="menu-content h-100" data-simplebar>
            <div class="menu-body navbar-vertical">
                <div class="collapse navbar-collapse tab-content" id="sidebarCollapse">
                    <!-- Navigation -->
                    <ul class="navbar-nav tab-pane active" id="Main" role="tabpanel">
                        {{-- <li
                            style="background-color: #115e0f; color:#fff !important; border-radius:50px; padding:10px 5px !improtant; text-align:center;"
                            class="menu-label  text-primary font-12 ">M<span>ain</span><br><span
                                class="font-10 text-secondary fw-normal">Unique Dashboard</span></li> --}}

                        <li class="menu-label mt-0 text-primary font-12 fw-semibold mt-3">A<span>dmin</span></li>
                        @if ($user->role != 2)

                            <li class="nav-item mt-3">
                                <a class="nav-link" href="#sidebarProduct" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarProduct">
                                    <i class="fas fa-cubes menu-icon"></i>
                                    <span>Product</span>
                                </a>
                                <div class="collapse" id="sidebarProduct">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('productlist') }}">Product</a>
                                        </li><!--end nav-item-->
                                        <li class="nav-item">
                                            <a href="{{ route('orderlistadmin') }}" class="nav-link">Product Order List</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('approveorders') }}" class="nav-link">Approve Orders</a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ route('todaysell') }}" class="nav-link">Todays Sell</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('godown.inventory') }}" class="nav-link">Godown Inventory</a>
                                        </li>


                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item mt-3">
                                <a class="nav-link" href="#sidebarquotation" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarquotation">
                                    <i class="fas fa-clipboard menu-icon"></i>
                                    <span>Quotation</span>
                                </a>
                                <div class="collapse" id="sidebarquotation">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('quotationinvoicetable') }}">Quotation
                                                Table</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>




                            <li class="nav-item mt-3">
                                <a class="nav-link" href="#sidebarUser" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarUser">
                                    <i class="fas fa-user-circle menu-icon"></i>
                                    <span>User</span>
                                </a>
                                <div class="collapse" id="sidebarUser">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('distributorlist') }}" class="nav-link">Create Employee</a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ route('permissionlist') }}" class="nav-link">Permission Employee</a>
                                        </li>


                                        <!--<li class="nav-item">-->
                                        <!--    <a href="{{ route('role') }}" class="nav-link">User Role</a>-->
                                        <!--</li>-->
                                        <li class="nav-item">
                                            <a href="{{ route('userdiscount') }}" class="nav-link">User Discount</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('manageaccount') }}" class="nav-link">Manage Account</a>
                                        </li>


                                    </ul>
                                </div>
                            </li>

                            <!--<li class="nav-item mt-3">-->
                            <!--    <a class="nav-link" href="#sidebarInvoice" data-bs-toggle="collapse" role="button"-->
                            <!--       aria-expanded="false" aria-controls="sidebarInvoice">-->
                            <!--        <i class="far fa-clipboard menu-icon"></i>-->
                            <!--        <span>Invoice</span>-->
                            <!--    </a>-->
                            <!--    <div class="collapse" id="sidebarInvoice">-->
                            <!--        <ul class="nav flex-column">-->
                            <!--            <li class="nav-item">-->
                            <!--                <a href="{{ route('insertdataget') }}" class="nav-link">Invoice data</a>-->
                            <!--            </li>-->
                            <!--            <li class="nav-item">-->
                            <!--                <a href="{{ route('invoicedatatable') }}" class="nav-link">Invoice Table</a>-->
                            <!--            </li>-->
                            <!--        </ul>-->
                            <!--    </div>-->
                            <!--</li>-->

                            <li class="menu-label mt-0 text-primary font-12 fw-semibold mt-3">C<span>ategory</span></li>

                            <li class="nav-item">
                                <a class="nav-link" href="#sidebarCategory" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarCategory">
                                    <i class="fas fa-chart-pie menu-icon"></i>
                                    <span>Category</span>
                                </a>
                                <div class="collapse" id="sidebarCategory">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('categorydata') }}">Master Category</a>
                                        </li><!--end nav-item-->
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('subcategorydata') }}">Sub Category</a>
                                        </li><!--end nav-item-->
                                    </ul>
                                </div>

                            <li class="nav-item">
                                <a class="nav-link" href="#sidebarbrand" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarbrand">
                                    <i class="fas fa-tags menu-icon"></i>
                                    <span>Brand</span>
                                </a>

                                <div class="collapse" id="sidebarbrand">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('userbrand') }}">Brand List</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>


                            <li class="nav-item">
                                <a class="nav-link" href="#sidebarlocation" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarlocation">
                                    <i class="fas fa-tags menu-icon"></i>
                                    <span>Location</span>
                                </a>

                                <div class="collapse" id="sidebarlocation">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('userlocation') }}">Location List</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            </li>

                            <li class="menu-label mt-0 text-primary font-12 fw-semibold mt-3">S<span>tock list</span></li>
                            @foreach ($getrole as $roledata)

                                <li class="nav-item">
                                    <a class="nav-link" href="#distributter{{ $roledata->id }}" data-bs-toggle="collapse"
                                        role="button" aria-expanded="false" aria-controls="distributter{{ $roledata->id }}">

                                        <i class="far fa-calendar-check menu-icon"></i>
                                        <span>{{ $roledata->role }}</span>
                                    </a>
                                    <div class="collapse" id="distributter{{ $roledata->id }}">
                                        <ul class="nav flex-column">
                                            <li class="nav-item">
                                                @if(isset($roledata->id))
                                                    <a class="nav-link"
                                                        href="{{ url('/stockorderlist/' . $roledata->id) }}">{{ $roledata->role }}
                                                        Stock List</a>
                                                @else
                                                    <span class="nav-link">Role data not available</span>
                                                @endif
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            @endforeach
                        @endif




                        @foreach ($authen as $check)

                            @if ($check->email === $user->email)
                                @if($user->role == '2')



                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('productinventery') }}"><i
                                                class="fas fa-cubes menu-icon"></i><span>My product</span></a>
                                    </li>


                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('rolehierarchylist') }}"><i
                                                class="fas fa-cubes menu-icon"></i><span>Role Hierarchy</span></a>
                                    </li>


                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('userorder') }}"><i
                                                class="fas fa-list-alt menu-icon"></i><span>UserStock List</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('getuserorder')}}"><i
                                                class="fas fa-shopping-cart menu-icon"></i><span>Orders</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('history')}}"><i
                                                class="fas fa-tags menu-icon"></i><span>Sales</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('userproducthistory')}}"><i
                                                class="fas fa-cart-arrow-down menu-icon"></i><span>purchase</span></a>
                                    </li>

                                @endif
                            @endif
                        @endforeach


                    </ul>
                    <ul class="navbar-nav tab-pane" id="Extra" role="tabpanel">
                        <li>
                            <div class="update-msg text-center position-relative">
                                <button type="button" class="btn-close position-absolute end-0 me-2"
                                    aria-label="Close"></button>
                                <img src="{{ asset('assets/images/speaker-light.png') }}" alt="" class="" height="110">
                                <h5 class="mt-0">Mannat Themes</h5>
                                <p class="mb-3">We Design and Develop Clean and High Quality Web Applications</p>
                                <a href="javascript: void(0);" class="btn btn-outline-warning btn-sm">Upgrade your
                                    plan</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- end left-sidenav-->
    <!-- end leftbar-menu-->

    <!-- Top Bar Start -->
    <!-- Top Bar Start -->
    <div class="topbar">
        <!-- Navbar -->
        <nav class="navbar-custom" id="navbar-custom">
            <ul class="list-unstyled topbar-nav float-end mb-0">
                <li class="dropdown">
                    <a class="nav-link dropdown-toggle arrow-none nav-icon" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <img src="{{ asset('assets/images/flags/Flag_of_India.png') }}" alt=""
                            class="thumb-xxs rounded">
                    </a>

                </li><!--end topbar-language-->



                <li class="dropdown notification-list">
                    <!--<a class="nav-link dropdown-toggle arrow-none nav-icon" data-bs-toggle="dropdown" href="#"-->
                    <!--    role="button" aria-haspopup="false" aria-expanded="false">-->
                    <!--    <i class="ti ti-bell"></i>-->
                    <!--    <span class="alert-badge"></span>-->
                    <!--</a>-->
                    <div class="dropdown-menu dropdown-menu-end dropdown-lg pt-0">

                        <h6
                            class="dropdown-item-text font-15 m-0 py-3 border-bottom d-flex justify-content-between align-items-center">
                            Notifications <span class="badge bg-soft-primary badge-pill">2</span>
                        </h6>
                        <div class="notification-menu" data-simplebar>
                            <!-- item-->
                            <a href="#" class="dropdown-item py-3">
                                <small class="float-end text-muted ps-2">2 min ago</small>
                                <div class="media">
                                    <div class="avatar-md bg-soft-primary">
                                        <i class="ti ti-chart-arcs"></i>
                                    </div>
                                    <div class="media-body align-self-center ms-2 text-truncate">
                                        <h6 class="my-0 fw-normal text-dark">Your order is placed</h6>
                                        <small class="text-muted mb-0">Dummy text of the printing and industry.</small>
                                    </div><!--end media-body-->
                                </div><!--end media-->
                            </a><!--end-item-->
                            <!-- item-->
                            <a href="#" class="dropdown-item py-3">
                                <small class="float-end text-muted ps-2">10 min ago</small>
                                <div class="media">
                                    <div class="avatar-md bg-soft-primary">
                                        <i class="ti ti-device-computer-camera"></i>
                                    </div>
                                    <div class="media-body align-self-center ms-2 text-truncate">
                                        <h6 class="my-0 fw-normal text-dark">Meeting with designers</h6>
                                        <small class="text-muted mb-0">It is a long established fact that a
                                            reader.</small>
                                    </div><!--end media-body-->
                                </div><!--end media-->
                            </a><!--end-item-->
                            <!-- item-->
                            <a href="#" class="dropdown-item py-3">
                                <small class="float-end text-muted ps-2">40 min ago</small>
                                <div class="media">
                                    <div class="avatar-md bg-soft-primary">
                                        <i class="ti ti-diamond"></i>
                                    </div>
                                    <div class="media-body align-self-center ms-2 text-truncate">
                                        <h6 class="my-0 fw-normal text-dark">UX 3 Task complete.</h6>
                                        <small class="text-muted mb-0">Dummy text of the printing.</small>
                                    </div><!--end media-body-->
                                </div><!--end media-->
                            </a><!--end-item-->
                            <!-- item-->
                            <a href="#" class="dropdown-item py-3">
                                <small class="float-end text-muted ps-2">1 hr ago</small>
                                <div class="media">
                                    <div class="avatar-md bg-soft-primary">
                                        <i class="ti ti-drone"></i>
                                    </div>
                                    <div class="media-body align-self-center ms-2 text-truncate">
                                        <h6 class="my-0 fw-normal text-dark">Your order is placed</h6>
                                        <small class="text-muted mb-0">It is a long established fact that a
                                            reader.</small>
                                    </div><!--end media-body-->
                                </div><!--end media-->
                            </a><!--end-item-->
                            <!-- item-->
                            <a href="#" class="dropdown-item py-3">
                                <small class="float-end text-muted ps-2">2 hrs ago</small>
                                <div class="media">
                                    <div class="avatar-md bg-soft-primary">
                                        <i class="ti ti-users"></i>
                                    </div>
                                    <div class="media-body align-self-center ms-2 text-truncate">
                                        <h6 class="my-0 fw-normal text-dark">Payment Successfull</h6>
                                        <small class="text-muted mb-0">Dummy text of the printing.</small>
                                    </div><!--end media-body-->
                                </div><!--end media-->
                            </a><!--end-item-->
                        </div>
                        <!-- All-->
                        <a href="javascript:void(0);" class="dropdown-item text-center text-primary">
                            View all <i class="fi-arrow-right"></i>
                        </a>
                    </div>
                </li>


                @foreach ($authen as $check)


                    <li class="dropdown">
                        <a class="nav-link dropdown-toggle nav-user" data-bs-toggle="dropdown" href="#" role="button"
                            aria-haspopup="false" aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <!--<img src="{{asset('images/'.$check->file)}}" alt="profile-user"-->
                                <!--    class="rounded-circle me-2 thumb-sm" />-->
                                <div>

                                    <small class="d-none d-md-block font-11">{{$check->role}}</small>
                                    <span class="d-none d-md-block fw-semibold font-12">{{$check->name}} <i
                                            class="mdi mdi-chevron-down"></i></span>

                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            @if ($check->email === $user->email)
                                @if($user->role == '2')
                                    <a class="dropdown-item" href="{{url('/userprofiledata/' . $check->id)}}"><i
                                            class="ti ti-user font-16 me-1 align-text-bottom"></i> Profile</a>
                                @endif
                            @endif
                            <div class="dropdown-divider mb-0"></div>
                            <a class="dropdown-item" href="auth-login.html">
                                <!--<i class="ti ti-power font-16 me-1 align-text-bottom" class="btn btn-sm btn-danger underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ms-2"></i> Logout-->

                                @auth
                                    <!-- If the user is logged in -->
                                    <form method="POST" action="{{ route('logout') }}" class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-sm btn-danger underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ms-2">
                                            {{ __('Log Out') }}
                                        </button>
                                        {{-- {{$slot}} --}}
                                    </form>
                                @else
                                    <!-- If the user is not logged in -->
                                    <a href="{{ route('login') }}"
                                        class="btn btn-sm btn-success underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ms-2"
                                        style="color:#fff;">
                                        {{ __('Login') }}
                                    </a>
                                @endauth
                            </a>
                        </div>
                    </li><!--end topbar-profile-->

                @endforeach



                <!--<li class="notification-list">-->
                <!--    <a class="nav-link arrow-none nav-icon offcanvas-btn" href="#" data-bs-toggle="offcanvas"-->
                <!--        data-bs-target="#Appearance" role="button" aria-controls="Rightbar">-->
                <!--        <i class="ti ti-settings ti-spin"></i>-->
                <!--    </a>-->
                <!--</li>-->
            </ul><!--end topbar-nav-->

            <ul class="list-unstyled topbar-nav mb-0">
                <li>
                    <button class="nav-link button-menu-mobile nav-icon" id="togglemenu">
                        <i class="ti ti-menu-2"></i>
                    </button>
                </li>
                <!--    <li class="hide-phone app-search">-->
                <!--        <form role="search" action="#" method="get">-->
                <!--            <input type="search" name="search" class="form-control top-search mb-0"-->
                <!--                placeholder="Type text...">-->
                <!--            <button type="submit"><i class="ti ti-search"></i></button>-->
                <!--        </form>-->
                <!--    </li>-->
            </ul>
        </nav>
        <!-- end navbar-->
    </div>
    <!-- Top Bar End -->
    <!-- Top Bar End -->

    <div class="page-wrapper">

        <!-- Page Content-->
        <div class="page-content-tab">

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



            <main>
                {{ $slot }}
            </main>
            <!-- Footer Start -->
            {{-- <footer class="footer text-center text-sm-start">
                &copy;
                <script>
                    document.write(new Date().getFullYear())
                </script> Unikit <span class="text-muted d-none d-sm-inline-block float-end">Crafted
                    with <i class="mdi mdi-heart text-danger"></i> by Mannatthemes</span>
            </footer> --}}
            <!-- end Footer -->
            <!--end footer-->
        </div>
        <!-- end page content -->
    </div>
    <!-- end page-wrapper -->

    <!-- Javascript  -->

    <script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/pages/analytics-index.init.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

</body>
<!--end body-->

</html>