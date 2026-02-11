<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'pengaduans';

    protected $fillable = [
        'user_id',
        'kategori_id',
        'tanggal',
        'lokasi',
        'keterangan',
        'foto',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
    ];

    /**
     * Get the user who created this pengaduan
     *
     * @return BelongsTo<User, Pengaduan>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category of this pengaduan
     *
     * @return BelongsTo<Kategori, Pengaduan>
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    /**
     * Get all feedback for this pengaduan
     *
     * @return HasMany<Feedback>
     */
    public function feedback(): HasMany
    {
        return $this->hasMany(Feedback::class);
    }

    /**
     * Scope for filtering by status
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for filtering by user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Get badge color based on status
     *
     * @return string
     */
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'Menunggu' => 'warning',
            'Proses' => 'info',
            'Selesai' => 'success',
            default => 'secondary'
        };
    }
}
