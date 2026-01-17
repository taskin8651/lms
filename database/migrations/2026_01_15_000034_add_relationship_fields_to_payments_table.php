<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPaymentsTable extends Migration
{
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedBigInteger('batch_student_id')->nullable();
            $table->foreign('batch_student_id', 'batch_student_fk_10791597')->references('id')->on('batch_students');
        });
    }
}
