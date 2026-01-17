<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatchStudentsTable extends Migration
{
    public function up()
    {
        Schema::create('batch_students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->datetime('joining_date')->nullable();
            $table->string('status')->nullable();
            $table->string('discount')->nullable();
            $table->longText('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
