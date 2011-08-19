-- This file SHOULD NOT executed directly since its containt some prefix
-- that will be replace during script installation
--
-- Table structure for table `acl`
--

CREATE TABLE IF NOT EXISTS `MR_PREFIX_acl` (
  `acl_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_type_id` int(3) unsigned NOT NULL,
  `acl_key` varchar(50) NOT NULL,
  `acl_value` char(1) NOT NULL,
  PRIMARY KEY (`acl_id`),
  KEY `fk_acl_user_type1` (`user_type_id`)
) ENGINE=MR_ENGINE_DB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE IF NOT EXISTS `MR_PREFIX_options` (
  `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(75) NOT NULL,
  `option_value` text NOT NULL,
  `option_autoload` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`option_id`),
  KEY `OPTNAME_IDX` (`option_name`)
) ENGINE=MR_ENGINE_DB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `MR_PREFIX_sessions` (
  `session_id` varchar(32) NOT NULL,
  `session_value` text NOT NULL,
  `session_last_activity` int(10) NOT NULL,
  `session_user_agent` varchar(255) NOT NULL,
  `session_ip_addr` varchar(15) NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=MR_ENGINE_DB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `MR_PREFIX_users` (
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
) ENGINE=MR_ENGINE_DB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_meta`
--

CREATE TABLE IF NOT EXISTS `MR_PREFIX_user_meta` (
  `user_meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `user_meta_name` varchar(50) NOT NULL,
  `user_meta_value` text NOT NULL,
  PRIMARY KEY (`user_meta_id`),
  KEY `FK_USER_ID` (`user_id`),
  KEY `META_NAME_IDX` (`user_meta_name`)
) ENGINE=MR_ENGINE_DB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE IF NOT EXISTS `MR_PREFIX_user_type` (
  `user_type_id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `user_type_name` varchar(45) NOT NULL,
  PRIMARY KEY (`user_type_id`)
) ENGINE=MR_ENGINE_DB  DEFAULT CHARSET=utf8;

INSERT INTO `MR_PREFIX_user_type` (`user_type_id`, `user_type_name`) VALUES
(1, 'Administrator'),
(2, 'Guest');


INSERT INTO `MR_PREFIX_users` (`user_id`, `user_name`, `user_first_name`, `user_last_name`, `user_pass`, `user_salt`, `user_email`, `user_type_id`, `user_status`) VALUES
(1, 'MR_USERNAME', 'MR_FIRST_NAME', 'MR_LAST_NAME', 'MR_PASSWORD', 'MR_SALT', 'MR_EMAIL', 1, 3),
(2, 'guest', 'Anonymous', 'User', 'foobar', '12345', 'guest@localhost.com', 2, 3);


INSERT INTO `MR_PREFIX_options` (`option_id`, `option_name`, `option_value`, `option_autoload`) VALUES
(1, 'active_plugins', 'a:2:{i:0;s:10:"secure_url";i:1;s:13:"tugu_pahlawan";}', 1),
(2, 'site_theme', 'default', 1),
(3, 'site_title', 'Miras Framework', 1),
(4, 'site_description', 'A PHP Framework That Makes Beginner Happy', 1);

INSERT INTO `MR_PREFIX_acl` (`acl_id`, `user_type_id`, `acl_key`, `acl_value`) VALUES
(1, 1, 'can_login', '1'),
(2, 2, 'can_login', '0');
