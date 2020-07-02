-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2020 at 09:57 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `latihan_yii2_api`
--

-- --------------------------------------------------------

--
-- Table structure for table `master_kejaksaan`
--

CREATE TABLE `master_kejaksaan` (
  `id` int(11) NOT NULL,
  `area_id` int(11) DEFAULT NULL,
  `code` char(5) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` enum('0','1') DEFAULT NULL COMMENT '0 inactive, 1 active',
  `created_date` datetime DEFAULT NULL,
  `updated_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_kejaksaan`
--

INSERT INTO `master_kejaksaan` (`id`, `area_id`, `code`, `name`, `address`, `status`, `created_date`, `updated_date`) VALUES
(1, 1, NULL, 'Kejaksaan Negeri Jakarta Barat', NULL, '1', '2020-06-13 13:52:23', '2020-06-13 06:52:32'),
(2, 2, NULL, 'Kejaksaan Negeri Jakarta Pusat', NULL, '1', '2020-06-13 13:52:23', '2020-06-13 06:52:33'),
(3, 3, NULL, 'Kejaksaan Negeri Jakarta Selatan', NULL, '1', '2020-06-13 13:52:23', '2020-06-13 06:52:34'),
(4, 4, NULL, 'Kejaksaan Negeri Jakarta Timur', NULL, '1', '2020-06-13 13:52:23', '2020-06-13 06:52:34'),
(5, 5, NULL, 'Kejaksaan Negeri Jakarta Utara', NULL, '1', '2020-06-13 13:52:23', '2020-06-13 06:52:35');

-- --------------------------------------------------------

--
-- Table structure for table `ref_error_codes`
--

CREATE TABLE `ref_error_codes` (
  `code` char(3) NOT NULL COMMENT 'Error codes',
  `message` varchar(255) DEFAULT NULL COMMENT 'Message of error',
  `messageID` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL COMMENT 'Description'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ref_error_codes`
--

INSERT INTO `ref_error_codes` (`code`, `message`, `messageID`, `description`) VALUES
('000', 'Success', 'Sukses', NULL),
('111', 'Login failed, invalid Username or Password', 'Username atau password salah', 'invalid login credential'),
('112', 'Invalid API key', 'API key salah', NULL),
('404', 'data not found', 'Data Tidak Ditemukan', NULL),
('500', 'Internal error', 'Terjadi kesalahan', NULL),
('600', 'Request failed', 'Request gagal', NULL),
('901', 'Invalid param', 'Parameter salah', NULL),
('999', 'Test', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `kejaksaan_id` int(11) DEFAULT 0,
  `username` varchar(256) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `auth_key` varchar(100) DEFAULT NULL,
  `role` enum('superadmin','highlevel','staff') DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0 COMMENT '0 = inactive, 1 = active',
  `verification_token` varchar(256) DEFAULT NULL,
  `password_reset_token` varchar(256) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_by_name` varchar(255) DEFAULT NULL,
  `updated_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `updated_by_name` varchar(255) DEFAULT NULL,
  `login_failed` tinyint(1) DEFAULT 0,
  `last_login_attempt` datetime DEFAULT NULL,
  `penalty_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `kejaksaan_id`, `username`, `email`, `password`, `auth_key`, `role`, `status`, `verification_token`, `password_reset_token`, `created_date`, `created_by`, `created_by_name`, `updated_date`, `updated_by`, `updated_by_name`, `login_failed`, `last_login_attempt`, `penalty_time`) VALUES
(1, 1, 'admin', 'lory@mail.com', '$2y$13$sZoJYITGQC33zdxWEMgyIOzDjNR4MJl3ZMcbNVhmURigx.N2.dDC.', NULL, 'superadmin', 1, NULL, NULL, '2020-06-05 12:35:19', NULL, NULL, '2020-07-01 11:58:24', NULL, NULL, 0, NULL, NULL),
(2, 1, 'hafidh', 'ahmadhafyd@gmail.com', '$2y$13$sZoJYITGQC33zdxWEMgyIOzDjNR4MJl3ZMcbNVhmURigx.N2.dDC.', NULL, 'superadmin', 1, NULL, NULL, '2020-06-05 12:35:19', NULL, NULL, '2020-06-17 09:45:43', NULL, NULL, 0, NULL, NULL),
(5, 2, 'testing', 'testing@mailinator.com', '$2y$13$yJEPPPLIs585RqyexDLiaOso2K9NHOGkL9gM5ZuVhD50Bjml5Hsie', NULL, 'highlevel', 1, NULL, NULL, NULL, NULL, NULL, '2020-06-16 16:14:01', NULL, NULL, 0, NULL, NULL),
(7, 1, 'testingwoi', 'testingwoi@mailinator.com', '$2y$13$z9C4eh4cCKxuYtvXuX3.FeDByArHUabn3iVpMXRKRsm3Gy/5UMi2.', NULL, 'staff', 0, NULL, NULL, NULL, NULL, NULL, '2020-06-25 05:25:28', NULL, NULL, 0, NULL, NULL),
(8, 2, 'emboh', 'eternitydeveloperid@gmail.com', '$2y$13$v4O/dhoztVqYoPLGINO2JOO9evVBbp9qkeSPQ.9hNzTtAwoqnEc/u', NULL, 'staff', 1, NULL, NULL, NULL, NULL, NULL, '2020-06-25 05:26:14', NULL, NULL, 0, NULL, NULL),
(9, 1, 'mobileakun', 'mobileakun@gmail.com', '$2y$13$Tpdf6mjCiqcKjobBuLdn/eE7deyjNPRUiXJxMF.bBi2jCBCihw5GC', NULL, 'superadmin', 1, NULL, NULL, NULL, NULL, NULL, '2020-06-30 09:42:28', NULL, NULL, 0, NULL, NULL),
(13, 3, 'kadalwoi', 'kadalwoi@gmail.com', '$2y$13$pqFkN22Xw2mQe4vr3sxi9uhNctipZjbgrVUrjd7ERE60CMda09Owa', NULL, 'superadmin', 1, NULL, NULL, NULL, NULL, NULL, '2020-07-02 07:20:33', NULL, NULL, 0, NULL, NULL),
(19, 4, 'kadalwoii', 'kadalwoii@gmail.com', '$2y$13$9Wy5zekkeM9S3n/Qbz5MHe6e2s26IxCApm5cNFh1Xp0p1BBrCG70W', 'oOh6xi6NLPOGYq-Ugq1ifxbLBeDB1QhI', 'superadmin', 1, NULL, NULL, NULL, NULL, NULL, '2020-07-02 07:49:18', NULL, NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `web_session`
--

CREATE TABLE `web_session` (
  `id` char(40) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` blob DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `web_session`
--

INSERT INTO `web_session` (`id`, `user_id`, `expire`, `data`, `type`) VALUES
('2UHV6ONU265BP-nHMBCuIvkvcXXfEeir', 1, 1594191123, NULL, 'api'),
('9-1r2W5T2q1rrShTHzsARdNqQEYAX75K', 1, 1594183945, NULL, 'api'),
('9wkH_DuW6Q-dx4h_bUW-MPIDgUcZy4xF', 1, 1594184650, NULL, 'api'),
('a3aYaQviYjafPEl9TUdKikHD3jlbrkCR', 1, 1594184796, NULL, 'api'),
('AM_tUTN89LXW-FpxYug2Dpkezg5tXNJP', 1, 1594187655, NULL, 'api'),
('b3gjvv8edukkf8asbhga0kvoa8', 1, 1593593556, 0x5f5f666c6173687c613a303a7b7d5f5f72657475726e55726c7c733a32393a22687474703a2f2f6b656a616b7361616e2e696f2f64617368626f617264223b5f5f69647c693a313b, NULL),
('CSuVbRmPbcZ02N7WC8uLwrbgbERyB7gS', 1, 1594183390, NULL, 'api'),
('dqr7ubdpvj71ctkfocagmrj9vo', 1, 1593677959, 0x5f5f666c6173687c613a303a7b7d5f5f72657475726e55726c7c733a32393a22687474703a2f2f6b656a616b7361616e2e696f2f64617368626f617264223b5f5f69647c693a313b, NULL),
('Fk0APXaUXN6cO8f-dqwOnzlKWilEDWmk', 1, 1594169886, NULL, 'api'),
('FM6OmvxglNMQP5nMjGmNDHt4xpkNUHUQ', 1, 1594185168, NULL, 'api'),
('k6MeI3lgv-_sUZYZ7i4Lbf-uhFRycRck', 1, 1594183918, NULL, 'api'),
('LCVhBFMxr7XZk-jLPX5SDWMRggENF0ol', 1, 1594181574, NULL, 'api'),
('lGuVzgP0_mwojMr668uZVpQ9GfBvo5Md', 1, 1594191117, NULL, 'api'),
('mC94ZlPAg93I1yNcuIjag7EwYUBEdfzM', 1, 1594187299, NULL, 'api'),
('MQUmerKCnbFoAxGJsVbH6OuQIQ8Wni9P', 1, 1594174869, NULL, 'api'),
('r7uiprr309cpcn2m8195n564vk', NULL, 1593673953, 0x5f5f666c6173687c613a303a7b7d5f5f72657475726e55726c7c733a32393a22687474703a2f2f6b656a616b7361616e2e696f2f64617368626f617264223b, NULL),
('RvZvnihtz--BQ7CEAxql90dw7ioNXhC4', 1, 1594174909, NULL, 'api'),
('S45SsfJZI7V_u_aZoaMe26E0e3_qSxHj', 1, 1594183249, NULL, 'api'),
('snPBg3rfbK5mz5d15lUQzRi3Rii0UF4a', 1, 1594174887, NULL, 'api'),
('TQqejbBKyqWyV_OS4rSbp4R-k_2aPBHq', 1, 1594184567, NULL, 'api'),
('uCaHxTZAmC_u0kqIQV8MTBhjYnf7Rzn3', 1, 1594185374, NULL, 'api'),
('V5AEaCRK7vQUExkem-cwYYJKOWkYV82Q', 1, 1594183387, NULL, 'api'),
('wDswRVjDD76sd6RhYIJNEPH5TOqt3JaO', 1, 1594186226, NULL, 'api'),
('YfHjX7FGuPwswCVyPYYHuXdsR13sRioO', 1, 1594169977, NULL, 'api'),
('zHYauY9wtJu_XP2cDwWd17S_tRr8K1B2', 1, 1594180314, NULL, 'api');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `master_kejaksaan`
--
ALTER TABLE `master_kejaksaan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ref_error_codes`
--
ALTER TABLE `ref_error_codes`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `web_session`
--
ALTER TABLE `web_session`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `expire` (`expire`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `master_kejaksaan`
--
ALTER TABLE `master_kejaksaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
