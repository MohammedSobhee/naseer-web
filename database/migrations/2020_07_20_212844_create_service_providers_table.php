<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_providers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('idno');
            $table->string('idno_file')->nullable();
            $table->longText('skill')->nullable();
            $table->string('skill_file')->nullable();
            $table->longText('bio')->nullable();
            $table->longText('address');
            $table->string('latitude');
            $table->string('longitude');
            $table->unsignedBigInteger('service_provider_type_id');
            $table->enum('license_type',['licensed','unlicensed'])->nullable();
            $table->string('licensed')->nullable();
            $table->string('licensed_file')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('service_provider_type_id')->references('id')->on('service_provider_types')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_providers');
    }
}
