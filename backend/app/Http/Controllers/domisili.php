<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class domisili extends Controller
{
    private function formatDomisili($dataDomisili)
    {
        $mapFields = [
            "provinsi" => ["id" => "provinsi_id", "nama_provinsi" => "nama_provinsi"],
            "kabupaten" => ["id" => "kabupaten_id", "nama_kabupaten" => "nama_kabupaten"],
            "kecamatan" => ["id" => "kecamatan_id", "nama_kecamatan" => "nama_kecamatan"],
            "kelurahan" => ["id" => "kelurahan_id", "nama_kelurahan" => "nama_kelurahan"],
        ];

        $result = [];
        foreach ($mapFields as $key => $fields) {
            $result[$key] = $dataDomisili
                ->map(fn($item) => [
                    "id" => $item->{$fields["id"]},
                    "nama_$key" => $item->{$fields["nama_$key"]},
                ])
                ->unique("id")
                ->values()
                ->all();
        }

        return $result;
    }


    public function ambilDomisili(Request $request)
    {
        $dataDomisili = \DB::table("provinsi")
            ->select("provinsi.id as provinsi_id", "provinsi.nama_provinsi", "kabupaten.id as kabupaten_id", "kabupaten.nama_kabupaten", "kecamatan.id as kecamatan_id", "kecamatan.nama_kecamatan", "kelurahan.id as kelurahan_id", "kelurahan.nama_kelurahan")
            ->join("kabupaten", "kabupaten.provinsi_id", "=", "provinsi.id")
            ->join("kecamatan", "kecamatan.kabupaten_id", "=", "kabupaten.id")
            ->join("kelurahan", "kelurahan.kecamatan_id", "=", "kecamatan.id")
            ->get();

        return response()->json($this->formatDomisili($dataDomisili), 200);
    }
}
