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
        Schema::create('ministerial_information', function (Blueprint $table) {
            $table->id();
            $table->string('ministry_performed',60);
            $table->string('current_ministry',60);
            $table->boolean('full_time');
            $table->string('ministry_qualification',70);
            $table->string('aspirated_ministry',70);
            $table->text('reason_aspiring_ministry');
            $table->string('cicle_to_be_taken',50);
            $table->string('previous_institution',50);
            $table->string('last_year_studied',20);
            $table->text('qualities_religious_worker');
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
        Schema::dropIfExists('ministerial_information');
    }
};
