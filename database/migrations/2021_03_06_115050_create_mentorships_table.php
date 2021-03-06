<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateMentorshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('mentorships'); // mentorships実テーブルが環境にあれば一旦ドロップ

        DB::statement('DROP VIEW IF EXISTS mentorships');
        DB::statement("CREATE VIEW
                            mentorships
                        AS 
                            SELECT mentor_id, mentee_id, (CASE 
                                                            WHEN (SELECT status FROM applications) = 2 THEN true 
                                                            ELSE false
                                                          END) as is_active 
                            FROM applications  
          ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS mentorships');
    }
}
