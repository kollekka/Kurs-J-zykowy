<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('language', 50);
            $table->enum('level', ['Beginner', 'Intermediate', 'Advanced']);
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('price', 10, 2);
            $table->foreignId('instructor_id')->constrained('instructors')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('courses');
    }
};
