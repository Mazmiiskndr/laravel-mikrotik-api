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
        Schema::create('premium_vouchers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('premium_voucher_uid')->unique();
            $table->string('voucher_batch_id');
            $table->string('username', 100);
            $table->string('password', 100);
            $table->integer('valid_until')->default(0);
            $table->integer('first_use')->default(0);
            $table->string('status', 50)->default("active");
            $table->tinyInteger('clean_up')->default(0);
            $table->string('time_limit', 50)->nullable();
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
        Schema::dropIfExists('premium_vouchers');
    }
};
