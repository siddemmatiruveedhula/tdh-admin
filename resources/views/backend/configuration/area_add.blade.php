@extends('admin.admin_master')
@section('admin')


    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Area</h4>

                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('area.all') }}">Area</a></li>
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

                            <h4 class="card-title">Add Area </h4><br><br>
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
                            <form method="post" class="row g-3" action="{{ route('area.store') }}" id="areaForm">
                                @csrf

                                <div class="alert alert-danger print-area-form-error-msg d-none">
                                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                    <ul>
                                    </ul>
                                </div>
                                <div class="col-4">
                                    <label for="example-text-input" class="form-label">Area Name <span
                                            class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input name="name" id="name" value="{{ old('name') }}"
                                            class="form-control" type="text">
                                        <span id="name_error" class="d-none con-error text-danger"></span><br />
                                    </div>
                                </div>

                                <div class="col-4">
                                    <label for="example-text-input" class="form-label"> Country <span
                                            class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <select name="country_id" id="country-dropdown" class="form-select select2">
                                            <option value="">--Select Country --</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}"
                                                    {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                                    {{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                        <span id="country_dropdown_error" class="d-none con-error text-danger"></span><br />
                                    </div>
                                </div>

                                <div class="col-4">
                                    <label for="example-text-input" class="form-label"> State <span
                                            class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <select name="state_id" id="state-dropdown" class="form-select select2"
                                            data-oldid="{{ Request::old() ? Request::old('state_id') : '' }}">
                                            <option value="">--Select State --</option>
                                            {{-- @foreach ($states as $states)
                                                <option value="{{ $states->id }}"
                                                    {{ old('state_id') == $states->id ? 'selected' : '' }}>
                                                    {{ $states->name }}</option>
                                            @endforeach --}}
                                        </select>
                                        <span id="state_dropdown_error" class="d-none con-error text-danger"></span><br />
                                    </div>
                                </div>

                                <div class="col-4">
                                    <label for="example-text-input" class="form-label">District<span
                                            class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <select name="district_id" id="district-dropdown" class="form-select select2"
                                            data-oldid="{{ Request::old() ? Request::old('district_id') : '' }}">
                                            <option value="">--Select District --</option>
                                            {{-- @foreach ($districts as $district)
                                                <option value="{{ $district->id }}"
                                                    {{ old('district_id') == $district->id ? 'selected' : '' }}>
                                                    {{ $district->name }}</option>
                                            @endforeach --}}
                                        </select>
                                        <span id="district_dropdown_error"
                                            class="d-none con-error text-danger"></span><br />
                                    </div>
                                </div>

                                <div class="col-4">
                                    <label for="example-text-input" class="form-label">City<span
                                            class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <select name="city_id" id="city-dropdown" class="form-select select2"
                                            data-oldid="{{ Request::old() ? Request::old('city_id') : '' }}">
                                            <option value="">--Select City --</option>
                                            {{-- @foreach ($cities as $city)
                                                <option value="{{ $city->id }}"
                                                    {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                                    {{ $city->name }}</option>
                                            @endforeach --}}
                                        </select>
                                        <span id="city_dropdown_error" class="d-none con-error text-danger"></span><br />
                                    </div>
                                </div>

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
                                    <input type="submit" id="area_submit" class="btn btn-info waves-effect waves-light"
                                        value="Add Area">
                                </div>

                            </form>



                        </div>
                    </div>
                </div> <!-- end col -->
            </div>



        </div>
    </div>

    <script>
        function nonNumeric(value) {
            return value == "" || /[a-z]/.test(value) || /[a-z]/.test(value) && /\d/.test(value) ||
                /[A-Z]/.test(value) || /[A-Z]/.test(value) && /\d/.test(value);
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {

            $("#areaForm").submit(function(e) {
                e.preventDefault();
                console.log('main');
                let area_name = $("#name");
                let country_dropdown = $("#country-dropdown");
                let state_dropdown = $("#state-dropdown");
                let district_dropdown = $("#district-dropdown");
                let city_dropdown = $("#city-dropdown");

                //error fields
                let name_error = $("#name_error");
                let country_error = $("#country_dropdown_error");
                let state_error = $("#state_dropdown_error");
                let district_error = $("#district_dropdown_error");
                let city_error = $("#city_dropdown_error");

                let name_has_error = false;
                let country_has_error = false;
                let state_has_error = false;
                let district_has_error = false;
                let city_has_error = false;

                let form_has_error = false;

                $(".con-error").addClass('d-none');

                area_name.on('input', function() {
                    if (!nonNumeric(area_name.val().trim())) {
                        name_error.html('Please enter valid name')
                    } else {
                        name_error.html('')
                    }
                });


                country_dropdown.on('change', function() {
                    if (!country_dropdown.val()) {
                        country_error.html('Please Select Country')
                    } else {
                        country_error.html('')
                    }
                });
                state_dropdown.on('change', function() {
                    if (!state_dropdown.val()) {
                        state_error.html('Please Select State')
                    } else {
                        state_error.html('')
                    }
                });
                district_dropdown.on('change', function() {
                    if (!district_dropdown.val()) {
                        district_error.html('Please Select District')
                    } else {
                        district_error.html('')
                    }
                });
                city_dropdown.on('change', function() {
                    if (!city_dropdown.val()) {
                        city_error.html('Please Select City')
                    } else {
                        city_error.html('')
                    }
                });


                if (area_name.val().trim() == '' || area_name.val().trim() == null) {
                    name_error.html('Please enter area name')
                    name_error.removeClass('d-none')
                    name_has_error = true;
                    form_has_error = true;
                } else {
                    if (!nonNumeric(area_name.val().trim())) {
                        name_error.html('Please enter valid area name')
                        name_error.removeClass('d-none')
                        name_has_error = true;
                        form_has_error = true;
                    }
                }

                if (!country_dropdown.val()) {
                    country_error.html('Please Select Country')
                    country_error.removeClass('d-none')
                    country_has_error = true;
                    form_has_error = true;
                } else {
                    country_error.html('')
                }
                if (!state_dropdown.val()) {
                    state_error.html('Please Select State')
                    state_error.removeClass('d-none')
                    state_has_error = true;
                    form_has_error = true;
                } else {
                    state_error.html('')
                }
                if (!district_dropdown.val()) {
                    district_error.html('Please Select District')
                    district_error.removeClass('d-none')
                    district_has_error = true;
                    form_has_error = true;
                } else {
                    district_error.html('')
                }
                if (!city_dropdown.val()) {
                    city_error.html('Please Select City')
                    city_error.removeClass('d-none')
                    city_has_error = true;
                    form_has_error = true;
                } else {
                    city_error.html('')
                }


                if (name_has_error) {
                    area_name.focus();
                    return false;
                } else if (country_has_error) {
                    country_dropdown.focus();
                    return false;
                } else if (state_has_error) {
                    state_dropdown.focus();
                    return false;
                } else if (district_has_error) {
                    district_dropdown.focus();
                    return false;
                } else if (city_has_error) {
                    city_dropdown.focus();
                    return false;
                }
                if (!form_has_error) {
                    let formData = new FormData(this);
                    console.log('success');
                    $.ajax({
                        url: "/area/store",
                        type: "POST",
                        data: formData,
                        dataType: 'json',
                        beforeSend: function() {
                            $(".print-area-form-error-msg").addClass('d-none');
                        },
                        success: function(data) {
                            console.log(data);
                            $("#area_submit").on('click');
                            if ($.isEmptyObject(data.error)) {
                                var url = "{{ route('area.all') }}";
                                window.location.href = url;
                                toastr.success(data.message, 'Area Inserted successfully!');
                            } else {
                                $(".print-area-form-error-msg").find("ul").html('');
                                $(".print-area-form-error-msg").removeClass('d-none');
                                $.each(data.error, function(key, value) {
                                    $(".print-area-form-error-msg").find("ul")
                                        .append('<li>' + value + '</li>');
                                    $(".print-area-form-error-msg").attr(
                                            "tabindex", -1)
                                        .focus();
                                });
                            }
                        },
                        contentType: false,
                        processData: false,
                    });
                }

            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $(document).ready(function($) {
                if ($("#state-dropdown").data('oldid') != '') {
                    $("#country-dropdown").change();
                }
                if ($("#district-dropdown").data('oldid') != '') {
                    $("#state-dropdown").change();
                }
                if ($("#city-dropdown").data('oldid') != '') {
                    $("#district-dropdown").change();
                }
            });
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
                        if ($("#state-dropdown").data('oldid') != '') {
                            $('#state-dropdown').val($("#state-dropdown")
                                .data('oldid'));
                        }
                        // $('#district-dropdown').html('<option value="">-- Select District --</option>');
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
                        if ($("#district-dropdown").data('oldid') != '') {
                            $('#district-dropdown').val($("#district-dropdown")
                                .data('oldid'));
                        }

                        //$('#city-dropdown').html('<option value="">-- Select City --</option>');
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

                        if ($("#city-dropdown").data('oldid') != '') {
                            $('#city-dropdown').val($("#city-dropdown")
                                .data('oldid'));
                        }

                    }
                });
            });

        });
    </script>
@endsection
