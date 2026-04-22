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
        Schema::table('products', function (Blueprint $table) {
            

            $table->enum('pending_status', ['pending_creation', 'pending_update', 'pending_deletion', 'approved'])
                ->default('approved')
                ->after('is_active'); 

            $table->json('pending_data')->nullable(); 

            $table->json('original_data')->nullable(); 


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['pending_status', 'pending_data', 'original_data']);
        });
    }
};
