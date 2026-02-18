<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Translation;
use App\Services\TranslationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * Translation API Controller
 */
class TranslationController extends Controller
{
    protected TranslationService $translationService;

    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;
    }

    /**
     * Tüm çeviriler
     */
    public function index(Request $request): JsonResponse
    {
        $locale = $request->get('locale');
        $group = $request->get('group');

        if ($group) {
            $translations = $this->translationService->group($group, $locale);
        } else {
            $translations = $this->translationService->all($locale);
        }

        return response()->json([
            'success' => true,
            'data' => $translations
        ]);
    }

    /**
     * Belirli locale için tüm çeviriler
     */
    public function byLocale(string $locale): JsonResponse
    {
        $translations = $this->translationService->getAllByLocale($locale);

        return response()->json([
            'success' => true,
            'locale' => $locale,
            'data' => $translations
        ]);
    }

    /**
     * Çeviri al
     */
    public function show(string $key, Request $request): JsonResponse
    {
        $locale = $request->get('locale', config('app.locale', 'tr'));
        $params = $request->get('params', []);

        $value = $this->translationService->get($key, $locale, $params);

        return response()->json([
            'success' => true,
            'key' => $key,
            'locale' => $locale,
            'value' => $value
        ]);
    }

    /**
     * Grup çevirilerini al
     */
    public function group(string $group, Request $request): JsonResponse
    {
        $locale = $request->get('locale', config('app.locale', 'tr'));
        $translations = $this->translationService->group($group, $locale);

        return response()->json([
            'success' => true,
            'group' => $group,
            'locale' => $locale,
            'data' => $translations
        ]);
    }

    /**
     * Çeviri oluştur
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate(Translation::rules());

        $translation = $this->translationService->create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Çeviri başarıyla oluşturuldu',
            'data' => $translation
        ], 201);
    }

    /**
     * Çeviri güncelle
     */
    public function update(Translation $translation, Request $request): JsonResponse
    {
        $validated = $request->validate(Translation::updateRules($translation->id));

        $updated = $this->translationService->update($translation, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Çeviri başarıyla güncellendi',
            'data' => $updated
        ]);
    }

    /**
     * Çeviri sil
     */
    public function destroy(Translation $translation): JsonResponse
    {
        $this->translationService->delete($translation);

        return response()->json([
            'success' => true,
            'message' => 'Çeviri başarıyla silindi'
        ]);
    }

    /**
     * Çeviri tarihçesi
     */
    public function history(Translation $translation): JsonResponse
    {
        $history = $translation->histories()
            ->orderByDesc('changed_at')
            ->get();

        return response()->json([
            'success' => true,
            'translation_key' => $translation->key,
            'data' => $history
        ]);
    }

    /**
     * Dil dosyalarını veritabanına sync et
     */
    public function syncFiles(): JsonResponse
    {
        $created = $this->translationService->syncFromFiles();

        return response()->json([
            'success' => true,
            'message' => "Toplam {$created} yeni çeviri senkronize edildi"
        ]);
    }

    /**
     * Mevcut dilleri al
     */
    public function locales(): JsonResponse
    {
        $locales = $this->translationService->getAvailableLocales();

        return response()->json([
            'success' => true,
            'data' => $locales
        ]);
    }

    /**
     * İstatistikler
     */
    public function stats(): JsonResponse
    {
        $stats = $this->translationService->getStats();

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Toplu çeviri oluştur
     */
    public function storeBulk(Request $request): JsonResponse
    {
        $translations = $request->validate([
            'translations' => 'required|array',
            'translations.*.key' => 'required|string',
            'translations.*.locale' => 'required|string',
            'translations.*.value' => 'required|string',
            'translations.*.group' => 'required|string'
        ]);

        $created = $this->translationService->createMany($translations['translations']);

        return response()->json([
            'success' => true,
            'message' => "Toplam " . $created->count() . " çeviri başarıyla oluşturuldu",
            'data' => $created
        ], 201);
    }

    /**
     * Cache'i temizle
     */
    public function clearCache(): JsonResponse
    {
        $this->translationService->clearCache();

        return response()->json([
            'success' => true,
            'message' => 'Cache başarıyla temizlendi'
        ]);
    }
}
