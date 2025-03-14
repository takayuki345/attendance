<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestStatus extends Model
{
    use HasFactory;

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'request_status_id');
    }

    public function attendance_requests()
    {
        return $this->hasMany(AttendanceRequest::class, 'request_status_id');
    }
}
