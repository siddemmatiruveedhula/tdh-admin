@extends('admin.admin_master')
@section('admin')

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">holiday</h4>

                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('holiday.index') }}">holiday</a></li>
                            <li class="breadcrumb-item active">UPDATE</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Update Holiday </h4><br><br>
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
                            <form method="post" class="row g-3" action="{{ route('holiday.update', $holiday->id) }}"
                                id="myForm" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="col-6">
                                    <label for="example-text-input" class="form-label">From Date<span
                                            class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <input name="from_date" value="{{ old('from_date', $holiday->from_date) }}" class="form-control example-date-input" type="date" id="from_date">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="example-text-input" class="form-label">To Date<span
                                            class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <input name="to_date" value="{{ old('to_date', $holiday->to_date) }}" class="form-control example-date-input" type="date" id="to_date">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="example-text-input" class="form-label"> Reason <span
                                            class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input name="reason" value="{{ old('reason', $holiday->reason) }}" class="form-control"
                                            type="text" placeholder="Reason">
                                    </div>
                                </div>
                                <div class="text-left">
                                    <input type="submit" class="btn btn-info waves-effect waves-light" value="Update">
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
