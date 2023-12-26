@extends('admin.admin_master')
@section('admin')
    

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">organization</h4>

                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('supplier.all') }}">organization</a></li>
                            <li class="breadcrumb-item active">ADD</li>
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

                            <h4 class="card-title">Add organization </h4><br><br>


                            @if (Session::has('success'))
                                <div class="alert alert-success">
                                    {{ Session::get('success') }}
                                    @php
                                        Session::forget('success');
                                    @endphp
                                </div>
                            @endif
                            <form method="post" class="row g-3" action="{{ route('supplier.store') }}" id="myForm">
                                @csrf

                                <div class="col-6">
                                    <label for="example-text-input" class="form-label">Organization Name<span
                                            class="text-danger">*</span>
                                    </label>
                                    <div class="form-group">
                                        <input name="name" value="{{ old('name') }}" placeholder="Organization Name"
                                            class="form-control" type="text">
                                    </div>
                                </div>
                                <!-- end row -->


                                <div class="col-6">
                                    <label for="example-text-input" class="form-label">Organization Mobile<span
                                            class="text-danger">*</span>
                                    </label>
                                    <div class="form-group">
                                        <input name="mobile_no" value="{{ old('mobile_no') }}" class="form-control"
                                            placeholder="Organization Mobile" type="text">
                                    </div>
                                </div>
                                <!-- end row -->


                                <div class="col-6">
                                    <label for="example-text-input" class="form-label">Organization Email<span
                                            class="text-danger">*</span>
                                    </label>
                                    <div class="form-group">
                                        <input name="email" value="{{ old('email') }}" class="form-control"
                                            placeholder="Organization Email" type="email">
                                    </div>
                                </div>
                                <!-- end row -->


                                <div class="col-6 mb-3">
                                    <label for="example-text-input" class="form-label">Organization
                                        Address<span class="text-danger">*</span>
                                    </label>
                                    <div class="form-group">
                                        <input name="address" value="{{ old('address') }}" class="form-control"
                                            placeholder="Organization Address" type="text">
                                    </div>
                                </div>
                                <!-- end row -->




                                <div class="text-center">
                                    <input type="submit" class="btn btn-info waves-effect waves-light"
                                        value="Add Organization">
                                </div>
                            </form>



                        </div>
                    </div>
                </div> <!-- end col -->
            </div>



        </div>
    </div>
    <script>
        function isName(name) {
            let regex = /^[a-zA-Z ]+$/;
            return regex.test(name);
        }

        function isEmail(email) {
            let regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return regex.test(email);
        }

        function isCompanyEmail(email) {
            let regex =
                /gmail.com|hotmail.com|yopmail.com|hotmail.com|yahoo.com|gmail.con|gmail|mail.ru|hotmail|yahoo|gmail..com|outlook.com|mail.com|AOL.com|aol.com|yandex.com|gmx.com/g;
            return regex.test(email);
        }

        function isPhoneNo(phone_no) {
            let regex = /^\d*(?:\.\d{1,2})?$/;
            return regex.test(phone_no);
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            jQuery.validator.addMethod("phoneUS", function(phone_number, element) {
                phone_number = phone_number.replace(/\s+/g, "");
                return this.optional(element) || phone_number.match(/^\d*(?:\.\d{1,2})?$/);
            }, "Please a valid phone number");
           
            jQuery.validator.addMethod("lettersonly", function(value, element) {
                return this.optional(element) || /^[A-Za-z ]+$/i.test(value);
            }, "Please enter Letters only");

            jQuery.validator.addMethod("isCompanyEmail", function(email, element) {
                email = email.replace(
                    /gmail.com|hotmail.com|yopmail.com|hotmail.com|yahoo.com|gmail.con|gmail|mail.ru|hotmail|yahoo|gmail..com|outlook.com|mail.com|AOL.com|aol.com|yandex.com|gmx.com/g,
                    "");
                return this.optional(element) || email.match(
                    /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);
            }, "Please Enter a Organizaation Email");
            $('#myForm').validate({
                rules: {
                    name: {
                        required: true,
                        lettersonly: true,
                    },
                    mobile_no: {
                        required: true,
                        phoneUS: true,
                        minlength: 10,
                        maxlength: 10,
                    },
                    email: {
                        required: true,
                        // isCompanyEmail: true,
                    },
                    address: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: 'Please Enter Organization Name',
                    },
                    mobile_no: {
                        required: 'Please Enter Organization Mobile Number',
                        minlength: 'Please Enter 10 Digit Mobile Number',
                        maxlength: 'Please Enter 10 Digit Mobile Number',
                    },
                    email: {
                        required: 'Please Enter Organization Email',
                    },
                    address: {
                        required: 'Please Enter Organization Address',
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
