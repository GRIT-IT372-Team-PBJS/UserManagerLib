-- phpMyAdmin SQL Dump

-- version 4.3.8

-- http://www.phpmyadmin.net

--

-- Host: localhost

-- Generation Time: Dec 03, 2016 at 07:45 PM

-- Server version: 5.5.51-38.2

-- PHP Version: 5.4.31



SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

SET time_zone = "+00:00";




/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;

/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;

/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;

/*!40101 SET NAMES utf8 */;



--

-- Database: `login_db`

--


-- --------------------------------------------------------



--

-- Table structure for table `auth`

--



CREATE TABLE IF NOT EXISTS `auth` (

  `auth_id` int(11) NOT NULL,

  `auth_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,

  `auth_rank` int(11) NOT NULL

) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



--

-- Dumping data for table `auth`

--


INSERT INTO `auth` (`auth_id`, `auth_type`, `auth_rank`) VALUES
(1, 'SUPER_ADMIN', 0),
(2, 'ADMIN', 1),
(3, 'REGULAR', 10);



-- 
--------------------------------------------------------


--


-- Table structure for table `sites`

--



CREATE TABLE IF NOT EXISTS `sites` (

  `site_id` int(11) NOT NULL,

  `site_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL

) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



--
------------------------------------------------------
--



--
-- Table structure for table `users`

--



CREATE TABLE IF NOT EXISTS `users` (

  `user_id` int(11) NOT NULL,

  `email` varchar(125) COLLATE utf8_unicode_ci NOT NULL,

  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,

  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,

  `middlename` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,

  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



-- --------------------------------------------------------



--

-- Table structure for table `user_site_auth`

--



CREATE TABLE IF NOT EXISTS `user_site_auth` (

  `user_id` int(11) NOT NULL,

  `site_id` int(11) NOT NULL,

  `user_auth` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL

) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



--

-- Indexes for dumped tables

--



--

-- Indexes for table `auth`

--


ALTER TABLE `auth`

 ADD PRIMARY KEY (`auth_id`),
 ADD UNIQUE KEY `auth_type` (`auth_type`),
 ADD UNIQUE KEY `auth_rank` (`auth_rank`);



--

-- Indexes for table `sites`

--


ALTER TABLE `sites`
 
 ADD PRIMARY KEY (`site_id`);



--

-- Indexes for table `users`

--


ALTER TABLE `users`
 
 ADD PRIMARY KEY (`user_id`),
 ADD UNIQUE KEY `email` (`email`);



--

-- AUTO_INCREMENT for dumped tables

--



--

-- AUTO_INCREMENT for table `auth`

--


ALTER TABLE `auth`
 
 MODIFY `auth_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;


--

-- AUTO_INCREMENT for table `users`

--


ALTER TABLE `users`
 
 MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
