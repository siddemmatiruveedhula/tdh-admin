@inject('carbon', 'Carbon\Carbon')
@extends('admin.admin_master')
@section('admin')
   

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Vehicle</h4>

                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('vehicles.all') }}">Vehicle</a></li>
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

                            <h4 class="card-title">Update a Vehicle</h4><br><br>



                            <form method="post" class="row g-3" action="{{ route('vehicles.update') }}" id="myForm">
                                @csrf

                                <input type="hidden" name="id" value="{{ $vehicle->id }}">
                                <div class="col-12">
                                    <label for="example-text-input" class="form-label">Driver Name<span
                                            class="text-danger">*</span> </label>
                                    <div class="form-group ">
                                        <input name="driver_name" class="form-control" type="text" placeholder="Name"
                                            value="{{ old('driver_name', $vehicle->driver_name) }}">
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="col-12">
                                    <label for="example-text-input" class="form-label">Driver Mobile<span
                                            class="text-danger">*</span></label>
                                    <div class="form-group ">
                                        <input name="driver_phone" class="form-control" type="text"
                                            placeholder="Mobile Number"
                                            value="{{ old('driver_phone', $vehicle->driver_phone) }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="example-text-input" class="form-label">Vehicle Type <span
                                            class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <select name="vehicle_type_id" id="vehicle_type_id" class="form-select select2">
                                            <option value="">--Select Vehicle Type --</option>
                                            @foreach ($vehicleTypes as $vehicleType)
                                                <option value="{{ $vehicleType->id }}"
                                                    {{ old('vehicle_type_id', $vehicle->vehicle_type_id) == $vehicleType->id ? 'selected' : '' }}>
                                                    {{ $vehicleType->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="example-text-input" class="form-label">Transportation <span
                                            class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <select name="transportation_id" id="transportation_id" class="form-select select2">
                                            <option value="">--Select Transportation --</option>
                                            @foreach ($transportations as $transportation)
                                                <option value="{{ $transportation->id }}"
                                                    {{ old('transportation_id', $vehicle->transportation_id) == $transportation->id ? 'selected' : '' }}>
                                                    {{ $transportation->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="example-text-input" class="form-label">Vehicle Number<span
                                            class="text-danger">*</span></label>
                                    <div class="form-group ">
                                        <input name="vehicle_number" class="form-control" type="text"
                                            placeholder="Vehicle Number"
                                            value="{{ old('vehicle_number', $vehicle->vehicle_number) }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="example-text-input" class="form-label">Check in Date<span
                                            class="text-danger">*</span></label>
                                    <div class="form-group ">

                                        <input name="check_in_date" id="vehicle_check_in_date"
                                            class="checkdatetimepicker form-control" type="text"
                                            value="{{ old('check_in_date', $carbon::parse($vehicle->check_in_date)->format('d-m-Y')) }}">

                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="example-text-input" class="form-label">Check in Time<span
                                            class="text-danger">*</span></label>
                                    <div class="form-group ">

                                        <input name="check_in_time" id="check_in_time" class="timeinpicker form-control"
                                            type="text" value="{{ old('check_in_time', $vehicle->check_in_time) }}">

                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="example-text-input" class="form-label">Check Out Date<span
                                            class="text-danger">*</span></label>
                                    <div class="form-group ">
                                        @if (!empty($vehicle->check_out_date))
                                            <input name="check_out_date" id="vehicle_check_out_date"
                                                class="checkOutdatetimepicker form-control" type="text"
                                                value="{{ old('check_out_date', $carbon::parse($vehicle->check_out_date)->format('d-m-Y')) }}">
                                        @else
                                            <input name="check_out_date" id="check_out_date"
                                                class="form-control" type="text"
                                                value="{{ old('check_out_date', $vehicle->check_out_date) }}" readonly>
                                        @endif

                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="example-text-input" class="form-label">Check Out Time<span
                                            class="text-danger">*</span></label>
                                    <div class="form-group ">

                                        @if ($vehicle->check_out_time != null)
                                            <input name="check_out_time" id="check_out_time"
                                                class="timeinpicker form-control" type="text"
                                                value="{{ old('check_out_time', $vehicle->check_out_time) }}">
                                        @else
                                            <input name="check_out_time" id="check_out_time"
                                                class="form-control" type="text"
                                                value="{{ old('check_out_time', $vehicle->check_out_time) }}" readonly>
                                        @endif


                                    </div>
                                </div>


                                <div class="text-center">
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

            // $('#vehicle_type_id option:not(:selected)').attr('disabled', true);

            jQuery.validator.addMethod("noSpace", function(value, element) {
                return value.indexOf(" ") < 0 && value != "";
            }, "No space please and don't leave it empty");
            jQuery.validator.addMethod("phoneUS", function(phone_number, element) {
                phone_number = phone_number.replace(/\s+/g, "");
                return this.optional(element) || phone_number.match(/^\d*(?:\.\d{1,2})?$/);
            }, "Please enter a valid phone number");
            $.validator.addMethod("alpha", function(value, element) {
                return this.optional(element) || value == value.match(/^[a-zA-Z\s]+$/);
            }, 'Please enter letters only');
            $('#myForm').validate({
                rules: {
                    driver_name: {
                        required: true,
                        alpha: true,
                    },
                    driver_phone: {
                        required: true,
                        phoneUS: true,
                        minlength: 10,
                        maxlength: 10,
                    },
                    vehicle_type_id: {
                        required: true,
                    },
                    transportation_id: {
                        required: true,
                    },
                    vehicle_number: {
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
                    driver_name: {
                        required: 'Please Enter Driver Name',
                    },
                    driver_phone: {
                        required: 'Please Enter  Mobile Number',
                        maxlength: 'Please Enter  10 digits only',
                        minlength: 'Please Enter  10 digits only',
                    },
                    vehicle_type_id: {
                        required: 'Please Select Vehicle Type',
                    },
                    transportation_id: {
                        required: 'Please Select Transportation',
                    },
                    vehicle_number: {
                        required: 'Please Enter Vehicle Number',
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
