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
        Schema::create('premium_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('voucher_batch_id');
            $table->integer('date');
            $table->string('operator', 50);
            $table->integer('quantity');
            $table->string('service', 200);
            $table->timestamps();
            $table->foreign('voucher_batch_id')
                ->references('id')
                ->on('voucher_batches')
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
        Schema::dropIfExists('premium_logs');
    }
};
