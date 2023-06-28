<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('radcheck', function (Blueprint $table) {
            $table->id();
            $table->string('username', 64);
            $table->string('attribute', 64);
            $table->string('op', 2)->default("==");
            $table->string('value', 253);
        });
        // Add index with specific length
        DB::statement('CREATE INDEX username_index ON radcheck (username(32));');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('radcheck');
        // Drop the index
        DB::statement('DROP INDEX username_index ON radcheck;');
    }
};
