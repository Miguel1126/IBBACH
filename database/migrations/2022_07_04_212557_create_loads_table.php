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
        Schema::create('loads', function (Blueprint $table) {
            $table->id();
            $table->string('status',10);
            $table->foreignId('user_id')
            ->nullable()
            ->constrained('users')
            ->cascadeOnUpdate()
            ->nullOnDelete();
            $table->foreignId('cycle_id')
            ->nullable()
            ->constrained('cycles')
            ->cascadeOnUpdate()
            ->nullOnDelete();
            $table->foreignId('subject_id')
            ->nullable()
            ->constrained('subjects')
            ->cascadeOnUpdate()
            ->nullOnDelete();
            $table->foreignId('schedule_id')
            ->nullable()
            ->constrained('schedules')
            ->cascadeOnUpdate()
            ->nullOnDelete();
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
        Schema::dropIfExists('loads');
    }
};