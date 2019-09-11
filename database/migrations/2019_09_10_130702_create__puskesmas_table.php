<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePuskesmasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('_puskesmas', function(Blueprint $table)
		{
			$table->increments('puskesmas_id');
			$table->integer('kecamatan_id')->nullable();
			$table->string('puskesmas_no', 100)->nullable();
			$table->string('puskesmas_nama', 100)->nullable();
			$table->text('puskesmas_alamat', 65535)->nullable();
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
		Schema::drop('_puskesmas');
	}

}
