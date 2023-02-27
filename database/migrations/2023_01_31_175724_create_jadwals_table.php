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
            $table->foreign('kode_kelas')->references('kode_kelas')->on('kelas')->onUpdate('cascade');
            $table->string('nip_guru',100);
            $table->foreign('nip_guru')->references('nip_guru')->on('gurus')->onUpdate('cascade');
            $table->unsignedBigInteger('sesi');
            $table->foreign('sesi')->references('id')->on('sesis')->onUpdate('cascade');
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