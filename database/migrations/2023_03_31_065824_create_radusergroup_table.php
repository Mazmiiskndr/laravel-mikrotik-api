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
<<<<<<< HEAD
        if (!Schema::hasTable('radreply')) {
            Schema::create('radusergroup', function (Blueprint $table) {
                $table->id();
                $table->string('username', 64)->unique();
                $table->string('groupname', 64);
                $table->string('priority', 2)->default(1);
                $table->string('user_type', 20);
                $table->integer('voucher_id')->nullable();
            });
        }
=======
        Schema::create('radusergroup', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('username', 64)->unique();
            $table->string('groupname', 64);
            $table->string('priority', 2)->default(1);
            $table->string('user_type', 20);
            $table->integer('voucher_id')->nullable();
        });
>>>>>>> b94242a (use uuid as primary key)
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('radusergroup');
    }
};
