@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Leave Type</h4>

                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('leavetype.all') }}">Leave Type</a></li>
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

                            <h4 class="card-title">Add Leave type </h4><br><br>
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
                            <form method="post" class="row g-3" action="{{ route('leavetype.store') }}" name="leavetypeForm"
                                id="leavetypeForm">
                                @csrf

                                <div class="alert alert-danger print-city-form-error-msg d-none">
                                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                    <ul>
                                    </ul>
                                </div>
                                
                                <div class="col-4">
                                    <label for="example-text-input" class="form-label"> Leave Type <span
                                            class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input name="leave_type" value="{{ old('leave_type') }}" class="form-control"
                                            type="text">
                                    </div>
                                </div> <!-- end row -->
                                <div class="col-4">
                                    <label for="example-text-input" class="form-label">Status<span
                                            class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <select name="status" class="form-select" aria-label="Select status">
                                            <option {{ old('status') }} value="1">Active
                                            </option>
                                            <option {{ old('status') }} value="0">Inactive
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="text-left">
                                    <input type="submit" id="leavetype_submit" class="btn btn-info waves-effect waves-light"
                                        value="Add Leave Type">
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#leavetypeForm").validate({
                ignore: ":hidden",
                rules: {
                    leave_type: {
                        required: true,
                    },
                    status: {
                        required: true,
                    },

                },
                messages: {
                    leave_type: {
                        required: 'Please Enter Leave Type',
                    },
                    status: {
                        required: 'Please select Status',
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
                submitHandler: function(form) {
                    $.ajax({
                        url: "/leavetype/store",
                        type: "POST",
                        data: $(form).serialize(),
                        beforeSend: function() {
                            $(".print-city-form-error-msg").addClass('d-none');
                        },
                        success: function(data) {
                            $("#leavetype_submit").on('click');
                            if ($.isEmptyObject(data.error)) {
                                var url = "{{ route('leavetype.all') }}";
                                window.location.href = url;
                                toastr.success(data.message, 'Leave Type Inserted successfully!');
                            } else {
                                $(".print-city-form-error-msg").find("ul").html('');
                                $(".print-city-form-error-msg").removeClass('d-none');
                                $.each(data.error, function(key, value) {
                                    $(".print-city-form-error-msg").find("ul")
                                        .append('<li>' + value + '</li>');
                                    $(".print-city-form-error-msg").attr(
                                            "tabindex", -1)
                                        .focus();
                                });
                            }
                        },
                    });
                    return false; // required to block normal submit since you used ajax
                }
            });

        });
    </script>
@endsection
