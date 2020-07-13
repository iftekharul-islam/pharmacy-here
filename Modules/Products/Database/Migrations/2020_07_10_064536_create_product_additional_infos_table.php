<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductAdditionalInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_additional_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('administration')->nullable();
            $table->string('precaution')->nullable();
            $table->string('indication')->nullable();
            $table->string('contra_indication')->nullable();
            $table->string('side_effect')->nullable();
            $table->string('mode_of_action')->nullable();
            $table->string('interaction')->nullable();
            $table->string('adult_dose')->nullable();
            $table->string('child_dose')->nullable();
            $table->string('renal_dose')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
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
        Schema::dropIfExists('product_additional_infos');
    }
}
