<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        date_default_timezone_set("Asia/Jakarta");
        DB::table("form_innovation")->insert([
            "id" => 1,
            "user_id" => 1,
            "judul" => "Ide infrastruktur terbaru",
            "deskripsi" => "ya begitulahh...",
            "file"=> "https://picsum.photos/200",
        ]);
    }
}
