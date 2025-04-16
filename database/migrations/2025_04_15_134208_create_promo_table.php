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
        Schema::create('promo', function (Blueprint $table) {
            $table->string('kode_promo', 6)->primary();
            $table->string('type');
            $table->decimal('discount', 5, 2);
            $table->datetime('start_date');
            $table->datetime('end_date');
        
            // Relasi opsional ke entitas
            $table->string('kode_kategori', 6)->nullable();
            $table->string('kode_author', 6)->nullable();
            $table->string('kode_publisher', 6)->nullable();
            $table->unsignedBigInteger('user_id')->nullable(); // Member
        
            $table->timestamps();
        
            // Foreign key (optional)
            $table->foreign('kode_kategori')->references('kode_kategori')->on('kategori')->onDelete('set null');
            $table->foreign('kode_author')->references('kode_author')->on('author')->onDelete('set null');
            $table->foreign('kode_publisher')->references('kode_publisher')->on('publisher')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo');
    }
};
