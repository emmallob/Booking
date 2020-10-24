-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2020 at 03:39 PM
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
-- Table structure for table `cron_scheduler`
--

CREATE TABLE `cron_scheduler` (
  `id` int(11) NOT NULL,
  `query` text DEFAULT NULL,
  `item_id` varchar(255) DEFAULT NULL,
  `user_id` varchar(32) DEFAULT NULL,
  `notice_code` varchar(12) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `cron_type` varchar(32) DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0',
  `active_date` datetime DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_processed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cron_scheduler`
--

INSERT INTO `cron_scheduler` (`id`, `query`, `item_id`, `user_id`, `notice_code`, `subject`, `cron_type`, `status`, `active_date`, `date_created`, `date_processed`) VALUES
(1, '[{\"user_id\":\"KidkkL949\",\"email\":\"admin@mail.com\",\"fullname\":\"Demo User\"}]', 'aDAOWRcY3eid0hCnBmVtIL17jXMvkQSs', 'KidkkL949', '5', 'Email Message', 'email', '0', '2020-10-24 13:58:46', '2020-10-24 13:58:46', NULL),
(2, '[{\"user_id\":\"KidkkL949\",\"email\":\"admin@mail.com\",\"fullname\":\"Demo User\"}]', 'vjnXVo2CSKT6twpJurNcs7RPUAHQaZL1', 'KidkkL949', '5', 'Email Message', 'email', '0', '2020-10-24 14:00:50', '2020-10-24 14:00:50', NULL),
(3, '[{\"user_id\":\"KidkkL949\",\"email\":\"admin@mail.com\",\"fullname\":\"Demo User\"}]', 'W7J4U1SPb3jzBFwH5IhsMg62qaAnZQpX', 'KidkkL949', '5', 'Email Message', 'email', '0', '2020-10-24 14:01:11', '2020-10-24 14:01:11', NULL),
(4, '[{\"user_id\":\"KidkkL949\",\"email\":\"admin@mail.com\",\"fullname\":\"Demo User\"}]', 'OhxJGp4gnab3H6FSslC0dc2ViKkz95rY', 'KidkkL949', '5', 'Email Message', 'email', '0', '2020-10-24 14:01:34', '2020-10-24 14:01:34', NULL),
(5, '[{\"user_id\":\"KidkkL949\",\"email\":\"admin@mail.com\",\"fullname\":\"Demo User\"}]', 'b8vXtNCqHQBGfkrg5chULVO93unjZx2S', 'KidkkL949', '5', 'Email Message', 'email', '0', '2020-10-24 14:01:48', '2020-10-24 14:01:48', NULL);

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
(4, '244444', 'Mez6F1RuHKA32ZvLWnNYPJ4qr7waIcCj', 'New Department Addition - Edited', '&lt;p&gt;Test new department adding.This department is doing grat here.&lt;/p&gt;&lt;p&gt;Thank you&lt;/p&gt;', '#d20f0f', '1'),
(5, '244444', 'RJsS5elNOU7b3pZA1rx2Lg4mhvdHaikG', 'Test department', '', '#000000', '0'),
(6, '244444', 'cnaCYi9eQEj3S2BHUrZGXtRbduN1ATDm', 'another test department', '', '#000000', '0');

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
  `maximum_multiple_booking` int(10) UNSIGNED NOT NULL DEFAULT 1,
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

INSERT INTO `events` (`id`, `client_guid`, `event_guid`, `event_title`, `event_slug`, `halls_guid`, `event_date`, `start_time`, `end_time`, `booking_start_time`, `booking_end_time`, `is_payable`, `department_guid`, `allow_multiple_booking`, `maximum_multiple_booking`, `description`, `ticket_guid`, `state`, `created_on`, `created_by`, `deleted`) VALUES
(1, '244444', '13E6a02YfzwdlJqrLDIA74HvbnZ5GkuF', '1st Service', '1st-service', 'chFJwLaZkCQItRe8Aq1gYbSo4MvETrXl,PjRoBO6bEIynqurS30iwAZh5Fx4LXkCT,3YOdhCXlnv1GrTLuEKBHjUc546a2VZWy', '2020-10-25', '08:00', '09:00', '2020-10-23 08:30:00', '2020-10-24 22:00:00', '0', 'null', '1', 3, '2nd Annual thanksgiving and fundraising service to aim members hit by COVID-19 Pandemic', 'null', 'in-progress', '2020-10-23 08:28:09', 'KidkkL949', '0'),
(2, '244444', 'eudHjSn2zIqhD9TYg3OXM5pFCbJVl7Pv', '2nd Service', '2nd-service', 'chFJwLaZkCQItRe8Aq1gYbSo4MvETrXl,PjRoBO6bEIynqurS30iwAZh5Fx4LXkCT,3YOdhCXlnv1GrTLuEKBHjUc546a2VZWy', '2020-10-25', '10:00', '11:15', '2020-10-23 08:30:00', '2020-10-24 22:00:00', '1', 'null', '1', 3, '2nd Annual thanksgiving and fundraising service to aim members hit by COVID-19 Pandemic', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'in-progress', '2020-10-23 08:29:03', 'KidkkL949', '0');

-- --------------------------------------------------------

--
-- Table structure for table `events_booking`
--

CREATE TABLE `events_booking` (
  `id` int(11) NOT NULL,
  `client_guid` varchar(32) DEFAULT NULL,
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

INSERT INTO `events_booking` (`id`, `client_guid`, `event_guid`, `hall_guid`, `seat_guid`, `seat_name`, `ticket_guid`, `ticket_serial`, `booked_by`, `fullname`, `created_by`, `address`, `status`, `deleted`, `created_on`, `user_agent`) VALUES
(1, '244444', '13E6a02YfzwdlJqrLDIA74HvbnZ5GkuF', '3YOdhCXlnv1GrTLuEKBHjUc546a2VZWy', '7_11', 'R77', NULL, NULL, '0203317732', 'Emmanuel Obeng', '0203317732', 'H/No 59, Dodowa - Accra', '1', '0', '2020-10-23 08:43:20', 'Windows 10|Chrome'),
(2, '244444', '13E6a02YfzwdlJqrLDIA74HvbnZ5GkuF', '3YOdhCXlnv1GrTLuEKBHjUc546a2VZWy', '6_1', 'R56', NULL, NULL, '0203317732', 'Henry Asmah', '0203317732', 'Adjiringanor, Accra', '0', '0', '2020-10-23 08:45:00', 'Windows 10|Chrome'),
(3, '244444', '13E6a02YfzwdlJqrLDIA74HvbnZ5GkuF', '3YOdhCXlnv1GrTLuEKBHjUc546a2VZWy', '7_9', 'M75', NULL, NULL, '0203317732', 'Kofi Norgbey Sithole', '0203317732', 'Zoom Lion, School Junction', '0', '0', '2020-10-23 08:49:57', 'Windows 10|Chrome'),
(4, '244444', '13E6a02YfzwdlJqrLDIA74HvbnZ5GkuF', '3YOdhCXlnv1GrTLuEKBHjUc546a2VZWy', '4_3', 'M36', NULL, NULL, '0550107770', 'Fred Solomon', '0248908930', 'Accra-Ghana', '0', '0', '2020-10-23 08:53:17', 'Android|Chrome'),
(5, '244444', '13E6a02YfzwdlJqrLDIA74HvbnZ5GkuF', '3YOdhCXlnv1GrTLuEKBHjUc546a2VZWy', '4_8', 'M41', NULL, NULL, '0550107770', 'Amoah Stephen', '0456092909', 'Accra', '1', '0', '2020-10-23 08:54:14', 'Android|Chrome'),
(6, '244444', '13E6a02YfzwdlJqrLDIA74HvbnZ5GkuF', '3YOdhCXlnv1GrTLuEKBHjUc546a2VZWy', '3_11', 'M33', NULL, NULL, '0550107770', 'Appiah Amenu Asiedu', '0290989093', 'Accra - Steward', '0', '0', '2020-10-23 08:54:43', 'Android|Chrome'),
(7, '244444', '13E6a02YfzwdlJqrLDIA74HvbnZ5GkuF', '3YOdhCXlnv1GrTLuEKBHjUc546a2VZWy', '6_7', 'M62', NULL, NULL, '0247685521', 'Emmanuella Darko', '0247685521', 'Agbelezaa, Manet - Teshie Road', '0', '0', '2020-10-23 09:01:57', 'Windows 10|Chrome'),
(8, '244444', '13E6a02YfzwdlJqrLDIA74HvbnZ5GkuF', '3YOdhCXlnv1GrTLuEKBHjUc546a2VZWy', '7_4', 'M70', NULL, NULL, '0247685521', 'Evangelist Collins Sakyiama', '0234098598', 'Agbelezaa, Manet - Teshie Road', '0', '0', '2020-10-23 09:01:57', 'Windows 10|Chrome'),
(9, '244444', '13E6a02YfzwdlJqrLDIA74HvbnZ5GkuF', '3YOdhCXlnv1GrTLuEKBHjUc546a2VZWy', '7_5', 'M71', NULL, NULL, '0247685521', 'Sandra Sakyiama', '0234506909', 'Agbelezaa, Manet - Teshie Road', '0', '0', '2020-10-23 09:01:57', 'Windows 10|Chrome'),
(10, '244444', 'eudHjSn2zIqhD9TYg3OXM5pFCbJVl7Pv', '3YOdhCXlnv1GrTLuEKBHjUc546a2VZWy', '5_9', 'M53', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DA2P6NGF', '0234098598', 'The name', '0234098598', 'THERE', '0', '0', '2020-10-24 13:04:35', 'Windows 10|Chrome'),
(11, '244444', '13E6a02YfzwdlJqrLDIA74HvbnZ5GkuF', '3YOdhCXlnv1GrTLuEKBHjUc546a2VZWy', '2_6', 'M17', NULL, NULL, '0240989894', 'The test', '0240989894', 'the test address', '1', '0', '2020-10-24 13:06:36', 'Windows 10|Chrome'),
(12, '244444', '13E6a02YfzwdlJqrLDIA74HvbnZ5GkuF', '3YOdhCXlnv1GrTLuEKBHjUc546a2VZWy', '6_11', 'M66', NULL, NULL, '0240989894', 'Another Seat', '0240989894', 'Test another seat', '1', '0', '2020-10-24 13:06:48', 'Windows 10|Chrome'),
(13, '244444', '13E6a02YfzwdlJqrLDIA74HvbnZ5GkuF', 'chFJwLaZkCQItRe8Aq1gYbSo4MvETrXl', '4_7', 'ST98', NULL, NULL, '0203989094', 'Roger Ocansey', '090939890', 'Steward Finance', '0', '0', '2020-10-24 13:17:46', 'Windows 10|Chrome'),
(14, '244444', '13E6a02YfzwdlJqrLDIA74HvbnZ5GkuF', 'chFJwLaZkCQItRe8Aq1gYbSo4MvETrXl', '6_7', 'ST99', NULL, NULL, '0203989094', 'Nana Kow Dadson', '0920938940', 'Steward Finance, Assistant', '0', '0', '2020-10-24 13:17:46', 'Windows 10|Chrome'),
(15, '244444', '13E6a02YfzwdlJqrLDIA74HvbnZ5GkuF', 'chFJwLaZkCQItRe8Aq1gYbSo4MvETrXl', '7_7', 'ST100', NULL, NULL, '0203989094', 'Emily Addo Boateng', '092093093', 'Steward Administration', '0', '0', '2020-10-24 13:17:46', 'Windows 10|Chrome');

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
(1, '13E6a02YfzwdlJqrLDIA74HvbnZ5GkuF', 'chFJwLaZkCQItRe8Aq1gYbSo4MvETrXl', 'Choir &amp; Stewards', '9', '7', '{\"blocked\":[\"4_7\",\"6_7\",\"7_7\"],\"removed\":[\"1_1\",\"1_2\",\"1_3\",\"1_4\",\"1_5\",\"1_6\",\"1_7\",\"2_1\",\"2_2\",\"2_3\",\"2_4\",\"2_5\",\"2_6\",\"2_7\",\"3_1\",\"3_2\",\"3_3\",\"3_4\",\"3_5\",\"3_6\",\"3_7\",\"4_1\",\"4_2\",\"4_3\",\"4_4\",\"4_5\",\"4_6\",\"5_1\",\"5_2\",\"5_3\",\"5_4\",\"5_5\",\"5_6\",\"5_7\",\"6_1\",\"6_2\",\"6_3\",\"6_4\",\"6_5\",\"6_6\",\"7_1\",\"9_1\",\"8_7\",\"9_7\",\"7_2\",\"7_6\"],\"labels\":{\"7_3\":\"CR95\",\"7_4\":\"CR96\",\"7_5\":\"CR97\",\"8_1\":\"CR84\",\"8_2\":\"CR90\",\"8_3\":\"CR91\",\"8_4\":\"CR92\",\"8_5\":\"CR93\",\"8_6\":\"CR94\",\"9_2\":\"CR85\",\"9_3\":\"CR86\",\"9_4\":\"CR87\",\"9_5\":\"CR88\",\"9_6\":\"CR89\"}}', '1'),
(2, '13E6a02YfzwdlJqrLDIA74HvbnZ5GkuF', 'PjRoBO6bEIynqurS30iwAZh5Fx4LXkCT', 'Chansel', '1', '8', '{\"blocked\":[],\"removed\":[\"1_3\",\"1_4\",\"1_5\",\"1_6\"],\"labels\":{\"1_1\":\"CH80\",\"1_2\":\"CH81\",\"1_7\":\"CH82\",\"1_8\":\"CH83\"}}', '0'),
(3, '13E6a02YfzwdlJqrLDIA74HvbnZ5GkuF', '3YOdhCXlnv1GrTLuEKBHjUc546a2VZWy', 'Main Hall', '9', '11', '{\"blocked\":[\"1_1\",\"8_1\",\"8_11\",\"9_1\",\"9_2\",\"9_3\",\"9_9\",\"9_10\",\"9_11\",\"7_11\",\"6_1\",\"7_9\",\"4_3\",\"4_8\",\"3_11\",\"6_7\",\"7_4\",\"7_5\",\"2_6\",\"6_11\"],\"removed\":[\"1_1\",\"8_2\",\"8_3\",\"8_4\",\"8_5\",\"8_6\",\"8_7\",\"8_8\",\"8_9\",\"8_10\",\"9_1\",\"9_2\",\"9_3\",\"9_9\",\"9_10\",\"9_11\",\"9_5\",\"9_6\",\"9_7\"],\"labels\":{\"1_2\":\"M2\",\"1_3\":\"M3\",\"1_4\":\"M4\",\"1_5\":\"M5\",\"1_6\":\"M6\",\"1_7\":\"M7\",\"1_8\":\"M8\",\"1_9\":\"M9\",\"1_10\":\"M10\",\"1_11\":\"U11\",\"2_1\":\"U12\",\"2_2\":\"M13\",\"2_3\":\"M14\",\"2_4\":\"M15\",\"2_5\":\"M16\",\"2_7\":\"M18\",\"2_8\":\"M19\",\"2_9\":\"M20\",\"2_10\":\"M21\",\"2_11\":\"M22\",\"3_1\":\"M23\",\"3_2\":\"M24\",\"3_3\":\"M25\",\"3_4\":\"M26\",\"3_5\":\"M27\",\"3_6\":\"M28\",\"3_7\":\"M29\",\"3_8\":\"M30\",\"3_9\":\"M31\",\"3_10\":\"M32\",\"4_1\":\"R34\",\"4_2\":\"M35\",\"4_4\":\"M37\",\"4_5\":\"M38\",\"4_6\":\"M39\",\"4_7\":\"M40\",\"4_9\":\"M42\",\"4_10\":\"M43\",\"4_11\":\"M44\",\"5_1\":\"R45\",\"5_2\":\"M46\",\"5_3\":\"M47\",\"5_4\":\"M48\",\"5_5\":\"M49\",\"5_6\":\"M50\",\"5_7\":\"M51\",\"5_8\":\"M52\",\"5_9\":\"M53\",\"5_10\":\"M54\",\"5_11\":\"M55\",\"6_2\":\"M57\",\"6_3\":\"M58\",\"6_4\":\"M59\",\"6_5\":\"M60\",\"6_6\":\"M61\",\"6_8\":\"M63\",\"6_9\":\"M64\",\"6_10\":\"M65\",\"7_1\":\"R67\",\"7_2\":\"M68\",\"7_3\":\"M69\",\"7_6\":\"M72\",\"7_7\":\"M73\",\"7_8\":\"M74\",\"7_10\":\"M76\",\"8_1\":\"EMP\",\"8_11\":\"EMP\",\"9_4\":\"M78\",\"9_8\":\"M79\"}}', '1'),
(4, 'eudHjSn2zIqhD9TYg3OXM5pFCbJVl7Pv', 'chFJwLaZkCQItRe8Aq1gYbSo4MvETrXl', 'Choir &amp; Stewards', '9', '7', '{\"blocked\":[],\"removed\":[\"1_1\",\"1_2\",\"1_3\",\"1_4\",\"1_5\",\"1_6\",\"1_7\",\"2_1\",\"2_2\",\"2_3\",\"2_4\",\"2_5\",\"2_6\",\"2_7\",\"3_1\",\"3_2\",\"3_3\",\"3_4\",\"3_5\",\"3_6\",\"3_7\",\"4_1\",\"4_2\",\"4_3\",\"4_4\",\"4_5\",\"4_6\",\"5_1\",\"5_2\",\"5_3\",\"5_4\",\"5_5\",\"5_6\",\"5_7\",\"6_1\",\"6_2\",\"6_3\",\"6_4\",\"6_5\",\"6_6\",\"7_1\",\"9_1\",\"8_7\",\"9_7\",\"7_2\",\"7_6\"],\"labels\":{\"4_7\":\"ST98\",\"6_7\":\"ST99\",\"7_3\":\"CR95\",\"7_4\":\"CR96\",\"7_5\":\"CR97\",\"7_7\":\"ST100\",\"8_1\":\"CR84\",\"8_2\":\"CR90\",\"8_3\":\"CR91\",\"8_4\":\"CR92\",\"8_5\":\"CR93\",\"8_6\":\"CR94\",\"9_2\":\"CR85\",\"9_3\":\"CR86\",\"9_4\":\"CR87\",\"9_5\":\"CR88\",\"9_6\":\"CR89\"}}', '0'),
(5, 'eudHjSn2zIqhD9TYg3OXM5pFCbJVl7Pv', 'PjRoBO6bEIynqurS30iwAZh5Fx4LXkCT', 'Chansel', '1', '8', '{\"blocked\":[],\"removed\":[\"1_3\",\"1_4\",\"1_5\",\"1_6\"],\"labels\":{\"1_1\":\"CH80\",\"1_2\":\"CH81\",\"1_7\":\"CH82\",\"1_8\":\"CH83\"}}', '0'),
(6, 'eudHjSn2zIqhD9TYg3OXM5pFCbJVl7Pv', '3YOdhCXlnv1GrTLuEKBHjUc546a2VZWy', 'Main Hall', '9', '11', '{\"blocked\":[\"1_1\",\"8_1\",\"8_11\",\"9_1\",\"9_2\",\"9_3\",\"9_9\",\"9_10\",\"9_11\",\"5_9\"],\"removed\":[\"1_1\",\"8_2\",\"8_3\",\"8_4\",\"8_5\",\"8_6\",\"8_7\",\"8_8\",\"8_9\",\"8_10\",\"9_1\",\"9_2\",\"9_3\",\"9_9\",\"9_10\",\"9_11\",\"9_5\",\"9_6\",\"9_7\"],\"labels\":{\"1_2\":\"M2\",\"1_3\":\"M3\",\"1_4\":\"M4\",\"1_5\":\"M5\",\"1_6\":\"M6\",\"1_7\":\"M7\",\"1_8\":\"M8\",\"1_9\":\"M9\",\"1_10\":\"M10\",\"1_11\":\"U11\",\"2_1\":\"U12\",\"2_2\":\"M13\",\"2_3\":\"M14\",\"2_4\":\"M15\",\"2_5\":\"M16\",\"2_6\":\"M17\",\"2_7\":\"M18\",\"2_8\":\"M19\",\"2_9\":\"M20\",\"2_10\":\"M21\",\"2_11\":\"M22\",\"3_1\":\"M23\",\"3_2\":\"M24\",\"3_3\":\"M25\",\"3_4\":\"M26\",\"3_5\":\"M27\",\"3_6\":\"M28\",\"3_7\":\"M29\",\"3_8\":\"M30\",\"3_9\":\"M31\",\"3_10\":\"M32\",\"3_11\":\"M33\",\"4_1\":\"R34\",\"4_2\":\"M35\",\"4_3\":\"M36\",\"4_4\":\"M37\",\"4_5\":\"M38\",\"4_6\":\"M39\",\"4_7\":\"M40\",\"4_8\":\"M41\",\"4_9\":\"M42\",\"4_10\":\"M43\",\"4_11\":\"M44\",\"5_1\":\"R45\",\"5_2\":\"M46\",\"5_3\":\"M47\",\"5_4\":\"M48\",\"5_5\":\"M49\",\"5_6\":\"M50\",\"5_7\":\"M51\",\"5_8\":\"M52\",\"5_10\":\"M54\",\"5_11\":\"M55\",\"6_1\":\"R56\",\"6_2\":\"M57\",\"6_3\":\"M58\",\"6_4\":\"M59\",\"6_5\":\"M60\",\"6_6\":\"M61\",\"6_7\":\"M62\",\"6_8\":\"M63\",\"6_9\":\"M64\",\"6_10\":\"M65\",\"6_11\":\"M66\",\"7_1\":\"R67\",\"7_2\":\"M68\",\"7_3\":\"M69\",\"7_4\":\"M70\",\"7_5\":\"M71\",\"7_6\":\"M72\",\"7_7\":\"M73\",\"7_8\":\"M74\",\"7_9\":\"M75\",\"7_10\":\"M76\",\"7_11\":\"R77\",\"8_1\":\"EMP\",\"8_11\":\"EMP\",\"9_4\":\"M78\",\"9_8\":\"M79\"}}', '1');

-- --------------------------------------------------------

--
-- Table structure for table `events_media`
--

CREATE TABLE `events_media` (
  `id` int(11) NOT NULL,
  `client_guid` varchar(32) DEFAULT NULL,
  `event_guid` varchar(32) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `media_data` varchar(255) DEFAULT NULL,
  `media_type` varchar(32) DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `files_attachment`
--

CREATE TABLE `files_attachment` (
  `id` int(12) UNSIGNED NOT NULL,
  `resource` varchar(32) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `attachment_size` varchar(16) DEFAULT NULL,
  `record_id` varchar(80) DEFAULT NULL,
  `resource_id` varchar(64) DEFAULT NULL,
  `created_by` varchar(32) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `files_attachment`
--

INSERT INTO `files_attachment` (`id`, `resource`, `description`, `attachment_size`, `record_id`, `resource_id`, `created_by`, `date_created`) VALUES
(1, 'messaging_emails', '{\"files\":[{\"unique_id\":\"A97LDstvepZlHKi4bN5CwWngzThFkfjOacM1d8Q6oRmI0uEYxJVBSry\",\"name\":\"2020-10-11_060244.csv\",\"path\":\"assets\\/uploads\\/\\/docs\\/emails\\/2020-10-11_060244.csv\",\"type\":\"csv\",\"size\":\"2.98KB\",\"size_raw\":\"0\",\"is_deleted\":0,\"record_id\":\"aDAOWRcY3eid0hCnBmVtIL17jXMvkQSs\",\"datetime\":\"Saturday, 24th October 2020 at 12:58:46PM\",\"favicon\":\"fa fa-file-csv fa-1x\",\"color\":\"success\",\"uploaded_by\":null,\"uploaded_by_id\":\"KidkkL949\"}],\"files_count\":1,\"raw_size_mb\":0,\"files_size\":\"0MB\"}', '0', 'aDAOWRcY3eid0hCnBmVtIL17jXMvkQSs', 'aDAOWRcY3eid0hCnBmVtIL17jXMvkQSs', 'KidkkL949', '2020-10-24 13:58:46');

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
(1, '244444', '3YOdhCXlnv1GrTLuEKBHjUc546a2VZWy', '9', '11', 80, 'Main Hall', 'KidkkL949', '{\"blocked\":[\"1_1\",\"8_1\",\"8_11\",\"9_1\",\"9_2\",\"9_3\",\"9_9\",\"9_10\",\"9_11\"],\"removed\":[\"1_1\",\"8_2\",\"8_3\",\"8_4\",\"8_5\",\"8_6\",\"8_7\",\"8_8\",\"8_9\",\"8_10\",\"9_1\",\"9_2\",\"9_3\",\"9_9\",\"9_10\",\"9_11\",\"9_5\",\"9_6\",\"9_7\"],\"labels\":{\"1_2\":\"M2\",\"1_3\":\"M3\",\"1_4\":\"M4\",\"1_5\":\"M5\",\"1_6\":\"M6\",\"1_7\":\"M7\",\"1_8\":\"M8\",\"1_9\":\"M9\",\"1_10\":\"M10\",\"1_11\":\"U11\",\"2_1\":\"U12\",\"2_2\":\"M13\",\"2_3\":\"M14\",\"2_4\":\"M15\",\"2_5\":\"M16\",\"2_6\":\"M17\",\"2_7\":\"M18\",\"2_8\":\"M19\",\"2_9\":\"M20\",\"2_10\":\"M21\",\"2_11\":\"M22\",\"3_1\":\"M23\",\"3_2\":\"M24\",\"3_3\":\"M25\",\"3_4\":\"M26\",\"3_5\":\"M27\",\"3_6\":\"M28\",\"3_7\":\"M29\",\"3_8\":\"M30\",\"3_9\":\"M31\",\"3_10\":\"M32\",\"3_11\":\"M33\",\"4_1\":\"R34\",\"4_2\":\"M35\",\"4_3\":\"M36\",\"4_4\":\"M37\",\"4_5\":\"M38\",\"4_6\":\"M39\",\"4_7\":\"M40\",\"4_8\":\"M41\",\"4_9\":\"M42\",\"4_10\":\"M43\",\"4_11\":\"M44\",\"5_1\":\"R45\",\"5_2\":\"M46\",\"5_3\":\"M47\",\"5_4\":\"M48\",\"5_5\":\"M49\",\"5_6\":\"M50\",\"5_7\":\"M51\",\"5_8\":\"M52\",\"5_9\":\"M53\",\"5_10\":\"M54\",\"5_11\":\"M55\",\"6_1\":\"R56\",\"6_2\":\"M57\",\"6_3\":\"M58\",\"6_4\":\"M59\",\"6_5\":\"M60\",\"6_6\":\"M61\",\"6_7\":\"M62\",\"6_8\":\"M63\",\"6_9\":\"M64\",\"6_10\":\"M65\",\"6_11\":\"M66\",\"7_1\":\"R67\",\"7_2\":\"M68\",\"7_3\":\"M69\",\"7_4\":\"M70\",\"7_5\":\"M71\",\"7_6\":\"M72\",\"7_7\":\"M73\",\"7_8\":\"M74\",\"7_9\":\"M75\",\"7_10\":\"M76\",\"7_11\":\"R77\",\"8_1\":\"EMP\",\"8_11\":\"EMP\",\"9_4\":\"M78\",\"9_8\":\"M79\"}}', '', 12, '2020-10-23 02:54:18', '1', '0'),
(2, '244444', 'PjRoBO6bEIynqurS30iwAZh5Fx4LXkCT', '1', '8', 4, 'Chansel', 'KidkkL949', '{\"blocked\":[],\"removed\":[\"1_3\",\"1_4\",\"1_5\",\"1_6\"],\"labels\":{\"1_1\":\"CH80\",\"1_2\":\"CH81\",\"1_7\":\"CH82\",\"1_8\":\"CH83\"}}', '', 0, '2020-10-23 02:59:24', '1', '0'),
(3, '244444', 'chFJwLaZkCQItRe8Aq1gYbSo4MvETrXl', '9', '7', 17, 'Choir &amp; Stewards', 'KidkkL949', '{\"blocked\":[],\"removed\":[\"1_1\",\"1_2\",\"1_3\",\"1_4\",\"1_5\",\"1_6\",\"1_7\",\"2_1\",\"2_2\",\"2_3\",\"2_4\",\"2_5\",\"2_6\",\"2_7\",\"3_1\",\"3_2\",\"3_3\",\"3_4\",\"3_5\",\"3_6\",\"3_7\",\"4_1\",\"4_2\",\"4_3\",\"4_4\",\"4_5\",\"4_6\",\"5_1\",\"5_2\",\"5_3\",\"5_4\",\"5_5\",\"5_6\",\"5_7\",\"6_1\",\"6_2\",\"6_3\",\"6_4\",\"6_5\",\"6_6\",\"7_1\",\"9_1\",\"8_7\",\"9_7\",\"7_2\",\"7_6\"],\"labels\":{\"4_7\":\"ST98\",\"6_7\":\"ST99\",\"7_3\":\"CR95\",\"7_4\":\"CR96\",\"7_5\":\"CR97\",\"7_7\":\"ST100\",\"8_1\":\"CR84\",\"8_2\":\"CR90\",\"8_3\":\"CR91\",\"8_4\":\"CR92\",\"8_5\":\"CR93\",\"8_6\":\"CR94\",\"9_2\":\"CR85\",\"9_3\":\"CR86\",\"9_4\":\"CR87\",\"9_5\":\"CR88\",\"9_6\":\"CR89\"}}', '', 3, '2020-10-23 03:01:34', '1', '0'),
(4, '244444', 'Sv26Gg1DOksWcUt0LnKBob5FwMAu9xfE', '3', '3', 9, 'test', 'KidkkL949', '{\"blocked\":[],\"removed\":[],\"labels\":{\"1_1\":1,\"1_2\":2,\"1_3\":3,\"2_1\":4,\"2_2\":5,\"2_3\":6,\"3_1\":7,\"3_2\":8,\"3_3\":9}}', '', 0, '2020-10-24 11:08:15', '1', '0'),
(5, '244444', 'bkWAhK74Nyv6Bi5wOTUYDQaztSP2GF9m', '5', '3', 12, 'tested hall', 'KidkkL949', '{\"blocked\":[],\"removed\":[\"2_1\",\"3_2\",\"5_2\"],\"labels\":{\"1_1\":\"1\",\"1_2\":\"2\",\"1_3\":\"3\",\"2_2\":\"5\",\"2_3\":\"6\",\"3_1\":\"7\",\"3_3\":\"9\",\"4_1\":\"10\",\"4_2\":\"11\",\"4_3\":\"12\",\"5_1\":\"13\",\"5_3\":\"15\"}}', '', 0, '2020-10-24 11:08:51', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `client_guid` varchar(32) DEFAULT NULL,
  `unique_guid` varchar(32) DEFAULT NULL,
  `related_item` varchar(32) DEFAULT NULL,
  `related_guid` varchar(32) DEFAULT NULL,
  `message_type` enum('sms','email') DEFAULT NULL,
  `recipient_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `recipient_list` text NOT NULL DEFAULT current_timestamp(),
  `recipient_status` varchar(1000) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` varchar(3000) DEFAULT NULL,
  `sms_units` int(10) UNSIGNED DEFAULT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(32) DEFAULT NULL,
  `current_status` enum('pending','sent','failed','cancelled') NOT NULL DEFAULT 'pending',
  `deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sms_purchases`
--

CREATE TABLE `sms_purchases` (
  `id` int(11) NOT NULL,
  `client_guid` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `request_unique_id` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sms_capacity` int(11) NOT NULL DEFAULT 0,
  `package_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `user_guid` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `previous_balance` int(11) DEFAULT 0,
  `current_balance` int(11) NOT NULL DEFAULT 0,
  `request_date` datetime NOT NULL DEFAULT current_timestamp(),
  `request_status` enum('Pending','Processed','Cancelled') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Pending',
  `cancelled_date` datetime DEFAULT NULL,
  `status` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `processed_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sms_purchases`
--

INSERT INTO `sms_purchases` (`id`, `client_guid`, `request_unique_id`, `transaction_id`, `sms_capacity`, `package_price`, `user_guid`, `previous_balance`, `current_balance`, `request_date`, `request_status`, `cancelled_date`, `status`, `processed_date`) VALUES
(1, '244444', '6AEqnBKUk1bs37IPY9jxTJQtRZMcLXmilf8zyOpWehvFN0HVgDGouwS', '100000000001', 1000, '200.00', 'KidkkL949', 0, 0, '2020-10-24 11:11:20', 'Pending', NULL, '0', NULL),
(2, '244444', 'i6fIzPZ3K7qHgVQYnNDxjoGmCkE82e9MOW45wtX1LJuScaAB0pTsU', '100000000002', 500, '100.00', 'KidkkL949', 0, 0, '2020-10-24 11:11:46', 'Pending', NULL, '0', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sms_subscribers`
--

CREATE TABLE `sms_subscribers` (
  `id` int(11) NOT NULL,
  `client_guid` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `sms_package` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `sms_units` int(11) NOT NULL DEFAULT 0,
  `sender_id` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'EvelynCRM'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sms_subscribers`
--

INSERT INTO `sms_subscribers` (`id`, `client_guid`, `sms_package`, `sms_units`, `sender_id`) VALUES
(1, '244444', 'Minimum', 1000, 'EvelynCRM');

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
(1, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'The event for the ticket', 200, 1, 198, '1', 200.00, '2020-10-24 10:05:43', 'KidkkL949', 'yes', '1', '1'),
(2, '244444', 'wlGOe6YVH9IRNjpkfDvUy8EFiKcnxhLP', 'gafdad', 12, 0, 12, '0', 0.00, '2020-10-24 10:12:27', 'KidkkL949', 'yes', '1', '1'),
(3, '244444', 'iBnsTfYLj7opq8XckIQVUxyRdAMv5u9N', 'afadafdaf', 22, 0, 22, '0', 0.00, '2020-10-24 10:13:17', 'KidkkL949', 'yes', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tickets_listing`
--

CREATE TABLE `tickets_listing` (
  `id` int(11) UNSIGNED NOT NULL,
  `client_guid` varchar(32) DEFAULT NULL,
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

INSERT INTO `tickets_listing` (`id`, `client_guid`, `ticket_guid`, `ticket_serial`, `ticket_amount`, `sold_state`, `sold_by`, `bought_by`, `used_date`, `event_booked`, `status`, `created_by`, `created_on`) VALUES
(1, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DA6BPCWJ', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(2, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DA6MHIUG', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(3, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DATGNJ92', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(4, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAGOZ132', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(5, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAT7P0UH', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(6, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAZOCD9Y', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(7, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAACBSXQ', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(8, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAPFQSVK', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(9, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAANMZON', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(10, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DA2KBV73', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(11, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAT6I8DY', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(12, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAJWCPZ6', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(13, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DALEXDS7', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(14, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAHY0SF1', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(15, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DA18WMPZ', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(16, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAG3KQDE', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(17, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAC7BZSH', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(18, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAQIVALK', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(19, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DA8KXGTO', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(20, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DA2P6NGF', 200.00, '1', 'KidkkL949', 'Emmanuel Obeng - 0550107770', '2020-10-24 13:04:35', 'eudHjSn2zIqhD9TYg3OXM5pFCbJVl7Pv', 'used', NULL, '2020-10-24 10:05:43'),
(21, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAXB74N6', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(22, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAUV3KCP', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(23, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAC9A2LO', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(24, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAFT1OVH', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(25, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAVSXMFA', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(26, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAR3EFVE', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(27, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAHJEAZB', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(28, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAY4FBXX', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(29, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAOTFIEW', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(30, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DARFQRZ8', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(31, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DACYV6I0', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(32, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DALPIXNU', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(33, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAQ42VX6', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(34, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DANM5HMF', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(35, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAS58YZB', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(36, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DACTGYPB', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(37, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAAKSKVZ', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(38, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DA0OJNSX', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(39, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DABKMX2A', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(40, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAJNLSY7', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(41, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAYIMCNR', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(42, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAHSWQVT', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(43, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAYXOV8V', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(44, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAIUM7DY', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(45, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAWKIHOG', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(46, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAQTIMTU', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(47, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DARPK8BQ', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(48, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAWFU7CC', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(49, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAF4M6EK', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(50, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DABWN8BA', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(51, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DATVDSA9', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(52, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAC6A3VE', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(53, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAGORJWO', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(54, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DACAI8VJ', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(55, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DANHR2EL', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(56, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAJKSGDN', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(57, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAVRXQ84', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(58, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAKPA3ZU', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(59, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DARF6R3I', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(60, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAB3FKSG', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(61, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAFHKX4T', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(62, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DANAEKBJ', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(63, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAAKP4KJ', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(64, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAPCD8D0', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(65, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAZF71YP', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(66, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAI2DNL1', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(67, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DA8FKEYL', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(68, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAXEM98F', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(69, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAYPPUQM', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(70, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DATBFRPZ', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(71, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAZUESD5', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(72, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DA5MHXUO', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(73, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DACGIFQB', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(74, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAYKMA82', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(75, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAUPG5ZS', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(76, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAUSYPNB', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(77, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAQSK3GO', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(78, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DATC4LQO', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(79, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAHW4DID', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(80, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAKPJRMF', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(81, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DA0C2GFF', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(82, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAZKIAPY', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(83, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAXWMRG1', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(84, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAEIEUCZ', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(85, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAUTZLKJ', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(86, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DADVAUI0', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(87, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAOAN7OL', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(88, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAETPNPN', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(89, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DACOFQTL', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(90, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAVY316U', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(91, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAG4HAOE', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(92, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAGVIEHK', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(93, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DA5DRPFB', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(94, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAMXO9UB', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(95, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAGAQ1CJ', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(96, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAIHWTKW', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(97, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DARZJISG', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(98, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DASWTF2M', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(99, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DARNPTWD', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(100, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAXLVJQ2', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(101, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DANKXD0S', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(102, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAJVDMBA', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(103, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DA0O7QZF', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(104, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAZQPMY7', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(105, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAK620KJ', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(106, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DASWVFY2', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(107, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DANBM3DJ', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(108, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DADEVYON', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(109, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAF1VZSN', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(110, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAKPLASO', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(111, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAGALL3S', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(112, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAPZHDYA', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(113, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAGFLDNS', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(114, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAGRMPHK', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(115, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DALG4PSR', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(116, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DA9W2LS8', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(117, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAWWS1EL', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(118, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAFNNWZQ', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(119, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DA37UF9T', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(120, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAHZ1GFB', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(121, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAQ5EXPS', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(122, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DA3FPBGI', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(123, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAHYJS4V', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(124, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DA6VE9CO', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(125, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAQ3JUKK', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(126, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAPR271S', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(127, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DA3QTGIN', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(128, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAWCKELI', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(129, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAHOEXDR', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(130, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAIGTYFV', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(131, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAEUAEHT', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(132, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAFIZCL3', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(133, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAMGZZSU', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(134, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DATBXWVZ', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(135, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAOJIMDV', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(136, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DABH97FR', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(137, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAUJF0OA', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(138, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DA9WYRVR', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(139, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DANVEM6R', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(140, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAZKBSAC', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(141, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAGA1ERU', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(142, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DA8QMXVN', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(143, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DANBDTHF', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(144, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DALXCOMY', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(145, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAFKOPY6', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(146, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAJD2EKZ', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(147, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DA79OJQC', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(148, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAZPO5FD', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(149, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAZ53EGA', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(150, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DA1RUGZH', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(151, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAL3GBWB', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(152, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAZ1YUWQ', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(153, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAJCMKKF', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(154, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAA4MI9W', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(155, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAKNLIGR', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(156, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DASYNIDV', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(157, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAO5JZSR', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(158, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAC4KOT1', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(159, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAKHPG2Q', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(160, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAWNLZNT', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(161, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DA1CM53H', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(162, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAGNOEK4', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(163, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DALUYRQE', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(164, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAHRIMU7', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(165, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAGSZ9LH', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(166, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAURI5E8', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(167, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DACO5OGY', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(168, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAYH6ZFW', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(169, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAHKK3WS', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(170, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DADG6XNH', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(171, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DANFLZRA', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(172, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DADUJBGH', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(173, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAVLMGUB', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(174, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAA7CTBE', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(175, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAX51OIB', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(176, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DA2EQLKI', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(177, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAERUTIJ', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(178, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DA3G9Z0O', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(179, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DALZ17SV', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(180, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAOTZ5SM', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(181, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAWGDRHZ', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(182, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DATENVFR', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(183, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAQIAPKH', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(184, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DARCEIUH', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(185, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAMN71TF', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(186, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAKPDJB3', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(187, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAC7ZUIF', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(188, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DADFQKU2', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(189, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DARBA5XY', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(190, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DA8GI1VX', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(191, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAY1W8GD', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(192, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAX4UW7D', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(193, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DATYILI6', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(194, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAMDJHOZ', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(195, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAMP3O9O', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(196, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAMKW4PN', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(197, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DA0JHP7N', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(198, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAXMK2FU', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(199, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAJ6OTMD', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(200, '244444', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', 'DAV2U3UN', 200.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:05:43'),
(201, '244444', 'wlGOe6YVH9IRNjpkfDvUy8EFiKcnxhLP', 'AOMZ5OL', 0.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:12:27'),
(202, '244444', 'wlGOe6YVH9IRNjpkfDvUy8EFiKcnxhLP', 'AQMW6GG', 0.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:12:27'),
(203, '244444', 'wlGOe6YVH9IRNjpkfDvUy8EFiKcnxhLP', 'APZBMFG', 0.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:12:27'),
(204, '244444', 'wlGOe6YVH9IRNjpkfDvUy8EFiKcnxhLP', 'ACJRNNA', 0.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:12:27'),
(205, '244444', 'wlGOe6YVH9IRNjpkfDvUy8EFiKcnxhLP', 'AUOVZNS', 0.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:12:27'),
(206, '244444', 'wlGOe6YVH9IRNjpkfDvUy8EFiKcnxhLP', 'ATLY9JO', 0.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:12:27'),
(207, '244444', 'wlGOe6YVH9IRNjpkfDvUy8EFiKcnxhLP', 'ANYAV72', 0.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:12:27'),
(208, '244444', 'wlGOe6YVH9IRNjpkfDvUy8EFiKcnxhLP', 'AH8CXTW', 0.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:12:27'),
(209, '244444', 'wlGOe6YVH9IRNjpkfDvUy8EFiKcnxhLP', 'AROBUEY', 0.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:12:27'),
(210, '244444', 'wlGOe6YVH9IRNjpkfDvUy8EFiKcnxhLP', 'AEEVSCW', 0.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:12:27'),
(211, '244444', 'wlGOe6YVH9IRNjpkfDvUy8EFiKcnxhLP', 'AOUKY0S', 0.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:12:27'),
(212, '244444', 'wlGOe6YVH9IRNjpkfDvUy8EFiKcnxhLP', 'AGKXW6A', 0.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:12:27'),
(213, '244444', 'iBnsTfYLj7opq8XckIQVUxyRdAMv5u9N', 'DFSQ4SIN', 0.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:13:17'),
(214, '244444', 'iBnsTfYLj7opq8XckIQVUxyRdAMv5u9N', 'DFU0GIUY', 0.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:13:17'),
(215, '244444', 'iBnsTfYLj7opq8XckIQVUxyRdAMv5u9N', 'DFQSHWE9', 0.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:13:17'),
(216, '244444', 'iBnsTfYLj7opq8XckIQVUxyRdAMv5u9N', 'DFYWG2GK', 0.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:13:17'),
(217, '244444', 'iBnsTfYLj7opq8XckIQVUxyRdAMv5u9N', 'DF8S5SJV', 0.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:13:17'),
(218, '244444', 'iBnsTfYLj7opq8XckIQVUxyRdAMv5u9N', 'DFKJIINL', 0.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:13:17'),
(219, '244444', 'iBnsTfYLj7opq8XckIQVUxyRdAMv5u9N', 'DFRUYYBP', 0.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:13:17'),
(220, '244444', 'iBnsTfYLj7opq8XckIQVUxyRdAMv5u9N', 'DFIQDRIZ', 0.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:13:17'),
(221, '244444', 'iBnsTfYLj7opq8XckIQVUxyRdAMv5u9N', 'DF9FOMWH', 0.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:13:17'),
(222, '244444', 'iBnsTfYLj7opq8XckIQVUxyRdAMv5u9N', 'DFGT41YJ', 0.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:13:17'),
(223, '244444', 'iBnsTfYLj7opq8XckIQVUxyRdAMv5u9N', 'DFERC45V', 0.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:13:17'),
(224, '244444', 'iBnsTfYLj7opq8XckIQVUxyRdAMv5u9N', 'DFH3H4GZ', 0.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:13:17'),
(225, '244444', 'iBnsTfYLj7opq8XckIQVUxyRdAMv5u9N', 'DFFNMHUZ', 0.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:13:17'),
(226, '244444', 'iBnsTfYLj7opq8XckIQVUxyRdAMv5u9N', 'DF9UVTGK', 0.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:13:17'),
(227, '244444', 'iBnsTfYLj7opq8XckIQVUxyRdAMv5u9N', 'DFYS7R85', 0.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:13:17'),
(228, '244444', 'iBnsTfYLj7opq8XckIQVUxyRdAMv5u9N', 'DF5PVYUK', 0.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:13:17'),
(229, '244444', 'iBnsTfYLj7opq8XckIQVUxyRdAMv5u9N', 'DFJQE3NG', 0.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:13:17'),
(230, '244444', 'iBnsTfYLj7opq8XckIQVUxyRdAMv5u9N', 'DF27HEFB', 0.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:13:17'),
(231, '244444', 'iBnsTfYLj7opq8XckIQVUxyRdAMv5u9N', 'DFE1FYCT', 0.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:13:17'),
(232, '244444', 'iBnsTfYLj7opq8XckIQVUxyRdAMv5u9N', 'DFGV9EYF', 0.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:13:17'),
(233, '244444', 'iBnsTfYLj7opq8XckIQVUxyRdAMv5u9N', 'DF3DYUAV', 0.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:13:17'),
(234, '244444', 'iBnsTfYLj7opq8XckIQVUxyRdAMv5u9N', 'DFF8TDTO', 0.00, '0', NULL, NULL, NULL, NULL, 'pending', NULL, '2020-10-24 10:13:17');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_purchases`
--

CREATE TABLE `ticket_purchases` (
  `id` int(11) NOT NULL,
  `ticket_id` varchar(32) DEFAULT NULL,
  `event_id` varchar(32) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `contact` varchar(64) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ticket_purchases`
--

INSERT INTO `ticket_purchases` (`id`, `ticket_id`, `event_id`, `fullname`, `contact`, `email`, `date_created`) VALUES
(1, '20', '2', 'Emmanuel Obeng', '0550107770', 'emmallob14@gmail.com', '2020-10-24 10:20:27');

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
  `access_level` int(11) UNSIGNED NOT NULL DEFAULT 1,
  `theme` enum('1','2') CHARACTER SET latin1 NOT NULL DEFAULT '2',
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `online` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `last_seen` datetime DEFAULT current_timestamp(),
  `deleted` enum('0','1') CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `organization` varchar(4000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dashboard_settings` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT '{"navbar":"","theme":"light-theme"}',
  `verify_token` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `last_login` datetime DEFAULT current_timestamp(),
  `last_login_attempts_time` datetime DEFAULT current_timestamp(),
  `contact` varchar(15) CHARACTER SET latin1 DEFAULT NULL,
  `created_on` datetime DEFAULT current_timestamp(),
  `created_by` varchar(11) CHARACTER SET latin1 DEFAULT NULL,
  `image` varchar(255) CHARACTER SET latin1 DEFAULT 'assets/img/avatar.png',
  `user_type` enum('user','holder') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'holder'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `client_guid`, `user_guid`, `name`, `gender`, `email`, `username`, `password`, `access_level`, `theme`, `status`, `online`, `last_seen`, `deleted`, `organization`, `dashboard_settings`, `verify_token`, `last_login`, `last_login_attempts_time`, `contact`, `created_on`, `created_by`, `image`, `user_type`) VALUES
(1, '244444', 'KidkkL949', 'Demo User', 'Male', 'admin@mail.com', 'adminuser', '$2y$10$CsTd71XkkvbkgMwyZgyZ3.TtJ4LKj1yCQNkvswgbinVvD8JaJyJ/y', 1, '2', '1', '1', '2020-10-24 14:39:16', '0', NULL, '{\"navbar\":\"visible\",\"theme\":\"light-theme\"}', NULL, '2020-10-24 11:04:30', '2020-07-16 22:13:54', '44444444444', '2020-07-16 22:13:54', NULL, 'assets/img/profiles/nj7PqWXzRAcQH8mVKOurb1TYF.png', 'holder'),
(4, '244444', 'BK273956291861', 'test vendor', NULL, 'testvendor@mail.com', 'testvendor', '$2y$10$4WwO8P8TBo8y33jceh8rc.8FimNvy49towNKlDk.FMC2AzkGlWr5.', 3, '2', '1', '1', '2020-10-24 14:37:27', '0', NULL, '{\"navbar\":\"visible\",\"theme\":\"dark-theme\"}', NULL, '2020-10-24 14:36:16', '2020-10-24 10:52:48', '0550107770', '2020-10-24 10:52:48', NULL, 'assets/img/avatar.png', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `users_access_attempt`
--

CREATE TABLE `users_access_attempt` (
  `id` int(11) NOT NULL,
  `ipaddress` varchar(50) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `username_found` enum('0','1') DEFAULT '0',
  `attempt_type` enum('login','reset') DEFAULT 'login',
  `attempts` int(11) DEFAULT 0,
  `lastattempt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

--
-- Dumping data for table `users_access_levels`
--

INSERT INTO `users_access_levels` (`id`, `access_level_code`, `access_level_name`, `access_level_permissions`) VALUES
(1, 1, 'Admin', '{\"permissions\":{\"halls\":{\"list\":\"1\",\"add\":\"1\",\"configure\":1,\"update\":\"1\",\"delete\":\"1\"},\"events\":{\"list\":1,\"add\":1,\"update\":1,\"delete\":1,\"insight\":1},\"departments\":{\"list\":1,\"add\":1,\"update\":1,\"delete\":1},\"tickets\":{\"list\":1,\"generate\":1,\"delete\":1,\"sell\":1,\"return\":1,\"reports\":1},\"users\":{\"manage\":1,\"delete\":1,\"accesslevel\":1},\"account\":{\"manage\":1,\"subscription\":1},\"communications\":{\"manage\":1}}}'),
(2, 2, 'Moderator', '{\"permissions\":{\"halls\":{\"list\":\"1\",\"add\":\"1\",\"configure\":1,\"update\":\"1\",\"delete\":\"1\"},\"events\":{\"list\":1,\"add\":1,\"update\":1,\"delete\":1,\"insight\":1},\"departments\":{\"list\":1,\"add\":1,\"update\":1,\"delete\":1},\"tickets\":{\"list\":1,\"generate\":1,\"delete\":1,\"sell\":1,\"reports\":1}}}'),
(3, 3, 'Voucher Vendor', '{\"permissions\":{\"halls\":{\"list\":\"1\"},\"events\":{\"list\":1},\"departments\":{\"list\":1},\"tickets\":{\"list\":1,\"sell\":1,\"return\":1,\"reports\":1}}}');

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
  `client_email_host` varchar(255) DEFAULT NULL,
  `client_email_password` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `country` int(11) DEFAULT NULL,
  `account_logo` varchar(255) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `activated` enum('0','1') DEFAULT '0',
  `subscription` text DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_accounts`
--

INSERT INTO `users_accounts` (`id`, `client_guid`, `client_abbr`, `client_key`, `name`, `email`, `client_email_host`, `client_email_password`, `phone`, `address`, `city`, `country`, `account_logo`, `date_created`, `activated`, `subscription`, `status`) VALUES
(1, '244444', 'kdm', NULL, 'Kwesi Dickson Memorial Methodist Society - Adjiringanor', 'testmailer@mail.com', 'mail.supremecluster.com', 'tRandom29', '0550107770', 'test address', 'Accra City', 13, 'assets/img/meth_logo.jpg', '2020-07-01 21:18:18', '0', '{\"halls_created\":1,\"halls\":10,\"users\":12,\"users_created\":8,\"account_type\":\"basic\",\"expiry_date\":\"2021-01-01\"}', '1');

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
(1, '244444', 'KidkkL949', 'account', '244444', '2020-10-23 08:22:38', 'Windows 10 | Chrome | ::1', 'Updated the Account details.'),
(2, '244444', 'KidkkL949', 'events', '13E6a02YfzwdlJqrLDIA74HvbnZ5GkuF', '2020-10-23 08:28:09', 'Windows 10 | Chrome | ::1', 'Created a new Event.'),
(3, '244444', 'KidkkL949', 'events', 'eudHjSn2zIqhD9TYg3OXM5pFCbJVl7Pv', '2020-10-23 08:29:03', 'Windows 10 | Chrome | ::1', 'Created a new Event.'),
(4, '244444', 'KidkkL949', 'events', '13E6a02YfzwdlJqrLDIA74HvbnZ5GkuF', '2020-10-23 08:32:43', 'Windows 10 | Chrome | ::1', 'Updated the event details.'),
(5, '244444', 'KidkkL949', 'events', 'eudHjSn2zIqhD9TYg3OXM5pFCbJVl7Pv', '2020-10-23 08:35:17', 'Windows 10 | Chrome | ::1', 'Updated the event details.'),
(6, NULL, NULL, 'halls', 'chFJwLaZkCQItRe8Aq1gYbSo4MvETrXl', '2020-10-24 10:01:30', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(7, NULL, NULL, 'halls', 'chFJwLaZkCQItRe8Aq1gYbSo4MvETrXl', '2020-10-24 10:02:38', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(8, '244444', 'KidkkL949', 'halls', 'chFJwLaZkCQItRe8Aq1gYbSo4MvETrXl', '2020-10-24 10:02:51', 'Windows 10 | Chrome | ::1', 'Updated the hall details.'),
(9, '244444', 'KidkkL949', 'events', '13E6a02YfzwdlJqrLDIA74HvbnZ5GkuF', '2020-10-24 10:03:08', 'Windows 10 | Chrome | ::1', 'Updated the event details.'),
(10, '244444', 'KidkkL949', 'tickets', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', '2020-10-24 10:05:43', 'Windows 10 | Chrome | ::1', 'Generated 200 tickets for an Event.'),
(11, '244444', 'KidkkL949', 'tickets', 'pFcumvGkV32fgQxIzSWDdrnehUBKoqJP', '2020-10-24 10:10:21', 'Windows 10 | Chrome | ::1', 'Activated the ticket.'),
(12, '244444', 'KidkkL949', 'tickets', 'wlGOe6YVH9IRNjpkfDvUy8EFiKcnxhLP', '2020-10-24 10:12:27', 'Windows 10 | Chrome | ::1', 'Generated 12 tickets for an Event.'),
(13, '244444', 'KidkkL949', 'tickets', 'wlGOe6YVH9IRNjpkfDvUy8EFiKcnxhLP', '2020-10-24 10:13:04', 'Windows 10 | Chrome | ::1', 'Activated the ticket.'),
(14, '244444', 'KidkkL949', 'tickets', 'iBnsTfYLj7opq8XckIQVUxyRdAMv5u9N', '2020-10-24 10:13:17', 'Windows 10 | Chrome | ::1', 'Generated 22 tickets for an Event.'),
(15, '244444', 'KidkkL949', 'tickets', 'iBnsTfYLj7opq8XckIQVUxyRdAMv5u9N', '2020-10-24 10:15:55', 'Windows 10 | Chrome | ::1', 'Activated the ticket.'),
(16, '244444', 'KidkkL949', 'events', 'eudHjSn2zIqhD9TYg3OXM5pFCbJVl7Pv', '2020-10-24 10:18:51', 'Windows 10 | Chrome | ::1', 'Updated the event details.'),
(17, '244444', 'KidkkL949', 'ticket', 'DA2P6NGF', '2020-10-24 10:20:27', 'Windows 10 | Chrome | ::1', 'Event: 2nd Service Ticket was sold out to Emmanuel Obeng'),
(18, '244444', 'KidkkL949', 'departments', 'Ujs3IObGKPlEua59nexZ1LXtmqv2B7dy', '2020-10-24 10:24:57', 'Windows 10 | Chrome | ::1', 'Updated the details of the department.'),
(19, '244444', 'KidkkL949', 'departments', 'RJsS5elNOU7b3pZA1rx2Lg4mhvdHaikG', '2020-10-24 10:25:07', 'Windows 10 | Chrome | ::1', 'Created a new Department.'),
(20, '244444', 'KidkkL949', 'departments', 'cnaCYi9eQEj3S2BHUrZGXtRbduN1ATDm', '2020-10-24 10:25:15', 'Windows 10 | Chrome | ::1', 'Created a new Department.'),
(21, '244444', 'KidkkL949', 'users', 'KidkkL949', '2020-10-24 10:38:59', 'Windows 10 | Chrome | ::1', 'You have updated your account information.'),
(22, '244444', 'KidkkL949', 'users', 'KidkkL949', '2020-10-24 10:42:10', 'Windows 10 | Chrome | ::1', 'You have updated your account information.'),
(23, '244444', 'KidkkL949', 'users', 'KidkkL949', '2020-10-24 10:45:47', 'Windows 10 | Chrome | ::1', 'You have updated your account information.'),
(24, '244444', 'KidkkL949', 'account', '244444', '2020-10-24 10:48:39', 'Windows 10 | Chrome | ::1', 'Updated the Account details.'),
(25, '244444', 'KidkkL949', 'account', '244444', '2020-10-24 10:48:57', 'Windows 10 | Chrome | ::1', 'Updated the Account details.'),
(26, '244444', 'KidkkL949', 'account', '244444', '2020-10-24 10:50:15', 'Windows 10 | Chrome | ::1', 'Updated the Account details.'),
(27, '244444', NULL, 'profile', 'BK273956291861', '2020-10-24 10:52:48', 'Windows 10 | Chrome | ::1', 'Added a new the Profile Account of test vendor.'),
(28, '244444', 'KidkkL949', 'profile', 'BK936539567228', '2020-10-24 10:53:49', 'Windows 10 | Chrome | ::1', 'Added a new the Profile Account of Test Vendor 2.'),
(29, '244444', 'KidkkL949', 'profile', 'BK579375641863', '2020-10-24 10:55:14', 'Windows 10 | Chrome | ::1', 'Added a new the Profile Account of test moderator.'),
(30, '244444', 'KidkkL949', 'profile', 'BK436562217974', '2020-10-24 10:56:40', 'Windows 10 | Chrome | ::1', 'Added a new the Profile Account of test.'),
(31, '244444', 'KidkkL949', 'profile', 'BK657289344795', '2020-10-24 10:57:04', 'Windows 10 | Chrome | ::1', 'Added a new the Profile Account of ates.'),
(32, '244444', 'KidkkL949', 'profile', 'BK796447125126', '2020-10-24 10:58:31', 'Windows 10 | Chrome | ::1', 'Added a new the Profile Account of afdafda.'),
(33, '244444', 'KidkkL949', 'profile', 'BK846198631459', '2020-10-24 10:58:58', 'Windows 10 | Chrome | ::1', 'Added a new the Profile Account of afafaijlkakjlk.'),
(34, '244444', 'BK273956291861', 'account-verify', 'BK273956291861', '2020-10-24 11:00:12', 'Windows 10 | Chrome | ::1', 'Verified the Email Address attached to this Account.'),
(35, '244444', 'BK273956291861', 'account-verify', 'BK273956291861', '2020-10-24 11:01:14', 'Windows 10 | Chrome | ::1', 'Verified the Email Address attached to this Account.'),
(36, '244444', 'KidkkL949', 'password_reset', 'KidkkL949', '2020-10-24 11:02:57', 'Windows 10 | Chrome | ::1', 'Demo User requested for a password reset code.'),
(37, NULL, NULL, 'halls', 'Sv26Gg1DOksWcUt0LnKBob5FwMAu9xfE', '2020-10-24 11:08:15', 'Windows 10 | Chrome | ::1', 'Created a new hall.'),
(38, NULL, NULL, 'halls', 'bkWAhK74Nyv6Bi5wOTUYDQaztSP2GF9m', '2020-10-24 11:08:51', 'Windows 10 | Chrome | ::1', 'Created a new hall.'),
(39, '244444', 'KidkkL949', 'halls', 'bkWAhK74Nyv6Bi5wOTUYDQaztSP2GF9m', '2020-10-24 11:09:23', 'Windows 10 | Chrome | ::1', 'Updated the hall details.'),
(40, NULL, NULL, 'halls', 'bkWAhK74Nyv6Bi5wOTUYDQaztSP2GF9m', '2020-10-24 11:09:31', 'Windows 10 | Chrome | ::1', 'Updated the hall configuration data.'),
(41, 'KidkkL949', '<strong></strong> sent out a mai', 'messaging_emails', 'aDAOWRcY3eid0hCnBmVtIL17jXMvkQSs', '2020-10-24 13:58:46', 'Windows 10 | Chrome | ::1', NULL),
(42, 'KidkkL949', '<strong></strong> sent out a mai', 'messaging_emails', 'vjnXVo2CSKT6twpJurNcs7RPUAHQaZL1', '2020-10-24 14:00:50', 'Windows 10 | Chrome | ::1', NULL),
(43, 'KidkkL949', '<strong></strong> sent out a mai', 'messaging_emails', 'W7J4U1SPb3jzBFwH5IhsMg62qaAnZQpX', '2020-10-24 14:01:11', 'Windows 10 | Chrome | ::1', NULL),
(44, 'KidkkL949', '<strong>Demo User</strong> sent ', 'messaging_emails', 'OhxJGp4gnab3H6FSslC0dc2ViKkz95rY', '2020-10-24 14:01:34', 'Windows 10 | Chrome | ::1', NULL),
(45, 'KidkkL949', '<strong>Demo User</strong> sent ', 'messaging_emails', 'b8vXtNCqHQBGfkrg5chULVO93unjZx2S', '2020-10-24 14:01:48', 'Windows 10 | Chrome | ::1', NULL),
(46, '244444', 'KidkkL949', 'remove', 'RJsS5elNOU7b3pZA1rx2Lg4mhvdHaikG', '2020-10-24 14:32:14', 'Windows 10 | Chrome | ::1', 'Deleted a department.'),
(47, '244444', 'KidkkL949', 'remove', 'cnaCYi9eQEj3S2BHUrZGXtRbduN1ATDm', '2020-10-24 14:32:38', 'Windows 10 | Chrome | ::1', 'Deleted a department.'),
(48, '244444', 'KidkkL949', 'remove', 'bkWAhK74Nyv6Bi5wOTUYDQaztSP2GF9m', '2020-10-24 14:33:02', 'Windows 10 | Chrome | ::1', 'Deleted a hall.'),
(49, '244444', 'KidkkL949', 'booking', '5', '2020-10-24 14:33:12', 'Windows 10 | Chrome | ::1', 'The Booking was successfully confirmed.'),
(50, '244444', 'KidkkL949', 'booking', '12', '2020-10-24 14:33:17', 'Windows 10 | Chrome | ::1', 'The Booking was successfully confirmed.'),
(51, '244444', 'KidkkL949', 'booking', '1', '2020-10-24 14:33:22', 'Windows 10 | Chrome | ::1', 'The Booking was successfully confirmed.'),
(52, '244444', 'KidkkL949', 'booking', '11', '2020-10-24 14:33:27', 'Windows 10 | Chrome | ::1', 'The Booking was successfully confirmed.'),
(53, '244444', 'BK273956291861', 'account-verify', 'BK273956291861', '2020-10-24 14:35:55', 'Windows 10 | Chrome | ::1', 'Verified the Email Address attached to this Account.'),
(54, '244444', 'BK273956291861', 'password_reset', 'BK273956291861', '2020-10-24 14:36:10', 'Windows 10 | Chrome | ::1', 'You successfully changed your password.'),
(55, '244444', 'BK273956291861', 'password_reset', 'BK273956291861', '2020-10-24 14:36:10', 'Windows 10 | Chrome | ::1', 'test vendor successfully resetted the password.'),
(56, '244444', 'BK273956291861', 'remove', 'eudHjSn2zIqhD9TYg3OXM5pFCbJVl7Pv', '2020-10-24 14:36:42', 'Windows 10 | Chrome | ::1', 'Cancelled an Event that is yet to be held.');

-- --------------------------------------------------------

--
-- Table structure for table `users_api_endpoints`
--

CREATE TABLE `users_api_endpoints` (
  `id` int(11) NOT NULL,
  `item_id` varchar(32) DEFAULT NULL,
  `version` varchar(32) NOT NULL DEFAULT 'v1',
  `resource` varchar(64) DEFAULT NULL,
  `endpoint` varchar(255) DEFAULT NULL,
  `method` enum('GET','POST','PUT','DELETE') DEFAULT 'GET',
  `description` varchar(255) DEFAULT NULL,
  `parameter` text DEFAULT NULL,
  `status` enum('overloaded','active','dormant','inactive') NOT NULL DEFAULT 'active',
  `counter` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `last_updated` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  `deprecated` enum('0','1') NOT NULL DEFAULT '0',
  `added_by` varchar(32) DEFAULT NULL,
  `updated_by` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_api_endpoints`
--

INSERT INTO `users_api_endpoints` (`id`, `item_id`, `version`, `resource`, `endpoint`, `method`, `description`, `parameter`, `status`, `counter`, `date_created`, `last_updated`, `deleted`, `deprecated`, `added_by`, `updated_by`) VALUES
(1, 'uzz3vl42fhvgxc7dbt9odqhomacti01k', 'v1', 'halls', 'halls/list', 'GET', '', '{\"limit\":\"The number of rows to return in the results\",\"hall_guid\":\"The Id of the hall to load the data\"}', 'active', 0, '2020-10-24 08:47:34', '2020-10-24 08:47:34', '0', '0', 'KidkkL949', NULL),
(2, 'eoi50uzss2yrdq1wmhxlm7zq4gvnhigt', 'v1', 'users', 'users/history', 'GET', '', '{\"user_id\": \"required - The user id to load the activity logs\",\"limit\": \"The number of rows to return\"}', 'active', 0, '2020-10-24 08:50:04', '2020-10-24 08:51:34', '0', '0', 'KidkkL949', 'KidkkL949'),
(3, '9jbf7gxhabnfvqmlyeag6dzdjxnpitt2', 'v1', 'halls', 'halls/add', 'POST', '', '{ \"hall_name\": \"required - The name of the hall\", \"hall_rows\": \"required - The the number of rows\", \"hall_columns\": \"required - The number of columns\", \"description\": \"Sample description / facilities of this hall\" }', 'active', 0, '2020-10-24 08:52:13', '2020-10-24 08:52:13', '0', '0', 'KidkkL949', NULL),
(4, 'su9kd8vzneqvhjmyi3qbho7tx4b2pkjy', 'v1', 'halls', 'halls/activate', 'POST', '', '{ \"hall_guid\": \"required - This is the unique guid of the hall to activate.\" }', 'active', 0, '2020-10-24 08:52:46', '2020-10-24 08:52:46', '0', '0', 'KidkkL949', NULL),
(5, 'ggjdyzvroa7whuqizilkdahet1cbeupf', 'v1', 'halls', 'halls/reset', 'POST', '', '{\"hall_guid\": \"required - This is the unique guid of the hall to reset.\"}', 'active', 0, '2020-10-24 08:53:09', '2020-10-24 08:53:09', '0', '0', 'KidkkL949', NULL),
(6, 'yw2w3mhpk9xgaikbs1csndjjvmitgofc', 'v1', 'halls', 'halls/configure', 'POST', '', '{\"available_seats\": \"required - An array of the available seats. (Check documentation for the format)\", \"blocked_seats\": \"An array of the blocked seats. (Check documentation for the format)\", \"removed_seats\": \"An array of the removed seats. (Check documentation for the format)\", \"hall_guid\": \"required - The unique id of the hall.\" }', 'active', 0, '2020-10-24 08:53:40', '2020-10-24 08:53:40', '0', '0', 'KidkkL949', NULL),
(7, '95d6sfoyzkzuaxh8nh2frpcmgbxd13ni', 'v1', 'halls', 'halls/update', 'POST', '', '{ \"hall_name\": \"required - The name of the hall\", \"hall_rows\": \"required - The the number of rows\", \"hall_columns\": \"required - The number of columns\", \"description\": \"Sample description / facilities of this hall\", \"hall_guid\": \"required - The unique guid of the hall\" }', 'active', 0, '2020-10-24 08:54:50', '2020-10-24 08:54:50', '0', '0', 'KidkkL949', NULL),
(8, '9sdriyzftbjl6uv0eskcihjpqlm3y1xn', 'v1', 'reservations', 'reservations/list', 'GET', '', '{ \"limit\": \"The number of rows to return in the results\", \"event_guid\": \"The Event Id to Filter the Results\" }', 'active', 0, '2020-10-24 08:56:37', '2020-10-24 08:56:37', '0', '0', 'KidkkL949', NULL),
(9, 'aieltdszhk38zu9vrwe0gpchopqbfsja', 'v1', 'reservations', 'reservations/reserve', 'POST', '', '{\"event_guid\": \"required - The Event that the user is booking\", \"hall_guid\": \"required - The hall that is been booked\", \"hall_guid_key\": \"required - This is for hall key as it appears in the list of halls for the event\", \"ticket_serial\": \"The serial number for the ticket.\", \"booking_details\": \"required - The details of the user making the booking. (Please refer to the documentation at https://api.eventsplanner.com for the appropriate format)\" }', 'active', 0, '2020-10-24 08:57:21', '2020-10-24 08:57:21', '0', '0', 'KidkkL949', NULL),
(10, 'afzjmlcugnbxpihgwie2sn13xcjypzot', 'v1', 'departments', 'departments/list', 'GET', '', '{ \"limit\": \"The number of rows to return in the results\", \"department_guid\": \"The Id of the Department\" }', 'active', 0, '2020-10-24 08:57:42', '2020-10-24 08:57:42', '0', '0', 'KidkkL949', NULL),
(11, 'r2bx4cyqvjlwfbr1oxcjaae5gttk0ke6', 'v1', 'departments', 'departments/add', 'POST', '', '{ \"department_name\": \"required - The name of the department\", \"color\": \"The color representing that department\", \"description\": \"Additional description\" }', 'active', 0, '2020-10-24 08:58:14', '2020-10-24 08:58:14', '0', '0', 'KidkkL949', NULL),
(12, 'mprediu1tjswhqdcgx94hojgblkkxvyn', 'v1', 'departments', 'departments/update', 'POST', '', '{ \"department_name\": \"required - The name of the department\", \"color\": \"The color representing that department\", \"description\": \"Additional description\", \"department_guid\": \"The unique id of the department\" }', 'active', 0, '2020-10-24 08:58:58', '2020-10-24 08:58:58', '0', '0', 'KidkkL949', NULL),
(13, '421olg7pdfndacsc50bkilfwhsyweztt', 'v1', 'tickets', 'tickets/list', 'GET', '', '{ \"limit\": \"The number of rows to return in the results\", \"ticket_guid\": \"The Id of the ticket to load the data\", \"event_guid\": \"This filters the list of tickets by the Event Guid\" }', 'active', 0, '2020-10-24 09:00:02', '2020-10-24 09:00:02', '0', '0', 'KidkkL949', NULL),
(14, 'nnxqu5wrieospote3plmzib97vz04vyf', 'v1', 'tickets', 'tickets/sales_list', 'GET', '', '{ \"limit\": \"The number of rows to return in the results\", \"serial\": \"The Id of the ticket serial to load the data\", \"date\": \"This is the date for which the user wants to fetch the records\" }', 'active', 0, '2020-10-24 09:00:48', '2020-10-24 09:00:48', '0', '0', 'KidkkL949', NULL),
(15, 'y64ghksiv8mnwltux2fzbtocxnrjefsp', 'v1', 'tickets', 'tickets/activate', 'POST', '', '{ \"ticket_guid\": \"required - The id for the generated tickets to be activated\" }', 'active', 0, '2020-10-24 09:01:09', '2020-10-24 09:01:09', '0', '0', 'KidkkL949', NULL),
(16, 't8ymipgiqfaekdwtn3vajlw4n0hvodl7', 'v1', 'tickets', 'tickets/validate', 'POST', '', '{ \"ticket_guid\": \"required - The id for the generated tickets to be validated.\", \"event_guid\": \"required - This is the unique id for the event.\" }', 'active', 0, '2020-10-24 09:01:44', '2020-10-24 09:01:44', '0', '0', 'KidkkL949', NULL),
(17, 'uza9qxak67eplwdzpmcc0oiitbownt8m', 'v1', 'tickets', 'tickets/sell', 'POST', '', '{ \"ticket_guid\": \"required - The id for the generated tickets to be validated.\", \"event_guid\": \"required - This is the unique id for the event.\", \"fullname\": \"required - The fullname of the person making the purchase.\", \"contact\": \"required - The contact number of the person making the purchase.\", \"email\": \"The email address of the person making the purchase.\" }', 'active', 0, '2020-10-24 09:02:16', '2020-10-24 09:02:16', '0', '0', 'KidkkL949', NULL),
(18, '9dtggvbjc20jp8h5diz3hnrtmye1qwcx', 'v1', 'tickets', 'tickets/generate', 'POST', '', '{ \"ticket_title\": \"required - The title for this ticket.\", \"quantity\": \"The number of Tickets to be generated (default is 100).\", \"initials\": \"Any initials for be appended to this ticket.\", \"length\": \"required - What is the expected length of the serial number?\", \"ticket_is_payable\": \"Is this ticket paid for? (0 or 1)\", \"ticket_amount\": \"If paid, what is the amount to be paid for this ticket?\" }', 'active', 0, '2020-10-24 09:02:50', '2020-10-24 09:02:50', '0', '0', 'KidkkL949', NULL),
(19, 'atlmgkjb2sxfy1qi7cp9piw4vedatmul', 'v1', 'tickets', 'tickets/update', 'PUT', '', '{ \"ticket_title\": \"required - The title for this ticket\", \"quantity\": \"required - The number of Tickets to be generated (default is 100)\", \"ticket_is_payable\": \"Is this ticket paid for?\", \"ticket_amount\": \"If paid, what is the amount to be paid for this ticket?\", \"ticket_guid\": \"required - The unique guid of the ticket to load\" }', 'active', 0, '2020-10-24 09:03:28', '2020-10-24 09:03:28', '0', '0', 'KidkkL949', NULL),
(20, '3lh81e6vvdfguxw9maiajqpc50gkzbyl', 'v1', 'events', 'events/list', 'GET', '', '{ \"state\": \"This is the filter applied to the state of the event\", \"limit\": \"The number of rows to return in the results\", \"summary\": \"This is an optional parameter to query\", \"event_guid\": \"The guid of the event to load the data\" }', 'active', 0, '2020-10-24 09:03:53', '2020-10-24 09:03:53', '0', '0', 'KidkkL949', NULL),
(21, 'zo2fsxodycikmu6map9tg50wveneqrxa', 'v1', 'events', 'events/add', 'POST', '', '{ \"event_title\": \"required - The name of the hall\", \"department_guid\": \"The guid of the department to attach this event\", \"event_date\": \"required - The date for which this event will be held\", \"start_time\": \"required - The starting time for the event\", \"end_time\": \"required - The end time for the event\", \"files\": \"Any additional file to the event\", \"halls_guid\": \"required - The halls that will be used for this event\", \"booking_starttime\": \"required - The date and time begin booking\", \"booking_endtime\": \"required - The date and time to end booking\", \"event_is_payable\": \"Is the event payable (0 or 1)\", \"ticket_guid\": \"If payable, what then is the tickets for this event.\", \"multiple_booking\": \"Can a user make several bookings with the same contact number? (0 or 1)\", \"maximum_booking\": \"Whats the maximum number of bookings that a user can make.\", \"attachment\": \"Attach multiple images or videos to this event.\", \"description\": \"Sample description or information about this event.\" }', 'active', 0, '2020-10-24 09:04:55', '2020-10-24 09:04:55', '0', '0', 'KidkkL949', NULL),
(22, 'eckxbbgzzhpi72mtnsskcxl8owgddqml', 'v1', 'events', 'events/update', 'POST', '', '{ \"event_title\": \"required - The name of the hall\", \"department_guid\": \"The guid of the department to attach this event\", \"event_date\": \"required - The date for which this event will be held\", \"start_time\": \"required - The starting time for the event\", \"end_time\": \"required - The end time for the event\", \"halls_guid\": \"required - The halls that will be used for this event\", \"booking_starttime\": \"required - The date and time begin booking\", \"booking_endtime\": \"required - The date and time to end booking\", \"event_is_payable\": \"Is the event payable (0 or 1)\", \"files\": \"Any additional file to the event\", \"ticket_guid\": \"If payable, what then is the tickets for this event.\", \"multiple_booking\": \"Can a user make several bookings with the same contact number? (0 or 1)\", \"maximum_booking\": \"Whats the maximum number of bookings that a user can make.\", \"attachment\": \"Attach multiple images or videos to this event.\", \"description\": \"Sample description or information about this event.\", \"event_guid\": \"required - The unique guid of the hall\" }', 'active', 0, '2020-10-24 09:06:00', '2020-10-24 09:06:00', '0', '0', 'KidkkL949', NULL),
(23, 'dqp3j9iznvflwuem6loweuyd7zt4kcix', 'v1', 'events', 'events/remove_attachment', 'POST', '', '{\"event_guid\": \"required - The event guid to delete.\"}', 'active', 0, '2020-10-24 09:07:17', '2020-10-24 09:07:17', '0', '0', 'KidkkL949', NULL),
(24, 'ebdxnhritsrogchqpwz5valwin6doxsb', 'v1', 'settings', 'settings/general', 'POST', '', '{ \"name\": \"required - The name of the company\", \"email\": \"required - The email address of the company\", \"primary_contact\": \"required - The Primary Contact Number\", \"secondary_contact\": \"The Secondary Contact Number\", \"website\": \"The webiste url of the company\", \"address\": \"required - The Address of the company\", \"logo\": \"The Company Logo\", \"client_abbr\": \"required - This is the url for making the reservation\", \"color_picker\": \"The preset colour option\", \"color\": \"The the preset colors\", \"background_color\": \"The the background color to use\", \"bg_color_light\": \"The the background light color to use\" }', 'active', 0, '2020-10-24 09:08:04', '2020-10-24 09:08:04', '0', '0', 'KidkkL949', NULL),
(25, 'gdq4txevzcjz3ferotql7kf6p0r8sm9w', 'v1', 'remove', 'remove/confirm', 'DELETE', '', '{ \"item\": \"required - The Item Type to remove\", \"item_id\": \"required - The Item ID to Remove\" }', 'active', 0, '2020-10-24 09:08:36', '2020-10-24 09:08:36', '0', '0', 'KidkkL949', NULL),
(26, 'tbfp0n2uicybivcamy6lpgxagel4e8z9', 'v1', 'insight', 'insight/report', 'GET', '', '{ \"tree\": \"The data to return: to be comma separated (list, booking_summary, detail, booking_count, overall_summary, vouchers) - Default is list.\", \"event_guid\": \"The event guid to load the data\", \"period\": \"The timeframe for the report to generate\", \"order\": \"The order for the results listing (ASC or DESC)\", \"user_guid\": \"This is the unique id of the Admin User to generate reports\" }', 'active', 0, '2020-10-24 09:09:06', '2020-10-24 09:09:06', '0', '0', 'KidkkL949', NULL),
(27, 'zztfvmjwrnsaycqdtnoy4w86chaik21p', 'v1', 'sms', 'sms/check_balance', 'GET', '', '{ \"description\": \"Check the SMS Unit balance for this account\" }', 'active', 0, '2020-10-24 09:10:00', '2020-10-24 09:10:00', '0', '0', 'KidkkL949', NULL),
(28, 'qqadpf5lkaxjhzd7zy9xmmnogbtew2kc', 'v1', 'sms', 'sms/history', 'GET', 'Get the SMS History sent from this account', '{ \"limit\": \"The number of rows to return in the results\", \"group\": \"Could either be bulk or single\" }', 'active', 0, '2020-10-24 09:10:50', '2020-10-24 09:10:50', '0', '0', 'KidkkL949', NULL),
(29, 'eo7ap8lmhwwuydvbjqai2lcxv0oueyq3', 'v1', 'sms', 'sms/category', 'GET', '', '{ \"msg_type\": \"required - This is the type of message to send\", \"recipient\": \"required - The receipient group to receive the message.\" }', 'active', 0, '2020-10-24 09:11:10', '2020-10-24 09:11:10', '0', '0', 'KidkkL949', NULL),
(30, 'uxknshmcoxbkcumdd2lwe14lewhgz3ri', 'v1', 'sms', 'sms/topup_list', 'GET', '', '', 'active', 0, '2020-10-24 09:11:31', '2020-10-24 09:11:31', '0', '0', 'KidkkL949', NULL),
(31, 'vhxpjm0glak8irmwyzqb5n7oeghu1spy', 'v1', 'sms', 'sms/send', 'POST', '', '{ \"message\": \"required - The message to send\", \"recipients\": \"The recipients to receive the message\", \"category\": \"required - The category of messages to receive\", \"data\": \"This is an additional data to parse together with the recipient category\", \"unit\": \"The unit of messages to send out to the uses.\" }', 'active', 0, '2020-10-24 09:12:05', '2020-10-24 09:12:05', '0', '0', 'KidkkL949', NULL),
(32, 'v3pnablcg6f9izjdfz5mgd7uothnktlr', 'v1', 'sms', 'sms/topup', 'POST', '', '{ \"amount\": \"required - The amount of SMS bundle to purchase\" }', 'active', 0, '2020-10-24 09:12:28', '2020-10-24 09:12:28', '0', '0', 'KidkkL949', NULL),
(33, 'ca1kuhssondwrtveu5q3fdmplnomy2pb', 'v1', 'emails', 'emails/temp_attachments', 'GET', '', '', 'active', 0, '2020-10-24 09:12:49', '2020-10-24 09:12:49', '0', '0', 'KidkkL949', NULL),
(34, 'i1kywd0u2pfgosgjzxacxznv6eb8ltsk', 'v1', 'emails', 'emails/list', 'GET', '', '{ \"contact_guid\": \"The unique id of the customer\", \"limit\": \"The number of rows to return in the results\", \"message_guid\": \"This is the unique id of the message\", \"message_type\": \"This is the category of the message\" }', 'active', 0, '2020-10-24 09:13:21', '2020-10-24 09:13:21', '0', '0', 'KidkkL949', NULL),
(35, 'gmvlk9adpwt7wxctrhs1dmgnqkz3is2u', 'v1', 'emails', 'emails/attach', 'POST', '', '{ \"mail_attachment\": \"required - This must be a file document to upload\" }', 'active', 0, '2020-10-24 09:13:44', '2020-10-24 09:13:44', '0', '0', 'KidkkL949', NULL),
(36, '8geghsipkjwtldqm2k7r6unioofev1uc', 'v1', 'emails', 'emails/execute', 'POST', 'Send all pending mails', '', 'active', 0, '2020-10-24 09:14:05', '2020-10-24 09:15:11', '0', '0', 'KidkkL949', 'KidkkL949'),
(37, 'viflr0skx4bghxc1oaejdlihukomn8p3', 'v1', 'emails', 'emails/remove_attachment', 'POST', '', '{ \"document_id\": \"required - The temporary id of the document to remove\" }', 'active', 0, '2020-10-24 09:14:58', '2020-10-24 09:14:58', '0', '0', 'KidkkL949', NULL),
(38, 'rqzsg15oevp94jhd073nefniuujvpkxy', 'v1', 'emails', 'emails/discard', 'POST', 'Discard the email message composing', '', 'active', 0, '2020-10-24 09:15:47', '2020-10-24 09:15:47', '0', '0', 'KidkkL949', NULL),
(39, 'h8eatbwdy9igzq1nzhlcps43rolgjj5y', 'v1', 'emails', 'emails/send', 'POST', '', '{ \"sender\": \"required - The Email to send the message from\", \"subject\": \"required - The subject of the mail\", \"message\": \"required - The content of the email message\", \"recipients\": \"required - The recipients to receive the email\" }', 'active', 0, '2020-10-24 09:16:50', '2020-10-24 09:16:50', '0', '0', 'KidkkL949', NULL),
(40, 'esbmhj6ofwxkqvruwyj7pxf8gualens2', 'v1', 'users', 'users/list', 'GET', 'This endpoint lists users from the database.', '{ \"limit\": \"This is the number to limit the results\", \"user_id\": \"This is applied when the user has parsed an ID. This will limit the result by the user id parsed.\",\"lookup\":\"Optional parameter\",\"minified\":\"Optional parameter\"}', 'active', 0, '2020-10-24 09:17:31', '2020-10-24 11:59:04', '0', '0', 'KidkkL949', 'KidkkL949'),
(41, 'ruzykfpewxh8h5c9ovz0jdf1alporxwt', 'v1', 'users', 'users/access_levels', 'GET', 'This endpoint returns an arrayed list of access level parameters that are associated to that particular access level', '{ \"level_id\": \"The access level id parsed\" }', 'active', 0, '2020-10-24 09:18:03', '2020-10-24 09:18:03', '0', '0', 'KidkkL949', NULL),
(42, 'dmihzxusvjete9uw8ngcxyojkth6qsip', 'v1', 'users', 'users/add', 'POST', 'This endpoint is used for creating a user account', '{ \"fullname\": \"required - The fullname of the user\", \"access_level\": \"The Access Level Permissions of this user\", \"access_level_id\": \"This is the user access level id\", \"contact\": \"The contact number of the Account Holder\", \"email\": \"required - The email address of the user\", \"username\": \"The username must always be unique\", \"user_image\": \"The user image for profile picture\", \"theme\": \"This is the default background theme to use (light-theme or dark-theme)\", \"navbar\": \"This specifies whether the navigation bar must be hidden or visible\" }', 'active', 0, '2020-10-24 09:18:56', '2020-10-24 09:18:56', '0', '0', 'KidkkL949', NULL),
(43, '2x5nxjwvlgg6cbm7artkhzpf3wibedei', 'v1', 'users', 'users/update', 'POST', '', '{ \"user_image\": \"The user image for profile picture\", \"fullname\": \"required - Provide the lastname\", \"email\": \"required - This is the Email Address of the Account Holder\", \"user_guid\": \"required - The user id to update\", \"username\": \"required - The username of the user\", \"access_level_id\": \"This is the user access level id\", \"contact\": \"The contact number of the Account Holder\", \"access_level\": \"array - The access Level of the user\", \"theme\": \"This is the default background theme to use (light-theme or dark-theme)\", \"navbar\": \"This specifies whether the navigation bar must be hidden or visible\" }', 'active', 0, '2020-10-24 09:19:46', '2020-10-24 09:19:46', '0', '0', 'KidkkL949', NULL),
(44, 'z1vzlp8doldthkcgqustifrayam6jbe2', 'v1', 'users', 'users/history', 'POST', 'This endpoint returns the list of user activity logs', '{ \"user_id\": \"required - The user id to load the activity logs\", \"limit\": \"The number of rows to return\" }', 'active', 0, '2020-10-24 09:20:28', '2020-10-24 09:20:28', '0', '0', 'KidkkL949', NULL),
(45, 'gb61h2xfmykcpeljvqreoutvxn0ydskd', 'v1', 'users', 'users/access_levels_list', 'POST', 'This endpoint returns an arrayed list of access level parameters that are associated to that particular access level', '{ \"level_id\": \"required - The access level id parsed\", \"user_guid\": \"The user id to update the access level permissions\" }', 'active', 0, '2020-10-24 09:21:23', '2020-10-24 09:21:23', '0', '0', 'KidkkL949', NULL),
(46, 'nmoh0izjblk8gegri9dcctpnwvbpamwj', 'v1', 'users', 'users/permissions', 'POST', 'Load the users access permissions', '{ \"user_id\": \"The access level id parsed\", \"access_level\": \"The access level id to load the permissions\" }', 'active', 0, '2020-10-24 09:21:51', '2020-10-24 09:21:51', '0', '0', 'KidkkL949', NULL),
(47, 'stz2edaqajys54wnxx7h6bdyuwgiopnf', 'v1', 'users', 'users/change_password', 'POST', 'Use this endpoint to change a users password', '{ \"user_guid\": \"required - This is the unique user id to change the password.\", \"password\": \"required - Enter the password\", \"password_2\": \"required - Reenter password to confirm\" }', 'active', 0, '2020-10-24 09:22:20', '2020-10-24 09:22:20', '0', '0', 'KidkkL949', NULL),
(48, 'iacdcesx5r7fjkunzbzo0gq9byoqejrk', 'v1', 'users', 'users/access_levels', 'POST', 'Update the user access permissions', '{ \"user_id\": \"required - The user id to update the access level permissions\", \"access_level\": \"required - The access level\", \"access_permissions\": \"required - Array of the access levels\" }', 'active', 0, '2020-10-24 09:22:46', '2020-10-24 09:22:46', '0', '0', 'KidkkL949', NULL),
(49, 'axd9swlsog1mzeeumiojhufwdl4raqkx', 'v1', 'users', 'users/update', 'PUT', '', '{ \"user_id\": \"required - The unique id of the user\", \"fullname\": \"required - The fullname of the user\", \"access_level\": \"required - The Access Level Permissions of this user\", \"gender\": \"The gender\", \"contact\": \"The phone number of the user\", \"email\": \"required - The email address of the user\" }', 'active', 0, '2020-10-24 09:23:18', '2020-10-24 09:23:18', '0', '0', 'KidkkL949', NULL),
(50, 'nzceeqtpn0ibgxlkpcj7rqs6ytwsf9i3', 'v1', 'users', 'users/theme', 'PUT', 'Use this endpoint to update the users defualt theme', '{ \"theme\": \"required - This is the theme color to be set\" }', 'active', 0, '2020-10-24 09:24:05', '2020-10-24 09:24:05', '0', '0', 'KidkkL949', NULL),
(51, 'lb42pmtnd1hbpy60owrgnrt5ymfi7uh9', 'v1', 'account', 'account/update', 'POST', '', '', 'active', 0, '2020-10-24 10:48:04', '2020-10-24 10:48:04', '0', '0', 'KidkkL949', NULL),
(52, 'vmxcu6emvxgfyt04l9capz3bjhwrnisw', 'v1', 'emails', 'emails/action', 'POST', '', '{\"action\":\"required - An array of actions to perform\"}', 'active', 0, '2020-10-24 11:53:56', '2020-10-24 11:53:56', '0', '0', 'KidkkL949', NULL),
(53, 'wlaxke0b1ngv63gjaqif8fcyzhpziorx', 'v1', 'files', 'files/attachments', 'POST', '', '{\"attachment_file_upload\":\"Document to upload, if any.\",\"module\":\"The module of documents to list.\",\"item_id\":\"This is the id of the item - This is needed in loading information\", \"label\":\"This will contain additional information\",\"comment_attachment_file_upload\":\"The file to attach\"}', 'active', 0, '2020-10-24 13:51:01', '2020-10-24 13:51:01', '0', '0', 'KidkkL949', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_api_keys`
--

CREATE TABLE `users_api_keys` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `client_guid` varchar(32) DEFAULT NULL,
  `username` varchar(55) DEFAULT NULL,
  `access_token` varchar(1000) DEFAULT NULL,
  `access_key` varchar(255) DEFAULT NULL,
  `access_type` enum('temp','permanent') DEFAULT 'permanent',
  `expiry_date` date DEFAULT NULL,
  `expiry_timestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `requests_limit` int(11) UNSIGNED DEFAULT 1000000,
  `total_requests` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `permissions` longtext DEFAULT NULL CHECK (json_valid(`permissions`)),
  `date_generated` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_api_keys`
--

INSERT INTO `users_api_keys` (`id`, `user_id`, `client_guid`, `username`, `access_token`, `access_key`, `access_type`, `expiry_date`, `expiry_timestamp`, `requests_limit`, `total_requests`, `permissions`, `date_generated`, `status`) VALUES
(6, 'tgxuwdwkdjr58mg64hxk1fc3efmnvata', NULL, 'test_admin', '$2y$10$wTlBdjQuI6HAT1XqwyHPZOkWHL47L4IsqPHq7ey6wv0hYbdSOjrJC', 'p43FVPXvUi8DWNzklKBHjhQ1S4wktGcJ6maAYLG73MOCdsxzjeQdsMREtBfn20TI9Hli', 'temp', '2020-09-30', '2020-09-30 21:46:52', 5000, 0, NULL, '2020-09-30 21:46:52', '1');

-- --------------------------------------------------------

--
-- Table structure for table `users_api_queries`
--

CREATE TABLE `users_api_queries` (
  `id` int(11) UNSIGNED NOT NULL,
  `requests_count` int(11) UNSIGNED DEFAULT NULL,
  `request_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users_api_requests`
--

CREATE TABLE `users_api_requests` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` varchar(64) DEFAULT NULL,
  `request_uri` varchar(1000) DEFAULT NULL,
  `request_payload` text DEFAULT NULL,
  `request_method` varchar(10) DEFAULT NULL,
  `response_code` int(11) UNSIGNED DEFAULT NULL,
  `user_ipaddress` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Table structure for table `users_emails`
--

CREATE TABLE `users_emails` (
  `id` int(10) UNSIGNED NOT NULL,
  `thread_id` varchar(32) DEFAULT NULL,
  `client_guid` varchar(32) DEFAULT NULL,
  `user_guid` varchar(32) DEFAULT NULL,
  `subject` varchar(1000) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `sender_details` varchar(2000) DEFAULT NULL,
  `recipient_details` text DEFAULT NULL,
  `recipient_list` text DEFAULT NULL,
  `copy_recipients` text DEFAULT NULL,
  `copy_recipients_list` text DEFAULT NULL,
  `read_list` text DEFAULT NULL,
  `favorite_list` text DEFAULT NULL,
  `important_list` text DEFAULT NULL,
  `trash_list` text DEFAULT NULL,
  `deleted_list` text DEFAULT NULL,
  `archive_list` text DEFAULT NULL,
  `label` enum('draft','inbox','trash','important','sent','archive') NOT NULL DEFAULT 'inbox',
  `mode` varchar(12) DEFAULT 'inbox',
  `schedule_send` enum('true','false') NOT NULL DEFAULT 'false',
  `schedule_date` datetime DEFAULT current_timestamp(),
  `sent_status` enum('0','1') NOT NULL DEFAULT '0',
  `sent_date` datetime DEFAULT NULL,
  `attachment_size` varchar(12) NOT NULL DEFAULT '0',
  `date_created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_emails`
--

INSERT INTO `users_emails` (`id`, `thread_id`, `client_guid`, `user_guid`, `subject`, `message`, `status`, `sender_details`, `recipient_details`, `recipient_list`, `copy_recipients`, `copy_recipients_list`, `read_list`, `favorite_list`, `important_list`, `trash_list`, `deleted_list`, `archive_list`, `label`, `mode`, `schedule_send`, `schedule_date`, `sent_status`, `sent_date`, `attachment_size`, `date_created`) VALUES
(1, '7xTeIEKY1bGjZX0RAs8iypdL45z6BtVh', '244444', 'tgxuwdwkdjr58mg64hxk1fc3efmnvata', 'Test Mail', '&lt;div&gt;&lt;!--block--&gt;This is a test email message that i am sending to 2 recipients&lt;br&gt;I am confident that the expected results will be achieved.&lt;/div&gt;', '1', '{\"fullname\":\"Frank Amoako\",\"email\":\"frankamoako@gmail.com\",\"user_id\":\"tgxuwdwkdjr58mg64hxk1fc3efmnvata\"}', '[{\"user_id\":\"KidkkL949\",\"email\":\"revsolo@mail.com\",\"fullname\":\"Solomon Kwarteng\"},{\"user_id\":\"BK273956291861\",\"email\":\"frankamoako@gmail.com\",\"fullname\":\"National Insurance Commission\"}]', '[\"KidkkL949\",\"BK273956291861\"]', '[]', '[]', '{\"0\":\"NULL\",\"2\":\"uIkajswRCXEVr58mg64hxk1fc3efmnva\"}', '[\"NULL\",\"tgxuwdwkdjr58mg64hxk1fc3efmnvata\",\"KidkkL949\"]', '[\"NULL\",\"tgxuwdwkdjr58mg64hxk1fc3efmnvata\",\"KidkkL949\"]', '[\"NULL\"]', '[\"NULL\"]', '[\"NULL\"]', 'inbox', 'sent', 'false', '2020-10-20 20:39:06', '0', NULL, '0', '2020-10-20 20:39:06'),
(2, 'u0cnFdkDIH825p6V3b4yENZjAhPJiomY', '244444', 'tgxuwdwkdjr58mg64hxk1fc3efmnvata', 'Test sending', '&lt;div&gt;&lt;!--block--&gt;This is to express our profound gratitude for the support you offered to us during the &lt;strong&gt;Naming &amp; Foundation Stone Laying &lt;/strong&gt;held on &lt;strong&gt;Saturday, 7th March, 2020.&lt;br&gt;&lt;/strong&gt;&lt;br&gt;&lt;/div&gt;&lt;div&gt;&lt;!--block--&gt;We sincerely appreciate your kind gesture and pray that our good Lord will bless you as you extend support towards the growth of the Church triumphant and to win more souls for His kingdom.&lt;br&gt;&lt;br&gt;&lt;/div&gt;&lt;div&gt;&lt;!--block--&gt;Once again we say a very BIG THANK YOU.&nbsp;&lt;/div&gt;', '1', '{\"fullname\":\"Frank Amoako\",\"email\":\"frankamoako@gmail.com\",\"user_id\":\"tgxuwdwkdjr58mg64hxk1fc3efmnvata\"}', '[{\"user_id\":\"KidkkL949\",\"email\":\"revsolo@mail.com\",\"fullname\":\"Solomon Kwarteng\"}]', '[\"KidkkL949\"]', '[{\"user_id\":\"G9fI4VlHtRPga5Ezq78S6wjNYcunFAs0\",\"email\":\"graceobeng@mail.com\",\"fullname\":\"Grace Obeng\"}]', '[\"G9fI4VlHtRPga5Ezq78S6wjNYcunFAs0\"]', '[\"NULL\",\"sgHvi29tuJakdfzmp71nowNlWr40BKDV\"]', '[\"NULL\",\"tgxuwdwkdjr58mg64hxk1fc3efmnvata\",\"sgHvi29tuJakdfzmp71nowNlWr40BKDV\",\"KidkkL949\"]', '[\"NULL\",\"tgxuwdwkdjr58mg64hxk1fc3efmnvata\"]', '[\"NULL\"]', '[\"NULL\"]', '[\"NULL\"]', 'inbox', 'sent', 'true', '2020-10-30 10:34:44', '0', NULL, '0', '2020-10-22 10:36:26'),
(7, 'b8vXtNCqHQBGfkrg5chULVO93unjZx2S', '244444', 'KidkkL949', 'sending test', '&lt;div&gt;&lt;!--block--&gt;test email sending to the demo user here and there and here and list&lt;/div&gt;', '1', '{\"fullname\":\"Demo User<br><span class=\'badge badge-success\'>Active<\\/span>\",\"email\":\"admin@mail.com\",\"user_id\":\"KidkkL949\"}', '[{\"user_id\":\"KidkkL949\",\"email\":\"admin@mail.com\",\"fullname\":\"Demo User\"}]', '[\"KidkkL949\"]', '[]', '[]', '[\"NULL\"]', '[\"NULL\"]', '[\"NULL\"]', '[\"NULL\"]', '[\"NULL\"]', '[\"NULL\"]', 'inbox', 'sent', 'false', '2020-10-24 14:01:48', '0', NULL, '0', '2020-10-24 14:01:48');

-- --------------------------------------------------------

--
-- Table structure for table `users_email_list`
--

CREATE TABLE `users_email_list` (
  `id` int(11) NOT NULL,
  `client_guid` varchar(32) DEFAULT 'NULL',
  `template_type` enum('general','sign_up','login','recovery','receipt','ticket') DEFAULT NULL,
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
(1, '244444', 'recovery', 'KidkkL949', '{\"recipients_list\":[{\"fullname\":\"Emmanuel Obeng\",\"email\":\"admin@mail.com\",\"customer_id\":\"KidkkL949\"}]}', '2020-07-02 08:24:57', '0', '[BookingLog] Change Password', 'Hi Emmanuel Obeng<br>You have requested to reset your password at BookingLog<br><br>Before you can reset your password please follow this link.<br><br><a class=\"alert alert-success\" href=\"http://localhost/booking/verify?password&token=q7FMh7moPzkLBiYud18cfdi6UF5RktJNTASgZUALDwHMqvOQpjBCwuhN8a6ExEXG5W1t\">Click Here to Reset Password</a><br><br>If it does not work please copy this link and place it in your browser url.<br><br>http://localhost/booking/verify?password&token=q7FMh7moPzkLBiYud18cfdi6UF5RktJNTASgZUALDwHMqvOQpjBCwuhN8a6ExEXG5W1t', 'KidkkL949', '1', NULL),
(2, '244444', 'recovery', 'FW651874392', '{\"recipients_list\":[{\"fullname\":\"testuser name\",\"email\":\"testusername@mail.com\",\"customer_id\":\"FW651874392\"}]}', '2020-07-16 21:56:10', '0', '[BookingLog] Change Password', 'Hi testuser name<br>You have successfully changed your password at BookingLog<br><br>Do ignore this message if your rightfully effected this change.<br><br>If not, do <a class=\"alert alert-success\" href=\"http://localhost/booking/recover\">Click Here</a> if you did not perform this act.', 'FW651874392', '0', NULL),
(3, '244444', 'ticket', 'DZ000072', '{\"recipients_list\":[{\"fullname\":\"Frank Obeng\",\"email\":\"emmallob14@gmail.com\",\"contact\":\"0550107770\"}]}', '2020-08-11 10:29:05', '0', 'Event: Ticket Based Event Ticket', 'Hi Frank Obeng, <br>Your Serial Number for the Event: Ticket Based Event \r\n            scheduled on 2020-07-31 is DZ000072. Thank you.', 'KidkkL949', '0', NULL),
(4, '244444', 'ticket', 'DZ000073', '{\"recipients_list\":[{\"fullname\":\"Grace Obeng Hyde\",\"email\":\"graciellaob@gmail.com\",\"contact\":\"0240553604\"}]}', '2020-08-11 10:33:52', '0', 'Event: Ticket Based Event Ticket', 'Hi Grace Obeng Hyde, <br>Your Serial Number for the Event: Ticket Based Event \r\n            scheduled on 2020-07-31 is DZ000073. Thank you.', 'KidkkL949', '0', NULL),
(5, '244444', 'ticket', 'DZ000032', '{\"recipients_list\":[{\"fullname\":\"George Asamoah\",\"email\":\"georgeasamoah@mail.com\",\"contact\":\"0203317732\"}]}', '2020-08-11 10:34:31', '0', 'Event: Ticket Based Event Ticket', 'Hi George Asamoah, <br>Your Serial Number for the Event: Ticket Based Event \r\n            scheduled on 2020-07-31 is DZ000032. Thank you.', 'KidkkL949', '0', NULL),
(6, '244444', 'ticket', 'DZ000009', '{\"recipients_list\":[{\"fullname\":\"Last Tester\",\"email\":\"testmail@mail.com\",\"contact\":\"0302909890\"}]}', '2020-08-11 10:36:48', '0', 'Event: Ticket Based Event Ticket', 'Hi Last Tester, <br>Your Serial Number for the Event: Ticket Based Event \r\n            scheduled on 2020-07-31 is DZ000009. Thank you.', 'KidkkL949', '0', NULL),
(7, '244444', 'ticket', 'DA2P6NGF', '{\"recipients_list\":[{\"fullname\":\"Emmanuel Obeng\",\"email\":\"emmallob14@gmail.com\",\"contact\":\"0550107770\"}]}', '2020-10-24 10:20:27', '0', 'Event: 2nd Service Ticket', 'Hi Emmanuel Obeng, <br>Your Serial Number for the Event: 2nd Service \r\n            scheduled on 2020-10-25 is DA2P6NGF. Thank you.', 'KidkkL949', '0', NULL),
(8, '244444', 'general', 'BK273956291861', '{\"recipients_list\":[{\"fullname\":\"test vendor\",\"email\":\"testvendor@mail.com\",\"customer_id\":\"BK273956291861\"}]}', '2020-10-24 10:52:48', '0', 'Account Setup \\[BookingLog\\]\n', 'Hello test vendor,\nYou have been added as a user on <strong>Kwesi Dickson Memorial Methodist Society - Adjiringanor</strong> to help manage the Account.\n\nYour username to be used for login is <strong>testvendor</strong>\nYou can use your previous password to continue to login.\nPlease <a href=\'http://localhost/booking/verify/account?token=YPbgfDHg41dt62HT7WRSJTd8ukYx540vVnoa8BwJMjAOrXeZAyoLCOlcDiKm6mCuh51\'><strong>Click Here</strong></a> to verify your Email Address.\n\n', NULL, '0', NULL),
(9, '244444', 'general', 'BK936539567228', '{\"recipients_list\":[{\"fullname\":\"Test Vendor 2\",\"email\":\"testvendor2@mail.com\",\"customer_id\":\"BK936539567228\"}]}', '2020-10-24 10:53:49', '0', 'Account Setup \\[BookingLog\\]\n', 'Hello Test Vendor 2,\nYou have been added as a user on <strong>Kwesi Dickson Memorial Methodist Society - Adjiringanor</strong> to help manage the Account.\n\nYour username to be used for login is <strong>testvendor2</strong>\nYou can use your previous password to continue to login.\nPlease <a href=\'http://localhost/booking/verify/account?token=7ckbtmMSnIWBvQrTeUqKC5iP9E8R6ZdgYXhyuo4pxaHsLF2J3fG0DNz\'><strong>Click Here</strong></a> to verify your Email Address.\n\n', 'KidkkL949', '0', NULL),
(15, '244444', 'recovery', 'KidkkL949', '{\"recipients_list\":[{\"fullname\":\"Demo User\",\"email\":\"admin@mail.com\",\"customer_id\":\"KidkkL949\"}]}', '2020-10-24 11:02:57', '0', '[BookingLog] Change Password', 'Hi Demo User<br>You have requested to reset your password at BookingLog<br><br>Before you can reset your password please follow this link.<br><br><a class=\"alert alert-success\" href=\"http://localhost/booking/verify?password&token=faECctni1dFU4XlBZJKR3OoG2brvqD6sPVY0uLH9jh5NpTwMWeyz78QxkAmS\">Click Here to Reset Password</a><br><br>If it does not work please copy this link and place it in your browser url.<br><br>http://localhost/booking/verify?password&token=faECctni1dFU4XlBZJKR3OoG2brvqD6sPVY0uLH9jh5NpTwMWeyz78QxkAmS', 'KidkkL949', '0', NULL),
(16, '244444', 'recovery', 'BK273956291861', '{\"recipients_list\":[{\"fullname\":\"test vendor\",\"email\":\"testvendor@mail.com\",\"customer_id\":\"BK273956291861\"}]}', '2020-10-24 14:36:10', '0', '[BookingLog] Change Password', 'Hi test vendor<br>You have successfully changed your password at BookingLog<br><br>Do ignore this message if your rightfully effected this change.<br><br>If not, do <a class=\"alert alert-success\" href=\"http://localhost/booking/recover\">Click Here</a> if you did not perform this act.', 'BK273956291861', '0', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_gender`
--

CREATE TABLE `users_gender` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users_gender`
--

INSERT INTO `users_gender` (`id`, `name`) VALUES
(1, 'Male'),
(2, 'Female'),
(3, 'Other');

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
(1, '244444', 'KidkkL949', 'admin@mail.com', '2020-10-23 08:22:28', '::1', 'Chrome|Windows 10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.12'),
(2, '244444', 'KidkkL949', 'admin@mail.com', '2020-10-23 08:52:15', '::1', 'Chrome|Windows 10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.12'),
(3, '244444', 'KidkkL949', 'admin@mail.com', '2020-10-23 09:17:53', '::1', 'Chrome|Windows 10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.12'),
(4, '244444', 'KidkkL949', 'admin@mail.com', '2020-10-23 10:38:53', '127.0.0.1', 'Firefox|Windows 10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:74.0) Gecko/20100101 Firefox/74.0'),
(5, '244444', 'KidkkL949', 'admin@mail.com', '2020-10-24 08:19:46', '::1', 'Chrome|Windows 10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.12'),
(6, '244444', 'KidkkL949', 'admin@mail.com', '2020-10-24 11:04:08', '::1', 'Chrome|Windows 10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.12'),
(7, '244444', 'KidkkL949', 'admin@mail.com', '2020-10-24 11:04:30', '::1', 'Chrome|Windows 10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.12'),
(8, '244444', 'BK273956291861', 'testvendor@mail.com', '2020-10-24 14:36:16', '::1', 'Chrome|Windows 10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.11');

-- --------------------------------------------------------

--
-- Table structure for table `users_notification`
--

CREATE TABLE `users_notification` (
  `id` int(11) UNSIGNED NOT NULL,
  `item_id` varchar(32) DEFAULT NULL,
  `user_id` varchar(32) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `initiated_by` enum('user','system') DEFAULT 'user',
  `notice_type` varchar(32) DEFAULT NULL,
  `created_by` varchar(32) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `seen_status` enum('0','1') NOT NULL DEFAULT '0',
  `seen_date` datetime DEFAULT NULL,
  `confirmed` enum('0','1') DEFAULT '0',
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users_reset_request`
--

CREATE TABLE `users_reset_request` (
  `id` int(11) NOT NULL,
  `item_id` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `user_guid` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `user_agent` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token_status` enum('USED','EXPIRED','PENDING','ANNULED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENDING',
  `request_token` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_date` datetime DEFAULT NULL,
  `reset_agent` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expiry_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_reset_request`
--

INSERT INTO `users_reset_request` (`id`, `item_id`, `username`, `user_guid`, `user_agent`, `token_status`, `request_token`, `reset_date`, `reset_agent`, `expiry_time`) VALUES
(1, NULL, 'testvendor', 'BK273956291861', 'NIL', 'PENDING', 'zLNtnxWHnzlavJQP5AWJ7SKBuCYGQeMHhydq8kmqilweKp5XbxRrcOw3sgDmARiZUO', NULL, NULL, 1603537274),
(2, NULL, 'adminuser', 'KidkkL949', 'Chrome Windows 10|::1', 'PENDING', 'faECctni1dFU4XlBZJKR3OoG2brvqD6sPVY0uLH9jh5NpTwMWeyz78QxkAmS', NULL, NULL, 1603537377),
(3, NULL, 'testvendor', 'BK273956291861', 'NIL', 'USED', NULL, '2020-10-24 14:36:10', 'Chrome Windows 10|::1', 1603546570);

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
(1, '244444', 'KidkkL949', '{\"permissions\":{\"halls\":{\"list\":\"1\",\"add\":\"1\",\"configure\":1,\"update\":\"1\",\"delete\":\"1\"},\"events\":{\"list\":1,\"add\":1,\"update\":1,\"delete\":1,\"insight\":1},\"departments\":{\"list\":1,\"add\":1,\"update\":1,\"delete\":1},\"members\":{\"list\":1,\"add\":1,\"update\":1,\"delete\":1},\"tickets\":{\"list\":1,\"generate\":1,\"delete\":1,\"sell\":1,\"return\":1,\"reports\":1},\"users\":{\"manage\":1,\"delete\":1,\"accesslevel\":1},\"account\":{\"manage\":1,\"subscription\":1},\"communications\":{\"manage\":1}}}', '2020-10-23 02:44:58', NULL),
(2, '244444', 'BK273956291861', '{\"permissions\":{\"halls\":{\"list\":1},\"events\":{\"list\":1},\"departments\":{\"list\":1},\"tickets\":{\"list\":1,\"sell\":1,\"return\":1,\"reports\":1}}}', '2020-10-24 10:52:48', '2020-10-24 10:52:48');

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
-- Indexes for table `cron_scheduler`
--
ALTER TABLE `cron_scheduler`
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
-- Indexes for table `events_media`
--
ALTER TABLE `events_media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `files_attachment`
--
ALTER TABLE `files_attachment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `halls`
--
ALTER TABLE `halls`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hall_guid` (`hall_guid`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_purchases`
--
ALTER TABLE `sms_purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_subscribers`
--
ALTER TABLE `sms_subscribers`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `ticket_purchases`
--
ALTER TABLE `ticket_purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_guid` (`user_guid`);

--
-- Indexes for table `users_access_attempt`
--
ALTER TABLE `users_access_attempt`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `users_api_endpoints`
--
ALTER TABLE `users_api_endpoints`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_api_keys`
--
ALTER TABLE `users_api_keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_api_queries`
--
ALTER TABLE `users_api_queries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_api_requests`
--
ALTER TABLE `users_api_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_data_monitoring`
--
ALTER TABLE `users_data_monitoring`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_emails`
--
ALTER TABLE `users_emails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_email_list`
--
ALTER TABLE `users_email_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_gender`
--
ALTER TABLE `users_gender`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_login_history`
--
ALTER TABLE `users_login_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_notification`
--
ALTER TABLE `users_notification`
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
-- AUTO_INCREMENT for table `cron_scheduler`
--
ALTER TABLE `cron_scheduler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `events_booking`
--
ALTER TABLE `events_booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `events_halls_configuration`
--
ALTER TABLE `events_halls_configuration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `events_media`
--
ALTER TABLE `events_media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `files_attachment`
--
ALTER TABLE `files_attachment`
  MODIFY `id` int(12) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `halls`
--
ALTER TABLE `halls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sms_purchases`
--
ALTER TABLE `sms_purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sms_subscribers`
--
ALTER TABLE `sms_subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tickets_listing`
--
ALTER TABLE `tickets_listing`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=235;

--
-- AUTO_INCREMENT for table `ticket_purchases`
--
ALTER TABLE `ticket_purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users_access_attempt`
--
ALTER TABLE `users_access_attempt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_access_levels`
--
ALTER TABLE `users_access_levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users_accounts`
--
ALTER TABLE `users_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users_activity_logs`
--
ALTER TABLE `users_activity_logs`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `users_api_endpoints`
--
ALTER TABLE `users_api_endpoints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `users_api_keys`
--
ALTER TABLE `users_api_keys`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users_api_queries`
--
ALTER TABLE `users_api_queries`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_api_requests`
--
ALTER TABLE `users_api_requests`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_data_monitoring`
--
ALTER TABLE `users_data_monitoring`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_emails`
--
ALTER TABLE `users_emails`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users_email_list`
--
ALTER TABLE `users_email_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users_gender`
--
ALTER TABLE `users_gender`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users_login_history`
--
ALTER TABLE `users_login_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users_notification`
--
ALTER TABLE `users_notification`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_reset_request`
--
ALTER TABLE `users_reset_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users_roles`
--
ALTER TABLE `users_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
