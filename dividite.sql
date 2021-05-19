-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2021 at 11:45 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dividite`
--

-- --------------------------------------------------------

--
-- Table structure for table `reset_password`
--

CREATE TABLE `reset_password` (
  `reset_code` varchar(10) NOT NULL,
  `email` varchar(23) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `uploaded_files`
--

CREATE TABLE `uploaded_files` (
  `uploader_email` varchar(23) NOT NULL,
  `file_name` varchar(254) NOT NULL,
  `description` varchar(100) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `category` varchar(18) NOT NULL,
  `downloads` int(5) NOT NULL DEFAULT 0,
  `uploaded_Time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uploaded_files`
--

INSERT INTO `uploaded_files` (`uploader_email`, `file_name`, `description`, `subject`, `category`, `downloads`, `uploaded_Time`) VALUES
('bsef18m503@pucit.edu.pk', 'Assembly-Language-Programming-and-Organization-of-the-IBM-PC-By-Ytha-Y.-Yu-Charles-Marut.pdf', 'Book Suggested by Sir Hafiz Muhammad Danish', 'Computer Oraganization And Assembly Language', 'Book', 1, '2020-06-14 15:07:25'),
('bitf18m590@pucit.edu.pk', 'c-programming-language-the-3rd-edition.pdf', '', 'Programming Fundamentals', 'Book', 1, '2020-06-17 18:01:44'),
('bsef18m503@pucit.edu.pk', 'Hands On GUI Programming With C__ And Qt5 - Lee Zhi Eng.pdf', 'This is the book related to C++ GUI', 'Programming Fundamentals', 'Book', 0, '2020-06-13 17:33:22'),
('bsef18m503@pucit.edu.pk', 'Introduction to Oracle SQL-Volume 1.pdf', 'Book Suggested by Sir Farhan Chaudhry', 'Database System', 'Book', 0, '2020-06-14 15:05:26'),
('bsef18m503@pucit.edu.pk', 'Islamiyat-Lazmi-BABsc.pdf', '', 'Islamic And Pakistan Studies', 'Book', 0, '2020-06-17 15:53:55'),
('bsef18m503@pucit.edu.pk', 'Learning PHP, MySQL  JavaScript, 5th Edition.pdf', '', 'Programming Fundamentals', 'Book', 2, '2020-06-17 18:21:24'),
('bitf18m590@pucit.edu.pk', 'Schaums Programming with C++.pdf', '', 'Programming Fundamentals', 'Book', 0, '2020-06-17 18:08:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `email` varchar(23) NOT NULL,
  `password` varchar(20) NOT NULL,
  `verification_code` varchar(6) NOT NULL,
  `verification_status` tinyint(1) NOT NULL DEFAULT 0,
  `image_uploaded` tinyint(1) NOT NULL DEFAULT 0,
  `registration_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`email`, `password`, `verification_code`, `verification_status`, `image_uploaded`, `registration_date`) VALUES
('bitf18m590@pucit.edu.pk', 'itman9089@', 'dgXHUO', 1, 1, '2020-06-17 22:19:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reset_password`
--
ALTER TABLE `reset_password`
  ADD PRIMARY KEY (`reset_code`);

--
-- Indexes for table `uploaded_files`
--
ALTER TABLE `uploaded_files`
  ADD PRIMARY KEY (`file_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
