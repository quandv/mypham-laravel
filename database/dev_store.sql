-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 29, 2016 at 02:55 PM
-- Server version: 5.7.15-0ubuntu0.16.04.1
-- PHP Version: 7.0.8-0ubuntu0.16.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dev_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(10) UNSIGNED NOT NULL,
  `admin_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `admin_cmt` int(11) NOT NULL,
  `admin_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `admin_level` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assigned_roles`
--

CREATE TABLE `assigned_roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `assigned_roles`
--

INSERT INTO `assigned_roles` (`id`, `user_id`, `role_id`) VALUES
(41, 22, 3),
(45, 25, 2),
(46, 26, 3),
(48, 28, 2),
(49, 29, 3),
(55, 31, 1),
(56, 23, 2),
(57, 32, 2),
(60, 17, 1),
(61, 27, 2),
(62, 27, 3),
(63, 27, 4),
(64, 30, 2),
(65, 30, 3),
(66, 30, 4),
(71, 24, 3),
(72, 24, 4),
(74, 33, 2),
(75, 33, 3),
(76, 33, 4),
(77, 35, 2),
(79, 34, 1),
(80, 36, 6),
(81, 37, 5),
(82, 38, 7),
(83, 39, 8),
(84, 40, 2),
(86, 41, 5),
(88, 21, 5),
(90, 42, 7),
(91, 43, 2),
(92, 1, 1),
(94, 44, 3);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(10) UNSIGNED NOT NULL,
  `category_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `category_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_image_hover` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_desc` text COLLATE utf8_unicode_ci,
  `category_id_parent` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `category_image`, `category_image_hover`, `category_desc`, `category_id_parent`) VALUES
(1, 'đồ ăn', '1475111488.Food-Normal.png', '1475111489.food-active.png', '3213213123213', 0),
(3, 'đồ uống', '1475111506.Drink-Normal.png', '1475111507.Drink-Active.png', '', 0),
(4, 'combo', '1475111519.Combo-Normal.png', '1475111520.Combo-Active.png', '', 0),
(5, 'Nạp TK', '1475111533.Card-Normal.png', '1475111534.Card-Active.png', 'fdsafdsafds à', 0),
(6, 'cơm', '1474685385.logo.png', '', '11111111', 1),
(10, 'mỳ   ', '', '', '', 1),
(11, 'bánh mỳ', '', '', '', 1),
(12, 'thức ăn nhanh', '', '', '', 2),
(13, 'snack', '', '', '', 2),
(14, 'bánh', '', '', '', 2),
(15, 'kẹo', '', '', '', 2),
(16, 'nước ngọt', '', '', '', 3),
(17, 'nước ép', '', '', '', 3),
(18, 'nước khoáng', '', '', '', 3),
(19, 'Combo đêm', '', '', '', 4),
(20, 'combo-2', '', '', '', 4),
(25, 'Đồ ăn thêm', NULL, '', 'đồ ăn thêm', 1),
(26, 'Cafe', NULL, '', 'Coffee', 3),
(27, 'tiền tài khoản', '1474639831.100k_oval_car_magnet.jpg', '', 'Nạp tiền cho khách', 5),
(28, 'Thẻ điện thoại', NULL, '', 'thẻ mobile', 5),
(30, 'Game bản quyền', '1475111545.Game-Normal.png', '1475111546.Game-active.png', 'Game bản quyền', 0),
(31, 'Counter-Strike: Global Offensive', '1474738468.Counter-Strike_Global_Offensive.jpg', '', 'Sản xuất: Valve Corporation – Hidden Path Entertainment\r\n\r\nPhát hành: Valve Corporation\r\n\r\nThể loại: Hành động\r\n\r\nNgày ra mắt: 22/08/2012', 30);

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `client_id` int(10) UNSIGNED NOT NULL,
  `client_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `client_ip` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `room_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`client_id`, `client_name`, `client_ip`, `room_id`) VALUES
(5, 'Máy 1', '192.168.1.20', 3),
(6, 'Máy 2', '192.168.1.21', 3),
(7, 'Máy 3', '192.168.1.22', 3),
(8, 'Máy 4', '192.168.1.23', 3),
(9, 'Máy 5', '192.168.1.24', 3),
(10, 'Máy 6', '192.168.1.25', 3),
(11, 'Máy 7', '192.168.1.26', 3),
(12, 'Máy 8', '192.168.1.27', 3),
(13, 'Máy 9', '192.168.1.28', 3),
(14, 'Máy 10', '192.168.1.29', 3),
(15, 'Máy 11', '192.168.1.30', 3),
(16, 'Máy 12', '192.168.1.31', 3),
(17, 'Máy 13', '192.168.1.32', 3),
(18, 'Máy 14', '192.168.1.33', 3),
(19, 'Máy 15', '192.168.1.34', 3),
(20, 'Máy 16', '192.168.1.35', 3),
(21, 'Máy 17', '192.168.1.36', 3),
(22, 'Máy 18', '192.168.1.37', 3),
(23, 'Máy 19', '192.168.1.38', 3),
(24, 'Máy 20', '192.168.1.39', 3),
(25, 'Máy 21', '192.168.1.40', 3),
(26, 'Máy 22', '192.168.1.41', 3),
(27, 'Máy 23', '192.168.1.42', 3),
(28, 'Máy 24', '192.168.1.43', 3),
(29, 'Máy 25', '192.168.1.44', 3),
(30, 'Máy 26', '192.168.1.45', 3),
(31, 'Máy 27', '192.168.1.46', 3),
(32, 'Máy 28', '192.168.1.47', 3),
(33, 'Máy 29', '192.168.1.48', 3),
(34, 'Máy 30', '192.168.1.49', 3),
(35, 'Máy 31', '192.168.1.50', 4),
(36, 'Máy 32', '192.168.1.51', 4),
(37, 'Máy 33', '192.168.1.52', 4),
(38, 'Máy 34', '192.168.1.53', 4),
(39, 'Máy 35', '192.168.1.54', 4),
(40, 'Máy 36', '192.168.1.55', 4),
(41, 'Máy 37', '192.168.1.56', 4),
(42, 'Máy 38', '192.168.1.57', 4),
(43, 'Máy 39', '192.168.1.58', 4),
(44, 'Máy 40', '192.168.1.59', 4),
(45, 'Máy 41', '192.168.1.60', 4),
(46, 'Máy 42', '192.168.1.61', 4),
(47, 'Máy 43', '192.168.1.62', 4),
(48, 'Máy 44', '192.168.1.63', 4),
(49, 'Máy 45', '192.168.1.64', 4),
(50, 'Máy 46', '192.168.1.65', 4),
(51, 'Máy 47', '192.168.1.66', 4),
(52, 'Máy 48', '192.168.1.67', 4),
(53, 'Máy 49', '192.168.1.68', 4),
(54, 'Máy 50', '192.168.1.69', 4),
(55, 'Máy 51', '192.168.1.70', 4),
(56, 'Máy 52', '192.168.1.71', 4),
(57, 'Máy 53', '192.168.1.72', 4),
(58, 'Máy 54', '192.168.1.73', 4),
(59, 'Máy 55', '192.168.1.74', 4),
(60, 'Máy 56', '192.168.1.75', 4),
(61, 'Máy 57', '192.168.1.76', 4),
(62, 'Máy 58', '192.168.1.77', 4),
(63, 'Máy 59', '192.168.1.78', 4),
(64, 'Máy 60', '192.168.1.79', 4),
(65, 'Máy 61', '192.168.1.80', 5),
(66, 'Máy 62', '192.168.1.81', 5),
(67, 'Máy 63', '192.168.1.82', 5),
(68, 'Máy 64', '192.168.1.83', 5),
(69, 'Máy 65', '192.168.1.84', 5),
(70, 'Máy 66', '192.168.1.85', 5),
(71, 'Máy 67', '192.168.1.86', 5),
(72, 'Máy 68', '192.168.1.87', 5),
(73, 'Máy 69', '192.168.1.88', 5),
(74, 'Máy 70', '192.168.1.89', 5),
(75, 'Máy 71', '192.168.1.90', 5),
(76, 'Máy 72', '192.168.1.91', 5),
(77, 'MÁy 73', '192.168.1.92', 5),
(78, 'Máy 74', '192.168.1.93', 5),
(79, 'Máy 75', '192.168.1.94', 5),
(80, 'Máy 76', '192.168.1.95', 5),
(81, 'Máy 77', '192.168.1.96', 5),
(82, 'Máy 78', '192.168.1.97', 5),
(83, 'Máy 79', '192.168.1.98', 5),
(84, 'Máy 80', '192.168.1.99', 5),
(85, 'Máy 81', '192.168.1.100', 5),
(86, 'Máy 82', '192.168.1.101', 5),
(87, 'Máy 83', '192.168.1.102', 5),
(88, 'Máy 84', '192.168.1.103', 5),
(89, 'Máy 85', '192.168.1.104', 5),
(90, 'Máy 86', '192.168.1.105', 5),
(91, 'Máy 87', '192.168.1.106', 5),
(92, 'Máy 88', '192.168.1.107', 5),
(93, 'Máy 89', '192.168.1.108', 5),
(94, 'Máy 90', '192.168.1.109', 5),
(99, 'Máy thu ngân tổng', '192.168.1.240', 2),
(100, 'Bếp', '192.168.1.201', 2),
(101, 'Máy thu ngân tầng 3', '192.168.1.202', 3),
(104, 'Máy thu ngân tầng 5', '192.168.1.204', 5),
(106, 'Nguyễn Văn Hợp', '192.168.1.16', 2),
(107, 'Lâm Thái Lê', '192.168.1.11', 5);

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id` int(10) UNSIGNED NOT NULL,
  `type_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `entity_id` int(10) UNSIGNED DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `class` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `assets` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id`, `type_id`, `user_id`, `entity_id`, `icon`, `class`, `text`, `assets`, `created_at`, `updated_at`) VALUES
(28, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-29 16:28:49', '2016-08-29 16:28:49'),
(29, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-29 16:29:56', '2016-08-29 16:29:56'),
(30, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-29 16:29:58', '2016-08-29 16:29:58'),
(31, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-29 16:34:07', '2016-08-29 16:34:07'),
(45, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-29 22:09:05', '2016-08-29 22:09:05'),
(46, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-29 22:09:06', '2016-08-29 22:09:06'),
(47, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-29 22:09:07', '2016-08-29 22:09:07'),
(48, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-29 22:09:08', '2016-08-29 22:09:08'),
(49, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-29 22:09:09', '2016-08-29 22:09:09'),
(50, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-29 22:09:09', '2016-08-29 22:09:09'),
(51, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-29 22:09:10', '2016-08-29 22:09:10'),
(52, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-29 22:09:11', '2016-08-29 22:09:11'),
(53, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-29 22:09:12', '2016-08-29 22:09:12'),
(54, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-29 22:09:13', '2016-08-29 22:09:13'),
(55, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-29 22:09:14', '2016-08-29 22:09:14'),
(56, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-30 12:03:39', '2016-08-30 12:03:39'),
(57, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-30 12:03:40', '2016-08-30 12:03:40'),
(58, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-30 12:03:41', '2016-08-30 12:03:41'),
(59, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-30 12:03:43', '2016-08-30 12:03:43'),
(60, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-30 12:03:44', '2016-08-30 12:03:44'),
(61, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-30 12:03:45', '2016-08-30 12:03:45'),
(62, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-30 12:03:46', '2016-08-30 12:03:46'),
(63, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-30 12:03:46', '2016-08-30 12:03:46'),
(64, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-30 12:03:46', '2016-08-30 12:03:46'),
(65, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-30 12:03:46', '2016-08-30 12:03:46'),
(66, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-30 12:03:47', '2016-08-30 12:03:47'),
(67, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-30 12:03:47', '2016-08-30 12:03:47'),
(68, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-30 12:03:47', '2016-08-30 12:03:47'),
(69, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-30 12:03:48', '2016-08-30 12:03:48'),
(70, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-30 12:03:49', '2016-08-30 12:03:49'),
(71, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-30 12:03:49', '2016-08-30 12:03:49'),
(72, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-30 12:03:50', '2016-08-30 12:03:50'),
(73, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-30 12:03:50', '2016-08-30 12:03:50'),
(74, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-30 12:03:51', '2016-08-30 12:03:51'),
(75, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-30 12:03:52', '2016-08-30 12:03:52'),
(76, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-30 12:03:56', '2016-08-30 12:03:56'),
(77, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-30 12:03:58', '2016-08-30 12:03:58'),
(78, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-30 12:03:59', '2016-08-30 12:03:59'),
(79, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-30 12:03:59', '2016-08-30 12:03:59'),
(80, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-30 12:03:59', '2016-08-30 12:03:59'),
(81, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-30 12:04:01', '2016-08-30 12:04:01'),
(82, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-30 12:04:02', '2016-08-30 12:04:02'),
(83, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-30 12:08:23', '2016-08-30 12:08:23'),
(84, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-30 12:08:25', '2016-08-30 12:08:25'),
(85, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-30 12:08:26', '2016-08-30 12:08:26'),
(95, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-30 12:57:18', '2016-08-30 12:57:18'),
(96, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-30 12:57:43', '2016-08-30 12:57:43'),
(97, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-30 12:57:44', '2016-08-30 12:57:44'),
(98, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-30 12:57:45', '2016-08-30 12:57:45'),
(99, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-30 12:57:49', '2016-08-30 12:57:49'),
(100, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-30 12:58:59', '2016-08-30 12:58:59'),
(101, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-30 12:59:01', '2016-08-30 12:59:01'),
(102, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-30 12:59:02', '2016-08-30 12:59:02'),
(103, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-30 12:59:02', '2016-08-30 12:59:02'),
(104, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-30 12:59:03', '2016-08-30 12:59:03'),
(108, 1, 17, NULL, NULL, NULL, 'admin', NULL, '2016-08-30 20:31:34', '2016-08-30 20:31:34'),
(109, 1, 17, NULL, NULL, NULL, 'admin', NULL, '2016-08-30 20:31:37', '2016-08-30 20:31:37'),
(110, 1, 17, NULL, NULL, NULL, 'admin', NULL, '2016-08-30 21:37:57', '2016-08-30 21:37:57'),
(131, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-31 11:57:58', '2016-08-31 11:57:58'),
(132, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-31 11:58:09', '2016-08-31 11:58:09'),
(133, 1, 1, NULL, NULL, NULL, 'hoang', NULL, '2016-08-31 11:58:23', '2016-08-31 11:58:23'),
(134, 1, 17, NULL, NULL, NULL, 'admin', NULL, '2016-08-31 11:59:12', '2016-08-31 11:59:12'),
(135, 1, 17, NULL, NULL, NULL, 'admin', NULL, '2016-09-01 02:33:14', '2016-09-01 02:33:14'),
(136, 1, 17, NULL, NULL, NULL, 'admin', NULL, '2016-09-01 02:33:16', '2016-09-01 02:33:16'),
(137, 1, 17, NULL, NULL, NULL, 'admin', NULL, '2016-09-01 02:33:44', '2016-09-01 02:33:44'),
(138, 1, 17, NULL, NULL, NULL, 'admin', NULL, '2016-09-01 02:33:53', '2016-09-01 02:33:53'),
(139, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>139</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-05 08:19:25', '2016-09-05 08:19:25'),
(140, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>139</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-05 08:19:37', '2016-09-05 08:19:37'),
(141, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>137</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-05 08:19:42', '2016-09-05 08:19:42'),
(142, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>137</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-05 08:19:45', '2016-09-05 08:19:45'),
(143, 1, 1, NULL, NULL, NULL, '<strong> hoang( hoangkhoik5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>140</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-05 09:14:45', '2016-09-05 09:14:45'),
(146, 1, 1, NULL, NULL, NULL, '<strong> hoang( hoangkhoik5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>138</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-06 06:37:03', '2016-09-06 06:37:03'),
(147, 1, 1, NULL, NULL, NULL, '<strong> hoang( hoangkhoik5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>138</strong> sang <span class="label label-warning">Đang xử lý</span>', NULL, '2016-09-06 06:37:06', '2016-09-06 06:37:06'),
(155, 1, 1, NULL, NULL, NULL, '<strong> hoang( hoangkhoik5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>138</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-06 06:44:27', '2016-09-06 06:44:27'),
(156, 1, 1, NULL, NULL, NULL, '<strong> hoang( hoangkhoik5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>145</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-06 07:00:23', '2016-09-06 07:00:23'),
(158, 1, 1, NULL, NULL, NULL, '<strong> hoang( hoangkhoik5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>145</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-06 07:01:50', '2016-09-06 07:01:50'),
(159, 1, 1, NULL, NULL, NULL, '<strong> hoang( hoangkhoik5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>138</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-06 07:02:15', '2016-09-06 07:02:15'),
(160, 1, 1, NULL, NULL, NULL, '<strong> hoang( hoangkhoik5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>138</strong> sang <span class="label label-warning">Đang xử lý</span>', NULL, '2016-09-06 07:04:03', '2016-09-06 07:04:03'),
(161, 1, 1, NULL, NULL, NULL, '<strong> hoang( hoangkhoik5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>138</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-06 07:04:04', '2016-09-06 07:04:04'),
(162, 1, 1, NULL, NULL, NULL, '<strong> hoang( hoangkhoik5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>138</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-06 07:04:06', '2016-09-06 07:04:06'),
(163, 1, 1, NULL, NULL, NULL, '<strong> hoang( hoangkhoik5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>145</strong> sang <span class="label label-warning">Đang xử lý</span>', NULL, '2016-09-06 07:04:28', '2016-09-06 07:04:28'),
(164, 1, 1, NULL, NULL, NULL, '<strong> hoang( hoangkhoik5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>145</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-06 07:04:30', '2016-09-06 07:04:30'),
(165, 1, 1, NULL, NULL, NULL, '<strong> hoang( hoangkhoik5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>145</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-06 07:04:31', '2016-09-06 07:04:31'),
(166, 1, 1, NULL, NULL, NULL, '<strong> hoang( hoangkhoik5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>146</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-06 07:05:42', '2016-09-06 07:05:42'),
(167, 1, 1, NULL, NULL, NULL, '<strong> hoang( hoangkhoik5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>146,145,144</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-06 07:09:11', '2016-09-06 07:09:11'),
(170, 1, 1, NULL, NULL, NULL, '<strong> hoang( hoangkhoik5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>149</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-06 07:11:12', '2016-09-06 07:11:12'),
(171, 1, 1, NULL, NULL, NULL, '<strong> hoang( hoangkhoik5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>150</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-06 07:12:42', '2016-09-06 07:12:42'),
(177, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>137</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-07 15:18:56', '2016-09-07 15:18:56'),
(178, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>152</strong> sang <span class="label label-warning">Đang xử lý</span>', NULL, '2016-09-07 15:22:40', '2016-09-07 15:22:40'),
(179, 1, 1, NULL, NULL, NULL, '<strong> hoang( hoangkhoik5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>148</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-07 15:46:25', '2016-09-07 15:46:25'),
(180, 1, 1, NULL, NULL, NULL, '<strong> hoang( hoangkhoik5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>148</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-07 15:46:28', '2016-09-07 15:46:28'),
(181, 1, 1, NULL, NULL, NULL, '<strong> hoang( hoangkhoik5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>148</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-07 15:46:30', '2016-09-07 15:46:30'),
(182, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>137,148</strong> sang <span class="label label-warning">Đang xử lý</span>', NULL, '2016-09-07 18:05:13', '2016-09-07 18:05:13'),
(183, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>152</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-07 19:02:23', '2016-09-07 19:02:23'),
(184, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>153</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-07 19:02:25', '2016-09-07 19:02:25'),
(185, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>151</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-08 15:46:43', '2016-09-08 15:46:43'),
(186, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>151</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-08 15:46:45', '2016-09-08 15:46:45'),
(187, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>153</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-08 15:55:27', '2016-09-08 15:55:27'),
(188, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>152</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-08 15:55:29', '2016-09-08 15:55:29'),
(189, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>153,152,151,150,149</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-08 15:55:46', '2016-09-08 15:55:46'),
(190, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>153,152,151,150,149</strong> sang <span class="label label-warning">Đang xử lý</span>', NULL, '2016-09-08 15:55:59', '2016-09-08 15:55:59'),
(191, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>148,147,146,145,144</strong> sang <span class="label label-warning">Đang xử lý</span>', NULL, '2016-09-08 15:56:08', '2016-09-08 15:56:08'),
(192, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>153,152,151,150,149</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-08 15:56:19', '2016-09-08 15:56:19'),
(193, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>148,147,146,145,144</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-08 15:56:28', '2016-09-08 15:56:28'),
(194, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>143,142,141,140,139</strong> sang <span class="label label-warning">Đang xử lý</span>', NULL, '2016-09-08 15:56:39', '2016-09-08 15:56:39'),
(195, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>154</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-09 19:17:21', '2016-09-09 19:17:21'),
(196, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>159</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-15 14:32:44', '2016-09-15 14:32:44'),
(197, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>162</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-19 03:31:57', '2016-09-19 03:31:57'),
(198, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>161</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-19 03:32:00', '2016-09-19 03:32:00'),
(199, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>163</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-22 10:21:15', '2016-09-22 10:21:15'),
(200, 1, 21, NULL, NULL, NULL, '<strong> thungant3( thungant3@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>166</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-23 01:22:10', '2016-09-23 01:22:10'),
(201, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>166</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-23 02:24:20', '2016-09-23 02:24:20'),
(202, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>174</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-23 02:37:00', '2016-09-23 02:37:00'),
(203, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>174</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-23 02:37:31', '2016-09-23 02:37:31'),
(204, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>175</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-23 03:25:11', '2016-09-23 03:25:11'),
(205, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>175</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-23 03:27:12', '2016-09-23 03:27:12'),
(206, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>167</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-23 08:05:23', '2016-09-23 08:05:23'),
(207, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>168</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-23 08:08:37', '2016-09-23 08:08:37'),
(208, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>178</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-23 08:16:59', '2016-09-23 08:16:59'),
(209, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>169</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-23 08:19:14', '2016-09-23 08:19:14'),
(210, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>170,171,172,173</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-23 08:19:27', '2016-09-23 08:19:27'),
(211, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>176,177</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-23 08:19:34', '2016-09-23 08:19:34'),
(212, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>179</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-23 08:20:53', '2016-09-23 08:20:53'),
(213, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>167</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-23 08:21:18', '2016-09-23 08:21:18'),
(214, 1, 26, NULL, NULL, NULL, '<strong> Thế Anh( theanh_gengargaming@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>168</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-23 08:44:26', '2016-09-23 08:44:26'),
(215, 1, 26, NULL, NULL, NULL, '<strong> Thế Anh( theanh_gengargaming@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>169</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-23 08:44:41', '2016-09-23 08:44:41'),
(216, 1, 26, NULL, NULL, NULL, '<strong> Thế Anh( theanh_gengargaming@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>170</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-23 08:46:02', '2016-09-23 08:46:02'),
(217, 1, 26, NULL, NULL, NULL, '<strong> Thế Anh( theanh_gengargaming@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>171</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-23 08:46:05', '2016-09-23 08:46:05'),
(218, 1, 26, NULL, NULL, NULL, '<strong> Thế Anh( theanh_gengargaming@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>172</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-23 08:46:08', '2016-09-23 08:46:08'),
(219, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>182</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-23 08:49:33', '2016-09-23 08:49:33'),
(220, 1, 26, NULL, NULL, NULL, '<strong> Thế Anh( theanh_gengargaming@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>173</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-23 08:52:39', '2016-09-23 08:52:39'),
(221, 1, 26, NULL, NULL, NULL, '<strong> Thế Anh( theanh_gengargaming@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>176</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-23 08:56:43', '2016-09-23 08:56:43'),
(222, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>186</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-23 08:59:45', '2016-09-23 08:59:45'),
(223, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>180,181</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-23 09:01:57', '2016-09-23 09:01:57'),
(224, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>183</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-23 09:02:05', '2016-09-23 09:02:05'),
(225, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>184</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-23 09:06:33', '2016-09-23 09:06:33'),
(226, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>185</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-23 09:07:36', '2016-09-23 09:07:36'),
(227, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>187</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-23 09:16:26', '2016-09-23 09:16:26'),
(228, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>188</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-23 09:16:31', '2016-09-23 09:16:31'),
(229, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>189</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-23 13:00:45', '2016-09-23 13:00:45'),
(230, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>189</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-23 13:00:48', '2016-09-23 13:00:48'),
(231, 1, 26, NULL, NULL, NULL, '<strong> Thế Anh( theanh_gengargaming@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>212</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-23 13:03:32', '2016-09-23 13:03:32'),
(232, 1, 26, NULL, NULL, NULL, '<strong> Thế Anh( theanh_gengargaming@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>212</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-23 13:03:36', '2016-09-23 13:03:36'),
(233, 1, 26, NULL, NULL, NULL, '<strong> Thế Anh( theanh_gengargaming@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>211</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-23 13:03:38', '2016-09-23 13:03:38'),
(234, 1, 26, NULL, NULL, NULL, '<strong> Thế Anh( theanh_gengargaming@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>177</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-23 13:03:51', '2016-09-23 13:03:51'),
(235, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>190</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-23 14:13:02', '2016-09-23 14:13:02'),
(236, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>213</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-23 14:18:25', '2016-09-23 14:18:25'),
(237, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>213</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-23 14:18:30', '2016-09-23 14:18:30'),
(238, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>212,211</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-23 14:19:13', '2016-09-23 14:19:13'),
(239, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>216</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 01:05:26', '2016-09-24 01:05:26'),
(240, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>215</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 01:10:36', '2016-09-24 01:10:36'),
(241, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>217</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 01:12:34', '2016-09-24 01:12:34'),
(242, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>219</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 01:12:53', '2016-09-24 01:12:53'),
(243, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>220</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 01:12:55', '2016-09-24 01:12:55'),
(244, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>215</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 01:12:55', '2016-09-24 01:12:55'),
(245, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>221</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 01:20:26', '2016-09-24 01:20:26'),
(246, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>222</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 01:21:11', '2016-09-24 01:21:11'),
(247, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>222</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 01:29:47', '2016-09-24 01:29:47'),
(248, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>221</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 01:30:04', '2016-09-24 01:30:04'),
(249, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>223</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 01:44:55', '2016-09-24 01:44:55'),
(250, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>224</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 01:59:30', '2016-09-24 01:59:30'),
(251, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>225</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 02:08:47', '2016-09-24 02:08:47'),
(252, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>225</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 02:10:28', '2016-09-24 02:10:28'),
(253, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>224</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 02:10:32', '2016-09-24 02:10:32'),
(254, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>226</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 02:33:02', '2016-09-24 02:33:02'),
(255, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>226</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 02:37:42', '2016-09-24 02:37:42'),
(256, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>223</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 02:37:55', '2016-09-24 02:37:55'),
(257, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>220</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 02:37:58', '2016-09-24 02:37:58'),
(258, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>227</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 02:38:01', '2016-09-24 02:38:01'),
(259, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>219</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 02:38:02', '2016-09-24 02:38:02'),
(260, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>217</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 02:38:05', '2016-09-24 02:38:05'),
(261, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>216</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 02:38:09', '2016-09-24 02:38:09'),
(262, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>227</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 02:38:14', '2016-09-24 02:38:14'),
(263, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>228</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 02:51:21', '2016-09-24 02:51:21'),
(264, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>228</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 02:52:01', '2016-09-24 02:52:01'),
(265, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>229</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 02:57:20', '2016-09-24 02:57:20'),
(266, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>229</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 02:59:57', '2016-09-24 02:59:57'),
(267, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>218</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-24 04:20:59', '2016-09-24 04:20:59'),
(268, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>230</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 04:33:00', '2016-09-24 04:33:00'),
(269, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>230</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 04:34:15', '2016-09-24 04:34:15'),
(270, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>231</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 04:39:46', '2016-09-24 04:39:46'),
(271, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>231</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 04:40:01', '2016-09-24 04:40:01'),
(272, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>232</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 05:03:11', '2016-09-24 05:03:11'),
(273, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>232</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 05:09:05', '2016-09-24 05:09:05'),
(274, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>233</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 05:32:27', '2016-09-24 05:32:27'),
(275, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>233</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 05:34:48', '2016-09-24 05:34:48'),
(276, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>234</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 05:49:43', '2016-09-24 05:49:43'),
(277, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>238</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 05:57:29', '2016-09-24 05:57:29'),
(278, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>239</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 05:57:32', '2016-09-24 05:57:32'),
(279, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>234</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 05:59:06', '2016-09-24 05:59:06'),
(280, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>241</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 06:06:20', '2016-09-24 06:06:20'),
(281, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>242</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 06:09:05', '2016-09-24 06:09:05'),
(282, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>241</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 06:10:33', '2016-09-24 06:10:33'),
(283, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>242</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 06:10:36', '2016-09-24 06:10:36'),
(284, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>239</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 06:10:39', '2016-09-24 06:10:39'),
(285, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>238</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 06:10:41', '2016-09-24 06:10:41'),
(286, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>245</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 06:18:56', '2016-09-24 06:18:56'),
(287, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>244</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 06:20:22', '2016-09-24 06:20:22'),
(288, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>245</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 06:20:26', '2016-09-24 06:20:26'),
(289, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>244</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 06:22:19', '2016-09-24 06:22:19'),
(290, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>248</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-24 06:35:24', '2016-09-24 06:35:24'),
(291, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>246</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-24 06:37:09', '2016-09-24 06:37:09'),
(292, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>240</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-24 06:42:44', '2016-09-24 06:42:44'),
(293, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>250</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 06:43:01', '2016-09-24 06:43:01'),
(294, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>249</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 06:43:22', '2016-09-24 06:43:22'),
(295, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>251</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 06:43:41', '2016-09-24 06:43:41'),
(296, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>242</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-24 06:44:02', '2016-09-24 06:44:02'),
(297, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>248</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-24 06:44:10', '2016-09-24 06:44:10'),
(298, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>246</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-24 06:44:25', '2016-09-24 06:44:25'),
(299, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>252</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 06:48:40', '2016-09-24 06:48:40'),
(300, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>249</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 06:49:54', '2016-09-24 06:49:54'),
(301, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>250</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 06:49:59', '2016-09-24 06:49:59'),
(302, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>251</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 06:50:02', '2016-09-24 06:50:02'),
(303, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>236,237</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-24 06:50:10', '2016-09-24 06:50:10'),
(304, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>252</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-24 06:52:20', '2016-09-24 06:52:20'),
(305, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>243</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 06:59:51', '2016-09-24 06:59:51'),
(306, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>254</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 07:00:06', '2016-09-24 07:00:06'),
(307, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>254</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 07:00:18', '2016-09-24 07:00:18'),
(308, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>243</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 07:05:59', '2016-09-24 07:05:59'),
(309, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>235,247,253,255</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-24 07:06:16', '2016-09-24 07:06:16'),
(310, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>256</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 07:11:51', '2016-09-24 07:11:51'),
(311, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>256</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 07:13:09', '2016-09-24 07:13:09'),
(312, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>257</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 07:22:36', '2016-09-24 07:22:36'),
(313, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>257</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 07:26:34', '2016-09-24 07:26:34'),
(314, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>258</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 07:38:52', '2016-09-24 07:38:52'),
(315, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>259</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 07:39:39', '2016-09-24 07:39:39'),
(316, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>258</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 07:51:48', '2016-09-24 07:51:48'),
(317, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>260</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 07:55:48', '2016-09-24 07:55:48'),
(318, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>260</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 07:59:01', '2016-09-24 07:59:01'),
(319, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>262</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 08:08:32', '2016-09-24 08:08:32'),
(320, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>262</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 08:14:07', '2016-09-24 08:14:07'),
(321, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>261</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 08:16:33', '2016-09-24 08:16:33'),
(322, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>263</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 08:17:13', '2016-09-24 08:17:13'),
(323, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>264</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 08:18:08', '2016-09-24 08:18:08'),
(324, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>263</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 08:22:33', '2016-09-24 08:22:33'),
(325, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>266</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 08:30:07', '2016-09-24 08:30:07'),
(326, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>267</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 08:33:07', '2016-09-24 08:33:07'),
(327, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>265</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 08:34:02', '2016-09-24 08:34:02'),
(328, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>269</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 08:35:36', '2016-09-24 08:35:36'),
(329, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>268</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 08:35:40', '2016-09-24 08:35:40'),
(330, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>261,264</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-24 08:38:55', '2016-09-24 08:38:55'),
(331, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>269</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 08:41:12', '2016-09-24 08:41:12'),
(332, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>265</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 08:42:21', '2016-09-24 08:42:21'),
(333, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>267</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 08:42:43', '2016-09-24 08:42:43');
INSERT INTO `history` (`id`, `type_id`, `user_id`, `entity_id`, `icon`, `class`, `text`, `assets`, `created_at`, `updated_at`) VALUES
(334, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>268</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 08:44:25', '2016-09-24 08:44:25'),
(335, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>272</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 08:49:00', '2016-09-24 08:49:00'),
(336, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>271</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 08:49:24', '2016-09-24 08:49:24'),
(337, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>270</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 08:49:26', '2016-09-24 08:49:26'),
(338, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>266</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 08:49:40', '2016-09-24 08:49:40'),
(339, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>273</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 08:49:48', '2016-09-24 08:49:48'),
(340, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>271</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 08:51:23', '2016-09-24 08:51:23'),
(341, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>274</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 08:53:15', '2016-09-24 08:53:15'),
(342, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>274</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 08:53:54', '2016-09-24 08:53:54'),
(343, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>273</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 08:53:56', '2016-09-24 08:53:56'),
(344, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>272</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 08:55:27', '2016-09-24 08:55:27'),
(345, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>275</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 08:56:26', '2016-09-24 08:56:26'),
(346, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>277</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 09:10:57', '2016-09-24 09:10:57'),
(347, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>270</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 09:13:18', '2016-09-24 09:13:18'),
(348, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>276</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-24 09:14:30', '2016-09-24 09:14:30'),
(349, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>280</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 09:14:37', '2016-09-24 09:14:37'),
(350, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>278</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 09:14:42', '2016-09-24 09:14:42'),
(351, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>278</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 09:16:04', '2016-09-24 09:16:04'),
(352, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>276</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 09:16:50', '2016-09-24 09:16:50'),
(353, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>280</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 09:18:52', '2016-09-24 09:18:52'),
(354, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>279</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 09:19:55', '2016-09-24 09:19:55'),
(355, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>275</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 09:22:27', '2016-09-24 09:22:27'),
(356, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>277</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 09:22:33', '2016-09-24 09:22:33'),
(357, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>276</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 09:28:45', '2016-09-24 09:28:45'),
(358, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>281</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 09:31:02', '2016-09-24 09:31:02'),
(359, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>279</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 09:32:24', '2016-09-24 09:32:24'),
(360, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>281</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 09:38:26', '2016-09-24 09:38:26'),
(361, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>282</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 09:38:52', '2016-09-24 09:38:52'),
(362, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>283</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 09:43:09', '2016-09-24 09:43:09'),
(363, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>281</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 09:44:57', '2016-09-24 09:44:57'),
(364, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>283</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 09:47:47', '2016-09-24 09:47:47'),
(365, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>283</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 09:51:42', '2016-09-24 09:51:42'),
(366, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>284</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 10:00:13', '2016-09-24 10:00:13'),
(367, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>285</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 10:00:16', '2016-09-24 10:00:16'),
(368, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>284</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 10:11:34', '2016-09-24 10:11:34'),
(369, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>285</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 10:11:44', '2016-09-24 10:11:44'),
(370, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>286</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 10:13:19', '2016-09-24 10:13:19'),
(371, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>287</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 10:16:28', '2016-09-24 10:16:28'),
(372, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>265</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-24 10:17:26', '2016-09-24 10:17:26'),
(373, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>286</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-24 10:17:42', '2016-09-24 10:17:42'),
(374, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>288</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 10:18:57', '2016-09-24 10:18:57'),
(375, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>288</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 10:20:12', '2016-09-24 10:20:12'),
(376, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>289</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 10:20:42', '2016-09-24 10:20:42'),
(377, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>290</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 10:25:44', '2016-09-24 10:25:44'),
(378, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>291</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 10:25:46', '2016-09-24 10:25:46'),
(379, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>289</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 10:27:16', '2016-09-24 10:27:16'),
(380, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>287</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 10:31:23', '2016-09-24 10:31:23'),
(381, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>292</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 10:35:23', '2016-09-24 10:35:23'),
(382, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>293</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 10:35:25', '2016-09-24 10:35:25'),
(383, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>295</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 10:42:11', '2016-09-24 10:42:11'),
(384, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>297</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 10:45:38', '2016-09-24 10:45:38'),
(385, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>291</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 10:47:49', '2016-09-24 10:47:49'),
(386, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>296</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 10:47:58', '2016-09-24 10:47:58'),
(387, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>294</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 10:48:22', '2016-09-24 10:48:22'),
(388, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>292</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 10:50:02', '2016-09-24 10:50:02'),
(389, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>290</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 10:50:05', '2016-09-24 10:50:05'),
(390, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>293</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 10:50:25', '2016-09-24 10:50:25'),
(391, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>259,282</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-24 10:54:45', '2016-09-24 10:54:45'),
(392, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>295</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 10:59:59', '2016-09-24 10:59:59'),
(393, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>294</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 11:01:04', '2016-09-24 11:01:04'),
(394, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>298</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 11:04:39', '2016-09-24 11:04:39'),
(395, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>299</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 11:12:11', '2016-09-24 11:12:11'),
(396, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>298</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 11:17:10', '2016-09-24 11:17:10'),
(397, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>300</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 11:19:22', '2016-09-24 11:19:22'),
(398, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>297</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 11:21:52', '2016-09-24 11:21:52'),
(399, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>301</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 11:32:12', '2016-09-24 11:32:12'),
(400, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>302</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 11:35:25', '2016-09-24 11:35:25'),
(401, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>302</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 11:38:04', '2016-09-24 11:38:04'),
(402, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>296</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 11:38:42', '2016-09-24 11:38:42'),
(403, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>304</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 11:42:48', '2016-09-24 11:42:48'),
(404, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>304</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 11:50:20', '2016-09-24 11:50:20'),
(405, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>301</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 11:53:16', '2016-09-24 11:53:16'),
(406, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>306</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 11:56:37', '2016-09-24 11:56:37'),
(407, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>299</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 11:57:08', '2016-09-24 11:57:08'),
(408, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>300</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 11:57:14', '2016-09-24 11:57:14'),
(409, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>306</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 11:59:22', '2016-09-24 11:59:22'),
(410, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>259</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 12:00:50', '2016-09-24 12:00:50'),
(411, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>282</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 12:00:53', '2016-09-24 12:00:53'),
(412, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>303</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 12:00:56', '2016-09-24 12:00:56'),
(413, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>282</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 12:03:34', '2016-09-24 12:03:34'),
(414, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>303</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 12:03:39', '2016-09-24 12:03:39'),
(415, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>259</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 12:03:42', '2016-09-24 12:03:42'),
(416, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>307</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 12:19:48', '2016-09-24 12:19:48'),
(417, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>308</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 12:31:09', '2016-09-24 12:31:09'),
(418, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>307</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 12:35:37', '2016-09-24 12:35:37'),
(419, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>308</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 12:35:41', '2016-09-24 12:35:41'),
(420, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>310</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 12:40:07', '2016-09-24 12:40:07'),
(421, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>309</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 12:40:09', '2016-09-24 12:40:09'),
(422, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>299</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-24 12:43:02', '2016-09-24 12:43:02'),
(423, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>310</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 12:50:45', '2016-09-24 12:50:45'),
(424, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>309</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 12:50:48', '2016-09-24 12:50:48'),
(425, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>311</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 12:54:28', '2016-09-24 12:54:28'),
(426, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>312</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 12:54:30', '2016-09-24 12:54:30'),
(427, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>313</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 12:56:10', '2016-09-24 12:56:10'),
(428, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>311</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 13:01:24', '2016-09-24 13:01:24'),
(429, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>312</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 13:01:26', '2016-09-24 13:01:26'),
(430, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>313</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 13:14:31', '2016-09-24 13:14:31'),
(431, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>314</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 13:23:00', '2016-09-24 13:23:00'),
(432, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>315</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 13:23:02', '2016-09-24 13:23:02'),
(433, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>316</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 13:29:57', '2016-09-24 13:29:57'),
(434, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>317</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 13:33:54', '2016-09-24 13:33:54'),
(435, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>318</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 13:39:43', '2016-09-24 13:39:43'),
(436, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>316</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 13:40:30', '2016-09-24 13:40:30'),
(437, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>305</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-24 13:41:02', '2016-09-24 13:41:02'),
(438, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>318</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 13:42:53', '2016-09-24 13:42:53'),
(439, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>320</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 13:45:21', '2016-09-24 13:45:21'),
(440, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>321</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 13:45:23', '2016-09-24 13:45:23'),
(441, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>317</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 13:49:18', '2016-09-24 13:49:18'),
(442, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>315</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 13:49:22', '2016-09-24 13:49:22'),
(443, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>322</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 14:14:35', '2016-09-24 14:14:35'),
(444, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>320</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 14:15:37', '2016-09-24 14:15:37'),
(445, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>321</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 14:15:40', '2016-09-24 14:15:40'),
(446, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>322</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 14:22:12', '2016-09-24 14:22:12'),
(447, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>324</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 14:22:57', '2016-09-24 14:22:57'),
(448, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>325</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 14:23:34', '2016-09-24 14:23:34'),
(449, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>323</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 14:24:07', '2016-09-24 14:24:07'),
(450, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>324</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 14:27:11', '2016-09-24 14:27:11'),
(451, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>323</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 14:33:05', '2016-09-24 14:33:05'),
(452, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>325</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 14:35:26', '2016-09-24 14:35:26'),
(453, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>326</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 14:37:10', '2016-09-24 14:37:10'),
(454, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>326</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 14:38:15', '2016-09-24 14:38:15'),
(455, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>327</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 14:48:10', '2016-09-24 14:48:10'),
(456, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>328</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 14:53:46', '2016-09-24 14:53:46'),
(457, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>327</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 14:56:59', '2016-09-24 14:56:59'),
(458, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>330</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 15:09:03', '2016-09-24 15:09:03'),
(459, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>329</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 15:10:03', '2016-09-24 15:10:03'),
(460, 1, 29, NULL, NULL, NULL, '<strong> lehuy( lehuy@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>330</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 15:31:28', '2016-09-24 15:31:28'),
(461, 1, 29, NULL, NULL, NULL, '<strong> lehuy( lehuy@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>329</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 15:31:31', '2016-09-24 15:31:31'),
(462, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>331</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 15:42:28', '2016-09-24 15:42:28'),
(463, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>333</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 15:51:06', '2016-09-24 15:51:06'),
(464, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>332</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 15:51:16', '2016-09-24 15:51:16'),
(465, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>336</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 15:58:40', '2016-09-24 15:58:40'),
(466, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>335</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 15:59:24', '2016-09-24 15:59:24'),
(467, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>337</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 16:27:13', '2016-09-24 16:27:13'),
(468, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>338</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 16:29:42', '2016-09-24 16:29:42'),
(469, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>339</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 16:30:23', '2016-09-24 16:30:23'),
(470, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>340</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 16:38:12', '2016-09-24 16:38:12'),
(471, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>341</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 16:38:24', '2016-09-24 16:38:24'),
(472, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>341</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 16:55:55', '2016-09-24 16:55:55'),
(473, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>340</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 16:56:00', '2016-09-24 16:56:00'),
(474, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>339</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 16:56:02', '2016-09-24 16:56:02'),
(475, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>338</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 16:56:04', '2016-09-24 16:56:04'),
(476, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>337</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 16:56:10', '2016-09-24 16:56:10'),
(477, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>342</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 17:02:17', '2016-09-24 17:02:17'),
(478, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>343</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 17:04:11', '2016-09-24 17:04:11'),
(479, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>344</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 17:05:45', '2016-09-24 17:05:45'),
(480, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>345</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 17:12:28', '2016-09-24 17:12:28'),
(481, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>342</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 17:15:57', '2016-09-24 17:15:57'),
(482, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>343</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 17:16:00', '2016-09-24 17:16:00'),
(483, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>345</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 17:18:10', '2016-09-24 17:18:10'),
(484, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>346</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 17:23:52', '2016-09-24 17:23:52'),
(485, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>347</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 17:23:55', '2016-09-24 17:23:55'),
(486, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>347</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 17:29:34', '2016-09-24 17:29:34'),
(487, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>346</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 17:29:35', '2016-09-24 17:29:35'),
(488, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>348</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 17:30:45', '2016-09-24 17:30:45'),
(489, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>349</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 17:30:48', '2016-09-24 17:30:48'),
(490, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>350</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 17:31:42', '2016-09-24 17:31:42'),
(491, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>351</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 17:31:44', '2016-09-24 17:31:44'),
(492, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>352</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 17:34:56', '2016-09-24 17:34:56'),
(493, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>353</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 17:36:41', '2016-09-24 17:36:41'),
(494, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>352</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 17:44:13', '2016-09-24 17:44:13'),
(495, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>353</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 17:44:17', '2016-09-24 17:44:17'),
(496, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>354</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 17:44:54', '2016-09-24 17:44:54'),
(497, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>354</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 17:53:05', '2016-09-24 17:53:05'),
(498, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>355</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 18:11:13', '2016-09-24 18:11:13'),
(499, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>355</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 18:23:36', '2016-09-24 18:23:36'),
(500, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>351</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 18:23:44', '2016-09-24 18:23:44'),
(501, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>348</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 18:23:49', '2016-09-24 18:23:49'),
(502, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>356</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 18:54:47', '2016-09-24 18:54:47'),
(503, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>356</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 18:59:40', '2016-09-24 18:59:40'),
(504, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>358</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 19:14:10', '2016-09-24 19:14:10'),
(505, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>357</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 19:14:12', '2016-09-24 19:14:12'),
(506, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>359</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 19:23:13', '2016-09-24 19:23:13'),
(507, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>358</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 19:25:09', '2016-09-24 19:25:09'),
(508, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>357</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 19:25:11', '2016-09-24 19:25:11'),
(509, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>359</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 19:26:55', '2016-09-24 19:26:55'),
(510, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>360</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 19:51:19', '2016-09-24 19:51:19'),
(511, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>360</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-24 19:57:41', '2016-09-24 19:57:41'),
(512, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>361</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-24 21:33:55', '2016-09-24 21:33:55'),
(513, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>361</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 00:36:19', '2016-09-25 00:36:19'),
(514, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>350</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 00:36:21', '2016-09-25 00:36:21'),
(515, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>349</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 00:36:23', '2016-09-25 00:36:23'),
(516, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>344</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 00:36:25', '2016-09-25 00:36:25'),
(517, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>314</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-25 01:32:42', '2016-09-25 01:32:42'),
(518, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>362</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 02:16:18', '2016-09-25 02:16:18'),
(519, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>362</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 02:25:16', '2016-09-25 02:25:16'),
(520, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>334</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-25 02:45:02', '2016-09-25 02:45:02'),
(521, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>364</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 02:50:20', '2016-09-25 02:50:20'),
(522, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>363</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 02:53:17', '2016-09-25 02:53:17'),
(523, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>365</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 03:09:14', '2016-09-25 03:09:14'),
(524, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>364</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 03:12:46', '2016-09-25 03:12:46'),
(525, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>365</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 03:12:49', '2016-09-25 03:12:49'),
(526, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>366</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 03:15:23', '2016-09-25 03:15:23'),
(527, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>363</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 03:15:23', '2016-09-25 03:15:23'),
(528, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>363</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 03:15:25', '2016-09-25 03:15:25'),
(529, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>367</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 03:17:01', '2016-09-25 03:17:01'),
(530, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>367</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 03:17:03', '2016-09-25 03:17:03'),
(531, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>366</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 03:19:41', '2016-09-25 03:19:41'),
(532, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>368</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 03:22:48', '2016-09-25 03:22:48'),
(533, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>368</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 03:30:45', '2016-09-25 03:30:45'),
(534, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>369</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 03:37:11', '2016-09-25 03:37:11'),
(535, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>370</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 03:40:10', '2016-09-25 03:40:10');
INSERT INTO `history` (`id`, `type_id`, `user_id`, `entity_id`, `icon`, `class`, `text`, `assets`, `created_at`, `updated_at`) VALUES
(536, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>369</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 03:40:57', '2016-09-25 03:40:57'),
(537, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>370</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 03:43:06', '2016-09-25 03:43:06'),
(538, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>372</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 03:54:27', '2016-09-25 03:54:27'),
(539, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>372</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 03:54:47', '2016-09-25 03:54:47'),
(540, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>373</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 04:00:14', '2016-09-25 04:00:14'),
(541, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>374</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 04:06:15', '2016-09-25 04:06:15'),
(542, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>374</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-25 04:11:35', '2016-09-25 04:11:35'),
(543, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>375</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 04:12:57', '2016-09-25 04:12:57'),
(544, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>375</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 04:13:33', '2016-09-25 04:13:33'),
(545, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>371</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 04:18:04', '2016-09-25 04:18:04'),
(546, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>371</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 04:18:14', '2016-09-25 04:18:14'),
(547, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>373</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 04:21:37', '2016-09-25 04:21:37'),
(548, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>376</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 04:37:01', '2016-09-25 04:37:01'),
(549, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>377</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 04:47:52', '2016-09-25 04:47:52'),
(550, 1, 30, NULL, NULL, NULL, '<strong> Thái Bếp( hayquenid1@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>376</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 04:48:12', '2016-09-25 04:48:12'),
(551, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>378</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 04:52:56', '2016-09-25 04:52:56'),
(552, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>377</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 04:57:23', '2016-09-25 04:57:23'),
(553, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>380</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 05:04:15', '2016-09-25 05:04:15'),
(554, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>378</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 05:10:44', '2016-09-25 05:10:44'),
(555, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>381</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 05:15:29', '2016-09-25 05:15:29'),
(556, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>382</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 05:17:37', '2016-09-25 05:17:37'),
(557, 1, 30, NULL, NULL, NULL, '<strong> Thái Bếp( hayquenid1@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>380</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 05:17:59', '2016-09-25 05:17:59'),
(558, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>379</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 05:26:31', '2016-09-25 05:26:31'),
(559, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>381</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 05:29:35', '2016-09-25 05:29:35'),
(560, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>383</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 05:30:03', '2016-09-25 05:30:03'),
(561, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>382</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 05:36:03', '2016-09-25 05:36:03'),
(562, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>384</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 05:41:03', '2016-09-25 05:41:03'),
(563, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>385</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 05:43:57', '2016-09-25 05:43:57'),
(564, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>386</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 05:44:11', '2016-09-25 05:44:11'),
(565, 1, 30, NULL, NULL, NULL, '<strong> Thái Bếp( hayquenid1@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>383</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 05:46:22', '2016-09-25 05:46:22'),
(566, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>387</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 05:46:27', '2016-09-25 05:46:27'),
(567, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>388</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 05:46:28', '2016-09-25 05:46:28'),
(568, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>384</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 05:48:49', '2016-09-25 05:48:49'),
(569, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>385</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 05:48:54', '2016-09-25 05:48:54'),
(570, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>386</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 05:55:26', '2016-09-25 05:55:26'),
(571, 1, 30, NULL, NULL, NULL, '<strong> Thái Bếp( hayquenid1@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>388</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 05:58:43', '2016-09-25 05:58:43'),
(572, 1, 30, NULL, NULL, NULL, '<strong> Thái Bếp( hayquenid1@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>387</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 05:58:44', '2016-09-25 05:58:44'),
(573, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>389</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 06:03:51', '2016-09-25 06:03:51'),
(574, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>389</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 06:07:51', '2016-09-25 06:07:51'),
(575, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>390</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 06:11:30', '2016-09-25 06:11:30'),
(576, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>390</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 06:15:48', '2016-09-25 06:15:48'),
(577, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>391</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 06:20:47', '2016-09-25 06:20:47'),
(578, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>392</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 06:24:55', '2016-09-25 06:24:55'),
(579, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>393</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 06:25:42', '2016-09-25 06:25:42'),
(580, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>393</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 06:32:09', '2016-09-25 06:32:09'),
(581, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>394</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 06:34:03', '2016-09-25 06:34:03'),
(582, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>395</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 06:36:32', '2016-09-25 06:36:32'),
(583, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>391</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 06:37:03', '2016-09-25 06:37:03'),
(584, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>392</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 06:39:50', '2016-09-25 06:39:50'),
(585, 1, 30, NULL, NULL, NULL, '<strong> Thái Bếp( hayquenid1@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>393</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-25 06:44:01', '2016-09-25 06:44:01'),
(586, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>394</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 06:47:36', '2016-09-25 06:47:36'),
(587, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>395</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 06:47:39', '2016-09-25 06:47:39'),
(588, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>397</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 06:50:57', '2016-09-25 06:50:57'),
(589, 1, 30, NULL, NULL, NULL, '<strong> Thái Bếp( hayquenid1@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>397</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 06:53:14', '2016-09-25 06:53:14'),
(590, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>398</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 06:55:42', '2016-09-25 06:55:42'),
(591, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>396</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 06:56:09', '2016-09-25 06:56:09'),
(592, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>396</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 06:56:13', '2016-09-25 06:56:13'),
(593, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>396</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 06:56:21', '2016-09-25 06:56:21'),
(594, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>398</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 06:58:09', '2016-09-25 06:58:09'),
(595, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>399</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 07:00:58', '2016-09-25 07:00:58'),
(596, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>399</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-25 07:02:52', '2016-09-25 07:02:52'),
(597, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>399</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-25 07:04:48', '2016-09-25 07:04:48'),
(598, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>400</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 07:05:27', '2016-09-25 07:05:27'),
(599, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>400</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 07:11:06', '2016-09-25 07:11:06'),
(600, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>402</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 07:16:19', '2016-09-25 07:16:19'),
(601, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>401</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 07:20:47', '2016-09-25 07:20:47'),
(602, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>402</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 07:24:21', '2016-09-25 07:24:21'),
(603, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>403</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 07:26:59', '2016-09-25 07:26:59'),
(604, 1, 30, NULL, NULL, NULL, '<strong> Thái Bếp( hayquenid1@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>403</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 07:31:17', '2016-09-25 07:31:17'),
(605, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>404</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 07:41:01', '2016-09-25 07:41:01'),
(606, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>405</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 07:43:50', '2016-09-25 07:43:50'),
(607, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>404</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 07:58:02', '2016-09-25 07:58:02'),
(608, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>405</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 08:00:47', '2016-09-25 08:00:47'),
(609, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>406</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 08:03:03', '2016-09-25 08:03:03'),
(610, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>407</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 08:05:13', '2016-09-25 08:05:13'),
(611, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>406</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 08:06:55', '2016-09-25 08:06:55'),
(612, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>407</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 08:06:57', '2016-09-25 08:06:57'),
(613, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>409</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 08:08:40', '2016-09-25 08:08:40'),
(614, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>410</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 08:11:54', '2016-09-25 08:11:54'),
(615, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>411</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-25 08:13:02', '2016-09-25 08:13:02'),
(616, 1, 30, NULL, NULL, NULL, '<strong> Thái Bếp( hayquenid1@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>410</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 08:14:36', '2016-09-25 08:14:36'),
(617, 1, 30, NULL, NULL, NULL, '<strong> Thái Bếp( hayquenid1@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>409</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 08:14:39', '2016-09-25 08:14:39'),
(618, 1, 30, NULL, NULL, NULL, '<strong> Thái Bếp( hayquenid1@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>409</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-25 08:14:43', '2016-09-25 08:14:43'),
(619, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>412</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 08:16:05', '2016-09-25 08:16:05'),
(620, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>412</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 08:16:24', '2016-09-25 08:16:24'),
(621, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>412</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-25 08:16:35', '2016-09-25 08:16:35'),
(622, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>413</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 08:19:06', '2016-09-25 08:19:06'),
(623, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>408</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 08:21:27', '2016-09-25 08:21:27'),
(624, 1, 31, NULL, NULL, NULL, '<strong> Đỗ Mạnh Tùng( mychulan@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>413</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 08:22:55', '2016-09-25 08:22:55'),
(625, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>414</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 08:23:06', '2016-09-25 08:23:06'),
(626, 1, 31, NULL, NULL, NULL, '<strong> Đỗ Mạnh Tùng( mychulan@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>414</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 08:26:42', '2016-09-25 08:26:42'),
(627, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>415</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 08:31:03', '2016-09-25 08:31:03'),
(628, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>416</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 08:32:08', '2016-09-25 08:32:08'),
(629, 1, 31, NULL, NULL, NULL, '<strong> Đỗ Mạnh Tùng( mychulan@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>416</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 08:35:35', '2016-09-25 08:35:35'),
(630, 1, 31, NULL, NULL, NULL, '<strong> Đỗ Mạnh Tùng( mychulan@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>415</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 08:35:38', '2016-09-25 08:35:38'),
(631, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>417</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 08:36:29', '2016-09-25 08:36:29'),
(632, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>418</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 08:40:05', '2016-09-25 08:40:05'),
(633, 1, 31, NULL, NULL, NULL, '<strong> Đỗ Mạnh Tùng( mychulan@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>418</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 08:44:04', '2016-09-25 08:44:04'),
(634, 1, 31, NULL, NULL, NULL, '<strong> Đỗ Mạnh Tùng( mychulan@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>419</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 08:44:31', '2016-09-25 08:44:31'),
(635, 1, 31, NULL, NULL, NULL, '<strong> Đỗ Mạnh Tùng( mychulan@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>417</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-25 08:44:39', '2016-09-25 08:44:39'),
(636, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>420</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 08:51:26', '2016-09-25 08:51:26'),
(637, 1, 31, NULL, NULL, NULL, '<strong> Đỗ Mạnh Tùng( mychulan@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>419</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 08:54:24', '2016-09-25 08:54:24'),
(638, 1, 31, NULL, NULL, NULL, '<strong> Đỗ Mạnh Tùng( mychulan@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>420</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 08:55:35', '2016-09-25 08:55:35'),
(639, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>421</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 09:18:52', '2016-09-25 09:18:52'),
(640, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>422</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 09:22:19', '2016-09-25 09:22:19'),
(641, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>421</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-25 09:23:08', '2016-09-25 09:23:08'),
(642, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>423</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 09:30:40', '2016-09-25 09:30:40'),
(643, 1, 31, NULL, NULL, NULL, '<strong> Đỗ Mạnh Tùng( mychulan@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>422</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 09:31:06', '2016-09-25 09:31:06'),
(644, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>424</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 09:35:42', '2016-09-25 09:35:42'),
(645, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>425</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 09:39:43', '2016-09-25 09:39:43'),
(646, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>426</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 09:40:26', '2016-09-25 09:40:26'),
(647, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>427</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 09:40:40', '2016-09-25 09:40:40'),
(648, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>425</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-25 09:41:28', '2016-09-25 09:41:28'),
(649, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>426</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-25 09:42:08', '2016-09-25 09:42:08'),
(650, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>425</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 09:42:48', '2016-09-25 09:42:48'),
(651, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>425</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-25 09:44:11', '2016-09-25 09:44:11'),
(652, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>428</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 09:45:47', '2016-09-25 09:45:47'),
(653, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>427,428</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 09:48:44', '2016-09-25 09:48:44'),
(654, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>428</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 09:49:33', '2016-09-25 09:49:33'),
(655, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>423</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 09:54:32', '2016-09-25 09:54:32'),
(656, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>428</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 09:57:42', '2016-09-25 09:57:42'),
(657, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>429</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 10:09:18', '2016-09-25 10:09:18'),
(658, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>429</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 10:09:41', '2016-09-25 10:09:41'),
(659, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>429</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 10:09:47', '2016-09-25 10:09:47'),
(660, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>429</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 10:10:01', '2016-09-25 10:10:01'),
(661, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>429</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 10:10:19', '2016-09-25 10:10:19'),
(662, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>430</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 10:16:32', '2016-09-25 10:16:32'),
(663, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>431</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 10:16:34', '2016-09-25 10:16:34'),
(664, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>429</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 10:18:08', '2016-09-25 10:18:08'),
(665, 1, 31, NULL, NULL, NULL, '<strong> Đỗ Mạnh Tùng( mychulan@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>430</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 10:23:39', '2016-09-25 10:23:39'),
(666, 1, 31, NULL, NULL, NULL, '<strong> Đỗ Mạnh Tùng( mychulan@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>431</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 10:23:42', '2016-09-25 10:23:42'),
(667, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>432</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 10:30:49', '2016-09-25 10:30:49'),
(668, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>432</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 10:30:56', '2016-09-25 10:30:56'),
(669, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>432</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 10:31:05', '2016-09-25 10:31:05'),
(670, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>432</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 10:32:00', '2016-09-25 10:32:00'),
(671, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>432</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 10:36:05', '2016-09-25 10:36:05'),
(672, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>433</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 10:56:29', '2016-09-25 10:56:29'),
(673, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>433</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 11:11:58', '2016-09-25 11:11:58'),
(674, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>434</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 11:31:15', '2016-09-25 11:31:15'),
(675, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>434</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 11:36:51', '2016-09-25 11:36:51'),
(676, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>435</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 11:44:22', '2016-09-25 11:44:22'),
(677, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>435</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 11:47:54', '2016-09-25 11:47:54'),
(678, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>436</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 11:51:49', '2016-09-25 11:51:49'),
(679, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>437</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 11:54:52', '2016-09-25 11:54:52'),
(680, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>439</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 11:55:20', '2016-09-25 11:55:20'),
(681, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>438</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 11:55:41', '2016-09-25 11:55:41'),
(682, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>439</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 12:05:51', '2016-09-25 12:05:51'),
(683, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>436</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-25 12:05:58', '2016-09-25 12:05:58'),
(684, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>437</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-25 12:06:07', '2016-09-25 12:06:07'),
(685, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>438</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 12:08:05', '2016-09-25 12:08:05'),
(686, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>440</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 12:38:44', '2016-09-25 12:38:44'),
(687, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>441</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 12:41:10', '2016-09-25 12:41:10'),
(688, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>440</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 12:43:38', '2016-09-25 12:43:38'),
(689, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>441</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 12:50:38', '2016-09-25 12:50:38'),
(690, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>442</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-25 12:52:16', '2016-09-25 12:52:16'),
(691, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>443</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 13:05:23', '2016-09-25 13:05:23'),
(692, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>443</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 13:08:20', '2016-09-25 13:08:20'),
(693, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>444</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 13:15:10', '2016-09-25 13:15:10'),
(694, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>445</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 13:23:01', '2016-09-25 13:23:01'),
(695, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>444</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 13:27:16', '2016-09-25 13:27:16'),
(696, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>446</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 13:43:57', '2016-09-25 13:43:57'),
(697, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>446</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 13:47:29', '2016-09-25 13:47:29'),
(698, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>448</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 13:48:38', '2016-09-25 13:48:38'),
(699, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>447</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 13:48:40', '2016-09-25 13:48:40'),
(700, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>448,447</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 13:59:38', '2016-09-25 13:59:38'),
(701, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>449</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 14:01:22', '2016-09-25 14:01:22'),
(702, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>450</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 14:23:14', '2016-09-25 14:23:14'),
(703, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>449</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 14:26:36', '2016-09-25 14:26:36'),
(704, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>450</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 14:27:10', '2016-09-25 14:27:10'),
(705, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>451</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 14:29:26', '2016-09-25 14:29:26'),
(706, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>451</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 14:32:03', '2016-09-25 14:32:03'),
(707, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>452</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 14:37:03', '2016-09-25 14:37:03'),
(708, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>452</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 14:41:48', '2016-09-25 14:41:48'),
(709, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>453</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-25 14:45:20', '2016-09-25 14:45:20'),
(710, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>455</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 14:48:52', '2016-09-25 14:48:52'),
(711, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>454</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 14:49:00', '2016-09-25 14:49:00'),
(712, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>454</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 14:55:10', '2016-09-25 14:55:10'),
(713, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>455</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 14:56:02', '2016-09-25 14:56:02'),
(714, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>456</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 15:17:35', '2016-09-25 15:17:35'),
(715, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>457</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 15:31:06', '2016-09-25 15:31:06'),
(716, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>458</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 15:31:53', '2016-09-25 15:31:53'),
(717, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>459</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 15:34:01', '2016-09-25 15:34:01'),
(718, 1, 30, NULL, NULL, NULL, '<strong> Thái Bếp( hayquenid1@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>458</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 15:44:08', '2016-09-25 15:44:08'),
(719, 1, 30, NULL, NULL, NULL, '<strong> Thái Bếp( hayquenid1@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>459</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 15:46:29', '2016-09-25 15:46:29'),
(720, 1, 30, NULL, NULL, NULL, '<strong> Thái Bếp( hayquenid1@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>457</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 15:46:31', '2016-09-25 15:46:31'),
(721, 1, 30, NULL, NULL, NULL, '<strong> Thái Bếp( hayquenid1@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>456</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 15:48:30', '2016-09-25 15:48:30'),
(722, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>460</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 15:53:46', '2016-09-25 15:53:46'),
(723, 1, 30, NULL, NULL, NULL, '<strong> Thái Bếp( hayquenid1@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>459</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-25 15:59:07', '2016-09-25 15:59:07'),
(724, 1, 30, NULL, NULL, NULL, '<strong> Thái Bếp( hayquenid1@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>460</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 16:32:34', '2016-09-25 16:32:34'),
(725, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>461</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 18:10:53', '2016-09-25 18:10:53'),
(726, 1, 29, NULL, NULL, NULL, '<strong> lehuy( lehuy@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>461</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 18:13:39', '2016-09-25 18:13:39'),
(727, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>462</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 18:15:24', '2016-09-25 18:15:24'),
(728, 1, 29, NULL, NULL, NULL, '<strong> lehuy( lehuy@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>462</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 20:10:00', '2016-09-25 20:10:00'),
(729, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>464</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 20:36:26', '2016-09-25 20:36:26'),
(730, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>463</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-25 20:38:05', '2016-09-25 20:38:05'),
(731, 1, 29, NULL, NULL, NULL, '<strong> lehuy( lehuy@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>463</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 20:50:49', '2016-09-25 20:50:49'),
(732, 1, 29, NULL, NULL, NULL, '<strong> lehuy( lehuy@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>464</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-25 20:51:02', '2016-09-25 20:51:02'),
(733, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>465</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 00:22:42', '2016-09-26 00:22:42'),
(734, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>465</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 00:32:52', '2016-09-26 00:32:52'),
(735, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>466</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-26 00:36:21', '2016-09-26 00:36:21');
INSERT INTO `history` (`id`, `type_id`, `user_id`, `entity_id`, `icon`, `class`, `text`, `assets`, `created_at`, `updated_at`) VALUES
(736, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>468</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 00:36:27', '2016-09-26 00:36:27'),
(737, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>467</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-26 00:36:31', '2016-09-26 00:36:31'),
(738, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>468</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 00:40:03', '2016-09-26 00:40:03'),
(739, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>469</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 00:57:11', '2016-09-26 00:57:11'),
(740, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>465</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-26 00:58:00', '2016-09-26 00:58:00'),
(741, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>461</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-26 00:58:14', '2016-09-26 00:58:14'),
(742, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>469</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 01:03:43', '2016-09-26 01:03:43'),
(743, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>470</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 01:06:30', '2016-09-26 01:06:30'),
(744, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>465</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 01:10:10', '2016-09-26 01:10:10'),
(745, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>465</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 01:19:36', '2016-09-26 01:19:36'),
(746, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>465</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-26 01:43:19', '2016-09-26 01:43:19'),
(747, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>471</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 02:11:56', '2016-09-26 02:11:56'),
(748, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>472</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-26 02:12:40', '2016-09-26 02:12:40'),
(749, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>471</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 02:17:20', '2016-09-26 02:17:20'),
(750, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>473</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 02:41:59', '2016-09-26 02:41:59'),
(751, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>473</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-26 03:19:44', '2016-09-26 03:19:44'),
(752, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>471</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-26 03:25:06', '2016-09-26 03:25:06'),
(753, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>471</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-26 03:25:10', '2016-09-26 03:25:10'),
(754, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>474</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 03:45:05', '2016-09-26 03:45:05'),
(755, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>474</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 03:49:14', '2016-09-26 03:49:14'),
(756, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>475</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 04:10:30', '2016-09-26 04:10:30'),
(757, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>477</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 04:10:51', '2016-09-26 04:10:51'),
(758, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>476</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-26 04:12:43', '2016-09-26 04:12:43'),
(759, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>476</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-26 04:12:50', '2016-09-26 04:12:50'),
(760, 1, 30, NULL, NULL, NULL, '<strong> Thái Bếp( hayquenid1@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>476</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-26 04:13:09', '2016-09-26 04:13:09'),
(761, 1, 30, NULL, NULL, NULL, '<strong> Thái Bếp( hayquenid1@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>476</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-26 04:13:17', '2016-09-26 04:13:17'),
(762, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>479</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 04:18:24', '2016-09-26 04:18:24'),
(763, 1, 30, NULL, NULL, NULL, '<strong> Thái Bếp( hayquenid1@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>475</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 04:26:55', '2016-09-26 04:26:55'),
(764, 1, 30, NULL, NULL, NULL, '<strong> Thái Bếp( hayquenid1@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>479</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 04:26:57', '2016-09-26 04:26:57'),
(765, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>480</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 04:29:18', '2016-09-26 04:29:18'),
(766, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>481</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 04:36:20', '2016-09-26 04:36:20'),
(767, 1, 30, NULL, NULL, NULL, '<strong> Thái Bếp( hayquenid1@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>481</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 04:38:38', '2016-09-26 04:38:38'),
(768, 1, 30, NULL, NULL, NULL, '<strong> Thái Bếp( hayquenid1@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>480</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 04:38:43', '2016-09-26 04:38:43'),
(769, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>476</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-26 05:04:08', '2016-09-26 05:04:08'),
(770, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>482</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 05:21:09', '2016-09-26 05:21:09'),
(771, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>483</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 05:22:10', '2016-09-26 05:22:10'),
(772, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>482</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 05:29:33', '2016-09-26 05:29:33'),
(773, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>483</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 05:34:04', '2016-09-26 05:34:04'),
(774, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>484</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 05:36:11', '2016-09-26 05:36:11'),
(775, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>485</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 05:36:24', '2016-09-26 05:36:24'),
(776, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>487</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 05:38:43', '2016-09-26 05:38:43'),
(777, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>487</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 05:44:51', '2016-09-26 05:44:51'),
(778, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>485</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 05:44:53', '2016-09-26 05:44:53'),
(779, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>484</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 05:44:55', '2016-09-26 05:44:55'),
(780, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>487</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 05:45:32', '2016-09-26 05:45:32'),
(781, 1, 30, NULL, NULL, NULL, '<strong> Thái Bếp( hayquenid1@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>487</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 05:45:40', '2016-09-26 05:45:40'),
(782, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>486</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-26 05:45:41', '2016-09-26 05:45:41'),
(783, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>488</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 05:55:01', '2016-09-26 05:55:01'),
(784, 1, 30, NULL, NULL, NULL, '<strong> Thái Bếp( hayquenid1@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>488</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 06:08:56', '2016-09-26 06:08:56'),
(785, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>489</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-26 06:19:05', '2016-09-26 06:19:05'),
(786, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>490</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-26 06:25:20', '2016-09-26 06:25:20'),
(787, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>491</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-26 06:26:04', '2016-09-26 06:26:04'),
(788, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>492,493</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-26 06:45:36', '2016-09-26 06:45:36'),
(789, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>494</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 07:06:54', '2016-09-26 07:06:54'),
(790, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>494</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 07:17:40', '2016-09-26 07:17:40'),
(791, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>478,486</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-26 07:22:57', '2016-09-26 07:22:57'),
(792, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>495</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 07:26:35', '2016-09-26 07:26:35'),
(793, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>496</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 07:37:08', '2016-09-26 07:37:08'),
(794, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>496</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 07:39:55', '2016-09-26 07:39:55'),
(795, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>497</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 07:45:18', '2016-09-26 07:45:18'),
(796, 1, 30, NULL, NULL, NULL, '<strong> Thái Bếp( hayquenid1@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>495</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 07:48:01', '2016-09-26 07:48:01'),
(797, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>499</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 07:48:21', '2016-09-26 07:48:21'),
(798, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>500</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 07:48:28', '2016-09-26 07:48:28'),
(799, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>500</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 08:04:42', '2016-09-26 08:04:42'),
(800, 1, 30, NULL, NULL, NULL, '<strong> Thái Bếp( hayquenid1@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>499</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 08:06:43', '2016-09-26 08:06:43'),
(801, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>502</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 08:10:03', '2016-09-26 08:10:03'),
(802, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>497</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 08:10:08', '2016-09-26 08:10:08'),
(803, 1, 30, NULL, NULL, NULL, '<strong> Thái Bếp( hayquenid1@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>502</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 08:24:41', '2016-09-26 08:24:41'),
(804, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>507</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-26 08:25:37', '2016-09-26 08:25:37'),
(805, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>498,501</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-26 08:26:19', '2016-09-26 08:26:19'),
(806, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>504,505</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-26 08:26:30', '2016-09-26 08:26:30'),
(807, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>503</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-26 08:26:41', '2016-09-26 08:26:41'),
(808, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>510</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-26 08:27:40', '2016-09-26 08:27:40'),
(809, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>509</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 08:27:55', '2016-09-26 08:27:55'),
(810, 1, 30, NULL, NULL, NULL, '<strong> Thái Bếp( hayquenid1@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>509</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 08:28:25', '2016-09-26 08:28:25'),
(811, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>508</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 08:28:45', '2016-09-26 08:28:45'),
(812, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>506</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 08:29:59', '2016-09-26 08:29:59'),
(813, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>511</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 08:30:02', '2016-09-26 08:30:02'),
(814, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>513</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-26 08:31:06', '2016-09-26 08:31:06'),
(815, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>514</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-26 08:31:43', '2016-09-26 08:31:43'),
(816, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>514</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-26 08:32:04', '2016-09-26 08:32:04'),
(817, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>515</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-26 08:33:36', '2016-09-26 08:33:36'),
(818, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>512</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 08:33:54', '2016-09-26 08:33:54'),
(819, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>516</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-26 08:36:02', '2016-09-26 08:36:02'),
(820, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>517</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-26 08:37:03', '2016-09-26 08:37:03'),
(821, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>506</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 08:37:40', '2016-09-26 08:37:40'),
(822, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>508</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 08:37:42', '2016-09-26 08:37:42'),
(823, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>511</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 08:37:44', '2016-09-26 08:37:44'),
(824, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>518</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 08:38:32', '2016-09-26 08:38:32'),
(825, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>519</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 08:40:55', '2016-09-26 08:40:55'),
(826, 1, 30, NULL, NULL, NULL, '<strong> Thái Bếp( hayquenid1@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>518</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 08:49:44', '2016-09-26 08:49:44'),
(827, 1, 30, NULL, NULL, NULL, '<strong> Thái Bếp( hayquenid1@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>512</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 08:51:51', '2016-09-26 08:51:51'),
(828, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>520</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 08:59:32', '2016-09-26 08:59:32'),
(829, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>521</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 09:06:03', '2016-09-26 09:06:03'),
(830, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>521</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 09:08:14', '2016-09-26 09:08:14'),
(831, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>522</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 09:09:19', '2016-09-26 09:09:19'),
(832, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>524</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 09:14:43', '2016-09-26 09:14:43'),
(833, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>523</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 09:14:51', '2016-09-26 09:14:51'),
(834, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>523</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 09:18:54', '2016-09-26 09:18:54'),
(835, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>522</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 09:28:40', '2016-09-26 09:28:40'),
(836, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>524</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 09:32:02', '2016-09-26 09:32:02'),
(837, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>525</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 09:37:45', '2016-09-26 09:37:45'),
(838, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>525</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 09:37:47', '2016-09-26 09:37:47'),
(839, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>526</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 09:43:27', '2016-09-26 09:43:27'),
(840, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>526</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 09:45:02', '2016-09-26 09:45:02'),
(841, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>527</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 09:53:03', '2016-09-26 09:53:03'),
(842, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>527</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 09:59:30', '2016-09-26 09:59:30'),
(843, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>528</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 10:07:59', '2016-09-26 10:07:59'),
(844, 1, 30, NULL, NULL, NULL, '<strong> Thái Bếp( hayquenid1@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>528</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 10:14:32', '2016-09-26 10:14:32'),
(845, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>529</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 10:39:40', '2016-09-26 10:39:40'),
(846, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>529</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 10:48:06', '2016-09-26 10:48:06'),
(847, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>530</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 10:49:40', '2016-09-26 10:49:40'),
(848, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>531</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 10:54:07', '2016-09-26 10:54:07'),
(849, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>531</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 10:54:10', '2016-09-26 10:54:10'),
(850, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>530</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 10:54:19', '2016-09-26 10:54:19'),
(851, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>532</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 10:55:50', '2016-09-26 10:55:50'),
(852, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>533</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 10:58:37', '2016-09-26 10:58:37'),
(853, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>534</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 11:02:34', '2016-09-26 11:02:34'),
(854, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>535</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 11:08:53', '2016-09-26 11:08:53'),
(855, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>536</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 11:10:10', '2016-09-26 11:10:10'),
(856, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>533</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 11:10:38', '2016-09-26 11:10:38'),
(857, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>535</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 11:10:45', '2016-09-26 11:10:45'),
(858, 1, 30, NULL, NULL, NULL, '<strong> Thái Bếp( hayquenid1@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>535</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 11:10:52', '2016-09-26 11:10:52'),
(859, 1, 30, NULL, NULL, NULL, '<strong> Thái Bếp( hayquenid1@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>532</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 11:11:12', '2016-09-26 11:11:12'),
(860, 1, 30, NULL, NULL, NULL, '<strong> Thái Bếp( hayquenid1@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>534</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 11:11:16', '2016-09-26 11:11:16'),
(861, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>537</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 11:16:34', '2016-09-26 11:16:34'),
(862, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>538</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 11:21:50', '2016-09-26 11:21:50'),
(863, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>539</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 11:21:53', '2016-09-26 11:21:53'),
(864, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>540</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 11:24:15', '2016-09-26 11:24:15'),
(865, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>536</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 11:24:32', '2016-09-26 11:24:32'),
(866, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>539</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 11:25:24', '2016-09-26 11:25:24'),
(867, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>538</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 11:25:26', '2016-09-26 11:25:26'),
(868, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>541</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 11:27:17', '2016-09-26 11:27:17'),
(869, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>540</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 11:28:12', '2016-09-26 11:28:12'),
(870, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>541</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 11:30:29', '2016-09-26 11:30:29'),
(871, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>537</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 11:37:28', '2016-09-26 11:37:28'),
(872, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>542</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 11:56:36', '2016-09-26 11:56:36'),
(873, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>542</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 12:02:50', '2016-09-26 12:02:50'),
(874, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>543</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 12:04:55', '2016-09-26 12:04:55'),
(875, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>544</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 12:04:56', '2016-09-26 12:04:56'),
(876, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>545</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 12:04:58', '2016-09-26 12:04:58'),
(877, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>544</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 12:12:46', '2016-09-26 12:12:46'),
(878, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>545</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 12:12:48', '2016-09-26 12:12:48'),
(879, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>546</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 12:13:59', '2016-09-26 12:13:59'),
(880, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>547</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 12:14:03', '2016-09-26 12:14:03'),
(881, 1, 30, NULL, NULL, NULL, '<strong> Thái Bếp( hayquenid1@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>547</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 12:17:50', '2016-09-26 12:17:50'),
(882, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>548</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 12:18:10', '2016-09-26 12:18:10'),
(883, 1, 30, NULL, NULL, NULL, '<strong> Thái Bếp( hayquenid1@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>543</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 12:23:37', '2016-09-26 12:23:37'),
(884, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>549</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 12:26:15', '2016-09-26 12:26:15'),
(885, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>551</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 12:35:12', '2016-09-26 12:35:12'),
(886, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>550</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 12:35:14', '2016-09-26 12:35:14'),
(887, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>551</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 12:39:35', '2016-09-26 12:39:35'),
(888, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>550</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 12:39:36', '2016-09-26 12:39:36'),
(889, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>546</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 12:39:48', '2016-09-26 12:39:48'),
(890, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>548</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 12:39:52', '2016-09-26 12:39:52'),
(891, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>549</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 12:39:55', '2016-09-26 12:39:55'),
(892, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>552</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 12:41:55', '2016-09-26 12:41:55'),
(893, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>553</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 12:42:12', '2016-09-26 12:42:12'),
(894, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>553</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 12:42:14', '2016-09-26 12:42:14'),
(895, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>554</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 12:51:15', '2016-09-26 12:51:15'),
(896, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>555</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 12:55:05', '2016-09-26 12:55:05'),
(897, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>555</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 12:57:39', '2016-09-26 12:57:39'),
(898, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>554</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 12:57:41', '2016-09-26 12:57:41'),
(899, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>552</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 12:57:43', '2016-09-26 12:57:43'),
(900, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>556</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 13:02:07', '2016-09-26 13:02:07'),
(901, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>557</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 13:05:50', '2016-09-26 13:05:50'),
(902, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>558</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 13:06:18', '2016-09-26 13:06:18'),
(903, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>559</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 13:09:13', '2016-09-26 13:09:13'),
(904, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>559</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 13:09:15', '2016-09-26 13:09:15'),
(905, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>560</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 13:28:59', '2016-09-26 13:28:59'),
(906, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>558</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 13:31:18', '2016-09-26 13:31:18'),
(907, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>557</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 13:31:20', '2016-09-26 13:31:20'),
(908, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>560</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 13:40:19', '2016-09-26 13:40:19'),
(909, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>561</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 13:42:06', '2016-09-26 13:42:06'),
(910, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>561</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 13:42:08', '2016-09-26 13:42:08'),
(911, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>561</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 13:42:11', '2016-09-26 13:42:11'),
(912, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>562</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 13:54:34', '2016-09-26 13:54:34'),
(913, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>562</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 14:01:56', '2016-09-26 14:01:56'),
(914, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>563</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 14:07:02', '2016-09-26 14:07:02'),
(915, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>564</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 14:14:36', '2016-09-26 14:14:36'),
(916, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>563</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 14:15:42', '2016-09-26 14:15:42'),
(917, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>564</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 14:15:47', '2016-09-26 14:15:47'),
(918, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>565</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 14:24:27', '2016-09-26 14:24:27'),
(919, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>566</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-26 14:39:26', '2016-09-26 14:39:26'),
(920, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>565</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 14:39:54', '2016-09-26 14:39:54'),
(921, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>567</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 14:42:14', '2016-09-26 14:42:14'),
(922, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>567</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 14:44:08', '2016-09-26 14:44:08'),
(923, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>566</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 15:06:29', '2016-09-26 15:06:29'),
(924, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>568</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 15:07:48', '2016-09-26 15:07:48'),
(925, 1, 32, NULL, NULL, NULL, '<strong> thu ngân tầng 5( thungantang5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>570</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 15:21:24', '2016-09-26 15:21:24'),
(926, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>569</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 15:22:03', '2016-09-26 15:22:03'),
(927, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>566</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 15:24:47', '2016-09-26 15:24:47'),
(928, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>571</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 16:03:08', '2016-09-26 16:03:08'),
(929, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>571</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 16:03:11', '2016-09-26 16:03:11'),
(930, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>572</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 16:07:02', '2016-09-26 16:07:02'),
(931, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>573</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 16:24:58', '2016-09-26 16:24:58'),
(932, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>573</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 16:25:01', '2016-09-26 16:25:01'),
(933, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>574</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 16:30:31', '2016-09-26 16:30:31'),
(934, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>576</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 16:38:08', '2016-09-26 16:38:08'),
(935, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>576</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 16:45:15', '2016-09-26 16:45:15'),
(936, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>575</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 16:45:17', '2016-09-26 16:45:17'),
(937, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>575</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 16:45:20', '2016-09-26 16:45:20');
INSERT INTO `history` (`id`, `type_id`, `user_id`, `entity_id`, `icon`, `class`, `text`, `assets`, `created_at`, `updated_at`) VALUES
(938, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>574</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 16:45:22', '2016-09-26 16:45:22'),
(939, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>577</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 16:57:43', '2016-09-26 16:57:43'),
(940, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>577</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 16:57:45', '2016-09-26 16:57:45'),
(941, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>578</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 18:20:46', '2016-09-26 18:20:46'),
(942, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>578</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 18:28:09', '2016-09-26 18:28:09'),
(943, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>579</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 18:53:29', '2016-09-26 18:53:29'),
(944, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>580</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 20:05:04', '2016-09-26 20:05:04'),
(945, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>580</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 20:15:51', '2016-09-26 20:15:51'),
(946, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>581</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 21:24:02', '2016-09-26 21:24:02'),
(947, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>581</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 21:39:22', '2016-09-26 21:39:22'),
(948, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>582</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 22:04:07', '2016-09-26 22:04:07'),
(949, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>583</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-26 22:04:09', '2016-09-26 22:04:09'),
(950, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>583</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 22:04:11', '2016-09-26 22:04:11'),
(951, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>582</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-26 22:04:14', '2016-09-26 22:04:14'),
(952, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>579</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-26 23:49:37', '2016-09-26 23:49:37'),
(953, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>579</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-27 00:04:08', '2016-09-27 00:04:08'),
(954, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>584</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-27 01:24:11', '2016-09-27 01:24:11'),
(955, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>584</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-27 01:41:47', '2016-09-27 01:41:47'),
(956, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>585</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-27 02:07:02', '2016-09-27 02:07:02'),
(957, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>585</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-27 02:10:24', '2016-09-27 02:10:24'),
(958, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>586</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-27 02:29:06', '2016-09-27 02:29:06'),
(959, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>587</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-27 02:29:45', '2016-09-27 02:29:45'),
(960, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>586</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-27 02:34:47', '2016-09-27 02:34:47'),
(961, 1, 27, NULL, NULL, NULL, '<strong> Bảo Lâm( arigato.hexor@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>588</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-27 02:35:47', '2016-09-27 02:35:47'),
(962, 1, 28, NULL, NULL, NULL, '<strong> Duy Mạnh( bestfriend2124@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>589</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-27 02:36:02', '2016-09-27 02:36:02'),
(963, 1, 17, NULL, NULL, NULL, '<strong> admin( admin@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>588</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-27 02:37:13', '2016-09-27 02:37:13'),
(964, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>588</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-27 02:37:21', '2016-09-27 02:37:21'),
(965, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>587</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-27 02:37:40', '2016-09-27 02:37:40'),
(966, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>589</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-27 02:37:42', '2016-09-27 02:37:42'),
(967, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>590</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-27 03:13:56', '2016-09-27 03:13:56'),
(968, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>591</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-27 03:22:03', '2016-09-27 03:22:03'),
(969, 1, 25, NULL, NULL, NULL, '<strong> Tung1998( ngthanhtung98@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>592</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-27 03:22:05', '2016-09-27 03:22:05'),
(970, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>590</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-27 03:23:36', '2016-09-27 03:23:36'),
(971, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>591</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-27 03:30:59', '2016-09-27 03:30:59'),
(972, 1, 24, NULL, NULL, NULL, '<strong> Ngọc Hà( peo.nguyen1989@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>592</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-27 03:31:01', '2016-09-27 03:31:01'),
(973, 1, 1, NULL, NULL, NULL, '<strong> hoang( hoangkhoik5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>593</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-27 04:03:53', '2016-09-27 04:03:53'),
(974, 1, 1, NULL, NULL, NULL, '<strong> hoang( hoangkhoik5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>594</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-27 04:03:55', '2016-09-27 04:03:55'),
(975, 1, 1, NULL, NULL, NULL, '<strong> hoang( hoangkhoik5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>596</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-28 01:29:05', '2016-09-28 01:29:05'),
(976, 1, 1, NULL, NULL, NULL, '<strong> hoang( hoangkhoik5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>596</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-28 01:29:12', '2016-09-28 01:29:12'),
(977, 1, 1, NULL, NULL, NULL, '<strong> hoang( hoangkhoik5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>596</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-28 01:37:13', '2016-09-28 01:37:13'),
(978, 1, 1, NULL, NULL, NULL, '<strong> hoang( hoangkhoik5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>596</strong> sang <span class="label label-warning">Đang xử lý</span>', NULL, '2016-09-28 01:37:15', '2016-09-28 01:37:15'),
(979, 1, 1, NULL, NULL, NULL, '<strong> hoang( hoangkhoik5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>600</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-28 07:59:06', '2016-09-28 07:59:06'),
(980, 1, 34, NULL, NULL, NULL, '<strong> Nguyễn Văn Hợp( hop.nguyen@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>610,609,608,607</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-28 10:16:12', '2016-09-28 10:16:12'),
(981, 1, 1, NULL, NULL, NULL, '<strong> hoang( hoangkhoik5@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>610</strong> sang <span class="label label-warning">Đang xử lý</span>', NULL, '2016-09-28 10:27:11', '2016-09-28 10:27:11'),
(982, 1, 34, NULL, NULL, NULL, '<strong> Nguyễn Văn Hợp( hop.nguyen@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>615,616,617,618</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-29 01:12:29', '2016-09-29 01:12:29'),
(983, 1, 34, NULL, NULL, NULL, '<strong> Nguyễn Văn Hợp( hop.nguyen@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>618,617,616,615</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-29 01:12:48', '2016-09-29 01:12:48'),
(984, 1, 34, NULL, NULL, NULL, '<strong> Nguyễn Văn Hợp( hop.nguyen@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>619</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-29 01:31:57', '2016-09-29 01:31:57'),
(985, 1, 34, NULL, NULL, NULL, '<strong> Nguyễn Văn Hợp( hop.nguyen@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>619</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-29 01:32:17', '2016-09-29 01:32:17'),
(986, 1, 41, NULL, NULL, NULL, '<strong> quanlytang3( quanlytang3@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>620</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-29 01:48:31', '2016-09-29 01:48:31'),
(987, 1, 41, NULL, NULL, NULL, '<strong> quanlytang3( quanlytang3@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>621</strong> sang <span class="label label-danger">Đã hủy</span>', NULL, '2016-09-29 01:48:42', '2016-09-29 01:48:42'),
(988, 1, 41, NULL, NULL, NULL, '<strong> quanlytang3( quanlytang3@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>621</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-29 01:48:45', '2016-09-29 01:48:45'),
(989, 1, 41, NULL, NULL, NULL, '<strong> quanlytang3( quanlytang3@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>621</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-29 01:48:53', '2016-09-29 01:48:53'),
(990, 1, 41, NULL, NULL, NULL, '<strong> quanlytang3( quanlytang3@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>621</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-29 01:48:59', '2016-09-29 01:48:59'),
(991, 1, 21, NULL, NULL, NULL, '<strong> thungant3( thungant3@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>620,621,622</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-29 01:54:10', '2016-09-29 01:54:10'),
(992, 1, 21, NULL, NULL, NULL, '<strong> thungant3( thungant3@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>620</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-29 01:54:15', '2016-09-29 01:54:15'),
(993, 1, 21, NULL, NULL, NULL, '<strong> thungant3( thungant3@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>621</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-29 01:54:17', '2016-09-29 01:54:17'),
(994, 1, 21, NULL, NULL, NULL, '<strong> thungant3( thungant3@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>622</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-29 01:54:19', '2016-09-29 01:54:19'),
(995, 1, 34, NULL, NULL, NULL, '<strong> Nguyễn Văn Hợp( hop.nguyen@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>620,621,622</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-29 01:54:44', '2016-09-29 01:54:44'),
(996, 1, 42, NULL, NULL, NULL, '<strong> QL 4( lazy_cat_kawaii@yahoo.com )</strong> thay đổi trạng thái đơn hàng  <strong>623</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-29 02:02:45', '2016-09-29 02:02:45'),
(997, 1, 42, NULL, NULL, NULL, '<strong> QL 4( lazy_cat_kawaii@yahoo.com )</strong> thay đổi trạng thái đơn hàng  <strong>623</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-29 02:03:19', '2016-09-29 02:03:19'),
(998, 1, 42, NULL, NULL, NULL, '<strong> QL 4( lazy_cat_kawaii@yahoo.com )</strong> thay đổi trạng thái đơn hàng  <strong>623</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-29 02:03:35', '2016-09-29 02:03:35'),
(999, 1, 42, NULL, NULL, NULL, '<strong> QL 4( lazy_cat_kawaii@yahoo.com )</strong> thay đổi trạng thái đơn hàng  <strong>623</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-29 02:03:54', '2016-09-29 02:03:54'),
(1000, 1, 42, NULL, NULL, NULL, '<strong> QL 4( lazy_cat_kawaii@yahoo.com )</strong> thay đổi trạng thái đơn hàng  <strong>623</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-29 02:05:23', '2016-09-29 02:05:23'),
(1001, 1, 42, NULL, NULL, NULL, '<strong> QL 4( lazy_cat_kawaii@yahoo.com )</strong> thay đổi trạng thái đơn hàng  <strong>624</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-29 02:06:42', '2016-09-29 02:06:42'),
(1002, 1, 42, NULL, NULL, NULL, '<strong> QL 4( lazy_cat_kawaii@yahoo.com )</strong> thay đổi trạng thái đơn hàng  <strong>623</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-29 02:06:55', '2016-09-29 02:06:55'),
(1003, 1, 42, NULL, NULL, NULL, '<strong> QL 4( lazy_cat_kawaii@yahoo.com )</strong> thay đổi trạng thái đơn hàng  <strong>624</strong> sang <span class="label label-warning">Đang xử lý</span>', NULL, '2016-09-29 02:07:03', '2016-09-29 02:07:03'),
(1004, 1, 42, NULL, NULL, NULL, '<strong> QL 4( lazy_cat_kawaii@yahoo.com )</strong> thay đổi trạng thái đơn hàng  <strong>624</strong> sang <span class="label label-warning">Đang xử lý</span>', NULL, '2016-09-29 02:07:18', '2016-09-29 02:07:18'),
(1005, 1, 42, NULL, NULL, NULL, '<strong> QL 4( lazy_cat_kawaii@yahoo.com )</strong> thay đổi trạng thái đơn hàng  <strong>624</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-29 02:07:26', '2016-09-29 02:07:26'),
(1006, 1, 42, NULL, NULL, NULL, '<strong> QL 4( lazy_cat_kawaii@yahoo.com )</strong> thay đổi trạng thái đơn hàng  <strong>623,624</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-29 02:07:45', '2016-09-29 02:07:45'),
(1007, 1, 42, NULL, NULL, NULL, '<strong> QL 4( lazy_cat_kawaii@yahoo.com )</strong> thay đổi trạng thái đơn hàng  <strong>624,623</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-29 02:08:09', '2016-09-29 02:08:09'),
(1008, 1, 43, NULL, NULL, NULL, '<strong> Phuc vu 1412( phucvu1412@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>624,623</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-29 02:14:46', '2016-09-29 02:14:46'),
(1009, 1, 43, NULL, NULL, NULL, '<strong> Phuc vu 1412( phucvu1412@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>623,624</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-29 02:15:08', '2016-09-29 02:15:08'),
(1010, 1, 43, NULL, NULL, NULL, '<strong> Phuc vu 1412( phucvu1412@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>624,623</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-29 02:16:32', '2016-09-29 02:16:32'),
(1011, 1, 43, NULL, NULL, NULL, '<strong> Phuc vu 1412( phucvu1412@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>624,623</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-29 02:19:38', '2016-09-29 02:19:38'),
(1012, 1, 43, NULL, NULL, NULL, '<strong> Phuc vu 1412( phucvu1412@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>624,623</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-29 02:19:56', '2016-09-29 02:19:56'),
(1013, 1, 43, NULL, NULL, NULL, '<strong> Phuc vu 1412( phucvu1412@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>623,624</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-29 02:20:48', '2016-09-29 02:20:48'),
(1014, 1, 44, NULL, NULL, NULL, '<strong> Thu ngan 1412( thungan1412@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>623,624</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-29 02:35:30', '2016-09-29 02:35:30'),
(1015, 1, 44, NULL, NULL, NULL, '<strong> Thu ngan 1412( thungan1412@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>625</strong> sang <span class="label label-success">Đã thu tiền</span>', NULL, '2016-09-29 02:47:11', '2016-09-29 02:47:11'),
(1016, 1, 44, NULL, NULL, NULL, '<strong> Thu ngan 1412( thungan1412@gmail.com )</strong> thay đổi trạng thái đơn hàng  <strong>625</strong> sang <span class="label label-success">Đã hoàn thành</span>', NULL, '2016-09-29 02:47:23', '2016-09-29 02:47:23');

-- --------------------------------------------------------

--
-- Table structure for table `history_types`
--

CREATE TABLE `history_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `history_types`
--

INSERT INTO `history_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Order', '2016-08-28 17:00:00', '2016-08-28 17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `listoption`
--

CREATE TABLE `listoption` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `listoption`
--

INSERT INTO `listoption` (`id`, `name`, `price`) VALUES
(4, 'Xúc xích', 10000),
(5, 'Trứng', 6000),
(8, 'Bò khô', 10000),
(9, 'Thêm 1k', 1000),
(10, 'Thêm 2k', 2000),
(12, 'Đổi Cơm Trắng Thành Cơm Chiên', 5000),
(13, 'Thêm 5k', 5000),
(14, 'Mì tôm', 5000);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2016_08_22_092341_create_category_table', 1),
('2016_08_22_092533_create_product_table', 1),
('2016_08_22_092623_create_option_table', 1),
('2016_08_22_092708_create_order_table', 1),
('2016_08_22_092759_create_orderdetails1_table', 1),
('2016_08_22_092805_create_orderdetails2_table', 1),
('2016_08_22_092823_create_room_table', 1),
('2016_08_22_092834_create_client_table', 1),
('2016_08_22_092842_create_admin_table', 1),
('2016_08_22_092341_setup_access_tables', 2),
('2016_08_22_092350_create_history_tables', 3);

-- --------------------------------------------------------

--
-- Table structure for table `option`
--

CREATE TABLE `option` (
  `id` int(10) UNSIGNED NOT NULL,
  `option_id` int(11) DEFAULT NULL,
  `option_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `option_price` int(11) NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `option`
--

INSERT INTO `option` (`id`, `option_id`, `option_name`, `option_price`, `product_id`) VALUES
(82, 4, 'Xúc xích', 10000, 111),
(83, 5, 'Trứng', 6000, 111),
(84, 8, 'Bò khô', 10000, 111),
(85, 9, 'Thêm 1k', 1000, 105),
(86, 10, 'Thêm 2k', 2000, 105),
(87, 13, 'Thêm 5k', 5000, 105),
(88, 9, 'Thêm 1k', 1000, 104),
(89, 10, 'Thêm 2k', 2000, 104),
(90, 13, 'Thêm 5k', 5000, 104),
(91, 9, 'Thêm 1k', 1000, 103),
(92, 10, 'Thêm 2k', 2000, 103),
(93, 13, 'Thêm 5k', 5000, 103),
(94, 9, 'Thêm 1k', 1000, 102),
(95, 10, 'Thêm 2k', 2000, 102),
(96, 13, 'Thêm 5k', 5000, 102),
(97, 9, 'Thêm 1k', 1000, 101),
(98, 10, 'Thêm 2k', 2000, 101),
(99, 13, 'Thêm 5k', 5000, 101),
(104, 14, 'Mì tôm', 5000, 66),
(105, 4, 'Xúc xích', 10000, 64),
(106, 5, 'Trứng', 6000, 64),
(107, 8, 'Bò khô', 10000, 64),
(108, 14, 'Mì tôm', 5000, 64),
(113, 4, 'Xúc xích', 10000, 67),
(114, 5, 'Trứng', 6000, 67),
(115, 8, 'Bò khô', 10000, 67),
(116, 14, 'Mì tôm', 5000, 67),
(117, 5, 'Trứng', 6000, 112);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `order_id` int(10) UNSIGNED NOT NULL,
  `order_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `order_create_time` datetime DEFAULT NULL,
  `order_price` float DEFAULT NULL,
  `order_notice` text COLLATE utf8_unicode_ci,
  `client_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `client_ip` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `room` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `room_id` int(11) NOT NULL,
  `message_destroy` text COLLATE utf8_unicode_ci NOT NULL,
  `order_status` tinyint(4) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`order_id`, `order_name`, `order_create_time`, `order_price`, `order_notice`, `client_name`, `client_ip`, `room`, `room_id`, `message_destroy`, `order_status`) VALUES
(607, '', '2016-09-28 16:40:04', 35000, '', 'Đoàn Việt Quân (Dev)', '192.168.1.18', 'IP VGM Company', 3, '', 3),
(608, '', '2016-09-28 17:13:47', 400000, '', 'Nguyễn Văn Hợp', '192.168.1.16', 'VGM Company( TEST )', 4, '', 3),
(609, '', '2016-09-28 17:14:18', 200000, '', 'Nguyễn Văn Hợp', '192.168.1.16', 'VGM Company( TEST )', 4, '', 3),
(610, '', '2016-09-28 17:15:40', 100000, '', 'Nguyễn Văn Hợp', '192.168.1.16', 'VGM Company( TEST )', 5, '', 1),
(611, '', '2016-09-28 17:37:55', 35000, '', 'Máy 1', '192.168.1.20', 'Tầng 3 - Gengar', 3, '', 1),
(612, '', '2016-09-28 17:44:07', 200000, '', 'Máy 1', '192.168.1.20', 'Tầng 3 - Gengar', 2, '', 1),
(613, '', '2016-09-28 17:46:11', 200000, '', 'Máy 1', '192.168.1.20', 'Tầng 3 - Gengar', 3, '', 1),
(614, '', '2016-09-28 17:46:35', 100000, '', 'Máy 1', '192.168.1.20', 'Tầng 3 - Gengar', 3, '', 1),
(615, '', '2016-09-29 08:12:00', 35000, '', 'Nguyễn Văn Hợp', '192.168.1.16', 'Tầng 2 - Gengar', 2, '', 3),
(616, '', '2016-09-29 08:12:12', 30000, '', 'Nguyễn Văn Hợp', '192.168.1.16', 'Tầng 2 - Gengar', 2, '', 3),
(617, '', '2016-09-29 08:12:22', 200000, '', 'Nguyễn Văn Hợp', '192.168.1.16', 'Tầng 2 - Gengar', 2, '', 3),
(618, '', '2016-09-29 08:12:25', 200000, '', 'Nguyễn Văn Hợp', '192.168.1.16', 'Tầng 2 - Gengar', 2, '', 3),
(619, '', '2016-09-29 08:31:14', 130000, '', 'Lâm Thái Lê', '192.168.1.11', 'Tầng 2 - Gengar', 2, '', 3),
(620, '', '2016-09-29 08:45:55', 243000, '', 'Lâm Thái Lê', '192.168.1.11', 'Tầng 3 - Gengar', 3, '', 3),
(621, '', '2016-09-29 08:48:30', 160000, '', 'Lâm Thái Lê', '192.168.1.11', 'Tầng 3 - Gengar', 3, '', 3),
(622, '', '2016-09-29 08:51:26', 103000, '', 'Lâm Thái Lê', '192.168.1.11', 'Tầng 3 - Gengar', 3, '', 3),
(623, '', '2016-09-29 09:02:12', 161000, '', 'Lâm Thái Lê', '192.168.1.11', 'Tầng 4 - Gengar', 4, '', 3),
(624, '', '2016-09-29 09:05:58', 68000, '', 'Lâm Thái Lê', '192.168.1.11', 'Tầng 4 - Gengar', 4, '', 3),
(625, '', '2016-09-29 09:46:55', 105000, '', 'Lâm Thái Lê', '192.168.1.11', 'Tầng 5 - Gengar', 5, '', 3);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `order_details_id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_price` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_quantity` int(11) NOT NULL DEFAULT '1',
  `product_option` text COLLATE utf8_unicode_ci,
  `product_name` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_details_id`, `order_id`, `product_id`, `product_price`, `product_quantity`, `product_option`, `product_name`, `category_id`) VALUES
(878, 607, 59, '35000', 1, '[]', 'Cơm rang dưa bò', 6),
(879, 608, 101, '200000', 2, '[]', 'Nạp 200k', 27),
(880, 609, 101, '200000', 1, '[]', 'Nạp 200k', 27),
(881, 610, 102, '100000', 1, '[]', 'Nạp 100k', 27),
(882, 611, 59, '35000', 1, '[]', 'Cơm rang dưa bò', 6),
(883, 612, 101, '200000', 1, '[]', 'Nạp 200k', 27),
(884, 613, 101, '200000', 1, '[]', 'Nạp 200k', 27),
(885, 614, 102, '100000', 1, '[]', 'Nạp 100k', 27),
(886, 615, 59, '35000', 1, '[]', 'Cơm rang dưa bò', 6),
(887, 616, 60, '30000', 1, '[]', 'Cơm rang thập cẩm', 6),
(888, 617, 101, '200000', 1, '[]', 'Nạp 200k', 27),
(889, 618, 101, '200000', 1, '[]', 'Nạp 200k', 27),
(890, 619, 87, '30000', 1, '[]', 'Nước táo', 17),
(891, 619, 103, '60000', 1, '[["93","Th\\u00eam 5k","5000","2"]]', 'Nạp 50k', 27),
(892, 619, 60, '30000', 1, '[]', 'Cơm rang thập cẩm', 6),
(893, 619, 106, '10000', 1, '[]', 'Bò khô', 25),
(894, 620, 59, '35000', 1, '[]', 'Cơm rang dưa bò', 6),
(895, 620, 72, '8000', 1, '[]', 'Pepsi', 16),
(896, 620, 101, '200000', 1, '[]', 'Nạp 200k', 27),
(897, 621, 60, '30000', 1, '[]', 'Cơm rang thập cẩm', 6),
(898, 621, 87, '30000', 1, '[]', 'Nước táo', 17),
(899, 621, 102, '100000', 1, '[]', 'Nạp 100k', 27),
(900, 622, 64, '35000', 1, '[]', 'Mỳ xào bò', 10),
(901, 622, 106, '10000', 1, '[]', 'Bò khô', 25),
(902, 622, 72, '8000', 1, '[]', 'Pepsi', 16),
(903, 622, 103, '50000', 1, '[]', 'Nạp 50k', 27),
(904, 623, 62, '30000', 1, '[]', 'Cơm bò xào', 6),
(905, 623, 96, '6000', 1, '[]', 'Trứng Rán', 25),
(906, 623, 90, '25000', 1, '[]', 'Nước dứa', 17),
(907, 623, 102, '100000', 1, '[]', 'Nạp 100k', 27),
(908, 624, 72, '8000', 1, '[]', 'Pepsi', 16),
(909, 624, 106, '10000', 1, '[]', 'Bò khô', 25),
(910, 624, 103, '50000', 1, '[]', 'Nạp 50k', 27),
(911, 625, 63, '30000', 1, '[]', 'Mỳ  tôm xào thập cẩm', 10),
(912, 625, 90, '25000', 1, '[]', 'Nước dứa', 17),
(913, 625, 103, '50000', 1, '[]', 'Nạp 50k', 27);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sort` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `sort`, `created_at`, `updated_at`) VALUES
(1, 'view-backend', 'View Back End', 0, '2016-08-28 17:00:00', '2016-08-28 17:00:00'),
(2, 'manager-option', 'Quản lý option\r\n', 0, '2016-08-28 17:00:00', '2016-08-28 17:00:00'),
(3, 'manager-user', 'Quản lý User', 0, '2016-08-28 17:00:00', '2016-08-28 17:00:00'),
(4, 'manager-history', 'Quản lý lịch sử', 0, '2016-08-28 17:00:00', '2016-08-28 17:00:00'),
(5, 'access-status-money', 'Cho phép cập nhật trạng thái sang đã thu tiền', 0, '2016-08-28 17:00:00', '2016-08-28 17:00:00'),
(6, 'access-status-finish', 'Cho phép cập nhật trạng thái sang đã hoàn thành', 0, '2016-08-28 17:00:00', '2016-08-28 17:00:00'),
(7, 'access-status-destroy', 'Cho phép cập nhật trạng thái sang hủy', 0, '2016-08-28 17:00:00', '2016-08-28 17:00:00'),
(8, 'manager-category', 'Quản lý category', 0, '2016-08-28 17:00:00', '2016-08-28 17:00:00'),
(9, 'manager-product', 'Quản lý product', 0, '2016-08-28 17:00:00', '2016-08-28 17:00:00'),
(10, 'manager-role', 'Quản lý role', 0, '2016-08-28 17:00:00', '2016-08-28 17:00:00'),
(11, 'manager-client', 'Quản lý client', 0, '2016-08-28 17:00:00', '2016-08-28 17:00:00'),
(12, 'manager-report', 'Quản lý báo cáo', 0, '2016-08-28 17:00:00', '2016-08-28 17:00:00'),
(13, 'manager-schedule', 'Quản lý Ca kíp', 0, '2016-08-28 17:00:00', '2016-08-28 17:00:00'),
(14, 'quan-ly-tang-3', 'Quản lý tầng 3', 0, '2016-08-28 17:00:00', '2016-08-28 17:00:00'),
(15, 'quan-ly-tang-4', 'Quản lý tầng 4', 0, '2016-08-28 17:00:00', '2016-08-28 17:00:00'),
(16, 'quan-ly-tang-5', 'Quản lý tầng 5', 0, '2016-08-28 17:00:00', '2016-08-28 17:00:00'),
(18, 'quan-ly-tang-2', 'Quản lý tầng 2', 0, '2016-09-27 17:00:00', '2016-09-27 17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `id` int(10) UNSIGNED NOT NULL,
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`id`, `permission_id`, `role_id`) VALUES
(1, 1, 1),
(14, 6, 4),
(43, 5, 2),
(44, 12, 2),
(45, 14, 2),
(46, 15, 2),
(47, 16, 2),
(48, 18, 2),
(49, 5, 5),
(50, 14, 5),
(51, 5, 6),
(52, 18, 6),
(53, 5, 7),
(54, 15, 7),
(55, 5, 8),
(56, 16, 8),
(57, 6, 3),
(58, 12, 3),
(59, 14, 3),
(60, 15, 3),
(61, 16, 3);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(10) UNSIGNED NOT NULL,
  `product_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `product_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_desc` text COLLATE utf8_unicode_ci,
  `product_price` int(11) NOT NULL DEFAULT '0',
  `category_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_image`, `product_desc`, `product_price`, `category_id`) VALUES
(59, 'Cơm rang dưa bò', '1474624815.cơm rang dưa bò.jpg', '', 35000, 6),
(60, 'Cơm rang thập cẩm', '1474624832.cơm rang thập cẩm.jpg', '', 30000, 6),
(61, 'Cơm đùi gà rán', '1474624851.cơm đùi gà rán.jpg', '', 35000, 6),
(62, 'Cơm bò xào', '1474624873.Cơm bò xào.jpg', '', 30000, 6),
(63, 'Mỳ  tôm xào thập cẩm', '1474624924.mỳ xào thập cẩm.jpg', '', 30000, 10),
(64, 'Mỳ xào bò', '1474624955.mỳ xào bò.jpg', '', 35000, 10),
(65, 'Mỳ xào bò khô', '1474624971.mỳ xào bò khô.jpg', '', 30000, 10),
(66, 'Mỳ bò', '1474625066.Mỳ bò.jpg', '', 25000, 10),
(67, 'Mỳ Tôm Trứng', '1474625088.mỳ trứng.jpg', '', 15000, 10),
(68, 'Bánh mỳ thập cẩm', '1474625116.bánh mỳ thập cẩm.jpg', 'tạm hết ', 20000, 11),
(69, 'Bánh mỳ pate trứng', '1474625148.bánh mỳ pate trứng.jpg', 'tạm thời hết', 15000, 11),
(70, 'Bánh mỳ trứng chả', '1474625169.bánh mỳ trứng chả.jpg', 'tạm hết ', 15000, 11),
(71, 'Bánh mỳ trứng bò khô', '1474625191.bánh mỳ trứng bò khô.jpg', 'tạm hết ', 25000, 11),
(72, 'Pepsi', '1474627493.p.jpg', '', 8000, 16),
(73, 'Sting đỏ', '1474625430.sting đỏ.jpg', '', 10000, 16),
(74, 'Sting vàng', '1474625442.sting vàng.png', '', 10000, 16),
(76, 'Moutain dew', '1474627415.moutain.jpg', '', 8000, 16),
(79, 'Aquafina', '1474626386.aquafina.png', '', 10000, 18),
(80, 'Ice đào', '1474626409.ice đào.jpg', '', 10000, 16),
(81, '7 up', '1474627703.7.jpg', '', 8000, 16),
(82, 'Twister', '1474626448.twister.jpg', '', 8000, 16),
(83, 'Revive', '1474626466.revive.jpg', '', 12000, 18),
(84, 'Cafe đen', '1474626617.đen đá.jpg', '', 15000, 26),
(85, 'Cafe nâu', '1474626634.nâu đá.png', '', 20000, 26),
(86, 'Cafe bạc xỉu', '1474626646.bạc xỉu.png', '', 25000, 26),
(87, 'Nước táo', '1474626955.nước táo.jpg', '', 30000, 17),
(89, 'Nước dưa hấu', '1474626997.dưa hấu.jpg', 'tạm thời hết', 30000, 17),
(90, 'Nước dứa', '1474627011.dứa.jpg', '', 25000, 17),
(91, 'Nước cam vắt', '1474627027.cam.jpg', '', 25000, 17),
(92, 'Nước chanh tươi', '1474627042.chanh.png', '', 20000, 17),
(93, 'Nước ổi', '1474627057.ổi.jpg', 'tạm thời hết', 30000, 17),
(95, 'Xúc xích', '1474627250.xúc xích.jpg', '', 10000, 25),
(96, 'Trứng Rán', '1474627269.trứng.jpg', '', 6000, 25),
(101, 'Nạp 200k', '1474690745.200.png', '+ 20 %', 200000, 27),
(102, 'Nạp 100k', '1474690705.100.png', '+ 10 %', 100000, 27),
(103, 'Nạp 50k', '1474690692.50.png', '+ 10 %', 50000, 27),
(104, 'Nạp 20k', '1474690677.20.png', '', 20000, 27),
(105, 'Nạp 10k', '1474690620.10.png', '', 10000, 27),
(106, 'Bò khô', '1474691079.thit-bo-kho-hang-giay-12.jpg', '', 10000, 25),
(107, 'Combo đêm phòng MOBA', '1474694164.combo_logo.jpg', 'Từ 23 giờ tối - 7 giờ sáng + 1 nước ngọt', 35000, 19),
(108, 'Combo đêm phòng FPS', '1474694222.combo_logo.jpg', 'Từ 23 giờ tối - 7 giờ sáng  + 1 nước ngọt', 50000, 19),
(109, 'Nước cà rốt', '1474700290.ep-ca-rot-20150101214156-581086-original.jpg', '', 25000, 17),
(110, 'Đùi gà KFC', '1474704206.dui-ga-nuong-kieu-han-1.png', '', 35000, 25),
(111, 'Mì tôm không trứng', '1474797976.1474625088.mỳ trứng.jpg', 'Mỳ tôm không trứng', 10000, 10),
(112, 'Cơm thịt kho', '1474944743.1269504288.img.jpg', '', 30000, 6);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `all` tinyint(1) NOT NULL DEFAULT '0',
  `sort` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `all`, `sort`, `created_at`, `updated_at`) VALUES
(1, 'Quản lý', 1, 1, '2016-08-28 17:00:00', '2016-08-28 17:00:00'),
(2, 'Nhân viên phục vụ', 0, 2, '2016-08-28 17:00:00', '2016-09-28 10:42:56'),
(3, 'Thu ngân', 0, 3, '2016-08-28 17:00:00', '2016-09-29 02:35:02'),
(4, 'Đầu bếp', 0, 4, '2016-08-28 17:00:00', '2016-09-06 09:16:40'),
(5, 'Quản lý tầng 3', 0, 0, '2016-09-28 10:19:22', '2016-09-29 01:49:59'),
(6, 'Quản lý tầng 2', 0, 0, '2016-09-28 10:33:12', '2016-09-29 01:50:09'),
(7, 'Quản lý tầng 4', 0, 0, '2016-09-28 10:33:26', '2016-09-29 01:50:15'),
(8, 'Quản lý tầng 5', 0, 0, '2016-09-28 10:33:33', '2016-09-29 01:50:22');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_id` int(10) UNSIGNED NOT NULL,
  `room_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `room_ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_id`, `room_name`, `room_ip`) VALUES
(2, 'Tầng 2 - Gengar', '113.20.109.40,1.55.165.32,42.112.15.76,222.252.17.34'),
(3, 'Tầng 3 - Gengar', '113.20.109.40,1.55.165.32,42.112.15.76,222.252.17.34'),
(4, 'Tầng 4 - Gengar', '113.20.109.40,1.55.165.32,42.112.15.76,222.252.17.34'),
(5, 'Tầng 5 - Gengar', '113.20.109.40,1.55.165.32,42.112.15.76,222.252.17.34');

-- --------------------------------------------------------

--
-- Table structure for table `scheduletime`
--

CREATE TABLE `scheduletime` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `scheduletime`
--

INSERT INTO `scheduletime` (`id`, `name`, `time_start`, `time_end`) VALUES
(1, 'Ca 1', '07:00:00', '15:00:00'),
(2, 'Ca 2', '15:00:00', '22:00:00'),
(3, 'Ca 3', '22:00:00', '07:00:00'),
(4, 'Ca1 + Ca2', '07:00:00', '22:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'hoang', 'hoangkhoik5@gmail.com', '$2y$10$5RLMStq8/CLpvYuj5rEDr.op0mD7DRFsUXvh7Ij64umP66JgQ/F2u', 1, 'mQzRz8BzncHeFBnC2QqEQZDh1Wj2nRIa4F7LdsEOlGpBekaTuQ2mUvIqsc4P', '2016-08-24 17:00:00', '2016-09-28 10:44:51'),
(17, 'admin', 'admin@vgm.company', '$2y$10$PaiY/ijtZmvD1srzC/Bq3.xBfK3slL3X9zJ1Nbs7o.yBsA5po1IaW', 1, '250DT3eZbPTRpjUvAS8BMXLwwgmkf1JIogtxVacvP81vckK82vbrRvpSO7PW', '2016-08-30 12:20:39', '2016-09-27 03:06:40'),
(21, 'thungant3', 'thungant3@gmail.com', '$2y$10$k0lXCWYF7yP/Ik7Oo1wTUOv2JM68P8Zs2iITK3SOxNnFQvswMobv.', 1, 'p6zgT8G5BRTx3liHvXApkY764AoakSawJ5aK6EIjHrnstplRQ2uHxXErpXin', '2016-09-23 01:20:35', '2016-09-29 01:53:24'),
(22, 'thungant4', 'thungant4@gmail.com', '$2y$10$pQj/FSK1aEM7l./z9YZGpuOKKcDtu4A9HNgujMWyqk3LycVuuW8/u', 1, '08apBKb6IMmC0FVHoJUIAQ5gdINDjKTSxmz4Esglktjj2jWZZudWumqkKCtr', '2016-09-23 01:20:58', '2016-09-23 01:24:23'),
(23, 'thungant5', 'thungant5@gmail.com', '$2y$10$ZbgJZoBSpLjZ7V4fssfchOeMAR12Yj41Mu81qvch8Hb9Fh4SDIf5C', 1, NULL, '2016-09-23 01:21:28', '2016-09-25 10:10:43'),
(24, 'Ngọc Hà', 'peo.nguyen1989@gmail.com', '$2y$10$9tj.LJMwW0TOWcYNU8gfle7mxPJmaWIAPp5w7rcGXBCrGKP5ECA1i', 1, 'HuPdaED5wkFT9AsxvPPOaGEo2OchTaTAfitzkjX2MbOdINjgG9VIQejgOSt0', '2016-09-23 08:04:30', '2016-09-27 02:01:06'),
(25, 'Tung1998', 'ngthanhtung98@gmail.com', '$2y$10$hfWNeFRY3.hbLka/ECVdH.IfDUSEP1BSwzflt7uSNRUeuRvbYC7DG', 1, 'pSVmXKZD93wSlMJaV9alhM2vBnryAjprMpMYA1x7kenE48Aozyrmar365iTX', '2016-09-23 08:14:36', '2016-09-26 08:31:46'),
(26, 'Thế Anh', 'theanh_gengargaming@gmail.com', '$2y$10$S2v/FTphc5dKqYc8aB4iEO7lYsjnOQPSuNwfRWtEranMOUySxTthi', 1, '79NSci6FEuU5JrjPZuUeoNEvLiOhODg7V0KLHt73TikAyvCpp2bDwgAHgVeA', '2016-09-23 08:44:01', '2016-09-23 11:02:49'),
(27, 'Bảo Lâm', 'arigato.hexor@gmail.com', '$2y$10$skoPuHrp6XAxv6gafTZhV.VRJjjDvskgbK4CvClN5lFDQYw3TZmkG', 1, 'uqcYMypOy0UHQYVRMR3uOPMv3cQOvJWgIzeUNnogL75DIYMTU5WhAbIcIxI6', '2016-09-23 09:05:28', '2016-09-26 15:13:07'),
(28, 'Duy Mạnh', 'bestfriend2124@gmail.com', '$2y$10$10LfuIZcjT.xO63U5miOFeS90WyIVbOy0dmFdEfMdl4Es9yErLXJa', 1, 'jc4egGQnp5q3LZLILf0pYvzFdeddqSitiRwxxiToxbWpBogGODtW4G9SkgTw', '2016-09-23 09:06:09', '2016-09-26 00:22:34'),
(29, 'lehuy', 'lehuy@gmail.com', '$2y$10$rR5QJR0tlzeZZPp3k/JUpuifZrVrAbQsNjY.AXvWy8UuT7MBcKnh6', 1, 'qIqIGQ2kXNX9pTHcmxyFdq9bqtqTiJmu1FZ0mL1zLNP7F0LjTIai3JDLFE1i', '2016-09-23 13:56:23', '2016-09-26 23:45:28'),
(30, 'Thái Bếp', 'hayquenid1@gmail.com', '$2y$10$rkyO3AZJx8qGcp/jxc6XwOxH2QN/g8fRi9541HOWM7hBGUM5jJTIe', 1, '2duHbQWy5ozVveAGpHVaDqO3AR70JY6Xm68SPIodVGvrtF2LcBnk9TMbOhoD', '2016-09-25 04:22:56', '2016-09-26 12:28:11'),
(31, 'Đỗ Mạnh Tùng', 'mychulan@gmail.com', '$2y$10$4L3yjXeD.8rtiuDkkMZqTOxtp8NBSPY/ZqGngaMaf9O81P.3UL8MO', 1, '6DSCZhqfbvsmHsmJwCcMJN3nRYyr3Zjrg64VWqsgDrs6hqVnLpDQbZOxzpoV', '2016-09-25 08:19:11', '2016-09-25 11:08:15'),
(32, 'thu ngân tầng 5', 'thungantang5@gmail.com', '$2y$10$RGMSAAcNCaIdrgRaBL26vOpmcsc5uw3qPIiqNkClM/h1X5sC4/PP6', 1, 'wiinHbiHz1bLKricqgbJF7TZeiQRCJID9F98HVyiRdQWLeX1RKkbiWNIqsoB', '2016-09-25 10:08:48', '2016-09-27 00:11:15'),
(33, 'Nguyễn Tú Hiếu', 'tuhieuvn@gmail.com', '$2y$10$54VR4HR3GREupt3dwoThmORIjrWNS3C3sCscIrPtJWbF9kV9oW9aq', 1, 'xBdZPF74Kjx2HHBPKgL2Xu92dYQQ9DzkK1gFJxgP5TmpLygWUOGAwbxVP78f', '2016-09-25 11:10:33', '2016-09-27 03:07:37'),
(34, 'Nguyễn Văn Hợp', 'hop.nguyen@vgm.company', '$2y$10$mcvvu7A9yb6/XX2EB812SeH6cU.Df1JlyLCkqd2Umy3faK74UxwTG', 1, 'yFtqmMjIYn9LkVbSBetsMrc02uPCfuTyQpopEMEcAQLCY1n6ZjRwazYAXTnH', '2016-09-27 03:06:35', '2016-09-29 02:13:44'),
(35, 'kkkk', 'user@gmail.com', '$2y$10$POG7Gr4E.olU34QP6I48pOUWaXFStHOlWHYhvevyQFKnagh10AmkG', 1, 'Ly3bN8TokDAYhewTWX8br0T9rte2o0acswNQbYdvduSwyhuJzQvKjZcyDtDo', '2016-09-28 04:18:28', '2016-09-28 08:59:58'),
(36, 'Tầng2', 'tang2@gmail.com', '$2y$10$SFIE.B7YtwS.icS1SIUo5OY8YrZ.9tQcG/Cac1IGDs0UnRDe8tpTC', 1, 'WTbSDNwQGEO7k0YkTyF3NHSHD6nihV8ptdwp1OVCJG6rouSwcYqzqye9wFJb', '2016-09-28 10:33:55', '2016-09-28 10:50:05'),
(37, 'Tầng3', 'tang3@gmail.com', '$2y$10$3R42Vb1tiYvb6KAWlaajo.holXdMNotjcyr0psLDxwJCirqwd0rCy', 1, 'zfdEJhGC5pPMW2ZYiYigHTdaqfXnxebPwBLA6cpIz26Yxhftcw5KnO44ZQgf', '2016-09-28 10:34:15', '2016-09-29 01:47:15'),
(38, 'Tầng4', 'tang4@gmail.com', '$2y$10$rnuvrv568BkThoBboGzOeOlCitirfGGE2WzMeXJ74bo.ef8dkFBXa', 1, NULL, '2016-09-28 10:36:01', '2016-09-28 10:36:01'),
(39, 'Tầng5', 'tang5@gmail.com', '$2y$10$elayyIrxTVGVQVQXoP16XeZ8RTmvg0AcA6/eedKXbpAts4n0fHLpW', 1, 'J7gAWiak0vIA9E1Mvtd2M29AX0xiBTa2KH3MphstGe0TGdu0VzF9Pf1a9e76', '2016-09-28 10:36:14', '2016-09-28 10:40:32'),
(40, 'Phục vụ(test)', 'phucvu@gmail.com', '$2y$10$GgQRXLoh4et86XeFhFSwL.ezajjd1Ia5LAJSo4li/VLIH9tppDQ1.', 1, 'Ldz3IJ5Al3OWhvRnvEnEUqLKrU5EIib3aSDqJsCtKdkZuV0o2t4jJlSVXU4m', '2016-09-28 10:43:42', '2016-09-28 10:46:50'),
(41, 'quanlytang3', 'quanlytang3@gmail.com', '$2y$10$/ss/OIi4ZwzduhfV5hh0/O0UmvMcFTeV81JFZvb6CxqMdTzQPImXu', 1, 'ObIqynHCsIsF0k0wgd2wEwYqEBzQkdxQGryx8Mq2YDb9zTgEDsoOPCl1Na0U', '2016-09-29 01:44:41', '2016-09-29 01:49:07'),
(42, 'QL 4', 'quanlytang4@gmail.com', '$2y$10$bXvHCAzePg6uFYGK8ehX4.JgMCkE7AHFqVGc1oG5v6yumY0BCJfyW', 1, 'w55XDtRl6uG9Vl4gD8w0BKKw4ZSVd5ylb6x9HIG3gutq5G4aLds50Cj1rGtt', '2016-09-29 02:00:23', '2016-09-29 02:12:10'),
(43, 'Phuc vu 1412', 'phucvu1412@gmail.com', '$2y$10$T9JHxT1Vk.D109/1yd0gs.5cpDaTTAnBcPD0G7/9P3.Vq2HrSZ6oe', 1, 'G9m8u6gwSnMclT4bpxmZPSxda5j1icJKqP6m2K2WbphKthotKauakXuki8ZQ', '2016-09-29 02:13:36', '2016-09-29 02:26:25'),
(44, 'Thu ngan 1412', 'thungan1412@gmail.com', '$2y$10$Qe2WsP.uYQrqk1FoWQo7/.6hX6n3Lz4u6Wi0o5lqQc33Ju.k5tUqC', 1, 'zDW06sjU5XHwiyiGQSF4M1hmsFAGglkyNlViBfIyfRTzck7hjXaNxL8fQBbj', '2016-09-29 02:26:07', '2016-09-29 02:33:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `admin_admin_cmt_unique` (`admin_cmt`);

--
-- Indexes for table `assigned_roles`
--
ALTER TABLE `assigned_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assigned_roles_user_id_foreign` (`user_id`),
  ADD KEY `assigned_roles_role_id_foreign` (`role_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`client_id`),
  ADD KEY `client_room_id_foreign` (`room_id`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `history_type_id_foreign` (`type_id`),
  ADD KEY `history_user_id_foreign` (`user_id`);

--
-- Indexes for table `history_types`
--
ALTER TABLE `history_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `listoption`
--
ALTER TABLE `listoption`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `option`
--
ALTER TABLE `option`
  ADD PRIMARY KEY (`id`),
  ADD KEY `option_product_id_foreign` (`product_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_details_id`),
  ADD KEY `order_details1_order_id_foreign` (`order_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_role_permission_id_foreign` (`permission_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `product_category_id_foreign` (`category_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `scheduletime`
--
ALTER TABLE `scheduletime`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `assigned_roles`
--
ALTER TABLE `assigned_roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `client_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;
--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1017;
--
-- AUTO_INCREMENT for table `history_types`
--
ALTER TABLE `history_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `listoption`
--
ALTER TABLE `listoption`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `option`
--
ALTER TABLE `option`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;
--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=626;
--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_details_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=914;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `room_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `scheduletime`
--
ALTER TABLE `scheduletime`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `assigned_roles`
--
ALTER TABLE `assigned_roles`
  ADD CONSTRAINT `assigned_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assigned_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `client_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `room` (`room_id`);

--
-- Constraints for table `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `history_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `history_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `history_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `option`
--
ALTER TABLE `option`
  ADD CONSTRAINT `option_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details1_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`);

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
