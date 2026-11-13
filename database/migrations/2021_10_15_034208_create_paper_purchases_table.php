<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaperPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paper_purchases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('quantity');
            $table->bigInteger('paper_id')->unsigned();
            $table->bigInteger('department_id')->unsigned();
            $table->bigInteger('fiscal_year_id')->unsigned();
            $table->string('month');
            $table->string('year');
            $table->timestamps();

            $table->foreign('fiscal_year_id')->references('id')->on('fiscal_years');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('paper_id')->references('id')->on('papers');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paper_purchases');
    }
}
