<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('seat_id');
            $table->foreign('seat_id')->references('id')->on('seats');

            $table->unsignedBigInteger('showroom_id');
            $table->foreign('showroom_id')->references('id')->on('showrooms')->onDelete('cascade');;

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');;

            $table->unsignedBigInteger('showing_id');
            $table->foreign('showing_id')->references('id')->on('showings')->onDelete('cascade');;

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket');
    }
}
