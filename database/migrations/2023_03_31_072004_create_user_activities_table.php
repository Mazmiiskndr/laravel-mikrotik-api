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
        Schema::create('users_activities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('username', 200)->nullable();
            $table->string('module', 200)->nullable();
            $table->string('page', 200)->nullable();
            $table->string('timestamp', 200)->nullable();
            $table->string('browser_name', 100)->nullable();
            $table->integer('browser_version');
            $table->string('os_name', 100)->nullable();
            $table->string('os_version', 100)->nullable();
            $table->string('device_type', 100)->nullable();
            $table->text('params')->nullable();
            $table->string('ip', 50)->nullable();
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
        Schema::dropIfExists('user_activities');
    }
};
