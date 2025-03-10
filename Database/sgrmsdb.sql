-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2025 at 02:27 PM
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
-- Database: `sgrmsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `case_records`
--

CREATE TABLE `case_records` (
  `case_id` int(11) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `grade_section` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `case_type` varchar(100) NOT NULL,
  `reported_by` varchar(100) NOT NULL,
  `filed_date` date NOT NULL DEFAULT curdate(),
  `filed_time` time NOT NULL DEFAULT curtime(),
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `case_records`
--

INSERT INTO `case_records` (`case_id`, `student_name`, `grade_section`, `description`, `case_type`, `reported_by`, `filed_date`, `filed_time`, `status`) VALUES
(1, 'John Bert D. Plameran', 'Grade 1', 'Image loss', 'Cheater', '', '2025-03-09', '17:14:53', ''),
(2, 'Christian Abendan', 'BSIT 3B', 'Ge harass niya si david', 'personal_issue', '', '2025-03-09', '17:14:53', ''),
(3, 'David Villondo', 'BSIT 3B', 'Nang cheat', 'academic issue', '', '2025-03-09', '17:14:53', ''),
(4, 'John', 'BSIT 3B', 'wala ra', 'Cheater', 'wala ra', '2222-01-01', '11:11:00', 'Pending'),
(5, 'John', 'BSIT 3B', 'asdasd', 'Cheater', 'wala ra', '2025-03-10', '05:01:48', 'Pending'),
(6, 'John', 'BSIT 3B', 'Cheating during summative test', 'Academic Issue', 'Christian James Abendan', '2025-03-10', '05:10:17', 'Pending'),
(7, 'John', 'BSIT 3B', 'cheating', 'Academic Issue', 'Christian James Abendan', '2025-03-10', '05:13:38', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `counselors`
--

CREATE TABLE `counselors` (
  `c_id` int(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `mname` varchar(50) NOT NULL,
  `contact_num` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `c_level` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `counselors`
--

INSERT INTO `counselors` (`c_id`, `lname`, `fname`, `mname`, `contact_num`, `email`, `c_level`) VALUES
(1, 'Garth Stark', 'Lawrence Acosta', 'Vera Fischer', '09123456789', 'xyhu@mailinator.com', 'College'),
(2, 'Aretha Pierce', 'Naomi Ball', 'Cora Weber', '0927542772', 'jojavaz@mailinator.com', 'Elementary'),
(3, 'Alma Dalton', 'Morgan Holcomb', 'Finn Mccormick', '094618541', 'wuby@mailinator.com', 'Elementary'),
(4, 'Dustin Tyson', 'Britanney Patel', 'Carter Mcmahon', '0915464125', 'jovatucuwy@mailinator.com', 'Elementary'),
(5, 'Price Langley', 'Cruz Moore', 'Tatyana Clay', '0915843558745', 'vajanuv@mailinator.com', 'College');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `s_id` int(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `mname` varchar(50) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `bod` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `mobile_num` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `educ_level` enum('Elementary','High School','College','Other') NOT NULL,
  `year_level` varchar(50) NOT NULL,
  `section` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`s_id`, `lname`, `fname`, `mname`, `gender`, `bod`, `address`, `mobile_num`, `email`, `educ_level`, `year_level`, `section`) VALUES
(1, 'Romano', 'David Sailas', 'Villondo', 'Male', '2003-02-12', 'dakit', '0123456789', 'xacy@mailinator.com', 'College', '3rd Year', 'Butig'),
(3, 'Brynne Graves', 'Barry Vasquez', 'Elton Sullivan', 'Female', '2010-10-04', 'Minima minim esse no', '0987321654', 'byxohotume@mailinator.com', 'High School', '7', 'Animi modi pariatur'),
(4, 'Joel Snider', 'Carolyn Avery', 'Oprah Sosa', 'Male', '2005-06-26', 'Excepteur reprehende', '094561237832', 'wocysih@mailinator.com', 'High School', '12', 'Consequat Amet id'),
(5, 'Elijah Weaver', 'Arden Dillard', 'Kellie Rivas', 'Male', '2009-09-23', 'Rerum laborum in non', 'Cupiditate unde do t', 'havomipof@mailinator.com', 'Elementary', '5', 'Minima sit ipsa aut'),
(6, 'Carl Bradshaw', 'Elijah Dominguez', 'Lana Morton', 'Female', '2000-08-29', 'Impedit eum quis fu', 'Ullam molestias duis', 'kosogoda@mailinator.com', 'High School', '9', 'Ea non quae esse ame'),
(7, 'Adrian Zamora', 'Alfonso Bauer', 'Yolanda Mcconnell', 'Male', '2017-04-29', 'Sed deserunt eu iure', 'Ratione illo at tene', 'valecino@mailinator.com', 'Elementary', '2', 'Consequatur in volup'),
(8, 'Reece Winters', 'Garrett Rodgers', 'Chandler Valencia', 'Male', '2015-02-12', 'Quia commodi sint ei', 'Reprehenderit labor', 'xybo@mailinator.com', 'Elementary', '5', 'Iste iste iure aut a'),
(9, 'Rosalyn Alvarado', 'Phyllis King', 'Emmanuel Salinas', 'Female', '2020-08-25', 'Cum vel tenetur amet', '09123456789', 'cysatibo@mailinator.com', 'Elementary', '2', 'kamonggay'),
(10, 'Zelenia Perez', 'Kylie Pace', 'Tad Raymond', 'Female', '1978-10-26', 'Dignissimos ea sit v', '09123456789', 'xupas@mailinator.com', 'College', '4th Year', 'Molestiae maxime in'),
(11, 'Paki Mann', 'Ruby Justice', 'Lilah Mitchell', 'Male', '2013-10-09', 'Dolor quis quae quo', 'Quae officiis dolor', 'fagu@mailinator.com', 'Elementary', '6', 'Iste nemo consequat'),
(12, 'Phyllis Battle', 'Kadeem Stuart', 'Jarrod Foreman', 'Male', '2010-12-19', 'Sed eos voluptates e', '09781654256', 'mydevam@mailinator.com', 'High School', 'Grade 7', 'Consequuntur culpa');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `t_id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `mname` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `section` varchar(100) NOT NULL,
  `teach_level` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`t_id`, `fname`, `lname`, `mname`, `email`, `phone`, `section`, `teach_level`) VALUES
(1, 'David Sailas', 'Romano', 'Villondo', 'sample@gmail.com', '09123456789', 'butig', 'College'),
(2, 'Keiko Mcconnell', 'Xandra Sosa', 'Zia Oliver', 'gogid@mailinator.com', '+1 (803) 286-60', 'Distinctio Voluptat', 'Elementary'),
(3, 'Louis Evans', 'George Preston', 'Xerxes Molina', 'rywubyjow@mailinator.com', '+1 (844) 845-18', 'Magnam consequatur ', 'College'),
(4, 'Aspen Wong', 'Brent Goff', 'Portia Sosa', 'werun@mailinator.com', '+1 (795) 724-67', 'Fugiat vel animi q', 'Elementary'),
(5, 'Montana Glover', 'Marvin Goff', 'Indira Lester', 'qurexaval@mailinator.com', '+1 (285) 178-71', 'Est adipisci sit qu', 'College');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Super Admin','Admin','Super User','User') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'superadmin', '482c811da5d5b4bc6d497ffa98491e38', 'Super Admin'),
(2, 'admin', '482c811da5d5b4bc6d497ffa98491e38', 'Admin'),
(3, 'superuser', '482c811da5d5b4bc6d497ffa98491e38', 'Super User'),
(4, 'user', '482c811da5d5b4bc6d497ffa98491e38', 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `case_records`
--
ALTER TABLE `case_records`
  ADD PRIMARY KEY (`case_id`);

--
-- Indexes for table `counselors`
--
ALTER TABLE `counselors`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`s_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`t_id`),
  ADD UNIQUE KEY `email` (`email`);

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
-- AUTO_INCREMENT for table `case_records`
--
ALTER TABLE `case_records`
  MODIFY `case_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `counselors`
--
ALTER TABLE `counselors`
  MODIFY `c_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `s_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `t_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
