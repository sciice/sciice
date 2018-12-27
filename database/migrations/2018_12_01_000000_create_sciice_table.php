<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSciiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sciice', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('username', 100)->unique();
            $table->string('email', 80)->unique();
            $table->string('mobile', 50)->unique();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->boolean('state')->default(true);
            $table->rememberToken();
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
        Schema::dropIfExists('sciice');
    }
}
