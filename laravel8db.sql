-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 06, 2021 at 09:18 AM
-- Server version: 5.7.31
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel8db`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2020_10_14_035649_create_users_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active_status` tinyint(4) NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_user_name_unique` (`user_name`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `api_token` (`api_token`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `user_name`, `email`, `email_verified_at`, `password`, `api_token`, `active_status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin', 'sysadmin@gmail.com', '2020-10-08 06:13:53', '$2y$10$cwu/aUcxYGWX532ot2AL.e2m9Cs26JC8tl3tYe3z4pvnxwbAMlfOC', 'admin', 1, 'o4KWwsDY605sGvXEz7FHmEnwCeGt9QoH6ei74RlucFMVpPLPwFY5F413PNNy', '2020-10-15 06:16:28', '2020-11-09 09:53:37'),
(2, 'Kannan Ramanan', 'root', 'kannan@gmail.com', NULL, '$2y$10$p20ftsLPWPeR.cY7duoiDuI.cGKWGy.BoPb1UrEYiU/EEwppl5cVi', NULL, 1, NULL, '2020-10-23 03:42:07', '2020-11-06 05:46:25'),
(3, 'Kamal Hasan', 'kamal', 'kumar@hotmail.com', NULL, '$2y$10$B7aVOM0rh/B/xoC2uR5cW.b42pjaqzuHzr5djHqAoL.0Vh8qND4xe', NULL, 0, NULL, '2020-10-23 05:16:05', '2020-11-09 09:07:24'),
(4, 'Kamal thani', 'kannan', 'shan@gmail.com', NULL, '$2y$10$53hqd7l/Bfc1TI9Afpb.l.kx3bVgtz.M839Huob7SdjNRd53cJ3L6', NULL, 0, NULL, '2020-10-23 05:17:54', '2020-11-05 11:06:40'),
(5, 'kakul thani', 'kakul', 'kakul@gmail.com', NULL, '$2y$10$KPRaXdL1oZX7omvMuggrh.ciZol7h0IU1yAGv3ySIITV5VLOoizVi', NULL, 0, NULL, '2020-10-23 05:19:20', '2020-11-06 05:45:24'),
(6, 'kumar Ramanan', 'kumar', 'kannan1@gmail.com', NULL, '$2y$10$fESns90A2ubeYaL19hszeuIpbNrHO2YV504YmpVYCdWou1QXv8smm', NULL, 0, NULL, '2020-10-23 05:20:14', '2020-11-09 09:26:16'),
(7, 'Visithan Veera', 'visithan', 'visithan@gmail.com', NULL, '$2y$10$bVlIPIWtpmIUYo2pRv4J.OCekI/6GdhKxs.7cPX5pxm4iEMeNrggO', NULL, 0, NULL, '2020-10-23 05:21:38', '2020-11-05 10:45:40'),
(8, 'Suthan Lavan', 'suthan', 'suthan@yahoo.com', NULL, '$2y$10$GAlSC37I.TqvK./UwqO3Wu/W6j1jIg4eoedFk2QfdLeacPr7Sd6U2', NULL, 0, NULL, '2020-11-03 22:40:52', '2020-11-05 11:19:28'),
(9, 'Janakan Niraj', 'janakan', 'janakan@outlook.com', NULL, '$2y$10$WFlg3Lm45wt9.8uIN.x6puePM20/r9l.5DX8iF5EYiDlxqqyJ.roG', NULL, 0, NULL, '2020-11-03 22:42:08', '2020-11-05 10:45:49'),
(10, 'Athiththan Karikalan', 'aathi', 'Athi@yahoo.com', NULL, '$2y$10$9rOwZfsTAgjZ1soCaByMf.CfAgxDocU/zyjh/fDUk8dk69VWFEney', NULL, 0, NULL, '2020-11-03 22:43:17', '2020-11-09 09:07:34'),
(11, 'sankar suntharam', 'sankar', 'sankar@outlook.com', NULL, '$2y$10$G6eEZrIMsqQwZxjwqbVYdO1nxndBmOzCMJxlAq8YyT6u5huydhdl2', NULL, 1, NULL, '2020-11-03 22:43:59', '2020-11-09 09:26:12'),
(12, 'Kannan Raja', 'gaam', 'gaamani@yahoo.com', NULL, '$2y$10$T7npBR7JgO7vcDkro07Wue3fW6u0SUSMYGmcyzFoZ/NYtkYeGv7xq', NULL, 1, NULL, '2020-11-09 06:20:40', '2020-11-09 09:13:41'),
(13, 'Manikkam Batcha', 'batcha', 'batcha@gmail.com', NULL, '$2y$10$wWWp0FXLNpoKH4HRwLRBteqaEMj2E/U9Fe8asvUexRlbU8k55oU/K', NULL, 0, NULL, '2020-11-09 06:23:27', '2020-11-10 04:20:14');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
