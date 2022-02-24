<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiquitationItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liquitation_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('liquidation_id');
            $table->date('date_acquired');
            $table->string('receipt_no', 255);
            $table->string('supplier');
            $table->json('items');
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
        Schema::dropIfExists('liquitation_items');
    }
}
