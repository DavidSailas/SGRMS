-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2025 at 02:33 AM
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
  `case_type` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `reported_by` varchar(100) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `academic_level` varchar(100) NOT NULL,
  `course_section` varchar(100) DEFAULT NULL,
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
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `case_records`
--

INSERT INTO `case_records` (`case_id`, `case_type`, `description`, `reported_by`, `student_name`, `academic_level`, `course_section`, `referred_by`, `referral_date`, `reason_for_referral`, `presenting_problem`, `observe_behavior`, `family_background`, `academic_history`, `social_relationships`, `medical_history`, `counselor_assessment`, `recommendations`, `follow_up_plan`, `filed_date`, `filed_time`, `status`) VALUES
(1, 'Behavioral', 'Student was caught cheating during an exam.', 'Prof. Dela Vega', 'Jacob M. Villondo', 'College', 'BSIT 4A', 'Instructor', '2024-11-10 10:32:00', 'Academic Misconduct', 'Cheating', 'Anxious during exam, avoided eye contact.', 'Single-parent household', 'Generally average, slight decline this term.', 'Few close friends, withdrawn.', 'None reported', 'Shows signs of stress, likely due to pressure to perform.', 'Weekly counseling recommended', 'Follow-up session in two weeks.', '2025-05-18', '14:32:11', 'Open'),
(2, 'Emotional', 'Student often cries in class and fails to participate.', 'Ms. Reyes', 'Anna L. Dela Cruz', 'College', 'BSIT 3B', 'Homeroom Adviser', '2024-10-28 08:45:00', 'Emotional Distress', 'Anxiety & Depression', 'Silent, teary-eyed, avoids participation.', 'Supportive family but strict parenting', 'Consistent performer, sudden drop in grades', 'Tends to isolate self.', 'Asthma', 'Needs emotional support and peer involvement.', 'Refer to psychologist, involve parents', 'Monitor behavior weekly.', '2025-05-18', '14:32:11', 'Open'),
(3, 'Peer Conflict', 'Student got into a physical fight with a classmate.', 'Coach Ramirez', 'Marc P. Reyes', 'College', 'BSBA 2A', 'PE Instructor', '2024-09-15 14:18:00', 'Peer Conflict', 'Aggressive Behavior', 'Hostile during discussion, defensive.', 'Both parents work overseas', 'Satisfactory, but disciplinary warnings present.', 'Frequent conflicts with peers.', 'No medical history reported.', 'Anger management issues, needs intervention.', 'Group therapy and conflict resolution activities', 'Weekly check-ins with guidance.', '2025-05-18', '14:32:11', 'Open'),
(4, 'Academic', 'Student is consistently failing Math subjects.', 'Mr. Tan', 'Kristine A. Torres', 'High School', '10-A', 'Subject Teacher', '2024-09-25 11:00:00', 'Academic Performance', 'Learning Difficulty', 'Struggles with attention and comprehension.', 'Lives with grandparents', 'Failing in Math and Science', 'Friendly, active in group work.', 'Wears eyeglasses, no major history', 'May have undiagnosed dyscalculia.', 'Recommend SPED screening, tutorial support', 'Re-evaluate after 1 month.', '2025-05-18', '14:32:11', 'Open'),
(5, 'Behavioral', 'Student is consistently disruptive in class.', 'Mrs. Santos', 'Miguel T. Garcia', 'High School', '9-B', 'Class Adviser', '2024-10-03 09:27:00', 'Disruption', 'Hyperactivity', 'Talks loudly, distracts classmates.', 'Large family, minimal supervision', 'Below average', 'Popular among peers, sometimes bullied.', 'Allergies, ADHD history', 'Likely ADHD – requires structured support.', 'Refer to school clinic and parent meeting', 'Monitor daily behavior.', '2025-05-18', '14:32:11', 'Open'),
(6, 'Academic', 'Student previously referred, needs follow-up due to persistent difficulty in Science.', 'Ms. Go', 'Patricia J. Lopez', 'High School', '8-C', 'Previous Counselor', '2024-10-18 13:42:00', 'Follow-up', 'Continued Academic Struggle', 'Appears more confident, still hesitant to speak.', 'Supportive family', 'Improved from last quarter', 'More interactive lately.', 'None', 'Progress noted, but Science grades remain low.', 'Tutorial sessions and academic coaching', 'Monitor progress every 2 weeks.', '2025-05-18', '14:32:11', 'Open');

-- --------------------------------------------------------

--
-- Table structure for table `counselors`
--

CREATE TABLE `counselors` (
  `c_id` int(50) NOT NULL,
  `u_id` int(11) NOT NULL,
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

INSERT INTO `counselors` (`c_id`, `u_id`, `lname`, `fname`, `mname`, `contact_num`, `email`, `c_level`, `c_image`) VALUES
(1, 21, 'Dela Cruz', 'Maria', 'N.', '09123451111', 'maria.elementary@guidance.com', 'Elementary', ''),
(2, 22, 'Reyes', 'Jonathan', 'C.', '09123452222', 'jonathan.hs@guidance.com', 'High School', ''),
(3, 23, 'Torres', 'Angelica', 'V.', '09123453333', 'angelica.college@guidance.com', 'College', '');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `message`, `timestamp`, `is_read`) VALUES
(1, 'New behavioral case filed for Jacob M. Villondo. Please review the details.', '2025-05-18 14:29:06', 1),
(2, 'Emotional distress referral received for Anna L. Dela Cruz. Counseling needed.', '2025-05-18 14:29:06', 1),
(3, 'Peer conflict involving Marc P. Reyes has been reported. Action required.', '2025-05-18 14:29:06', 1),
(4, 'Academic referral for Kristine A. Torres due to failing grades in Math.', '2025-05-18 14:29:06', 1),
(5, 'Behavioral disruption reported for Miguel T. Garcia. Guidance action suggested.', '2025-05-18 14:29:06', 1),
(6, 'Academic follow-up scheduled for Patricia J. Lopez. Progress being tracked.', '2025-05-18 14:29:06', 1);

-- --------------------------------------------------------

--
-- Table structure for table `parents`
--

CREATE TABLE `parents` (
  `p_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `guardian_name` varchar(100) NOT NULL,
  `relationship` varchar(50) NOT NULL,
  `contact_num` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parents`
--

INSERT INTO `parents` (`p_id`, `student_id`, `guardian_name`, `relationship`, `contact_num`) VALUES
(1, 1, 'Maria Villondo', 'Mother', '09991230001'),
(2, 2, 'Leo Dela Cruz', 'Father', '09991230002'),
(3, 3, 'Anna Reyes', 'Mother', '09991230003'),
(4, 4, 'Mark Santos', 'Father', '09991230004'),
(5, 5, 'Linda Garcia', 'Mother', '09991230005'),
(6, 6, 'Jose Ramirez', 'Father', '09991230006'),
(7, 7, 'Carmen Flores', 'Mother', '09991230007'),
(8, 8, 'Antonio Diaz', 'Father', '09991230008'),
(9, 9, 'Gloria Mendoza', 'Mother', '09991230009'),
(10, 10, 'Ramon Castillo', 'Father', '09991230010'),
(11, 11, 'Teresa Navarro', 'Mother', '09991230011'),
(12, 12, 'Luis Ortega', 'Father', '09991230012'),
(13, 13, 'Patricia Morales', 'Mother', '09991230013'),
(14, 14, 'Carlos Vega', 'Father', '09991230014'),
(15, 15, 'Sofia Ruiz', 'Mother', '09991230015'),
(16, 16, 'Miguel Castro', 'Father', '09991230016'),
(17, 17, 'Elena Santos', 'Mother', '09991230017'),
(18, 18, 'Jorge Ramos', 'Father', '09991230018'),
(19, 19, 'Lucia Alvarez', 'Mother', '09991230019'),
(20, 20, 'Dennis Manalo', 'Father', '09991230020');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `p_picture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `name`, `email`, `p_picture`, `created_at`) VALUES
(1, 'John Doe', 'john.doe@example.com', 'images/john_doe.jpg', '2025-03-25 07:47:56'),
(2, 'Jane Smith', 'jane.smith@example.com', 'images/jane_smith.jpg', '2025-03-25 07:47:56'),
(3, 'Alice Johnson', 'alice.johnson@example.com', 'images/alice_johnson.jpg', '2025-03-25 07:47:56');

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
  `s_image` varchar(255) NOT NULL,
  `previous_school` varchar(255) DEFAULT NULL,
  `last_year_school` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`s_id`, `id_num`, `prefix`, `lname`, `fname`, `mname`, `gender`, `bod`, `address`, `mobile_num`, `email`, `educ_level`, `year_level`, `section`, `program`, `s_image`, `previous_school`, `last_year_school`) VALUES
(1, 'SCC-25-00000001', 'N/A', 'Villondo', 'Jacob', 'M.', 'Male', '2005-03-21', 'Minglanilla, Cebu', '09123456701', 'jacob@example.com', 'College', '4th Year', '', 'BSIT', '', 'Minglanilla NHS', 'Minglanilla NHS'),
(2, 'SCC-25-00000002', 'N/A', 'Dela Cruz', 'Anna', 'L.', 'Female', '2006-02-14', 'Talisay City', '09123456702', 'anna@example.com', 'College', '3rd Year', '', 'BSIT', '', 'Talisay City College', 'Talisay City College'),
(3, 'SCC-25-00000003', 'N/A', 'Reyes', 'Marc', 'P.', 'Male', '2007-06-11', 'Cebu City', '09123456703', 'marc@example.com', 'College', '2nd Year', '', 'BSBA', '', 'USC', 'USC'),
(4, 'SCC-25-00000004', 'N/A', 'Torres', 'Kristine', 'A.', 'Female', '2009-07-07', 'Mandaue', '09123456704', 'kristine@example.com', 'High School', 'Grade 10', '10-A', '', '', 'Mandaue NHS', 'Mandaue NHS'),
(5, 'SCC-25-00000005', 'N/A', 'Garcia', 'Miguel', 'T.', 'Male', '2010-08-05', 'Lapu-Lapu', '09123456705', 'miguel@example.com', 'High School', 'Grade 9', '9-B', '', '', 'Gun-ob HS', 'Gun-ob HS'),
(6, 'SCC-25-00000006', 'N/A', 'Lopez', 'Patricia', 'J.', 'Female', '2011-09-21', 'Carcar', '09123456706', 'patricia@example.com', 'High School', 'Grade 8', '8-C', '', '', 'Carcar City HS', 'Carcar City HS'),
(7, 'SCC-25-00000007', 'N/A', 'Castro', 'John', 'R.', 'Male', '2012-01-17', 'Sibonga', '09123456707', 'john@example.com', 'Elementary', 'Grade 6', '6-A', '', '', 'Sibonga Elem.', 'Sibonga Elem.'),
(8, 'SCC-25-00000008', 'N/A', 'Navarro', 'Clara', 'H.', 'Female', '2013-03-19', 'Dumanjug', '09123456708', 'clara@example.com', 'Elementary', 'Grade 5', '5-B', '', '', 'Dumanjug Central', 'Dumanjug Central'),
(9, 'SCC-25-00000009', 'N/A', 'Diaz', 'Enzo', 'G.', 'Male', '2014-05-24', 'Argao', '09123456709', 'enzo@example.com', 'Elementary', 'Grade 4', '4-C', '', '', 'Argao Elementary', 'Argao Elementary'),
(10, 'SCC-25-00000010', 'N/A', 'Santos', 'Bianca', 'F.', 'Female', '2015-07-12', 'Dalaguete', '09123456710', 'bianca@example.com', 'Elementary', 'Grade 3', '3-A', '', '', 'Dalaguete Elem.', 'Dalaguete Elem.'),
(11, 'SCC-25-00000011', 'N/A', 'Alvarez', 'Ken', 'D.', 'Male', '2010-12-25', 'Minglanilla', '09123456711', 'ken@example.com', 'High School', 'Grade 9', '9-D', '', '', 'Lipata NHS', 'Lipata NHS'),
(12, 'SCC-25-00000012', 'N/A', 'Gomez', 'Rachel', 'E.', 'Female', '2008-04-03', 'Talisay', '09123456712', 'rachel@example.com', 'High School', 'Grade 11', '11-STEM', '', '', 'SCI-Talisay', 'SCI-Talisay'),
(13, 'SCC-25-00000013', 'N/A', 'Morales', 'Kyle', 'S.', 'Male', '2005-09-15', 'Cebu', '09123456713', 'kyle@example.com', 'College', '1st Year', '', 'BSCS', '', 'ACT', 'ACT'),
(14, 'SCC-25-00000014', 'N/A', 'Francisco', 'Lena', 'I.', 'Female', '2014-11-30', 'San Fernando', '09123456714', 'lena@example.com', 'Elementary', 'Grade 2', '2-C', '', '', 'San Fernando Elem.', 'San Fernando Elem.'),
(15, 'SCC-25-00000015', 'N/A', 'Ramos', 'Bryan', 'U.', 'Male', '2013-06-18', 'Naga', '09123456715', 'bryan@example.com', 'Elementary', 'Grade 4', '4-D', '', '', 'Naga Central', 'Naga Central'),
(16, 'SCC-25-00000016', 'N/A', 'Medina', 'Sophia', 'O.', 'Female', '2012-02-28', 'Talisay', '09123456716', 'sophia@example.com', 'Elementary', 'Grade 5', '5-A', '', '', 'SCI-Talisay', 'SCI-Talisay'),
(17, 'SCC-25-00000017', 'N/A', 'Fernandez', 'Arvin', 'Y.', 'Male', '2011-05-01', 'Carcar', '09123456717', 'arvin@example.com', 'High School', 'Grade 7', '7-B', '', '', 'Lipata NHS', 'Lipata NHS'),
(18, 'SCC-25-00000018', 'N/A', 'Agustin', 'Mira', 'Z.', 'Female', '2006-10-16', 'Cebu City', '09123456718', 'mira@example.com', 'College', '2nd Year', '', 'BSPSY', '', 'USJR', 'USJR'),
(19, 'SCC-25-00000019', 'N/A', 'Salazar', 'Nathan', 'K.', 'Male', '2007-11-22', 'Mandaue', '09123456719', 'nathan@example.com', 'College', '3rd Year', '', 'BSECE', '', 'UC', 'UC'),
(20, 'SCC-25-00000020', 'N/A', 'Manalo', 'Tricia', 'Q.', 'Female', '2010-03-30', 'Lapu-Lapu', '09123456720', 'tricia@example.com', 'High School', 'Grade 10', '10-C', '', '', 'Gun-ob HS', 'Gun-ob HS'),
(21, 'SCC-25-00000021', '', 'Romano', 'David Sailas', 'V.', 'Male', '2003-02-12', 'Lipata, Minglanilla, Cebu', '09817970638', 'dasai@gmail.com', 'College', '3rd Year', '', 'BSIT', '/Public/stud.img/default.png', 'SCC', 'SCC');

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
  `student_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `username`, `password`, `status`, `role`, `student_id`) VALUES
(1, 'headguidance', '$2y$10$s3e3fuEZShWuYA4s05VW6.IB6ke3b0NbBEzzGMFzk3sNDzgyt1UGS', 'Active', 'Head Guidance', NULL),
(2, 'SCC-25-00000001', '$2y$10$FPVKnCVBrRTt8tSgE.CCVeOlFiKq5qI3HRBlKDHzy5MFsL0tYNkCa', 'Active', 'Student', 1),
(3, 'SCC-25-00000002', '$2y$10$EebwHM6ChN3ueAgzFRAZxujWaYtpDZvtRxjMCNRw0zmJ7XEqUhn7u', 'Active', 'Student', 2),
(4, 'SCC-25-00000003', '$2y$10$hNKjPKZrD6RHPGgNKUUO0OGuHFJUXbhPB7BJ18lhSo6vA9FANryvy', 'Active', 'Student', 3),
(5, 'SCC-25-00000004', '$2y$10$XSkNq38sh9FwPN9wdyhGH.0dfVbqzKy0k6aSe7VvG9MbZXAxYgIje', 'Active', 'Student', 4),
(6, 'SCC-25-00000005', '$2y$10$O6NaJ5iZjFZDaEjZGnFMtO7fT2UuAG0VECNOoMf55JZ1knXEiM9XG', 'Active', 'Student', 5),
(7, 'SCC-25-00000006', '$2y$10$PbnyRQv.DxlbsFL5xiA/5.JmVw.Kr7Ho35MFZrM9fMIr7PSiCW7ya', 'Active', 'Student', 6),
(8, 'SCC-25-00000007', '$2y$10$AI6O8td2znU8nCiw2WdMpOyUCh4kESp6k.v5uQgHQQdG8BEZyjhLi', 'Active', 'Student', 7),
(9, 'SCC-25-00000008', '$2y$10$B2lv1Xw9Z3RDswM7UpM0Au1uTsywTwbm53sT2DRQAcLYBkBaWrnWq', 'Active', 'Student', 8),
(10, 'SCC-25-00000009', '$2y$10$eazVq6frTdd5ro.DcQ4vh.4ZaT8VpOn7jP9mFoZ7fpKRFe/NqF.Ni', 'Active', 'Student', 9),
(11, 'SCC-25-00000010', '$2y$10$xFe9.yys4U7VYbD9d.S2wuYbJCU0k2EZTof2x.tj0/v/1pjF.RBa2', 'Active', 'Student', 10),
(12, 'SCC-25-00000011', '$2y$10$h8aPDzvMZ2VAXShbV38uRujLJ2VK9IS/bbU4XZP.EOBE2TW0O7iqK', 'Active', 'Student', 11),
(13, 'SCC-25-00000012', '$2y$10$g.FasOhEDU05zfsNyp1yguEnRwAoxbY8vG5xd4K5mE1fF63b5a5z2', 'Active', 'Student', 12),
(14, 'SCC-25-00000013', '$2y$10$4lfszM/pQmZpp8VRn3NpeuL6VKBOc1V5MW5HyPMmraSKojYEvJ6cC', 'Active', 'Student', 13),
(15, 'SCC-25-00000014', '$2y$10$Q6OPPjTz1/GBur0q2Y4tG.Fkn5IVeAMYG5hGSFSs2i5t7e91s5UZK', 'Active', 'Student', 14),
(16, 'SCC-25-00000015', '$2y$10$dw4X6iSMVt0Z3je3OQwF4eK3sW3wdrxfcmU/iyz4VPPfTJ0MkpDgG', 'Active', 'Student', 15),
(17, 'SCC-25-00000016', '$2y$10$PFt2TbwWkFq/hssR9IPuKOx2rqZPYrfW26KCF1jNZ2G9Bo0oFQoFO', 'Active', 'Student', 16),
(18, 'SCC-25-00000017', '$2y$10$QPUdcwNU34sPpOLufvRNU.OXjDbH1ROwvZZuvU2KWHbgjGi9N7f3u', 'Active', 'Student', 17),
(19, 'SCC-25-00000018', '$2y$10$A6YhBJpP5uDjLoL4mr3P4.gOueKkj5N5RLo4yFoCbb0zrN1rMnEiK', 'Active', 'Student', 18),
(20, 'SCC-25-00000019', '$2y$10$GUP8oxBchL/0FSoUPCKR9O8dXKPtwbMpI3odD6OT5MRDbHTN5QNRi', 'Active', 'Student', 19),
(21, 'SCC-25-00000020', '$2y$10$nOX7PRtQO2rD4xVtAZcfOeGrZIM.dDKj0zDb1w8Ra.03DR99Zz4vG', 'Active', 'Student', 20),
(22, 'delacruz', '$2y$10$s3e3fuEZShWuYA4s05VW6.IB6ke3b0NbBEzzGMFzk3sNDzgyt1UGS', 'Active', 'Guidance Counselor', NULL),
(23, 'reyes', '$2y$10$s3e3fuEZShWuYA4s05VW6.IB6ke3b0NbBEzzGMFzk3sNDzgyt1UGS', 'Active', 'Guidance Counselor', NULL),
(24, 'torres', '$2y$10$s3e3fuEZShWuYA4s05VW6.IB6ke3b0NbBEzzGMFzk3sNDzgyt1UGS', 'Active', 'Guidance Counselor', NULL),
(25, 'SCC-25-00000021', '$2y$10$ppR.rMeMn/r9R424NShbU.svThz2wONUv4OV7dD6PJDy61.P5IGDK', 'Active', 'Student', NULL);

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
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parents`
--
ALTER TABLE `parents`
  ADD PRIMARY KEY (`p_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`s_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`),
  ADD KEY `fk_student_id` (`student_id`);

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
  MODIFY `case_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `parents`
--
ALTER TABLE `parents`
  ADD CONSTRAINT `parents_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`s_id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_student_id` FOREIGN KEY (`student_id`) REFERENCES `students` (`s_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
