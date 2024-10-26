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
        Schema::create('mobils', function (Blueprint $table) {
            $table->id();
            $table->string('gambar');
            $table->string('no_plat');
            $table->string('name');
            $table->string('type');
            $table->integer('year');
            $table->decimal('price_per_day', 12, 2);
            $table->decimal('denda', 12, 2);
            $table->enum('availability', ['Tersedia', 'Sold Out']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobils');
    }
};
