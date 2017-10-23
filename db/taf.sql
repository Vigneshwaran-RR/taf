-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 11, 2014 at 03:17 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `taf`
--

-- --------------------------------------------------------

--
-- Table structure for table `authd_pages`
--

CREATE TABLE IF NOT EXISTS `authd_pages` (
  `role_id` int(5) NOT NULL,
  `grtd_pages` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `authd_pages`
--

INSERT INTO `authd_pages` (`role_id`, `grtd_pages`) VALUES
(3, 'home'),
(3, 'myinfo'),
(3, 'signup'),
(4, 'home'),
(4, 'myinfo'),
(4, 'signup'),
(2, 'home'),
(2, 'myinfo'),
(2, 'signup'),
(2, 'roles');

-- --------------------------------------------------------

--
-- Table structure for table `ice`
--

CREATE TABLE IF NOT EXISTS `ice` (
  `P_fullname` varchar(30) NOT NULL,
  `P_phoneno` int(10) NOT NULL,
  `P_address` varchar(8192) NOT NULL,
  `IC1_name` varchar(30) NOT NULL,
  `IC1_phoneno` int(10) NOT NULL,
  `IC1_address` varchar(8192) NOT NULL,
  `IC2_name` varchar(30) NOT NULL,
  `IC2_phoneno` int(10) NOT NULL,
  `IC2_address` varchar(8192) NOT NULL,
  `M_bloodgroup` varchar(15) NOT NULL,
  `M_allergies` text NOT NULL,
  `M_medicalhistory` text NOT NULL,
  `D_name` varchar(30) NOT NULL,
  `D_phoneno` int(10) NOT NULL,
  `D_address` varchar(8192) NOT NULL,
  `D_affiliatedhospital` varchar(4096) NOT NULL,
  `username` varchar(255) NOT NULL,
  PRIMARY KEY (`P_fullname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ice`
--

INSERT INTO `ice` (`P_fullname`, `P_phoneno`, `P_address`, `IC1_name`, `IC1_phoneno`, `IC1_address`, `IC2_name`, `IC2_phoneno`, `IC2_address`, `M_bloodgroup`, `M_allergies`, `M_medicalhistory`, `D_name`, `D_phoneno`, `D_address`, `D_affiliatedhospital`, `username`) VALUES
('Ganesh', 2147483647, 'No 9/A Veerappan Street,\nSivakasi.', 'Al-Qaeda', 154, 'No 11, Bin Ladan Street,\nUnderWorld.', '', 0, '', '', '', '', '', 0, '', '', 'ganesh'),
('Shiva', 2147483647, 'Silverstein,\nWashington.\nUSA', 'Gogoly', 888888888, 'Bronztein,\nIlondon.', '', 0, '', 'AB+', 'Dust Allergy', 'NA', 'Dr. Needle', 2147483647, 'Muscular Street,\nDon Bone Colony,\nHaemoglobin.', '', 'shiva'),
('vinoth', 2147483647, '1st Floor, Grand Avenue,\nSilver Beach,\nCalifornia,\nUSA', 'Marguerite', 123456789, 'P14- 3rd Wing, IInd street,\nTechnopark,\nLos Vegas,\nUSA', 'Percy Blackney', 2147483647, 'T-6 Mark Enclave,\nRoyal Palace,\nLos Angeles,\nUSA', 'o+ve', 'Dust allergies', 'Nil', 'Dr. Stethoscope', 108, 'Government Medical college,\nSzteuzes,\nHongKong.', 'Great Britain Federal Hospital', 'madan');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `page_id` int(10) NOT NULL,
  `page_name` text NOT NULL,
  PRIMARY KEY (`page_id`),
  KEY `page_id` (`page_id`),
  KEY `page_id_2` (`page_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`page_id`, `page_name`) VALUES
(1, 'home'),
(2, 'myinfo'),
(3, 'signup'),
(4, 'roles');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `role_name` text NOT NULL,
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_name`, `role_id`) VALUES
('Super Admin', 2),
('Admin', 3),
('Users', 12);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `display_name` varchar(1024) NOT NULL,
  `email` varchar(512) NOT NULL,
  `role` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `display_name`, `email`, `role`) VALUES
(2, 'madan', 'e772d3b97c4ba665c8fcb3a18065a57f', 'Madan  U S', 'madanus@gmail.com', 'Super Admin'),
(11, 'vignesh', 'c5a753d093043bbebf3a31d409400f19', 'vignesh', 'vigneshwaran17691@gmail.com', 'Admin'),
(12, 'vinoth', '7ed8e02e77441dd97e2496386ba3db39', 'vinoth', 'vinoth@techartus.com', 'Admin'),
(13, 'ganesh', 'fa1d87bc7f85769ea9dee2e4957321ae', 'Ganesh', 'ganesh@gmail.com', 'Admin'),
(14, 'gowtham', 'a6d358f9786fe97e1ec604e5aaf299ec', 'gowtham', 'gowtham@gmail.com', 'Admin'),
(17, 'shiva', '475a874db17801e2325120c3b790a3eb', 'Shiva', 'shiva@gmail.com', 'Admin'),
(18, 'GJ', 'acb7a9cbbd0e79289cf341796e2f1ff4', 'GJ', 'gj@gmail.com', 'Admin');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
