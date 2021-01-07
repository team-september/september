<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilePurposesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_purposes', function (Blueprint $table) {
            $table->id()->comment('ユーザー目的ID');
            $table->unsignedBigInteger('profile_id')->comment('プロフィールID');
            $table->unsignedBigInteger('purpose_id')->comment('目的ID');
            $table->timestamps();

            $table->foreign('profile_id')
                ->references('id')
                ->on('profiles')
                ->onDelete('cascade');
            $table->foreign('purpose_id')
                ->references('id')
                ->on('purposes')
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
        Schema::dropIfExists('profile_purposes');
    }
}
