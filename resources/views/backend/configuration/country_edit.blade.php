@extends('admin.admin_master')
@section('admin')
    

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Country</h4>

                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('country.all') }}">Country</a></li>
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

                            <h4 class="card-title">Edit Country Page </h4><br><br>

                            @if (Session::has('success'))
                                <div class="alert alert-success">
                                    {{ Session::get('success') }}
                                    @php
                                        Session::forget('success');
                                    @endphp
                                </div>
                            @endif

                            <form method="post" action="{{ route('country.update') }}" id="myForm">
                                @csrf

                                <input type="hidden" name="id" value="{{ $country->id }}">
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Country Name<span
                                            class="text-danger">*</span> </label>
                                    <div class="form-group col-sm-10">
                                        <input name="countryCode" value="{{ old('countryCode', $country->countryCode) }}"
                                            class="form-control" type="text" placeholder="Country Code">
                                    </div>
                                </div>
                                <!-- end row -->
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Name<span
                                            class="text-danger">*</span> </label>
                                    <div class="form-group col-sm-10">
                                        <input name="name" value="{{ old('name', $country->name) }}" class="form-control"
                                            type="text" placeholder="Name">
                                    </div>
                                </div>
                                <!-- end row -->


                                <input type="submit" class="btn btn-info waves-effect waves-light" value="Update Country">
                            </form>



                        </div>
                    </div>
                </div> <!-- end col -->
            </div>



        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            jQuery.validator.addMethod("lettersonly", function(value, element) {
                return this.optional(element) || /^[A-Za-z ]+$/i.test(value);
            }, "Please enter Letters only");
            $('#myForm').validate({
                rules: {
                    countryCode: {
                        required: true,
                        lettersonly: true,
                        minlength: 2,
                        maxlength: 3,
                    },
                    name: {
                        required: true,
                        lettersonly: true,
                    },

                },
                messages: {
                    countryCode: {
                        required: 'Please Enter Country Code',
                        minlength: 'Please Enter Minimum 2 Letters',
                        maxlength: 'Please Enter Maximum 3 Letters',
                    },
                    name: {
                        required: 'Please Enter Country Name',
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
