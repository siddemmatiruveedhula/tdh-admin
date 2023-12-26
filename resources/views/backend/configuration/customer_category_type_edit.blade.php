@extends('admin.admin_master')
@section('admin')
    
    <div class="page-content">
        <div class="container-fluid">
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Customer Category Type</h4>

        </div>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('customer-category-type.all') }}">Customer Category Type</a></li>
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

                            <h4 class="card-title">Edit  Customer Category Type Page </h4><br><br>



                            <form method="post" action="{{ route('customer-category-type.update') }}" id="myForm">
                                @csrf

                                <div class="alert alert-danger print-city-form-error-msg d-none">
                                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                    <ul>
                                    </ul>
                                </div>

                                <input type="hidden" name="id" value="{{ $customerCategoryType->id }}">
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label"> Customer Category
                                        Type <span class="text-danger">*</span> </label>
                                    <div class="form-group col-sm-10">
                                        <input name="name" value="{{ $customerCategoryType->name }}" class="form-control"
                                            type="text">
                                    </div>
                                </div>
                                <!-- end row -->


                                <input type="submit" class="btn btn-info waves-effect waves-light"
                                    value="Update Customer Category">
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
                        required: 'Please Enter Customer Category Type',
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
                        url: "{{ route('customer-category-type.update') }}",
                        type: "POST",
                        data: $(form).serialize(),
                        beforeSend: function() {
                            $(".print-city-form-error-msg").addClass('d-none');
                        },
                        success: function(data) {
                            $("#submit_button").on('click');
                            if ($.isEmptyObject(data.error)) {
                                var url = "{{ route('customer-category-type.all') }}";
                                window.location.href = url;
                                toastr.success(data.message, 'Updated successfully!');
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
