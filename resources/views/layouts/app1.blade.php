<!DOCTYPE html>
<html lang="en">
{{-- Include Head --}}
@include('common.head')

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
{{--            @include('common.sidebar')--}}
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <!-- Nav Item - Login -->
                    <li class="nav-item">
                        <a class="nav-link text-gray-900" href="{{ route('login') }}">Tizimga kirish</a>
                    </li>

                    <!-- Nav Item - User Information -->
{{--                    <li class="nav-item dropdown no-arrow">--}}
{{--                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"--}}
{{--                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                            <img class="img-profile rounded-circle"--}}
{{--                                 src="{{asset('admin/img/undraw_profile.svg')}}">--}}
{{--                        </a>--}}
{{--                        <!-- Dropdown - User Information -->--}}
{{--                    </li>--}}
                </ul>

            </nav>

            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            @yield('content')
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        @include('common.footer')
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>
<!-- Logout Modal-->
@include('common.logout-modal')

<!-- Bootstrap core JavaScript-->
<script src="{{asset('js/app.js')}}"></script>


<!-- Custom scripts for all pages-->
<script src="{{asset('admin/js/sb-admin-2.min.js')}}"></script>

@yield('scripts')
</body>

</html>
