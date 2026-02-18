<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * TranslationHistory Model
 *
 * Çeviri değişiklik kaydı
 */
class TranslationHistory extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'translation_id',
        'old_value',
        'new_value',
        'changed_by',
        'changed_at'
    ];

    protected $casts = [
        'changed_at' => 'datetime'
    ];

    /**
     * İlişkili çeviriye erişim
     */
    public function translation(): BelongsTo
    {
        return $this->belongsTo(Translation::class, 'translation_id');
    }

    /**
     * Farkları göster
     */
    public function getDiff(): array
    {
        return [
            'from' => $this->old_value,
            'to' => $this->new_value,
            'changed_by' => $this->changed_by,
            'changed_at' => $this->changed_at
        ];
    }
}
