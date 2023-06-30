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
        Schema::create('clients', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('service_id');
            $table->string('customer_id', 50)->nullable();
            $table->string('username', 50);
            $table->string('password', 100);
            $table->tinyInteger('enable_user')->default(0);
            $table->smallInteger('simultaneous_use')->default(0);
            $table->string('static_ip_address', 100)->nullable();
            $table->string('identification', 100)->nullable();
            $table->string('first_name', 100)->nullable();
            $table->string('last_name', 100)->nullable();
            $table->string('fullname', 100)->nullable();
            $table->string('birth_place', 100)->nullable();
            $table->date('birth_date')->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('mobile', 50)->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('company', 100)->nullable();
            $table->string('address', 200)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('zip', 20)->nullable();
            $table->tinyInteger('tax')->default(0);
            $table->date('activation')->nullable();
            $table->integer('valid_until')->default(0);
            $table->integer('first_use')->default(0);
            $table->text('note')->nullable();
            $table->string('status', 100)->default("active");
            $table->integer('validfrom')->default(0);
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
        Schema::dropIfExists('clients');
    }
};
