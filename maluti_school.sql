-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2025 at 12:06 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `maluti_school`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `status` enum('Present','Absent','Late') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `student_id`, `class_id`, `date`, `status`) VALUES
(73, 1, 1, '2025-04-18', 'Present'),
(74, 2, 1, '2025-04-18', 'Absent'),
(76, 1, 2, '2025-04-18', 'Present'),
(77, 2, 2, '2025-04-18', 'Present'),
(78, 3, 2, '2025-04-18', 'Present'),
(79, 1, 2, '2025-04-18', 'Present'),
(80, 2, 2, '2025-04-18', 'Present'),
(81, 3, 2, '2025-04-18', 'Present'),
(82, 1, 1, '2025-04-18', 'Present'),
(83, 2, 1, '2025-04-18', 'Absent'),
(84, 3, 1, '2025-04-18', 'Present'),
(85, 1, 1, '2025-04-18', 'Present'),
(86, 2, 1, '2025-04-18', 'Absent'),
(87, 3, 1, '2025-04-18', 'Present'),
(88, 1, 1, '2025-04-18', 'Present'),
(89, 2, 1, '2025-04-18', 'Present'),
(90, 3, 1, '2025-04-18', 'Present'),
(91, 1, 1, '2025-04-19', 'Present'),
(92, 2, 1, '2025-04-19', 'Absent'),
(93, 3, 1, '2025-04-19', 'Present'),
(94, 1, 1, '2025-04-19', 'Present'),
(95, 2, 1, '2025-04-19', 'Absent'),
(96, 3, 1, '2025-04-19', 'Present'),
(100, 1, 1, '2025-04-19', 'Present'),
(101, 2, 1, '2025-04-19', 'Late'),
(102, 3, 1, '2025-04-19', 'Present'),
(103, 1, 1, '2025-04-19', 'Present'),
(104, 2, 1, '2025-04-19', 'Present'),
(105, 3, 1, '2025-04-19', 'Present'),
(106, 1, 1, '2025-04-20', 'Present'),
(107, 2, 1, '2025-04-20', 'Present'),
(108, 3, 1, '2025-04-20', 'Present'),
(109, 1, 1, '2025-04-29', 'Present'),
(110, 2, 1, '2025-04-29', 'Present'),
(111, 3, 1, '2025-04-29', 'Present'),
(112, 1, 1, '2025-04-29', 'Present'),
(113, 2, 1, '2025-04-29', 'Present'),
(114, 3, 1, '2025-04-29', 'Present'),
(115, 1, 1, '2025-05-05', 'Present'),
(116, 2, 1, '2025-05-05', 'Absent'),
(117, 3, 1, '2025-05-05', 'Present');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `class_name` varchar(50) NOT NULL,
  `class_teacher_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `class_name`, `class_teacher_id`) VALUES
(1, 'Grade 10', NULL),
(2, 'Grade 11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `exam_results`
--

CREATE TABLE `exam_results` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `term1` double DEFAULT NULL,
  `term2` double DEFAULT NULL,
  `term3` double DEFAULT NULL,
  `term4` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_results`
--

INSERT INTO `exam_results` (`id`, `student_id`, `class_id`, `subject`, `term1`, `term2`, `term3`, `term4`) VALUES
(2, 2, 1, 'Math', 88, 65, 43, 90),
(3, 3, 1, 'Math', 70, 78, 81, 73),
(4, 1, 1, 'Math', 70, 80, 67, 55),
(5, 2, 1, 'Math', 88, 65, 43, 90),
(6, 3, 1, 'Math', 70, 78, 81, 73),
(7, 1, 1, 'Math', 70, 80, 67, 55),
(8, 2, 1, 'Math', 88, 65, 43, 90),
(9, 3, 1, 'Math', 70, 78, 81, 73),
(10, 7, 1, 'Math', 90, 77, 45, 76),
(11, 1, 1, 'Math', 70, 80, 67, 55),
(12, 2, 1, 'Math', 88, 65, 43, 90),
(13, 3, 1, 'Math', 70, 78, 81, 73),
(14, 7, 1, 'Math', 90, 77, 45, 76),
(15, 1, 1, 'Math', 70, 80, 67, 55),
(16, 2, 1, 'Math', 88, 65, 43, 90),
(17, 3, 1, 'Math', 70, 78, 81, 73),
(18, 7, 1, 'Math', 90, 77, 45, 76),
(19, 1, 1, 'Math', 70, 80, 67, 55),
(20, 2, 1, 'Math', 88, 65, 43, 90),
(21, 3, 1, 'Math', 70, 78, 81, 73),
(22, 7, 1, 'Math', 90, 77, 45, 76),
(23, 1, 1, 'Math', 70, 80, 67, 55),
(24, 2, 1, 'Math', 88, 65, 43, 90),
(25, 3, 1, 'Math', 70, 78, 81, 73),
(26, 7, 1, 'Math', 90, 77, 45, 76),
(27, 1, 1, 'Math', 70, 80, 67, 55),
(28, 2, 1, 'Math', 88, 65, 43, 90),
(29, 3, 1, 'Math', 70, 78, 81, 73),
(30, 7, 1, 'Math', 90, 77, 45, 76),
(31, 1, 2, 'History', 40, 30, 27, 55),
(32, 2, 2, 'History', 88, 65, 43, 90),
(33, 3, 2, 'History', 70, 78, 81, 73),
(34, 7, 2, 'History', 90, 77, 45, 76),
(35, 1, 1, 'History', 40, 30, 27, 55),
(36, 2, 1, 'History', 88, 65, 43, 90),
(37, 3, 1, 'History', 70, 78, 81, 73),
(38, 7, 1, 'History', 90, 77, 45, 76),
(39, 1, 1, 'History', 40, 30, 27, 55),
(40, 2, 1, 'History', 88, 65, 43, 90),
(41, 3, 1, 'History', 70, 78, 81, 73),
(42, 7, 1, 'History', 90, 77, 45, 76);

-- --------------------------------------------------------

--
-- Table structure for table `fee_payments`
--

CREATE TABLE `fee_payments` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL,
  `term` varchar(10) DEFAULT NULL,
  `year` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fee_payments`
--

INSERT INTO `fee_payments` (`id`, `student_id`, `amount_paid`, `payment_date`, `term`, `year`) VALUES
(1, 1, 1000.00, '2025-04-20', '2', 2025),
(2, 1, 1000.00, '2025-04-21', '2', 2025),
(3, 7, 500.00, '2025-04-21', '2', 2025),
(4, 1, 1000.00, '2025-04-30', '2', 2025);

-- --------------------------------------------------------

--
-- Table structure for table `fee_structure`
--

CREATE TABLE `fee_structure` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `total_fee` decimal(10,2) NOT NULL,
  `term` varchar(10) DEFAULT NULL,
  `year` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fee_structure`
--

INSERT INTO `fee_structure` (`id`, `student_id`, `total_fee`, `term`, `year`) VALUES
(3, 7, 1500.00, 'Term 1', 2024);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `date_sent` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `subject`, `message`, `date_sent`) VALUES
(1, 'AGM', 'AGM meeting next week ', NULL),
(2, 'AGM', 'agm meeting next week', NULL),
(3, 'AGM', 'agm meeting next week', NULL),
(4, 'AGM', 'agm meeting next week', NULL),
(5, 'AGM', 'agm meeting next week', NULL),
(6, 'AGM', 'agm next week', NULL),
(7, 'AGM', 'agm next week', NULL),
(8, 'AGM', 'agm next week', NULL),
(9, 'AGM', 'agm next week', NULL),
(10, 'AGM', 'Reminder: AGM tomorrow.', NULL),
(11, 'AGM', 'agm tomorrow', NULL),
(12, 'AGM', 'jhftvdt', NULL),
(13, 'AGM', 'mdnffnfnf', NULL),
(14, 'AGM', 'jbcydgcsdv', NULL),
(15, 'AGM', 'kvhjicdgyv', NULL),
(16, 'AGM', 'stuff', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `message_recipients`
--

CREATE TABLE `message_recipients` (
  `id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message_recipients`
--

INSERT INTO `message_recipients` (`id`, `message_id`, `parent_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 3, 2),
(5, 3, 3),
(6, 4, 1),
(7, 5, 1),
(8, 5, 2),
(9, 5, 3),
(10, 6, 1),
(11, 6, 2),
(12, 6, 3),
(13, 7, 1),
(14, 7, 2),
(15, 7, 3),
(16, 8, 1),
(17, 8, 2),
(18, 8, 3),
(19, 9, 1),
(20, 9, 2),
(21, 9, 3),
(22, 10, 1),
(23, 10, 2),
(24, 10, 3),
(25, 11, 2),
(26, 12, 1),
(27, 12, 3),
(28, 13, 1),
(29, 14, 1),
(30, 14, 2),
(31, 14, 3),
(32, 15, 1),
(33, 15, 2),
(34, 16, 1),
(35, 16, 2),
(36, 16, 3);

-- --------------------------------------------------------

--
-- Table structure for table `parents`
--

CREATE TABLE `parents` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parents`
--

INSERT INTO `parents` (`id`, `full_name`, `phone_number`, `email`, `address`) VALUES
(1, 'Mathabo Mokoena', '54321123', 'mokoenathabo@gmail.com', 'Address 1'),
(2, 'Malerato Ntsoko', '62556232', 'malerato@gmail.com', 'Address 2'),
(3, 'Mampho Teba', '65432178', 'mphoteba@gmail.com', 'Address 3');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `user_id`, `class_id`, `parent_id`, `dob`, `gender`, `address`, `full_name`) VALUES
(1, 101, 1, 201, '2012-01-01', 'Male', 'Address 1', 'Thabo Mokoena'),
(2, 102, 1, 202, '2012-02-02', 'Female', 'Address 2', 'Lerato Ntsoko'),
(3, 103, 1, 104, '2006-02-04', 'Female', 'Address 4', 'Limpho Polaki'),
(7, 8, 2, 104, '2010-02-04', 'Female', 'address 5', 'Nancy Drew');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teacher_classes`
--

CREATE TABLE `teacher_classes` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','teacher','student','parent') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'Tseliso', 'sosa@123', 'teacher', '2025-04-18 07:26:46'),
(3, 'Tsepiso', 'polaki@123', 'admin', '2025-04-18 08:58:18'),
(8, 'Nancy', 'nan123', 'student', '2025-04-20 01:16:31'),
(101, 'thabo', 'password123', 'student', '2025-04-18 15:52:03'),
(102, 'lerato', 'lele987', 'student', '2025-04-18 15:52:03'),
(103, 'mpho', 'password123', 'student', '2025-04-18 15:52:03'),
(104, 'Khotso', 'milo@123', 'parent', '2025-04-18 20:26:57'),
(201, 'parent1', 'parentpass1', 'parent', '2025-04-18 22:37:48'),
(202, 'parent2', 'parentpass2', 'parent', '2025-04-18 22:37:48'),
(203, 'Tebello', 'nyane@123', 'parent', '2025-04-20 01:13:37'),
(204, 'linare', 'pumpkin', 'student', '2025-04-20 20:13:06'),
(205, 'Abel', 'xoxo', 'parent', '2025-04-30 16:57:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_teacher_id` (`class_teacher_id`);

--
-- Indexes for table `exam_results`
--
ALTER TABLE `exam_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `fee_payments`
--
ALTER TABLE `fee_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `fee_structure`
--
ALTER TABLE `fee_structure`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message_recipients`
--
ALTER TABLE `message_recipients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_id` (`message_id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `parents`
--
ALTER TABLE `parents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `teacher_classes`
--
ALTER TABLE `teacher_classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `exam_results`
--
ALTER TABLE `exam_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `fee_payments`
--
ALTER TABLE `fee_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `fee_structure`
--
ALTER TABLE `fee_structure`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `message_recipients`
--
ALTER TABLE `message_recipients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `parents`
--
ALTER TABLE `parents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teacher_classes`
--
ALTER TABLE `teacher_classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`);

--
-- Constraints for table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`class_teacher_id`) REFERENCES `teachers` (`id`);

--
-- Constraints for table `exam_results`
--
ALTER TABLE `exam_results`
  ADD CONSTRAINT `exam_results_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `exam_results_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`);

--
-- Constraints for table `fee_payments`
--
ALTER TABLE `fee_payments`
  ADD CONSTRAINT `fee_payments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Constraints for table `fee_structure`
--
ALTER TABLE `fee_structure`
  ADD CONSTRAINT `fee_structure_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Constraints for table `message_recipients`
--
ALTER TABLE `message_recipients`
  ADD CONSTRAINT `message_recipients_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`),
  ADD CONSTRAINT `message_recipients_ibfk_2` FOREIGN KEY (`parent_id`) REFERENCES `parents` (`id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `students_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`),
  ADD CONSTRAINT `students_ibfk_3` FOREIGN KEY (`parent_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `teacher_classes`
--
ALTER TABLE `teacher_classes`
  ADD CONSTRAINT `teacher_classes_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`),
  ADD CONSTRAINT `teacher_classes_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
