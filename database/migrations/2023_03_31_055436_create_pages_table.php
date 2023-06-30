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
        Schema::create('pages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('module_id');
            $table->string('page', 100);
            $table->string('title', 100);
            $table->string('url', 100);
            $table->text('allowed_groups');
            $table->tinyInteger('show_menu')->default(0);
            $table->integer('show_to')->nullable();

            $table->foreign('module_id')
                ->references('id')
                ->on('modules')
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
        Schema::dropIfExists('pages');
    }
};
