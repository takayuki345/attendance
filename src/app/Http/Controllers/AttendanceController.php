<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index($id)
    {
        if($id == 1) {

            return view('attendance-detail-edit');

        } elseif($id == 2) {

            return view('attendance-detail');

        }
    }
}
