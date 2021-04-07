<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAvailableTimes extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('available_times', function (Blueprint $table): void {
            $table->dropForeign('available_times_availability_id_foreign');
            $table->foreign('availability_id')
                ->references('id')
                ->on('availabilities')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('available_times', function (Blueprint $table): void {
            $table->dropForeign('available_times_availability_id_foreign');
            $table->foreign('availability_id')
                ->references('id')
                ->on('user')
                ->onDelete('cascade');
        });
    }
}
