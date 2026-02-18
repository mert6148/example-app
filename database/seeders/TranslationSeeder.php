<?php

namespace Database\Seeders;

use App\Models\Translation;
use Illuminate\Database\Seeder;

/**
 * Translation Seeder
 *
 * Varsayılan çeviriler
 */
class TranslationSeeder extends Seeder
{
    /**
     * Database'i seed et
     */
    public function run(): void
    {
        // Türkçe çeviriler
        $turkishTranslations = [
            [
                'key' => 'app.name',
                'locale' => 'tr',
                'value' => 'Laravel Uygulaması',
                'group' => 'app',
                'is_default' => true,
                'is_active' => true
            ],
            [
                'key' => 'app.welcome',
                'locale' => 'tr',
                'value' => 'Hoşgeldiniz!',
                'group' => 'app',
                'is_default' => true,
                'is_active' => true
            ],
            [
                'key' => 'app.welcome_message',
                'locale' => 'tr',
                'value' => 'Merhaba {name}, {app_name} uygulamasına hoşgeldiniz!',
                'group' => 'app',
                'is_default' => true,
                'is_active' => true
            ],
            [
                'key' => 'app.login',
                'locale' => 'tr',
                'value' => 'Giriş Yap',
                'group' => 'app',
                'is_active' => true
            ],
            [
                'key' => 'app.register',
                'locale' => 'tr',
                'value' => 'Kayıt Ol',
                'group' => 'app',
                'is_active' => true
            ],
            [
                'key' => 'app.logout',
                'locale' => 'tr',
                'value' => 'Çıkış Yap',
                'group' => 'app',
                'is_active' => true
            ],
            [
                'key' => 'messages.success',
                'locale' => 'tr',
                'value' => 'İşlem başarıyla tamamlandı',
                'group' => 'messages',
                'is_active' => true
            ],
            [
                'key' => 'messages.error',
                'locale' => 'tr',
                'value' => 'Bir hata oluştu, lütfen tekrar deneyin',
                'group' => 'messages',
                'is_active' => true
            ],
            [
                'key' => 'validation.required',
                'locale' => 'tr',
                'value' => '{attribute} alanı zorunludur',
                'group' => 'validation',
                'is_active' => true
            ],
            [
                'key' => 'validation.email',
                'locale' => 'tr',
                'value' => '{attribute} geçerli bir email adresi olmalıdır',
                'group' => 'validation',
                'is_active' => true
            ]
        ];

        // İngilizce çeviriler
        $englishTranslations = [
            [
                'key' => 'app.name',
                'locale' => 'en',
                'value' => 'Laravel Application',
                'group' => 'app',
                'is_default' => true,
                'is_active' => true
            ],
            [
                'key' => 'app.welcome',
                'locale' => 'en',
                'value' => 'Welcome!',
                'group' => 'app',
                'is_default' => true,
                'is_active' => true
            ],
            [
                'key' => 'app.welcome_message',
                'locale' => 'en',
                'value' => 'Hello {name}, welcome to {app_name}!',
                'group' => 'app',
                'is_default' => true,
                'is_active' => true
            ],
            [
                'key' => 'app.login',
                'locale' => 'en',
                'value' => 'Login',
                'group' => 'app',
                'is_active' => true
            ],
            [
                'key' => 'app.register',
                'locale' => 'en',
                'value' => 'Register',
                'group' => 'app',
                'is_active' => true
            ],
            [
                'key' => 'app.logout',
                'locale' => 'en',
                'value' => 'Logout',
                'group' => 'app',
                'is_active' => true
            ],
            [
                'key' => 'messages.success',
                'locale' => 'en',
                'value' => 'Operation completed successfully',
                'group' => 'messages',
                'is_active' => true
            ],
            [
                'key' => 'messages.error',
                'locale' => 'en',
                'value' => 'An error occurred, please try again',
                'group' => 'messages',
                'is_active' => true
            ],
            [
                'key' => 'validation.required',
                'locale' => 'en',
                'value' => '{attribute} field is required',
                'group' => 'validation',
                'is_active' => true
            ],
            [
                'key' => 'validation.email',
                'locale' => 'en',
                'value' => '{attribute} must be a valid email address',
                'group' => 'validation',
                'is_active' => true
            ]
        ];

        // Yinelenen anahtarları sil
        $all_translations = array_merge($turkishTranslations, $englishTranslations);

        foreach ($all_translations as $translation) {
            Translation::updateOrCreate(
                ['key' => $translation['key'], 'locale' => $translation['locale']],
                $translation
            );
        }

        $this->command->info('Translation seeder başarıyla çalıştırıldı!');
    }
}
