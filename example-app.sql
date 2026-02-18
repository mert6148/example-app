-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1:3306
-- Üretim Zamanı: 15 Şub 2026, 16:24:30
-- Sunucu sürümü: 9.1.0
-- PHP Sürümü: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `example-app`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `language_files`
--

DROP TABLE IF EXISTS `language_files`;
CREATE TABLE IF NOT EXISTS `language_files` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `file_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locale` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_synced_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `language_files_file_name_unique` (`file_name`),
  KEY `language_files_locale_group_index` (`locale`,`group`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2026_02_15_000000_create_translations_table', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `translations`
--

DROP TABLE IF EXISTS `translations`;
CREATE TABLE IF NOT EXISTS `translations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locale` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'tr',
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `group` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'app',
  `category` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `parameters` json DEFAULT NULL,
  `metadata` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_translation_key_locale` (`key`,`locale`),
  KEY `translations_locale_index` (`locale`),
  KEY `translations_group_index` (`group`),
  KEY `translations_category_index` (`category`),
  KEY `translations_locale_group_index` (`locale`,`group`),
  KEY `translations_is_active_index` (`is_active`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `translations`
--

INSERT INTO `translations` (`id`, `key`, `locale`, `value`, `group`, `category`, `file_path`, `is_default`, `is_active`, `notes`, `parameters`, `metadata`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'app.name', 'tr', 'Laravel Uygulaması', 'app', NULL, NULL, 1, 1, NULL, NULL, NULL, '2026-02-15 13:21:19', '2026-02-15 13:21:19', NULL),
(2, 'app.welcome', 'tr', 'Hoşgeldiniz!', 'app', NULL, NULL, 1, 1, NULL, NULL, NULL, '2026-02-15 13:21:19', '2026-02-15 13:21:19', NULL),
(3, 'app.welcome_message', 'tr', 'Merhaba {name}, {app_name} uygulamasına hoşgeldiniz!', 'app', NULL, NULL, 1, 1, NULL, NULL, NULL, '2026-02-15 13:21:19', '2026-02-15 13:21:19', NULL),
(4, 'messages.success', 'tr', 'İşlem başarıyla tamamlandı', 'messages', NULL, NULL, 0, 1, NULL, NULL, NULL, '2026-02-15 13:21:19', '2026-02-15 13:21:19', NULL),
(5, 'messages.error', 'tr', 'Bir hata oluştu, lütfen tekrar deneyin', 'messages', NULL, NULL, 0, 1, NULL, NULL, NULL, '2026-02-15 13:21:19', '2026-02-15 13:21:19', NULL),
(6, 'validation.required', 'tr', '{attribute} alanı zorunludur', 'validation', NULL, NULL, 0, 1, NULL, NULL, NULL, '2026-02-15 13:21:19', '2026-02-15 13:21:19', NULL),
(7, 'validation.email', 'tr', '{attribute} geçerli bir email adresi olmalıdır', 'validation', NULL, NULL, 0, 1, NULL, NULL, NULL, '2026-02-15 13:21:19', '2026-02-15 13:21:19', NULL),
(8, 'app.name', 'en', 'Laravel Application', 'app', NULL, NULL, 1, 1, NULL, NULL, NULL, '2026-02-15 13:21:19', '2026-02-15 13:21:19', NULL),
(9, 'app.welcome', 'en', 'Welcome!', 'app', NULL, NULL, 1, 1, NULL, NULL, NULL, '2026-02-15 13:21:19', '2026-02-15 13:21:19', NULL),
(10, 'app.welcome_message', 'en', 'Hello {name}, welcome to {app_name}!', 'app', NULL, NULL, 1, 1, NULL, NULL, NULL, '2026-02-15 13:21:19', '2026-02-15 13:21:19', NULL),
(11, 'messages.success', 'en', 'Operation completed successfully', 'messages', NULL, NULL, 0, 1, NULL, NULL, NULL, '2026-02-15 13:21:19', '2026-02-15 13:21:19', NULL),
(12, 'messages.error', 'en', 'An error occurred, please try again', 'messages', NULL, NULL, 0, 1, NULL, NULL, NULL, '2026-02-15 13:21:19', '2026-02-15 13:21:19', NULL),
(13, 'validation.required', 'en', '{attribute} field is required', 'validation', NULL, NULL, 0, 1, NULL, NULL, NULL, '2026-02-15 13:21:19', '2026-02-15 13:21:19', NULL),
(14, 'validation.email', 'en', '{attribute} must be a valid email address', 'validation', NULL, NULL, 0, 1, NULL, NULL, NULL, '2026-02-15 13:21:19', '2026-02-15 13:21:19', NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `translation_histories`
--

DROP TABLE IF EXISTS `translation_histories`;
CREATE TABLE IF NOT EXISTS `translation_histories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `translation_id` bigint UNSIGNED NOT NULL,
  `old_value` text COLLATE utf8mb4_unicode_ci,
  `new_value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `changed_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `changed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `translation_histories_translation_id_index` (`translation_id`),
  KEY `translation_histories_changed_at_index` (`changed_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
