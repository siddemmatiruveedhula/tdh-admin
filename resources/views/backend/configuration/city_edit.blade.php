@extends('admin.admin_master')
@section('admin')
    

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">City</h4>

                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('city.all') }}">City</a></li>
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

                            <h4 class="card-title">Edit City</h4><br><br>
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
                            <form method="post" class="row g-3" action="{{ route('city.update') }}" id="cityUpdateForm">
                                @csrf

                                <div class="alert alert-danger print-city-form-error-msg d-none">
                                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                    <ul>
                                    </ul>
                                </div>
                                <input type="hidden" name="id" value="{{ $city->id }}">


                                <div class="col-4">
                                    <label for="example-text-input" class="form-label"> Name <span
                                            class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input name="name" value="{{ $city->name }}" class="form-control"
                                            type="text">
                                    </div>
                                </div> <!-- end row -->

                                <div class="col-4">
                                    <label for="example-text-input" class="form-label"> Country <span
                                            class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <select name="country_id" id="country-dropdown" class="form-select select2">
                                            <option value="">--Select Country --</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}"
                                                    {{ old('country_id', $city->country_id) == $country->id ? 'selected' : '' }}>
                                                    {{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <label for="example-text-input" class="form-label"> State <span
                                            class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <select name="state_id" id="state-dropdown" class="form-select select2">
                                            <option value="">--Select State --</option>
                                            @foreach ($states as $states)
                                                <option value="{{ $states->id }}"
                                                    {{ old('state_id', $city->state_id) == $states->id ? 'selected' : '' }}>
                                                    {{ $states->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <label for="example-text-input" class="form-label">District<span
                                            class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <select name="district_id" id="district-dropdown" class="form-select select2">
                                            <option value="">--Select District --</option>
                                            @foreach ($districts as $district)
                                                <option value="{{ $district->id }}"
                                                    {{ old('district_id', $city->district_id) == $district->id ? 'selected' : '' }}>
                                                    {{ $district->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <label for="example-text-input" class="form-label">Status<span
                                            class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <select name="status" class="form-select" aria-label="Select status">
                                            <option {{ old('status', $city->status) == 1 ? 'selected' : '' }}
                                                value="1">Active
                                            </option>
                                            <option {{ old('status', $city->status) == 0 ? 'selected' : '' }}
                                                value="0">Inactive
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="text-left">
                                    <input type="submit" id="city_submit" class="btn btn-info waves-effect waves-light"
                                        value="Update City">
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
            jQuery.validator.addMethod("lettersonlys", function(value, element) {
                return this.optional(element) || /^[a-zA-Z ]*$/.test(value);
            }, "Please Enter Letters only");
            $("#cityUpdateForm").validate({
                ignore: ":hidden",
                rules: {
                    name: {
                        required: true,
                        lettersonlys: true,
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
                    status: {
                        required: true,
                    },

                },
                messages: {
                    name: {
                        required: 'Please Enter Name',
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
                        url: "/city/update",
                        type: "POST",
                        data: $(form).serialize(),
                        beforeSend: function() {
                            $(".print-city-form-error-msg").addClass('d-none');
                        },
                        success: function(data) {
                            $("#city_submit").on('click');
                            if ($.isEmptyObject(data.error)) {
                                var url = "{{ route('city.all') }}";
                                window.location.href = url;
                                toastr.success(data.message, 'City Updated successfully!');
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

        });
    </script>
@endsection
