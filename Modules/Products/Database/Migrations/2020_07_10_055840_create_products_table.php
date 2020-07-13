<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('status');
            $table->string('name');
            $table->string('slug');
            $table->double('trading_price');
            $table->double('purchase_price');
            $table->string('unit');
            $table->boolean('is_saleable');
            $table->boolean('is_service')->nullable();
            $table->boolean('is_printable')->nullable();
            $table->double('conversion_factor');
            $table->string('code')->nullable();
            $table->string('species')->nullable();
            $table->string('strength')->nullable();
            $table->string('type');
            $table->unsignedBigInteger('form_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('generic_id');
            $table->unsignedBigInteger('manufacturing_company_id');
            $table->unsignedBigInteger('primary_unit_id');
            $table->integer('secondary_unit_id')->nullable();
            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('generic_id')->references('id')->on('generics')->onDelete('cascade');
            $table->foreign('manufacturing_company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('primary_unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('products');
    }
}
