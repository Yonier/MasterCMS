CREATE TABLE `santi` (
  `id` int(11) NOT NULL,
  `bantype` enum('user','ip','machine') NOT NULL DEFAULT 'user',
  `value` varchar(50) NOT NULL,
  `reason` text NOT NULL,
  `expire` double NOT NULL DEFAULT '0',
  `added_by` varchar(50) NOT NULL,
  `added_date` varchar(50) NOT NULL
)