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
        Schema::create('cycles', function (Blueprint $table) {
            $table->id();
            $table->string('cycle');
            $table->Date('start_date');
            $table->Date('end_date');
            $table->string('status',1)->default('A');
            $table->foreignId('group_id')
            ->nullable()
            ->constrained('groups')
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
        Schema::dropIfExists('cycles');
    }
};