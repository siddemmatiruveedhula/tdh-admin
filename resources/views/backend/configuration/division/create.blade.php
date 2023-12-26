@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Division</h4>

                        </div>
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('division.index') }}">Division</a></li>
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

                                <h4 class="card-title">Add Division</h4><br><br>
                                @if (Session::has('success'))
                                    <div class="alert alert-success">
                                        {{ Session::get('success') }}
                                        @php
                                            Session::forget('success');
                                        @endphp
                                    </div>
                                @endif


                                <form method="post" class="row g-3" action="{{ route('division.store') }}" id="myForm">
                                    @csrf

                                    <div class="col-6">
                                        <label for="example-text-input" class="col-form-label">Name <span
                                                class="text-danger">*</span></label>
                                        <div class="form-group col-sm-12">
                                            <input name="name" class="form-control" type="text"
                                                value="{{ old('name') }}">
                                            @if ($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <label for="example-text-input" class="col-form-label">Departments<span
                                                class="text-danger">*</span></label>
                                        <div class="form-group col-sm-12">
                                            <select name="department_id" class="form-select select2"
                                                aria-label="Select supplier">
                                                <option value="">--Select Department--</option>
                                                @forelse ($departments as $department)
                                                    <option value="{{ $department->id }}"
                                                        {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                                        {{ $department->name }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="example-text-input" class="col-form-label">Status<span
                                                class="text-danger">*</span></label>
                                        <div class="form-group col-sm-12">
                                            <select name="status" class="form-select" aria-label="Select status">
                                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active
                                                </option>
                                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="text-left">
                                        <input type="submit" class="btn btn-info waves-effect waves-light"
                                            value="Add Division">
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
                        department_id: {
                            required: true,
                        },
                        status: {
                            required: true,
                        },

                    },
                    messages: {
                        name: {
                            required: 'Please Enter Division Name',
                        },
                        department_id: {
                            required: 'Please Select Department',
                        },
                        status_id: {
                            required: 'Please Select Status',
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
