-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2025 at 10:11 AM
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
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `activity` varchar(255) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `case_records`
--

CREATE TABLE `case_records` (
  `case_id` int(11) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `academic_level` varchar(50) NOT NULL,
  `grade_level` int(10) NOT NULL,
  `course_section` varchar(50) NOT NULL,
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

INSERT INTO `case_records` (`case_id`, `student_name`, `academic_level`, `grade_level`, `course_section`, `description`, `case_type`, `reported_by`, `filed_date`, `filed_time`, `status`) VALUES
(1, 'John Bert D. Plameran', 'Grade 1', 0, '', 'Image loss', 'Cheater', '', '2025-03-09', '17:14:53', 'Pending'),
(2, 'Christian Abendan', 'BSIT 3B', 0, '', 'Ge harass niya si david', 'personal_issue', '', '2025-03-09', '17:14:53', 'Pending'),
(3, 'David Villondo', 'BSIT 3B', 0, '', 'Nang cheat', 'academic issue', '', '2025-03-09', '17:14:53', 'Pending'),
(4, 'John', 'BSIT 3B', 0, '', 'wala ra', 'Cheater', 'wala ra', '2222-01-01', '11:11:00', 'Pending'),
(5, 'John', 'BSIT 3B', 0, '', 'asdasd', 'Cheater', 'wala ra', '2025-03-10', '05:01:48', 'Pending'),
(6, 'John', 'BSIT 3B', 0, '', 'Cheating during summative test', 'Academic Issue', 'Christian James Abendan', '2025-03-10', '05:10:17', 'Pending'),
(7, 'John', 'BSIT 3B', 0, '', 'cheating', 'Academic Issue', 'Christian James Abendan', '2025-03-10', '05:13:38', 'Pending'),
(8, 'Vince', 'BSIT 3 B', 0, '', 'elementary tirada', 'Manglotasay', 'david and christian', '2025-03-10', '08:52:41', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `counselors`
--

CREATE TABLE `counselors` (
  `c_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `mname` varchar(50) DEFAULT NULL,
  `contact_num` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `c_level` varchar(20) NOT NULL,
  `c_image` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `counselors`
--

INSERT INTO `counselors` (`c_id`, `u_id`, `lname`, `fname`, `mname`, `contact_num`, `email`, `c_level`, `c_image`) VALUES
(1, 18, 'Doe', 'John', 'A.', '09123456789', 'john.doe@gmail.com', 'Elementary', '\'images/john_doe.jpg\''),
(2, 19, 'Smith', 'Jane', 'B.', '09234567890', 'jane.smith@gmail.com', 'High School', '\'images/jane_smith.jpg\''),
(3, 20, 'Lee', 'Michael', 'C.', '09345678901', 'michael.lee@gmail.com', 'College', '\'images/michael_lee.jpg\'');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `s_id` int(11) NOT NULL,
  `id_num` varchar(20) NOT NULL,
  `prefix` varchar(10) DEFAULT NULL,
  `lname` varchar(50) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `mname` varchar(50) DEFAULT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `bod` date NOT NULL,
  `address` varchar(100) NOT NULL,
  `mobile_num` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `educ_level` enum('Elementary','High School','College') NOT NULL,
  `year_level` varchar(20) NOT NULL,
  `section` varchar(20) DEFAULT NULL,
  `program` varchar(100) DEFAULT NULL,
  `s_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`s_id`, `id_num`, `prefix`, `lname`, `fname`, `mname`, `gender`, `bod`, `address`, `mobile_num`, `email`, `educ_level`, `year_level`, `section`, `program`, `s_image`) VALUES
(1, 'SCC-25-00000001', '', 'Smith', 'John', 'Michael', 'Male', '2012-03-05', 'Lipata, Minglanilla, Cebu', '09123456781', 'john@example.com', 'Elementary', 'Grade 1', 'Red', '', '/SGRMS/profile/circle-user.png'),
(2, 'SCC-25-00000002', '', 'Johnson', 'Mary', 'Ann', 'Female', '2011-07-12', 'Lawaan, Talisay, Cebu', '09123456782', 'mary@example.com', 'College', '1st Year', '', 'BS Computer Science', '/SGRMS/profile/circle-user.png'),
(3, 'SCC-25-00000003', '', 'Williams', 'James', 'Robert', 'Male', '2010-11-20', 'Uling, Naga, Cebu', '09123456783', 'james@example.com', 'Elementary', 'Grade 3', 'Green', '', '/SGRMS/profile/circle-user.png'),
(4, 'SCC-25-00000004', '', 'Brown', 'Patricia', 'Elizabeth', 'Female', '2009-05-18', 'Tungkil, Minglanilla, Cebu', '09123456784', 'patricia@example.com', 'High School', 'Grade 7', 'Apple', '', '/SGRMS/profile/circle-user.png'),
(5, 'SCC-25-00000005', '', 'Jones', 'Michael', 'David', 'Male', '2008-09-30', 'Tinaan, Minglanilla, Cebu', '09123456785', 'michael@example.com', 'High School', 'Grade 8', 'Banana', '', '/SGRMS/profile/circle-user.png'),
(6, 'SCC-25-00000006', '', 'Garcia', 'Linda', 'Maria', 'Female', '2007-02-14', 'Poblacion, Talisay, Cebu', '09123456786', 'linda@example.com', 'College', '2nd Year', '', 'BS Information Technology', '/SGRMS/profile/circle-user.png'),
(7, 'SCC-25-00000007', '', 'Miller', 'Robert', 'Joseph', 'Male', '2006-06-25', 'San Isidro, Naga, Cebu', '09123456787', 'robert@example.com', 'College', '3rd Year', '', 'BS Nursing', '/SGRMS/profile/circle-user.png'),
(8, 'SCC-25-00000008', '', 'Davis', 'Jennifer', 'Susan', 'Female', '2005-10-12', 'Maghaway, Talisay, Cebu', '09123456788', 'jennifer@example.com', 'College', '4th Year', '', 'BS Education', '/SGRMS/profile/circle-user.png'),
(9, 'SCC-25-00000009', '', 'Rodriguez', 'William', 'Thomas', 'Male', '2004-04-05', 'Sangi, Minglanilla, Cebu', '09123456789', 'william@example.com', 'Elementary', 'Grade 2', 'Blue', '', '/SGRMS/profile/circle-user.png'),
(10, 'SCC-25-00000010', '', 'Martinez', 'Elizabeth', 'Karen', 'Female', '2003-08-20', 'San Roque, Naga, Cebu', '09123456790', 'elizabeth@example.com', 'High School', 'Grade 9', 'Cherry', '', '/SGRMS/profile/circle-user.png'),
(11, 'SCC-25-00000011', '', 'Hernandez', 'David', 'Paul', 'Male', '2002-12-01', 'Poblacion, Talisay, Cebu', '09123456791', 'david@example.com', 'College', '1st Year', '', 'BS Business Administration', '/SGRMS/profile/circle-user.png'),
(12, 'SCC-25-00000012', '', 'Lopez', 'Barbara', 'Nancy', 'Female', '2001-03-15', 'San Isidro, Naga, Cebu', '09123456792', 'barbara@example.com', 'Elementary', 'Grade 4', 'Yellow', '', '/SGRMS/profile/circle-user.png'),
(13, 'SCC-25-00000013', '', 'Gonzalez', 'Richard', 'Charles', 'Male', '2000-07-22', 'Maghaway, Talisay, Cebu', '09123456793', 'richard@example.com', 'High School', 'Grade 10', 'Durian', '', '/SGRMS/profile/circle-user.png'),
(14, 'SCC-25-00000014', '', 'Wilson', 'Jessica', 'Lisa', 'Female', '1999-11-10', 'Sangi, Minglanilla, Cebu', '09123456794', 'jessica@example.com', 'High School', 'Grade 11', 'Elderberry', '', '/SGRMS/profile/circle-user.png'),
(15, 'SCC-25-00000015', '', 'Anderson', 'Joseph', 'Daniel', 'Male', '1998-05-18', 'San Roque, Naga, Cebu', '09123456795', 'joseph@example.com', 'College', '2nd Year', '', 'BS Computer Science', '/SGRMS/profile/circle-user.png'),
(16, 'SCC-25-00000016', '', 'Taylor', 'Sarah', 'Michelle', 'Female', '2012-03-15', 'Lipata, Minglanilla, Cebu', '09123456796', 'sarah@example.com', 'Elementary', 'Grade 1', 'Red', '', '/SGRMS/profile/circle-user.png'),
(17, 'SCC-25-00000017', '', 'Thomas', 'Charles', 'Christopher', 'Male', '2011-07-22', 'Lawaan, Talisay, Cebu', '09123456797', 'charles@example.com', 'Elementary', 'Grade 2', 'Blue', '', '/SGRMS/profile/circle-user.png'),
(18, 'SCC-25-00000018', '', 'Moore', 'Karen', 'Patricia', 'Female', '2010-11-10', 'Uling, Naga, Cebu', '09123456798', 'karen@example.com', 'High School', 'Grade 7', 'Apple', '', '/SGRMS/profile/circle-user.png'),
(19, 'SCC-25-00000019', '', 'Jackson', 'Matthew', 'Anthony', 'Male', '2009-05-18', 'Tungkil, Minglanilla, Cebu', '09123456799', 'matthew@example.com', 'High School', 'Grade 8', 'Banana', '', '/SGRMS/profile/circle-user.png'),
(20, 'SCC-25-00000020', '', 'White', 'Nancy', 'Laura', 'Female', '2008-09-30', 'Tinaan, Minglanilla, Cebu', '09123456800', 'nancy@example.com', 'College', '3rd Year', '', 'BS Nursing', '/SGRMS/profile/circle-user.png'),
(21, 'SCC-25-00000021', '', 'Harris', 'Donald', 'Mark', 'Male', '2007-02-14', 'Poblacion, Talisay, Cebu', '09123456801', 'donald@example.com', 'Elementary', 'Grade 3', 'Green', '', '/SGRMS/profile/circle-user.png'),
(22, 'SCC-25-00000022', '', 'Martin', 'Betty', 'Dorothy', 'Female', '2006-06-25', 'San Isidro, Naga, Cebu', '09123456802', 'betty@example.com', 'High School', 'Grade 9', 'Cherry', '', '/SGRMS/profile/circle-user.png'),
(23, 'SCC-25-00000023', '', 'Thompson', 'Paul', 'Steven', 'Male', '2005-10-12', 'Maghaway, Talisay, Cebu', '09123456803', 'paul@example.com', 'College', '4th Year', '', 'BS Education', '/SGRMS/profile/circle-user.png'),
(24, 'SCC-25-00000024', '', 'Garcia', 'Sandra', 'Helen', 'Female', '2004-04-05', 'Sangi, Minglanilla, Cebu', '09123456804', 'sandra@example.com', 'Elementary', 'Grade 4', 'Yellow', '', '/SGRMS/profile/circle-user.png'),
(25, 'SCC-25-00000025', '', 'Martinez', 'George', 'Kenneth', 'Male', '2003-08-20', 'San Roque, Naga, Cebu', '09123456805', 'george@example.com', 'High School', 'Grade 10', 'Durian', '', '/SGRMS/profile/circle-user.png'),
(26, 'SCC-25-00000026', '', 'Robinson', 'Emily', 'Sharon', 'Female', '2002-12-01', 'Poblacion, Talisay, Cebu', '09123456806', 'emily@example.com', 'College', '1st Year', '', 'BS Business Administration', '/SGRMS/profile/circle-user.png'),
(27, 'SCC-25-00000027', '', 'Clark', 'Edward', 'Brian', 'Male', '2001-03-15', 'San Isidro, Naga, Cebu', '09123456807', 'edward@example.com', 'Elementary', 'Grade 5', 'Orange', '', '/SGRMS/profile/circle-user.png'),
(28, 'SCC-25-00000028', '', 'Lewis', 'Donna', 'Carol', 'Female', '2000-07-22', 'Maghaway, Talisay, Cebu', '09123456808', 'donna@example.com', 'High School', 'Grade 11', 'Elderberry', '', '/SGRMS/profile/circle-user.png'),
(29, 'SCC-25-00000029', '', 'Lee', 'Ronald', 'Jason', 'Male', '1999-11-10', 'Sangi, Minglanilla, Cebu', '09123456809', 'ronald@example.com', 'College', '2nd Year', '', 'BS Computer Science', '/SGRMS/profile/circle-user.png'),
(30, 'SCC-25-00000030', '', 'Walker', 'Susan', 'Margaret', 'Female', '1998-05-18', 'San Roque, Naga, Cebu', '09123456810', 'susan@example.com', 'Elementary', 'Grade 1', 'Red', '', '/SGRMS/profile/circle-user.png'),
(31, 'SCC-25-00000031', '', 'Hall', 'Kevin', 'Timothy', 'Male', '2012-03-15', 'Lipata, Minglanilla, Cebu', '09123456811', 'kevin@example.com', 'High School', 'Grade 7', 'Apple', '', '/SGRMS/profile/circle-user.png'),
(32, 'SCC-25-00000032', '', 'Allen', 'Kimberly', 'Deborah', 'Female', '2011-07-22', 'Lawaan, Talisay, Cebu', '09123456812', 'kimberly@example.com', 'College', '3rd Year', '', 'BS Nursing', '/SGRMS/profile/circle-user.png'),
(33, 'SCC-25-00000033', '', 'Young', 'Thomas', 'Jeffrey', 'Male', '2010-11-10', 'Uling, Naga, Cebu', '09123456813', 'thomas@example.com', 'Elementary', 'Grade 2', 'Blue', '', '/SGRMS/profile/circle-user.png'),
(34, 'SCC-25-00000034', '', 'King', 'Angela', 'Ruth', 'Female', '2009-05-18', 'Tungkil, Minglanilla, Cebu', '09123456814', 'angela@example.com', 'High School', 'Grade 8', 'Banana', '', '/SGRMS/profile/circle-user.png'),
(35, 'SCC-25-00000035', '', 'Wright', 'Steven', 'Ryan', 'Male', '2008-09-30', 'Tinaan, Minglanilla, Cebu', '09123456815', 'steven@example.com', 'College', '4th Year', '', 'BS Education', '/SGRMS/profile/circle-user.png'),
(36, 'SCC-25-00000036', '', 'Scott', 'Dorothy', 'Shirley', 'Female', '2007-02-14', 'Poblacion, Talisay, Cebu', '09123456816', 'dorothy@example.com', 'Elementary', 'Grade 3', 'Green', '', '/SGRMS/profile/circle-user.png'),
(37, 'SCC-25-00000037', '', 'Green', 'Joshua', 'Gary', 'Male', '2006-06-25', 'San Isidro, Naga, Cebu', '09123456817', 'joshua@example.com', 'High School', 'Grade 9', 'Cherry', '', '/SGRMS/profile/circle-user.png'),
(38, 'SCC-25-00000038', '', 'Baker', 'Helen', 'Anna', 'Female', '2005-10-12', 'Maghaway, Talisay, Cebu', '09123456818', 'helen@example.com', 'College', '1st Year', '', 'BS Business Administration', '/SGRMS/profile/circle-user.png'),
(39, 'SCC-25-00000039', '', 'Adams', 'Eric', 'Nicholas', 'Male', '2004-04-05', 'Sangi, Minglanilla, Cebu', '09123456819', 'eric@example.com', 'Elementary', 'Grade 4', 'Yellow', '', '/SGRMS/profile/circle-user.png'),
(40, 'SCC-25-00000040', '', 'Nelson', 'Carol', 'Brenda', 'Female', '2003-08-20', 'San Roque, Naga, Cebu', '09123456820', 'carol@example.com', 'High School', 'Grade 10', 'Durian', '', '/SGRMS/profile/circle-user.png'),
(41, 'SCC-25-00000041', '', 'Carter', 'Jason', 'Justin', 'Male', '2002-12-01', 'Poblacion, Talisay, Cebu', '09123456821', 'jason@example.com', 'College', '2nd Year', '', 'BS Computer Science', '/SGRMS/profile/circle-user.png'),
(42, 'SCC-25-00000042', '', 'Mitchell', 'Amy', 'Virginia', 'Female', '2001-03-15', 'San Isidro, Naga, Cebu', '09123456822', 'amy@example.com', 'Elementary', 'Grade 5', 'Orange', '', '/SGRMS/profile/circle-user.png'),
(43, 'SCC-25-00000043', '', 'Perez', 'Rebecca', 'Katherine', 'Female', '2000-07-22', 'Maghaway, Talisay, Cebu', '09123456823', 'rebecca@example.com', 'High School', 'Grade 11', 'Elderberry', '', '/SGRMS/profile/circle-user.png'),
(44, 'SCC-25-00000044', '', 'Roberts', 'Brandon', 'Adam', 'Male', '1999-11-10', 'Sangi, Minglanilla, Cebu', '09123456824', 'brandon@example.com', 'College', '3rd Year', '', 'BS Nursing', '/SGRMS/profile/circle-user.png'),
(45, 'SCC-25-00000045', '', 'Turner', 'Sharon', 'Pamela', 'Female', '1998-05-18', 'San Roque, Naga, Cebu', '09123456825', 'sharon@example.com', 'Elementary', 'Grade 1', 'Red', '', '/SGRMS/profile/circle-user.png'),
(46, 'SCC-25-00000046', '', 'Phillips', 'Jonathan', 'Patrick', 'Male', '2012-03-15', 'Lipata, Minglanilla, Cebu', '09123456826', 'jonathan@example.com', 'High School', 'Grade 7', 'Apple', '', '/SGRMS/profile/circle-user.png'),
(47, 'SCC-25-00000047', '', 'Campbell', 'Cynthia', 'Kathleen', 'Female', '2011-07-22', 'Lawaan, Talisay, Cebu', '09123456827', 'cynthia@example.com', 'College', '4th Year', '', 'BS Education', '/SGRMS/profile/circle-user.png'),
(48, 'SCC-25-00000048', '', 'Parker', 'Samuel', 'Benjamin', 'Male', '2010-11-10', 'Uling, Naga, Cebu', '09123456828', 'samuel@example.com', 'Elementary', 'Grade 2', 'Blue', '', '/SGRMS/profile/circle-user.png'),
(49, 'SCC-25-00000049', '', 'Evans', 'Deborah', 'Rachel', 'Female', '2009-05-18', 'Tungkil, Minglanilla, Cebu', '09123456829', 'deborah@example.com', 'High School', 'Grade 8', 'Banana', '', '/SGRMS/profile/circle-user.png'),
(50, 'SCC-25-00000050', '', 'Edwards', 'Frank', 'Gregory', 'Male', '2008-09-30', 'Tinaan, Minglanilla, Cebu', '09123456830', 'frank@example.com', 'College', '1st Year', '', 'BS Business Administration', '/SGRMS/profile/circle-user.png'),
(51, 'SCC-25-00000051', '', 'Gonzales', 'Carlos', 'Manuel', 'Male', '2012-03-15', 'Lipata, Minglanilla, Cebu', '09123456851', 'carlos@example.com', 'Elementary', 'Grade 1', 'Red', '', '/SGRMS/profile/circle-user.png'),
(52, 'SCC-25-00000052', '', 'Reyes', 'Ana', 'Marie', 'Female', '2011-07-22', 'Lawaan, Talisay, Cebu', '09123456852', 'ana@example.com', 'College', '1st Year', '', 'BS Computer Science', '/SGRMS/profile/circle-user.png'),
(53, 'SCC-25-00000053', '', 'Torres', 'Luis', 'Antonio', 'Male', '2010-11-10', 'Uling, Naga, Cebu', '09123456853', 'luis@example.com', 'Elementary', 'Grade 3', 'Green', '', '/SGRMS/profile/circle-user.png'),
(54, 'SCC-25-00000054', '', 'Cruz', 'Maria', 'Sofia', 'Female', '2009-05-18', 'Tungkil, Minglanilla, Cebu', '09123456854', 'maria@example.com', 'High School', 'Grade 7', 'Apple', '', '/SGRMS/profile/circle-user.png'),
(55, 'SCC-25-00000055', '', 'Santos', 'Jose', 'Miguel', 'Male', '2008-09-30', 'Tinaan, Minglanilla, Cebu', '09123456855', 'jose@example.com', 'High School', 'Grade 8', 'Banana', '', '/SGRMS/profile/circle-user.png'),
(56, 'SCC-25-00000056', '', 'Fernandez', 'Carmen', 'Isabel', 'Female', '2007-02-14', 'Poblacion, Talisay, Cebu', '09123456856', 'carmen@example.com', 'College', '2nd Year', '', 'BS Information Technology', '/SGRMS/profile/circle-user.png'),
(57, 'SCC-25-00000057', '', 'Gomez', 'Juan', 'Carlos', 'Male', '2006-06-25', 'San Isidro, Naga, Cebu', '09123456857', 'juan@example.com', 'College', '3rd Year', '', 'BS Nursing', '/SGRMS/profile/circle-user.png'),
(58, 'SCC-25-00000058', '', 'Diaz', 'Elena', 'Patricia', 'Female', '2005-10-12', 'Maghaway, Talisay, Cebu', '09123456858', 'elena@example.com', 'College', '4th Year', '', 'BS Education', '/SGRMS/profile/circle-user.png'),
(59, 'SCC-25-00000059', '', 'Lopez', 'Pedro', 'Jose', 'Male', '2004-04-05', 'Sangi, Minglanilla, Cebu', '09123456859', 'pedro@example.com', 'Elementary', 'Grade 2', 'Blue', '', '/SGRMS/profile/circle-user.png'),
(60, 'SCC-25-00000060', '', 'Martinez', 'Laura', 'Gabriela', 'Female', '2003-08-20', 'San Roque, Naga, Cebu', '09123456860', 'laura@example.com', 'High School', 'Grade 9', 'Cherry', '', '/SGRMS/profile/circle-user.png'),
(61, 'SCC-25-00000061', '', 'Perez', 'Ricardo', 'Alberto', 'Male', '2002-12-01', 'Poblacion, Talisay, Cebu', '09123456861', 'ricardo@example.com', 'College', '1st Year', '', 'BS Business Administration', '/SGRMS/profile/circle-user.png'),
(62, 'SCC-25-00000062', '', 'Gutierrez', 'Sofia', 'Beatriz', 'Female', '2001-03-15', 'San Isidro, Naga, Cebu', '09123456862', 'sofia@example.com', 'Elementary', 'Grade 4', 'Yellow', '', '/SGRMS/profile/circle-user.png'),
(63, 'SCC-25-00000063', '', 'Herrera', 'Miguel', 'Angel', 'Male', '2000-07-22', 'Maghaway, Talisay, Cebu', '09123456863', 'miguel@example.com', 'High School', 'Grade 10', 'Durian', '', '/SGRMS/profile/circle-user.png'),
(64, 'SCC-25-00000064', '', 'Jimenez', 'Isabella', 'Camila', 'Female', '1999-11-10', 'Sangi, Minglanilla, Cebu', '09123456864', 'isabella@example.com', 'High School', 'Grade 11', 'Elderberry', '', '/SGRMS/profile/circle-user.png'),
(65, 'SCC-25-00000065', '', 'Moreno', 'Alejandro', 'Javier', 'Male', '1998-05-18', 'San Roque, Naga, Cebu', '09123456865', 'alejandro@example.com', 'College', '2nd Year', '', 'BS Computer Science', '/SGRMS/profile/circle-user.png'),
(66, 'SCC-25-00000066', '', 'Romero', 'Valentina', 'Lucia', 'Female', '2012-03-15', 'Lipata, Minglanilla, Cebu', '09123456866', 'valentina@example.com', 'Elementary', 'Grade 1', 'Red', '', '/SGRMS/profile/circle-user.png'),
(67, 'SCC-25-00000067', '', 'Alvarez', 'Diego', 'Fernando', 'Male', '2011-07-22', 'Lawaan, Talisay, Cebu', '09123456867', 'diego@example.com', 'Elementary', 'Grade 2', 'Blue', '', '/SGRMS/profile/circle-user.png'),
(68, 'SCC-25-00000068', '', 'Ruiz', 'Daniela', 'Mariana', 'Female', '2010-11-10', 'Uling, Naga, Cebu', '09123456868', 'daniela@example.com', 'High School', 'Grade 7', 'Apple', '', '/SGRMS/profile/circle-user.png'),
(69, 'SCC-25-00000069', '', 'Molina', 'Santiago', 'Mateo', 'Male', '2009-05-18', 'Tungkil, Minglanilla, Cebu', '09123456869', 'santiago@example.com', 'High School', 'Grade 8', 'Banana', '', '/SGRMS/profile/circle-user.png'),
(70, 'SCC-25-00000070', '', 'Ortega', 'Valeria', 'Emilia', 'Female', '2008-09-30', 'Tinaan, Minglanilla, Cebu', '09123456870', 'valeria@example.com', 'College', '3rd Year', '', 'BS Nursing', '/SGRMS/profile/circle-user.png'),
(71, 'SCC-25-00000071', '', 'Castillo', 'Adrian', 'Sebastian', 'Male', '2007-02-14', 'Poblacion, Talisay, Cebu', '09123456871', 'adrian@example.com', 'Elementary', 'Grade 3', 'Green', '', '/SGRMS/profile/circle-user.png'),
(72, 'SCC-25-00000072', '', 'Ramos', 'Camila', 'Renata', 'Female', '2006-06-25', 'San Isidro, Naga, Cebu', '09123456872', 'camila@example.com', 'High School', 'Grade 9', 'Cherry', '', '/SGRMS/profile/circle-user.png'),
(73, 'SCC-25-00000073', '', 'Vargas', 'Nicolas', 'Leonardo', 'Male', '2005-10-12', 'Maghaway, Talisay, Cebu', '09123456873', 'nicolas@example.com', 'College', '4th Year', '', 'BS Education', '/SGRMS/profile/circle-user.png'),
(74, 'SCC-25-00000074', '', 'Flores', 'Antonella', 'Regina', 'Female', '2004-04-05', 'Sangi, Minglanilla, Cebu', '09123456874', 'antonella@example.com', 'Elementary', 'Grade 4', 'Yellow', '', '/SGRMS/profile/circle-user.png'),
(75, 'SCC-25-00000075', '', 'Guzman', 'Emilio', 'Rafael', 'Male', '2003-08-20', 'San Roque, Naga, Cebu', '09123456875', 'emilio@example.com', 'High School', 'Grade 10', 'Durian', '', '/SGRMS/profile/circle-user.png'),
(76, 'SCC-25-00000076', '', 'Herrera', 'Sara', 'Isabel', 'Female', '2002-12-01', 'Poblacion, Talisay, Cebu', '09123456876', 'sara@example.com', 'College', '1st Year', '', 'BS Business Administration', '/SGRMS/profile/circle-user.png'),
(77, 'SCC-25-00000077', '', 'Luna', 'Lucas', 'Matias', 'Male', '2001-03-15', 'San Isidro, Naga, Cebu', '09123456877', 'lucas@example.com', 'Elementary', 'Grade 5', 'Orange', '', '/SGRMS/profile/circle-user.png'),
(78, 'SCC-25-00000078', '', 'Mendez', 'Emma', 'Victoria', 'Female', '2000-07-22', 'Maghaway, Talisay, Cebu', '09123456878', 'emma@example.com', 'High School', 'Grade 11', 'Elderberry', '', '/SGRMS/profile/circle-user.png'),
(79, 'SCC-25-00000079', '', 'Navarro', 'Daniel', 'Gabriel', 'Male', '1999-11-10', 'Sangi, Minglanilla, Cebu', '09123456879', 'daniel@example.com', 'College', '2nd Year', '', 'BS Computer Science', '/SGRMS/profile/circle-user.png'),
(80, 'SCC-25-00000080', '', 'Ortiz', 'Olivia', 'Sofia', 'Female', '1998-05-18', 'San Roque, Naga, Cebu', '09123456880', 'olivia@example.com', 'Elementary', 'Grade 1', 'Red', '', '/SGRMS/profile/circle-user.png');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `t_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `mname` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `teach_level` enum('Elementary','High School','College') NOT NULL,
  `year_level` varchar(50) DEFAULT NULL,
  `section` varchar(50) DEFAULT NULL,
  `program` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`t_id`, `u_id`, `lname`, `fname`, `mname`, `email`, `phone`, `teach_level`, `year_level`, `section`, `program`) VALUES
(1, 2, 'Romano', 'Ashlyn', 'Batol', 'ashlyn@gmail.com', '09457000308', 'Elementary', 'Grade 1', 'Red', ''),
(2, 3, 'Romano', 'David', 'Villondo', 'david@gmail.com', '09817970638', 'College', '1st Year', '', 'BSIT'),
(3, 4, 'Smith', 'John', 'Doe', 'john.smith@gmail.com', '09123456789', 'Elementary', 'Grade 2', 'Blue', ''),
(4, 5, 'Johnson', 'Emily', 'Clark', 'emily.johnson@gmail.com', '09234567890', 'High School', 'Grade 11', 'Apple', ''),
(5, 6, 'Williams', 'Michael', 'Brown', 'michael.williams@gmail.com', '09345678901', 'Elementary', 'Grade 3', 'Green', ''),
(6, 7, 'Jones', 'Sarah', 'Davis', 'sarah.jones@gmail.com', '09456789012', 'High School', 'Grade 11', 'Banana', ''),
(7, 8, 'Garcia', 'Jessica', 'Martinez', 'jessica.garcia@gmail.com', '09567890123', 'Elementary', 'Grade 4', 'Yellow', ''),
(8, 9, 'Martinez', 'Daniel', 'Hernandez', 'daniel.martinez@gmail.com', '09678901234', 'College', '2nd Year', '', 'BSBA'),
(9, 10, 'Rodriguez', 'Laura', 'Lopez', 'laura.rodriguez@gmail.com', '09789012345', 'High School', 'Grade 10', 'Grapes', ''),
(10, 11, 'Wilson', 'Kevin', 'Anderson', 'kevin.wilson@gmail.com', '09890123456', 'Elementary', 'Grade 5', 'Purple', ''),
(11, 12, 'Taylor', 'Sophia', 'Nguyen', 'sophia.taylor@gmail.com', '09901234567', 'Elementary', 'Grade 6', 'Orange', ''),
(12, 13, 'Brown', 'Liam', 'Johnson', 'liam.brown@gmail.com', '09012345678', 'High School', 'Grade 7', 'Mango', ''),
(13, 14, 'Davis', 'Olivia', 'Martinez', 'olivia.davis@gmail.com', '09123456789', 'High School', 'Grade 8', 'Pineapple', ''),
(14, 15, 'Miller', 'James', 'Wilson', 'james.miller@gmail.com', '09234567890', 'College', '3rd Year', '', 'BSED'),
(15, 16, 'Wilson', 'Emma', 'Garcia', 'emma.wilson@gmail.com', '09345678901', 'College', '4th Year', '', 'BSBA'),
(16, 17, 'Abendan', 'Christine Jean', 'Arquilos', 'christine@gmail.com', '09193622447', 'College', '1st Year', '', 'BSIT');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `u_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('Active','Pending') NOT NULL DEFAULT 'Pending',
  `role` enum('Head Guidance','Guidance Counselor','Teacher') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `username`, `password`, `status`, `role`) VALUES
(1, 'headguidance', '$2y$10$s3e3fuEZShWuYA4s05VW6.IB6ke3b0NbBEzzGMFzk3sNDzgyt1UGS', 'Active', 'Head Guidance'),
(2, 'ashlyn', '$2y$10$5P8FL21PgkA5AUCjSH8Rd.pyMKbIzIacuRe0J4zcHSYSRDF8ApmeO', 'Pending', 'Teacher'),
(3, 'david', '$2y$10$s3e3fuEZShWuYA4s05VW6.IB6ke3b0NbBEzzGMFzk3sNDzgyt1UGS', 'Pending', 'Teacher'),
(4, 'john', '$2y$10$s3e3fuEZShWuYA4s05VW6.IB6ke3b0NbBEzzGMFzk3sNDzgyt1UGS', 'Pending', 'Teacher'),
(5, 'emily', '$2y$10$s3e3fuEZShWuYA4s05VW6.IB6ke3b0NbBEzzGMFzk3sNDzgyt1UGS', 'Pending', 'Teacher'),
(6, 'michael', '$2y$10$s3e3fuEZShWuYA4s05VW6.IB6ke3b0NbBEzzGMFzk3sNDzgyt1UGS', 'Pending', 'Teacher'),
(7, 'sarah', '$2y$10$s3e3fuEZShWuYA4s05VW6.IB6ke3b0NbBEzzGMFzk3sNDzgyt1UGS', 'Pending', 'Teacher'),
(8, 'jessica', '$2y$10$s3e3fuEZShWuYA4s05VW6.IB6ke3b0NbBEzzGMFzk3sNDzgyt1UGS', 'Pending', 'Teacher'),
(9, 'daniel', '$2y$10$s3e3fuEZShWuYA4s05VW6.IB6ke3b0NbBEzzGMFzk3sNDzgyt1UGS', 'Pending', 'Teacher'),
(10, 'laura', '$2y$10$s3e3fuEZShWuYA4s05VW6.IB6ke3b0NbBEzzGMFzk3sNDzgyt1UGS', 'Pending', 'Teacher'),
(11, 'kevin', '$2y$10$s3e3fuEZShWuYA4s05VW6.IB6ke3b0NbBEzzGMFzk3sNDzgyt1UGS', 'Pending', 'Teacher'),
(12, 'sophia', '$2y$10$s3e3fuEZShWuYA4s05VW6.IB6ke3b0NbBEzzGMFzk3sNDzgyt1UGS', 'Pending', 'Teacher'),
(13, 'liam', '$2y$10$s3e3fuEZShWuYA4s05VW6.IB6ke3b0NbBEzzGMFzk3sNDzgyt1UGS', 'Pending', 'Teacher'),
(14, 'olivia', '$2y$10$s3e3fuEZShWuYA4s05VW6.IB6ke3b0NbBEzzGMFzk3sNDzgyt1UGS', 'Pending', 'Teacher'),
(15, 'james', '$2y$10$s3e3fuEZShWuYA4s05VW6.IB6ke3b0NbBEzzGMFzk3sNDzgyt1UGS', 'Pending', 'Teacher'),
(16, 'emma', '$2y$10$s3e3fuEZShWuYA4s05VW6.IB6ke3b0NbBEzzGMFzk3sNDzgyt1UGS', 'Pending', 'Teacher'),
(17, 'christine', '$2y$10$Gix.MS4NvKf6swjUboIG6eo6aOfwgORzX0jgmJOHN.my1rfA/jGG6', 'Pending', 'Teacher'),
(18, 'john', '$2y$10$s3e3fuEZShWuYA4s05VW6.IB6ke3b0NbBEzzGMFzk3sNDzgyt1UGS', 'Active', 'Guidance Counselor'),
(19, 'jane', '$2y$10$s3e3fuEZShWuYA4s05VW6.IB6ke3b0NbBEzzGMFzk3sNDzgyt1UGS', 'Active', 'Guidance Counselor'),
(20, 'michael', '$2y$10$s3e3fuEZShWuYA4s05VW6.IB6ke3b0NbBEzzGMFzk3sNDzgyt1UGS', 'Active', 'Guidance Counselor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `case_records`
--
ALTER TABLE `case_records`
  ADD PRIMARY KEY (`case_id`);

--
-- Indexes for table `counselors`
--
ALTER TABLE `counselors`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `u_id` (`u_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`s_id`),
  ADD UNIQUE KEY `id_num` (`id_num`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`t_id`),
  ADD KEY `u_id` (`u_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `case_records`
--
ALTER TABLE `case_records`
  MODIFY `case_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `counselors`
--
ALTER TABLE `counselors`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `t_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `counselors`
--
ALTER TABLE `counselors`
  ADD CONSTRAINT `counselors_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `users` (`u_id`) ON DELETE CASCADE;

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `users` (`u_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
