-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2015 at 09:04 PM
-- Server version: 5.6.11
-- PHP Version: 5.5.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `adraaf`
--
CREATE DATABASE IF NOT EXISTS `adraaf` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `adraaf`;

-- --------------------------------------------------------

--
-- Table structure for table `actions`
--

CREATE TABLE IF NOT EXISTS `actions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `point` int(11) NOT NULL,
  `title` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `actions`
--

INSERT INTO `actions` (`id`, `point`, `title`) VALUES
(1, 10, 'save_offer'),
(2, 25, 'share_offer'),
(3, 50, 'buy_offer'),
(4, 5, 'drag_to_search'),
(5, 15, 'invite_friend'),
(6, 20, 'sign_up');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`) VALUES
(1, 'آرایشی، بهداشتی و عطر'),
(2, 'کافی شاپ'),
(3, 'قنادی'),
(4, 'کیف و کفش زنانه'),
(5, 'پوشاک ورزشی');

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE IF NOT EXISTS `levels` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `criteria` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=21 ;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`id`, `title`, `criteria`) VALUES
(1, '1', 0),
(2, '2', 101),
(3, '3', 222),
(4, '4', 373),
(5, '5', 554),
(6, '6', 765),
(7, '7', 1016),
(8, '8', 1317),
(9, '9', 1678),
(10, '10', 2119),
(11, '11', 2640),
(12, '12', 3271),
(13, '13', 4022),
(14, '14', 4923),
(15, '15', 6004),
(16, '16', 7305),
(17, '17', 8866),
(18, '18', 10737),
(19, '19', 12978),
(20, '20', 15669);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2015_09_10_140323_create_users_table', 1),
('2015_09_10_140718_create_actions_table', 1),
('2015_09_10_141129_create_categories_table', 1),
('2015_09_10_141218_create_stores_table', 1),
('2015_09_10_141808_create_offers_table', 1),
('2015_09_10_142106_create_levels_table', 1),
('2015_09_10_142246_create_user_levels_table', 1),
('2015_09_10_142500_create_user_actions_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE IF NOT EXISTS `offers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `maximum_percentage` double NOT NULL,
  `store_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `offers_store_id_foreign` (`store_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`id`, `description`, `start_date`, `end_date`, `maximum_percentage`, `store_id`, `created_at`, `updated_at`) VALUES
(1, 'پیشنهادی ویژه برندهای معتبر عطر و ادکلن', '2015-09-01 00:00:00', '2015-11-01 00:00:00', 15, 1, '2015-08-24 19:30:00', '0000-00-00 00:00:00'),
(2, 'کفشها و لباس های ورزشی', '2015-09-01 00:00:00', '2015-11-01 00:00:00', 20, 2, '2015-08-25 19:30:00', '0000-00-00 00:00:00'),
(3, 'ارائه انواع شیرینی های فانتزی', '2015-09-01 00:00:00', '2015-11-01 00:00:00', 10, 3, '2015-08-23 19:30:00', '0000-00-00 00:00:00'),
(4, 'یادآوری خاطرات دهه شصت در کافه دهه شصت', '2015-09-01 00:00:00', '2015-11-01 00:00:00', 25, 4, '2015-08-19 19:30:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE IF NOT EXISTS `stores` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `img_url` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `x` double NOT NULL,
  `y` double NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `stores_email_unique` (`email`),
  KEY `stores_category_id_foreign` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `email`, `password`, `title`, `address`, `img_url`, `x`, `y`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'info@hilandbeauty.com', '12345678', 'فروشگاه عطر هایلند', 'تهران، شهرک قدس، ابتدای بلوار فرحزادی، مجتمع تجاری میلاد نور، طبقه ششم', NULL, 35.753497, 51.362583, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'golestan@nikekish.ir', '12345678', 'فروشگاه نایک', 'شهرک غرب، ابتدای خیابان ایران زمین، مرکز تجاری گلستان', NULL, 35.753427, 51.374265, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'iranzamin@langine.ir', '12345678', 'قنادی لانجین', 'شهرک غرب، ابتدای خیابان ایران زمین، روبروی مهستان، مرکز تجاری ایران زمین', NULL, 35.752774, 51.373385, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'info@dahe60.ir', '12345678', 'کافه دهه شصت', 'شهرک غرب، ابتدای خیابان ایران زمین، نرسیده به مهستان، پلاک 40', NULL, 35.75327, 51.371937, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `uuid` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_uuid_unique` (`uuid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `uuid`, `created_at`, `updated_at`) VALUES
(1, 'arsalan@yarveisi.com', '12345678', '275cc80b-0fb2-4d53-b54a-513867af0a6e', '2015-09-01 19:30:00', '2015-09-01 19:30:00'),
(2, 'sadjad@fallah.com', '12345678', '275cc80b-0fb2-4d53-b54a-513867af0a6f', '2015-09-01 19:30:00', '2015-09-01 19:30:00'),
(3, 'omid@jafari.com', '12345678', '275cc80b-0fb2-4d53-b54a-513867af0a6g', '2015-09-01 19:30:00', '2015-09-01 19:30:00'),
(4, 'ali@motameni.com', '12345678', '275cc80b-0fb2-4d53-b54a-513867af0a6h', '2015-09-01 19:30:00', '2015-09-01 19:30:00'),
(5, 'marathon@sharif.edu', '12345678', '275cc80b-0fb2-4d53-b54a-513867af0a6i', '2015-09-01 19:30:00', '2015-09-01 19:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_actions`
--

CREATE TABLE IF NOT EXISTS `user_actions` (
  `user_id` int(10) unsigned NOT NULL,
  `action_id` int(10) unsigned NOT NULL,
  `offer_id` int(10) unsigned DEFAULT NULL,
  `points` int(11) NOT NULL,
  `price` int(11) DEFAULT NULL,
  `action_x` double DEFAULT NULL,
  `action_y` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `user_actions_user_id_foreign` (`user_id`),
  KEY `user_actions_action_id_foreign` (`action_id`),
  KEY `user_actions_offer_id_foreign` (`offer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_actions`
--

INSERT INTO `user_actions` (`user_id`, `action_id`, `offer_id`, `points`, `price`, `action_x`, `action_y`, `created_at`, `updated_at`) VALUES
(1, 6, NULL, 20, NULL, NULL, NULL, '2015-09-01 19:30:00', '0000-00-00 00:00:00'),
(2, 6, NULL, 20, NULL, NULL, NULL, '2015-09-01 19:30:00', '0000-00-00 00:00:00'),
(3, 6, NULL, 20, NULL, NULL, NULL, '2015-09-01 19:30:00', '0000-00-00 00:00:00'),
(4, 6, NULL, 20, NULL, NULL, NULL, '2015-09-01 19:30:00', '0000-00-00 00:00:00'),
(5, 6, NULL, 20, NULL, NULL, NULL, '2015-09-01 19:30:00', '0000-00-00 00:00:00'),
(1, 4, NULL, 5, NULL, NULL, NULL, '2015-09-02 19:30:00', '0000-00-00 00:00:00'),
(1, 4, NULL, 5, NULL, NULL, NULL, '2015-09-02 19:30:00', '0000-00-00 00:00:00'),
(2, 4, NULL, 5, NULL, NULL, NULL, '2015-09-02 19:30:00', '0000-00-00 00:00:00'),
(2, 4, NULL, 5, NULL, NULL, NULL, '2015-09-02 19:30:00', '0000-00-00 00:00:00'),
(2, 4, NULL, 5, NULL, NULL, NULL, '2015-09-02 19:30:00', '0000-00-00 00:00:00'),
(3, 4, NULL, 5, NULL, NULL, NULL, '2015-09-02 19:30:00', '0000-00-00 00:00:00'),
(4, 4, NULL, 5, NULL, NULL, NULL, '2015-09-02 19:30:00', '0000-00-00 00:00:00'),
(4, 4, NULL, 5, NULL, NULL, NULL, '2015-09-02 19:30:00', '0000-00-00 00:00:00'),
(5, 4, NULL, 5, NULL, NULL, NULL, '2015-09-02 19:30:00', '0000-00-00 00:00:00'),
(1, 1, 1, 10, NULL, NULL, NULL, '2015-09-02 19:30:00', '0000-00-00 00:00:00'),
(1, 1, 2, 10, NULL, NULL, NULL, '2015-09-02 19:30:00', '0000-00-00 00:00:00'),
(1, 1, 3, 10, NULL, NULL, NULL, '2015-09-02 19:30:00', '0000-00-00 00:00:00'),
(2, 1, 1, 10, NULL, NULL, NULL, '2015-09-02 19:30:00', '0000-00-00 00:00:00'),
(2, 1, 2, 10, NULL, NULL, NULL, '2015-09-02 19:30:00', '0000-00-00 00:00:00'),
(2, 1, 4, 10, NULL, NULL, NULL, '2015-09-02 19:30:00', '0000-00-00 00:00:00'),
(3, 1, 3, 10, NULL, NULL, NULL, '2015-09-02 19:30:00', '0000-00-00 00:00:00'),
(3, 1, 4, 10, NULL, NULL, NULL, '2015-09-02 19:30:00', '0000-00-00 00:00:00'),
(4, 1, 1, 10, NULL, NULL, NULL, '2015-09-02 19:30:00', '0000-00-00 00:00:00'),
(5, 1, 1, 10, NULL, NULL, NULL, '2015-09-02 19:30:00', '0000-00-00 00:00:00'),
(5, 1, 2, 10, NULL, NULL, NULL, '2015-09-02 19:30:00', '0000-00-00 00:00:00'),
(5, 1, 3, 10, NULL, NULL, NULL, '2015-09-02 19:30:00', '0000-00-00 00:00:00'),
(5, 1, 4, 10, NULL, NULL, NULL, '2015-09-02 19:30:00', '0000-00-00 00:00:00'),
(1, 2, 2, 25, NULL, NULL, NULL, '2015-09-03 19:30:00', '0000-00-00 00:00:00'),
(2, 2, 2, 25, NULL, NULL, NULL, '2015-09-03 19:30:00', '0000-00-00 00:00:00'),
(2, 2, 4, 25, NULL, NULL, NULL, '2015-09-03 19:30:00', '0000-00-00 00:00:00'),
(3, 2, 3, 25, NULL, NULL, NULL, '2015-09-03 19:30:00', '0000-00-00 00:00:00'),
(3, 2, 4, 25, NULL, NULL, NULL, '2015-09-03 19:30:00', '0000-00-00 00:00:00'),
(4, 2, 1, 25, NULL, NULL, NULL, '2015-09-03 19:30:00', '0000-00-00 00:00:00'),
(5, 2, 3, 25, NULL, NULL, NULL, '2015-09-03 19:30:00', '0000-00-00 00:00:00'),
(5, 2, 4, 25, NULL, NULL, NULL, '2015-09-03 19:30:00', '0000-00-00 00:00:00'),
(1, 3, 2, 50, 1000000, NULL, NULL, '2015-09-04 19:30:00', '0000-00-00 00:00:00'),
(2, 3, 2, 50, 400000, NULL, NULL, '2015-09-04 19:30:00', '0000-00-00 00:00:00'),
(2, 3, 4, 50, 500000, NULL, NULL, '2015-09-04 19:30:00', '0000-00-00 00:00:00'),
(3, 3, 3, 50, 300000, NULL, NULL, '2015-09-04 19:30:00', '0000-00-00 00:00:00'),
(5, 3, 4, 50, 350000, NULL, NULL, '2015-09-04 19:30:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_levels`
--

CREATE TABLE IF NOT EXISTS `user_levels` (
  `user_id` int(10) unsigned NOT NULL,
  `level_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `user_levels_user_id_foreign` (`user_id`),
  KEY `user_levels_level_id_foreign` (`level_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_levels`
--

INSERT INTO `user_levels` (`user_id`, `level_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2015-09-01 19:30:00', '0000-00-00 00:00:00'),
(1, 2, '2015-09-04 19:30:00', '0000-00-00 00:00:00'),
(2, 1, '2015-09-01 19:30:00', '0000-00-00 00:00:00'),
(2, 2, '2015-09-03 19:30:00', '0000-00-00 00:00:00'),
(3, 1, '2015-09-01 19:30:00', '0000-00-00 00:00:00'),
(3, 2, '2015-09-04 19:30:00', '0000-00-00 00:00:00'),
(4, 1, '2015-09-01 19:30:00', '0000-00-00 00:00:00'),
(5, 1, '2015-09-01 19:30:00', '0000-00-00 00:00:00'),
(5, 2, '2015-09-03 19:30:00', '0000-00-00 00:00:00');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `offers`
--
ALTER TABLE `offers`
  ADD CONSTRAINT `offers_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`);

--
-- Constraints for table `stores`
--
ALTER TABLE `stores`
  ADD CONSTRAINT `stores_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `user_actions`
--
ALTER TABLE `user_actions`
  ADD CONSTRAINT `user_actions_action_id_foreign` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`),
  ADD CONSTRAINT `user_actions_offer_id_foreign` FOREIGN KEY (`offer_id`) REFERENCES `offers` (`id`),
  ADD CONSTRAINT `user_actions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_levels`
--
ALTER TABLE `user_levels`
  ADD CONSTRAINT `user_levels_level_id_foreign` FOREIGN KEY (`level_id`) REFERENCES `levels` (`id`),
  ADD CONSTRAINT `user_levels_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
