<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Talepler extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::create('talepler',function($table){
		$table->unsignedInteger('id', true); 
		$table->string('daire_turu'); 
		$table->string('adi_soyadi');
		$table->string('ogrenim_durumu');
                $table->string('meslek');
                $table->string('aylik_gelir');
                $table->string('adres',500);
                $table->string('telefon');
                $table->string('eposta');
                $table->string('tamamlanma_orani');
                $table->string('kredi_cekme');
                $table->string('odeme_sekli');
                $table->string('fiyat_araligi');
                $table->string('mesaj');
		$table->timestamps();
            });
	}

	public function down()
	{
            Schema::dropIfExists('talepler');
	}

}
