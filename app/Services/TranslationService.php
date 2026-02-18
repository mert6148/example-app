<?php

namespace App\Services;

use App\Models\Translation;
use App\Models\TranslationHistory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * Translation Service
 *
 * Çeviri işlemlerini yönetir
 */
class TranslationService
{
    private const CACHE_PREFIX = 'translations';
    private const CACHE_TTL = 3600; // 1 saat

    /**
     * Tüm çeviriler
     */
    public function all(string $locale = null): Collection
    {
        if ($locale) {
            return Translation::locale($locale)->active()->get();
        }

        return Translation::active()->get();
    }

    /**
     * Grup içerisindeki çeviriler
     */
    public function group(string $group, string $locale = null): array
    {
        $cache_key = "{$this->getCacheKey()}.{$group}";
        if ($locale) {
            $cache_key .= ".{$locale}";
        }

        return Cache::remember($cache_key, self::CACHE_TTL, function () use ($group, $locale) {
            $query = Translation::group($group)->active();

            if ($locale) {
                $query->locale($locale);
            }

            $translations = $query->get();
            $result = [];

            foreach ($translations as $translation) {
                $result[$translation->key] = $translation->value;
            }

            return $result;
        });
    }

    /**
     * Tek bir çeviri al
     */
    public function get(string $key, string $locale = null, array $params = []): ?string
    {
        if (!$locale) {
            $locale = config('app.locale', 'tr');
        }

        $translation = Translation::where('key', $key)
            ->where('locale', $locale)
            ->active()
            ->first();

        if (!$translation) {
            // Varsayılan dile dön
            if ($locale !== config('app.fallback_locale', 'tr')) {
                return $this->get($key, config('app.fallback_locale', 'tr'), $params);
            }

            return $key;
        }

        return $translation->formatValue($params);
    }

    /**
     * Çeviri oluştur
     */
    public function create(array $data): Translation
    {
        $translation = Translation::create($data);
        $this->clearCache();

        return $translation;
    }

    /**
     * Çeviriler toplu oluştur
     */
    public function createMany(array $translations): Collection
    {
        $created = collect();

        foreach ($translations as $translation) {
            $created->push($this->create($translation));
        }

        return $created;
    }

    /**
     * Çeviri güncelle
     */
    public function update(Translation $translation, array $data): Translation
    {
        // Tarihçe kaydet
        if (isset($data['value']) && $data['value'] !== $translation->value) {
            TranslationHistory::create([
                'translation_id' => $translation->id,
                'old_value' => $translation->value,
                'new_value' => $data['value'],
                'changed_by' => auth()->user()?->email ?? 'system',
                'changed_at' => now()
            ]);
        }

        $translation->update($data);
        $this->clearCache();

        return $translation;
    }

    /**
     * Çeviri sil
     */
    public function delete(Translation $translation): bool
    {
        $result = $translation->delete();
        $this->clearCache();

        return $result;
    }

    /**
     * Çeviri geri yükle (soft delete)
     */
    public function restore(int $id): Translation
    {
        $translation = Translation::withTrashed()->find($id);
        $translation->restore();
        $this->clearCache();

        return $translation;
    }

    /**
     * Kalıcı olarak sil
     */
    public function forceDelete(Translation $translation): bool
    {
        $result = $translation->forceDelete();
        $this->clearCache();

        return $result;
    }

    /**
     * Belirli bir locale için tüm çeviriler
     */
    public function getAllByLocale(string $locale): array
    {
        $cache_key = $this->getCacheKey() . ".locale.{$locale}";

        return Cache::remember($cache_key, self::CACHE_TTL, function () use ($locale) {
            $translations = Translation::locale($locale)->active()->get();
            $result = [];

            foreach ($translations as $translation) {
                if (!isset($result[$translation->group])) {
                    $result[$translation->group] = [];
                }
                $result[$translation->group][$translation->key] = $translation->value;
            }

            return $result;
        });
    }

    /**
     * Dil dosyalarını veritabanına sync et
     */
    public function syncFromFiles(): int
    {
        $lang_path = resource_path('lang');
        $created = 0;

        if (!is_dir($lang_path)) {
            return $created;
        }

        $locales = array_diff(scandir($lang_path), ['.', '..']);

        foreach ($locales as $locale) {
            $locale_path = $lang_path . DIRECTORY_SEPARATOR . $locale;

            if (!is_dir($locale_path)) {
                continue;
            }

            $files = glob($locale_path . '/*.php');

            foreach ($files as $file) {
                $group = basename($file, '.php');
                $translations_array = require $file;

                $created += $this->syncGroupTranslations($group, $locale, $translations_array, $file);
            }
        }

        $this->clearCache();

        return $created;
    }

    /**
     * Grup çevirilerini sync et
     */
    private function syncGroupTranslations($group, $locale, array $data, $file_path): int
    {
        $created = 0;
        $prefix = '';

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                // Nested arrays'ı işle
                foreach ($value as $sub_key => $sub_value) {
                    $full_key = "{$prefix}{$key}.{$sub_key}";
                    $created += $this->syncSingleTranslation($full_key, $locale, $sub_value, $group, $file_path);
                }
            } else {
                $full_key = $prefix . $key;
                $created += $this->syncSingleTranslation($full_key, $locale, $value, $group, $file_path);
            }
        }

        return $created;
    }

    /**
     * Tek bir çevirimi sync et
     */
    private function syncSingleTranslation($key, $locale, $value, $group, $file_path): int
    {
        $translation = Translation::where('key', $key)
            ->where('locale', $locale)
            ->first();

        if (!$translation) {
            Translation::create([
                'key' => $key,
                'locale' => $locale,
                'value' => $value,
                'group' => $group,
                'file_path' => $file_path,
                'is_active' => true
            ]);

            return 1;
        } else {
            $translation->update(['value' => $value]);
        }

        return 0;
    }

    /**
     * Cache'i temizle
     */
    public function clearCache(): void
    {
        Cache::forget($this->getCacheKey());
        Cache::flush();
    }

    /**
     * Cache key'i al
     */
    private function getCacheKey(): string
    {
        return self::CACHE_PREFIX;
    }

    /**
     * Mevcut dilleri al
     */
    public function getAvailableLocales(): array
    {
        return Cache::remember(self::CACHE_PREFIX . '.locales', self::CACHE_TTL, function () {
            return Translation::distinct('locale')->pluck('locale')->toArray();
        });
    }

    /**
     * İstatistikler
     */
    public function getStats(): array
    {
        return [
            'total_translations' => Translation::count(),
            'locales' => Translation::distinct('locale')->count(),
            'groups' => Translation::distinct('group')->count(),
            'by_locale' => Translation::selectRaw('locale, COUNT(*) as count')
                ->groupBy('locale')
                ->pluck('count', 'locale')
                ->all()
        ];
    }
}
