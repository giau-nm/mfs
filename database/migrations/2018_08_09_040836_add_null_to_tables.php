<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNullToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add null data to table devices
        Schema::table('devices', function (Blueprint $table) {
            $table->string('screen_size', 45)->nullable()->change();
            $table->string('os', 45)->nullable()->change();
            $table->string('type', 45)->nullable()->change();
            $table->string('manufacture', 45)->nullable()->change();
            $table->string('carrier', 45)->nullable()->change();
            $table->text('note')->nullable()->change();
            $table->string('phone_number', 30)->nullable()->change();
            $table->string('imei', 45)->nullable()->change();
            $table->string('udid', 45)->nullable()->change();
            $table->string('serial', 45)->nullable()->change();
        });

        // Add null data to table requests
        Schema::table('requests', function (Blueprint $table) {
            $table->dateTime('actual_start_time')->nullable()->change();
            $table->dateTime('actual_end_time')->nullable()->change();
            $table->text('note')->nullable()->change();
        });

        // Add null data to table reports
        Schema::table('reports', function (Blueprint $table) {
            $table->text('content')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
