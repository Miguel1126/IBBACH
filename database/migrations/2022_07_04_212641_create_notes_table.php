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
            $table->float('ev1')->default(0.0);
            $table->float('percentege1')->default(0.0);
            $table->float('ev2')->default(0.0);
            $table->float('percentege2')->default(0.0);
            $table->float('ev3')->default(0.0);
            $table->float('percentege3')->default(0.0);
            $table->float('ev4')->default(0.0);
            $table->float('percentege4')->default(0.0);
            $table->float('ev5')->default(0.0);
            $table->float('percentege5')->default(0.0);
            $table->float('finalAverage')->default(0.0);
            $table->string('status',1)->default('I');
            $table->string('result_status',1)->default('R');
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