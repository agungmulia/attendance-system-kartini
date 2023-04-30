<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresensisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presensis', function (Blueprint $table) {
            $table->id();
            $table->string('nis_siswa',100);
            $table->foreign('nis_siswa')->references('nis_siswa')->on('siswas')->onUpdate('cascade')->onDelete('cascade');
            $table->string('status_presensi',20)->default('Belum Absen');
            $table->integer('total_hadir_presensi')->default(0);
            $table->integer('total_izin_presensi')->default(0);
            $table->integer('total_alpha_presensi')->default(0);
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
        Schema::dropIfExists('presensis');
    }
}