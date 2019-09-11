<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePregnancyProcessTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('_pregnancy_process', function(Blueprint $table)
		{
			$table->increments('pp_id');
			$table->string('pp_code', 100)->nullable();
			$table->string('pp_nokk', 100)->nullable();
			$table->string('pp_noktp_ibu', 100)->nullable();
			$table->string('pp_nama_ibu', 100)->nullable();
			$table->string('pp_goldarah_ibu', 1)->nullable();
			$table->text('pp_imagektp_ibu', 65535)->nullable();
			$table->string('pp_noktp_ayah', 100)->nullable();
			$table->string('pp_nama_ayah', 100)->nullable();
			$table->text('pp_imagektp_ayah', 65535)->nullable();
			$table->string('pp_nama_anak', 100)->nullable();
			$table->enum('pp_jk_anak', array('laki-laki','perempuan'))->nullable();
			$table->integer('pp_anak_ke');
			$table->text('pp_imagekk', 65535)->nullable();
			$table->text('pp_imagebukunikah', 65535)->nullable();
			$table->text('pp_alamat_paket', 65535)->nullable();
			$table->enum('pp_status', array('new','born','done','send'))->nullable();
			$table->integer('created_by')->comment('bidan-id');
			$table->timestamp('created_at')->nullable();
			$table->integer('update_born_by')->nullable();
			$table->timestamp('update_to_born')->nullable();
			$table->timestamp('update_to_done')->nullable();
			$table->timestamp('update_to_send')->nullable();
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
		Schema::drop('_pregnancy_process');
	}

}
