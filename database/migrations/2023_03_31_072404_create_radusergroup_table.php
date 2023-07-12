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
        if (!Schema::hasTable('radusergroup')) {
            Schema::create('radusergroup', function (Blueprint $table) {
                $table->id();
                $table->string('username', 64);
                $table->string('groupname', 64);
                $table->string('priority', 2)->default(1);
                $table->string('user_type', 20);
                $table->uuid('voucher_id')->nullable();

                $table->foreign('voucher_id')
                ->references('id')
                ->on('vouchers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('radusergroup');
    }
};
