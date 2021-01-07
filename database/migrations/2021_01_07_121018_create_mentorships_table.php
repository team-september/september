<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMentorshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mentorships', function (Blueprint $table) {
            $table->id()->comment('メンターシップID');
            $table->unsignedBigInteger('mentor_id')->comment('メンターID');
            $table->unsignedBigInteger('mentee_id')->comment('メンティーID');
            $table->boolean('is_active')->defalut(true)->comment('アクティブフラグ');
            $table->timestamps();

            $table->foreign('mentor_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('mentee_id')
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
        Schema::dropIfExists('mentorships');
    }
}
