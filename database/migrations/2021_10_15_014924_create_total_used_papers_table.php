<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTotalUsedPapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('total_used_papers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('quantity');
            $table->string('month');
            $table->string('year');
            $table->bigInteger('department_id')->unsigned();
            // $table->bigInteger('monthly_used_paper_id')->unsigned();
            $table->bigInteger('fiscal_year_id')->unsigned();
            $table->timestamps();

            // $table->foreign('monthly_used_paper_id')->references('id')->on('monthly_used_papers');
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
        Schema::dropIfExists('total_used_papers');
    }
}
