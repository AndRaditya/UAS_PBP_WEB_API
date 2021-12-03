<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiObatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_obats', function (Blueprint $table) {
            $table->id();
            $table->string('namaPembeli');
            $table->string('nomorHpPembeli');
            $table->string('alamatPembeli');
            $table->string('umurPembeli');
            $table->integer('jumlahBeli');
            $table->integer('idObat');
            $table->double('totalBayarObat');
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
        Schema::dropIfExists('transaksi_obats');
    }
}