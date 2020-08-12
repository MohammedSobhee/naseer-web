<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourtAndLawsuitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //القضايا والمحاكم
        Schema::create('court_and_lawsuits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_id');
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('sub_service_id');

            $table->enum('prosecutor_defender', ['prosecutor', 'defender'])->nullable();
            $table->enum('lawsuit_nature', ['individual', 'company_institution', 'government_agency'])->nullable(); // فرد - شركة/مؤسسة - جهة حكومية
            $table->enum('lawsuit_proof', ['lawsuit', 'proof'])->nullable();
            $table->enum('criminal_case', ['Personal', 'public_prosecution'])->nullable(); //(شخصية- النيابة العامة)
            $table->unsignedBigInteger('country_id')->nullable();
            $table->string('court_name')->nullable(); // طلب الاستئناف
            $table->string('property_country')->nullable(); // بلد العقار
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('request_id')->references('id')->on('requests')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->foreign('sub_service_id')->references('id')->on('sub_services')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('court_and_lawsuits');
    }
}
