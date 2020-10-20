<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemindersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reminders', function (Blueprint $table) {
            $table->id();
            $table->integer('reminder_id')->nullable();
            $table->string('frequency')->nullable();
            $table->string('start_date')->nullable();

            $table->string('duration_type')->nullable();
            $table->string('duration_days')->nullable();
            $table->string('days_type')->nullable();
            $table->string('specific_days')->nullable();
            $table->string('medicine_type')->nullable();
            $table->string('medicine_strength')->nullable();

            $table->string('medicine_name')->nullable();
            $table->string('patient_name')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();

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
        Schema::dropIfExists('reminders');
    }
}
