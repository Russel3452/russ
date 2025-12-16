-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2025 at 12:30 PM
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
-- Database: `hw`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `session_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('present','absent','late','excused') NOT NULL DEFAULT 'present',
  `checked_in_at` timestamp NULL DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `recorded_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `session_id`, `user_id`, `status`, `checked_in_at`, `notes`, `recorded_by`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 'present', '2025-12-15 12:03:12', NULL, 2, '2025-12-15 11:16:01', '2025-12-15 12:03:12'),
(2, 1, 6, 'present', '2025-12-15 12:03:12', NULL, 2, '2025-12-15 11:16:01', '2025-12-15 12:03:12'),
(3, 1, 7, 'present', '2025-12-15 12:03:12', NULL, 2, '2025-12-15 11:16:01', '2025-12-15 12:03:12'),
(4, 1, 8, 'present', '2025-12-15 12:03:12', NULL, 2, '2025-12-15 11:16:01', '2025-12-15 12:03:12'),
(5, 1, 19, 'present', '2025-12-15 12:03:12', NULL, 2, '2025-12-15 11:16:01', '2025-12-15 12:03:12'),
(6, 1, 4, 'present', '2025-12-15 12:03:12', NULL, 2, '2025-12-15 12:03:12', '2025-12-15 12:03:12'),
(7, 12, 4, 'present', '2025-12-16 03:06:27', NULL, 2, '2025-12-16 03:06:27', '2025-12-16 03:06:27'),
(8, 12, 5, 'late', NULL, NULL, 2, '2025-12-16 03:06:27', '2025-12-16 03:06:27'),
(9, 12, 6, 'present', '2025-12-16 03:06:27', NULL, 2, '2025-12-16 03:06:27', '2025-12-16 03:06:27'),
(10, 12, 7, 'present', '2025-12-16 03:06:27', NULL, 2, '2025-12-16 03:06:27', '2025-12-16 03:06:27'),
(11, 12, 8, 'present', '2025-12-16 03:06:27', NULL, 2, '2025-12-16 03:06:27', '2025-12-16 03:06:27'),
(12, 12, 19, 'present', '2025-12-16 03:06:27', NULL, 2, '2025-12-16 03:06:27', '2025-12-16 03:06:27');

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED DEFAULT NULL,
  `old_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`old_values`)),
  `new_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`new_values`)),
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `model`, `model_id`, `old_values`, `new_values`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(1, 1, 'create', 'User', 14, NULL, '{\"name\":\"JOHN LLOYD BLANQUERA\",\"email\":\"loyd@wellness.com\",\"password\":\"$2y$12$ZYfM8okNiOe8n85i02mbheTDX2T6yWwkeg4lrCfjGcrgr43vAw4zG\",\"role\":\"participant\",\"phone\":\"09563222820\",\"address\":\"Zone 4\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-15 08:53:56', '2025-12-15 08:53:56'),
(2, 1, 'update', 'User', 14, '{\"id\":14,\"name\":\"JOHN LLOYD BLANQUERA\",\"email\":\"loyd@wellness.com\",\"role\":\"participant\",\"phone\":\"09563222820\",\"address\":\"Zone 4\",\"date_of_birth\":null,\"gender\":null,\"health_conditions\":null,\"email_verified_at\":null,\"created_at\":\"2025-12-15T16:53:56.000000Z\",\"updated_at\":\"2025-12-15T16:53:56.000000Z\"}', '{\"name\":\"JOHN LLOYD BLANQUERAs\",\"email\":\"loyd@wellness.com\",\"role\":\"participant\",\"phone\":\"09563222820\",\"address\":\"Zone 4\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-15 08:55:16', '2025-12-15 08:55:16'),
(3, 1, 'delete', 'User', 14, '{\"id\":14,\"name\":\"JOHN LLOYD BLANQUERAs\",\"email\":\"loyd@wellness.com\",\"role\":\"participant\",\"phone\":\"09563222820\",\"address\":\"Zone 4\",\"date_of_birth\":null,\"gender\":null,\"health_conditions\":null,\"email_verified_at\":null,\"created_at\":\"2025-12-15T16:53:56.000000Z\",\"updated_at\":\"2025-12-15T16:55:16.000000Z\"}', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-15 08:56:14', '2025-12-15 08:56:14'),
(4, 1, 'create', 'Program', 5, NULL, '{\"name\":\"john lloyd\",\"description\":\"xsavdsv\",\"category\":\"fitness\",\"coordinator_id\":\"2\",\"start_date\":\"2025-12-16\",\"end_date\":\"2025-12-17\",\"enrollment_deadline\":\"2025-12-16\",\"duration\":\"sdsgsdg\",\"location\":\"Bula\",\"capacity\":\"15\",\"status\":\"active\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-15 09:13:13', '2025-12-15 09:13:13'),
(5, 1, 'update', 'SystemSetting', NULL, NULL, '{\"max_active_programs\":\"3\",\"wellness_categories\":\"Fitness,Mental Health,Wellness,Nutrition,Yoga\",\"metric_templates\":\"Weight,Blood Pressure,Heart Rate,BMI,Body Fat %\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-15 09:18:29', '2025-12-15 09:18:29'),
(6, 1, 'generate_report', 'Report', NULL, NULL, '{\"report_type\":\"user\",\"date_range\":\"last_7_days\",\"format\":\"pdf\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-15 09:30:19', '2025-12-15 09:30:19'),
(7, 1, 'generate_report', 'Report', NULL, NULL, '{\"report_type\":\"program\",\"date_range\":\"last_7_days\",\"format\":\"pdf\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-15 09:32:02', '2025-12-15 09:32:02'),
(8, 1, 'generate_report', 'Report', NULL, NULL, '{\"report_type\":\"user\",\"date_range\":\"last_7_days\",\"format\":\"pdf\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-15 09:34:31', '2025-12-15 09:34:31'),
(9, 1, 'generate_report', 'Report', NULL, NULL, '{\"report_type\":\"program\",\"date_range\":\"last_7_days\",\"format\":\"pdf\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-15 09:34:56', '2025-12-15 09:34:56'),
(10, 1, 'generate_report', 'Report', NULL, NULL, '{\"report_type\":\"user\",\"date_range\":\"last_7_days\",\"format\":\"pdf\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-15 09:37:22', '2025-12-15 09:37:22'),
(11, 1, 'generate_report', 'Report', NULL, NULL, '{\"report_type\":\"user\",\"date_range\":\"last_7_days\",\"format\":\"excel\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-15 09:38:12', '2025-12-15 09:38:12'),
(12, 1, 'generate_report', 'Report', NULL, NULL, '{\"report_type\":\"user\",\"date_range\":\"last_7_days\",\"format\":\"csv\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-15 09:38:25', '2025-12-15 09:38:25'),
(13, 1, 'generate_report', 'Report', NULL, NULL, '{\"report_type\":\"user\",\"date_range\":\"last_7_days\",\"format\":\"pdf\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-15 09:54:59', '2025-12-15 09:54:59'),
(14, 1, 'generate_report', 'Report', NULL, NULL, '{\"report_type\":\"user\",\"date_range\":\"last_7_days\",\"format\":\"pdf\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-15 10:03:13', '2025-12-15 10:03:13'),
(15, 1, 'generate_report', 'Report', NULL, NULL, '{\"report_type\":\"program\",\"date_range\":\"last_7_days\",\"format\":\"excel\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-15 10:03:29', '2025-12-15 10:03:29'),
(16, 1, 'generate_report', 'Report', NULL, NULL, '{\"report_type\":\"activity\",\"date_range\":\"last_7_days\",\"format\":\"csv\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-15 10:03:39', '2025-12-15 10:03:39'),
(17, 1, 'update', 'User', 1, NULL, '{\"name\":\"Admin User\",\"email\":\"admin@wellness.com\",\"phone\":\"555-0100\",\"date_of_birth\":null,\"gender\":\"male\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-15 10:32:01', '2025-12-15 10:32:01'),
(18, 2, 'create', 'Session', 41, NULL, '{\"topic\":\"sfs\",\"description\":\"fvsevs\",\"facilitator\":\"sevseg\",\"location\":\"esgsg\",\"session_date\":\"2025-12-16T02:42\",\"duration_minutes\":\"60\",\"program_id\":\"5\",\"status\":\"scheduled\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-15 10:42:42', '2025-12-15 10:42:42'),
(19, 2, 'create', 'Program', 10, NULL, '{\"name\":\"john lloyd\",\"description\":\"dfg\",\"category\":\"fitness\",\"start_date\":\"2025-12-16\",\"end_date\":\"2025-12-17\",\"enrollment_deadline\":\"2025-12-15\",\"capacity\":\"30\",\"status\":\"active\",\"coordinator_id\":2,\"enrolled_count\":0}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-15 11:00:39', '2025-12-15 11:00:39'),
(20, 2, 'create', 'ProgressMetric', 1, NULL, '{\"metric_type\":\"120\\/80\",\"metric_value\":\"150\",\"unit\":\"72\",\"recorded_date\":\"2025-12-15\",\"notes\":\"dvffbd\",\"registration_id\":\"1\",\"recorded_by\":2}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-15 11:05:58', '2025-12-15 11:05:58'),
(21, 2, 'create', 'ProgressMetric', 2, NULL, '{\"metric_type\":\"bp\",\"metric_value\":\"120\\/80\",\"unit\":\"bp\",\"recorded_date\":\"2025-12-15\",\"notes\":\"fgdrfg\",\"registration_id\":\"1\",\"recorded_by\":2}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-15 11:07:17', '2025-12-15 11:07:17'),
(22, 2, 'update', 'Registration', 1, '{\"id\":1,\"user_id\":4,\"program_id\":1,\"health_goals\":\"Want to lose weight and feel healthier\",\"personal_notes\":null,\"status\":\"registered\",\"withdrawal_reason\":null,\"registered_at\":\"2025-12-16T02:10:17.000000Z\",\"created_at\":\"2025-09-06T18:10:17.000000Z\",\"updated_at\":\"2025-12-15T18:10:17.000000Z\"}', '{\"id\":1,\"user_id\":4,\"program_id\":1,\"health_goals\":\"Want to lose weight and feel healthier\",\"personal_notes\":null,\"status\":\"withdrawn\",\"withdrawal_reason\":\"etgrthfy\",\"registered_at\":\"2025-12-16T02:10:17.000000Z\",\"created_at\":\"2025-09-06T18:10:17.000000Z\",\"updated_at\":\"2025-12-15T19:07:50.000000Z\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-15 11:07:51', '2025-12-15 11:07:51'),
(23, 2, 'update', 'Program', 10, '{\"id\":10,\"name\":\"john lloyd\",\"description\":\"dfg\",\"category\":\"fitness\",\"start_date\":\"2025-12-16T00:00:00.000000Z\",\"end_date\":\"2025-12-17T00:00:00.000000Z\",\"enrollment_deadline\":\"2025-12-15T00:00:00.000000Z\",\"capacity\":30,\"enrolled_count\":0,\"status\":\"active\",\"coordinator_id\":2,\"created_at\":\"2025-12-15T19:00:39.000000Z\",\"updated_at\":\"2025-12-15T19:00:39.000000Z\"}', '{\"name\":\"john lloyd\",\"description\":\"dfg\",\"category\":\"fitness\",\"start_date\":\"2025-12-16\",\"end_date\":\"2025-12-17\",\"enrollment_deadline\":\"2025-12-15\",\"capacity\":\"30\",\"status\":\"draft\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-15 11:09:37', '2025-12-15 11:09:37'),
(24, 2, 'update', 'Program', 10, '{\"id\":10,\"name\":\"john lloyd\",\"description\":\"dfg\",\"category\":\"fitness\",\"start_date\":\"2025-12-16T00:00:00.000000Z\",\"end_date\":\"2025-12-17T00:00:00.000000Z\",\"enrollment_deadline\":\"2025-12-15T00:00:00.000000Z\",\"capacity\":30,\"enrolled_count\":0,\"status\":\"draft\",\"coordinator_id\":2,\"created_at\":\"2025-12-15T19:00:39.000000Z\",\"updated_at\":\"2025-12-15T19:09:37.000000Z\"}', '{\"name\":\"john lloyd\",\"description\":\"dfg\",\"category\":\"fitness\",\"start_date\":\"2025-12-16\",\"end_date\":\"2025-12-17\",\"enrollment_deadline\":\"2025-12-15\",\"capacity\":\"30\",\"status\":\"draft\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-15 11:09:45', '2025-12-15 11:09:45'),
(25, 2, 'create', 'Session', 42, NULL, '{\"topic\":\"sfs\",\"description\":\"csdvfbgnh\",\"facilitator\":\"sevseg\",\"location\":\"Nabua\",\"session_date\":\"2025-12-16T03:10\",\"duration_minutes\":\"60\",\"program_id\":\"10\",\"status\":\"scheduled\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-15 11:10:12', '2025-12-15 11:10:12'),
(26, 2, 'create', 'Attendance', 1, NULL, '{\"attendance\":[{\"user_id\":\"5\",\"status\":\"present\",\"notes\":null},{\"user_id\":\"6\",\"status\":\"present\",\"notes\":null},{\"user_id\":\"7\",\"status\":\"present\",\"notes\":null},{\"user_id\":\"8\",\"status\":\"present\",\"notes\":null},{\"user_id\":\"19\",\"status\":\"present\",\"notes\":null}]}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-15 11:16:01', '2025-12-15 11:16:01'),
(27, 4, 'update', 'Registration', 1, '{\"health_goals\":\"Want to lose weight and feel healthier\",\"personal_notes\":null}', '{\"health_goals\":\"Want to lose weight and feel healthier\",\"personal_notes\":\"okay\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-15 11:37:46', '2025-12-15 11:37:46'),
(28, 4, 'create', 'Registration', 2, NULL, '{\"health_goals\":\"dsfd\",\"personal_notes\":\"sfsgv\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-15 11:58:05', '2025-12-15 11:58:05'),
(29, 4, 'create', 'Registration', 1, NULL, '{\"health_goals\":null,\"personal_notes\":null}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-15 12:02:04', '2025-12-15 12:02:04'),
(30, 2, 'create', 'Attendance', 1, NULL, '{\"attendance\":[{\"user_id\":\"4\",\"status\":\"present\",\"notes\":null},{\"user_id\":\"5\",\"status\":\"present\",\"notes\":null},{\"user_id\":\"6\",\"status\":\"present\",\"notes\":null},{\"user_id\":\"7\",\"status\":\"present\",\"notes\":null},{\"user_id\":\"8\",\"status\":\"present\",\"notes\":null},{\"user_id\":\"19\",\"status\":\"present\",\"notes\":null}]}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-15 12:03:12', '2025-12-15 12:03:12'),
(31, 4, 'update', 'User', 4, NULL, '{\"name\":\"Participant 1a\",\"email\":\"participant1@wellness.com\",\"phone\":\"555-0001\",\"date_of_birth\":\"2002-12-15\",\"gender\":\"other\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-15 12:07:51', '2025-12-15 12:07:51'),
(32, 4, 'update', 'User', 4, NULL, '{\"name\":\"Participant 1\",\"email\":\"participant1@wellness.com\",\"phone\":\"555-0001\",\"date_of_birth\":\"2002-12-15\",\"gender\":\"other\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-15 12:07:57', '2025-12-15 12:07:57'),
(33, 1, 'generate_report', 'Report', NULL, NULL, '{\"report_type\":\"user\",\"date_range\":\"last_7_days\",\"format\":\"pdf\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2025-12-16 02:14:52', '2025-12-16 02:14:52'),
(34, 1, 'create', 'User', 37, NULL, '{\"name\":\"john\",\"email\":\"johnlloydblanquera22306@gmail.com\",\"password\":\"$2y$12$yu4r1Jy27AHvi9NuFjUjUezAK11BB14Z56TEAUTMPW7EmSaKYgpsm\",\"role\":\"participant\",\"phone\":\"09706065972\",\"address\":\"Zone 4\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-16 02:53:06', '2025-12-16 02:53:06'),
(35, 1, 'generate_report', 'Report', NULL, NULL, '{\"report_type\":\"user\",\"date_range\":\"last_7_days\",\"format\":\"pdf\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-16 02:57:25', '2025-12-16 02:57:25'),
(36, 1, 'generate_report', 'Report', NULL, NULL, '{\"report_type\":\"user\",\"date_range\":\"last_7_days\",\"format\":\"excel\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-16 02:57:57', '2025-12-16 02:57:57'),
(37, 1, 'generate_report', 'Report', NULL, NULL, '{\"report_type\":\"program\",\"date_range\":\"last_7_days\",\"format\":\"excel\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-16 02:58:36', '2025-12-16 02:58:36'),
(38, 1, 'update', 'User', 1, NULL, '{\"name\":\"Admin Users\",\"email\":\"admin@wellness.com\",\"phone\":\"555-0100\",\"date_of_birth\":null,\"gender\":\"male\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-16 02:59:38', '2025-12-16 02:59:38'),
(39, 1, 'update', 'User', 1, NULL, '{\"name\":\"Admin User\",\"email\":\"admin@wellness.com\",\"phone\":\"555-0100\",\"date_of_birth\":null,\"gender\":\"male\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-16 02:59:55', '2025-12-16 02:59:55'),
(40, 2, 'create', 'Program', 11, NULL, '{\"name\":\"sapokin si jonas\",\"description\":\"gamitan ng flying kick\",\"category\":\"fitness\",\"start_date\":\"2025-12-18\",\"end_date\":\"2025-12-20\",\"enrollment_deadline\":\"2025-12-16\",\"capacity\":\"30\",\"status\":\"active\",\"coordinator_id\":2,\"enrolled_count\":0}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-16 03:03:28', '2025-12-16 03:03:28'),
(41, 2, 'create', 'Session', 43, NULL, '{\"topic\":\"kilangan sapokin si jonas\",\"description\":\"asdsfbghnhjhgf\",\"facilitator\":\"ikaw\",\"location\":\"nabua\",\"session_date\":\"2025-12-17T19:04\",\"duration_minutes\":\"60\",\"program_id\":\"11\",\"status\":\"scheduled\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-16 03:04:57', '2025-12-16 03:04:57'),
(42, 2, 'create', 'Attendance', 12, NULL, '{\"attendance\":[{\"user_id\":\"4\",\"status\":\"present\",\"notes\":null},{\"user_id\":\"5\",\"status\":\"late\",\"notes\":null},{\"user_id\":\"6\",\"status\":\"present\",\"notes\":null},{\"user_id\":\"7\",\"status\":\"present\",\"notes\":null},{\"user_id\":\"8\",\"status\":\"present\",\"notes\":null},{\"user_id\":\"19\",\"status\":\"present\",\"notes\":null}]}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-16 03:06:27', '2025-12-16 03:06:27'),
(43, 2, 'create', 'ProgressMetric', 3, NULL, '{\"metric_type\":\"bp\",\"metric_value\":\"120\\/80\",\"unit\":\"bp\",\"recorded_date\":\"2025-12-16\",\"notes\":\"adsfdgrfhtjgyuhlji\",\"registration_id\":\"5\",\"recorded_by\":2}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-16 03:07:40', '2025-12-16 03:07:40'),
(44, 2, 'update', 'Registration', 1, '{\"id\":1,\"user_id\":4,\"program_id\":1,\"health_goals\":null,\"personal_notes\":null,\"status\":\"registered\",\"withdrawal_reason\":\"etgrthfy\",\"registered_at\":\"2025-12-15T20:02:04.000000Z\",\"created_at\":\"2025-09-06T18:10:17.000000Z\",\"updated_at\":\"2025-12-15T20:02:04.000000Z\"}', '{\"id\":1,\"user_id\":4,\"program_id\":1,\"health_goals\":null,\"personal_notes\":null,\"status\":\"withdrawn\",\"withdrawal_reason\":\"pinalo\",\"registered_at\":\"2025-12-15T20:02:04.000000Z\",\"created_at\":\"2025-09-06T18:10:17.000000Z\",\"updated_at\":\"2025-12-16T11:11:08.000000Z\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-16 03:11:08', '2025-12-16 03:11:08'),
(45, 4, 'create', 'Registration', 1, NULL, '{\"health_goals\":\"sfdgfhtgjykuh\",\"personal_notes\":\"asfzdgfhgjhj\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-16 03:12:57', '2025-12-16 03:12:57'),
(46, 4, 'create', 'Registration', 8, NULL, '{\"health_goals\":\"cxvcbvnbm\",\"personal_notes\":\"czvnbmn,m\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', '2025-12-16 03:15:56', '2025-12-16 03:15:56');

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
-- Table structure for table `generated_reports`
--

CREATE TABLE `generated_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `report_type` varchar(255) NOT NULL,
  `date_range` varchar(255) NOT NULL,
  `format` varchar(255) NOT NULL,
  `filters` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`filters`)),
  `filename` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `generated_reports`
--

INSERT INTO `generated_reports` (`id`, `user_id`, `report_type`, `date_range`, `format`, `filters`, `filename`, `created_at`, `updated_at`) VALUES
(1, 1, 'User Report', 'last_7_days', 'PDF', '{\"role\":\"all\"}', 'user_report_2025-12-15_180313.pdf', '2025-12-15 10:03:13', '2025-12-15 10:03:13'),
(2, 1, 'Program Report', 'last_7_days', 'EXCEL', '{\"status\":\"all\",\"category\":\"all\"}', 'program_report_2025-12-15_180329.excel', '2025-12-15 10:03:29', '2025-12-15 10:03:29'),
(3, 1, 'Activity Report', 'last_7_days', 'CSV', '{\"action\":\"all\",\"model\":\"all\"}', 'activity_report_2025-12-15_180339.csv', '2025-12-15 10:03:39', '2025-12-15 10:03:39'),
(4, 1, 'User Report', 'last_7_days', 'PDF', '{\"role\":\"all\"}', 'user_report_2025-12-16_101452.pdf', '2025-12-16 02:14:52', '2025-12-16 02:14:52'),
(5, 1, 'User Report', 'last_7_days', 'PDF', '{\"role\":\"all\"}', 'user_report_2025-12-16_105725.pdf', '2025-12-16 02:57:25', '2025-12-16 02:57:25'),
(6, 1, 'User Report', 'last_7_days', 'EXCEL', '{\"role\":\"all\"}', 'user_report_2025-12-16_105757.excel', '2025-12-16 02:57:57', '2025-12-16 02:57:57'),
(7, 1, 'Program Report', 'last_7_days', 'EXCEL', '{\"status\":\"all\",\"category\":\"all\"}', 'program_report_2025-12-16_105836.excel', '2025-12-16 02:58:36', '2025-12-16 02:58:36');

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_12_16_000003_add_role_to_users_table', 1),
(5, '2024_12_16_000004_create_programs_table', 1),
(6, '2024_12_16_000005_create_registrations_table', 1),
(7, '2024_12_16_000006_create_sessions_table', 1),
(8, '2024_12_16_000007_create_attendance_table', 1),
(9, '2024_12_16_000008_create_progress_metrics_table', 1),
(10, '2024_12_16_000009_create_audit_logs_table', 1),
(13, '2024_12_16_000010_create_system_settings_table', 2),
(14, '2025_12_15_175732_create_generated_reports_table', 2);

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
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `category` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `enrollment_deadline` date NOT NULL,
  `capacity` int(11) NOT NULL,
  `enrolled_count` int(11) NOT NULL DEFAULT 0,
  `status` enum('draft','active','completed','cancelled') NOT NULL DEFAULT 'draft',
  `coordinator_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`id`, `name`, `description`, `category`, `start_date`, `end_date`, `enrollment_deadline`, `capacity`, `enrolled_count`, `status`, `coordinator_id`, `created_at`, `updated_at`) VALUES
(1, 'Weight Loss Challenge', 'A comprehensive 12-week weight loss program designed to help you achieve your fitness goals through proper nutrition and exercise.', 'Fitness', '2025-12-22', '2026-03-16', '2025-12-18', 20, 8, 'active', 2, '2025-06-26 10:10:17', '2025-12-16 03:12:57'),
(2, 'Stress Management Workshop', 'Learn effective techniques to manage stress and improve your mental well-being through mindfulness and relaxation exercises.', 'Mental Health', '2025-12-25', '2026-02-09', '2025-12-20', 15, 2, 'active', 3, '2025-11-29 10:10:17', '2025-12-15 11:58:05'),
(3, 'Yoga and Meditation', 'Improve flexibility, strength, and inner peace through guided yoga and meditation sessions.', 'Wellness', '2025-12-29', '2026-03-23', '2025-12-22', 25, 1, 'active', 2, '2025-12-04 10:10:17', '2025-12-15 10:10:17'),
(4, 'Nutrition Basics', 'Learn the fundamentals of healthy eating and meal planning for optimal health.', 'Nutrition', '2025-12-20', '2026-01-26', '2025-12-17', 30, 5, 'active', 3, '2025-07-07 10:10:17', '2025-12-15 10:10:17'),
(5, 'john lloyd', 'xsavdsv', 'fitness', '2025-12-16', '2025-12-17', '2025-12-16', 15, 0, 'active', 2, '2025-12-15 09:13:13', '2025-12-15 09:13:13'),
(6, 'Cardio Bootcamp', 'A comprehensive program designed to help you achieve your wellness goals.', 'Fitness', '2025-12-22', '2026-03-09', '2025-12-18', 20, 2, 'completed', 2, '2025-11-20 10:10:17', '2025-12-15 10:10:17'),
(7, 'Mindfulness Training', 'A comprehensive program designed to help you achieve your wellness goals.', 'Mental Health', '2025-12-22', '2026-03-09', '2025-12-18', 16, 1, 'completed', 3, '2025-07-10 10:10:17', '2025-12-15 10:10:17'),
(8, 'Strength Training', 'A comprehensive program designed to help you achieve your wellness goals.', 'Fitness', '2025-12-22', '2026-03-09', '2025-12-18', 23, 6, 'active', 2, '2025-07-30 10:10:17', '2025-12-16 03:15:56'),
(9, 'Healthy Cooking Class', 'A comprehensive program designed to help you achieve your wellness goals.', 'Nutrition', '2025-12-22', '2026-03-09', '2025-12-18', 27, 2, 'completed', 3, '2025-08-12 10:10:17', '2025-12-15 10:10:17'),
(10, 'john lloyd', 'dfg', 'fitness', '2025-12-16', '2025-12-17', '2025-12-15', 30, 0, 'draft', 2, '2025-12-15 11:00:39', '2025-12-15 11:09:37'),
(11, 'sapokin si jonas', 'gamitan ng flying kick', 'fitness', '2025-12-18', '2025-12-20', '2025-12-16', 30, 0, 'active', 2, '2025-12-16 03:03:28', '2025-12-16 03:03:28');

-- --------------------------------------------------------

--
-- Table structure for table `program_sessions`
--

CREATE TABLE `program_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `program_id` bigint(20) UNSIGNED NOT NULL,
  `topic` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `facilitator` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `session_date` datetime NOT NULL,
  `duration_minutes` int(11) NOT NULL,
  `status` enum('scheduled','ongoing','completed','cancelled') NOT NULL DEFAULT 'scheduled',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `program_sessions`
--

INSERT INTO `program_sessions` (`id`, `program_id`, `topic`, `description`, `facilitator`, `location`, `session_date`, `duration_minutes`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Week 1: Weight Loss Session', 'Weekly check-in and workout session', 'Sarah Johnson', 'Fitness Center', '2025-12-22 18:00:00', 60, 'scheduled', '2025-12-15 08:31:53', '2025-12-15 08:31:53'),
(2, 1, 'Week 2: Weight Loss Session', 'Weekly check-in and workout session', 'Sarah Johnson', 'Fitness Center', '2025-12-29 18:00:00', 60, 'scheduled', '2025-12-15 08:31:53', '2025-12-15 08:31:53'),
(3, 1, 'Week 3: Weight Loss Session', 'Weekly check-in and workout session', 'Sarah Johnson', 'Fitness Center', '2026-01-05 18:00:00', 60, 'scheduled', '2025-12-15 08:31:53', '2025-12-15 08:31:53'),
(4, 1, 'Week 4: Weight Loss Session', 'Weekly check-in and workout session', 'Sarah Johnson', 'Fitness Center', '2026-01-12 18:00:00', 60, 'scheduled', '2025-12-15 08:31:53', '2025-12-15 08:31:53'),
(5, 1, 'Week 5: Weight Loss Session', 'Weekly check-in and workout session', 'Sarah Johnson', 'Fitness Center', '2026-01-19 18:00:00', 60, 'scheduled', '2025-12-15 08:31:53', '2025-12-15 08:31:53'),
(6, 1, 'Week 6: Weight Loss Session', 'Weekly check-in and workout session', 'Sarah Johnson', 'Fitness Center', '2026-01-26 18:00:00', 60, 'scheduled', '2025-12-15 08:31:53', '2025-12-15 08:31:53'),
(7, 1, 'Week 7: Weight Loss Session', 'Weekly check-in and workout session', 'Sarah Johnson', 'Fitness Center', '2026-02-02 18:00:00', 60, 'scheduled', '2025-12-15 08:31:53', '2025-12-15 08:31:53'),
(8, 1, 'Week 8: Weight Loss Session', 'Weekly check-in and workout session', 'Sarah Johnson', 'Fitness Center', '2026-02-09 18:00:00', 60, 'scheduled', '2025-12-15 08:31:53', '2025-12-15 08:31:53'),
(9, 1, 'Week 9: Weight Loss Session', 'Weekly check-in and workout session', 'Sarah Johnson', 'Fitness Center', '2026-02-16 18:00:00', 60, 'scheduled', '2025-12-15 08:31:53', '2025-12-15 08:31:53'),
(10, 1, 'Week 10: Weight Loss Session', 'Weekly check-in and workout session', 'Sarah Johnson', 'Fitness Center', '2026-02-23 18:00:00', 60, 'scheduled', '2025-12-15 08:31:53', '2025-12-15 08:31:53'),
(11, 1, 'Week 11: Weight Loss Session', 'Weekly check-in and workout session', 'Sarah Johnson', 'Fitness Center', '2026-03-02 18:00:00', 60, 'scheduled', '2025-12-15 08:31:53', '2025-12-15 08:31:53'),
(12, 1, 'Week 12: Weight Loss Session', 'Weekly check-in and workout session', 'Sarah Johnson', 'Fitness Center', '2026-03-09 18:00:00', 60, 'scheduled', '2025-12-15 08:31:53', '2025-12-15 08:31:53'),
(13, 2, 'Session 1: Stress Management', 'Learn and practice stress reduction', 'Michael Chen', 'Wellness Room', '2025-12-29 17:00:00', 90, 'scheduled', '2025-12-15 08:31:53', '2025-12-15 08:31:53'),
(14, 2, 'Session 2: Stress Management', 'Learn and practice stress reduction', 'Michael Chen', 'Wellness Room', '2026-01-05 17:00:00', 90, 'scheduled', '2025-12-15 08:31:53', '2025-12-15 08:31:53'),
(15, 2, 'Session 3: Stress Management', 'Learn and practice stress reduction', 'Michael Chen', 'Wellness Room', '2026-01-12 17:00:00', 90, 'scheduled', '2025-12-15 08:31:53', '2025-12-15 08:31:53'),
(16, 2, 'Session 4: Stress Management', 'Learn and practice stress reduction', 'Michael Chen', 'Wellness Room', '2026-01-19 17:00:00', 90, 'scheduled', '2025-12-15 08:31:53', '2025-12-15 08:31:53'),
(17, 2, 'Session 5: Stress Management', 'Learn and practice stress reduction', 'Michael Chen', 'Wellness Room', '2026-01-26 17:00:00', 90, 'scheduled', '2025-12-15 08:31:53', '2025-12-15 08:31:53'),
(18, 2, 'Session 6: Stress Management', 'Learn and practice stress reduction', 'Michael Chen', 'Wellness Room', '2026-02-02 17:00:00', 90, 'scheduled', '2025-12-15 08:31:53', '2025-12-15 08:31:53'),
(19, 2, 'Session 7: Stress Management', 'Learn and practice stress reduction', 'Michael Chen', 'Wellness Room', '2026-02-09 17:00:00', 90, 'scheduled', '2025-12-15 08:31:53', '2025-12-15 08:31:53'),
(20, 2, 'Session 8: Stress Management', 'Learn and practice stress reduction', 'Michael Chen', 'Wellness Room', '2026-02-16 17:00:00', 90, 'scheduled', '2025-12-15 08:31:53', '2025-12-15 08:31:53'),
(21, 1, 'Week 1: Weight Loss Session', 'Weekly check-in and workout session', 'Sarah Johnson', 'Fitness Center', '2025-12-22 18:00:00', 60, 'scheduled', '2025-12-15 10:10:17', '2025-12-15 10:10:17'),
(22, 1, 'Week 2: Weight Loss Session', 'Weekly check-in and workout session', 'Sarah Johnson', 'Fitness Center', '2025-12-29 18:00:00', 60, 'scheduled', '2025-12-15 10:10:17', '2025-12-15 10:10:17'),
(23, 1, 'Week 3: Weight Loss Session', 'Weekly check-in and workout session', 'Sarah Johnson', 'Fitness Center', '2026-01-05 18:00:00', 60, 'scheduled', '2025-12-15 10:10:17', '2025-12-15 10:10:17'),
(24, 1, 'Week 4: Weight Loss Session', 'Weekly check-in and workout session', 'Sarah Johnson', 'Fitness Center', '2026-01-12 18:00:00', 60, 'scheduled', '2025-12-15 10:10:17', '2025-12-15 10:10:17'),
(25, 1, 'Week 5: Weight Loss Session', 'Weekly check-in and workout session', 'Sarah Johnson', 'Fitness Center', '2026-01-19 18:00:00', 60, 'scheduled', '2025-12-15 10:10:17', '2025-12-15 10:10:17'),
(26, 1, 'Week 6: Weight Loss Session', 'Weekly check-in and workout session', 'Sarah Johnson', 'Fitness Center', '2026-01-26 18:00:00', 60, 'scheduled', '2025-12-15 10:10:17', '2025-12-15 10:10:17'),
(27, 1, 'Week 7: Weight Loss Session', 'Weekly check-in and workout session', 'Sarah Johnson', 'Fitness Center', '2026-02-02 18:00:00', 60, 'scheduled', '2025-12-15 10:10:17', '2025-12-15 10:10:17'),
(28, 1, 'Week 8: Weight Loss Session', 'Weekly check-in and workout session', 'Sarah Johnson', 'Fitness Center', '2026-02-09 18:00:00', 60, 'scheduled', '2025-12-15 10:10:17', '2025-12-15 10:10:17'),
(29, 1, 'Week 9: Weight Loss Session', 'Weekly check-in and workout session', 'Sarah Johnson', 'Fitness Center', '2026-02-16 18:00:00', 60, 'scheduled', '2025-12-15 10:10:17', '2025-12-15 10:10:17'),
(30, 1, 'Week 10: Weight Loss Session', 'Weekly check-in and workout session', 'Sarah Johnson', 'Fitness Center', '2026-02-23 18:00:00', 60, 'scheduled', '2025-12-15 10:10:17', '2025-12-15 10:10:17'),
(31, 1, 'Week 11: Weight Loss Session', 'Weekly check-in and workout session', 'Sarah Johnson', 'Fitness Center', '2026-03-02 18:00:00', 60, 'scheduled', '2025-12-15 10:10:17', '2025-12-15 10:10:17'),
(32, 1, 'Week 12: Weight Loss Session', 'Weekly check-in and workout session', 'Sarah Johnson', 'Fitness Center', '2026-03-09 18:00:00', 60, 'scheduled', '2025-12-15 10:10:17', '2025-12-15 10:10:17'),
(33, 2, 'Session 1: Stress Management', 'Learn and practice stress reduction', 'Michael Chen', 'Wellness Room', '2025-12-29 17:00:00', 90, 'scheduled', '2025-12-15 10:10:17', '2025-12-15 10:10:17'),
(34, 2, 'Session 2: Stress Management', 'Learn and practice stress reduction', 'Michael Chen', 'Wellness Room', '2026-01-05 17:00:00', 90, 'scheduled', '2025-12-15 10:10:17', '2025-12-15 10:10:17'),
(35, 2, 'Session 3: Stress Management', 'Learn and practice stress reduction', 'Michael Chen', 'Wellness Room', '2026-01-12 17:00:00', 90, 'scheduled', '2025-12-15 10:10:17', '2025-12-15 10:10:17'),
(36, 2, 'Session 4: Stress Management', 'Learn and practice stress reduction', 'Michael Chen', 'Wellness Room', '2026-01-19 17:00:00', 90, 'scheduled', '2025-12-15 10:10:17', '2025-12-15 10:10:17'),
(37, 2, 'Session 5: Stress Management', 'Learn and practice stress reduction', 'Michael Chen', 'Wellness Room', '2026-01-26 17:00:00', 90, 'scheduled', '2025-12-15 10:10:17', '2025-12-15 10:10:17'),
(38, 2, 'Session 6: Stress Management', 'Learn and practice stress reduction', 'Michael Chen', 'Wellness Room', '2026-02-02 17:00:00', 90, 'scheduled', '2025-12-15 10:10:17', '2025-12-15 10:10:17'),
(39, 2, 'Session 7: Stress Management', 'Learn and practice stress reduction', 'Michael Chen', 'Wellness Room', '2026-02-09 17:00:00', 90, 'scheduled', '2025-12-15 10:10:17', '2025-12-15 10:10:17'),
(40, 2, 'Session 8: Stress Management', 'Learn and practice stress reduction', 'Michael Chen', 'Wellness Room', '2026-02-16 17:00:00', 90, 'scheduled', '2025-12-15 10:10:17', '2025-12-15 10:10:17'),
(41, 5, 'sfs', 'fvsevs', 'sevseg', 'esgsg', '2025-12-16 02:42:00', 60, 'scheduled', '2025-12-15 10:42:42', '2025-12-15 10:42:42'),
(42, 10, 'sfs', 'csdvfbgnh', 'sevseg', 'Nabua', '2025-12-16 03:10:00', 60, 'scheduled', '2025-12-15 11:10:12', '2025-12-15 11:10:12'),
(43, 11, 'kilangan sapokin si jonas', 'asdsfbghnhjhgf', 'ikaw', 'nabua', '2025-12-17 19:04:00', 60, 'scheduled', '2025-12-16 03:04:57', '2025-12-16 03:04:57');

-- --------------------------------------------------------

--
-- Table structure for table `progress_metrics`
--

CREATE TABLE `progress_metrics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `registration_id` bigint(20) UNSIGNED NOT NULL,
  `metric_type` varchar(255) NOT NULL,
  `metric_value` varchar(255) NOT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `recorded_date` date NOT NULL,
  `notes` text DEFAULT NULL,
  `recorded_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `progress_metrics`
--

INSERT INTO `progress_metrics` (`id`, `registration_id`, `metric_type`, `metric_value`, `unit`, `recorded_date`, `notes`, `recorded_by`, `created_at`, `updated_at`) VALUES
(1, 1, '120/80', '150', '72', '2025-12-15', 'dvffbd', 2, '2025-12-15 11:05:58', '2025-12-15 11:05:58'),
(2, 1, 'bp', '120/80', 'bp', '2025-12-15', 'fgdrfg', 2, '2025-12-15 11:07:17', '2025-12-15 11:07:17'),
(3, 5, 'bp', '120/80', 'bp', '2025-12-16', 'adsfdgrfhtjgyuhlji', 2, '2025-12-16 03:07:39', '2025-12-16 03:07:39');

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `program_id` bigint(20) UNSIGNED NOT NULL,
  `health_goals` text DEFAULT NULL,
  `personal_notes` text DEFAULT NULL,
  `status` enum('registered','active','completed','withdrawn') NOT NULL DEFAULT 'registered',
  `withdrawal_reason` text DEFAULT NULL,
  `registered_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`id`, `user_id`, `program_id`, `health_goals`, `personal_notes`, `status`, `withdrawal_reason`, `registered_at`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 'sfdgfhtgjykuh', 'asfzdgfhgjhj', 'registered', 'pinalo', '2025-12-16 03:12:57', '2025-09-06 10:10:17', '2025-12-16 03:12:57'),
(2, 5, 1, 'Want to lose weight and feel healthier', NULL, 'registered', NULL, '2025-12-15 08:31:53', '2025-12-15 08:31:53', '2025-12-15 08:31:53'),
(3, 6, 1, 'Want to lose weight and feel healthier', NULL, 'registered', NULL, '2025-12-15 08:31:53', '2025-12-15 08:31:53', '2025-12-15 08:31:53'),
(4, 7, 1, 'Want to lose weight and feel healthier', NULL, 'registered', NULL, '2025-12-15 08:31:53', '2025-12-15 08:31:53', '2025-12-15 08:31:53'),
(5, 8, 1, 'Want to lose weight and feel healthier', NULL, 'registered', NULL, '2025-12-15 18:10:17', '2025-08-28 10:10:17', '2025-12-15 10:10:17'),
(6, 5, 8, 'Want to improve my wellness and health', NULL, 'registered', NULL, '2025-12-15 18:10:17', '2025-12-12 10:10:17', '2025-12-15 10:10:17'),
(7, 6, 4, 'Want to improve my wellness and health', NULL, 'registered', NULL, '2025-12-15 18:10:17', '2025-09-08 10:10:17', '2025-12-15 10:10:17'),
(8, 7, 8, 'Want to improve my wellness and health', NULL, 'registered', NULL, '2025-12-15 18:10:17', '2025-10-14 10:10:17', '2025-12-15 10:10:17'),
(9, 9, 4, 'Want to improve my wellness and health', NULL, 'registered', NULL, '2025-12-15 18:10:17', '2025-11-27 10:10:17', '2025-12-15 10:10:17'),
(10, 10, 4, 'Want to improve my wellness and health', NULL, 'registered', NULL, '2025-12-15 18:10:17', '2025-10-13 10:10:17', '2025-12-15 10:10:17'),
(11, 11, 6, 'Want to improve my wellness and health', NULL, 'registered', NULL, '2025-12-15 18:10:17', '2025-09-25 10:10:17', '2025-12-15 10:10:17'),
(12, 12, 3, 'Want to improve my wellness and health', NULL, 'registered', NULL, '2025-12-15 18:10:17', '2025-09-25 10:10:17', '2025-12-15 10:10:17'),
(13, 13, 2, 'Want to improve my wellness and health', NULL, 'registered', NULL, '2025-12-15 18:10:17', '2025-07-11 10:10:17', '2025-12-15 10:10:17'),
(14, 16, 8, 'Want to improve my wellness and health', NULL, 'registered', NULL, '2025-12-15 18:10:17', '2025-07-09 10:10:17', '2025-12-15 10:10:17'),
(15, 17, 9, 'Want to improve my wellness and health', NULL, 'registered', NULL, '2025-12-15 18:10:17', '2025-09-17 10:10:17', '2025-12-15 10:10:17'),
(16, 18, 4, 'Want to improve my wellness and health', NULL, 'registered', NULL, '2025-12-15 18:10:17', '2025-07-04 10:10:17', '2025-12-15 10:10:17'),
(17, 19, 1, 'Want to improve my wellness and health', NULL, 'registered', NULL, '2025-12-15 18:10:17', '2025-08-17 10:10:17', '2025-12-15 10:10:17'),
(18, 20, 8, 'Want to improve my wellness and health', NULL, 'registered', NULL, '2025-12-15 18:10:17', '2025-12-04 10:10:17', '2025-12-15 10:10:17'),
(19, 21, 7, 'Want to improve my wellness and health', NULL, 'registered', NULL, '2025-12-15 18:10:17', '2025-07-19 10:10:17', '2025-12-15 10:10:17'),
(20, 22, 4, 'Want to improve my wellness and health', NULL, 'registered', NULL, '2025-12-15 18:10:17', '2025-11-08 10:10:17', '2025-12-15 10:10:17'),
(21, 23, 6, 'Want to improve my wellness and health', NULL, 'registered', NULL, '2025-12-15 18:10:17', '2025-08-05 10:10:17', '2025-12-15 10:10:17'),
(22, 24, 8, 'Want to improve my wellness and health', NULL, 'registered', NULL, '2025-12-15 18:10:17', '2025-12-08 10:10:17', '2025-12-15 10:10:17'),
(23, 25, 9, 'Want to improve my wellness and health', NULL, 'registered', NULL, '2025-12-15 18:10:17', '2025-09-02 10:10:17', '2025-12-15 10:10:17'),
(24, 4, 2, 'dsfd', 'sfsgv', 'registered', NULL, '2025-12-15 11:58:05', '2025-12-15 11:58:05', '2025-12-15 11:58:05'),
(25, 4, 8, 'cxvcbvnbm', 'czvnbmn,m', 'registered', NULL, '2025-12-16 03:15:56', '2025-12-16 03:15:56', '2025-12-16 03:15:56');

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
('GVRw7DIHH7ykd0svLI2Elw0sFhRfWdNNcdyGzcUv', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiM1NLM2dRMTRXcGFJdmtSWlFBeVk2R1Zwc1BhQW91a3FUU3VXaU05QyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1765884052),
('i5RgYVqa5s539h6OktNm8yuCkwkWAF3iVrdsRz13', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRFlOYktCb1FsM0liWjIxOVM1Q2I2bU9NY2xYaE5xbkt6SG03U0wxTiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1765882267),
('iK1iGd55fTdIyy90TyPqw7rWitCaNWUgflY3nfU5', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRWs5ZE1RekNzOVVBWHFBa3RiTUliZ21MQ0owTElTeG5NdnQ5V0N5eSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9fQ==', 1765884086);

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `key`, `value`, `description`, `created_at`, `updated_at`) VALUES
(1, 'max_active_programs', '3', 'Maximum number of active programs per participant', '2025-12-15 10:10:17', '2025-12-15 10:10:17'),
(2, 'wellness_categories', 'Fitness,Mental Health,Wellness,Nutrition,Yoga', 'Available wellness program categories', '2025-12-15 10:10:17', '2025-12-15 10:10:17'),
(3, 'metric_templates', 'Weight,Blood Pressure,Heart Rate,BMI,Body Fat %', 'Available health metric templates', '2025-12-15 10:10:17', '2025-12-15 10:10:17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('participant','coordinator','admin') NOT NULL DEFAULT 'participant',
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `health_conditions` text DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `phone`, `address`, `date_of_birth`, `gender`, `health_conditions`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@wellness.com', 'admin', '555-0100', NULL, NULL, 'male', NULL, NULL, '$2y$12$ce0jEfqyeAmB0620dyfUMe4lsz3GGKVSZEYNNP94daQpM1e2mXT6O', 'YhlFye3uYZsqKj60ykYNXdxFxgsxllUyLdaFTy9B9mriNuHBvcBY3217AZpc', '2025-12-15 08:31:50', '2025-12-16 02:59:55'),
(2, 'Sarah Johnson', 'coordinator1@wellness.com', 'coordinator', '555-0101', NULL, NULL, NULL, NULL, NULL, '$2y$12$n.SZJqlI7Z4VC9zN02tcQ.QTk1kRP/CtG35NSua4PuTV1SgexptWG', '0e9xla4OcQPREH2tTmUzGxyKpqxOroM93bos3THf6tecsJww5ZKLoWOGh6eD', '2025-12-15 08:31:50', '2025-12-15 08:31:50'),
(3, 'Michael Chen', 'coordinator2@wellness.com', 'coordinator', '555-0102', NULL, NULL, NULL, NULL, NULL, '$2y$12$/qQUianoM1o2cGx5UW0IqOGvle413dgilTG0F8eHeYe8ZHGzon9pC', NULL, '2025-12-15 08:31:50', '2025-12-15 08:31:50'),
(4, 'Participant 1', 'participant1@wellness.com', 'participant', '555-0001', NULL, '2002-12-15', 'other', NULL, NULL, '$2y$12$uQlYhswwrNPYC8gedUjwq.SP09R.m.c6L/TxDZsjt.TGJBD6V2plK', 'fbvcfaz9zpu0gALfKxr7WtpKiPTmnq927554MOFa3K0rvWWj8YArOYMPpUPY', '2025-12-03 10:10:09', '2025-12-15 12:07:57'),
(5, 'Participant 2', 'participant2@wellness.com', 'participant', '555-0002', NULL, '1994-12-15', 'female', NULL, NULL, '$2y$12$9KG3yFBWNzR6bJtJDo.bN.0nAaB5U6Aj6nP9ziTvw3YfYGPrs2I/u', NULL, '2025-07-20 10:10:09', '2025-12-15 10:10:09'),
(6, 'Participant 3', 'participant3@wellness.com', 'participant', '555-0003', NULL, '1986-12-15', 'other', NULL, NULL, '$2y$12$7SJdDYcok3mI2vzD5WMYcesTeQyFLwyPPKsnxK96i//K6om0jUhSS', NULL, '2025-07-09 10:10:09', '2025-12-15 10:10:10'),
(7, 'Participant 4', 'participant4@wellness.com', 'participant', '555-0004', NULL, '1988-12-15', 'other', NULL, NULL, '$2y$12$BY9ZoUczIKLgl1aIOO.07.e0ulKGh4N1LJmSWzVSb8QA.EVfwaNVC', NULL, '2025-12-01 10:10:10', '2025-12-15 10:10:10'),
(8, 'Participant 5', 'participant5@wellness.com', 'participant', '555-0005', NULL, '1994-12-15', 'female', NULL, NULL, '$2y$12$nvPaBOP.jDDOoj2i8/EVpeNppCEbDOUx.FBrGnNURaZlFLYVbdjlm', NULL, '2025-12-07 10:10:10', '2025-12-15 10:10:10'),
(9, 'Participant 6', 'participant6@wellness.com', 'participant', '555-0006', NULL, '1985-12-15', 'male', NULL, NULL, '$2y$12$j7Wo2cU6a9DNIqOP95x5Ju7JArHsvxWlD06/2.88OXrBMmv9Pt2wC', NULL, '2025-11-29 10:10:10', '2025-12-15 10:10:10'),
(10, 'Participant 7', 'participant7@wellness.com', 'participant', '555-0007', NULL, '1985-12-15', 'other', NULL, NULL, '$2y$12$vtWXtcaw/Uox6b.Y9Mo1ue.UjRjp/crc.yBaTdMbVDtEAmBpIb2Vu', NULL, '2025-11-14 10:10:10', '2025-12-15 10:10:11'),
(11, 'Participant 8', 'participant8@wellness.com', 'participant', '555-0008', NULL, '1988-12-15', 'male', NULL, NULL, '$2y$12$m4kAs3vF0iThbUCmL/ynTOQx0/Pj5z.vH9KQuKAN71wk.xfW9rYWe', NULL, '2025-11-30 10:10:11', '2025-12-15 10:10:11'),
(12, 'Participant 9', 'participant9@wellness.com', 'participant', '555-0009', NULL, '1981-12-15', 'other', NULL, NULL, '$2y$12$lNAva4eptWRXAR/a7sX2.eE13Xam7C2xDweeTsdcD8ErMtTz1QhOq', NULL, '2025-07-07 10:10:11', '2025-12-15 10:10:11'),
(13, 'Participant 10', 'participant10@wellness.com', 'participant', '555-0010', NULL, '1976-12-15', 'male', NULL, NULL, '$2y$12$2NfZA2AU2Nh0XeKu7cljN.MTTI9EbGPn.panDsOeSwVL7WRvcEfim', NULL, '2025-07-31 10:10:11', '2025-12-15 10:10:12'),
(16, 'Participant 11', 'participant11@wellness.com', 'participant', '555-0011', NULL, '1989-12-15', 'other', NULL, NULL, '$2y$12$VKwWLBmK/hW9h0yNoYtAvOJfWFy1YrDKffQt.jR29OtQSm9BhIBwe', NULL, '2025-12-02 10:10:12', '2025-12-15 10:10:12'),
(17, 'Participant 12', 'participant12@wellness.com', 'participant', '555-0012', NULL, '1998-12-15', 'male', NULL, NULL, '$2y$12$4kevQzVCZ27yIagr2hiZ9e9Y.WoHWJalN/wTatnAXFXlfP/WCIq8i', NULL, '2025-08-08 10:10:12', '2025-12-15 10:10:12'),
(18, 'Participant 13', 'participant13@wellness.com', 'participant', '555-0013', NULL, '1991-12-15', 'female', NULL, NULL, '$2y$12$oV3xl15eFGJ/smYSTKlsWuVI8wpvP9UdJlGSrSn0vAv8jTGrSn1Hy', NULL, '2025-10-21 10:10:12', '2025-12-15 10:10:12'),
(19, 'Participant 14', 'participant14@wellness.com', 'participant', '555-0014', NULL, '2003-12-15', 'female', NULL, NULL, '$2y$12$HrzC4aRApYQ1yPFlrH.j5eeW87bIi4ui506NNSnbsnhWP0Zvb4qy6', NULL, '2025-10-08 10:10:12', '2025-12-15 10:10:13'),
(20, 'Participant 15', 'participant15@wellness.com', 'participant', '555-0015', NULL, '1991-12-15', 'male', NULL, NULL, '$2y$12$1BmAQFl/s2rpq2rPT/9ile4slvKc0gj9lO1tMys.g1cz9xGanFEsm', NULL, '2025-07-20 10:10:13', '2025-12-15 10:10:13'),
(21, 'Participant 16', 'participant16@wellness.com', 'participant', '555-0016', NULL, '2001-12-15', 'female', NULL, NULL, '$2y$12$NYhXRhmT6kMS5hP7cQuHE.4wIWipITKTGGG353wtQeo9jKYjMdZJ6', NULL, '2025-09-04 10:10:13', '2025-12-15 10:10:13'),
(22, 'Participant 17', 'participant17@wellness.com', 'participant', '555-0017', NULL, '1998-12-15', 'female', NULL, NULL, '$2y$12$ZOYz6ehEuEfci2ce62YCi.H.8Xiz1lS2co9ZipSLh3xdAwfbAzuuC', NULL, '2025-11-19 10:10:13', '2025-12-15 10:10:14'),
(23, 'Participant 18', 'participant18@wellness.com', 'participant', '555-0018', NULL, '1979-12-15', 'female', NULL, NULL, '$2y$12$/zCKP8SC53x6XHBiZ74P3O/obwW5rfYcMI6kaqtW8URa/sXnh.irG', NULL, '2025-07-19 10:10:14', '2025-12-15 10:10:14'),
(24, 'Participant 19', 'participant19@wellness.com', 'participant', '555-0019', NULL, '1994-12-15', 'other', NULL, NULL, '$2y$12$0RA/1Z2voo9VAi1K0.BHDOMTrTvyS8K1Ewc.WEPEhDx8EM3hrbH0q', NULL, '2025-09-06 10:10:14', '2025-12-15 10:10:14'),
(25, 'Participant 20', 'participant20@wellness.com', 'participant', '555-0020', NULL, '1978-12-15', 'other', NULL, NULL, '$2y$12$o2da.cJXChtUzA/8ckp1i.IS6hhHXvTzO8e1LRDqmyDwK5nuhI1yy', NULL, '2025-07-16 10:10:14', '2025-12-15 10:10:14'),
(26, 'Participant 21', 'participant21@wellness.com', 'participant', '555-0021', NULL, '1997-12-15', 'male', NULL, NULL, '$2y$12$8fKVHZjLbIQfkJ4odj/qGu2case4gPAYThAQmj/vrgpQB0kbSvHrK', NULL, '2025-07-30 10:10:14', '2025-12-15 10:10:15'),
(27, 'Participant 22', 'participant22@wellness.com', 'participant', '555-0022', NULL, '1984-12-15', 'female', NULL, NULL, '$2y$12$858bJsJHhUZHP.F5xO965uIY27/yj5RUFQEbXH6JtWkHAXBv2ikAS', NULL, '2025-07-04 10:10:15', '2025-12-15 10:10:15'),
(28, 'Participant 23', 'participant23@wellness.com', 'participant', '555-0023', NULL, '1977-12-15', 'other', NULL, NULL, '$2y$12$xbhv0kc6bLm30.MAIVf4S.F61ck/Ukotn30kYdXjL4Bdsqr1/hl/S', NULL, '2025-12-05 10:10:15', '2025-12-15 10:10:15'),
(29, 'Participant 24', 'participant24@wellness.com', 'participant', '555-0024', NULL, '1997-12-15', 'male', NULL, NULL, '$2y$12$3W3IsUrb.A3CyGdUTieviOWgi7lWz7ZiZ8UC8.E1VGsouuqrqw2d2', NULL, '2025-08-24 10:10:15', '2025-12-15 10:10:15'),
(30, 'Participant 25', 'participant25@wellness.com', 'participant', '555-0025', NULL, '2000-12-15', 'male', NULL, NULL, '$2y$12$DuyPqncjgrOJxkkfrVF0HuUBLNOoSVq5govxAkS0jK4vHTo4wALCu', NULL, '2025-09-05 10:10:15', '2025-12-15 10:10:16'),
(31, 'Participant 26', 'participant26@wellness.com', 'participant', '555-0026', NULL, '1976-12-15', 'other', NULL, NULL, '$2y$12$Chzzh1WwhO9wZqM53pSnpeHYj8aAZV75CZxl1Ojmh86ifHpmePwYW', NULL, '2025-11-22 10:10:16', '2025-12-15 10:10:16'),
(32, 'Participant 27', 'participant27@wellness.com', 'participant', '555-0027', NULL, '1985-12-15', 'other', NULL, NULL, '$2y$12$TXXfdXhnISaqsNuHcy64w.jQLqsWV6DO4o3ujWSXkRwl6LC3lf.sW', NULL, '2025-08-04 10:10:16', '2025-12-15 10:10:16'),
(33, 'Participant 28', 'participant28@wellness.com', 'participant', '555-0028', NULL, '1979-12-15', 'male', NULL, NULL, '$2y$12$1gN3krTHF68YVmIREZQT0OksoHHgRB./aTYlyoXFTra2knFCK2pzW', NULL, '2025-10-27 10:10:16', '2025-12-15 10:10:16'),
(34, 'Participant 29', 'participant29@wellness.com', 'participant', '555-0029', NULL, '1977-12-15', 'other', NULL, NULL, '$2y$12$lU00zYCM.caFed16Vx3hIOE8mNWfwj.2v4j1kWLAeCcNyISoa01wW', NULL, '2025-06-24 10:10:16', '2025-12-15 10:10:17'),
(35, 'Participant 30', 'participant30@wellness.com', 'participant', '555-0030', NULL, '1987-12-15', 'other', NULL, NULL, '$2y$12$vqidw9aSMZrPgyczUN579urNwawUhs4MZiZOwSNUqE7kes10dpFda', NULL, '2025-06-22 10:10:17', '2025-12-15 10:10:17'),
(36, 'JOHN LLOYD BLANQUERA', 'loyd@wellness.com', 'participant', '09563222825', 'Zone 4', '2025-12-16', NULL, 'xszvzdv', NULL, '$2y$12$iYEzp4m0c99o4VH6oYvpzesRDsfAB8ftfeLlED/g2/.wLkYzUz.kC', 'Ta7ScHzS0UkdzepFPtyaEXybGNDzds7qsOIN4N0c11iijNbxoahnXuICYvdr', '2025-12-15 12:14:44', '2025-12-15 12:14:44'),
(37, 'john', 'johnlloydblanquera22306@gmail.com', 'participant', '09706065972', 'Zone 4', NULL, NULL, NULL, NULL, '$2y$12$yu4r1Jy27AHvi9NuFjUjUezAK11BB14Z56TEAUTMPW7EmSaKYgpsm', NULL, '2025-12-16 02:53:06', '2025-12-16 02:53:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `attendance_session_id_user_id_unique` (`session_id`,`user_id`),
  ADD KEY `attendance_user_id_foreign` (`user_id`),
  ADD KEY `attendance_recorded_by_foreign` (`recorded_by`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audit_logs_user_id_foreign` (`user_id`);

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
-- Indexes for table `generated_reports`
--
ALTER TABLE `generated_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `generated_reports_user_id_foreign` (`user_id`);

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
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `programs_coordinator_id_foreign` (`coordinator_id`);

--
-- Indexes for table `program_sessions`
--
ALTER TABLE `program_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `program_sessions_program_id_foreign` (`program_id`);

--
-- Indexes for table `progress_metrics`
--
ALTER TABLE `progress_metrics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `progress_metrics_registration_id_foreign` (`registration_id`),
  ADD KEY `progress_metrics_recorded_by_foreign` (`recorded_by`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `registrations_user_id_program_id_unique` (`user_id`,`program_id`),
  ADD KEY `registrations_program_id_foreign` (`program_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `system_settings_key_unique` (`key`);

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
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `generated_reports`
--
ALTER TABLE `generated_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `program_sessions`
--
ALTER TABLE `program_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `progress_metrics`
--
ALTER TABLE `progress_metrics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_recorded_by_foreign` FOREIGN KEY (`recorded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `attendance_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `program_sessions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendance_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `generated_reports`
--
ALTER TABLE `generated_reports`
  ADD CONSTRAINT `generated_reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `programs`
--
ALTER TABLE `programs`
  ADD CONSTRAINT `programs_coordinator_id_foreign` FOREIGN KEY (`coordinator_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `program_sessions`
--
ALTER TABLE `program_sessions`
  ADD CONSTRAINT `program_sessions_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `progress_metrics`
--
ALTER TABLE `progress_metrics`
  ADD CONSTRAINT `progress_metrics_recorded_by_foreign` FOREIGN KEY (`recorded_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `progress_metrics_registration_id_foreign` FOREIGN KEY (`registration_id`) REFERENCES `registrations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `registrations`
--
ALTER TABLE `registrations`
  ADD CONSTRAINT `registrations_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `registrations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
