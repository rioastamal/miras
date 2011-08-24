-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 21, 2011 at 04:53 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

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
  PRIMARY KEY (`acl_id`),
  KEY `fk_acl_user_type1` (`user_type_id`)
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
(1, 'active_plugins', 'a:2:{i:0;s:10:"secure_url";i:1;s:13:"tugu_pahlawan";}', 1),
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
('356de60cf571f3a9e5e949abbdc399df', 'a:2:{s:7:"user_id";s:1:"1";s:12:"is_logged_in";b:1;}', 1313938368, 'Mozilla/5.0 (X11; Linux i686; rv:2.0.1) Gecko/20100101 Firefox/4.0.1', '127.0.0.1'),
('4a277431339168cca0c7b6b52fb3cb83', 'a:0:{}', 1313909624, 'Mozilla/5.0 (X11; Linux i686; rv:2.0.1) Gecko/20100101 Firefox/4.0.1', '127.0.0.1');

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
  KEY `SEARCHABLE_IDX` (`user_email`,`user_last_name`,`user_first_name`),
  KEY `fk_users_user_type` (`user_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `mr_users`
--

INSERT INTO `mr_users` (`user_id`, `user_name`, `user_first_name`, `user_last_name`, `user_pass`, `user_salt`, `user_email`, `user_type_id`, `user_status`) VALUES
(1, 'admin', 'Super', 'Admin', '932c189a06cdced2f9ff0e0019d4c60c', 'd.{S.P|*', 'admin@localhost.org', 1, 3),
(2, 'guest', 'Anonymous', 'User', 'foobar', '12345', 'guest@localhost.com', 2, 3);

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
  KEY `FK_USER_ID` (`user_id`),
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `mr_user_type`
--

INSERT INTO `mr_user_type` (`user_type_id`, `user_type_name`) VALUES
(1, 'Administrator'),
(2, 'Guest');


