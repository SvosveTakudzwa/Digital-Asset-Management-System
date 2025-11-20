-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 29, 2024 at 02:50 PM
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
-- Database: `assets_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `assets_id` int(11) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_description` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `serial_number` varchar(255) NOT NULL,
  `date_created` date NOT NULL,
  `signature` text NOT NULL,
  `qr_code` varchar(255) DEFAULT NULL,
  `missing` varchar(3) DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`assets_id`, `student_id`, `user_id`, `item_description`, `model`, `serial_number`, `date_created`, `signature`, `qr_code`, `missing`) VALUES
(9, 'H210404P', 2, 'Lenovo Laptop', '15bs031XC', 'HGydydyGY', '2024-06-29', '667ff3ad7bce2.png', '667ff3ad7d29e.jpg', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `deleted_assets`
--

CREATE TABLE `deleted_assets` (
  `asset_id` int(11) NOT NULL,
  `asset_name` varchar(255) NOT NULL,
  `reg_number` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `serial_number` varchar(255) NOT NULL,
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `portal_users`
--

CREATE TABLE `portal_users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `id_number` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `is_verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `portal_users`
--

INSERT INTO `portal_users` (`id`, `username`, `email`, `password`, `dob`, `id_number`, `phone_number`, `address`, `is_verified`) VALUES
(1, 'Takudzwa Svosve', 'h210404p@hit.ac.zw', '$2y$10$Ez5UJAk8FF1tusjTs21YkORrZh8uhBXjO9Z9rKBNnj83TYxTjzw/S', '2001-09-29', '79-172727L26', '0714376512', 'Mbizo 3', 1),
(2, 'Rakinzi Silver', 'h200156w@hit.ac.zw', '$2y$10$/GSHIovhJ0Bxe9lyYHvGCO7kb7ffBrwn3WA1W7jyjTHblrNySF4YK', '2000-02-22', '73-172828 k 24', '0786680563', '1000 Glaudina, Harare', 1);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `sid` int(11) NOT NULL,
  `student_id` text NOT NULL,
  `student_username` text NOT NULL,
  `student_email` text NOT NULL,
  `student_phone` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_session`
--

CREATE TABLE `user_session` (
  `session_id` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `activity` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_session`
--

INSERT INTO `user_session` (`session_id`, `user_id`, `activity`, `date`) VALUES
('HIT667fd9b8137756.22248026', 1, 'login', '2024-06-29 09:54:00'),
('HIT667fd9cd743cd0.37621215', 1, 'logout', '2024-06-29 09:54:21'),
('HIT667fd9d6a07d24.49889135', 1, 'login', '2024-06-29 09:54:30'),
('HIT667fd9e39a00c2.20789823', 1, 'logout', '2024-06-29 09:54:43'),
('HIT667fd9fe0b2e27.75460938', 1, 'login', '2024-06-29 09:55:10'),
('HIT667fda6f19b271.60119651', 1, 'logout', '2024-06-29 09:57:03'),
('HIT667fda8698a083.07930137', 1, 'login', '2024-06-29 09:57:26'),
('HIT667fe683a74fb1.45289317', 1, 'login', '2024-06-29 10:48:35'),
('HIT667fe6aa0061a6.95344521', 1, 'logout', '2024-06-29 10:49:14'),
('HIT667fe6cdbb82d9.10002684', 1, 'login', '2024-06-29 10:49:49'),
('HIT667fec0212df07.80430530', 1, 'logout', '2024-06-29 11:12:02'),
('HIT667ff065ba80e8.48466035', 1, 'login', '2024-06-29 11:30:45'),
('HIT667ff17e222eb9.04882048', 1, 'login', '2024-06-29 11:35:26'),
('HIT667ff28c985ea8.25247167', 1, 'logout', '2024-06-29 11:39:56'),
('HIT667ff3168000a2.77414012', 2, 'logout', '2024-06-29 11:42:14'),
('HIT667ff3279812c7.17464831', 2, 'login', '2024-06-29 11:42:31'),
('HIT667ff413473616.17339047', 2, 'logout', '2024-06-29 11:46:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`assets_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `deleted_assets`
--
ALTER TABLE `deleted_assets`
  ADD PRIMARY KEY (`asset_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `portal_users`
--
ALTER TABLE `portal_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `user_session`
--
ALTER TABLE `user_session`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `assets_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `portal_users`
--
ALTER TABLE `portal_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assets`
--
ALTER TABLE `assets`
  ADD CONSTRAINT `assets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `portal_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `deleted_assets`
--
ALTER TABLE `deleted_assets`
  ADD CONSTRAINT `deleted_assets_ibfk_1` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`assets_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `deleted_assets_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `portal_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_session`
--
ALTER TABLE `user_session`
  ADD CONSTRAINT `user_session_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `portal_users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
