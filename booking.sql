-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2020 at 03:44 AM
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

DROP TABLE IF EXISTS `alerts`;
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

DROP TABLE IF EXISTS `country`;
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

DROP TABLE IF EXISTS `departments`;
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
(4, '244444', 'Mez6F1RuHKA32ZvLWnNYPJ4qr7waIcCj', 'New Department Addition - Edited', '&lt;p&gt;Test new department adding.This department is doing grat here.&lt;/p&gt;&lt;p&gt;Thank you&lt;/p&gt;', '#d20f0f', '1');

-- --------------------------------------------------------

--
-- Table structure for table `emails`
--

DROP TABLE IF EXISTS `emails`;
CREATE TABLE `emails` (
  `id` int(11) NOT NULL,
  `client_guid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'The company sending the message',
  `email_guid` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_guid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'User in the company who sent the message',
  `sent_via` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `favourite` enum('0','1') COLLATE utf8_unicode_ci DEFAULT '0',
  `recipient` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `copy_to` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_sent` datetime DEFAULT NULL,
  `date_log` datetime DEFAULT current_timestamp(),
  `email_status` enum('Pending','Sent','Delivered','Failed','Draft') COLLATE utf8_unicode_ci DEFAULT 'Pending',
  `email_state` enum('inbox','trash','draft','sent') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'sent',
  `status` enum('0','1','2') COLLATE utf8_unicode_ci DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emails_attachments`
--

DROP TABLE IF EXISTS `emails_attachments`;
CREATE TABLE `emails_attachments` (
  `id` int(11) NOT NULL,
  `client_guid` varchar(32) DEFAULT NULL,
  `email_guid` varchar(32) DEFAULT NULL,
  `document_name` varchar(255) DEFAULT NULL,
  `document_link` varchar(255) DEFAULT NULL,
  `document_type` varchar(25) DEFAULT NULL,
  `document_size` varchar(25) DEFAULT NULL,
  `document_size_actual` varchar(25) DEFAULT NULL,
  `date_log` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
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

-- --------------------------------------------------------

--
-- Table structure for table `events_booking`
--

DROP TABLE IF EXISTS `events_booking`;
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

-- --------------------------------------------------------

--
-- Table structure for table `events_halls_configuration`
--

DROP TABLE IF EXISTS `events_halls_configuration`;
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

-- --------------------------------------------------------

--
-- Table structure for table `events_media`
--

DROP TABLE IF EXISTS `events_media`;
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
-- Table structure for table `halls`
--

DROP TABLE IF EXISTS `halls`;
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

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
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

DROP TABLE IF EXISTS `sms_purchases`;
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

-- --------------------------------------------------------

--
-- Table structure for table `sms_subscribers`
--

DROP TABLE IF EXISTS `sms_subscribers`;
CREATE TABLE `sms_subscribers` (
  `id` int(11) NOT NULL,
  `client_guid` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `sms_package` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `sms_units` int(11) NOT NULL DEFAULT 0,
  `sender_id` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'EvelynCRM'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
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

-- --------------------------------------------------------

--
-- Table structure for table `tickets_listing`
--

DROP TABLE IF EXISTS `tickets_listing`;
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

-- --------------------------------------------------------

--
-- Table structure for table `ticket_purchases`
--

DROP TABLE IF EXISTS `ticket_purchases`;
CREATE TABLE `ticket_purchases` (
  `id` int(11) NOT NULL,
  `ticket_id` varchar(32) DEFAULT NULL,
  `event_id` varchar(32) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `contact` varchar(64) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
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
  `deleted` enum('0','1') CHARACTER SET latin1 NOT NULL DEFAULT '0',
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

INSERT INTO `users` (`id`, `client_guid`, `user_guid`, `name`, `gender`, `email`, `username`, `password`, `access_level`, `theme`, `status`, `deleted`, `dashboard_settings`, `verify_token`, `last_login`, `last_login_attempts_time`, `contact`, `created_on`, `created_by`, `image`, `user_type`) VALUES
(1, '244444', 'KidkkL949', 'Demo User', 'Male', 'admin@mail.com', 'adminuser', '$2y$10$CsTd71XkkvbkgMwyZgyZ3.TtJ4LKj1yCQNkvswgbinVvD8JaJyJ/y', 1, '2', '1', '0', '{\"navbar\":\"visible\",\"theme\":\"light-theme\"}', NULL, '2020-10-23 02:05:49', '2020-07-16 22:13:54', '44444444444', '2020-07-16 22:13:54', NULL, 'assets/img/profiles/nj7PqWXzRAcQH8mVKOurb1TYF.png', 'holder'),
(2, '244444', 'KidkkL9491', 'Voucher User', 'Male', 'demouser@mail.com', 'demouser', '$2y$10$CsTd71XkkvbkgMwyZgyZ3.TtJ4LKj1yCQNkvswgbinVvD8JaJyJ/y', 1, '2', '1', '0', '{\"navbar\":\"\",\"theme\":\"light-theme\"}', NULL, '2020-07-17 09:43:44', '2020-07-16 22:13:54', '44444444444', '2020-07-16 22:13:54', NULL, 'assets/img/avatar.png', 'holder'),
(3, '244444', 'FW917546832', 'Emmanuel Obeng Hyde', NULL, 'moderator@mail.com', 'moderator', '$2y$10$Q/MWA6VjnrmAHI3ZVPPi.O.2clgVSw6EvXeeRrn3t5VZAKp7ETBRa', 2, '2', '1', '0', '{\"navbar\":\"\",\"theme\":\"light-theme\"}', NULL, '2020-07-17 10:04:42', '2020-07-17 10:00:37', '334343434343', '2020-07-17 10:00:37', 'KidkkL9491', 'assets/img/avatar.png', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `users_access_levels`
--

DROP TABLE IF EXISTS `users_access_levels`;
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

DROP TABLE IF EXISTS `users_accounts`;
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
(1, '244444', 'kdm', NULL, 'Kwesi Dickson Memorial Methodist Society -', 'testmailer@mail.com', 'mail.supremecluster.com', 'tRandom29', '0550107770', 'test address', 'Accra City', 13, 'assets/img/meth_logo.jpg', '2020-07-01 21:18:18', '0', '{\"halls_created\":5,\"halls\":10,\"users\":12,\"users_created\":3,\"account_type\":\"basic\",\"expiry_date\":\"2021-01-01\"}', '1');

-- --------------------------------------------------------

--
-- Table structure for table `users_activity_logs`
--

DROP TABLE IF EXISTS `users_activity_logs`;
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

-- --------------------------------------------------------

--
-- Table structure for table `users_data_monitoring`
--

DROP TABLE IF EXISTS `users_data_monitoring`;
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

DROP TABLE IF EXISTS `users_email_list`;
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
(1, '244444', 'recovery', 'KidkkL949', '{\"recipients_list\":[{\"fullname\":\"Emmanuel Obeng\",\"email\":\"admin@mail.com\",\"customer_id\":\"KidkkL949\"}]}', '2020-07-02 08:24:57', '0', '[BookingLog] Change Password', 'Hi Emmanuel Obeng<br>You have requested to reset your password at BookingLog<br><br>Before you can reset your password please follow this link.<br><br><a class=\"alert alert-success\" href=\"http://localhost/booking/verify?password&token=q7FMh7moPzkLBiYud18cfdi6UF5RktJNTASgZUALDwHMqvOQpjBCwuhN8a6ExEXG5W1t\">Click Here to Reset Password</a><br><br>If it does not work please copy this link and place it in your browser url.<br><br>http://localhost/booking/verify?password&token=q7FMh7moPzkLBiYud18cfdi6UF5RktJNTASgZUALDwHMqvOQpjBCwuhN8a6ExEXG5W1t', 'KidkkL949', '0', NULL),
(2, '244444', 'recovery', 'FW651874392', '{\"recipients_list\":[{\"fullname\":\"testuser name\",\"email\":\"testusername@mail.com\",\"customer_id\":\"FW651874392\"}]}', '2020-07-16 21:56:10', '0', '[BookingLog] Change Password', 'Hi testuser name<br>You have successfully changed your password at BookingLog<br><br>Do ignore this message if your rightfully effected this change.<br><br>If not, do <a class=\"alert alert-success\" href=\"http://localhost/booking/recover\">Click Here</a> if you did not perform this act.', 'FW651874392', '0', NULL),
(3, '244444', 'ticket', 'DZ000072', '{\"recipients_list\":[{\"fullname\":\"Frank Obeng\",\"email\":\"emmallob14@gmail.com\",\"contact\":\"0550107770\"}]}', '2020-08-11 10:29:05', '0', 'Event: Ticket Based Event Ticket', 'Hi Frank Obeng, <br>Your Serial Number for the Event: Ticket Based Event \r\n            scheduled on 2020-07-31 is DZ000072. Thank you.', 'KidkkL949', '0', NULL),
(4, '244444', 'ticket', 'DZ000073', '{\"recipients_list\":[{\"fullname\":\"Grace Obeng Hyde\",\"email\":\"graciellaob@gmail.com\",\"contact\":\"0240553604\"}]}', '2020-08-11 10:33:52', '0', 'Event: Ticket Based Event Ticket', 'Hi Grace Obeng Hyde, <br>Your Serial Number for the Event: Ticket Based Event \r\n            scheduled on 2020-07-31 is DZ000073. Thank you.', 'KidkkL949', '0', NULL),
(5, '244444', 'ticket', 'DZ000032', '{\"recipients_list\":[{\"fullname\":\"George Asamoah\",\"email\":\"georgeasamoah@mail.com\",\"contact\":\"0203317732\"}]}', '2020-08-11 10:34:31', '0', 'Event: Ticket Based Event Ticket', 'Hi George Asamoah, <br>Your Serial Number for the Event: Ticket Based Event \r\n            scheduled on 2020-07-31 is DZ000032. Thank you.', 'KidkkL949', '0', NULL),
(6, '244444', 'ticket', 'DZ000009', '{\"recipients_list\":[{\"fullname\":\"Last Tester\",\"email\":\"testmail@mail.com\",\"contact\":\"0302909890\"}]}', '2020-08-11 10:36:48', '0', 'Event: Ticket Based Event Ticket', 'Hi Last Tester, <br>Your Serial Number for the Event: Ticket Based Event \r\n            scheduled on 2020-07-31 is DZ000009. Thank you.', 'KidkkL949', '0', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_gender`
--

DROP TABLE IF EXISTS `users_gender`;
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

DROP TABLE IF EXISTS `users_login_history`;
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

-- --------------------------------------------------------

--
-- Table structure for table `users_reset_request`
--

DROP TABLE IF EXISTS `users_reset_request`;
CREATE TABLE `users_reset_request` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_guid` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_agent` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `token_status` enum('USED','EXPIRED','PENDING','ANNULED') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'PENDING',
  `request_token` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reset_date` datetime DEFAULT NULL,
  `reset_agent` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `request_date` datetime NOT NULL DEFAULT current_timestamp(),
  `expiry_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_roles`
--

DROP TABLE IF EXISTS `users_roles`;
CREATE TABLE `users_roles` (
  `id` int(11) NOT NULL,
  `client_guid` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_guid` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `permissions` varchar(5000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_logged` datetime NOT NULL DEFAULT current_timestamp(),
  `last_updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Indexes for table `emails`
--
ALTER TABLE `emails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emails_attachments`
--
ALTER TABLE `emails_attachments`
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
-- AUTO_INCREMENT for table `emails`
--
ALTER TABLE `emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emails_attachments`
--
ALTER TABLE `emails_attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events_media`
--
ALTER TABLE `events_media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `halls`
--
ALTER TABLE `halls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sms_purchases`
--
ALTER TABLE `sms_purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sms_subscribers`
--
ALTER TABLE `sms_subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tickets_listing`
--
ALTER TABLE `tickets_listing`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_purchases`
--
ALTER TABLE `ticket_purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_data_monitoring`
--
ALTER TABLE `users_data_monitoring`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_email_list`
--
ALTER TABLE `users_email_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users_gender`
--
ALTER TABLE `users_gender`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users_login_history`
--
ALTER TABLE `users_login_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_reset_request`
--
ALTER TABLE `users_reset_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_roles`
--
ALTER TABLE `users_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
