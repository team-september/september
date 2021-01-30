<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReadApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'read_applications',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('application_id')->comment('応募ID');
                $table->unsignedBigInteger('user_id')->comment('ユーザーID');
                $table->timestamps();

                $table->foreign('application_id')
                    ->references('id')
                    ->on('applications')
                    ->onDelete('cascade');
                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('read_applications');
    }
}
