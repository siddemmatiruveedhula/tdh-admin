@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Customer Category Type All</h4>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <a href="{{ route('customer-category-type.add') }}" class="btn btn-dark btn-rounded waves-effect waves-light"
                                style="float:right;"><i class="fas fa-plus-circle"> Add Customer Category Type </i></a> <br> <br>

                            <h4 class="card-title">Customer Category Type Data </h4>


                            <table id="customerCateTypeTable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%">Sl</th>
                                        <th>Name</th>
                                        {{-- <th>Status</th> --}}
                                        <th width="20%">Action</th>
                                </thead>


                                <tbody>

                                    @foreach ($customerCategoryTypes as $key => $customerCategoryType)
                                        <tr>
                                            <td> {{ $key + 1 }} </td>
                                            <td> {{ $customerCategoryType->name }} </td>
                                            {{-- <td>
                                                @if ($customerCategoryType->status == 1)
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" checked
                                                            onchange="changecustomerCategoryTypeStatus({{ $customerCategoryType->id }})">
                                                    </div>
                                                @else
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                            onchange="changecustomerCategoryTypeStatus({{ $customerCategoryType->id }})">
                                                    </div>
                                                @endif
                                            </td> --}}
                                            <td>
                                                <a href="{{ route('customer-category-type.edit', $customerCategoryType->id) }}" class="btn btn-info sm"
                                                    title="Edit Data"> <i class="fas fa-edit"></i> </a>

                                                {{-- <a href="{{ route('country.delete', $country->id) }}" class="btn btn-danger sm"
                                                    title="Delete Data" id="delete"> <i class="fas fa-trash-alt"></i>
                                                </a> --}}

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
@endsection

@section('js-scripts')
    <script>
        // function changecustomerCategoryTypeStatus(id) {
        //     $.ajax({
        //         type: "put",
        //         data: {
        //             _token: '{{ csrf_token() }}'
        //         },
        //         url: "{{ url('/customer-category-type-status/') }}" + "/" + id,
        //         success: function(response) {
        //             toastr.options = {
        //                 "closeButton": true,
        //                 "progressBar": true
        //             }
        //             toastr.success(response)
        //         },
        //         error: function(err) {
        //             console.log(err);
        //         }
        //     })
        // }
        $(document).ready(function() {
            $('#customerCateTypeTable').DataTable({
                dom: 'Blftip',
               
                buttons: [
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1]
                        },
                        title: 'Customer Category Types List',
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1]
                        },
                        title: 'Customer Category Types List',
                    },
                    
                ],
                lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
            });
        });
    </script>
@endsection
