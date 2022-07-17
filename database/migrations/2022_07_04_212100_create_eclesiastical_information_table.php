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
        Schema::create('ecclesiastical_information', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_pastor');
            $table->boolean('is_member');
            $table->integer('pastor_phone');
            $table->string('church_name',60);
            $table->string('church_address',70);
            $table->integer('church_phone');
            $table->string('district',70);
            $table->string('pastor_name',30);
            $table->string('licence',20);
            $table->string('reference_name_one',30);
            $table->integer('reference_phone_one');
            $table->string('reference_name_two',30);
            $table->integer('reference_phone_two');
            $table->text('christ_accepted');
            $table->date('christening_date');
            $table->string('time_being_member');
            $table->text('privileges_held');
            $table->string('denomination',20);
            $table->text('study_reason');
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
        Schema::dropIfExists('ecclesiastical_information');
    }
};