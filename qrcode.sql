-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2024 at 12:03 PM
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
-- Database: `qrcode`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_code` varchar(7) NOT NULL,
  `course_name` text NOT NULL,
  `year` enum('1,1','1,2','2,1','2,2','4,1','4,2') NOT NULL,
  `program` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_code`, `course_name`, `year`, `program`) VALUES
('SCS2002', 'WEB DEVELOPMENT', '1,1', 'COMPUTER SCIENCE'),
('SCS2004', 'DIGITAL ELECTRONICS', '1,1', 'COMPUTER SCIENCE'),
('SCS2010', 'APPLIED STATISTICS', '2,1', 'COMPUTER SCIENCE');

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `invigilator` text NOT NULL,
  `course_code` varchar(7) NOT NULL,
  `No_of_candidates` int(11) NOT NULL,
  `date` date NOT NULL,
  `session` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`invigilator`, `course_code`, `No_of_candidates`, `date`, `session`) VALUES
('[value-1]', '[value-', 0, '0000-00-00', '[value-5]'),
('[value-1]', '[value-', 0, '0000-00-00', '[value-5]'),
('[value-1]', '[value-', 0, '0000-00-00', '[value-5]'),
('A Dube', 'SCS2010', 0, '0000-00-00', 'MORNING'),
('B Cook', 'SCS2002', 1, '2024-02-28', 'AFTERNOON\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `exam_log`
--

CREATE TABLE `exam_log` (
  `course_code` varchar(7) NOT NULL,
  `student_id` varchar(10) NOT NULL,
  `time_in` timestamp NOT NULL DEFAULT current_timestamp(),
  `time_out` time DEFAULT NULL,
  `signature` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_log`
--

INSERT INTO `exam_log` (`course_code`, `student_id`, `time_in`, `time_out`, `signature`) VALUES
('', 'N02221224B', '2024-02-23 06:21:15', '00:00:00', ''),
('', 'N02221224V', '2024-02-26 12:55:10', NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(20) NOT NULL,
  `image_data` longblob NOT NULL,
  `time` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `image_data`, `time`) VALUES
(1, '', '2024-02-16 10:41:25.295039'),
(2, '', '2024-02-16 10:41:29.529566'),
(3, '', '2024-02-16 10:53:15.538027'),
(4, '', '2024-02-16 10:53:17.127271'),
(5, '', '2024-02-16 10:53:19.905033'),
(6, '', '2024-02-16 10:53:20.988356'),
(7, '', '2024-02-16 10:53:29.989722'),
(8, '', '2024-02-16 10:53:31.939769'),
(9, '', '2024-02-16 10:54:19.513472'),
(10, '', '2024-02-16 10:56:36.100018'),
(11, '', '2024-02-16 10:58:07.623284'),
(12, '', '2024-02-16 11:05:06.378485'),
(13, '', '2024-02-16 11:05:42.738681'),
(14, '', '2024-02-16 11:05:45.431168'),
(15, '', '2024-02-19 07:26:28.718771'),
(16, '', '2024-02-19 07:32:43.937969'),
(17, '', '2024-02-20 08:16:27.220257'),
(18, '', '2024-02-22 11:04:47.758609'),
(19, '', '2024-02-22 11:21:53.750999'),
(20, '', '2024-02-22 11:30:47.894767'),
(21, '', '2024-02-22 11:35:11.415478'),
(22, 0x363564373836303364666361662e706e67, '2024-02-22 17:36:04.102548'),
(23, 0x363564373836366531643331392e706e67, '2024-02-22 17:37:50.120948'),
(24, 0x363564373837636663333132622e706e67, '2024-02-22 17:43:43.800460'),
(25, 0x363564373838316536376232642e6a706567, '2024-02-22 17:45:02.425860');

-- --------------------------------------------------------

--
-- Table structure for table `students_details`
--

CREATE TABLE `students_details` (
  `student_id` varchar(10) NOT NULL,
  `name` text NOT NULL,
  `program` text NOT NULL,
  `year` enum('1,1','1,2','2,1','2,2','4,1','4,2') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students_details`
--

INSERT INTO `students_details` (`student_id`, `name`, `program`, `year`) VALUES
('N02221224B', 'THABO DUBE', 'COMPUTER SCIENCE', '1,1'),
('N02221224V', 'LEBO SEBATA', 'INDUSTRIAL ENGINEERING', '4,1'),
('N02221225A', 'JOHN MOSS', 'COMPUTER SCIENCE', '2,1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_code`);

--
-- Indexes for table `exam_log`
--
ALTER TABLE `exam_log`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students_details`
--
ALTER TABLE `students_details`
  ADD PRIMARY KEY (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
