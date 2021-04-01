<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAvailableTimes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('available_times', function (Blueprint $table) {
            $table->dropForeign('available_times_availability_id_foreign');
            $table->foreign('availability_id')
            ->references('id')
                ->on('availabilities')
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
        Schema::table('available_times', function (Blueprint $table) {
            $table->dropForeign('available_times_availability_id_foreign');
            $table->foreign('availability_id')
            ->references('id')
                ->on('user')
                ->onDelete('cascade');
        });
    }
}
