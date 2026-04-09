<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_transactions_table.php
    public function up(): void
        {
    Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke siswa
        $table->foreignId('book_id')->constrained()->onDelete('cascade'); // Relasi ke buku
        $table->date('borrow_date');
        $table->date('return_date')->nullable();
        $table->enum('status', ['dipinjam', 'dikembalikan'])->default('dipinjam');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
