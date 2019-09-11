<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProcessDetailTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('_process_detail', function(Blueprint $table)
		{
			$table->integer('ppd_id', true);
			$table->integer('pp_id');
			$table->integer('bidan_id');
			$table->text('ppd_note', 65535);
			$table->integer('ppd_point');
			$table->enum('ppd_status', array('checkup','born'));
			$table->date('ppd_date');
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
		Schema::drop('_process_detail');
	}

}
