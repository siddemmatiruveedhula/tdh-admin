@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Vehicle Type All</h4>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <a href="{{ route('vehicle.add') }}" class="btn btn-dark btn-rounded waves-effect waves-light"
                                style="float:right;"><i class="fas fa-plus-circle"> Add Vehicle Type </i></a> <br> <br>

                            <h4 class="card-title">Vehicle Type List </h4>


                            <table id="vehicleTypeTable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%">Sl</th>
                                        <th>Vehicle Type</th>
                                        <th>Status</th>
                                        <th>Action</th>

                                </thead>


                                <tbody>

                                    @foreach ($vehicleTypes as $key => $vehicleType)
                                        <tr>
                                            <td> {{ $key + 1 }} </td>
                                            <td> {{ $vehicleType->name }} </td>
                                            <td>
                                                @if ($vehicleType->status == 1)
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" checked
                                                            onchange="changeVehicleTypeStatus({{ $vehicleType->id }})">
                                                    </div>
                                                @else
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                            onchange="changeVehicleTypeStatus({{ $vehicleType->id }})">
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('vehicle.edit', $vehicleType->id) }}" class="btn btn-info sm"
                                                    title="Edit Data"> <i class="fas fa-edit"></i> </a>


                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->



        </div> <!-- container-fluid -->
    </div>
    <script>
        function changeVehicleTypeStatus(id) {
            $.ajax({
                type: "put",
                data: {
                    _token: '{{ csrf_token() }}'
                },
                url: "{{ url('/vehicle-type-status/') }}" + "/" + id,
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
            $('#vehicleTypeTable').DataTable({
                dom: 'Blftip',
               
                buttons: [
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1]
                        },
                        title: 'Vehicle Type List',
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1]
                        },
                        title: 'Vehicle Type List',
                    },
                    
                ],
                lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
            });
        });
    </script>
@endsection
