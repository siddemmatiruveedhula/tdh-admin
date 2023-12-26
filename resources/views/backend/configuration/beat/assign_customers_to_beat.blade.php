@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                {{-- <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Beat</h4>
                </div> --}}
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('beat.index') }}">Beat</a></li>
                        <li class="breadcrumb-item active">ASSIGN CUSTOMERS TO BEAT</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">ASSIGN CUSTOMERS TO BEAT</h4><br>


                        @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                            @php
                            Session::forget('success');
                            @endphp
                        </div>
                        @endif
                        <form method="post" class="row g-3" action="{{ route('update-beat-customers', $beat->id) }}" id="myForm"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <div class="col-12">
                                <label for="example-text-input" class="form-label"> Name <span
                                        class="text-danger">*</span></label>
                                <div class="form-group">
                                    <input name="name" value="{{ old('name', $beat->name) }}" class="form-control"
                                        type="text" readonly>
                                    @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="col-12">
                                <label for="example-text-input" class="form-label">Select Customers
                                    {{-- <span class="text-danger">*</span> --}}
                                </label>
                                <div class="form-group">
                                    <select multiple="multiple" name="customers[]" id="customers">
                                        @forelse ($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                        @empty                                            
                                        @endforelse 
                                        @forelse ($beat_customers as $customer)
                                            <option value="{{ $customer->id }}" selected>{{ $customer->name }}</option>
                                        @empty                                            
                                        @endforelse                                        
                                    </select>
                                </div>
                            </div>

                            <div class="text-left">
                                <input type="submit" class="btn btn-info waves-effect waves-light" value="SUBMIT">
                            </div>
                        </form>



                    </div>
                </div>
            </div> <!-- end col -->
        </div>



    </div>
</div>

@endsection
@section('js-scripts')
<script type="text/javascript">
    $(document).ready(function() {
        var select = document.getElementById("customers");
            multi(select, {
                non_selected_header: "Customers",
                selected_header: "Selected Customers"
            });
    });
</script>
@endsection