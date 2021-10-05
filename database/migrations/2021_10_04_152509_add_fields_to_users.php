<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('last_name')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instalgram')->nullable();
            $table->string('twitter')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('note')->nullable();
            $table->string('usertype')->nullable();
            $table->string('profile_picture')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
