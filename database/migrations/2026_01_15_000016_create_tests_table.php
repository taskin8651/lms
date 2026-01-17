<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestsTable extends Migration
{
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {

            $table->bigIncrements('id');

            // 🔗 Relations
            $table->unsignedBigInteger('batch_id')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();

            // 📝 Basic Info
            $table->string('title')->nullable();
            $table->string('test_type')->nullable(); // class / unit / mock

            // ⚙️ Test Config
            $table->enum('mode', ['exam', 'practice'])->default('exam');
            $table->integer('total_questions')->default(0);
            $table->integer('total_marks')->default(0);
            $table->integer('duration')->nullable(); // in minutes

            // 🚀 Publish Control
            $table->boolean('is_published')->default(false);

            $table->timestamps();
            $table->softDeletes();

            // 🔐 Foreign Keys (optional but recommended)
            // $table->foreign('batch_id')->references('id')->on('batches')->onDelete('cascade');
            // $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tests');
    }
}
