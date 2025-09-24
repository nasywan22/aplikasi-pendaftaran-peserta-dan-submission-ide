<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $table = "profiles";

    protected $fillable = [
        'user_id',
        'school',
        'provinsi_id',
        'kabupaten_id',
        'kecamatan_id',
        'kelurahan_id',
        'photo',
    ];


    public function profileRelation()
    {
        return $this->belongsTo(User::class, "user_id","id");
    }
}
