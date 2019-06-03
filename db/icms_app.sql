-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 03, 2019 at 01:30 PM
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
-- Database: `icms_app`
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

--
-- Dumping data for table `active_guests`
--

INSERT INTO `active_guests` (`ip`, `timestamp`) VALUES
('::1', 1559196834);

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
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bankreps`
--

DROP TABLE IF EXISTS `bankreps`;
CREATE TABLE IF NOT EXISTS `bankreps` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `banks_id` int(10) UNSIGNED NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `added_on` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `added_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bankreps_banks_id_index` (`banks_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bankreps`
--

INSERT INTO `bankreps` (`id`, `username`, `banks_id`, `branch_id`, `added_on`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 'bankcmu', 1, NULL, '1559223347', 'sadmin', NULL, NULL),
(2, 'bankrep', 1, NULL, '1559223362', 'sadmin', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

DROP TABLE IF EXISTS `banks`;
CREATE TABLE IF NOT EXISTS `banks` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_slug` text COLLATE utf8mb4_unicode_ci,
  `added_by` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `added_on` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`id`, `bank_name`, `bank_code`, `bank_slug`, `added_by`, `added_on`, `created_at`, `updated_at`) VALUES
(1, 'Fidelity Bank Plc', 'Fidelity', 'fidelity-bank-plc', 'sadmin', '1559221985', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bank_branches`
--

DROP TABLE IF EXISTS `bank_branches`;
CREATE TABLE IF NOT EXISTS `bank_branches` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `banks_id` int(10) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci,
  `branch_location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_location_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_cmu` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_rep` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` text COLLATE utf8mb4_unicode_ci,
  `added_on` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `added_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bank_branches_banks_id_index` (`banks_id`)
) ENGINE=MyISAM AUTO_INCREMENT=88 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bank_branches`
--

INSERT INTO `bank_branches` (`id`, `banks_id`, `name`, `branch_location`, `branch_location_code`, `branch_cmu`, `branch_rep`, `slug`, `added_on`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'OBASANJO MAIN (ASPAMDA)', 'TRADE FAIR COMPLEX, BADAGRY EXPRESSWAY', '006', 'bankcmu', 'bankrep', 'obasanjo-main-(aspamda)', '1559224669', 'sadmin', NULL, NULL),
(2, 1, 'BBA', 'ATIKU ABUBAKAR HALL, BBA TRADE FAIR COMPLEX', '018', 'bankcmu', 'bankrep', 'bba', '1559224715', 'sadmin', NULL, NULL),
(3, 1, 'Ojo Alaba', 'H44/45 OLOJO DRIVEÂ  OJO, ALABA', '075', 'bankcmu', 'bankrep', 'ojo-alaba', '1559224755', 'sadmin', NULL, NULL),
(4, 1, 'Alaba Cash Center', 'D 592 Electrical section, Alaba Int&#39;l Market Ojo', '075', 'bankcmu', 'bankrep', 'alaba-cash-center', '1559224793', 'sadmin', NULL, NULL),
(5, 1, 'GZI Cash Center', 'Area 5,Ipenrin gate , Opic Estate I Agbara industrial estate ogun state', '075', 'bankcmu', 'bankrep', 'gzi-cash-center', '1559224824', 'sadmin', NULL, NULL),
(6, 1, 'APT', 'ASSOCIATION OF PROGRESSIVE TRADERS MKT, TRADE FAIR ', '078', 'bankcmu', 'bankrep', 'apt', '1559224883', 'sadmin', NULL, NULL),
(7, 1, 'Orile/Coker', '1ST Floor Â Â Block 16, Agric Â Market ,Orile , Lagos, not', '086', 'bankcmu', 'bankrep', 'orile/coker', '1559224913', 'sadmin', NULL, NULL),
(8, 1, 'Festac', 'PLOT K, FIRST AVENUE BY CANAL, FESTAC  TOWN', '097', 'bankcmu', 'bankrep', 'festac', '1559224941', 'sadmin', NULL, NULL),
(9, 1, 'Ire-Akari', '42/44,IRE AKARI ESTATE ROAD ISOLO', '133', 'bankcmu', 'bankrep', 'ire-akari', '1559224967', 'sadmin', NULL, NULL),
(10, 1, 'Alaba 2', 'BB 68 Japan Line.(Electronics Market) Alaba Int&#39;l Market', '178', 'bankcmu', 'bankrep', 'alaba-2', '1559225006', 'sadmin', NULL, NULL),
(11, 1, 'Odunade', '27,Â BADAGRY EXPRESSWAY,ODUNADE BUILDING MATERIAL MARKET,COKER ORILE,Â LAGOS', '180', 'bankcmu', 'bankrep', 'odunade', '1559225050', 'sadmin', NULL, NULL),
(12, 1, 'Old Ojo Road', 'No 39 Old Ojo Road,Mazamaza, Lagos', '196', 'bankcmu', 'bankrep', 'old-ojo-road', '1559225077', 'sadmin', NULL, NULL),
(13, 1, 'Ago Palace', 'Â No 99 Ago Palace Way,Okota.', '207', 'bankcmu', 'bankrep', 'ago-palace', '1559225102', 'sadmin', NULL, NULL),
(14, 1, 'Ejigbo', '96 EGBE ROAD, EJIGBO', '233', 'bankcmu', 'bankrep', 'ejigbo', '1559225139', 'sadmin', NULL, NULL),
(15, 1, 'Ijesha', '10 Odofin Park Estate, By Lords Chosen Church, Ijesha Bus Stop, Along Oshodi Apapa Express way, Lagos.', '240', 'bankcmu', 'bankrep', 'ijesha', '1559225167', 'sadmin', NULL, NULL),
(16, 1, 'Ikeja Allen', '2A ALLEN AVENUE, IKEJA, LAGOS', '003', 'bankcmu', 'bankrep', 'ikeja-allen', '1559225197', 'sadmin', NULL, NULL),
(17, 1, 'Oregun', '53, KUDIRAT ABIOLA WAY, OREGUN IKEJA', '033', 'bankcmu', 'bankrep', 'oregun', '1559225220', 'sadmin', NULL, NULL),
(18, 1, 'Nahco', 'NAHCO COMPLEX, MURITALA MOHAMMED INT&#39;L AIRPORT, IKEJA, LAGOS', '042', 'bankcmu', 'bankrep', 'nahco', '1559225244', 'sadmin', NULL, NULL),
(19, 1, 'Ojota', 'KM 16, IKORODU ROAD OJOTA B/STOP', '142', 'bankcmu', 'bankrep', 'ojota', '1559225286', 'sadmin', NULL, NULL),
(20, 1, 'Ikeja Oba Akran', '21, OBA AKRAN AVENUE, IKEJA, LAGOS', '080', 'bankcmu', 'bankrep', 'ikeja-oba-akran', '1559225317', 'sadmin', NULL, NULL),
(21, 1, 'Computer Village', '16,OLA AYENI STREET, BY OTIGBA STREET,  IKEJA ,LAGOS', '087', 'bankcmu', 'bankrep', 'computer-village', '1559225347', 'sadmin', NULL, NULL),
(22, 1, 'Ogba', 'PLOT P, BLOCK 2, OGBA HOUSING SCHEME, OGUNNUSI RD (old Isheri Rd), OGBA, IKEJA, LAGOS', '174', 'bankcmu', 'bankrep', 'ogba', '1559225398', 'sadmin', NULL, NULL),
(23, 1, 'Ilupeju', '42, Coker road , Ilupeju Lagos', '203', 'bankcmu', 'bankrep', 'ilupeju', '1559225461', 'sadmin', NULL, NULL),
(24, 1, 'Airport Road', '39, INTERNATIONAL AIRPORT RD (BESIDE IBIS HOTEL), LAGOS', '173', 'bankcmu', 'bankrep', 'airport-road', '1559225489', 'sadmin', NULL, NULL),
(25, 1, 'GRA Ikeja', '49, Isaac John Street, GRA, Ikeja Lagos', '234', 'bankcmu', 'bankrep', 'gra-ikeja', '1559225555', 'sadmin', NULL, NULL),
(26, 1, 'Egbeda', '45 Idimu Road by Pipeline bus stop  Idimu Lagos', '112', 'bankcmu', 'bankrep', 'egbeda', '1559225583', 'sadmin', NULL, NULL),
(27, 1, 'Egbeda Cash Center', 'OLUGBEDE MODEL MKT, EGBEDA.', '112', 'bankcmu', 'bankrep', 'egbeda-cash-center', '1559225616', 'sadmin', NULL, NULL),
(28, 1, 'Dopemu', '6/8 DOPEMU ROUNDABOUT, LAGOS', '074', 'bankcmu', 'bankrep', 'dopemu', '1559225641', 'sadmin', NULL, NULL),
(29, 1, 'Alagbado', '327/329  ABEOKUTA EXPRESS WAY,BY CASSO BUS STOP,ALAGBADO LAGOS', '146', 'bankcmu', 'bankrep', 'alagbado', '1559225668', 'sadmin', NULL, NULL),
(30, 1, 'Agege', 'No 28/29 Iju Road,By Pen Cinema Round About,Agege.', '192', 'bankcmu', 'bankrep', 'agege', '1559225695', 'sadmin', NULL, NULL),
(31, 1, 'Ikorodu', '54 LAGOS ROAD IKORODU', '175', 'bankcmu', 'bankrep', 'ikorodu', '1559225719', 'sadmin', NULL, NULL),
(32, 1, 'LASPOTECH Ikorodu', 'Lagos State Polytechnic, 2nd Gate, Ikorodu, Lagos', '175', 'bankcmu', 'bankrep', 'laspotech-ikorodu', '1559225746', 'sadmin', NULL, NULL),
(33, 1, 'Iyana Ipaja', '66, NEW IPAJA ROAD, ALAGUNTAN B/STOP, IYANA IPAJA, LAGOS.', '208', 'bankcmu', 'bankrep', 'iyana-ipaja', '1559225768', 'sadmin', NULL, NULL),
(34, 1, 'Ketu', '576, IKORODU ROAD KETU LAGOS', '165', 'bankcmu', 'bankrep', 'ketu', '1559225812', 'sadmin', NULL, NULL),
(35, 1, 'Oshodi', '18A OSHODI-APAPA EXPRESSWAY, OSHODI, LAGOS', '137', 'bankcmu', 'bankrep', 'oshodi', '1559225838', 'sadmin', NULL, NULL),
(36, 1, 'Oshodi Cash Center', 'No 11, BANJOKO STREET, OSHODI MARKET ', '137', 'bankcmu', 'bankrep', 'oshodi-cash-center', '1559225860', 'sadmin', NULL, NULL),
(37, 1, 'Mushin', '299, AGEGE MOTOR RD, MUSHIN.', '113', 'bankcmu', 'bankrep', 'mushin', '1559225883', 'sadmin', NULL, NULL),
(38, 1, 'Shomolu Cash Center', 'Shomolu local govt. Council, 5 Humani Street Off Bajulaiye Road Shomolu Lagos', '113', 'bankcmu', 'bankrep', 'shomolu-cash-center', '1559225912', 'sadmin', NULL, NULL),
(39, 1, 'Igando', ' 46 Igando Ikotun Road Igando', '241', 'bankcmu', 'bankrep', 'igando', '1559225930', 'sadmin', NULL, NULL),
(40, 1, 'Oyingbo', '28 KANO STREET, EBUTE META, LAGOS', '005', 'bankcmu', 'bankrep', 'oyingbo', '1559225964', 'sadmin', NULL, NULL),
(41, 1, 'Ladipo', '84 LADIPO STREET, MATORI, LAGOS', '012', 'bankcmu', 'bankrep', 'ladipo', '1559225983', 'sadmin', NULL, NULL),
(42, 1, 'Gbagada', '27 DIYA STREET, GBAGADA, LAGOS', '022', 'bankcmu', 'bankrep', 'gbagada', '1559226003', 'sadmin', NULL, NULL),
(43, 1, 'Yaba (Birrel Avenue)', '326, HERBERT MACAULAY WAY, BY BIRREL AVENUE, YABA', '026', 'bankcmu', 'bankrep', 'yaba-(birrel-avenue)', '1559226034', 'sadmin', NULL, NULL),
(44, 1, 'Matori', '143 LADIPO STREET, MATORI, LAGOS', '045', 'bankcmu', 'bankrep', 'matori', '1559226054', 'sadmin', NULL, NULL),
(45, 1, 'PromiseLand Cash Center', '1-5, JIMADE CLOSE, PROMISELAND AUTO DEALERS MKT, MATORI.', '045', 'bankcmu', 'bankrep', 'promiseland-cash-center', '1559226096', 'sadmin', NULL, NULL),
(46, 1, 'Ebute-Meta', '11C WILLOUGBY STREET, EBUTE META, LAGOS', '073', 'bankcmu', 'bankrep', 'ebute-meta', '1559226117', 'sadmin', NULL, NULL),
(47, 1, 'Akoka', '95 SAINT FINBARS RD AKOKA', '128', 'bankcmu', 'bankrep', 'akoka', '1559226168', 'sadmin', NULL, NULL),
(48, 1, 'Tejuosho', '57 TEJUOSHO ROAD LAGOS', '141', 'bankcmu', 'bankrep', 'tejuosho', '1559226196', 'sadmin', NULL, NULL),
(49, 1, 'Fadeyi', '70 Ikorodu Road, Fadeyi', '157', 'bankcmu', 'bankrep', 'fadeyi', '1559226228', 'sadmin', NULL, NULL),
(50, 1, 'Aguda', ' 27 & 29 Enitan Street, Aguda', '158', 'bankcmu', 'bankrep', 'aguda', '1559226348', 'sadmin', NULL, NULL),
(51, 1, 'Bode Thomas Surulere', '40 Bode Thomas Street, Surulere, Lagos', '200', 'bankcmu', 'bankrep', 'bode-thomas-surulere', '1559226382', 'sadmin', NULL, NULL),
(52, 1, 'ORILE STEEL MARKETÂ  Cash Center', 'ORILE STEEL MARKETÂ  ', '200', 'bankcmu', 'bankrep', 'orile-steel-market-cash-center', '1559226414', 'sadmin', NULL, NULL),
(53, 1, 'Apapa Road Branch', 'No. 102 Apapa Road , Costain', '229', 'bankcmu', 'bankrep', 'apapa-road-branch', '1559226439', 'sadmin', NULL, NULL),
(54, 1, 'Apapa Burma', '11,BURMA ROAD, APAPA LAGOS', '009', 'bankcmu', 'bankrep', 'apapa-burma', '1559226473', 'sadmin', NULL, NULL),
(55, 1, 'Apapa Warehouse', '39 WAREHOUSE ROAD APAPA LAGOS', '031', 'bankcmu', 'bankrep', 'apapa-warehouse', '1559226500', 'sadmin', NULL, NULL),
(56, 1, 'Kofo Abayomi Apapa', '33 KOFO ABAYOMI STREET APAPA, LAGOS', '079', 'bankcmu', 'bankrep', 'kofo-abayomi-apapa', '1559226532', 'sadmin', NULL, NULL),
(57, 1, 'Ibafon', '16, APAPA-OSHODI EXPRESSWAY, OPPOSITE IBRU JETTY, APAPA, LAGOS', '083', 'bankcmu', 'bankrep', 'ibafon', '1559226559', 'sadmin', NULL, NULL),
(58, 1, 'Tincan', 'BEHIND CUSTOM LONG ROOM TINCAN', '088', 'bankcmu', 'bankrep', 'tincan', '1559226578', 'sadmin', NULL, NULL),
(59, 1, 'Apapa Park Lane', '16B PARKLANE APAPA LAGOS', '132', 'bankcmu', 'bankrep', 'apapa-park-lane', '1559226598', 'sadmin', NULL, NULL),
(60, 1, 'Trinity', '225, kiri-kiri Rd, by Trinity Bus-stop, Olodi Apapa', '161', 'bankcmu', 'bankrep', 'trinity', '1559226619', 'sadmin', NULL, NULL),
(61, 1, 'Boundary', 'BOUNDARY MARKET OFF MOBIL ROAD, AJEGUNLE APAPA, LAGOS', '188', 'bankcmu', 'bankrep', 'boundary', '1559226641', 'sadmin', NULL, NULL),
(62, 1, 'Ijora Badiya', '19,Â  SARI IGANMU ROAD,IJORA BADIYA LAGOS', '199', 'bankcmu', 'bankrep', 'ijora-badiya', '1559226676', 'sadmin', NULL, NULL),
(63, 1, 'Suru Alaba', 'Â FOLASHADE TINUBU OJO ULTRA MODERN MARKET COMPLEX, SURU ALABA , LAGOS', '216', 'bankcmu', 'bankrep', 'suru-alaba', '1559226698', 'sadmin', NULL, NULL),
(64, 1, 'Oke Arin', '31, DADDY ALHAJA STREET, OFF OKE-ARIN STREET.', '004', 'bankcmu', 'bankrep', 'oke-arin', '1559226731', 'sadmin', NULL, NULL),
(65, 1, 'Idumagbo', '18, IDUMAGBO AVENUE, LAGOS ISLAND, LAGOS', '014', 'bankcmu', 'bankrep', 'idumagbo', '1559226752', 'sadmin', NULL, NULL),
(66, 1, 'Awolowo Road', '19A, AWOLOWO ROAD, IKOYI, LAGOS', '027', 'bankcmu', 'bankrep', 'awolowo-road', '1559226804', 'sadmin', NULL, NULL),
(67, 1, 'Idumota', '101/103, ENU-OWA STREET, IDUMOTA, LAGOS', '028', 'bankcmu', 'bankrep', 'idumota', '1559226824', 'sadmin', NULL, NULL),
(68, 1, 'Broad Street', '132, BROAD STREET, LAGOS ISLAND, LAGOS', '039', 'bankcmu', 'bankrep', 'broad-street', '1559226852', 'sadmin', NULL, NULL),
(69, 1, 'Enuowa', '69, ENU-OWA STREET, LAGOS ISLAND, LAGOS', '072', 'bankcmu', 'bankrep', 'enuowa', '1559226876', 'sadmin', NULL, NULL),
(70, 1, 'Balogun (FTH)', 'FINANCIAL TRUST HOUSE, 1-4, BALOGUN STR, LAGOS ISLAND, LAGOS', '076', 'bankcmu', 'bankrep', 'balogun-(fth)', '1559226981', 'sadmin', NULL, NULL),
(71, 1, 'Moloney', '3/5, MOLONEY STREET, BEHIND TBS RACE COURSE, LAGOS', '140', 'bankcmu', 'bankrep', 'moloney', '1559227004', 'sadmin', NULL, NULL),
(72, 1, 'Bamgbose', 'NO 6 BAMGBOSE STREET LAGOS ISLAND', '231', 'bankcmu', 'bankrep', 'bamgbose', '1559227022', 'sadmin', NULL, NULL),
(73, 1, 'Victoria Garden City (VGC)', 'PLOT 8, KM 22 LAGOS-EPE EXPRESSWAY, VGC', '007', 'bankcmu', 'bankrep', 'victoria-garden-city-(vgc)', '1559227060', 'sadmin', NULL, NULL),
(74, 1, 'Corporate Branch', '2, KOFO ABAYOMI STREET, VICTORIA ISLAND, LAGOS', '016', 'bankcmu', 'bankrep', 'corporate-branch', '1559227092', 'sadmin', NULL, NULL),
(75, 1, 'LBS', 'Plot 6, Block 11,Budo farm Layout Ajiwe Â Ajah Lagos', '020', 'bankcmu', 'bankrep', 'lbs', '1559227111', 'sadmin', NULL, NULL),
(76, 1, 'Adetokunbo Ademola', '16 ADETOKUNBO ADEMOLA STREET, V/I, LAGOS', '038', 'bankcmu', 'bankrep', 'adetokunbo-ademola', '1559227139', 'sadmin', NULL, NULL),
(77, 1, 'ALEXANDER (ENSEC)', '20b Â Modupe Alakija street, Ikoyi Lagos', '050', 'bankcmu', 'bankrep', 'alexander-(ensec)', '1559227205', 'sadmin', NULL, NULL),
(78, 1, 'Ahmadu Bello', 'No 141 Ahmadu Bello Way opposite Silver Bird Gallery Victoria Island Lagos', '062', 'bankcmu', 'bankrep', 'ahmadu-bello', '1559227237', 'sadmin', NULL, NULL),
(79, 1, 'Adeyemo Alakija', '2 ADEYEMO ALAKIJA STREET, V/ISLAND, LAGOS', '082', 'bankcmu', 'bankrep', 'adeyemo-alakija', '1559227264', 'sadmin', NULL, NULL),
(80, 1, 'SAKA TINUBU (MINI BRANCH)', 'No 10 Saka Tinubu Street,Victoria Island Lagos', '085', 'bankcmu', 'bankrep', 'saka-tinubu-(mini-branch)', '1559227298', 'sadmin', NULL, NULL),
(81, 1, 'ADEOLA HOPEWELL (MINI BRANCH)', '36, ADEOLA HOPEWELL, VICTORIA ISLAND, LAGOS', '091', 'bankcmu', 'bankrep', 'adeola-hopewell-(mini-branch)', '1559227331', 'sadmin', NULL, NULL),
(82, 1, 'Lekki (Oniru)', 'LAYOUT  B,PLOT 3,BLK 2, ONIRU PRIVATE EST, LEKKI-LAGOS', '098', 'bankcmu', 'bankrep', 'lekki-(oniru)', '1559227365', 'sadmin', NULL, NULL),
(83, 1, 'Ikota', 'BLOCK O,SHOP 80-88, ROAD 1 IKOTA SHOPPING COMPLEX LAGOS', '145', 'bankcmu', 'bankrep', 'ikota', '1559227402', 'sadmin', NULL, NULL),
(84, 1, 'Adeola Odeku', '28, ADEOLA ODEKU STREET, VICTORIA ISLAND, LAGOS', '169', 'bankcmu', 'bankrep', 'adeola-odeku', '1559227426', 'sadmin', NULL, NULL),
(85, 1, 'Ibeju Lekki', 'IBEJU LEKKI LOCAL GOVERNMENT SECRETARIAT,KM 47 LEKKI-EPE EXPRESSWAY, IGANDO-OLOJA TOWN, LAGOS STATE.', '176', 'bankcmu', 'bankrep', 'ibeju-lekki', '1559227447', 'sadmin', NULL, NULL),
(86, 1, 'Badore', '20 BADORE ROAD, AJAH, LAGOS ', '217', 'bankcmu', 'bankrep', 'badore', '1559227468', 'sadmin', NULL, NULL),
(87, 1, 'Admiralty', 'BLOCK A9, PLOT 2B, ADMIRALTY WAY, LEKKI, LAGOS', '219', 'bankcmu', 'bankrep', 'admiralty', '1559227491', 'sadmin', NULL, NULL);

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
-- Table structure for table `bookballances`
--

DROP TABLE IF EXISTS `bookballances`;
CREATE TABLE IF NOT EXISTS `bookballances` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `banks_id` int(10) UNSIGNED NOT NULL,
  `bb_balance` int(11) NOT NULL,
  `last_update` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bookballances_banks_id_index` (`banks_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookballances`
--

INSERT INTO `bookballances` (`id`, `banks_id`, `bb_balance`, `last_update`, `created_at`, `updated_at`) VALUES
(1, 1, 15000000, '1559565527', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bundleconfirmationbags`
--

DROP TABLE IF EXISTS `bundleconfirmationbags`;
CREATE TABLE IF NOT EXISTS `bundleconfirmationbags` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `bundleconfirmation_id` int(10) UNSIGNED NOT NULL,
  `client` int(11) DEFAULT NULL,
  `branch` int(11) DEFAULT NULL,
  `seal_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `d1000` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `d1000_category` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `d1000_amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `d500` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `d500_category` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `d500_amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `d200` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `d200_category` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `d200_amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `d100` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `d100_category` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `d100_amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `d50` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `d50_category` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `d50_amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `d20` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `d20_category` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `d20_amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `d10` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `d10_category` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `d10_amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `d5` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `d5_category` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `d5_amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `d1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `d1_category` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `d1_amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` int(11) NOT NULL DEFAULT '0',
  `added_on` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `added_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bundleconfirmationbags_bundleconfirmation_id_index` (`bundleconfirmation_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bundleconfirmationbags`
--

INSERT INTO `bundleconfirmationbags` (`id`, `bundleconfirmation_id`, `client`, `branch`, `seal_number`, `currency`, `d1000`, `d1000_category`, `d1000_amount`, `d500`, `d500_category`, `d500_amount`, `d200`, `d200_category`, `d200_amount`, `d100`, `d100_category`, `d100_amount`, `d50`, `d50_category`, `d50_amount`, `d20`, `d20_category`, `d20_amount`, `d10`, `d10_category`, `d10_amount`, `d5`, `d5_category`, `d5_amount`, `d1`, `d1_category`, `d1_amount`, `amount`, `added_on`, `added_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 3, '1559309504-100001', '1', '1000', '1', '15000000', '500', '', '0', '200', '', '0', '100', '', '0', '50', '', '0', '20', '', '0', '10', '', '0', '5', '', '0', '1', '', '0', 15000000, '1559459131', 'onyinyechi', NULL, NULL),
(2, 1, 1, 3, '1559309504-100001', '1', '1000', '1', '15000000', '500', '', '0', '200', '', '0', '100', '', '0', '50', '', '0', '20', '', '0', '10', '', '0', '5', '', '0', '1', '', '0', 15000000, '1559459219', 'onyinyechi', NULL, NULL),
(3, 2, 1, 3, '1559309711-100002', '1', '1000', '1', '15000000', '500', '1', '10000000', '200', '1', '5000000', '100', '', '0', '50', '', '0', '20', '', '0', '10', '', '0', '5', '', '0', '1', '', '0', 30000000, '1559459884', 'onyinyechi', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bundleconfirmations`
--

DROP TABLE IF EXISTS `bundleconfirmations`;
CREATE TABLE IF NOT EXISTS `bundleconfirmations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `bc_title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `strim` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `conslocation` int(11) DEFAULT NULL,
  `audit_trail_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `added_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirmation_done` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'NO',
  `ended_on` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bundleconfirmations_client_id_index` (`client_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bundleconfirmations`
--

INSERT INTO `bundleconfirmations` (`id`, `bc_title`, `client_id`, `strim`, `conslocation`, `audit_trail_number`, `added_by`, `confirmation_done`, `ended_on`, `reference_number`, `created_at`, `updated_at`) VALUES
(1, 'Test BC For Fidelity Bank 02*06*2019', 1, 'CBN', 17, '1559457057', 'onyinyechi', 'YES', '1559459795', NULL, NULL, NULL),
(2, 'Test BC For Fidelity Bank 02*06*2019', 1, 'Others', 17, '1559459823', 'onyinyechi', 'YES', '1559459911', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cashallocations`
--

DROP TABLE IF EXISTS `cashallocations`;
CREATE TABLE IF NOT EXISTS `cashallocations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `allocated_to` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `workstation` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seal_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `audit_trail_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `denomination_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount_allocated` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `allocated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `allocated_on` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount_returned` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `returned_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `returned_on` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ca_comment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `returned_user` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ca_shift` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `is_fit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `is_unfit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `is_atm` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `declared_value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `shortage` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `comment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `evidence` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mixups` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `m1000` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `m500` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `m200` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `m100` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `m50` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `m20` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `m10` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `m5` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `m1` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `fake_notes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `fake_serial_numbers` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state_of_cash` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `old_seal_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cashallocations`
--

INSERT INTO `cashallocations` (`id`, `allocated_to`, `workstation`, `seal_number`, `client_name`, `audit_trail_number`, `currency_id`, `denomination_id`, `amount_allocated`, `allocated_by`, `allocated_on`, `amount_returned`, `returned_by`, `returned_on`, `ca_comment`, `returned_user`, `ca_shift`, `is_fit`, `is_unfit`, `is_atm`, `declared_value`, `shortage`, `comment`, `evidence`, `mixups`, `m1000`, `m500`, `m200`, `m100`, `m50`, `m20`, `m10`, `m5`, `m1`, `fake_notes`, `fake_serial_numbers`, `state_of_cash`, `old_seal_number`, `created_at`, `updated_at`) VALUES
(1, 'chinyeaka', 'Workstation VIGFS001', '1559459951-200001', '1', '1559460999', '1', '1', '15000000', 'gifty', '1559460999', NULL, 'chinyeaka', '1559463960', 'l', 'gifty', 'Morning', '15000000', '0', '0', '15000000', '0', 'k', NULL, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '', '1', '1559459951-100001', NULL, NULL),
(2, 'janey', 'Workstation VIGFS002', '1559459951-200001', '1', '1559461033', '1', '1', '15000000', 'gifty', '1559461033', NULL, NULL, NULL, NULL, NULL, 'Morning', '15000000', '0', '0', '15000000', '0', 'q', '228250445745mission.png', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '', '1', '1559459951-100001', NULL, NULL),
(3, 'chinyeaka', 'Workstation VIGFS001', '1559460104-200002', '1', '1559461083', '1', '1', '15000000', 'gifty', '1559461083', NULL, 'chinyeaka', '1559463908', 'j', 'gifty', 'Morning', '14900000', '95000', '4000', '15000000', '1000', 'h', NULL, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '', '1', '', NULL, NULL),
(4, 'janey', 'Workstation VIGFS003', '1559460163-200003', '1', '1559461108', '1', '2', '10000000', 'gifty', '1559461108', NULL, 'janey', '1559461999', 'j', 'gifty', 'Morning', '9000000', '500000', '499000', '10000000', '1000', 'h', NULL, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2', '', '1', '', NULL, NULL),
(5, 'shinene', 'Workstation VIGFS006', '1559460211-200004', '1', '1559461127', '1', '1', '5000000', 'gifty', '1559461127', NULL, 'shinene', '1559461678', 'kool', 'gifty', 'Morning', '4500000', '495000', '4500', '5000000', '500', 'cool', NULL, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '10', '', '1', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cash_processings`
--

DROP TABLE IF EXISTS `cash_processings`;
CREATE TABLE IF NOT EXISTS `cash_processings` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `allocated_to` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `workstation` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seal_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `audit_trail_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `denomination_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount_allocated` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `allocated_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `allocated_on` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount_returned` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `difference` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `returned_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `returned_on` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ca_comment` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `returned_user` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ca_shift` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_fit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_unfit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_atm` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_fakenote` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shortage` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_sorting_value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `declared_value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `counted_value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `evidens` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cits`
--

DROP TABLE IF EXISTS `cits`;
CREATE TABLE IF NOT EXISTS `cits` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `evacuation_id` int(22) DEFAULT NULL,
  `seal_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `cit_officer_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `added_on` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `added_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `picked_up_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `picked_up_on` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `received_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `received_on` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bundle_confirmed` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NO',
  `bundle_confirmed_comment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bundle_confirmed_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bundle_confirmed_on` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bundle_confirmation_status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `old_seal_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cits`
--

INSERT INTO `cits` (`id`, `evacuation_id`, `seal_number`, `vehicle_id`, `cit_officer_id`, `delivery_status`, `added_on`, `added_by`, `picked_up_by`, `picked_up_on`, `received_by`, `received_on`, `bundle_confirmed`, `bundle_confirmed_comment`, `bundle_confirmed_by`, `bundle_confirmed_on`, `bundle_confirmation_status`, `old_seal_number`, `created_at`, `updated_at`) VALUES
(1, 1, '1559309504-100001', 1, 'gandoki', 'Received At Boxroom', '1559310142', 'bankcmu', 'gandoki', '05/31/19', 'fabian', '1559312900', 'YES', 'Second Half', 'onyinyechi', '1559459219', 'Confirmed', NULL, NULL, NULL),
(2, 1, '1559309711-100002', 1, 'gandoki', 'Received At Boxroom', '1559310142', 'bankcmu', 'gandoki', '05/31/19', 'fabian', '1559312900', 'YES', 'Complete', 'onyinyechi', '1559459884', 'Confirmed', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `consignmentlocations`
--

DROP TABLE IF EXISTS `consignmentlocations`;
CREATE TABLE IF NOT EXISTS `consignmentlocations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bankview` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NO',
  `workstation` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NO',
  `slug` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `consignmentlocations`
--

INSERT INTO `consignmentlocations` (`id`, `name`, `bankview`, `workstation`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Client Office', 'YES', 'NO', 'client-office', NULL, NULL),
(2, 'ICMS Victoria Island CPC', 'YES', 'NO', 'icms-victoria-island-cpc', NULL, NULL),
(3, 'Central Bank of Nigeria Marina', 'YES', 'NO', 'central-bank-of-nigeria-marina', NULL, NULL),
(4, 'Bank Hub', 'YES', 'NO', 'bank-hub', NULL, NULL),
(5, 'Other Banks Branches', 'YES', 'NO', 'other-banks-branches', NULL, NULL),
(6, 'Other Branches', 'YES', 'NO', 'other-branches', NULL, NULL),
(7, 'Cash In Transit (CIT)', 'NO', 'NO', 'cash-in-transit-(cit)', NULL, NULL),
(8, 'Box Room', 'NO', 'NO', 'box-room', NULL, NULL),
(9, 'AC Vault', 'NO', 'NO', 'ac-vault', NULL, NULL),
(10, 'AE Vault', 'NO', 'NO', 'ae-vault', NULL, NULL),
(11, 'ICMS CAC Vault', 'NO', 'NO', NULL, NULL, NULL),
(12, 'ICMS CAD Vault', 'NO', 'NO', NULL, NULL, NULL),
(13, 'CBN CAC Vault', 'NO', 'NO', NULL, NULL, NULL),
(14, 'CBN CAD Vault', 'NO', 'NO', NULL, NULL, NULL),
(15, 'PreVault', 'NO', 'NO', NULL, NULL, NULL),
(16, 'Treasury', 'NO', 'NO', NULL, NULL, NULL),
(17, 'Bundle Confirmation Area 1', 'NO', 'NO', NULL, NULL, NULL),
(18, 'Bundle Confirmation Area 2', 'NO', 'NO', NULL, NULL, NULL),
(19, 'Processing Floor Supervisor 1', 'NO', 'NO', NULL, NULL, NULL),
(20, 'Processing Floor Supervisor 2', 'NO', 'NO', NULL, NULL, NULL),
(21, 'Workstation VIGFS001', 'NO', 'YES', NULL, NULL, NULL),
(22, 'Workstation VIGFS002', 'NO', 'YES', NULL, NULL, NULL),
(23, 'Workstation VIGFS003', 'NO', 'YES', NULL, NULL, NULL),
(24, 'Workstation VIGFS004', 'NO', 'YES', NULL, NULL, NULL),
(25, 'Workstation VIGFS005', 'NO', 'YES', NULL, NULL, NULL),
(26, 'Workstation VIGFS006', 'NO', 'YES', NULL, NULL, NULL),
(27, 'Workstation VIGFS007', 'NO', 'YES', NULL, NULL, NULL),
(28, 'Workstation VIGFS008', 'NO', 'YES', NULL, NULL, NULL),
(29, 'Workstation VIGFS009', 'NO', 'YES', NULL, NULL, NULL),
(30, 'Workstation VIGFS010', 'NO', 'YES', NULL, NULL, NULL),
(31, 'Workstation VIGFS011', 'NO', 'YES', NULL, NULL, NULL),
(32, 'Workstation VIGFS012', 'NO', 'YES', NULL, NULL, NULL),
(33, 'Workstation VIGFS013', 'NO', 'YES', NULL, NULL, NULL),
(34, 'Workstation VIGFS014', 'NO', 'YES', NULL, NULL, NULL),
(35, 'Workstation VIGFS015', 'NO', 'YES', NULL, NULL, NULL),
(36, 'Workstation VIGFS016', 'NO', 'YES', NULL, NULL, NULL),
(37, 'Workstation VIGFS017', 'NO', 'YES', NULL, NULL, NULL),
(38, 'Workstation VIGFS018', 'NO', 'YES', NULL, NULL, NULL),
(39, 'Workstation VIGFS019', 'NO', 'YES', NULL, NULL, NULL),
(40, 'Workstation VIGFS020', 'NO', 'YES', NULL, NULL, NULL),
(41, 'Workstation VIGFS021', 'NO', 'YES', NULL, NULL, NULL),
(42, 'Workstation VIGFS022', 'NO', 'YES', NULL, NULL, NULL),
(43, 'Workstation VIGFS023', 'NO', 'YES', NULL, NULL, NULL),
(44, 'Workstation VIGFS024', 'NO', 'YES', NULL, NULL, NULL),
(45, 'Workstation VIGFS025', 'NO', 'YES', NULL, NULL, NULL),
(46, 'Workstation VIGFS026', 'NO', 'YES', NULL, NULL, NULL),
(47, 'Workstation VIGFS027', 'NO', 'YES', NULL, NULL, NULL),
(48, 'Workstation VIGFS028', 'NO', 'YES', NULL, NULL, NULL),
(49, 'Workstation VIGFS029', 'NO', 'YES', NULL, NULL, NULL),
(50, 'Workstation VIGFS030', 'NO', 'YES', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `containertypes`
--

DROP TABLE IF EXISTS `containertypes`;
CREATE TABLE IF NOT EXISTS `containertypes` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `containertypes`
--

INSERT INTO `containertypes` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Bag', 'bag', NULL, NULL),
(2, 'Full Box ', 'full-box-', NULL, NULL),
(3, 'Others ', 'others-', NULL, NULL),
(4, 'Odd Box ', 'odd-box-', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

DROP TABLE IF EXISTS `currencies`;
CREATE TABLE IF NOT EXISTS `currencies` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Nigerian Naira', 'naira', NULL, NULL),
(2, 'European Euro', 'euro', NULL, NULL),
(3, 'US Dollar', 'usd', NULL, NULL),
(4, 'British Pounds', 'gbp', NULL, NULL),
(5, 'South Africa Rand', 'zar', NULL, NULL),
(6, 'West African CFA', 'cfa', NULL, NULL),
(7, 'Chinese Yuan', 'cny', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dayshifts`
--

DROP TABLE IF EXISTS `dayshifts`;
CREATE TABLE IF NOT EXISTS `dayshifts` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `dstart_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dday` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dshift` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dstarted` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NO',
  `dstarted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dclosed` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NO',
  `dclosed_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dclosed_on` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dstatus` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dayshifts`
--

INSERT INTO `dayshifts` (`id`, `dstart_title`, `dday`, `dshift`, `dstarted`, `dstarted_by`, `dclosed`, `dclosed_by`, `dclosed_on`, `dstatus`, `created_at`, `updated_at`) VALUES
(1, 'Moday Shift', NULL, NULL, 'NO', NULL, 'NO', NULL, NULL, NULL, NULL, NULL),
(2, 'Moday Shift', NULL, NULL, 'NO', NULL, 'NO', NULL, NULL, NULL, NULL, NULL),
(3, 'Moday Shift', NULL, NULL, 'NO', NULL, 'NO', NULL, NULL, NULL, NULL, NULL),
(4, 'Moday Shift', NULL, NULL, 'NO', NULL, 'NO', NULL, NULL, NULL, NULL, NULL),
(5, 'Moday Shift', NULL, NULL, 'NO', NULL, 'NO', NULL, NULL, NULL, NULL, NULL),
(6, 'Moday Shift', NULL, NULL, 'NO', NULL, 'NO', NULL, NULL, NULL, NULL, NULL),
(7, 'Moday Shift', NULL, NULL, 'NO', NULL, 'NO', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `denominations`
--

DROP TABLE IF EXISTS `denominations`;
CREATE TABLE IF NOT EXISTS `denominations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `denominations`
--

INSERT INTO `denominations` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, '1000', NULL, NULL, NULL),
(2, '500', NULL, NULL, NULL),
(3, '200', NULL, NULL, NULL),
(4, '100', NULL, NULL, NULL),
(5, '50', NULL, NULL, NULL),
(6, '20', NULL, NULL, NULL),
(7, '10', NULL, NULL, NULL),
(8, '5', NULL, NULL, NULL),
(9, '1', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `depositcategories`
--

DROP TABLE IF EXISTS `depositcategories`;
CREATE TABLE IF NOT EXISTS `depositcategories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `depositcategories`
--

INSERT INTO `depositcategories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Mint ', 'mint-', NULL, NULL),
(2, 'Unfit Notes ', 'unfit-notes-', NULL, NULL),
(3, 'ATM Fit Notes ', 'atm-fit-notes-', NULL, NULL),
(4, 'Teller Fit Notes ', 'teller-fit-notes-', NULL, NULL),
(5, 'Mutilated Notes ', 'mutilated-notes-', NULL, NULL),
(6, 'Awaiting Evaluation (Unprocessed) ', 'awaiting-evaluation-(unprocessed)-', NULL, NULL),
(7, 'Awaiting Evaluation (Vault) ', 'awaiting-evaluation-(vault)-', NULL, NULL),
(8, 'Awaiting Evaluation (Processing Floor) ', 'awaiting-evaluation-(processing-floor)-', NULL, NULL),
(9, 'AC Awaiting Confirmation ', 'ac-awaiting-confirmation-', NULL, NULL),
(10, 'Others', 'others', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `deposittypes`
--

DROP TABLE IF EXISTS `deposittypes`;
CREATE TABLE IF NOT EXISTS `deposittypes` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deposittypes`
--

INSERT INTO `deposittypes` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, ' 	Central Bank of Nigeria (CBN) Deposits', '-central-bank-of-nigeria-(cbn)-deposits', NULL, NULL),
(2, 'Total Cash Solution (TCS) Deposits', 'total-cash-solution-(tcs)-deposits', NULL, NULL),
(3, 'Cash Processing (CP) Deposits', 'cash-processing-(cp)-deposits', NULL, NULL),
(4, 'Retail Deposits', 'retail-deposits', NULL, NULL),
(5, 'Others', 'others', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `evacuationpreparations`
--

DROP TABLE IF EXISTS `evacuationpreparations`;
CREATE TABLE IF NOT EXISTS `evacuationpreparations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `evacuation_id` int(10) UNSIGNED NOT NULL,
  `seal_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `container_type_id` int(11) NOT NULL,
  `deposit_type_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `currency_id` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cash_1000` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cash_1000_amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cash_500` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cash_500_amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cash_200` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cash_200_amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cash_100` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cash_100_amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cash_50` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cash_50_amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cash_20` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cash_20_amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cash_10` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cash_10_amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cash_5` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cash_5_amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cash_1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cash_1_amount` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_rep` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updatedOn` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_deleted` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NO',
  `deleted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_on` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_amount_bc` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `is_bceed` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NO',
  `is_pickedup` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NO',
  `pickedup_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pickedup_on` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_handed_over` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NO',
  `is_handed_over_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_handed_over_on` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_opened` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NO',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `evacuationpreparations_evacuation_id_index` (`evacuation_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `evacuationpreparations`
--

INSERT INTO `evacuationpreparations` (`id`, `client_id`, `evacuation_id`, `seal_number`, `container_type_id`, `deposit_type_id`, `category_id`, `currency_id`, `cash_1000`, `cash_1000_amount`, `cash_500`, `cash_500_amount`, `cash_200`, `cash_200_amount`, `cash_100`, `cash_100_amount`, `cash_50`, `cash_50_amount`, `cash_20`, `cash_20_amount`, `cash_10`, `cash_10_amount`, `cash_5`, `cash_5_amount`, `cash_1`, `cash_1_amount`, `total_amount`, `client_rep`, `updatedOn`, `is_deleted`, `deleted_by`, `deleted_on`, `total_amount_bc`, `is_bceed`, `is_pickedup`, `pickedup_by`, `pickedup_on`, `is_handed_over`, `is_handed_over_by`, `is_handed_over_on`, `is_opened`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '1559309504-100001', 1, '1', 1, 'naira', '1000', '30000000', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '30000000', 'bankcmu', '1559309704', 'NO', NULL, NULL, '30000000', 'YES', 'YES', 'gandoki', '05/31/19', 'NO', NULL, NULL, 'YES', NULL, NULL),
(2, 1, 1, '1559309711-100002', 2, '2', 1, 'naira', '1000', '15000000', '500', '10000000', '200', '5000000', '100', '', '50', '', '20', '', '10', '', '5', '', '1', '', '30000000', 'bankcmu', '1559309755', 'NO', NULL, NULL, '30000000', 'YES', 'YES', 'gandoki', '05/31/19', 'NO', NULL, NULL, 'YES', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `evacuations`
--

DROP TABLE IF EXISTS `evacuations`;
CREATE TABLE IF NOT EXISTS `evacuations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `er_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `location_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `consignment_location_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cit_reciever_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cit_confirmation_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vehicle_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NO',
  `cit_confirmation` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cit_confirmation_date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_rep` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updatedOn` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cp_done` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NO',
  `er_status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preannounced` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NO',
  `date_execution` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `er_slug` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `evacuations`
--

INSERT INTO `evacuations` (`id`, `er_name`, `bank_id`, `branch_id`, `location_code`, `consignment_location_id`, `cit_reciever_id`, `cit_confirmation_token`, `vehicle_id`, `cit`, `cit_confirmation`, `cit_confirmation_date`, `client_rep`, `updatedOn`, `cp_done`, `er_status`, `preannounced`, `date_execution`, `er_slug`, `created_at`, `updated_at`) VALUES
(1, 'Test Evacuation Request 31-05-2019', 1, 3, 'H44/45 OLOJO DRIVEÂ  OJO, ALABA', '2', 'gandoki', '1cittoken181559309945cittoken181', '1', 'YES', NULL, NULL, 'bankcmu', '1559309038', 'YES', 'Consignment Picked Up By CIT', 'NO', '2019-06-03', 'test-evacuation-request-31-05-2019', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `generals`
--

DROP TABLE IF EXISTS `generals`;
CREATE TABLE IF NOT EXISTS `generals` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `middlename` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phoneNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `occupation` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dp` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `generals`
--

INSERT INTO `generals` (`id`, `username`, `surname`, `firstname`, `middlename`, `dob`, `gender`, `phoneNumber`, `address`, `state`, `country`, `occupation`, `profile`, `dp`, `created_at`, `updated_at`) VALUES
(1, 'judenka', 'Omenka', 'Jude', 'Ochokwu', '1990/09/10', 'Male', '08020685214', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'judenka', 'Omenka', 'Jude', 'Ochokwu', '1990/09/10', 'Male', '08020685214', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'judenka', 'Omenka', 'Jude', 'Ochokwu', '1990/09/10', 'Male', '08020685214', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'judenka', 'Omenka', 'Jude', 'Ochokwu', '1990/09/10', 'Male', '08020685214', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'judenka', 'Omenka', 'Jude', 'Ochokwu', '1990/09/10', 'Male', '08020685214', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'judenka', 'Omenka', 'Jude', 'Ochokwu', '1990/09/10', 'Male', '08020685214', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'judenka', 'Omenka', 'Jude', 'Ochokwu', '1990/09/10', 'Male', '08020685214', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `internalmovements`
--

DROP TABLE IF EXISTS `internalmovements`;
CREATE TABLE IF NOT EXISTS `internalmovements` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `source_location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `destination_location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seal_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `added_on` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `added_by` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `received_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `received_on` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `movement_status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_opened` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NO',
  `bc` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NO',
  `is_moved_out` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NO',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `internalmovements`
--

INSERT INTO `internalmovements` (`id`, `source_location`, `destination_location`, `seal_number`, `added_on`, `added_by`, `received_by`, `received_on`, `movement_status`, `is_opened`, `bc`, `is_moved_out`, `created_at`, `updated_at`) VALUES
(7, '19', '9', '1559460104-200002', '1559485681', 'gifty', '', '', 'Pending', 'NO', 'NO', 'NO', NULL, NULL),
(6, '19', '9', '1559459951-200001', '1559485681', 'gifty', '', '', 'Pending', 'NO', 'NO', 'NO', NULL, NULL),
(4, '8', '17', '1559309711-100002', '1559317534', 'fabian', 'onyinyechi', '1559317572', 'Confirmed', 'YES', 'YES', 'NO', NULL, NULL),
(5, '8', '17', '1559309504-100001', '1559317534', 'fabian', 'onyinyechi', '1559317572', 'Confirmed', 'YES', 'YES', 'NO', NULL, NULL),
(8, '17', '19', '1559460163-200003', '1559460326', 'onyinyechi', 'gifty', '1559460384', 'Confirmed', 'NO', 'NO', 'NO', NULL, NULL),
(9, '17', '19', '1559460211-200004', '1559460326', 'onyinyechi', 'gifty', '1559460384', 'Confirmed', 'NO', 'NO', 'NO', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=180 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(22, '2014_10_12_000000_create_users_table', 1),
(23, '2014_10_12_100000_create_password_resets_table', 1),
(24, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(25, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(26, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(27, '2016_06_01_000004_create_oauth_clients_table', 1),
(28, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(178, '2019_05_20_145240_create_thrownexceptions_table', 16),
(179, '2019_05_20_152852_create_vehicles_table', 17),
(176, '2019_05_20_140837_create_sealings_table', 14),
(177, '2019_05_20_143910_create_shiftsdays_table', 15),
(173, '2019_05_12_072923_create_generals_table', 11),
(174, '2019_05_20_133752_create_internalmovements_table', 12),
(175, '2019_05_20_135815_create_notifications_table', 13),
(172, '2019_05_20_120543_create_deposittypes_table', 10),
(171, '2019_05_20_115547_create_depositcategories_table', 9),
(169, '2019_05_20_113145_create_dayshifts_table', 7),
(170, '2019_05_20_114515_create_denominations_table', 8),
(168, '2019_05_20_111749_create_currencies_table', 6),
(167, '2019_05_20_110350_create_containertypes_table', 5),
(166, '2019_05_20_064044_create_consignmentlocations_table', 4),
(164, '2019_05_19_094741_create_cashallocations_table', 2),
(165, '2019_05_12_072624_create_cits_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `username`, `subject`, `message`, `status`, `created_at`, `updated_at`) VALUES
(1, 'judenka', 'Test Notice', '100001 noone for now', NULL, NULL, NULL),
(2, 'judenka', 'Test Notice', '100001 noone for now', NULL, NULL, NULL),
(3, 'judenka', 'Test Notice', '100001 noone for now', NULL, NULL, NULL),
(4, 'judenka', 'Test Notice', '100001 noone for now', NULL, NULL, NULL),
(5, 'judenka', 'Test Notice', '100001 noone for now', NULL, NULL, NULL),
(6, 'judenka', 'Test Notice', '100001 noone for now', NULL, NULL, NULL),
(7, 'judenka', 'Test Notice', '100001 noone for now', NULL, NULL, NULL),
(8, 'judenka', 'Test Notice', '100001 noone for now', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
CREATE TABLE IF NOT EXISTS `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('09f4ed9db22691d9a16f214e4ba9ccfbc9e62273a79642a19644025593d4854fd40935f48669d3dd', 1, 3, 'Personal Access Token', '[]', 0, '2019-05-07 12:44:01', '2019-05-07 12:44:01', '2020-05-07 06:44:01'),
('4422639f19230b2a12af9f06a8c5d9606ffaf975c5065830eaea8a64a6ba3e9b9f4cb4bbb984649f', 1, 3, 'Personal Access Token', '[]', 0, '2019-05-07 13:18:54', '2019-05-07 13:18:54', '2020-05-07 07:18:54'),
('15ec362f62fdc26a61d889f98f387c639e25e19cc75b481abb3b2da48487b7f3df9c4b07b1eee992', 1, 3, 'Personal Access Token', '[]', 0, '2019-05-07 14:13:45', '2019-05-07 14:13:45', '2020-05-07 08:13:45'),
('ff1787f94b902b9e0b5d90764295d1fea1093638dc4a16544639f03040a553875526c06b4ecf37aa', 1, 3, 'Personal Access Token', '[]', 0, '2019-05-07 15:16:23', '2019-05-07 15:16:23', '2020-05-07 09:16:23'),
('9078a442c34a17c357694141499f83d87d36a90328e0243ae948fd4ec8c658b9560812a8eef4c4e8', 1, 3, 'Personal Access Token', '[]', 0, '2019-05-07 15:25:36', '2019-05-07 15:25:36', '2020-05-07 09:25:36'),
('6516754b63fa8f24037a1b3f7e1bf606546699efd51d4fa966e874b785af17fbd3ec7cc83fb5e9f0', 1, 3, 'Personal Access Token', '[]', 0, '2019-05-07 15:32:30', '2019-05-07 15:32:30', '2020-05-07 09:32:30'),
('9e4ec984e67fb61fdbc8a6852e3d518ca4fc8e826476ddf1069ce795ef798e3317d2c325e032ed15', 1, 3, 'Personal Access Token', '[]', 0, '2019-05-07 15:41:45', '2019-05-07 15:41:45', '2020-05-07 09:41:45'),
('7ba4032f72fabcbb35048c22c8c8776993e895cc418ead7252445551e64dbf3bb656932ad2c22ed7', 1, 3, 'Personal Access Token', '[]', 0, '2019-05-10 15:07:26', '2019-05-10 15:07:26', '2020-05-10 09:07:26'),
('b4d2fc0f2ed01d0cb73ab62d486308a0527bea6f7691eca49559fe425635371a0d945b1c2a803992', 1, 3, 'Personal Access Token', '[]', 0, '2019-05-10 21:31:28', '2019-05-10 21:31:28', '2020-05-10 15:31:28'),
('0dfff523d712a5e144d547dc5e3f4e581b61fbbdd123ca6d4c8bcb50c2381e41fdbc6c8e53de5448', 1, 2, NULL, '[]', 0, '2019-05-21 13:44:12', '2019-05-21 13:44:12', '2020-05-21 14:44:12');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

DROP TABLE IF EXISTS `oauth_auth_codes`;
CREATE TABLE IF NOT EXISTS `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
CREATE TABLE IF NOT EXISTS `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', '9sc5WTgAEgxcslq8o3kBvGU1hx2lFHHKCKK2oFEz', 'http://localhost', 1, 0, 0, '2019-05-07 05:16:15', '2019-05-07 05:16:15'),
(2, NULL, 'Laravel Password Grant Client', 'MegMimwMxNz2FIxfXTyKkCKHOOrclRYBKAIH30eB', 'http://localhost', 0, 1, 0, '2019-05-07 05:16:15', '2019-05-07 05:16:15'),
(3, NULL, 'Laravel Personal Access Client', 'gyWfG0CZXy9uqOU4UC947AeJhoEC41FwMf2CoX1U', 'http://localhost', 1, 0, 0, '2019-05-07 05:18:17', '2019-05-07 05:18:17');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

DROP TABLE IF EXISTS `oauth_personal_access_clients`;
CREATE TABLE IF NOT EXISTS `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_personal_access_clients_client_id_index` (`client_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2019-05-07 05:16:15', '2019-05-07 05:16:15'),
(2, 3, '2019-05-07 05:18:17', '2019-05-07 05:18:17');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
CREATE TABLE IF NOT EXISTS `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_refresh_tokens`
--

INSERT INTO `oauth_refresh_tokens` (`id`, `access_token_id`, `revoked`, `expires_at`) VALUES
('de2c6d5f3862e6683d65d3adbbb2ce4d155e46cca3c02fea2bda84c1937be42df5a5b39de59eaf8e', '0dfff523d712a5e144d547dc5e3f4e581b61fbbdd123ca6d4c8bcb50c2381e41fdbc6c8e53de5448', 0, '2020-05-21 14:44:12');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sealings`
--

DROP TABLE IF EXISTS `sealings`;
CREATE TABLE IF NOT EXISTS `sealings` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `strim` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sealing_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `container_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `denomination_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seal_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `added_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `added_on` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_opened` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NO',
  `total_amount_allocated` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_processors` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `old_seal_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seal_batch` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_amount_sealed` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sealings`
--

INSERT INTO `sealings` (`id`, `strim`, `sealing_title`, `client`, `location_id`, `category_id`, `container_id`, `currency_id`, `denomination_id`, `amount`, `seal_number`, `added_by`, `added_on`, `is_opened`, `total_amount_allocated`, `total_processors`, `old_seal_number`, `seal_batch`, `total_amount_sealed`, `created_at`, `updated_at`) VALUES
(1, 'CBN', 'Test Sealing For Fidelity Bank 02*06*2019', '1', '17', '1', '1', '1', '1', '30000000', '1559459951-200001', 'onyinyechi', '1559460006', 'YES', '30000000', '2', '1559459951-100001', '172019-06-02', '30000000', NULL, NULL),
(2, 'Others', 'Test Sealing For Fidelity Bank 02*06*2019', '1', '17', '1', '2', '1', '1', '15000000', '1559460104-200002', 'onyinyechi', '1559460147', 'YES', '15000000', '1', '', '172019-06-02', '15000000', NULL, NULL),
(3, 'Others', 'Test Sealing For Fidelity Bank 02*06*2019', '1', '17', '1', '2', '1', '2', '10000000', '1559460163-200003', 'onyinyechi', '1559460205', 'YES', '10000000', '1', '', '172019-06-02', '10000000', NULL, NULL),
(4, 'Others', 'Test Sealing For Fidelity Bank 02*06*2019', '1', '17', '1', '3', '1', '1', '5000000', '1559460211-200004', 'onyinyechi', '1559460269', 'YES', '5000000', '1', '', '172019-06-02', '5000000', NULL, NULL),
(5, 'CBN', 'getWorkStationLists', '1', '19', '1', '1', '1', '1', '30000000', '1559464125-300001', 'gifty', '1559464171', 'NO', NULL, NULL, '1559464125-200001', '192019-06-02', '30000000', NULL, NULL),
(6, 'Others', 'getWorkStationLists', '1', '19', '1', '3', '1', '1', '15000000', '1559464176-300002', 'gifty', '1559464217', 'NO', NULL, NULL, '', '192019-06-02', '15000000', NULL, NULL),
(7, 'Others', 'getWorkStationLists', '1', '19', '1', '3', '1', '2', '10000000', '1559464221-300003', 'gifty', '1559464247', 'NO', NULL, NULL, '', '192019-06-02', '10000000', NULL, NULL),
(8, 'Others', 'getWorkStationLists', '1', '19', '1', '3', '1', '3', '5000000', '1559464251-300004', 'gifty', '1559464276', 'NO', NULL, NULL, '', '192019-06-02', '5000000', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shiftsdays`
--

DROP TABLE IF EXISTS `shiftsdays`;
CREATE TABLE IF NOT EXISTS `shiftsdays` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `day_id` int(11) DEFAULT NULL,
  `stitle` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sshift` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sstarted` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NO',
  `sstarted_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sstarted_on` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sclosed` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NO',
  `sclosed_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sclosed_on` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sstatus` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shiftsdays`
--

INSERT INTO `shiftsdays` (`id`, `day_id`, `stitle`, `sshift`, `sstarted`, `sstarted_by`, `sstarted_on`, `sclosed`, `sclosed_by`, `sclosed_on`, `sstatus`, `created_at`, `updated_at`) VALUES
(1, 1, 'Test Notice', 'Morning', 'NO', 'judenka', '85585100001', 'NO', NULL, NULL, NULL, NULL, NULL),
(2, 1, 'Test Notice', 'Morning', 'NO', 'judenka', '85585100001', 'NO', NULL, NULL, NULL, NULL, NULL),
(3, 1, 'Test Notice', 'Morning', 'NO', 'judenka', '85585100001', 'NO', NULL, NULL, NULL, NULL, NULL),
(4, 1, 'Test Notice', 'Morning', 'NO', 'judenka', '85585100001', 'NO', NULL, NULL, NULL, NULL, NULL),
(5, 1, 'Test Notice', 'Morning', 'NO', 'judenka', '85585100001', 'NO', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `supplies`
--

DROP TABLE IF EXISTS `supplies`;
CREATE TABLE IF NOT EXISTS `supplies` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` int(10) UNSIGNED NOT NULL,
  `sr_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sr_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sr_date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sr_comment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requested_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requested_on` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sr_status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bp_done` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NO',
  `sr_slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NO',
  `sr_verified` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NO',
  `verified_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verified_on` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verified_comment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sr_approved` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NO',
  `approved_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_on` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_comment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dispatched_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dispatched_on` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sr_dispatch_comment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'Not Delivered',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `supplies_client_id_index` (`client_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supplies`
--

INSERT INTO `supplies` (`id`, `client_id`, `sr_title`, `sr_type`, `sr_date`, `sr_comment`, `requested_by`, `requested_on`, `sr_status`, `bp_done`, `sr_slug`, `cit`, `sr_verified`, `verified_by`, `verified_on`, `verified_comment`, `sr_approved`, `approved_by`, `approved_on`, `approved_comment`, `dispatched_by`, `dispatched_on`, `sr_dispatch_comment`, `delivery_status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Test Supply Request', 'Swap / Sales', '2019-06-04', 'Test Comment Updated', 'bankcmu', '1559541324', 'Approved, Awaiting Dispatch', 'YES', 'test-supply-request', 'NO', 'YES', 'sadmin', '1559560440', 'yes', 'YES', 'sadmin', '1559560541', 'good', NULL, NULL, NULL, 'Not Delivered', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `supplybranches`
--

DROP TABLE IF EXISTS `supplybranches`;
CREATE TABLE IF NOT EXISTS `supplybranches` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `supply_id` int(10) UNSIGNED NOT NULL,
  `client` int(11) DEFAULT NULL,
  `branch` int(11) DEFAULT NULL,
  `currency` int(11) DEFAULT NULL,
  `denomination` int(11) DEFAULT NULL,
  `cash_category` int(11) DEFAULT NULL,
  `amount` int(11) NOT NULL DEFAULT '0',
  `processed_amount` int(11) NOT NULL DEFAULT '0',
  `requested_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requested_on` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_deleted` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NO',
  `is_dispatched` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'NO',
  `is_dispatchedOn` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_dispatchedBy` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cit_officer` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cit_vehicle` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_delivered` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NO',
  `is_deliveredOn` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_deliveredBy` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_received` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NO',
  `is_receivedOn` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_receivedBy` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `srb_status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_packed` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NO',
  `packed_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `packed_on` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_splitted` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NO',
  `seal_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `supplybranches_supply_id_index` (`supply_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supplybranches`
--

INSERT INTO `supplybranches` (`id`, `supply_id`, `client`, `branch`, `currency`, `denomination`, `cash_category`, `amount`, `processed_amount`, `requested_by`, `requested_on`, `is_deleted`, `is_dispatched`, `is_dispatchedOn`, `is_dispatchedBy`, `cit_officer`, `cit_vehicle`, `is_delivered`, `is_deliveredOn`, `is_deliveredBy`, `is_received`, `is_receivedOn`, `is_receivedBy`, `srb_status`, `is_packed`, `packed_by`, `packed_on`, `is_splitted`, `seal_number`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 1, 1, 25000000, 0, 'bankcmu', '1559541611', 'NO', 'YES', '1559562148', 'sadmin', 'gandoki', '1', 'YES', '1559565527', 'gandoki', 'NO', NULL, NULL, 'Dispatched', 'YES', 'sadmin', '1559561531', 'NO', '1559561011-400001', NULL, NULL),
(2, 1, 1, 2, 1, 1, 1, 20000000, 0, 'bankcmu', '1559541756', 'NO', 'YES', '1559564066', 'sadmin', 'gandoki', '1', 'YES', '1559565510', 'gandoki', 'NO', NULL, NULL, 'Dispatched', 'YES', 'sadmin', '1559561548', 'NO', '1559561533-400002', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `thrownexceptions`
--

DROP TABLE IF EXISTS `thrownexceptions`;
CREATE TABLE IF NOT EXISTS `thrownexceptions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `seal_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `denomination` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expected_Amount` int(11) DEFAULT NULL,
  `actual_amount` int(11) DEFAULT NULL,
  `thrown_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thrown_on` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thrown_comment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thrown_to` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reviewed_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reviewed_on` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reviewed_comment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ex_status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surname` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstname` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `middlename` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phoneno` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'avatar.png',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `activation_token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `userid` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `userlevel` int(11) DEFAULT NULL,
  `timestamp` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registration_status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `approved_by` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_on` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `passw` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `surname`, `firstname`, `middlename`, `phoneno`, `gender`, `address`, `name`, `email`, `email_verified_at`, `password`, `avatar`, `active`, `activation_token`, `remember_token`, `userid`, `userlevel`, `timestamp`, `registration_status`, `approved_by`, `approved_on`, `created_at`, `updated_at`, `deleted_at`, `passw`) VALUES
(1, 'sadmin', 'Ibeh', 'Ernest', 'Ekele', '08020689069', 'Male', 'Plot 8, Gbagada Road, Gbagada, Lagos State, Nigeria.', 'Ibeh Ernest Ekele', 'e.ibeh@icms.ng', NULL, '$2y$10$2DkWI/sXJEIbF/UxCjSea.vMrnjHypZnYVPczz90bdTvubDvelVH2', 'avatar.png', 1, '', NULL, 'be212f5da8beee6b4b2fcf602f13c454', 20, '1559196055', 'Approved', NULL, NULL, '2019-05-07 12:29:59', '2019-05-07 12:42:36', NULL, '46b7050a21307101930c1fae3efa062a');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

DROP TABLE IF EXISTS `vehicles`;
CREATE TABLE IF NOT EXISTS `vehicles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `name`, `number`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'ICMS-BV-LAG-1', '6pEUQJKhLS', 'icms-bv-lag-1', NULL, NULL),
(2, 'ICMS-BV-LAG-2', 'Rikg6MgsG3', 'icms-bv-lag-2', NULL, NULL),
(3, 'ICMS-BV-LAG-3', 'E3WrEvEPjM', 'icms-bv-lag-3', NULL, NULL),
(4, 'ICMS-BV-LAG-4', 'hgLi06IX7w', 'icms-bv-lag-4', NULL, NULL),
(5, 'ICMS-BV-LAG-5', 'mQx1e0VV6R', 'icms-bv-lag-5', NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
