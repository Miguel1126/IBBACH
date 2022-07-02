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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->date('payment_date');
            $table->date('last_pay_date');
            $table->decimal('sourcharge',8,2);
            $table->foreignId('rate_id')
            ->nullable()
            ->constrained('rates')
            ->cascadeOnUpdate()
            ->nullOnDelete();
            $table->timestamps();
            // Cuando esté lista la tabla de users le quitan el comentario al código de abajo
            /* $table->foreignId('user_id')
            ->nullable()
            ->constrained('users')
            ->cascadeOnUpdate()
            ->nullOnDelete();
            $table->timestamps(); */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
