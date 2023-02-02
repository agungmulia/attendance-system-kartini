<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->string('kode_kelas',50)->primary();
            $table->timestamps();
            $table->string('tingkat_kelas',3);
            $table->integer('nomor_kelas');
            $table->string('jurusan_kelas',100);
            $table->string('wali_kelas',100);
            $table->foreign('wali_kelas')->references('nip_guru')->on('gurus')->onUpdate('cascade')->onDelete('cascade')->index('nama_guru');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kelas');
    }
}