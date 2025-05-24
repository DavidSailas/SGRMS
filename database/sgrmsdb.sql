-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2025 at 06:45 PM
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
  `timestamp` datetime DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `id` int(11) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `requester_name` varchar(100) NOT NULL,
  `requester_type` enum('parent','teacher') NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `reason` text NOT NULL,
  `status` enum('pending','approved','completed','canceled') DEFAULT 'pending',
  `counselor_notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appointment_history`
--

CREATE TABLE `appointment_history` (
  `id` int(11) NOT NULL,
  `appointment_id` int(11) DEFAULT NULL,
  `action` enum('created','approved','rescheduled','canceled','completed') NOT NULL,
  `old_date` date DEFAULT NULL,
  `old_time` time DEFAULT NULL,
  `new_date` date DEFAULT NULL,
  `new_time` time DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `action_by` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `case_records`
--

CREATE TABLE `case_records` (
  `case_id` int(11) NOT NULL,
  `case_type` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `reported_by` varchar(100) NOT NULL,
  `referred_by` varchar(100) NOT NULL,
  `referral_date` datetime NOT NULL,
  `reason_for_referral` varchar(100) NOT NULL,
  `presenting_problem` varchar(100) NOT NULL,
  `observe_behavior` text NOT NULL,
  `family_background` varchar(100) NOT NULL,
  `academic_history` varchar(100) NOT NULL,
  `social_relationships` varchar(100) NOT NULL,
  `medical_history` varchar(500) NOT NULL,
  `counselor_assessment` varchar(500) NOT NULL,
  `recommendations` varchar(500) NOT NULL,
  `follow_up_plan` varchar(500) NOT NULL,
  `filed_date` date NOT NULL DEFAULT curdate(),
  `filed_time` time NOT NULL DEFAULT curtime(),
  `status` varchar(50) NOT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `case_records`
--

INSERT INTO `case_records` (`case_id`, `case_type`, `description`, `reported_by`, `referred_by`, `referral_date`, `reason_for_referral`, `presenting_problem`, `observe_behavior`, `family_background`, `academic_history`, `social_relationships`, `medical_history`, `counselor_assessment`, `recommendations`, `follow_up_plan`, `filed_date`, `filed_time`, `status`, `student_id`) VALUES
(3, 'Peer Conflict', 'A consequatur Dolor', 'Architecto voluptate', 'Doloremque sed corru', '2001-02-28 00:00:00', 'Molestiae irure eius', 'Nulla praesentium al', 'Nulla sunt sit dolo', 'Consequat Pariatur', 'Nesciunt laborum D', 'Lorem aute officia i', 'Laudantium voluptas', 'Adipisci hic reprehe', 'Incidunt nisi aliqu', 'Eos nulla voluptate', '2025-05-21', '01:56:30', 'Archived', 1),
(4, 'Academic', 'Neque sunt deserunt ', 'Ullamco velit cum p', 'Voluptate id iste qu', '1973-05-20 00:00:00', 'Rerum corporis nostr', 'Sed dolore nobis ali', 'Temporibus laborum ', 'Aliqua Obcaecati po', 'Omnis enim expedita ', 'Blanditiis explicabo', 'Minus nisi ut exerci', 'Ducimus ullam dolor', 'Nihil error eiusmod ', 'Qui incidunt simili', '2025-05-21', '02:03:02', 'Pending', 1),
(5, 'Emotional', 'Lorem cupiditate quo', 'Consequatur aut rat', 'Sit corporis rerum ', '2018-02-10 00:00:00', 'Quae molestiae ad fu', 'Duis sit sint dicta', 'Nihil quo quis aperi', 'Et excepteur ratione', 'Ex est eum dolore co', 'Est consequatur eos', 'Sint provident dolo', 'Ex consequatur persp', 'Excepturi inventore ', 'Occaecat laborum Qu', '2025-05-21', '02:03:16', 'Resolved', 2),
(6, 'Emotional', 'Anim consequatur ius', 'Quia qui consequatur', 'Minim dicta ut perfe', '2015-10-30 00:00:00', 'Commodo voluptatibus', 'Modi voluptatum veni', 'Ut sequi officiis co', 'Voluptatum eum illo ', 'Voluptatem Officia ', 'Omnis sint ut accusa', 'Officia autem distin', 'Impedit aut occaeca', 'Cum Nam ipsa debiti', 'Commodo non officiis', '2025-05-21', '02:03:34', 'Resolved', 1),
(7, 'Emotional', 'Velit non dolor veni', 'Blanditiis autem id ', 'Aliquip tenetur et s', '2005-09-10 00:00:00', 'Illum irure enim ir', 'Ut quasi Nam sint o', 'Neque qui earum volu', 'Labore aliquip elit', 'Aperiam dicta facere', 'Dicta hic aliquid do', 'Debitis dolore magna', 'Nisi velit sit est', 'Optio dolore simili', 'Et qui dignissimos s', '2025-05-21', '02:03:53', 'Pending', 4),
(8, 'Behavioral', 'Tempora animi excep', 'In illo beatae dolor', 'Quia qui et fugiat e', '1988-12-22 00:00:00', 'Et quia libero amet', 'Quos accusantium fac', 'Duis possimus deser', 'Dolore iusto quos op', 'Omnis voluptatem pr', 'Ipsam iste sed exped', 'Cum sit in velit no', 'Velit magnam cupidi', 'Labore tenetur ex vo', 'Vero molestiae dolor', '2025-05-21', '02:04:37', 'Resolved', 4);

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
  `c_level` varchar(50) NOT NULL,
  `c_image` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `counselors`
--

INSERT INTO `counselors` (`c_id`, `lname`, `fname`, `mname`, `contact_num`, `email`, `c_level`, `c_image`) VALUES
(1, 'Amena Rodriguez', 'Alyssa Mclean', 'Bruce Chavez', 'Et aut ea voluptate', 'vekuw@mailinator.com', 'High School', ''),
(2, 'Romano', 'David Sailas', 'Villondo', '09123456789', 'chebry28@gmail.com', 'College', ''),
(3, 'Romano', 'Ashlyn', 'Batol', '09123456789', 'ashlyn@gmail.com', 'Elementary', '');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `message`, `timestamp`, `is_read`, `user_id`) VALUES
(1, 'A new case of type \'Peer Conflict\' has been filed for student Cole, Jescie (ID: SCC-25-00000001).', '2025-05-20 13:56:30', 1, NULL),
(2, 'A new case of type \'Academic\' has been filed for student Cole, Jescie (ID: SCC-25-00000001).', '2025-05-20 14:03:02', 1, NULL),
(3, 'A new case of type \'Emotional\' has been filed for student Buchanan, Jonas (ID: SCC-25-00000002).', '2025-05-20 14:03:16', 1, NULL),
(4, 'A new case of type \'Emotional\' has been filed for student Cole, Jescie (ID: SCC-25-00000001).', '2025-05-20 14:03:34', 1, NULL),
(5, 'A new case of type \'Emotional\' has been filed for student Donovan, Drake (ID: SCC-25-00000004).', '2025-05-20 14:03:53', 1, NULL),
(6, 'A new case of type \'Behavioral\' has been filed for student Donovan, Drake (ID: SCC-25-00000004).', '2025-05-20 14:04:37', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `parents`
--

CREATE TABLE `parents` (
  `p_id` int(11) NOT NULL,
  `guardian_name` varchar(100) NOT NULL,
  `relationship` varchar(50) NOT NULL,
  `contact_num` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parents`
--

INSERT INTO `parents` (`p_id`, `guardian_name`, `relationship`, `contact_num`, `email`) VALUES
(1, 'Hamilton Simon', 'Est cupidatat eveni', 'Laborum Pariatur E', 'palygudozo@mailinator.com'),
(2, 'Miranda Chase', 'Inventore veniam in', 'Autem qui excepturi ', 'sezehebe@mailinator.com'),
(3, 'Oleg Petersen', 'Irure fugit aut vol', 'Et quam corrupti vo', 'voculixyju@mailinator.com'),
(4, 'Lucas Simon', 'Guardain', 'Esse non omnis omnis', 'wodelehyzi@mailinator.com'),
(5, 'Sylvester Santana', 'Voluptates eiusmod d', 'Omnis at laborum dol', 'lugatul@mailinator.com'),
(6, 'Jamal Kirk', 'Odit non qui id et v', 'Perspiciatis atque ', 'varogur@mailinator.com'),
(7, 'Patricia Fowler', 'Quia velit nulla ma', 'Obcaecati deserunt s', 'zopymyha@mailinator.com'),
(8, 'Curran Byers', 'Necessitatibus delen', 'Sequi maxime deserun', 'widoqus@mailinator.com'),
(9, 'Silas Thornton', 'Quia fuga Sit minim', 'Consectetur est fug', 'ritucuviso@mailinator.com'),
(10, 'Charde Nolan', 'Dolor velit id sapie', 'At dolores in totam ', 'saqezudavo@mailinator.com'),
(11, 'Chandler Kirby', 'Assumenda reprehende', 'Enim doloribus lauda', 'cake@mailinator.com'),
(12, 'Sasha Burgess', 'Est tenetur et rerum', 'Et beatae consequatu', 'wyserygiw@mailinator.com'),
(13, 'Macy Farmer', 'Sed ducimus excepte', 'Aut consectetur sapi', 'moxidid@mailinator.com'),
(14, 'Hamilton Simon', 'Est cupidatat eveni', 'Laborum Pariatur E', 'palygudozo@mailinator.com'),
(15, 'Aaron Middleton', 'Guardian', 'Eiusmod adipisci id ', 'mijav@mailinator.com'),
(16, 'Aaron Middleton', 'Guardian', 'Eiusmod adipisci id', 'mijav@mailinator.com'),
(17, 'Lewis Haney', 'Guardian', 'Debitis error consec', 'dyvi@mailinator.com'),
(18, 'Nero Bright', 'Eligendi quas dolore', 'Nisi sed sunt et ut', 'kemyqarev@mailinator.com');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `s_id` int(11) NOT NULL,
  `id_num` varchar(20) NOT NULL,
  `suffix` varchar(10) DEFAULT NULL,
  `lname` varchar(50) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `mname` varchar(50) DEFAULT NULL,
  `sex` enum('Male','Female') NOT NULL,
  `bod` date NOT NULL,
  `address` varchar(100) NOT NULL,
  `mobile_num` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `educ_level` enum('Elementary','High School','College') NOT NULL,
  `year_level` varchar(20) NOT NULL,
  `section` varchar(20) DEFAULT NULL,
  `program` varchar(100) DEFAULT NULL,
  `s_image` varchar(255) NOT NULL,
  `previous_school` varchar(255) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`s_id`, `id_num`, `suffix`, `lname`, `fname`, `mname`, `sex`, `bod`, `address`, `mobile_num`, `email`, `educ_level`, `year_level`, `section`, `program`, `s_image`, `previous_school`, `status`, `parent_id`) VALUES
(1, 'SCC-25-00000001', '', 'Cole', 'Jescie', 'Zephania Preston', 'Male', '1993-05-30', 'Nostrum adipisicing ', 'A consequuntur ', 'qylifeboz@mailinator.com', 'College', '1st Year', '', 'BSIT', '/Public/stud.img/default.png', 'Facere quia maxime e', 'Active', 1),
(2, 'SCC-25-00000002', 'Numquam te', 'Buchanan', 'Jonas', 'Miriam Abbott', 'Female', '1993-02-07', 'Qui ut quo commodo d', 'Eu autem quidem', 'pokoqijepy@mailinator.com', 'High School', 'Grade 9', 'Tempore autem labor', '', '/Public/stud.img/default.png', 'Nulla sequi tempor n', 'Inactive', 2),
(3, 'SCC-25-00000003', 'Et in amet', 'Haney', 'Sylvia', 'Jasper Norman', 'Male', '2023-04-11', 'Ex eius fuga Unde i', 'Ipsam natus ex ', 'pubulorij@mailinator.com', 'Elementary', 'Grade 5', 'Ullam sit delectus', '', '/Public/stud.img/default.png', 'Temporibus qui beata', 'Inactive', 3),
(4, 'SCC-25-00000004', 'Aspernatur', 'Donovan', 'Drake', 'Cyrus Cantu', 'Male', '1978-06-30', 'Eos aut ea omnis ab ', 'Velit voluptati', 'wojajuhoma@mailinator.com', 'Elementary', 'Grade 5', 'Nihil aut ut in qui ', '', '/Public/stud.img/default.png', 'Optio commodo sed e', 'Active', 4),
(5, 'SCC-25-00000005', 'Vel maxime', 'Pitts', 'Solomon', 'Hyacinth Nash', 'Male', '2016-08-30', 'Inventore est ut et ', 'Ea velit maiore', 'felocaj@mailinator.com', 'College', '2nd Year', 'Cupiditate ut aliqua', 'BSIT', '/Public/stud.img/default.png', 'Deserunt consequatur', 'Active', 5),
(6, 'SCC-25-00000006', 'Quaerat qu', 'Wheeler', 'Kaye', 'Lillith Berger', 'Female', '2017-06-19', 'Rerum laborum Neces', 'Qui et enim err', 'tifu@mailinator.com', 'Elementary', 'Grade 2', 'Est rerum et soluta', '', '/Public/stud.img/default.png', 'Aut obcaecati consec', 'Active', 6),
(7, 'SCC-25-00000007', 'Modi sit d', 'Calhoun', 'Garth', 'Latifah Gillespie', 'Male', '1990-04-22', 'Est atque eiusmod s', 'Dolore qui obca', 'hudi@mailinator.com', 'Elementary', 'Grade 4', 'Et ad in sint volupt', '', '/Public/stud.img/default.png', 'Doloremque molestiae', 'Active', 7),
(8, 'SCC-25-00000008', 'Id est har', 'Young', 'Cally', 'Herman Finley', 'Female', '1980-10-09', 'Blanditiis sequi vol', 'Molestias quasi', 'hawahifo@mailinator.com', 'High School', 'Grade 11', 'Corporis minim neque', '', '/Public/stud.img/default.png', 'Cupidatat eos dolor', 'Archived', 9),
(9, 'SCC-25-00000009', 'In sed cum', 'Thornton', 'Kareem', 'Leandra Schroeder', 'Male', '1990-09-04', 'Harum qui atque dolo', 'Repellendus Off', 'sujehuju@mailinator.com', 'College', '2nd Year', 'Accusantium similiqu', '', '/Public/stud.img/default.png', '0', 'Active', 11),
(10, 'SCC-25-00000010', 'Laboris re', 'Cooper', 'Gareth', 'Tucker Phelps', 'Male', '2016-09-22', 'Et fugit recusandae', 'Possimus elit e', 'zivojejihu@mailinator.com', 'High School', 'Grade 11', 'Qui magnam aut labor', '', '/Public/stud.img/default.png', '0', 'Active', 12),
(11, 'SCC-25-00000011', 'Quae ea no', 'Sears', 'Brian', 'Alexandra Roth', 'Female', '1983-02-05', 'Et nemo et officia r', 'Esse lorem quod', 'myge@mailinator.com', 'College', '4th Year', 'Est voluptatem min', '', '/Public/stud.img/default.png', '0', 'Active', 13),
(12, 'SCC-25-00000012', '', 'Howell', 'Vaughan', 'Sage Franco', 'Male', '2008-07-19', 'Vero cum doloribus e', 'Eligendi sed it', 'mifiw@mailinator.com', 'Elementary', 'Grade 4', 'Dolor magna iste ad ', '', '/Public/stud.img/default.png', '0', 'Active', 15),
(13, 'SCC-25-00000013', '', 'Smith', 'Kylan', 'Martina Castro', 'Female', '2017-04-10', 'Atque expedita vero ', 'Qui sequi dolor', 'feci@mailinator.com', 'Elementary', 'Grade 3', 'Similique earum prae', '', '/Public/stud.img/default.png', '0', 'Inactive', 17),
(14, 'SCC-25-00000014', 'Itaque tem', 'Riley', 'Macaulay', 'April Church', 'Male', '1993-06-14', 'Non possimus except', 'In sequi repell', 'zaguvo@mailinator.com', 'Elementary', 'Grade 6', 'Laborum Accusantium', '', '/Public/stud.img/default.png', 'Reprehenderit aute ', 'Archived', 18);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `u_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('Active','Pending') NOT NULL DEFAULT 'Pending',
  `role` enum('Head Guidance','Guidance Counselor','Parent','Student') DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `counselor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `username`, `password`, `status`, `role`, `student_id`, `parent_id`, `counselor_id`) VALUES
(1, 'headguidance', '$2y$10$s3e3fuEZShWuYA4s05VW6.IB6ke3b0NbBEzzGMFzk3sNDzgyt1UGS', 'Active', 'Head Guidance', NULL, NULL, NULL),
(2, 'SCC-25-00000001', '$2y$10$579Xu...Y/Zz.h/wD95E9OwhqRbBLsSyyxvkIAM7dMRMZTOMy5cYa', 'Active', 'Student', 1, 1, NULL),
(3, 'SCC-25-00000002', '$2y$10$WIlEgcQA3TKPQ.SUPUiER.hMkdPnrjvL/Rd15qtgUgHicKYjjcXV6', 'Active', 'Student', 2, 2, NULL),
(4, 'SCC-25-00000003', '$2y$10$Aq74d4u1scgcvwP6kLjrAujZ.MUNG1w1Wp/CJNZjt8.NmUhlZtg2W', 'Pending', 'Student', 3, 3, NULL),
(5, 'parent', '$2y$10$s3e3fuEZShWuYA4s05VW6.IB6ke3b0NbBEzzGMFzk3sNDzgyt1UGS', 'Active', 'Parent', NULL, 4, NULL),
(6, 'counsel', '$2y$10$s3e3fuEZShWuYA4s05VW6.IB6ke3b0NbBEzzGMFzk3sNDzgyt1UGS', 'Active', 'Guidance Counselor', NULL, NULL, 1),
(7, 'dasai', '$2y$10$PTn61IuKTbBHA6a9LHAALudpYyPXeKDTpenbfc1zq88M4OCDLgxdq', 'Active', 'Guidance Counselor', NULL, NULL, 2),
(8, 'ashlyn', '$2y$10$f1sQpvNepCiHaPqxg9uqQ.GAkigUT0x3wiX7Yt3d8tdA5dUKeyJz2', 'Active', 'Guidance Counselor', NULL, NULL, 3),
(9, 'SCC-25-00000005', '$2y$10$irAu/sgGZmEKbIRqXjcuw.lTciTgBtHguaB1ZbvQpqXN.k2xEXPOK', 'Active', 'Student', 5, 5, NULL),
(10, 'SCC-25-00000006', '$2y$10$2eCZ6BmpXhljfwYlMdEkB.tITZC3XMVHs/dSbb2lDsdk9nkmrC4Aq', 'Active', 'Student', 6, 6, NULL),
(11, 'SCC-25-00000007', '$2y$10$ddD0IoS9V.6A6buF5HXoFOUASal3xGnVSuq8kbdo6sg6xb169Y0em', 'Active', 'Student', 7, 7, NULL),
(12, 'SCC-25-00000008', '$2y$10$DFbdeNETTcrAryzPxFCfOub.GZzu9IUpw2jwBFWGvbOA865d1HVN.', 'Pending', 'Student', 8, 9, NULL),
(13, 'SCC-25-00000009', '$2y$10$LjZvpes2Mj.krAPlooKNzOCdEJsb6CHS/RSqJAEAo835QPiJJUk1G', 'Active', 'Student', 9, 11, NULL),
(14, 'SCC-25-00000010', '$2y$10$.NoU0g4ZlBfNhE5IfPkGi.RuShcj.OxstEUImL0VKqEDzf9pjoWiO', 'Active', 'Student', 10, 12, NULL),
(15, 'SCC-25-00000011', '$2y$10$HkNSfsZPN0Yb4F4kbCd6Aeb1QQIZFD8G7WgYVEaajVktbHGu8XVju', 'Active', 'Student', 11, 13, NULL),
(16, 'simon', '$2y$10$sxOCRG7G1iMtKU7OlxkkTe4ul0yoDEL1h2nQrOcYIjokUkWhGLg8O', 'Pending', 'Parent', NULL, 14, NULL),
(17, 'SCC-25-00000012', '$2y$10$HOxp5gkQ8c0UndrvofpIh.TWAe7flAwnyzm367yP/5vDiz3HiIoDC', 'Active', 'Student', 12, 15, NULL),
(18, 'aaron', '$2y$10$rN1mePjFq4r1ZgLIyANPCOm56xYijyEWIDAp3mW5cpS5A7N8.xCtO', 'Active', 'Parent', NULL, 16, NULL),
(19, 'SCC-25-00000013', '$2y$10$JeP.PRJ/9znZBh1pq6xniu6QSkK93CTr34S1NVBCyMi6OQeOxyehS', 'Active', 'Student', 13, 17, NULL),
(20, 'SCC-25-00000014', '$2y$10$wtZ2/5xuxr9iPJEpiVXTKeq1/lJa0In7kFHc9ptSShU4WEdoK9fPy', 'Active', 'Student', NULL, NULL, NULL),
(21, 'abc', '$2y$10$3B6EhNaZAOoMa6zQ5bmkBuWtUyeF2NDxiTRzR6u1BcfXybYsMRG3m', 'Pending', 'Parent', NULL, 18, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointment_history`
--
ALTER TABLE `appointment_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointment_id` (`appointment_id`);

--
-- Indexes for table `case_records`
--
ALTER TABLE `case_records`
  ADD PRIMARY KEY (`case_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `counselors`
--
ALTER TABLE `counselors`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `parents`
--
ALTER TABLE `parents`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`s_id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `counselor_id` (`counselor_id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appointment_history`
--
ALTER TABLE `appointment_history`
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
  MODIFY `c_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `parents`
--
ALTER TABLE `parents`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`u_id`);

--
-- Constraints for table `appointment_history`
--
ALTER TABLE `appointment_history`
  ADD CONSTRAINT `appointment_history_ibfk_1` FOREIGN KEY (`appointment_id`) REFERENCES `appointment` (`id`);

--
-- Constraints for table `case_records`
--
ALTER TABLE `case_records`
  ADD CONSTRAINT `case_records_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`s_id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`u_id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `parents` (`p_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`s_id`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`counselor_id`) REFERENCES `counselors` (`c_id`),
  ADD CONSTRAINT `users_ibfk_3` FOREIGN KEY (`parent_id`) REFERENCES `parents` (`p_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
