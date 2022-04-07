<?php

namespace App\Http\Controllers;

use App\User;

class AbsenceController extends Controller
{
    /**
     * Display a listing of the attendance.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $absences = User::attendance()->all();
        dd($absences);
        return view('admin.absence')->with(['absences' => $absences]);
    }
}
