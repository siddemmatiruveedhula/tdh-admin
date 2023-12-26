@extends('admin.admin_master')
@section('admin')
    

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Storage Type</h4>

                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('storage-type.all') }}">Storage Type</a></li>
                            <li class="breadcrumb-item active">UPDATE</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- end page title -->
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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Edit Storage Type Page </h4><br><br>

                            @if (Session::has('success'))
                                <div class="alert alert-success">
                                    {{ Session::get('success') }}
                                    @php
                                        Session::forget('success');
                                    @endphp
                                </div>
                            @endif

                            <form method="post" action="{{ route('storage-type.update') }}" id="myForm">
                                @csrf

                                <input type="hidden" name="id" value="{{ $storage_type->id }}">
                                
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Name<span
                                            class="text-danger">*</span> </label>
                                    <div class="form-group col-sm-10">
                                        <input name="name" value="{{ old('name', $storage_type->name) }}" class="form-control"
                                            type="text" placeholder="Storage Type">
                                    </div>
                                </div>
                                <!-- end row -->


                                <input type="submit" class="btn btn-info waves-effect waves-light" value="Update Storage Type">
                            </form>



                        </div>
                    </div>
                </div> <!-- end col -->
            </div>



        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            jQuery.validator.addMethod("nonNumeric", function(value) {
                    return value == "" || /[a-z]/.test(value) || /[a-z]/.test(value) && /\d/.test(value) ||
                        /[A-Z]/.test(value) || /[A-Z]/.test(value) && /\d/.test(value);
                },
                "Please enter Letters or Alphanumeric only"
            );
            $('#myForm').validate({
                rules: {
                    name: {
                        required: true,
                        nonNumeric: true,
                    },

                },
                messages: {
                    name: {
                        required: 'Please Enter Storage Type',
                    },

                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });
        });
    </script>
@endsection
