--
-- Estrutura da tabela `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `mid` smallint(6) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `text` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`mid`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6385 ;

--
-- Gatilhos `messages`
--
DROP TRIGGER IF EXISTS `onMessage`;
DELIMITER //
CREATE TRIGGER `onMessage` AFTER INSERT ON `messages`
 FOR EACH ROW BEGIN
       UPDATE `users` SET `users`.`messages` = ( `users`.`messages` + 1 ) 
       WHERE `users`.`uid` = NEW.uid ;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(28) NOT NULL,
  `login` varchar(49) NOT NULL,
  `passwd` varchar(40) NOT NULL,
  `joined` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `messages` int(9) NOT NULL DEFAULT '0',
  `status` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `login` (`login`,`nickname`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;
