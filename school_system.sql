-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2024 at 05:25 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `grade` varchar(5) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `subject` varchar(100) DEFAULT NULL,
  `remarks` enum('Passed','Failed') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `student_email` varchar(100) NOT NULL,
  `pre_enrollment_data` text NOT NULL,
  `status` enum('pending','approved') DEFAULT 'pending',
  `teacher_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `old_or_new` enum('old','new') NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `mi` varchar(5) DEFAULT NULL,
  `age` int(11) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `street` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL,
  `zipcode` varchar(10) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `religion` varchar(50) DEFAULT NULL,
  `contact_number` varchar(15) DEFAULT NULL,
  `guardian` varchar(100) DEFAULT NULL,
  `guardian_relation` varchar(50) DEFAULT NULL,
  `last_school` varchar(100) DEFAULT NULL,
  `course` varchar(100) DEFAULT NULL,
  `student_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_name`, `student_email`, `pre_enrollment_data`, `status`, `teacher_id`, `created_at`, `old_or_new`, `first_name`, `last_name`, `mi`, `age`, `gender`, `street`, `city`, `province`, `zipcode`, `birthday`, `religion`, `contact_number`, `guardian`, `guardian_relation`, `last_school`, `course`, `student_id`) VALUES
(35, 'Jerome Esma', 'jeromeesma10@gmail.com', '{\"old_or_new\":\"new\"}', 'pending', NULL, '2024-11-04 06:56:49', 'old', '', '', NULL, 0, 'Male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '24-000005'),
(36, 'Jerome Esma', 'jeromeesma10@gmail.com', '{\"old_or_new\":\"new\"}', 'pending', NULL, '2024-11-04 07:05:13', 'old', '', '', NULL, 0, 'Male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '24-000006'),
(2025, 'Dinelo Donor', 'jeromeesma10@gmail.com', '{\"old_or_new\":\"new\"}', 'pending', NULL, '2024-11-04 13:16:10', 'old', '', '', NULL, 0, 'Male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '24-000009'),
(2026, 'Marjorie Quinnia', 'jeromeesma10@gmail.com', '{\"old_or_new\":\"new\"}', 'approved', NULL, '2024-11-04 13:19:35', 'old', '', '', NULL, 0, 'Male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '24-0010'),
(2027, 'Faith Emnas', 'faithemnas@gmail.com', '{\"old_or_new\":\"new\"}', 'approved', NULL, '2024-11-14 00:23:57', 'old', '', '', NULL, 0, 'Male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '24-00011');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('admin','teacher','student') NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `user_type`, `email`, `created_at`, `status`) VALUES
(6, 'esma', 'esma', 'admin', 'admin@example.com', '2024-10-08 17:28:27', NULL),
(7, 'fdgfgf', '', 'teacher', 'dfhj@gmail.com', '2024-11-04 05:08:18', NULL),
(8, 'fdgfgf', '', 'teacher', 'dfhj@gmail.com', '2024-11-04 05:08:24', NULL),
(10, 'yom', '$2y$10$2I4tB8jcSmda5WHVdzfFVO0rysquVI/tamHc6VeHzveS28mMR549u', 'teacher', 'jeromeesma10@gmail.com', '2024-11-11 05:16:07', NULL),
(11, 'esma', 'esma1', 'admin', '', '2024-11-12 07:53:58', NULL),
(13, 'jerome', 'jerome', 'teacher', '', '2024-11-12 08:26:12', NULL),
(14, 'adminuser', '$2y$10$E0VvL2zTSJ3glFYmcVIMguIS2FY1dPCkj6mLlAxv7XnHVpTQosfFq', 'admin', 'admin@example.com', '2024-11-13 11:43:05', 'active'),
(15, 'newadmin', '$2y$10$4Qd06tLZo6f7kOAtdA2gfzXjA0UEynHlY9Tg1rTrwJYIHJj6gMBtu', 'admin', 'newadmin@example.com', '2024-11-13 12:16:48', 'active'),
(16, 'newteacher', '$2y$10$3HpiFVFN5ZpLRu46WmFO.vXsH9ON1I7FxjmlmVzzh1IQkYkcFX2H.', 'teacher', 'newteacher@example.com', '2024-11-13 12:17:19', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2030;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grades_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
