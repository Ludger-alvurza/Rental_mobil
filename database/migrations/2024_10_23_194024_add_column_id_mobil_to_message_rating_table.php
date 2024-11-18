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
        Schema::table('message_rating', function (Blueprint $table) {
            $table->unsignedBigInteger('id_mobil')->after('id');

            $table->foreign('id_mobil')->references('id')->on('mobils')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('message_rating', function (Blueprint $table) {
            // Menghapus foreign key dan kolom id_mobil
            $table->dropForeign(['id_mobil']);
            $table->dropColumn('id_mobil');
        });
    }
};
