<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'name')) {
                $table->string('name', 255)->change();
            }
            if (Schema::hasColumn('users', 'email')) {
                $table->string('email', 255)->change();
            }
            if (Schema::hasColumn('users', 'password')) {
                $table->string('password', 60)->change();
            }
            $table->integer('type')->default(0);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'name')) {
                $table->string('name')->change();
            }
            if (Schema::hasColumn('users', 'email')) {
                $table->string('email')->change();
            }
            if (Schema::hasColumn('users', 'password')) {
                $table->string('password')->change();
            }
            $table->dropColumn('type');
            $table->dropColumn('deleted_at');
        });
    }
}
