<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sub_service_id');
            $table->string('key');
            $table->string('select_key')->nullable();
            $table->string('value')->nullable();
            $table->string('hint');
            $table->enum('type', ['select','text','date','object_list','select_tree','location','file','number']);
            $table->longText('data')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
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
        Schema::dropIfExists('request_fields');
    }
}
