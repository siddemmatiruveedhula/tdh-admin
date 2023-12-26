@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Holidays</h4>

                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('holiday.index') }}">Holidays</a></li>
                            <li class="breadcrumb-item active">Add</li>
                        </ol>
                    </nav>
                </div>
            </div>
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
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Add Holiday</h4><br><br>

                            <form method="post" class="row g-3" action="{{ route('holiday.store') }}" id="myForm">
                                @csrf
                                <div class="col-6">
                                    <label for="example-text-input" class="col-form-label">From Date
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="form-group col-sm-12">
                                        <input name="from_date" class="form-control example-date-input" type="date" id="from_date"
                                            value="{{ old('from_date') }}">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="example-text-input" class="col-form-label">To Date
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="form-group col-sm-12">
                                        <input name="to_date" class="form-control example-date-input" type="date" id="to_date"
                                        value="{{ old('to_date') }}">
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label for="example-text-input" class="col-form-label">Reason <span
                                            class="text-danger">*</span></label>
                                    <div class="form-group col-sm-12">
                                        <input name="reason" class="form-control" type="text"
                                            placeholder="reason" value="{{ old('reason') }}">
                                    </div>
                                </div>

                                <div class="text-left">
                                    <input type="submit" id="add_payment" class="btn btn-info waves-effect waves-light"
                                        value="Add Holiday">
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
            $('#myForm').validate({
                rules: {
                    from_date: {
                        required: true,
                    },
                    to_date: {
                        required: true,
                    },
                    reason: {
                        required: true,
                    },
                },
                messages: {
                    from_date: {
                        required: 'Please Select From Date',
                    },
                    to_date: {
                        required: 'Please Select To Date',
                    },
                    reason: {
                        required: 'Please Enter Reason',
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
