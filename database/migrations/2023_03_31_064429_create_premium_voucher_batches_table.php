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
        Schema::create('premium_voucher_batches', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('service_id');
            $table->integer('quantity');
            $table->integer('created');
            $table->string('created_by', 100);
            $table->text('note')->nullable();
            $table->dateTime('premium_service_end_time')->nullable();
            $table->enum('status', ['active', 'expired'])->default("active");
            $table->string('type', 50)->nullable();
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
        Schema::dropIfExists('premium_voucher_batches');
    }
};
