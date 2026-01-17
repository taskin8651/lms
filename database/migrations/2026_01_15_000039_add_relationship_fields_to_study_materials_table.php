<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToStudyMaterialsTable extends Migration
{
    public function up()
    {
        Schema::table('study_materials', function (Blueprint $table) {
            $table->unsignedBigInteger('chapter_id')->nullable();
            $table->foreign('chapter_id', 'chapter_fk_10791696')->references('id')->on('chapters');
        });
    }
}
