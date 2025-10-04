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
        Schema::table('loan_applications', function (Blueprint $table) {
            $table->json('loan_data')->nullable()->change();
            $table->string('purpose')->nullable()->change();
            $table->timestamp('submitted_at')->nullable()->change();
            $table->timestamp('evaluated_at')->nullable()->change();
            $table->text('evaluation_notes')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loan_applications', function (Blueprint $table) {
            $table->json('loan_data')->nullable(false)->change();
            $table->string('purpose')->nullable(false)->change();
            $table->timestamp('submitted_at')->nullable(false)->change();
            $table->timestamp('evaluated_at')->nullable(false)->change();
            $table->text('evaluation_notes')->nullable(false)->change();
        });
    }
};
