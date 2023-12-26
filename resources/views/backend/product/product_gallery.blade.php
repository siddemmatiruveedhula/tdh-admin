@extends('admin.admin_master')
@section('admin')
    

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Product</h4>

                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('product.all') }}">Product</a></li>
                            <li class="breadcrumb-item active">Gallery</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Add Product Image</h4><br><br>
                            @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                            <form class="row g-3" id="myForm" action="{{ route('product-gallery.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="col-6">
                                    <label for="example-text-input" class="form-label">Product Image<span
                                            class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <input name="image[]" class="form-control" type="file" id="image[]" multiple>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="status" class="form-label">Status <span
                                            class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <select name="status" class="form-select" aria-label="Select Status">
                                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <input type="hidden" name="product_id" required value="{{ $product->id }}">
                                <br>

                                <div class="text-left">
                                    <button type="submit" class="btn btn-info waves-effect waves-light">Upload</button>
                                </div>
                            </form>
                            <br>

                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Image</th>
                                        <th>Status</th>
                                        <th>Action</th>

                                </thead>


                                <tbody>

                                    @foreach ($gallery as $key => $item)
                                        <tr>
                                            <td> {{ $key + 1 }} </td>
                                            <td>    <img src="{{ asset('upload/product-gallery/' . $item->image) }}"
                                                style="width:60px; height:50px">
                                            <td>
                                                @if ($item->status == 1)
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" checked
                                                            onchange="changeProductgalleryStatus({{ $item->id }})">
                                                    </div>
                                                @else
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                            onchange="changeProductgalleryStatus({{ $item->id }})">
                                                    </div>
                                                @endif
                                            </td>
                                            <td>

                                                <a href="{{ route('product-gallery.delete', $item->id) }}"
                                                    class="btn btn-danger sm" title="Delete Data" id="delete"> <i
                                                        class="fas fa-trash-alt"></i>
                                                </a>

                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>



                        </div>
                    </div>
                </div> <!-- end col -->
            </div>

        </div>
    </div>
    <script>
        function changeProductgalleryStatus(id) {
            $.ajax({
                type: "put",
                data: {
                    _token: '{{ csrf_token() }}'
                },
                url: "{{ url('/product-gallery-status/') }}" + "/" + id,
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
    </script>

@endsection
