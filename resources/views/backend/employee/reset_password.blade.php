@extends('admin.admin_master')
@section('admin')


    <div class="page-content">
        <div class="container-fluid">
            <div class="pagetitle">
                <h3>Employee</h3>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('employee.all') }}">Employee</a></li>
                        <li class="breadcrumb-item active">Reset Password</li>
                    </ol>
                </nav>
            </div><!-- End Page Title -->
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Reset Password</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <section class="section">
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
                    <div class="col-lg-12">

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $user->name }}</h5>
                                <form class="row g-3" action="{{ route('update-reset-password', $user->id) }}"
                                    method="POST">
                                    @csrf

                                    <div class="col-12">
                                        <label for="new_password" class="form-label">New Password <span
                                                class="text-danger">*</span></label>
                                        <input type="password" class="form-control" name="new_password" id="new_password"
                                            value="{{ old('new_password') }}">
                                    </div>


                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

@endsection
