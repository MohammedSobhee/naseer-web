<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesRegistrationAndTrademarkingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies_registration_and_trademarkings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_id');
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('sub_service_id');
            $table->enum('authorization_type', ['individual', 'institution'])->nullable(); //وكالة فردية / وكالة مؤسسات او شركات
            $table->integer('agents_num')->nullable();
            $table->integer('clients_num')->nullable();
            $table->double('debt_value')->nullable();
            $table->enum('delivery_method', ['cash', 'transfer', 'check'])->nullable(); //نقدا / حوالة / شيك
            $table->double('property_value')->nullable();

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
        Schema::dropIfExists('companies_registration_and_trademarkings');
    }
}
