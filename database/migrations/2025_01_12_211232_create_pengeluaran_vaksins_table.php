<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengeluaran_vaksins', function (Blueprint $table) {
            $table->id();
            $table->integer('id_supplier')->nullable();
            $table->string('title');
            $table->integer('id_vaksin');
            $table->integer('qty');
            $table->string('price');
            $table->date('tanggal_pembelian');
            $table->date('tanggal_pengiriman');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluaran_vaksins');
    }
};
