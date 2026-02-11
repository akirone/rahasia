<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedback';

    protected $fillable = [
        'pengaduan_id',
        'user_id',
        'tanggal',
        'isi',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
    ];

    /**
     * Get the pengaduan that owns this feedback
     *
     * @return BelongsTo<Pengaduan, Feedback>
     */
    public function pengaduan(): BelongsTo
    {
        return $this->belongsTo(Pengaduan::class);
    }

    /**
     * Get the user who created this feedback
     *
     * @return BelongsTo<User, Feedback>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
