@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Holidays</h4>

                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('holiday.create') }}" class="btn btn-dark btn-rounded waves-effect waves-light"
                                style="float:right;"><i class="fas fa-plus-circle"> Add Holiday </i></a> <br> <br>
                            <h4 class="card-title">Holidays List</h4>

                            <table id="holidayTable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <th width="5%">Sl</th>
                                    <th>From Date</th>
                                    <th>To Date</th>
                                    <th>Reason</th>
                                    <th>Created By</th>
                                    <th width="20%">Action</th>
                                </thead>

                                <tbody>
                                    @foreach ($holidays as $key => $holiday)
                                        <tr>
                                            <td> {{ $key + 1 }} </td>
                                            <td>{{ date('d-m-Y',strtotime($holiday->from_date)) }}</td>
                                            <td>{{ date('d-m-Y',strtotime($holiday->to_date)) }}</td>
                                            <td> {{ $holiday->reason }} </td>
                                            <td> {{ $holiday->user->name ?? '' }} </td>
                                            <td>
                                                <a href="{{ route('holiday.edit', $holiday->id) }}" class="btn btn-info sm"
                                                    title="Edit Data"> <i class="fas fa-edit"></i> </a>
                                                
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
            $('#holidayTable').DataTable({
                dom: 'Blftip',
               
                buttons: [
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1,2,3,4]
                        },
                        title: 'Holidays List',
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1,2,3,4]
                        },
                        title: 'Holidays List',
                    },
                    
                ],
                lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
            });
        });
    </script>
@endsection
