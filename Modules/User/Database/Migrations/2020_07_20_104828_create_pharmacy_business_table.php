<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePharmacyBusinessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pharmacy_business', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pharmacy_name')->nullable();
            $table->string('pharmacy_address')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('bkash_number')->nullable();
            $table->string('nid_img_path')->nullable();
            $table->string('trade_img_path')->nullable();
            $table->string('drug_img_path')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');


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
        Schema::dropIfExists('pharmacy_business');
    }
}
