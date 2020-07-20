<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'users', function ( Blueprint $table ) {
			$table->id();
			$table->string( 'name')->nullable();
			$table->string( 'phone_number')->unique();
			$table->string( 'email')->nullable();
            $table->string( 'password')->nullable();
            $table->string('slug')->nullable();
            $table->string('image')->nullable();
            $table->string('alternative_phone_number')->nullable();
            $table->string('dob')->nullable();
            $table->string('gender')->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_pharmacy')->default(false);
			$table->timestamp( 'email_verified_at' )->nullable();
			$table->rememberToken();
			$table->softDeletes();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'users' );
	}
}
