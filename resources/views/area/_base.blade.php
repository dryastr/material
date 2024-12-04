<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/prism/prism.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/select2/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/bundles/jquery-selectric/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel='shortcut icon' type='image/x-icon' href='{{ asset('files/img/namikulo.png') }}' />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('head')
</head>

<body>
    <div class="loader"></div>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar sticky">
                <div class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg collapse-btn"> <i data-feather="align-justify"></i></a>
                        </li>
                    </ul>
                </div>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user"> <img alt="image" src="{{ asset('files/img/user.png') }}" class="user-img-radious-style"> <span class="d-sm-none d-lg-inline-block"></span></a>
                        <div class="dropdown-menu dropdown-menu-right pullDown">
                            <div class="dropdown-title">Hello {{ Auth::user()->nama }}</div>
                            <a href="{{ url('profil') }}" class="dropdown-item has-icon"> <i class="far fa-user"></i> Profile
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="{{ url('logout') }}" class="dropdown-item has-icon text-danger"> <i class="fas fa-sign-out-alt"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="{{ url('dashboard') }}"> <img alt="image" src="{{ asset('files/img/namikulo.png') }}" class="header-logo" /> <span class="logo-name">PT Ciba Vision</span>
                        </a>
                    </div>
                    <ul class="sidebar-menu mt-4">
                        <li class="@if ($page == 'dashboard') active @endif">
                            <a href="{{ url('dashboard') }}" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
                        </li>
                        @if (Auth::user()->role == 'Admin')
                            <li class="@if ($page == 'user') active @endif">
                                <a href="{{ url('user') }}" class="nav-link"><i data-feather="user"></i><span>Kelola User</span></a>
                            </li>
                            <li class="@if ($page == 'barang') active @endif">
                                <a href="{{ url('barang') }}" class="nav-link"><i data-feather="briefcase"></i><span>Master Barang</span></a>
                            </li>
                        @endif

                        @if (Auth::user()->role == 'Staff')
                            <li class="@if ($page == 'permintaan') active @endif">
                                <a href="{{ url('permintaan') }}" class="nav-link"><i data-feather="file"></i><span>Permintaan Pesanan</span></a>
                            </li>
                        @else
                            <li class="@if ($page == 'pesanan') active @endif">
                                <a href="{{ url('pesanan') }}" class="nav-link"><i data-feather="calendar"></i><span>Pesanan Masuk</span></a>
                            </li>
                        @endif
                        <li class="@if ($page == 'riwayat') active @endif">
                            <a href="{{ url('riwayat') }}" class="nav-link"><i data-feather="command"></i><span>Riwayat Pesanan</span></a>
                        </li>


                    </ul>
                </aside>
            </div>
            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-body">
                        @yield('content')
                    </div>
                </section>
                @yield('modal')
                <div class="settingSidebar">
                    <a href="javascript:void(0)" class="settingPanelToggle"> <i class="fa fa-spin fa-cog"></i>
                    </a>
                    <div class="settingSidebar-body ps-container ps-theme-default">
                        <div class=" fade show active">
                            <div class="setting-panel-header">Setting Panel
                            </div>
                            <div class="p-15 border-bottom">
                                <h6 class="font-medium m-b-10">Select Layout</h6>
                                <div class="selectgroup layout-color w-50">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="value" value="1" class="selectgroup-input-radio select-layout" checked>
                                        <span class="selectgroup-button">Light</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="value" value="2" class="selectgroup-input-radio select-layout">
                                        <span class="selectgroup-button">Dark</span>
                                    </label>
                                </div>
                            </div>
                            <div class="p-15 border-bottom">
                                <h6 class="font-medium m-b-10">Sidebar Color</h6>
                                <div class="selectgroup selectgroup-pills sidebar-color">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="icon-input" value="1" class="selectgroup-input select-sidebar">
                                        <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip" data-original-title="Light Sidebar"><i class="fas fa-sun"></i></span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="icon-input" value="2" class="selectgroup-input select-sidebar" checked>
                                        <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip" data-original-title="Dark Sidebar"><i class="fas fa-moon"></i></span>
                                    </label>
                                </div>
                            </div>
                            <div class="p-15 border-bottom">
                                <h6 class="font-medium m-b-10">Color Theme</h6>
                                <div class="theme-setting-options">
                                    <ul class="choose-theme list-unstyled mb-0">
                                        <li title="white" class="active">
                                            <div class="white"></div>
                                        </li>
                                        <li title="cyan">
                                            <div class="cyan"></div>
                                        </li>
                                        <li title="black">
                                            <div class="black"></div>
                                        </li>
                                        <li title="purple">
                                            <div class="purple"></div>
                                        </li>
                                        <li title="orange">
                                            <div class="orange"></div>
                                        </li>
                                        <li title="green">
                                            <div class="green"></div>
                                        </li>
                                        <li title="red">
                                            <div class="red"></div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="p-15 border-bottom">
                                <div class="theme-setting-options">
                                    <label class="m-b-0">
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" id="mini_sidebar_setting">
                                        <span class="custom-switch-indicator"></span>
                                        <span class="control-label p-l-10">Mini Sidebar</span>
                                    </label>
                                </div>
                            </div>
                            <div class="p-15 border-bottom">
                                <div class="theme-setting-options">
                                    <label class="m-b-0">
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" id="sticky_header_setting">
                                        <span class="custom-switch-indicator"></span>
                                        <span class="control-label p-l-10">Sticky Header</span>
                                    </label>
                                </div>
                            </div>
                            <div class="mt-4 mb-4 p-3 align-center rt-sidebar-last-ele">
                                <a href="#" class="btn btn-icon icon-left btn-primary btn-restore-theme">
                                    <i class="fas fa-undo"></i> Restore Default
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="main-footer">
                <div class="footer-left m-0">
                    <p class="m-0">Copyrights © 2024 All Rights Reserved </p>
                </div>
                <div class="footer-right">
                    <p class="m-0">Task Management</p>
                </div>
            </footer>
        </div>
    </div>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/prism/prism.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/alert/package/dist/sweetalert2.all.js') }} "></script>
    <script>
        var datatable = $("#table-1").DataTable({

        });

        function errorAjaxResponse(response) {
            if (response.status == 500) {
                swal.fire({
                    icon: "error",
                    title: 'Gagal !',
                    text: 'Terjadi kesalahan !',
                    showConfirmButton: true,
                    timer: 1000
                });
            } else if (response.status == 401) {
                swal.fire({
                    icon: "error",
                    title: 'Gagal !',
                    text: 'Anda harus login kembali',
                    showConfirmButton: true,
                    timer: 1000
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '{{ url('/') }}';
                    }
                });
            } else if (response.status == 419) {
                swal.fire({
                    icon: "error",
                    title: 'Gagal !',
                    text: 'Halaman kadaluarsa, silahkan reload halaman!',
                    showConfirmButton: true,
                    timer: 1000
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
            } else {
                swal.fire({
                    icon: "error",
                    title: 'Gagal !',
                    text: 'Sepertinya ada yang tidak beres...',
                    showConfirmButton: true,
                    timer: 1000
                });
            }
        }

        function idrFormat(angka, format = false) {
            var numberString = angka.toString();
            var sisa = numberString.length % 3;
            var rupiah = numberString.substr(0, sisa);
            var ribuan = numberString.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
                var separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            if (format == true) {
                rupiah = 'Rp. ' + rupiah;
            }

            return rupiah;
        }

        function formatNumber(input) {
            let value = input.value.replace(/\./g, '');
            value = value.replace(/\D/g, '');
            value = new Intl.NumberFormat('en-US').format(value);
            input.value = value;
        }
    </script>
    @stack('js')
</body>

</html>
