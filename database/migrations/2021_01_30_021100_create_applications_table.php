<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(
            'applications',
            function (Blueprint $table): void {
                $table->id();
                $table->unsignedBigInteger('mentee_id')->comment('メンティーID');
                $table->unsignedBigInteger('mentor_id')->comment('メンターID');
                $table->unsignedTinyInteger('status')->comment('応募ステータス');
                $table->timestamp('approved_at')->nullable()->comment('承認日');
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
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
}
