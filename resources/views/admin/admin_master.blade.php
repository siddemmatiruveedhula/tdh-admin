<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Tenali Double Horse</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/cresol-favicon.svg') }}">

    <!-- Select 2 -->
    <link href="{{ asset('backend/assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
    <!-- end Select 2  -->


    <!-- jquery.vectormap css -->
    <link href="{{ asset('backend/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- DataTables -->
    <link href="{{ asset('backend/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('backend/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('backend/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet"> -->
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>

    <!-- Datatables export button CSS -->
    <link href='https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css' rel='stylesheet'
        type='text/css'>
    <link href="{{ asset('backend/assets/libs/jquery/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/libs/multi-select/multi.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/filter_multi_select.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('backend/assets/filter-multi-select-bundle.min.js') }}"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css" />

</head>

<body data-topbar="dark">

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

    <!-- Begin page -->
    <div id="layout-wrapper">


        @include('admin.body.header')

        <!-- ========== Left Sidebar Start ========== -->
        @include('admin.body.sidebar')
        <!-- Left Sidebar End -->



        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            @yield('admin')
            <!-- End Page-content -->

            @include('admin.body.footer')


        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->

    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> --}}
    <script src="{{ asset('backend/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/jquery/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/multi-select/multi.min.js') }}"></script>


    <!-- apexcharts -->
    {{-- <script src="{{ asset('backend/assets/libs/apexcharts/apexcharts.min.js') }}"></script> --}}

    <!-- jquery.vectormap map -->
    <script src="{{ asset('backend/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}">
    </script>
    <script src="{{ asset('backend/assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js') }}">
    </script>

    <!-- Required datatable js -->
    <script src="{{ asset('backend/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Responsive examples -->
    <script src="{{ asset('backend/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}">
    </script>

    {{-- <script src="{{ asset('backend/assets/js/pages/dashboard.init.js') }}"></script> --}}

    <!-- App js -->
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':
                    toastr.info(" {{ Session::get('message') }} ");
                    break;

                case 'success':
                    toastr.success(" {{ Session::get('message') }} ");
                    break;

                case 'warning':
                    toastr.warning(" {{ Session::get('message') }} ");
                    break;

                case 'error':
                    toastr.error(" {{ Session::get('message') }} ");
                    break;
            }
        @endif
    </script>

    <!-- Required datatable js -->
    <script src="{{ asset('backend/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Datatable init js -->
    <script src="{{ asset('backend/assets/js/pages/datatables.init.js') }}"></script>

    <script src="{{ asset('backend/assets/js/validate.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/validate-additional-methods.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script src="{{ asset('backend/assets/js/code.js') }}"></script>


    <script src="{{ asset('backend/assets/js/handlebars.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>

    <!--  For Select2 -->
    <script src="{{ asset('backend/assets/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pages/form-advanced.init.js') }}"></script>
    <!-- end  For Select2 -->
    <script>
        @if (Session::has('success'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.success("{{ session('success') }}");
        @endif

        @if (Session::has('error'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.error("{{ session('error') }}");
        @endif

        @if (Session::has('info'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.info("{{ session('info') }}");
        @endif

        @if (Session::has('warning'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.warning("{{ session('warning') }}");
        @endif
    </script>
    <!-- Javascript -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
    <script>
        $(function() {
            var orderDate = $("#order_date").val();
            $(".datepicker").datepicker({
                dateFormat: 'dd-mm-yy',
                changeMonth: true,
                changeYear: true,
                minDate: orderDate,
            });
        });

        $('.timeinpicker').timepicker({
            timeFormat: 'HH:mm',
            forceRoundTime: true,
            showMeridian: false,
            interval: 1,
            // minTime: checkintime,
            // maxTime: checkintime,
            // defaultTime: checkintime,
            // startTime: checkintime,
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });



        var checkintime = $('#check_in_time').val();
        var times = $('.timepicker').timepicker({
            timeFormat: 'HH:mm',
            forceRoundTime: true,
            showMeridian: false,
            interval: 1,
            // minTime: checkintime,
            // maxTime: checkintime,
            // defaultTime: checkintime,
            // startTime: checkintime,
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js">
    </script>
    <script type="text/javascript">
        $(document).ready(function() {

            var checkintime = $('#visitor_check_in_date').val();
            $('.checkdatetimepicker').datetimepicker({
                // format:'d-m-Y H:i',
                dayOfWeekStart: 1,
                // mask: '10-12-9999 29:59',
                yearStart: 2000,
                yearEnd: 2200,
                step: 1,
                format: 'd-m-Y',
                // formatTime: 'H:i',
                formatDate: 'd-m-Y',
                minDate: checkintime,
                maxDate: checkintime,
                minTime: 0,
                maxTime: 0,
                //  defaultTime: now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds(),

            });
            var checkouttime = $('#visitor_check_out_date').val();
            $('.checkOutdatetimepicker').datetimepicker({

                // format:'d-m-Y H:i',

                dayOfWeekStart: 1,
                // mask: '10-12-9999 29:59',
                yearStart: 2000,
                yearEnd: 2200,
                step: 1,
                format: 'd-m-Y',
                // formatTime: 'H:i',
                formatDate: 'd-m-Y',
                minDate: checkouttime,
                maxDate: checkouttime,
                minTime: 0,
                maxTime: 0,
                //  defaultTime: now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds(),

            });
            var checkintime = $('#vehicle_check_in_date').val();
            $('.checkdatetimepicker').datetimepicker({
                // format:'d-m-Y H:i',
                dayOfWeekStart: 1,
                // mask: '10-12-9999 29:59',
                yearStart: 2000,
                yearEnd: 2200,
                step: 1,
                format: 'd-m-Y',
                // formatTime: 'H:i',
                formatDate: 'd-m-Y',
                minDate: checkintime,
                maxDate: checkintime,
                minTime: 0,
                maxTime: 0,
                //  defaultTime: now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds(),

            });
            var checkouttime = $('#vehicle_check_out_date').val();
            $('.checkOutdatetimepicker').datetimepicker({

                // format:'d-m-Y H:i',

                dayOfWeekStart: 1,
                // mask: '10-12-9999 29:59',
                yearStart: 2000,
                yearEnd: 2200,
                step: 1,
                format: 'd-m-Y',
                // formatTime: 'H:i',
                formatDate: 'd-m-Y',
                minDate: checkouttime,
                maxDate: checkouttime,
                minTime: 0,
                maxTime: 0,
                //  defaultTime: now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds(),

            });

        });
    </script>


    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    @yield('js-scripts')
</body>

</html>
