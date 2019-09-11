<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBidanTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('_bidan', function(Blueprint $table)
		{
			$table->increments('bidan_id');
			$table->string('kelurahan_id', 190)->nullable();
			$table->integer('puskesmas_id')->nullable();
			$table->boolean('bidan_statis')->default(0);
			$table->boolean('bidan_pns')->nullable();
			$table->string('bidan_nik', 100)->nullable();
			$table->string('bidan_nip', 100)->nullable();
			$table->string('bidan_nomor', 100)->nullable();
			$table->string('bidan_nama', 100)->nullable();
			$table->string('bidan_telp', 12)->nullable();
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
		Schema::drop('_bidan');
	}

}
