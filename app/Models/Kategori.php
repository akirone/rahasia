<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris';

    protected $fillable = [
        'nama',
    ];

    /**
     * Get all pengaduan in this category
     *
     * @return HasMany<Pengaduan>
     */
    public function pengaduans(): HasMany
    {
        return $this->hasMany(Pengaduan::class);
    }
}
