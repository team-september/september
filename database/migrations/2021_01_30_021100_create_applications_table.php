<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'applications',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('mentee_id');
                $table->unsignedBigInteger('mentor_id');
                $table->timestamps();

                $table->foreign('mentee_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
                $table->foreign('mentor_id')
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
        Schema::dropIfExists('applications');
    }
}
