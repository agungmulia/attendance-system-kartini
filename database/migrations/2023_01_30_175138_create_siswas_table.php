<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->string('nis_siswa',100)->primary();
            $table->string('foto_siswa')->nullable();
            $table->string('nama_siswa',100);
            $table->string('alamat_siswa',255);
            $table->string('jenis_kelamin_siswa',15);
            $table->string('tempat_lahir_siswa',100);
            $table->date('tanggal_lahir_siswa');
            $table->string('email_siswa',100);
            $table->string('kode_kelas',50)->nullable();
            $table->foreign('kode_kelas')->references('kode_kelas')->on('kelas')->onUpdate('cascade');
            $table->string('no_telp_orang_tua',15)->nullable();
            $table->string('no_telp_siswa',15);
            $table->string('password_siswa',100);
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
        Schema::dropIfExists('siswas');
    }
}