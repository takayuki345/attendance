<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceRequest extends Model
{
    use HasFactory;

    public function request_status()
    {
        return $this->belongsTo(RequestStatus::class, 'request_status_id');
    }

    public function attendance_request_breaks()
    {
        return $this->hasMany(AttendanceRequestBreak::class, 'attendance_request_id');
    }

    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }
}
