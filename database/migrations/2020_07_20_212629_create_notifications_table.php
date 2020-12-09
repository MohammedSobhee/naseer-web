<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id')->nullable();
            $table->enum('action', ['new_order', 'assigned', 'initial_assigned', 'completed_order', 'canceled_order', 'new_offer', 'edit_contract_client', 'edit_contract_provider', 'chat', 'public']);

            $table->unsignedBigInteger('action_id')->nullable();
            $table->longText('message')->nullable(); // for public action
            $table->boolean('seen')->default(false);

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
