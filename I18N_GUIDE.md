# i18n Sistemi Rehberi

## Özet

Bu proje, Laravel uygulaması için üretim hazır, veritabanı tabanlı çok dilli (i18n) bir sistem içermektedir. Sistem, dinamik çevirilerin yönetilmesi, yerelleştirme (localization), parametre interpolasyonu ve değişim geçmişinin takibi gibi tüm özellikleri sunar.

---

## Özellikler

### Backend (Laravel)
✅ **Veritabanı Tabanlı Çeviriler**
- `translations` tablosu: Çeviri anahtarları, değerleri, yerel ayarlar
- `language_files` tablosu: Dil dosyaları ve metadata
- `translation_histories` tablosu: Değişim geçmişi ve versiyon kontrolü

✅ **Eloquent Modelleri**
- `Translation` modeli: Scopes (locale, group, active, default), İlişkiler, Doğrulama
- `TranslationHistory` modeli: Değişim takibi, getDiff() metodu

✅ **Service Layer**
- `TranslationService`: 20+ metot, caching, fallback locale
- Metotlar: get, create, update, delete, group, getAllByLocale, syncFromFiles, getStats

✅ **REST API**
- 13 endpoint: İndex, göster, öğret, oluştur, toplu oluştur, güncelle, sil, tarih, senkronize, istatistik
- Request validasyonu ve hata yönetimi

### Frontend (TypeScript/Vue 3)
✅ **I18n Manager**
- `I18n` sınıfı: Locale yönetimi, çeviri alma, API entegrasyonu
- İlişkileri: Yerel depolama (localStorage), İnceleme depolaması (SessionStorage)
- Fallback locale desteği
- Parametre interpolasyonu ({name}, {count})

✅ **Vue 3 Plugin**
- `createVueI18nPlugin()`: Vue uygulamasına entegrasyon
- Global özellikleri: `$i18n`, `$t()`, `$locale()`, `$setLocale()`
- Event dinleyicileri: locale-changed

✅ **HTML Demo Sayfaları**
- Türkçe: `lang/tr/index.html`
- İngilizce: `lang/en/index.html`
- İşlevsel dil değiştiricisi, localStorage kalıcılığı

---

## Kurulum

### 1. Bağımlılıkları Yükle
```bash
npm install --legacy-peer-deps
```

### 2. Veritabanı Geçişini Çalıştır
```bash
php artisan migrate
```

### 3. Seeder Verilerini Yükle
```bash
php artisan db:seed --class=TranslationSeeder
```

### 4. TypeScript Derle
```bash
npm run ts:build
```

### 5. Geliştirme Sunucusunu Başlat
```bash
php artisan serve
npm run ts:watch      # Ayrı terminal penceresinde
```

---

## Kullanım

### PHP (Laravel)

#### Temel Çeviri Alma
```php
use App\Services\TranslationService;

$service = new TranslationService();

// Tek çeviri
$welcome = $service->get('app.welcome', 'tr');

// Parametrelerle çeviri
$message = $service->get('app.welcome_message', 'tr', null, [
    'name' => 'John',
    'app_name' => 'Laravel'
]);

// Fallback locale ile
$translation = $service->get('app.name', 'en', 'tr');
```

#### Grup Çevirilerini Alma
```php
// Tüm 'app' grubu çevirilerini al
$appTranslations = $service->group('app', 'tr');

// Sonuç:
// [
//     'app.name' => 'Uygulamam',
//     'app.welcome' => 'Hoşgeldiniz',
//     ...
// ]
```

#### Yerleşim (Locale) Çevirilerini Alma
```php
// Tüm Türkçe çeviriler (iç içe yapıda)
$trAll = $service->getAllByLocale('tr');

// Sonuç:
// [
//     'app' => [
//         'name' => 'Uygulamam',
//         'welcome' => 'Hoşgeldiniz',
//         ...
//     ],
//     'messages' => [...],
//     'validation' => [...]
// ]
```

#### Yeni Çeviri Oluşturma
```php
$translation = $service->create([
    'key' => 'app.new_feature',
    'locale' => 'tr',
    'value' => 'Yeni Özellik',
    'group' => 'app',
    'category' => 'features',
    'is_default' => false
]);
```

#### Çevirimi Güncelleme
```php
$updated = $service->update($translationId, [
    'value' => 'Güncellenmiş Değer'
]);

// Geçmişe kaydedilir ve changed_by, changed_at takip edilir
```

#### Çevirimi Silme
```php
$deleted = $service->delete($translationId);

// Soft delete: Veritabanında kalır, is_active = false
// Restore etmek için: $service->restore($translationId)
```

#### İstatistikler
```php
$stats = $service->getStats();

// Sonuç:
// [
//     'total' => 42,
//     'by_locale' => [
//         'tr' => 21,
//         'en' => 21
//     ],
//     'by_group' => [
//         'app' => 14,
//         'messages' => 14,
//         'validation' => 14
//     ],
//     'active' => 42,
//     'inactive' => 0
// ]
```

#### Model Scopes Kullanması
```php
use App\Models\Translation;

// Türkçe çeviriler
$turkish = Translation::locale('tr')->get();

// App grubu
$appGroup = Translation::group('app')->get();

// Aktif çeviriler
$active = Translation::active()->get();

// Varsayılan çeviriler
$default = Translation::default()->get();

// Kombinli
$activeTurkishApp = Translation::active()
    ->locale('tr')
    ->group('app')
    ->get();
```

#### Değişim Geçmişi
```php
$translation = Translation::find(1);

// Geçmiş kayıtlarını al
$history = $translation->history()->get();

foreach ($history as $record) {
    $diff = $record->getDiff();
    echo "Öncesi: " . $diff['before'];
    echo "Sonrası: " . $diff['after'];
    echo "Değiştirenler: " . $record->changed_by;
}
```

### TypeScript/JavaScript (Frontend)

#### Temel Kullanım
```typescript
import { createI18n, useI18n, t } from '@/utils/i18n';

// I18n örneğini oluştur
const i18n = createI18n('tr', 'tr', '/api');

// Çeviriler yükle
await i18n.loadTranslations('tr');

// Çeviriyi al
const welcome = i18n.t('app.welcome');

// Parametrelerle
const message = i18n.translate('app.welcome_message', {
    name: 'John',
    app_name: 'Laravel'
});

// Dili değiştir
await i18n.switchLocale('en');
```

#### Global Hook
```typescript
import { useI18n } from '@/utils/i18n';

const i18n = useI18n();

const translation = i18n.t('app.name');
const locale = i18n.getLocale();
```

#### Senkron Erişim (Cache)
```typescript
import { t } from '@/utils/i18n';

// Önceden yüklenmişse hızlı erişim
const welcome = t('app.welcome');
```

#### Async Erişim
```typescript
const i18n = useI18n();

const translation = await i18n.getTranslation('app.name', 'tr');
const groupTranslations = await i18n.getGroupTranslations('app', 'tr');
```

#### Dil Değiştirme
```typescript
const i18n = useI18n();

// Mevcut dilleri al
const locales = await i18n.getAvailableLocales();

// Dili değiştir
await i18n.switchLocale('en');

// Event dinle
window.addEventListener('locale-changed', (event: any) => {
    console.log('Yeni dil:', event.detail.locale);
});
```

#### Vue 3 Uygulamasında
```typescript
// main.ts
import { createVueI18nPlugin } from '@/utils/vue-i18n';

app.use(createVueI18nPlugin('tr', 'tr', '/api'));
```

```vue
<template>
  <div>
    <!-- Global $t fonksiyonunu kullan -->
    <h1>{{ $t('app.welcome') }}</h1>

    <!-- Dil değiştiricisi -->
    <select v-model="locale" @change="$setLocale(locale)">
      <option value="tr">Türkçe</option>
      <option value="en">English</option>
    </select>

    <!-- Mevcut dili göster -->
    <p>Mevcut Dil: {{ $locale() }}</p>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const locale = ref('tr');
</script>
```

#### Örnekleri Çalıştırma
```typescript
import * as examples from '@/i18n-examples';

// Hepsi
await examples.runAllI18nExamples();

// Belirli bir örnek
await examples.basicExample();
await examples.groupExample();
await examples.languageSwitchExample();
```

### C# / .NET (İstemci)

C# istemcileri için `Language_class.cs` sınıfı, Laravel i18n API'si ile iletişim kurma yöntemini sunar.

#### Temel Kullanım
```csharp
using Lang;

// i18n sınıfını başlat
var i18n = new LanguageClass(
    currentLocale: "tr",
    fallbackLocale: "tr",
    apiUrl: "http://localhost:8000/api"
);

// Çeviri al
var welcome = await i18n.GetTranslation("app.welcome", "tr");
Console.WriteLine(welcome); // "Hoşgeldiniz!"

// Parametrelerle
var message = await i18n.GetTranslation(
    "app.welcome_message",
    "tr",
    new Dictionary<string, string>
    {
        { "name", "Ali" },
        { "app_name", "Laravel" }
    }
);
// Result: "Merhaba Ali, Laravel uygulamasına hoş geldiniz!"
```

#### Grup Çevirilerine Erişim
```csharp
var i18n = new LanguageClass("tr", "tr", "http://localhost:8000/api");

// APP grubunu yükle
var appGroup = await i18n.GetGroupTranslations("app", "tr");

foreach (var kvp in appGroup)
{
    Console.WriteLine($"{kvp.Key}: {kvp.Value}");
}
```

#### Tüm Çeviriler
```csharp
// Türkçe çeviriler (iç içe yapı)
var trTranslations = await i18n.GetAllByLocale("tr");

// İngilizce çeviriler
var enTranslations = await i18n.GetAllByLocale("en");
```

#### Yerel Ayarları Alma
```csharp
var locales = await i18n.GetAvailableLocales();
// Result: ["tr", "en", ...]

foreach (var locale in locales)
{
    Console.WriteLine($"Available: {locale}");
}
```

#### İstatistikler
```csharp
var stats = await i18n.GetStats();
Console.WriteLine($"Total: {stats["total"]}");
// By Locale, By Group, Active, Inactive gibi bilgiler
```

#### Yeni Çeviri Oluşturma (Admin)
```csharp
var success = await i18n.CreateTranslation(
    key: "app.new_feature",
    locale: "tr",
    value: "Yeni Özellik",
    group: "app"
);

if (success)
{
    Console.WriteLine("Çeviri başarıyla oluşturuldu!");
    i18n.ClearCache(); // Önbellek temizle
}
```

#### Parametreler
```csharp
var template = "Merhaba {name}, {count} ileti alındı.";
var parameters = new Dictionary<string, string>
{
    { "name", "John" },
    { "count", "5" }
};

var result = i18n.InterpolateParameters(template, parameters);
// Result: "Merhaba John, 5 ileti alındı."
```

#### Önbellekle Ayarlanması
```csharp
var i18n = new LanguageClass("tr", "tr", "http://localhost:8000/api");

// İlk çağrı: API'den yüklenir ve cache'lenir
var group1 = await i18n.GetGroupTranslations("app", "tr");

// İkinci çağrı: Önbellekten gelir (hızlı)
var group2 = await i18n.GetGroupTranslations("app", "tr");

// Önbellek temizle
i18n.ClearCache();

// Üçüncü çağrı: Tekrar API'den yüklenir
var group3 = await i18n.GetGroupTranslations("app", "tr");
```

---

## Veritabanı Şeması

i18n sistemi 3 ana tablodan oluşur: `translations`, `language_files` ve `translation_histories`.

### Tablo 1: Translations (Çeviriler)
- **id**: Birincil anahtar
- **key**: Çeviri anahtarı (app.name, app.welcome_message, vb.)
- **locale**: Dil/Yerleşim (tr, en, de, vb.)
- **value**: Çevirinin değeri
- **group**: Çeviri grubu (app, messages, validation, vb.)
- **category**: Kategori (features, ui, messages, vb.)
- **is_default**: Varsayılan (fallback) çeviri mi?
- **is_active**: Aktif mi?
- **parameters**: JSON - Parametre adları (["name", "count"])
- **metadata**: JSON - Açıklamalar, versiyon vs.
- **created_by / updated_by**: Kullanıcı ID'leri
- **soft deletes**: Silme işlemi gerçekleşmez, deleted_at işaretlenir

### Tablo 2: Language Files (Dil Dosyaları)
- **id**: Birincil anahtar
- **locale**: Dil
- **group**: Grup adı
- **filepath**: Dosya yolu
- **file_hash**: Dosya hash'i (senkronizasyon için)
- **translation_count**: Bu dosyadaki çeviri sayısı
- **last_synced_at**: Son senkronizasyon zamanı

### Tablo 3: Translation Histories (Geçmiş)
- **id**: Birincil anahtar
- **translation_id**: Çeviri ID'si (Foreign Key)
- **old_value**: Önceki değer
- **new_value**: Yeni değer
- **changed_by**: Değişikliği yapan kullanıcı ID
- **change_reason**: Değişiklik nedeni
- **created_at**: Değişiklik zamanı

### Veritabanı Ayarı

Tam SQL şeması `lang/lang_db.sql` dosyasında bulunur. Makine bazlı kurulumu için:

```bash
# 1. SQL dosyasını kopyala
cat lang/lang_db.sql | mysql -u root -p

# 2. Alternatif olarak Laravel migration'ı çalıştır
php artisan migrate

# 3. Seeder verilerini yükle
php artisan db:seed --class=TranslationSeeder
```

### Index Yapıları

Performans için optimized:
- `idx_key_locale`: (key, locale)
- `idx_locale`: locale
- `idx_group`: group
- `idx_category`: category
- `idx_is_active`: is_active
- `unique_translation`: (key, locale, deleted_at)

### Cache Stratejileri

Laravel cache sistemi kullanılır:

| Cache Anahtarı | TTL | Amaç |
|---|---|---|
| `translations_{group}_{locale}` | 1 saat | Grup çeviriler |
| `translations_all_{locale}` | 2 saat | Tüm çeviriler |
| `language_files_{locale}` | 1 gün | Dosya metadata |
| `translation_stats` | 6 saat | İstatistikler |

---

## API Endpoints

### İndex
```
GET /api/translations
Sorgu Parametreleri:
  - locale: Belirli yerel ayar filtrası
  - group: Belirli grup filtrası
  - per_page: Sayfa başına İtemi (varsayılan: 15)
```

### Belirli Çeviri
```
GET /api/translations/{id}
Yanıt: Çeviri nesnesi
```

### Grup
```
GET /api/translations/group/{group}
Yanıt: Grup içindeki tüm çeviriler
```

### Yerleşim
```
GET /api/translations/locale/{locale}
Yanıt: İç içe yerleşim çevirileri
```

### Oluştur
```
POST /api/translations
İstek Yükü:
{
  "key": "app.new",
  "locale": "tr",
  "value": "Yeni Çeviri",
  "group": "app"
}
```

### Toplu Oluştur
```
POST /api/translations/bulk/store
İstek Yükü:
[
  { "key": "app.key1", "locale": "tr", "value": "...", "group": "app" },
  { "key": "app.key2", "locale": "tr", "value": "...", "group": "app" }
]
```

### Güncelle
```
PUT /api/translations/{id}
İstek Yükü:
{
  "value": "Güncellenmiş Değer"
}
```

### Sil
```
DELETE /api/translations/{id}
Yanıt: { "message": "Translation deleted" }
```

### Geçmiş
```
GET /api/translations/{id}/history
Yanıt: Değişim kayıtları
```

### Dosyalardan Senkronize Et
```
POST /api/translations/sync-files
Yanıt: Senkronize edilen çeviriler
```

### Cache Temizle
```
POST /api/translations/clear-cache
Yanıt: Başarı mesajı
```

### Mevcut Diller
```
GET /api/translations/locales
Yanıt: ["tr", "en"]
```

### İstatistikler
```
GET /api/translations/stats
Yanıt: İstatistik nesnesi
```

---

## Veritabanı Şeması

### translations tablosu
```sql
CREATE TABLE translations (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  key VARCHAR(255) NOT NULL,
  locale VARCHAR(10) NOT NULL,
  value LONGTEXT NOT NULL,
  group VARCHAR(100),
  category VARCHAR(100),
  is_default BOOLEAN DEFAULT FALSE,
  is_active BOOLEAN DEFAULT TRUE,
  parameters JSON,
  metadata JSON,
  created_at TIMESTAMP,
  updated_at TIMESTAMP,
  deleted_at TIMESTAMP (soft delete),
  UNIQUE INDEX unique_key_locale (key, locale),
  INDEX idx_locale (locale),
  INDEX idx_group (group),
  INDEX idx_category (category),
  INDEX idx_locale_group (locale, group),
  INDEX idx_is_active (is_active)
);
```

### language_files tablosu
```sql
CREATE TABLE language_files (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  locale VARCHAR(10) NOT NULL,
  file_path VARCHAR(255) NOT NULL,
  file_name VARCHAR(100) NOT NULL,
  last_synced_at TIMESTAMP,
  created_at TIMESTAMP,
  updated_at TIMESTAMP,
  UNIQUE INDEX unique_locale_path (locale, file_path)
);
```

### translation_histories tablosu
```sql
CREATE TABLE translation_histories (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  translation_id BIGINT NOT NULL,
  old_value LONGTEXT,
  new_value LONGTEXT,
  changed_by VARCHAR(255),
  changed_at TIMESTAMP,
  created_at TIMESTAMP,
  FOREIGN KEY (translation_id) REFERENCES translations(id) ON DELETE CASCADE,
  INDEX idx_translation_id (translation_id),
  INDEX idx_changed_at (changed_at)
);
```

---

## Konfigürasyon

### tsconfig.json
```json
{
  "compilerOptions": {
    "baseUrl": ".",
    "paths": {
      "@/*": ["public/ts/*"],
      "@types/*": ["public/ts/types/*"],
      "@utils/*": ["public/ts/utils/*"]
    }
  }
}
```

### I18n Parametreleri
```typescript
const i18n = createI18n(
  'tr',           // Varsayılan yerleşim
  'tr',           // Fallback yerleşim
  '/api'          // API taban URL'si
);
```

---

## Örnekler

### Örnek 1: Backend'de Çeviriler
```php
// Controller'da
public function welcome()
{
    $service = new TranslationService();

    return view('welcome', [
        'welcome' => $service->get('app.welcome', app()->getLocale()),
        'features' => $service->group('app', app()->getLocale())
    ]);
}
```

### Örnek 2: Frontend'de Dinamik Dil Değiştirme
```vue
<script setup>
import { useI18n } from '@/utils/i18n';
import { ref } from 'vue';

const i18n = useI18n();
const currentLocale = ref(i18n.getLocale());

const switchLanguage = async (newLocale) => {
    await i18n.switchLocale(newLocale);
    currentLocale.value = newLocale;
    // UI otomatik güncellenir
};
</script>

<template>
  <select :value="currentLocale" @change="switchLanguage">
    <option value="tr">Türkçe</option>
    <option value="en">English</option>
  </select>

  <h1>{{ $t('app.welcome') }}</h1>
</template>
```

### Örnek 3: Artisan Komutu ile Örnekleri Çalıştırma
```bash
# Tüm örnekleri çalıştır
php artisan i18n:examples --all

# İnteraktif menü
php artisan i18n:examples
```

---

## Hata Ayıklama

### Çeviriler Yüklenmedi
```typescript
// Cache'i temizle
const i18n = useI18n();
i18n.clearCache();

// Yeniden yükle
await i18n.loadTranslations('tr');
```

### Parametreler Çalışmıyor
```typescript
// Doğru format kontrol et
const msg = i18n.translate('app.welcome_message', {
    name: 'John',        // Büyük/küçük harf duyarlı!
    app_name: 'Laravel'
});
```

### API Bağlantı Hatası
```bash
# API sunucusunun çalışıp çalışmadığını kontrol et
php artisan serve

# CORS ayarlarını kontrol et (cors.php)
# API rota tanımlarını kontrol et (routes/api.php)
```

---

## Test Etme

### Laravel Artisan Komutlarından

i18n örneklerini çalıştır:
```bash
# Tüm örnekleri çalıştır
php artisan i18n:examples --all

# Interaktif olarak seç
php artisan i18n:examples
```

Example komutı şunları gösterir:
- Temel çeviri alma
- Veritabanından çeviri alma
- Grup çevirilerine erişim
- Yerel ayar çevirilerini alma
- Çeviri oluşturma/güncelleme/silme
- İstatistikler ve cache yönetimi
- Model scopes
- Değişim geçmişi

### PHP Unit Testi
```php
use App\Services\TranslationService;
use Tests\TestCase;

class TranslationServiceTest extends TestCase
{
    public function test_get_translation()
    {
        $service = new TranslationService();
        
        $translation = $service->get('app.welcome', 'tr');
        $this->assertIsString($translation);
        $this->assertNotEmpty($translation);
    }

    public function test_group_translations()
    {
        $service = new TranslationService();
        
        $group = $service->group('app', 'tr');
        $this->assertIsArray($group);
        $this->assertCount(5, $group); // En az 5 çeviri
    }

    public function test_create_translation()
    {
        $service = new TranslationService();
        
        $translation = $service->create([
            'key' => 'test.key',
            'locale' => 'tr',
            'value' => 'Test Değeri',
            'group' => 'test'
        ]);
        
        $this->assertNotNull($translation->id);
        $this->assertEquals('Test Değeri', $translation->value);
    }
}
```

### Postman API Testi

Postman collection oluştur:

**1. Tüm çeviriler al**
```
GET http://localhost:8000/api/translations
```

**2. Türkçe çeviriler**
```
GET http://localhost:8000/api/translations/locale/tr
```

**3. APP grubu**
```
GET http://localhost:8000/api/translations/group/app
```

**4. Belirli anahtarı al**
```
GET http://localhost:8000/api/translations/key/app.name
```

**5. Çeviri oluştur**
```
POST http://localhost:8000/api/translations
Content-Type: application/json

{
  "key": "app.new_key",
  "locale": "tr",
  "value": "Yeni Çeviri",
  "group": "app"
}
```

**6. Çeviriyi güncelle**
```
PUT http://localhost:8000/api/translations/1
Content-Type: application/json

{
  "value": "Güncellenmiş Çeviri"
}
```

**7. İstatistikler**
```
GET http://localhost:8000/api/translations/stats
```

### TypeScript Testi
```typescript
import { expect, describe, it } from 'vitest';
import { createI18n } from '@/utils/i18n';

describe('I18n', () => {
    const i18n = createI18n('tr', 'tr', '/api');

    it('should create instance', () => {
        expect(i18n).toBeDefined();
        expect(i18n.getLocale()).toBe('tr');
    });

    it('should translate', async () => {
        await i18n.loadTranslations('tr');
        const translation = i18n.t('app.welcome');
        expect(translation).toBeTruthy();
    });

    it('should interpolate parameters', () => {
        const result = i18n.interpolateParameters(
            'Merhaba {name}',
            { name: 'Ali' }
        );
        expect(result).toBe('Merhaba Ali');
    });
});
```

### C# Testi
```csharp
using Lang;
using Xunit;

public class LanguageClassTests
{
    private readonly LanguageClass _i18n;

    public LanguageClassTests()
    {
        _i18n = new LanguageClass("tr", "tr", "http://localhost:8000/api");
    }

    [Fact]
    public async Task GetTranslation_ShouldReturnString()
    {
        var result = await _i18n.GetTranslation("app.welcome", "tr");
        Assert.NotNull(result);
        Assert.NotEmpty(result);
    }

    [Fact]
    public void InterpolateParameters_ShouldReplace()
    {
        var template = "Merhaba {name}";
        var parameters = new Dictionary<string, string> 
        { 
            { "name", "Ali" } 
        };
        
        var result = _i18n.InterpolateParameters(template, parameters);
        Assert.Equal("Merhaba Ali", result);
    }

    [Fact]
    public async Task GetAvailableLocales_ShouldReturnList()
    {
        var locales = await _i18n.GetAvailableLocales();
        Assert.NotNull(locales);
        Assert.NotEmpty(locales);
    }
}
```

---

## Test Etme (Eski Versiyon)

### PHP Unit Testi
```php
public function test_translation_service()
{
    $service = new TranslationService();
    
    $translation = $service->get('app.welcome', 'tr');
    $this->assertIsString($translation);
    $this->assertNotEmpty($translation);
}
```

### TypeScript Testi
```typescript
import { createI18n } from '@/utils/i18n';

describe('I18n', () => {
    it('should translate correctly', async () => {
        const i18n = createI18n('tr', 'tr', '/api');
        const translation = await i18n.translate('app.welcome');
        expect(translation).toBeTruthy();
    });
});
```

---

1. **Caching**: Grup çeviriler 1 saat cache'lenir
2. **Lazy Loading**: Çeviriler ihtiyaç anında yüklenir
3. **Batch Operations**: Toplu oluştur işlemi kullanın
4. **Database Indexing**: Locale ve group için indexed
5. **localStorage**: Frontend çeviriler yerel depolamada kalır

---

## Test Etme

### PHP Unit Testi
```php
public function test_translation_service()
{
    $service = new TranslationService();

    $translation = $service->get('app.welcome', 'tr');
    $this->assertIsString($translation);
    $this->assertNotEmpty($translation);
}
```

### TypeScript Testi
```typescript
import { createI18n } from '@/utils/i18n';

describe('I18n', () => {
    it('should translate correctly', async () => {
        const i18n = createI18n('tr', 'tr', '/api');
        const translation = await i18n.translate('app.welcome');
        expect(translation).toBeTruthy();
    });
});
```

---

## Kaynaklar

- [Laravel Localization](https://laravel.com/docs/localization)
- [Vue 3 Plugins](https://vuejs.org/guide/reusability/plugins.html)
- [TypeScript Documentation](https://www.typescriptlang.org/docs/)
- [i18n Best Practices](https://www.w3.org/International/questions/qa-what-is-i18n)

---

## Lisans

MIT License - Bu proje açık kaynak ve özgürce kullanılabilir.

---

## Katkıda Bulunma

Katkılarınızı memnuniyetle karşılarız! Lütfen:

1. Bir fork oluşturun
2. Özellik dalı oluşturun (`git checkout -b feature/AmazingFeature`)
3. Değişikliklerinizi commit edin (`git commit -m 'Add some AmazingFeature'`)
4. Dalınıza push edin (`git push origin feature/AmazingFeature`)
5. Pull Request açın

---

**Sorular veya Sorunlar?** Issues sekmesinde bir sorun açın.
