@extends('admin.admin_master')
@section('admin')
   

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Storage</h4>

                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('storage.all') }}">Storage</a></li>
                            <li class="breadcrumb-item active">ADD</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Add Storage </h4><br><br>

                            @if (Session::has('success'))
                                <div class="alert alert-success">
                                    {{ Session::get('success') }}
                                    @php
                                        Session::forget('success');
                                    @endphp
                                </div>
                            @endif

                            <form method="post" action="{{ route('storage.store') }}" id="myForm">
                                @csrf

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label"> Name<span
                                            class="text-danger">*</span> </label>
                                    <div class="form-group col-sm-10">
                                        <input name="name" class="form-control" type="text"
                                            value="{{ old('name') }}">
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Storage Type <span
                                            class="text-danger">*</span> </label>
                                    <div class="form-group col-sm-10">
                                        <select name="storage_type_id" class="form-select select2">
                                            <option value="">--Select Storage Type --</option>
                                            @foreach ($storageTypes as $storageType)
                                                <option value="{{ $storageType->id }}"
                                                    {{ old('storage_type_id') == $storageType->id ? 'selected' : '' }}>
                                                    {{ $storageType->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">No of Product Types
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="form-group col-sm-10">
                                        <input name="no_of_products_types" value="{{ old('no_of_products_types') }}" class="form-control" type="text">
                                    </div>
                                </div>
                                <!-- end row -->


                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Capacity <span
                                            class="text-danger">*</span>
                                    </label>
                                    <div class="form-group col-sm-10">
                                        <input name="capacity" value="{{ old('capacity') }}" class="form-control" type="text">
                                    </div>
                                </div>
                                <!-- end row -->


                                <div class="row mb-3">
                                    <label for="status" class="col-sm-2 col-form-label">Status <span
                                            class="text-danger">*</span></label>
                                    <div class="form-group col-sm-10">
                                        <select name="status" class="form-select" aria-label="Select Status">
                                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="text-left">
                                    <input type="submit" class="btn btn-info waves-effect waves-light" value="Add Storage">
                                </div>


                            </form>



                        </div>
                    </div>
                </div> <!-- end col -->
            </div>



        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            jQuery.validator.addMethod('numericOnly', function(value) {
                return value == "" || /^[0-9]+$/.test(value);
            }, 'Please only enter numeric values (0-9)');
           
            jQuery.validator.addMethod("nonNumeric", function(value, element) {
                return this.optional(element) || isNaN(Number(value));
            }, "Please enter letters or Alphanumeric");
            $('#myForm').validate({

                rules: {
                    name: {
                        required: true,
                        nonNumeric: true,
                    },
                    storage_type_id: {
                        required: true,
                    },
                    no_of_products_types: {
                        required: true,
                        numericOnly: true,
                    },
                    capacity: {
                        required: true,
                        numericOnly: true,
                    },

                },
                messages: {
                    name: {
                        required: 'Please enter Product Name',
                    },
                    storage_type_id: {
                        required: 'Please Select Storage Type',
                    },
                    no_of_products_types: {
                        required: 'Please Enter No of Product Types',
                    },
                    capacity: {
                        required: 'Please Enter Capacity',
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
