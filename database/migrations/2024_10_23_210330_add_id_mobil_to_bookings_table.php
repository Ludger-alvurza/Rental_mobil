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
            $table->unsignedBigInteger('id_mobil')->nullable(); // Menambahkan kolom id_mobil
            $table->foreign('id_mobil')->references('id')->on('mobils')->onDelete('cascade'); // Membuat foreign key
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['id_mobil']); // Drop foreign key dulu
            $table->dropColumn('id_mobil'); // Hapus kolom id_mobil
        });
    }
};
