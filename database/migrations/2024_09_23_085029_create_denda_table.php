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
        Schema::create('denda', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_transaction')->nullable();
            $table->bigInteger('id_mobil')->nullable();
            $table->decimal('price',20,0);
            $table->integer('qty');
            $table->decimal('total',20,0);
            $table->decimal('denda',20,0);
            $table->decimal('denda1',20,0);
            $table->decimal('denda2',20,0);
            $table->decimal('denda3',20,0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('denda');
    }
};
