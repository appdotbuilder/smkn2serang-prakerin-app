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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nip')->unique();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('subject')->nullable();
            $table->enum('role', ['supervising_teacher', 'homeroom_teacher', 'vice_principal'])->default('supervising_teacher');
            $table->string('homeroom_class')->nullable(); // For homeroom teachers
            $table->timestamps();
            
            // Indexes for performance
            $table->index('nip');
            $table->index('role');
            $table->index('homeroom_class');
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};