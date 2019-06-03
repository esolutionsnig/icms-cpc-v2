-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 23, 2019 at 05:09 AM
-- Server version: 5.7.19
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `icms_cpc`
--

-- --------------------------------------------------------

--
-- Table structure for table `active_guests`
--

DROP TABLE IF EXISTS `active_guests`;
CREATE TABLE IF NOT EXISTS `active_guests` (
  `ip` varchar(15) NOT NULL,
  `timestamp` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `active_users`
--

DROP TABLE IF EXISTS `active_users`;
CREATE TABLE IF NOT EXISTS `active_users` (
  `username` varchar(30) NOT NULL,
  `timestamp` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
CREATE TABLE IF NOT EXISTS `announcements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `updateBy` varchar(30) NOT NULL,
  `updatedOn` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

DROP TABLE IF EXISTS `banks`;
CREATE TABLE IF NOT EXISTS `banks` (
  `bank_id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(150) DEFAULT NULL,
  `bank_code` varchar(50) DEFAULT NULL,
  `bank_slug` varchar(250) DEFAULT NULL,
  `added_on` varchar(50) DEFAULT NULL,
  `added_by` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`bank_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bank_branch`
--

DROP TABLE IF EXISTS `bank_branch`;
CREATE TABLE IF NOT EXISTS `bank_branch` (
  `branch_id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_id` int(11) DEFAULT NULL,
  `branch_name` varchar(255) DEFAULT NULL,
  `branch_location` varchar(50) DEFAULT NULL,
  `branch_location_code` varchar(50) DEFAULT NULL,
  `branch_cmu` varchar(30) DEFAULT NULL,
  `branch_rep` varchar(30) DEFAULT NULL,
  `branch_slug` varchar(225) DEFAULT NULL,
  `added_on` varchar(50) DEFAULT NULL,
  `added_by` varchar(50) NOT NULL,
  PRIMARY KEY (`branch_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bank_reps`
--

DROP TABLE IF EXISTS `bank_reps`;
CREATE TABLE IF NOT EXISTS `bank_reps` (
  `br_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) DEFAULT NULL,
  `bank_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `added_on` varchar(50) DEFAULT NULL,
  `added_by` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`br_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bank_requests`
--

DROP TABLE IF EXISTS `bank_requests`;
CREATE TABLE IF NOT EXISTS `bank_requests` (
  `er_id` int(11) NOT NULL AUTO_INCREMENT,
  `er_name` varchar(255) DEFAULT NULL,
  `bank_id` varchar(255) DEFAULT NULL,
  `branch_id` varchar(255) DEFAULT NULL,
  `location_code` varchar(50) DEFAULT NULL,
  `consignment_location_id` varchar(255) DEFAULT NULL,
  `cit_reciever_id` varchar(30) DEFAULT NULL,
  `cit_confirmation_token` varchar(150) DEFAULT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `cit` varchar(4) DEFAULT 'NO',
  `cit_confirmation` varchar(15) DEFAULT 'NOT RECEIVED',
  `cit_confirmation_date` varchar(25) DEFAULT NULL,
  `er_slug` varchar(255) DEFAULT NULL,
  `client_rep` varchar(30) DEFAULT NULL,
  `updatedOn` varchar(50) DEFAULT NULL,
  `cp_done` varchar(4) DEFAULT 'NO',
  `er_status` varchar(100) DEFAULT NULL,
  `preannounced` varchar(4) DEFAULT 'NO',
  `date_execution` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`er_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `banned_users`
--

DROP TABLE IF EXISTS `banned_users`;
CREATE TABLE IF NOT EXISTS `banned_users` (
  `username` varchar(30) NOT NULL,
  `timestamp` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `book_balance`
--

DROP TABLE IF EXISTS `book_balance`;
CREATE TABLE IF NOT EXISTS `book_balance` (
  `bb_id` int(250) NOT NULL AUTO_INCREMENT,
  `bb_client` int(11) DEFAULT NULL,
  `bb_balance` int(20) NOT NULL DEFAULT '0',
  `last_update` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`bb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bundle_confirmations`
--

DROP TABLE IF EXISTS `bundle_confirmations`;
CREATE TABLE IF NOT EXISTS `bundle_confirmations` (
  `bc_id` int(11) NOT NULL AUTO_INCREMENT,
  `bcs_id` int(11) DEFAULT NULL,
  `client` varchar(255) DEFAULT NULL,
  `branch` varchar(255) DEFAULT NULL,
  `seal_number` varchar(100) DEFAULT NULL,
  `currency` varchar(50) DEFAULT NULL,
  `d1000` int(5) DEFAULT NULL,
  `d1000_category` varchar(100) DEFAULT NULL,
  `d1000_amount` int(11) NOT NULL DEFAULT '0',
  `d500` int(5) DEFAULT NULL,
  `d500_category` varchar(100) DEFAULT NULL,
  `d500_amount` int(11) NOT NULL DEFAULT '0',
  `d200` int(11) DEFAULT NULL,
  `d200_category` varchar(100) DEFAULT NULL,
  `d200_amount` int(11) NOT NULL DEFAULT '0',
  `d100` int(11) DEFAULT NULL,
  `d100_category` varchar(100) DEFAULT NULL,
  `d100_amount` int(11) NOT NULL DEFAULT '0',
  `d50` int(11) DEFAULT NULL,
  `d50_category` varchar(100) DEFAULT NULL,
  `d50_amount` int(11) NOT NULL DEFAULT '0',
  `d20` int(11) DEFAULT NULL,
  `d20_category` varchar(100) DEFAULT NULL,
  `d20_amount` int(11) NOT NULL DEFAULT '0',
  `d10` int(11) DEFAULT NULL,
  `d10_category` varchar(100) DEFAULT NULL,
  `d10_amount` int(11) NOT NULL DEFAULT '0',
  `d5` int(11) DEFAULT NULL,
  `d5_category` varchar(100) DEFAULT NULL,
  `d5_amount` int(11) NOT NULL DEFAULT '0',
  `d1` int(11) DEFAULT NULL,
  `d1_category` varchar(100) DEFAULT NULL,
  `d1_amount` int(11) NOT NULL DEFAULT '0',
  `amount` varchar(50) DEFAULT NULL,
  `added_on` varchar(50) DEFAULT NULL,
  `added_by` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`bc_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bundle_confirmation_start`
--

DROP TABLE IF EXISTS `bundle_confirmation_start`;
CREATE TABLE IF NOT EXISTS `bundle_confirmation_start` (
  `bcs_id` int(11) NOT NULL AUTO_INCREMENT,
  `bc_title` text,
  `client_id` int(11) DEFAULT NULL,
  `strim` varchar(200) DEFAULT NULL,
  `conslocation` int(11) DEFAULT NULL,
  `audit_trail_number` varchar(100) DEFAULT NULL,
  `added_by` varchar(30) DEFAULT NULL,
  `confirmation_done` varchar(4) DEFAULT 'NO',
  `ended_on` varchar(50) DEFAULT NULL,
  `reference_number` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`bcs_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cash_allocations`
--

DROP TABLE IF EXISTS `cash_allocations`;
CREATE TABLE IF NOT EXISTS `cash_allocations` (
  `ca_id` int(11) NOT NULL AUTO_INCREMENT,
  `allocated_to` varchar(30) DEFAULT NULL,
  `workstation` varchar(150) DEFAULT NULL,
  `seal_number` varchar(50) DEFAULT NULL,
  `client_name` varchar(255) DEFAULT NULL,
  `audit_trail_number` varchar(50) DEFAULT NULL,
  `currency_id` varchar(11) DEFAULT NULL,
  `denomination_id` int(11) DEFAULT NULL,
  `amount_allocated` int(11) DEFAULT NULL,
  `allocated_by` varchar(30) DEFAULT NULL,
  `allocated_on` varchar(50) DEFAULT NULL,
  `amount_returned` int(11) DEFAULT NULL,
  `returned_by` varchar(30) DEFAULT NULL,
  `returned_on` varchar(50) DEFAULT NULL,
  `ca_comment` text,
  `returned_user` varchar(30) DEFAULT NULL,
  `ca_shift` varchar(20) DEFAULT NULL,
  `is_fit` int(11) NOT NULL DEFAULT '0',
  `is_unfit` int(11) NOT NULL DEFAULT '0',
  `is_atm` int(11) NOT NULL DEFAULT '0',
  `declared_value` int(11) NOT NULL DEFAULT '0',
  `shortage` int(11) NOT NULL DEFAULT '0',
  `comment` text,
  `evidence` varchar(150) DEFAULT NULL,
  `mixups` int(11) DEFAULT '0',
  `m1000` int(11) NOT NULL DEFAULT '0',
  `m500` int(11) NOT NULL DEFAULT '0',
  `m200` int(11) NOT NULL DEFAULT '0',
  `m100` int(11) NOT NULL DEFAULT '0',
  `m50` int(11) NOT NULL DEFAULT '0',
  `m20` int(11) NOT NULL DEFAULT '0',
  `m10` int(11) NOT NULL DEFAULT '0',
  `m5` int(11) NOT NULL DEFAULT '0',
  `m1` int(11) NOT NULL DEFAULT '0',
  `fake_notes` int(11) NOT NULL DEFAULT '0',
  `fake_serial_numbers` text,
  `state_of_cash` int(11) DEFAULT NULL,
  `old_seal_number` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`ca_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cash_preparations`
--

DROP TABLE IF EXISTS `cash_preparations`;
CREATE TABLE IF NOT EXISTS `cash_preparations` (
  `er_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) DEFAULT NULL,
  `ev_req_id` int(11) DEFAULT NULL,
  `seal_number` varchar(30) DEFAULT NULL,
  `container_type_id` int(11) DEFAULT NULL,
  `deposit_type_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `currency_id` varchar(11) DEFAULT NULL,
  `cash_1000` varchar(11) DEFAULT NULL,
  `cash_1000_amount` varchar(24) DEFAULT '0',
  `cash_500` varchar(11) DEFAULT NULL,
  `cash_500_amount` varchar(24) DEFAULT '0',
  `cash_200` varchar(11) DEFAULT NULL,
  `cash_200_amount` varchar(24) DEFAULT '0',
  `cash_100` varchar(11) DEFAULT NULL,
  `cash_100_amount` varchar(24) DEFAULT '0',
  `cash_50` varchar(11) DEFAULT NULL,
  `cash_50_amount` varchar(24) DEFAULT '0',
  `cash_20` varchar(11) DEFAULT NULL,
  `cash_20_amount` varchar(24) DEFAULT '0',
  `cash_10` varchar(11) DEFAULT NULL,
  `cash_10_amount` varchar(24) DEFAULT '0',
  `cash_5` varchar(11) DEFAULT NULL,
  `cash_5_amount` varchar(24) DEFAULT '0',
  `cash_1` varchar(11) DEFAULT NULL,
  `cash_1_amount` varchar(24) DEFAULT NULL,
  `total_amount` varchar(24) DEFAULT '0',
  `client_rep` varchar(30) DEFAULT NULL,
  `updatedOn` varchar(50) DEFAULT NULL,
  `is_deleted` varchar(4) NOT NULL DEFAULT 'NO',
  `deleted_by` varchar(30) DEFAULT NULL,
  `deleted_on` varchar(30) DEFAULT NULL,
  `total_amount_bc` int(11) DEFAULT '0',
  `is_bceed` varchar(3) NOT NULL DEFAULT 'NO',
  `is_pickedup` varchar(4) NOT NULL DEFAULT 'NO',
  `pickedup_by` varchar(30) DEFAULT NULL,
  `pickedup_on` varchar(30) DEFAULT NULL,
  `is_handed_over` varchar(4) NOT NULL DEFAULT 'NO',
  `handed_over_by` varchar(30) DEFAULT NULL,
  `handed_over_on` varchar(30) DEFAULT NULL,
  `is_opened` varchar(4) NOT NULL DEFAULT 'NO',
  PRIMARY KEY (`er_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cash_processing`
--

DROP TABLE IF EXISTS `cash_processing`;
CREATE TABLE IF NOT EXISTS `cash_processing` (
  `cp_id` int(11) NOT NULL AUTO_INCREMENT,
  `allocated_to` varchar(30) DEFAULT NULL,
  `workstation` varchar(150) DEFAULT NULL,
  `seal_number` varchar(50) DEFAULT NULL,
  `client_name` varchar(255) DEFAULT NULL,
  `audit_trail_number` varchar(50) DEFAULT NULL,
  `currency_id` varchar(11) DEFAULT NULL,
  `denomination_id` int(11) DEFAULT NULL,
  `amount_allocated` int(11) DEFAULT NULL,
  `allocated_by` varchar(30) DEFAULT NULL,
  `allocated_on` varchar(50) DEFAULT NULL,
  `amount_returned` int(11) DEFAULT NULL,
  `difference` int(11) DEFAULT NULL,
  `returned_by` varchar(30) DEFAULT NULL,
  `returned_on` varchar(50) DEFAULT NULL,
  `ca_comment` text,
  `returned_user` varchar(30) DEFAULT NULL,
  `ca_shift` varchar(20) DEFAULT NULL,
  `is_fit` varchar(4) DEFAULT NULL,
  `is_unfit` varchar(4) DEFAULT NULL,
  `is_atm` varchar(4) DEFAULT NULL,
  `is_fakenote` varchar(4) DEFAULT NULL,
  `shortage` int(11) DEFAULT '0',
  `post_sorting_value` int(11) DEFAULT '0',
  `declared_value` int(11) DEFAULT '0',
  `counted_value` int(11) DEFAULT '0',
  `comment` varchar(255) DEFAULT NULL,
  `evidens` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`cp_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cit`
--

DROP TABLE IF EXISTS `cit`;
CREATE TABLE IF NOT EXISTS `cit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ev_req_id` int(11) DEFAULT NULL,
  `seal_number` varchar(30) DEFAULT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `cit_officer_id` varchar(30) DEFAULT NULL,
  `delivery_status` varchar(150) DEFAULT NULL,
  `added_on` varchar(50) DEFAULT NULL,
  `added_by` varchar(50) DEFAULT NULL,
  `picked_up_by` varchar(30) DEFAULT NULL,
  `picked_up_on` varchar(50) DEFAULT NULL,
  `received_by` varchar(30) DEFAULT NULL,
  `received_on` varchar(30) DEFAULT NULL,
  `bundle_confirmed` varchar(4) DEFAULT 'NO',
  `bundle_confirmed_comment` text,
  `bundle_confirmed_by` varchar(30) DEFAULT NULL,
  `bundle_confirmed_on` varchar(50) DEFAULT NULL,
  `bundle_confirmation_status` text,
  `old_seal_number` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `consignment_locations`
--

DROP TABLE IF EXISTS `consignment_locations`;
CREATE TABLE IF NOT EXISTS `consignment_locations` (
  `location_id` int(11) NOT NULL AUTO_INCREMENT,
  `location_name` varchar(150) DEFAULT NULL,
  `location_slug` varchar(200) DEFAULT NULL,
  `bankview` varchar(4) DEFAULT 'NO',
  `workstation` varchar(4) DEFAULT 'NO',
  PRIMARY KEY (`location_id`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `consignment_locations`
--

INSERT INTO `consignment_locations` (`location_id`, `location_name`, `location_slug`, `bankview`, `workstation`) VALUES
(1, 'Client Office', 'client-office', 'YES', 'NO'),
(2, 'Cash In Transit (CIT)', 'cash-in-transit-(cit)', 'NO', 'NO'),
(3, 'Box Room', 'box-room', 'NO', 'NO'),
(4, 'AC Vault', 'ac-vault', 'NO', 'NO'),
(5, 'AE Vault', 'ae-vault', 'NO', 'NO'),
(6, 'Bundle Confirmation Area 1', 'bundle-confirmation-area-1', 'NO', 'NO'),
(7, 'Bundle Confirmation Area 2', 'bundle-confirmation-area-2', 'NO', 'NO'),
(8, 'Processing Floor Supervisor 1', 'processing-floor-supervisor-1', 'NO', 'NO'),
(9, 'Processing Floor Supervisor 2', 'processing-floor-supervisor-2', 'NO', 'NO'),
(10, 'Work Station   VIGFS001', 'work-station-vigfs001', 'NO', 'YES'),
(11, 'Work Station   VIGFS002', 'work-station-vigfs002', 'NO', 'YES'),
(12, 'Work Station   VIGFS003', 'work-station-vigfs003', 'NO', 'YES'),
(13, 'Work Station   VIGFS004', 'work-station-vigfs004', 'NO', 'YES'),
(14, 'Work Station   VIGFS005', 'work-station-vigfs005', 'NO', 'YES'),
(15, 'Work Station   VIGFS006', 'work-station-vigfs006', 'NO', 'YES'),
(16, 'Work Station   VIGFS007', 'work-station-vigfs007', 'NO', 'YES'),
(17, 'Work Station   VIGFS008', 'work-station-vigfs008', 'NO', 'YES'),
(18, 'Work Station   VIGFS009', 'work-station-vigfs009', 'NO', 'YES'),
(19, 'Work Station   VIGFS010', 'work-station-vigfs010', 'NO', 'YES'),
(20, 'Work Station   VIGFS011', 'work-station-vigfs011', 'NO', 'YES'),
(21, 'Work Station   VIGFS012', 'work-station-vigfs012', 'NO', 'YES'),
(22, 'Work Station   VIGFS013', 'work-station-vigfs013', 'NO', 'YES'),
(23, 'Work Station   VIGFS014', 'work-station-vigfs014', 'NO', 'YES'),
(24, 'Work Station   VIGFS015', 'work-station-vigfs015', 'NO', 'YES'),
(25, 'Work Station   VIGFS016', 'work-station-vigfs016', 'NO', 'YES'),
(26, 'Work Station   VIGFS017', 'work-station-vigfs017', 'NO', 'YES'),
(27, 'Work Station   VIGFS018', 'work-station-vigfs018', 'NO', 'YES'),
(28, 'Work Station   VIGFS019', 'work-station-vigfs019', 'NO', 'YES'),
(29, 'Work Station   VIGFS020', 'work-station-vigfs020', 'NO', 'YES'),
(30, 'Work Station   VIGFS021', 'work-station-vigfs021', 'NO', 'YES'),
(31, 'Work Station   VIGFS022', 'work-station-vigfs022', 'NO', 'YES'),
(32, 'Work Station   VIGFS023', 'work-station-vigfs023', 'NO', 'YES'),
(33, 'Work Station   VIGFS024', 'work-station-vigfs024', 'NO', 'YES'),
(34, 'Work Station   VIGFS025', 'work-station-vigfs025', 'NO', 'YES'),
(35, 'Work Station   VIGFS026', 'work-station-vigfs026', 'NO', 'YES'),
(36, 'Work Station   VIGFS028', 'work-station-vigfs028', 'NO', 'YES'),
(37, 'Work Station   VIGFS029', 'work-station-vigfs029', 'NO', 'YES'),
(38, 'Work Station   VIGFS030', 'work-station-vigfs030', 'NO', 'YES'),
(39, 'ICMS VI CPC', 'icms-vi-cpc', 'YES', NULL),
(40, 'CBN Marina', 'cbn-marina', 'YES', NULL),
(41, 'Bank Hub', 'bank-hub', 'YES', NULL),
(42, 'Other Bank Branches', 'other-bank-branches', 'YES', NULL),
(43, 'Other Branches', 'other-branches', 'YES', NULL),
(44, 'ICMS CAC Vault', 'icms-cac-vault', 'NO', 'NO'),
(45, 'CBN CAC Vault', 'cbn-cac-vault', 'NO', 'NO'),
(46, 'ICMS CAD Vault', 'icms-cad-vault', 'NO', 'NO'),
(47, 'CBN CAD Vault', 'cbn-cad-vault', 'NO', 'NO'),
(48, 'PreVault', 'prevault', 'NO', 'NO'),
(49, 'Treasury', 'treasury', 'NO', 'NO');

-- --------------------------------------------------------

--
-- Table structure for table `container_types`
--

DROP TABLE IF EXISTS `container_types`;
CREATE TABLE IF NOT EXISTS `container_types` (
  `ct_id` int(11) NOT NULL AUTO_INCREMENT,
  `ct_name` varchar(50) DEFAULT NULL,
  `ct_slug` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`ct_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `container_types`
--

INSERT INTO `container_types` (`ct_id`, `ct_name`, `ct_slug`) VALUES
(1, 'Bag', 'bag'),
(2, 'Full Box', 'full-box'),
(3, 'Others', 'others'),
(4, 'Odd Box', 'odd-box');

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

DROP TABLE IF EXISTS `currencies`;
CREATE TABLE IF NOT EXISTS `currencies` (
  `currency_id` int(2) NOT NULL AUTO_INCREMENT,
  `currency_name` varchar(50) DEFAULT NULL,
  `currency_slug` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`currency_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`currency_id`, `currency_name`, `currency_slug`) VALUES
(1, 'Nigerian Naira', 'naira'),
(2, 'European Euro', 'euro'),
(3, 'US Dollar', 'usd'),
(4, 'British Pounds', 'gbp'),
(5, 'South African Rand', 'zar'),
(6, 'West African CFA', 'cfa'),
(7, 'Chinese Yuan', 'cny');

-- --------------------------------------------------------

--
-- Table structure for table `day_shift`
--

DROP TABLE IF EXISTS `day_shift`;
CREATE TABLE IF NOT EXISTS `day_shift` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dstart_title` varchar(255) DEFAULT NULL,
  `dday` varchar(30) DEFAULT NULL,
  `dshift` varchar(15) DEFAULT NULL,
  `dstarted` varchar(4) DEFAULT 'NO',
  `dstarted_by` varchar(30) DEFAULT NULL,
  `dclosed` varchar(4) NOT NULL DEFAULT 'NO',
  `dclosed_by` varchar(30) DEFAULT NULL,
  `dclosed_on` varchar(30) DEFAULT NULL,
  `dstatus` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `denominations`
--

DROP TABLE IF EXISTS `denominations`;
CREATE TABLE IF NOT EXISTS `denominations` (
  `denomination_id` int(2) NOT NULL AUTO_INCREMENT,
  `denomination_name` varchar(4) DEFAULT NULL,
  `denomination_slug` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`denomination_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `denominations`
--

INSERT INTO `denominations` (`denomination_id`, `denomination_name`, `denomination_slug`) VALUES
(1, '1000', '1000'),
(2, '500', '500'),
(3, '200', '200'),
(4, '100', '100'),
(5, '50', '50'),
(6, '20', '20'),
(7, '10', '10'),
(8, '5', '5'),
(9, '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `deposit_category`
--

DROP TABLE IF EXISTS `deposit_category`;
CREATE TABLE IF NOT EXISTS `deposit_category` (
  `dc_id` int(11) NOT NULL AUTO_INCREMENT,
  `dc_name` varchar(100) DEFAULT NULL,
  `dc_slug` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`dc_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deposit_category`
--

INSERT INTO `deposit_category` (`dc_id`, `dc_name`, `dc_slug`) VALUES
(1, 'Mint', 'mint'),
(2, 'Unfit Notes', 'unfit-notes'),
(3, 'ATM Fit Notes', 'atm-fit-notes'),
(4, 'Teller Fit Notes', 'teller-fit-notes'),
(5, 'Mutilated Notes', 'mulilated-notes'),
(6, 'Awaiting Evaluation (Unprocessed)', 'awaiting-evaluation-(unprocessed)'),
(7, 'Awaiting Evaluation (Vault)', 'awaiting-evaluation-(vault)'),
(8, 'Awaiting Evaluation (Processing Floor)', 'awaiting-evaluation-(processing-floor)'),
(9, 'Others', 'others'),
(10, 'AC Awaiting Confirmation', 'ac-awaiting-confirmation');

-- --------------------------------------------------------

--
-- Table structure for table `deposit_types`
--

DROP TABLE IF EXISTS `deposit_types`;
CREATE TABLE IF NOT EXISTS `deposit_types` (
  `dt_id` int(11) NOT NULL AUTO_INCREMENT,
  `dt_name` varchar(50) DEFAULT NULL,
  `dt_slug` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`dt_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deposit_types`
--

INSERT INTO `deposit_types` (`dt_id`, `dt_name`, `dt_slug`) VALUES
(1, 'Central Bank of Nigeria (CBN) Deposits', 'central-bank-of-nigeria-(cbn)-deposits'),
(2, 'Total Cash Solution (TCS) Deposits', 'total-cash-solution-(tcs)-deposits'),
(3, 'Cash Processing (CP) Deposits', 'cash-processing-(cp)-deposits'),
(4, 'Retail Deposits', 'retail-deposits'),
(5, 'Others', 'others');

-- --------------------------------------------------------

--
-- Table structure for table `general`
--

DROP TABLE IF EXISTS `general`;
CREATE TABLE IF NOT EXISTS `general` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) DEFAULT NULL,
  `surname` varchar(50) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `middlename` varchar(50) DEFAULT NULL,
  `dob` varchar(50) DEFAULT NULL,
  `gender` varchar(7) DEFAULT NULL,
  `phoneNumber` varchar(20) DEFAULT NULL,
  `address` text,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `occupation` varchar(200) DEFAULT NULL,
  `profile` text,
  `dp` varchar(150) DEFAULT NULL,
  `updatedOn` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `internal_movements`
--

DROP TABLE IF EXISTS `internal_movements`;
CREATE TABLE IF NOT EXISTS `internal_movements` (
  `im_id` int(11) NOT NULL AUTO_INCREMENT,
  `source_location` varchar(150) DEFAULT NULL,
  `destination_location` varchar(150) DEFAULT NULL,
  `seal_number` varchar(100) DEFAULT NULL,
  `added_on` varchar(50) DEFAULT NULL,
  `added_by` varchar(30) DEFAULT NULL,
  `received_by` varchar(30) DEFAULT NULL,
  `received_on` varchar(30) DEFAULT NULL,
  `movement_status` text,
  `is_opened` varchar(4) NOT NULL DEFAULT 'NO',
  `bc` varchar(50) NOT NULL DEFAULT 'NOT COMPLETED',
  `is_moved_out` varchar(3) NOT NULL DEFAULT 'NO',
  PRIMARY KEY (`im_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `sender` varchar(30) NOT NULL,
  `subject` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `attachFile` text NOT NULL,
  `sentOn` int(10) NOT NULL,
  `status` varchar(7) NOT NULL,
  `reciever` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `subject` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(7) NOT NULL,
  `recOn` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sealings`
--

DROP TABLE IF EXISTS `sealings`;
CREATE TABLE IF NOT EXISTS `sealings` (
  `s_id` int(11) NOT NULL AUTO_INCREMENT,
  `strim` varchar(10) DEFAULT NULL,
  `sealing_title` varchar(255) DEFAULT NULL,
  `client` varchar(255) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `container_id` int(11) DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `denomination_id` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `seal_number` varchar(50) DEFAULT NULL,
  `added_by` varchar(30) DEFAULT NULL,
  `added_on` varchar(50) DEFAULT NULL,
  `is_opened` varchar(4) NOT NULL DEFAULT 'NO',
  `total_amount_allocated` int(20) NOT NULL DEFAULT '0',
  `total_processors` int(5) NOT NULL DEFAULT '0',
  `old_seal_number` varchar(30) DEFAULT NULL,
  `seal_batch` varchar(50) DEFAULT NULL,
  `total_amount_sealed` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`s_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `seal_numbers`
--

DROP TABLE IF EXISTS `seal_numbers`;
CREATE TABLE IF NOT EXISTS `seal_numbers` (
  `seal_id` int(11) NOT NULL AUTO_INCREMENT,
  `seal_number` varchar(100) DEFAULT NULL,
  `container_type_id` int(11) DEFAULT NULL,
  `deposit_type_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `added_by` varchar(30) DEFAULT NULL,
  `added_on` varchar(50) DEFAULT NULL,
  `is_deleted` varchar(4) DEFAULT 'NO',
  `deleted_by` varchar(30) DEFAULT NULL,
  `deleted_on` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`seal_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `shifts_day`
--

DROP TABLE IF EXISTS `shifts_day`;
CREATE TABLE IF NOT EXISTS `shifts_day` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `day_id` int(11) DEFAULT NULL,
  `stitle` varchar(255) DEFAULT NULL,
  `sshift` varchar(50) DEFAULT NULL,
  `sstarted` varchar(30) DEFAULT NULL,
  `sstarted_by` varchar(30) NOT NULL,
  `sstarted_on` varchar(30) DEFAULT NULL,
  `sclosed` varchar(4) DEFAULT NULL,
  `sclosed_by` varchar(30) DEFAULT NULL,
  `sclosed_on` varchar(30) DEFAULT NULL,
  `sstatus` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `supply_requests`
--

DROP TABLE IF EXISTS `supply_requests`;
CREATE TABLE IF NOT EXISTS `supply_requests` (
  `sr_id` int(11) NOT NULL AUTO_INCREMENT,
  `client` int(11) DEFAULT NULL,
  `sr_title` varchar(255) DEFAULT NULL,
  `sr_type` varchar(255) DEFAULT NULL,
  `sr_date` varchar(20) DEFAULT NULL,
  `sr_comment` text,
  `requested_by` varchar(30) DEFAULT NULL,
  `requested_on` varchar(30) DEFAULT NULL,
  `sr_status` varchar(100) NOT NULL DEFAULT 'Pending',
  `bp_done` varchar(4) NOT NULL DEFAULT 'NO',
  `sr_slug` text,
  `cit` varchar(4) NOT NULL DEFAULT 'NO',
  `sr_verified` varchar(3) NOT NULL DEFAULT 'NO',
  `verified_by` varchar(30) DEFAULT NULL,
  `verified_on` varchar(30) DEFAULT NULL,
  `verified_comment` text,
  `sr_approved` varchar(3) NOT NULL DEFAULT 'NO',
  `approved_by` varchar(30) DEFAULT NULL,
  `approved_on` varchar(30) DEFAULT NULL,
  `approved_comment` text,
  `dispatched_by` varchar(30) DEFAULT NULL,
  `dispatched_on` varchar(30) DEFAULT NULL,
  `sr_dispatch_comment` text,
  `delivery_status` varchar(20) NOT NULL DEFAULT 'NOT DELIVERED',
  PRIMARY KEY (`sr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `supply_requests_branch`
--

DROP TABLE IF EXISTS `supply_requests_branch`;
CREATE TABLE IF NOT EXISTS `supply_requests_branch` (
  `srb_id` int(250) NOT NULL AUTO_INCREMENT,
  `sr_id` int(250) DEFAULT NULL,
  `client` int(11) DEFAULT NULL,
  `branch` int(250) DEFAULT NULL,
  `currency` int(11) DEFAULT NULL,
  `denomination` int(11) DEFAULT NULL,
  `cash_category` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT '0',
  `processed_amount` int(11) DEFAULT '0',
  `requested_by` varchar(30) DEFAULT NULL,
  `requested_on` varchar(30) DEFAULT NULL,
  `is_deleted` varchar(3) NOT NULL DEFAULT 'NO',
  `is_dispatched` varchar(3) NOT NULL DEFAULT 'NO',
  `is_dispatchedOn` varchar(30) DEFAULT NULL,
  `is_dispatchedBy` varchar(30) DEFAULT NULL,
  `cit_officer` varchar(30) DEFAULT NULL,
  `cit_vehicle` varchar(30) DEFAULT NULL,
  `is_delivered` varchar(3) NOT NULL DEFAULT 'NO',
  `is_deliveredOn` varchar(30) DEFAULT NULL,
  `is_deliveredBy` varchar(30) DEFAULT NULL,
  `is_received` varchar(3) NOT NULL DEFAULT 'NO',
  `is_receivedOn` varchar(30) DEFAULT NULL,
  `is_receivedBy` text,
  `srb_status` int(1) DEFAULT '0',
  `is_packed` varchar(3) NOT NULL DEFAULT 'NO',
  `packed_by` varchar(30) DEFAULT NULL,
  `packed_on` varchar(30) DEFAULT NULL,
  `is_splitted` varchar(3) DEFAULT 'NO',
  `seal_number` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`srb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `thrown_exceptions`
--

DROP TABLE IF EXISTS `thrown_exceptions`;
CREATE TABLE IF NOT EXISTS `thrown_exceptions` (
  `ex_id` int(11) NOT NULL AUTO_INCREMENT,
  `seal_number` varchar(50) DEFAULT NULL,
  `currency` varchar(10) DEFAULT NULL,
  `denomination` varchar(10) DEFAULT NULL,
  `expected_amount` int(20) DEFAULT NULL,
  `actual_amount` int(20) DEFAULT NULL,
  `thrown_by` varchar(30) DEFAULT NULL,
  `thrown_on` varchar(50) DEFAULT NULL,
  `thrown_comment` text,
  `thrown_to` varchar(30) DEFAULT NULL,
  `reviewed_by` varchar(30) DEFAULT NULL,
  `reviewed_on` varchar(50) DEFAULT NULL,
  `reviewed_comment` text,
  `ex_status` varchar(20) DEFAULT 'Unresolved',
  PRIMARY KEY (`ex_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(30) NOT NULL,
  `surname` varchar(50) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `middlename` varchar(50) DEFAULT NULL,
  `phoneno` varchar(30) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `address` text,
  `password` varchar(32) DEFAULT NULL,
  `userid` varchar(32) DEFAULT NULL,
  `userlevel` tinyint(1) UNSIGNED NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `userdp` varchar(100) DEFAULT NULL,
  `todayview` int(2) NOT NULL DEFAULT '0',
  `timestamp` int(11) UNSIGNED NOT NULL,
  `registration_status` varchar(12) NOT NULL DEFAULT 'Pending',
  `approved_by` varchar(30) DEFAULT NULL,
  `approved_on` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `surname`, `firstname`, `middlename`, `phoneno`, `gender`, `address`, `password`, `userid`, `userlevel`, `email`, `userdp`, `todayview`, `timestamp`, `registration_status`, `approved_by`, `approved_on`) VALUES
('abang', 'Okon', 'Abang', 'Ofoneme', '08026365214', NULL, NULL, '46b7050a21307101930c1fae3efa062a', '4669c1358561d36e92a096e0de583359', 15, 'a.okon@mail.com', NULL, 0, 1554809019, 'Approved', 'sadmin', '1551942799'),
('babafemi', 'Amos', 'Babafemi', '', '08025413696', NULL, NULL, '46b7050a21307101930c1fae3efa062a', '00fd27b7648540186c2228908b34597d', 20, 'b.amos@mail.com', NULL, 0, 1558442424, 'Approved', 'sadmin', '1551942763'),
('bankcmu', 'bank', 'cmu', '', '08012121212', NULL, NULL, '7d302f675bac337d6223fd8a09d52a23', '8eb75f755f35e65fae0cfa3d77f26e63', 15, 'bcmu@icms.ng', NULL, 0, 1558438199, 'Approved', 'sadmin', '1551942763'),
('bankrep', 'bank', 'rep', '', '08051114414', NULL, NULL, '3db146b313529abd629f0c35d77e4637', '0', 14, 'bankrep@icms.ng', NULL, 0, 1551859984, 'Approved', 'sadmin', '1551942763'),
('blaze', 'James', 'John', 'Blaze', '07025896374', NULL, NULL, '46b7050a21307101930c1fae3efa062a', 'a1e7c81401dbc645ae3ebc6bc673dd0a', 15, 'jb.james@mail.com', NULL, 0, 1553520723, 'Approved', 'sadmin', '1551915932'),
('cashprocessing', 'Cash Processing', 'Officer', '', '08122454112', NULL, NULL, 'b52ce3aa813c1e46171fe7113e82603e', 'c0f1ba8f3e448a2374fb97708b1a954d', 4, 'cashprocessingofficer@icms.ng', NULL, 0, 1551367415, 'Approved', 'sadmin', '1551942763'),
('chinyeaka', 'Nwazuluoke', 'Chinyeaka', '', '08022222222', NULL, NULL, '46b7050a21307101930c1fae3efa062a', '0', 4, 'c.nwa@icms.ng', NULL, 0, 1551265717, 'Approved', 'sadmin', '1551942799'),
('cpsupervisor', 'C.P.', 'supervisor', '', '07122121315', NULL, NULL, 'e09ab17db54c077960a6db4e030e1214', 'ed7429f02bb1615626b642fdb9a64da1', 5, 'cpsupo@icms.ng', NULL, 0, 1557810541, 'Approved', 'sadmin', '1551942763'),
('fabian', 'Chuckwuma', 'Fabian', '', '07052418596', NULL, NULL, '46b7050a21307101930c1fae3efa062a', '33ef904d178834a3e543bb76aa2e6a46', 12, 'f.chukwuma@mail.com', NULL, 0, 1554880149, 'Approved', 'sadmin', '1551942763'),
('florence', 'Dambazau', 'Florence', 'Aisha', '09025412563', NULL, NULL, '46b7050a21307101930c1fae3efa062a', 'ead43354901b8f7e76216652580c9a99', 14, 'f.dambazau@mail.com', NULL, 0, 1550567432, 'Approved', 'sadmin', '1551942763'),
('gandoki', 'Lai', 'Gandoki', 'M', '09025415874', NULL, NULL, '46b7050a21307101930c1fae3efa062a', '0de8ebc653abe007d14975c1eda94a59', 13, 'g.lai@mail.com', NULL, 0, 1554880065, 'Approved', 'sadmin', '1551942799'),
('gifty', 'Tobore', 'Gift', '', '08025417485', NULL, NULL, '46b7050a21307101930c1fae3efa062a', '459fb47f0949acbe8e6c92cb48887658', 5, 'g.tobore@mail.com', NULL, 0, 1553629053, 'Approved', 'sadmin', '1551942799'),
('icmsboxroom', 'ICMS', 'Box Room', '', '07011111111', NULL, NULL, '7ee8f8b3fab14730721531cf94288fdb', 'ce8760a2c99c5b4a221873bb4d1eeed8', 1, 'boxroom@icms.ng', NULL, 0, 1557756568, 'Approved', 'sadmin', '1551942799'),
('icmscmo', 'ICMS', 'CMO', '', '08012141516', NULL, NULL, 'fc118d762d2a6f04303590dda6821793', '439f0b66c396915ec19e7beae021dbc9', 13, 'icmscmo@icms.ng', NULL, 0, 1557756207, 'Approved', 'sadmin', '1551942763'),
('icmsvault', 'ICMS', 'Vault Officer', '', '07012121415', NULL, NULL, 'db37b0cbedf349c988283515e64740bd', 'e1af089468c0bd0722ff6ca9e1dfff6e', 2, 'vault@icms.ng', NULL, 0, 1557756647, 'Approved', 'sadmin', '1551942799'),
('janey', 'Doe', 'Jane', '', '08025412589', NULL, NULL, '46b7050a21307101930c1fae3efa062a', '0', 4, 'j.doe@mail.com', NULL, 0, 1550484538, 'Approved', 'sadmin', '1551942763'),
('kendric', 'Eric', 'Kendric', '', '09025635245', NULL, NULL, '46b7050a21307101930c1fae3efa062a', 'cc81172384c58af2bdce028b63171aa2', 13, 's.eric@mail.com', NULL, 0, 1551259820, 'Approved', 'sadmin', '1551942763'),
('onyinyechi', 'Okusaga', 'Onyinyechi', '', '08025417896', NULL, NULL, '46b7050a21307101930c1fae3efa062a', 'c20474631af37aadb9d28d080a374f47', 8, 'o.okusaga@mail.com', NULL, 0, 1553599216, 'Approved', 'sadmin', '1551942799'),
('sadmin', 'John', 'Doe', 'M', '08020689069', 'Male', 'Plot 8, Gbagada Road, Gbagada, Lagos State, Nigeria.', '46b7050a21307101930c1fae3efa062a', '37a3efe87754a2d0f710c2f19c6d68f9', 20, 'ibeh_ernest@yahoo.com', '783176s5.jpg', 0, 1554973350, 'Approved', NULL, NULL),
('seriki', 'Seriki', 'Ismail', '', '07085748596', NULL, NULL, '46b7050a21307101930c1fae3efa062a', '33b32e236d9fca6e0294d08f84fec867', 3, 's.ismail@mail.com', NULL, 0, 1554973089, 'Approved', 'sadmin', '1551942799'),
('shinene', 'Ochonganoko', 'Shinene', 'B', '080251478596', NULL, NULL, '46b7050a21307101930c1fae3efa062a', '0', 4, 's.ochonganoko@mail.com', NULL, 0, 1550484661, 'Approved', 'sadmin', '1551942799'),
('smith', 'Mark', 'Smith', '', '07025896324', NULL, NULL, '46b7050a21307101930c1fae3efa062a', '0', 14, 's.mark@mail.com', NULL, 0, 1550484759, 'Approved', 'sadmin', '1551942799'),
('treasury', 'Treasury', 'Officer', '', '07121242512', NULL, NULL, '9640c8ba168953bacddef0bd3681546b', '3e6e2e157732f68103e2e92d5db133ad', 7, 'treasury@icms.ng', NULL, 0, 1557758064, 'Approved', 'sadmin', '1551942813');

-- --------------------------------------------------------

--
-- Table structure for table `vault`
--

DROP TABLE IF EXISTS `vault`;
CREATE TABLE IF NOT EXISTS `vault` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) DEFAULT NULL,
  `seal_number` varchar(30) DEFAULT NULL,
  `added_by` varchar(30) DEFAULT NULL,
  `added_on` varchar(50) DEFAULT NULL,
  `counted` varchar(4) NOT NULL DEFAULT 'NO',
  `counted_by` varchar(30) DEFAULT NULL,
  `counted_on` varchar(30) DEFAULT NULL,
  `currency` varchar(50) DEFAULT NULL,
  `denomination` int(5) DEFAULT NULL,
  `amount` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

DROP TABLE IF EXISTS `vehicles`;
CREATE TABLE IF NOT EXISTS `vehicles` (
  `vehicle_id` int(11) NOT NULL AUTO_INCREMENT,
  `vehicle_number` varchar(12) DEFAULT NULL,
  `vehicle_name` varchar(100) DEFAULT NULL,
  `vehicle_slug` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`vehicle_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
