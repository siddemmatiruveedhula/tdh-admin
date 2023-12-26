@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Product All</h4>



                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <a href="{{ route('product.add') }}" class="btn btn-dark btn-rounded waves-effect waves-light"
                                style="float:right;"><i class="fas fa-plus-circle"> Add Product </i></a> <br> <br>

                            <h4 class="card-title">Products list</h4>
                            <div class="table-responsive">

                                <table id="productTable" class="table table-bordered nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Sl</th>
                                            {{-- <th>Organization</th> --}}
                                            <th>Category</th>
                                            <th>Product Name</th>
                                            <th>Unit</th>
                                            <th>Default Price</th>
                                            <th>Status</th>
                                            <th>Action</th>

                                    </thead>


                                    <tbody>

                                        @foreach ($product as $key => $item)
                                            <tr>
                                                <td> {{ $key + 1 }} </td>
                                                {{-- <td> {{ $item['supplier']['name'] ?? '' }} </td> --}}
                                                <td> {{ $item['category']['name'] ?? '' }} </td>
                                                <td> {{ $item->name }} </td>
                                                <td> {{ $item['unit']['name'] }} </td>
                                                <td> {{ $item->default_price }} </td>
                                                <td>
                                                    @if ($item->status == 1)
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" checked
                                                                onchange="changeProductStatus({{ $item->id }})">
                                                        </div>
                                                    @else
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                onchange="changeProductStatus({{ $item->id }})">
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('product.edit', $item->id) }}" class="btn btn-info sm"
                                                        title="Edit Data"> <i class="fas fa-edit"></i> </a>

                                                    <a href="{{ route('product-gallery', $item->id) }} "
                                                        class="btn btn-primary sm" title="Gallery"><i
                                                            class="fas fa-images"></i>
                                                    </a>


                                                    {{-- <a href="{{ route('product.delete', $item->id) }}" class="btn btn-danger sm"
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
        function changeProductStatus(id) {
            $.ajax({
                type: "put",
                data: {
                    _token: '{{ csrf_token() }}'
                },
                url: "{{ url('/product-status/') }}" + "/" + id,
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
            $('#productTable').DataTable({
                dom: 'Blftip',

                buttons: [{
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        },
                        title: 'Products List',
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        },
                        title: 'Products List',
                    },

                ],
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ]
            });
        });
    </script>
@endsection
