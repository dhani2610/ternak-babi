<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaksin extends Model
{
    use HasFactory;

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'id_satuan');
    }

    public function pengeluaranVaksin()
    {
        return $this->hasMany(PengeluaranVaksin::class, 'id_vaksin');
    }

    public function inventoryVaksin()
    {
        return $this->hasMany(InventoryVaksin::class, 'id_vaksin');
    }

}
