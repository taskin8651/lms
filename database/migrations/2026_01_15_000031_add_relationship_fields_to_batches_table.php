<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToBatchesTable extends Migration
{
    public function up()
    {
        Schema::table('batches', function (Blueprint $table) {
            $table->unsignedBigInteger('class_level_id')->nullable();
            $table->foreign('class_level_id', 'class_level_fk_10791566')->references('id')->on('class_levels');
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->foreign('subject_id', 'subject_fk_10791567')->references('id')->on('subjects');
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->foreign('teacher_id', 'teacher_fk_10791568')->references('id')->on('teachers');
            $table->unsignedBigInteger('academic_session_id')->nullable();
            $table->foreign('academic_session_id', 'academic_session_fk_10791730')->references('id')->on('academic_sessions');
        });
    }
}
