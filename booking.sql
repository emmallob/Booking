-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2020 at 09:31 AM
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
-- Table structure for table `email_list`
--

DROP TABLE IF EXISTS `email_list`;
CREATE TABLE `email_list` (
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
-- Dumping data for table `email_list`
--

INSERT INTO `email_list` (`id`, `client_guid`, `template_type`, `item_guid`, `recipients_list`, `date_requested`, `sent_status`, `subject`, `message`, `request_performed_by`, `deleted`, `date_sent`) VALUES
(1, '244444', 'general', 'FW651874392', '{\"recipients_list\":[{\"fullname\":\"testuser name\",\"email\":\"testusername@mail.com\",\"customer_id\":\"FW651874392\"}]}', '2020-07-16 21:22:01', '0', 'Account Setup \\[BookingLog\\]\n', 'Hello testuser name,\nYou have been added as a user on <strong>Kwesi Dickson Memorial Methodist Society</strong> to help manage the Account.\n\nYour username to be used for login is <strong>testusername</strong>\nYou can use your previous password to continue to login.\nPlease <a href=\'http://localhost/booking/verify/account?token=Uq6zTIrIweB7A5sByw18YOov3y8UJWha2JVFVS4Dkh4bMRiK2DxP0QNunbGZdL0YmpRGltzE3f\'><strong>Click Here</strong></a> to verify your Email Address.\n\n', 'KidkkL949', '0', NULL),
(2, '244444', 'recovery', 'KidkkL949', '{\"recipients_list\":[{\"fullname\":\"Demo User\",\"email\":\"admin@mail.com\",\"customer_id\":\"KidkkL949\"}]}', '2020-07-16 22:17:18', '0', '[BookingLog] Change Password', 'Hi Demo User<br>You have requested to reset your password at BookingLog<br><br>Before you can reset your password please follow this link.<br><br><a class=\"alert alert-success\" href=\"http://localhost/booking/verify?password&token=y9tLxbw1OUD2Z8ck05KWNRvjo3hgpABGsMrqfIuJQneFl4V7ETXYadC6Pizm\">Click Here to Reset Password</a><br><br>If it does not work please copy this link and place it in your browser url.<br><br>http://localhost/booking/verify?password&token=y9tLxbw1OUD2Z8ck05KWNRvjo3hgpABGsMrqfIuJQneFl4V7ETXYadC6Pizm', 'KidkkL949', '0', NULL),
(3, '244444', 'recovery', 'KidkkL949', '{\"recipients_list\":[{\"fullname\":\"Demo User\",\"email\":\"admin@mail.com\",\"customer_id\":\"KidkkL949\"}]}', '2020-07-16 22:17:53', '0', '[BookingLog] Change Password', 'Hi Demo User<br>You have successfully changed your password at BookingLog<br><br>Do ignore this message if your rightfully effected this change.<br><br>If not, do <a class=\"alert alert-success\" href=\"http://localhost/booking/recover\">Click Here</a> if you did not perform this act.', 'KidkkL949', '0', NULL),
(4, '244444', 'general', 'FW917546832', '{\"recipients_list\":[{\"fullname\":\"afdadafdaf\",\"email\":\"admin@mail.com\",\"customer_id\":\"FW917546832\"}]}', '2020-07-17 10:00:37', '0', 'Account Setup \\[BookingLog\\]\n', 'Hello afdadafdaf,\nYou have been added as a user on <strong>Kwesi Dickson Memorial Methodist Society</strong> to help manage the Account.\n\nYour username to be used for login is <strong>admin</strong>\nYou can use your previous password to continue to login.\nPlease <a href=\'http://localhost/booking/verify/account?token=TFK6pw2NGeoJA3J7dxh8LrMWzsOVZfbHV8USNRv29ZYcMSFXt0qKRloxsaAEDTOuP0uY1\'><strong>Click Here</strong></a> to verify your Email Address.\n\n', 'KidkkL9491', '0', NULL),
(5, '244444', 'recovery', 'FW917546832', '{\"recipients_list\":[{\"fullname\":\"afdadafdaf\",\"email\":\"moderator@mail.com\",\"customer_id\":\"FW917546832\"}]}', '2020-07-17 10:04:29', '0', '[BookingLog] Change Password', 'Hi afdadafdaf<br>You have successfully changed your password at BookingLog<br><br>Do ignore this message if your rightfully effected this change.<br><br>If not, do <a class=\"alert alert-success\" href=\"http://localhost/booking/recover\">Click Here</a> if you did not perform this act.', 'FW917546832', '0', NULL),
(12, '244444', 'ticket', 'DZ000046', '{\"recipients_list\":[{\"fullname\":\"Emmanuella Darko\",\"email\":\"jauntybae@gmail.com\",\"contact\":\"04849940049\"}]}', '2020-07-29 07:04:20', '0', 'Event: Ticket Based Event Ticket', 'Hi Emmanuella Darko, <br>Your Serial Number for the Event: Ticket Based Event \r\n            scheduled on 2020-07-31 is DZ000046. Thank you.', 'KidkkL949', '0', NULL),
(13, '244444', 'ticket', 'DZ000019', '{\"recipients_list\":[{\"fullname\":\"Emmanuel Obeng\",\"email\":\"emmallob14@gmail.com\",\"contact\":\"0550107770\"}]}', '2020-07-29 07:06:12', '0', 'Event: Ticket Based Event Ticket', 'Hi Emmanuel Obeng, <br>Your Serial Number for the Event: Ticket Based Event \r\n            scheduled on 2020-07-31 is DZ000019. Thank you.', 'KidkkL949', '0', NULL),
(14, '244444', 'ticket', 'DZ000008', '{\"recipients_list\":[{\"fullname\":\"Name of Person\",\"email\":\"nameofperson@mail.com\",\"contact\":\"0203317732\"}]}', '2020-07-29 07:07:54', '0', 'Event: Ticket Based Event Ticket', 'Hi Name of Person, <br>Your Serial Number for the Event: Ticket Based Event \r\n            scheduled on 2020-07-31 is DZ000008. Thank you.', 'KidkkL949', '0', NULL);

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

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `client_guid`, `event_guid`, `event_title`, `event_slug`, `halls_guid`, `event_date`, `start_time`, `end_time`, `booking_start_time`, `booking_end_time`, `is_payable`, `department_guid`, `allow_multiple_booking`, `maximum_multiple_booking`, `description`, `ticket_guid`, `state`, `created_on`, `created_by`, `deleted`) VALUES
(1, '244444', 'TKOzIsL1nP25Xk3pHcJChfYBrmGoE0gR', 'Test Event with longer name to list in there', 'test-event', 'jsN64gp3daOnXiLSyzAEK0VuQ1qDbI5x,Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '2020-07-12', '07:00', '20:24', '2020-07-07 19:25:00', '2020-07-11 22:30:00', '0', 'Mez6F1RuHKA32ZvLWnNYPJ4qr7waIcCj', '1', 3, 'This is the event description', NULL, 'past', '2020-07-07 19:31:47', 'KidkkL949', '0'),
(2, '244444', 'yo5xv0MFGRI6LdEjzNY7Xr4fkJ8K1m3W', 'Ticket Based Event', 'ticket-based-event', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M,1OV9ytXor7Qdu4lZc0Cqxhgk5WLTMesB', '2020-07-31', '17:00', '20:00', '2020-07-15 04:00:00', '2020-07-31 04:41:00', '1', 'Ujs3IObGKPlEua59nexZ1LXtmqv2B7dy', '0', 1, 'This is the event to book, i am trusting that it will be as i want it to be', 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'in-progress', '2020-07-15 04:42:19', 'KidkkL949', '0'),
(3, '244444', 'EWHJfZYme3w4FLyBjp6richQxd7b9D1k', 'Test Event With Attachment', 'test-event-with-attachment', 'kZyXxACRUgbdaVu2tH9qro01EfhY6LSm,1OV9ytXor7Qdu4lZc0Cqxhgk5WLTMesB,CENwouk4yhHGXDfdixsgLrTlFtIp9jOq', '2020-07-26', '12:08', '14:08', '2020-07-17 13:55:00', '2020-07-25 12:08:00', '0', 'Mez6F1RuHKA32ZvLWnNYPJ4qr7waIcCj', '0', 1, 'This event has an attachment', 'null', 'in-progress', '2020-07-17 12:08:42', 'KidkkL949', '0');

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

--
-- Dumping data for table `events_booking`
--

INSERT INTO `events_booking` (`id`, `client_guid`, `event_guid`, `hall_guid`, `seat_guid`, `seat_name`, `ticket_guid`, `ticket_serial`, `booked_by`, `fullname`, `created_by`, `address`, `status`, `deleted`, `created_on`, `user_agent`) VALUES
(2, '244444', 'TKOzIsL1nP25Xk3pHcJChfYBrmGoE0gR', 'jsN64gp3daOnXiLSyzAEK0VuQ1qDbI5x', '6_3', '6_3', NULL, NULL, NULL, 'Emmanuel Obeng', '0550107770', 'Dodowa, Accra', '1', '0', '2020-07-07 19:39:27', 'Windows 10|Chrome'),
(3, '244444', 'TKOzIsL1nP25Xk3pHcJChfYBrmGoE0gR', 'jsN64gp3daOnXiLSyzAEK0VuQ1qDbI5x', '6_9', '6_9', NULL, NULL, NULL, 'Grace Obeng', '0240553604', 'Shiashie, Accra', '0', '0', '2020-07-07 19:39:28', 'Windows 10|Chrome'),
(4, '244444', 'TKOzIsL1nP25Xk3pHcJChfYBrmGoE0gR', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '7_2', '50', NULL, NULL, NULL, 'Emmanuel Obeng', '0550107770', 'The Address of my place.', '0', '1', '2020-07-07 20:07:32', 'Windows 10|Chrome'),
(5, '244444', 'TKOzIsL1nP25Xk3pHcJChfYBrmGoE0gR', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '4_5', '4_5', NULL, NULL, NULL, 'That is my name', '0550107770', 'thatnk ', '1', '0', '2020-07-07 20:08:22', 'Windows 10|Chrome'),
(6, '244444', 'TKOzIsL1nP25Xk3pHcJChfYBrmGoE0gR', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '62', '62', NULL, NULL, '0240553604', 'Emmanuella Darko', '0240553604', 'House Address', '0', '0', '2020-07-07 22:32:50', 'Windows 10|Chrome'),
(7, '244444', 'yo5xv0MFGRI6LdEjzNY7Xr4fkJ8K1m3W', '1OV9ytXor7Qdu4lZc0Cqxhgk5WLTMesB', '6_7', '47', 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000003', '0550107771', 'Frank Amoah', '0540394930', 'Accra, Ghana', '1', '0', '2020-07-15 05:50:19', 'Windows 10|Chrome'),
(8, '244444', 'yo5xv0MFGRI6LdEjzNY7Xr4fkJ8K1m3W', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '3_4', '20', 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000004', '0550107771', 'Frank Amoah', '0550107771', 'Accra Ghana', '1', '0', '2020-07-15 06:08:03', 'Windows 10|Chrome'),
(9, '244444', 'yo5xv0MFGRI6LdEjzNY7Xr4fkJ8K1m3W', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '6_4', '44', 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000007', '0550107770', 'Frank Amoah', '0550107770', 'The House Address ', '1', '0', '2020-07-17 12:23:23', 'Windows 10|Chrome'),
(10, '244444', 'yo5xv0MFGRI6LdEjzNY7Xr4fkJ8K1m3W', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '7_1', '49', 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000014', '0240770100', 'Frank Amoah', '0240770100', 'Analitica Innovare No 5 Wu-Biibi Lane, Ritz Junction, Madina Accra', '1', '0', '2020-07-17 12:30:33', 'Windows 10|Chrome'),
(11, '244444', 'yo5xv0MFGRI6LdEjzNY7Xr4fkJ8K1m3W', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '1_5', '5', 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'DZ000017', '0550107000', 'Simon Kortey', '0550107000', 'Analitica Innovare No 5 Wu-Biibi Lane, Ritz Junction, Madina Accra', '1', '0', '2020-07-17 12:44:12', 'Windows 10|Chrome'),
(12, '244444', 'EWHJfZYme3w4FLyBjp6richQxd7b9D1k', 'kZyXxACRUgbdaVu2tH9qro01EfhY6LSm', '6_6', 'C5', NULL, NULL, '0550107000', 'Frank Solomons', '0550107000', 'Reserve Seat Here', '1', '0', '2020-07-18 16:36:06', 'Windows 10|Chrome');

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

--
-- Dumping data for table `events_halls_configuration`
--

INSERT INTO `events_halls_configuration` (`id`, `event_guid`, `hall_guid`, `hall_name`, `rows`, `columns`, `configuration`, `commenced`) VALUES
(1, 'TKOzIsL1nP25Xk3pHcJChfYBrmGoE0gR', 'jsN64gp3daOnXiLSyzAEK0VuQ1qDbI5x', 'Main Hall', '7', '11', '{\"blocked\":[\"4_5\",\"4_6\",\"4_7\",\"6_3\",\"6_9\"],\"removed\":{\"0\":\"1_1\",\"1\":\"1_2\",\"2\":\"1_10\",\"3\":\"1_11\",\"4\":\"6_1\",\"5\":\"6_2\",\"6\":\"6_10\",\"7\":\"6_11\",\"8\":\"7_4\",\"9\":\"7_5\",\"10\":\"7_6\",\"11\":\"7_7\",\"12\":\"7_8\",\"26\":\"3_3\",\"27\":\"3_4\",\"28\":\"3_8\",\"29\":\"3_9\"},\"labels\":{\"1_3\":\"M3\",\"1_4\":\"M4\",\"1_5\":\"M5\",\"1_6\":\"M6\",\"1_7\":\"M7\",\"1_8\":\"M8\",\"1_9\":\"M9\",\"2_1\":\"M22\",\"2_2\":\"M21\",\"2_3\":\"M20\",\"2_4\":\"M19\",\"2_5\":\"M18\",\"2_6\":\"M17\",\"2_7\":\"M16\",\"2_8\":\"M15\",\"2_9\":\"M14\",\"2_10\":\"M13\",\"2_11\":\"M12\",\"3_1\":\"R23\",\"3_2\":\"M24\",\"3_5\":\"M27\",\"3_6\":\"M28\",\"3_7\":\"M29\",\"3_10\":\"M32\",\"3_11\":\"M33\",\"4_1\":\"R44\",\"4_2\":\"M43\",\"4_3\":\"M42\",\"4_4\":\"M41\",\"4_5\":\"M40\",\"4_6\":\"M39\",\"4_7\":\"M38\",\"4_8\":\"M37\",\"4_9\":\"M36\",\"4_10\":\"M35\",\"4_11\":\"M34\",\"5_1\":\"R45\",\"5_2\":\"M46\",\"5_3\":\"M47\",\"5_4\":\"M48\",\"5_5\":\"M49\",\"5_6\":\"M50\",\"5_7\":\"M51\",\"5_8\":\"M52\",\"5_9\":\"M53\",\"5_10\":\"M54\",\"5_11\":\"M55\",\"6_4\":\"M59\",\"6_5\":\"M60\",\"6_6\":\"M61\",\"6_7\":\"M62\",\"6_8\":\"M63\",\"7_1\":\"R67\",\"7_2\":\"M68\",\"7_3\":\"M69\",\"7_9\":\"M75\",\"7_10\":\"M76\",\"7_11\":\"R77\"}}', '1'),
(2, 'TKOzIsL1nP25Xk3pHcJChfYBrmGoE0gR', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', 'Second Hall to Insert', '11', '8', '{\"blocked\":{\"0\":\"4_2\",\"1\":\"4_7\",\"2\":\"2_1\",\"3\":\"2_8\",\"4\":\"10_2\",\"5\":\"10_3\",\"6\":\"10_6\",\"7\":\"10_7\",\"8\":\"6_2\",\"9\":\"6_7\",\"10\":\"7_4\",\"11\":\"7_5\",\"12\":\"9_1\",\"13\":\"9_8\",\"15\":\"4_5\",\"16\":\"8_6\"},\"removed\":[\"8_2\",\"8_4\",\"8_5\",\"8_7\",\"5_4\",\"5_5\",\"2_4\",\"2_5\",\"11_4\",\"11_5\",\"11_1\",\"11_8\",\"10_4\",\"10_5\"],\"labels\":{\"1_1\":\"1\",\"1_2\":\"2\",\"1_3\":\"3\",\"1_4\":\"4\",\"1_5\":\"5\",\"1_6\":\"6\",\"1_7\":\"7\",\"1_8\":\"8\",\"2_1\":\"9\",\"2_2\":\"10\",\"2_3\":\"11\",\"2_6\":\"14\",\"2_7\":\"15\",\"2_8\":\"16\",\"3_1\":\"17\",\"3_2\":\"18\",\"3_3\":\"19\",\"3_4\":\"20\",\"3_5\":\"21\",\"3_6\":\"22\",\"3_7\":\"23\",\"3_8\":\"24\",\"4_1\":\"25\",\"4_2\":\"26\",\"4_3\":\"27\",\"4_4\":\"28\",\"4_6\":\"30\",\"4_7\":\"31\",\"4_8\":\"32\",\"5_1\":\"33\",\"5_2\":\"34\",\"5_3\":\"35\",\"5_6\":\"38\",\"5_7\":\"39\",\"5_8\":\"40\",\"6_1\":\"41\",\"6_2\":\"42\",\"6_3\":\"43\",\"6_4\":\"44\",\"6_5\":\"45\",\"6_6\":\"46\",\"6_7\":\"47\",\"6_8\":\"48\",\"7_1\":\"49\",\"7_3\":\"51\",\"7_4\":\"52\",\"7_5\":\"53\",\"7_6\":\"54\",\"7_7\":\"55\",\"7_8\":\"56\",\"8_1\":\"57\",\"8_3\":\"59\",\"8_8\":\"64\",\"9_1\":\"65\",\"9_2\":\"66\",\"9_3\":\"67\",\"9_4\":\"68\",\"9_5\":\"69\",\"9_6\":\"70\",\"9_7\":\"71\",\"9_8\":\"72\",\"10_1\":\"73\",\"10_2\":\"74\",\"10_3\":\"75\",\"10_6\":\"78\",\"10_7\":\"79\",\"10_8\":\"80\",\"11_2\":\"82\",\"11_3\":\"83\",\"11_6\":\"86\",\"11_7\":\"87\",\"7_2\":\"50\"}}', '1'),
(17, '', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', 'Second Hall to Insert', '', '', '{\"blocked\":[\"4_2\",\"4_7\",\"2_1\",\"2_8\",\"10_2\",\"10_3\",\"10_6\",\"10_7\",\"6_2\",\"6_7\",\"7_4\",\"7_5\",\"9_1\",\"9_8\"],\"removed\":[\"8_2\",\"8_4\",\"8_5\",\"8_7\",\"5_4\",\"5_5\",\"2_4\",\"2_5\",\"11_4\",\"11_5\",\"11_1\",\"11_8\",\"10_4\",\"10_5\"],\"labels\":{\"1_1\":\"1\",\"1_2\":\"2\",\"1_3\":\"3\",\"1_4\":\"4\",\"1_5\":\"5\",\"1_6\":\"6\",\"1_7\":\"7\",\"1_8\":\"8\",\"2_1\":\"9\",\"2_2\":\"10\",\"2_3\":\"11\",\"2_6\":\"14\",\"2_7\":\"15\",\"2_8\":\"16\",\"3_1\":\"17\",\"3_2\":\"18\",\"3_3\":\"19\",\"3_4\":\"20\",\"3_5\":\"21\",\"3_6\":\"22\",\"3_7\":\"23\",\"3_8\":\"24\",\"4_1\":\"25\",\"4_2\":\"26\",\"4_3\":\"27\",\"4_4\":\"28\",\"4_5\":\"29\",\"4_6\":\"30\",\"4_7\":\"31\",\"4_8\":\"32\",\"5_1\":\"33\",\"5_2\":\"34\",\"5_3\":\"35\",\"5_6\":\"38\",\"5_7\":\"39\",\"5_8\":\"40\",\"6_1\":\"41\",\"6_2\":\"42\",\"6_3\":\"43\",\"6_4\":\"44\",\"6_5\":\"45\",\"6_6\":\"46\",\"6_7\":\"47\",\"6_8\":\"48\",\"7_1\":\"49\",\"7_2\":\"50\",\"7_3\":\"51\",\"7_4\":\"52\",\"7_5\":\"53\",\"7_6\":\"54\",\"7_7\":\"55\",\"7_8\":\"56\",\"8_1\":\"57\",\"8_3\":\"59\",\"8_6\":\"62\",\"8_8\":\"64\",\"9_1\":\"65\",\"9_2\":\"66\",\"9_3\":\"67\",\"9_4\":\"68\",\"9_5\":\"69\",\"9_6\":\"70\",\"9_7\":\"71\",\"9_8\":\"72\",\"10_1\":\"73\",\"10_2\":\"74\",\"10_3\":\"75\",\"10_6\":\"78\",\"10_7\":\"79\",\"10_8\":\"80\",\"11_2\":\"82\",\"11_3\":\"83\",\"11_6\":\"86\",\"11_7\":\"87\"}}', '0'),
(18, '', '1OV9ytXor7Qdu4lZc0Cqxhgk5WLTMesB', 'Final Test No errors', '', '', '{\"blocked\":[\"1_1\",\"1_8\",\"4_4\",\"4_5\"],\"removed\":[\"7_4\",\"7_5\",\"1_1\",\"1_8\",\"6_1\",\"6_8\",\"6_3\",\"6_4\",\"6_5\",\"6_6\"],\"labels\":{\"1_2\":\"2\",\"1_3\":\"3\",\"1_4\":\"4\",\"1_5\":\"5\",\"1_6\":\"6\",\"1_7\":\"7\",\"2_1\":\"M9\",\"2_2\":\"10\",\"2_3\":\"11\",\"2_4\":\"12\",\"2_5\":\"13\",\"2_6\":\"M14\",\"2_7\":\"15\",\"2_8\":\"16\",\"3_1\":\"17\",\"3_2\":\"18\",\"3_3\":\"19\",\"3_4\":\"M20\",\"3_5\":\"21\",\"3_6\":\"M22\",\"3_7\":\"23\",\"3_8\":\"24\",\"4_1\":\"25\",\"4_2\":\"M26\",\"4_3\":\"27\",\"4_4\":\"\",\"4_5\":\"\",\"4_6\":\"30\",\"4_7\":\"M31\",\"4_8\":\"32\",\"5_1\":\"33\",\"5_2\":\"34\",\"5_3\":\"M35\",\"5_4\":\"36\",\"5_5\":\"37\",\"5_6\":\"M38\",\"5_7\":\"39\",\"5_8\":\"40\",\"6_2\":\"M42\",\"6_7\":\"47\",\"7_1\":\"49\",\"7_2\":\"50\",\"7_3\":\"51\",\"7_6\":\"54\",\"7_7\":\"55\",\"7_8\":\"56\"}}', '0'),
(19, 'yo5xv0MFGRI6LdEjzNY7Xr4fkJ8K1m3W', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', 'Second Hall to Insert', '11', '8', '{\"blocked\":[\"4_2\",\"4_7\",\"2_1\",\"2_8\",\"10_2\",\"10_3\",\"10_6\",\"10_7\",\"6_2\",\"6_7\",\"7_4\",\"7_5\",\"9_1\",\"9_8\",\"3_4\",\"6_4\",\"7_1\",\"1_5\"],\"removed\":[\"8_2\",\"8_4\",\"8_5\",\"8_7\",\"5_4\",\"5_5\",\"2_4\",\"2_5\",\"11_4\",\"11_5\",\"11_1\",\"11_8\",\"10_4\",\"10_5\"],\"labels\":{\"1_1\":\"1\",\"1_2\":\"2\",\"1_3\":\"3\",\"1_4\":\"4\",\"1_6\":\"6\",\"1_7\":\"7\",\"1_8\":\"8\",\"2_1\":\"9\",\"2_2\":\"10\",\"2_3\":\"11\",\"2_6\":\"14\",\"2_7\":\"15\",\"2_8\":\"16\",\"3_1\":\"17\",\"3_2\":\"18\",\"3_3\":\"19\",\"3_5\":\"21\",\"3_6\":\"22\",\"3_7\":\"23\",\"3_8\":\"24\",\"4_1\":\"25\",\"4_2\":\"26\",\"4_3\":\"27\",\"4_4\":\"28\",\"4_5\":\"29\",\"4_6\":\"30\",\"4_7\":\"31\",\"4_8\":\"32\",\"5_1\":\"33\",\"5_2\":\"34\",\"5_3\":\"35\",\"5_6\":\"38\",\"5_7\":\"39\",\"5_8\":\"40\",\"6_1\":\"41\",\"6_2\":\"42\",\"6_3\":\"43\",\"6_5\":\"45\",\"6_6\":\"46\",\"6_7\":\"47\",\"6_8\":\"48\",\"7_2\":\"50\",\"7_3\":\"51\",\"7_4\":\"52\",\"7_5\":\"53\",\"7_6\":\"54\",\"7_7\":\"55\",\"7_8\":\"56\",\"8_1\":\"57\",\"8_3\":\"59\",\"8_6\":\"62\",\"8_8\":\"64\",\"9_1\":\"65\",\"9_2\":\"66\",\"9_3\":\"67\",\"9_4\":\"68\",\"9_5\":\"69\",\"9_6\":\"70\",\"9_7\":\"71\",\"9_8\":\"72\",\"10_1\":\"73\",\"10_2\":\"74\",\"10_3\":\"75\",\"10_6\":\"78\",\"10_7\":\"79\",\"10_8\":\"80\",\"11_2\":\"82\",\"11_3\":\"83\",\"11_6\":\"86\",\"11_7\":\"87\"}}', '1'),
(20, 'yo5xv0MFGRI6LdEjzNY7Xr4fkJ8K1m3W', '1OV9ytXor7Qdu4lZc0Cqxhgk5WLTMesB', 'Final Test No errors', '7', '8', '{\"blocked\":[\"1_1\",\"1_8\",\"4_4\",\"4_5\",\"6_7\"],\"removed\":[\"7_4\",\"7_5\",\"1_1\",\"1_8\",\"6_1\",\"6_8\",\"6_3\",\"6_4\",\"6_5\",\"6_6\"],\"labels\":{\"1_2\":\"2\",\"1_3\":\"3\",\"1_4\":\"4\",\"1_5\":\"5\",\"1_6\":\"6\",\"1_7\":\"7\",\"2_1\":\"M9\",\"2_2\":\"10\",\"2_3\":\"11\",\"2_4\":\"12\",\"2_5\":\"13\",\"2_6\":\"M14\",\"2_7\":\"15\",\"2_8\":\"16\",\"3_1\":\"17\",\"3_2\":\"18\",\"3_3\":\"19\",\"3_4\":\"M20\",\"3_5\":\"21\",\"3_6\":\"M22\",\"3_7\":\"23\",\"3_8\":\"24\",\"4_1\":\"25\",\"4_2\":\"M26\",\"4_3\":\"27\",\"4_4\":\"\",\"4_5\":\"\",\"4_6\":\"30\",\"4_7\":\"M31\",\"4_8\":\"32\",\"5_1\":\"33\",\"5_2\":\"34\",\"5_3\":\"M35\",\"5_4\":\"36\",\"5_5\":\"37\",\"5_6\":\"M38\",\"5_7\":\"39\",\"5_8\":\"40\",\"6_2\":\"M42\",\"7_1\":\"49\",\"7_2\":\"50\",\"7_3\":\"51\",\"7_6\":\"54\",\"7_7\":\"55\",\"7_8\":\"56\"}}', '1'),
(46, 'EWHJfZYme3w4FLyBjp6richQxd7b9D1k', 'kZyXxACRUgbdaVu2tH9qro01EfhY6LSm', 'that is the test hall', '10', '9', '{\"blocked\":[\"6_6\"],\"removed\":[\"1_1\",\"1_2\",\"1_3\",\"1_4\",\"1_6\",\"1_7\",\"1_8\",\"1_9\",\"2_1\",\"2_2\",\"2_3\",\"2_7\",\"2_8\",\"2_9\",\"3_1\",\"3_2\",\"3_8\",\"3_9\",\"4_1\",\"4_9\",\"5_2\",\"5_3\",\"5_4\",\"5_5\",\"5_6\",\"5_7\",\"5_8\",\"6_5\",\"7_5\",\"8_5\",\"9_4\",\"9_5\",\"9_6\",\"10_1\",\"10_9\"],\"labels\":{\"1_5\":\"A1\",\"2_4\":\"A2\",\"2_5\":\"A3\",\"2_6\":\"A4\",\"3_3\":\"A5\",\"3_4\":\"A6\",\"3_5\":\"A7\",\"3_6\":\"A8\",\"3_7\":\"A9\",\"4_2\":\"B1\",\"4_3\":\"B2\",\"4_4\":\"B3\",\"4_5\":\"B4\",\"4_6\":\"B5\",\"4_7\":\"B6\",\"4_8\":\"B7\",\"5_1\":\"B8\",\"5_9\":\"B9\",\"6_1\":\"C1\",\"6_2\":\"C2\",\"6_3\":\"C3\",\"6_4\":\"C4\",\"6_7\":\"C6\",\"6_8\":\"C7\",\"6_9\":\"C8\",\"7_1\":\"D1\",\"7_2\":\"D2\",\"7_3\":\"D3\",\"7_4\":\"D4\",\"7_6\":\"D5\",\"7_7\":\"D6\",\"7_8\":\"D7\",\"7_9\":\"D8\",\"8_1\":\"D9\",\"8_2\":\"D10\",\"8_3\":\"D11\",\"8_4\":\"D12\",\"8_6\":\"D13\",\"8_7\":\"D14\",\"8_8\":\"D15\",\"8_9\":\"D16\",\"9_1\":\"D17\",\"9_2\":\"D18\",\"9_3\":\"D19\",\"9_7\":\"D20\",\"9_8\":\"D21\",\"9_9\":\"D22\",\"10_2\":\"E1\",\"10_3\":\"E2\",\"10_4\":\"E3\",\"10_5\":\"E4\",\"10_6\":\"E5\",\"10_7\":\"E6\",\"10_8\":\"E7\"}}', '1'),
(47, 'EWHJfZYme3w4FLyBjp6richQxd7b9D1k', '1OV9ytXor7Qdu4lZc0Cqxhgk5WLTMesB', 'Final Test No errors', '7', '8', '{\"blocked\":[\"1_1\",\"1_8\",\"4_4\",\"4_5\"],\"removed\":[\"7_4\",\"7_5\",\"1_1\",\"1_8\",\"6_1\",\"6_8\",\"6_3\",\"6_4\",\"6_5\",\"6_6\"],\"labels\":{\"1_2\":\"2\",\"1_3\":\"3\",\"1_4\":\"4\",\"1_5\":\"5\",\"1_6\":\"6\",\"1_7\":\"7\",\"2_1\":\"M9\",\"2_2\":\"10\",\"2_3\":\"11\",\"2_4\":\"12\",\"2_5\":\"13\",\"2_6\":\"M14\",\"2_7\":\"15\",\"2_8\":\"16\",\"3_1\":\"17\",\"3_2\":\"18\",\"3_3\":\"19\",\"3_4\":\"M20\",\"3_5\":\"21\",\"3_6\":\"M22\",\"3_7\":\"23\",\"3_8\":\"24\",\"4_1\":\"25\",\"4_2\":\"M26\",\"4_3\":\"27\",\"4_4\":\"\",\"4_5\":\"\",\"4_6\":\"30\",\"4_7\":\"M31\",\"4_8\":\"32\",\"5_1\":\"33\",\"5_2\":\"34\",\"5_3\":\"M35\",\"5_4\":\"36\",\"5_5\":\"37\",\"5_6\":\"M38\",\"5_7\":\"39\",\"5_8\":\"40\",\"6_2\":\"M42\",\"6_7\":\"47\",\"7_1\":\"49\",\"7_2\":\"50\",\"7_3\":\"51\",\"7_6\":\"54\",\"7_7\":\"55\",\"7_8\":\"56\"}}', '0'),
(48, 'EWHJfZYme3w4FLyBjp6richQxd7b9D1k', 'CENwouk4yhHGXDfdixsgLrTlFtIp9jOq', 'Craziest Hall With Seat', '12', '12', '{\"blocked\":[],\"removed\":[\"1_1\",\"1_2\",\"1_11\",\"1_12\",\"2_4\",\"2_5\",\"2_6\",\"2_7\",\"2_8\",\"2_9\",\"4_6\",\"4_7\",\"6_3\",\"6_6\",\"6_7\",\"6_10\",\"7_6\",\"7_7\",\"8_6\",\"8_7\",\"9_1\",\"9_12\",\"10_1\",\"10_12\",\"11_1\",\"11_2\",\"11_11\",\"11_12\",\"12_1\",\"12_2\",\"12_3\",\"12_10\",\"12_11\",\"12_12\"],\"labels\":{\"1_3\":\"3\",\"1_4\":\"4\",\"1_5\":\"5\",\"1_6\":\"6\",\"1_7\":\"7\",\"1_8\":\"8\",\"1_9\":\"9\",\"1_10\":\"10\",\"2_1\":\"13\",\"2_2\":\"14\",\"2_3\":\"15\",\"2_10\":\"22\",\"2_11\":\"23\",\"2_12\":\"24\",\"3_1\":\"25\",\"3_2\":\"26\",\"3_3\":\"27\",\"3_4\":\"28\",\"3_5\":\"29\",\"3_6\":\"30\",\"3_7\":\"31\",\"3_8\":\"32\",\"3_9\":\"33\",\"3_10\":\"34\",\"3_11\":\"35\",\"3_12\":\"36\",\"4_1\":\"37\",\"4_2\":\"38\",\"4_3\":\"39\",\"4_4\":\"40\",\"4_5\":\"41\",\"4_8\":\"44\",\"4_9\":\"45\",\"4_10\":\"46\",\"4_11\":\"47\",\"4_12\":\"48\",\"5_1\":\"49\",\"5_2\":\"50\",\"5_3\":\"51\",\"5_4\":\"52\",\"5_5\":\"53\",\"5_6\":\"54\",\"5_7\":\"55\",\"5_8\":\"56\",\"5_9\":\"57\",\"5_10\":\"58\",\"5_11\":\"59\",\"5_12\":\"60\",\"6_1\":\"61\",\"6_2\":\"62\",\"6_4\":\"64\",\"6_5\":\"65\",\"6_8\":\"68\",\"6_9\":\"69\",\"6_11\":\"71\",\"6_12\":\"72\",\"7_1\":\"73\",\"7_2\":\"74\",\"7_3\":\"75\",\"7_4\":\"76\",\"7_5\":\"77\",\"7_8\":\"80\",\"7_9\":\"81\",\"7_10\":\"82\",\"7_11\":\"83\",\"7_12\":\"84\",\"8_1\":\"85\",\"8_2\":\"86\",\"8_3\":\"87\",\"8_4\":\"88\",\"8_5\":\"89\",\"8_8\":\"92\",\"8_9\":\"93\",\"8_10\":\"94\",\"8_11\":\"95\",\"8_12\":\"96\",\"9_2\":\"98\",\"9_3\":\"99\",\"9_4\":\"100\",\"9_5\":\"101\",\"9_6\":\"102\",\"9_7\":\"103\",\"9_8\":\"104\",\"9_9\":\"105\",\"9_10\":\"106\",\"9_11\":\"107\",\"10_2\":\"110\",\"10_3\":\"111\",\"10_4\":\"112\",\"10_5\":\"113\",\"10_6\":\"114\",\"10_7\":\"115\",\"10_8\":\"116\",\"10_9\":\"117\",\"10_10\":\"118\",\"10_11\":\"119\",\"11_3\":\"123\",\"11_4\":\"124\",\"11_5\":\"125\",\"11_6\":\"126\",\"11_7\":\"127\",\"11_8\":\"128\",\"11_9\":\"129\",\"11_10\":\"130\",\"12_4\":\"136\",\"12_5\":\"137\",\"12_6\":\"138\",\"12_7\":\"139\",\"12_8\":\"140\",\"12_9\":\"141\"}}', '0');

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

--
-- Dumping data for table `events_media`
--

INSERT INTO `events_media` (`id`, `client_guid`, `event_guid`, `created_date`, `media_data`, `media_type`, `status`) VALUES
(1, '244444', 'EWHJfZYme3w4FLyBjp6richQxd7b9D1k', '2020-07-18 16:26:11', '{\"media\":\"assets\\/events\\/KhAo9w7p5CqSd0gZU3vOWBRk2.jpg\",\"type\":\"image\\/jpeg\",\"size\":23438,\"state\":\"uploaded\"}', 'image/jpeg', '0'),
(2, '244444', 'EWHJfZYme3w4FLyBjp6richQxd7b9D1k', '2020-07-18 16:26:29', '{\"media\":\"assets\\/events\\/ncOKYTSybQa9mgL6lXUp3keHd.jpeg\",\"type\":\"image\\/jpeg\",\"size\":75414,\"state\":\"uploaded\"}', 'image/jpeg', '1'),
(3, '244444', 'EWHJfZYme3w4FLyBjp6richQxd7b9D1k', '2020-07-18 16:26:40', '{\"media\":\"assets\\/events\\/aobsn9QCPd2JN1Gl7BjWVUXyL.mp4\",\"type\":\"video\\/mp4\",\"size\":946593,\"state\":\"uploaded\"}', 'video/mp4', '1'),
(4, '244444', 'EWHJfZYme3w4FLyBjp6richQxd7b9D1k', '2020-07-18 16:26:40', '{\"media\":\"assets\\/events\\/M6zoTL7gysIj8cX1Am0lnJYaC.mp4\",\"type\":\"video\\/mp4\",\"size\":955060,\"state\":\"uploaded\"}', 'video/mp4', '1');

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

--
-- Dumping data for table `halls`
--

INSERT INTO `halls` (`id`, `client_guid`, `hall_guid`, `rows`, `columns`, `seats`, `hall_name`, `created_by`, `configuration`, `facilities`, `overall_booking`, `created_on`, `status`, `deleted`) VALUES
(1, '244444', 'kZyXxACRUgbdaVu2tH9qro01EfhY6LSm', '10', '9', 55, 'that is the test hall', '11111', '{\"blocked\":[],\"removed\":[\"1_1\",\"1_2\",\"1_3\",\"1_4\",\"1_6\",\"1_7\",\"1_8\",\"1_9\",\"2_1\",\"2_2\",\"2_3\",\"2_7\",\"2_8\",\"2_9\",\"3_1\",\"3_2\",\"3_8\",\"3_9\",\"4_1\",\"4_9\",\"5_2\",\"5_3\",\"5_4\",\"5_5\",\"5_6\",\"5_7\",\"5_8\",\"6_5\",\"7_5\",\"8_5\",\"9_4\",\"9_5\",\"9_6\",\"10_1\",\"10_9\"],\"labels\":{\"1_5\":\"A1\",\"2_4\":\"A2\",\"2_5\":\"A3\",\"2_6\":\"A4\",\"3_3\":\"A5\",\"3_4\":\"A6\",\"3_5\":\"A7\",\"3_6\":\"A8\",\"3_7\":\"A9\",\"4_2\":\"B1\",\"4_3\":\"B2\",\"4_4\":\"B3\",\"4_5\":\"B4\",\"4_6\":\"B5\",\"4_7\":\"B6\",\"4_8\":\"B7\",\"5_1\":\"B8\",\"5_9\":\"B9\",\"6_1\":\"C1\",\"6_2\":\"C2\",\"6_3\":\"C3\",\"6_4\":\"C4\",\"6_6\":\"C5\",\"6_7\":\"C6\",\"6_8\":\"C7\",\"6_9\":\"C8\",\"7_1\":\"D1\",\"7_2\":\"D2\",\"7_3\":\"D3\",\"7_4\":\"D4\",\"7_6\":\"D5\",\"7_7\":\"D6\",\"7_8\":\"D7\",\"7_9\":\"D8\",\"8_1\":\"D9\",\"8_2\":\"D10\",\"8_3\":\"D11\",\"8_4\":\"D12\",\"8_6\":\"D13\",\"8_7\":\"D14\",\"8_8\":\"D15\",\"8_9\":\"D16\",\"9_1\":\"D17\",\"9_2\":\"D18\",\"9_3\":\"D19\",\"9_7\":\"D20\",\"9_8\":\"D21\",\"9_9\":\"D22\",\"10_2\":\"E1\",\"10_3\":\"E2\",\"10_4\":\"E3\",\"10_5\":\"E4\",\"10_6\":\"E5\",\"10_7\":\"E6\",\"10_8\":\"E7\"}}', 'This hall has a lot of facilities that we are very much interest in. I am hoping that it will be a great service to all of us', 1, '2020-07-01 21:41:07', '1', '0'),
(2, '244444', 'Nc9P0FguL7fobH2pV16r4ykSQijKlY8M', '11', '8', 74, 'Second Hall to Insert', '11111', '{\"blocked\":[\"4_2\",\"4_7\",\"2_1\",\"2_8\",\"10_2\",\"10_3\",\"10_6\",\"10_7\",\"6_2\",\"6_7\",\"7_4\",\"7_5\",\"9_1\",\"9_8\"],\"removed\":[\"8_2\",\"8_4\",\"8_5\",\"8_7\",\"5_4\",\"5_5\",\"2_4\",\"2_5\",\"11_4\",\"11_5\",\"11_1\",\"11_8\",\"10_4\",\"10_5\"],\"labels\":{\"1_1\":\"1\",\"1_2\":\"2\",\"1_3\":\"3\",\"1_4\":\"4\",\"1_5\":\"5\",\"1_6\":\"6\",\"1_7\":\"7\",\"1_8\":\"8\",\"2_1\":\"9\",\"2_2\":\"10\",\"2_3\":\"11\",\"2_6\":\"14\",\"2_7\":\"15\",\"2_8\":\"16\",\"3_1\":\"17\",\"3_2\":\"18\",\"3_3\":\"19\",\"3_4\":\"20\",\"3_5\":\"21\",\"3_6\":\"22\",\"3_7\":\"23\",\"3_8\":\"24\",\"4_1\":\"25\",\"4_2\":\"26\",\"4_3\":\"27\",\"4_4\":\"28\",\"4_5\":\"29\",\"4_6\":\"30\",\"4_7\":\"31\",\"4_8\":\"32\",\"5_1\":\"33\",\"5_2\":\"34\",\"5_3\":\"35\",\"5_6\":\"38\",\"5_7\":\"39\",\"5_8\":\"40\",\"6_1\":\"41\",\"6_2\":\"42\",\"6_3\":\"43\",\"6_4\":\"44\",\"6_5\":\"45\",\"6_6\":\"46\",\"6_7\":\"47\",\"6_8\":\"48\",\"7_1\":\"49\",\"7_2\":\"50\",\"7_3\":\"51\",\"7_4\":\"52\",\"7_5\":\"53\",\"7_6\":\"54\",\"7_7\":\"55\",\"7_8\":\"56\",\"8_1\":\"57\",\"8_3\":\"59\",\"8_6\":\"62\",\"8_8\":\"64\",\"9_1\":\"65\",\"9_2\":\"66\",\"9_3\":\"67\",\"9_4\":\"68\",\"9_5\":\"69\",\"9_6\":\"70\",\"9_7\":\"71\",\"9_8\":\"72\",\"10_1\":\"73\",\"10_2\":\"74\",\"10_3\":\"75\",\"10_6\":\"78\",\"10_7\":\"79\",\"10_8\":\"80\",\"11_2\":\"82\",\"11_3\":\"83\",\"11_6\":\"86\",\"11_7\":\"87\"}}', '', 7, '2020-07-01 21:44:12', '1', '0'),
(3, '244444', '1OV9ytXor7Qdu4lZc0Cqxhgk5WLTMesB', '7', '8', 46, 'Final Test No errors', '11111', '{\"blocked\":[\"1_1\",\"1_8\",\"4_4\",\"4_5\"],\"removed\":[\"7_4\",\"7_5\",\"1_1\",\"1_8\",\"6_1\",\"6_8\",\"6_3\",\"6_4\",\"6_5\",\"6_6\"],\"labels\":{\"1_2\":\"2\",\"1_3\":\"3\",\"1_4\":\"4\",\"1_5\":\"5\",\"1_6\":\"6\",\"1_7\":\"7\",\"2_1\":\"M9\",\"2_2\":\"10\",\"2_3\":\"11\",\"2_4\":\"12\",\"2_5\":\"13\",\"2_6\":\"M14\",\"2_7\":\"15\",\"2_8\":\"16\",\"3_1\":\"17\",\"3_2\":\"18\",\"3_3\":\"19\",\"3_4\":\"M20\",\"3_5\":\"21\",\"3_6\":\"M22\",\"3_7\":\"23\",\"3_8\":\"24\",\"4_1\":\"25\",\"4_2\":\"M26\",\"4_3\":\"27\",\"4_4\":\"\",\"4_5\":\"\",\"4_6\":\"30\",\"4_7\":\"M31\",\"4_8\":\"32\",\"5_1\":\"33\",\"5_2\":\"34\",\"5_3\":\"M35\",\"5_4\":\"36\",\"5_5\":\"37\",\"5_6\":\"M38\",\"5_7\":\"39\",\"5_8\":\"40\",\"6_2\":\"M42\",\"6_7\":\"47\",\"7_1\":\"49\",\"7_2\":\"50\",\"7_3\":\"51\",\"7_6\":\"54\",\"7_7\":\"55\",\"7_8\":\"56\"}}', 'This is the final test', 1, '2020-07-01 21:45:18', '1', '0'),
(5, '244444', 'CENwouk4yhHGXDfdixsgLrTlFtIp9jOq', '12', '12', 110, 'Craziest Hall With Seat', 'KidkkL949', '{\"blocked\":[],\"removed\":[\"1_1\",\"1_2\",\"1_11\",\"1_12\",\"2_4\",\"2_5\",\"2_6\",\"2_7\",\"2_8\",\"2_9\",\"4_6\",\"4_7\",\"6_3\",\"6_6\",\"6_7\",\"6_10\",\"7_6\",\"7_7\",\"8_6\",\"8_7\",\"9_1\",\"9_12\",\"10_1\",\"10_12\",\"11_1\",\"11_2\",\"11_11\",\"11_12\",\"12_1\",\"12_2\",\"12_3\",\"12_10\",\"12_11\",\"12_12\"],\"labels\":{\"1_3\":\"3\",\"1_4\":\"4\",\"1_5\":\"5\",\"1_6\":\"6\",\"1_7\":\"7\",\"1_8\":\"8\",\"1_9\":\"9\",\"1_10\":\"10\",\"2_1\":\"13\",\"2_2\":\"14\",\"2_3\":\"15\",\"2_10\":\"22\",\"2_11\":\"23\",\"2_12\":\"24\",\"3_1\":\"25\",\"3_2\":\"26\",\"3_3\":\"27\",\"3_4\":\"28\",\"3_5\":\"29\",\"3_6\":\"30\",\"3_7\":\"31\",\"3_8\":\"32\",\"3_9\":\"33\",\"3_10\":\"34\",\"3_11\":\"35\",\"3_12\":\"36\",\"4_1\":\"37\",\"4_2\":\"38\",\"4_3\":\"39\",\"4_4\":\"40\",\"4_5\":\"41\",\"4_8\":\"44\",\"4_9\":\"45\",\"4_10\":\"46\",\"4_11\":\"47\",\"4_12\":\"48\",\"5_1\":\"49\",\"5_2\":\"50\",\"5_3\":\"51\",\"5_4\":\"52\",\"5_5\":\"53\",\"5_6\":\"54\",\"5_7\":\"55\",\"5_8\":\"56\",\"5_9\":\"57\",\"5_10\":\"58\",\"5_11\":\"59\",\"5_12\":\"60\",\"6_1\":\"61\",\"6_2\":\"62\",\"6_4\":\"64\",\"6_5\":\"65\",\"6_8\":\"68\",\"6_9\":\"69\",\"6_11\":\"71\",\"6_12\":\"72\",\"7_1\":\"73\",\"7_2\":\"74\",\"7_3\":\"75\",\"7_4\":\"76\",\"7_5\":\"77\",\"7_8\":\"80\",\"7_9\":\"81\",\"7_10\":\"82\",\"7_11\":\"83\",\"7_12\":\"84\",\"8_1\":\"85\",\"8_2\":\"86\",\"8_3\":\"87\",\"8_4\":\"88\",\"8_5\":\"89\",\"8_8\":\"92\",\"8_9\":\"93\",\"8_10\":\"94\",\"8_11\":\"95\",\"8_12\":\"96\",\"9_2\":\"98\",\"9_3\":\"99\",\"9_4\":\"100\",\"9_5\":\"101\",\"9_6\":\"102\",\"9_7\":\"103\",\"9_8\":\"104\",\"9_9\":\"105\",\"9_10\":\"106\",\"9_11\":\"107\",\"10_2\":\"110\",\"10_3\":\"111\",\"10_4\":\"112\",\"10_5\":\"113\",\"10_6\":\"114\",\"10_7\":\"115\",\"10_8\":\"116\",\"10_9\":\"117\",\"10_10\":\"118\",\"10_11\":\"119\",\"11_3\":\"123\",\"11_4\":\"124\",\"11_5\":\"125\",\"11_6\":\"126\",\"11_7\":\"127\",\"11_8\":\"128\",\"11_9\":\"129\",\"11_10\":\"130\",\"12_4\":\"136\",\"12_5\":\"137\",\"12_6\":\"138\",\"12_7\":\"139\",\"12_8\":\"140\",\"12_9\":\"141\"}}', '', 0, '2020-07-02 08:18:32', '1', '0'),
(6, '244444', 'pQSP594rEGjlzyVOtae6YiTqfuhxvg8I', '2', '3', 6, 'jhgjhgj', 'KidkkL949', '{\"blocked\":[],\"removed\":[],\"labels\":{\"1_1\":1,\"1_2\":2,\"1_3\":3,\"2_1\":4,\"2_2\":5,\"2_3\":6}}', '', 0, '2020-07-02 09:07:00', '0', '1'),
(7, '244444', 'jsN64gp3daOnXiLSyzAEK0VuQ1qDbI5x', '7', '11', 53, 'Main Hall', 'KidkkL949', '{\"blocked\":[\"4_5\",\"4_6\",\"4_7\",\"7_3\",\"7_9\"],\"removed\":[\"1_1\",\"1_2\",\"1_10\",\"1_11\",\"6_1\",\"6_2\",\"6_10\",\"6_11\",\"7_4\",\"7_5\",\"7_6\",\"7_7\",\"7_8\",\"3_3\",\"3_4\",\"3_8\",\"3_9\",\"4_1\",\"4_11\"],\"labels\":{\"1_3\":\"M3\",\"1_4\":\"M4\",\"1_5\":\"M5\",\"1_6\":\"M6\",\"1_7\":\"M7\",\"1_8\":\"M8\",\"1_9\":\"M9\",\"2_1\":\"M22\",\"2_2\":\"M21\",\"2_3\":\"M20\",\"2_4\":\"M19\",\"2_5\":\"M18\",\"2_6\":\"M17\",\"2_7\":\"M16\",\"2_8\":\"M15\",\"2_9\":\"M14\",\"2_10\":\"M13\",\"2_11\":\"M12\",\"3_1\":\"R23\",\"3_2\":\"M24\",\"3_5\":\"M27\",\"3_6\":\"M28\",\"3_7\":\"M29\",\"3_10\":\"M32\",\"3_11\":\"M33\",\"4_2\":\"M43\",\"4_3\":\"M42\",\"4_4\":\"M41\",\"4_5\":\"M40\",\"4_6\":\"M39\",\"4_7\":\"M38\",\"4_8\":\"M37\",\"4_9\":\"M36\",\"4_10\":\"M35\",\"5_1\":\"R45\",\"5_2\":\"M46\",\"5_3\":\"M47\",\"5_4\":\"M48\",\"5_5\":\"M49\",\"5_6\":\"M50\",\"5_7\":\"M51\",\"5_8\":\"M52\",\"5_9\":\"M53\",\"5_10\":\"M54\",\"5_11\":\"M55\",\"6_3\":\"M58\",\"6_4\":\"M59\",\"6_5\":\"M60\",\"6_6\":\"M61\",\"6_7\":\"M62\",\"6_8\":\"M63\",\"6_9\":\"M64\",\"7_1\":\"R67\",\"7_2\":\"M68\",\"7_3\":\"M69\",\"7_9\":\"M75\",\"7_10\":\"M76\",\"7_11\":\"R77\"}}', 'test hall insert', 2, '2020-07-04 00:00:13', '1', '0');

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

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `client_guid`, `unique_guid`, `related_item`, `related_guid`, `message_type`, `recipient_count`, `recipient_list`, `recipient_status`, `subject`, `message`, `sms_units`, `created_on`, `created_by`, `current_status`, `deleted`) VALUES
(2, '244444', 'oJtDXrAgRBizseU92mFMZTlI3dv70ShC', 'event', 'TKOzIsL1nP25Xk3pHcJChfYBrmGoE0gR', 'sms', 4, '[{\"fullname\":\"Grace Obeng\",\"contact\":\"0240553604\"},{\"fullname\":\"Emmanuella Darko\",\"contact\":\"0240553604\"},{\"fullname\":\"Emmanuel Obeng\",\"contact\":\"0550107770\"},{\"fullname\":\"That is my name\",\"contact\":\"0550107770\"}]', NULL, 'Send Messages to 4 contacts', 'Select Event - Booked / Confirmed to Receive Mail Select Event - Booked / Confirmed to Receive Mail', 4, '2020-07-21 03:11:32', 'KidkkL949', 'pending', '0'),
(3, '244444', 'oJtDXrAgRBizseU92mFMZTlI3dv70Saa', 'event', 'TKOzIsL1nP25Xk3pHcJChfYBrmGoE0gR', 'sms', 4, '[{\"fullname\":\"Grace Obeng\",\"contact\":\"0240553604\"},{\"fullname\":\"Emmanuella Darko\",\"contact\":\"0240553604\"},{\"fullname\":\"Emmanuel Obeng\",\"contact\":\"0550107770\"},{\"fullname\":\"That is my name\",\"contact\":\"0550107770\"}]', NULL, 'Sent out an SMS to 4 contacts for the event: Test Event with longer name to list in there', 'Sending a follower up message to the list.', 4, '2020-07-21 04:15:26', 'KidkkL949', 'pending', '0'),
(4, '244444', 'WqknybOEI91jGfvcNPmatM63B82QL0U4', 'event', 'TKOzIsL1nP25Xk3pHcJChfYBrmGoE0gR', 'sms', 4, '[{\"fullname\":\"Grace Obeng\",\"contact\":\"0240553604\"},{\"fullname\":\"Emmanuella Darko\",\"contact\":\"0240553604\"},{\"fullname\":\"Emmanuel Obeng\",\"contact\":\"0550107770\"},{\"fullname\":\"That is my name\",\"contact\":\"0550107770\"}]', NULL, 'Sent out an SMS to 4 contacts for the event: Test Event with longer name to list in there', 'This is a message to all contacts list. i am confident that it will work out as i want it to work out for me.', 4, '2020-07-21 04:27:07', 'KidkkL949', 'pending', '0'),
(6, '244444', 'aGvbZxyjlD1r62V7z3gNIEKs8BndCTO0', 'contacts', NULL, 'sms', 10, '[{\"fullname\":\"Emmanuel Obeng\",\"contact\":\"0550107770\",\"category\":\"Confirmed\",\"event_guid\":\"TKOzIsL1nP25Xk3pHcJChfYBrmGoE0gR\"},{\"fullname\":\"Grace Obeng\",\"contact\":\"0240553604\",\"category\":\"Booked\",\"event_guid\":\"TKOzIsL1nP25Xk3pHcJChfYBrmGoE0gR\"},{\"fullname\":\"That is my name\",\"contact\":\"0550107770\",\"category\":\"Confirmed\",\"event_guid\":\"TKOzIsL1nP25Xk3pHcJChfYBrmGoE0gR\"},{\"fullname\":\"Emmanuella Darko\",\"contact\":\"0240553604\",\"category\":\"Booked\",\"event_guid\":\"TKOzIsL1nP25Xk3pHcJChfYBrmGoE0gR\"},{\"fullname\":\"Frank Amoah\",\"contact\":\"0540394930\",\"category\":\"Confirmed\",\"event_guid\":\"yo5xv0MFGRI6LdEjzNY7Xr4fkJ8K1m3W\"},{\"fullname\":\"Frank Amoah\",\"contact\":\"0550107771\",\"category\":\"Confirmed\",\"event_guid\":\"yo5xv0MFGRI6LdEjzNY7Xr4fkJ8K1m3W\"},{\"fullname\":\"Frank Amoah\",\"contact\":\"0550107770\",\"category\":\"Confirmed\",\"event_guid\":\"yo5xv0MFGRI6LdEjzNY7Xr4fkJ8K1m3W\"},{\"fullname\":\"Frank Amoah\",\"contact\":\"0240770100\",\"category\":\"Confirmed\",\"event_guid\":\"yo5xv0MFGRI6LdEjzNY7Xr4fkJ8K1m3W\"},{\"fullname\":\"Simon Kortey\",\"contact\":\"0550107000\",\"category\":\"Confirmed\",\"event_guid\":\"yo5xv0MFGRI6LdEjzNY7Xr4fkJ8K1m3W\"},{\"fullname\":\"Frank Solomons\",\"contact\":\"0550107000\",\"category\":\"Confirmed\",\"event_guid\":\"EWHJfZYme3w4FLyBjp6richQxd7b9D1k\"}]', NULL, 'Sent out an SMS to all 10 contacts in the database.', 'This is a message to all contacts list. i am confident that it will work out as i want it to work out for me.', 10, '2020-07-21 04:51:56', 'KidkkL949', 'pending', '0');

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

--
-- Dumping data for table `sms_subscribers`
--

INSERT INTO `sms_subscribers` (`id`, `client_guid`, `sms_package`, `sms_units`, `sender_id`) VALUES
(1, '244444', 'V8SMSGIT', 219, 'BookingLog');

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

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `client_guid`, `ticket_guid`, `ticket_title`, `number_generated`, `number_sold`, `number_left`, `is_payable`, `ticket_amount`, `created_on`, `created_by`, `generated`, `activated`, `status`) VALUES
(1, '244444', 'E6WFfhHscDNGX5jlQodPLrBeqi18S2xY', 'Tickets to use for some events', 100, 8, 92, '1', 40.00, '2020-07-05 17:06:32', 'KidkkL949', 'yes', '1', '1'),
(2, '244444', 'E8i4N1G0SqzcotKhBsxInkd7R6aZ9Le3', 'Another Ticket for Event', 300, 0, 0, '1', 100.00, '2020-07-05 17:06:57', 'KidkkL949', 'yes', '1', '1');

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

--
-- Dumping data for table `ticket_purchases`
--

INSERT INTO `ticket_purchases` (`id`, `ticket_id`, `event_id`, `fullname`, `contact`, `email`, `date_created`) VALUES
(7, '46', '2', 'Emmanuella Darko', '04849940049', 'jauntybae@gmail.com', '2020-07-29 07:06:50'),
(8, '19', '2', 'Emmanuel Obeng', '0550107770', 'emmallob14@gmail.com', '2020-07-29 07:06:50'),
(9, '8', '2', 'Name of Person', '0203317732', 'nameofperson@mail.com', '2020-07-29 07:07:54');

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

INSERT INTO `users` (`id`, `client_guid`, `user_guid`, `name`, `gender`, `email`, `username`, `password`, `access_level`, `theme`, `status`, `deleted`, `verify_token`, `last_login`, `last_login_attempts_time`, `contact`, `created_on`, `created_by`, `image`, `user_type`) VALUES
(1, '244444', 'KidkkL949', 'Demo User', 'Male', 'admin@mail.com', 'adminuser', '$2y$10$CsTd71XkkvbkgMwyZgyZ3.TtJ4LKj1yCQNkvswgbinVvD8JaJyJ/y', 1, '2', '1', '0', NULL, '2020-07-29 05:00:49', '2020-07-16 22:13:54', '44444444444', '2020-07-16 22:13:54', NULL, 'assets/img/profiles/nj7PqWXzRAcQH8mVKOurb1TYF.png', 'holder'),
(2, '244444', 'KidkkL9491', 'Voucher User', 'Male', 'demouser@mail.com', 'demouser', '$2y$10$CsTd71XkkvbkgMwyZgyZ3.TtJ4LKj1yCQNkvswgbinVvD8JaJyJ/y', 1, '2', '1', '0', NULL, '2020-07-17 09:43:44', '2020-07-16 22:13:54', '44444444444', '2020-07-16 22:13:54', NULL, 'assets/img/avatar.png', 'holder'),
(3, '244444', 'FW917546832', 'Emmanuel Obeng Hyde', NULL, 'moderator@mail.com', 'moderator', '$2y$10$Q/MWA6VjnrmAHI3ZVPPi.O.2clgVSw6EvXeeRrn3t5VZAKp7ETBRa', 2, '2', '1', '0', NULL, '2020-07-17 10:04:42', '2020-07-17 10:00:37', '334343434343', '2020-07-17 10:00:37', 'KidkkL9491', 'assets/img/avatar.png', 'user');

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
(1, 1, 'Admin', '{\"permissions\":{\"halls\":{\"list\":\"1\",\"add\":\"1\",\"configure\":1,\"update\":\"1\",\"delete\":\"1\"},\"events\":{\"list\":1,\"add\":1,\"update\":1,\"delete\":1,\"insight\":1},\"departments\":{\"list\":1,\"add\":1,\"update\":1,\"delete\":1},\"tickets\":{\"list\":1,\"generate\":1,\"delete\":1,\"sell\":1,\"reports\":1},\"users\":{\"manage\":1,\"delete\":1,\"accesslevel\":1},\"account\":{\"manage\":1,\"subscription\":1}}}'),
(2, 2, 'Moderator', '{\"permissions\":{\"halls\":{\"list\":\"1\",\"add\":\"1\",\"configure\":1,\"update\":\"1\",\"delete\":\"1\"},\"events\":{\"list\":1,\"add\":1,\"update\":1,\"delete\":1,\"insight\":1},\"departments\":{\"list\":1,\"add\":1,\"update\":1,\"delete\":1},\"tickets\":{\"list\":1,\"generate\":1,\"delete\":1,\"sell\":1,\"reports\":1}}}'),
(3, 3, 'Voucher Vendor', '{\"permissions\":{\"halls\":{\"list\":\"1\"},\"events\":{\"list\":1},\"departments\":{\"list\":1},\"tickets\":{\"list\":1,\"sell\":1,\"reports\":1}}}');

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

INSERT INTO `users_accounts` (`id`, `client_guid`, `client_abbr`, `client_key`, `name`, `email`, `phone`, `address`, `city`, `country`, `account_logo`, `date_created`, `activated`, `subscription`, `status`) VALUES
(1, '244444', 'kdm', NULL, 'Kwesi Dickson Memorial Methodist Society - Adjiringanor', 'testmailer@mail.com', '0550107770', 'test address', 'Accra City', 13, 'assets/img/meth_logo.jpg', '2020-07-01 21:18:18', '0', '{\"halls_created\":5,\"halls\":10,\"users\":12,\"users_created\":3,\"account_type\":\"basic\",\"expiry_date\":\"2021-01-01\"}', '1');

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

--
-- Dumping data for table `users_activity_logs`
--

INSERT INTO `users_activity_logs` (`id`, `client_guid`, `user_guid`, `page`, `item_guid`, `date_recorded`, `user_agent`, `description`) VALUES
(7, '244444', 'KidkkL949', 'ticket', 'DZ000046', '2020-07-29 07:04:20', 'Windows 10 | Chrome | ::1', 'Event: Ticket Based Event Ticket was sold out to Emmanuella Darko'),
(8, '244444', 'KidkkL949', 'ticket', 'DZ000019', '2020-07-29 07:06:12', 'Windows 10 | Chrome | ::1', 'Event: Ticket Based Event Ticket was sold out to Emmanuel Obeng'),
(9, '244444', 'KidkkL949', 'ticket', 'DZ000008', '2020-07-29 07:07:54', 'Windows 10 | Chrome | ::1', 'Event: Ticket Based Event Ticket was sold out to Name of Person'),
(10, '244444', 'KidkkL949', 'departments', 'Mez6F1RuHKA32ZvLWnNYPJ4qr7waIcCj', '2020-07-29 07:38:19', 'Windows 10 | Chrome | ::1', 'Updated the details of the department.');

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
(1, '244444', 'recovery', 'KidkkL949', '{\"recipients_list\":[{\"fullname\":\"Emmanuel Obeng\",\"email\":\"admin@mail.com\",\"customer_id\":\"KidkkL949\"}]}', '2020-07-02 08:24:57', '0', '[BookingLog] Change Password', 'Hi Emmanuel Obeng<br>You have requested to reset your password at BookingLog<br><br>Before you can reset your password please follow this link.<br><br><a class=\"alert alert-success\" href=\"http://localhost/booking/verify?password&token=q7FMh7moPzkLBiYud18cfdi6UF5RktJNTASgZUALDwHMqvOQpjBCwuhN8a6ExEXG5W1t\">Click Here to Reset Password</a><br><br>If it does not work please copy this link and place it in your browser url.<br><br>http://localhost/booking/verify?password&token=q7FMh7moPzkLBiYud18cfdi6UF5RktJNTASgZUALDwHMqvOQpjBCwuhN8a6ExEXG5W1t', 'KidkkL949', '0', NULL),
(2, '244444', 'recovery', 'FW651874392', '{\"recipients_list\":[{\"fullname\":\"testuser name\",\"email\":\"testusername@mail.com\",\"customer_id\":\"FW651874392\"}]}', '2020-07-16 21:56:10', '0', '[BookingLog] Change Password', 'Hi testuser name<br>You have successfully changed your password at BookingLog<br><br>Do ignore this message if your rightfully effected this change.<br><br>If not, do <a class=\"alert alert-success\" href=\"http://localhost/booking/recover\">Click Here</a> if you did not perform this act.', 'FW651874392', '0', NULL);

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

--
-- Dumping data for table `users_login_history`
--

INSERT INTO `users_login_history` (`id`, `client_guid`, `user_guid`, `username`, `lastlogin`, `log_ipaddress`, `log_browser`, `log_platform`) VALUES
(1, '244444', 'KidkkL949', 'admin@mail.com', '2020-07-28 22:35:41', '::1', 'Chrome|Windows 10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.89'),
(2, '244444', 'KidkkL949', 'admin@mail.com', '2020-07-29 05:00:49', '::1', 'Chrome|Windows 10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.89');

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

--
-- Dumping data for table `users_reset_request`
--

INSERT INTO `users_reset_request` (`id`, `username`, `user_guid`, `user_agent`, `token_status`, `request_token`, `reset_date`, `reset_agent`, `request_date`, `expiry_time`) VALUES
(1, 'demouser', 'KidkkL949', 'Chrome Windows 10|::1', 'USED', NULL, '2020-07-16 22:17:53', 'Chrome Windows 10|::1', '2020-07-16 22:17:18', 1594934273),
(2, 'admin', 'FW917546832', 'NIL', 'USED', NULL, '2020-07-17 10:04:29', 'Chrome Windows 10|::1', '2020-07-17 10:04:04', 1594976669);

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
-- Dumping data for table `users_roles`
--

INSERT INTO `users_roles` (`id`, `client_guid`, `user_guid`, `permissions`, `date_logged`, `last_updated`) VALUES
(1, '244444', 'KidkkL949', '{\"permissions\":{\"halls\":{\"list\":\"1\",\"add\":\"1\",\"configure\":1,\"update\":\"1\",\"delete\":\"1\"},\"events\":{\"list\":1,\"add\":1,\"update\":1,\"delete\":1,\"insight\":1},\"departments\":{\"list\":1,\"add\":1,\"update\":1,\"delete\":1},\"tickets\":{\"list\":1,\"generate\":1,\"delete\":1,\"sell\":1,\"reports\":1},\"users\":{\"manage\":1,\"delete\":1,\"accesslevel\":1},\"account\":{\"manage\":1,\"subscription\":1},\"communications\":{\"manage\":1}}}', '2020-07-02 09:03:11', '2020-07-17 09:41:12'),
(3, '244444', 'KidkkL9491', '{\"permissions\":{\"halls\":{\"list\":1,\"add\":1,\"configure\":1,\"update\":1},\"events\":{\"list\":1,\"add\":1,\"update\":1,\"insight\":1},\"departments\":{\"list\":1,\"add\":1,\"update\":1},\"tickets\":{\"list\":1,\"generate\":1},\"users\":{\"manage\":1,\"delete\":1},\"account\":{\"manage\":1,\"subscription\":1}}}', '2020-07-02 09:03:11', '2020-07-17 09:42:34'),
(4, '244444', 'FW917546832', '{\"permissions\":{\"halls\":{\"list\":\"1\",\"add\":\"1\",\"configure\":1,\"update\":\"1\",\"delete\":\"1\"},\"events\":{\"list\":1,\"add\":1,\"update\":1,\"delete\":1,\"insight\":1},\"departments\":{\"list\":1,\"add\":1,\"update\":1,\"delete\":1},\"tickets\":{\"list\":1,\"generate\":1,\"delete\":1,\"sell\":1,\"reports\":1}}}', '2020-07-17 10:00:37', '2020-07-17 10:00:37');

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
-- Indexes for table `email_list`
--
ALTER TABLE `email_list`
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
-- AUTO_INCREMENT for table `email_list`
--
ALTER TABLE `email_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `events_booking`
--
ALTER TABLE `events_booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `events_halls_configuration`
--
ALTER TABLE `events_halls_configuration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `events_media`
--
ALTER TABLE `events_media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `halls`
--
ALTER TABLE `halls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sms_subscribers`
--
ALTER TABLE `sms_subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tickets_listing`
--
ALTER TABLE `tickets_listing`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_purchases`
--
ALTER TABLE `ticket_purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users_data_monitoring`
--
ALTER TABLE `users_data_monitoring`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_email_list`
--
ALTER TABLE `users_email_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users_gender`
--
ALTER TABLE `users_gender`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users_login_history`
--
ALTER TABLE `users_login_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users_reset_request`
--
ALTER TABLE `users_reset_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users_roles`
--
ALTER TABLE `users_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
