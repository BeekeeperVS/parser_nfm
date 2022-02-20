-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: mysql_db:3306
-- Час створення: Лют 20 2022 р., 18:14
-- Версія сервера: 8.0.19
-- Версія PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `nfm_catalog`
--

-- --------------------------------------------------------

--
-- Структура таблиці `nc_brand`
--

CREATE TABLE `nc_brand` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `nc_model`
--

CREATE TABLE `nc_model` (
  `id` bigint UNSIGNED NOT NULL,
  `external_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `series_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `nc_part`
--

CREATE TABLE `nc_part` (
  `id` bigint UNSIGNED NOT NULL,
  `number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `usage` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight` decimal(10,3) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `nc_product_group`
--

CREATE TABLE `nc_product_group` (
  `id` bigint UNSIGNED NOT NULL,
  `external_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_type_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `nc_product_type`
--

CREATE TABLE `nc_product_type` (
  `id` bigint UNSIGNED NOT NULL,
  `external_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `nc_scheme`
--

CREATE TABLE `nc_scheme` (
  `id` bigint UNSIGNED NOT NULL,
  `external_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  `section_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `assembly_image` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `nc_scheme_part`
--

CREATE TABLE `nc_scheme_part` (
  `id` bigint UNSIGNED NOT NULL,
  `scheme_id` bigint UNSIGNED NOT NULL,
  `part_id` bigint UNSIGNED NOT NULL,
  `position` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `nc_section`
--

CREATE TABLE `nc_section` (
  `id` bigint UNSIGNED NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `nc_series`
--

CREATE TABLE `nc_series` (
  `id` bigint UNSIGNED NOT NULL,
  `external_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_group_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `system_migration`
--

CREATE TABLE `system_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `nc_brand`
--
ALTER TABLE `nc_brand`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `nc_model`
--
ALTER TABLE `nc_model`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nc_model_series_id_foreign` (`series_id`);

--
-- Індекси таблиці `nc_part`
--
ALTER TABLE `nc_part`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `nc_product_group`
--
ALTER TABLE `nc_product_group`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nc_product_group_external_id_unique` (`external_id`),
  ADD KEY `nc_product_group_product_type_id_foreign` (`product_type_id`);

--
-- Індекси таблиці `nc_product_type`
--
ALTER TABLE `nc_product_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nc_product_type_external_id_unique` (`external_id`),
  ADD KEY `nc_product_type_brand_id_foreign` (`brand_id`);

--
-- Індекси таблиці `nc_scheme`
--
ALTER TABLE `nc_scheme`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nc_scheme_external_id_unique` (`external_id`),
  ADD KEY `nc_scheme_model_id_foreign` (`model_id`),
  ADD KEY `nc_scheme_section_id_foreign` (`section_id`);

--
-- Індекси таблиці `nc_scheme_part`
--
ALTER TABLE `nc_scheme_part`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nc_scheme_part_scheme_id_foreign` (`scheme_id`),
  ADD KEY `nc_scheme_part_part_id_foreign` (`part_id`);

--
-- Індекси таблиці `nc_section`
--
ALTER TABLE `nc_section`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nc_section_model_id_foreign` (`model_id`);

--
-- Індекси таблиці `nc_series`
--
ALTER TABLE `nc_series`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nc_series_external_id_unique` (`external_id`),
  ADD KEY `nc_series_product_group_id_foreign` (`product_group_id`);

--
-- Індекси таблиці `system_migration`
--
ALTER TABLE `system_migration`
  ADD PRIMARY KEY (`version`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `nc_brand`
--
ALTER TABLE `nc_brand`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `nc_model`
--
ALTER TABLE `nc_model`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `nc_part`
--
ALTER TABLE `nc_part`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `nc_product_group`
--
ALTER TABLE `nc_product_group`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `nc_product_type`
--
ALTER TABLE `nc_product_type`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `nc_scheme`
--
ALTER TABLE `nc_scheme`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `nc_scheme_part`
--
ALTER TABLE `nc_scheme_part`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `nc_section`
--
ALTER TABLE `nc_section`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `nc_series`
--
ALTER TABLE `nc_series`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `nc_model`
--
ALTER TABLE `nc_model`
  ADD CONSTRAINT `nc_model_series_id_foreign` FOREIGN KEY (`series_id`) REFERENCES `nc_series` (`id`) ON DELETE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `nc_product_group`
--
ALTER TABLE `nc_product_group`
  ADD CONSTRAINT `nc_product_group_product_type_id_foreign` FOREIGN KEY (`product_type_id`) REFERENCES `nc_product_type` (`id`) ON DELETE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `nc_product_type`
--
ALTER TABLE `nc_product_type`
  ADD CONSTRAINT `nc_product_type_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `nc_brand` (`id`) ON DELETE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `nc_scheme`
--
ALTER TABLE `nc_scheme`
  ADD CONSTRAINT `nc_scheme_model_id_foreign` FOREIGN KEY (`model_id`) REFERENCES `nc_model` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `nc_scheme_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `nc_section` (`id`) ON DELETE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `nc_scheme_part`
--
ALTER TABLE `nc_scheme_part`
  ADD CONSTRAINT `nc_scheme_part_part_id_foreign` FOREIGN KEY (`part_id`) REFERENCES `nc_part` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `nc_scheme_part_scheme_id_foreign` FOREIGN KEY (`scheme_id`) REFERENCES `nc_scheme` (`id`) ON DELETE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `nc_section`
--
ALTER TABLE `nc_section`
  ADD CONSTRAINT `nc_section_model_id_foreign` FOREIGN KEY (`model_id`) REFERENCES `nc_model` (`id`) ON DELETE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `nc_series`
--
ALTER TABLE `nc_series`
  ADD CONSTRAINT `nc_series_product_group_id_foreign` FOREIGN KEY (`product_group_id`) REFERENCES `nc_product_group` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
