@extends('admin.admin_master')
@section('admin')
    <style>
        .ui-datepicker-calendar {
            display: none;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">

    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">


                        <div class="card-header bg-info text-white">
                            @php
                                if (isset($month)) {
                                    $date_picker = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $month)->format('M-Y');
                                } else {
                                    $date_picker = \Carbon\Carbon::now()->format('M-Y');
                                }
                                
                            @endphp
                            Month Wise Report
                            <div id="random_date">{{ $date_picker }}</div>
                        </div>

                        <div class="card-body">

                            <form action="{{ route('sheet-report') }}" method="POST">
                                @csrf
                                <div class="row input-daterange">
                                    <div class="col-md-4">
                                        <label for="division_id" class="form-label"> Month </label>
                                        <div class="form-group">
                                            <input type="text" name="month" id="month" value="{{ $date_picker }}"
                                                class="datepicker form-control" placeholder="Select Specific Month"
                                                readonly />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="division_id" class="form-label">Department</label>
                                        <div class="form-group">
                                            <select name="department_id" id="department_id" class="form-select select2"
                                                onchange="getDivisions()">
                                                <option value="" disabled selected>--Select Department--</option>
                                                @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}"
                                                        {{ old('department_id', $department_id) == $department->id ? 'selected' : '' }}>
                                                        {{ $department->name ?? '' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @php
                                        
                                        $divs = App\Models\Division::select('*')
                                            ->where('department_id', $department_id)
                                            ->where('status', 1)
                                            ->get();
                                        
                                    @endphp
                                    <div class="col-md-4 mb-3" id="division_id_content">
                                        <label for="division_id" class="form-label">Division</label>
                                        <div class="form-group">
                                            <select name="division_id" id="division_id" class="form-select select2">
                                                <option value="" disabled selected>--Select Division--</option>
                                                @if ($division_id != '')
                                                    @foreach ($divs as $division)
                                                        <option value="{{ $division->id }}"
                                                            {{ old('division_id', $division_id) == $division->id ? 'selected' : '' }}>
                                                            {{ $division->name }}</option>
                                                    @endforeach
                                                @else
                                                    @foreach ($divisions as $division)
                                                        <option value="{{ $division->id }}"
                                                            {{ old('division_id', $division_id) == $division->id ? 'selected' : '' }}>
                                                            {{ $division->name }}</option>
                                                    @endforeach
                                                @endif

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="submit" class="form-label"> </label>
                                        <div class="form-group">
                                            <button type="submit" name="submit" class="btn btn-primary">Filter</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <br>

                            <div class="table-rep-plugin">
                                <div class="table-responsive">

                                    <table id="mytable" class="table table-bordered nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        {{-- <table class="table table-md table-hover" id="printTable"> --}}
                                        <thead class="thead-dark">
                                            <tr>
                                                <th style="font-weight: bold;">Employee Name</th>
                                                <th style="font-weight: bold;">Department</th>
                                                <th style="font-weight: bold;">Division</th>

                                                @php
                                                    
                                                    if (isset($month)) {
                                                        $dates = [];
                                                        $months = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $month)->format('m');
                                                    
                                                        $days_in_month = \Carbon\Carbon::now()->month($months)->daysInMonth;
                                                        $months = ltrim($months, '0');
                                                        $year = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $month)->format('Y');
                                                    
                                                        for ($i = 1; $i < $days_in_month + 1; ++$i) {
                                                            $dates[] = \Carbon\Carbon::createFromDate($year, $months, $i)->format('d');
                                                        }
                                                    } else {
                                                        $dates = [];
                                                        $today = today();
                                                        // echo $today->daysInMonth;
                                                        // echo $today->month;
                                                        // echo $today->year;
                                                        // exit;
                                                    
                                                        for ($i = 1; $i < $today->daysInMonth + 1; ++$i) {
                                                            $dates[] = \Carbon\Carbon::createFromDate($today->year, $today->month, $i)->format('d');
                                                        }
                                                    }
                                                    
                                                @endphp
                                                @foreach ($dates as $date)
                                                    <th style="">{{ $date }}</th>
                                                @endforeach

                                            </tr>
                                        </thead>

                                        <tbody>

                                            @foreach ($employees as $employee)
                                                <input type="hidden" name="employee_id" value="{{ $employee->id }}">

                                                <tr>
                                                    <td>{{ $employee->name }}</td>
                                                    <td>{{ $employee->department->name ?? '' }}</td>
                                                    <td>{{ $employee->division->name ?? '' }}</td>

                                                    @if (isset($month))
                                                        @for ($i = 1; $i < $days_in_month + 1; ++$i)
                                                            @php
                                                                
                                                                $date_picker = \Carbon\Carbon::createFromDate($year, $months, $i)->format('Y-m-d');
                                                                $newDate = date('l', strtotime($date_picker));
                                                                $holiday_check = \App\Models\Holiday::query()
                                                                    ->whereRaw('"' . $date_picker . '" between `from_date` and `to_date`')
                                                                    ->first();
                                                                $leave_check = \App\Models\Leave::query()
                                                                    ->where('employee_id', $employee->id)
                                                                    ->where('date', $date_picker)
                                                                    ->where('status', 'approved')
                                                                    ->first();
                                                                
                                                                $check_attd = \App\Models\Attendance::query()
                                                                    ->where('employee_id', $employee->id)
                                                                    ->where('attendance_date', $date_picker)
                                                                    ->first();
                                                                
                                                            @endphp
                                                            <td>

                                                                <div class="form-check form-check-inline ">
                                                                    @if ($newDate == 'Sunday')
                                                                        @if (isset($check_attd))
                                                                            @if ($check_attd->status == 1)
                                                                                <i class="fas text-success">HP</i>
                                                                            @endif
                                                                        @else
                                                                            <i class="fas text-primary">H</i>
                                                                        @endif
                                                                    @elseif (isset($holiday_check))
                                                                        @if ($holiday_check->id != '')
                                                                            @if (isset($check_attd))
                                                                                @if ($check_attd->status == 1)
                                                                                    <i class="fas text-primary">HP</i>
                                                                                @endif
                                                                            @else
                                                                                <i class="fas text-primary">H</i>
                                                                            @endif
                                                                        @endif
                                                                    @elseif (isset($leave_check))
                                                                        @if ($leave_check->id != '')
                                                                            @if (isset($check_attd))
                                                                                @if ($check_attd->status == 1)
                                                                                    <i class="fas text-warning">LP</i>
                                                                                @endif
                                                                            @else
                                                                                <i class="fas text-warning">L</i>
                                                                            @endif
                                                                        @endif
                                                                    @elseif (isset($check_attd))
                                                                        @if ($check_attd->status == 1)
                                                                            <i class="fas text-success">P</i>
                                                                        @else
                                                                            <i class="fas text-danger">P</i>
                                                                        @endif
                                                                    @else
                                                                        <i class="fas text-danger">A</i>
                                                                    @endif
                                                                </div>

                                                            </td>
                                                        @endfor
                                                    @else
                                                        @for ($i = 1; $i < $today->daysInMonth + 1; ++$i)
                                                            @php
                                                                
                                                                $date_picker = \Carbon\Carbon::createFromDate($today->year, $today->month, $i)->format('Y-m-d');
                                                                $newDate = date('l', strtotime($date_picker));
                                                                $holiday_check = \App\Models\Holiday::query()
                                                                    ->whereRaw('"' . $date_picker . '" between `from_date` and `to_date`')
                                                                    ->first();
                                                                $leave_check = \App\Models\Leave::query()
                                                                    ->where('employee_id', $employee->id)
                                                                    ->where('date', $date_picker)
                                                                    ->where('status', 'approved')
                                                                    ->first();
                                                                
                                                                $check_attd = \App\Models\Attendance::query()
                                                                    ->where('employee_id', $employee->id)
                                                                    ->where('attendance_date', $date_picker)
                                                                    ->first();
                                                                
                                                            @endphp
                                                            <td>

                                                                <div class="form-check form-check-inline ">
                                                                    @if ($newDate == 'Sunday')
                                                                        @if (isset($check_attd))
                                                                            @if ($check_attd->status == 1)
                                                                                <i class="fas text-primary">HP</i>
                                                                            @endif
                                                                        @else
                                                                            <i class="fas text-primary">H</i>
                                                                        @endif
                                                                    @elseif (isset($holiday_check))
                                                                        @if ($holiday_check->id != '')
                                                                            @if (isset($check_attd))
                                                                                @if ($check_attd->status == 1)
                                                                                    <i class="fas text-primary">HP</i>
                                                                                @endif
                                                                            @else
                                                                                <i class="fas text-primary">H</i>
                                                                            @endif
                                                                        @endif
                                                                    @elseif (isset($leave_check))
                                                                        @if ($leave_check->id != '')
                                                                            @if (isset($check_attd))
                                                                                @if ($check_attd->status == 1)
                                                                                    <i class="fas text-warning">LP</i>
                                                                                @endif
                                                                            @else
                                                                                <i class="fas text-warning">L</i>
                                                                            @endif
                                                                        @endif
                                                                    @elseif (isset($check_attd))
                                                                        @if ($check_attd->status == 1)
                                                                            <i class="fas text-success">P</i>
                                                                        @else
                                                                            <i class="fas text-danger">P</i>
                                                                        @endif
                                                                    @else
                                                                        <i class="fas text-danger">A</i>
                                                                    @endif
                                                                </div>

                                                            </td>
                                                        @endfor
                                                    @endif

                                                </tr>
                                            @endforeach


                                        </tbody>
                                        <!-- Log on to codeastro.com for more projects! -->


                                    </table>

                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->



            </div> <!-- container-fluid -->
        </div>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>

        <script type="text/javascript">
            $(function() {
                $('.datepicker').datepicker({
                    changeMonth: true,
                    changeYear: true,
                    showButtonPanel: true,
                    dateFormat: 'M-yy',
                    onClose: function(dateText, inst) {
                        $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
                    }
                });
            });

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

        <script>
            // var currentDate = new Date()
            // // var day = currentDate.getDate()
            // var month = currentDate.getMonth()
            // var year = currentDate.getFullYear()
            // const monthNames = ["January", "February", "March", "April", "May", "June",
            //     "July", "August", "September", "October", "November", "December"
            // ];

            $('#mytable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Attendance Report On  ' + $("#random_date").text(),
                        // footer: true
                    },
                    {
                        extend: 'pdf',
                        orientation: 'landscape',
                        pageSize: 'A3',
                        title: 'Attendance Report On  ' + $("#random_date").text(),
                    }
                ],
            });
        </script>
    @endsection
