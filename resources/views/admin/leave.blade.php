@extends('layouts.main')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Leave
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Leave</li>
            </ol>
        </section>
        <!-- Main content -->

        @php
        
        $latRef = '35.771263';
        $lonRef = '-5.800296';
        
        function distance($latRef, $lonRef, $latAttendance, $lonAttendance, $unit)
        {
            // echo ' $latAttendance ' . $latAttendance . '<br>';
            // echo ' $lonAttendance ' . $lonAttendance . '<br>';
            // echo ' $latRef ' . $latRef . '<br>';
            // echo ' $lonRef ' . $lonRef . '<br>';
            if ($latRef == $latAttendance && $lonRef == $lonAttendance) {
                return 0;
            } else {
                $theta = $lonRef - $lonAttendance;
                $dist = sin(deg2rad($latRef)) * sin(deg2rad($latAttendance)) + cos(deg2rad($latRef)) * cos(deg2rad($latAttendance)) * cos(deg2rad($theta));
                $dist = acos($dist);
                $dist = rad2deg($dist);
                $miles = $dist * 60 * 1.1515;
                $unit = strtoupper($unit);
        
                if ($unit == 'M') {
                    return $miles * 1.609344 * 1000;
                } elseif ($unit == 'N') {
                    return $miles * 0.8684;
                } else {
                    return $miles;
                }
            }
        }
    @endphp
        <section class="content">
            @include('includes.messages')

            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <a href="/leave/assign" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i
                                    class="fa fa-plus"></i> New</a>
                        </div>
                        <div class="box-body">
                            <table id="example1" class="table table-bordered">
                                <thead>
                                    <th>Date</th>
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Leave</th>
                                    <th>Time In</th>
                                    <th>Time Out</th>
                                    <th>Location</th>
                                </thead>
                                <tbody>
                                    @foreach ($leaves as $leave)
                                        <tr>
                                            <td>{{ $leave->leave_date }}</td>
                                            <td>{{ $leave->user_id }}</td>
                                            <td>{{ $leave->user->name }}</td>
                                            <td>{{ $leave->leave_time }}
                                                @if ($leave->status == 1)
                                                    <span class="label label-warning pull-right">On Time</span>
                                                @else
                                                    <span class="label label-danger pull-right">Early Go</span>
                                                @endif
                                            </td>
                                            <td>{{ $leave->user->schedules->first()->time_in }} </td>
                                            <td>{{ $leave->user->schedules->first()->time_out }}</td>
                                            <td>
                                                @if (isset($leave->latitude) && isset($leave->longitude))
                                                    @if (distance($latRef, $lonRef, $leave->latitude, $leave->longitude, 'M') > 100)
                                                        <a href="https://maps.google.com/?q={{ $leave->latitude }},{{ $leave->longitude }}"
                                                            target="_blank">
                                                            <span class="label label-danger ">Out Of Range</span>
                                                        </a>
                                                        {{-- <br>
                                                        <iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d11050.261470957426!2d{{ $leave->longitude }}!3d{{ $leave->latitude }}!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sfr!2sma!4v1649295957223!5m2!1sfr!2sma"
                                                            width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> --}}
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
