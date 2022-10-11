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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name');
            $table->string('code')->unique();
            $table->string('password');
            $table->string('role');
            $table->string('status')->default('activo');
            $table->integer('paid_months')->default(0);
            $table->foreignId('group_id')
            ->nullable()
            ->constrained('groups')
            ->cascadeOnUpdate()
            ->nullOnDelete();
            $table->foreignId('applicant_id')
            ->nullable()
            ->constrained('applicants')
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
        Schema::dropIfExists('users');
    }
};