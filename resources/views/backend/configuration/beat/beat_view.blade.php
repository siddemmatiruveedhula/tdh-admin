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
                        <li class="breadcrumb-item active">BEAT Details</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- end page title -->


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $eod->employee->name }}  Beat Details on {{ $eod->date->format('d-m-Y') }}</h4>
                        <table class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <th width="5%">Sl</th>
                                <th>Date & Time</th>
                                <th>Location</th>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $order->created_at->format('d-m-Y h:i A') }}</td>
                                    <td>
                                        @if($order->latitude && $order->longitude)
                                        <div style="height:300px;">
                                            <iframe
                                                src="https://www.google.com/maps?q={{ $order->latitude }},{{ $order->longitude }}&hl=es;z=14&output=embed"
                                                style="width:100%;height:100%"></iframe>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>
            </div> <!-- end col -->
        </div>



    </div>
</div>

@endsection