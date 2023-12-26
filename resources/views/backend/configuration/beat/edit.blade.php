@extends('admin.admin_master')
@section('admin')
    

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Beat</h4>

                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('beat.index') }}">Beat</a></li>
                            <li class="breadcrumb-item active">UPDATE</li>
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

                            <h4 class="card-title">Edit Beat </h4><br><br>

                            <form method="post" class="row g-3" action="{{ route('beat.update') }}"
                                id="myForm" method="POST">
                                @csrf
                                <div class="alert alert-danger print-city-form-error-msg d-none">
                                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                    <ul>
                                       
                                    </ul>
                                </div>
                                <input type="hidden" name="id" value="{{ $beat->id }}">
                                <div class="col-6">
                                    <label for="example-text-input" class="form-label"> Name <span
                                            class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input name="name" value="{{ old('name', $beat->name) }}" class="form-control"
                                            type="text">
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <!-- end row -->
                                <div class="col-6">
                                    <label for="example-text-input" class="form-label">City<span
                                        class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <select name="city_id" id="city-dropdown" class="form-select select2" aria-label="Select city">
                                            <option value="">--Select City --</option>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}"
                                                    {{ old('city_id', $beat->city_id) == $city->id ? 'selected' : '' }}>
                                                    {{ $city->name }} - {{ $city->district_name }} - {{ $city->states_name }} - {{ $city->countrie_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="col-6">
                                    <label for="example-text-input" class="form-label">Supplier
                                        {{-- <span class="text-danger">*</span> --}}
                                    </label>
                                    <div class="form-group">
                                        <select name="supplier_id" class="form-select select2" aria-label="Select supplier">
                                            <option value="">--Select Supplier--</option>
                                            @forelse ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}"
                                                    {{ old('supplier_id', $beat->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                                    {{ $supplier->name }}({{ $supplier->customer_type_name }})</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label for="example-text-input" class="form-label">Status<span
                                            class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <select name="status" class="form-select" aria-label="Select status">
                                            <option {{ old('status', $beat->status) == 1 ? 'selected' : '' }}
                                                value="1">Active
                                            </option>
                                            <option {{ old('status', $beat->status) == 0 ? 'selected' : '' }}
                                                value="0">Inactive
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="text-left">
                                    <input type="submit" id="update_beat" class="btn btn-info waves-effect waves-light" value="Update Beat">
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
                    name: {
                        required: true,
                    },
                    city_id: {
                        required: true,
                    },
                    status: {
                        required: true,
                    },

                },
                messages: {
                    name: {
                        required: 'Please Enter Beat Name',
                    },
                    city_id: {
                        required: 'Please Select City',
                    },
                    status_id: {
                        required: 'Please Select Status',
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
                        if ($('#city-dropdown').val()) {
                            $('#city-dropdown').removeClass('is-invalid');
                        } else {
                            $('#city-dropdown').addClass('is-invalid');
                        }
                        
                    });
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: "/beat/update",
                        type: "POST",
                        data: $(form).serialize(),
                        beforeSend: function() {
                            $(".print-city-form-error-msg").addClass('d-none');
                        },
                        success: function(data) {
                            $("#update_beat").on('click');
                            if ($.isEmptyObject(data.error)) {
                                var url = "{{ route('beat.index') }}";
                                window.location.href = url;
                                toastr.success(data.message, 'Beat Updated successfully');
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
@endsection
