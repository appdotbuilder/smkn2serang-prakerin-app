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
        Schema::create('daily_journals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('placement_id')->constrained('prakerin_placements')->onDelete('cascade');
            $table->date('journal_date');
            $table->text('activities');
            $table->text('learning_outcomes')->nullable();
            $table->text('challenges')->nullable();
            $table->enum('attendance_status', ['present', 'absent', 'sick', 'permission'])->default('present');
            $table->time('clock_in')->nullable();
            $table->time('clock_out')->nullable();
            $table->text('teacher_comment')->nullable();
            $table->text('company_comment')->nullable();
            $table->integer('teacher_rating')->nullable(); // 1-5 scale
            $table->integer('company_rating')->nullable(); // 1-5 scale
            $table->timestamps();
            
            // Unique constraint to prevent duplicate entries per day
            $table->unique(['placement_id', 'journal_date']);
            
            // Indexes for performance
            $table->index('placement_id');
            $table->index('journal_date');
            $table->index('attendance_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_journals');
    }
};