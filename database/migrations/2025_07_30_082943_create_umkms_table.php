<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('umkms', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('usaha', 200)->nullable();
            $table->string('kelurahan_desa', 100)->nullable();
            $table->decimal('x', 12, 8)->nullable();
            $table->decimal('y', 12, 8)->nullable();
            $table->string('kontak', 100)->nullable();
            $table->string('kelas_usaha', 100)->nullable();
            $table->enum('resiko_sdm', ['Rendah', 'Sedang', 'Tinggi'])->nullable();
            $table->enum('risiko_pemodalan', ['Rendah', 'Sedang', 'Tinggi'])->nullable();
            $table->enum('risiko_produksi', ['Rendah', 'Sedang', 'Tinggi'])->nullable();
            $table->enum('risiko_pemasaran', ['Rendah', 'Sedang', 'Tinggi'])->nullable();
            $table->enum('risiko_hukum', ['Rendah', 'Sedang', 'Tinggi'])->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('umkms');
    }
};