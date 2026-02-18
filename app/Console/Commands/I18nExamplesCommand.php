<?php

namespace App\Console\Commands;

use App\Examples\I18nExamples;
use Illuminate\Console\Command;

class I18nExamplesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'i18n:examples {--all : Tüm örnekleri çalıştır}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'i18n örneklerini çalıştır';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if ($this->option('all')) {
            I18nExamples::runAll();
        } else {
            $this->info('i18n örneklerini çalıştırmak için bir seçim yapın:');
            $examples = [
                'basic' => 'Temel çeviri alma',
                'database' => 'Veritabanından çeviri alma',
                'group' => 'Grup çevirilerini alma',
                'locale' => 'Yerleşim çevirilerini alma',
                'create' => 'Çeviri oluşturma',
                'update' => 'Çeviri güncelleme',
                'delete' => 'Çeviri silme',
                'stats' => 'İstatistikler',
                'cache' => 'Cache yönetimi',
                'sync' => 'Dosyalardan senkronizasyon',
                'scopes' => 'Model scopes',
                'history' => 'Değişim geçmişi',
            ];

            $choice = $this->choice(
                'Hangi örneği çalıştırmak istersiniz?',
                $examples,
                0,
                null,
                true
            );

            if ($choice && isset($examples[$choice])) {
                $method = $choice . 'Example';
                $method = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $choice)))) . 'Example';

                if (method_exists(I18nExamples::class, $method)) {
                    I18nExamples::$method();
                    $this->info("\n✅ Örnek başarıyla çalıştırıldı!");
                } else {
                    $this->error("Örnek metodu bulunamadı: {$method}");
                    return 1;
                }
            }
        }

        return 0;
    }
}
