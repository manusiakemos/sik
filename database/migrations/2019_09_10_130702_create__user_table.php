<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('_user', function(Blueprint $table)
		{
			$table->increments('user_id');
			$table->integer('bidan_id')->nullable();
			$table->string('username', 100)->nullable()->default('');
			$table->string('password', 100)->nullable()->default('');
			$table->enum('user_level', array('bidan','capil','kominfo'))->default('bidan');
			$table->string('api_token', 100)->nullable();
			$table->string('remember_token', 100)->nullable();
			$table->string('user_avatar', 100)->nullable();
			$table->dateTime('login_at')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('_user');
	}

}
