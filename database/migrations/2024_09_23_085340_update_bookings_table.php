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
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('id_user')->after('id')->nullable(); // Menambahkan kolom id_user setelah kolom id
            $table->enum('pembatalan', ['Dipesan', 'Dibatalkan','Terverifikasi'])->after('id_user')->default('Dipesan'); // Menambahkan kolom Pembatalan setelah kolom id_user
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('id_user');
            $table->dropColumn('pembatalan');
        });
    }
};
