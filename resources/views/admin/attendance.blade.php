@extends('layouts.main')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Attendance
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Attendance</li>
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
                            <a href="/attendance/assign" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i
                                    class="fa fa-plus"></i> New</a>
                        </div>
                        <div class="box-body">
                            <table id="example1" class="table table-bordered">
                                <thead>
                                    <th>Date</th>
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Attendance</th>
                                    <th>Time In</th>
                                    <th>Time Out</th>
                                    <th>Location</th>
                                </thead>
                                <tbody>
                                    @foreach ($attendances as $attendance)
                                        <tr>
                                            <td>{{ $attendance->attendance_date }}</td>
                                            <td>{{ $attendance->user_id }}</td>
                                            <td>{{ $attendance->user->name }}</td>
                                            <td>{{ $attendance->attendance_time }}
                                                @if ($attendance->status == 1)
                                                    <span class="label label-warning pull-right">On Time</span>
                                                @else
                                                    <span class="label label-danger pull-right">Late</span>
                                                @endif
                                            </td>
                                            <td>{{ $attendance->user->schedules->first()->time_in }} </td>
                                            <td>{{ $attendance->user->schedules->first()->time_out }}</td>
                                            <td>
                                                @if ($attendance->latitude!=null && $attendance->longitude!=null &&  $attendance->latitude!=0 && $attendance->longitude!=0)
                                                    @if (distance($latRef, $lonRef, $attendance->latitude, $attendance->longitude, 'M') > 100)
                                                        <a href="https://maps.google.com/?q={{ $attendance->latitude }},{{ $attendance->longitude }}"
                                                            target="_blank">
                                                            <span class="label label-danger ">Out Of Range</span>

                                                        </a>
                                                        {{-- <br>
                                                        <iframe
                                                            src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d11050.261470957426!2d{{ $attendance->longitude }}!3d{{ $attendance->latitude }}!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sfr!2sma!4v1649295957223!5m2!1sfr!2sma"
                                                            width="100%" height="200" style="border:0;" allowfullscreen=""
                                                            loading="lazy"
                                                            referrerpolicy="no-referrer-when-downgrade"></iframe> --}}
                                                            @else

                                                            <a href="https://maps.google.com/?q={{ $attendance->latitude }},{{ $attendance->longitude }}"
                                                                target="_blank">
                                                                <span class="label label-success ">View in map</span>
    
                                                            </a>
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
