<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table): void {
            $table->id()->comment('ユーザーID');
            $table->string('sub')->unique()->comment('ユーザー識別子');
            $table->boolean('is_mentor')->comment('メンターフラグ');
            $table->string('nickname')->comment('ニックネーム');
            $table->string('name')->comment('名前');
            $table->string('picture')->comment('画像');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
}
