@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Customer All</h4>



                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <a href="{{ route('customer.add') }}" class="btn btn-dark btn-rounded waves-effect waves-light"
                                style="float:right;"><i class="fas fa-plus-circle"> Add Customer </i></a> <br> <br>

                            <h4 class="card-title">Customer All Data </h4>


                            <table id="customerTable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Name</th>
                                        <th>Customer Image </th>
                                        {{-- <th>Email</th> --}}
                                        {{-- <th>Address</th> --}}
                                        <th>Status</th>
                                        <th>Action</th>

                                </thead>


                                <tbody>

                                    @foreach ($customers as $key => $item)
                                        <tr>
                                            <td> {{ $key + 1 }} </td>
                                            <td> {{ $item->name }} </td>
                                            <td>
                                                @if ($item->customer_image)
                                                    <img src="{{ asset('upload/customer/' . $item->customer_image) }}"
                                                        style="width:60px; height:50px">
                                                @else
                                                    Not available
                                                @endif
                                            </td>
                                            {{-- <td> {{ $item->email }} </td> --}}
                                            {{-- <td> {{ $item->address }} </td> --}}
                                            <td>
                                                @if ($item->status == 1)
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" checked
                                                            onchange="changeCustomerStatus({{ $item->id }})">
                                                    </div>
                                                @else
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                            onchange="changeCustomerStatus({{ $item->id }})">
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('customer.edit', $item->id) }}" class="btn btn-info sm"
                                                    title="Edit Data"> <i class="fas fa-edit"></i> </a>

                                                {{-- <a href="{{ route('customer.reset-password', $item->id) }}"
                                                    class="btn btn-info sm"><i class="fa fa-key"
                                                        title="Reset Password"></i></a> --}}
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
        function changeCustomerStatus(id) {
            $.ajax({
                type: "put",
                data: {
                    _token: '{{ csrf_token() }}'
                },
                url: "{{ url('/customer-status/') }}" + "/" + id,
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
        $('#customerTable').DataTable({
            dom: 'Blftip',
           
            buttons: [
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: [0, 1]
                    },
                    title: 'Customers List',
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: [0, 1]
                    },
                    title: 'Customers List',
                },
                
            ],
            lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
        });
    });
    </script>
@endsection
