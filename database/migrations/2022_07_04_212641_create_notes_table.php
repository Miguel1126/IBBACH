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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->float('ev1',);
            $table->float('percentege1',);
            $table->float('ev2',);
            $table->float('percentege2',);
            $table->float('ev3',);
            $table->float('percentege3',);
            $table->float('ev4',);
            $table->float('percentege4',);
            $table->float('ev5',);
            $table->float('percentege5',);
            $table->float('finalAverage',);
            $table->string('status',1)->default('A');
            $table->foreignId('inscription_id')
            ->nullable()
            ->constrained('inscriptions')
            ->cascadeOnUpdate()
            ->nullOndelete();
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
        Schema::dropIfExists('notes');
    }
};