<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateKelurahanTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('_kelurahan', function(Blueprint $table)
		{
			$table->integer('kelurahan_id', true);
			$table->integer('kecamatan_id');
			$table->string('kelurahan_kd', 11)->nullable();
			$table->string('kelurahan_nama', 190)->default('');
			$table->string('kelurahan_kantor_desa', 190)->nullable();
			$table->string('kelurahan_kodepos', 100)->nullable();
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
		Schema::drop('_kelurahan');
	}

}
