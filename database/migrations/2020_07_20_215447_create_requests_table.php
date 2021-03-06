<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('service_id')->nullable();
            $table->enum('type', ['categorized', 'uncategorized'])->nullable();
//            $table->integer('level'); // [1-3]

            $table->longText('case_text')->nullable();
            $table->string('case_audio')->nullable();
            $table->string('case_file')->nullable();

            $table->longText('evidences_text')->nullable();
            $table->string('evidences_audio')->nullable();
            $table->string('evidences_file')->nullable();

            $table->longText('preferred_outcomes_text')->nullable();
            $table->string('preferred_outcomes_audio')->nullable();
            $table->string('preferred_outcomes_file')->nullable();

            $table->enum('contact_prefer', ['go_to_service_provider', 'go_to_user', 'according_agreement'])->nullable();
            $table->enum('payment_prefer', ['down_payment', 'without_down_payment'])->nullable();
            $table->timestamp('service_date'); //موعد تقديم الخدمة

            $table->longText('contract')->nullable();
            $table->integer('contract_status')->default(0); // 0 didn't edit, 1 edited by service provider, 2 edited by client

            $table->enum('status', ['new', 'initial_assigned', 'assigned', 'completed', 'canceled'])->default('new'); // initial_assigned client just choose service provider
            $table->boolean('is_active')->default(true);
            $table->boolean('is_edit')->default(false);

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('requests');
    }
}
