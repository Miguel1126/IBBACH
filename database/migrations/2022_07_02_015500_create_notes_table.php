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
            $table->decimal('ev1',);
            $table->decimal('ev2',);
            $table->decimal('ev4',);
            $table->decimal('ev4',);
            $table->decimal('ev5',);
            $table->decimal('percentege',);
            $table->decimal('finalAverage',);
            $table->string('status',10);
            $table->foreignId('load_id')
            ->nullable()
            ->constrained('loads')
            ->cascadeOnUpdate()
            ->nullOndelete();
            $table->foreignId('inscription_id')
            ->nullable()
            ->constrained('inscriptions')
            ->cascadeOnUpdate()
            ->nullOndelete();
            $table->timestamps();
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
