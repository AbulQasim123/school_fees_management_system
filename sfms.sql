-- phpMyAdmin SQL Dump
-- version 5.3.0-dev+20221207.ce5ce76a8d
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 11, 2023 at 03:57 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sfms`
--

-- --------------------------------------------------------

--
-- Table structure for table `sfms_acedemic_standard`
--

CREATE TABLE `sfms_acedemic_standard` (
  `acedemic_standard_id` int(11) NOT NULL,
  `acedemic_standard_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `acedemic_standard_division` varchar(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `acedemic_standard_status` enum('Enable','Disable') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `acedemic_standard_added_on` datetime DEFAULT NULL,
  `acedemic_standard_updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sfms_acedemic_standard`
--

INSERT INTO `sfms_acedemic_standard` (`acedemic_standard_id`, `acedemic_standard_name`, `acedemic_standard_division`, `acedemic_standard_status`, `acedemic_standard_added_on`, `acedemic_standard_updated_on`) VALUES
(1, 'Junior KG', 'A', 'Enable', NULL, NULL),
(2, 'Senior KG', 'A', 'Enable', NULL, NULL),
(3, '1', 'A', 'Disable', NULL, NULL),
(4, '2', 'A', 'Disable', NULL, NULL),
(5, '3', 'A', 'Disable', NULL, NULL),
(6, 'HSC', 'A', 'Enable', '2023-01-09 01:41:19', '2023-01-09 02:19:48');

-- --------------------------------------------------------

--
-- Table structure for table `sfms_acedemic_year`
--

CREATE TABLE `sfms_acedemic_year` (
  `acedemic_year_id` int(11) NOT NULL,
  `acedemic_start_year` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `acedemic_start_month` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `acedemic_end_year` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `acedemic_end_month` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `acedemic_year_status` enum('Enable','Disable') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `acedemic_added_on` datetime DEFAULT NULL,
  `acedemic_updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sfms_acedemic_year`
--

INSERT INTO `sfms_acedemic_year` (`acedemic_year_id`, `acedemic_start_year`, `acedemic_start_month`, `acedemic_end_year`, `acedemic_end_month`, `acedemic_year_status`, `acedemic_added_on`, `acedemic_updated_on`) VALUES
(1, '2023', 'February', '2024', 'March', 'Disable', '2023-01-08 20:55:12', '2023-01-16 20:26:46');

-- --------------------------------------------------------

--
-- Table structure for table `sfms_admin`
--

CREATE TABLE `sfms_admin` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `admin_email` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `admin_password` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `admin_type` enum('Master','User') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `admin_status` enum('Enable','Disable') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `admin_added_on` datetime DEFAULT NULL,
  `admin_updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sfms_admin`
--

INSERT INTO `sfms_admin` (`admin_id`, `admin_name`, `admin_email`, `admin_password`, `admin_type`, `admin_status`, `admin_added_on`, `admin_updated_on`) VALUES
(1, 'John Smith', 'admin@sfms.com', 'password', 'Master', 'Enable', '2023-01-08 19:54:18', '2023-01-08 19:54:22'),
(2, 'Peter Parker', 'user@sfms.com', 'password123', 'User', 'Enable', '2023-01-08 19:54:27', '2023-01-08 19:54:30'),
(3, 'Ram', 'ram@sfms.com', 'ram', 'User', 'Enable', '2023-01-08 15:26:49', '2023-01-08 20:57:51');

-- --------------------------------------------------------

--
-- Table structure for table `sfms_setting`
--

CREATE TABLE `sfms_setting` (
  `setting_id` int(2) NOT NULL,
  `school_name` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `school_address` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `school_email_address` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `school_website` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `school_contact_number` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sfms_setting`
--

INSERT INTO `sfms_setting` (`setting_id`, `school_name`, `school_address`, `school_email_address`, `school_website`, `school_contact_number`) VALUES
(1, 'Testing Schools', 'Testing School Address, 7522525', 'testingschool@gmail.com', 'https://www.testingschool.org/', '7412589630');

-- --------------------------------------------------------

--
-- Table structure for table `sfms_student`
--

CREATE TABLE `sfms_student` (
  `student_id` int(11) NOT NULL,
  `student_number` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `student_name` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `student_father_name` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `student_mother_name` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `student_date_of_birth` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `student_address` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `student_date_of_addmission` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `student_contact_number1` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `student_contact_number2` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `student_image` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `student_added_on` datetime DEFAULT NULL,
  `student_updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sfms_student`
--

INSERT INTO `sfms_student` (`student_id`, `student_number`, `student_name`, `student_father_name`, `student_mother_name`, `student_date_of_birth`, `student_address`, `student_date_of_addmission`, `student_contact_number1`, `student_contact_number2`, `student_image`, `student_added_on`, `student_updated_on`) VALUES
(1, 'R004632', 'AbulQasim Ansari', 'Tahir', 'Zaibun Nisha', '01/03/2000', 'Bagi Mauaima', '01/05/2022', '9795844049', '8853668543', '1673298350-122599814.jpg', '2023-01-10 02:35:50', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sfms_acedemic_standard`
--
ALTER TABLE `sfms_acedemic_standard`
  ADD PRIMARY KEY (`acedemic_standard_id`);

--
-- Indexes for table `sfms_acedemic_year`
--
ALTER TABLE `sfms_acedemic_year`
  ADD PRIMARY KEY (`acedemic_year_id`);

--
-- Indexes for table `sfms_admin`
--
ALTER TABLE `sfms_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `sfms_setting`
--
ALTER TABLE `sfms_setting`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `sfms_student`
--
ALTER TABLE `sfms_student`
  ADD PRIMARY KEY (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sfms_acedemic_standard`
--
ALTER TABLE `sfms_acedemic_standard`
  MODIFY `acedemic_standard_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sfms_acedemic_year`
--
ALTER TABLE `sfms_acedemic_year`
  MODIFY `acedemic_year_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sfms_admin`
--
ALTER TABLE `sfms_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sfms_student`
--
ALTER TABLE `sfms_student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
