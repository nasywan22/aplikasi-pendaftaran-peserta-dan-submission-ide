<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class form_innovation extends Model
{
    protected $table = "form_innovation";

    protected $fillable = [
        "user_id",
        "judul",
        "deskripsi",
        "file_proposal",
    ];
}
