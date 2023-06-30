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
        Schema::create('sales_log', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('password', 100);
            $table->string('mac', 50);
            $table->string('ip', 50);
            $table->string('service', 100);
            $table->integer('cost');
            $table->string('currency', 3);
            $table->dateTime('date_of_sale');
            $table->tinyInteger('backup')->default(0);
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
        Schema::dropIfExists('sales_log');
    }
};
