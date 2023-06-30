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
        Schema::create('ad_type', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 200);
            $table->string('title', 200);
            $table->string('max_height', 100);
            $table->string('max_width', 100)->nullable();
            $table->string('max_size', 100)->nullable();
            $table->string('mobile_max_height', 100)->nullable();
            $table->string('mobile_max_width', 100)->nullable();
            $table->string('mobile_max_size', 100)->nullable();
            $table->tinyInteger('single_image')->default(0);
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
        Schema::dropIfExists('ad_type');
    }
};
