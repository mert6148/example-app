<?php

namespace App\Examples;

use App\Models\Translation;
use App\Services\TranslationService;
use Illuminate\Support\Facades\Cache;

/**
 * i18n Kullanım Örnekleri (Laravel)
 */
class I18nExamples
{
    /**
     * Örnek 1: Temel Çeviri Alma
     */
    public static function basicTranslationExample(): void
    {
        echo "=== i18n - Basic Example ===\n";

        // Belirli bir çeviriyi al
        $welcome = __('app.welcome');
        echo "Welcome: {$welcome}\n";

        // Parametrelerle çeviri
        $message = __('app.welcome_message', [
            'name' => 'John',
            'app_name' => 'Laravel'
        ]);
        echo "Message: {$message}\n";

        echo "\n";
    }

    /**
     * Örnek 2: Veritabanından Çeviri Alma
     */
    public static function databaseTranslationExample(): void
    {
        echo "=== i18n - Database Example ===\n";

        $service = new TranslationService();

        // Tek bir çeviri al
        $translation = $service->get('app.name', 'tr');
        echo "Translation (TR): {$translation}\n";

        // Fallback locale ile
        $translation = $service->get('app.name', 'en', 'tr');
        echo "Translation (EN/fallback TR): {$translation}\n";

        // Parametrelerle
        $welcomeMsg = $service->get('app.welcome_message', 'tr', null, [
            'name' => 'Ali',
            'app_name' => 'Laravel Uygulaması'
        ]);
        echo "Welcome Message: {$welcomeMsg}\n";

        echo "\n";
    }

    /**
     * Örnek 3: Grup Çevirilerini Alma
     */
    public static function groupTranslationsExample(): void
    {
        echo "=== i18n - Group Translations Example ===\n";

        $service = new TranslationService();

        // Tüm app grubu çevirilerini al
        $appTranslations = $service->group('app', 'tr');
        echo "App Translations (TR):\n";
        foreach ($appTranslations as $key => $value) {
            echo "  {$key}: {$value}\n";
        }

        // Mesajlar grubu
        $messages = $service->group('messages', 'en');
        echo "\nMessages (EN):\n";
        foreach ($messages as $key => $value) {
            echo "  {$key}: {$value}\n";
        }

        echo "\n";
    }

    /**
     * Örnek 4: Yerleşim (Locale) Çevirilerini Alma
     */
    public static function localeTranslationsExample(): void
    {
        echo "=== i18n - Locale Translations Example ===\n";

        $service = new TranslationService();

        // Türkçe çeviriler (iç içe yapıda)
        $trTranslations = $service->getAllByLocale('tr');
        echo "Turkish Translations:\n";
        echo json_encode($trTranslations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";

        // İngilizce çeviriler
        $enTranslations = $service->getAllByLocale('en');
        echo "\nEnglish Translations:\n";
        echo json_encode($enTranslations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";

        echo "\n";
    }

    /**
     * Örnek 5: Çeviri Oluşturma
     */
    public static function createTranslationExample(): void
    {
        echo "=== i18n - Create Translation Example ===\n";

        $service = new TranslationService();

        // Yeni çeviri oluştur
        $translation = $service->create([
            'key' => 'app.new_feature',
            'locale' => 'tr',
            'value' => 'Yeni Özellik',
            'group' => 'app',
            'category' => 'features',
            'is_default' => false,
            'parameters' => json_encode([])
        ]);

        echo "Created Translation:\n";
        echo "  ID: {$translation->id}\n";
        echo "  Key: {$translation->key}\n";
        echo "  Value: {$translation->value}\n";

        // İngilizce versiyonunu da oluştur
        $translationEn = $service->create([
            'key' => 'app.new_feature',
            'locale' => 'en',
            'value' => 'New Feature',
            'group' => 'app',
            'category' => 'features',
            'is_default' => false
        ]);

        echo "\nEnglish Translation:\n";
        echo "  ID: {$translationEn->id}\n";
        echo "  Value: {$translationEn->value}\n";

        echo "\n";
    }

    /**
     * Örnek 6: Çeviri Güncelleme
     */
    public static function updateTranslationExample(): void
    {
        echo "=== i18n - Update Translation Example ===\n";

        $service = new TranslationService();

        // Çeviriyi güncelle
        $translation = $service->update(1, [
            'value' => 'Güncellenmiş Hoşgeldiniz'
        ]);

        echo "Updated Translation:\n";
        echo "  Value: {$translation->value}\n";
        echo "  Updated At: {$translation->updated_at}\n";

        // Parametrelerle güncelle
        $translation = $service->update(2, [
            'value' => 'Merhaba {name}, {app_name} uygulamasına hoş geldiniz!',
            'parameters' => json_encode(['name', 'app_name'])
        ]);

        echo "\nWith Parameters:\n";
        echo "  Template: {$translation->value}\n";

        echo "\n";
    }

    /**
     * Örnek 7: Çeviri Silme
     */
    public static function deleteTranslationExample(): void
    {
        echo "=== i18n - Delete Translation Example ===\n";

        $service = new TranslationService();

        // Çeviriyi sil
        $result = $service->delete(1);
        echo "Translation deleted: " . ($result ? 'Yes' : 'No') . "\n";

        // Soft delete nedeniyle veritabanında kalır
        $deleted = Translation::onlyTrashed()->find(1);
        if ($deleted) {
            echo "Found in soft deleted: {$deleted->value}\n";
        }

        echo "\n";
    }

    /**
     * Örnek 8: İstatistikler
     */
    public static function statisticsExample(): void
    {
        echo "=== i18n - Statistics Example ===\n";

        $service = new TranslationService();

        $stats = $service->getStats();
        echo "Translation Statistics:\n";
        echo "  Total: {$stats['total']}\n";
        echo "  By Locale:\n";
        foreach ($stats['by_locale'] as $locale => $count) {
            echo "    {$locale}: {$count}\n";
        }
        echo "  By Group:\n";
        foreach ($stats['by_group'] as $group => $count) {
            echo "    {$group}: {$count}\n";
        }
        echo "  Active: {$stats['active']}\n";
        echo "  Inactive: {$stats['inactive']}\n";

        echo "\n";
    }

    /**
     * Örnek 9: Cache Yönetimi
     */
    public static function cacheExample(): void
    {
        echo "=== i18n - Cache Example ===\n";

        $service = new TranslationService();

        // İlk istekte API'den yükle ve cache'le
        $cacheKey = 'translations_app_tr';
        $translations = Cache::remember($cacheKey, 3600, function () use ($service) {
            return $service->group('app', 'tr');
        });

        echo "Translations cached:\n";
        foreach ($translations as $key => $value) {
            echo "  {$key}: {$value}\n";
        }

        // Cache'i temizle
        Cache::forget($cacheKey);
        echo "\nCache cleared\n";

        echo "\n";
    }

    /**
     * Örnek 10: Dosyalardan Senkronizasyon
     */
    public static function syncFromFilesExample(): void
    {
        echo "=== i18n - Sync from Files Example ===\n";

        $service = new TranslationService();

        // Lang dosyalarından senkronize et
        $synced = $service->syncFromFiles();

        echo "Synced translations:\n";
        foreach ($synced as $locale => $groups) {
            echo "  Locale: {$locale}\n";
            foreach ($groups as $group => $count) {
                echo "    {$group}: {$count} translations\n";
            }
        }

        echo "\n";
    }

    /**
     * Örnek 11: Model Scopes
     */
    public static function scopesExample(): void
    {
        echo "=== i18n - Model Scopes Example ===\n";

        // Türkçe çeviriler
        $trTranslations = Translation::locale('tr')->get();
        echo "Turkish Translations: " . $trTranslations->count() . "\n";

        // App grubu çeviriler
        $appGroup = Translation::group('app')->get();
        echo "App Group: " . $appGroup->count() . "\n";

        // Aktif çeviriler
        $active = Translation::active()->get();
        echo "Active: " . $active->count() . "\n";

        // Varsayılan çeviriler
        $default = Translation::default()->get();
        echo "Default: " . $default->count() . "\n";

        // Kombinli scope'lar
        $activeTr = Translation::active()->locale('tr')->get();
        echo "Active Turkish: " . $activeTr->count() . "\n";

        echo "\n";
    }

    /**
     * Örnek 12: Değişim Geçmişi
     */
    public static function translationHistoryExample(): void
    {
        echo "=== i18n - Translation History Example ===\n";

        // Bir çeviriyi güncelleyelim (bu tarih kaydı oluşturacak)
        $service = new TranslationService();
        $translation = $service->update(1, [
            'value' => 'Yeni Değer'
        ]);

        // Geçmiş kayıtlarını al
        $history = $translation->history()->get();
        echo "History Records: " . $history->count() . "\n";

        foreach ($history as $record) {
            echo "  - Changed by: {$record->changed_by}\n";
            echo "    At: {$record->changed_at}\n";
            $diff = $record->getDiff();
            echo "    Before: {$diff['before']}\n";
            echo "    After: {$diff['after']}\n";
        }

        echo "\n";
    }

    /**
     * Tüm Örnekleri Çalıştır
     */
    public static function runAll(): void
    {
        echo "\n🌍 i18n Examples Started\n\n";

        self::basicTranslationExample();
        self::databaseTranslationExample();
        self::groupTranslationsExample();
        self::localeTranslationsExample();
        self::createTranslationExample();
        self::updateTranslationExample();
        self::deleteTranslationExample();
        self::statisticsExample();
        self::cacheExample();
        self::syncFromFilesExample();
        self::scopesExample();
        self::translationHistoryExample();

        echo "✅ i18n Examples Completed\n\n";
    }
}
