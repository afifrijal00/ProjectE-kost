<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->date('transfer_date')->nullable()->after('dp_amount');
            $table->string('sender_name')->nullable()->after('transfer_date');
            $table->string('proof_photo')->nullable()->after('sender_name');
        });

        // Tambah 'verify' ke enum dp_status
        DB::statement("ALTER TABLE bookings MODIFY dp_status ENUM('pending','verify','paid') DEFAULT 'pending'");
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['transfer_date', 'sender_name', 'proof_photo']);
        });

        DB::statement("ALTER TABLE bookings MODIFY dp_status ENUM('pending','paid') DEFAULT 'pending'");
    }
};