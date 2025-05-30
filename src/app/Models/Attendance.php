<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'user_id',
        'start',
        'end',
        'note',
        'attendance_status_id',
        'request_status_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function request_status()
    {
        return $this->belongsTo(RequestStatus::class, 'request_status_id');
    }

    public function attendance_status()
    {
        return $this->belongsTo(AttendanceStatus::class, 'attendance_status_id');
    }

    public function attendance_breaks()
    {
        return $this->hasMany(AttendanceBreak::class);
    }

    public function attendance_request()
    {
        return $this->hasMany(AttendanceRequest::class);
    }
}
