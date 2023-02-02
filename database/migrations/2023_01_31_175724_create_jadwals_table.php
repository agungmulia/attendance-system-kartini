<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwals', function (Blueprint $table) {
            $table->string('kode_jadwal',50)->primary();
            $table->string('mata_pelajaran_jadwal',50);
            $table->string('hari_jadwal',15);
            $table->string('kode_kelas',50);
            $table->foreign('kode_kelas')->references('kode_kelas')->on('kelas')->onUpdate('cascade')->onDelete('cascade');
            $table->string('nip_guru',100);
            $table->foreign('nip_guru')->references('nip_guru')->on('gurus')->onUpdate('cascade')->onDelete('cascade');
            $table->string('sesi',100);
            $table->foreign('sesi')->references('nama_sesi')->on('sesis')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('jadwals');
    }
}