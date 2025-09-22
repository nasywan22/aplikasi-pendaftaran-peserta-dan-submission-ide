<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    public function profileRelation()
    {
        return $this->belongsTo(User::class, "user_id","id");
    }
}
