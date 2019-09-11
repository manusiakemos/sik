<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateKecamatanTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('_kecamatan', function(Blueprint $table)
		{
			$table->integer('kecamatan_id', true);
			$table->integer('kabupaten_id')->index('kabupaten_idfk');
			$table->string('kecamatan_nama');
			$table->string('kecamatan_kodepos')->nullable();
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
		Schema::drop('_kecamatan');
	}

}
