<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToAttendancesTable extends Migration
{
    public function up()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->unsignedBigInteger('batch_student_id')->nullable();
            $table->foreign('batch_student_id', 'batch_student_fk_10791618')->references('id')->on('batch_students');
            $table->unsignedBigInteger('marked_by_id')->nullable();
            $table->foreign('marked_by_id', 'marked_by_fk_10791631')->references('id')->on('teachers');
        });
    }
}
