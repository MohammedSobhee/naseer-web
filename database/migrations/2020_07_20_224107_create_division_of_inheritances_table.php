<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDivisionOfInheritancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //تقسيم الميراث
        Schema::create('division_of_inheritances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_id');
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('sub_service_id');
            $table->longText('heirs_details')->nullable(); //تفاصيل الورثة
            $table->enum('type_service_provided', ['written', 'oral']); //كتابية - شفوية

            $table->string('agreers')->nullable();
            $table->string('against')->nullable();

            $table->double('money')->nullable();
            $table->double('real_estate')->nullable();
            $table->double('bonds_shares')->nullable();
            $table->double('companies')->nullable();
            $table->double('others')->nullable();

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
        Schema::dropIfExists('division_of_inheritances');
    }
}
