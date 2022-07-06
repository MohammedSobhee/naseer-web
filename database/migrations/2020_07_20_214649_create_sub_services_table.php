<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('sub_services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_case')->default(false);
            $table->boolean('is_evidence')->default(false);
            $table->boolean('is_prefered_outcome')->default(false);
            $table->unsignedBigInteger('service_id');
            $table->string('icon')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_services');
    }
}
