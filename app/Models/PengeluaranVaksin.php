<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengeluaranVaksin extends Model
{
    use HasFactory;
    
    public function vaksin()
    {
        return $this->belongsTo(Vaksin::class, 'id_vaksin');
    }
}
