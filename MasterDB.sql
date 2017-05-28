CREATE TABLE IF NOT EXISTS `dashboard_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `timestamp` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `dashboard_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `timestamp` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `hotel_updates` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `timestamp` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `master_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(1000) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `longstory` text COLLATE latin1_general_ci,
  `shortstory` text COLLATE latin1_general_ci,
  `published` int(10) NOT NULL DEFAULT '0',
  `image` varchar(255) COLLATE latin1_general_ci DEFAULT '{@master_cdn}/img/mastercms.png',
  `campaign` int(1) NOT NULL DEFAULT '0',
  `campaignimg` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `author` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT '1',
  `comments` enum('0','1') COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci ROW_FORMAT=DYNAMIC;

CREATE TABLE IF NOT EXISTS `news_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) NOT NULL,
  `new_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `timestamp` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `news_likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) NOT NULL,
  `new_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `refers_awards` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `refers_amount` int(11) NOT NULL,
  `award_type` varchar(20) NOT NULL,
  `value` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `users_refer_limit` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) NOT NULL,
  `ref_limit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1; 

CREATE TABLE IF NOT EXISTS `user_awards` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) NOT NULL,
  `award_id` int(11) NOT NULL,
  `award_type` varchar(25) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `user_delete_code` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) NOT NULL,
  `code` text NOT NULL,
  `expire` int(50) NOT NULL,
  `timestamp` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `user_forgot_code` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) NOT NULL,
  `code` text NOT NULL,
  `expire` int(25) NOT NULL,
  `timestamp` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `user_refers` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `refered_user` varchar(15) NOT NULL,
  `user_id` int(11) NOT NULL,
  `datetime` int(15) NOT NULL,
  `refer_ip` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `user_verification_code` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) NOT NULL,
  `code` text NOT NULL,
  `expire` int(50) NOT NULL,
  `new_mail` varchar(100) NOT NULL,
  `timestamp` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `logs_client_staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `data_string` text NOT NULL,
  `machine_id` varchar(75) NOT NULL DEFAULT '',
  `timestamp` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `ranks` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `shortname` varchar(32) NOT NULL,
  `color` varchar(7) NOT NULL,
  `fuse_hide_staff` enum('0','1') NOT NULL DEFAULT '0',
  `badge` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

ALTER TABLE `ranks`
  ADD `fuse_hide_staff` enum('0','1') NOT NULL DEFAULT '0',
  ADD `color` varchar(7) NOT NULL,
  ADD `badge` varchar(32) NOT NULL;

ALTER TABLE `users`
  ADD `facebook_account` enum('0','1') NOT NULL DEFAULT '0',
  ADD `facebook_id` varchar(100) NOT NULL,
  ADD `facebook_completed` enum('0','1') NOT NULL,
  ADD `last_used` int(20) NOT NULL,
  ADD `pin` varchar(200) NOT NULL,
  ADD `client_pin` varchar(200) NOT NULL,
  ADD `staff_occult` enum('0','1') NOT NULL,
  ADD `work` varchar(50) NOT NULL,
  ADD `block_view_profile` enum('0','1') NOT NULL;

ALTER TABLE `users` CHANGE `auth_ticket` `auth_ticket` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE `users` CHANGE `password` `password` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
