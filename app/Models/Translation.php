<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Translation Model
 * 
 * @property int $id
 * @property string $key
 * @property string $locale
 * @property string $value
 * @property string $group
 * @property string|null $category
 * @property string|null $file_path
 * @property bool $is_default
 * @property bool $is_active
 * @property string|null $notes
 * @property array|null $parameters
 * @property array|null $metadata
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 */
class Translation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'key',
        'locale',
        'value',
        'group',
        'category',
        'file_path',
        'is_default',
        'is_active',
        'notes',
        'parameters',
        'metadata'
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'is_active' => 'boolean',
        'parameters' => 'json',
        'metadata' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    /**
     * Geçerlenyetmeme kuralları
     */
    public static function rules(): array
    {
        return [
            'key' => 'required|string|unique:translations',
            'locale' => 'required|string|max:10',
            'value' => 'required|string',
            'group' => 'required|string|max:50',
            'category' => 'nullable|string|max:50',
            'is_active' => 'boolean'
        ];
    }

    /**
     * Güncelleme kuralları
     */
    public static function updateRules($id): array
    {
        return [
            'key' => 'required|string|unique:translations,key,' . $id,
            'locale' => 'required|string|max:10',
            'value' => 'required|string',
            'group' => 'required|string|max:50',
            'category' => 'nullable|string|max:50',
            'is_active' => 'boolean'
        ];
    }

    /**
     * Çevirinin tarihçesini al
     */
    public function histories()
    {
        return $this->hasMany(TranslationHistory::class, 'translation_id');
    }

    /**
     * Belirli dile göre çeviriler
     */
    public static function scopeLocale($query, $locale)
    {
        return $query->where('locale', $locale);
    }

    /**
     * Belirli gruba göre çeviriler
     */
    public static function scopeGroup($query, $group)
    {
        return $query->where('group', $group);
    }

    /**
     * Aktif çeviriler
     */
    public static function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Varsayılan çeviriler
     */
    public static function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    /**
     * Parametrelerle metni biçimlendir
     */
    public function formatValue(array $params = []): string
    {
        $value = $this->value;

        foreach ($params as $key => $value_param) {
            $value = str_replace('{' . $key . '}', $value_param, $value);
        }

        return $value;
    }

    /**
     * Bu çevirinin tüm dillerdeki çevirilerini al
     */
    public function getTranslations()
    {
        return self::where('key', $this->key)->get();
    }

    /**
     * Başka bir dilde çeviriye erişim
     */
    public function translate($locale)
    {
        return self::where('key', $this->key)
            ->where('locale', $locale)
            ->first();
    }
}
