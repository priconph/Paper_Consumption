<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMonthlyUsedPapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthly_used_papers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('data_monthly_used_paper');
            $table->bigInteger('paper_id')->unsigned();
            $table->bigInteger('department_id')->unsigned();
            $table->bigInteger('paper_purchases_id')->unsigned();
            $table->bigInteger('fiscal_year_id')->unsigned();
            $table->string('reason');
            $table->string('year');
            $table->string('month');
            $table->timestamps();

            $table->foreign('paper_id')->references('id')->on('papers');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('paper_purchases_id')->references('id')->on('paper_purchases');
            $table->foreign('fiscal_year_id')->references('id')->on('fiscal_years');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monthly_used_papers');
    }
}
