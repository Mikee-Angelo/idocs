<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnouncements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->integer('event_type_id')->unsigned()->index();
            $table->mediumText('header_img')->nullable();
            $table->text('title');
            $table->longText('description');
            $table->mediumText('url')->nullable();
            $table->dateTime('starts_at');
            $table->dateTime('ends_at');
            $table->bigInteger('created_by')->unsigned()->index();
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
        Schema::dropIfExists('announcements');
    }
}
