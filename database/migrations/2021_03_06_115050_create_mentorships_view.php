<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMentorshipsView extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('mentorships'); // 実テーブルドロップ

        DB::statement('DROP VIEW IF EXISTS mentorships');
        DB::statement('CREATE VIEW
                            mentorships
                        AS 
                             SELECT mentor_id, mentee_id, (CASE 
                                                                WHEN STATUS = 2 THEN true 
                                                                ELSE false 
                                                            END) as is_active 
                             from applications;
          ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS mentorships');
    }
}
