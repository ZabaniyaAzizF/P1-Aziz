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
        Schema::create('top_ups', function (Blueprint $table) {
            $table->string('kode_topups', 8)->primary(); // ID utama
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->decimal('amount', 12, 2); // Jumlah top up
            $table->string('method'); // Metode (manual / transfer)
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending'); // Status
            $table->string('bukti_transfer')->nullable(); // Tambahan: path bukti pembayaran
            $table->timestamp('created_at')->useCurrent(); // Timestamp otomatis
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('top_ups');
    }
};
