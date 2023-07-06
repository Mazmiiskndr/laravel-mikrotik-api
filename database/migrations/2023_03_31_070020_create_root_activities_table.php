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
        Schema::create('root_activities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('username', 200)->nullable();
            $table->string('module', 200)->nullable();
            $table->string('page', 200)->nullable();
            $table->string('timestamp', 200)->nullable();
            $table->string('browser_name', 200)->nullable();
            $table->integer('browser_version');
            $table->string('os_name', 50)->nullable();
            $table->string('os_version', 50)->nullable();
            $table->string('device_type', 50)->nullable();
            $table->text('params')->nullable();
            $table->string('ip', 25)->nullable();
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
        Schema::dropIfExists('root_activities');
    }
};
