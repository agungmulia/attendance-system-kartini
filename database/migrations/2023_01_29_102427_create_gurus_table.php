<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGurusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gurus', function (Blueprint $table) {
            $table->string('nip_guru',100)->primary();
            $table->string('foto_guru')->nullable();
            $table->string('nama_guru',100);
            $table->string('tempat_lahir_guru',100);
            $table->date('tanggal_lahir_guru');
            $table->string('alamat_guru',255);
            $table->string('jenis_kelamin_guru',15);
            $table->string('email_guru',100);
            $table->string('no_telp_guru',15);
            $table->string('password_guru',100);
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
        Schema::dropIfExists('gurus');
    }
}