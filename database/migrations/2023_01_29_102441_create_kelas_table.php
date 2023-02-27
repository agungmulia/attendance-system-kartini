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
            $table->string('tingkat_kelas',3);
            $table->integer('nomor_kelas');
            $table->string('jurusan_kelas',100);
            $table->string('nip_guru',100)->nullable();
            $table->foreign('nip_guru')->references('nip_guru')->on('gurus')->onUpdate('cascade');
            $table->timestamps();
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