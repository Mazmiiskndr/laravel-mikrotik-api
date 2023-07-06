<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('root_activity_log', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('username', 100);
            $table->string('action', 200);
            $table->string('ip', 50);
            $table->text('params');
            $table->dateTime('time_of_action');
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
        Schema::dropIfExists('root_activity_log');
    }
};
