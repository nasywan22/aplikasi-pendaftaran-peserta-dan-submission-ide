<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class form extends Controller
{
    public function kirimInovasi(Request $request)
    {
        $dataHasilValidasi = $request->validate([
            "judul" => "required|string",
            "deskripsi" => "required|string",
            "proposal" => "required|file|mimes:pdf|max:2048",
        ]);

        try {
            $path = $request->file("proposal")->store("proposal", "public");

            \App\Models\form_innovation::create([
                "user_id" => \Auth::id(),
                "judul" => $dataHasilValidasi["judul"],
                "deskripsi" => $dataHasilValidasi["deskripsi"],
                "file_proposal" => $path,
            ]);

            return response()->json([
                "message" => "Form berhasil dikirim"
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                "error" => $e->getMessage(),
            ], 500);
        }
    }
}
