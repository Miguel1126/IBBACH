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
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->date('registration_date');
            $table->foreignId('personal_information_id')
            ->nullable()
            ->constrained('personal_information')
            ->cascadeOnUpdate()
            ->nullOnDelete();
            $table->foreignId('eclesiastical_information_id')
            ->nullable()
            ->constrained('eclesiastical_information')
            ->cascadeOnUpdate()
            ->nullOnDelete();
            $table->foreignId('ministerial_information_id')
            ->nullable()
            ->constrained('ministerial_information')
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
        Schema::dropIfExists('applicants');
    }
};
