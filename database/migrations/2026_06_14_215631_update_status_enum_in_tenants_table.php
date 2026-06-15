<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE tenants MODIFY status ENUM('active','pending','past','checkout_requested','inactive') DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE tenants MODIFY status ENUM('active','pending','past') DEFAULT 'pending'");
    }
};