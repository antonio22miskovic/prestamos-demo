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
        Schema::create('loan_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->json('loan_data'); // Store loan application data as JSON
            $table->integer('current_step')->default(1);
            $table->enum('status', ['draft', 'pending', 'approved', 'rejected'])->default('draft');
            $table->string('purpose')->nullable(); // Step 1: Purpose of loan
            $table->decimal('amount', 12, 2)->nullable(); // Step 2: Amount requested
            $table->integer('term_months')->nullable(); // Step 2: Term in months
            $table->boolean('has_previous_loans')->default(false); // Step 2: Previous loans
            $table->decimal('evaluation_score', 5, 2)->nullable(); // Evaluation score
            $table->text('evaluation_notes')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('evaluated_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_applications');
    }
};
