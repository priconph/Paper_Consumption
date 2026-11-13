<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeginningBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beginning_balances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('quantity');
            $table->string('month');
            $table->bigInteger('paper_id')->unsigned();
            $table->bigInteger('department_id')->unsigned();
            $table->bigInteger('fiscal_year_id')->unsigned();
            $table->timestamps();

            $table->foreign('paper_id')->references('id')->on('papers');
            $table->foreign('department_id')->references('id')->on('departments');
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
        Schema::dropIfExists('beginning_balances');
    }
}
