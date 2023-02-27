<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsFullOpenAndHasBreakTimeColumnInPharmacyBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pharmacy_businesses', function (Blueprint $table) {
            $table->boolean('is_full_open')->default(false);
            $table->boolean('has_break_time')->default(false);
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
            $table->dropColumn('is_full_open');
            $table->dropColumn('has_break_time');
        });
    }
}
