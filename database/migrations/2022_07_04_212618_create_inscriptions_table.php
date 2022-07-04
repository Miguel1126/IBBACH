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
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->id();
            $table->date('registration_date');
            $table->string('current_year',10);
            $table->string('status',10);
            $table->foreignId('user_id')
            ->nullable()
            ->constrained('users')
            ->cascadeOnUpdate()
            ->nullOnDelete();
            $table->foreignId('load_id')
            ->nullable()
            ->constrained('loads')
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
        Schema::dropIfExists('inscriptions');
    }
};