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
        Schema::create('hotel_rooms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('room_number', 50);
            $table->string('name', 100)->default("Guest");
            $table->string('password', 50);
            $table->string('folio_number', 100);
            $table->uuid('service_id');
            $table->string('default_cron_type', 100);
            $table->enum('status', ['active', 'deactive'])->default("deactive");
            $table->tinyInteger('edit')->default(0);
            $table->dateTime('change_service_end_time')->nullable();
            $table->dateTime('arrival')->nullable();
            $table->dateTime('departure')->nullable();
            $table->string('no_posting', 50)->default("N");
            $table->timestamps();

            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotel_rooms');
    }
};
