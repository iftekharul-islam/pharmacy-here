<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPharmacyIdColumnNullableOnOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('pharmacy_id')->nullable()->change();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('pharmacy_id')->nullable(false)->change();
        });
        Schema::enableForeignKeyConstraints();
    }
}
