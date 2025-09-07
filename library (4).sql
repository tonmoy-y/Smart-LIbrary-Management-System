-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 08, 2025 at 01:08 AM
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
-- Database: `library`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `dept` varchar(100) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `pic` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `Name`, `dept`, `phone`, `email`, `username`, `password`, `pic`, `status`) VALUES
(19, 'Tonmoy Sarker', '123', '01521788253', 'tonm51@gmail.com', 'admin123', '$2y$10$ae4OAWuyU8zlpm/gy1EzPOo1nx6gl/3K9nZok3qFgYC', 'admin.jpg', 'Yes'),
(20, 'Tonmoy Sarker', 'CSE', '01521788253', 'to@gmail.com', 'tonmoy', '$2y$10$g2Ckl7elsk5xzCQINSjb5OCaczoFQCW1hPgyFeGCpbOxRD3cnoDW.', 'admin.jpg', 'Yes'),
(22, 'Tonmoy Sarker', 'CSE', '01521788253', 'ton451@gmail.com', 'tonmoy3', '$2y$10$PE3WKQnT0F1m0oOwIb8dcuLFb.0MITkLupIYnmoQWtePq97usA6MS', 'looking_each_other_1757273285.jpg', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `bid` int(11) NOT NULL,
  `names` varchar(255) NOT NULL,
  `authors` varchar(255) NOT NULL,
  `edition` varchar(100) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `quantity` int(11) DEFAULT 0,
  `department` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`bid`, `names`, `authors`, `edition`, `status`, `quantity`, `department`, `image`) VALUES
(1, 'Introduction to Algorithms', 'Thomas H. Cormen', '3rd', 'Available', 4, 'CSE', 'introduction-to-algorithms-3rd-edition.jpg'),
(3, 'Operating System Concepts', 'Abraham Silberschatz', '9th', 'Available', 3, 'CSE', 'operating-system-concepts-3.jpg'),
(4, 'Computer Networks', 'Andrew S. Tanenbaum', '5th', 'Available', 6, 'CSE', 'computer-networks-4.jpg'),
(5, 'Artificial Intelligence: A Modern Approach', 'Stuart Russell', '4th', 'Not Available', 0, 'CSE', 'Russell_AI.jpg'),
(6, 'Digital Logic Design', 'M. Morris Mano', '5th', 'Available', 5, 'EEE', 'digital-logic-design-6.jpg'),
(7, 'Microprocessor Architecture', 'Ramesh Gaonkar', '6th', 'Available', 11, 'EEE', 'microprocessor-architecture-7.jpg'),
(8, 'Signals and Systems', 'Alan V. Oppenheim', '2nd', 'Available', 4, 'EEE', 'signals-and-systems-8.jpg'),
(9, 'Control Systems Engineering', 'Norman S. Nise', '7th', 'Available', 3, 'EEE', 'control-systems-engineering-9.jpg'),
(10, 'Power Electronics', 'Muhammad H. Rashid', '4th', 'Available', 2, 'EEE', 'power-electronics-10.jpg'),
(11, 'Engineering Mathematics', 'B.S. Grewal', '43rd', 'Available', 8, 'Math', 'engineering-mathematics-11.jpg'),
(12, 'Higher Engineering Mathematics', 'H.K. Dass', '12th', 'Available', 6, 'Math', 'HK_Das.jpg'),
(13, 'Linear Algebra and Its Applications', 'Gilbert Strang', '5th', 'Available', 5, 'Math', 'linear-algebra-and-its-applications-13.jpg'),
(14, 'Probability and Statistics', 'Miller & Freund', '8th', 'Available', 4, 'Math', 'probability_stats.jpg'),
(15, 'Numerical Methods for Engineers', 'Steven C. Chapra', '7th', 'Available', 3, 'Math', 'numerical-methods-for-engineers-15.jpg'),
(16, 'Physics for Scientists and Engineers', 'Raymond A. Serway', '9th', 'Available', 6, 'Physics', 'physics-for-scientists-and-engineers-16.jpg'),
(17, 'Fundamentals of Physics', 'Halliday, Resnick, Walker', '10th', 'Available', 5, 'Physics', 'fundamentals-of-physics-17.jpg'),
(18, 'Concepts of Modern Physics', 'Arthur Beiser', '7th', 'Available', 4, 'Physics', 'concepts-of-modern-physics-18.jpg'),
(19, 'Engineering Physics', 'Satyaprakash', '2nd', 'Available', 3, 'Physics', 'eng_phy.jpg'),
(20, 'Quantum Mechanics', 'David J. Griffiths', '2nd', 'Available', 2, 'Physics', 'quantum-mechanics-20.jpg'),
(21, 'Basic Electrical Engineering', 'V.K. Mehta', '3rd', 'Available', 6, 'EEE', 'Basic_EE.jpg'),
(22, 'Electronic Devices and Circuits', 'Boylestad & Nashelsky', '11th', 'Available', 5, 'EEE', 'electronic-devices-and-circuits-22.jpg'),
(23, 'Circuit Theory: Analysis & Synthesis', 'A. Chakrabarti', '4th', 'Available', 4, 'EEE', 'circuit.jpg'),
(24, 'Signals and Linear Systems', 'B.P. Lathi', '3rd', 'Available', 3, 'EEE', 'signals-and-linear-systems-24.jpg'),
(25, 'Data Structures and Algorithms', 'Ellis Horowitz', '2nd', 'Available', 4, 'CSE', 'comdata.jpg'),
(26, 'Software Engineering', 'Ian Sommerville', '10th', 'Available', 3, 'CSE', 'software-engineering-26.jpg'),
(27, 'Computer Organization and Architecture', 'William Stallings', '10th', 'Available', 5, 'CSE', 'computer-organization-and-architecture-27.jpg'),
(28, 'Compiler Design', 'Alfred V. Aho', '2nd', 'Available', 2, 'CSE', 'compiler-design-28.jpg'),
(29, 'Discrete Mathematics and Its Applications', 'Kenneth H. Rosen', '7th', 'Available', 6, 'Math', 'discrete-mathematics-and-its-applications-29.jpg'),
(31, 'Database System Concepts', 'Silberschatz, Korth, and Sudarshan', '7th', 'Available ', 3, 'CSE', 'db7-cover.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `admin_reply` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `username`, `comment`, `admin_reply`) VALUES
(13, 'admin', 'Hi there ', 'I have solved the problem\nI have solved the problem\nI have solved the problem'),
(16, 'admin', 'Hi', 'hi'),
(20, 'tonmoy', 'hey admin \r\ni need an help', 'What\'s that'),
(21, 'tonmoy', 'dsf', 'qewsdgfhjkl');

-- --------------------------------------------------------

--
-- Table structure for table `fine`
--

CREATE TABLE `fine` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `bid` varchar(50) NOT NULL,
  `returned` date NOT NULL,
  `days` int(11) NOT NULL,
  `fine` decimal(10,2) NOT NULL,
  `status` enum('paid','unpaid') NOT NULL DEFAULT 'unpaid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `issue_book`
--

CREATE TABLE `issue_book` (
  `username` varchar(50) NOT NULL,
  `bid` int(11) NOT NULL,
  `issue` varchar(50) NOT NULL,
  `return` varchar(50) NOT NULL,
  `approve` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `issue_book`
--

INSERT INTO `issue_book` (`username`, `bid`, `issue`, `return`, `approve`) VALUES
('tonmoy3', 3, '2025-09-08', '2025-09-18', 'Yes'),
('tonmoy3', 4, '2025-09-07', '2025-09-08', '<p style=\"color:yellow; background-color: green;\"> RETURNED </p>');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `message` varchar(200) NOT NULL,
  `status` varchar(50) NOT NULL,
  `sender` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `name` varchar(100) NOT NULL,
  `roll` varchar(20) NOT NULL,
  `dept` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `status` int(50) NOT NULL DEFAULT 0,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `pic` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`name`, `roll`, `dept`, `phone`, `email`, `status`, `username`, `password`, `pic`) VALUES
('Tonmoy Sarker', '213124', 'CSE', '01521788253', 'tonmoy4451@gmail.com', 1, 'tonmoy3', '$2y$10$7qQAXrhCY5gNBk6Zzdqy9u45816j2TNWit5x5wBEyHwTigU2UHHrW', 'looking_each_other_1757282183.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `timer`
--

CREATE TABLE `timer` (
  `name` varchar(50) NOT NULL,
  `bid` int(11) NOT NULL,
  `tm` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timer`
--

INSERT INTO `timer` (`name`, `bid`, `tm`) VALUES
('tonmoy3', 3, 'Sep 18, 2025 20:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `verify`
--

CREATE TABLE `verify` (
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `otp` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `verify_admin`
--

CREATE TABLE `verify_admin` (
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `otp` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`bid`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fine`
--
ALTER TABLE `fine`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `issue_book`
--
ALTER TABLE `issue_book`
  ADD PRIMARY KEY (`username`,`bid`,`issue`,`approve`),
  ADD KEY `bid` (`bid`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `roll` (`roll`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `timer`
--
ALTER TABLE `timer`
  ADD PRIMARY KEY (`name`,`bid`),
  ADD KEY `username` (`name`),
  ADD KEY `bid` (`bid`);

--
-- Indexes for table `verify`
--
ALTER TABLE `verify`
  ADD KEY `fk_student_username` (`username`);

--
-- Indexes for table `verify_admin`
--
ALTER TABLE `verify_admin`
  ADD KEY `fk_admin_username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `bid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `fine`
--
ALTER TABLE `fine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `issue_book`
--
ALTER TABLE `issue_book`
  ADD CONSTRAINT `issue_book_ibfk_1` FOREIGN KEY (`username`) REFERENCES `student` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `issue_book_ibfk_2` FOREIGN KEY (`bid`) REFERENCES `books` (`bid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `timer`
--
ALTER TABLE `timer`
  ADD CONSTRAINT `timer_ibfk_1` FOREIGN KEY (`name`) REFERENCES `student` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `timer_ibfk_2` FOREIGN KEY (`bid`) REFERENCES `books` (`bid`) ON DELETE CASCADE;

--
-- Constraints for table `verify`
--
ALTER TABLE `verify`
  ADD CONSTRAINT `fk_student_username` FOREIGN KEY (`username`) REFERENCES `student` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `verify_admin`
--
ALTER TABLE `verify_admin`
  ADD CONSTRAINT `fk_admin_username` FOREIGN KEY (`username`) REFERENCES `admin` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
