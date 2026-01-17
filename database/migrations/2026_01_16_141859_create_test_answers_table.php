<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestAnswersTable extends Migration
{
    public function up()
    {
        Schema::create('test_answers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('test_attempt_id')
                  ->constrained('test_attempts')
                  ->onDelete('cascade');

            $table->foreignId('question_id')
                  ->constrained('questions')
                  ->onDelete('cascade');

            $table->string('selected_option')->nullable(); // a,b,c,d
            $table->boolean('is_correct')->default(false);

            $table->decimal('marks_obtained', 6, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('test_answers');
    }
}
