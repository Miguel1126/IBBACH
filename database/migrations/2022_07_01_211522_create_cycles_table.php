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
            $table->interger('cycle');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status',10);
            $table->foreignId('group_id')
            ->nullable()
            ->constrained('groups')
            ->cascadeOnUpdate()
            ->nullOndelete();
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
