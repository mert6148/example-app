<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Helpers\I18n;
use App\Services\TranslationService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // initialize the translation helper
        I18n::init($this->app->make(TranslationService::class));

        // blade directive for quick translation: @t('app.key', ['param'=>val])
        Blade::directive('t', function ($expression) {
            return "<?php echo \\App\\Helpers\\I18n::t($expression); ?>";
        });
    }
}
