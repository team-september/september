<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUrlsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('urls', function (Blueprint $table): void {
            $table->id()->comment('URL ID');
            $table->unsignedInteger('url_type')->comment('URL種別'); //1.twitter, 2,github, 3,website, 4.othersのような感じ
            $table->string('url')->comment('URL');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('urls');
    }
}
