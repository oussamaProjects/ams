<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Tell the browser to be responsive to screen width -->

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/dist/css/AdminLTE.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="/bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="/plugins/timepicker/bootstrap-timepicker.min.css">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <style type="text/css">
        .mt20 {
            margin-top: 20px;
        }

        .bold {
            font-weight: bold;
        }

        /* chart style*/
        #legend ul {
            list-style: none;
        }

        #legend ul li {
            display: inline;
            padding-left: 30px;
            position: relative;
            margin-bottom: 4px;
            border-radius: 5px;
            padding: 2px 8px 2px 28px;
            font-size: 14px;
            cursor: default;
            -webkit-transition: background-color 200ms ease-in-out;
            -moz-transition: background-color 200ms ease-in-out;
            -o-transition: background-color 200ms ease-in-out;
            transition: background-color 200ms ease-in-out;
        }

        #legend li span {
            display: block;
            position: absolute;
            left: 0;
            top: 0;
            width: 20px;
            height: 100%;
            border-radius: 5px;
        }

    </style>

    @yield('style')

</head>


<body class="hold-transition login-page">
    <div class="login-box">

        @if (\Route::currentRouteName() == 'attendance.QrCode')
            <div class="image m-b-md">
                <img src="/images/pictos/shift-management_software-free.png" alt="shift-management_software-free">
            </div>
            <div class="login-logo">
                Attendance
            </div>
            <div class="login-box-body"> 
                @include('includes.messages')
                <form class="form-horizontal row" id="attendance_leave" method="POST" action="{{ route('attendance.assignQrCode') }}">
        @else
            <div class="image m-b-md">
                <img src="/images/pictos/online-attendance.png" alt="online-attendance">
            </div>
            <div class="login-logo">
                Leave
            </div>
            <div class="login-box-body">
                
                @include('includes.messages')
                <form class="form-horizontal row" id="attendance_leave" method="POST" action="{{ route('leave.assignQrCode') }}">
        @endif

                    @csrf

                    <input type="hidden" name="pin_code" id="code_pin" value="{{ $code_pin }}">
                    <input type="hidden" name="latitude" id="latitude">
                    <input type="hidden" name="longitude" id="longitude"> 
                </form>
        </div>
    </div>

    @include('includes.scripts')

    <script>
        var code_pin = document.getElementById("code_pin");
        var latitude = document.getElementById("latitude");
        var longitude = document.getElementById("longitude");
        var x = document.getElementById("info");

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        latitude.value = position.coords.latitude;
                        longitude.value = position.coords.longitude;
                    },
                    function(error) {
                        switch (error.code) {
                            case error.PERMISSION_DENIED:
                                alert("User denied the request for Geolocation.");
                                x.innerHTML = "User denied the request for Geolocation."
                                break;
                            case error.POSITION_UNAVAILABLE:
                                alert("Location information is unavailable.");
                                x.innerHTML = "Location information is unavailable."
                                break;
                            case error.TIMEOUT:
                                alert("The request to get user location timed out.");
                                x.innerHTML = "The request to get user location timed out."
                                break;
                            case error.UNKNOWN_ERROR:
                                alert("An unknown error occurred.");
                                x.innerHTML = "An unknown error occurred."
                                break;
                        }
                    }, {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    });
            } else {
                alert("Geolocation is not supported by this browser.");
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
        }
        getLocation();

        setTimeout(() => {
            if (code_pin.value != 0 && code_pin.value != null) {
                $('#attendance_leave').submit();
            }
        }, 500);

        $('#attendance_leave').submit(function() {
            if (latitude.value == null || longitude.value == null || latitude.value == 0 || longitude.value == 0) {
                alert('You should enable the GPS to assing yo attendance/leave. Thank you!');
                return false;
            }
            return true; // return false to cancel form action
        });
    </script>

</body>

</html>
