@extends('admin.admin_master')
@section('admin')
    

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Customer</h4>
                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('customer.all') }}">Customer</a></li>
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

                            <h4 class="card-title">Add Customer </h4><br><br>

                            <form method="post" class="row g-3" action="{{ route('customer.store') }}" id="myForm"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="alert alert-danger print-city-form-error-msg d-none">
                                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                    <ul>
                                    </ul>
                                </div>

                                <div class="col-4">
                                    <label for="example-text-input" class="form-label"> Name<span
                                            class="text-danger">*</span> </label>
                                    <div class="form-group ">
                                        <input name="name" class="form-control" type="text" placeholder="Name"
                                            value="{{ old('name') }}">
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="col-4">
                                    <label for="example-text-input" class="form-label"> Customer Code</label>
                                    <div class="form-group ">
                                        <input name="customer_code" class="form-control" type="text"
                                            placeholder="Customer Code" value="{{ old('customer_code') }}">
                                    </div>
                                </div>
                                <!-- end row -->
                                <div class="col-4">
                                    <label for="example-text-input" class="form-label"> Customer Alias</label>
                                    <div class="form-group ">
                                        <input name="customer_alias" class="form-control" type="text"
                                            placeholder="Customer Alias" value="{{ old('customer_alias') }}">
                                    </div>
                                </div>
                                <!-- end row -->


                                <div class="col-4">
                                    <label for="example-text-input" class="form-label"> Mobile </label>
                                    <div class="form-group ">
                                        <input name="mobile_no" class="form-control" type="text"
                                            placeholder="Phone Number" value="{{ old('mobile_no') }}">
                                    </div>
                                </div>
                                <!-- end row -->


                                {{-- <div class="col-4">
                                    <label for="example-text-input" class="form-label"> Email<span
                                            class="text-danger">*</span> </label>
                                    <div class="form-group ">
                                        <input name="email" class="form-control" type="email" placeholder="Email"
                                            value="{{ old('email') }}">
                                    </div>
                                </div>
                                <!-- end row -->
                                <div class="col-4">
                                    <label for="example-text-input" class="form-label"> Password <span
                                            class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <input name="password" class="form-control" type="password" placeholder="Password"
                                            value="{{ old('password') }}">

                                    </div>
                                </div> --}}


                                <div class="col-4">
                                    <label for="example-text-input" class="form-label"> Address<span
                                            class="text-danger">*</span> </label>
                                    <div class="form-group ">
                                        <input name="address" class="form-control" type="text" placeholder="Address"
                                            value="{{ old('address') }}">
                                    </div>
                                </div>
                                <!-- end row -->
                                <div class="col-4">
                                    <label for="example-text-input" class="form-label"> Pin Code </label>
                                    <div class="form-group ">
                                        <input name="pin_code" class="form-control" type="text" placeholder="Pin Code"
                                            value="{{ old('pin_code') }}">
                                    </div>
                                </div>
                                <!-- end row -->


                                {{-- <div class="col-4">
                                    <label for="example-text-input" class="form-label"> Discount Amount</label>
                                    <div class="form-group ">
                                        <input name="discount_amount" class="form-control" type="text"
                                            placeholder="Discount Amount" value="{{ old('discount_amount') }}">
                                    </div>
                                </div>
                                <!-- end row --> --}}


                                <div class="col-4">
                                    <label for="example-text-input" class="form-label"> Credit Limit </label>
                                    <div class="form-group ">
                                        <input name="credit_limit" class="form-control" type="text"
                                            placeholder="Credit Limit" value="{{ old('credit_limit') }}">
                                    </div>
                                </div>
                                <!-- end row -->


                                <div class="col-4">
                                    <label for="example-text-input" class="form-label"> Credit Duration</label>
                                    <div class="form-group ">
                                        <input name="credit_duration" class="form-control" type="text"
                                            placeholder="Credit Duration" value="{{ old('credit_duration') }}">
                                    </div>
                                </div>
                                <!-- end row -->
                                <div class="col-4">
                                    <label for="example-text-input" class="form-label"> GST Number</label>
                                    <div class="form-group">
                                        <input name="gst_no" class="form-control" type="text"
                                            placeholder="GST Number" value="{{ old('gst_no') }}">
                                    </div>
                                </div>
                                <!-- end row -->


                                {{-- <div class="col-4">
                                    <label for="example-text-input" class="form-label">Distributor CST</label>
                                    <div class="form-group">
                                        <input name="distributor_cst" class="form-control" type="text"
                                            placeholder="Distributor CST" value="{{ old('distributor_cst') }}">
                                    </div>
                                </div>
                                <!-- end row -->


                                <div class="col-4">
                                    <label for="example-text-input" class="form-label">LBT Number</label>
                                    <div class="form-group">
                                        <input name="lbt_no" class="form-control" type="text"
                                            placeholder="LBT Number" value="{{ old('lbt_no') }}">
                                    </div>
                                </div>
                                <!-- end row --> --}}

                                <div class="col-4">
                                    <label for="example-text-input" class="form-label">Customer Type <span
                                            class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <select name="customer_type" id="customer_type" class="form-select select2">
                                            <option value="">--Select Customer Type--</option>
                                            @foreach ($customerRoles as $customerRole)
                                                <option value="{{ $customerRole->id }}"
                                                    {{ old('customer_type') == $customerRole->id ? 'selected' : '' }}>
                                                    {{ $customerRole->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label for="example-text-input" class="form-label">Customer Category Type
                                    </label>
                                    <div class="form-group">
                                        <select name="customer_category_type" id="customer_category_type"
                                            class="form-select select2">
                                            <option value="">--Select Customer --</option>
                                            @foreach ($customerCategoryTypes as $customerCategoryType)
                                                <option value="{{ $customerCategoryType->id }}"
                                                    {{ old('customer_category_type') == $customerCategoryType->id ? 'selected' : '' }}>
                                                    {{ $customerCategoryType->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label for="example-text-input" class="form-label">Beat
                                        {{-- <span class="text-danger">*</span> --}}
                                    </label>
                                    <div class="form-group">
                                        <select name="beat_id" id="beat_id" class="form-select select2">
                                            <option value="">--Select Beat--</option>
                                            @foreach ($beats as $beat)
                                                <option value="{{ $beat->id }}"
                                                    {{ old('beat_id') == $beat->id ? 'selected' : '' }}>
                                                    {{ $beat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label for="example-text-input" class="form-label">Country<span
                                            class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <select name="country_id" id="country-dropdown" class="form-select select2">
                                            <option value="">--Select Country--</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}"
                                                    {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                                    {{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label for="example-text-input" class="form-label">State<span
                                            class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <select name="state_id" id="state-dropdown" class="form-select select2">
                                            <option value="">--Select State--</option>
                                            {{-- @foreach ($states as $state)
                                                <option value="{{ $state->id }}"
                                                    {{ old('state_id') == $state->id ? 'selected' : '' }}>
                                                    {{ $state->name }}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>

                                </div>
                                <div class="col-4">
                                    <label for="example-text-input" class="form-label">District <span
                                            class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <select name="district_id" id="district-dropdown" class="form-select select2">
                                            <option value="">-- Select District --</option>
                                            {{-- @foreach ($districts as $district)
                                                <option value="{{ $district->id }}"
                                                    {{ old('district') == $district->id ? 'selected' : '' }}>
                                                    {{ $district->name }}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>

                                </div>
                                <div class="col-4">
                                    <label for="example-text-input" class="form-label">City </label>
                                    <div class="form-group">
                                        <select name="city_id" id="city-dropdown" class="form-select select2">
                                            <option value="">--Select City --</option>
                                            {{-- @foreach ($cities as $city)
                                                <option value="{{ $city->id }}"
                                                    {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                                    {{ $city->name }}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>

                                </div>


                                <div class="col-4">
                                    <label for="example-text-input" class="form-label">Area </label>
                                    <div class="form-group">
                                        <select name="area_id" id="area-dropdown" class="form-select select2">
                                            <option value="">--Select Area --</option>
                                            {{-- @foreach ($areas as $areas)
                                                <option value="{{ $areas->id }}"
                                                    {{ old('area_id') == $areas->id ? 'selected' : '' }}>
                                                    {{ $areas->name }}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>

                                </div>

                                <div class="col-4">
                                    <label for="example-text-input" class="form-label">Discount % </label>
                                    <div class="form-group">
                                        <input name="discount" class="form-control" type="text"
                                            placeholder="Discount" value="{{ old('discount') }}">

                                    </div>

                                </div>


                                <div class="col-4">
                                    <label for="example-text-input" class="form-label">FSSAI No </label>
                                    <div class="form-group">

                                        <input name="fssai_no" class="form-control" type="text"
                                            placeholder="FSSAI No" value="{{ old('fssai_no') }}">
                                    </div>

                                </div>
                                <div class="col-4">
                                    <label for="example-text-input" class="form-label">Parent Hierarchy</label>
                                    <div class="form-group">
                                        <select name="parent_hierarchy_id" id="area-dropdown"
                                            class="form-select select2">
                                            <option value="">--Select Distributor/Delaer --</option>
                                            @foreach ($distributor_dealers as $distributor_dealer)
                                                <option value="{{ $distributor_dealer->id }}"
                                                    {{ old('parent_hierarchy_id') == $distributor_dealer->id ? 'selected' : '' }}>
                                                    {{ $distributor_dealer->name }}({{ $distributor_dealer->role->name }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                                <div class="col-4">
                                    <label for="example-text-input" class="form-label">Communicating Person</label>
                                    <div class="form-group">

                                        <input name="communicating_person" class="form-control" type="text"
                                            placeholder="Communicating Person" value="{{ old('communicating_person') }}">
                                    </div>

                                </div>

                                <div class="col-4">
                                    <label for="example-text-input" class="form-label">Default SO
                                        {{-- <span class="text-danger">*</span> --}}
                                    </label>
                                    <div class="form-group">
                                        <select name="default_so" id="default_so" class="form-select select2">
                                            <option value="">--Select Default SO --</option>
                                            @foreach ($defaultSos as $defaultSo)
                                                <option value="{{ $defaultSo->id }}"
                                                    {{ old('default_so') == $defaultSo->id ? 'selected' : '' }}>
                                                    {{ $defaultSo->name }}
                                                    @if ($defaultSo->role_id)
                                                        ({{ $defaultSo->role->name }})
                                                    @else
                                                        {{ null }}
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <label for="example-text-input" class="form-label"> Image </label>
                                    <div class="form-group ">
                                        <input name="customer_image" class="form-control" type="file" id="image">
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="col-4">
                                    <label for="example-text-input" class="form-label"> </label>
                                    <div class="">
                                        <img id="showImage" class="rounded avatar-lg"
                                            src="{{ url('upload/no_image.jpg') }}" alt="Card image cap">
                                    </div>
                                </div>
                                <!-- end row -->
                                <div class="text-center">
                                    <input type="submit" id="add_customer" class="btn btn-info waves-effect waves-light"
                                        value="Add Customer">
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
            jQuery.validator.addMethod("noSpace", function(value, element) {
                return value.indexOf(" ") < 0 && value != "";
            }, "No space please and don't leave it empty");

            jQuery.validator.addMethod("phoneUS", function(phone_number, element) {
                phone_number = phone_number.replace(/\s+/g, "");
                return this.optional(element) || phone_number.match(/^\d*(?:\.\d{1,2})?$/);
            }, "Please enter a valid phone number");

            jQuery.validator.addMethod('numericOnly', function(value) {
                return value == "" || /^[0-9]+$/.test(value);
            }, 'Please only enter numeric values (0-9)');

            jQuery.validator.addMethod("valdiateDiscount", function(value, element) {
                var defaultValue = parseInt(100);
                var discountValue = parseInt(value);
                return value == "" || discountValue < defaultValue;
            }, 'Discount should be less than 100');

            jQuery.validator.addMethod("strongePassword", function(value) {
                    return value == "" || /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) && /[a-z]/.test(value) && /\d/.test(value) ||
                        /[A-Z]/.test(value);
                },
                "Please enter Alphanumeric"
            );

            jQuery.validator.addMethod("nonNumeric", function(value) {
                    return value == "" || /[a-z]/.test(value) || /[a-z]/.test(value) && /\d/.test(value) ||
                        /[A-Z]/.test(value) || /[A-Z]/.test(value) && /\d/.test(value);
                },
                "Please enter Letters or Alphanumeric only"
            );

            jQuery.validator.addMethod('allowDecimal', function(value) {
                return value == "" || /^[0-9\.]+$/.test(value);
            }, 'Please Enter Only Numeric Values (0-9)');

            $('#myForm').validate({
                rules: {
                    name: {
                        required: true,
                        nonNumeric: true,
                    },
                    mobile_no: {
                        phoneUS: true,
                        minlength: 10,
                        maxlength: 10,
                    },
                    // password: {
                    //     required: true,
                    //     minlength: 4,
                    // },
                    // email: {
                    //     required: true,
                    // },
                    gst_no: {
                        // required: true,
                        strongePassword: true,
                        minlength: 15,
                        maxlength: 15,
                    },
                    address: {
                        required: true,
                    },
                    discount: {
                        allowDecimal: true,
                        step: 0.01,
                        valdiateDiscount: true,
                    },
                    pin_code: {
                        numericOnly: true,
                        minlength: 6,
                        maxlength: 6,
                    },
                    credit_limit: {
                        numericOnly: true,
                    },
                    credit_duration: {
                        numericOnly: true,
                    },
                    country_id: {
                        required: true,
                    },
                    state_id: {
                        required: true,
                    },
                    district_id: {
                        required: true,
                    },
                    customer_type: {
                        required: true,
                    },
                    fssai_no: {
                        numericOnly: true,
                        minlength: 14,
                        maxlength: 14,
                    },
                    customer_alias: {
                        nonNumeric: true,
                    },
                    communicating_person: {
                        nonNumeric: true,
                    },

                },
                messages: {
                    name: {
                        required: 'Please Enter Customer Name',
                    },
                    mobile_no: {
                        minlength: 'Please Enter 10 digit Mobile Number',
                        maxlength: 'Please Enter 10 digit Mobile Number',
                    },
                    // email: {
                    //     required: 'Please Enter  Email',
                    // },
                    // password: {
                    //     required: 'Please Enter Password',
                    //     minlength: 'Password length must be greater than or equal to 4',
                    // },
                    address: {
                        required: 'Please Enter Your Address',
                    },
                    discount: {
                        step: 'It must include two decimal places',
                    },
                    gst_no: {
                        // required: 'Please Enter GST Number',
                        minlength: 'Please enter 15 Digit Valid Alpha Numeric GST Number',
                        maxlength: 'Please enter 15 Digit Valid Alpha Numeric GST Number',
                    },
                    pin_code: {
                        minlength: 'pincode should be 6 digits only',
                        maxlength: 'pincode should be 6 digits only',
                    },
                    country_id: {
                        required: 'Please Select Country',
                    },
                    state_id: {
                        required: 'Please Select State',
                    },
                    district_id: {
                        required: 'Please Select District',
                    },
                    customer_type: {
                        required: 'Please Select Customer Type',
                    },
                    fssai_no: {
                        minlength: 'Please Enter 14 digit FSSAI Number',
                        maxlength: 'Please Enter 14 digit FSSAI Number',
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
                    $('select').on('change', function() {
                        if ($('#country-dropdown').val()) {
                            $('#country-dropdown').removeClass('is-invalid');
                        } else {
                            $('#country-dropdown').addClass('is-invalid');
                        }
                        if ($('#state-dropdown').val()) {
                            $('#state-dropdown').removeClass('is-invalid');
                        } else {
                            $('#state-dropdown').addClass('is-invalid');
                        }
                        if ($('#district-dropdown').val()) {
                            $('#district-dropdown').removeClass('is-invalid');
                        } else {
                            $('#district-dropdown').addClass('is-invalid');
                        }

                    });
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: "/customer/store",
                        type: "POST",
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: new FormData(form),
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function() {
                            $(".print-city-form-error-msg").addClass('d-none');
                        },
                        success: function(data) {
                            $("#add_customer").on('click');
                            if ($.isEmptyObject(data.error)) {
                                var url = "{{ route('customer.all') }}";
                                window.location.href = url;
                                toastr.success(data.message,
                                    'Customer Inserted successfully!');
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
                    return false;
                }
            });
        });
    </script>


    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
    <script>
        $(document).ready(function() {

            /*------------------------------------------
            --------------------------------------------
            Country Dropdown Change Event
            --------------------------------------------
            --------------------------------------------*/
            $('#country-dropdown').on('change', function() {
                var idCountry = this.value;
                $("#state-dropdown").html('');
                $.ajax({
                    url: "{{ url('api/fetch-states') }}",
                    type: "POST",
                    data: {
                        country_id: idCountry,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#state-dropdown').html(
                            '<option value="">-- Select State --</option>');
                        $.each(result.states, function(key, value) {
                            $("#state-dropdown").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                        $('#district-dropdown').html(
                            '<option value="">-- Select District --</option>');
                        $('#city-dropdown').html('<option value="">-- Select City --</option>');
                    }
                });
            });

            /*------------------------------------------
            --------------------------------------------
            State Dropdown Change Event
            --------------------------------------------
            --------------------------------------------*/
            $('#state-dropdown').on('change', function() {
                var idState = this.value;
                $("#district-dropdown").html('');
                $.ajax({
                    url: "{{ url('api/fetch-districts') }}",
                    type: "POST",
                    data: {
                        state_id: idState,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(res) {
                        $('#district-dropdown').html(
                            '<option value="">-- Select District --</option>');
                        $.each(res.districts, function(key, value) {
                            $("#district-dropdown").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                    }
                });
            });


            /*------------------------------------------
             --------------------------------------------
             District Dropdown Change Event
             --------------------------------------------
             --------------------------------------------*/
            $('#district-dropdown').on('change', function() {
                var idDistrict = this.value;
                $("#city-dropdown").html('');
                $.ajax({
                    url: "{{ url('api/fetch-cities') }}",
                    type: "POST",
                    data: {
                        district_id: idDistrict,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(res) {
                        $('#city-dropdown').html('<option value="">-- Select City --</option>');
                        $.each(res.cities, function(key, value) {
                            $("#city-dropdown").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                    }
                });
            });

            $('#city-dropdown').on('change', function() {
                var idCity = this.value;
                $("#area-dropdown").html('');
                $.ajax({
                    url: "{{ url('api/fetch-areas') }}",
                    type: "POST",
                    data: {
                        city_id: idCity,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(res) {
                        $('#area-dropdown').html(
                            '<option value="">-- Select Areas --</option>');
                        $.each(res.areas, function(key, value) {
                            $("#area-dropdown").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                    }
                });
            });

        });
    </script>
@endsection
