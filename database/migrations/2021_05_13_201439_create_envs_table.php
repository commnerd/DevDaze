<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnvsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('envs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('docker_image_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string("label");
            $table->string("value");
            $table->unique(['docker_image_id', 'label']);
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
        Schema::dropIfExists('envs');
    }
}
