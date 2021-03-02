<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('mentee_id')->comment('メンティーID');
            $table->unsignedBigInteger('mentor_id')->comment('メンターID');
            $table->date('date')->comment('予約日');
            $table->time('time')->comment('予約時間');
            $table->unsignedTinyInteger('status')->comment('予約ステータス');
            $table->text('mentor_comment')->nullable()->comment('メンターからのコメント');
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
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
}
