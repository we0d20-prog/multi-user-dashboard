-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 24 أكتوبر 2026 الساعة 16:30
-- إصدار الخادم: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `multi_user_dashboard`
--

-- --------------------------------------------------------

--
-- بنية الجدول `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `ip_address` varchar(45) DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `operating_system` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `created_at`, `ip_address`, `browser`, `operating_system`) VALUES
(1, 1, 'Created User: fahad adnan', '2026-06-20 12:46:44', NULL, NULL, NULL),
(2, 1, 'Created Role: Test Role', '2026-06-22 14:31:48', NULL, NULL, NULL),
(3, 1, 'Deleted Role: Test Role', '2026-06-22 14:32:08', NULL, NULL, NULL),
(4, 1, 'Updated User: yaser', '2026-06-27 14:15:24', NULL, NULL, NULL),
(5, 1, 'User Logout', '2026-06-28 13:04:26', NULL, NULL, NULL),
(6, 1, 'User Login', '2026-06-28 13:40:11', NULL, NULL, NULL),
(7, 1, 'User Logout', '2026-06-28 14:27:33', NULL, NULL, NULL),
(8, 9, 'User Login', '2026-06-28 14:27:51', NULL, NULL, NULL),
(9, 9, 'User Logout', '2026-06-28 14:28:04', NULL, NULL, NULL),
(10, 1, 'User Login', '2026-06-28 14:28:07', NULL, NULL, NULL),
(11, 1, 'Created User: Rami samir', '2026-06-28 14:46:03', NULL, NULL, NULL),
(12, 1, 'Activated User: Admin', '2026-06-28 16:05:18', NULL, NULL, NULL),
(13, 1, 'Activated User: Ahmed', '2026-06-28 16:05:23', NULL, NULL, NULL),
(14, 1, 'Activated User: Ahmed', '2026-06-28 16:05:25', NULL, NULL, NULL),
(15, 1, 'Activated User: Ahmed', '2026-06-28 16:05:26', NULL, NULL, NULL),
(16, 1, 'Activated User: Ahmed', '2026-06-28 16:05:26', NULL, NULL, NULL),
(17, 1, 'Activated User: Admin', '2026-06-28 16:10:01', NULL, NULL, NULL),
(18, 1, 'Activated User: Admin', '2026-06-28 16:10:02', NULL, NULL, NULL),
(19, 1, 'Activated User: Admin', '2026-06-28 16:10:02', NULL, NULL, NULL),
(20, 1, 'Activated User: Admin', '2026-06-28 16:10:03', NULL, NULL, NULL),
(21, 1, 'Activated User: Admin', '2026-06-28 16:10:04', NULL, NULL, NULL),
(22, 1, 'Activated User: Ahmed', '2026-06-28 16:14:27', NULL, NULL, NULL),
(23, 1, 'Activated User: moataz', '2026-06-29 12:40:24', NULL, NULL, NULL),
(24, 1, 'Activated User: Ahmed', '2026-06-29 12:40:26', NULL, NULL, NULL),
(25, 1, 'User Logout', '2026-06-29 12:40:42', NULL, NULL, NULL),
(26, 1, 'User Login', '2026-06-29 14:02:36', NULL, NULL, NULL),
(27, 1, 'Deactivated User: Ahmed', '2026-06-29 14:03:31', NULL, NULL, NULL),
(28, 1, 'User Logout', '2026-06-29 14:03:40', NULL, NULL, NULL),
(29, 1, 'User Login', '2026-06-29 14:04:00', NULL, NULL, NULL),
(30, 1, 'Activated User: Ahmed', '2026-06-29 14:04:04', NULL, NULL, NULL),
(31, 1, 'Deactivated User: Ahmed', '2026-06-29 14:04:07', NULL, NULL, NULL),
(32, 1, 'Activated User: Ahmed', '2026-06-29 14:04:09', NULL, NULL, NULL),
(33, 1, 'User Logout', '2026-07-01 12:24:02', NULL, NULL, NULL),
(34, 1, 'User Login', '2026-07-01 12:24:04', NULL, NULL, NULL),
(35, 1, 'User Logout', '2026-07-02 13:31:15', NULL, NULL, NULL),
(36, 1, 'User Login', '2026-07-02 13:31:17', NULL, NULL, NULL),
(37, 1, 'User Logout', '2026-07-04 12:49:41', NULL, NULL, NULL),
(38, 1, 'User Login', '2026-07-04 12:49:42', NULL, NULL, NULL),
(39, 1, 'User Logout', '2026-07-05 12:26:31', NULL, NULL, NULL),
(40, 1, 'User Login', '2026-07-05 12:26:33', NULL, NULL, NULL),
(41, 1, 'User Logout', '2026-07-06 23:02:44', NULL, NULL, NULL),
(42, 10, 'User Login', '2026-07-06 23:03:50', NULL, NULL, NULL),
(43, 10, 'User Logout', '2026-07-06 23:04:54', NULL, NULL, NULL),
(44, 1, 'User Login', '2026-07-06 23:04:57', NULL, NULL, NULL),
(45, 1, 'User Logout', '2026-07-10 14:10:06', NULL, NULL, NULL),
(46, 9, 'User Login', '2026-07-11 12:42:59', NULL, NULL, NULL),
(47, 9, 'User Logout', '2026-07-11 12:43:10', NULL, NULL, NULL),
(48, 1, 'User Login', '2026-07-11 12:43:12', NULL, NULL, NULL),
(49, 1, 'Created User: wail', '2026-07-11 12:43:57', NULL, NULL, NULL),
(50, 1, 'User Logout', '2026-07-11 12:44:12', NULL, NULL, NULL),
(53, 1, 'User Login', '2026-07-11 13:25:51', NULL, NULL, NULL),
(54, 1, 'Updated User: Ahmed sami', '2026-07-12 15:26:41', '::1', 'Google Chrome', 'Windows'),
(55, 1, 'Updated User: Ahmed', '2026-07-13 12:00:21', '::1', 'Google Chrome', 'Windows'),
(56, 1, 'User Login', '2026-07-13 12:04:29', '127.0.0.1', 'Google Chrome', 'Windows'),
(57, 1, 'User Logout', '2026-07-13 14:24:41', '::1', 'Google Chrome', 'Windows'),
(58, 1, 'User Login', '2026-07-13 14:24:43', '::1', 'Google Chrome', 'Windows'),
(59, 1, 'Created User: Mahmud', '2026-07-14 14:20:30', '::1', 'Google Chrome', 'Windows'),
(60, 1, 'Deleted User: Mahmud', '2026-07-14 14:21:09', '::1', 'Google Chrome', 'Windows'),
(61, 1, 'Created User: yamen', '2026-07-14 14:21:48', '::1', 'Google Chrome', 'Windows'),
(62, 1, 'Updated User: Admin', '2026-07-15 14:42:18', '::1', 'Google Chrome', 'Windows'),
(63, 1, 'Created User: esmail', '2026-07-15 14:42:54', '::1', 'Google Chrome', 'Windows'),
(64, 1, 'Deleted User: esmail', '2026-07-15 14:47:00', '::1', 'Google Chrome', 'Windows'),
(65, 1, 'Updated User: yamenn', '2026-07-15 15:07:03', '::1', 'Google Chrome', 'Windows'),
(66, 1, 'Deleted User: yamenn', '2026-07-15 15:09:49', '::1', 'Google Chrome', 'Windows'),
(67, 1, 'Updated User: waail', '2026-07-16 12:20:24', '::1', 'Google Chrome', 'Windows'),
(68, 1, 'User Logout', '2026-07-16 12:20:41', '::1', 'Google Chrome', 'Windows'),
(69, 9, 'User Login', '2026-07-16 12:20:54', '::1', 'Google Chrome', 'Windows'),
(70, 9, 'Updated User: yasser', '2026-07-16 12:21:23', '::1', 'Google Chrome', 'Windows'),
(71, 9, 'User Logout', '2026-07-16 12:21:33', '::1', 'Google Chrome', 'Windows'),
(72, 1, 'User Login', '2026-07-16 12:21:36', '::1', 'Google Chrome', 'Windows'),
(73, 1, 'Deleted User: waail', '2026-07-16 12:22:07', '::1', 'Google Chrome', 'Windows'),
(74, 1, 'Updated Role: manager1', '2026-07-16 12:26:56', '::1', 'Google Chrome', 'Windows'),
(75, 1, 'Created Role: Supportxz', '2026-07-16 12:47:31', '::1', 'Google Chrome', 'Windows'),
(76, 1, 'Updated Role: Supportx', '2026-07-16 13:18:44', '::1', 'Google Chrome', 'Windows'),
(77, 1, 'Created Role: employe', '2026-07-16 13:37:28', '::1', 'Google Chrome', 'Windows'),
(78, 1, 'Deleted Role: employe', '2026-07-16 13:37:39', '::1', 'Google Chrome', 'Windows'),
(79, 1, 'Created Role: manager', '2026-07-16 13:38:12', '::1', 'Google Chrome', 'Windows'),
(80, 1, 'Updated Role: manager1', '2026-07-16 13:40:02', '::1', 'Google Chrome', 'Windows'),
(81, 1, 'Updated Role: manageryyyyy', '2026-07-16 13:40:10', '::1', 'Google Chrome', 'Windows'),
(82, 1, 'Updated Role: manager', '2026-07-16 13:40:20', '::1', 'Google Chrome', 'Windows'),
(83, 1, 'Deleted Role: manageryyyyy', '2026-07-16 13:40:25', '::1', 'Google Chrome', 'Windows'),
(84, 1, 'Updated Role: Supportxuuu', '2026-07-16 13:40:38', '::1', 'Google Chrome', 'Windows'),
(85, 1, 'Deleted Role: Supportxuuu', '2026-07-16 13:40:43', '::1', 'Google Chrome', 'Windows'),
(86, 1, 'Updated Role: Support', '2026-07-16 13:41:54', '::1', 'Google Chrome', 'Windows'),
(87, 1, 'Created Role: bab', '2026-07-16 13:51:30', '::1', 'Google Chrome', 'Windows'),
(88, 1, 'Deleted Role: bab', '2026-07-16 13:51:35', '::1', 'Google Chrome', 'Windows'),
(89, 1, 'Moved User To Trash: Rami samir', '2026-07-18 12:32:32', '::1', 'Google Chrome', 'Windows'),
(90, 1, 'Restored User: Rami samir', '2026-07-18 12:37:54', '::1', 'Google Chrome', 'Windows'),
(91, 1, 'Moved User To Trash: Zaher', '2026-07-18 12:38:22', '::1', 'Google Chrome', 'Windows'),
(92, 1, 'Restored User: Zaher', '2026-07-18 12:38:28', '::1', 'Google Chrome', 'Windows'),
(93, 1, 'Created User: eman taha', '2026-07-18 13:01:20', '::1', 'Google Chrome', 'Windows'),
(94, 1, 'Deactivated User: eman taha', '2026-07-18 13:01:31', '::1', 'Google Chrome', 'Windows'),
(95, 1, 'Activated User: eman taha', '2026-07-18 13:01:54', '::1', 'Google Chrome', 'Windows'),
(96, 1, 'Moved User To Trash: eman taha', '2026-07-18 13:02:12', '::1', 'Google Chrome', 'Windows'),
(97, 1, 'Restored User: eman taha', '2026-07-18 13:02:22', '::1', 'Google Chrome', 'Windows'),
(98, 1, 'Moved User To Trash: eman taha', '2026-07-18 13:02:36', '::1', 'Google Chrome', 'Windows'),
(99, 1, 'Permanently Deleted User: eman taha', '2026-07-18 13:03:12', '::1', 'Google Chrome', 'Windows'),
(100, 1, 'Created User: sami bassam', '2026-07-19 12:42:29', '::1', 'Google Chrome', 'Windows'),
(101, 1, 'Moved User To Trash: sami bassam', '2026-07-19 12:45:29', '::1', 'Google Chrome', 'Windows'),
(102, 1, 'Permanently Deleted User: sami bassam', '2026-07-19 12:56:16', '::1', 'Google Chrome', 'Windows'),
(103, 1, 'Created User: samh', '2026-07-19 12:56:57', '::1', 'Google Chrome', 'Windows'),
(104, 1, 'Moved User To Trash: samh', '2026-07-19 13:00:32', '::1', 'Google Chrome', 'Windows'),
(105, 1, 'Permanently Deleted User: samh', '2026-07-19 13:00:39', '::1', 'Google Chrome', 'Windows'),
(106, 1, 'Created User: dalal', '2026-07-19 13:41:09', '::1', 'Google Chrome', 'Windows'),
(107, 1, 'Moved User To Trash: dalal', '2026-07-19 13:44:59', '::1', 'Google Chrome', 'Windows'),
(108, 1, 'Permanently Deleted User: dalal', '2026-07-19 13:45:05', '::1', 'Google Chrome', 'Windows'),
(109, 1, 'Created User: samr ee', '2026-07-19 13:45:38', '::1', 'Google Chrome', 'Windows'),
(110, 1, 'Moved User To Trash: samr ee', '2026-07-19 13:46:25', '::1', 'Google Chrome', 'Windows'),
(111, 1, 'Permanently Deleted User: samr ee', '2026-07-19 13:46:43', '::1', 'Google Chrome', 'Windows'),
(112, 1, 'Created User: waleed sami', '2026-07-19 13:47:45', '::1', 'Google Chrome', 'Windows'),
(113, 1, 'Moved User To Trash: waleed sami', '2026-07-19 13:56:04', '::1', 'Google Chrome', 'Windows'),
(114, 1, 'Permanently Deleted User: waleed sami', '2026-07-19 13:56:10', '::1', 'Google Chrome', 'Windows'),
(115, 1, 'Created User: waleed ff', '2026-07-19 13:56:40', '::1', 'Google Chrome', 'Windows'),
(116, 1, 'Created User: marwan', '2026-07-19 14:01:01', '::1', 'Google Chrome', 'Windows'),
(117, 1, 'Moved User To Trash: waleed ff', '2026-07-19 14:10:35', '::1', 'Google Chrome', 'Windows'),
(118, 1, 'Moved User To Trash: marwan', '2026-07-19 14:10:45', '::1', 'Google Chrome', 'Windows'),
(119, 1, 'Permanently Deleted User: waleed ff', '2026-07-19 14:10:52', '::1', 'Google Chrome', 'Windows'),
(120, 1, 'Permanently Deleted User: marwan', '2026-07-19 14:10:55', '::1', 'Google Chrome', 'Windows'),
(121, 1, 'Created User: mahmod', '2026-07-19 14:11:36', '::1', 'Google Chrome', 'Windows'),
(122, 1, 'Moved User To Trash: mahmod', '2026-07-19 14:17:38', '::1', 'Google Chrome', 'Windows'),
(123, 1, 'Permanently Deleted User: mahmod', '2026-07-19 14:17:51', '::1', 'Google Chrome', 'Windows'),
(124, 1, 'Created User: waleed sami', '2026-07-19 14:18:34', '::1', 'Google Chrome', 'Windows'),
(125, 1, 'Created User: ayman', '2026-07-20 13:05:10', '::1', 'Google Chrome', 'Windows'),
(126, 1, 'Moved User To Trash: maram', '2026-07-23 12:06:27', '::1', 'Google Chrome', 'Windows'),
(127, 1, 'Permanently Deleted User: maram', '2026-07-23 12:06:34', '::1', 'Google Chrome', 'Windows'),
(128, 1, 'Created User: maram basm', '2026-07-23 12:07:44', '::1', 'Google Chrome', 'Windows'),
(129, 1, 'User Logout', '2026-07-25 14:07:38', '::1', 'Google Chrome', 'Windows'),
(130, 1, 'User Login', '2026-07-25 14:07:40', '::1', 'Google Chrome', 'Windows'),
(131, 1, 'User Logout', '2026-07-26 12:52:17', '::1', 'Google Chrome', 'Windows'),
(132, 9, 'User Login', '2026-07-26 12:52:41', '::1', 'Google Chrome', 'Windows'),
(133, 9, 'User Logout', '2026-07-26 12:53:28', '::1', 'Google Chrome', 'Windows'),
(134, 1, 'User Login', '2026-07-26 12:55:14', '::1', 'Google Chrome', 'Windows'),
(135, 1, 'User Logout', '2026-07-26 12:55:35', '::1', 'Google Chrome', 'Windows'),
(136, 8, 'User Login', '2026-07-26 12:55:48', '::1', 'Google Chrome', 'Windows'),
(137, 8, 'User Logout', '2026-07-26 13:15:31', '::1', 'Google Chrome', 'Windows'),
(138, 1, 'User Login', '2026-07-26 13:15:33', '::1', 'Google Chrome', 'Windows'),
(139, 1, 'User Logout', '2026-07-26 13:15:41', '::1', 'Google Chrome', 'Windows'),
(140, 9, 'User Login', '2026-07-26 13:15:53', '::1', 'Google Chrome', 'Windows'),
(141, 9, 'User Logout', '2026-07-26 18:23:32', '::1', 'Google Chrome', 'Windows'),
(142, 1, 'User Login', '2026-07-26 18:23:34', '::1', 'Google Chrome', 'Windows'),
(143, 1, 'User Logout', '2026-07-26 18:51:46', '::1', 'Google Chrome', 'Windows'),
(144, 9, 'User Login', '2026-07-26 18:51:59', '::1', 'Google Chrome', 'Windows'),
(145, 9, 'User Logout', '2026-07-26 18:52:08', '::1', 'Google Chrome', 'Windows'),
(146, 1, 'User Login', '2026-07-26 18:52:13', '::1', 'Google Chrome', 'Windows'),
(147, 1, 'Created User: fadi sami', '2026-07-26 18:53:36', '::1', 'Google Chrome', 'Windows'),
(148, 1, 'User Logout', '2026-07-26 18:53:55', '::1', 'Google Chrome', 'Windows'),
(149, 34, 'User Login', '2026-07-26 18:54:11', '::1', 'Google Chrome', 'Windows'),
(150, 34, 'User Logout', '2026-07-26 18:54:25', '::1', 'Google Chrome', 'Windows'),
(151, 1, 'User Login', '2026-07-26 18:54:27', '::1', 'Google Chrome', 'Windows'),
(152, 1, 'Updated User: Ahmed', '2026-07-26 18:57:34', '::1', 'Google Chrome', 'Windows'),
(153, 1, 'User Logout', '2026-07-26 18:57:37', '::1', 'Google Chrome', 'Windows'),
(154, 2, 'User Login', '2026-07-26 18:57:51', '::1', 'Google Chrome', 'Windows'),
(155, 2, 'User Logout', '2026-07-26 18:58:08', '::1', 'Google Chrome', 'Windows'),
(156, 1, 'User Login', '2026-07-26 18:58:10', '::1', 'Google Chrome', 'Windows'),
(157, 1, 'User Logout', '2026-07-27 14:31:29', '::1', 'Google Chrome', 'Windows'),
(158, 2, 'User Login', '2026-07-27 14:31:46', '::1', 'Google Chrome', 'Windows'),
(159, 2, 'Updated Profile', '2026-07-27 14:32:01', '::1', 'Google Chrome', 'Windows'),
(160, 2, 'User Logout', '2026-07-27 14:32:26', '::1', 'Google Chrome', 'Windows'),
(161, 1, 'User Login', '2026-07-27 14:32:28', '::1', 'Google Chrome', 'Windows'),
(162, 1, 'User Logout', '2026-07-27 14:56:49', '::1', 'Google Chrome', 'Windows'),
(163, 9, 'User Login', '2026-07-27 14:57:15', '::1', 'Google Chrome', 'Windows'),
(164, 9, 'User Logout', '2026-07-28 13:08:46', '::1', 'Google Chrome', 'Windows'),
(165, 1, 'User Login', '2026-07-28 13:08:48', '::1', 'Google Chrome', 'Windows'),
(166, 1, 'User Logout', '2026-07-28 13:13:12', '::1', 'Google Chrome', 'Windows'),
(167, 9, 'User Login', '2026-07-28 13:13:29', '::1', 'Google Chrome', 'Windows'),
(168, 9, 'User Logout', '2026-07-28 13:13:46', '::1', 'Google Chrome', 'Windows'),
(169, 2, 'User Login', '2026-07-28 13:14:00', '::1', 'Google Chrome', 'Windows'),
(170, 2, 'Updated Profile', '2026-07-28 13:14:16', '::1', 'Google Chrome', 'Windows'),
(171, 2, 'User Logout', '2026-07-28 13:14:18', '::1', 'Google Chrome', 'Windows'),
(172, 9, 'User Login', '2026-07-28 13:14:30', '::1', 'Google Chrome', 'Windows'),
(173, 9, 'User Logout', '2026-07-28 13:14:37', '::1', 'Google Chrome', 'Windows'),
(174, 1, 'User Login', '2026-07-28 13:14:41', '::1', 'Google Chrome', 'Windows'),
(175, 1, 'User Logout', '2026-07-28 13:27:21', '::1', 'Google Chrome', 'Windows'),
(176, 9, 'User Login', '2026-07-28 13:27:34', '::1', 'Google Chrome', 'Windows'),
(177, 9, 'Updated Profile', '2026-07-28 13:27:50', '::1', 'Google Chrome', 'Windows'),
(178, 9, 'Updated Profile', '2026-07-28 13:27:55', '::1', 'Google Chrome', 'Windows'),
(179, 9, 'User Logout', '2026-07-28 13:28:12', '::1', 'Google Chrome', 'Windows'),
(180, 2, 'User Login', '2026-07-28 13:28:39', '::1', 'Google Chrome', 'Windows'),
(181, 2, 'User Logout', '2026-07-29 13:22:37', '::1', 'Google Chrome', 'Windows'),
(182, 1, 'User Login', '2026-07-29 13:22:40', '::1', 'Google Chrome', 'Windows'),
(183, 1, 'User Logout', '2026-07-29 13:24:59', '::1', 'Google Chrome', 'Windows'),
(184, 9, 'User Login', '2026-07-29 13:25:18', '::1', 'Google Chrome', 'Windows'),
(185, 9, 'Updated Profile', '2026-07-29 13:25:31', '::1', 'Google Chrome', 'Windows'),
(186, 9, 'User Logout', '2026-07-29 13:27:12', '::1', 'Google Chrome', 'Windows'),
(187, 1, 'User Login', '2026-07-29 13:27:16', '::1', 'Google Chrome', 'Windows'),
(188, 1, 'User Logout', '2026-07-29 19:14:15', '::1', 'Google Chrome', 'Windows'),
(189, 2, 'User Login', '2026-07-29 19:14:34', '::1', 'Google Chrome', 'Windows'),
(190, 2, 'Updated Profile', '2026-07-29 19:30:18', '::1', 'Google Chrome', 'Windows'),
(191, 2, 'User Logout', '2026-07-29 19:30:26', '::1', 'Google Chrome', 'Windows'),
(192, 9, 'User Login', '2026-07-29 19:30:40', '::1', 'Google Chrome', 'Windows'),
(193, 9, 'Updated Profile', '2026-07-30 12:54:09', '::1', 'Google Chrome', 'Windows'),
(194, 9, 'User Logout', '2026-07-30 13:47:21', '::1', 'Google Chrome', 'Windows'),
(195, 1, 'User Login', '2026-07-30 13:47:23', '::1', 'Google Chrome', 'Windows'),
(196, 1, 'User Logout', '2026-07-30 13:47:45', '::1', 'Google Chrome', 'Windows'),
(197, 2, 'User Login', '2026-07-30 13:48:02', '::1', 'Google Chrome', 'Windows'),
(198, 2, 'Updated Profile', '2026-07-30 13:48:18', '::1', 'Google Chrome', 'Windows'),
(199, 2, 'User Logout', '2026-07-30 13:48:26', '::1', 'Google Chrome', 'Windows'),
(200, 9, 'User Login', '2026-07-30 13:48:36', '::1', 'Google Chrome', 'Windows'),
(201, 9, 'User Logout', '2026-07-30 13:48:40', '::1', 'Google Chrome', 'Windows'),
(202, 1, 'User Login', '2026-07-30 13:48:43', '::1', 'Google Chrome', 'Windows'),
(203, 1, 'User Logout', '2026-07-30 14:25:34', '::1', 'Google Chrome', 'Windows'),
(204, 2, 'User Login', '2026-07-30 14:25:50', '::1', 'Google Chrome', 'Windows'),
(205, 2, 'User Logout', '2026-07-30 14:58:21', '::1', 'Google Chrome', 'Windows'),
(206, 1, 'User Login', '2026-07-30 14:58:23', '::1', 'Google Chrome', 'Windows'),
(207, 1, 'Created Department : IT', '2026-08-02 13:49:25', '::1', 'Google Chrome', 'Windows'),
(208, 1, 'User Logout', '2026-08-02 13:51:27', '::1', 'Google Chrome', 'Windows'),
(209, 2, 'User Login', '2026-08-02 13:51:46', '::1', 'Google Chrome', 'Windows'),
(210, 2, 'User Logout', '2026-08-02 13:53:57', '::1', 'Google Chrome', 'Windows'),
(211, 1, 'User Login', '2026-08-02 13:53:59', '::1', 'Google Chrome', 'Windows'),
(212, 1, 'User Logout', '2026-08-02 13:54:14', '::1', 'Google Chrome', 'Windows'),
(213, 9, 'User Login', '2026-08-02 13:54:26', '::1', 'Google Chrome', 'Windows'),
(214, 9, 'User Logout', '2026-08-02 13:54:41', '::1', 'Google Chrome', 'Windows'),
(215, 1, 'User Login', '2026-08-02 13:54:45', '::1', 'Google Chrome', 'Windows'),
(216, 1, 'Update Department : IT', '2026-08-03 13:51:51', '::1', 'Google Chrome', 'Windows'),
(217, 1, 'Update Department : IT', '2026-08-03 13:54:55', '::1', 'Google Chrome', 'Windows'),
(218, 1, 'Update Department : IT', '2026-08-03 13:58:39', '::1', 'Google Chrome', 'Windows'),
(219, 1, 'Created Department : do', '2026-08-03 14:23:12', '::1', 'Google Chrome', 'Windows'),
(220, 1, 'Update Department : doo', '2026-08-03 14:23:27', '::1', 'Google Chrome', 'Windows'),
(221, 1, 'Deleted Department : doo', '2026-08-03 14:23:31', '::1', 'Google Chrome', 'Windows'),
(222, 1, 'Created Department : hi', '2026-08-03 15:29:15', '::1', 'Google Chrome', 'Windows'),
(223, 1, 'Deleted Department : hi', '2026-08-04 15:32:47', '::1', 'Google Chrome', 'Windows'),
(224, 1, 'Created Department : men', '2026-08-04 17:16:11', '::1', 'Google Chrome', 'Windows'),
(225, 1, 'Update Department : men', '2026-08-04 17:16:23', '::1', 'Google Chrome', 'Windows'),
(226, 1, 'Deleted Department : men', '2026-08-04 17:16:29', '::1', 'Google Chrome', 'Windows'),
(227, 1, 'Created User: firas safe', '2026-08-05 12:22:16', '::1', 'Google Chrome', 'Windows'),
(228, 1, 'Deactivated User: firas safe', '2026-08-05 12:23:45', '::1', 'Google Chrome', 'Windows'),
(229, 1, 'Updated User: farok mohammed', '2026-08-05 12:24:34', '::1', 'Google Chrome', 'Windows'),
(230, 1, 'Updated User: farouk mohammed', '2026-08-05 12:26:02', '::1', 'Google Chrome', 'Windows'),
(231, 1, 'Created Department : HR', '2026-08-05 12:35:30', '::1', 'Google Chrome', 'Windows'),
(232, 1, 'Created Department : Sales', '2026-08-05 12:37:47', '::1', 'Google Chrome', 'Windows'),
(233, 1, 'Activated User: farouk mohammed', '2026-08-05 13:39:22', '::1', 'Google Chrome', 'Windows'),
(234, 1, 'Updated User: Ahmed', '2026-08-05 18:51:30', '::1', 'Google Chrome', 'Windows'),
(235, 1, 'Updated User: Ahmed', '2026-08-05 18:51:47', '::1', 'Google Chrome', 'Windows'),
(236, 1, 'Updated User: Ahmed', '2026-08-05 19:28:51', '::1', 'Google Chrome', 'Windows'),
(237, 1, 'Updated User: yasser', '2026-08-05 19:29:25', '::1', 'Google Chrome', 'Windows'),
(238, 1, 'Updated User: Zaher', '2026-08-08 12:03:47', '::1', 'Google Chrome', 'Windows'),
(239, 1, 'Updated User: waleedsami', '2026-08-08 12:04:29', '::1', 'Google Chrome', 'Windows'),
(240, 1, 'Updated User: moataz', '2026-08-08 12:04:53', '::1', 'Google Chrome', 'Windows'),
(241, 1, 'Updated User: Suleiman Tayser', '2026-08-08 12:05:24', '::1', 'Google Chrome', 'Windows'),
(242, 1, 'Updated User: Hassan Mohammed smer', '2026-08-08 12:05:43', '::1', 'Google Chrome', 'Windows'),
(243, 1, 'Updated User: fadi sami', '2026-08-08 12:06:18', '::1', 'Google Chrome', 'Windows'),
(244, 1, 'Updated User: maram basm', '2026-08-08 12:06:32', '::1', 'Google Chrome', 'Windows'),
(245, 1, 'Updated User: faisal naim', '2026-08-08 12:06:49', '::1', 'Google Chrome', 'Windows'),
(246, 1, 'Updated User: Rami samir', '2026-08-08 12:07:03', '::1', 'Google Chrome', 'Windows'),
(247, 1, 'Updated User: ayman', '2026-08-08 12:07:16', '::1', 'Google Chrome', 'Windows'),
(248, 1, 'Updated User: fahad adnan', '2026-08-08 12:07:28', '::1', 'Google Chrome', 'Windows'),
(249, 1, 'Created User: sary naim', '2026-08-08 13:34:06', '::1', 'Google Chrome', 'Windows'),
(250, 1, 'Created User: tamer mohsen', '2026-08-09 18:54:58', '::1', 'Google Chrome', 'Windows'),
(251, 1, 'User Logout', '2026-08-10 13:13:44', '::1', 'Google Chrome', 'Windows'),
(252, 35, 'User Login', '2026-08-10 13:13:52', '::1', 'Google Chrome', 'Windows'),
(253, 35, 'User Logout', '2026-08-10 13:13:54', '::1', 'Google Chrome', 'Windows'),
(254, 1, 'User Login', '2026-08-10 13:14:02', '::1', 'Google Chrome', 'Windows'),
(255, 1, 'User Logout', '2026-08-10 14:24:38', '::1', 'Google Chrome', 'Windows'),
(256, 9, 'User Login', '2026-08-10 14:24:53', '::1', 'Google Chrome', 'Windows'),
(257, 9, 'User Logout', '2026-08-10 14:33:58', '::1', 'Google Chrome', 'Windows'),
(258, 37, 'User Login', '2026-08-10 14:34:07', '::1', 'Google Chrome', 'Windows'),
(259, 37, 'User Logout', '2026-08-10 14:34:43', '::1', 'Google Chrome', 'Windows'),
(260, 1, 'User Login', '2026-08-10 14:34:52', '::1', 'Google Chrome', 'Windows'),
(261, 1, 'User Logout', '2026-08-11 13:04:33', '::1', 'Google Chrome', 'Windows'),
(262, 9, 'User Login', '2026-08-11 13:04:46', '::1', 'Google Chrome', 'Windows'),
(263, 9, 'User Logout', '2026-08-11 13:06:23', '::1', 'Google Chrome', 'Windows'),
(264, 1, 'User Login', '2026-08-11 13:10:17', '::1', 'Google Chrome', 'Windows'),
(265, 1, 'User Logout', '2026-08-12 12:30:02', '::1', 'Google Chrome', 'Windows'),
(266, 1, 'User Login', '2026-08-12 12:31:09', '::1', 'Google Chrome', 'Windows'),
(267, 1, 'User Logout', '2026-08-12 12:31:41', '::1', 'Google Chrome', 'Windows'),
(268, 14, 'User Login', '2026-08-12 12:31:52', '::1', 'Google Chrome', 'Windows'),
(269, 14, 'User Logout', '2026-08-12 13:42:23', '::1', 'Google Chrome', 'Windows'),
(270, 35, 'User Login', '2026-08-12 13:56:45', '::1', 'Google Chrome', 'Windows'),
(271, 35, 'User Logout', '2026-08-12 13:56:56', '::1', 'Google Chrome', 'Windows'),
(272, 1, 'User Login', '2026-08-12 13:57:05', '::1', 'Google Chrome', 'Windows'),
(273, 1, 'User Login', '2026-08-17 19:18:36', '::1', 'Google Chrome', 'Windows'),
(274, 1, 'User Logout', '2026-08-17 19:20:01', '::1', 'Google Chrome', 'Windows'),
(275, 9, 'User Login', '2026-08-17 19:20:17', '::1', 'Google Chrome', 'Windows'),
(276, 9, 'User Logout', '2026-08-17 19:21:59', '::1', 'Google Chrome', 'Windows'),
(277, 43, 'User Login', '2026-08-17 19:22:09', '::1', 'Google Chrome', 'Windows'),
(278, 43, 'User Logout', '2026-08-17 19:24:01', '::1', 'Google Chrome', 'Windows'),
(279, 9, 'User Login', '2026-08-17 19:24:06', '::1', 'Google Chrome', 'Windows'),
(280, 9, 'User Logout', '2026-08-17 19:24:13', '::1', 'Google Chrome', 'Windows'),
(281, 43, 'User Login', '2026-08-17 19:24:22', '::1', 'Google Chrome', 'Windows'),
(282, 43, 'Created Leave Request #1', '2026-08-17 19:34:52', '::1', 'Google Chrome', 'Windows'),
(283, 43, 'User Logout', '2026-08-17 19:35:16', '::1', 'Google Chrome', 'Windows'),
(284, 9, 'User Login', '2026-08-17 19:35:24', '::1', 'Google Chrome', 'Windows'),
(285, 9, 'User Logout', '2026-08-18 20:07:12', '::1', 'Google Chrome', 'Windows'),
(286, 43, 'User Login', '2026-08-18 20:07:20', '::1', 'Google Chrome', 'Windows'),
(287, 43, 'User Logout', '2026-08-19 13:06:24', '::1', 'Google Chrome', 'Windows'),
(288, 1, 'User Login', '2026-08-19 13:06:29', '::1', 'Google Chrome', 'Windows'),
(289, 1, 'User Logout', '2026-08-19 13:07:00', '::1', 'Google Chrome', 'Windows'),
(290, 9, 'User Login', '2026-08-19 13:07:05', '::1', 'Google Chrome', 'Windows'),
(291, 9, 'User Logout', '2026-08-19 13:07:21', '::1', 'Google Chrome', 'Windows'),
(292, 43, 'User Login', '2026-08-19 13:07:27', '::1', 'Google Chrome', 'Windows'),
(293, 43, 'User Logout', '2026-08-19 13:47:04', '::1', 'Google Chrome', 'Windows'),
(294, 9, 'User Login', '2026-08-19 13:47:09', '::1', 'Google Chrome', 'Windows'),
(295, 9, 'Approved Leave Request #', '2026-08-19 13:47:15', '::1', 'Google Chrome', 'Windows'),
(296, 9, 'User Logout', '2026-08-19 13:47:34', '::1', 'Google Chrome', 'Windows'),
(297, 43, 'User Login', '2026-08-19 13:47:39', '::1', 'Google Chrome', 'Windows'),
(298, 43, 'Created Leave Request #2', '2026-08-22 14:48:33', '::1', 'Google Chrome', 'Windows'),
(299, 43, 'User Logout', '2026-08-22 14:48:35', '::1', 'Google Chrome', 'Windows'),
(300, 9, 'User Login', '2026-08-22 14:48:39', '::1', 'Google Chrome', 'Windows'),
(301, 9, 'Rejected Leave Request #2', '2026-08-22 14:58:46', '::1', 'Google Chrome', 'Windows'),
(302, 9, 'User Logout', '2026-08-22 14:59:06', '::1', 'Google Chrome', 'Windows'),
(303, 43, 'User Login', '2026-08-22 14:59:11', '::1', 'Google Chrome', 'Windows'),
(304, 43, 'User Logout', '2026-08-23 11:48:10', '::1', 'Google Chrome', 'Windows'),
(305, 1, 'User Login', '2026-08-23 11:48:14', '::1', 'Google Chrome', 'Windows'),
(306, 1, 'User Logout', '2026-08-23 11:48:56', '::1', 'Google Chrome', 'Windows'),
(307, 35, 'User Login', '2026-08-23 11:49:09', '::1', 'Google Chrome', 'Windows'),
(308, 35, 'Created Leave Request #3', '2026-08-23 11:49:50', '::1', 'Google Chrome', 'Windows'),
(309, 35, 'User Logout', '2026-08-23 11:50:06', '::1', 'Google Chrome', 'Windows'),
(310, 1, 'User Login', '2026-08-23 11:50:13', '::1', 'Google Chrome', 'Windows'),
(311, 1, 'User Logout', '2026-08-23 11:50:52', '::1', 'Google Chrome', 'Windows'),
(312, 8, 'User Login', '2026-08-23 11:51:26', '::1', 'Google Chrome', 'Windows'),
(313, 8, 'User Logout', '2026-08-23 11:51:45', '::1', 'Google Chrome', 'Windows'),
(314, 1, 'User Login', '2026-08-23 11:51:51', '::1', 'Google Chrome', 'Windows'),
(315, 1, 'User Logout', '2026-08-23 11:52:21', '::1', 'Google Chrome', 'Windows'),
(316, 10, 'User Login', '2026-08-23 11:52:37', '::1', 'Google Chrome', 'Windows'),
(317, 10, 'Approved Leave Request #', '2026-08-23 11:52:58', '::1', 'Google Chrome', 'Windows'),
(318, 10, 'User Logout', '2026-08-23 11:53:15', '::1', 'Google Chrome', 'Windows'),
(319, 8, 'User Login', '2026-08-23 11:53:24', '::1', 'Google Chrome', 'Windows'),
(320, 8, 'User Logout', '2026-08-23 11:53:29', '::1', 'Google Chrome', 'Windows'),
(321, 10, 'User Login', '2026-08-23 11:53:36', '::1', 'Google Chrome', 'Windows'),
(322, 10, 'User Logout', '2026-08-23 11:53:45', '::1', 'Google Chrome', 'Windows'),
(323, 35, 'User Login', '2026-08-23 11:53:58', '::1', 'Google Chrome', 'Windows'),
(324, 35, 'User Logout', '2026-08-23 11:56:04', '::1', 'Google Chrome', 'Windows'),
(325, 1, 'User Login', '2026-08-23 11:56:08', '::1', 'Google Chrome', 'Windows'),
(326, 1, 'User Logout', '2026-08-23 11:56:24', '::1', 'Google Chrome', 'Windows'),
(327, 37, 'User Login', '2026-08-23 11:56:40', '::1', 'Google Chrome', 'Windows'),
(328, 37, 'User Logout', '2026-08-23 11:57:11', '::1', 'Google Chrome', 'Windows'),
(329, 1, 'User Login', '2026-08-23 11:57:18', '::1', 'Google Chrome', 'Windows'),
(330, 1, 'User Logout', '2026-08-23 11:57:53', '::1', 'Google Chrome', 'Windows'),
(331, 41, 'User Login', '2026-08-23 11:58:08', '::1', 'Google Chrome', 'Windows'),
(332, 41, 'Created Leave Request #4', '2026-08-23 11:58:30', '::1', 'Google Chrome', 'Windows'),
(333, 41, 'User Logout', '2026-08-23 11:58:33', '::1', 'Google Chrome', 'Windows'),
(334, 39, 'User Login', '2026-08-23 11:58:52', '::1', 'Google Chrome', 'Windows'),
(335, 39, 'Approved Leave Request #', '2026-08-23 11:59:23', '::1', 'Google Chrome', 'Windows'),
(336, 39, 'User Logout', '2026-08-23 11:59:29', '::1', 'Google Chrome', 'Windows'),
(337, 1, 'User Login', '2026-08-23 11:59:34', '::1', 'Google Chrome', 'Windows'),
(338, 1, 'User Logout', '2026-08-23 14:08:37', '::1', 'Google Chrome', 'Windows'),
(339, 9, 'User Login', '2026-08-23 14:08:45', '::1', 'Google Chrome', 'Windows'),
(340, 9, 'User Logout', '2026-08-23 14:08:59', '::1', 'Google Chrome', 'Windows'),
(341, 1, 'User Login', '2026-08-23 14:09:03', '::1', 'Google Chrome', 'Windows'),
(342, 1, 'User Logout', '2026-08-23 14:16:30', '::1', 'Google Chrome', 'Windows'),
(343, 1, 'User Login', '2026-08-23 14:16:31', '::1', 'Google Chrome', 'Windows'),
(344, 1, 'User Logout', '2026-08-23 19:15:48', '::1', 'Google Chrome', 'Windows'),
(345, 9, 'User Login', '2026-08-23 19:15:55', '::1', 'Google Chrome', 'Windows'),
(346, 9, 'User Logout', '2026-08-23 19:18:22', '::1', 'Google Chrome', 'Windows'),
(347, 1, 'User Login', '2026-08-24 13:58:46', '::1', 'Google Chrome', 'Windows'),
(348, 1, 'User Logout', '2026-08-24 14:00:07', '::1', 'Google Chrome', 'Windows'),
(349, 9, 'User Login', '2026-08-24 14:00:14', '::1', 'Google Chrome', 'Windows'),
(350, 9, 'User Logout', '2026-08-24 14:00:28', '::1', 'Google Chrome', 'Windows'),
(351, 9, 'User Login', '2026-08-24 14:00:33', '::1', 'Google Chrome', 'Windows'),
(352, 9, 'User Logout', '2026-08-24 14:00:40', '::1', 'Google Chrome', 'Windows'),
(353, 43, 'User Login', '2026-08-24 14:00:48', '::1', 'Google Chrome', 'Windows'),
(354, 43, 'User Logout', '2026-08-24 14:01:15', '::1', 'Google Chrome', 'Windows'),
(355, 1, 'User Login', '2026-08-24 14:01:22', '::1', 'Google Chrome', 'Windows'),
(356, 1, 'User Logout', '2026-08-24 14:01:41', '::1', 'Google Chrome', 'Windows'),
(357, 43, 'User Login', '2026-08-24 14:01:47', '::1', 'Google Chrome', 'Windows'),
(358, 43, 'User Logout', '2026-08-24 14:05:37', '::1', 'Google Chrome', 'Windows'),
(359, 1, 'User Login', '2026-08-24 14:05:42', '::1', 'Google Chrome', 'Windows'),
(360, 1, 'User Logout', '2026-08-24 16:56:34', '::1', 'Google Chrome', 'Windows'),
(361, 43, 'User Login', '2026-08-24 16:56:40', '::1', 'Google Chrome', 'Windows'),
(362, 43, 'User Logout', '2026-08-24 16:56:52', '::1', 'Google Chrome', 'Windows'),
(363, 9, 'User Login', '2026-08-24 16:56:58', '::1', 'Google Chrome', 'Windows'),
(364, 9, 'User Logout', '2026-08-24 16:57:26', '::1', 'Google Chrome', 'Windows'),
(365, 43, 'User Login', '2026-08-24 16:57:33', '::1', 'Google Chrome', 'Windows'),
(366, 43, 'User Logout', '2026-08-26 15:02:30', '::1', 'Google Chrome', 'Windows'),
(367, 43, 'User Login', '2026-08-26 15:02:31', '::1', 'Google Chrome', 'Windows'),
(368, 43, 'Employee Check In', '2026-08-26 15:02:36', '::1', 'Google Chrome', 'Windows'),
(369, 43, 'Employee Check Out', '2026-08-26 15:03:17', '::1', 'Google Chrome', 'Windows'),
(370, 43, 'User Logout', '2026-08-26 15:03:22', '::1', 'Google Chrome', 'Windows'),
(371, 9, 'User Login', '2026-08-26 15:03:28', '::1', 'Google Chrome', 'Windows'),
(372, 9, 'User Logout', '2026-08-26 15:04:21', '::1', 'Google Chrome', 'Windows'),
(373, 1, 'User Login', '2026-08-26 15:04:26', '::1', 'Google Chrome', 'Windows'),
(374, 1, 'User Logout', '2026-08-26 15:04:34', '::1', 'Google Chrome', 'Windows'),
(375, 9, 'User Login', '2026-08-26 15:04:40', '::1', 'Google Chrome', 'Windows'),
(376, 9, 'User Logout', '2026-08-26 15:13:08', '::1', 'Google Chrome', 'Windows'),
(377, 9, 'User Login', '2026-08-26 15:13:10', '::1', 'Google Chrome', 'Windows'),
(378, 9, 'User Logout', '2026-08-26 15:13:15', '::1', 'Google Chrome', 'Windows'),
(379, 1, 'User Login', '2026-08-26 15:13:26', '::1', 'Google Chrome', 'Windows'),
(380, 1, 'User Logout', '2026-08-27 11:52:03', '::1', 'Google Chrome', 'Windows'),
(381, 41, 'User Login', '2026-08-27 11:52:44', '::1', 'Google Chrome', 'Windows'),
(382, 41, 'User Logout', '2026-08-27 11:53:15', '::1', 'Google Chrome', 'Windows'),
(383, 1, 'User Login', '2026-08-27 11:53:21', '::1', 'Google Chrome', 'Windows'),
(384, 1, 'User Logout', '2026-08-27 11:53:49', '::1', 'Google Chrome', 'Windows'),
(385, 43, 'User Login', '2026-08-27 11:54:41', '::1', 'Google Chrome', 'Windows'),
(386, 43, 'User Logout', '2026-08-27 11:55:22', '::1', 'Google Chrome', 'Windows'),
(387, 1, 'User Login', '2026-08-27 11:55:29', '::1', 'Google Chrome', 'Windows'),
(388, 1, 'User Logout', '2026-08-27 11:55:57', '::1', 'Google Chrome', 'Windows'),
(389, 14, 'User Login', '2026-08-27 11:56:12', '::1', 'Google Chrome', 'Windows'),
(390, 14, 'Employee Check In', '2026-08-27 12:00:22', '::1', 'Google Chrome', 'Windows'),
(391, 14, 'User Logout', '2026-08-27 12:01:52', '::1', 'Google Chrome', 'Windows'),
(392, 43, 'User Login', '2026-08-27 12:02:00', '::1', 'Google Chrome', 'Windows'),
(393, 43, 'Employee Check In', '2026-08-27 12:02:05', '::1', 'Google Chrome', 'Windows'),
(394, 43, 'User Logout', '2026-08-27 12:02:17', '::1', 'Google Chrome', 'Windows'),
(395, 43, 'User Login', '2026-08-27 12:02:19', '::1', 'Google Chrome', 'Windows'),
(396, 43, 'User Logout', '2026-08-27 12:02:31', '::1', 'Google Chrome', 'Windows'),
(397, 9, 'User Login', '2026-08-27 12:02:43', '::1', 'Google Chrome', 'Windows'),
(398, 9, 'User Logout', '2026-08-27 12:03:13', '::1', 'Google Chrome', 'Windows'),
(399, 35, 'User Login', '2026-08-27 12:03:30', '::1', 'Google Chrome', 'Windows'),
(400, 35, 'Employee Check In', '2026-08-27 12:03:40', '::1', 'Google Chrome', 'Windows'),
(401, 35, 'User Logout', '2026-08-27 14:41:55', '::1', 'Google Chrome', 'Windows'),
(402, 43, 'User Login', '2026-08-27 14:41:58', '::1', 'Google Chrome', 'Windows'),
(403, 43, 'User Logout', '2026-08-27 14:42:10', '::1', 'Google Chrome', 'Windows'),
(404, 9, 'User Login', '2026-08-27 14:42:15', '::1', 'Google Chrome', 'Windows'),
(405, 9, 'User Logout', '2026-08-27 14:42:38', '::1', 'Google Chrome', 'Windows'),
(406, 16, 'User Login', '2026-08-27 14:42:48', '::1', 'Google Chrome', 'Windows'),
(407, 16, 'Employee Check In', '2026-08-27 14:42:53', '::1', 'Google Chrome', 'Windows'),
(408, 16, 'User Logout', '2026-08-27 14:43:13', '::1', 'Google Chrome', 'Windows'),
(409, 16, 'User Login', '2026-08-27 17:56:35', '::1', 'Google Chrome', 'Windows'),
(410, 16, 'User Logout', '2026-08-27 17:56:52', '::1', 'Google Chrome', 'Windows'),
(411, 1, 'User Login', '2026-08-27 17:57:03', '::1', 'Google Chrome', 'Windows'),
(412, 1, 'User Logout', '2026-08-27 17:57:19', '::1', 'Google Chrome', 'Windows'),
(413, 43, 'User Login', '2026-08-27 17:57:26', '::1', 'Google Chrome', 'Windows'),
(414, 43, 'User Logout', '2026-08-27 18:17:08', '::1', 'Google Chrome', 'Windows'),
(415, 9, 'User Login', '2026-08-27 18:17:15', '::1', 'Google Chrome', 'Windows'),
(416, 9, 'User Logout', '2026-08-27 18:23:29', '::1', 'Google Chrome', 'Windows'),
(417, 1, 'User Login', '2026-08-27 18:23:38', '::1', 'Google Chrome', 'Windows'),
(418, 1, 'User Logout', '2026-08-29 15:59:32', '::1', 'Google Chrome', 'Windows'),
(419, 35, 'User Login', '2026-08-29 15:59:38', '::1', 'Google Chrome', 'Windows'),
(420, 35, 'User Logout', '2026-08-29 15:59:48', '::1', 'Google Chrome', 'Windows'),
(421, 1, 'User Login', '2026-08-29 15:59:55', '::1', 'Google Chrome', 'Windows'),
(422, 1, 'User Logout', '2026-08-29 16:09:39', '::1', 'Google Chrome', 'Windows'),
(423, 43, 'User Login', '2026-08-29 16:09:45', '::1', 'Google Chrome', 'Windows'),
(424, 43, 'User Logout', '2026-08-29 16:09:57', '::1', 'Google Chrome', 'Windows'),
(425, 9, 'User Login', '2026-08-29 16:10:11', '::1', 'Google Chrome', 'Windows'),
(426, 9, 'User Logout', '2026-08-29 16:10:16', '::1', 'Google Chrome', 'Windows'),
(427, 1, 'User Login', '2026-08-29 16:10:22', '::1', 'Google Chrome', 'Windows'),
(428, 1, 'User Logout', '2026-08-29 16:11:00', '::1', 'Google Chrome', 'Windows'),
(429, 43, 'User Login', '2026-08-29 16:11:05', '::1', 'Google Chrome', 'Windows'),
(430, 43, 'User Logout', '2026-08-29 16:11:14', '::1', 'Google Chrome', 'Windows'),
(431, 1, 'User Login', '2026-08-29 16:17:12', '::1', 'Google Chrome', 'Windows'),
(432, 1, 'User Logout', '2026-08-29 16:18:32', '::1', 'Google Chrome', 'Windows'),
(433, 35, 'User Login', '2026-08-29 16:18:38', '::1', 'Google Chrome', 'Windows'),
(434, 35, 'User Logout', '2026-08-29 16:18:43', '::1', 'Google Chrome', 'Windows'),
(435, 43, 'User Login', '2026-08-29 16:18:49', '::1', 'Google Chrome', 'Windows'),
(436, 43, 'User Logout', '2026-08-29 16:19:00', '::1', 'Google Chrome', 'Windows'),
(437, 9, 'User Login', '2026-08-29 16:19:22', '::1', 'Google Chrome', 'Windows'),
(438, 9, 'User Logout', '2026-08-29 16:19:29', '::1', 'Google Chrome', 'Windows'),
(439, 1, 'User Login', '2026-08-29 16:19:34', '::1', 'Google Chrome', 'Windows'),
(440, 1, 'User Logout', '2026-08-30 15:09:33', '::1', 'Google Chrome', 'Windows'),
(441, 1, 'User Login', '2026-08-30 15:09:34', '::1', 'Google Chrome', 'Windows'),
(442, 1, 'User Logout', '2026-08-30 15:23:06', '::1', 'Google Chrome', 'Windows'),
(443, 43, 'User Login', '2026-08-30 15:23:11', '::1', 'Google Chrome', 'Windows'),
(444, 43, 'User Logout', '2026-08-30 15:23:51', '::1', 'Google Chrome', 'Windows'),
(445, 9, 'User Login', '2026-08-30 15:23:55', '::1', 'Google Chrome', 'Windows'),
(446, 9, 'User Logout', '2026-08-30 15:24:08', '::1', 'Google Chrome', 'Windows'),
(447, 1, 'User Login', '2026-08-30 15:24:12', '::1', 'Google Chrome', 'Windows'),
(448, 1, 'User Logout', '2026-08-31 15:14:56', '::1', 'Google Chrome', 'Windows'),
(449, 43, 'User Login', '2026-08-31 15:15:01', '::1', 'Google Chrome', 'Windows'),
(450, 43, 'Employee Check In', '2026-08-31 15:15:23', '::1', 'Google Chrome', 'Windows'),
(451, 43, 'User Logout', '2026-08-31 15:15:53', '::1', 'Google Chrome', 'Windows'),
(452, 1, 'User Login', '2026-08-31 15:15:58', '::1', 'Google Chrome', 'Windows'),
(453, 1, 'Deactivated User: Zaher', '2026-08-31 15:26:57', '::1', 'Google Chrome', 'Windows'),
(454, 1, 'Activated User: Zaher', '2026-08-31 15:27:00', '::1', 'Google Chrome', 'Windows'),
(455, 1, 'Updated Announcement #1', '2026-09-01 15:13:07', '::1', 'Google Chrome', 'Windows'),
(456, 1, 'Deleted Announcement #1 - اعلان', '2026-09-01 15:19:04', '::1', 'Google Chrome', 'Windows'),
(457, 1, 'User Logout', '2026-09-05 16:50:26', '::1', 'Google Chrome', 'Windows'),
(458, 35, 'User Login', '2026-09-05 16:50:33', '::1', 'Google Chrome', 'Windows'),
(459, 35, 'User Logout', '2026-09-05 16:51:37', '::1', 'Google Chrome', 'Windows'),
(460, 1, 'User Login', '2026-09-05 16:51:43', '::1', 'Google Chrome', 'Windows'),
(461, 1, 'User Logout', '2026-09-05 16:52:01', '::1', 'Google Chrome', 'Windows'),
(462, 43, 'User Login', '2026-09-05 16:52:13', '::1', 'Google Chrome', 'Windows'),
(463, 43, 'User Logout', '2026-09-06 15:15:37', '::1', 'Google Chrome', 'Windows'),
(464, 1, 'User Login', '2026-09-06 15:15:41', '::1', 'Google Chrome', 'Windows'),
(465, 1, 'User Logout', '2026-09-06 15:48:49', '::1', 'Google Chrome', 'Windows'),
(466, 9, 'User Login', '2026-09-06 15:48:52', '::1', 'Google Chrome', 'Windows'),
(467, 9, 'User Logout', '2026-09-06 15:48:59', '::1', 'Google Chrome', 'Windows'),
(468, 43, 'User Login', '2026-09-06 15:49:04', '::1', 'Google Chrome', 'Windows'),
(469, 43, 'User Logout', '2026-09-06 15:49:53', '::1', 'Google Chrome', 'Windows'),
(470, 1, 'User Login', '2026-09-06 15:49:57', '::1', 'Google Chrome', 'Windows'),
(471, 1, 'User Logout', '2026-09-06 16:00:43', '::1', 'Google Chrome', 'Windows'),
(472, 43, 'User Login', '2026-09-06 16:00:48', '::1', 'Google Chrome', 'Windows'),
(473, 43, 'Updated Profile', '2026-09-06 16:00:58', '::1', 'Google Chrome', 'Windows'),
(474, 43, 'Changed Password', '2026-09-06 16:01:23', '::1', 'Google Chrome', 'Windows'),
(475, 43, 'User Logout', '2026-09-06 16:01:28', '::1', 'Google Chrome', 'Windows'),
(476, 43, 'User Login', '2026-09-06 16:01:50', '::1', 'Google Chrome', 'Windows'),
(477, 43, 'Changed Password', '2026-09-06 16:02:07', '::1', 'Google Chrome', 'Windows'),
(478, 43, 'Updated Profile', '2026-09-06 16:02:11', '::1', 'Google Chrome', 'Windows'),
(479, 43, 'User Logout', '2026-09-06 16:02:25', '::1', 'Google Chrome', 'Windows'),
(480, 1, 'User Login', '2026-09-06 16:02:29', '::1', 'Google Chrome', 'Windows'),
(481, 1, 'User Logout', '2026-09-06 16:32:47', '::1', 'Google Chrome', 'Windows'),
(482, 43, 'User Login', '2026-09-06 16:32:51', '::1', 'Google Chrome', 'Windows'),
(483, 43, 'Employee Check In', '2026-09-06 16:36:33', '::1', 'Google Chrome', 'Windows'),
(484, 43, 'User Logout', '2026-09-06 16:37:56', '::1', 'Google Chrome', 'Windows'),
(485, 1, 'User Login', '2026-09-06 16:38:01', '::1', 'Google Chrome', 'Windows'),
(486, 1, 'User Logout', '2026-09-07 14:24:46', '::1', 'Google Chrome', 'Windows'),
(487, 43, 'User Login', '2026-09-07 14:24:50', '::1', 'Google Chrome', 'Windows'),
(488, 43, 'User Logout', '2026-09-07 14:25:07', '::1', 'Google Chrome', 'Windows'),
(489, 9, 'User Login', '2026-09-07 14:25:13', '::1', 'Google Chrome', 'Windows'),
(490, 9, 'User Logout', '2026-09-07 14:25:30', '::1', 'Google Chrome', 'Windows'),
(491, 1, 'User Login', '2026-09-07 14:25:34', '::1', 'Google Chrome', 'Windows'),
(492, 1, 'Deactivated User: Zaher', '2026-09-07 14:58:12', '::1', 'Google Chrome', 'Windows'),
(493, 1, 'Activated User: Zaher', '2026-09-07 14:58:13', '::1', 'Google Chrome', 'Windows'),
(494, 1, 'User Logout', '2026-09-07 15:16:23', '::1', 'Google Chrome', 'Windows'),
(495, 43, 'User Login', '2026-09-07 15:16:29', '::1', 'Google Chrome', 'Windows'),
(496, 43, 'Employee Check In', '2026-09-07 15:18:37', '::1', 'Google Chrome', 'Windows'),
(497, 43, 'User Logout', '2026-09-07 15:19:21', '::1', 'Google Chrome', 'Windows'),
(498, 1, 'User Login', '2026-09-07 15:19:27', '::1', 'Google Chrome', 'Windows'),
(499, 1, 'Deactivated User: yasser', '2026-09-08 15:20:25', '::1', 'Google Chrome', 'Windows'),
(500, 1, 'Activated User: yasser', '2026-09-08 15:20:26', '::1', 'Google Chrome', 'Windows'),
(501, 1, 'User Logout', '2026-09-08 16:46:41', '::1', 'Google Chrome', 'Windows'),
(502, 9, 'User Login', '2026-09-08 16:46:48', '::1', 'Google Chrome', 'Windows'),
(503, 9, 'User Logout', '2026-09-08 16:54:43', '::1', 'Google Chrome', 'Windows'),
(504, 43, 'User Login', '2026-09-08 16:54:48', '::1', 'Google Chrome', 'Windows'),
(505, 43, 'User Logout', '2026-09-08 16:55:20', '::1', 'Google Chrome', 'Windows'),
(506, 9, 'User Login', '2026-09-08 16:55:26', '::1', 'Google Chrome', 'Windows'),
(507, 9, 'User Logout', '2026-09-08 17:00:02', '::1', 'Google Chrome', 'Windows'),
(508, 1, 'User Login', '2026-09-08 17:00:07', '::1', 'Google Chrome', 'Windows'),
(509, 1, 'User Logout', '2026-09-08 17:00:36', '::1', 'Google Chrome', 'Windows'),
(510, 9, 'User Login', '2026-09-08 17:00:39', '::1', 'Google Chrome', 'Windows'),
(511, 9, 'Created Leave Request #5', '2026-09-08 17:01:06', '::1', 'Google Chrome', 'Windows'),
(512, 9, 'Approved Leave Request #', '2026-09-08 17:01:41', '::1', 'Google Chrome', 'Windows'),
(513, 9, 'User Logout', '2026-09-09 14:32:42', '::1', 'Google Chrome', 'Windows'),
(514, 1, 'User Login', '2026-09-09 14:32:47', '::1', 'Google Chrome', 'Windows'),
(515, 1, 'User Logout', '2026-09-09 14:33:12', '::1', 'Google Chrome', 'Windows'),
(516, 10, 'User Login', '2026-09-09 14:33:18', '::1', 'Google Chrome', 'Windows'),
(517, 10, 'Created Leave Request #6', '2026-09-09 14:33:53', '::1', 'Google Chrome', 'Windows'),
(518, 10, 'User Logout', '2026-09-09 14:34:19', '::1', 'Google Chrome', 'Windows'),
(519, 1, 'User Login', '2026-09-09 14:34:22', '::1', 'Google Chrome', 'Windows'),
(520, 1, 'User Logout', '2026-09-09 14:41:11', '::1', 'Google Chrome', 'Windows'),
(521, 10, 'User Login', '2026-09-09 14:41:18', '::1', 'Google Chrome', 'Windows'),
(522, 10, 'User Logout', '2026-09-09 14:56:16', '::1', 'Google Chrome', 'Windows'),
(523, 1, 'User Login', '2026-09-09 14:56:21', '::1', 'Google Chrome', 'Windows'),
(524, 1, 'Rejected Leave Request #6', '2026-09-09 15:00:51', '::1', 'Google Chrome', 'Windows'),
(525, 1, 'User Logout', '2026-09-09 15:00:55', '::1', 'Google Chrome', 'Windows'),
(526, 10, 'User Login', '2026-09-09 15:01:02', '::1', 'Google Chrome', 'Windows'),
(527, 10, 'User Logout', '2026-09-09 15:01:39', '::1', 'Google Chrome', 'Windows'),
(528, 10, 'User Login', '2026-09-09 15:01:46', '::1', 'Google Chrome', 'Windows'),
(529, 10, 'Created Leave Request #7', '2026-09-09 15:02:08', '::1', 'Google Chrome', 'Windows'),
(530, 10, 'User Logout', '2026-09-09 15:02:13', '::1', 'Google Chrome', 'Windows'),
(531, 1, 'User Login', '2026-09-09 15:02:17', '::1', 'Google Chrome', 'Windows'),
(532, 1, 'Approved Leave Request #', '2026-09-09 15:02:58', '::1', 'Google Chrome', 'Windows'),
(533, 1, 'User Logout', '2026-09-09 15:05:12', '::1', 'Google Chrome', 'Windows'),
(534, 1, 'User Login', '2026-09-09 15:05:14', '::1', 'Google Chrome', 'Windows'),
(535, 1, 'User Logout', '2026-09-12 17:41:12', '::1', 'Google Chrome', 'Windows'),
(536, 16, 'User Login', '2026-09-12 17:41:18', '::1', 'Google Chrome', 'Windows'),
(537, 16, 'Created Leave Request #8', '2026-09-12 17:42:05', '::1', 'Google Chrome', 'Windows'),
(538, 16, 'User Logout', '2026-09-12 17:42:09', '::1', 'Google Chrome', 'Windows'),
(539, 9, 'User Login', '2026-09-12 17:42:14', '::1', 'Google Chrome', 'Windows'),
(540, 9, 'Approved Leave Request #', '2026-09-12 17:42:33', '::1', 'Google Chrome', 'Windows'),
(541, 9, 'User Logout', '2026-09-12 17:42:37', '::1', 'Google Chrome', 'Windows'),
(542, 16, 'User Login', '2026-09-12 17:42:43', '::1', 'Google Chrome', 'Windows'),
(543, 16, 'Employee Check In', '2026-09-13 14:42:01', '::1', 'Google Chrome', 'Windows'),
(544, 16, 'User Logout', '2026-09-13 15:16:20', '::1', 'Google Chrome', 'Windows'),
(545, 43, 'User Login', '2026-09-13 15:16:24', '::1', 'Google Chrome', 'Windows'),
(546, 43, 'Employee Check In', '2026-09-13 15:16:30', '::1', 'Google Chrome', 'Windows'),
(547, 43, 'User Logout', '2026-09-13 15:19:59', '::1', 'Google Chrome', 'Windows'),
(548, 1, 'User Login', '2026-09-13 15:20:05', '::1', 'Google Chrome', 'Windows'),
(549, 1, 'تم إنشاء المستخدم: wasef assaf', '2026-09-13 15:25:43', '::1', 'Google Chrome', 'Windows'),
(550, 1, 'تم إنشاء المستخدم: sameh mohamed', '2026-09-13 16:08:13', '::1', 'Google Chrome', 'Windows'),
(551, 1, 'تم إنشاء المستخدم: laith khaled', '2026-09-13 16:11:37', '::1', 'Google Chrome', 'Windows'),
(552, 1, 'تم إنشاء المستخدم: amen hadi', '2026-09-13 16:14:39', '::1', 'Google Chrome', 'Windows'),
(553, 1, 'تم تحديث بيانات المستخدم: yasser', '2026-09-13 16:21:11', '::1', 'Google Chrome', 'Windows'),
(554, 1, 'User Logout', '2026-09-13 16:21:23', '::1', 'Google Chrome', 'Windows'),
(555, 1, 'User Login', '2026-09-13 16:22:31', '::1', 'Google Chrome', 'Windows'),
(556, 1, 'User Logout', '2026-09-13 16:23:12', '::1', 'Google Chrome', 'Windows'),
(557, 12, 'User Login', '2026-09-13 16:23:22', '::1', 'Google Chrome', 'Windows'),
(558, 12, 'User Logout', '2026-09-13 16:23:29', '::1', 'Google Chrome', 'Windows'),
(559, 1, 'User Login', '2026-09-13 16:23:33', '::1', 'Google Chrome', 'Windows'),
(560, 1, 'تم تحديث بيانات المستخدم: Suleiman Tayser', '2026-09-13 16:24:12', '::1', 'Google Chrome', 'Windows'),
(561, 1, 'User Logout', '2026-09-13 16:24:16', '::1', 'Google Chrome', 'Windows'),
(562, 10, 'User Login', '2026-09-13 16:24:25', '::1', 'Google Chrome', 'Windows'),
(563, 10, 'User Logout', '2026-09-13 16:24:49', '::1', 'Google Chrome', 'Windows'),
(564, 1, 'User Login', '2026-09-13 16:24:55', '::1', 'Google Chrome', 'Windows'),
(565, 1, 'تم تحديث بيانات المستخدم: waleed sami', '2026-09-13 16:25:30', '::1', 'Google Chrome', 'Windows'),
(566, 1, 'تم تحديث بيانات المستخدم: maram naser', '2026-09-13 16:25:52', '::1', 'Google Chrome', 'Windows'),
(567, 1, 'تم تحديث بيانات المستخدم: ayman', '2026-09-13 16:26:17', '::1', 'Google Chrome', 'Windows'),
(568, 1, 'تم تحديث بيانات المستخدم: omar ahmed', '2026-09-13 16:26:32', '::1', 'Google Chrome', 'Windows'),
(569, 1, 'تم تحديث بيانات المستخدم: fadi sami', '2026-09-13 16:26:48', '::1', 'Google Chrome', 'Windows'),
(570, 1, 'تم تحديث بيانات المستخدم: rawan salah', '2026-09-13 16:27:06', '::1', 'Google Chrome', 'Windows'),
(571, 1, 'تم تحديث بيانات المستخدم: tamer mohsen', '2026-09-13 16:27:18', '::1', 'Google Chrome', 'Windows'),
(572, 1, 'تم تحديث بيانات المستخدم: rawan salah', '2026-09-13 16:28:04', '::1', 'Google Chrome', 'Windows'),
(573, 1, 'User Logout', '2026-09-13 16:28:55', '::1', 'Google Chrome', 'Windows'),
(574, 43, 'User Login', '2026-09-13 16:28:59', '::1', 'Google Chrome', 'Windows'),
(575, 43, 'User Logout', '2026-09-13 16:37:27', '::1', 'Google Chrome', 'Windows'),
(576, 1, 'User Login', '2026-09-13 16:37:31', '::1', 'Google Chrome', 'Windows'),
(577, 1, 'User Logout', '2026-09-16 16:10:52', '::1', 'Google Chrome', 'Windows'),
(578, 43, 'User Login', '2026-09-16 16:10:57', '::1', 'Google Chrome', 'Windows'),
(579, 43, 'تم تسجيل حضور الموظف', '2026-09-16 16:11:04', '::1', 'Google Chrome', 'Windows'),
(580, 43, 'User Logout', '2026-09-16 16:23:41', '::1', 'Google Chrome', 'Windows'),
(581, 1, 'User Login', '2026-09-16 16:23:46', '::1', 'Google Chrome', 'Windows'),
(582, 1, 'Updated Announcement #2', '2026-09-16 16:37:47', '::1', 'Google Chrome', 'Windows'),
(583, 1, 'User Logout', '2026-09-19 15:53:11', '::1', 'Google Chrome', 'Windows'),
(584, 43, 'User Login', '2026-09-19 15:53:16', '::1', 'Google Chrome', 'Windows'),
(585, 43, 'Updated Profile', '2026-09-19 16:50:08', '::1', 'Google Chrome', 'Windows'),
(586, 43, 'User Logout', '2026-09-19 16:50:18', '::1', 'Google Chrome', 'Windows'),
(587, 1, 'User Login', '2026-09-19 16:50:24', '::1', 'Google Chrome', 'Windows'),
(588, 1, 'User Logout', '2026-09-19 16:50:49', '::1', 'Google Chrome', 'Windows'),
(589, 35, 'User Login', '2026-09-19 16:50:55', '::1', 'Google Chrome', 'Windows'),
(590, 35, 'Updated Profile', '2026-09-19 16:51:02', '::1', 'Google Chrome', 'Windows'),
(591, 35, 'User Logout', '2026-09-19 16:51:05', '::1', 'Google Chrome', 'Windows'),
(592, 39, 'User Login', '2026-09-19 16:51:08', '::1', 'Google Chrome', 'Windows'),
(593, 39, 'Updated Profile', '2026-09-19 16:51:13', '::1', 'Google Chrome', 'Windows'),
(594, 39, 'User Logout', '2026-09-19 16:51:14', '::1', 'Google Chrome', 'Windows'),
(595, 9, 'User Login', '2026-09-19 16:51:19', '::1', 'Google Chrome', 'Windows'),
(596, 9, 'User Logout', '2026-09-19 16:51:24', '::1', 'Google Chrome', 'Windows'),
(597, 16, 'User Login', '2026-09-19 16:51:42', '::1', 'Google Chrome', 'Windows'),
(598, 16, 'Updated Profile', '2026-09-19 16:51:47', '::1', 'Google Chrome', 'Windows'),
(599, 16, 'User Logout', '2026-09-19 16:51:48', '::1', 'Google Chrome', 'Windows'),
(600, 37, 'User Login', '2026-09-19 16:52:00', '::1', 'Google Chrome', 'Windows');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `created_at`, `ip_address`, `browser`, `operating_system`) VALUES
(601, 37, 'Updated Profile', '2026-09-19 16:52:06', '::1', 'Google Chrome', 'Windows'),
(602, 37, 'User Logout', '2026-09-19 16:52:07', '::1', 'Google Chrome', 'Windows'),
(603, 16, 'User Login', '2026-09-19 16:52:15', '::1', 'Google Chrome', 'Windows'),
(604, 16, 'User Logout', '2026-09-19 16:52:17', '::1', 'Google Chrome', 'Windows'),
(605, 16, 'User Login', '2026-09-19 16:52:19', '::1', 'Google Chrome', 'Windows'),
(606, 16, 'User Logout', '2026-09-19 16:52:24', '::1', 'Google Chrome', 'Windows'),
(607, 37, 'User Login', '2026-09-19 16:52:29', '::1', 'Google Chrome', 'Windows'),
(608, 37, 'User Logout', '2026-09-19 16:52:32', '::1', 'Google Chrome', 'Windows'),
(609, 10, 'User Login', '2026-09-19 16:52:37', '::1', 'Google Chrome', 'Windows'),
(610, 10, 'User Logout', '2026-09-19 16:52:45', '::1', 'Google Chrome', 'Windows'),
(611, 8, 'User Login', '2026-09-19 16:53:02', '::1', 'Google Chrome', 'Windows'),
(612, 8, 'User Logout', '2026-09-19 16:53:09', '::1', 'Google Chrome', 'Windows'),
(613, 1, 'User Login', '2026-09-19 16:53:25', '::1', 'Google Chrome', 'Windows'),
(614, 1, 'User Logout', '2026-09-19 16:53:43', '::1', 'Google Chrome', 'Windows'),
(615, 2, 'User Login', '2026-09-19 16:53:54', '::1', 'Google Chrome', 'Windows'),
(616, 2, 'Updated Profile', '2026-09-19 16:54:00', '::1', 'Google Chrome', 'Windows'),
(617, 2, 'User Logout', '2026-09-19 16:54:02', '::1', 'Google Chrome', 'Windows'),
(618, 1, 'User Login', '2026-09-19 16:54:06', '::1', 'Google Chrome', 'Windows'),
(619, 1, 'User Logout', '2026-09-19 16:54:16', '::1', 'Google Chrome', 'Windows'),
(620, 1, 'User Login', '2026-09-19 16:55:10', '::1', 'Google Chrome', 'Windows'),
(621, 1, 'User Logout', '2026-09-19 16:55:22', '::1', 'Google Chrome', 'Windows'),
(622, 8, 'User Login', '2026-09-19 16:55:33', '::1', 'Google Chrome', 'Windows'),
(623, 8, 'Updated Profile', '2026-09-19 16:55:39', '::1', 'Google Chrome', 'Windows'),
(624, 8, 'User Logout', '2026-09-19 16:55:41', '::1', 'Google Chrome', 'Windows'),
(625, 1, 'User Login', '2026-09-19 16:55:45', '::1', 'Google Chrome', 'Windows'),
(626, 1, 'User Logout', '2026-09-19 16:56:06', '::1', 'Google Chrome', 'Windows'),
(627, 13, 'User Login', '2026-09-19 16:56:26', '::1', 'Google Chrome', 'Windows'),
(628, 13, 'Updated Profile', '2026-09-19 16:56:36', '::1', 'Google Chrome', 'Windows'),
(629, 13, 'User Logout', '2026-09-19 16:56:37', '::1', 'Google Chrome', 'Windows'),
(630, 1, 'User Login', '2026-09-19 16:56:40', '::1', 'Google Chrome', 'Windows'),
(631, 1, 'User Logout', '2026-09-19 16:56:52', '::1', 'Google Chrome', 'Windows'),
(632, 14, 'User Login', '2026-09-19 16:57:04', '::1', 'Google Chrome', 'Windows'),
(633, 14, 'Updated Profile', '2026-09-19 16:57:09', '::1', 'Google Chrome', 'Windows'),
(634, 14, 'User Logout', '2026-09-19 16:57:10', '::1', 'Google Chrome', 'Windows'),
(635, 1, 'User Login', '2026-09-19 16:57:13', '::1', 'Google Chrome', 'Windows'),
(636, 1, 'User Logout', '2026-09-19 17:22:23', '::1', 'Google Chrome', 'Windows'),
(637, 12, 'User Login', '2026-09-19 17:22:32', '::1', 'Google Chrome', 'Windows'),
(638, 12, 'User Logout', '2026-09-19 17:22:43', '::1', 'Google Chrome', 'Windows'),
(639, 1, 'User Login', '2026-09-19 17:22:53', '::1', 'Google Chrome', 'Windows'),
(640, 1, 'User Logout', '2026-09-19 17:23:10', '::1', 'Google Chrome', 'Windows'),
(641, 15, 'User Login', '2026-09-19 17:23:34', '::1', 'Google Chrome', 'Windows'),
(642, 15, 'Updated Profile', '2026-09-19 17:23:39', '::1', 'Google Chrome', 'Windows'),
(643, 15, 'User Logout', '2026-09-19 17:23:42', '::1', 'Google Chrome', 'Windows'),
(644, 1, 'User Login', '2026-09-19 17:23:47', '::1', 'Google Chrome', 'Windows'),
(645, 1, 'User Logout', '2026-09-19 17:23:59', '::1', 'Google Chrome', 'Windows'),
(646, 30, 'User Login', '2026-09-19 17:24:08', '::1', 'Google Chrome', 'Windows'),
(647, 30, 'Updated Profile', '2026-09-19 17:24:15', '::1', 'Google Chrome', 'Windows'),
(648, 30, 'User Logout', '2026-09-19 17:24:16', '::1', 'Google Chrome', 'Windows'),
(649, 1, 'User Login', '2026-09-19 17:24:21', '::1', 'Google Chrome', 'Windows'),
(650, 1, 'User Logout', '2026-09-19 17:24:34', '::1', 'Google Chrome', 'Windows'),
(651, 31, 'User Login', '2026-09-19 17:24:45', '::1', 'Google Chrome', 'Windows'),
(652, 31, 'Updated Profile', '2026-09-19 17:25:01', '::1', 'Google Chrome', 'Windows'),
(653, 31, 'User Logout', '2026-09-19 17:25:03', '::1', 'Google Chrome', 'Windows'),
(654, 1, 'User Login', '2026-09-19 17:25:06', '::1', 'Google Chrome', 'Windows'),
(655, 1, 'User Logout', '2026-09-19 17:25:21', '::1', 'Google Chrome', 'Windows'),
(656, 1, 'User Login', '2026-09-19 17:34:36', '::1', 'Google Chrome', 'Windows'),
(657, 1, 'User Logout', '2026-09-19 17:35:20', '::1', 'Google Chrome', 'Windows'),
(658, 1, 'User Login', '2026-09-19 17:35:38', '::1', 'Google Chrome', 'Windows'),
(659, 1, 'User Logout', '2026-09-19 17:35:40', '::1', 'Google Chrome', 'Windows'),
(660, 34, 'User Login', '2026-09-19 17:35:50', '::1', 'Google Chrome', 'Windows'),
(661, 34, 'Updated Profile', '2026-09-19 17:35:56', '::1', 'Google Chrome', 'Windows'),
(662, 34, 'User Logout', '2026-09-19 17:35:57', '::1', 'Google Chrome', 'Windows'),
(663, 1, 'User Login', '2026-09-19 17:36:00', '::1', 'Google Chrome', 'Windows'),
(664, 1, 'User Logout', '2026-09-19 17:36:17', '::1', 'Google Chrome', 'Windows'),
(665, 36, 'User Login', '2026-09-19 17:36:28', '::1', 'Google Chrome', 'Windows'),
(666, 36, 'Updated Profile', '2026-09-19 17:36:34', '::1', 'Google Chrome', 'Windows'),
(667, 36, 'User Logout', '2026-09-19 17:36:35', '::1', 'Google Chrome', 'Windows'),
(668, 1, 'User Login', '2026-09-19 17:36:37', '::1', 'Google Chrome', 'Windows'),
(669, 1, 'User Logout', '2026-09-19 17:36:58', '::1', 'Google Chrome', 'Windows'),
(670, 40, 'User Login', '2026-09-19 17:37:09', '::1', 'Google Chrome', 'Windows'),
(671, 40, 'Updated Profile', '2026-09-19 17:37:14', '::1', 'Google Chrome', 'Windows'),
(672, 40, 'User Logout', '2026-09-19 17:37:16', '::1', 'Google Chrome', 'Windows'),
(673, 1, 'User Login', '2026-09-19 17:37:19', '::1', 'Google Chrome', 'Windows'),
(674, 1, 'User Logout', '2026-09-19 17:37:33', '::1', 'Google Chrome', 'Windows'),
(675, 38, 'User Login', '2026-09-19 17:37:42', '::1', 'Google Chrome', 'Windows'),
(676, 38, 'Updated Profile', '2026-09-19 17:37:48', '::1', 'Google Chrome', 'Windows'),
(677, 38, 'User Logout', '2026-09-19 17:37:49', '::1', 'Google Chrome', 'Windows'),
(678, 1, 'User Login', '2026-09-19 17:37:52', '::1', 'Google Chrome', 'Windows'),
(679, 1, 'User Logout', '2026-09-19 17:38:05', '::1', 'Google Chrome', 'Windows'),
(680, 41, 'User Login', '2026-09-19 17:38:13', '::1', 'Google Chrome', 'Windows'),
(681, 41, 'Updated Profile', '2026-09-19 17:38:17', '::1', 'Google Chrome', 'Windows'),
(682, 41, 'User Logout', '2026-09-19 17:38:19', '::1', 'Google Chrome', 'Windows'),
(683, 1, 'User Login', '2026-09-19 17:38:21', '::1', 'Google Chrome', 'Windows'),
(684, 1, 'User Logout', '2026-09-19 17:38:36', '::1', 'Google Chrome', 'Windows'),
(685, 1, 'User Login', '2026-09-19 17:39:03', '::1', 'Google Chrome', 'Windows'),
(686, 1, 'User Logout', '2026-09-19 17:39:14', '::1', 'Google Chrome', 'Windows'),
(687, 42, 'User Login', '2026-09-19 17:39:24', '::1', 'Google Chrome', 'Windows'),
(688, 42, 'Updated Profile', '2026-09-19 17:39:30', '::1', 'Google Chrome', 'Windows'),
(689, 42, 'User Logout', '2026-09-19 17:39:31', '::1', 'Google Chrome', 'Windows'),
(690, 1, 'User Login', '2026-09-19 17:39:33', '::1', 'Google Chrome', 'Windows'),
(691, 1, 'User Logout', '2026-09-19 17:39:52', '::1', 'Google Chrome', 'Windows'),
(692, 44, 'User Login', '2026-09-19 17:40:06', '::1', 'Google Chrome', 'Windows'),
(693, 44, 'Updated Profile', '2026-09-19 17:40:12', '::1', 'Google Chrome', 'Windows'),
(694, 44, 'User Logout', '2026-09-19 17:40:13', '::1', 'Google Chrome', 'Windows'),
(695, 1, 'User Login', '2026-09-19 17:40:15', '::1', 'Google Chrome', 'Windows'),
(696, 1, 'User Logout', '2026-09-19 17:40:26', '::1', 'Google Chrome', 'Windows'),
(697, 45, 'User Login', '2026-09-19 17:40:36', '::1', 'Google Chrome', 'Windows'),
(698, 45, 'Updated Profile', '2026-09-19 17:40:42', '::1', 'Google Chrome', 'Windows'),
(699, 45, 'Updated Profile', '2026-09-19 17:40:47', '::1', 'Google Chrome', 'Windows'),
(700, 45, 'User Logout', '2026-09-19 17:40:49', '::1', 'Google Chrome', 'Windows'),
(701, 1, 'User Login', '2026-09-19 17:40:51', '::1', 'Google Chrome', 'Windows'),
(702, 1, 'User Logout', '2026-09-19 17:41:01', '::1', 'Google Chrome', 'Windows'),
(703, 46, 'User Login', '2026-09-19 17:41:09', '::1', 'Google Chrome', 'Windows'),
(704, 46, 'Updated Profile', '2026-09-19 17:41:14', '::1', 'Google Chrome', 'Windows'),
(705, 46, 'User Logout', '2026-09-19 17:41:16', '::1', 'Google Chrome', 'Windows'),
(706, 1, 'User Login', '2026-09-19 17:41:18', '::1', 'Google Chrome', 'Windows'),
(707, 1, 'User Logout', '2026-09-19 17:41:29', '::1', 'Google Chrome', 'Windows'),
(708, 47, 'User Login', '2026-09-19 17:41:38', '::1', 'Google Chrome', 'Windows'),
(709, 47, 'Updated Profile', '2026-09-19 17:41:43', '::1', 'Google Chrome', 'Windows'),
(710, 47, 'User Logout', '2026-09-19 17:41:47', '::1', 'Google Chrome', 'Windows'),
(711, 1, 'User Login', '2026-09-19 17:41:49', '::1', 'Google Chrome', 'Windows'),
(712, 1, 'User Logout', '2026-09-19 17:42:04', '::1', 'Google Chrome', 'Windows'),
(713, 48, 'User Login', '2026-09-19 17:42:12', '::1', 'Google Chrome', 'Windows'),
(714, 48, 'Updated Profile', '2026-09-19 17:42:17', '::1', 'Google Chrome', 'Windows'),
(715, 48, 'User Logout', '2026-09-19 17:42:19', '::1', 'Google Chrome', 'Windows'),
(716, 1, 'User Login', '2026-09-19 17:42:21', '::1', 'Google Chrome', 'Windows'),
(717, 1, 'User Logout', '2026-09-19 17:42:36', '::1', 'Google Chrome', 'Windows'),
(718, 49, 'User Login', '2026-09-19 17:42:44', '::1', 'Google Chrome', 'Windows'),
(719, 49, 'Updated Profile', '2026-09-19 17:42:51', '::1', 'Google Chrome', 'Windows'),
(720, 49, 'User Logout', '2026-09-19 17:42:52', '::1', 'Google Chrome', 'Windows'),
(721, 1, 'User Login', '2026-09-19 17:42:54', '::1', 'Google Chrome', 'Windows'),
(722, 1, 'User Logout', '2026-09-19 17:43:08', '::1', 'Google Chrome', 'Windows'),
(723, 50, 'User Login', '2026-09-19 17:43:17', '::1', 'Google Chrome', 'Windows'),
(724, 50, 'Updated Profile', '2026-09-19 17:43:22', '::1', 'Google Chrome', 'Windows'),
(725, 50, 'User Logout', '2026-09-19 17:43:23', '::1', 'Google Chrome', 'Windows'),
(726, 1, 'User Login', '2026-09-19 17:43:25', '::1', 'Google Chrome', 'Windows'),
(727, 1, 'User Logout', '2026-09-19 17:43:58', '::1', 'Google Chrome', 'Windows'),
(728, 1, 'User Login', '2026-09-19 17:44:15', '::1', 'Google Chrome', 'Windows'),
(729, 1, 'User Logout', '2026-09-20 16:43:34', '::1', 'Google Chrome', 'Windows'),
(730, 3, 'User Login', '2026-09-20 17:15:01', '::1', 'Google Chrome', 'Windows'),
(731, 3, 'Changed Password', '2026-09-20 17:15:23', '::1', 'Google Chrome', 'Windows'),
(732, 3, 'User Logout', '2026-09-20 17:15:29', '::1', 'Google Chrome', 'Windows'),
(733, 1, 'User Login', '2026-09-20 17:15:34', '::1', 'Google Chrome', 'Windows'),
(734, 1, 'تم تحديث بيانات المستخدم: waleed mohammed', '2026-09-20 17:16:32', '::1', 'Google Chrome', 'Windows'),
(735, 1, 'User Logout', '2026-09-20 17:16:48', '::1', 'Google Chrome', 'Windows'),
(736, 33, 'User Login', '2026-09-20 17:18:05', '::1', 'Google Chrome', 'Windows'),
(737, 33, 'Changed Password', '2026-09-20 17:18:25', '::1', 'Google Chrome', 'Windows'),
(738, 33, 'Updated Profile', '2026-09-20 17:18:32', '::1', 'Google Chrome', 'Windows'),
(739, 33, 'User Logout', '2026-09-20 17:18:34', '::1', 'Google Chrome', 'Windows'),
(740, 1, 'User Login', '2026-09-20 17:18:36', '::1', 'Google Chrome', 'Windows'),
(741, 1, 'User Logout', '2026-09-20 17:19:55', '::1', 'Google Chrome', 'Windows'),
(742, 12, 'User Login', '2026-09-20 17:20:06', '::1', 'Google Chrome', 'Windows'),
(743, 12, 'Updated Profile', '2026-09-20 17:20:31', '::1', 'Google Chrome', 'Windows'),
(744, 12, 'Updated Profile', '2026-09-20 17:20:34', '::1', 'Google Chrome', 'Windows'),
(745, 12, 'User Logout', '2026-09-20 17:20:38', '::1', 'Google Chrome', 'Windows'),
(746, 1, 'User Login', '2026-09-20 17:20:40', '::1', 'Google Chrome', 'Windows'),
(747, 1, 'User Logout', '2026-09-20 17:21:02', '::1', 'Google Chrome', 'Windows'),
(748, 10, 'User Login', '2026-09-20 17:21:17', '::1', 'Google Chrome', 'Windows'),
(749, 10, 'Updated Profile', '2026-09-20 17:21:23', '::1', 'Google Chrome', 'Windows'),
(750, 10, 'User Logout', '2026-09-20 17:21:25', '::1', 'Google Chrome', 'Windows'),
(751, 1, 'User Login', '2026-09-20 17:21:31', '::1', 'Google Chrome', 'Windows'),
(752, 1, 'User Logout', '2026-09-21 16:30:21', '::1', 'Google Chrome', 'Windows'),
(753, 1, 'User Login', '2026-09-21 16:30:23', '::1', 'Google Chrome', 'Windows'),
(754, 1, 'User Logout', '2026-09-22 16:33:29', '::1', 'Google Chrome', 'Windows'),
(755, 39, 'User Login', '2026-09-22 16:33:36', '::1', 'Google Chrome', 'Windows'),
(756, 39, 'تم تسجيل حضور الموظف', '2026-09-22 16:34:28', '::1', 'Google Chrome', 'Windows'),
(757, 39, 'User Logout', '2026-09-23 15:28:00', '::1', 'Google Chrome', 'Windows'),
(758, 1, 'User Login', '2026-09-23 15:28:05', '::1', 'Google Chrome', 'Windows'),
(759, 1, 'User Logout', '2026-09-23 15:31:52', '::1', 'Google Chrome', 'Windows'),
(760, 9, 'User Login', '2026-09-23 15:31:57', '::1', 'Google Chrome', 'Windows'),
(761, 9, 'User Logout', '2026-09-23 15:32:16', '::1', 'Google Chrome', 'Windows'),
(762, 43, 'User Login', '2026-09-23 15:32:29', '::1', 'Google Chrome', 'Windows'),
(763, 43, 'تم تسجيل حضور الموظف - سجل رقم 13', '2026-09-23 15:45:27', '::1', 'Google Chrome', 'Windows'),
(764, 43, 'تم تسجيل خروج الموظف - سجل رقم 13 - وقت العمل 1 دقيقة', '2026-09-23 15:46:19', '::1', 'Google Chrome', 'Windows'),
(765, 43, 'User Logout', '2026-09-23 15:46:31', '::1', 'Google Chrome', 'Windows'),
(766, 1, 'User Login', '2026-09-23 15:46:36', '::1', 'Google Chrome', 'Windows'),
(767, 1, 'User Logout', '2026-09-23 15:46:50', '::1', 'Google Chrome', 'Windows'),
(768, 1, 'User Login', '2026-09-23 15:49:26', '::1', 'Google Chrome', 'Windows'),
(769, 1, 'User Logout', '2026-09-23 15:49:42', '::1', 'Google Chrome', 'Windows'),
(770, 43, 'User Login', '2026-09-23 15:49:46', '::1', 'Google Chrome', 'Windows'),
(771, 43, 'User Logout', '2026-09-23 15:50:08', '::1', 'Google Chrome', 'Windows'),
(772, 1, 'User Login', '2026-09-23 15:50:12', '::1', 'Google Chrome', 'Windows'),
(773, 1, 'User Logout', '2026-09-23 15:52:31', '::1', 'Google Chrome', 'Windows'),
(774, 12, 'User Login', '2026-09-23 15:52:47', '::1', 'Google Chrome', 'Windows'),
(775, 12, 'User Logout', '2026-09-23 15:53:19', '::1', 'Google Chrome', 'Windows'),
(776, 1, 'User Login', '2026-09-23 15:53:22', '::1', 'Google Chrome', 'Windows'),
(777, 1, 'User Logout', '2026-09-23 16:12:48', '::1', 'Google Chrome', 'Windows'),
(778, 9, 'User Login', '2026-09-23 16:12:53', '::1', 'Google Chrome', 'Windows'),
(779, 9, 'User Logout', '2026-09-23 16:13:17', '::1', 'Google Chrome', 'Windows'),
(780, 43, 'User Login', '2026-09-23 16:13:23', '::1', 'Google Chrome', 'Windows'),
(781, 43, 'User Logout', '2026-09-23 16:13:39', '::1', 'Google Chrome', 'Windows'),
(782, 1, 'User Login', '2026-09-23 16:13:47', '::1', 'Google Chrome', 'Windows'),
(783, 1, 'User Logout', '2026-09-23 16:20:36', '::1', 'Google Chrome', 'Windows'),
(784, 1, 'User Login', '2026-09-23 16:30:38', '::1', 'Google Chrome', 'Windows'),
(785, 1, 'User Logout', '2026-09-23 16:30:43', '::1', 'Google Chrome', 'Windows'),
(786, 1, 'User Login', '2026-09-23 16:33:03', '::1', 'Google Chrome', 'Windows'),
(787, 1, 'User Logout', '2026-09-23 16:33:09', '::1', 'Google Chrome', 'Windows'),
(788, 1, 'User Login', '2026-09-25 15:05:16', '::1', 'Google Chrome', 'Windows'),
(789, 1, 'User Logout', '2026-09-25 15:07:26', '::1', 'Google Chrome', 'Windows'),
(790, 43, 'User Login', '2026-09-25 15:07:30', '::1', 'Google Chrome', 'Windows'),
(791, 43, 'User Logout', '2026-09-25 15:07:39', '::1', 'Google Chrome', 'Windows'),
(792, 1, 'User Login', '2026-09-25 15:07:43', '::1', 'Google Chrome', 'Windows'),
(793, 1, 'User Logout', '2026-09-26 07:31:45', '::1', 'Google Chrome', 'Windows'),
(794, 43, 'User Login', '2026-09-26 07:31:49', '::1', 'Google Chrome', 'Windows'),
(795, 43, 'تم تسجيل حضور الموظف - سجل رقم 14', '2026-09-26 07:31:55', '::1', 'Google Chrome', 'Windows'),
(796, 1, 'User Login', '2026-09-26 18:53:47', '::1', 'Google Chrome', 'Windows'),
(797, 1, 'User Logout', '2026-09-27 08:23:38', '::1', 'Google Chrome', 'Windows'),
(798, 35, 'User Login', '2026-09-27 08:23:44', '::1', 'Google Chrome', 'Windows'),
(799, 35, 'تم تسجيل حضور الموظف - سجل رقم 15', '2026-09-27 08:23:48', '::1', 'Google Chrome', 'Windows'),
(800, 35, 'تم تسجيل خروج الموظف - سجل رقم 15 - وقت العمل 445 دقيقة', '2026-09-27 15:48:36', '::1', 'Google Chrome', 'Windows'),
(801, 35, 'User Logout', '2026-09-27 15:48:50', '::1', 'Google Chrome', 'Windows'),
(802, 1, 'User Login', '2026-09-27 15:48:53', '::1', 'Google Chrome', 'Windows'),
(803, 1, 'User Logout', '2026-09-28 16:12:53', '::1', 'Google Chrome', 'Windows'),
(804, 35, 'User Login', '2026-09-28 16:12:57', '::1', 'Google Chrome', 'Windows'),
(805, 35, 'User Logout', '2026-09-28 16:13:13', '::1', 'Google Chrome', 'Windows'),
(806, 1, 'User Login', '2026-09-28 16:13:17', '::1', 'Google Chrome', 'Windows'),
(807, 1, 'User Logout', '2026-09-28 16:13:32', '::1', 'Google Chrome', 'Windows'),
(808, 35, 'User Login', '2026-09-28 16:13:35', '::1', 'Google Chrome', 'Windows'),
(809, 35, 'User Logout', '2026-09-28 16:13:49', '::1', 'Google Chrome', 'Windows'),
(810, 1, 'User Login', '2026-09-28 16:13:52', '::1', 'Google Chrome', 'Windows'),
(811, 1, 'User Logout', '2026-09-28 16:14:03', '::1', 'Google Chrome', 'Windows'),
(812, 1, 'User Login', '2026-09-28 16:14:04', '::1', 'Google Chrome', 'Windows'),
(813, 1, 'User Logout', '2026-09-28 16:14:21', '::1', 'Google Chrome', 'Windows'),
(814, 35, 'User Login', '2026-09-28 16:14:25', '::1', 'Google Chrome', 'Windows'),
(815, 35, 'تم تسجيل حضور الموظف - سجل رقم 16', '2026-09-28 16:14:52', '::1', 'Google Chrome', 'Windows'),
(816, 35, 'Created Leave Request #9', '2026-09-28 16:22:48', '::1', 'Google Chrome', 'Windows'),
(817, 35, 'User Logout', '2026-09-28 16:23:04', '::1', 'Google Chrome', 'Windows'),
(818, 1, 'User Login', '2026-09-28 16:23:07', '::1', 'Google Chrome', 'Windows'),
(819, 1, 'User Logout', '2026-09-28 16:23:42', '::1', 'Google Chrome', 'Windows'),
(820, 12, 'User Login', '2026-09-28 16:23:59', '::1', 'Google Chrome', 'Windows'),
(821, 12, 'Approved Leave Request #', '2026-09-28 16:24:42', '::1', 'Google Chrome', 'Windows'),
(822, 12, 'User Logout', '2026-09-28 16:24:47', '::1', 'Google Chrome', 'Windows'),
(823, 35, 'User Login', '2026-09-28 16:24:54', '::1', 'Google Chrome', 'Windows'),
(824, 35, 'تم تسجيل خروج الموظف - سجل رقم 16 - وقت العمل 10 دقيقة', '2026-09-28 16:25:08', '::1', 'Google Chrome', 'Windows'),
(825, 35, 'User Logout', '2026-09-28 16:27:05', '::1', 'Google Chrome', 'Windows'),
(826, 12, 'User Login', '2026-09-28 16:27:21', '::1', 'Google Chrome', 'Windows'),
(827, 12, 'User Logout', '2026-09-28 16:29:57', '::1', 'Google Chrome', 'Windows'),
(828, 1, 'User Login', '2026-09-28 16:30:01', '::1', 'Google Chrome', 'Windows'),
(829, 1, 'User Logout', '2026-09-28 16:32:53', '::1', 'Google Chrome', 'Windows'),
(830, 9, 'User Login', '2026-09-28 16:32:58', '::1', 'Google Chrome', 'Windows'),
(831, 9, 'User Logout', '2026-09-28 16:33:32', '::1', 'Google Chrome', 'Windows'),
(832, 1, 'User Login', '2026-09-28 16:33:35', '::1', 'Google Chrome', 'Windows'),
(833, 1, 'User Logout', '2026-09-29 07:16:16', '::1', 'Google Chrome', 'Windows'),
(834, 43, 'User Login', '2026-09-29 07:16:23', '::1', 'Google Chrome', 'Windows'),
(835, 43, 'تم تسجيل حضور الموظف - سجل رقم 17', '2026-09-29 07:16:28', '::1', 'Google Chrome', 'Windows'),
(836, 43, 'User Logout', '2026-09-29 07:16:43', '::1', 'Google Chrome', 'Windows'),
(837, 35, 'User Login', '2026-09-29 07:16:53', '::1', 'Google Chrome', 'Windows'),
(838, 35, 'تم تسجيل حضور الموظف - سجل رقم 18', '2026-09-29 07:17:08', '::1', 'Google Chrome', 'Windows'),
(839, 35, 'تم تسجيل خروج الموظف - سجل رقم 18 - وقت العمل 515 دقيقة', '2026-09-29 15:51:53', '::1', 'Google Chrome', 'Windows'),
(840, 35, 'User Logout', '2026-09-29 15:52:04', '::1', 'Google Chrome', 'Windows'),
(841, 43, 'User Login', '2026-09-29 15:52:08', '::1', 'Google Chrome', 'Windows'),
(842, 43, 'تم تسجيل خروج الموظف - سجل رقم 17 - وقت العمل 516 دقيقة', '2026-09-29 15:52:12', '::1', 'Google Chrome', 'Windows'),
(843, 43, 'User Logout', '2026-09-29 15:53:34', '::1', 'Google Chrome', 'Windows'),
(844, 1, 'User Login', '2026-09-29 15:53:38', '::1', 'Google Chrome', 'Windows'),
(845, 1, 'User Logout', '2026-09-29 16:04:59', '::1', 'Google Chrome', 'Windows'),
(846, 9, 'User Login', '2026-09-29 16:05:06', '::1', 'Google Chrome', 'Windows'),
(847, 9, 'User Logout', '2026-09-29 16:05:15', '::1', 'Google Chrome', 'Windows'),
(848, 9, 'User Login', '2026-09-29 16:05:47', '::1', 'Google Chrome', 'Windows'),
(849, 9, 'User Logout', '2026-10-01 16:03:15', '::1', 'Google Chrome', 'Windows'),
(850, 1, 'User Login', '2026-10-01 16:03:18', '::1', 'Google Chrome', 'Windows'),
(851, 1, 'User Logout', '2026-10-07 16:51:36', '::1', 'Google Chrome', 'Windows'),
(852, 1, 'User Login', '2026-10-07 16:51:38', '::1', 'Google Chrome', 'Windows'),
(853, 1, 'User Logout', '2026-10-10 15:34:52', '::1', 'Google Chrome', 'Windows'),
(854, 35, 'User Login', '2026-10-10 15:34:57', '::1', 'Google Chrome', 'Windows'),
(855, 35, 'User Logout', '2026-10-10 15:35:13', '::1', 'Google Chrome', 'Windows'),
(856, 1, 'User Login', '2026-10-10 15:35:20', '::1', 'Google Chrome', 'Windows'),
(857, 1, 'تم تعطيل المستخدم: Ahmed', '2026-10-10 15:53:32', '::1', 'Google Chrome', 'Windows'),
(858, 1, 'تم تفعيل المستخدم: Ahmed', '2026-10-10 15:53:41', '::1', 'Google Chrome', 'Windows'),
(859, 1, 'User Logout', '2026-10-11 17:04:31', '::1', 'Google Chrome', 'Windows'),
(860, 35, 'User Login', '2026-10-11 17:04:36', '::1', 'Google Chrome', 'Windows'),
(861, 35, 'تم تسجيل حضور الموظف - سجل رقم 19', '2026-10-11 17:05:30', '::1', 'Google Chrome', 'Windows'),
(862, 35, 'تم تسجيل خروج الموظف - سجل رقم 19 - وقت العمل 0 دقيقة', '2026-10-11 17:05:33', '::1', 'Google Chrome', 'Windows'),
(863, 35, 'User Login', '2026-10-14 13:48:55', '::1', 'Google Chrome', 'Windows'),
(864, 35, 'User Logout', '2026-10-14 13:55:55', '::1', 'Google Chrome', 'Windows'),
(865, 1, 'User Login', '2026-10-14 13:56:01', '::1', 'Google Chrome', 'Windows'),
(866, 1, 'User Logout', '2026-10-18 13:45:55', '::1', 'Google Chrome', 'Windows'),
(867, 1, 'User Login', '2026-10-18 13:45:57', '::1', 'Google Chrome', 'Windows'),
(868, 1, 'User Logout', '2026-10-21 14:15:33', '::1', 'Google Chrome', 'Windows'),
(869, 35, 'User Login', '2026-10-21 14:15:37', '::1', 'Google Chrome', 'Windows'),
(870, 35, 'User Logout', '2026-10-21 14:15:43', '::1', 'Google Chrome', 'Windows'),
(871, 9, 'User Login', '2026-10-21 14:15:49', '::1', 'Google Chrome', 'Windows'),
(872, 9, 'User Logout', '2026-10-21 14:16:25', '::1', 'Google Chrome', 'Windows'),
(873, 1, 'User Login', '2026-10-21 14:16:37', '::1', 'Google Chrome', 'Windows'),
(874, 1, 'User Logout', '2026-10-21 14:17:27', '::1', 'Google Chrome', 'Windows'),
(875, 12, 'User Login', '2026-10-21 14:17:40', '::1', 'Google Chrome', 'Windows'),
(876, 12, 'User Logout', '2026-10-21 14:18:54', '::1', 'Google Chrome', 'Windows'),
(877, 1, 'User Login', '2026-10-21 14:18:59', '::1', 'Google Chrome', 'Windows'),
(878, 1, 'User Logout', '2026-10-21 15:01:24', '::1', 'Google Chrome', 'Windows'),
(879, 1, 'User Login', '2026-10-21 15:07:19', '::1', 'Google Chrome', 'Windows');

-- --------------------------------------------------------

--
-- بنية الجدول `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `target_type` enum('all','department','role') NOT NULL DEFAULT 'all',
  `target_id` int(11) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `message`, `created_by`, `target_type`, `target_id`, `status`, `created_at`, `updated_at`) VALUES
(2, 'اعلان هام', 'اجتماع غدا للموظفين الساعه 10:30', 1, 'all', NULL, 'inactive', '2026-08-29 16:18:22', '2026-09-16 16:37:47'),
(3, 'اجتماع هام غدا الساعه 10صباحا', 'يرجى الحضور غدا للاجتماع في قاعه 154', 1, 'all', NULL, 'active', '2026-09-06 16:22:52', '2026-09-06 16:22:52'),
(4, 'اعلان هام', 'اجتماع غدا الساعه 10:30 ص بقاعه 351', 1, 'role', 2, 'active', '2026-09-23 16:12:41', '2026-09-23 16:12:41'),
(5, 'اعلان هام', 'اجتماع يوم الاحد القادم الساعه 11 يرجى من الجميع الحضور', 1, 'all', NULL, 'active', '2026-10-21 14:13:37', '2026-10-21 14:13:37'),
(6, 'اعلان هام', 'على جميع مدراء قسم  IT الحضور غدا الساعه 8', 1, 'role', 1, 'active', '2026-10-21 14:15:19', '2026-10-21 14:15:19');

-- --------------------------------------------------------

--
-- بنية الجدول `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `attendance_date` date NOT NULL,
  `check_in` time DEFAULT NULL,
  `check_out` time DEFAULT NULL,
  `status` enum('present','late','absent','leave') DEFAULT 'present',
  `late_minutes` int(11) DEFAULT 0,
  `work_minutes` int(11) DEFAULT 0,
  `source` enum('manual','system','biometric') DEFAULT 'system',
  `device_id` varchar(100) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `attendance`
--

INSERT INTO `attendance` (`id`, `user_id`, `attendance_date`, `check_in`, `check_out`, `status`, `late_minutes`, `work_minutes`, `source`, `device_id`, `notes`, `created_at`, `updated_at`) VALUES
(1, 43, '2026-08-26', '17:02:36', '17:03:17', 'late', 542, 0, 'system', NULL, NULL, '2026-08-26 15:02:36', '2026-08-26 15:03:17'),
(2, 14, '2026-08-27', '14:00:22', NULL, 'late', 360, 0, 'system', NULL, NULL, '2026-08-27 12:00:22', '2026-08-27 12:00:22'),
(3, 43, '2026-08-27', '14:02:05', NULL, 'late', 362, 0, 'system', NULL, NULL, '2026-08-27 12:02:05', '2026-08-27 12:02:05'),
(4, 35, '2026-08-27', '14:03:40', NULL, 'late', 363, 0, 'system', NULL, NULL, '2026-08-27 12:03:40', '2026-08-27 12:03:40'),
(5, 16, '2026-08-27', '16:42:53', NULL, 'late', 522, 0, 'system', NULL, NULL, '2026-08-27 14:42:53', '2026-08-27 14:42:53'),
(6, 43, '2026-08-31', '17:15:23', NULL, 'late', 555, 0, 'system', NULL, NULL, '2026-08-31 15:15:23', '2026-08-31 15:15:23'),
(7, 43, '2026-09-06', '18:36:33', NULL, 'late', 636, 0, 'system', NULL, NULL, '2026-09-06 16:36:33', '2026-09-06 16:36:33'),
(8, 43, '2026-09-07', '17:18:37', NULL, 'late', 558, 0, 'system', NULL, NULL, '2026-09-07 15:18:37', '2026-09-07 15:18:37'),
(9, 16, '2026-09-13', '16:42:01', '17:15:43', 'late', 522, 34, 'system', NULL, NULL, '2026-09-13 14:42:01', '2026-09-13 15:15:43'),
(10, 43, '2026-09-13', '17:16:30', '17:16:38', 'late', 556, 0, 'system', NULL, NULL, '2026-09-13 15:16:30', '2026-09-13 15:16:38'),
(11, 43, '2026-09-16', '18:11:04', '18:12:08', 'late', 611, 1, 'system', NULL, NULL, '2026-09-16 16:11:04', '2026-09-16 16:12:08'),
(12, 39, '2026-09-22', '18:34:28', '18:36:16', 'late', 634, 2, 'system', NULL, NULL, '2026-09-22 16:34:28', '2026-09-22 16:36:16'),
(13, 43, '2026-09-23', '17:45:27', '17:46:19', 'late', 585, 1, 'system', NULL, NULL, '2026-09-23 15:45:27', '2026-09-23 15:46:19'),
(14, 43, '2026-09-26', '09:31:55', NULL, 'late', 91, 0, 'system', NULL, NULL, '2026-09-26 07:31:55', '2026-09-26 07:31:55'),
(15, 35, '2026-09-27', '10:23:48', '17:48:36', 'late', 143, 445, 'system', NULL, NULL, '2026-09-27 08:23:48', '2026-09-27 15:48:36'),
(16, 35, '2026-09-28', '18:14:52', '18:25:08', 'late', 614, 10, 'system', NULL, NULL, '2026-09-28 16:14:52', '2026-09-28 16:25:08'),
(17, 43, '2026-09-29', '09:16:28', '17:52:12', 'late', 76, 516, 'system', NULL, NULL, '2026-09-29 07:16:28', '2026-09-29 15:52:12'),
(18, 35, '2026-09-29', '09:17:08', '17:51:53', 'late', 77, 515, 'system', NULL, NULL, '2026-09-29 07:17:08', '2026-09-29 15:51:53'),
(19, 35, '2026-10-11', '19:05:30', '19:05:33', 'late', 665, 0, 'system', NULL, NULL, '2026-10-11 17:05:30', '2026-10-11 17:05:33');

-- --------------------------------------------------------

--
-- بنية الجدول `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `department_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `departments`
--

INSERT INTO `departments` (`id`, `department_name`, `description`, `created_at`) VALUES
(1, 'IT', 'Information Technology', '2026-08-02 13:49:25'),
(5, 'HR', 'Human Resources', '2026-08-05 12:35:30'),
(6, 'Sales', 'Business Development', '2026-08-05 12:37:47');

-- --------------------------------------------------------

--
-- بنية الجدول `leave_requests`
--

CREATE TABLE `leave_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `leave_type` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `reason` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `manager_note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `leave_requests`
--

INSERT INTO `leave_requests` (`id`, `user_id`, `leave_type`, `start_date`, `end_date`, `reason`, `status`, `manager_note`, `created_at`, `updated_at`) VALUES
(1, 43, 'Sick Leave', '2026-08-19', '2026-08-27', NULL, 'approved', NULL, '2026-08-17 19:34:52', '2026-08-19 13:47:15'),
(2, 43, 'Emergency Leave', '2026-08-31', '2026-11-24', NULL, 'rejected', 'rejected now', '2026-08-22 14:48:33', '2026-08-22 14:58:46'),
(3, 35, 'Unpaid Leave', '2026-08-24', '2026-08-30', NULL, 'approved', NULL, '2026-08-23 11:49:50', '2026-08-23 11:52:58'),
(4, 41, 'Emergency Leave', '2026-08-25', '2026-08-27', NULL, 'approved', NULL, '2026-08-23 11:58:30', '2026-08-23 11:59:23'),
(5, 9, 'Emergency Leave', '2026-09-10', '2026-09-18', NULL, 'approved', NULL, '2026-09-08 17:01:06', '2026-09-08 17:01:41'),
(6, 10, 'Emergency Leave', '2026-09-10', '2026-09-12', NULL, 'rejected', 'غير موافق حاليا لوجود عمل', '2026-09-09 14:33:53', '2026-09-09 15:00:51'),
(7, 10, 'Emergency Leave', '2026-09-16', '2026-09-24', '', 'approved', NULL, '2026-09-09 15:02:08', '2026-09-09 15:02:58'),
(8, 16, 'Sick Leave', '2026-09-13', '2026-09-15', '', 'approved', NULL, '2026-09-12 17:42:05', '2026-09-12 17:42:33'),
(9, 35, 'Emergency Leave', '2026-09-29', '2026-09-30', '..', 'approved', NULL, '2026-09-28 16:22:48', '2026-09-28 16:24:42');

-- --------------------------------------------------------

--
-- بنية الجدول `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `is_read`, `created_at`) VALUES
(1, 0, 'New User', 'User Mahmud has been created successfully.', 1, '2026-07-14 14:20:30'),
(2, 0, 'New User', 'User yamen has been created successfully.', 1, '2026-07-14 14:21:48'),
(3, 0, 'New User', 'User esmail has been created successfully.', 1, '2026-07-15 14:42:54'),
(4, 0, 'User Updated', 'User yamenn has been updated successfully.', 1, '2026-07-15 15:07:03'),
(5, 0, 'User Deleted', 'User  has been deleted successfully.', 1, '2026-07-15 15:09:49'),
(6, 0, 'User Updated', 'User waail has been updated successfully.', 1, '2026-07-16 12:20:24'),
(7, 0, 'User Updated', 'User yasser has been updated successfully.', 1, '2026-07-16 12:21:23'),
(8, 0, 'User Deleted', 'User  has been deleted successfully.', 1, '2026-07-16 12:22:07'),
(9, 0, 'New Role', 'Role  has been created successfully.', 1, '2026-07-16 12:30:32'),
(10, 0, 'New Role', 'Role  has been created successfully.', 1, '2026-07-16 12:32:45'),
(11, 0, 'New Role', 'Role  has been created successfully.', 1, '2026-07-16 12:32:45'),
(12, 0, 'New Role', 'Role  has been created successfully.', 1, '2026-07-16 12:33:37'),
(13, 0, 'New Role', 'Role  has been created successfully.', 1, '2026-07-16 12:34:13'),
(14, 0, 'New Role', 'Role  has been created successfully.', 1, '2026-07-16 12:47:31'),
(15, 0, 'Role Updated', 'Role Supportx has been updated successfully.', 1, '2026-07-16 13:18:44'),
(16, 0, 'New Role', 'Role  has been created successfully.', 1, '2026-07-16 13:37:28'),
(17, 0, 'Role Deleted', 'Role employehas been deleted successfully.', 1, '2026-07-16 13:37:39'),
(18, 0, 'New Role', 'Role  has been created successfully.', 1, '2026-07-16 13:38:12'),
(19, 0, 'Role Updated', 'Role manager1 has been updated successfully.', 1, '2026-07-16 13:40:02'),
(20, 0, 'Role Updated', 'Role manageryyyyy has been updated successfully.', 1, '2026-07-16 13:40:10'),
(21, 0, 'Role Updated', 'Role manager has been updated successfully.', 1, '2026-07-16 13:40:20'),
(22, 0, 'Role Deleted', 'Role manageryyyyyhas been deleted successfully.', 1, '2026-07-16 13:40:25'),
(23, 0, 'Role Updated', 'Role Supportxuuu has been updated successfully.', 1, '2026-07-16 13:40:38'),
(24, 0, 'Role Deleted', 'Role Supportxuuuhas been deleted successfully.', 1, '2026-07-16 13:40:43'),
(25, 0, 'Role Updated', 'Role Support has been updated successfully.', 1, '2026-07-16 13:41:54'),
(26, 0, 'New Role', 'Role  has been created successfully.', 1, '2026-07-16 13:51:30'),
(27, 0, 'Role Deleted', 'Role babhas been deleted successfully.', 1, '2026-07-16 13:51:35'),
(28, 0, 'Settings Updated', 'System settings have been updated successfully.', 1, '2026-07-16 14:00:24'),
(29, 0, 'Settings Updated', 'System settings have been updated successfully.', 1, '2026-07-16 14:00:33'),
(30, 0, 'User Moved To Trash', 'User Rami samir has been moved to trash.', 1, '2026-07-18 12:32:32'),
(31, 0, 'User Restored', 'User Rami samir has been restored successfully.', 1, '2026-07-18 12:37:54'),
(32, 0, 'User Moved To Trash', 'User Zaher has been moved to trash.', 1, '2026-07-18 12:38:22'),
(33, 0, 'User Restored', 'User Zaher has been restored successfully.', 1, '2026-07-18 12:38:28'),
(34, 0, 'New User', 'User eman taha has been created successfully.', 1, '2026-07-18 13:01:20'),
(35, 0, 'User Moved To Trash', 'User eman taha has been moved to trash.', 1, '2026-07-18 13:02:12'),
(36, 0, 'User Restored', 'User eman taha has been restored successfully.', 1, '2026-07-18 13:02:22'),
(37, 0, 'User Moved To Trash', 'User eman taha has been moved to trash.', 1, '2026-07-18 13:02:36'),
(38, 0, 'User Deleted Permanently', 'User eman taha has been permanently deleted.', 1, '2026-07-18 13:03:12'),
(39, 0, 'New User', 'User sami bassam has been created successfully.', 1, '2026-07-19 12:42:29'),
(40, 0, 'User Moved To Trash', 'User sami bassam has been moved to trash.', 1, '2026-07-19 12:45:29'),
(41, 0, 'User Deleted Permanently', 'User sami bassam has been permanently deleted.', 1, '2026-07-19 12:56:16'),
(42, 0, 'New User', 'User samh has been created successfully.', 1, '2026-07-19 12:56:57'),
(43, 0, 'User Moved To Trash', 'User samh has been moved to trash.', 1, '2026-07-19 13:00:32'),
(44, 0, 'User Deleted Permanently', 'User samh has been permanently deleted.', 1, '2026-07-19 13:00:39'),
(45, 0, 'New User', 'User dalal has been created successfully.', 1, '2026-07-19 13:41:09'),
(46, 0, 'User Moved To Trash', 'User dalal has been moved to trash.', 1, '2026-07-19 13:44:59'),
(47, 0, 'User Deleted Permanently', 'User dalal has been permanently deleted.', 1, '2026-07-19 13:45:05'),
(48, 0, 'New User', 'User samr ee has been created successfully.', 1, '2026-07-19 13:45:38'),
(49, 0, 'User Moved To Trash', 'User samr ee has been moved to trash.', 1, '2026-07-19 13:46:25'),
(50, 0, 'User Deleted Permanently', 'User samr ee has been permanently deleted.', 1, '2026-07-19 13:46:43'),
(51, 0, 'New User', 'User waleed sami has been created successfully.', 1, '2026-07-19 13:47:45'),
(52, 0, 'User Moved To Trash', 'User waleed sami has been moved to trash.', 1, '2026-07-19 13:56:04'),
(53, 0, 'User Deleted Permanently', 'User waleed sami has been permanently deleted.', 1, '2026-07-19 13:56:10'),
(54, 0, 'New User', 'User waleed ff has been created successfully.', 1, '2026-07-19 13:56:40'),
(55, 0, 'New User', 'User marwan has been created successfully.', 1, '2026-07-19 14:01:01'),
(56, 0, 'User Moved To Trash', 'User waleed ff has been moved to trash.', 1, '2026-07-19 14:10:35'),
(57, 0, 'User Moved To Trash', 'User marwan has been moved to trash.', 1, '2026-07-19 14:10:45'),
(58, 0, 'User Deleted Permanently', 'User waleed ff has been permanently deleted.', 1, '2026-07-19 14:10:52'),
(59, 0, 'User Deleted Permanently', 'User marwan has been permanently deleted.', 1, '2026-07-19 14:10:55'),
(60, 0, 'New User', 'User mahmod has been created successfully.', 1, '2026-07-19 14:11:36'),
(61, 0, 'User Moved To Trash', 'User mahmod has been moved to trash.', 1, '2026-07-19 14:17:38'),
(62, 0, 'User Deleted Permanently', 'User mahmod has been permanently deleted.', 1, '2026-07-19 14:17:51'),
(63, 0, 'New User', 'User waleed sami has been created successfully.', 1, '2026-07-19 14:18:34'),
(64, 0, 'New User', 'User ayman has been created successfully.', 1, '2026-07-20 13:05:10'),
(65, 0, 'User Moved To Trash', 'User maram has been moved to trash.', 1, '2026-07-23 12:06:27'),
(66, 0, 'User Deleted Permanently', 'User maram has been permanently deleted.', 1, '2026-07-23 12:06:34'),
(67, 0, 'New User', 'User maram basm has been created successfully.', 1, '2026-07-23 12:07:44'),
(68, 1, 'New User', 'User fadi sami has been created successfully.', 1, '2026-07-26 18:53:36'),
(69, 1, 'User Updated', 'User Ahmed has been updated successfully.', 1, '2026-07-26 18:57:34'),
(70, 1, 'Profile Updated', 'User Ahmed updated his profile.', 1, '2026-07-27 14:32:01'),
(71, 2, 'Profile Updated', 'Your profile has been updated successfully.', 1, '2026-07-27 14:32:01'),
(72, 1, 'Profile Updated', 'User Ahmed updated his profile.', 1, '2026-07-28 13:14:16'),
(73, 2, 'Profile Updated', 'Your profile has been updated successfully.', 1, '2026-07-28 13:14:16'),
(74, 1, 'Profile Updated', 'User moataz updated his profile.', 1, '2026-07-28 13:27:50'),
(75, 9, 'Profile Updated', 'Your profile has been updated successfully.', 1, '2026-07-28 13:27:50'),
(76, 1, 'Profile Updated', 'User moataz updated his profile.', 1, '2026-07-28 13:27:55'),
(77, 9, 'Profile Updated', 'Your profile has been updated successfully.', 1, '2026-07-28 13:27:55'),
(78, 1, 'Profile Updated', 'User moataz updated his profile.', 1, '2026-07-29 13:25:31'),
(79, 9, 'Profile Updated', 'Your profile has been updated successfully.', 1, '2026-07-29 13:25:31'),
(80, 1, 'Profile Updated', 'User Ahmed updated his profile.', 1, '2026-07-29 19:30:18'),
(81, 2, 'Profile Updated', 'Your profile has been updated successfully.', 1, '2026-07-29 19:30:18'),
(82, 1, 'Profile Updated', 'User moataz updated his profile.', 1, '2026-07-30 12:54:09'),
(83, 9, 'Profile Updated', 'Your profile has been updated successfully.', 1, '2026-07-30 12:54:09'),
(84, 1, 'Profile Updated', 'User Ahmed updated his profile.', 1, '2026-07-30 13:48:18'),
(85, 2, 'Profile Updated', 'Your profile has been updated successfully.', 1, '2026-07-30 13:48:18'),
(86, 1, 'New Department', 'Department IT has been created.', 1, '2026-08-02 13:49:25'),
(87, 1, 'Department Updated', 'Department IT has been updated.', 1, '2026-08-03 13:58:39'),
(88, 1, 'New Department', 'Department do has been created.', 1, '2026-08-03 14:23:12'),
(89, 1, 'Department Updated', 'Department doo has been updated.', 1, '2026-08-03 14:23:27'),
(90, 1, 'Department Deleted', 'Department doo has been deleted.', 1, '2026-08-03 14:23:31'),
(91, 1, 'New Department', 'Department hi has been created.', 1, '2026-08-03 15:29:15'),
(92, 1, 'Department Deleted', 'Department hi has been deleted.', 1, '2026-08-04 15:32:47'),
(93, 1, 'New Department', 'Department men has been created.', 1, '2026-08-04 17:16:11'),
(94, 1, 'Department Updated', 'Department men has been updated.', 1, '2026-08-04 17:16:23'),
(95, 1, 'Department Deleted', 'Department men has been deleted.', 1, '2026-08-04 17:16:29'),
(96, 1, 'New User', 'User firas safe has been created successfully.', 1, '2026-08-05 12:22:16'),
(97, 1, 'User Updated', 'User farok mohammed has been updated successfully.', 1, '2026-08-05 12:24:34'),
(98, 1, 'User Updated', 'User farouk mohammed has been updated successfully.', 1, '2026-08-05 12:26:02'),
(99, 1, 'New Department', 'Department HR has been created.', 1, '2026-08-05 12:35:30'),
(100, 1, 'New Department', 'Department Sales has been created.', 1, '2026-08-05 12:37:47'),
(101, 1, 'User Updated', 'User Ahmed has been updated successfully.', 1, '2026-08-05 18:51:30'),
(102, 1, 'User Updated', 'User Ahmed has been updated successfully.', 1, '2026-08-05 18:51:47'),
(103, 1, 'User Updated', 'User Ahmed has been updated successfully.', 1, '2026-08-05 19:28:51'),
(104, 1, 'User Updated', 'User yasser has been updated successfully.', 1, '2026-08-05 19:29:25'),
(105, 1, 'User Updated', 'User Zaher has been updated successfully.', 1, '2026-08-08 12:03:47'),
(106, 1, 'User Updated', 'User waleedsami has been updated successfully.', 1, '2026-08-08 12:04:29'),
(107, 1, 'User Updated', 'User moataz has been updated successfully.', 1, '2026-08-08 12:04:53'),
(108, 1, 'User Updated', 'User Suleiman Tayser has been updated successfully.', 1, '2026-08-08 12:05:24'),
(109, 1, 'User Updated', 'User Hassan Mohammed smer has been updated successfully.', 1, '2026-08-08 12:05:43'),
(110, 1, 'User Updated', 'User fadi sami has been updated successfully.', 1, '2026-08-08 12:06:18'),
(111, 1, 'User Updated', 'User maram basm has been updated successfully.', 1, '2026-08-08 12:06:32'),
(112, 1, 'User Updated', 'User faisal naim has been updated successfully.', 1, '2026-08-08 12:06:49'),
(113, 1, 'User Updated', 'User Rami samir has been updated successfully.', 1, '2026-08-08 12:07:03'),
(114, 1, 'User Updated', 'User ayman has been updated successfully.', 1, '2026-08-08 12:07:16'),
(115, 1, 'User Updated', 'User fahad adnan has been updated successfully.', 1, '2026-08-08 12:07:28'),
(116, 1, 'New User', 'User sary naim has been created successfully.', 1, '2026-08-08 13:34:06'),
(117, 1, 'New Employee', 'Employee tamer mohsenhas been added to HR department.', 1, '2026-08-09 18:54:58'),
(118, 3, 'New Leave Request', 'Employee hanafi khaled has submitted a new leave request.', 0, '2026-08-17 19:34:52'),
(119, 9, 'New Leave Request', 'Employee hanafi khaled has submitted a new leave request.', 1, '2026-08-17 19:34:52'),
(120, 34, 'New Leave Request', 'Employee hanafi khaled has submitted a new leave request.', 0, '2026-08-17 19:34:52'),
(121, 37, 'New Leave Request', 'Employee hanafi khaled has submitted a new leave request.', 1, '2026-08-17 19:34:52'),
(122, 38, 'New Leave Request', 'Employee hanafi khaled has submitted a new leave request.', 0, '2026-08-17 19:34:52'),
(123, 44, 'New Leave Request', 'Employee hanafi khaled has submitted a new leave request.', 0, '2026-08-17 19:34:52'),
(124, 43, 'leave Request Approved', 'Your leave request #1 has been approved.', 1, '2026-08-19 13:47:15'),
(125, 3, 'New Leave Request', 'Employee hanafi khaled has submitted a new leave request.', 0, '2026-08-22 14:48:33'),
(126, 9, 'New Leave Request', 'Employee hanafi khaled has submitted a new leave request.', 1, '2026-08-22 14:48:33'),
(127, 34, 'New Leave Request', 'Employee hanafi khaled has submitted a new leave request.', 0, '2026-08-22 14:48:33'),
(128, 37, 'New Leave Request', 'Employee hanafi khaled has submitted a new leave request.', 1, '2026-08-22 14:48:33'),
(129, 38, 'New Leave Request', 'Employee hanafi khaled has submitted a new leave request.', 0, '2026-08-22 14:48:33'),
(130, 44, 'New Leave Request', 'Employee hanafi khaled has submitted a new leave request.', 0, '2026-08-22 14:48:33'),
(131, 43, 'Leave Request Rejected', 'Your leave request #2 has been rejected.', 1, '2026-08-22 14:58:46'),
(132, 10, 'New Leave Request', 'Employee firas safe has submitted a new leave request.', 1, '2026-08-23 11:49:50'),
(133, 12, 'New Leave Request', 'Employee firas safe has submitted a new leave request.', 1, '2026-08-23 11:49:50'),
(134, 31, 'New Leave Request', 'Employee firas safe has submitted a new leave request.', 0, '2026-08-23 11:49:50'),
(135, 39, 'New Leave Request', 'Employee firas safe has submitted a new leave request.', 1, '2026-08-23 11:49:50'),
(136, 40, 'New Leave Request', 'Employee firas safe has submitted a new leave request.', 0, '2026-08-23 11:49:50'),
(137, 35, 'leave Request Approved', 'Your leave request #3 has been approved.', 1, '2026-08-23 11:52:58'),
(138, 10, 'New Leave Request', 'Employee omar ahmed has submitted a new leave request.', 1, '2026-08-23 11:58:30'),
(139, 12, 'New Leave Request', 'Employee omar ahmed has submitted a new leave request.', 1, '2026-08-23 11:58:30'),
(140, 31, 'New Leave Request', 'Employee omar ahmed has submitted a new leave request.', 0, '2026-08-23 11:58:30'),
(141, 39, 'New Leave Request', 'Employee omar ahmed has submitted a new leave request.', 1, '2026-08-23 11:58:30'),
(142, 40, 'New Leave Request', 'Employee omar ahmed has submitted a new leave request.', 0, '2026-08-23 11:58:30'),
(143, 41, 'leave Request Approved', 'Your leave request #4 has been approved.', 1, '2026-08-23 11:59:23'),
(144, 1, 'اعلان هام', 'اجتماع غدا للموظفين الساعه 10:30', 1, '2026-08-29 16:18:22'),
(145, 2, 'اعلان هام', 'اجتماع غدا للموظفين الساعه 10:30', 0, '2026-08-29 16:18:22'),
(146, 3, 'اعلان هام', 'اجتماع غدا للموظفين الساعه 10:30', 0, '2026-08-29 16:18:22'),
(147, 8, 'اعلان هام', 'اجتماع غدا للموظفين الساعه 10:30', 0, '2026-08-29 16:18:22'),
(148, 9, 'اعلان هام', 'اجتماع غدا للموظفين الساعه 10:30', 1, '2026-08-29 16:18:22'),
(149, 10, 'اعلان هام', 'اجتماع غدا للموظفين الساعه 10:30', 1, '2026-08-29 16:18:22'),
(150, 12, 'اعلان هام', 'اجتماع غدا للموظفين الساعه 10:30', 1, '2026-08-29 16:18:22'),
(151, 13, 'اعلان هام', 'اجتماع غدا للموظفين الساعه 10:30', 0, '2026-08-29 16:18:22'),
(152, 14, 'اعلان هام', 'اجتماع غدا للموظفين الساعه 10:30', 0, '2026-08-29 16:18:22'),
(153, 15, 'اعلان هام', 'اجتماع غدا للموظفين الساعه 10:30', 0, '2026-08-29 16:18:22'),
(154, 16, 'اعلان هام', 'اجتماع غدا للموظفين الساعه 10:30', 1, '2026-08-29 16:18:22'),
(155, 30, 'اعلان هام', 'اجتماع غدا للموظفين الساعه 10:30', 0, '2026-08-29 16:18:22'),
(156, 31, 'اعلان هام', 'اجتماع غدا للموظفين الساعه 10:30', 0, '2026-08-29 16:18:22'),
(157, 33, 'اعلان هام', 'اجتماع غدا للموظفين الساعه 10:30', 1, '2026-08-29 16:18:22'),
(158, 34, 'اعلان هام', 'اجتماع غدا للموظفين الساعه 10:30', 0, '2026-08-29 16:18:22'),
(159, 35, 'اعلان هام', 'اجتماع غدا للموظفين الساعه 10:30', 1, '2026-08-29 16:18:22'),
(160, 36, 'اعلان هام', 'اجتماع غدا للموظفين الساعه 10:30', 0, '2026-08-29 16:18:22'),
(161, 37, 'اعلان هام', 'اجتماع غدا للموظفين الساعه 10:30', 0, '2026-08-29 16:18:22'),
(162, 38, 'اعلان هام', 'اجتماع غدا للموظفين الساعه 10:30', 0, '2026-08-29 16:18:22'),
(163, 39, 'اعلان هام', 'اجتماع غدا للموظفين الساعه 10:30', 1, '2026-08-29 16:18:22'),
(164, 40, 'اعلان هام', 'اجتماع غدا للموظفين الساعه 10:30', 0, '2026-08-29 16:18:22'),
(165, 41, 'اعلان هام', 'اجتماع غدا للموظفين الساعه 10:30', 0, '2026-08-29 16:18:22'),
(166, 42, 'اعلان هام', 'اجتماع غدا للموظفين الساعه 10:30', 0, '2026-08-29 16:18:22'),
(167, 43, 'اعلان هام', 'اجتماع غدا للموظفين الساعه 10:30', 1, '2026-08-29 16:18:22'),
(168, 44, 'اعلان هام', 'اجتماع غدا للموظفين الساعه 10:30', 0, '2026-08-29 16:18:22'),
(169, 1, 'Profile Updated', 'User hanafi khaledي updated his profile.', 1, '2026-09-06 16:00:58'),
(170, 43, 'Profile Updated', 'Your profile has been updated successfully.', 1, '2026-09-06 16:00:58'),
(171, 1, 'Password Changed', 'User hanafi khaledي changed his password.', 1, '2026-09-06 16:01:23'),
(172, 43, 'Password Changed', 'Your password has been changed successfully.', 1, '2026-09-06 16:01:23'),
(173, 1, 'Password Changed', 'User hanafi khaledي changed his password.', 1, '2026-09-06 16:02:07'),
(174, 43, 'Password Changed', 'Your password has been changed successfully.', 1, '2026-09-06 16:02:07'),
(175, 1, 'Profile Updated', 'User hanafi khaled updated his profile.', 1, '2026-09-06 16:02:11'),
(176, 43, 'Profile Updated', 'Your profile has been updated successfully.', 1, '2026-09-06 16:02:11'),
(177, 1, 'اجتماع هام غدا الساعه 10صباحا', 'يرجى الحضور غدا للاجتماع في قاعه 154', 1, '2026-09-06 16:22:52'),
(178, 2, 'اجتماع هام غدا الساعه 10صباحا', 'يرجى الحضور غدا للاجتماع في قاعه 154', 0, '2026-09-06 16:22:52'),
(179, 3, 'اجتماع هام غدا الساعه 10صباحا', 'يرجى الحضور غدا للاجتماع في قاعه 154', 0, '2026-09-06 16:22:52'),
(180, 8, 'اجتماع هام غدا الساعه 10صباحا', 'يرجى الحضور غدا للاجتماع في قاعه 154', 0, '2026-09-06 16:22:52'),
(181, 9, 'اجتماع هام غدا الساعه 10صباحا', 'يرجى الحضور غدا للاجتماع في قاعه 154', 1, '2026-09-06 16:22:52'),
(182, 10, 'اجتماع هام غدا الساعه 10صباحا', 'يرجى الحضور غدا للاجتماع في قاعه 154', 1, '2026-09-06 16:22:52'),
(183, 12, 'اجتماع هام غدا الساعه 10صباحا', 'يرجى الحضور غدا للاجتماع في قاعه 154', 1, '2026-09-06 16:22:52'),
(184, 13, 'اجتماع هام غدا الساعه 10صباحا', 'يرجى الحضور غدا للاجتماع في قاعه 154', 0, '2026-09-06 16:22:52'),
(185, 14, 'اجتماع هام غدا الساعه 10صباحا', 'يرجى الحضور غدا للاجتماع في قاعه 154', 0, '2026-09-06 16:22:52'),
(186, 15, 'اجتماع هام غدا الساعه 10صباحا', 'يرجى الحضور غدا للاجتماع في قاعه 154', 0, '2026-09-06 16:22:52'),
(187, 16, 'اجتماع هام غدا الساعه 10صباحا', 'يرجى الحضور غدا للاجتماع في قاعه 154', 1, '2026-09-06 16:22:52'),
(188, 30, 'اجتماع هام غدا الساعه 10صباحا', 'يرجى الحضور غدا للاجتماع في قاعه 154', 0, '2026-09-06 16:22:52'),
(189, 31, 'اجتماع هام غدا الساعه 10صباحا', 'يرجى الحضور غدا للاجتماع في قاعه 154', 0, '2026-09-06 16:22:52'),
(190, 33, 'اجتماع هام غدا الساعه 10صباحا', 'يرجى الحضور غدا للاجتماع في قاعه 154', 1, '2026-09-06 16:22:52'),
(191, 34, 'اجتماع هام غدا الساعه 10صباحا', 'يرجى الحضور غدا للاجتماع في قاعه 154', 0, '2026-09-06 16:22:52'),
(192, 35, 'اجتماع هام غدا الساعه 10صباحا', 'يرجى الحضور غدا للاجتماع في قاعه 154', 1, '2026-09-06 16:22:52'),
(193, 36, 'اجتماع هام غدا الساعه 10صباحا', 'يرجى الحضور غدا للاجتماع في قاعه 154', 0, '2026-09-06 16:22:52'),
(194, 37, 'اجتماع هام غدا الساعه 10صباحا', 'يرجى الحضور غدا للاجتماع في قاعه 154', 0, '2026-09-06 16:22:52'),
(195, 38, 'اجتماع هام غدا الساعه 10صباحا', 'يرجى الحضور غدا للاجتماع في قاعه 154', 0, '2026-09-06 16:22:52'),
(196, 39, 'اجتماع هام غدا الساعه 10صباحا', 'يرجى الحضور غدا للاجتماع في قاعه 154', 1, '2026-09-06 16:22:52'),
(197, 40, 'اجتماع هام غدا الساعه 10صباحا', 'يرجى الحضور غدا للاجتماع في قاعه 154', 0, '2026-09-06 16:22:52'),
(198, 41, 'اجتماع هام غدا الساعه 10صباحا', 'يرجى الحضور غدا للاجتماع في قاعه 154', 0, '2026-09-06 16:22:52'),
(199, 42, 'اجتماع هام غدا الساعه 10صباحا', 'يرجى الحضور غدا للاجتماع في قاعه 154', 0, '2026-09-06 16:22:52'),
(200, 43, 'اجتماع هام غدا الساعه 10صباحا', 'يرجى الحضور غدا للاجتماع في قاعه 154', 1, '2026-09-06 16:22:52'),
(201, 44, 'اجتماع هام غدا الساعه 10صباحا', 'يرجى الحضور غدا للاجتماع في قاعه 154', 0, '2026-09-06 16:22:52'),
(202, 1, 'Settings Updated', 'System settings have been updated successfully.', 1, '2026-09-08 14:56:10'),
(203, 1, 'Settings Updated', 'System settings have been updated successfully.', 1, '2026-09-08 14:56:17'),
(204, 1, 'Settings Updated', 'System settings have been updated successfully.', 1, '2026-09-08 14:56:23'),
(205, 3, 'New Leave Request', 'Employee moataz has submitted a new leave request.', 0, '2026-09-08 17:01:06'),
(206, 9, 'New Leave Request', 'Employee moataz has submitted a new leave request.', 1, '2026-09-08 17:01:06'),
(207, 34, 'New Leave Request', 'Employee moataz has submitted a new leave request.', 0, '2026-09-08 17:01:06'),
(208, 37, 'New Leave Request', 'Employee moataz has submitted a new leave request.', 0, '2026-09-08 17:01:06'),
(209, 38, 'New Leave Request', 'Employee moataz has submitted a new leave request.', 0, '2026-09-08 17:01:06'),
(210, 44, 'New Leave Request', 'Employee moataz has submitted a new leave request.', 0, '2026-09-08 17:01:06'),
(211, 9, 'leave Request Approved', 'Your leave request #5 has been approved.', 1, '2026-09-08 17:01:41'),
(212, 10, 'New Leave Request', 'Employee Suleiman Tayser has submitted a new leave request.', 1, '2026-09-09 14:33:53'),
(213, 12, 'New Leave Request', 'Employee Suleiman Tayser has submitted a new leave request.', 1, '2026-09-09 14:33:53'),
(214, 31, 'New Leave Request', 'Employee Suleiman Tayser has submitted a new leave request.', 0, '2026-09-09 14:33:53'),
(215, 39, 'New Leave Request', 'Employee Suleiman Tayser has submitted a new leave request.', 1, '2026-09-09 14:33:53'),
(216, 40, 'New Leave Request', 'Employee Suleiman Tayser has submitted a new leave request.', 0, '2026-09-09 14:33:53'),
(217, 10, 'Leave Request Rejected', 'Your leave request #6 has been rejected.', 1, '2026-09-09 15:00:51'),
(218, 1, 'New Manager Leave Request', 'Manager Suleiman Tayser has submitted a new leave request.', 1, '2026-09-09 15:02:08'),
(219, 10, 'leave Request Approved', 'Your leave request #7 has been approved.', 1, '2026-09-09 15:02:58'),
(220, 3, 'طلب إجازة جديد', 'قام الموظف Rami samir بتقديم طلب إجازة جديد.', 0, '2026-09-12 17:42:05'),
(221, 9, 'طلب إجازة جديد', 'قام الموظف Rami samir بتقديم طلب إجازة جديد.', 1, '2026-09-12 17:42:05'),
(222, 34, 'طلب إجازة جديد', 'قام الموظف Rami samir بتقديم طلب إجازة جديد.', 0, '2026-09-12 17:42:05'),
(223, 37, 'طلب إجازة جديد', 'قام الموظف Rami samir بتقديم طلب إجازة جديد.', 0, '2026-09-12 17:42:05'),
(224, 38, 'طلب إجازة جديد', 'قام الموظف Rami samir بتقديم طلب إجازة جديد.', 0, '2026-09-12 17:42:05'),
(225, 44, 'طلب إجازة جديد', 'قام الموظف Rami samir بتقديم طلب إجازة جديد.', 0, '2026-09-12 17:42:05'),
(226, 16, 'تمت الموافقة على طلب الإجازة', 'تمت الموافقة على طلب الإجازة رقم #8.', 1, '2026-09-12 17:42:33'),
(227, 1, 'موظف جديد', 'تمت إضافة الموظف wasef assaf إلى قسم HR بنجاح.', 1, '2026-09-13 15:25:43'),
(228, 1, 'موظف جديد', 'تمت إضافة الموظف sameh mohamed إلى قسم HR بنجاح.', 1, '2026-09-13 16:08:13'),
(229, 1, 'موظف جديد', 'تمت إضافة الموظف laith khaled إلى قسم HR بنجاح.', 1, '2026-09-13 16:11:37'),
(230, 1, 'موظف جديد', 'تمت إضافة الموظف amen hadi إلى قسم IT بنجاح.', 1, '2026-09-13 16:14:39'),
(231, 1, 'تم تحديث بيانات المستخدم', 'تم تحديث بيانات المستخدم yasser بنجاح.', 1, '2026-09-13 16:21:11'),
(232, 1, 'تم تحديث بيانات المستخدم', 'تم تحديث بيانات المستخدم Suleiman Tayser بنجاح.', 1, '2026-09-13 16:24:12'),
(233, 1, 'تم تحديث بيانات المستخدم', 'تم تحديث بيانات المستخدم waleed sami بنجاح.', 1, '2026-09-13 16:25:30'),
(234, 1, 'تم تحديث بيانات المستخدم', 'تم تحديث بيانات المستخدم maram naser بنجاح.', 1, '2026-09-13 16:25:52'),
(235, 1, 'تم تحديث بيانات المستخدم', 'تم تحديث بيانات المستخدم ayman بنجاح.', 1, '2026-09-13 16:26:17'),
(236, 1, 'تم تحديث بيانات المستخدم', 'تم تحديث بيانات المستخدم omar ahmed بنجاح.', 1, '2026-09-13 16:26:32'),
(237, 1, 'تم تحديث بيانات المستخدم', 'تم تحديث بيانات المستخدم fadi sami بنجاح.', 1, '2026-09-13 16:26:48'),
(238, 1, 'تم تحديث بيانات المستخدم', 'تم تحديث بيانات المستخدم rawan salah بنجاح.', 1, '2026-09-13 16:27:06'),
(239, 1, 'تم تحديث بيانات المستخدم', 'تم تحديث بيانات المستخدم tamer mohsen بنجاح.', 1, '2026-09-13 16:27:18'),
(240, 1, 'تم تحديث بيانات المستخدم', 'تم تحديث بيانات المستخدم rawan salah بنجاح.', 1, '2026-09-13 16:28:04'),
(241, 1, 'تم تحديث الملف الشخصي', 'قام المستخدم hanafi khaled بتحديث ملفه الشخصي.', 1, '2026-09-19 16:50:08'),
(242, 43, 'تم تحديث الملف الشخصي', 'تم تحديث ملفك الشخصي بنجاح.', 1, '2026-09-19 16:50:08'),
(243, 1, 'تم تحديث الملف الشخصي', 'قام المستخدم firas safe بتحديث ملفه الشخصي.', 1, '2026-09-19 16:51:02'),
(244, 35, 'تم تحديث الملف الشخصي', 'تم تحديث ملفك الشخصي بنجاح.', 1, '2026-09-19 16:51:02'),
(245, 1, 'تم تحديث الملف الشخصي', 'قام المستخدم maram naser بتحديث ملفه الشخصي.', 1, '2026-09-19 16:51:13'),
(246, 39, 'تم تحديث الملف الشخصي', 'تم تحديث ملفك الشخصي بنجاح.', 1, '2026-09-19 16:51:13'),
(247, 1, 'تم تحديث الملف الشخصي', 'قام المستخدم Rami samir بتحديث ملفه الشخصي.', 1, '2026-09-19 16:51:47'),
(248, 16, 'تم تحديث الملف الشخصي', 'تم تحديث ملفك الشخصي بنجاح.', 0, '2026-09-19 16:51:47'),
(249, 1, 'تم تحديث الملف الشخصي', 'قام المستخدم rawan salah بتحديث ملفه الشخصي.', 1, '2026-09-19 16:52:06'),
(250, 37, 'تم تحديث الملف الشخصي', 'تم تحديث ملفك الشخصي بنجاح.', 0, '2026-09-19 16:52:06'),
(251, 1, 'تم تحديث الملف الشخصي', 'قام المستخدم Ahmed بتحديث ملفه الشخصي.', 1, '2026-09-19 16:54:00'),
(252, 2, 'تم تحديث الملف الشخصي', 'تم تحديث ملفك الشخصي بنجاح.', 0, '2026-09-19 16:54:00'),
(253, 1, 'تم تحديث الملف الشخصي', 'قام المستخدم Zaher بتحديث ملفه الشخصي.', 1, '2026-09-19 16:55:39'),
(254, 8, 'تم تحديث الملف الشخصي', 'تم تحديث ملفك الشخصي بنجاح.', 0, '2026-09-19 16:55:39'),
(255, 1, 'تم تحديث الملف الشخصي', 'قام المستخدم Hassan Mohammed smer بتحديث ملفه الشخصي.', 1, '2026-09-19 16:56:36'),
(256, 13, 'تم تحديث الملف الشخصي', 'تم تحديث ملفك الشخصي بنجاح.', 0, '2026-09-19 16:56:36'),
(257, 1, 'تم تحديث الملف الشخصي', 'قام المستخدم faisal naim بتحديث ملفه الشخصي.', 1, '2026-09-19 16:57:09'),
(258, 14, 'تم تحديث الملف الشخصي', 'تم تحديث ملفك الشخصي بنجاح.', 0, '2026-09-19 16:57:09'),
(259, 1, 'تم تحديث الملف الشخصي', 'قام المستخدم fahad adnan بتحديث ملفه الشخصي.', 1, '2026-09-19 17:23:39'),
(260, 15, 'تم تحديث الملف الشخصي', 'تم تحديث ملفك الشخصي بنجاح.', 0, '2026-09-19 17:23:39'),
(261, 1, 'تم تحديث الملف الشخصي', 'قام المستخدم waleed sami بتحديث ملفه الشخصي.', 1, '2026-09-19 17:24:15'),
(262, 30, 'تم تحديث الملف الشخصي', 'تم تحديث ملفك الشخصي بنجاح.', 0, '2026-09-19 17:24:15'),
(263, 1, 'تم تحديث الملف الشخصي', 'قام المستخدم ayman بتحديث ملفه الشخصي.', 1, '2026-09-19 17:25:01'),
(264, 31, 'تم تحديث الملف الشخصي', 'تم تحديث ملفك الشخصي بنجاح.', 0, '2026-09-19 17:25:01'),
(265, 1, 'تم تحديث الملف الشخصي', 'قام المستخدم fadi sami بتحديث ملفه الشخصي.', 1, '2026-09-19 17:35:56'),
(266, 34, 'تم تحديث الملف الشخصي', 'تم تحديث ملفك الشخصي بنجاح.', 0, '2026-09-19 17:35:56'),
(267, 1, 'تم تحديث الملف الشخصي', 'قام المستخدم farouk mohammed بتحديث ملفه الشخصي.', 1, '2026-09-19 17:36:34'),
(268, 36, 'تم تحديث الملف الشخصي', 'تم تحديث ملفك الشخصي بنجاح.', 0, '2026-09-19 17:36:34'),
(269, 1, 'تم تحديث الملف الشخصي', 'قام المستخدم omar ahmed بتحديث ملفه الشخصي.', 1, '2026-09-19 17:37:14'),
(270, 40, 'تم تحديث الملف الشخصي', 'تم تحديث ملفك الشخصي بنجاح.', 0, '2026-09-19 17:37:14'),
(271, 1, 'تم تحديث الملف الشخصي', 'قام المستخدم rawan salah بتحديث ملفه الشخصي.', 1, '2026-09-19 17:37:48'),
(272, 38, 'تم تحديث الملف الشخصي', 'تم تحديث ملفك الشخصي بنجاح.', 0, '2026-09-19 17:37:48'),
(273, 1, 'تم تحديث الملف الشخصي', 'قام المستخدم omar ahmed بتحديث ملفه الشخصي.', 1, '2026-09-19 17:38:17'),
(274, 41, 'تم تحديث الملف الشخصي', 'تم تحديث ملفك الشخصي بنجاح.', 0, '2026-09-19 17:38:17'),
(275, 1, 'تم تحديث الملف الشخصي', 'قام المستخدم sary naim بتحديث ملفه الشخصي.', 1, '2026-09-19 17:39:30'),
(276, 42, 'تم تحديث الملف الشخصي', 'تم تحديث ملفك الشخصي بنجاح.', 0, '2026-09-19 17:39:30'),
(277, 1, 'تم تحديث الملف الشخصي', 'قام المستخدم tamer mohsen بتحديث ملفه الشخصي.', 1, '2026-09-19 17:40:12'),
(278, 44, 'تم تحديث الملف الشخصي', 'تم تحديث ملفك الشخصي بنجاح.', 0, '2026-09-19 17:40:12'),
(279, 1, 'تم تحديث الملف الشخصي', 'قام المستخدم rakan ahmed بتحديث ملفه الشخصي.', 1, '2026-09-19 17:40:42'),
(280, 45, 'تم تحديث الملف الشخصي', 'تم تحديث ملفك الشخصي بنجاح.', 0, '2026-09-19 17:40:42'),
(281, 1, 'تم تحديث الملف الشخصي', 'قام المستخدم rakan ahmed بتحديث ملفه الشخصي.', 1, '2026-09-19 17:40:47'),
(282, 45, 'تم تحديث الملف الشخصي', 'تم تحديث ملفك الشخصي بنجاح.', 0, '2026-09-19 17:40:47'),
(283, 1, 'تم تحديث الملف الشخصي', 'قام المستخدم wasef assaf بتحديث ملفه الشخصي.', 1, '2026-09-19 17:41:14'),
(284, 46, 'تم تحديث الملف الشخصي', 'تم تحديث ملفك الشخصي بنجاح.', 0, '2026-09-19 17:41:14'),
(285, 1, 'تم تحديث الملف الشخصي', 'قام المستخدم mansour mahmoud بتحديث ملفه الشخصي.', 1, '2026-09-19 17:41:43'),
(286, 47, 'تم تحديث الملف الشخصي', 'تم تحديث ملفك الشخصي بنجاح.', 0, '2026-09-19 17:41:43'),
(287, 1, 'تم تحديث الملف الشخصي', 'قام المستخدم sameh mohamed بتحديث ملفه الشخصي.', 1, '2026-09-19 17:42:17'),
(288, 48, 'تم تحديث الملف الشخصي', 'تم تحديث ملفك الشخصي بنجاح.', 0, '2026-09-19 17:42:17'),
(289, 1, 'تم تحديث الملف الشخصي', 'قام المستخدم laith khaled بتحديث ملفه الشخصي.', 1, '2026-09-19 17:42:51'),
(290, 49, 'تم تحديث الملف الشخصي', 'تم تحديث ملفك الشخصي بنجاح.', 0, '2026-09-19 17:42:51'),
(291, 1, 'تم تحديث الملف الشخصي', 'قام المستخدم amen hadi بتحديث ملفه الشخصي.', 1, '2026-09-19 17:43:22'),
(292, 50, 'تم تحديث الملف الشخصي', 'تم تحديث ملفك الشخصي بنجاح.', 0, '2026-09-19 17:43:22'),
(293, 1, 'تم تغيير كلمة المرور', 'قام المستخدم yasser بتغيير كلمة المرور الخاصة به.', 1, '2026-09-20 17:15:23'),
(294, 3, 'تم تغيير كلمة المرور', 'تم تغيير كلمة المرور الخاصة بك بنجاح.', 0, '2026-09-20 17:15:23'),
(295, 1, 'تم تحديث بيانات المستخدم', 'تم تحديث بيانات المستخدم waleed mohammed بنجاح.', 1, '2026-09-20 17:16:32'),
(296, 1, 'تم تغيير كلمة المرور', 'قام المستخدم waleed mohammed بتغيير كلمة المرور الخاصة به.', 1, '2026-09-20 17:18:25'),
(297, 33, 'تم تغيير كلمة المرور', 'تم تغيير كلمة المرور الخاصة بك بنجاح.', 0, '2026-09-20 17:18:25'),
(298, 1, 'تم تحديث الملف الشخصي', 'قام المستخدم waleed mohammed بتحديث ملفه الشخصي.', 1, '2026-09-20 17:18:32'),
(299, 33, 'تم تحديث الملف الشخصي', 'تم تحديث ملفك الشخصي بنجاح.', 0, '2026-09-20 17:18:32'),
(300, 1, 'تم تحديث الملف الشخصي', 'قام المستخدم waleedsami بتحديث ملفه الشخصي.', 1, '2026-09-20 17:20:31'),
(301, 12, 'تم تحديث الملف الشخصي', 'تم تحديث ملفك الشخصي بنجاح.', 1, '2026-09-20 17:20:31'),
(302, 1, 'تم تحديث الملف الشخصي', 'قام المستخدم waleedsami بتحديث ملفه الشخصي.', 1, '2026-09-20 17:20:34'),
(303, 12, 'تم تحديث الملف الشخصي', 'تم تحديث ملفك الشخصي بنجاح.', 1, '2026-09-20 17:20:34'),
(304, 1, 'تم تحديث الملف الشخصي', 'قام المستخدم Suleiman Tayser بتحديث ملفه الشخصي.', 1, '2026-09-20 17:21:23'),
(305, 10, 'تم تحديث الملف الشخصي', 'تم تحديث ملفك الشخصي بنجاح.', 0, '2026-09-20 17:21:23'),
(306, 1, 'تم تحديث الإعدادات', 'تم تحديث إعدادات النظام بنجاح.', 1, '2026-09-20 17:32:16'),
(307, 1, 'تم تحديث الإعدادات', 'تم تحديث إعدادات النظام بنجاح.', 1, '2026-09-20 17:34:02'),
(308, 1, 'تم تحديث الإعدادات', 'تم تحديث إعدادات النظام بنجاح.', 1, '2026-09-20 17:34:05'),
(309, 1, 'تم تحديث الإعدادات', 'تم تحديث إعدادات النظام بنجاح.', 1, '2026-09-20 17:41:34'),
(310, 9, 'اعلان هام', 'اجتماع غدا الساعه 10:30 ص بقاعه 351', 1, '2026-09-23 16:12:41'),
(311, 12, 'اعلان هام', 'اجتماع غدا الساعه 10:30 ص بقاعه 351', 1, '2026-09-23 16:12:41'),
(312, 12, 'طلب إجازة جديد', 'قام الموظف firas safe بتقديم طلب إجازة جديد.', 1, '2026-09-28 16:22:48'),
(313, 35, 'تمت الموافقة على طلب الإجازة', 'تمت الموافقة على طلب الإجازة رقم #9.', 1, '2026-09-28 16:24:42'),
(314, 1, 'اعلان هام', 'اجتماع يوم الاحد القادم الساعه 11 يرجى من الجميع الحضور', 1, '2026-10-21 14:13:37'),
(315, 2, 'اعلان هام', 'اجتماع يوم الاحد القادم الساعه 11 يرجى من الجميع الحضور', 0, '2026-10-21 14:13:37'),
(316, 3, 'اعلان هام', 'اجتماع يوم الاحد القادم الساعه 11 يرجى من الجميع الحضور', 0, '2026-10-21 14:13:37'),
(317, 8, 'اعلان هام', 'اجتماع يوم الاحد القادم الساعه 11 يرجى من الجميع الحضور', 0, '2026-10-21 14:13:37'),
(318, 9, 'اعلان هام', 'اجتماع يوم الاحد القادم الساعه 11 يرجى من الجميع الحضور', 1, '2026-10-21 14:13:37'),
(319, 10, 'اعلان هام', 'اجتماع يوم الاحد القادم الساعه 11 يرجى من الجميع الحضور', 0, '2026-10-21 14:13:37'),
(320, 12, 'اعلان هام', 'اجتماع يوم الاحد القادم الساعه 11 يرجى من الجميع الحضور', 1, '2026-10-21 14:13:37'),
(321, 13, 'اعلان هام', 'اجتماع يوم الاحد القادم الساعه 11 يرجى من الجميع الحضور', 0, '2026-10-21 14:13:37'),
(322, 14, 'اعلان هام', 'اجتماع يوم الاحد القادم الساعه 11 يرجى من الجميع الحضور', 0, '2026-10-21 14:13:37'),
(323, 15, 'اعلان هام', 'اجتماع يوم الاحد القادم الساعه 11 يرجى من الجميع الحضور', 0, '2026-10-21 14:13:37'),
(324, 16, 'اعلان هام', 'اجتماع يوم الاحد القادم الساعه 11 يرجى من الجميع الحضور', 0, '2026-10-21 14:13:37'),
(325, 30, 'اعلان هام', 'اجتماع يوم الاحد القادم الساعه 11 يرجى من الجميع الحضور', 0, '2026-10-21 14:13:37'),
(326, 31, 'اعلان هام', 'اجتماع يوم الاحد القادم الساعه 11 يرجى من الجميع الحضور', 0, '2026-10-21 14:13:37'),
(327, 33, 'اعلان هام', 'اجتماع يوم الاحد القادم الساعه 11 يرجى من الجميع الحضور', 0, '2026-10-21 14:13:37'),
(328, 34, 'اعلان هام', 'اجتماع يوم الاحد القادم الساعه 11 يرجى من الجميع الحضور', 0, '2026-10-21 14:13:37'),
(329, 35, 'اعلان هام', 'اجتماع يوم الاحد القادم الساعه 11 يرجى من الجميع الحضور', 1, '2026-10-21 14:13:37'),
(330, 36, 'اعلان هام', 'اجتماع يوم الاحد القادم الساعه 11 يرجى من الجميع الحضور', 0, '2026-10-21 14:13:37'),
(331, 37, 'اعلان هام', 'اجتماع يوم الاحد القادم الساعه 11 يرجى من الجميع الحضور', 0, '2026-10-21 14:13:37'),
(332, 38, 'اعلان هام', 'اجتماع يوم الاحد القادم الساعه 11 يرجى من الجميع الحضور', 0, '2026-10-21 14:13:37'),
(333, 39, 'اعلان هام', 'اجتماع يوم الاحد القادم الساعه 11 يرجى من الجميع الحضور', 0, '2026-10-21 14:13:37'),
(334, 40, 'اعلان هام', 'اجتماع يوم الاحد القادم الساعه 11 يرجى من الجميع الحضور', 0, '2026-10-21 14:13:37'),
(335, 41, 'اعلان هام', 'اجتماع يوم الاحد القادم الساعه 11 يرجى من الجميع الحضور', 0, '2026-10-21 14:13:37'),
(336, 42, 'اعلان هام', 'اجتماع يوم الاحد القادم الساعه 11 يرجى من الجميع الحضور', 0, '2026-10-21 14:13:37'),
(337, 43, 'اعلان هام', 'اجتماع يوم الاحد القادم الساعه 11 يرجى من الجميع الحضور', 0, '2026-10-21 14:13:37'),
(338, 44, 'اعلان هام', 'اجتماع يوم الاحد القادم الساعه 11 يرجى من الجميع الحضور', 0, '2026-10-21 14:13:37'),
(339, 45, 'اعلان هام', 'اجتماع يوم الاحد القادم الساعه 11 يرجى من الجميع الحضور', 0, '2026-10-21 14:13:37'),
(340, 46, 'اعلان هام', 'اجتماع يوم الاحد القادم الساعه 11 يرجى من الجميع الحضور', 0, '2026-10-21 14:13:37'),
(341, 47, 'اعلان هام', 'اجتماع يوم الاحد القادم الساعه 11 يرجى من الجميع الحضور', 0, '2026-10-21 14:13:37'),
(342, 48, 'اعلان هام', 'اجتماع يوم الاحد القادم الساعه 11 يرجى من الجميع الحضور', 0, '2026-10-21 14:13:37'),
(343, 49, 'اعلان هام', 'اجتماع يوم الاحد القادم الساعه 11 يرجى من الجميع الحضور', 0, '2026-10-21 14:13:37'),
(344, 50, 'اعلان هام', 'اجتماع يوم الاحد القادم الساعه 11 يرجى من الجميع الحضور', 0, '2026-10-21 14:13:37'),
(345, 1, 'اعلان هام', 'على جميع مدراء قسم  IT الحضور غدا الساعه 8', 1, '2026-10-21 14:15:19');

-- --------------------------------------------------------

--
-- بنية الجدول `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `token`, `created_at`) VALUES
(1, 'moataz@gmail.com', 'ca4bcbcf20260defee4bd075e7fd0e1114931a34ce74aebef3c4b072b388ca60', '2026-07-11 12:42:05'),
(8, 'waleedtanani97@gmail.com', '90c1ea5d409d935c8b09b093a05c6ef193adf06fa3349907f594c5d4369b9cd2', '2026-09-19 17:28:29'),
(9, 'we0d20@gmail.com', 'b0380af4414ddf8ebd8a864a87656d010f7129239859850e9d41f1c226615f09', '2026-09-23 16:21:29');

-- --------------------------------------------------------

--
-- بنية الجدول `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `permission_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `permissions`
--

INSERT INTO `permissions` (`id`, `permission_name`) VALUES
(14, 'activity_logs.view'),
(26, 'announcements.create'),
(28, 'announcements.delete'),
(27, 'announcements.edit'),
(25, 'announcements.view'),
(24, 'attendance.view'),
(9, 'dashboard.view'),
(18, 'departments.create'),
(20, 'departments.delete'),
(19, 'departments.edit'),
(17, 'departments.view'),
(23, 'leaves.approve'),
(22, 'leaves.create'),
(21, 'leaves.view'),
(16, 'notifications.view'),
(11, 'profile.edit'),
(10, 'profile.view'),
(13, 'reports.export'),
(12, 'reports.view'),
(6, 'roles.create'),
(8, 'roles.delete'),
(7, 'roles.edit'),
(5, 'roles.view'),
(15, 'settings.view'),
(2, 'users.create'),
(4, 'users.delete'),
(3, 'users.edit'),
(1, 'users.view');

-- --------------------------------------------------------

--
-- بنية الجدول `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `created_at`) VALUES
(1, 'admin', '2026-06-02 13:22:03'),
(2, 'manager', '2026-06-02 13:22:03'),
(3, 'employee', '2026-06-02 13:22:03'),
(6, 'Accountant', '2026-06-15 12:28:43'),
(7, 'Support', '2026-06-15 12:29:02');

-- --------------------------------------------------------

--
-- بنية الجدول `role_permissions`
--

CREATE TABLE `role_permissions` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES
(387, 1, 14),
(388, 1, 26),
(389, 1, 28),
(390, 1, 27),
(391, 1, 25),
(392, 1, 24),
(393, 1, 9),
(394, 1, 18),
(395, 1, 20),
(396, 1, 19),
(397, 1, 17),
(398, 1, 23),
(399, 1, 22),
(400, 1, 21),
(401, 1, 16),
(402, 1, 11),
(403, 1, 10),
(404, 1, 13),
(405, 1, 12),
(406, 1, 6),
(407, 1, 8),
(408, 1, 7),
(409, 1, 5),
(410, 1, 15),
(411, 1, 2),
(412, 1, 4),
(413, 1, 3),
(414, 1, 1),
(437, 1, 25),
(438, 1, 26),
(439, 1, 27),
(440, 1, 28),
(479, 3, 25),
(480, 3, 24),
(481, 3, 9),
(482, 3, 22),
(483, 3, 21),
(484, 3, 16),
(485, 3, 11),
(486, 3, 10),
(487, 2, 25),
(488, 2, 24),
(489, 2, 9),
(490, 2, 17),
(491, 2, 23),
(492, 2, 22),
(493, 2, 21),
(494, 2, 16),
(495, 2, 11),
(496, 2, 10),
(497, 2, 13),
(498, 2, 12),
(499, 2, 5),
(500, 2, 2),
(501, 2, 3),
(502, 2, 1);

-- --------------------------------------------------------

--
-- بنية الجدول `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `site_name` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `settings`
--

INSERT INTO `settings` (`id`, `site_name`, `company_name`, `logo`) VALUES
(1, 'Employee Hup', 'TechSolutions lnc', '1789926094_6ab01ace56e61.jpg');

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT 'default.png',
  `role_id` int(11) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `deleted_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `theme` enum('light','dark') DEFAULT 'light'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `image`, `role_id`, `department_id`, `status`, `deleted_at`, `created_at`, `theme`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$10$00u7FQrTZKiaFtNpyRj4teehgwKWkWSx9O3J0DBOR4lKh8DCLc8PG', 'default.png', 1, NULL, 'active', NULL, '2026-06-02 13:32:23', 'light'),
(2, 'Ahmed', 'ahmed@gmail.com', '$2y$10$1rqqfGXhNtuJiifydBCuVeqEcPRPM5SjvWyD0gzWX9.yFADzH/qEK', '', 3, 5, 'active', NULL, '2026-06-04 15:19:47', 'light'),
(3, 'yasser', 'yasser@gmail.com', '$2y$10$BKw93GcA/6DLnFa7M6yOnu7nyG/ebXix/fWXEeIQRWqvA9f9b/pLK', '1781102093_ibrahem.png', 3, 5, 'active', NULL, '2026-06-05 15:10:32', 'light'),
(8, 'Zaher', 'zaher@gmail.com', '$2y$10$RlKdGVvvCCRbFTgpEFCHYOzhFev8.kZ3w6/TBXWKc4vHZwGpoA1RO', '', 3, 1, 'active', NULL, '2026-06-06 14:32:53', 'light'),
(9, 'moataz', 'moataz@gmail.com', '$2y$10$.stdh5WOPqIzwO51eBKpMuChE2YlhyHNaX5bof10YaMz26ZFY6Q7W', '1780757527.jpg', 2, 5, 'active', NULL, '2026-06-06 14:52:07', 'light'),
(10, 'Suleiman Tayser', 'suleiman@gmail.com', '$2y$10$2MgFYX4oqrVc8ESjJeTMcOogxlF99bRJCp.V0nh24yLc/tiF61zgy', '', 3, 1, 'active', NULL, '2026-06-06 14:55:23', 'light'),
(12, 'waleedsami', 'waleesami@gmail.com', '$2y$10$k8RjVinYUXTTj.C04nxGTOgmhhtq4F01LGoj/2v9rk4YwvhGXnQX2', '1789924831_1780757723nnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnn.jpg', 2, 1, 'active', NULL, '2026-06-07 16:26:02', 'light'),
(13, 'Hassan Mohammed smer', 'hassan@gmail.com', '$2y$10$h5OP5RxVqdTFYkFHsb9vp.uUOCSzZlPpTpX4LBoI86D4aV0jgIUtm', '', 3, 5, 'active', NULL, '2026-06-08 15:16:18', 'light'),
(14, 'faisal naim', 'faisal@gmail.com', '$2y$10$zy7E1eLJWZ.riCGCpCei8epfLzlnkUnhCcWJ7bZd0YqdQD0k0s1uu', '', 3, 5, 'active', NULL, '2026-06-09 13:17:30', 'light'),
(15, 'fahad adnan', 'fahad@gmail.com', '$2y$10$gkRmJcrndtrKbd/jhnzif.cfdFBRxAiOqMEsHGUeWcEeX9/miuUfa', '', 3, 5, 'active', NULL, '2026-06-20 12:46:44', 'light'),
(16, 'Rami samir', 'rami@gmail.com', '$2y$10$bNZl6FQSiKfla7s5QwbEPuuVOHymZ4SUOycOxFaee335Hv4vzjvC2', '', 3, 5, 'active', NULL, '2026-06-28 14:46:03', 'light'),
(30, 'waleed sami', 'we0d20@gmail.com', '$2y$10$7u3Up/KjCc2De8QTc10eYOKbz/zM2MqcREdppzWKozgGzW60J.BMC', '', 3, 1, 'active', NULL, '2026-07-19 14:18:31', 'light'),
(31, 'ayman', 'waleed66552200@gmail.com', '$2y$10$S16xbQ3APYgO3zyLR339wOqxZa8b7VShHcDdZz3bHMZiNnJtDkkSa', '', 3, 1, 'active', NULL, '2026-07-20 13:05:08', 'light'),
(33, 'waleed mohammed', 'waleedtanani97@gmail.com', '$2y$10$Xr3yDmY5ObKRT73CfFWh7.tEvgxMPEp6pZth3vOb8elQQNKopGPFK', '', 3, 5, 'active', NULL, '2026-07-23 12:07:41', 'light'),
(34, 'fadi sami', 'fadi@gmail.com', '$2y$10$AdDrhpYJKKABIhhEO8BAT.0lCA2zDcqKc/WxjTDcz.IPH.gb77mym', '', 3, 5, 'active', NULL, '2026-07-26 18:53:30', 'light'),
(35, 'firas safe', 'firas@gmail.com', '$2y$10$BsQDy.1khDW93nMh5x/E1eOKY9ttSFJNtIIimd.0PbKg1pTO4Jm46', '', 3, 1, 'active', NULL, '2026-08-05 12:21:29', 'light'),
(36, 'farouk mohammed', 'farouk@gmail.com', '$2y$10$SmJHNS5EtbhbARyjt3EQMO0KnvEqX5mLuC.N3ZG7xt7AK0b7.yo4e', '', 3, 1, 'active', NULL, '2026-08-05 12:22:10', 'light'),
(37, 'rawan salah', 'rawansalah@gmail.com', '$2y$10$vk6WZ5sYG4pD7AZ4JqnewuyYkws132vrKyYHZ2AmHA7r/1NE3gUyS', '', 3, 5, 'active', NULL, '2026-08-05 13:36:35', 'light'),
(38, 'rawan salah', 'rawansalah1@gmail.com', '$2y$10$dIGAEHbLclDBNpSa6m0gIuplljy7iwWyLDrOQ1Gdq2SZqQ27cUOSi', '', 3, 5, 'active', NULL, '2026-08-05 13:37:01', 'light'),
(39, 'maram naser', 'maram@gmail.com', '$2y$10$pabhRcHpDDeU.j0PsO6nkO4Gpym1iuBezhatydyLhGctGesodOq2O', '', 3, 1, 'active', NULL, '2026-08-05 13:38:18', 'light'),
(40, 'omar ahmed', 'omarahmed@gmail.com', '$2y$10$qHr5Shx6bqec2Ww02qWu.uws.ZJwCposg4OqJGuJTbNXHPHPBy8A.', '', 3, 1, 'active', NULL, '2026-08-08 13:31:51', 'light'),
(41, 'omar ahmed', 'omarahmed1@gmail.com', '$2y$10$WIkWesuOYD5rx21NrildCOo5mdUoq.5Iq5Hj5JGv5FKiqYHrTx3iy', 'default.png', 3, 1, 'active', NULL, '2026-08-08 13:32:32', 'light'),
(42, 'sary naim', 'sary@gmail.com', '$2y$10$r6ZO5fCGqtgnEiipfYQQEuyo2szd.F3POgolbtMFzcImM/WlrLs72', '', 3, 1, 'active', NULL, '2026-08-08 13:33:55', 'light'),
(43, 'hanafi khaled', 'h0122n@gmail.com', '$2y$10$DFQIanP.qlOOIwLpky0z6OjwWh1Vh9v/rlQyykQEN8kYtNVcCc13W', '', 3, 5, 'active', NULL, '2026-08-08 13:59:39', 'light'),
(44, 'tamer mohsen', 'tamer14@gmail.com', '$2y$10$pg318Dkt1.CjImDNBjl/GegA9afaC31bXYoi3/ORoGOHhpDjco1Ey', '', 3, 5, 'active', NULL, '2026-08-09 18:54:51', 'light'),
(45, 'rakan ahmed', 'rakan14ahmed@gmail.com', '$2y$10$n73HkUAeTTR7iCtwDvu6TOUmsoHLTR1ZNvEAvAl6N0S6C.G.oY8RC', '', 3, 5, 'active', NULL, '2026-09-13 15:23:14', 'light'),
(46, 'wasef assaf', 'wasasaf@gmail.com', '$2y$10$GzY.adNR/wFhomzm.N/vLuAN9T/m7HsXZ1f2Afx4s78dR.qsMEKpa', '', 3, 5, 'active', NULL, '2026-09-13 15:25:39', 'light'),
(47, 'mansour mahmoud', 'mansour123@gmail.com', '$2y$10$ydkE2LLykkCX5bluzxu6zuZp2VBTP8GlTFPuwhVUcrjI/VbdM7uDy', '', 3, 1, 'active', NULL, '2026-09-13 16:05:48', 'light'),
(48, 'sameh mohamed', 'sameh147@gmail.com', '$2y$10$bvZJQoohk32V317.W84haeTW2eZ0md6Ny6byJt/0MbIVnSiKcJ2zO', '', 3, 5, 'active', NULL, '2026-09-13 16:08:08', 'light'),
(49, 'laith khaled', 'laith7899@gmail.com', '$2y$10$lqVBymChYQA4QVbIIePpMOchGJwuhDo6JhCirjBLXSSStm1B3I9F6', '', 3, 5, 'active', NULL, '2026-09-13 16:11:32', 'light'),
(50, 'amen hadi', 'amen547@gmail.com', '$2y$10$k6X52wiSEGyxP8gZ2XVvGetzA2sLLdtlpDZ.rhKW6FkpR0yoS.G.y', '', 3, 1, 'active', NULL, '2026-09-13 16:14:33', 'light');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_date` (`user_id`,`attendance_date`),
  ADD KEY `idx_attendance_date` (`attendance_date`),
  ADD KEY `idx_attendance_user` (`user_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permission_name` (`permission_name`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_user_role` (`role_id`),
  ADD KEY `fk_department` (`department_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=880;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `leave_requests`
--
ALTER TABLE `leave_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=346;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=503;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- قيود الجداول المُلقاة.
--

--
-- قيود الجداول `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `fk_attendance_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD CONSTRAINT `leave_requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_department` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
