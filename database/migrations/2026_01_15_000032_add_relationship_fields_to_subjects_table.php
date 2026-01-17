<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSubjectsTable extends Migration
{
    public function up()
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->unsignedBigInteger('class_level_id')->nullable();
            $table->foreign('class_level_id', 'class_level_fk_10791560')->references('id')->on('class_levels');
        });
    }
}
