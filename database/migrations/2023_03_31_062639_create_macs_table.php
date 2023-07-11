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
        Schema::create('macs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('mac_address', 100);
            $table->string('password', 100)->nullable();
            $table->string('mikrotik_group', 100)->nullable();
            $table->string('validfrom', 100)->nullable();
            $table->string('validto', 100)->nullable();
            $table->enum('status', ['bypassed', 'blocked'])->default("bypassed");
            $table->text('description')->nullable();
            $table->string('server', 100)->default("all");
            $table->string('mikrotik_id', 50);
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
        Schema::dropIfExists('macs');
    }
};
