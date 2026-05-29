<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->foreignId('responded_by')->nullable()->constrained('users')->nullOnDelete()->after('admin_response');
            $table->timestamp('responded_at')->nullable()->after('responded_by');
        });
    }

    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropColumn(['responded_by', 'responded_at']);
        });
    }
};