@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Organization All</h4>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <a href="{{ route('supplier.add') }}" class="btn btn-dark btn-rounded waves-effect waves-light"
                                style="float:right;"><i class="fas fa-plus-circle"> Add Organization </i></a> <br> <br>

                            <h4 class="card-title">Organization All Data </h4>

                            <div class="table-responsive">
                                <table id="organizationTable" class="table table-bordered nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Sl</th>
                                            <th>Name</th>
                                            <th>Mobile Number </th>
                                            <th>Email</th>
                                            <th>Address</th>
                                            <th>Status</th>
                                            <th>Action</th>

                                    </thead>


                                    <tbody>

                                        @foreach ($suppliers as $key => $item)
                                            <tr>
                                                <td> {{ $key + 1 }} </td>
                                                <td> {{ $item->name }} </td>
                                                <td> {{ $item->mobile_no }} </td>
                                                <td> {{ $item->email }} </td>
                                                <td> {{ $item->address }} </td>
                                                <td>
                                                    @if ($item->status == 1)
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" checked
                                                                onchange="changeSupplierStatus({{ $item->id }})">
                                                        </div>
                                                    @else
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                onchange="changeSupplierStatus({{ $item->id }})">
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('supplier.edit', $item->id) }}"
                                                        class="btn btn-info sm" title="Edit Data"> <i
                                                            class="fas fa-edit"></i> </a>

                                                    {{-- <a href="{{ route('supplier.delete', $item->id) }}" class="btn btn-danger sm"
                                                    title="Delete Data" id="delete"> <i class="fas fa-trash-alt"></i>
                                                </a> --}}

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
        function changeSupplierStatus(id) {
            $.ajax({
                type: "put",
                data: {
                    _token: '{{ csrf_token() }}'
                },
                url: "{{ url('/organization-status/') }}" + "/" + id,
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
            $('#organizationTable').DataTable({
                dom: 'Blftip',
               
                buttons: [
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        },
                        title: 'Organizations List',
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        },
                        title: 'Organizations List',
                    },
                    
                ],
                lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
            });
        });
    </script>
@endsection
