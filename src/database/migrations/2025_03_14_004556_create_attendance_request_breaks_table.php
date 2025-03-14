<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceRequestBreaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_request_breaks', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('attendance_request_id');
            $table->dateTime('break_start');
            $table->dateTime('break_end');
            $table->timestamps();

            $table->primary(['id', 'attendance_request_id']);

            $table->foreign('attendance_request_id')->references('id')->on('attendance_requests')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance_request_breaks');
    }
}
