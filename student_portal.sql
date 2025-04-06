-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2025 at 07:23 PM
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
-- Database: `student_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `Attendance_ID` int(11) NOT NULL,
  `Student_PRN` varchar(20) NOT NULL,
  `Course_Name` varchar(100) NOT NULL,
  `Status` enum('Present','Absent') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`Attendance_ID`, `Student_PRN`, `Course_Name`, `Status`) VALUES
(1, 'PRN001', 'Data Structures', 'Present'),
(2, 'PRN002', 'Database Systems', 'Absent'),
(3, 'PRN003', 'Web Development', 'Present'),
(4, 'PRN004', 'Operating Systems', 'Absent'),
(5, 'PRN005', 'Machine Learning', 'Present');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` varchar(20) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `credits` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `department`, `credits`) VALUES
('45', 'Computer Science', 'sdsd', 2);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `Dept_ID` int(11) NOT NULL,
  `Dept_Name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`Dept_ID`, `Dept_Name`) VALUES
(1, 'Computer Engineering'),
(2, 'Information Technology'),
(3, 'Mechanical Engineering'),
(4, 'Civil Engineering'),
(5, 'Electronics and Telecommunication');

-- --------------------------------------------------------

--
-- Table structure for table `enrollment`
--

CREATE TABLE `enrollment` (
  `Student_PRN` varchar(20) NOT NULL,
  `Student_Name` varchar(100) DEFAULT NULL,
  `Course_ID` varchar(20) NOT NULL,
  `Course_Name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollment`
--

INSERT INTO `enrollment` (`Student_PRN`, `Student_Name`, `Course_ID`, `Course_Name`) VALUES
('45645', 'nikhil', '45', 'dsa');

-- --------------------------------------------------------

--
-- Table structure for table `exam_details`
--

CREATE TABLE `exam_details` (
  `exam_id` int(11) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `exam_date` date NOT NULL,
  `exam_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_details`
--

INSERT INTO `exam_details` (`exam_id`, `course_name`, `exam_date`, `exam_time`) VALUES
(1, 'Mathematics', '2025-05-15', '10:00:00'),
(2, 'Physics', '2025-05-17', '13:00:00'),
(3, 'Computer Science', '2025-05-20', '09:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `faculty_id` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`faculty_id`, `name`, `email`, `contact`, `created_at`) VALUES
('2', 'nikhil', 'gd@gmail.com', '9518594235', '2025-04-06 14:15:36'),
('23', 'atharvsakhare ', 'nikhil@gmail.com', '9518594278', '2025-04-06 14:31:19');

-- --------------------------------------------------------

--
-- Table structure for table `faculty_salary`
--

CREATE TABLE `faculty_salary` (
  `Salary_ID` int(11) NOT NULL,
  `Faculty_ID` int(11) NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `Department` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty_salary`
--

INSERT INTO `faculty_salary` (`Salary_ID`, `Faculty_ID`, `Amount`, `Department`) VALUES
(1, 101, 55000.00, 'Computer Engineering'),
(2, 102, 60000.00, 'Information Technology'),
(3, 103, 52000.00, 'Mechanical Engineering'),
(4, 104, 58000.00, 'Electronics'),
(5, 105, 61000.00, 'Civil Engineering');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `Feedback_ID` int(11) NOT NULL,
  `Student_PRN` varchar(20) NOT NULL,
  `Course_Name` varchar(100) NOT NULL,
  `Message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`Feedback_ID`, `Student_PRN`, `Course_Name`, `Message`) VALUES
(1, 'PRN001', 'Data Structures', 'Very helpful and clear instruction.'),
(2, 'PRN002', 'Database Systems', 'Enjoyed learning with practicals.'),
(3, 'PRN003', 'Operating Systems', 'Needs more real-world examples.'),
(4, 'PRN004', 'Web Development', 'Fun and interactive course!'),
(5, 'PRN005', 'Machine Learning', 'A bit fast-paced but informative.');

-- --------------------------------------------------------

--
-- Table structure for table `fees`
--

CREATE TABLE `fees` (
  `Fee_ID` int(11) NOT NULL,
  `Student_PRN` bigint(20) NOT NULL,
  `Course_Name` varchar(100) NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `Dept_ID` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fees`
--

INSERT INTO `fees` (`Fee_ID`, `Student_PRN`, `Course_Name`, `Amount`, `Dept_ID`) VALUES
(1, 220101123456, 'Data Structures', 25000.00, 'CSE01'),
(2, 220101123457, 'Operating Systems', 23000.00, 'CSE01'),
(3, 220101123458, 'Database Systems', 24000.00, 'IT01'),
(4, 220101123459, 'Mechanics', 20000.00, 'MECH01'),
(5, 220101123460, 'Thermodynamics', 21000.00, 'MECH01');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `username`, `password`) VALUES
(1, 'atharv', '$2y$10$zGllaKAzqlSj6ORNg4TpwOkrsWA8oE2sfdICDmhj87hN3ccj8r2ke');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`Attendance_ID`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`Dept_ID`);

--
-- Indexes for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD PRIMARY KEY (`Student_PRN`,`Course_ID`);

--
-- Indexes for table `exam_details`
--
ALTER TABLE `exam_details`
  ADD PRIMARY KEY (`exam_id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`faculty_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `faculty_salary`
--
ALTER TABLE `faculty_salary`
  ADD PRIMARY KEY (`Salary_ID`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`Feedback_ID`);

--
-- Indexes for table `fees`
--
ALTER TABLE `fees`
  ADD PRIMARY KEY (`Fee_ID`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `Attendance_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `Dept_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `exam_details`
--
ALTER TABLE `exam_details`
  MODIFY `exam_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `faculty_salary`
--
ALTER TABLE `faculty_salary`
  MODIFY `Salary_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `Feedback_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `fees`
--
ALTER TABLE `fees`
  MODIFY `Fee_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
