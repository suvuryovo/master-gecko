<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterGecko extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_gecko', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('morph');
            $table->string('notes')->nullable();
            $table->integer('project')->nullable();
            $table->date('dob')->nullable();
            $table->string('sex')->default('Unsex');
            $table->string('traits');
            $table->string('dam')->nullable();
            $table->integer('id_dam')->nullable();
            $table->string('dam_path')->nullable();
            $table->string('sire')->nullable();
            $table->integer('id_sire')->nullable();
            $table->string('sire_path')->nullable();
            $table->string('gecko_path')->nullable();
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
        Schema::dropIfExists('master_gecko');
    }
}
