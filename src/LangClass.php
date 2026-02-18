<?php

namespace App\Src;

use PDO;
use PDOException;

/**
 * Simple PHP i18n helper modeled after lang_class.java
 * Connects to MySQL via PDO, caches results in static memory.
 */
class LangClass
{
    private PDO $pdo;
    private string $currentLocale;
    private string $fallbackLocale;
    private static array $cache = [];
    private static int $cacheTtl = 3600;

    public function __construct(
        string $dsn,
        string $user,
        string $pass,
        string $currentLocale = 'tr',
        string $fallbackLocale = 'tr'
    ) {
        $this->currentLocale = $currentLocale;
        $this->fallbackLocale = $fallbackLocale;
        $this->pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }

    public function get(string $key, ?string $locale = null, array $params = []): string
    {
        $locale = $locale ?? $this->currentLocale;
        $cacheKey = "key:$key:$locale";
        if (isset(self::$cache[$cacheKey]) && time() < self::$cache[$cacheKey]['expires']) {
            return $this->interpolate(self::$cache[$cacheKey]['value'], $params);
        }

        $stmt = $this->pdo->prepare(
            'SELECT value FROM translations WHERE `key` = :key AND locale = :locale AND is_active = 1 LIMIT 1'
        );
        $stmt->execute(['key' => $key, 'locale' => $locale]);
        $row = $stmt->fetch();
        $value = $row['value'] ?? $key;

        self::$cache[$cacheKey] = [
            'value' => $value,
            'expires' => time() + self::$cacheTtl
        ];

        return $this->interpolate($value, $params);
    }

    public function group(string $group, ?string $locale = null): array
    {
        $locale = $locale ?? $this->currentLocale;
        $cacheKey = "group:$group:$locale";
        if (isset(self::$cache[$cacheKey]) && time() < self::$cache[$cacheKey]['expires']) {
            return self::$cache[$cacheKey]['data'];
        }

        $stmt = $this->pdo->prepare(
            'SELECT `key`, `value` FROM translations WHERE `group` = :group AND locale = :locale AND is_active = 1'
        );
        $stmt->execute(['group' => $group, 'locale' => $locale]);
        $result = [];
        while ($row = $stmt->fetch()) {
            $result[$row['key']] = $row['value'];
        }

        self::$cache[$cacheKey] = [
            'data' => $result,
            'expires' => time() + self::$cacheTtl
        ];

        return $result;
    }

    private function interpolate(string $template, array $params): string
    {
        if ($template === '' || empty($params)) {
            return $template;
        }
        foreach ($params as $k => $v) {
            $template = str_replace('{' . $k . '}', $v, $template);
        }
        return $template;
    }

    public function clearCache(): void
    {
        self::$cache = [];
    }
}
