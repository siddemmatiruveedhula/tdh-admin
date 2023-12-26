@inject('carbon', 'Carbon\Carbon')
@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Vehicles</h4>



                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Vehicles List </h4>

                            <div class="table-responsive">
                                <table id="vehicleTable" class="table table-bordered nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Sl</th>
                                            <th>Vehicle Type</th>
                                            <th>Transportation</th>
                                            <th>Vehicle Number</th>
                                            <th>Driver Name</th>
                                            <th>Phone Number</th>
                                            <th>Check In Date & Time</th>
                                            <th>Check Out Date & Time</th>
                                            <th>Status</th>
                                            <th>Action</th>

                                    </thead>


                                    <tbody>

                                        @foreach ($vehicles as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->vehicleType->name }}</td>
                                                <td>{{ $item->transportation->name ?? ''}}</td>
                                                <td>{{ $item->vehicle_number }}</td>
                                                <td>{{ $item->driver_name }}</td>
                                                <td>{{ $item->driver_phone }}</td>
                                                {{-- <td>{{ $item->check_in_time }}</td>
                                                <td>{{ $item->check_out_time }}</td> --}}
                                                <td>
                                                    @if ($item->check_in_date)
                                                        {{ $carbon::parse($item->check_in_date)->format('d-m-Y') }}
                                                        {{ $item->check_in_time }}
                                                    @else
                                                        {{ null }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->check_out_date)
                                                        {{ $carbon::parse($item->check_out_date)->format('d-m-Y') }}
                                                        {{ $item->check_out_time }}
                                                    @else
                                                        {{ null }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->status == 1)
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" checked
                                                                onchange="changeVehicleStatus({{ $item->id }})">
                                                        </div>
                                                    @else
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                onchange="changeVehicleStatus({{ $item->id }})">
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('vehicles.edit', $item->id) }}"
                                                        class="btn btn-info sm" title="Edit Data"> <i
                                                            class="fa fa-edit"></i> </a>
                                                </td>
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
        function changeVehicleStatus(id) {
            $.ajax({
                type: "put",
                data: {
                    _token: '{{ csrf_token() }}'
                },
                url: "{{ url('/vehicles-status/') }}" + "/" + id,
                success: function(response) {
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true
                    }
                    toastr.success(response)
                },
                error: function(err) {
                    console.log(err);
                }
            })
        }
        $(document).ready(function() {
            $('#vehicleTable').DataTable({
                dom: 'Blftip',
               
                buttons: [
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7]
                        },
                        title: 'Vehicles List',
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7]
                        },
                        title: 'Vehicles List',
                    },
                    
                ],
                lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
            });
        });
    </script>
@endsection
