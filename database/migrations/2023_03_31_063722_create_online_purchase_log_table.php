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
        Schema::create('online_purchase_log', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('username', 100);
            $table->string('mac', 50);
            $table->string('ip', 100);
            $table->integer('service_id');
            $table->date('date');
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
        Schema::dropIfExists('online_purchase_log');
    }
};
