<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('shifts', function (Blueprint $table) {
            $table->time('begin_date')->nullable()->change();
            $table->time('end_date')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('shifts', function (Blueprint $table) {
            $table->dateTime('begin_date')->nullable()->change();
            $table->dateTime('end_date')->nullable()->change();
        });
    }
};
