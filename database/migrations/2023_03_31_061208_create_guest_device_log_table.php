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
        Schema::create('guest_device_log', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('os_name', 200)->nullable();
            $table->string('os_version', 200)->nullable();
            $table->string('browser_name', 200)->nullable();
            $table->string('browser_version', 200)->nullable();
            $table->string('type', 100)->nullable();
            $table->integer('time');
            $table->string('mac', 50)->nullable();
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
        Schema::dropIfExists('guest_device_log');
    }
};
