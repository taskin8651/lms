<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnouncementsTable extends Migration
{
    public function up()
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->longText('message')->nullable();
            $table->string('publish_date')->nullable();
            $table->string('status')->nullable();
            $table->date('expire_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
