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
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('title', 100);
            $table->tinyInteger('is_parent')->default(0);
            $table->integer('show_to')->nullable();
            $table->string('url',200)->nullable();
            $table->tinyInteger('extensible');
            $table->tinyInteger('active');
            $table->string('icon_class',50)->nullable();
            $table->string('root',100)->default(0);
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
        Schema::dropIfExists('modules');
    }
};
