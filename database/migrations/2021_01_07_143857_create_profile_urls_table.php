<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileUrlsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profile_urls', function (Blueprint $table): void {
            $table->id()->comment('ユーザーURL_ID');
            $table->unsignedBigInteger('profile_id')->comment('プロフィールID');
            $table->unsignedBigInteger('url_id')->comment('URL ID');
            $table->timestamps();

            $table->foreign('profile_id')
                ->references('id')
                ->on('profiles')
                ->onDelete('cascade');
            $table->foreign('url_id')
                ->references('id')
                ->on('urls')
                ->onDelete('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_urls');
    }
}
