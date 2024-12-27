<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penilaian extends Model
{
    use HasFactory;

    protected $fillable = [
        'alternatif_id',
        'kriteria_id',
        'sub_kriteria_id',
    ];

    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id', 'id');
    }
    public function alternatif(): BelongsTo
    {
        return $this->belongsTo(Alternatif::class);
    }
    public function sub(): BelongsTo
    {
        return $this->belongsTo(SubKriteria::class, 'sub_kriteria_id', 'id');
    }
}
