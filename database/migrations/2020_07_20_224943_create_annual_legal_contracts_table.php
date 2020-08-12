<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnualLegalContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('annual_legal_contracts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_id');
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('sub_service_id');
            $table->string('activity')->nullable(); //
            $table->string('contract_period')->nullable(); //
            $table->double('lawsuit_argument')->nullable(); //
            $table->double('preparation_interception')->nullable(); //
            $table->double('contract_formation')->nullable(); //
            $table->double('contract_revision')->nullable(); //
            $table->double('legal_consultation')->nullable(); //
            $table->double('issue_procuration')->nullable(); //

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
        Schema::dropIfExists('annual_legal_contracts');
    }
}
