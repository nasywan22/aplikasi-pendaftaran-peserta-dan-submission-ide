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
        Schema::create('provinsi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_provinsi');
            $table->timestamps();
        });

        Schema::create('kabupaten', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provinsi_id')->constrained("provinsi")->onDelete('cascade');
            $table->string('nama_kabupaten');
            $table->timestamps();
        });

        Schema::create('kecamatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kabupaten_id')->constrained("kabupaten")->onDelete('cascade');
            $table->string('nama_kecamatan');
            $table->timestamps();
        });

        Schema::create('kelurahan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kecamatan_id')->constrained("kecamatan")->onDelete('cascade');
            $table->string('nama_kelurahan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $domisili = ["provinsi", "kabupaten", "kecamatan", "kelurahan"];
        foreach ($domisili as $table) {
            Schema::dropIfExists($table);
        }
    }
};
