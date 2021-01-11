<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileSkillsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profile_skills', function (Blueprint $table): void {
            $table->id()->comment('ユーザースキルID');
            $table->unsignedBigInteger('profile_id')->comment('プロフィールID');
            $table->unsignedBigInteger('skill_id')->comment('スキルID');
            $table->timestamps();

            $table->foreign('profile_id')
                ->references('id')
                ->on('profiles')
                ->onDelete('cascade');
            $table->foreign('skill_id')
                ->references('id')
                ->on('skills')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_skills');
    }
}
