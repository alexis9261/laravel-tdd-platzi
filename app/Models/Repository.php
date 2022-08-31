<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repository extends Model
{
    use HasFactory;

    /**
     * Undocumented function long description
     *
     * @return User
     **/
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
