@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Leaves</h4>

                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            {{-- <a href="{{ route('holiday.create') }}"
                                class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right;"><i
                                    class="fas fa-plus-circle"> Add Holiday </i></a> <br> <br> --}}
                            <h4 class="card-title">Leaves List</h4>

                            <table id="leaveTable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <th width="5%">Sl</th>
                                    <th>Employee Name</th>
                                    <th>Leave Date</th>
                                    <th>Leave Type</th>
                                    <th>Leave Status</th>
                                    <th>Approved By</th>
                                    <th width="20%">Action</th>
                                </thead>

                                <tbody>
                                    @foreach ($leaves as $key => $leave)
                                        <tr>
                                            <td> {{ $key + 1 }} </td>
                                            <td>{{ $leave->employee->name }} </td>
                                            <td>{{ date('d-m-Y', strtotime($leave->date)) }}</td>
                                            <td> {{ $leave->leavetype->leave_type }} </td>
                                            <td>
                                                @if ($leave->status == 'approved')
                                                    {{ 'Approved' }}
                                                @else
                                                    {{ 'Not Approved' }}
                                                @endif
                                            </td>
                                            <td> {{ $leave->approved->name ?? '' }} </td>
                                            <td>
                                                @if ($leave->status == 'not_approved')
                                                    <a href="{{ route('leave.edit', $leave->id) }}"
                                                        class="btn btn-info sm" title="Edit Data"> <i
                                                            class="fas fa-edit"></i> </a>
                                                @else
                                                    {{ '' }}
                                                @endif


                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <!-- The Modal -->
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->



        </div> <!-- container-fluid -->
    </div>
    <script>
      
        $(document).ready(function() {
            $('#leaveTable').DataTable({
                dom: 'Blftip',
               
                buttons: [
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1,2,3,4,5]
                        },
                        title: 'Leaves List',
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1,2,3,4,5]
                        },
                        title: 'Leaves List',
                    },
                    
                ],
                lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
            });
        });
    </script>
@endsection
