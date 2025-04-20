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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_id')->constrained('enrollments')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->timestamp('payment_date')->useCurrent();
            $table->enum('payment_method', ['card', 'bank_transfer', 'paypal']);
            $table->enum('status', ['paid', 'pending', 'failed']);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('payments');
    }
};
