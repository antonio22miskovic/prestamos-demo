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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->foreignId('loan_application_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('amount', 12, 2);
            $table->decimal('interest_rate', 5, 2); // Annual interest rate
            $table->integer('term_months');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['draft', 'pending', 'approved', 'rejected', 'active', 'paid', 'defaulted'])->default('draft');
            $table->decimal('monthly_fee', 10, 2);
            $table->decimal('total_amount', 12, 2); // Total amount to be paid
            $table->text('approval_note')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
