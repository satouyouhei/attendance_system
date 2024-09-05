<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimestampsViewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
                CREATE OR REPLACE VIEW timestamps_view_table AS SELECT
                u.id,
                u.name,
                t.date_work,
                t.punchIn,
                t.punchOut,
                SEC_TO_TIME(COALESCE(SUM(TIME_TO_SEC(TIMEDIFF(r.rest_end,r.rest_start))),0)) AS rest_total,
                TIMEDIFF(t.punchOut,t.punchIn) AS work_total,
                u.scene
            FROM
                users u
            JOIN
                timestamps t ON u.id = t.user_id
            LEFT JOIN
                rests r ON t.id = r.timestamp_id
            GROUP BY
                u.id,
                u.name,
                t.date_work,
                t.punchIn,
                t.punchOut,
                u.scene
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timestamps_view');
    }
}
