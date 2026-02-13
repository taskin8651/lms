<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('study_progress', function (Blueprint $table) {
    $table->id();
    $table->foreignId('study_material_id')->constrained()->onDelete('cascade');
    $table->foreignId('student_id')->constrained()->onDelete('cascade');

    $table->boolean('is_completed')->default(false);
    $table->timestamp('completed_at')->nullable();

    $table->timestamps();

    $table->unique(['study_material_id','student_id']);
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('study_progress');
    }
};
