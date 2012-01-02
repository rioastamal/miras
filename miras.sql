-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `miras`
--

-- --------------------------------------------------------

--
-- Table structure for table `mr_acl`
--

CREATE TABLE IF NOT EXISTS `mr_acl` (
  `acl_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_type_id` int(3) unsigned NOT NULL,
  `acl_key` varchar(50) NOT NULL,
  `acl_value` char(1) NOT NULL,
  PRIMARY KEY (`acl_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `mr_acl`
--

INSERT INTO `mr_acl` (`acl_id`, `user_type_id`, `acl_key`, `acl_value`) VALUES
(1, 1, 'can_login', '1'),
(2, 2, 'can_login', '0');

-- --------------------------------------------------------

--
-- Table structure for table `mr_options`
--

CREATE TABLE IF NOT EXISTS `mr_options` (
  `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(75) NOT NULL,
  `option_value` text NOT NULL,
  `option_autoload` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`option_id`),
  KEY `OPTNAME_IDX` (`option_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `mr_options`
--

INSERT INTO `mr_options` (`option_id`, `option_name`, `option_value`, `option_autoload`) VALUES
(1, 'active_plugins', 'a:6:{i:0;s:10:"secure_url";i:1;s:13:"tugu_pahlawan";i:2;s:17:"core_user_manager";i:3;s:21:"core_resources_loader";i:4;s:21:"core_settings_manager";i:5;s:16:"core_role_editor";}', 1),
(2, 'site_theme', 'default', 1),
(3, 'site_title', 'Miras Framework', 1),
(4, 'site_description', 'A PHP Framework That Makes Beginner Happy', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mr_sessions`
--

CREATE TABLE IF NOT EXISTS `mr_sessions` (
  `session_id` varchar(32) NOT NULL,
  `session_value` text NOT NULL,
  `session_last_activity` int(10) NOT NULL,
  `session_user_agent` varchar(255) NOT NULL,
  `session_ip_addr` varchar(15) NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mr_sessions`
--

INSERT INTO `mr_sessions` (`session_id`, `session_value`, `session_last_activity`, `session_user_agent`, `session_ip_addr`) VALUES
('d8b8b706942255f26f8d0ed03c72da97', 'a:0:{}', 1325527938, 'Mozilla/5.0 (X11; Linux i686; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `mr_users`
--

CREATE TABLE IF NOT EXISTS `mr_users` (
  `user_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(16) NOT NULL,
  `user_first_name` varchar(20) NOT NULL,
  `user_last_name` varchar(20) NOT NULL,
  `user_pass` varchar(32) NOT NULL,
  `user_salt` char(8) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_type_id` int(3) unsigned NOT NULL,
  `user_status` tinyint(1) DEFAULT '1' COMMENT '0 = Deleted\n1 = Pending\n2 = Blocked\n3 = Active',
  PRIMARY KEY (`user_id`),
  KEY `USERNAME_IDX` (`user_name`,`user_status`),
  KEY `PASS_IDX` (`user_pass`),
  KEY `SEARCHABLE_IDX` (`user_email`,`user_last_name`,`user_first_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `mr_users`
--

INSERT INTO `mr_users` (`user_id`, `user_name`, `user_first_name`, `user_last_name`, `user_pass`, `user_salt`, `user_email`, `user_type_id`, `user_status`) VALUES
(1, 'admin', 'Super', 'Admin', '932c189a06cdced2f9ff0e0019d4c60c', 'd.{S.P|*', 'admin@localhost.org', 1, 3),
(2, 'guest', 'Anonymous', 'User', 'foobar', '12345', 'guest@localhost.com', 2, 3),
(4, 'oasis', 'OASIS', 'Band', '3f7244b46e080d82483aaf93fc8f2320', 'Qh#i+Sj1', 'oasis@localhost.org', 3, 2),
(6, 'beatle', 'The', 'Beatles', '0dd609b6661212a500f71bd7990a8523', 'Yaud(vb', 'beatle@localhost.org', 3, 2),
(8, 'xy', 'Speed', 'of Sound', '3fdad725386a7f9fad3f2e14d62d799a', 'Nm=A2A+X', 'coldplay@localhost.org', 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `mr_user_meta`
--

CREATE TABLE IF NOT EXISTS `mr_user_meta` (
  `user_meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `user_meta_name` varchar(50) NOT NULL,
  `user_meta_value` text NOT NULL,
  PRIMARY KEY (`user_meta_id`),
  KEY `META_NAME_IDX` (`user_meta_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `mr_user_meta`
--


-- --------------------------------------------------------

--
-- Table structure for table `mr_user_type`
--

CREATE TABLE IF NOT EXISTS `mr_user_type` (
  `user_type_id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `user_type_name` varchar(45) NOT NULL,
  PRIMARY KEY (`user_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `mr_user_type`
--

INSERT INTO `mr_user_type` (`user_type_id`, `user_type_name`) VALUES
(1, 'Administrator'),
(2, 'Guest'),
(3, 'Normal');
