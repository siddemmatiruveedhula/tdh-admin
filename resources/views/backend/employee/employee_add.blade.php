@extends('admin.admin_master')
@section('admin')
    
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Employees</h4>

                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('employee.all') }}">Employee</a></li>
                            <li class="breadcrumb-item active">Add</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- end page title -->


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Add Employee </h4><br><br>

                            @if (Session::has('success'))
                                <div class="alert alert-success">
                                    {{ Session::get('success') }}
                                    @php
                                        Session::forget('success');
                                    @endphp
                                </div>
                            @endif

                            <form class="row g-3" action="{{ route('employee.store') }}" id="contactForm"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="alert alert-danger print-contact-form-error-msg d-none">
                                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                    <ul>
                                    </ul>
                                </div>
                                <div class="col-4">
                                    <label class="form-label"> Name<span class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <input type="text" name="name" id="name" class="form-control"
                                            placeholder="Name" value="{{ old('name') }}">
                                        <span id="name_error" class="d-none con-error text-danger"></span><br />

                                    </div>
                                </div>
                                <div class="col-4">
                                    <label class="form-label">User Name<span class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <input type="text" name="username" id="username" class="form-control"
                                            placeholder="User Name" value="{{ old('username') }}">
                                        <span id="username_error" class="d-none con-error text-danger"></span><br />

                                    </div>
                                </div>

                                <div class="col-4">
                                    <label class="form-label">Personal Email</label>
                                    <div class="form-group">
                                        <input name="email" id="email" class="form-control" type="email"
                                            placeholder="Personal Email" value="{{ old('email') }}">
                                        <span id="email_error" class="d-none con-error text-danger"></span><br />

                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="col-4">
                                    <label class="form-label">Organization Email <span class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input name="office_email" id="office_email" class="form-control" type="email"
                                            placeholder="Organization Email" value="{{ old('office_email') }}">
                                        <span id="office_email_error" class="d-none con-error text-danger"></span><br />

                                    </div>
                                </div>
                                <!-- end row -->
                                <div class="col-4">
                                    <label class="form-label">Personal Phone </label>
                                    <div class="form-group ">
                                        <input name="personal_phone" id="personal_phone" class="form-control" type="text"
                                            placeholder="Personal Phone Number" value="{{ old('personal_phone') }}">
                                        <span id="personal_phone_error" class="d-none con-error text-danger"></span><br />
                                    </div>
                                </div>
                                <!-- end row -->
                                <div class="col-4">
                                    <label class="form-label">Organization Phone<span class="text-danger">*</span></label>
                                    <div class="form-group ">
                                        <input name="office_phone" id="office_phone" class="form-control" type="text"
                                            placeholder="Organization Phone Number" value="{{ old('office_phone') }}">
                                        <span id="office_phone_error" class="d-none con-error text-danger"></span><br />
                                    </div>
                                </div>
                                <!-- end row -->


                                <div class="col-4">
                                    <label class="form-label"> Password <span class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input name="password" id="password" class="form-control" type="password"
                                            placeholder="Password" value="{{ old('password') }}">
                                        <span id="password_error" class="d-none con-error text-danger"></span><br />

                                    </div>
                                </div>
                                <!-- end row -->
                                <div class="col-4">
                                    <label class="form-label"> Employee ID</label>
                                    <div class="form-group ">
                                        <input name="employee_code" id="employee_code" class="form-control"
                                            type="text" placeholder="Employee ID" value="{{ old('employee_code') }}">
                                        <span id="employee_code_error" class="d-none con-error text-danger"></span><br />

                                    </div>
                                </div>



                                <div class="col-4">
                                    <label class="form-label"> Address </label>
                                    <div class="form-group ">
                                        <input name="address" id="address" class="form-control" type="text"
                                            placeholder="Address" value="{{ old('address') }}">
                                        <span id="address_error" class="d-none con-error text-danger"></span><br />
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="col-4">
                                    <label class="form-label">Role <span class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <select name="role_id" id="role_id" class="form-select select2">
                                            <option value="">--Select Role --</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}"
                                                    {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                                    {{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                        <span id="role_id_error" class="d-none con-error text-danger"></span><br />
                                    </div>

                                </div>
                                <div class="col-4">
                                    <label class="form-label">POC - 1</label>
                                    <div class="form-group">
                                        <select name="poc_1" id="poc_1" class="form-select select2">
                                            <option value="">--Select POC-1 --</option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}"
                                                    {{ old('poc_1') == $employee->id ? 'selected' : '' }}>
                                                    {{ $employee->name ?? '' }} ( {{ $employee->role->name ?? '' }} )
                                                </option>
                                            @endforeach
                                        </select>
                                        <span id="poc_1_error" class="d-none con-error text-danger"></span><br />
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label class="form-label">POC - 2</label>
                                    <div class="form-group">
                                        <select name="poc_2" id="poc_2" class="form-select select2">
                                            <option value="">--Select POC-2 --</option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}"
                                                    {{ old('poc_2') == $employee->id ? 'selected' : '' }}>
                                                    {{ $employee->name ?? '' }}( {{ $employee->role->name ?? '' }} )
                                                </option>
                                            @endforeach
                                        </select>
                                        <span id="poc_2_error" class="d-none con-error text-danger"></span><br />
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label class="form-label">Department<span class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <select name="department_id" id="department_id" class="form-select select2"
                                            onchange="getDivisions()">
                                            <option value="">--Select Department--</option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}"
                                                    {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                                    {{ $department->name }}</option>
                                            @endforeach
                                        </select>
                                        <span id="department_id_error" class="d-none con-error text-danger"></span><br />
                                    </div>
                                </div>

                                <div class="col-4" id="division_id_content">
                                    <label for="division_id" class="form-label">Division <span
                                            class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <select name="division_id" id="division_id" class="form-select select2"
                                            aria-label="Select Sector">
                                            <option value="" disabled selected>--Select Division--</option>
                                            @php
                                                if (old('department_id')) {
                                                    $divisions = App\Models\Division::select('id', 'name')
                                                        ->where('department_id', old('department_id'))
                                                        ->where('status', true)
                                                        ->get();
                                                }
                                            @endphp
                                            @if (isset($divisions))
                                                @foreach ($divisions as $division)
                                                    <option value="{{ $division->id }}"
                                                        {{ old('division_id') == $division->id ? 'selected' : '' }}>
                                                        {{ $division->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <span id="division_id_error" class="d-none con-error text-danger"></span><br />
                                    </div>
                                </div>

                                <div class="col-4">
                                    <label class="form-label"> DA </label>
                                    <div class="form-group ">
                                        <input name="daily_allowance" class="form-control" type="text"
                                            id="daily_allowance" placeholder="Daily Allowance"
                                            value="{{ old('daily_allowance') }}">
                                        <span id="daily_allowance_error"
                                            class="d-none con-error text-danger"></span><br />
                                    </div>
                                </div>

                                <div class="col-4">
                                    <label for="status" class="form-label">Status <span
                                            class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <select name="status" class="form-select" aria-label="Select Status">
                                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label class="form-label">Working Location</label>
                                    <div class="form-group ">
                                        <input name="working_location" id="working_location" class="form-control"
                                            type="text" placeholder="working location"
                                            value="{{ old('working_location') }}">
                                        <span id="working_location_error"
                                            class="d-none con-error text-danger"></span><br />
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="col-4">
                                    <label class="form-label"> Image </label>
                                    <div class="form-group">
                                        <input name="image" class="form-control" type="file" id="image">
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="col-4">
                                    <label class="form-label"> </label>
                                    <div class="form-group">
                                        <img id="showImage" class="rounded avatar-lg"
                                            src="{{ url('upload/no_image.jpg') }}" alt="Card image cap">
                                    </div>
                                </div>
                                <!-- end row -->


                                <div class="text-center">
                                    <button type="submit" id="employee_submit"
                                        class="btn btn-info waves-effect waves-light">Add Employee</button>
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

        function isNumeric(value) {
            let regex = /^[0-9]+$/;
            return regex.test(value);
        }

        function nonNumeric(value) {
            return value == "" || /[a-z]/.test(value) || /[a-z]/.test(value) && /\d/.test(value) ||
                    /[A-Z]/.test(value) || /[A-Z]/.test(value) && /\d/.test(value);
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
            $("#contactForm").submit(function(e) {
                e.preventDefault();
                //input fileds
                let emp_name = $("#name");
                let username = $("#username");
                let email = $("#email");
                let office_email = $("#office_email");
                let phone = $("#personal_phone");
                let office_phone = $("#office_phone");
                let password = $("#password");
                let employee_code = $("#employee_code");
                let address = $("#address");
                let role_id = $("#role_id");
                let poc_1 = $("#poc_1");
                let poc_2 = $("#poc_2");
                let department_id = $("#department_id");
                let division_id = $("#division_id");
                let working_location = $("#working_location");
                let daily_allowance = $("#daily_allowance");

                //error fields
                let emp_name_error = $("#name_error");
                let username_error = $("#username_error");
                let email_error = $("#email_error");
                let office_email_error = $("#office_email_error");
                let phone_error = $("#personal_phone_error");
                let office_phone_error = $("#office_phone_error");
                let employee_code_error = $("#employee_code_error");
                let password_error = $("#password_error");
                let address_error = $("#address_error");
                let role_id_error = $("#role_id_error");
                let poc_1_error = $("#poc_1_error");
                let poc_2_error = $("#poc_2_error");
                let department_id_error = $("#department_id_error");
                let division_id_error = $("#division_id_error");
                let working_location_error = $("#working_location_error");
                let daily_allowance_error = $("#daily_allowance_error");

                let emp_name_has_error = false;
                let username_has_error = false;
                let email_has_error = false;
                let office_email_has_error = false;
                let phone_has_error = false;
                let office_phone_has_error = false;
                let employee_code_has_error = false;
                let password_has_error = false;
                let role_id_has_error = false;
                let address_has_error = false;
                let poc_1_has_error = false;
                let poc_2_has_error = false;
                let department_id_has_error = false;
                let division_id_has_error = false;
                let working_location_has_error = false;
                let daily_allowance_has_error = false;

                let form_has_error = false;

                $(".con-error").addClass('d-none');

                emp_name.on('input', function() {
                    if (!nonNumeric(emp_name.val().trim())) {
                        emp_name_error.html('Please enter valid name')
                    } else {
                        emp_name_error.html('')
                    }
                });

                working_location.on('input', function() {
                    if (!isName(working_location.val().trim())) {
                        working_location_error.html('Please enter Letters only')
                    } else {
                        working_location_error.html('')
                    }
                });

                daily_allowance.on('input', function() {
                    if (!isNumeric(daily_allowance.val().trim())) {
                        daily_allowance_error.html('Please enter Numbers only')
                    } else {
                        daily_allowance_error.html('')
                    }
                });

                email.on('input', function() {
                    if (!isEmail(email.val().trim())) {
                        email_error.html(
                            'Please enter valid email')
                    } else {
                        email_error.html('')
                    }
                });
                office_email.on('input', function() {
                    if (!isEmail(office_email.val().trim())) {
                        office_email_error.html('Please enter valid email')
                    } 
                    else {
                        office_email_error.html('')
                    }
                });
                phone.on('input', function() {
                    if (isPhoneNo(phone.val().trim())) {
                        if (isPhoneNo(phone.val().trim())) {
                            if (phone.val().trim().length != 10) {
                                phone_error.html('Please enter 10 digit mobile number')
                            }
                            if (phone.val().trim().length == 10) {
                                phone_error.html('')
                            }
                        }
                    } else if (!isPhoneNo(phone.val().trim())) {
                        phone_error.html('Please enter valid mobile number')
                        phone_has_error = true;
                        form_has_error = true;
                    } else {
                        phone_error.html('')
                        phone_has_error = false;
                        form_has_error = false;
                    }
                });
                office_phone.on('input', function() {
                    if (isPhoneNo(office_phone.val().trim())) {
                        if (isPhoneNo(office_phone.val().trim())) {
                            if (office_phone.val().trim().length != 10) {
                                office_phone_error.html('Please enter 10 digit mobile number')
                            }
                            if (office_phone.val().trim().length == 10) {
                                office_phone_error.html('')
                            }
                        }
                    } else if (!isPhoneNo(office_phone.val().trim())) {
                        office_phone_error.html('Please enter valid mobile number')
                        office_phone_has_error = true;
                        form_has_error = true;
                    } else {
                        office_phone_error.html('')
                        office_phone_has_error = false;
                        form_has_error = false;
                    }
                });
                password.on('input', function() {
                    if (password.val().trim()) {
                        if (password.val().trim().length < 4) {
                            password_error.html('Please enter atleast 4 characters')
                        }
                        if (password.val().trim().length == 4) {
                            password_error.html('')
                        }

                    }
                });

            
                role_id.on('change', function() {
                    if (!role_id.val()) {
                        role_id_error.html('Please Select Role')
                    } else {
                        role_id_error.html('')
                    }
                });

                department_id.on('change', function() {
                    if (!department_id.val()) {
                        department_id_error.html('Please Select Department')
                    } else {
                        department_id_error.html('')
                    }
                });
                division_id.on('change', function() {
                    if (!division_id.val()) {
                        division_id_error.html('Please Select Department')
                    } else {
                        division_id_error.html('')
                    }
                });

                poc_2.on('change', function() {
                    if (poc_2.val()) {
                        if ($("#poc_1").val() === $("#poc_2").val()) {
                            poc_2_error.html('Poc-1 and poc-2 should not be same')
                        } else {
                            poc_2_error.html('')
                        }
                    } else {
                        poc_2_error.html('')
                    }
                });

                if (emp_name.val().trim() == '' || emp_name.val().trim() == null) {
                    emp_name_error.html('Please enter employee name')
                    emp_name_error.removeClass('d-none')
                    emp_name_has_error = true;
                    form_has_error = true;
                } else {
                    if (!nonNumeric(emp_name.val().trim())) {
                        emp_name_error.html('Please enter valid employee name')
                        emp_name_error.removeClass('d-none')
                        emp_name_has_error = true;
                        form_has_error = true;
                    }
                }

                if (working_location.val().trim() == '' || working_location.val().trim() == null) {
                    working_location_error.html('')
                    working_location_error.removeClass('d-none')
                    working_location_has_error = false;
                    form_has_error = false;
                } else {
                    if (!isName(working_location.val().trim())) {
                        working_location_error.html('Please enter Letters only')
                        working_location_error.removeClass('d-none')
                        working_location_has_error = true;
                        form_has_error = true;
                    }
                }

                if (daily_allowance.val().trim() == '' || daily_allowance.val().trim() == null) {
                    daily_allowance_error.html('')
                    daily_allowance_error.removeClass('d-none')
                    daily_allowance_has_error = false;
                    form_has_error = false;
                } else {
                    if (!isNumeric(daily_allowance.val().trim())) {
                        daily_allowance_error.html('Please enter Numbers only')
                        daily_allowance_error.removeClass('d-none')
                        daily_allowance_has_error = true;
                        form_has_error = true;
                    }
                }

                if (username.val().trim() == '' || username.val().trim() == null) {
                    username_error.html('Please enter user name')
                    username_error.removeClass('d-none')
                    username_has_error = true;
                    form_has_error = true;
                } else {
                    if (isNumeric(username.val().trim())) {
                        username_error.html('it should be Alphanumeric')
                        username_error.removeClass('d-none')
                        username_has_error = true;
                        form_has_error = true;
                    } else if (username.val().length < 5) {
                        username_error.html('User Name Must Contain at least 5 letter')
                        username_error.removeClass('d-none')
                        username_has_error = true;
                        form_has_error = true;
                    }
                }
                if (email.val().trim() == '' || email.val().trim() == null) {
                    email_error.html('')
                    email_error.removeClass('d-none')
                    email_has_error = false;
                    form_has_error = false;
                } else {
                    if (!isEmail(email.val().trim())) {
                        email_error.html('Please enter valid email')
                        email_error.removeClass('d-none')
                        email_has_error = true;
                        form_has_error = true;
                    }
                }

                if (office_email.val().trim() == '' || office_email.val().trim() == null) {
                    office_email_error.html('Please enter Organization Email')
                    office_email_error.removeClass('d-none')
                    office_email_has_error = false;
                    form_has_error = false;
                } else {
                    if (!isEmail(office_email.val().trim())) {
                        office_email_error.html('Please enter valid email')
                        office_email_error.removeClass('d-none')
                        office_email_has_error = true;
                        form_has_error = true;
                    } 
                }

                if (phone.val().trim() == '' || !phone.val().trim() == null) {
                    phone_error.html('')
                    phone_error.removeClass('d-none')
                    phone_has_error = false;
                    form_has_error = false;
                } else {
                    if (isPhoneNo(phone.val().trim())) {
                        if (phone.val().trim().length != 10) {
                            phone_error.html('Please enter 10 digit mobile number')
                            phone_error.removeClass('d-none')
                            phone_has_error = true;
                            form_has_error = true;
                        }
                    } else {
                        phone_error.html('Please enter valid mobile number')
                        phone_error.removeClass('d-none')
                        phone_has_error = true;
                        form_has_error = true;
                    }
                }

                if (office_phone.val().trim() == '' || !office_phone.val().trim() == null) {
                    office_phone_error.html('Please Enter Organization Phone number')
                    office_phone_error.removeClass('d-none')
                    office_phone_has_error = true;
                    form_has_error = true;
                } else {
                    if (isPhoneNo(office_phone.val().trim())) {
                        if (office_phone.val().trim().length != 10) {
                            office_phone_error.html('Please enter 10 digit mobile number')
                            office_phone_error.removeClass('d-none')
                            office_phone_has_error = true;
                            form_has_error = true;
                        }
                    } else {
                        office_phone_error.html('Please enter valid mobile number')
                        office_phone_error.removeClass('d-none')
                        office_phone_has_error = true;
                        form_has_error = true;
                    }
                }

                if (password.val().trim() == '' || !password.val().trim() == null) {
                    password_error.html('Please enter Password')
                    password_error.removeClass('d-none')
                    password_has_error = false;
                    form_has_error = false;
                } else if (password.val().trim().length < 4) {
                    password_error.html('Please enter atleast 4 characters')
                    password_error.removeClass('d-none')
                    password_has_error = true;
                    form_has_error = true;
                }



                if (poc_2.val()) {
                    if ($("#poc_1").val() === $("#poc_2").val()) {
                        poc_2_error.html('Poc-1 and poc-2 should not be same')
                        poc_2_error.removeClass('d-none')
                        poc_2_has_error = true;
                        form_has_error = true;
                    } else {
                        poc_2_error.html('')
                    }
                } else {
                    poc_2_error.html('')

                }

                if (!role_id.val()) {
                    role_id_error.html('Please Select Role')
                    role_id_error.removeClass('d-none')
                    role_id_has_error = true;
                    form_has_error = true;
                } else {
                    role_id_error.html('')
                }

                if (!department_id.val()) {
                    department_id_error.html('Please Select Department')
                    department_id_error.removeClass('d-none')
                    department_id_has_error = true;
                    form_has_error = true;
                } else {
                    department_id_error.html('')
                }
                if (!division_id.val()) {
                    division_id_error.html('Please Select Division')
                    division_id_error.removeClass('d-none')
                    division_id_has_error = true;
                    form_has_error = true;
                } else {
                    division_id_error.html('')
                }

                if (emp_name_has_error) {
                    emp_name.focus();
                    return false;
                } else if (username_has_error) {
                    username.focus();
                    return false;
                } else if (email_has_error) {
                    email.focus();
                    return false;
                } else if (office_email_has_error) {
                    office_email.focus();
                    return false;
                } else if (phone_has_error) {
                    phone.focus();
                    return false;
                } else if (office_phone_has_error) {
                    office_phone.focus();
                    return false;
                } else if (password_has_error) {
                    password.focus();
                    return false;
                } else if (employee_code_has_error) {
                    employee_code.focus();
                    return false;
                } 
           
                else if (address_has_error) {
                    address.focus();
                    return false;
                } else if (role_id_has_error) {
                    role_id.focus();
                    return false;
                } else if (poc_1_has_error) {
                    poc_1.focus();
                    return false;
                } else if (poc_2_has_error) {
                    poc_2.focus();
                    return false;
                } else if (department_id_has_error) {
                    department_id.focus();
                    return false;
                } else if (division_id_has_error) {
                    division_id.focus();
                    return false;
                } else if (working_location_has_error) {
                    working_location.focus();
                    return false;
                } else {
                    let formData = new FormData(this);
                    $.ajax({
                        url: "/employee/store",
                        type: "POST",
                        data: formData,
                        dataType: 'json',
                        beforeSend: function() {
                            $(".print-contact-form-error-msg").addClass('d-none');
                        },
                        success: function(data) {
                            $("#employee_submit").on('click');
                            if ($.isEmptyObject(data.error)) {
                                var url = "{{ route('employee.all') }}";
                                window.location.href = url;
                                toastr.success(data.message, 'Employee Inserted successfully!');
                            } else {
                                $(".print-contact-form-error-msg").find("ul").html('');
                                $(".print-contact-form-error-msg").removeClass('d-none');
                                $.each(data.error, function(key, value) {
                                    $(".print-contact-form-error-msg").find("ul")
                                        .append('<li>' + value + '</li>');
                                    $(".print-contact-form-error-msg").attr(
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
        function getDivisions() {
            let id = $("#department_id").val();
            $.ajax({
                type: "get",
                data: {
                    _token: '{{ csrf_token() }}'
                },
                url: "{{ url('/employee-division/') }}" + "/" + id,
                success: function(response) {
                    $("#division_id_content").html(response);
                },
                error: function(err) {
                    console.log(err);
                }
            })
        }
    </script>
@endsection
