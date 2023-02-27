<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->string('nis_siswa',100);
            $table->foreign('nis_siswa')->references('nis_siswa')->on('siswas')->onUpdate('cascade')->onDelete('cascade');
            $table->string('status_absensi',20)->default('Belum Absen');
            $table->integer('hadir_absensi')->default(0);
            $table->integer('izin_absensi')->default(0);
            $table->integer('alpha_absensi')->default(0);
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
        Schema::dropIfExists('absensis');
    }
}