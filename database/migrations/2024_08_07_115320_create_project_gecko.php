<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectGecko extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_gecko', function (Blueprint $table) {
            $table->id();
            $table->string('project_name');
            $table->string('code');
            $table->string('notes')->nullable();
            $table->integer('dam');
            $table->integer('sire');
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
        Schema::dropIfExists('project_gecko');
    }
}
