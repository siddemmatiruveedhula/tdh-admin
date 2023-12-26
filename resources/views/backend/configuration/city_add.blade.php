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

                            <h4 class="card-title">Add City </h4><br><br>
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
                            <form method="post" class="row g-3" action="{{ route('city.store') }}" name="cityForm"
                                id="cityForm">
                                @csrf

                                <div class="alert alert-danger print-city-form-error-msg d-none">
                                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                    <ul>
                                    </ul>
                                </div>
                                <div class="col-4">
                                    <label for="example-text-input" class="form-label"> Name <span
                                            class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input name="name" value="{{ old('name') }}" class="form-control"
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
                                                    {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                                    {{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                        
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
                                    <input type="submit" id="city_submit" class="btn btn-info waves-effect waves-light"
                                        value="Add City">
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
            $("#cityForm").validate({
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
                        required: 'Please Enter City Name',
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
                        url: "/city/store",
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
                                toastr.success(data.message, 'City Inserted successfully!');
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
        // $(document).ready(function() {
        //     $('#cityForm').validate({
        //         rules: {
        //             name: {
        //                 required: true,
        //             },
        //             country_id: {
        //                 required: true,
        //             },
        //             state_id: {
        //                 required: true,
        //             },
        //             district_id: {
        //                 required: true,
        //             },
        //             status: {
        //                 required: true,
        //             },

        //         },
        //         messages: {
        //             name: {
        //                 required: 'Please Enter Name',
        //             },
        //             country_id: {
        //                 required: 'Please Select Country',
        //             },
        //             state_id: {
        //                 required: 'Please Select State',
        //             },
        //             district_id: {
        //                 required: 'Please Select District',
        //             },
        //             status: {
        //                 required: 'Please select Status',
        //             },

        //         },
        //         errorElement: 'span',
        //         errorPlacement: function(error, element) {
        //             error.addClass('invalid-feedback');
        //             element.closest('.form-group').append(error);
        //         },
        //         highlight: function(element, errorClass, validClass) {
        //             $(element).addClass('is-invalid');
        //         },
        //         unhighlight: function(element, errorClass, validClass) {
        //             $(element).removeClass('is-invalid');
        //         },
        //     });

        //     let city_name = $("#name");
        //     let country_dropdown = $("#country-dropdown");
        //     let state_dropdown = $("#state-dropdown");
        //     let district_dropdown = $("#district-dropdown");
        //     let city_dropdown = $("#city-dropdown");

        //     //error fields
        //     let name_error = $("#name_error");
        //     let country_error = $("#country_dropdown_error");
        //     let state_error = $("#state_dropdown_error");
        //     let district_error = $("#district_dropdown_error");
        //     let city_error = $("#city_dropdown_error");

        //     let name_has_error = false;
        //     let country_has_error = false;
        //     let state_has_error = false;
        //     let district_has_error = false;
        //     let city_has_error = false;

        //     let form_has_error = false;

        //     $(".con-error").addClass('d-none');

        //     country_dropdown.on('change', function() {
        //         if (!country_dropdown.val()) {
        //             country_error.html('Please Select Country')
        //         } else {
        //             country_error.html('')
        //         }
        //     });
        //     state_dropdown.on('change', function() {
        //         if (!state_dropdown.val()) {
        //             state_error.html('Please Select State')
        //         } else {
        //             state_error.html('')
        //         }
        //     });
        //     district_dropdown.on('change', function() {
        //         if (!district_dropdown.val()) {
        //             district_error.html('Please Select District')
        //         } else {
        //             district_error.html('')
        //         }
        //     });


        //     if (city_name.val().trim() == '' || city_name.val().trim() == null) {
        //         name_error.html('Please enter area name')
        //         name_error.removeClass('d-none')
        //         name_has_error = true;
        //         form_has_error = true;
        //     } else {
        //         name_error.html('')
        //     }
        //     if (!country_dropdown.val()) {
        //         country_error.html('Please Select Country')
        //         country_error.removeClass('d-none')
        //         country_has_error = true;
        //         form_has_error = true;
        //     } else {
        //         country_error.html('')
        //     }
        //     if (!state_dropdown.val()) {
        //         state_error.html('Please Select State')
        //         state_error.removeClass('d-none')
        //         state_has_error = true;
        //         form_has_error = true;
        //     } else {
        //         state_error.html('')
        //     }
        //     if (!district_dropdown.val()) {
        //         district_error.html('Please Select District')
        //         district_error.removeClass('d-none')
        //         district_has_error = true;
        //         form_has_error = true;
        //     } else {
        //         district_error.html('')
        //     }



        //     if (name_has_error) {
        //         area_name.focus();
        //         return false;
        //     } else if (country_has_error) {
        //         country_dropdown.focus();
        //         return false;
        //     } else if (state_has_error) {
        //         state_dropdown.focus();
        //         return false;
        //     } else if (district_has_error) {
        //         district_dropdown.focus();
        //         return false;
        //     }
        //     if (!form_has_error) {
        //         $("#cityForm").submit(function(e) {
        //             e.preventDefault();
        //             let formData = new FormData(this);
        //             $.ajax({
        //                 url: "/city/store",
        //                 type: "POST",
        //                 data: formData,
        //                 dataType: 'json',
        //                 beforeSend: function() {
        //                     $(".print-city-form-error-msg").addClass('d-none');
        //                 },
        //                 success: function(data) {
        //                     $("#city_submit").on('click');
        //                     if ($.isEmptyObject(data.error)) {
        //                         var url = "{{ route('city.all') }}";
        //                         window.location.href = url;
        //                         toastr.success(data.message, 'City Inserted successfully!');
        //                     } else {
        //                         $(".print-city-form-error-msg").find("ul").html('');
        //                         $(".print-city-form-error-msg").removeClass('d-none');
        //                         $.each(data.error, function(key, value) {
        //                             $(".print-city-form-error-msg").find("ul")
        //                                 .append('<li>' + value + '</li>');
        //                             $(".print-city-form-error-msg").attr(
        //                                     "tabindex", -1)
        //                                 .focus();
        //                         });
        //                     }
        //                 },
        //                 contentType: false,
        //                 processData: false,
        //             });

        //         });
        //     }
        // });
    </script>

    <script>
        $(document).ready(function() {
            $(document).ready(function($) {
                if ($("#state-dropdown").data('oldid') != '') {
                    $("#country-dropdown").change();
                }

            });
            $(document).ready(function($) {

                if ($("#district-dropdown").data('oldid') != '') {
                    $("#state-dropdown").change();

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
                            // alert ($("#state-dropdown").data('oldid'));
                            $('#state-dropdown').val($("#state-dropdown")
                                .data('oldid'));

                        }


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
                    success: function(result) {
                        $('#district-dropdown').html(
                            '<option value="">-- Select District --</option>');
                        $.each(result.districts, function(key, value) {
                            $("#district-dropdown").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });

                        if ($("#district-dropdown").data('oldid') != '') {
                            $('#district-dropdown').val($("#district-dropdown")
                                .data('oldid'));

                        }


                    }
                });
            });



        });
    </script>
@endsection
