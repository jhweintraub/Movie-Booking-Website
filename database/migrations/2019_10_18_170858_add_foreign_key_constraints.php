<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cards', function (Blueprint $table) {
           $table->unsignedBigInteger('user_id')->nullable();
           $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');;
        });

        Schema::table('seats', function (Blueprint $table) {
            $table->unsignedBigInteger('showings_id')->nullable();
            $table->foreign('showings_id')->references('id')->on('showings')->onDelete('cascade');;
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->unsignedBigInteger('booking_id')->nullable();
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');;
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
