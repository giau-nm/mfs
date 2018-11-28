<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->integer('status');
            $table->string('code', 45)->unique();
            $table->string('screen_size', 45);
            $table->string('os', 45);
            $table->string('type', 45);
            $table->string('manufacture', 45);
            $table->string('carrier', 45);
            $table->text('note');
            $table->string('phone_number', 30);
            $table->string('imei', 45);
            $table->string('udid', 45);
            $table->string('serial', 45);
            $table->timestamp('checked_at');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devices');
    }
}
