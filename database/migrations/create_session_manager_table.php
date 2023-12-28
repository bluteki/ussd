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
        Schema::create('session_managers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('session_id');
            $table->string('msisdn');
            $table->string('data')->default(json_encode([]));
            $table->string('menus')->default(json_encode([]));
            $table->integer('navigation_tracker')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('session_managers');
    }
};