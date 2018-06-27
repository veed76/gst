-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 06, 2017 at 11:42 PM
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
  `company_type` varchar(255) NOT NULL,
  `company_user_uuid` varchar(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gst_company`
--

INSERT INTO `gst_company` (`company_id`, `company_uuid`, `company_name`, `company_address`, `company_pincode`, `company_email`, `company_profileurl`, `company_phone`, `company_mobile`, `company_createdt`, `company_modifydt`, `company_status`, `company_password`, `company_country`, `company_state`, `company_city`, `company_gstin`, `company_registrationdt`, `company_name_entity`, `company_pan`, `company_branch_name`, `company_type`, `company_user_uuid`) VALUES
(1, 'c169961d-f458-4dc2-88ae-9855e3881378', 'company name', 'address', '395006', 'officialgohil@gmail.com', '', '', '7894561234', '2017-10-06 14:39:08', '2017-10-06 14:39:08', 1, '', '', '1', 'surat', '789445612626265', '2017-12-09', 'vishal', '8794654849', 'branch name', '', '25156856-44ae-4a97-886b-66fbf4c69f53'),
(2, 'bebbe8cf-228c-4e81-ba4a-41c538da6b4d', 'retert', 'tertertret', '464564', 'officialgohil@gmail.com', 'employee.png', '7987964564', '7978976456', '2017-10-06 14:45:32', '2017-10-06 14:45:32', 1, '', '', '1', 'dfdsfasfsad', '789445612626265', '2017-02-11', 'tretreter', '6464564564', 'erterter', '', '25156856-44ae-4a97-886b-66fbf4c69f53'),
(3, 'c6593524-cdee-4f82-b7c7-fbe3c8d7be2b', 'gfdgdfgdfg', 'dfgdfg', '645656', 'a@gmail.com', 'employee.png', '9879797897', '7978675455', '2017-10-06 14:51:36', '2017-10-06 14:51:36', 1, '', '', '1', 'Suratf', 't75675675675675', '0000-00-00', 'gdfgdfg', '4567456456', 'dfgdf', '', '25156856-44ae-4a97-886b-66fbf4c69f53'),
(4, 'f04eaebb-f5e6-449f-951b-790f912e0f91', 'fdsfsdfsdf', 'fsdfsdfsdf', '546546', 'a@gmail.com', 'employee2.png', '7897897897', '9789797897', '2017-10-06 14:56:35', '2017-10-06 14:56:35', 1, '', '', '2', 'ujfghfghfgh', 'ffhgffhfytryrty', '2017-04-11', 'sdfsdfsd', 'fghfghfghf', 'dsfsdfsdf', '', '25156856-44ae-4a97-886b-66fbf4c69f53');

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
  ADD PRIMARY KEY (`company_id`,`company_uuid`);

--
-- Indexes for table `gst_registration`
--
ALTER TABLE `gst_registration`
  ADD PRIMARY KEY (`user_id`,`user_uuid`,`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gst_company`
--
ALTER TABLE `gst_company`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `gst_registration`
--
ALTER TABLE `gst_registration`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
