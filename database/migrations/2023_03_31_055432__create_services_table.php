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
        Schema::create('services', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('service_name', 64);
            $table->string('type', 25)->default('Regular');
            $table->tinyInteger('burst_mode')->default(0);
            $table->integer('ul_rate')->default(0);
            $table->integer('dl_rate')->default(0);
            $table->integer('ul_br_rate')->nullable();
            $table->integer('dl_br_rate')->nullable();
            $table->integer('ul_br_trh')->nullable();
            $table->integer('dl_br_trh');
            $table->mediumInteger('ul_br_time')->nullable();
            $table->mediumInteger('dl_br_time')->nullable();
            $table->smallInteger('priority')->nullable();
            $table->integer('session_timeout')->default(0);
            $table->integer('idle_timeout')->default(0);
            $table->tinyInteger('bandwidth_change')->default(0);
            $table->string('from', 2)->nullable();
            $table->string('to', 2)->nullable();
            $table->tinyInteger('bc_burst_mode')->default(0);
            $table->integer('bc_ul_rate')->nullable();
            $table->integer('bc_dl_rate')->nullable();
            $table->integer('bc_ul_br_rate')->nullable();
            $table->integer('bc_dl_br_rate')->nullable();
            $table->integer('bc_ul_br_trh')->nullable();
            $table->integer('bc_dl_br_trh')->nullable();
            $table->integer('bc_ul_br_time')->nullable();
            $table->integer('bc_dl_br_time')->nullable();
            $table->smallInteger('bc_priority')->nullable();
            $table->smallInteger('simultaneous_use')->default(0);
            $table->enum('validity_type', ['none', 'after_created', 'after_first_login'])->default('none');
            $table->integer('validity')->default(0);
            $table->enum('unit_validity', ['days', 'weeks', 'months', 'years'])->default('days');
            $table->integer('time_limit')->default(0);
            $table->enum('unit_time', ['minutes', 'hours', 'days'])->default('minutes');
            $table->enum('time_limit_type', [
                'none',
                'one_time_continuous',
                'one_time_gradually',
                'weekly_reset',
                'monthly_reset',
            ])->default('none');
            $table->tinyInteger('enable_limit')->default(0);
            $table->decimal('cost', 10, 2)->nullable();
            $table->string('currency', 3)->default('IDR');
            // *** TODO:
            $table->tinyInteger('for_purchase')->default(0);
            $table->integer('purchase_duration')->default(0);
            $table->enum('unit_time_purchase', ['hours', 'days'])->default('hours');
            $table->string('description', 200)->nullable();
            $table->tinyInteger('cron')->default(0);
            $table->string('cron_type', 25)->nullable();
            $table->integer('volume_limit')->default(0);
            $table->enum('volume_limit_unit', ['MB', 'GB'])->default("MB");
            $table->bigInteger('volume_limit_bytes')->default(0);
            $table->integer('validfrom')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
};
