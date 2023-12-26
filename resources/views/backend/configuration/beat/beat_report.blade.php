@extends('admin.admin_master')
@section('admin')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">PJP Report</h4>

                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="beatReportTable" class="table table-bordered nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%">Sl</th>
                                        <th>PJP DATE</th>
                                        <th>EMP NAME</th>
                                        <th>EMP CODE</th>
                                        <th>ROLE NAME</th>
                                        <th>CHECK IN</th>
                                        <th>CHECK OUT</th>                                        
                                        <th>DA</th>
                                        <th>TA</th>
                                        <th>OTHER EXPENSES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($eods as $eod)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $eod->date->format('d-m-Y') }}</td>
                                        <td>
                                            <a href="{{ route('beat-view',$eod->id) }}" target="_blank">
                                            {{ $eod->employee->name }}
                                            </a>
                                        </td>
                                        <td>{{ $eod->employee->employee_code }}</td>
                                        <td>{{ $eod->employee->role->name }}</td>
                                        <td>{{ $eod->attendance->attendance_time }}</td>
                                        <td>{{ $eod->attendance->clockout_time }}</td>                                        
                                        <td>{{ $eod->da }}</td>
                                        <td>{{ $eod->ta }}</td>
                                        <td>{{ $eod->other_expenses }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->



    </div> <!-- container-fluid -->
</div>
<script>
   
    $(document).ready(function() {
        $('#beatReportTable').DataTable({
            dom: 'Blftip',
           
            buttons: [
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8,9]
                    },
                    title: 'PJP Report',
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8,9]
                    },
                    title: 'PJP Report',
                },
                
            ],
            lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
        });
    });
</script>
@endsection