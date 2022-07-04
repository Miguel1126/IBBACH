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
        Schema::create('personal_information', function (Blueprint $table) {
            $table->id();
            $table->string('name',50);
            $table->string('last_name',50);
            $table->string('email',60);
            $table->integer('phone');
            $table->string('address',100);
            $table->string('nationality',50);
            $table->date('birth_date');
            $table->string('marital_status',60);
            $table->string('mate_name',50)->nullable();
            $table->string('secular_degree',60);
            $table->string('current_ocupation',100);
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
        Schema::dropIfExists('personal_information');
    }
};