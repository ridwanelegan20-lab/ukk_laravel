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
        Schema::table('books', function (Blueprint $table) {
            // Menambahkan kolom year (tipe integer) setelah kolom category_id
            $table->integer('year')->nullable()->after('category_id');
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            // Untuk menghapus kolom jika migrasi di-rollback
            $table->dropColumn('year');
        });
    }
};
