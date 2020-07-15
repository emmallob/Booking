-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 15, 2020 at 05:18 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `alerts`
--

CREATE TABLE `alerts` (
  `id` int(11) NOT NULL,
  `client_guid` varchar(32) DEFAULT NULL,
  `user_guid` varchar(32) DEFAULT NULL,
  `message` varchar(1000) DEFAULT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `favicon` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `country_name` varchar(255) NOT NULL,
  `country_code` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `country_name`, `country_code`) VALUES
(1, 'Afghanistan', 'AF'),
(2, 'Aland Islands', 'AX'),
(3, 'Albania', 'AL'),
(4, 'Algeria', 'DZ'),
(5, 'American Samoa', 'AS'),
(6, 'Andorra', 'AD'),
(7, 'Angola', 'AO'),
(8, 'Anguilla', 'AI'),
(9, 'Antarctica', 'AQ'),
(10, 'Antigua and Barbuda', 'AG'),
(11, 'Argentina', 'AR'),
(12, 'Armenia', 'AM'),
(13, 'Aruba', 'AW'),
(14, 'Australia', 'AU'),
(15, 'Austria', 'AT'),
(16, 'Azerbaijan', 'AZ'),
(17, 'Bahamas', 'BS'),
(18, 'Bahrain', 'BH'),
(19, 'Bangladesh', 'BD'),
(20, 'Barbados', 'BB'),
(21, 'Belarus', 'BY'),
(22, 'Belgium', 'BE'),
(23, 'Belize', 'BZ'),
(24, 'Benin', 'BJ'),
(25, 'Bermuda', 'BM'),
(26, 'Bhutan', 'BT'),
(27, 'Bolivia, Plurinational State of', 'BO'),
(28, 'Bonaire, Sint Eustatius and Saba', 'BQ'),
(29, 'Bosnia and Herzegovina', 'BA'),
(30, 'Botswana', 'BW'),
(31, 'Bouvet Island', 'BV'),
(32, 'Brazil', 'BR'),
(33, 'British Indian Ocean Territory', 'IO'),
(34, 'Brunei Darussalam', 'BN'),
(35, 'Bulgaria', 'BG'),
(36, 'Burkina Faso', 'BF'),
(37, 'Burundi', 'BI'),
(38, 'Cambodia', 'KH'),
(39, 'Cameroon', 'CM'),
(40, 'Canada', 'CA'),
(41, 'Cape Verde', 'CV'),
(42, 'Cayman Islands', 'KY'),
(43, 'Central African Republic', 'CF'),
(44, 'Chad', 'TD'),
(45, 'Chile', 'CL'),
(46, 'China', 'CN'),
(47, 'Christmas Island', 'CX'),
(48, 'Cocos (Keeling) Islands', 'CC'),
(49, 'Colombia', 'CO'),
(50, 'Comoros', 'KM'),
(51, 'Congo', 'CG'),
(52, 'Congo, the Democratic Republic of the', 'CD'),
(53, 'Cook Islands', 'CK'),
(54, 'Costa Rica', 'CR'),
(55, 'Cote d\'Ivoire', 'CI'),
(56, 'Croatia', 'HR'),
(57, 'Cuba', 'CU'),
(58, 'Curacao', 'CW'),
(59, 'Cyprus', 'CY'),
(60, 'Czech Republic', 'CZ'),
(61, 'Denmark', 'DK'),
(62, 'Djibouti', 'DJ'),
(63, 'Dominica', 'DM'),
(64, 'Dominican Republic', 'DO'),
(65, 'Ecuador', 'EC'),
(66, 'Egypt', 'EG'),
(67, 'El Salvador', 'SV'),
(68, 'Equatorial Guinea', 'GQ'),
(69, 'Eritrea', 'ER'),
(70, 'Estonia', 'EE'),
(71, 'Ethiopia', 'ET'),
(72, 'Falkland Islands (Malvinas)', 'FK'),
(73, 'Faroe Islands', 'FO'),
(74, 'Fiji', 'FJ'),
(75, 'Finland', 'FI'),
(76, 'France', 'FR'),
(77, 'French Guiana', 'GF'),
(78, 'French Polynesia', 'PF'),
(79, 'French Southern Territories', 'TF'),
(80, 'Gabon', 'GA'),
(81, 'Gambia', 'GM'),
(82, 'Georgia', 'GE'),
(83, 'Germany', 'DE'),
(84, 'Ghana', 'GH'),
(85, 'Gibraltar', 'GI'),
(86, 'Greece', 'GR'),
(87, 'Greenland', 'GL'),
(88, 'Grenada', 'GD'),
(89, 'Guadeloupe', 'GP'),
(90, 'Guam', 'GU'),
(91, 'Guatemala', 'GT'),
(92, 'Guernsey', 'GG'),
(93, 'Guinea', 'GN'),
(94, 'Guinea-Bissau', 'GW'),
(95, 'Guyana', 'GY'),
(96, 'Haiti', 'HT'),
(97, 'Heard Island and McDonald Islands', 'HM'),
(98, 'Holy See (Vatican City State)', 'VA'),
(99, 'Honduras', 'HN'),
(100, 'Hong Kong', 'HK'),
(101, 'Hungary', 'HU'),
(102, 'Iceland', 'IS'),
(103, 'India', 'IN'),
(104, 'Indonesia', 'ID'),
(105, 'Iran, Islamic Republic of', 'IR'),
(106, 'Iraq', 'IQ'),
(107, 'Ireland', 'IE'),
(108, 'Isle of Man', 'IM'),
(109, 'Israel', 'IL'),
(110, 'Italy', 'IT'),
(111, 'Jamaica', 'JM'),
(112, 'Japan', 'JP'),
(113, 'Jersey', 'JE'),
(114, 'Jordan', 'JO'),
(115, 'Kazakhstan', 'KZ'),
(116, 'Kenya', 'KE'),
(117, 'Kiribati', 'KI'),
(118, 'Korea, Democratic People\'s Republic of', 'KP'),
(119, 'Korea, Republic of', 'KR'),
(120, 'Kuwait', 'KW'),
(121, 'Kyrgyzstan', 'KG'),
(122, 'Lao People\'s Democratic Republic', 'LA'),
(123, 'Latvia', 'LV'),
(124, 'Lebanon', 'LB'),
(125, 'Lesotho', 'LS'),
(126, 'Liberia', 'LR'),
(127, 'Libya', 'LY'),
(128, 'Liechtenstein', 'LI'),
(129, 'Lithuania', 'LT'),
(130, 'Luxembourg', 'LU'),
(131, 'Macao', 'MO'),
(132, 'Macedonia, the Former Yugoslav Republic of', 'MK'),
(133, 'Madagascar', 'MG'),
(134, 'Malawi', 'MW'),
(135, 'Malaysia', 'MY'),
(136, 'Maldives', 'MV'),
(137, 'Mali', 'ML'),
(138, 'Malta', 'MT'),
(139, 'Marshall Islands', 'MH'),
(140, 'Martinique', 'MQ'),
(141, 'Mauritania', 'MR'),
(142, 'Mauritius', 'MU'),
(143, 'Mayotte', 'YT'),
(144, 'Mexico', 'MX'),
(145, 'Micronesia, Federated States of', 'FM'),
(146, 'Moldova, Republic of', 'MD'),
(147, 'Monaco', 'MC'),
(148, 'Mongolia', 'MN'),
(149, 'Montenegro', 'ME'),
(150, 'Montserrat', 'MS'),
(151, 'Morocco', 'MA'),
(152, 'Mozambique', 'MZ'),
(153, 'Myanmar', 'MM'),
(154, 'Namibia', 'NA'),
(155, 'Nauru', 'NR'),
(156, 'Nepal', 'NP'),
(157, 'Netherlands', 'NL'),
(158, 'New Caledonia', 'NC'),
(159, 'New Zealand', 'NZ'),
(160, 'Nicaragua', 'NI'),
(161, 'Niger', 'NE'),
(162, 'Nigeria', 'NG'),
(163, 'Niue', 'NU'),
(164, 'Norfolk Island', 'NF'),
(165, 'Northern Mariana Islands', 'MP'),
(166, 'Norway', 'NO'),
(167, 'Oman', 'OM'),
(168, 'Pakistan', 'PK'),
(169, 'Palau', 'PW'),
(170, 'Palestine, State of', 'PS'),
(171, 'Panama', 'PA'),
(172, 'Papua New Guinea', 'PG'),
(173, 'Paraguay', 'PY'),
(174, 'Peru', 'PE'),
(175, 'Philippines', 'PH'),
(176, 'Pitcairn', 'PN'),
(177, 'Poland', 'PL'),
(178, 'Portugal', 'PT'),
(179, 'Puerto Rico', 'PR'),
(180, 'Qatar', 'QA'),
(181, 'Reunion', 'RE'),
(182, 'Romania', 'RO'),
(183, 'Russian Federation', 'RU'),
(184, 'Rwanda', 'RW'),
(185, 'Saint Barthelemy', 'BL'),
(186, 'Saint Helena, Ascension and Tristan da Cunha', 'SH'),
(187, 'Saint Kitts and Nevis', 'KN'),
(188, 'Saint Lucia', 'LC'),
(189, 'Saint Martin (French part)', 'MF'),
(190, 'Saint Pierre and Miquelon', 'PM'),
(191, 'Saint Vincent and the Grenadines', 'VC'),
(192, 'Samoa', 'WS'),
(193, 'San Marino', 'SM'),
(194, 'Sao Tome and Principe', 'ST'),
(195, 'Saudi Arabia', 'SA'),
(196, 'Senegal', 'SN'),
(197, 'Serbia', 'RS'),
(198, 'Seychelles', 'SC'),
(199, 'Sierra Leone', 'SL'),
(200, 'Singapore', 'SG'),
(201, 'Sint Maarten (Dutch part)', 'SX'),
(202, 'Slovakia', 'SK'),
(203, 'Slovenia', 'SI'),
(204, 'Solomon Islands', 'SB'),
(205, 'Somalia', 'SO'),
(206, 'South Africa', 'ZA'),
(207, 'South Georgia and the South Sandwich Islands', 'GS'),
(208, 'South Sudan', 'SS'),
(209, 'Spain', 'ES'),
(210, 'Sri Lanka', 'LK'),
(211, 'Sudan', 'SD'),
(212, 'Suriname', 'SR'),
(213, 'Svalbard and Jan Mayen', 'SJ'),
(214, 'Swaziland', 'SZ'),
(215, 'Sweden', 'SE'),
(216, 'Switzerland', 'CH'),
(217, 'Syrian Arab Republic', 'SY'),
(218, 'Taiwan, Province of China', 'TW'),
(219, 'Tajikistan', 'TJ'),
(220, 'Tanzania, United Republic of', 'TZ'),
(221, 'Thailand', 'TH'),
(222, 'Timor-Leste', 'TL'),
(223, 'Togo', 'TG'),
(224, 'Tokelau', 'TK'),
(225, 'Tonga', 'TO'),
(226, 'Trinidad and Tobago', 'TT'),
(227, 'Tunisia', 'TN'),
(228, 'Turkey', 'TR'),
(229, 'Turkmenistan', 'TM'),
(230, 'Turks and Caicos Islands', 'TC'),
(231, 'Tuvalu', 'TV'),
(232, 'Uganda', 'UG'),
(233, 'Ukraine', 'UA'),
(234, 'United Arab Emirates', 'AE'),
(235, 'United Kingdom', 'GB'),
(236, 'United States', 'US'),
(237, 'United States Minor Outlying Islands', 'UM'),
(238, 'Uruguay', 'UY'),
(239, 'Uzbekistan', 'UZ'),
(240, 'Vanuatu', 'VU'),
(241, 'Venezuela, Bolivarian Republic of', 'VE'),
(242, 'Viet Nam', 'VN'),
(243, 'Virgin Islands, British', 'VG'),
(244, 'Virgin Islands, U.S.', 'VI'),
(245, 'Wallis and Futuna', 'WF'),
(246, 'Western Sahara', 'EH'),
(247, 'Yemen', 'YE'),
(248, 'Zambia', 'ZM'),
(249, 'Zimbabwe', 'ZW');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_guid` varchar(255) DEFAULT NULL,
  `department_guid` varchar(32) DEFAULT NULL,
  `department_name` varchar(255) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `color` varchar(32) DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `client_guid`, `department_guid`, `department_name`, `description`, `color`, `status`) VALUES
(1, '244444', 'JGbv0gaiEU1nMmcsfHBhlrtk54RWT9XV', 'This is the first department', 'i am adding a new department into the database. I am confident first test will work out.', '#000000', '1'),
(2, '244444', 'Ujs3IObGKPlEua59nexZ1LXtmqv2B7dy', 'Methodist Youth Fellowship', 'This is the youth fellowship', '#eecd2b', '1'),
(3, '244444', 'sX9Yrq8CQ7gnwaKBThEfmRFM4b3AcJLN', 'Tes Delete', 'This is a test delete', '#000000', '0'),
(4, '244444', 'Mez6F1RuHKA32ZvLWnNYPJ4qr7waIcCj', 'New Department Addition - Edited', 'Test new department adding', '#d20f0f', '1');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `client_guid` varchar(32) DEFAULT NULL,
  `event_guid` varchar(32) DEFAULT NULL,
  `event_title` varchar(255) DEFAULT NULL,
  `event_slug` varchar(255) DEFAULT NULL,
  `halls_guid` varchar(1000) DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `start_time` varchar(20) DEFAULT NULL,
  `end_time` varchar(20) DEFAULT NULL,
  `booking_start_time` datetime DEFAULT NULL,
  `booking_end_time` datetime DEFAULT NULL,
  `is_payable` enum('0','1') DEFAULT '0',
  `department_guid` varchar(32) DEFAULT NULL,
  `allow_multiple_booking` enum('0','1') NOT NULL DEFAULT '1',
  `maximum_multiple_booking` int(10) UNSIGNED NOT NULL DEFAULT 3,
  `attachment` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `ticket_guid` varchar(32) DEFAULT NULL,
  `state` enum('pending','in-progress','cancelled','past') DEFAULT 'pending',
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(32) DEFAULT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `client_guid`, `event_guid`, `event_title`, `event_slug`, `halls_guid`, `event_date`, `start_time`, `end_time`, `booking_start_time`, `booking_end_time`, `is_payable`, `department_guid`, `allow_multiple_booking`, `maximum_multiple_booking`, `attachment`, `description`, `ticket_guid`, `state`, `created_on`, `created_by`, `deleted`) VALUES
(1, '244444', 'TKOzIsL1nP25Xk3pHcJChfYBrmGoE0gR', 'Test Event', 'test-event', 'jsN64gp3daOnXiLSyzAEK0VuQ1qDbI5x,Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '2020-07-12', '07:00', '20:24', '2020-07-07 19:25:00', '2020-07-11 22:30:00', '0', 'Mez6F1RuHKA32ZvLWnNYPJ4qr7waIcCj', '1', 3, NULL, 'This is the event description', NULL, 'in-progress', '2020-07-07 19:31:47', 'KidkkL949', '0');

-- --------------------------------------------------------

--
-- Table structure for table `events_booking`
--

CREATE TABLE `events_booking` (
  `id` int(11) NOT NULL,
  `event_guid` varchar(32) DEFAULT NULL,
  `hall_guid` varchar(32) DEFAULT NULL,
  `seat_guid` varchar(20) DEFAULT NULL,
  `seat_name` varchar(32) DEFAULT NULL,
  `ticket_guid` varchar(32) DEFAULT NULL,
  `ticket_serial` varchar(32) DEFAULT NULL,
  `booked_by` varchar(32) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `created_by` varchar(32) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0',
  `deleted` enum('0','1') DEFAULT '0',
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `user_agent` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events_booking`
--

INSERT INTO `events_booking` (`id`, `event_guid`, `hall_guid`, `seat_guid`, `seat_name`, `ticket_guid`, `ticket_serial`, `booked_by`, `fullname`, `created_by`, `address`, `status`, `deleted`, `created_on`, `user_agent`) VALUES
(2, 'TKOzIsL1nP25Xk3pHcJChfYBrmGoE0gR', 'jsN64gp3daOnXiLSyzAEK0VuQ1qDbI5x', '6_3', '6_3', NULL, NULL, NULL, 'Emmanuel Obeng', '0550107770', 'Dodowa, Accra', '1', '0', '2020-07-07 19:39:27', 'Windows 10|Chrome'),
(3, 'TKOzIsL1nP25Xk3pHcJChfYBrmGoE0gR', 'jsN64gp3daOnXiLSyzAEK0VuQ1qDbI5x', '6_9', '6_9', NULL, NULL, NULL, 'Grace Obeng', '0240553604', 'Shiashie, Accra', '1', '0', '2020-07-07 19:39:28', 'Windows 10|Chrome'),
(4, 'TKOzIsL1nP25Xk3pHcJChfYBrmGoE0gR', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '7_2', '50', NULL, NULL, NULL, 'Emmanuel Obeng', '0550107770', 'The Address of my place.', '0', '1', '2020-07-07 20:07:32', 'Windows 10|Chrome'),
(5, 'TKOzIsL1nP25Xk3pHcJChfYBrmGoE0gR', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '4_5', '4_5', NULL, NULL, NULL, 'That is my name', '0550107770', 'thatnk ', '1', '0', '2020-07-07 20:08:22', 'Windows 10|Chrome'),
(6, 'TKOzIsL1nP25Xk3pHcJChfYBrmGoE0gR', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '62', '62', NULL, NULL, '0240553604', 'Emmanuella Darko', '0240553604', 'House Address', '1', '0', '2020-07-07 22:32:50', 'Windows 10|Chrome');

-- --------------------------------------------------------

--
-- Table structure for table `events_halls_configuration`
--

CREATE TABLE `events_halls_configuration` (
  `id` int(11) NOT NULL,
  `event_guid` varchar(32) DEFAULT NULL,
  `hall_guid` varchar(32) DEFAULT NULL,
  `hall_name` varchar(255) DEFAULT NULL,
  `rows` varchar(32) DEFAULT NULL,
  `columns` varchar(32) DEFAULT NULL,
  `configuration` text DEFAULT NULL,
  `commenced` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events_halls_configuration`
--

INSERT INTO `events_halls_configuration` (`id`, `event_guid`, `hall_guid`, `hall_name`, `rows`, `columns`, `configuration`, `commenced`) VALUES
(1, 'TKOzIsL1nP25Xk3pHcJChfYBrmGoE0gR', 'jsN64gp3daOnXiLSyzAEK0VuQ1qDbI5x', 'Main Hall', '7', '11', '{\"blocked\":[\"4_5\",\"4_6\",\"4_7\",\"6_3\",\"6_9\"],\"removed\":{\"0\":\"1_1\",\"1\":\"1_2\",\"2\":\"1_10\",\"3\":\"1_11\",\"4\":\"6_1\",\"5\":\"6_2\",\"6\":\"6_10\",\"7\":\"6_11\",\"8\":\"7_4\",\"9\":\"7_5\",\"10\":\"7_6\",\"11\":\"7_7\",\"12\":\"7_8\",\"26\":\"3_3\",\"27\":\"3_4\",\"28\":\"3_8\",\"29\":\"3_9\"},\"labels\":{\"1_3\":\"M3\",\"1_4\":\"M4\",\"1_5\":\"M5\",\"1_6\":\"M6\",\"1_7\":\"M7\",\"1_8\":\"M8\",\"1_9\":\"M9\",\"2_1\":\"M22\",\"2_2\":\"M21\",\"2_3\":\"M20\",\"2_4\":\"M19\",\"2_5\":\"M18\",\"2_6\":\"M17\",\"2_7\":\"M16\",\"2_8\":\"M15\",\"2_9\":\"M14\",\"2_10\":\"M13\",\"2_11\":\"M12\",\"3_1\":\"R23\",\"3_2\":\"M24\",\"3_5\":\"M27\",\"3_6\":\"M28\",\"3_7\":\"M29\",\"3_10\":\"M32\",\"3_11\":\"M33\",\"4_1\":\"R44\",\"4_2\":\"M43\",\"4_3\":\"M42\",\"4_4\":\"M41\",\"4_5\":\"M40\",\"4_6\":\"M39\",\"4_7\":\"M38\",\"4_8\":\"M37\",\"4_9\":\"M36\",\"4_10\":\"M35\",\"4_11\":\"M34\",\"5_1\":\"R45\",\"5_2\":\"M46\",\"5_3\":\"M47\",\"5_4\":\"M48\",\"5_5\":\"M49\",\"5_6\":\"M50\",\"5_7\":\"M51\",\"5_8\":\"M52\",\"5_9\":\"M53\",\"5_10\":\"M54\",\"5_11\":\"M55\",\"6_4\":\"M59\",\"6_5\":\"M60\",\"6_6\":\"M61\",\"6_7\":\"M62\",\"6_8\":\"M63\",\"7_1\":\"R67\",\"7_2\":\"M68\",\"7_3\":\"M69\",\"7_9\":\"M75\",\"7_10\":\"M76\",\"7_11\":\"R77\"}}', '1'),
(2, 'TKOzIsL1nP25Xk3pHcJChfYBrmGoE0gR', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', 'Second Hall to Insert', '11', '8', '{\"blocked\":{\"0\":\"4_2\",\"1\":\"4_7\",\"2\":\"2_1\",\"3\":\"2_8\",\"4\":\"10_2\",\"5\":\"10_3\",\"6\":\"10_6\",\"7\":\"10_7\",\"8\":\"6_2\",\"9\":\"6_7\",\"10\":\"7_4\",\"11\":\"7_5\",\"12\":\"9_1\",\"13\":\"9_8\",\"15\":\"4_5\",\"16\":\"8_6\"},\"removed\":[\"8_2\",\"8_4\",\"8_5\",\"8_7\",\"5_4\",\"5_5\",\"2_4\",\"2_5\",\"11_4\",\"11_5\",\"11_1\",\"11_8\",\"10_4\",\"10_5\"],\"labels\":{\"1_1\":\"1\",\"1_2\":\"2\",\"1_3\":\"3\",\"1_4\":\"4\",\"1_5\":\"5\",\"1_6\":\"6\",\"1_7\":\"7\",\"1_8\":\"8\",\"2_1\":\"9\",\"2_2\":\"10\",\"2_3\":\"11\",\"2_6\":\"14\",\"2_7\":\"15\",\"2_8\":\"16\",\"3_1\":\"17\",\"3_2\":\"18\",\"3_3\":\"19\",\"3_4\":\"20\",\"3_5\":\"21\",\"3_6\":\"22\",\"3_7\":\"23\",\"3_8\":\"24\",\"4_1\":\"25\",\"4_2\":\"26\",\"4_3\":\"27\",\"4_4\":\"28\",\"4_6\":\"30\",\"4_7\":\"31\",\"4_8\":\"32\",\"5_1\":\"33\",\"5_2\":\"34\",\"5_3\":\"35\",\"5_6\":\"38\",\"5_7\":\"39\",\"5_8\":\"40\",\"6_1\":\"41\",\"6_2\":\"42\",\"6_3\":\"43\",\"6_4\":\"44\",\"6_5\":\"45\",\"6_6\":\"46\",\"6_7\":\"47\",\"6_8\":\"48\",\"7_1\":\"49\",\"7_3\":\"51\",\"7_4\":\"52\",\"7_5\":\"53\",\"7_6\":\"54\",\"7_7\":\"55\",\"7_8\":\"56\",\"8_1\":\"57\",\"8_3\":\"59\",\"8_8\":\"64\",\"9_1\":\"65\",\"9_2\":\"66\",\"9_3\":\"67\",\"9_4\":\"68\",\"9_5\":\"69\",\"9_6\":\"70\",\"9_7\":\"71\",\"9_8\":\"72\",\"10_1\":\"73\",\"10_2\":\"74\",\"10_3\":\"75\",\"10_6\":\"78\",\"10_7\":\"79\",\"10_8\":\"80\",\"11_2\":\"82\",\"11_3\":\"83\",\"11_6\":\"86\",\"11_7\":\"87\",\"7_2\":\"50\"}}', '1');

-- --------------------------------------------------------

--
-- Table structure for table `halls`
--

CREATE TABLE `halls` (
  `id` int(11) NOT NULL,
  `client_guid` varchar(32) DEFAULT NULL,
  `hall_guid` varchar(32) DEFAULT NULL,
  `rows` varchar(10) DEFAULT NULL,
  `columns` varchar(10) DEFAULT NULL,
  `seats` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `hall_name` varchar(255) DEFAULT NULL,
  `created_by` varchar(32) DEFAULT NULL,
  `configuration` varchar(2000) DEFAULT NULL,
  `facilities` varchar(2000) DEFAULT NULL,
  `overall_booking` int(10) UNSIGNED DEFAULT 0,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('0','1') NOT NULL DEFAULT '0',
  `deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `halls`
--

INSERT INTO `halls` (`id`, `client_guid`, `hall_guid`, `rows`, `columns`, `seats`, `hall_name`, `created_by`, `configuration`, `facilities`, `overall_booking`, `created_on`, `status`, `deleted`) VALUES
(1, '244444', 'kZyXxACRUgbdaVu2tH9qro01EfhY6LSm', '10', '9', 55, 'that is the test hall', '11111', '{\"blocked\":[],\"removed\":[\"1_1\",\"1_2\",\"1_3\",\"1_4\",\"1_6\",\"1_7\",\"1_8\",\"1_9\",\"2_1\",\"2_2\",\"2_3\",\"2_7\",\"2_8\",\"2_9\",\"3_1\",\"3_2\",\"3_8\",\"3_9\",\"4_1\",\"4_9\",\"5_2\",\"5_3\",\"5_4\",\"5_5\",\"5_6\",\"5_7\",\"5_8\",\"6_5\",\"7_5\",\"8_5\",\"9_4\",\"9_5\",\"9_6\",\"10_1\",\"10_9\"],\"labels\":{\"1_5\":\"A1\",\"2_4\":\"A2\",\"2_5\":\"A3\",\"2_6\":\"A4\",\"3_3\":\"A5\",\"3_4\":\"A6\",\"3_5\":\"A7\",\"3_6\":\"A8\",\"3_7\":\"A9\",\"4_2\":\"B1\",\"4_3\":\"B2\",\"4_4\":\"B3\",\"4_5\":\"B4\",\"4_6\":\"B5\",\"4_7\":\"B6\",\"4_8\":\"B7\",\"5_1\":\"B8\",\"5_9\":\"B9\",\"6_1\":\"C1\",\"6_2\":\"C2\",\"6_3\":\"C3\",\"6_4\":\"C4\",\"6_6\":\"C5\",\"6_7\":\"C6\",\"6_8\":\"C7\",\"6_9\":\"C8\",\"7_1\":\"D1\",\"7_2\":\"D2\",\"7_3\":\"D3\",\"7_4\":\"D4\",\"7_6\":\"D5\",\"7_7\":\"D6\",\"7_8\":\"D7\",\"7_9\":\"D8\",\"8_1\":\"D9\",\"8_2\":\"D10\",\"8_3\":\"D11\",\"8_4\":\"D12\",\"8_6\":\"D13\",\"8_7\":\"D14\",\"8_8\":\"D15\",\"8_9\":\"D16\",\"9_1\":\"D17\",\"9_2\":\"D18\",\"9_3\":\"D19\",\"9_7\":\"D20\",\"9_8\":\"D21\",\"9_9\":\"D22\",\"10_2\":\"E1\",\"10_3\":\"E2\",\"10_4\":\"E3\",\"10_5\":\"E4\",\"10_6\":\"E5\",\"10_7\":\"E6\",\"10_8\":\"E7\"}}', 'This hall has a lot of facilities that we are very much interest in. I am hoping that it will be a great service to all of us', 0, '2020-07-01 21:41:07', '1', '0'),
(2, '244444', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '11', '8', 74, 'Second Hall to Insert', '11111', '{\"blocked\":[\"4_2\",\"4_7\",\"2_1\",\"2_8\",\"10_2\",\"10_3\",\"10_6\",\"10_7\",\"6_2\",\"6_7\",\"7_4\",\"7_5\",\"9_1\",\"9_8\"],\"removed\":[\"8_2\",\"8_4\",\"8_5\",\"8_7\",\"5_4\",\"5_5\",\"2_4\",\"2_5\",\"11_4\",\"11_5\",\"11_1\",\"11_8\",\"10_4\",\"10_5\"],\"labels\":{\"1_1\":\"1\",\"1_2\":\"2\",\"1_3\":\"3\",\"1_4\":\"4\",\"1_5\":\"5\",\"1_6\":\"6\",\"1_7\":\"7\",\"1_8\":\"8\",\"2_1\":\"9\",\"2_2\":\"10\",\"2_3\":\"11\",\"2_6\":\"14\",\"2_7\":\"15\",\"2_8\":\"16\",\"3_1\":\"17\",\"3_2\":\"18\",\"3_3\":\"19\",\"3_4\":\"20\",\"3_5\":\"21\",\"3_6\":\"22\",\"3_7\":\"23\",\"3_8\":\"24\",\"4_1\":\"25\",\"4_2\":\"26\",\"4_3\":\"27\",\"4_4\":\"28\",\"4_5\":\"29\",\"4_6\":\"30\",\"4_7\":\"31\",\"4_8\":\"32\",\"5_1\":\"33\",\"5_2\":\"34\",\"5_3\":\"35\",\"5_6\":\"38\",\"5_7\":\"39\",\"5_8\":\"40\",\"6_1\":\"41\",\"6_2\":\"42\",\"6_3\":\"43\",\"6_4\":\"44\",\"6_5\":\"45\",\"6_6\":\"46\",\"6_7\":\"47\",\"6_8\":\"48\",\"7_1\":\"49\",\"7_2\":\"50\",\"7_3\":\"51\",\"7_4\":\"52\",\"7_5\":\"53\",\"7_6\":\"54\",\"7_7\":\"55\",\"7_8\":\"56\",\"8_1\":\"57\",\"8_3\":\"59\",\"8_6\":\"62\",\"8_8\":\"64\",\"9_1\":\"65\",\"9_2\":\"66\",\"9_3\":\"67\",\"9_4\":\"68\",\"9_5\":\"69\",\"9_6\":\"70\",\"9_7\":\"71\",\"9_8\":\"72\",\"10_1\":\"73\",\"10_2\":\"74\",\"10_3\":\"75\",\"10_6\":\"78\",\"10_7\":\"79\",\"10_8\":\"80\",\"11_2\":\"82\",\"11_3\":\"83\",\"11_6\":\"86\",\"11_7\":\"87\"}}', '', 3, '2020-07-01 21:44:12', '1', '0'),
(3, '244444', '1OV9ytXor7Qdu4lZc0Cqxhgk5WLTMesB', '7', '8', 46, 'Final Test No errors', '11111', '{\"blocked\":[\"1_1\",\"1_8\",\"4_4\",\"4_5\"],\"removed\":[\"7_4\",\"7_5\",\"1_1\",\"1_8\",\"6_1\",\"6_8\",\"6_3\",\"6_4\",\"6_5\",\"6_6\"],\"labels\":{\"1_2\":\"2\",\"1_3\":\"3\",\"1_4\":\"4\",\"1_5\":\"5\",\"1_6\":\"6\",\"1_7\":\"7\",\"2_1\":\"M9\",\"2_2\":\"10\",\"2_3\":\"11\",\"2_4\":\"12\",\"2_5\":\"13\",\"2_6\":\"M14\",\"2_7\":\"15\",\"2_8\":\"16\",\"3_1\":\"17\",\"3_2\":\"18\",\"3_3\":\"19\",\"3_4\":\"M20\",\"3_5\":\"21\",\"3_6\":\"M22\",\"3_7\":\"23\",\"3_8\":\"24\",\"4_1\":\"25\",\"4_2\":\"M26\",\"4_3\":\"27\",\"4_4\":\"\",\"4_5\":\"\",\"4_6\":\"30\",\"4_7\":\"M31\",\"4_8\":\"32\",\"5_1\":\"33\",\"5_2\":\"34\",\"5_3\":\"M35\",\"5_4\":\"36\",\"5_5\":\"37\",\"5_6\":\"M38\",\"5_7\":\"39\",\"5_8\":\"40\",\"6_2\":\"M42\",\"6_7\":\"47\",\"7_1\":\"49\",\"7_2\":\"50\",\"7_3\":\"51\",\"7_6\":\"54\",\"7_7\":\"55\",\"7_8\":\"56\"}}', 'This is the final test', 0, '2020-07-01 21:45:18', '1', '0'),
(5, '244444', 'CENwouk4yhHGXDfdixsgLrTlFtIp9jOq', '12', '12', 110, 'Craziest Hall With Seat', 'KidkkL949', '{\"blocked\":[],\"removed\":[\"1_1\",\"1_2\",\"1_11\",\"1_12\",\"2_4\",\"2_5\",\"2_6\",\"2_7\",\"2_8\",\"2_9\",\"4_6\",\"4_7\",\"6_3\",\"6_6\",\"6_7\",\"6_10\",\"7_6\",\"7_7\",\"8_6\",\"8_7\",\"9_1\",\"9_12\",\"10_1\",\"10_12\",\"11_1\",\"11_2\",\"11_11\",\"11_12\",\"12_1\",\"12_2\",\"12_3\",\"12_10\",\"12_11\",\"12_12\"],\"labels\":{\"1_3\":\"3\",\"1_4\":\"4\",\"1_5\":\"5\",\"1_6\":\"6\",\"1_7\":\"7\",\"1_8\":\"8\",\"1_9\":\"9\",\"1_10\":\"10\",\"2_1\":\"13\",\"2_2\":\"14\",\"2_3\":\"15\",\"2_10\":\"22\",\"2_11\":\"23\",\"2_12\":\"24\",\"3_1\":\"25\",\"3_2\":\"26\",\"3_3\":\"27\",\"3_4\":\"28\",\"3_5\":\"29\",\"3_6\":\"30\",\"3_7\":\"31\",\"3_8\":\"32\",\"3_9\":\"33\",\"3_10\":\"34\",\"3_11\":\"35\",\"3_12\":\"36\",\"4_1\":\"37\",\"4_2\":\"38\",\"4_3\":\"39\",\"4_4\":\"40\",\"4_5\":\"41\",\"4_8\":\"44\",\"4_9\":\"45\",\"4_10\":\"46\",\"4_11\":\"47\",\"4_12\":\"48\",\"5_1\":\"49\",\"5_2\":\"50\",\"5_3\":\"51\",\"5_4\":\"52\",\"5_5\":\"53\",\"5_6\":\"54\",\"5_7\":\"55\",\"5_8\":\"56\",\"5_9\":\"57\",\"5_10\":\"58\",\"5_11\":\"59\",\"5_12\":\"60\",\"6_1\":\"61\",\"6_2\":\"62\",\"6_4\":\"64\",\"6_5\":\"65\",\"6_8\":\"68\",\"6_9\":\"69\",\"6_11\":\"71\",\"6_12\":\"72\",\"7_1\":\"73\",\"7_2\":\"74\",\"7_3\":\"75\",\"7_4\":\"76\",\"7_5\":\"77\",\"7_8\":\"80\",\"7_9\":\"81\",\"7_10\":\"82\",\"7_11\":\"83\",\"7_12\":\"84\",\"8_1\":\"85\",\"8_2\":\"86\",\"8_3\":\"87\",\"8_4\":\"88\",\"8_5\":\"89\",\"8_8\":\"92\",\"8_9\":\"93\",\"8_10\":\"94\",\"8_11\":\"95\",\"8_12\":\"96\",\"9_2\":\"98\",\"9_3\":\"99\",\"9_4\":\"100\",\"9_5\":\"101\",\"9_6\":\"102\",\"9_7\":\"103\",\"9_8\":\"104\",\"9_9\":\"105\",\"9_10\":\"106\",\"9_11\":\"107\",\"10_2\":\"110\",\"10_3\":\"111\",\"10_4\":\"112\",\"10_5\":\"113\",\"10_6\":\"114\",\"10_7\":\"115\",\"10_8\":\"116\",\"10_9\":\"117\",\"10_10\":\"118\",\"10_11\":\"119\",\"11_3\":\"123\",\"11_4\":\"124\",\"11_5\":\"125\",\"11_6\":\"126\",\"11_7\":\"127\",\"11_8\":\"128\",\"11_9\":\"129\",\"11_10\":\"130\",\"12_4\":\"136\",\"12_5\":\"137\",\"12_6\":\"138\",\"12_7\":\"139\",\"12_8\":\"140\",\"12_9\":\"141\"}}', '', 0, '2020-07-02 08:18:32', '1', '0'),
(6, '244444', 'pQSP594rEGjlzyVOtae6YiTqfuhxvg8I', '2', '3', 6, 'jhgjhgj', 'KidkkL949', '{\"blocked\":[],\"removed\":[],\"labels\":{\"1_1\":1,\"1_2\":2,\"1_3\":3,\"2_1\":4,\"2_2\":5,\"2_3\":6}}', '', 0, '2020-07-02 09:07:00', '0', '1'),
(7, '244444', 'jsN64gp3daOnXiLSyzAEK0VuQ1qDbI5x', '7', '11', 58, 'Main Hall', 'KidkkL949', '{\"blocked\":[\"4_5\",\"4_6\",\"4_7\",\"7_3\",\"7_9\"],\"removed\":[\"1_1\",\"1_2\",\"1_10\",\"1_11\",\"6_1\",\"6_2\",\"6_10\",\"6_11\",\"7_4\",\"7_5\",\"7_6\",\"7_7\",\"7_8\",\"3_3\",\"3_4\",\"3_8\",\"3_9\",\"4_1\",\"4_11\"],\"labels\":{\"1_3\":\"M3\",\"1_4\":\"M4\",\"1_5\":\"M5\",\"1_6\":\"M6\",\"1_7\":\"M7\",\"1_8\":\"M8\",\"1_9\":\"M9\",\"2_1\":\"M22\",\"2_2\":\"M21\",\"2_3\":\"M20\",\"2_4\":\"M19\",\"2_5\":\"M18\",\"2_6\":\"M17\",\"2_7\":\"M16\",\"2_8\":\"M15\",\"2_9\":\"M14\",\"2_10\":\"M13\",\"2_11\":\"M12\",\"3_1\":\"R23\",\"3_2\":\"M24\",\"3_5\":\"M27\",\"3_6\":\"M28\",\"3_7\":\"M29\",\"3_10\":\"M32\",\"3_11\":\"M33\",\"4_2\":\"M43\",\"4_3\":\"M42\",\"4_4\":\"M41\",\"4_5\":\"M40\",\"4_6\":\"M39\",\"4_7\":\"M38\",\"4_8\":\"M37\",\"4_9\":\"M36\",\"4_10\":\"M35\",\"5_1\":\"R45\",\"5_2\":\"M46\",\"5_3\":\"M47\",\"5_4\":\"M48\",\"5_5\":\"M49\",\"5_6\":\"M50\",\"5_7\":\"M51\",\"5_8\":\"M52\",\"5_9\":\"M53\",\"5_10\":\"M54\",\"5_11\":\"M55\",\"6_3\":\"M58\",\"6_4\":\"M59\",\"6_5\":\"M60\",\"6_6\":\"M61\",\"6_7\":\"M62\",\"6_8\":\"M63\",\"6_9\":\"M64\",\"7_1\":\"R67\",\"7_2\":\"M68\",\"7_3\":\"M69\",\"7_9\":\"M75\",\"7_10\":\"M76\",\"7_11\":\"R77\"}}', 'test hall insert', 2, '2020-07-04 00:00:13', '1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) UNSIGNED NOT NULL,
  `client_guid` varchar(32) DEFAULT NULL,
  `ticket_guid` varchar(255) DEFAULT NULL,
  `ticket_title` varchar(255) DEFAULT NULL,
  `number_generated` int(12) UNSIGNED DEFAULT 0,
  `number_sold` int(12) UNSIGNED NOT NULL DEFAULT 0,
  `number_left` int(12) UNSIGNED NOT NULL DEFAULT 0,
  `is_payable` enum('0','1') NOT NULL DEFAULT '0',
  `ticket_amount` double(12,2) NOT NULL DEFAULT 0.00,
  `created_on` datetime DEFAULT current_timestamp(),
  `created_by` varchar(32) DEFAULT NULL,
  `generated` enum('yes','waiting') NOT NULL DEFAULT 'waiting',
  `activated` enum('0','1') NOT NULL DEFAULT '0',
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `client_guid`, `ticket_guid`, `ticket_title`, `number_generated`, `number_sold`, `number_left`, `is_payable`, `ticket_amount`, `created_on`, `created_by`, `generated`, `activated`, `status`) VALUES
(1, '244444', 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'Tickets to use for some events', 100, 0, 0, '1', 40.00, '2020-07-05 17:06:32', 'KidkkL949', 'yes', '0', '1'),
(2, '244444', 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'Another Ticket for Event', 300, 0, 0, '1', 100.00, '2020-07-05 17:06:57', 'KidkkL949', 'yes', '0', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tickets_listing`
--

CREATE TABLE `tickets_listing` (
  `id` int(11) UNSIGNED NOT NULL,
  `ticket_guid` varchar(32) DEFAULT NULL,
  `ticket_serial` varchar(32) DEFAULT NULL,
  `ticket_amount` double(12,2) NOT NULL DEFAULT 0.00,
  `sold_state` enum('0','1') NOT NULL DEFAULT '0',
  `sold_by` varchar(32) DEFAULT NULL,
  `bought_by` varchar(32) DEFAULT NULL,
  `used_date` datetime DEFAULT NULL,
  `event_booked` varchar(32) DEFAULT NULL,
  `status` enum('pending','used','invalid') DEFAULT 'pending',
  `created_by` varchar(32) DEFAULT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tickets_listing`
--

INSERT INTO `tickets_listing` (`id`, `ticket_guid`, `ticket_serial`, `ticket_amount`, `sold_state`, `sold_by`, `bought_by`, `used_date`, `event_booked`, `status`, `created_by`, `created_on`) VALUES
(1, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000001', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(2, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000002', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(3, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000003', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(4, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000004', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(5, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000005', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(6, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000006', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(7, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000007', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(8, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000008', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(9, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000009', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(10, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000010', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(11, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000011', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(12, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000012', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(13, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000013', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(14, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000014', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(15, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000015', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(16, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000016', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(17, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000017', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(18, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000018', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(19, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000019', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(20, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000020', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(21, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000021', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(22, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000022', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(23, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000023', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(24, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000024', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(25, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000025', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(26, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000026', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(27, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000027', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(28, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000028', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(29, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000029', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(30, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000030', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(31, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000031', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(32, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000032', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(33, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000033', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(34, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000034', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(35, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000035', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(36, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000036', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(37, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000037', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(38, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000038', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(39, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000039', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(40, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000040', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(41, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000041', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(42, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000042', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(43, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000043', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(44, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000044', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(45, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000045', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(46, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000046', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(47, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000047', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(48, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000048', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(49, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000049', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(50, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000050', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(51, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000051', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(52, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000052', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(53, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000053', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(54, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000054', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(55, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000055', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(56, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000056', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(57, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000057', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(58, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000058', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(59, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000059', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(60, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000060', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(61, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000061', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(62, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000062', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(63, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000063', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(64, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000064', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(65, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000065', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(66, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000066', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(67, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000067', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(68, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000068', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(69, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000069', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(70, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000070', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(71, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000071', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(72, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000072', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(73, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000073', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(74, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000074', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(75, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000075', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(76, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000076', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(77, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000077', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(78, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000078', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(79, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000079', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(80, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000080', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(81, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000081', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(82, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000082', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(83, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000083', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(84, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000084', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(85, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000085', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(86, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000086', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(87, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000087', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(88, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000088', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(89, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000089', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(90, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000090', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(91, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000091', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(92, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000092', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(93, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000093', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(94, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000094', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(95, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000095', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(96, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000096', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(97, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000097', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(98, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000098', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(99, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000099', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(100, 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000100', 40.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:32'),
(101, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000001', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(102, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000002', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(103, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000003', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(104, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000004', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(105, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000005', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(106, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000006', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(107, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000007', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(108, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000008', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(109, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000009', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(110, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000010', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(111, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000011', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(112, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000012', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(113, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000013', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(114, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000014', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(115, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000015', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(116, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000016', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(117, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000017', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(118, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000018', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(119, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000019', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(120, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000020', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(121, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000021', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(122, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000022', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(123, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000023', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(124, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000024', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(125, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000025', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(126, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000026', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(127, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000027', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(128, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000028', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(129, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000029', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(130, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000030', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(131, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000031', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(132, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000032', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(133, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000033', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(134, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000034', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(135, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000035', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(136, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000036', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(137, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000037', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(138, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000038', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(139, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000039', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(140, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000040', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(141, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000041', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(142, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000042', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(143, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000043', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(144, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000044', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(145, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000045', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(146, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000046', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(147, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000047', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(148, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000048', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(149, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000049', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(150, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000050', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(151, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000051', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(152, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000052', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(153, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000053', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(154, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000054', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(155, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000055', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(156, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000056', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(157, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000057', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(158, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000058', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(159, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000059', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(160, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000060', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(161, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000061', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(162, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000062', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(163, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000063', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(164, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000064', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(165, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000065', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(166, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000066', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(167, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000067', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(168, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000068', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(169, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000069', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(170, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000070', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(171, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000071', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(172, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000072', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(173, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000073', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(174, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000074', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(175, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000075', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(176, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000076', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(177, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000077', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(178, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000078', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(179, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000079', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(180, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000080', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(181, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000081', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(182, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000082', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(183, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000083', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(184, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000084', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(185, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000085', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(186, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000086', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(187, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000087', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(188, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000088', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(189, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000089', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(190, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000090', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(191, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000091', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(192, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000092', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(193, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000093', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(194, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000094', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(195, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000095', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(196, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000096', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(197, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000097', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(198, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000098', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(199, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000099', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(200, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000100', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(201, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000101', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(202, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000102', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(203, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000103', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(204, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000104', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(205, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000105', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(206, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000106', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(207, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000107', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(208, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000108', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(209, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000109', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(210, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000110', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(211, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000111', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(212, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000112', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(213, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000113', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(214, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000114', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(215, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000115', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(216, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000116', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(217, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000117', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(218, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000118', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(219, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000119', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(220, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000120', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(221, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000121', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(222, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000122', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(223, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000123', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(224, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000124', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(225, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000125', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(226, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000126', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(227, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000127', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(228, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000128', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(229, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000129', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(230, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000130', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(231, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000131', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(232, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000132', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(233, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000133', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(234, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000134', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(235, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000135', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(236, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000136', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(237, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000137', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(238, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000138', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(239, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000139', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(240, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000140', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(241, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000141', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(242, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000142', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(243, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000143', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(244, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000144', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(245, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000145', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(246, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000146', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(247, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000147', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(248, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000148', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(249, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000149', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(250, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000150', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(251, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000151', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(252, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000152', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(253, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000153', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(254, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000154', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(255, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000155', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(256, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000156', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(257, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000157', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(258, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000158', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(259, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000159', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(260, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000160', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(261, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000161', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(262, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000162', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(263, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000163', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(264, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000164', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(265, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000165', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(266, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000166', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(267, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000167', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(268, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000168', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(269, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000169', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(270, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000170', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(271, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000171', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(272, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000172', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(273, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000173', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(274, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000174', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(275, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000175', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(276, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000176', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(277, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000177', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(278, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000178', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(279, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000179', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(280, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000180', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(281, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000181', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(282, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000182', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(283, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000183', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(284, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000184', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(285, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000185', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(286, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000186', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(287, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000187', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(288, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000188', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(289, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000189', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(290, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000190', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(291, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000191', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(292, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000192', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(293, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000193', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(294, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000194', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(295, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000195', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(296, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000196', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(297, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000197', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(298, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000198', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(299, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000199', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(300, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000200', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(301, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000201', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(302, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000202', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(303, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000203', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(304, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000204', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(305, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000205', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(306, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000206', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(307, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000207', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(308, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000208', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(309, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000209', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(310, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000210', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(311, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000211', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(312, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000212', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(313, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000213', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(314, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000214', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(315, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000215', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(316, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000216', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(317, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000217', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(318, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000218', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(319, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000219', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(320, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000220', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(321, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000221', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(322, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000222', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(323, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000223', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(324, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000224', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(325, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000225', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(326, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000226', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(327, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000227', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(328, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000228', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(329, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000229', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(330, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000230', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(331, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000231', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(332, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000232', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(333, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000233', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(334, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000234', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(335, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000235', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(336, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000236', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(337, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000237', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(338, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000238', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(339, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000239', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(340, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000240', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(341, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000241', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(342, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000242', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(343, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000243', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(344, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000244', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(345, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000245', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(346, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000246', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(347, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000247', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(348, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000248', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(349, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000249', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(350, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000250', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(351, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000251', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(352, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000252', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(353, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000253', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(354, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000254', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(355, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000255', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(356, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000256', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(357, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000257', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(358, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000258', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(359, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000259', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(360, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000260', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(361, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000261', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(362, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000262', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(363, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000263', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(364, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000264', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(365, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000265', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(366, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000266', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(367, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000267', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(368, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000268', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(369, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000269', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(370, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000270', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(371, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000271', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(372, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000272', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(373, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000273', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(374, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000274', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(375, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000275', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(376, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000276', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(377, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000277', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(378, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000278', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(379, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000279', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(380, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000280', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(381, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000281', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(382, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000282', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(383, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000283', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(384, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000284', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57');
INSERT INTO `tickets_listing` (`id`, `ticket_guid`, `ticket_serial`, `ticket_amount`, `sold_state`, `sold_by`, `bought_by`, `used_date`, `event_booked`, `status`, `created_by`, `created_on`) VALUES
(385, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000285', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(386, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000286', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(387, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000287', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(388, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000288', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(389, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000289', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(390, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000290', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(391, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000291', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(392, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000292', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(393, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000293', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(394, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000294', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(395, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000295', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(396, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000296', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(397, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000297', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(398, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000298', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(399, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000299', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57'),
(400, 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'ER000300', 100.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-07-05 17:06:57');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `client_guid` varchar(32) CHARACTER SET latin1 DEFAULT NULL,
  `user_guid` varchar(32) CHARACTER SET latin1 DEFAULT NULL,
  `name` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `gender` enum('Male','Female') CHARACTER SET latin1 DEFAULT NULL,
  `email` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `username` varchar(25) CHARACTER SET latin1 DEFAULT NULL,
  `password` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `access_level` int(11) UNSIGNED NOT NULL DEFAULT 6,
  `theme` enum('1','2') CHARACTER SET latin1 NOT NULL DEFAULT '2',
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `deleted` enum('0','1') CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `verify_token` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `last_login` datetime DEFAULT current_timestamp(),
  `last_login_attempts_time` datetime DEFAULT current_timestamp(),
  `contact` varchar(15) CHARACTER SET latin1 DEFAULT NULL,
  `created_on` datetime DEFAULT current_timestamp(),
  `created_by` varchar(11) CHARACTER SET latin1 DEFAULT NULL,
  `image` varchar(255) CHARACTER SET latin1 DEFAULT 'assets/img/profiles/avatar.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `client_guid`, `user_guid`, `name`, `gender`, `email`, `username`, `password`, `access_level`, `theme`, `status`, `deleted`, `verify_token`, `last_login`, `last_login_attempts_time`, `contact`, `created_on`, `created_by`, `image`) VALUES
(1, '244444', 'KidkkL949', 'Emmanuel Obeng', NULL, 'admin@mail.com', 'emmanuel', '$2y$10$9cJ2TrRa9djMO9dbMWKFiutl6jaR6z4xPfUoZFjb2ibWdEfU7IcPK', 1, '2', '1', '0', 'thaisakjfkalfd', '2020-07-15 02:08:14', '2020-07-01 07:02:30', '0438388388', '2020-07-01 07:02:30', NULL, 'assets/img/profiles/avatar.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users_access_levels`
--

CREATE TABLE `users_access_levels` (
  `id` int(11) NOT NULL,
  `access_level_code` int(11) NOT NULL DEFAULT 6,
  `access_level_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'GUEST',
  `access_level_permissions` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_accounts`
--

CREATE TABLE `users_accounts` (
  `id` int(11) NOT NULL,
  `client_guid` varchar(32) DEFAULT NULL,
  `client_abbr` varchar(12) DEFAULT NULL,
  `client_key` varchar(500) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `activated` enum('0','1') DEFAULT '0',
  `subscription` text DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_accounts`
--

INSERT INTO `users_accounts` (`id`, `client_guid`, `client_abbr`, `client_key`, `name`, `email`, `phone`, `address`, `logo`, `date_created`, `activated`, `subscription`, `status`) VALUES
(1, '244444', 'kdm', NULL, 'Kwesi Dickson Memorial Methodist Society', 'testmail@mail.com', '3939393993', 'test address', 'assets/img/meth_logo.jpg', '2020-07-01 21:18:18', '0', '{\"halls_created\":3,\"halls\":10,\"users\":12,\"users_created\":1}', '1');

-- --------------------------------------------------------

--
-- Table structure for table `users_activity_logs`
--

CREATE TABLE `users_activity_logs` (
  `id` int(11) UNSIGNED NOT NULL,
  `client_guid` varchar(32) DEFAULT NULL,
  `user_guid` varchar(32) DEFAULT NULL,
  `page` varchar(64) DEFAULT NULL,
  `item_guid` varchar(64) DEFAULT NULL,
  `date_recorded` datetime NOT NULL DEFAULT current_timestamp(),
  `user_agent` varchar(255) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_activity_logs`
--

INSERT INTO `users_activity_logs` (`id`, `client_guid`, `user_guid`, `page`, `item_guid`, `date_recorded`, `user_agent`, `description`) VALUES
(1, NULL, NULL, 'halls', 'aD1ANQ0MnsxPYC7rfc6TlW5z23LwudoZ', '2020-07-01 21:40:47', 'Windows 10 | Chrome | ::1', 'Created a new hall.'),
(2, NULL, NULL, 'halls', 'kZyXxACRUgbdaVu2tH9qro01EfhY6LSm', '2020-07-01 21:41:07', 'Windows 10 | Chrome | ::1', 'Created a new hall.'),
(3, NULL, NULL, 'halls', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '2020-07-01 21:44:12', 'Windows 10 | Chrome | ::1', 'Created a new hall.'),
(4, NULL, NULL, 'halls', '1OV9ytXor7Qdu4lZc0Cqxhgk5WLTMesB', '2020-07-01 21:45:18', 'Windows 10 | Chrome | ::1', 'Created a new hall.'),
(5, NULL, NULL, 'halls', '1OV9ytXor7Qdu4lZc0Cqxhgk5WLTMesB', '2020-07-02 00:15:08', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(6, NULL, NULL, 'halls', '1OV9ytXor7Qdu4lZc0Cqxhgk5WLTMesB', '2020-07-02 00:15:40', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(7, NULL, NULL, 'halls', '1OV9ytXor7Qdu4lZc0Cqxhgk5WLTMesB', '2020-07-02 00:16:24', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(8, NULL, NULL, 'halls', '1OV9ytXor7Qdu4lZc0Cqxhgk5WLTMesB', '2020-07-02 00:16:33', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(9, NULL, NULL, 'halls', '1OV9ytXor7Qdu4lZc0Cqxhgk5WLTMesB', '2020-07-02 00:18:38', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(10, NULL, NULL, 'halls', '1OV9ytXor7Qdu4lZc0Cqxhgk5WLTMesB', '2020-07-02 00:25:59', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(11, NULL, NULL, 'halls', '1OV9ytXor7Qdu4lZc0Cqxhgk5WLTMesB', '2020-07-02 00:26:21', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(12, NULL, NULL, 'halls', '1OV9ytXor7Qdu4lZc0Cqxhgk5WLTMesB', '2020-07-02 00:26:24', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(13, NULL, NULL, 'halls', '1OV9ytXor7Qdu4lZc0Cqxhgk5WLTMesB', '2020-07-02 00:27:10', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(14, NULL, NULL, 'halls', '1OV9ytXor7Qdu4lZc0Cqxhgk5WLTMesB', '2020-07-02 00:29:17', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(15, NULL, NULL, 'halls', 'kZyXxACRUgbdaVu2tH9qro01EfhY6LSm', '2020-07-02 00:30:36', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(16, NULL, NULL, 'halls', 'kZyXxACRUgbdaVu2tH9qro01EfhY6LSm', '2020-07-02 00:32:05', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(17, NULL, NULL, 'halls', 'kZyXxACRUgbdaVu2tH9qro01EfhY6LSm', '2020-07-02 00:33:40', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(18, NULL, NULL, 'halls', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '2020-07-02 00:35:11', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(19, NULL, NULL, 'halls', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '2020-07-02 00:40:59', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(20, NULL, NULL, 'halls', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '2020-07-02 00:41:03', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(21, NULL, NULL, 'halls', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '2020-07-02 00:41:05', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(22, NULL, NULL, 'halls', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '2020-07-02 00:49:19', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(23, NULL, NULL, 'halls', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '2020-07-02 00:49:38', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(24, NULL, NULL, 'halls', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '2020-07-02 00:49:47', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(25, NULL, NULL, 'halls', '0iHFD5QuyvdaeMsnWZSUYoNTqPCxGw1X', '2020-07-02 00:51:08', 'Windows 10 | Chrome | ::1', 'Created a new hall.'),
(26, NULL, NULL, 'halls', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '2020-07-02 08:17:53', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(27, NULL, NULL, 'halls', 'CENwouk4yhHGXDfdixsgLrTlFtIp9jOq', '2020-07-02 08:18:32', 'Windows 10 | Chrome | ::1', 'Created a new hall.'),
(28, NULL, NULL, 'halls', 'CENwouk4yhHGXDfdixsgLrTlFtIp9jOq', '2020-07-02 08:19:22', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(29, '244444', 'KidkkL949', 'password_reset', 'KidkkL949', '2020-07-02 08:24:57', 'Windows 10 | Chrome | ::1', 'Emmanuel Obeng requested for a password reset code.'),
(30, NULL, NULL, 'halls', 'pQSP594rEGjlzyVOtae6YiTqfuhxvg8I', '2020-07-02 09:07:00', 'Windows 10 | Chrome | ::1', 'Created a new hall.'),
(31, 'KidkkL949', '244444', 'remove', 'pQSP594rEGjlzyVOtae6YiTqfuhxvg8I', '2020-07-02 09:23:50', 'Windows 10 | Chrome | ::1', 'Deleted a hall.'),
(32, 'KidkkL949', '244444', 'remove', 'pQSP594rEGjlzyVOtae6YiTqfuhxvg8I', '2020-07-02 09:25:34', 'Windows 10 | Chrome | ::1', 'Deleted a hall.'),
(33, 'KidkkL949', '244444', 'remove', 'pQSP594rEGjlzyVOtae6YiTqfuhxvg8I', '2020-07-02 09:27:24', 'Windows 10 | Chrome | ::1', 'Deleted a hall.'),
(34, 'KidkkL949', '244444', 'remove', 'CENwouk4yhHGXDfdixsgLrTlFtIp9jOq', '2020-07-02 09:29:18', 'Windows 10 | Chrome | ::1', 'Deleted a hall.'),
(35, NULL, NULL, 'departments', 'JGbv0gaiEU1nMmcsfHBhlrtk54RWT9XV', '2020-07-02 22:52:54', 'Windows 10 | Chrome | ::1', 'Created a new Department.'),
(36, NULL, NULL, 'departments', 'Ujs3IObGKPlEua59nexZ1LXtmqv2B7dy', '2020-07-02 22:59:09', 'Windows 10 | Chrome | ::1', 'Created a new Department.'),
(37, NULL, NULL, 'departments', NULL, '2020-07-02 23:09:06', 'Windows 10 | Chrome | ::1', 'Updated the details of the department.'),
(38, NULL, NULL, 'departments', 'Ujs3IObGKPlEua59nexZ1LXtmqv2B7dy', '2020-07-02 23:09:18', 'Windows 10 | Chrome | ::1', 'Updated the details of the department.'),
(39, NULL, NULL, 'departments', 'Ujs3IObGKPlEua59nexZ1LXtmqv2B7dy', '2020-07-02 23:10:00', 'Windows 10 | Chrome | ::1', 'Updated the details of the department.'),
(40, NULL, NULL, 'departments', 'Ujs3IObGKPlEua59nexZ1LXtmqv2B7dy', '2020-07-02 23:10:08', 'Windows 10 | Chrome | ::1', 'Updated the details of the department.'),
(41, NULL, NULL, 'departments', 'Ujs3IObGKPlEua59nexZ1LXtmqv2B7dy', '2020-07-02 23:10:20', 'Windows 10 | Chrome | ::1', 'Updated the details of the department.'),
(42, NULL, NULL, 'departments', 'sX9Yrq8CQ7gnwaKBThEfmRFM4b3AcJLN', '2020-07-02 23:10:51', 'Windows 10 | Chrome | ::1', 'Created a new Department.'),
(43, 'KidkkL949', '244444', 'remove', 'sX9Yrq8CQ7gnwaKBThEfmRFM4b3AcJLN', '2020-07-02 23:12:18', 'Windows 10 | Chrome | ::1', 'Deleted a department.'),
(44, NULL, NULL, 'tickets', 'Rj5TapqxFQA2NGntPJc1vz8SEZhCBIwH', '2020-07-03 00:09:37', 'Windows 10 | Chrome | ::1', 'Generated 130 tickets for an Event.'),
(45, NULL, NULL, 'tickets', 'lFUASkPm1ZhcnXJ0N8IWVY5uLyOdb97s', '2020-07-03 00:11:34', 'Windows 10 | Chrome | ::1', 'Generated 130 tickets for an Event.'),
(46, NULL, NULL, 'tickets', '4qMcpyKvEuJh35OjzP8aNDdxIRW6kmSi', '2020-07-03 00:27:32', 'Windows 10 | Chrome | ::1', 'Generated 10 tickets for an Event.'),
(47, NULL, NULL, 'tickets', 'JjSLgXe3cBo0R7YxPHus5p2rk8d6ZFOV', '2020-07-03 00:33:54', 'Windows 10 | Chrome | ::1', 'Generated 1000 tickets for an Event.'),
(48, NULL, NULL, 'tickets', '4oWil7hATQP2MzCSv5g3ncpENmf9euka', '2020-07-03 00:38:29', 'Windows 10 | Chrome | ::1', 'Generated 5000 tickets for an Event.'),
(49, NULL, NULL, 'events', 'kojxfBZOSsQ1HKpyA5480Rh7lLVEnizX', '2020-07-03 22:00:37', 'Windows 10 | Chrome | ::1', 'Created a new Event.'),
(50, NULL, NULL, 'events', 'SiItVavogkBM9EOAz862YwQL0jZ3pmHF', '2020-07-03 22:53:09', 'Windows 10 | Chrome | ::1', 'Created a new Event.'),
(51, NULL, NULL, 'halls', '0iHFD5QuyvdaeMsnWZSUYoNTqPCxGw1X', '2020-07-03 23:07:20', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(52, NULL, NULL, 'halls', NULL, '2020-07-03 23:35:01', 'Windows 10 | Chrome | ::1', 'Updated hall details.'),
(53, NULL, NULL, 'halls', NULL, '2020-07-03 23:38:18', 'Windows 10 | Chrome | ::1', 'Updated hall details.'),
(54, NULL, NULL, 'halls', '0iHFD5QuyvdaeMsnWZSUYoNTqPCxGw1X', '2020-07-03 23:38:33', 'Windows 10 | Chrome | ::1', 'Updated hall details.'),
(55, NULL, NULL, 'halls', '0iHFD5QuyvdaeMsnWZSUYoNTqPCxGw1X', '2020-07-03 23:40:31', 'Windows 10 | Chrome | ::1', 'Updated hall details.'),
(56, NULL, NULL, 'halls', '0iHFD5QuyvdaeMsnWZSUYoNTqPCxGw1X', '2020-07-03 23:41:20', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(57, NULL, NULL, 'halls', '0iHFD5QuyvdaeMsnWZSUYoNTqPCxGw1X', '2020-07-03 23:41:36', 'Windows 10 | Chrome | ::1', 'Updated hall details.'),
(58, NULL, NULL, 'halls', '0iHFD5QuyvdaeMsnWZSUYoNTqPCxGw1X', '2020-07-03 23:42:45', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(59, NULL, NULL, 'halls', '0iHFD5QuyvdaeMsnWZSUYoNTqPCxGw1X', '2020-07-03 23:43:16', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(60, 'KidkkL949', '244444', 'remove', '0iHFD5QuyvdaeMsnWZSUYoNTqPCxGw1X', '2020-07-03 23:56:22', 'Windows 10 | Chrome | ::1', 'Deleted a hall.'),
(61, 'KidkkL949', '244444', 'remove', '0iHFD5QuyvdaeMsnWZSUYoNTqPCxGw1X', '2020-07-03 23:57:17', 'Windows 10 | Chrome | ::1', 'Deleted a hall.'),
(62, NULL, NULL, 'halls', 'CENwouk4yhHGXDfdixsgLrTlFtIp9jOq', '2020-07-03 23:59:23', 'Windows 10 | Chrome | ::1', 'Updated hall details.'),
(63, NULL, NULL, 'halls', 'CENwouk4yhHGXDfdixsgLrTlFtIp9jOq', '2020-07-03 23:59:36', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(64, NULL, NULL, 'halls', 'jsN64gp3daOnXiLSyzAEK0VuQ1qDbI5x', '2020-07-04 00:00:13', 'Windows 10 | Chrome | ::1', 'Created a new hall.'),
(65, NULL, NULL, 'halls', 'jsN64gp3daOnXiLSyzAEK0VuQ1qDbI5x', '2020-07-04 00:00:25', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(66, NULL, NULL, 'halls', 'jsN64gp3daOnXiLSyzAEK0VuQ1qDbI5x', '2020-07-04 00:00:29', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(67, NULL, NULL, 'departments', 'Mez6F1RuHKA32ZvLWnNYPJ4qr7waIcCj', '2020-07-04 00:01:40', 'Windows 10 | Chrome | ::1', 'Created a new Department.'),
(68, NULL, NULL, 'departments', 'Mez6F1RuHKA32ZvLWnNYPJ4qr7waIcCj', '2020-07-04 00:01:51', 'Windows 10 | Chrome | ::1', 'Updated the details of the department.'),
(69, NULL, NULL, 'halls', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '2020-07-04 17:18:20', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(70, NULL, NULL, 'halls', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '2020-07-04 17:26:28', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(71, NULL, NULL, 'halls', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '2020-07-04 17:38:01', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(72, NULL, NULL, 'halls', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '2020-07-04 17:38:08', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(73, NULL, NULL, 'halls', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '2020-07-04 17:38:20', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(74, NULL, NULL, 'halls', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '2020-07-04 17:47:07', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(75, NULL, NULL, 'halls', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '2020-07-04 17:48:17', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(76, NULL, NULL, 'halls', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '2020-07-04 17:49:50', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(77, NULL, NULL, 'halls', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '2020-07-04 17:50:00', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(78, NULL, NULL, 'halls', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '2020-07-04 17:50:25', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(79, NULL, NULL, 'halls', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '2020-07-04 17:50:43', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(80, NULL, NULL, 'halls', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '2020-07-04 17:51:44', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(81, NULL, NULL, 'halls', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '2020-07-04 17:51:51', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(82, NULL, NULL, 'events', 'SiItVavogkBM9EOAz862YwQL0jZ3pmHF', '2020-07-04 20:31:56', 'Windows 10 | Chrome | ::1', 'Updated the event details.'),
(83, 'KidkkL949', '244444', 'remove', 'SiItVavogkBM9EOAz862YwQL0jZ3pmHF', '2020-07-04 20:48:05', 'Windows 10 | Chrome | ::1', 'Cancelled an Event that is yet to be held.'),
(84, NULL, NULL, 'halls', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '2020-07-04 21:08:26', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(85, NULL, NULL, 'halls', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '2020-07-04 21:08:31', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(86, NULL, NULL, 'halls', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '2020-07-04 21:08:35', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(87, NULL, NULL, 'events', '2lH3mfpE6IUr1bMzZPNvwK79oatGCcTs', '2020-07-04 22:36:49', 'Windows 10 | Chrome | ::1', 'Created a new Event.'),
(88, NULL, NULL, 'events', 'SsdfafldkjafldafdM9EOAz862YwQL0j', '2020-07-04 22:51:49', 'Windows 10 | Chrome | ::1', 'Updated the event details.'),
(89, NULL, NULL, 'events', '2lH3mfpE6IUddfdNvwK79oatGCc', '2020-07-04 22:54:13', 'Windows 10 | Chrome | ::1', 'Updated the event details.'),
(90, NULL, NULL, 'halls', 'jsN64gp3daOnXiLSyzAEK0VuQ1qDbI5x', '2020-07-05 11:11:29', 'Windows 10 | Chrome | ::1', 'Updated hall details.'),
(91, NULL, NULL, 'halls', 'jsN64gp3daOnXiLSyzAEK0VuQ1qDbI5x', '2020-07-05 11:11:54', 'Windows 10 | Chrome | ::1', 'Updated hall details.'),
(92, NULL, NULL, 'halls', 'jsN64gp3daOnXiLSyzAEK0VuQ1qDbI5x', '2020-07-05 11:14:47', 'Windows 10 | Chrome | ::1', 'Updated hall details.'),
(93, NULL, NULL, 'halls', 'jsN64gp3daOnXiLSyzAEK0VuQ1qDbI5x', '2020-07-05 11:16:55', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(94, NULL, NULL, 'halls', 'jsN64gp3daOnXiLSyzAEK0VuQ1qDbI5x', '2020-07-05 11:17:25', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(95, NULL, NULL, 'halls', 'jsN64gp3daOnXiLSyzAEK0VuQ1qDbI5x', '2020-07-05 11:19:02', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(96, NULL, NULL, 'halls', 'jsN64gp3daOnXiLSyzAEK0VuQ1qDbI5x', '2020-07-05 11:19:44', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(97, NULL, NULL, 'tickets', 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', '2020-07-05 17:06:32', 'Windows 10 | Chrome | ::1', 'Generated 100 tickets for an Event.'),
(98, NULL, NULL, 'tickets', 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', '2020-07-05 17:06:57', 'Windows 10 | Chrome | ::1', 'Generated 300 tickets for an Event.'),
(99, NULL, NULL, 'events', 'SiItVavogkBM9EOAz862YwQL0jZ3pmHF', '2020-07-05 17:07:09', 'Windows 10 | Chrome | ::1', 'Updated the event details.'),
(100, NULL, NULL, 'events', 'SsdfafldkjafldafdM9EOAz862YwQL0j', '2020-07-05 17:07:28', 'Windows 10 | Chrome | ::1', 'Updated the event details.'),
(101, NULL, NULL, 'events', '2lH3mfpE6IUddfdNvwK79oatGCc', '2020-07-05 17:45:20', 'Windows 10 | Chrome | ::1', 'Updated the event details.'),
(102, NULL, NULL, 'halls', 'CENwouk4yhHGXDfdixsgLrTlFtIp9jOq', '2020-07-05 17:59:08', 'Windows 10 | Chrome | ::1', 'Updated hall details.'),
(103, NULL, NULL, 'events', 'TKOzIsL1nP25Xk3pHcJChfYBrmGoE0gR', '2020-07-07 19:31:47', 'Windows 10 | Chrome | ::1', 'Created a new Event.'),
(104, NULL, NULL, 'halls', 'jsN64gp3daOnXiLSyzAEK0VuQ1qDbI5x', '2020-07-07 19:32:38', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(105, NULL, NULL, 'halls', 'jsN64gp3daOnXiLSyzAEK0VuQ1qDbI5x', '2020-07-07 19:32:54', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(106, NULL, NULL, 'halls', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '2020-07-07 19:57:12', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(107, NULL, NULL, 'halls', 'jsN64gp3daOnXiLSyzAEK0VuQ1qDbI5x', '2020-07-07 19:57:58', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(108, NULL, NULL, 'halls', 'jsN64gp3daOnXiLSyzAEK0VuQ1qDbI5x', '2020-07-07 22:43:14', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.');

-- --------------------------------------------------------

--
-- Table structure for table `users_data_monitoring`
--

CREATE TABLE `users_data_monitoring` (
  `id` int(11) NOT NULL,
  `client_guid` int(11) DEFAULT 1,
  `data_type` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `item_guid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data_set` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_guid` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_log` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_email_list`
--

CREATE TABLE `users_email_list` (
  `id` int(11) NOT NULL,
  `client_guid` varchar(32) DEFAULT 'NULL',
  `template_type` enum('general','invoice','sign_up','login','recovery','request','receipt') DEFAULT NULL,
  `item_guid` varchar(32) DEFAULT NULL,
  `recipients_list` text DEFAULT NULL,
  `date_requested` datetime DEFAULT current_timestamp(),
  `sent_status` enum('0','1') DEFAULT '0',
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `request_performed_by` varchar(255) DEFAULT NULL,
  `deleted` enum('0','1') DEFAULT '0',
  `date_sent` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_email_list`
--

INSERT INTO `users_email_list` (`id`, `client_guid`, `template_type`, `item_guid`, `recipients_list`, `date_requested`, `sent_status`, `subject`, `message`, `request_performed_by`, `deleted`, `date_sent`) VALUES
(1, '244444', 'recovery', 'KidkkL949', '{\"recipients_list\":[{\"fullname\":\"Emmanuel Obeng\",\"email\":\"admin@mail.com\",\"customer_id\":\"KidkkL949\"}]}', '2020-07-02 08:24:57', '0', '[BookingLog] Change Password', 'Hi Emmanuel Obeng<br>You have requested to reset your password at BookingLog<br><br>Before you can reset your password please follow this link.<br><br><a class=\"alert alert-success\" href=\"http://localhost/booking/verify?password&token=q7FMh7moPzkLBiYud18cfdi6UF5RktJNTASgZUALDwHMqvOQpjBCwuhN8a6ExEXG5W1t\">Click Here to Reset Password</a><br><br>If it does not work please copy this link and place it in your browser url.<br><br>http://localhost/booking/verify?password&token=q7FMh7moPzkLBiYud18cfdi6UF5RktJNTASgZUALDwHMqvOQpjBCwuhN8a6ExEXG5W1t', 'KidkkL949', '0', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_login_history`
--

CREATE TABLE `users_login_history` (
  `id` int(11) NOT NULL,
  `client_guid` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_guid` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastlogin` datetime DEFAULT current_timestamp(),
  `log_ipaddress` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `log_browser` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `log_platform` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_login_history`
--

INSERT INTO `users_login_history` (`id`, `client_guid`, `user_guid`, `username`, `lastlogin`, `log_ipaddress`, `log_browser`, `log_platform`) VALUES
(1, '244444', '', 'admin@mail.com', '2020-07-02 07:58:33', '::1', 'Chrome|Windows 10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.11'),
(2, '244444', '', 'admin@mail.com', '2020-07-02 07:59:11', '::1', 'Chrome|Windows 10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.11'),
(3, '244444', '', 'admin@mail.com', '2020-07-02 08:15:31', '::1', 'Chrome|Windows 10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.11'),
(4, '244444', '', 'admin@mail.com', '2020-07-02 08:16:12', '::1', 'Chrome|Windows 10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.11'),
(5, '244444', '', 'admin@mail.com', '2020-07-02 08:16:27', '::1', 'Chrome|Windows 10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.11'),
(6, '244444', '', 'admin@mail.com', '2020-07-02 08:16:37', '::1', 'Chrome|Windows 10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.11'),
(7, '244444', '', 'admin@mail.com', '2020-07-02 08:44:09', '::1', 'Chrome|Windows 10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.11'),
(8, '244444', 'KidkkL949', 'admin@mail.com', '2020-07-02 22:20:01', '::1', 'Chrome|Windows 10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.11'),
(9, '244444', 'KidkkL949', 'admin@mail.com', '2020-07-03 09:49:00', '::1', 'Chrome|Windows 10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.11'),
(10, '244444', 'KidkkL949', 'admin@mail.com', '2020-07-03 20:44:31', '::1', 'Chrome|Windows 10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.11'),
(11, '244444', 'KidkkL949', 'admin@mail.com', '2020-07-03 20:44:32', '::1', 'Chrome|Windows 10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.11'),
(12, '244444', 'KidkkL949', 'admin@mail.com', '2020-07-04 14:07:29', '::1', 'Chrome|Windows 10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.11'),
(13, '244444', 'KidkkL949', 'admin@mail.com', '2020-07-04 16:38:06', '::1', 'Chrome|Windows 10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.11'),
(14, '244444', 'KidkkL949', 'admin@mail.com', '2020-07-04 20:23:32', '::1', 'Chrome|Windows 10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.11'),
(15, '244444', 'KidkkL949', 'admin@mail.com', '2020-07-04 21:08:18', '::1', 'Chrome|Windows 10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.11'),
(16, '244444', 'KidkkL949', 'admin@mail.com', '2020-07-04 22:34:52', '::1', 'Chrome|Windows 10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.11'),
(17, '244444', 'KidkkL949', 'admin@mail.com', '2020-07-05 11:09:23', '::1', 'Chrome|Windows 10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.11'),
(18, '244444', 'KidkkL949', 'admin@mail.com', '2020-07-05 11:09:23', '::1', 'Chrome|Windows 10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.11'),
(19, '244444', 'KidkkL949', 'admin@mail.com', '2020-07-05 16:23:50', '::1', 'Chrome|Windows 10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.11'),
(20, '244444', 'KidkkL949', 'admin@mail.com', '2020-07-06 20:09:52', '::1', 'Chrome|Windows 10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.11'),
(21, '244444', 'KidkkL949', 'admin@mail.com', '2020-07-07 13:55:44', '::1', 'Chrome|Windows 10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.11'),
(22, '244444', 'KidkkL949', 'admin@mail.com', '2020-07-07 19:20:54', '::1', 'Chrome|Windows 10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.11'),
(23, '244444', 'KidkkL949', 'admin@mail.com', '2020-07-07 22:39:49', '::1', 'Chrome|Windows 10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.11'),
(24, '244444', 'KidkkL949', 'admin@mail.com', '2020-07-08 22:06:04', '::1', 'Chrome|Windows 10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.11'),
(25, '244444', 'KidkkL949', 'admin@mail.com', '2020-07-11 12:43:09', '::1', 'Chrome|Windows 10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.11'),
(26, '244444', 'KidkkL949', 'admin@mail.com', '2020-07-15 02:08:14', '::1', 'Chrome|Windows 10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.11');

-- --------------------------------------------------------

--
-- Table structure for table `users_reset_request`
--

CREATE TABLE `users_reset_request` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_guid` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_agent` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `token_status` enum('USED','EXPIRED','PENDING','ANNULED') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'PENDING',
  `request_token` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reset_date` datetime DEFAULT NULL,
  `reset_agent` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `expiry_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users_reset_request`
--

INSERT INTO `users_reset_request` (`id`, `username`, `user_guid`, `user_agent`, `token_status`, `request_token`, `reset_date`, `reset_agent`, `expiry_time`) VALUES
(1, 'emmanuel', 'KidkkL949', 'Chrome Windows 10|::1', 'PENDING', 'q7FMh7moPzkLBiYud18cfdi6UF5RktJNTASgZUALDwHMqvOQpjBCwuhN8a6ExEXG5W1t', NULL, NULL, 1593678297);

-- --------------------------------------------------------

--
-- Table structure for table `users_roles`
--

CREATE TABLE `users_roles` (
  `id` int(11) NOT NULL,
  `client_guid` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_guid` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `permissions` varchar(5000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_logged` datetime NOT NULL DEFAULT current_timestamp(),
  `last_updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_roles`
--

INSERT INTO `users_roles` (`id`, `client_guid`, `user_guid`, `permissions`, `date_logged`, `last_updated`) VALUES
(1, '244444', 'KidkkL949', '{\"permissions\":{\"halls\":{\"list\":\"1\",\"add\":\"1\",\"configure\":1,\"update\":\"1\",\"delete\":\"1\"},\"events\":{\"list\":1,\"add\":1,\"update\":1,\"delete\":1},\"departments\":{\"list\":1,\"add\":1,\"update\":1,\"delete\":1},\"tickets\":{\"list\":1,\"generate\":1,\"delete\":1,\"sell\":1}}}', '2020-07-02 09:03:11', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alerts`
--
ALTER TABLE `alerts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `event_guid` (`event_guid`);

--
-- Indexes for table `events_booking`
--
ALTER TABLE `events_booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events_halls_configuration`
--
ALTER TABLE `events_halls_configuration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `halls`
--
ALTER TABLE `halls`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hall_guid` (`hall_guid`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ticket_guid` (`ticket_guid`);

--
-- Indexes for table `tickets_listing`
--
ALTER TABLE `tickets_listing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_guid` (`user_guid`);

--
-- Indexes for table `users_access_levels`
--
ALTER TABLE `users_access_levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_accounts`
--
ALTER TABLE `users_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_activity_logs`
--
ALTER TABLE `users_activity_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_data_monitoring`
--
ALTER TABLE `users_data_monitoring`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_email_list`
--
ALTER TABLE `users_email_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_login_history`
--
ALTER TABLE `users_login_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_reset_request`
--
ALTER TABLE `users_reset_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_roles`
--
ALTER TABLE `users_roles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alerts`
--
ALTER TABLE `alerts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=250;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `events_booking`
--
ALTER TABLE `events_booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `events_halls_configuration`
--
ALTER TABLE `events_halls_configuration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `halls`
--
ALTER TABLE `halls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tickets_listing`
--
ALTER TABLE `tickets_listing`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=401;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users_access_levels`
--
ALTER TABLE `users_access_levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_accounts`
--
ALTER TABLE `users_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users_activity_logs`
--
ALTER TABLE `users_activity_logs`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `users_data_monitoring`
--
ALTER TABLE `users_data_monitoring`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_email_list`
--
ALTER TABLE `users_email_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users_login_history`
--
ALTER TABLE `users_login_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users_reset_request`
--
ALTER TABLE `users_reset_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users_roles`
--
ALTER TABLE `users_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
