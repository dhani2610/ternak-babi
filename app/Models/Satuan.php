<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    use HasFactory;

    public function vaksins()
    {
        return $this->hasMany(Vaksin::class, 'id_satuan');
    }
}
