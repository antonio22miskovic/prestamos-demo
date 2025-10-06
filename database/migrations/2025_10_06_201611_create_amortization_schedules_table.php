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
        Schema::create('amortization_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained()->onDelete('cascade');
            $table->integer('period_number'); // Número de cuota (1, 2, 3...)
            $table->date('due_date'); // Fecha de vencimiento
            $table->decimal('beginning_balance', 15, 2); // Saldo inicial del período
            $table->decimal('payment_amount', 10, 2); // Monto total de la cuota
            $table->decimal('principal_payment', 10, 2); // Pago a capital
            $table->decimal('interest_payment', 10, 2); // Pago de intereses
            $table->decimal('ending_balance', 15, 2); // Saldo final del período
            $table->enum('status', ['pending', 'paid', 'overdue', 'partial'])->default('pending');
            $table->decimal('amount_paid', 10, 2)->default(0); // Monto pagado
            $table->date('payment_date')->nullable(); // Fecha de pago
            $table->text('notes')->nullable(); // Notas adicionales
            $table->timestamps();
            
            // Índices para mejorar performance
            $table->index(['loan_id', 'period_number']);
            $table->index(['due_date', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amortization_schedules');
    }
};
