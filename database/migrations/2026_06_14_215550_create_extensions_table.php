<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('extensions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->integer('duration'); // bulan tambahan: 1, 3, 6, 12
            $table->decimal('amount', 12, 2); // total bayar (full)
            $table->date('transfer_date')->nullable();
            $table->string('sender_name')->nullable();
            $table->string('proof_photo')->nullable();
            $table->enum('status', ['pending', 'verify', 'approved', 'rejected'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('extensions');
    }
};