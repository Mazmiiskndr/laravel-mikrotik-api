<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function ($table) {
            // $table->dropForeign('clients_client_id_foreign');
            // $table->dropColumn('client_id');
            $table->string('username', 50)->nullable()->change();
            $table->string('password', 100)->nullable()->change();
        });

        Schema::dropIfExists('socials');

        Schema::create('socials', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('client_id');
            $table->string('oauth_id')->nullable();
            $table->string('oauth_provider')->nullable();
            $table->timestamps();

            // create relationship
            $table->foreign('client_id')
                ->references('id')
                ->on('clients')
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
        Schema::dropIfExists('socials');
    }
}
