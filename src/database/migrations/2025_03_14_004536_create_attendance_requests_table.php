<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_requests', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->dateTime('start');
            $table->dateTime('end');
            $table->string('note');
            $table->foreignId('request_status_id')->constrained('request_statuses', 'id');
            $table->dateTime('request_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance_requests');
    }
}
