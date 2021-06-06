<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGadPlanLists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gad_plan_lists', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('gad_plans_id')->unsigned();
            $table->foreign('gad_plans_id')->references('id')->on('gad_plans')->onDelete('cascade');
            $table->longText('gad_issue_mandate');
            $table->longText('cause_of_issue');
            $table->longText('gad_statement_objective');
            $table->bigInteger('relevant_agencies')->unsigned();
            $table->mediumText('gad_activity');
            $table->mediumText('indicator_target');
            $table->double('budget_requirement', 15, 2);
            $table->bigInteger('budget_source')->unsigned();
            $table->bigInteger('responsible_unit')->unsigned();
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
        Schema::dropIfExists('gad_plan_lists');
    }
}
