<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestAttemptsTable extends Migration
{
    public function up()
    {
        Schema::create('test_attempts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('test_id')
                  ->constrained('tests')
                  ->onDelete('cascade');

            $table->foreignId('batch_student_id')
                  ->constrained('batch_students')
                  ->onDelete('cascade');

            $table->integer('attempt_no')->default(1);

            $table->integer('total_questions')->default(0);
            $table->integer('attempted')->default(0);
            $table->integer('correct')->default(0);
            $table->integer('wrong')->default(0);

            $table->decimal('score', 6, 2)->default(0);
            $table->decimal('percentage', 5, 2)->default(0);

            $table->enum('status', ['in_progress', 'completed'])
                  ->default('in_progress');

            $table->timestamp('started_at')->nullable();
            $table->timestamp('submitted_at')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('test_attempts');
    }
}

