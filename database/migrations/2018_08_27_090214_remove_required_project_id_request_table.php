<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveRequiredProjectIdRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requests', function (Blueprint $table)
        {
            if (Schema::hasColumn('requests', 'project_id')) {
                $table->integer('project_id')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requests', function (Blueprint $table)
        {
            if (Schema::hasColumn('requests', 'project_id')) {
                $table->integer('project_id')->change();
            }
        });
    }
}
