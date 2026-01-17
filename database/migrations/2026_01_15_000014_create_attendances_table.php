<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->datetime('attendance_date')->nullable();
            $table->datetime('punch_in_time')->nullable();
            $table->datetime('punch_out_time')->nullable();
            $table->string('status')->nullable();
            $table->string('punch_in_lat')->nullable();
            $table->string('punch_in_lng')->nullable();
            $table->longText('punch_in_location')->nullable();
            $table->string('punch_out_lat')->nullable();
            $table->string('punch_out_lng')->nullable();
            $table->longText('punch_out_loc')->nullable();
            $table->longText('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
