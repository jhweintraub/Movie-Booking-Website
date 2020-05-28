<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SecondForeignKeyConstraintUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('card_id')->nullable();
            $table->foreign('card_id')->references('id')->on('cards')->onDelete('cascade');
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->unsignedBigInteger('ticket_type_id')->nullable();
            $table->foreign('ticket_type_id')->references('id')->on('ticket_types')->onDelete('cascade');;
        });

        Schema::table('showings', function (Blueprint $table) {
            $table->unsignedBigInteger('showroom_id');
            $table->foreign('showroom_id')->references('id')->on('showrooms')->onDelete('cascade');;
            $table->unique(['dateTime', 'showroom_id']);
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
