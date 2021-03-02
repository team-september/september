<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mentee_id')->comment('メンティーID');
            $table->unsignedBigInteger('mentor_id')->comment('メンターID');
            $table->date('date')->comment('予約日');
            $table->time('time')->comment('予約時間');
            $table->unsignedTinyInteger('status')->comment('予約ステータス');
            $table->nullable()->text('mentor_comment')->comment('メンターからのコメント');
            $table->timestamps();

            $table->foreign('mentee_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('mentor_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
