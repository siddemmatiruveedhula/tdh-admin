@extends('admin.admin_master')
@section('admin')

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Payment</h4>

                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('payment.index') }}">Payment</a></li>
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

                            <h4 class="card-title">Update Payment </h4><br><br>
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
                            <form method="post" class="row g-3" action="{{ route('payment.update', $payment->id) }}"
                                id="myForm" enctype="multipart/form-data" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="col-6">
                                    <label for="example-text-input" class="form-label">Customer<span
                                            class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <select name="customer_id" id="customer-dropdown" class="form-select select2">
                                            <option value="">--Select Customer --</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}"
                                                    {{ old('customer_id', $payment->customer_id) == $customer->id ? 'selected' : '' }}>
                                                    {{ $customer->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="example-text-input" class="form-label">Mode Of Payment<span
                                            class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <select name="payment_mode" class="form-select select2">
                                            <option value="">--Select Mode Of Payment --</option>
                                            @foreach ($paymentTypes as $ptKey => $ptValue)
                                                <option value="{{ $ptValue }}"
                                                    {{ $ptKey == $payment->payment_mode ? 'selected' : '' }}>
                                                    {{ $ptValue }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="example-text-input" class="form-label"> Payment Ref No. <span
                                            class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input name="payment_ref_no"
                                            value="{{ old('payment_ref_no', $payment->payment_ref_no) }}"
                                            class="form-control" type="text" placeholder="Payment Ref No.">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="example-text-input" class="form-label"> Paid Amount <span
                                            class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input name="paid_amount" value="{{ old('paid_amount', $payment->paid_amount) }}"
                                            class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="example-text-input" class="form-label"> Paid Date <span
                                            class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input name="paid_date" value="{{ old('paid_date', $payment->paid_date) }}"
                                            class="form-control example-date-input" type="date" id="paid_date">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="example-text-input" class="form-label"> Person Name </label>
                                    <div class="form-group">
                                        <input name="person_name" value="{{ old('person_name', $payment->person_name) }}"
                                            class="form-control" placeholder="Person Name" type="text">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="example-text-input" class="form-label"> Phone Number</label>
                                    <div class="form-group">
                                        <input name="phone_number"
                                            value="{{ old('phone_number', $payment->phone_number) }}" class="form-control"
                                            placeholder="Phone Number" type="text">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="example-text-input" class="form-label"> City</label>
                                    <div class="form-group">
                                        <input name="city" value="{{ old('city', $payment->city) }}"
                                            class="form-control" placeholder="City" type="text">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="example-text-input" class="col-form-label">Payment Proof</label>
                                    <div class="form-group col-sm-12">
                                        <input name="payment_proof" class="form-control" type="file">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="example-text-input" class="col-form-label">Status<span
                                            class="text-danger">*</span></label>
                                    <div class="form-group col-sm-12">
                                        <select name="status" class="form-select" aria-label="Select status">
                                            <option value="approved"
                                                {{ old('status', $payment->status) == 'approved' ? 'selected' : '' }}>
                                                Approved
                                            </option>
                                            <option value="not_approved"
                                                {{ old('status', $payment->status) == 'not_approved' ? 'selected' : '' }}>
                                                Not Approved
                                            </option>
                                        </select>
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
    <script language="javascript">
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();

        today = yyyy + '-' + mm + '-' + dd;
        $('#paid_date').attr('max', today);
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            jQuery.validator.addMethod('numericOnly', function(value) {
                return /^[0-9]+$/.test(value);
            }, 'Please only enter numeric values (0-9)');
            $.validator.addMethod("alpha", function(value, element) {
                return this.optional(element) || value == value.match(/^[a-zA-Z\s]+$/);
            }, 'Please enter letters only');
            $('#myForm').validate({
                rules: {
                    customer_id: {
                        required: true,
                    },
                    payment_mode: {
                        required: true,
                    },
                    payment_ref_no: {
                        required: true,
                    },
                    paid_amount: {
                        required: true,
                        numericOnly: true,
                    },
                    phone_number: {
                        number: true,
                        pattern: "^[1-9]{1}[0-9]{9}$"
                    },
                    person_name: {
                        alpha: true,
                    },
                },
                messages: {
                    customer_id: {
                        required: 'Please Select Customer',
                    },
                    payment_mode: {
                        required: 'Please Select Mode Of Payment',
                    },
                    payment_ref_no: {
                        required: 'Please Enter Payment Ref No.',
                    },
                    paid_amount: {
                        required: 'Please Enter Paid Amount',
                    },
                    phone_number: {
                        number: "Please Enter Valid Phone number",
                        pattren: "Please Enter Valid Phone number",
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
