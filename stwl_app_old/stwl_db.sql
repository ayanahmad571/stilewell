-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2016 at 01:21 PM
-- Server version: 5.6.17-log
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `stwl_db`
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `order_sum_qty`
--
CREATE TABLE IF NOT EXISTS `order_sum_qty` (
`oi_id` int(255)
,`oi_rel_pr_id` int(255)
,`oi_rel_or_id` int(255)
,`oi_qty` varchar(698)
,`oi_price_for_one` varchar(698)
,`oi_valid` int(2)
,`sumqtyorder` double
);
-- --------------------------------------------------------

--
-- Table structure for table `sw_access_master`
--

CREATE TABLE IF NOT EXISTS `sw_access_master` (
  `swa_id` int(255) NOT NULL AUTO_INCREMENT,
  `swa_type` int(255) NOT NULL,
  `swa_desc` varchar(698) NOT NULL,
  `swa_valid` int(2) NOT NULL DEFAULT '1' COMMENT 'only 1 or 0',
  PRIMARY KEY (`swa_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `sw_access_master`
--

INSERT INTO `sw_access_master` (`swa_id`, `swa_type`, `swa_desc`, `swa_valid`) VALUES
(1, 1, 'only view\r\n', 1),
(2, 2, 'view and insert\r\n', 1),
(3, 3, 'view,insert,update\r\n', 1),
(4, 4, 'view,insert,update,delete\r\n', 1),
(5, 5, 'view,insert,update,delete,add users and infinity\r\n', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sw_modules`
--

CREATE TABLE IF NOT EXISTS `sw_modules` (
  `mo_id` int(11) NOT NULL AUTO_INCREMENT,
  `mo_name` varchar(698) NOT NULL,
  `mo_href` varchar(698) NOT NULL DEFAULT 'blah.php',
  `mo_icon` varchar(698) NOT NULL DEFAULT 'fa fa-icon',
  `mo_min_level` int(20) NOT NULL,
  `mo_valid` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`mo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `sw_modules`
--

INSERT INTO `sw_modules` (`mo_id`, `mo_name`, `mo_href`, `mo_icon`, `mo_min_level`, `mo_valid`) VALUES
(1, 'Dashboard', 'home.php', 'ion-home', 1, 1),
(2, 'Inventory', 'inven.php\r\n', 'ion-briefcase', 1, 1),
(3, 'Orders', 'orders.php\r\n', 'ion-clipboard', 5, 1),
(4, 'Users', 'users_main.php', 'ion-person-stalker', 5, 1),
(5, 'Stats', 'stat.php\r\n', 'ion-stats-bars', 1, 1),
(6, 'Quantity', 'qty.php', 'ion-plus', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sw_orders`
--

CREATE TABLE IF NOT EXISTS `sw_orders` (
  `or_id` int(255) NOT NULL AUTO_INCREMENT,
  `or_ref_name` varchar(698) NOT NULL,
  `or_datentime` varchar(698) NOT NULL,
  `or_buy_name` varchar(698) NOT NULL,
  `or_valid` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`or_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `sw_orders`
--

INSERT INTO `sw_orders` (`or_id`, `or_ref_name`, `or_datentime`, `or_buy_name`, `or_valid`) VALUES
(1, 'Y6gI', '1465125435', 'Miracfil', 1),
(2, 'MD4RR5', '1465204219', 'Mauritious', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sw_order_items`
--

CREATE TABLE IF NOT EXISTS `sw_order_items` (
  `oi_id` int(255) NOT NULL AUTO_INCREMENT,
  `oi_rel_pr_id` int(255) NOT NULL,
  `oi_rel_or_id` int(255) NOT NULL,
  `oi_qty` varchar(698) NOT NULL,
  `oi_price_for_one` varchar(698) NOT NULL,
  `oi_valid` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`oi_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `sw_order_items`
--

INSERT INTO `sw_order_items` (`oi_id`, `oi_rel_pr_id`, `oi_rel_or_id`, `oi_qty`, `oi_price_for_one`, `oi_valid`) VALUES
(1, 1, 1, '100', '54', 1),
(2, 2, 1, '54', '28', 1),
(3, 3, 1, '14', '10', 1),
(4, 5, 1, '1000', '21', 0),
(5, 10, 1, '1000', '988', 0),
(6, 4, 1, '12', '12', 0),
(7, 5, 1, '12', '32', 1),
(8, 5, 1, '12', '32', 0),
(9, 4, 1, '12', '2000', 1),
(10, 6, 1, '12', '33', 1),
(11, 9, 1, '35', '405', 1),
(12, 10, 1, '12', '43', 1),
(13, 1, 2, '12', '100', 1),
(14, 3, 2, '100', '40', 1),
(15, 2, 2, '345', '23', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sw_products_list`
--

CREATE TABLE IF NOT EXISTS `sw_products_list` (
  `pr_id` int(255) NOT NULL AUTO_INCREMENT,
  `pr_name` varchar(698) NOT NULL,
  `pr_type` varchar(698) NOT NULL,
  `pr_desc` varchar(698) NOT NULL,
  `pr_price` varchar(698) NOT NULL,
  `pr_qty` bigint(255) NOT NULL DEFAULT '0',
  `pr_invoiceno` varchar(698) NOT NULL,
  `pr_dnt` varchar(698) NOT NULL,
  `pr_valid` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`pr_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `sw_products_list`
--

INSERT INTO `sw_products_list` (`pr_id`, `pr_name`, `pr_type`, `pr_desc`, `pr_price`, `pr_qty`, `pr_invoiceno`, `pr_dnt`, `pr_valid`) VALUES
(1, '4 leg table', 'Exterior', 'this is a good type of chair', '40', 500, '', '1465220223', 1),
(2, 'ChairType4', 'INTERIOR', 'this is the best tavle\r\n', '50', 645, '', '1465220223', 1),
(3, 'Cupholder tyh4\r\n', 'INTERIOR', 'the is a car cupholder\r\n', '50', 583, '', '1465220223', 1),
(4, 'Lamp', 'Home', 'none', '20', 120, '', '1465220223', 1),
(5, 'PS4', 'gaming', 'online fees apply', '2000', 1000, '', '1465220223', 1),
(6, 'Tester', 'Perfume', 'oud type ery strong', '1500', 548, '', '1465220223', 1),
(7, 'Laptop', 'Alien', 'I7 1tb ram and  16mb cache', '10000', 5, '', '1465220223', 0),
(8, 'Tv remote', 'House', 'TataSky', '20', 0, '', '1465220223', 0),
(9, 'Tv remote', 'House', 'TataSky', '20', 123, '', '1465220223', 1),
(10, 'Alienware M18x', 'Laptop', 'i7 TBR', '10000', 512, '', '1465220223', 1),
(11, 'Lamp type 2', 'Lamparon', 'Montreal TDC', '25', 12, '', '1465220223', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sw_usrs_inf`
--

CREATE TABLE IF NOT EXISTS `sw_usrs_inf` (
  `sw_u_id` int(255) NOT NULL AUTO_INCREMENT,
  `sw_username` varchar(698) NOT NULL,
  `sw_password` varchar(698) NOT NULL,
  `sw_pass_words` varchar(698) DEFAULT NULL,
  `sw_prefix_name` varchar(698) NOT NULL,
  `sw_u_f_name` varchar(698) NOT NULL,
  `sw_u_l_name` varchar(698) NOT NULL,
  `sw_u_dob` varchar(698) NOT NULL,
  `sw_u_access` int(2) NOT NULL DEFAULT '3',
  `sw_contc_no` varchar(698) NOT NULL,
  `sw_email` varchar(698) NOT NULL,
  `sw_validtill` varchar(698) NOT NULL DEFAULT '0',
  `sw_valid` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`sw_u_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `sw_usrs_inf`
--

INSERT INTO `sw_usrs_inf` (`sw_u_id`, `sw_username`, `sw_password`, `sw_pass_words`, `sw_prefix_name`, `sw_u_f_name`, `sw_u_l_name`, `sw_u_dob`, `sw_u_access`, `sw_contc_no`, `sw_email`, `sw_validtill`, `sw_valid`) VALUES
(1, 'tanweer', '3276805e3e099d42ff7728309893ea82', 'tanweer', 'mr', 'Tanweer', 'Ahmad', '14-06-1963', 5, '971050435163', 'tanweer@stilewell.com', '0', 1),
(2, 'ayan', '0b2cfd4581fbe8b7195bc16ae5e2b92c', 'ayan', 'master', 'Ayan', 'Ahmad', '05-07-2001', 4, '0919971458215', 'ayanzcap@otmi.vom', '0', 1),
(3, 'madiha', '7e0deb8853363a84629ba98fbaa29c55', 'madiha', 'ms', 'Madiha', 'Ahmad', '18-01-1995', 3, '0919810198686', 'madiha@thekings.biz', '0', 1),
(5, 'ahmad', '61243c7b9a4022cb3f8dc3106767ed12', 'ahmad', 'mr', 'Ayan', 'Ahmad', '05-07-2001', 1, '0919971458215', 'ayazn@hotmail.com', '1465201975', 1),
(6, 'admin', '0baea2f0ae20150db78f58cddac442a9', 'superuser', 'mr', 'Admin', 'Superuser', '00-00-000', 5, '9876543210', 'admin@example.com', '0', 1);

-- --------------------------------------------------------

--
-- Structure for view `order_sum_qty`
--
DROP TABLE IF EXISTS `order_sum_qty`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `order_sum_qty` AS select `sw_order_items`.`oi_id` AS `oi_id`,`sw_order_items`.`oi_rel_pr_id` AS `oi_rel_pr_id`,`sw_order_items`.`oi_rel_or_id` AS `oi_rel_or_id`,`sw_order_items`.`oi_qty` AS `oi_qty`,`sw_order_items`.`oi_price_for_one` AS `oi_price_for_one`,`sw_order_items`.`oi_valid` AS `oi_valid`,sum(`sw_order_items`.`oi_qty`) AS `sumqtyorder` from `sw_order_items` where (`sw_order_items`.`oi_valid` = 1) group by `sw_order_items`.`oi_rel_pr_id`;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
