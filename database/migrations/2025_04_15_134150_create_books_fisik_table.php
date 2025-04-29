<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books_fisik', function (Blueprint $table) {
            $table->string('kode_books_fisik', 8)->primary();
            $table->string('title');
            $table->string('kode_kategori', 6);
            $table->string('kode_author', 6);
            $table->string('kode_publisher', 6);
            $table->decimal('harga', 10, 2);
            $table->text('deskripsi')->nullable();
            $table->string('isbn')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();

            $table->foreign('kode_kategori')->references('kode_kategori')->on('kategori')->onDelete('cascade');
            $table->foreign('kode_author')->references('kode_author')->on('author')->onDelete('cascade');
            $table->foreign('kode_publisher')->references('kode_publisher')->on('publisher')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books_fisik');
    }
};