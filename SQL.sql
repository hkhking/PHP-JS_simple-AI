--
-- Table structure for table `2015log`
--

CREATE TABLE IF NOT EXISTS `2015log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `kind` varchar(50) NOT NULL DEFAULT '',
  `stime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ua` text NOT NULL,
  `ip` varchar(10) NOT NULL DEFAULT '',
  `statu` int(1) NOT NULL DEFAULT '2',
  `list` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product` (`product`,`kind`),
  KEY `stime` (`stime`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=398 ;

-- --------------------------------------------------------

--
-- Table structure for table `keywordlist`
--

CREATE TABLE IF NOT EXISTS `keywordlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `word` text NOT NULL,
  `product` varchar(50) NOT NULL DEFAULT '',
  `kind` varchar(50) NOT NULL DEFAULT '',
  `stime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `statu` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `product` (`product`,`kind`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=60 ;

-- --------------------------------------------------------

--
-- Table structure for table `questionbox`
--

CREATE TABLE IF NOT EXISTS `questionbox` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `answear` text NOT NULL,
  `product` varchar(50) NOT NULL DEFAULT '',
  `question` text NOT NULL,
  `kind` varchar(50) NOT NULL DEFAULT '',
  `statu` int(50) NOT NULL DEFAULT '0',
  `stime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `product` (`product`,`kind`),
  KEY `statu` (`product`,`statu`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=61 ;
