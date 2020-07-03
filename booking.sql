-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2020 at 02:05 AM
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
(3, '244444', 'sX9Yrq8CQ7gnwaKBThEfmRFM4b3AcJLN', 'Tes Delete', 'This is a test delete', '#000000', '0');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `client_guid` varchar(32) DEFAULT NULL,
  `event_guid` varchar(32) DEFAULT NULL,
  `event_title` varchar(255) DEFAULT NULL,
  `halls_guid` varchar(1000) DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `start_time` varchar(20) DEFAULT NULL,
  `end_time` varchar(20) DEFAULT NULL,
  `booking_start_time` varchar(255) DEFAULT NULL,
  `booking_end_time` varchar(255) DEFAULT NULL,
  `is_payable` enum('0','1') DEFAULT '0',
  `department_guid` varchar(32) DEFAULT NULL,
  `allow_multiple_booking` enum('0','1') NOT NULL DEFAULT '1',
  `maximum_multiple_booking` int(10) UNSIGNED NOT NULL DEFAULT 3,
  `attachment` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `ticket_guid` varchar(32) DEFAULT NULL,
  `activated` enum('0','1') NOT NULL DEFAULT '0',
  `state` enum('pending','in-progress','cancelled','past') DEFAULT 'pending',
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(32) DEFAULT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `events_booking`
--

CREATE TABLE `events_booking` (
  `id` int(11) NOT NULL,
  `event_guid` varchar(32) DEFAULT NULL,
  `ticket_guid` varchar(32) DEFAULT NULL,
  `ticket_serial` varchar(32) DEFAULT NULL,
  `created_by` varchar(32) DEFAULT NULL,
  `contact_details` text DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0',
  `deleted` enum('0','1') DEFAULT '0',
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `user_agent` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `events_halls_configuration`
--

CREATE TABLE `events_halls_configuration` (
  `event_id` int(11) NOT NULL,
  `event_guid` varchar(32) DEFAULT NULL,
  `configuration` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('0','1') NOT NULL DEFAULT '0',
  `deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `halls`
--

INSERT INTO `halls` (`id`, `client_guid`, `hall_guid`, `rows`, `columns`, `seats`, `hall_name`, `created_by`, `configuration`, `facilities`, `created_on`, `status`, `deleted`) VALUES
(1, '244444', 'kZyXxACRUgbdaVu2tH9qro01EfhY6LSm', '10', '9', 55, 'that is the test hall', '11111', '{\"blocked\":[],\"removed\":[\"1_1\",\"1_2\",\"1_3\",\"1_4\",\"1_6\",\"1_7\",\"1_8\",\"1_9\",\"2_1\",\"2_2\",\"2_3\",\"2_7\",\"2_8\",\"2_9\",\"3_1\",\"3_2\",\"3_8\",\"3_9\",\"4_1\",\"4_9\",\"5_2\",\"5_3\",\"5_4\",\"5_5\",\"5_6\",\"5_7\",\"5_8\",\"6_5\",\"7_5\",\"8_5\",\"9_4\",\"9_5\",\"9_6\",\"10_1\",\"10_9\"],\"labels\":{\"1_5\":\"A1\",\"2_4\":\"A2\",\"2_5\":\"A3\",\"2_6\":\"A4\",\"3_3\":\"A5\",\"3_4\":\"A6\",\"3_5\":\"A7\",\"3_6\":\"A8\",\"3_7\":\"A9\",\"4_2\":\"B1\",\"4_3\":\"B2\",\"4_4\":\"B3\",\"4_5\":\"B4\",\"4_6\":\"B5\",\"4_7\":\"B6\",\"4_8\":\"B7\",\"5_1\":\"B8\",\"5_9\":\"B9\",\"6_1\":\"C1\",\"6_2\":\"C2\",\"6_3\":\"C3\",\"6_4\":\"C4\",\"6_6\":\"C5\",\"6_7\":\"C6\",\"6_8\":\"C7\",\"6_9\":\"C8\",\"7_1\":\"D1\",\"7_2\":\"D2\",\"7_3\":\"D3\",\"7_4\":\"D4\",\"7_6\":\"D5\",\"7_7\":\"D6\",\"7_8\":\"D7\",\"7_9\":\"D8\",\"8_1\":\"D9\",\"8_2\":\"D10\",\"8_3\":\"D11\",\"8_4\":\"D12\",\"8_6\":\"D13\",\"8_7\":\"D14\",\"8_8\":\"D15\",\"8_9\":\"D16\",\"9_1\":\"D17\",\"9_2\":\"D18\",\"9_3\":\"D19\",\"9_7\":\"D20\",\"9_8\":\"D21\",\"9_9\":\"D22\",\"10_2\":\"E1\",\"10_3\":\"E2\",\"10_4\":\"E3\",\"10_5\":\"E4\",\"10_6\":\"E5\",\"10_7\":\"E6\",\"10_8\":\"E7\"}}', 'This hall has a lot of facilities that we are very much interest in. I am hoping that it will be a great service to all of us', '2020-07-01 21:41:07', '1', '0'),
(2, '244444', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '11', '8', 78, 'Second Hall to Insert', '11111', '{\"blocked\":[],\"removed\":[],\"labels\":{\"1_1\":1,\"1_2\":2,\"1_3\":3,\"1_4\":4,\"1_5\":5,\"1_6\":6,\"1_7\":7,\"1_8\":8,\"2_1\":9,\"2_2\":10,\"2_3\":11,\"2_4\":12,\"2_5\":13,\"2_6\":14,\"2_7\":15,\"2_8\":16,\"3_1\":17,\"3_2\":18,\"3_3\":19,\"3_4\":20,\"3_5\":21,\"3_6\":22,\"3_7\":23,\"3_8\":24,\"4_1\":25,\"4_2\":26,\"4_3\":27,\"4_4\":28,\"4_5\":29,\"4_6\":30,\"4_7\":31,\"4_8\":32,\"5_1\":33,\"5_2\":34,\"5_3\":35,\"5_4\":36,\"5_5\":37,\"5_6\":38,\"5_7\":39,\"5_8\":40,\"6_1\":41,\"6_2\":42,\"6_3\":43,\"6_4\":44,\"6_5\":45,\"6_6\":46,\"6_7\":47,\"6_8\":48,\"7_1\":49,\"7_2\":50,\"7_3\":51,\"7_4\":52,\"7_5\":53,\"7_6\":54,\"7_7\":55,\"7_8\":56,\"8_1\":57,\"8_2\":58,\"8_3\":59,\"8_4\":60,\"8_5\":61,\"8_6\":62,\"8_7\":63,\"8_8\":64,\"9_1\":65,\"9_2\":66,\"9_3\":67,\"9_4\":68,\"9_5\":69,\"9_6\":70,\"9_7\":71,\"9_8\":72,\"10_1\":73,\"10_2\":74,\"10_3\":75,\"10_4\":76,\"10_5\":77,\"10_6\":78,\"10_7\":79,\"10_8\":80,\"11_1\":81,\"11_2\":82,\"11_3\":83,\"11_4\":84,\"11_5\":85,\"11_6\":86,\"11_7\":87,\"11_8\":88}}', '', '2020-07-01 21:44:12', '1', '0'),
(3, '244444', '1OV9ytXor7Qdu4lZc0Cqxhgk5WLTMesB', '7', '8', 46, 'Final Test No errors', '11111', '{\"blocked\":[\"1_1\",\"1_8\",\"4_4\",\"4_5\"],\"removed\":[\"7_4\",\"7_5\",\"1_1\",\"1_8\",\"6_1\",\"6_8\",\"6_3\",\"6_4\",\"6_5\",\"6_6\"],\"labels\":{\"1_2\":\"2\",\"1_3\":\"3\",\"1_4\":\"4\",\"1_5\":\"5\",\"1_6\":\"6\",\"1_7\":\"7\",\"2_1\":\"M9\",\"2_2\":\"10\",\"2_3\":\"11\",\"2_4\":\"12\",\"2_5\":\"13\",\"2_6\":\"M14\",\"2_7\":\"15\",\"2_8\":\"16\",\"3_1\":\"17\",\"3_2\":\"18\",\"3_3\":\"19\",\"3_4\":\"M20\",\"3_5\":\"21\",\"3_6\":\"M22\",\"3_7\":\"23\",\"3_8\":\"24\",\"4_1\":\"25\",\"4_2\":\"M26\",\"4_3\":\"27\",\"4_4\":\"\",\"4_5\":\"\",\"4_6\":\"30\",\"4_7\":\"M31\",\"4_8\":\"32\",\"5_1\":\"33\",\"5_2\":\"34\",\"5_3\":\"M35\",\"5_4\":\"36\",\"5_5\":\"37\",\"5_6\":\"M38\",\"5_7\":\"39\",\"5_8\":\"40\",\"6_2\":\"M42\",\"6_7\":\"47\",\"7_1\":\"49\",\"7_2\":\"50\",\"7_3\":\"51\",\"7_6\":\"54\",\"7_7\":\"55\",\"7_8\":\"56\"}}', 'This is the final test', '2020-07-01 21:45:18', '1', '0'),
(4, '244444', '0iHFD5QuyvdaeMsnWZSUYoNTqPCxGw1X', '3', '4', 12, 'Final Test', '11111', '{\"blocked\":[],\"removed\":[],\"labels\":{\"1_1\":1,\"1_2\":2,\"1_3\":3,\"1_4\":4,\"2_1\":5,\"2_2\":6,\"2_3\":7,\"2_4\":8,\"3_1\":9,\"3_2\":10,\"3_3\":11,\"3_4\":12}}', 'This is a final test for my halls', '2020-07-02 00:51:08', '1', '0'),
(5, '244444', 'CENwouk4yhHGXDfdixsgLrTlFtIp9jOq', '12', '12', 110, 'pre test', 'KidkkL949', '{\"blocked\":[],\"removed\":[\"1_1\",\"1_2\",\"1_11\",\"1_12\",\"2_4\",\"2_5\",\"2_6\",\"2_7\",\"2_8\",\"2_9\",\"4_6\",\"4_7\",\"6_3\",\"6_6\",\"6_7\",\"6_10\",\"7_6\",\"7_7\",\"8_6\",\"8_7\",\"9_1\",\"9_12\",\"10_1\",\"10_12\",\"11_1\",\"11_2\",\"11_11\",\"11_12\",\"12_1\",\"12_2\",\"12_3\",\"12_10\",\"12_11\",\"12_12\"],\"labels\":{\"1_3\":\"3\",\"1_4\":\"4\",\"1_5\":\"5\",\"1_6\":\"6\",\"1_7\":\"7\",\"1_8\":\"8\",\"1_9\":\"9\",\"1_10\":\"10\",\"2_1\":\"13\",\"2_2\":\"14\",\"2_3\":\"15\",\"2_10\":\"22\",\"2_11\":\"23\",\"2_12\":\"24\",\"3_1\":\"25\",\"3_2\":\"26\",\"3_3\":\"27\",\"3_4\":\"28\",\"3_5\":\"29\",\"3_6\":\"30\",\"3_7\":\"31\",\"3_8\":\"32\",\"3_9\":\"33\",\"3_10\":\"34\",\"3_11\":\"35\",\"3_12\":\"36\",\"4_1\":\"37\",\"4_2\":\"38\",\"4_3\":\"39\",\"4_4\":\"40\",\"4_5\":\"41\",\"4_8\":\"44\",\"4_9\":\"45\",\"4_10\":\"46\",\"4_11\":\"47\",\"4_12\":\"48\",\"5_1\":\"49\",\"5_2\":\"50\",\"5_3\":\"51\",\"5_4\":\"52\",\"5_5\":\"53\",\"5_6\":\"54\",\"5_7\":\"55\",\"5_8\":\"56\",\"5_9\":\"57\",\"5_10\":\"58\",\"5_11\":\"59\",\"5_12\":\"60\",\"6_1\":\"61\",\"6_2\":\"62\",\"6_4\":\"64\",\"6_5\":\"65\",\"6_8\":\"68\",\"6_9\":\"69\",\"6_11\":\"71\",\"6_12\":\"72\",\"7_1\":\"73\",\"7_2\":\"74\",\"7_3\":\"75\",\"7_4\":\"76\",\"7_5\":\"77\",\"7_8\":\"80\",\"7_9\":\"81\",\"7_10\":\"82\",\"7_11\":\"83\",\"7_12\":\"84\",\"8_1\":\"85\",\"8_2\":\"86\",\"8_3\":\"87\",\"8_4\":\"88\",\"8_5\":\"89\",\"8_8\":\"92\",\"8_9\":\"93\",\"8_10\":\"94\",\"8_11\":\"95\",\"8_12\":\"96\",\"9_2\":\"98\",\"9_3\":\"99\",\"9_4\":\"100\",\"9_5\":\"101\",\"9_6\":\"102\",\"9_7\":\"103\",\"9_8\":\"104\",\"9_9\":\"105\",\"9_10\":\"106\",\"9_11\":\"107\",\"10_2\":\"110\",\"10_3\":\"111\",\"10_4\":\"112\",\"10_5\":\"113\",\"10_6\":\"114\",\"10_7\":\"115\",\"10_8\":\"116\",\"10_9\":\"117\",\"10_10\":\"118\",\"10_11\":\"119\",\"11_3\":\"123\",\"11_4\":\"124\",\"11_5\":\"125\",\"11_6\":\"126\",\"11_7\":\"127\",\"11_8\":\"128\",\"11_9\":\"129\",\"11_10\":\"130\",\"12_4\":\"136\",\"12_5\":\"137\",\"12_6\":\"138\",\"12_7\":\"139\",\"12_8\":\"140\",\"12_9\":\"141\"}}', '', '2020-07-02 08:18:32', '0', '1'),
(6, '244444', 'pQSP594rEGjlzyVOtae6YiTqfuhxvg8I', '2', '3', 6, 'jhgjhgj', 'KidkkL949', '{\"blocked\":[],\"removed\":[],\"labels\":{\"1_1\":1,\"1_2\":2,\"1_3\":3,\"2_1\":4,\"2_2\":5,\"2_3\":6}}', '', '2020-07-02 09:07:00', '0', '1');

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
  `state` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `client_guid`, `ticket_guid`, `ticket_title`, `number_generated`, `number_sold`, `number_left`, `is_payable`, `ticket_amount`, `created_on`, `created_by`, `generated`, `activated`, `state`) VALUES
(1, '244444', 'lFUASkPm1ZhcnXJ0N8IWVY5uLyOdb97s', 'Dinner for the Event', 130, 0, 0, '0', 0.00, '2020-07-03 00:11:34', 'KidkkL949', 'yes', '1', '1'),
(2, '244444', '4qMcpyKvEuJh35OjzP8aNDdxIRW6kmSi', 'This is the test ticket', 10, 0, 0, '1', 0.00, '2020-07-03 00:27:32', 'KidkkL949', 'yes', '1', '1'),
(3, '244444', 'JjSLgXe3cBo0R7YxPHus5p2rk8d6ZFOV', 'test generated ticket', 1000, 0, 0, '1', 240.00, '2020-07-03 00:33:54', 'KidkkL949', 'yes', '1', '1'),
(4, '244444', '4oWil7hATQP2MzCSv5g3ncpENmf9euka', 'Generate 5000 tickets, Time Checker', 5000, 0, 0, '0', 0.00, '2020-07-03 00:38:29', 'KidkkL949', 'yes', '1', '1');

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
  `status` enum('pending','used','invalid') DEFAULT 'pending',
  `created_by` varchar(32) DEFAULT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(1, '244444', 'KidkkL949', 'Emmanuel Obeng', NULL, 'admin@mail.com', 'emmanuel', '$2y$10$9cJ2TrRa9djMO9dbMWKFiutl6jaR6z4xPfUoZFjb2ibWdEfU7IcPK', 1, '2', '1', '0', 'thaisakjfkalfd', '2020-07-02 22:20:01', '2020-07-01 07:02:30', '0438388388', '2020-07-01 07:02:30', NULL, 'assets/img/profiles/avatar.jpg');

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
  `client_key` varchar(500) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `activated` enum('0','1') DEFAULT '0',
  `subscription` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_accounts`
--

INSERT INTO `users_accounts` (`id`, `client_guid`, `client_key`, `name`, `email`, `phone`, `address`, `logo`, `date_created`, `activated`, `subscription`) VALUES
(1, '244444', NULL, 'Test Company', 'testmail@mail.com', '3939393993', 'test address', NULL, '2020-07-01 21:18:18', '0', '{\"halls_created\":4,\"halls\":10,\"users\":12,\"users_created\":1}');

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
(48, NULL, NULL, 'tickets', '4oWil7hATQP2MzCSv5g3ncpENmf9euka', '2020-07-03 00:38:29', 'Windows 10 | Chrome | ::1', 'Generated 5000 tickets for an Event.');

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
(8, '244444', 'KidkkL949', 'admin@mail.com', '2020-07-02 22:20:01', '::1', 'Chrome|Windows 10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.11');

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
(1, '244444', 'KidkkL949', '{\"permissions\":{\"halls\":{\"list\":\"1\",\"add\":\"1\",\"configure\":1,\"update\":\"1\",\"delete\":\"1\"},\"departments\":{\"list\":1,\"add\":1,\"update\":1,\"delete\":1}}}', '2020-07-02 09:03:11', NULL);

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events_booking`
--
ALTER TABLE `events_booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events_halls_configuration`
--
ALTER TABLE `events_halls_configuration`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `halls`
--
ALTER TABLE `halls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets_listing`
--
ALTER TABLE `tickets_listing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events_booking`
--
ALTER TABLE `events_booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events_halls_configuration`
--
ALTER TABLE `events_halls_configuration`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `halls`
--
ALTER TABLE `halls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tickets_listing`
--
ALTER TABLE `tickets_listing`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `users_email_list`
--
ALTER TABLE `users_email_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users_login_history`
--
ALTER TABLE `users_login_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
