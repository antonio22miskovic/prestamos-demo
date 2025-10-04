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
            // Index for client_id and status queries
            $table->index(['client_id', 'status']);
            // Index for client_id and created_at for ordering
            $table->index(['client_id', 'created_at']);
        });

        Schema::table('loans', function (Blueprint $table) {
            // Index for client_id and status queries
            $table->index(['client_id', 'status']);
        });

        Schema::table('client_documents', function (Blueprint $table) {
            // Index for client_id queries
            $table->index('client_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loan_applications', function (Blueprint $table) {
            $table->dropIndex(['client_id', 'status']);
            $table->dropIndex(['client_id', 'created_at']);
        });

        Schema::table('loans', function (Blueprint $table) {
            $table->dropIndex(['client_id', 'status']);
        });

        Schema::table('client_documents', function (Blueprint $table) {
            $table->dropIndex(['client_id']);
        });
    }
};
