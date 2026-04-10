<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            // Menambahkan kolom 'image' yang posisinya setelah kolom 'author'
            // nullable() artinya kolom ini boleh kosong jika buku tidak ada gambarnya
            $table->string('image')->nullable()->after('author'); 
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};