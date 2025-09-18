<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class domisili extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Provinsi
        $provinsiJabar = \DB::table('provinsi')->insertGetId([
            'nama_provinsi' => 'Jawa Barat',
        ]);

        $provinsiJateng = \DB::table('provinsi')->insertGetId([
            'nama_provinsi' => 'Jawa Tengah',
        ]);

        // Kabupaten
        $kabBandung = \DB::table('kabupaten')->insertGetId([
            'provinsi_id' => $provinsiJabar,
            'nama_kabupaten' => 'Bandung',
        ]);

        $kabBekasi = \DB::table('kabupaten')->insertGetId([
            'provinsi_id' => $provinsiJabar,
            'nama_kabupaten' => 'Bekasi',
        ]);

        $kabSemarang = \DB::table('kabupaten')->insertGetId([
            'provinsi_id' => $provinsiJateng,
            'nama_kabupaten' => 'Semarang',
        ]);

        $kabSolo = \DB::table('kabupaten')->insertGetId([
            'provinsi_id' => $provinsiJateng,
            'nama_kabupaten' => 'Surakarta',
        ]);

        // Kecamatan
        $kecCimahi = \DB::table('kecamatan')->insertGetId([
            'kabupaten_id' => $kabBandung,
            'nama_kecamatan' => 'Cimahi',
        ]);

        $kecCibiru = \DB::table('kecamatan')->insertGetId([
            'kabupaten_id' => $kabBandung,
            'nama_kecamatan' => 'Cibiru',
        ]);

        $kecBantargebang = \DB::table('kecamatan')->insertGetId([
            'kabupaten_id' => $kabBekasi,
            'nama_kecamatan' => 'Bantar Gebang',
        ]);

        $kecUngaran = \DB::table('kecamatan')->insertGetId([
            'kabupaten_id' => $kabSemarang,
            'nama_kecamatan' => 'Ungaran',
        ]);

        $kecLaweyan = \DB::table('kecamatan')->insertGetId([
            'kabupaten_id' => $kabSolo,
            'nama_kecamatan' => 'Laweyan',
        ]);

        // Kelurahan
        \DB::table('kelurahan')->insert([
            ['kecamatan_id' => $kecCimahi, 'nama_kelurahan' => 'Cimahi Tengah'],
            ['kecamatan_id' => $kecCimahi, 'nama_kelurahan' => 'Cimahi Utara'],
            ['kecamatan_id' => $kecCibiru, 'nama_kelurahan' => 'Cibiru Wetan'],
            ['kecamatan_id' => $kecBantargebang, 'nama_kelurahan' => 'Cikiwul'],
            ['kecamatan_id' => $kecUngaran, 'nama_kelurahan' => 'Ungaran Barat'],
            ['kecamatan_id' => $kecLaweyan, 'nama_kelurahan' => 'Sriwedari'],
        ]);
    }
}
