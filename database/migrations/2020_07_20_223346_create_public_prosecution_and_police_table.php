<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicProsecutionAndPoliceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //التمثيل أمام الشرطة - التمثيل أمام الشرطة والنيابة العامة - التمثيل اما م النيابة العامة
        Schema::create('public_prosecution_and_police', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_id');
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('sub_service_id');
            $table->enum('accused_status', ['suspended', 'unsuspended']);//موقوف - غير موقوف
            $table->enum('accused_gender', ['male', 'female', 'minor']); //ذكر - أنثى - قاصر

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
        Schema::dropIfExists('public_prosecution_and_police');
    }
}
