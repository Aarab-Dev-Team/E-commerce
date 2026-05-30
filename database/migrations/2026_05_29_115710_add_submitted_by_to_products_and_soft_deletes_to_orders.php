<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('submitted_by')->nullable()->constrained('users')->nullOnDelete()->after('original_data');
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete()->after('submitted_by');
            $table->timestamp('reviewed_at')->nullable()->after('reviewed_by');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['submitted_by']);
            $table->dropForeign(['reviewed_by']);
            $table->dropColumn(['submitted_by', 'reviewed_by', 'reviewed_at']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
