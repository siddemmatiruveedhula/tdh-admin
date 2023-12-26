@inject('carbon', 'Carbon\Carbon')
@extends('admin.admin_master')
@section('admin')
    

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Visitor</h4>

                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('visitor.all') }}">Visitor
                                </a></li>
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

                            <h4 class="card-title">Update a Visitor</h4><br><br>



                            <form method="post" class="row g-3" action="{{ route('visitor.update') }}" id="myForm">
                                @csrf

                                <input type="hidden" name="id" value="{{ $visitor->id }}">
                                <div class="col-12">
                                    <label for="example-text-input" class="form-label">Visitor Name<span
                                            class="text-danger">*</span> </label>
                                    <div class="form-group ">
                                        <input name="visitor_name" class="form-control" type="text" placeholder="Name"
                                            value="{{ old('visitor_name', $visitor->visitor_name) }}">
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="col-12">
                                    <label for="example-text-input" class="form-label">Visitor Mobile<span
                                            class="text-danger">*</span></label>
                                    <div class="form-group ">
                                        <input name="visitor_phone" class="form-control" type="text"
                                            placeholder="Mobile Number"
                                            value="{{ old('visitor_phone', $visitor->visitor_phone) }}">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="example-text-input" class="form-label">Visitor City<span
                                            class="text-danger">*</span></label>
                                    <div class="form-group ">
                                        <input name="visitor_city" class="form-control" type="text" placeholder="City"
                                            value="{{ old('visitor_city', $visitor->visitor_city) }}">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="example-text-input" class="form-label">Card Number<span
                                            class="text-danger">*</span></label>
                                    <div class="form-group ">
                                        <input name="card_no" class="form-control" type="text" placeholder="Card Number"
                                            value="{{ old('card_no', $visitor->card_no) }}">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="example-text-input" class="form-label">Visitor From<span
                                            class="text-danger">*</span></label>
                                    <div class="form-group ">
                                        <input name="visitor_from" class="form-control" type="text"
                                            placeholder="Visitor From"
                                            value="{{ old('visitor_from', $visitor->visitor_from) }}">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="example-text-input" class="form-label">Agenda<span
                                            class="text-danger">*</span></label>
                                    <div class="form-group ">
                                        <input name="agenda" class="form-control" type="text" placeholder="Agenda"
                                            value="{{ old('agenda', $visitor->agenda) }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="example-text-input" class="form-label">Whom To Meet<span
                                            class="text-danger">*</span></label>
                                    <div class="form-group ">
                                        <input name="whom_to_meet" class="form-control" type="text"
                                            placeholder="Whom To Meet"
                                            value="{{ old('whom_to_meet', $visitor->whom_to_meet) }}">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="example-text-input" class="form-label">Check in Date<span
                                            class="text-danger">*</span></label>
                                    <div class="form-group ">

                                        <input name="check_in_date" id="visitor_check_in_date"
                                            class="checkdatetimepicker form-control" type="text"
                                            value="{{ old('check_in_date', $carbon::parse($visitor->check_in_date)->format('d-m-Y')) }}">

                                    </div>

                                </div>
                                <div class="col-12">
                                    <label for="example-text-input" class="form-label">Check in Time<span
                                            class="text-danger">*</span></label>
                                    <div class="form-group ">
                                        <input name="check_in_time" id="visitor_check_in_time"
                                            class="timeinpicker form-control" type="text"
                                            value="{{ old('check_in_time', $visitor->check_in_time) }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="example-text-input" class="form-label">Check Out Date<span
                                            class="text-danger">*</span></label>
                                    <div class="form-group ">
                                        @if (!empty($visitor->check_out_date))
                                            <input name="check_out_date" id="visitor_check_out_date"
                                                class="checkOutdatetimepicker form-control" type="text"
                                                value="{{ old('check_out_date', $carbon::parse($visitor->check_out_date)->format('d-m-Y')) }}">
                                        @else
                                            <input name="check_out_date" id="check_out_date"
                                                class="form-control" type="text"
                                                value="{{ old('check_out_date', $visitor->check_out_date) }}" readonly>
                                        @endif

                                    </div>
                                </div>


                                <div class="col-12">
                                    <label for="example-text-input" class="form-label">Check Out Time<span
                                            class="text-danger">*</span></label>
                                    <div class="form-group ">
                                        @if ($visitor->check_out_time != null)
                                            <input name="check_out_time" id="visitor_check_out_time"
                                                class="timepicker form-control" type="text"
                                                value="{{ old('check_out_time', $visitor->check_out_time) }}">
                                        @else
                                            <input name="check_out_time" id="visitor_check_out_time"
                                                class="form-control" type="text"
                                                value="{{ old('check_out_time', $visitor->check_out_time) }}" readonly>
                                        @endif



                                    </div>
                                </div>

                                <div class="col-12">

                                    <input class="form-check-input" type="checkbox" name="card_submit" id="card_submit"
                                        value="{{ $visitor->card_submit }}"
                                        @if (old('card_submit', $visitor->card_submit) == '1') checked="checked" @endif>

                                    <label for="card_submit" class="form-label " style="margin-left: 2px"> Card is
                                        Submitted?</label>
                                </div>


                                <div class="text-center">
                                    <input type="submit" id="visitor_submit"
                                        class="btn btn-info waves-effect waves-light" value="Save">
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
            // jQuery.validator.addMethod("valdiateTime", function(value, element) {
            //     var checkInTime = $("#check_in_time").val();
            //     var checkOutTime = $("#check_out_time").val();
            //     // var checkOutTime = value;
            //     var m = checkInTime.match(/^(\d+)[ :,](\d+)$/);
            //     if (m) {
            //         console.log("Hour: " + parseInt(m[1]));
            //         console.log("Minute: " + parseInt(m[2]));
            //     }
            //     // console.log("checkInTime", checkInTime);
            //     // console.log("checkOutTime", value);
            //     return value < checkInTime;
            // }, 'Check Out Time should be greater than to Check In Time');
            if ($('#card_submit').is(':checked')) {
                $('#visitor_submit').removeAttr('disabled');
            } else {
                $('#visitor_submit').attr('disabled', true);
            }
            $('#card_submit').click(function() {
                if ($(this).is(':checked')) {
                    $('#visitor_submit').removeAttr('disabled');
                } else {
                    $('#visitor_submit').attr('disabled', true);
                }
            });
            jQuery.validator.addMethod("noSpace", function(value, element) {
                return value.indexOf(" ") < 0 && value != "";
            }, "No space please and don't leave it empty");
            jQuery.validator.addMethod("phoneUS", function(phone_number, element) {
                phone_number = phone_number.replace(/\s+/g, "");
                return this.optional(element) || phone_number.match(/^\d*(?:\.\d{1,2})?$/);
            }, "Please enter a valid phone number");
            jQuery.validator.addMethod("nonNumeric", function(value) {
                        return value == "" || /[a-z]/.test(value) || /[a-z]/.test(value) && /\d/.test(value) ||
                            /[A-Z]/.test(value) || /[A-Z]/.test(value) && /\d/.test(value);
                    },
                    "Please enter Letters or Alphanumeric only"
                );
            $('#myForm').validate({
                rules: {
                    visitor_name: {
                        required: true,
                        nonNumeric: true,
                    },
                    visitor_phone: {
                        required: true,
                        phoneUS: true,
                        minlength: 10,
                        maxlength: 10,
                    },
                    visitor_city: {
                        required: true,
                    },
                    card_no: {
                        required: true,
                    },
                    visitor_from: {
                        required: true,
                    },
                    agenda: {
                        required: true,
                    },
                    whom_to_meet: {
                        required: true,
                    },
                    check_in_time: {
                        required: true,
                    },
                    check_out_time: {
                        required: true,
                    },
                    check_in_date: {
                        required: true,
                    },
                    check_out_date: {
                        required: true,
                    },



                },
                messages: {
                    visitor_name: {
                        required: 'Please Enter Visitor Name',
                    },
                    visitor_phone: {
                        required: 'Please Enter  Mobile Number',
                        maxlength: 'Please Enter  10 digits only',
                        minlength: 'Please Enter  10 digits only',
                    },
                    visitor_city: {
                        required: 'Please Enter Visitor City',
                    },
                    card_no: {
                        required: 'Please Enter Card Number',
                    },
                    visitor_from: {
                        required: 'Please Enter Visitor From',
                    },
                    agenda: {
                        required: 'Please Enter Agenda',
                    },
                    whom_to_meet: {
                        required: 'Please Enter Whom to Meet',
                    },
                    check_in_time: {
                        required: 'Please Enter  Check in Time',
                    },
                    check_out_time: {
                        required: 'Please Enter  Check Out Time',
                    },
                    check_in_date: {
                        required: 'Please Enter  Check in Date',
                    },
                    check_out_date: {
                        required: 'Please Enter  Check Out Date',
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
