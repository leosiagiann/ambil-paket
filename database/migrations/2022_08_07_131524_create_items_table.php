<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('resi')->unique();
            $table->string('sender');
            $table->string('sender_phone');
            $table->string('sender_address');
            $table->string('detail_sender_address');
            $table->string('receiver');
            $table->string('receiver_phone');
            $table->string('receiver_address');
            $table->string('detail_receiver_address');
            $table->string('weight');
            $table->double('price');
            $table->string('time_delivery');
            $table->string('status');
            $table->string('note');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}