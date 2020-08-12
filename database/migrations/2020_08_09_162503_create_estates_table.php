<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // موجودات التركة
        Schema::create('estates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sub_service_id');
            $table->string('hint');
            $table->string('key');
            $table->string('label');
            $table->enum('type', ['text', 'number']);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('sub_service_id')->references('id')->on('sub_services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estates');
    }
}
