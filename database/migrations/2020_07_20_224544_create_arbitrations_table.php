<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArbitrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //تحكم
        Schema::create('arbitrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_id');
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('sub_service_id');
            $table->string('subject'); //
            $table->double('value'); //
            $table->enum('specialty', ['lawful','legal','engineering','accounting','real_estate','medical','without_specifying']);  //" شرعي -  قانوني - هندسي - محاسبي - عقاري- طبي - بدون تحديد "

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('request_id')->references('id')->on('requests')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
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
        Schema::dropIfExists('arbitrations');
    }
}
