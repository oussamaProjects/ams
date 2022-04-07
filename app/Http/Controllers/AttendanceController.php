<?php

namespace App\Http\Controllers;

use DateTime;
use App\User;
use App\Latetime;
use App\Attendance;
use App\Http\Requests\AttendanceEmp;
use Stevebauman\Location\Facades\Location;


class AttendanceController extends Controller
{

    /**
     * Display a listing of the attendance.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // if ($position = Location::get('196.112.21.179')) {
        //     // Successfully retrieved position.
        //     dd( $position);
        // } else {
        //     // Failed retrieving position.
        // }


        // $ip = \Request::ip(); 
        // $location = geoip()->getLocation('196.112.21.179');
        // // $location = geoip()->getLocation($ip);
        // dd($location);
        $attendances = Attendance::where('attendance_date', date("Y-m-d"))->get();
        return view('admin.attendance')->with(['attendances' => $attendances]);
    }

    /**
     * Display a listing of the latetime.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexLatetime()
    {
        return view('admin.latetime')->with(['latetimes' => Latetime::all()]);
    }

    /**
     * Display a listing of the latetime.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAbsence()
    {
        // $absences = User::attendance();
        // dd($absences);
        return view('admin.absence')->with(['absences' => $absences]);
    }

    /**
     * assign attendance to employee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function assign(AttendanceEmp $request)
    {
        $request->validated();

        if ($employee = User::where('pin_code', $request->pin_code)->first()) {
            // if ($employee = User::whereEmail(request('email'))->first()) {
            // if (Hash::check($request->pin_code, $employee->pin_code)) {
            if (Attendance::whereAttendance_date(date("Y-m-d"))->whereUser_id($employee->id)->get()->count() < 2) {
                // if (!Attendance::whereAttendance_date(date("Y-m-d"))->whereUser_id($employee->id)->first()) {
                $attendance = new Attendance;
                $attendance->user_id = $employee->id;
                $attendance->attendance_time = date("H:i:s");
                $attendance->attendance_date = date("Y-m-d");
                $attendance->latitude = $request->latitude;
                $attendance->longitude = $request->longitude;

                $latetime_nv_2 = new DateTime($employee->schedules->first()->time_in);
                $latetime_nv_1 = new DateTime($employee->schedules->first()->time_in);

                $latetime_nv_2->modify('+15 minutes');
                $latetime_nv_1->modify('+10 minutes');

                if (!($employee->schedules->first()->time_in >= $latetime_nv_2)) {
                    $attendance->status = 2;
                    AttendanceController::lateTime($employee);
                } elseif (!($employee->schedules->first()->time_in >= $latetime_nv_1)) {
                    $attendance->status = 0;
                    AttendanceController::lateTime($employee);
                };

                $attendance->save();
            } else {
                return redirect()->route('leave.login')->with('error', 'you assigned your attendance before');
            }
            // } else {
            //     return redirect()->route('leave.login')->with('error', 'Failed to assign the attendance');
            // }
        } else
            return redirect()->route('attendance.login')->with('error', 'this code do not exist');


        return redirect()->route('leave.login')->with('success', 'Successful in assign the attendance');
    }
    /**
     * assignQrCode attendance to employee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function assignQrCode(AttendanceEmp $request)
    {
        $request->validated();

        if ($employee = User::where('pin_code', $request->pin_code)->first()) {
            // if ($employee = User::whereEmail(request('email'))->first()) {
            // if (Hash::check($request->pin_code, $employee->pin_code)) {
            if (Attendance::whereAttendance_date(date("Y-m-d"))->whereUser_id($employee->id)->get()->count() < 2) {
                // if (!Attendance::whereAttendance_date(date("Y-m-d"))->whereUser_id($employee->id)->first()) {
                $attendance = new Attendance;
                $attendance->user_id = $employee->id;
                $attendance->attendance_time = date("H:i:s");
                $attendance->attendance_date = date("Y-m-d");
                $attendance->latitude = $request->latitude;
                $attendance->longitude = $request->longitude;

                $latetime_nv_2 = new DateTime($employee->schedules->first()->time_in);
                $latetime_nv_1 = new DateTime($employee->schedules->first()->time_in);

                $latetime_nv_2->modify('+15 minutes');
                $latetime_nv_1->modify('+10 minutes');

                if (!($employee->schedules->first()->time_in >= $latetime_nv_2)) {
                    $attendance->status = 2;
                    AttendanceController::lateTime($employee);
                } elseif (!($employee->schedules->first()->time_in >= $latetime_nv_1)) {
                    $attendance->status = 0;
                    AttendanceController::lateTime($employee);
                };

                $attendance->save();
            } else {
                return redirect()->route('attendance.QrCode')->with('error', 'you assigned your attendance before');
            }
            // } else {
            //     return redirect()->route('attendance.QrCode')->with('error', 'Failed to assign the attendance');
            // }
        } else
            return redirect()->route('attendance.QrCode')->with('error', 'this code do not exist');


        return redirect()->route('attendance.QrCode')->with('success', 'Successful in assign the attendance');
    }

    /**
     * assign late time for attendace .
     *
     * @return \Illuminate\Http\Response
     */
    public static function lateTime(User $employee)
    {
        $current_t = new DateTime(date("H:i:s"));
        $start_t = new DateTime($employee->schedules->first()->time_in);
        $difference = $start_t->diff($current_t)->format('%H:%I:%S');

        $latetime = new Latetime;
        $latetime->user_id = $employee->id;
        $latetime->duration = $difference;
        $latetime->latetime_date  = date("Y-m-d");
        $latetime->save();
    }
}
