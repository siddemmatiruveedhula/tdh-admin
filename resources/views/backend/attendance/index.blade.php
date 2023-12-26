@inject('carbon', 'Carbon\Carbon')
@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Date Wise Report</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row input-daterange">
                                <div class="col-md-4">
                                    <label for="from_date" class="form-label">Date</label>
                                    <div class="form-group">
                                        <input type="text" name="from_date" value="{{ $current_date }}" id="from_date"
                                            class="datepicker form-control" placeholder="Select Specific Day" readonly />
                                    </div>
                                </div><br>
                                <div class="col-md-4">
                                    <label for="division_id" class="form-label">Department</label>
                                    <div class="form-group">
                                        <select name="department_id" id="department_id" class="form-select select2"
                                            onchange="getDivisions()">
                                            <option value="" disabled selected>--Select Department--</option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}">{{ $department->name ?? '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3" id="division_id_content">
                                    <label for="division_id" class="form-label">Division</label>
                                    <div class="form-group">
                                        <select name="division_id" id="division_id" class="form-select select2">
                                            <option value="" disabled selected>--Select Division--</option>
                                            @php
                                                if (old('department_id')) {
                                                    $divisions = App\Models\Division::select('id', 'name')
                                                        ->where('department_id', old('department_id'))
                                                        ->where('status', true)
                                                        ->get();
                                                }
                                            @endphp
                                            @if (isset($divisions))
                                                @foreach ($divisions as $division)
                                                    <option value="{{ $division->id }}"
                                                        {{ old('division_id') == $division->id ? 'selected' : '' }}>
                                                        {{ $division->name }}</option>
                                                @endforeach
                                            @endif
                                            @foreach ($divisions as $division)
                                                <option value="{{ $division->id }}"
                                                    {{ old('division_id') == $division->id ? 'selected' : '' }}>
                                                    {{ $division->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" name="filter" id="filter"
                                        class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                            <br>

                            <div class="table-rep-plugin">
                                <div class="table-responsive">
                                    <table id="order_table" class="table table-bordered nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Name</th>
                                                <th>Role</th>
                                                {{-- <th>Organization</th> --}}
                                                <th>Department</th>
                                                <th>Division</th>
                                                <th>Status</th>
                                                <th>Clock In</th>
                                                <th>Clock Out</th>
                                            </tr>
                                        </thead>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js-scripts')
    <script>
        $(document).ready(function() {


            load_data();

            function load_data(from_date = '',division_id='',department_id='') {
                $('#order_table').DataTable({
                    processing: true,
                    serverSide: true,
                    paging: false,
                    ajax: {
                        url: "{{ route('attendance') }}",
                        data: {
                            from_date: from_date,
                            division_id: division_id,
                            department_id: department_id
                        }
                    },
                    dom: 'Blfrtip',
                    buttons: [
                        {
                        extend: 'excel',
                        title: 'Attendance Report On ' + $("#from_date").val(),
                        footer: true
                    },
                    {
                        extend: 'pdf',
                        title: 'Attendance Report On ' + $("#from_date").val(),
                        footer: true
                    }
                ],
                    columns: [{
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'role_name',
                            name: 'role_name'
                        },
                        // {
                        //     data: 'supplier_name',
                        //     name: 'supplier_name'
                        // },
                        
                        {
                            data: 'department_name',
                            name: 'department_name'
                        },

                        {
                            data: 'division_name',
                            name: 'division_name'
                        },
                        {
                            data: 'attendance_status',
                            name: 'attendance_status'
                        },
                        {
                            data: 'attendance_time',
                            name: 'attendance_time'
                        },
                        {
                            data: 'clockout_time',
                            name: 'clockout_time'
                        },
                    ],
                });
            }




            // var department_id = $('#department_id').val();

            // load_dep_data();

            // function load_dep_data(department_id = '') {
            //     $('#order_table').DataTable({
            //         processing: true,
            //         serverSide: true,
            //         paging: false,
            //         ajax: {
            //             url: "{{ route('attendance') }}",
            //             data: {
            //                 department_id: department_id
            //             }
            //         },
            //         dom: 'Blfrtip',
            //         buttons: [{
            //             extend: 'excel',
            //             title: 'Attendance Report On ' + $("#from_date").val(),
            //             footer: true
            //         }],
            //         columns: [{
            //                 data: 'name',
            //                 name: 'name'
            //             },
            //             {
            //                 data: 'role_name',
            //                 name: 'role_name'
            //             },
            //             {
            //                 data: 'supplier_name',
            //                 name: 'supplier_name'
            //             },

            //             {
            //                 data: 'division_name',
            //                 name: 'division_name'
            //             },
            //             {
            //                 data: 'department_name',
            //                 name: 'department_name'
            //             },
            //             {
            //                 data: 'attendance_status',
            //                 name: 'attendance_status'
            //             },
            //             {
            //                 data: 'attendance_time',
            //                 name: 'attendance_time'
            //             },
            //             {
            //                 data: 'clockout_time',
            //                 name: 'clockout_time'
            //             },
            //         ],
            //     });
            // }

            // load_my_data();

            // function load_my_data(division_id = '') {
            //     $('#order_table').DataTable({
            //         processing: true,
            //         serverSide: true,
            //         paging: false,
            //         ajax: {
            //             url: "{{ route('attendance') }}",
            //             data: {
            //                 division_id: division_id
            //             }
            //         },
            //         dom: 'Blfrtip',
            //         buttons: [{
            //             extend: 'excel',
            //             title: 'Attendance Report On ' + $("#from_date").val(),
            //             footer: true
            //         }],
            //         columns: [{
            //                 data: 'name',
            //                 name: 'name'
            //             },
            //             {
            //                 data: 'role_name',
            //                 name: 'role_name'
            //             },
            //             {
            //                 data: 'supplier_name',
            //                 name: 'supplier_name'
            //             },

            //             {
            //                 data: 'division_name',
            //                 name: 'division_name'
            //             },
            //             {
            //                 data: 'department_name',
            //                 name: 'department_name'
            //             },
            //             {
            //                 data: 'attendance_status',
            //                 name: 'attendance_status'
            //             },
            //             {
            //                 data: 'attendance_time',
            //                 name: 'attendance_time'
            //             },
            //             {
            //                 data: 'clockout_time',
            //                 name: 'clockout_time'
            //             },
            //         ],
            //     });
            // }

            $('#filter').click(function() {
                var from_date = $('#from_date').val();
                var division_id = $('#division_id').val();
                var department_id = $('#department_id').val();

                if (from_date != '') {
                    $('#order_table').DataTable().destroy();
                    load_data(from_date,division_id,department_id);
                }
                // if (department_id != '') {
                //     $('#order_table').DataTable().destroy();
                //     load_data(department_id);
                // }
                // if (division_id != '') {
                //     $('#order_table').DataTable().destroy();
                //     load_data(division_id);
                // }
                // if (department_id != '') {
                //     $('#order_table').DataTable().destroy();
                //     load_dep_data(department_id);
                // }
                // if (division_id != '') {
                //     $('#order_table').DataTable().destroy();
                //     load_my_data(division_id);
                // } else {
                //     alert('Please Select Specific Day');
                // }

            });

        });
    </script>
    <script>
        function getDivisions() {
            let id = $("#department_id").val();
            $.ajax({
                type: "get",
                data: {
                    _token: '{{ csrf_token() }}'
                },
                url: "{{ url('/employee-division/') }}" + "/" + id,
                success: function(response) {
                    $("#division_id_content").html(response);
                },
                error: function(err) {
                    console.log(err);
                }
            })
        }
    </script>
@endsection
