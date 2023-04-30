<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPresensisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_presensis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_presensi');
            $table->foreign('id_presensi')->references('id')->on('presensis')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nis_siswa',100);
            $table->foreign('nis_siswa')->references('nis_siswa')->on('siswas')->onUpdate('cascade')->onDelete('cascade');
            $table->string('keterangan_presensi',255)->nullable()->default(NULL);
            $table->string('status_presensi',25);
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
        Schema::dropIfExists('detail__presensis');
    }
}