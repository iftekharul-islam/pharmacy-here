<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeBankIdInPharmacyBusiness extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pharmacy_businesses', function (Blueprint $table) {
            $table->unsignedBigInteger('bank_name')->nullable()->change();
            $table->renameColumn('bank_name', 'bank_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pharmacy_businesses', function (Blueprint $table) {
            $table->string('bank_id')->nullable()->change();
            $table->renameColumn('bank_id' , 'bank_name');

        });
    }
}
