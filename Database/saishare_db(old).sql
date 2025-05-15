-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2025 at 01:36 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `saishare_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `archived` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`id`, `name`, `code`, `archived`, `created_at`, `updated_at`) VALUES
(1, 'It days', 'CODE_67f1053add536', 0, '2025-04-05 20:26:02', '2025-04-05 20:26:02'),
(2, 'Food trip', 'CODE_67f174fca28be', 0, '2025-04-06 04:22:52', '2025-04-06 04:22:52'),
(3, 'Food trip', 'CODE_67f174fcec72b', 0, '2025-04-06 04:22:52', '2025-04-06 04:22:52'),
(4, 'Food trip', 'CODE_67f1900c6173d', 0, '2025-04-06 06:18:20', '2025-04-06 06:18:20'),
(5, 'Food trip', 'CODE_67f191d622380', 0, '2025-04-06 06:25:58', '2025-04-06 06:25:58'),
(6, 'Rood Trip', 'CODE_67f19b6b6889e', 0, '2025-04-06 07:06:51', '2025-04-06 07:06:51'),
(7, 'Rood Trip', 'CODE_67f19b6bc6ddb', 0, '2025-04-06 07:06:51', '2025-04-06 07:06:51'),
(8, 'sample', 'CODE_67f1abd625482', 0, '2025-04-06 08:16:54', '2025-04-06 08:16:54'),
(9, 'test', 'CODE_67f1b1883d3eb', 0, '2025-04-06 08:41:12', '2025-04-06 08:41:12'),
(10, 'testing', 'CODE_67f1b47bd9615', 0, '2025-04-06 08:53:47', '2025-04-06 08:53:47'),
(11, 'samples', 'CODE_67f1c39b96c09', 0, '2025-04-06 09:58:19', '2025-04-06 09:58:19'),
(12, 'Snacks', 'CODE_67f1c73f8be10', 0, '2025-04-06 10:13:51', '2025-04-06 10:13:51'),
(13, 'Food trip', 'CODE_67f1ca6867acd', 0, '2025-04-06 10:27:20', '2025-04-06 10:27:20'),
(14, 'Food trip', 'CODE_67f1e554bc17c', 0, '2025-04-06 12:22:12', '2025-04-06 12:22:12');

-- --------------------------------------------------------

--
-- Table structure for table `bill_splits`
--

CREATE TABLE `bill_splits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bill_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bill_splits`
--

INSERT INTO `bill_splits` (`id`, `bill_id`, `name`, `amount`, `created_at`, `updated_at`) VALUES
(1, 4, 'Ashlyn', 500.00, '2025-04-06 06:19:56', '2025-04-06 06:19:56'),
(2, 4, 'You', 500.00, '2025-04-06 06:19:56', '2025-04-06 06:19:56'),
(3, 10, 'Initial Split', 0.00, '2025-04-06 08:53:47', '2025-04-06 08:53:47'),
(4, 10, 'Split Share', 100.00, '2025-04-06 08:54:13', '2025-04-06 08:54:13'),
(5, 11, 'Initial Split', 0.00, '2025-04-06 09:58:19', '2025-04-06 09:58:19'),
(6, 12, 'Ashlyn', 500.00, '2025-04-06 10:14:19', '2025-04-06 10:14:19'),
(7, 12, 'Ashlyn', 500.00, '2025-04-06 10:14:19', '2025-04-06 10:14:19'),
(8, 12, 'Ashlyn', 500.00, '2025-04-06 10:14:19', '2025-04-06 10:14:19'),
(9, 13, 'Ashlyn', 100.00, '2025-04-06 10:27:29', '2025-04-06 10:27:29'),
(10, 13, 'Ashlyn', 100.00, '2025-04-06 10:27:30', '2025-04-06 10:27:30');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(7, '0001_01_01_000000_create_users_table', 1),
(8, '0001_01_01_000001_create_cache_table', 1),
(9, '0001_01_01_000002_create_jobs_table', 1),
(10, '2025_04_05_053010_add_firstname_lastname_nickname_to_users_table', 2),
(11, '2025_04_05_071405_remove_name_from_users_table', 3),
(12, '2025_04_05_093554_create_bills_table', 4),
(14, '2025_04_05_174128_add_split_to_bills_table', 5),
(15, '2025_04_07_054530_add_google_id_to_users_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('CUQrSToPwYpqvLLveQbBpB9L83R2UxvgFGsU7iRT', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiekZzUk5RNFEzY2ZuaHdWSkxYVDU2Rm1lWExSU2FJNldKVUlaY2tCOCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk4OiJodHRwOi8vbG9jYWxob3N0OjgwMDAvbG9naW4vZ29vZ2xlL2NhbGxiYWNrP2F1dGh1c2VyPTAmY29kZT00JTJGMEFiXzVxbGtfa3FVd0lwaVI0OVdNMG5LRDRDWWktTXNiRUZUemlINm9ZSjI0anBZbTE3N0ljTWFWVHlTUkhMVWZvS1Uwc3cmcHJvbXB0PW5vbmUmc2NvcGU9ZW1haWwlMjBwcm9maWxlJTIwaHR0cHMlM0ElMkYlMkZ3d3cuZ29vZ2xlYXBpcy5jb20lMkZhdXRoJTJGdXNlcmluZm8ucHJvZmlsZSUyMG9wZW5pZCUyMGh0dHBzJTNBJTJGJTJGd3d3Lmdvb2dsZWFwaXMuY29tJTJGYXV0aCUyRnVzZXJpbmZvLmVtYWlsIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1744022072),
('ETfotwLwVd2ZlWJmU8rbFkhjpOgJqUakQlihdhfA', 18, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaWV1dlBHbUpmRXBETEVGa0NHcHJEem5WUzVYRkFQT1BqUTV5QVVJUSI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTg7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9iaWxscyI7fX0=', 1744025467),
('hvmbRYTZ8h48E90S02KVTmObARaugy1cChLK0xko', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRWk0UkpicHdoR0ZxdUJZRWY4dmZTUU1BOTdkbEZXdDJMVzZqb0hFeiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbi9nb29nbGUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjU6InN0YXRlIjtzOjQwOiJ0UW1BTEZONUFHN0EwSUkzd1F2b3hPYVpoUlo2TnlEdEczbjNkNElmIjt9', 1744025270),
('IXBfpEHrw4Im1v6XT5snYS21Mx7XeW39yFufDjLT', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiREg4NmZicWxxMEMzNTVuUW1vZ1B2S1JMa09tNGVTZWw4T1lZZzNTaiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbi9nb29nbGUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1744025031),
('Jb0RHpwKSDqFmNDrClYbxAPIkt3swpb0nCponlL8', 17, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSHVYNVlhc1RFNjYwNmV5ZVhmTTRWaDZUckpjSkt6ZXFYZ21IMHg4aSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9iaWxscyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE3O30=', 1744025279),
('KMYmRF6X3CyAbPopzARvuG1VaVzTcUUUywr3diGc', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWjhYazk3QlVTSzNNdWhZWFBUUURmR003aFNJc3VXd1ZOV1Nyb1FNUyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbi9nb29nbGUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjU6InN0YXRlIjtzOjQwOiJFOURabnFFTHFCcjhoZ1Q1QUhoYmNJUldsc0tYRXg1S3ZlQW5kbURNIjt9', 1744022070),
('o7G3ii0QlwUK2HIX3I2RXAoQVKNGOxjkulM3aqGO', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36 OPR/117.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRnNZY0NMV0FadEdWQ3RFVHpnTEZoSDFIOUg4NXpFc3RLb0dVbWpHdiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZWdpc3RlciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1744023632),
('ON72sk7xfgHi80cxU41Udt3dmglJNhXioNoPqkkT', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNjBuY2g5UlJuVnZPM0g4SFhrYzhTZ1JaMDZtbEtxZ3NqT1lWc3RPRCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbi9nb29nbGUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1744025398),
('uSwzFhb0SE4MsISLw3pLuaJibaA2RfGbkUtdQh0p', 16, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiV0xnNGhGNVU1aUF1MVIwS3dVTWRrNFNuUWV4cHN1UldES0Jna1I4SyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9iaWxscyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE2O30=', 1744025040),
('uUvmP8hKHCVGS0l0wr6DbH5LW06YQeMnlBipvsI6', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOUNYR0FWOWgySjB1MmhGNERiUVN1SjJFZUlEUXhCOUIxNENERTdRVCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbi9nb29nbGUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1744022861),
('yMIR4hX9qMktqXIp2VJb6yVBmJw4vmX9sYxpxvEQ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVWlNZkRVY2tJcnpYYkZWS0YyYm0zcEx3SXRsd2xhM08zN2t0MVoxTyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzAxOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvbG9naW4vZ29vZ2xlL2NhbGxiYWNrP2F1dGh1c2VyPTAmY29kZT00JTJGMEFiXzVxbG1sRF9TRGtoeTEyTlB1dWpJYU8zcUxyMzBReExNZmY3Y2REREcxeGRBVVVEdmxLZW5XVXZrRHlETFBzVzRIZGcmcHJvbXB0PWNvbnNlbnQmc2NvcGU9ZW1haWwlMjBwcm9maWxlJTIwb3BlbmlkJTIwaHR0cHMlM0ElMkYlMkZ3d3cuZ29vZ2xlYXBpcy5jb20lMkZhdXRoJTJGdXNlcmluZm8ucHJvZmlsZSUyMGh0dHBzJTNBJTJGJTJGd3d3Lmdvb2dsZWFwaXMuY29tJTJGYXV0aCUyRnVzZXJpbmZvLmVtYWlsIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1744022905);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `nickname`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `google_id`) VALUES
(1, 'David Sailas', 'Villondo', 'Dasai', 'chebry28@gmail.com', NULL, '$2y$12$C.OzTfZp0bG5F/YXxhKR9uZ20lQMm3q1YausqRdWpdqkHtXCTx3KG', NULL, '2025-04-05 17:16:48', '2025-04-05 17:16:48', NULL),
(2, 'Mircelyn', 'Batol', 'Ashlyn', 'ashlyn@gmail.com', NULL, '$2y$12$IfEsAiW3GKzkn15qlCT5de.5SGMVP3qIkFXnM/FU7OcE4T/Ge.kti', NULL, '2025-04-05 17:21:51', '2025-04-05 17:21:51', NULL),
(16, 'David', 'Romano', 'davidromano1223', 'davidromano1223@gmail.com', NULL, '$2y$12$nvvTBeOKN2c9LUaL2ORaFeHjXNt1ZJdLdsvOMP4aDN.Y1lOwpdlES', NULL, '2025-04-07 21:23:54', '2025-04-07 21:23:54', NULL),
(17, 'David', 'Villondo', 'davidvillondo', 'davidvillondo@gmail.com', NULL, '$2y$12$OydO1xFO9K4.Oroafflz.umPD5BdePcQmy1jhohUHHW7S16cLLoQ6', NULL, '2025-04-07 21:27:53', '2025-04-07 21:27:53', NULL),
(18, 'David', 'Sailas', 'davidsailas0001', 'davidsailas0001@gmail.com', NULL, '$2y$12$j7iU3adqXkILYKuFFAAwCeksnV/lN4rtAhz.ZM2TOCxsYizbsO2W6', NULL, '2025-04-07 21:31:01', '2025-04-07 21:31:01', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bills_code_unique` (`code`);

--
-- Indexes for table `bill_splits`
--
ALTER TABLE `bill_splits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bill_splits_bill_id_foreign` (`bill_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_nickname_unique` (`nickname`),
  ADD UNIQUE KEY `users_google_id_unique` (`google_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `bill_splits`
--
ALTER TABLE `bill_splits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bill_splits`
--
ALTER TABLE `bill_splits`
  ADD CONSTRAINT `bill_splits_bill_id_foreign` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
