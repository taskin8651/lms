<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveClassesTable extends Migration
{
    public function up()
    {
        Schema::create('live_classes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('class_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('class_type')->nullable();
            $table->string('meeting_link')->nullable();
            $table->string('topic')->nullable();
            $table->string('description')->nullable();
            $table->longText('recording_link')->nullable();
            $table->string('status')->nullable();
            $table->longText('remark')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
