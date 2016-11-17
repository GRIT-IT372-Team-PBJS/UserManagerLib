-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2016 at 11:58 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `loginlib`
--
CREATE DATABASE IF NOT EXISTS `loginlib` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `loginlib`;

-- --------------------------------------------------------

--
-- Table structure for table `auth`
--

CREATE TABLE IF NOT EXISTS `auth` (
  `auth_id` int(11) NOT NULL AUTO_INCREMENT,
  `auth_type` varchar(255) NOT NULL,
  `auth_rank` int(11) NOT NULL,
  PRIMARY KEY (`auth_id`),
  UNIQUE KEY `auth_type` (`auth_type`),
  UNIQUE KEY `auth_rank` (`auth_rank`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `auth`
--

INSERT INTO `auth` (`auth_id`, `auth_type`, `auth_rank`) VALUES
(1, 'SUPER_ADMIN', 0),
(2, 'ADMIN', 1),
(3, 'REGULAR', 10);

-- --------------------------------------------------------

--
-- Table structure for table `sites`
--

CREATE TABLE IF NOT EXISTS `sites` (
  `site_id` int(11) NOT NULL,
  `site_name` varchar(255) NOT NULL,
  PRIMARY KEY (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sites`
--

INSERT INTO `sites` (`site_id`, `site_name`) VALUES
(1, 'it-connect');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(125) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `middename` varchar(255) DEFAULT NULL,
  `auth_type` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `firstname`, `lastname`, `middename`, `auth_type`, `password`) VALUES
(1, 'pk@gmail.com', 'Peter', 'Kim', 'Lee', '', '$2y$10$JlqUPqGe4Q4/evjzjQTrvOo1E4iceSPyVRwlcVu/W06zLhMDaQQCy'),
(3, 'pk2@gmail.com', 'Peter', 'Kim', 'Lee', 'SUPER_ADMIN', '$2y$10$ZBMFVQjGCNCTpDpmmssDterHr43rlKuNOaFdqCkyVe68ki9yq8jAi');

-- --------------------------------------------------------

--
-- Table structure for table `user_auth_xref`
--

CREATE TABLE IF NOT EXISTS `user_auth_xref` (
  `user_id` int(11) NOT NULL,
  `auth_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_auth_xref`
--

INSERT INTO `user_auth_xref` (`user_id`, `auth_type`) VALUES
(3, 'SUPER_ADMIN');

-- --------------------------------------------------------

--
-- Table structure for table `user_site_xref`
--

CREATE TABLE IF NOT EXISTS `user_site_xref` (
  `user_id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  KEY `user_id` (`user_id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_site_xref`
--

INSERT INTO `user_site_xref` (`user_id`, `site_id`) VALUES
(1, 1),
(3, 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_site_xref`
--
ALTER TABLE `user_site_xref`
  ADD CONSTRAINT `user_site_xref_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `user_site_xref_ibfk_2` FOREIGN KEY (`site_id`) REFERENCES `sites` (`site_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
