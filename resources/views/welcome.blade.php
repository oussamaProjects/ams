<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href="/dist/css/clock.css" rel="stylesheet">

    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
            display: none
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links>a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        .clockStyle {
            font-size: 2rem;
            margin: 0 auto;
            padding: 10px;
            color: #000000;
            text-align: center;
        }

    </style>
</head>

<body>
    <div class="flex-center position-ref full-height">
        @if (Route::has('login'))
            <div class="top-right links">
                @auth
                    <a href="{{ url('/home') }}">Home</a>
                @else
                    <a href="{{ route('login') }}">Login</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Register</a>
                    @endif
                @endauth
            </div>
        @endif

        <div class="content">


            {{-- <div class="image m-b-md">
                <img src="/images/pictos/attendance_tracking_software.png" alt=attendance_tracking_software">
            </div> --}}

            <div class="m-b-md">
                {{-- <div class="clockStyle" id="clock">123</div> --}}
                <div id="clock" class="progress-clock">
                    <button class="progress-clock__time-date" data-group="d" type="button">
                        <small data-unit="w">Sunday</small><br>
                        <span data-unit="mo">January</span>
                        <span data-unit="d">1</span>
                    </button>
                    <button class="progress-clock__time-digit" data-unit="h" data-group="h"
                        type="button">12</button><span class="progress-clock__time-colon">:</span><button
                        class="progress-clock__time-digit" data-unit="m" data-group="m" type="button">00</button><span
                        class="progress-clock__time-colon">:</span><button class="progress-clock__time-digit"
                        data-unit="s" data-group="s" type="button">00</button>
                    <span class="progress-clock__time-ampm" data-unit="ap">AM</span>
                    <svg class="progress-clock__rings" width="256" height="256" viewBox="0 0 256 256">
                        <defs>
                            <linearGradient id="pc-red" x1="1" y1="0.5" x2="0" y2="0.5">
                                <stop offset="0%" stop-color="#f953c6" />
                                <stop offset="100%" stop-color="#b91d73" />
                            </linearGradient>
                            <linearGradient id="pc-yellow" x1="1" y1="0.5" x2="0" y2="0.5">
                                <stop offset="0%" stop-color="#00B4DB" />
                                <stop offset="100%" stop-color="#0083B0" />
                            </linearGradient>
                            <linearGradient id="pc-blue" x1="1" y1="0.5" x2="0" y2="0.5">
                                <stop offset="0%" stop-color="#8E2DE2" />
                                <stop offset="100%" stop-color="#4A00E0" />
                            </linearGradient>
                            <linearGradient id="pc-purple" x1="1" y1="0.5" x2="0" y2="0.5">
                                <stop offset="0%" stop-color="#FF416C" />
                                <stop offset="100%" stop-color="#FF4B2B" />
                            </linearGradient>
                        </defs>
                        <!-- Days of Month -->
                        <g data-units="d">
                            <circle class="progress-clock__ring" cx="128" cy="128" r="74" fill="none" opacity="0.1"
                                stroke="url(#pc-red)" stroke-width="12" />
                            <circle class="progress-clock__ring-fill" data-ring="mo" cx="128" cy="128" r="74"
                                fill="none" stroke="url(#pc-red)" stroke-width="12" stroke-dasharray="465 465"
                                stroke-dashoffset="465" stroke-linecap="round" transform="rotate(-90,128,128)" />
                        </g>
                        <!-- Hours of Day -->
                        <g data-units="h">
                            <circle class="progress-clock__ring" cx="128" cy="128" r="90" fill="none" opacity="0.1"
                                stroke="url(#pc-yellow)" stroke-width="12" />
                            <circle class="progress-clock__ring-fill" data-ring="d" cx="128" cy="128" r="90" fill="none"
                                stroke="url(#pc-yellow)" stroke-width="12" stroke-dasharray="565.5 565.5"
                                stroke-dashoffset="565.5" stroke-linecap="round" transform="rotate(-90,128,128)" />
                        </g>
                        <!-- Minutes of Hour -->
                        <g data-units="m">
                            <circle class="progress-clock__ring" cx="128" cy="128" r="106" fill="none" opacity="0.1"
                                stroke="url(#pc-blue)" stroke-width="12" />
                            <circle class="progress-clock__ring-fill" data-ring="h" cx="128" cy="128" r="106"
                                fill="none" stroke="url(#pc-blue)" stroke-width="12" stroke-dasharray="666 666"
                                stroke-dashoffset="666" stroke-linecap="round" transform="rotate(-90,128,128)" />
                        </g>
                        <!-- Seconds of Minute -->
                        <g data-units="s">
                            <circle class="progress-clock__ring" cx="128" cy="128" r="122" fill="none" opacity="0.1"
                                stroke="url(#pc-purple)" stroke-width="12" />
                            <circle class="progress-clock__ring-fill" data-ring="m" cx="128" cy="128" r="122"
                                fill="none" stroke="url(#pc-purple)" stroke-width="12" stroke-dasharray="766.5 766.5"
                                stroke-dashoffset="766.5" stroke-linecap="round" transform="rotate(-90,128,128)" />
                        </g>
                    </svg>
                </div>

            </div>

            <div class="links">

                @if (isset($code_pin))
                    <a href="/attendance/assignQrCode/{{ $code_pin }}" class="attendance">Attendance</a>
                    <a href="#"></a>
                    <a href="/leave/assignQrCode/{{ $code_pin }}" class="leave">Leave</a>
                @else
                    <a href="/attendance/assign" class="attendance">Attendance</a>
                    <a href="#"></a>
                    <a href="/leave/assign" class="leave">Leave</a>
                @endif



            </div>
        </div>
    </div>

    <script type="text/javascript">
        // setInterval(displayclock, 500);

        // function displayclock() {
        //     var time = new Date();
        //     var hrs = time.getHours();
        //     var min = time.getMinutes();
        //     var sec = time.getSeconds();
        //     var en = 'AM';
        //     if (hrs > 12) {
        //         en = 'PM';
        //     }
        //     if (hrs > 12) {
        //         hrs = hrs - 12;
        //     }
        //     if (hrs == 0) {
        //         hrs = 12;
        //     }
        //     if (hrs < 10) {
        //         hrs = '0' + hrs;
        //     }
        //     if (min < 10) {
        //         min = '0' + min;
        //     }
        //     if (sec < 10) {
        //         sec = '0' + sec;
        //     }
        //     document.getElementById("clock").innerHTML = hrs + ':' + min + ':' + sec + ' ' + en;
        // }
    </script>

    <script src="/dist/js/clock.js"></script>
</body>

</html>
