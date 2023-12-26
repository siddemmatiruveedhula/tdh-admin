@extends('admin.admin_master')
@section('admin')
   

    <style>
        
    </style>

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Assign Pjp</h4>

                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('assign_pjp.index') }}">Assign Pjp</a></li>
                            <li class="breadcrumb-item active">Add</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Add Assign Pjp</h4><br><br>
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

                            @if (Session::has('success'))
                                <div class="alert alert-success">
                                    {{ Session::get('success') }}
                                    @php
                                        Session::forget('success');
                                    @endphp
                                </div>
                            @endif


                            <form method="post" class="row g-3" action="{{ route('assign_pjp.store') }}" id="myForm">
                                @csrf

                                <div class="col-4">
                                    <label for="example-text-input" class="form-label">Date <span
                                            class="text-danger">*</span></label>
                                    <div class="form-group ">
                                        <input name="date" class="form-control" id="date_picker" type="date"
                                            value="{{ $date }}">
                                        @if ($errors->has('date'))
                                            <span class="text-danger">{{ $errors->first('date') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label for="example-text-input" class="form-label">Employee<span
                                            class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <select name="employee_id" id="employee-dropdown" class="form-select select2">
                                            <option value="">--Select Employee --</option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}"
                                                    {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                                    {{ $employee->name }} 
                                                    @if ($employee->role_id)
                                                        ({{ $employee->role->name }})
                                                    @else
                                                        {{ null }}
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <label for="example-text-input" class="form-label">Beats <span
                                            class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <select name="beat_id[]" id="beat-dropdown" class="filter-multi-select" multiple>
                                            {{-- <option value="">--Select Beats --</option> --}}
                                            @foreach ($beats as $beat)
                                                <option value="{{ $beat->id }}"
                                                    {{ old('beat_id') == $beat->id ? 'selected' : '' }}>
                                                    {{ $beat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-4">
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
                                    <input type="submit" class="btn btn-info waves-effect waves-light" value="Add">
                                </div>

                            </form>



                        </div>
                    </div>
                </div> <!-- end col -->
            </div>



        </div>
    </div>
    <script language="javascript">
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();

        today = yyyy + '-' + mm + '-' + dd;
        $('#date_picker').attr('min', today);
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    employee_id: {
                        required: true,
                    },
                    beat_id: {
                        required: true,
                    },
                    status: {
                        required: true,
                    },

                },
                messages: {
                    name: {
                        required: 'Please Enter Your Name',
                    },
                    employee_id: {
                        required: 'Please Select Employee',
                    },
                    beat_id: {
                        required: 'Please Select Beat',
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
