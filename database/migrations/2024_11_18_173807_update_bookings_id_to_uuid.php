<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB; // Ini juga kalau lo pakai query di `DB::table()`

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Step 1: Tambahkan kolom UUID baru
        // Schema::table('bookings', function (Blueprint $table) {
        //     $table->uuid('uuid')->nullable();
        // });

        // Step 2: Generate UUID untuk data yang sudah ada
        // Step 2: Generate UUID untuk data lama
        // DB::table('bookings')->get()->each(function ($booking) {
        //     if (!$booking->uuid) {
        //         DB::table('bookings')
        //             ->where('id', $booking->id)
        //             ->update(['uuid' => (string) Str::uuid()]);
        //     }
        // });

        // // Step 3: Nonaktifkan auto-increment dari kolom ID lama
        // Schema::table('bookings', function (Blueprint $table) {
        //     $table->dropPrimary(); // Drop primary key dulu
        //     $table->unsignedBigInteger('id')->change(); // Hapus auto-increment
        // });

        // // Step 4: Jadikan UUID sebagai primary key
        // Schema::table('bookings', function (Blueprint $table) {
        //     $table->uuid('id')->primary()->change();
        // });

        // // Step 5: Hapus kolom UUID sementara
        // Schema::table('bookings', function (Blueprint $table) {
        //     if (Schema::hasColumn('bookings', 'uuid')) {
        //         $table->dropColumn('uuid');
        //     }
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('bookings', function (Blueprint $table) {
        //     $table->dropPrimary(); // Drop primary key UUID
        // });
    
        // // Pastikan kolom 'id' yang lama ada, jika belum ada, buat lagi
        // Schema::table('bookings', function (Blueprint $table) {
        //     if (!Schema::hasColumn('bookings', 'id')) {
        //         $table->unsignedBigInteger('id')->autoIncrement()->primary();
        //     }
        // });
    }
};
