<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToBookingsTable extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->date('booking_start')->nullable(); // Tambahin kolom booking_start
            $table->date('booking_end')->nullable();   // Tambahin kolom booking_end
            $table->enum('payment_status', ['Pending', 'Paid', 'Canceled'])->default('Pending'); // Tambahin kolom payment_status
            $table->enum('booking_status', ['Pending','Confirmed', 'In Progress', 'Completed'])->default('Pending'); // Tambahin kolom booking_status
            $table->decimal('total_amount', 12, 2)->nullable(); // Tambahin kolom total_amount
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('booking_start');
            $table->dropColumn('booking_end');
            $table->dropColumn('payment_status');
            $table->dropColumn('booking_status');
            $table->dropColumn('total_amount');
        });
    }
}

