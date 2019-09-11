<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('_setting', function(Blueprint $table)
		{
			$table->integer('setting_id', true);
			$table->integer('app_id');
			$table->string('setting_type', 20);
			$table->string('setting_name', 100);
			$table->text('setting_value', 65535);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('_setting');
	}

}
