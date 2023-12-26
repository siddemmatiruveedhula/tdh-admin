@extends('admin.admin_master')
@section('admin')

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Factory Sale</h4>

                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('saleorder.index') }}">Factory Sale List</a></li>
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

                            <h4 class="card-title">Update Factory Sale Order </h4><br><br>
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
                            <form method="post" class="row g-3" action="{{ route('saleorder.update', $sale_order->id) }}"
                                id="myForm" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="col-6">
                                    <label for="example-text-input" class="form-label">Visitor<span
                                            class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <select name="visitor_id" id="customer-dropdown" class="form-select select2">
                                            <option value="">--Select Visitor --</option>
                                            @foreach ($visitors as $visitor)
                                                <option value="{{ $visitor->id }}"
                                                    {{ old('visitor_id', $sale_order->visitor_id) == $visitor->id ? 'selected' : '' }}>
                                                    {{ $visitor->visitor_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="example-text-input" class="form-label"> Bill No. <span
                                            class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input name="bill_no" value="{{ old('bill_no', $sale_order->bill_no) }}" class="form-control"
                                            type="text" placeholder="Bill No.">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="example-text-input" class="form-label"> Amount <span
                                            class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input name="amount" value="{{ old('amount', $sale_order->amount) }}" class="form-control"
                                            type="text" placeholder="Amount">
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
                    visitor_id: {
                        required: true,
                    },
                    bill_no: {
                        required: true,
                    },
                    amount: {
                        required: true,
                    },
                },
                messages: {
                    visitor_id: {
                        required: 'Please Select Visitor',
                    },
                    bill_no: {
                        required: 'Please Enter Bill No.',
                    },
                    amount: {
                        required: 'Please Enter Amount',
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
