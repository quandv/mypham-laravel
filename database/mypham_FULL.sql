-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th8 02, 2017 lúc 07:09 CH
-- Phiên bản máy phục vụ: 10.1.21-MariaDB
-- Phiên bản PHP: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `mypham`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `assigned_roles`
--

CREATE TABLE `assigned_roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `assigned_roles`
--

INSERT INTO `assigned_roles` (`id`, `user_id`, `role_id`) VALUES
(219, 73, 1),
(389, 114, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `category_id` int(10) UNSIGNED NOT NULL,
  `category_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `category_alias` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_image_hover` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_desc` text COLLATE utf8_unicode_ci,
  `category_id_parent` int(11) NOT NULL DEFAULT '0',
  `category_status` tinyint(4) NOT NULL DEFAULT '1',
  `category_type` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `category_alias`, `category_image`, `category_image_hover`, `category_desc`, `category_id_parent`, `category_status`, `category_type`) VALUES
(1, 'Dưỡng da', 'Duong-da', '1475111488.Food-Normal.png', '1475111489.food-active.png', '', 0, 1, 1),
(3, 'Dưỡng tóc', 'Duong-toc', '1475111506.Drink-Normal.png', '1475111507.Drink-Active.png', '', 0, 1, 1),
(6, 'Kem dưỡng da', 'Kem-duong-da', '1474685385.logo.png', '', '', 1, 1, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `client`
--

CREATE TABLE `client` (
  `client_id` int(10) UNSIGNED NOT NULL,
  `client_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `client_ip` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `room_id` int(10) UNSIGNED NOT NULL,
  `chat_type` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `client`
--

INSERT INTO `client` (`client_id`, `client_name`, `client_ip`, `room_id`, `chat_type`) VALUES
(5, 'Máy 1', '192.168.1.20', 3, NULL),
(6, 'Máy 2', '192.168.1.21', 3, NULL),
(7, 'Máy 3', '192.168.1.22', 3, NULL),
(8, 'Máy 4', '192.168.1.23', 3, NULL),
(9, 'Máy 5', '192.168.1.24', 3, NULL),
(10, 'Máy 6', '192.168.1.25', 3, NULL),
(11, 'Máy 7', '192.168.1.26', 3, NULL),
(12, 'Máy 8', '192.168.1.27', 3, NULL),
(13, 'Máy 9', '192.168.1.28', 3, NULL),
(14, 'Máy 10', '192.168.1.29', 3, NULL),
(15, 'Máy 11', '192.168.1.30', 3, NULL),
(16, 'Máy 12', '192.168.1.31', 3, NULL),
(17, 'Máy 13', '192.168.1.32', 3, NULL),
(18, 'Máy 14', '192.168.1.33', 3, NULL),
(19, 'Máy 15', '192.168.1.34', 3, NULL),
(20, 'Máy 16', '192.168.1.35', 3, NULL),
(21, 'Máy 17', '192.168.1.36', 3, NULL),
(22, 'Máy 18', '192.168.1.37', 3, NULL),
(23, 'Máy 19', '192.168.1.38', 3, NULL),
(24, 'Máy 20', '192.168.1.39', 3, NULL),
(25, 'Máy 21', '192.168.1.40', 3, NULL),
(26, 'Máy 22', '192.168.1.41', 3, NULL),
(27, 'Máy 23', '192.168.1.42', 3, NULL),
(28, 'Máy 24', '192.168.1.43', 3, NULL),
(29, 'Máy 25', '192.168.1.44', 3, NULL),
(30, 'Máy 26', '192.168.1.45', 3, NULL),
(31, 'Máy 27', '192.168.1.46', 3, NULL),
(32, 'Máy 28', '192.168.1.47', 3, NULL),
(33, 'Máy 29', '192.168.1.48', 3, NULL),
(34, 'Máy 30', '192.168.1.49', 3, NULL),
(35, 'Máy 31', '192.168.1.50', 4, NULL),
(36, 'Máy 32', '192.168.1.51', 4, NULL),
(37, 'Máy 33', '192.168.1.52', 4, NULL),
(38, 'Máy 34', '192.168.1.53', 4, NULL),
(39, 'Máy 35', '192.168.1.54', 4, NULL),
(40, 'Máy 36', '192.168.1.55', 4, NULL),
(41, 'Máy 37', '192.168.1.56', 4, NULL),
(42, 'Máy 38', '192.168.1.57', 4, NULL),
(43, 'Máy 39', '192.168.1.58', 4, NULL),
(44, 'Máy 40', '192.168.1.59', 4, NULL),
(45, 'Máy 41', '192.168.1.60', 4, NULL),
(46, 'Máy 42', '192.168.1.61', 4, NULL),
(47, 'Máy 43', '192.168.1.62', 4, NULL),
(48, 'Máy 44', '192.168.1.63', 4, NULL),
(49, 'Máy 45', '192.168.1.64', 4, NULL),
(50, 'Máy 46', '192.168.1.65', 4, NULL),
(51, 'Máy 47', '192.168.1.66', 4, NULL),
(52, 'Máy 48', '192.168.1.67', 4, NULL),
(53, 'Máy 49', '192.168.1.68', 4, NULL),
(54, 'Máy 50', '192.168.1.69', 4, NULL),
(55, 'Máy 51', '192.168.1.70', 4, NULL),
(56, 'Máy 52', '192.168.1.71', 4, NULL),
(57, 'Máy 53', '192.168.1.72', 4, NULL),
(58, 'Máy 54', '192.168.1.73', 4, NULL),
(59, 'Máy 55', '192.168.1.74', 4, NULL),
(60, 'Máy 56', '192.168.1.75', 4, NULL),
(61, 'Máy 57', '192.168.1.76', 4, NULL),
(62, 'Máy 58', '192.168.1.77', 4, NULL),
(63, 'Máy 59', '192.168.1.78', 4, NULL),
(64, 'Máy 60', '192.168.1.79', 4, NULL),
(65, 'Máy 61', '192.168.1.80', 5, NULL),
(66, 'Máy 62', '192.168.1.81', 5, NULL),
(67, 'Máy 63', '192.168.1.82', 5, NULL),
(68, 'Máy 64', '192.168.1.83', 5, NULL),
(69, 'Máy 65', '192.168.1.84', 5, NULL),
(70, 'Máy 66', '192.168.1.85', 5, NULL),
(71, 'Máy 67', '192.168.1.86', 5, NULL),
(72, 'Máy 68', '192.168.1.87', 5, NULL),
(73, 'Máy 69', '192.168.1.88', 5, NULL),
(75, 'Máy 71', '192.168.1.90', 5, NULL),
(76, 'Máy 72', '192.168.1.91', 5, NULL),
(77, 'MÁy 73', '192.168.1.92', 5, NULL),
(78, 'Máy 74', '192.168.1.93', 5, NULL),
(79, 'Máy 75', '192.168.1.94', 5, NULL),
(80, 'Máy 76', '192.168.1.95', 5, NULL),
(81, 'Máy 77', '192.168.1.96', 5, NULL),
(82, 'Máy 78', '192.168.1.97', 5, NULL),
(83, 'Máy 79', '192.168.1.98', 5, NULL),
(84, 'Máy 80', '192.168.1.99', 5, NULL),
(85, 'Máy 81', '192.168.1.100', 5, NULL),
(86, 'Máy 82', '192.168.1.101', 5, NULL),
(87, 'Máy 83', '192.168.1.102', 5, NULL),
(88, 'Máy 84', '192.168.1.103', 5, NULL),
(89, 'Máy 85', '192.168.1.104', 5, NULL),
(90, 'Máy 86', '192.168.1.105', 5, NULL),
(91, 'Máy 87', '192.168.1.106', 5, NULL),
(92, 'Máy 88', '192.168.1.107', 5, NULL),
(93, 'Máy 89', '192.168.1.108', 5, NULL),
(94, 'Máy 90', '192.168.1.109', 5, NULL),
(100, 'ĐẦU BẾP', '192.168.1.201', 2, 1),
(104, 'THU NGÂN T5', '192.168.1.195', 5, 1),
(106, 'NGUYỄN VĂN HỢP', '192.168.18.113', 2, 1),
(108, 'SUPER ADMIN', '192.168.50.1', 2, 1),
(110, 'THU NGÂN T4', '192.168.1.204', 4, 1),
(111, 'THU NGÂN TỔNG', '192.168.1.240', 2, 1),
(115, 'Máy 70', '192.168.1.223', 5, NULL),
(117, 'THU NGÂN T3', '192.168.1.205', 3, 1),
(118, 'QUÂN HOME', '192.168.1.11', 2, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `history`
--

CREATE TABLE `history` (
  `id` int(10) UNSIGNED NOT NULL,
  `type_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `entity_id` int(10) UNSIGNED DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `class` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `details_order_id` text COLLATE utf8_unicode_ci NOT NULL,
  `time_process` float NOT NULL,
  `qty_order` int(11) NOT NULL,
  `order_status` tinyint(4) NOT NULL,
  `assets` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `entity_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entity_value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entity_status` tinyint(2) DEFAULT NULL,
  `entity_desc` text COLLATE utf8_unicode_ci,
  `entity_option` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `history`
--

INSERT INTO `history` (`id`, `type_id`, `user_id`, `entity_id`, `icon`, `class`, `text`, `details_order_id`, `time_process`, `qty_order`, `order_status`, `assets`, `created_at`, `updated_at`, `email`, `name`, `entity_name`, `entity_value`, `entity_status`, `entity_desc`, `entity_option`) VALUES
(23311, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 10:46:01', '2016-11-24 10:46:01', 'dev@vgm.company', 'DEV-VGM', ' Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[]'),
(23315, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 10:46:20', '2016-11-24 10:46:20', 'dev@vgm.company', 'DEV-VGM', ' Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[]'),
(23323, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 10:51:36', '2016-11-24 10:51:36', 'dev@vgm.company', 'DEV-VGM', ' Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[{\"option_id\":11,\"option_name\":\"Th\\u00eam 5k\",\"option_price\":5000}]'),
(23324, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 10:51:41', '2016-11-24 10:51:41', 'dev@vgm.company', 'DEV-VGM', ' Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[{\"option_id\":11,\"option_name\":\"Th\\u00eam 5k\",\"option_price\":5000}]'),
(23326, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 10:56:29', '2016-11-24 10:56:29', 'dev@vgm.company', 'DEV-VGM', ' Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[]'),
(23327, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 10:57:06', '2016-11-24 10:57:06', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[]'),
(23329, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 10:59:15', '2016-11-24 10:59:15', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[{\"option_id\":11,\"option_name\":\"Th\\u00eam 5k\",\"option_price\":5000}]'),
(23330, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 10:59:35', '2016-11-24 10:59:35', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[]'),
(23331, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 10:59:39', '2016-11-24 10:59:39', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[]'),
(23332, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:01:18', '2016-11-24 11:01:18', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[{\"option_id\":11,\"option_name\":\"Th\\u00eam 5k\",\"option_price\":5000}]'),
(23333, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:01:24', '2016-11-24 11:01:24', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[{\"option_id\":11,\"option_name\":\"Th\\u00eam 5k\",\"option_price\":5000}]'),
(23334, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:02:09', '2016-11-24 11:02:09', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[{\"option_id\":11,\"option_name\":\"Th\\u00eam 5k\",\"option_price\":5000}]'),
(23340, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:06:05', '2016-11-24 11:06:05', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[]'),
(23341, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:07:00', '2016-11-24 11:07:00', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[]'),
(23343, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:08:23', '2016-11-24 11:08:23', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[]'),
(23344, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:08:38', '2016-11-24 11:08:38', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[{\"option_id\":11,\"option_name\":\"Th\\u00eam 5k\",\"option_price\":5000}]'),
(23345, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:09:11', '2016-11-24 11:09:11', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[{\"option_id\":11,\"option_name\":\"Th\\u00eam 5k\",\"option_price\":5000}]'),
(23346, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:10:41', '2016-11-24 11:10:41', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[]'),
(23347, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:12:00', '2016-11-24 11:12:00', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[]'),
(23349, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:14:20', '2016-11-24 11:14:20', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[]'),
(23350, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:14:55', '2016-11-24 11:14:55', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[]'),
(23355, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:16:48', '2016-11-24 11:16:48', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[]'),
(23356, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:17:14', '2016-11-24 11:17:14', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[]'),
(23357, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:17:45', '2016-11-24 11:17:45', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[]'),
(23358, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:18:00', '2016-11-24 11:18:00', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[]'),
(23359, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:18:13', '2016-11-24 11:18:13', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[]'),
(23360, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:19:33', '2016-11-24 11:19:33', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[]'),
(23363, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:20:31', '2016-11-24 11:20:31', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[]'),
(23364, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:22:12', '2016-11-24 11:22:12', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[]'),
(23365, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:22:26', '2016-11-24 11:22:26', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[]'),
(23366, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:22:38', '2016-11-24 11:22:38', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[{\"option_id\":5,\"option_name\":\"X\\u00fac X\\u00edch\",\"option_price\":10000},{\"option_id\":11,\"option_name\":\"Th\\u00eam 5k\",\"option_price\":5000}]'),
(23367, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:22:50', '2016-11-24 11:22:50', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[]'),
(23371, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:24:25', '2016-11-24 11:24:25', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[]'),
(23372, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:25:24', '2016-11-24 11:25:24', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[]'),
(23373, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:27:06', '2016-11-24 11:27:06', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[{\"option_id\":5,\"option_name\":\"X\\u00fac X\\u00edch\",\"option_price\":10000},{\"option_id\":11,\"option_name\":\"Th\\u00eam 5k\",\"option_price\":5000}]'),
(23374, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:27:12', '2016-11-24 11:27:12', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[{\"option_id\":11,\"option_name\":\"Th\\u00eam 5k\",\"option_price\":5000}]'),
(23375, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:27:20', '2016-11-24 11:27:20', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[{\"option_id\":5,\"option_name\":\"X\\u00fac X\\u00edch\",\"option_price\":10000}]'),
(23376, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:28:06', '2016-11-24 11:28:06', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[]'),
(23377, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:28:51', '2016-11-24 11:28:51', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[]'),
(23378, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:29:25', '2016-11-24 11:29:25', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[]'),
(23379, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:29:48', '2016-11-24 11:29:48', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[]'),
(23380, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:29:52', '2016-11-24 11:29:52', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[]'),
(23381, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:29:59', '2016-11-24 11:29:59', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[]'),
(23382, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:30:46', '2016-11-24 11:30:46', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[]'),
(23383, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:30:53', '2016-11-24 11:30:53', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[]'),
(23386, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:35:59', '2016-11-24 11:35:59', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[]'),
(23387, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:36:30', '2016-11-24 11:36:30', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[]'),
(23390, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:37:16', '2016-11-24 11:37:16', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[]'),
(23391, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:37:27', '2016-11-24 11:37:27', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[]'),
(23392, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:37:39', '2016-11-24 11:37:39', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[{\"option_id\":5,\"option_name\":\"X\\u00fac X\\u00edch\",\"option_price\":10000}]'),
(23397, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:45:50', '2016-11-24 11:45:50', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[{\"option_id\":5,\"option_name\":\"X\\u00fac X\\u00edch\",\"option_price\":10000},{\"option_id\":11,\"option_name\":\"Th\\u00eam 5k\",\"option_price\":5000}]'),
(23398, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:45:54', '2016-11-24 11:45:54', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[]'),
(23399, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:46:52', '2016-11-24 11:46:52', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[]'),
(23400, 4, 73, 10, NULL, NULL, '', '', 0, 0, 0, NULL, '2016-11-24 11:49:23', '2016-11-24 11:49:23', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Siêu Cấp Đặc Biệt', '25000', 1, NULL, '[]'),
(29089, 1, 73, NULL, NULL, NULL, '<strong> DEV-VGM( dev@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>16084(0 phút) ,</strong> sang <span class=\"label label-danger\">Đã hủy</span>', '{\"16084\":{\"order_id\":16084,\"order_status\":\"1\",\"created_at\":\"2016-12-05 09:15:06\",\"room_id\":\"3\",\"status_changed\":\"4\",\"timestamp_process\":39}}', 39, 1, 4, NULL, '2016-12-05 02:15:45', '2016-12-05 02:15:45', 'dev@vgm.company', 'DEV-VGM', NULL, NULL, NULL, NULL, NULL),
(68107, 4, 73, 48, NULL, NULL, '', '', 0, 0, 0, NULL, '2017-02-03 08:50:57', '2017-02-03 08:50:57', 'dev@vgm.company', 'DEV-VGM', 'Bánh Mỳ Xá Xíu - Pate', '20000', 1, NULL, '[{\"option_id\":3,\"option_name\":\"Tr\\u1ee9ng \\u1ed0p La\",\"option_price\":6000},{\"option_id\":5,\"option_name\":\"X\\u00fac X\\u00edch\",\"option_price\":10000}]'),
(77375, 1, 73, NULL, NULL, NULL, '<strong> DEV-VGM( dev@vgm.company )</strong> thay đổi trạng thái đơn hàng  <strong>41218(0 phút) ,</strong> sang <span class=\"label label-success\">Đã thu tiền</span>', '{\"41218\":{\"order_id\":\"41218\",\"order_status\":\"1\",\"created_at\":\"2017-02-18 19:38:09\",\"room_id\":\"2\",\"status_changed\":2,\"timestamp_process\":27}}', 27, 1, 2, NULL, '2017-02-18 12:38:36', '2017-02-18 12:38:36', 'dev@vgm.company', 'DEV-VGM', NULL, NULL, NULL, NULL, NULL),
(77376, 4, 73, 75, NULL, NULL, '', '', 0, 0, 0, NULL, '2017-02-22 14:09:08', '2017-02-22 14:09:08', 'dev@vgm.company', 'DEV-VGM', 'vichy', '111111', 1, NULL, '[]'),
(77377, 2, 73, NULL, NULL, NULL, '{\"74\":\"vichy d\\u01b0\\u1ee1ng da\",\"75\":\"B\\u1ed9 t\\u1ea9y trang Apple Juicy Special Cleansing Kit Inn\",\"76\":\"Kem d\\u01b0\\u1ee1ng \\u1ea9m ban \\u0111\\u00eam\"}', '', 0, 0, 0, NULL, '2017-02-26 05:41:43', '2017-02-26 05:41:43', 'dev@vgm.company', 'DEV-VGM', NULL, NULL, NULL, NULL, NULL),
(77378, 2, 73, NULL, NULL, NULL, '{\"74\":\"vichy d\\u01b0\\u1ee1ng da\",\"75\":\"B\\u1ed9 t\\u1ea9y trang Apple Juicy Special Cleansing Kit Inn\",\"76\":\"Kem d\\u01b0\\u1ee1ng \\u1ea9m ban \\u0111\\u00eam\"}', '', 0, 0, 1, NULL, '2017-02-26 05:41:50', '2017-02-26 05:41:50', 'dev@vgm.company', 'DEV-VGM', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `history_details`
--

CREATE TABLE `history_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `history_id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `order_status` tinyint(4) NOT NULL,
  `room_id` tinyint(4) NOT NULL,
  `status_changed` tinyint(4) NOT NULL,
  `timestamp_process` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `history_details`
--

INSERT INTO `history_details` (`id`, `history_id`, `order_id`, `order_status`, `room_id`, `status_changed`, `timestamp_process`, `created_at`, `updated_at`) VALUES
(68634, 77375, 41218, 1, 2, 2, 27, '2017-02-18 12:38:09', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `history_store`
--

CREATE TABLE `history_store` (
  `id` int(10) UNSIGNED NOT NULL,
  `type_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `entity_id` int(11) UNSIGNED DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `class` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `text` text COLLATE utf8_unicode_ci,
  `content` text COLLATE utf8_unicode_ci,
  `assets` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `history_store`
--

INSERT INTO `history_store` (`id`, `type_id`, `user_id`, `email`, `name`, `entity_id`, `icon`, `class`, `text`, `content`, `assets`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'hoangkhoik5@gmail.com', 'hoangkhoi', 18, NULL, NULL, '', '[{\"hn_name\":\"g\\u1ea1o\",\"hn_spt_id\":\"1\",\"hn_price\":\"10\",\"hn_quantity\":\"10\",\"hn_time_expiry\":\"2016-10-14\",\"hn_hdn_id\":18,\"hn_status\":1}]', NULL, '2016-10-14 07:54:49', '2016-10-14 07:54:49'),
(2, 1, 1, 'hoangkhoik5@gmail.com', 'hoangkhoi', 19, NULL, NULL, '', '[{\"hn_name\":\"g\\u1ea1o\",\"hn_spt_id\":\"1\",\"hn_price\":\"10\",\"hn_quantity\":\"10\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":19,\"hn_status\":1}]', NULL, '2016-10-14 08:31:05', '2016-10-14 08:31:05'),
(3, 1, 1, 'hoangkhoik5@gmail.com', 'hoangkhoi', 20, NULL, NULL, '', '[{\"hn_name\":\"g\\u1ea1o\",\"hn_spt_id\":\"1\",\"hn_price\":\"10\",\"hn_quantity\":\"10\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":20,\"hn_status\":1}]', NULL, '2016-10-14 08:31:10', '2016-10-14 08:31:10'),
(4, 1, 1, 'hoangkhoik5@gmail.com', 'hoangkhoi', 21, NULL, NULL, '', '[{\"hn_name\":\"g\\u1ea1o\",\"hn_spt_id\":\"1\",\"hn_price\":\"10\",\"hn_quantity\":\"10\",\"hn_time_expiry\":\"2016-10-14\",\"hn_hdn_id\":21,\"hn_status\":1}]', NULL, '2016-10-14 09:06:25', '2016-10-14 09:06:25'),
(5, 1, 21, 'thungant3@gmail.com', 'Thu ngân tầng 3', 22, NULL, NULL, '', '[{\"hn_name\":\"21321\",\"hn_spt_id\":\"4\",\"hn_price\":\"10\",\"hn_quantity\":\"10\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":22,\"hn_status\":1},{\"hn_name\":\"g\\u1ea1o\",\"hn_spt_id\":\"1\",\"hn_price\":\"10\",\"hn_quantity\":\"10\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":22,\"hn_status\":1}]', NULL, '2016-10-14 09:25:12', '2016-10-14 09:25:12'),
(6, 2, 21, 'thungant3@gmail.com', 'Thu ngân tầng 3', 22, NULL, NULL, '', '[{\"hn_name\":\"21321\",\"hn_spt_id\":4,\"hn_price\":\"10\",\"hn_quantity\":\"10\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":\"22\",\"hn_status\":1},{\"hn_name\":\"g\\u1ea1o\",\"hn_spt_id\":1,\"hn_price\":\"10\",\"hn_quantity\":\"10\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":\"22\",\"hn_status\":1}]', NULL, '2016-10-14 09:59:37', '2016-10-14 09:59:37'),
(7, 2, 21, 'thungant3@gmail.com', 'Thu ngân tầng 3', 21, NULL, NULL, '', '[{\"hn_name\":\"g\\u1ea1o\",\"hn_spt_id\":1,\"hn_price\":\"10\",\"hn_quantity\":\"101\",\"hn_time_expiry\":\"2016-10-14\",\"hn_hdn_id\":\"21\",\"hn_status\":1}]', NULL, '2016-10-14 10:00:25', '2016-10-14 10:00:25'),
(8, 1, 68, 'hoangkhoik5@gmail.com', 'hoangkhoi', 16, NULL, NULL, '', '[{\"hn_name\":\"g\\u1ea1o\",\"hn_spt_id\":\"1\",\"hn_price\":\"10\",\"hn_quantity\":\"10\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":16,\"hn_status\":1},{\"hn_name\":\"11222\",\"hn_spt_id\":\"5\",\"hn_price\":\"10\",\"hn_quantity\":\"10\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":16,\"hn_status\":1}]', NULL, '2016-10-14 10:15:35', '2016-10-14 10:15:35'),
(9, 1, 68, 'hoangkhoik5@gmail.com', 'hoangkhoi', 17, NULL, NULL, '', '[{\"hn_name\":\"g\\u1ea1o\",\"hn_spt_id\":\"1\",\"hn_price\":\"100000\",\"hn_quantity\":\"12\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":17,\"hn_status\":1}]', NULL, '2016-10-14 10:23:17', '2016-10-14 10:23:17'),
(10, 2, 68, 'hoangkhoik5@gmail.com', 'hoangkhoi', 17, NULL, NULL, '', '[{\"hn_name\":\"g\\u1ea1o\",\"hn_spt_id\":1,\"hn_price\":\"100000\",\"hn_quantity\":\"1\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":\"17\",\"hn_status\":1}]', NULL, '2016-10-14 10:23:46', '2016-10-14 10:23:46'),
(11, 1, 1, 'admin@vgm.company', 'Admin', 18, NULL, NULL, '', '[{\"hn_name\":\"G\\u1ea1o t\\u00e1m th\\u01a1m\",\"hn_spt_id\":\"1\",\"hn_price\":\"1000000\",\"hn_quantity\":\"100\",\"hn_time_expiry\":\"2016-10-31\",\"hn_hdn_id\":18,\"hn_status\":1},{\"hn_name\":\"Stink \\u0111\\u1ecf\",\"hn_spt_id\":\"5\",\"hn_price\":\"800000\",\"hn_quantity\":\"200\",\"hn_time_expiry\":\"2016-10-31\",\"hn_hdn_id\":18,\"hn_status\":1},{\"hn_name\":\"Stink V\\u00e0ng\",\"hn_spt_id\":\"6\",\"hn_price\":\"800000\",\"hn_quantity\":\"200\",\"hn_time_expiry\":\"2016-10-31\",\"hn_hdn_id\":18,\"hn_status\":1},{\"hn_name\":\"B\\u00f2 kh\\u00f4\",\"hn_spt_id\":\"13\",\"hn_price\":\"200000\",\"hn_quantity\":\"20\",\"hn_time_expiry\":\"2016-10-31\",\"hn_hdn_id\":18,\"hn_status\":1}]', NULL, '2016-10-18 10:31:53', '2016-10-18 10:31:53'),
(12, 2, 1, 'admin@vgm.company', 'Admin', 18, NULL, NULL, '', '[{\"hn_name\":\"G\\u1ea1o t\\u00e1m th\\u01a1m\",\"hn_spt_id\":1,\"hn_price\":\"1000000\",\"hn_quantity\":\"100\",\"hn_time_expiry\":\"2016-10-31\",\"hn_hdn_id\":\"18\",\"hn_status\":1},{\"hn_name\":\"Stink \\u0111\\u1ecf\",\"hn_spt_id\":5,\"hn_price\":\"800000\",\"hn_quantity\":\"200\",\"hn_time_expiry\":\"2016-10-31\",\"hn_hdn_id\":\"18\",\"hn_status\":1},{\"hn_name\":\"Stink V\\u00e0ng\",\"hn_spt_id\":6,\"hn_price\":\"800000\",\"hn_quantity\":\"200\",\"hn_time_expiry\":\"2016-10-31\",\"hn_hdn_id\":\"18\",\"hn_status\":1},{\"hn_name\":\"B\\u00f2 kh\\u00f4\",\"hn_spt_id\":13,\"hn_price\":\"200000\",\"hn_quantity\":\"20\",\"hn_time_expiry\":\"2016-10-31\",\"hn_hdn_id\":\"18\",\"hn_status\":1},{\"hn_name\":\"\\u0110\\u00f9i g\\u00e0\",\"hn_spt_id\":\"14\",\"hn_price\":\"100000\",\"hn_quantity\":\"20\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":\"18\",\"hn_status\":1}]', NULL, '2016-10-18 10:37:15', '2016-10-18 10:37:15'),
(13, 2, 1, 'admin@vgm.company', 'Admin', 18, NULL, NULL, '', '[{\"hn_name\":\"G\\u1ea1o t\\u00e1m th\\u01a1m\",\"hn_spt_id\":1,\"hn_price\":\"1000000\",\"hn_quantity\":\"100\",\"hn_time_expiry\":\"2016-10-31\",\"hn_hdn_id\":\"18\",\"hn_status\":1},{\"hn_name\":\"Stink \\u0111\\u1ecf\",\"hn_spt_id\":5,\"hn_price\":\"800000\",\"hn_quantity\":\"200\",\"hn_time_expiry\":\"2016-10-31\",\"hn_hdn_id\":\"18\",\"hn_status\":1},{\"hn_name\":\"Stink V\\u00e0ng\",\"hn_spt_id\":6,\"hn_price\":\"800000\",\"hn_quantity\":\"200\",\"hn_time_expiry\":\"2016-10-31\",\"hn_hdn_id\":\"18\",\"hn_status\":1},{\"hn_name\":\"B\\u00f2 kh\\u00f4\",\"hn_spt_id\":13,\"hn_price\":\"200000\",\"hn_quantity\":\"20\",\"hn_time_expiry\":\"2016-10-31\",\"hn_hdn_id\":\"18\",\"hn_status\":1},{\"hn_name\":\"\\u0110\\u00f9i g\\u00e0\",\"hn_spt_id\":\"14\",\"hn_price\":\"100000\",\"hn_quantity\":\"20\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":\"18\",\"hn_status\":1}]', NULL, '2016-10-18 10:37:15', '2016-10-18 10:37:15'),
(14, 2, 1, 'admin@vgm.company', 'Admin', 18, NULL, NULL, '', '[{\"hn_name\":\"G\\u1ea1o t\\u00e1m th\\u01a1m\",\"hn_spt_id\":1,\"hn_price\":\"1000000\",\"hn_quantity\":\"100\",\"hn_time_expiry\":\"2016-10-31\",\"hn_hdn_id\":\"18\",\"hn_status\":1},{\"hn_name\":\"Stink \\u0111\\u1ecf\",\"hn_spt_id\":5,\"hn_price\":\"800000\",\"hn_quantity\":\"200\",\"hn_time_expiry\":\"2016-10-31\",\"hn_hdn_id\":\"18\",\"hn_status\":1},{\"hn_name\":\"Stink V\\u00e0ng\",\"hn_spt_id\":6,\"hn_price\":\"800000\",\"hn_quantity\":\"200\",\"hn_time_expiry\":\"2016-10-31\",\"hn_hdn_id\":\"18\",\"hn_status\":1},{\"hn_name\":\"B\\u00f2 kh\\u00f4\",\"hn_spt_id\":13,\"hn_price\":\"200000\",\"hn_quantity\":\"20\",\"hn_time_expiry\":\"2016-10-31\",\"hn_hdn_id\":\"18\",\"hn_status\":1},{\"hn_name\":\"\\u0110\\u00f9i g\\u00e0\",\"hn_spt_id\":14,\"hn_price\":\"100000\",\"hn_quantity\":\"20\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":\"18\",\"hn_status\":1}]', NULL, '2016-10-18 10:37:41', '2016-10-18 10:37:41'),
(15, 2, 1, 'admin@vgm.company', 'Admin', 18, NULL, NULL, '', '[{\"hn_name\":\"G\\u1ea1o t\\u00e1m th\\u01a1m\",\"hn_spt_id\":1,\"hn_price\":\"1000000\",\"hn_quantity\":\"100\",\"hn_time_expiry\":\"2016-10-31\",\"hn_hdn_id\":\"18\",\"hn_status\":1},{\"hn_name\":\"Stink \\u0111\\u1ecf\",\"hn_spt_id\":5,\"hn_price\":\"800000\",\"hn_quantity\":\"200\",\"hn_time_expiry\":\"2016-10-31\",\"hn_hdn_id\":\"18\",\"hn_status\":1},{\"hn_name\":\"Stink V\\u00e0ng\",\"hn_spt_id\":6,\"hn_price\":\"800000\",\"hn_quantity\":\"200\",\"hn_time_expiry\":\"2016-10-31\",\"hn_hdn_id\":\"18\",\"hn_status\":1},{\"hn_name\":\"B\\u00f2 kh\\u00f4\",\"hn_spt_id\":13,\"hn_price\":\"200000\",\"hn_quantity\":\"20\",\"hn_time_expiry\":\"2016-10-31\",\"hn_hdn_id\":\"18\",\"hn_status\":1},{\"hn_name\":\"\\u0110\\u00f9i g\\u00e0\",\"hn_spt_id\":14,\"hn_price\":\"100000\",\"hn_quantity\":\"20\",\"hn_time_expiry\":\"2016-10-31\",\"hn_hdn_id\":\"18\",\"hn_status\":1},{\"hn_name\":\"Moutain Dew\",\"hn_spt_id\":\"7\",\"hn_price\":\"800000\",\"hn_quantity\":\"200\",\"hn_time_expiry\":\"2016-10-19\",\"hn_hdn_id\":\"18\",\"hn_status\":1}]', NULL, '2016-10-18 10:38:13', '2016-10-18 10:38:13'),
(16, 2, 1, 'admin@vgm.company', 'Admin', 18, NULL, NULL, '', '[{\"hn_name\":\"G\\u1ea1o t\\u00e1m th\\u01a1m\",\"hn_spt_id\":1,\"hn_price\":\"1000000\",\"hn_quantity\":\"200\",\"hn_time_expiry\":\"2016-10-31\",\"hn_hdn_id\":\"18\",\"hn_status\":1},{\"hn_name\":\"Stink \\u0111\\u1ecf\",\"hn_spt_id\":5,\"hn_price\":\"800000\",\"hn_quantity\":\"200\",\"hn_time_expiry\":\"2016-10-31\",\"hn_hdn_id\":\"18\",\"hn_status\":1},{\"hn_name\":\"Stink V\\u00e0ng\",\"hn_spt_id\":6,\"hn_price\":\"800000\",\"hn_quantity\":\"200\",\"hn_time_expiry\":\"2016-10-31\",\"hn_hdn_id\":\"18\",\"hn_status\":1},{\"hn_name\":\"B\\u00f2 kh\\u00f4\",\"hn_spt_id\":13,\"hn_price\":\"200000\",\"hn_quantity\":\"20\",\"hn_time_expiry\":\"2016-10-31\",\"hn_hdn_id\":\"18\",\"hn_status\":1},{\"hn_name\":\"\\u0110\\u00f9i g\\u00e0\",\"hn_spt_id\":14,\"hn_price\":\"100000\",\"hn_quantity\":\"20\",\"hn_time_expiry\":\"2016-10-31\",\"hn_hdn_id\":\"18\",\"hn_status\":1},{\"hn_name\":\"Moutain Dew\",\"hn_spt_id\":7,\"hn_price\":\"800000\",\"hn_quantity\":\"200\",\"hn_time_expiry\":\"2016-10-19\",\"hn_hdn_id\":\"18\",\"hn_status\":1}]', NULL, '2016-10-19 02:55:09', '2016-10-19 02:55:09'),
(17, 1, 1, 'admin@vgm.company', 'Admin', 19, NULL, NULL, '', '[{\"hn_name\":\"G\\u1ea1o t\\u00e1m th\\u01a1m\",\"hn_spt_id\":\"1\",\"hn_price\":\"100000\",\"hn_quantity\":\"100\",\"hn_time_expiry\":\"2016-10-24\",\"hn_hdn_id\":19,\"hn_status\":1}]', NULL, '2016-10-19 02:55:58', '2016-10-19 02:55:58'),
(18, 2, 1, 'admin@vgm.company', 'Admin', 19, NULL, NULL, '', '[{\"hn_name\":\"G\\u1ea1o t\\u00e1m th\\u01a1m\",\"hn_spt_id\":1,\"hn_price\":\"100000\",\"hn_quantity\":\"200\",\"hn_time_expiry\":\"2016-10-24\",\"hn_hdn_id\":\"19\",\"hn_status\":1}]', NULL, '2016-10-19 02:59:44', '2016-10-19 02:59:44'),
(19, 1, 1, 'admin@vgm.company', 'Admin', 20, NULL, NULL, '', '[{\"hn_name\":\"\\u0110\\u00f9i g\\u00e0\",\"hn_spt_id\":\"14\",\"hn_price\":\"200000\",\"hn_quantity\":\"100\",\"hn_time_expiry\":\"2016-10-31\",\"hn_hdn_id\":20,\"hn_status\":1}]', NULL, '2016-10-19 03:24:59', '2016-10-19 03:24:59'),
(20, 1, 1, 'admin@vgm.company', 'Admin', 21, NULL, NULL, '', '[{\"hn_name\":\"Stink \\u0111\\u1ecf\",\"hn_spt_id\":\"5\",\"hn_price\":\"1000000\",\"hn_quantity\":\"100\",\"hn_time_expiry\":\"2016-10-20\",\"hn_hdn_id\":21,\"hn_status\":1},{\"hn_name\":\"Stink V\\u00e0ng\",\"hn_spt_id\":\"6\",\"hn_price\":\"1000000\",\"hn_quantity\":\"100\",\"hn_time_expiry\":\"2016-10-20\",\"hn_hdn_id\":21,\"hn_status\":1},{\"hn_name\":\"Moutain Dew\",\"hn_spt_id\":\"7\",\"hn_price\":\"1000000\",\"hn_quantity\":\"100\",\"hn_time_expiry\":\"2016-10-28\",\"hn_hdn_id\":21,\"hn_status\":1},{\"hn_name\":\"Ice \\u0110\\u00e0o\",\"hn_spt_id\":\"8\",\"hn_price\":\"1000000\",\"hn_quantity\":\"100\",\"hn_time_expiry\":\"2016-10-26\",\"hn_hdn_id\":21,\"hn_status\":1}]', NULL, '2016-10-19 03:32:51', '2016-10-19 03:32:51'),
(21, 1, 72, 'hop.nguyen@vgm.company', 'Nguyễn Văn Hợp', 22, NULL, NULL, '', '[{\"hn_name\":\"G\\u1ea1o t\\u00e1m th\\u01a1m\",\"hn_spt_id\":\"1\",\"hn_price\":\"1000000\",\"hn_quantity\":\"100\",\"hn_time_expiry\":\"2016-10-30\",\"hn_hdn_id\":22,\"hn_status\":1},{\"hn_name\":\"\\u0110\\u00f9i g\\u00e0\",\"hn_spt_id\":\"14\",\"hn_price\":\"1000000\",\"hn_quantity\":\"100\",\"hn_time_expiry\":\"2016-10-30\",\"hn_hdn_id\":22,\"hn_status\":1},{\"hn_name\":\"Rau c\\u1ea3i\",\"hn_spt_id\":\"15\",\"hn_price\":\"1000000\",\"hn_quantity\":\"100\",\"hn_time_expiry\":\"2016-10-30\",\"hn_hdn_id\":22,\"hn_status\":1},{\"hn_name\":\"Rau m\\u00f9i\",\"hn_spt_id\":\"16\",\"hn_price\":\"1000000\",\"hn_quantity\":\"100\",\"hn_time_expiry\":\"2016-10-30\",\"hn_hdn_id\":22,\"hn_status\":1}]', NULL, '2016-10-20 02:56:07', '2016-10-20 02:56:07'),
(22, 1, 72, 'hop.nguyen@vgm.company', 'Nguyễn Văn Hợp', 23, NULL, NULL, '', '[{\"hn_name\":\"B\\u00f2 kh\\u00f4\",\"hn_spt_id\":\"13\",\"hn_price\":\"100000\",\"hn_quantity\":\"20\",\"hn_time_expiry\":\"2016-10-30\",\"hn_hdn_id\":23,\"hn_status\":1}]', NULL, '2016-10-20 03:01:31', '2016-10-20 03:01:31'),
(23, 1, 72, 'hop.nguyen@vgm.company', 'Nguyễn Văn Hợp', 24, NULL, NULL, '', '[{\"hn_name\":\"B\\u00f2 kh\\u00f4\",\"hn_spt_id\":\"13\",\"hn_price\":\"1000000\",\"hn_quantity\":\"20\",\"hn_time_expiry\":\"2016-10-30\",\"hn_hdn_id\":24,\"hn_status\":1}]', NULL, '2016-10-20 03:03:08', '2016-10-20 03:03:08'),
(24, 1, 72, 'hop.nguyen@vgm.company', 'Nguyễn Văn Hợp', 25, NULL, NULL, '', '[{\"hn_name\":\"B\\u00f2 kh\\u00f4\",\"hn_spt_id\":\"13\",\"hn_price\":\"100000\",\"hn_quantity\":\"20\",\"hn_time_expiry\":\"2016-10-30\",\"hn_hdn_id\":25,\"hn_status\":1}]', NULL, '2016-10-20 03:05:11', '2016-10-20 03:05:11'),
(25, 1, 72, 'hop.nguyen@vgm.company', 'Nguyễn Văn Hợp', 26, NULL, NULL, '', '[{\"hn_name\":\"Revive\",\"hn_spt_id\":\"12\",\"hn_price\":\"1000000\",\"hn_quantity\":\"100\",\"hn_time_expiry\":\"2016-10-30\",\"hn_hdn_id\":26,\"hn_status\":1}]', NULL, '2016-10-20 03:18:47', '2016-10-20 03:18:47'),
(26, 1, 72, 'hop.nguyen@vgm.company', 'Nguyễn Văn Hợp', 27, NULL, NULL, '', '[{\"hn_name\":\"Tr\\u1ee9ng g\\u00e0\",\"hn_spt_id\":\"21\",\"hn_price\":\"100000\",\"hn_quantity\":\"100\",\"hn_time_expiry\":\"2016-10-30\",\"hn_hdn_id\":27,\"hn_status\":1}]', NULL, '2016-10-20 03:40:09', '2016-10-20 03:40:09'),
(27, 1, 72, 'hop.nguyen@vgm.company', 'Nguyễn Văn Hợp', 28, NULL, NULL, '', '[{\"hn_name\":\"7 Up\",\"hn_spt_id\":\"9\",\"hn_price\":\"1000000\",\"hn_quantity\":\"0.1\",\"hn_time_expiry\":\"2016-10-25\",\"hn_hdn_id\":28,\"hn_status\":1}]', NULL, '2016-10-20 08:29:48', '2016-10-20 08:29:48'),
(28, 2, 72, 'hop.nguyen@vgm.company', 'Nguyễn Văn Hợp', 28, NULL, NULL, '', '[{\"hn_name\":\"7 Up\",\"hn_spt_id\":9,\"hn_price\":\"1000000\",\"hn_quantity\":\"100\",\"hn_time_expiry\":\"2016-10-25\",\"hn_hdn_id\":\"28\",\"hn_status\":1}]', NULL, '2016-10-20 08:32:56', '2016-10-20 08:32:56'),
(29, 1, 1, 'admin@vgm.company', 'Admin', 29, NULL, NULL, '', '[{\"hn_name\":\"G\\u1ea1o t\\u00e1m th\\u01a1m\",\"hn_spt_id\":\"1\",\"hn_price\":\"1\",\"hn_quantity\":\"2\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":29,\"hn_status\":1},{\"hn_name\":\"Stink \\u0111\\u1ecf\",\"hn_spt_id\":\"5\",\"hn_price\":\"1\",\"hn_quantity\":\"1\",\"hn_time_expiry\":\"2016-10-11\",\"hn_hdn_id\":29,\"hn_status\":1},{\"hn_name\":\"Stink V\\u00e0ng\",\"hn_spt_id\":\"6\",\"hn_price\":\"1\",\"hn_quantity\":\"12\",\"hn_time_expiry\":\"2016-10-04\",\"hn_hdn_id\":29,\"hn_status\":1}]', NULL, '2016-10-22 04:30:05', '2016-10-22 04:30:05'),
(30, 2, 1, 'admin@vgm.company', 'Admin', 28, NULL, NULL, '', '[{\"hn_name\":\"7 Up\",\"hn_spt_id\":9,\"hn_price\":\"1000000\",\"hn_quantity\":\"100\",\"hn_time_expiry\":\"2016-10-25\",\"hn_hdn_id\":\"28\",\"hn_status\":1},{\"hn_name\":\"Stink V\\u00e0ng\",\"hn_spt_id\":\"6\",\"hn_price\":\"1\",\"hn_quantity\":\"1\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":\"28\",\"hn_status\":1}]', NULL, '2016-10-22 04:36:24', '2016-10-22 04:36:24'),
(31, 2, 1, 'admin@vgm.company', 'Admin', 29, NULL, NULL, '', '[{\"hn_name\":\"Moutain Dew\",\"hn_spt_id\":\"7\",\"hn_price\":\"1\",\"hn_quantity\":\"1\",\"hn_time_expiry\":\"2016-10-22\",\"hn_hdn_id\":\"29\",\"hn_status\":1},{\"hn_name\":\"G\\u1ea1o t\\u00e1m th\\u01a1m\",\"hn_spt_id\":\"1\",\"hn_price\":\"1000000\",\"hn_quantity\":\"100\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":\"29\",\"hn_status\":1}]', NULL, '2016-10-22 04:36:45', '2016-10-22 04:36:45'),
(32, 2, 1, 'admin@vgm.company', 'Admin', 29, NULL, NULL, '', '[{\"hn_name\":\"Moutain Dew\",\"hn_spt_id\":7,\"hn_price\":\"1\",\"hn_quantity\":\"1\",\"hn_time_expiry\":\"2016-10-22\",\"hn_hdn_id\":\"29\",\"hn_status\":1},{\"hn_name\":\"Stink V\\u00e0ng\",\"hn_spt_id\":\"6\",\"hn_price\":\"1\",\"hn_quantity\":\"1\",\"hn_time_expiry\":\"2016-10-25\",\"hn_hdn_id\":\"29\",\"hn_status\":1},{\"hn_name\":\"G\\u1ea1o t\\u00e1m th\\u01a1m\",\"hn_spt_id\":1,\"hn_price\":\"1000000\",\"hn_quantity\":\"100\",\"hn_time_expiry\":\"2016-10-31\",\"hn_hdn_id\":\"29\",\"hn_status\":1},{\"hn_name\":\"Stink \\u0111\\u1ecf\",\"hn_spt_id\":\"5\",\"hn_price\":\"1\",\"hn_quantity\":\"1\",\"hn_time_expiry\":\"2016-10-05\",\"hn_hdn_id\":\"29\",\"hn_status\":1}]', NULL, '2016-10-22 04:38:13', '2016-10-22 04:38:13'),
(33, 1, 1, 'admin@vgm.company', 'Admin', 30, NULL, NULL, '', '[{\"hn_name\":\"G\\u1ea1o t\\u00e1m th\\u01a1m\",\"hn_spt_id\":\"1\",\"hn_price\":\"1110\",\"hn_quantity\":\"1110\",\"hn_time_expiry\":\"2016-10-25\",\"hn_hdn_id\":30,\"hn_status\":1}]', NULL, '2016-10-24 04:01:16', '2016-10-24 04:01:16'),
(34, 2, 1, 'admin@vgm.company', 'Admin', 30, NULL, NULL, '', '[{\"hn_name\":\"G\\u1ea1o t\\u00e1m th\\u01a1m\",\"hn_spt_id\":1,\"hn_price\":\"1110\",\"hn_quantity\":\"1110\",\"hn_time_expiry\":\"2016-10-31\",\"hn_hdn_id\":\"30\",\"hn_status\":1}]', NULL, '2016-10-24 04:01:27', '2016-10-24 04:01:27'),
(35, 1, 71, 'hop.nguyen@vgm.company', 'Nguyễn Văn Hợp', 31, NULL, NULL, '', '[{\"hn_name\":\"Th\\u1ecbt th\\u0103n b\\u00f2\",\"hn_spt_id\":\"29\",\"hn_price\":\"750.000\",\"hn_quantity\":\"3\",\"hn_time_expiry\":\"2016-11-08\",\"hn_hdn_id\":31,\"hn_status\":1}]', NULL, '2016-11-05 02:03:46', '2016-11-05 02:03:46'),
(36, 1, 81, 'hoai.nguyen@vgm.company', 'Hoài Mít', 32, NULL, NULL, '', '[{\"hn_name\":\"Sting v\\u00e0ng\",\"hn_spt_id\":\"55\",\"hn_price\":\"0\",\"hn_quantity\":\"601\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":32,\"hn_status\":1},{\"hn_name\":\"Mowntain Dew\",\"hn_spt_id\":\"56\",\"hn_price\":\"0\",\"hn_quantity\":\"599\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":32,\"hn_status\":1},{\"hn_name\":\"Revive\",\"hn_spt_id\":\"58\",\"hn_price\":\"0\",\"hn_quantity\":\"641\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":32,\"hn_status\":1},{\"hn_name\":\"Pepsi\",\"hn_spt_id\":\"59\",\"hn_price\":\"0\",\"hn_quantity\":\"602\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":32,\"hn_status\":1},{\"hn_name\":\"Ice \\u0111\\u00e0o\",\"hn_spt_id\":\"60\",\"hn_price\":\"0\",\"hn_quantity\":\"581\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":32,\"hn_status\":1},{\"hn_name\":\"B\\u00f2 h\\u00fac\",\"hn_spt_id\":\"61\",\"hn_price\":\"0\",\"hn_quantity\":\"589\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":32,\"hn_status\":1},{\"hn_name\":\"Twister\",\"hn_spt_id\":\"62\",\"hn_price\":\"0\",\"hn_quantity\":\"610\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":32,\"hn_status\":1},{\"hn_name\":\"7up\",\"hn_spt_id\":\"79\",\"hn_price\":\"0\",\"hn_quantity\":\"610\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":32,\"hn_status\":1}]', NULL, '2016-11-23 10:19:52', '2016-11-23 10:19:52'),
(37, 2, 81, 'hoai.nguyen@vgm.company', 'Hoài Mít', 32, NULL, NULL, '', '[{\"hn_name\":\"Sting v\\u00e0ng\",\"hn_spt_id\":55,\"hn_price\":\"0\",\"hn_quantity\":\"601\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":\"32\",\"hn_status\":1},{\"hn_name\":\"Mowntain Dew\",\"hn_spt_id\":56,\"hn_price\":\"0\",\"hn_quantity\":\"599\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":\"32\",\"hn_status\":1},{\"hn_name\":\"Revive\",\"hn_spt_id\":58,\"hn_price\":\"0\",\"hn_quantity\":\"641\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":\"32\",\"hn_status\":1},{\"hn_name\":\"Pepsi\",\"hn_spt_id\":59,\"hn_price\":\"0\",\"hn_quantity\":\"602\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":\"32\",\"hn_status\":1},{\"hn_name\":\"Ice \\u0111\\u00e0o\",\"hn_spt_id\":60,\"hn_price\":\"0\",\"hn_quantity\":\"581\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":\"32\",\"hn_status\":1},{\"hn_name\":\"B\\u00f2 h\\u00fac\",\"hn_spt_id\":61,\"hn_price\":\"0\",\"hn_quantity\":\"589\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":\"32\",\"hn_status\":1},{\"hn_name\":\"Twister\",\"hn_spt_id\":62,\"hn_price\":\"0\",\"hn_quantity\":\"610\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":\"32\",\"hn_status\":1},{\"hn_name\":\"7up\",\"hn_spt_id\":79,\"hn_price\":\"0\",\"hn_quantity\":\"610\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":\"32\",\"hn_status\":1},{\"hn_name\":\"Sting \\u0111\\u1ecf\",\"hn_spt_id\":\"54\",\"hn_price\":\"0\",\"hn_quantity\":\"583\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":\"32\",\"hn_status\":1}]', NULL, '2016-11-23 10:25:30', '2016-11-23 10:25:30'),
(38, 2, 81, 'hoai.nguyen@vgm.company', 'Hoài Mít', 32, NULL, NULL, '', '[{\"hn_name\":\"Sting v\\u00e0ng\",\"hn_spt_id\":55,\"hn_price\":\"0\",\"hn_quantity\":\"601\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":\"32\",\"hn_status\":1},{\"hn_name\":\"Mowntain Dew\",\"hn_spt_id\":56,\"hn_price\":\"0\",\"hn_quantity\":\"599\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":\"32\",\"hn_status\":1},{\"hn_name\":\"Revive\",\"hn_spt_id\":58,\"hn_price\":\"0\",\"hn_quantity\":\"641\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":\"32\",\"hn_status\":1},{\"hn_name\":\"Pepsi\",\"hn_spt_id\":59,\"hn_price\":\"0\",\"hn_quantity\":\"602\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":\"32\",\"hn_status\":1},{\"hn_name\":\"Ice \\u0111\\u00e0o\",\"hn_spt_id\":60,\"hn_price\":\"0\",\"hn_quantity\":\"581\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":\"32\",\"hn_status\":1},{\"hn_name\":\"B\\u00f2 h\\u00fac\",\"hn_spt_id\":61,\"hn_price\":\"0\",\"hn_quantity\":\"589\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":\"32\",\"hn_status\":1},{\"hn_name\":\"Twister\",\"hn_spt_id\":62,\"hn_price\":\"0\",\"hn_quantity\":\"610\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":\"32\",\"hn_status\":1},{\"hn_name\":\"7up\",\"hn_spt_id\":79,\"hn_price\":\"0\",\"hn_quantity\":\"610\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":\"32\",\"hn_status\":1},{\"hn_name\":\"Sting \\u0111\\u1ecf\",\"hn_spt_id\":54,\"hn_price\":\"0\",\"hn_quantity\":\"583\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":\"32\",\"hn_status\":1},{\"hn_name\":\"Aquafina\",\"hn_spt_id\":\"57\",\"hn_price\":\"0\",\"hn_quantity\":\"571\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":\"32\",\"hn_status\":1}]', NULL, '2016-11-23 11:25:35', '2016-11-23 11:25:35'),
(39, 1, 50, 'hai.trieu@vgm.company', 'Super Admin', 33, NULL, NULL, '', '[{\"hn_name\":\"Th\\u1ecbt g\\u00e0\",\"hn_spt_id\":\"30\",\"hn_price\":\"0\",\"hn_quantity\":\"10\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":33,\"hn_status\":1}]', NULL, '2016-11-26 04:54:38', '2016-11-26 04:54:38'),
(40, 1, 50, 'hai.trieu@vgm.company', 'Super Admin', 34, NULL, NULL, '', '[{\"hn_name\":\"Tr\\u1ee9ng g\\u00e0\",\"hn_spt_id\":\"28\",\"hn_price\":\"0\",\"hn_quantity\":\"25\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":34,\"hn_status\":1}]', NULL, '2016-11-26 04:55:28', '2016-11-26 04:55:28'),
(41, 1, 81, 'hoai.nguyen@vgm.company', 'Hoài Mít', 35, NULL, NULL, '', '[{\"hn_name\":\"Tr\\u1ee9ng g\\u00e0\",\"hn_spt_id\":\"28\",\"hn_price\":\"200000\",\"hn_quantity\":\"132\",\"hn_time_expiry\":\"2016-12-31\",\"hn_hdn_id\":35,\"hn_status\":1}]', NULL, '2016-12-03 02:32:32', '2016-12-03 02:32:32'),
(42, 2, 71, 'hop.nguyen@vgm.company', 'Nguyễn Văn Hợp', 35, NULL, NULL, '', '[{\"hn_name\":\"Tr\\u1ee9ng g\\u00e0\",\"hn_spt_id\":28,\"hn_price\":\"200000\",\"hn_quantity\":\"62\",\"hn_time_expiry\":\"2016-12-31\",\"hn_hdn_id\":\"35\",\"hn_status\":1}]', NULL, '2016-12-03 03:08:50', '2016-12-03 03:08:50'),
(43, 1, 71, 'hop.nguyen@vgm.company', 'Nguyễn Văn Hợp', 36, NULL, NULL, '', '[{\"hn_name\":\"X\\u00fac x\\u00edch\",\"hn_spt_id\":\"32\",\"hn_price\":\"0\",\"hn_quantity\":\"76\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":36,\"hn_status\":1}]', NULL, '2016-12-03 06:52:27', '2016-12-03 06:52:27'),
(44, 1, 71, 'hop.nguyen@vgm.company', 'Nguyễn Văn Hợp', 37, NULL, NULL, '', '[{\"hn_name\":\"X\\u00fac x\\u00edch\",\"hn_spt_id\":\"32\",\"hn_price\":\"0\",\"hn_quantity\":\"34\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":37,\"hn_status\":1}]', NULL, '2016-12-03 06:53:20', '2016-12-03 06:53:20'),
(45, 1, 71, 'hop.nguyen@vgm.company', 'Nguyễn Văn Hợp', 38, NULL, NULL, '', '[{\"hn_name\":\"Tr\\u1ee9ng g\\u00e0\",\"hn_spt_id\":\"28\",\"hn_price\":0,\"hn_quantity\":\"6\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":38,\"hn_status\":1,\"hn_unit\":\"Qu\\u1ea3\"},{\"hn_name\":\"Rau c\\u1ea3i\",\"hn_spt_id\":\"38\",\"hn_price\":0,\"hn_quantity\":\"12.9\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":38,\"hn_status\":1,\"hn_unit\":\"Kg\"},{\"hn_name\":\"H\\u00e0nh l\\u00e1\",\"hn_spt_id\":\"40\",\"hn_price\":0,\"hn_quantity\":\"1.768\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":38,\"hn_status\":1,\"hn_unit\":\"Kg\"},{\"hn_name\":\"Rau m\\u00f9i\",\"hn_spt_id\":\"41\",\"hn_price\":0,\"hn_quantity\":\"4\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":38,\"hn_status\":1,\"hn_unit\":\"M\\u1edb\"},{\"hn_name\":\"T\\u1ecfi b\\u00f3c\",\"hn_spt_id\":\"51\",\"hn_price\":0,\"hn_quantity\":\"240\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":38,\"hn_status\":1,\"hn_unit\":\"Gram\"},{\"hn_name\":\"Th\\u1ecbt b\\u00f2\",\"hn_spt_id\":\"53\",\"hn_price\":0,\"hn_quantity\":\"1.84\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":38,\"hn_status\":1,\"hn_unit\":\"Kg\"},{\"hn_name\":\"G\\u1ea1o T\\u1ebb th\\u01b0\\u1eddng\",\"hn_spt_id\":\"65\",\"hn_price\":0,\"hn_quantity\":\"2.672\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":38,\"hn_status\":1,\"hn_unit\":\"Kg\"},{\"hn_name\":\"D\\u01b0a chua\",\"hn_spt_id\":\"66\",\"hn_price\":0,\"hn_quantity\":\"1.328\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":38,\"hn_status\":1,\"hn_unit\":\"Kg\"},{\"hn_name\":\"M\\u1ef3 h\\u1ea3o h\\u1ea3o\",\"hn_spt_id\":\"68\",\"hn_price\":0,\"hn_quantity\":\"211\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":38,\"hn_status\":1,\"hn_unit\":\"G\\u00f3i\"},{\"hn_name\":\"B\\u1ed9t n\\u00eam\",\"hn_spt_id\":\"73\",\"hn_price\":0,\"hn_quantity\":\"0.048\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":38,\"hn_status\":1,\"hn_unit\":\"Kg\"},{\"hn_name\":\"D\\u1ea7u \\u0103n C\\u00e1i L\\u00e2n\",\"hn_spt_id\":\"77\",\"hn_price\":0,\"hn_quantity\":\"0.64\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":38,\"hn_status\":1,\"hn_unit\":\"L\"},{\"hn_name\":\"B\\u00f2 kh\\u00f4\",\"hn_spt_id\":\"80\",\"hn_price\":0,\"hn_quantity\":\"2.8\",\"hn_time_expiry\":\"\",\"hn_hdn_id\":38,\"hn_status\":1,\"hn_unit\":\"Kg\"}]', NULL, '2016-12-05 06:37:09', '2016-12-05 06:37:09');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `history_store_types`
--

CREATE TABLE `history_store_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `history_store_types`
--

INSERT INTO `history_store_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Thêm hóa đơn nhập', '2016-10-13 17:00:00', '2016-10-13 17:00:00'),
(2, 'Cập nhật hóa đơn nhập', '2016-10-13 17:00:00', '2016-10-13 17:00:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `history_types`
--

CREATE TABLE `history_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `history_types`
--

INSERT INTO `history_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Order', '2016-08-28 17:00:00', '2016-08-28 17:00:00'),
(2, 'Cập nhật trạng thái sản phẩm', '2016-08-28 17:00:00', '2016-08-28 17:00:00'),
(3, 'Thêm sản phẩm', '2016-08-28 17:00:00', '2016-08-28 17:00:00'),
(4, 'Sửa sản phẩm', '2016-08-28 17:00:00', '2016-08-28 17:00:00'),
(5, 'Xóa sản phẩm', '2016-08-28 17:00:00', '2016-08-28 17:00:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hoa_don_nhap`
--

CREATE TABLE `hoa_don_nhap` (
  `hdn_id` int(11) NOT NULL,
  `hdn_code` varchar(255) DEFAULT NULL,
  `hdn_create_time` datetime DEFAULT NULL,
  `hdn_update_time` datetime DEFAULT NULL,
  `hdn_id_employee` int(11) DEFAULT NULL,
  `hdn_name_employee` varchar(255) DEFAULT NULL,
  `hdn_nsx_id` int(11) NOT NULL,
  `hdn_nsx_name` varchar(255) NOT NULL,
  `hdn_status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
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
-- Cấu trúc bảng cho bảng `order`
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
  `order_status` tinyint(4) DEFAULT '1',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `order_stock` text COLLATE utf8_unicode_ci,
  `order_type` tinyint(4) DEFAULT '0',
  `order_chef_do` tinyint(4) DEFAULT '1',
  `customer_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order`
--

INSERT INTO `order` (`order_id`, `order_name`, `order_create_time`, `order_price`, `order_notice`, `client_name`, `client_ip`, `room`, `room_id`, `message_destroy`, `order_status`, `updated_at`, `order_stock`, `order_type`, `order_chef_do`, `customer_name`, `customer_phone`, `customer_email`, `customer_address`) VALUES
(41218, '', '2017-02-18 19:38:09', 10000, '', 'QUÂN HOME', '192.168.1.11', 'Tầng 2 - Gengar', 2, '', 2, '2017-02-18 12:38:36', '{\"77\":0.01,\"109\":1}', 0, 1, NULL, NULL, NULL, NULL),
(41219, NULL, '2017-02-26 14:14:11', 200000, '', NULL, NULL, NULL, 0, '', 1, '2017-02-26 07:14:11', NULL, 0, 1, 'quan', '090 3113 492', '', 'Thanh xuân'),
(41220, NULL, '2017-02-26 14:14:31', 200000, '', NULL, NULL, NULL, 0, '', 1, '2017-02-26 07:14:31', NULL, 0, 1, 'quan', '090 3113 492', '', 'Thanh xuân'),
(41221, NULL, '2017-02-26 14:15:01', 200000, '', NULL, NULL, NULL, 0, '', 1, '2017-02-26 07:15:01', NULL, 0, 1, 'quan', '090 3113 492', '', 'Thanh xuân'),
(41222, NULL, '2017-02-26 14:18:11', 1200000, '', NULL, NULL, NULL, 0, '', 1, '2017-02-26 07:18:11', NULL, 0, 1, 'quan', '090 3113 492', '', 'Thanh xuân');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
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
-- Đang đổ dữ liệu cho bảng `order_details`
--

INSERT INTO `order_details` (`order_details_id`, `order_id`, `product_id`, `product_price`, `product_quantity`, `product_option`, `product_name`, `category_id`) VALUES
(50934, 41222, 76, '200000', 1, NULL, 'Kem dưỡng ẩm ban đêm', 6),
(50935, 41222, 74, '1000000', 1, NULL, 'vichy dưỡng da', 6);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('CSKHT5@gmail.com', 'e0817e86ace0bdb29aa1da346cef5f5b0ec84017ed997a5f806db3e99c2d32d9', '2017-01-31 15:31:06');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `permissions`
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
-- Đang đổ dữ liệu cho bảng `permissions`
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
(18, 'quan-ly-tang-2', 'Quản lý tầng 2', 0, '2016-09-27 17:00:00', '2016-09-27 17:00:00'),
(19, 'access-status-pending', 'Quyền cập nhật trạng thái từ hủy sang đang xử lý', 0, '2016-09-27 17:00:00', '2016-09-27 17:00:00'),
(20, 'dashboard', 'Quyền truy cập dashboard', 0, '2016-09-27 17:00:00', '2016-09-27 17:00:00'),
(21, 'cap-nhat-het-hang', 'Cập nhật hết hàng', 0, '2016-09-30 17:00:00', '2016-09-30 17:00:00'),
(22, 'manager-stock', 'Quản lý kho hàng', 0, '2016-10-24 02:55:44', '2016-10-24 17:00:00'),
(23, 'manager-recipe', 'Quản lý công thức', 0, '2016-10-25 03:03:18', '2016-10-24 17:00:00'),
(24, 'manager-room', 'Quản lý phòng máy', 0, '2016-10-25 09:48:29', '2016-10-24 17:00:00'),
(25, 'manager-all-order', 'Quản lý tất cả đơn hàng', 0, '2016-10-25 09:48:29', '2016-10-24 17:00:00'),
(26, 'access-pendding-destroy', 'Chuyển từ đang xử lý sang hủy', 0, '2016-10-25 09:48:29', '2016-10-24 17:00:00'),
(27, 'access-approved-destroy', 'Chuyển từ đã thu tiền sang hủy', 0, '2016-10-25 09:48:29', '2016-10-24 17:00:00'),
(28, 'access-done-destroy', 'Chuyển từ đã hoàn thành sang hủy', 0, '2016-10-25 09:48:29', '2016-10-24 17:00:00'),
(29, 'chef-do', 'Bếp xử lý đơn hàng', 0, '2016-11-25 01:24:31', '2016-11-24 17:00:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `permission_role`
--

CREATE TABLE `permission_role` (
  `id` int(10) UNSIGNED NOT NULL,
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `product_id` int(10) UNSIGNED NOT NULL,
  `product_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_desc` text COLLATE utf8_unicode_ci,
  `product_price` int(11) NOT NULL DEFAULT '0',
  `category_id` int(10) UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL,
  `product_ctm_id` int(11) NOT NULL,
  `sort` int(11) DEFAULT NULL,
  `product_type` tinyint(4) DEFAULT '1',
  `product_saleoff` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `alias`, `product_image`, `product_desc`, `product_price`, `category_id`, `status`, `product_ctm_id`, `sort`, `product_type`, `product_saleoff`) VALUES
(74, 'vichy dưỡng da', 'vichy-duong-da', '[\"235722111.jpg\",\"235722222.jpeg\"]', '', 1000000, 6, 1, 0, 3, 2, 0),
(75, 'Bộ tẩy trang Apple Juicy Special Cleansing Kit Inn', 'Bo-tay-trang-Apple-Juicy-Special-Cleansing-Kit-Inn', '[\"205402111.jpg\",\"205402222.jpeg\"]', '<h2>Bộ tẩy trang t&aacute;o Apple Juicy Special Cleansing Kit Innisfree</h2>\r\n\r\n<p style=\"text-align:center\"><img alt=\"\" src=\"/public/uploads/images/d2cd96e0485e0665eb25cf291f0cc49d.jpeg\" style=\"height:305px; width:200px\" /></p>\r\n\r\n<p style=\"text-align:center\">&nbsp;</p>\r\n\r\n<ul>\r\n</ul>\r\n\r\n<h4>&nbsp;</h4>\r\n', 115000, 6, 1, 0, 1, 1, 0),
(76, 'Kem dưỡng ẩm ban đêm', 'Kem-duong-am-ban-dem', '[\"100221222.jpeg\"]', '', 200000, 6, 1, 0, 2, 3, 10);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `roles`
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
-- Đang đổ dữ liệu cho bảng `roles`
--

INSERT INTO `roles` (`id`, `name`, `all`, `sort`, `created_at`, `updated_at`) VALUES
(1, 'CEO', 1, 1, '2016-08-28 17:00:00', '2016-11-28 07:59:42');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `room`
--

CREATE TABLE `room` (
  `room_id` int(10) UNSIGNED NOT NULL,
  `room_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `room_ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `room`
--

INSERT INTO `room` (`room_id`, `room_name`, `room_ip`) VALUES
(2, 'Tầng 2 - Gengar', '127.0.0.1'),
(3, 'Tầng 3 - Gengar', '113.20.109.40,1.55.165.32,42.112.15.76,222.252.17.34,1.55.102.172,1.55.98.207,117.0.118.64,222.252.17.23,222.252.17.219,1.55.98.224,1.55.102.100,42.114.142.128,1.55.98.192,58.187.14.62,1.55.102.17,1.55.101.234,118.70.133.201,27.72.59.52,42.112.144.127'),
(4, 'Tầng 4 - Gengar', '113.20.109.40,1.55.165.32,42.112.15.76,222.252.17.34,1.55.102.172,1.55.98.207,117.0.118.64,222.252.17.23,222.252.17.219,1.55.98.224,1.55.102.100,42.114.142.128,1.55.98.192,58.187.14.62,1.55.102.17,1.55.101.234,118.70.133.201,27.72.59.52,42.112.144.127'),
(5, 'Tầng 5 - Gengar', '113.20.109.40,1.55.165.32,42.112.15.76,222.252.17.34,1.55.102.172,1.55.98.207,117.0.118.64,222.252.17.23,222.252.17.219,1.55.98.224,1.55.102.100,42.114.142.128,1.55.98.192,58.187.14.62,1.55.102.17,1.55.101.234,118.70.133.201,27.72.59.52,42.112.144.127'),
(6, 'Tầng 6 - Gengar', '113.20.109.40,1.55.165.32,42.112.15.76,222.252.17.34,1.55.102.172,1.55.98.207,117.0.118.64,222.252.17.23,222.252.17.219,1.55.98.224,1.55.102.100,42.114.142.128,1.55.98.192,1.55.102.17,118.70.133.201,27.72.59.52,42.112.144.127');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `scheduletime`
--

CREATE TABLE `scheduletime` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `scheduletime`
--

INSERT INTO `scheduletime` (`id`, `name`, `time_start`, `time_end`) VALUES
(1, 'Ca 1 - Sáng', '06:00:00', '14:00:00'),
(2, 'Ca 2 - Chiều', '14:00:00', '22:00:00'),
(3, 'Ca 3 - Đêm ', '22:00:00', '06:00:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `avatar`, `email`, `password`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(73, 'DEV', '1501688827.111.jpg', 'dev@gmail.com', '$2y$10$4MC9spQSzSfHYKgNr8kAbeNqoNy3tV.hmGzYB7JvtrALOIya7tTcy', 1, 'UucV3cWRRU5JeKsnZM2rrmwGcIh2fYlCcrLyqsJ4gBLc9awrOASJ80zF7Kvv', '2016-11-02 01:14:54', '2017-08-02 15:47:07'),
(114, 'dev2', '', 'dev2@gmail.com', '$2y$10$1zJLiFP33vWia5gDb4A3mu1eP/XSl7IHU7sDqy6GC/Nc.VLwcJX2K', 1, NULL, '2017-08-02 15:00:57', '2017-08-02 15:00:57');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `assigned_roles`
--
ALTER TABLE `assigned_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assigned_roles_user_id_foreign` (`user_id`),
  ADD KEY `assigned_roles_role_id_foreign` (`role_id`);

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Chỉ mục cho bảng `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`client_id`),
  ADD KEY `client_room_id_foreign` (`room_id`);

--
-- Chỉ mục cho bảng `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `history_type_id_foreign` (`type_id`),
  ADD KEY `history_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `history_details`
--
ALTER TABLE `history_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `history_details_history_id_foreign` (`history_id`);

--
-- Chỉ mục cho bảng `history_store`
--
ALTER TABLE `history_store`
  ADD PRIMARY KEY (`id`),
  ADD KEY `history_store_type_id_foreign` (`type_id`),
  ADD KEY `history_store_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `history_store_types`
--
ALTER TABLE `history_store_types`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `history_types`
--
ALTER TABLE `history_types`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `hoa_don_nhap`
--
ALTER TABLE `hoa_don_nhap`
  ADD PRIMARY KEY (`hdn_id`);

--
-- Chỉ mục cho bảng `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_details_id`),
  ADD KEY `order_details1_order_id_foreign` (`order_id`);

--
-- Chỉ mục cho bảng `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Chỉ mục cho bảng `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Chỉ mục cho bảng `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_role_permission_id_foreign` (`permission_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `product_category_id_foreign` (`category_id`);

--
-- Chỉ mục cho bảng `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Chỉ mục cho bảng `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`);

--
-- Chỉ mục cho bảng `scheduletime`
--
ALTER TABLE `scheduletime`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `assigned_roles`
--
ALTER TABLE `assigned_roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=390;
--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT cho bảng `client`
--
ALTER TABLE `client`
  MODIFY `client_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;
--
-- AUTO_INCREMENT cho bảng `history`
--
ALTER TABLE `history`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77379;
--
-- AUTO_INCREMENT cho bảng `history_details`
--
ALTER TABLE `history_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68635;
--
-- AUTO_INCREMENT cho bảng `history_store`
--
ALTER TABLE `history_store`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT cho bảng `history_store_types`
--
ALTER TABLE `history_store_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT cho bảng `history_types`
--
ALTER TABLE `history_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT cho bảng `hoa_don_nhap`
--
ALTER TABLE `hoa_don_nhap`
  MODIFY `hdn_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT cho bảng `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41223;
--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_details_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50936;
--
-- AUTO_INCREMENT cho bảng `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT cho bảng `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=399;
--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;
--
-- AUTO_INCREMENT cho bảng `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT cho bảng `room`
--
ALTER TABLE `room`
  MODIFY `room_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT cho bảng `scheduletime`
--
ALTER TABLE `scheduletime`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;
--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `assigned_roles`
--
ALTER TABLE `assigned_roles`
  ADD CONSTRAINT `assigned_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assigned_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `client_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `room` (`room_id`);

--
-- Các ràng buộc cho bảng `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `history_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `history_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `history_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details1_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`);

--
-- Các ràng buộc cho bảng `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
