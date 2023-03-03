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
        Schema::create('data_process_models', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('min_support');
            $table->integer('min_confidence');
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
        Schema::dropIfExists('data_process_models');
    }
};
