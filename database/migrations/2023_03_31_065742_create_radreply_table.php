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
        if (!Schema::hasTable('radreply')) {
            Schema::create('radreply', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('username', 64)->unique();
                $table->string('attribute', 64);
                $table->string('op', 2)->default("=");
                $table->string('value', 253);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('radreply');
    }
};
