<?php

namespace App\Helpers;

use App\Services\TranslationService;

class I18n
{
    /**
     * @var TranslationService
     */
    protected static $service;

    public static function init(TranslationService $service)
    {
        self::$service = $service;
    }

    public static function t(string $key, array $params = [], string $locale = null): string
    {
        if (!self::$service) {
            self::$service = app(TranslationService::class);
        }

        return self::$service->get($key, $locale ?? app()->getLocale(), $params);
    }
}
