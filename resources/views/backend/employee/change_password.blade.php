@extends('layouts.master')

@section('title', 'Admin - Change Password')

@section('content')

    <div class="pagetitle">
        <h1>Admins</h1>
        <nav>
            <ol class="breadcrumb">
                   <li class="breadcrumb-item"><a href="{{ route('employee.index') }}">Admin</a></li>
                <li class="breadcrumb-item active">Change Password</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

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
        @elseif(session('err'))
          
            <div class="alert alert-danger" >
                {{ session('err') }}
            </div>
            
        @endif
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Change Password</h5>
                        <form class="row g-3" action="{{ route('update-password') }}" method="POST">
                            @csrf
                            <div class=" col-12">
                                <label for="old_password" class="form-label">Old Password <span
                                        class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="old_password" id="old_password"
                                    value="{{ old('old_password') }}">
                            </div>

                            <div class=" col-12">
                                <label for="new_password" class="form-label">New Password <span
                                        class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="new_password" id="new_password"
                                    value="{{ old('new_password') }}">
                            </div>
                            <div class=" col-12">
                                <label for="confirm_new_password" class="form-label">Confirm New Password <span
                                        class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="confirm_new_password"
                                    id="confirm_new_password" value="{{ old('confirm_new_password') }}">
                                <p class="text-danger" id="message"></p>
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

@endsection
