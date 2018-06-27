-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 05, 2017 at 11:44 PM
-- Server version: 5.7.19
-- PHP Version: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gst`
--

-- --------------------------------------------------------

--
-- Table structure for table `gst_company`
--

CREATE TABLE `gst_company` (
  `company_id` int(11) NOT NULL,
  `company_uuid` varchar(36) NOT NULL,
  `company_name` varchar(36) NOT NULL,
  `company_address` varchar(1000) NOT NULL,
  `company_pincode` varchar(36) NOT NULL,
  `company_email` varchar(50) NOT NULL,
  `company_profileurl` varchar(200) NOT NULL,
  `company_phone` varchar(255) NOT NULL,
  `company_mobile` varchar(255) NOT NULL,
  `company_createdt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `company_modifydt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `company_status` int(11) NOT NULL DEFAULT '1',
  `company_password` varchar(255) NOT NULL,
  `company_country` varchar(255) NOT NULL,
  `company_state` varchar(255) NOT NULL,
  `company_city` varchar(255) NOT NULL,
  `company_gstin` varchar(255) NOT NULL,
  `company_registrationdt` date NOT NULL,
  `company_name_entity` varchar(255) NOT NULL,
  `company_pan` varchar(255) NOT NULL,
  `company_branch_name` varchar(255) NOT NULL,
  `company_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gst_registration`
--

CREATE TABLE `gst_registration` (
  `user_id` int(11) NOT NULL,
  `user_uuid` varchar(36) NOT NULL,
  `user_firstname` varchar(36) NOT NULL,
  `user_middlename` varchar(36) NOT NULL,
  `user_lastname` varchar(36) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_address` varchar(2000) NOT NULL,
  `user_profileurl` varchar(255) NOT NULL,
  `user_mobile` varchar(255) NOT NULL,
  `user_createdt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_modifydt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_status` int(11) NOT NULL DEFAULT '1',
  `user_password` varchar(255) NOT NULL,
  `user_country` varchar(255) NOT NULL,
  `user_state` varchar(255) NOT NULL,
  `user_city` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gst_registration`
--

INSERT INTO `gst_registration` (`user_id`, `user_uuid`, `user_firstname`, `user_middlename`, `user_lastname`, `user_email`, `user_address`, `user_profileurl`, `user_mobile`, `user_createdt`, `user_modifydt`, `user_status`, `user_password`, `user_country`, `user_state`, `user_city`) VALUES
(1, '25156856-44ae-4a97-886b-66fbf4c69f53', 'vishal', '', '', 'vishal@gmail.com', '', '', '', '2017-10-04 16:40:13', '2017-10-04 16:40:13', 1, '457f8cf0fc9af872df765130c9031de0', '', '', ''),
(2, 'f0ada259-e636-4a57-b608-ca6c10b323ea', 'root', '', '', 'vishal1@gmail.com', '', '', '', '2017-10-04 17:15:10', '2017-10-04 17:15:10', 1, '457f8cf0fc9af872df765130c9031de0', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gst_company`
--
ALTER TABLE `gst_company`
  ADD PRIMARY KEY (`company_id`,`company_email`);

--
-- Indexes for table `gst_registration`
--
ALTER TABLE `gst_registration`
  ADD PRIMARY KEY (`user_id`,`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gst_company`
--
ALTER TABLE `gst_company`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gst_registration`
--
ALTER TABLE `gst_registration`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
