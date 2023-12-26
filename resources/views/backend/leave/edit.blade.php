@extends('admin.admin_master')
@section('admin')

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Leaves</h4>

                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('leave.index') }}">Leaves</a></li>
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

                            <h4 class="card-title">Update Leave </h4><br><br>
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
                            <form method="post" class="row g-3" action="{{ route('leave.update', $leave->id) }}"
                                id="myForm" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="col-6">
                                    <label for="example-text-input" class="form-label">Employee Name<span
                                            class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <input name="employee_name" value="{{ old('employee_name', $leave->employee->name) }}" class="form-control" type="text" readonly>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="example-text-input" class="form-label">Date<span
                                            class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <input name="date" value="{{ old('date', $leave->date) }}" class="form-control example-date-input" type="date" readonly>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="example-text-input" class="form-label">Leave Type<span
                                            class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <input name="leave_type" value="{{ old('leave_type', $leave->leavetype->leave_type) }}" class="form-control" type="text" readonly>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="example-text-input" class="form-label">Status<span
                                            class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <select name="status" class="form-select" aria-label="Select status">
                                            <option value="approved"
                                                {{ old('status', $leave->status) == 'approved' ? 'selected' : '' }}>Approved
                                            </option>
                                            <option value="not_approved"
                                                {{ old('status', $leave->status) == 'not_approved' ? 'selected' : '' }}>Not Approved
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
@endsection
