-- Adminer 3.6.4 MySQL dump

SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = '+02:00';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `forums`;
CREATE TABLE `forums` (
  `tid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `pid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `message` longtext NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT '',
  `time` int(14) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`pid`),
  KEY `tid` (`tid`),
  KEY `uid` (`uid`),
  KEY `status` (`status`),
  KEY `time` (`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `forums_title`;
CREATE TABLE `forums_title` (
  `fid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `p_fid` bigint(20) unsigned DEFAULT '0',
  `last_pid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `titre` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `moderator` varchar(255) NOT NULL DEFAULT '',
  `nb_topics` bigint(20) NOT NULL DEFAULT '0',
  `nb_posts` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`fid`),
  KEY `last_pid` (`last_pid`),
  KEY `p_fid` (`p_fid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `forums_title` (`fid`, `p_fid`, `last_pid`, `titre`, `description`, `moderator`, `nb_topics`, `nb_posts`) VALUES
(0,	NULL,	0,	'Discussions diverses',	'ici parlez de ce que vous voulez...',	'',	0,	0);

DROP TABLE IF EXISTS `forums_topics`;
CREATE TABLE `forums_topics` (
  `fid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `tid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `sujet` varchar(255) NOT NULL DEFAULT '',
  `status` varchar(20) NOT NULL DEFAULT '',
  `posts` bigint(20) unsigned NOT NULL DEFAULT '0',
  `first_pid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `last_pid` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`tid`),
  KEY `fid` (`fid`),
  KEY `uid` (`uid`),
  KEY `last_pid` (`last_pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `online`;
CREATE TABLE `online` (
  `IP` varchar(15) NOT NULL DEFAULT '',
  `time` int(14) unsigned NOT NULL DEFAULT '0',
  `site` bigint(20) unsigned NOT NULL DEFAULT '0',
  `user` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`IP`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='personnes online';

INSERT INTO `online` (`IP`, `time`, `site`, `user`) VALUES
('86.207.222.252',	1345596040,	1,	'Visiteur'),
('98.14.88.144',	1344910937,	1,	'Visiteur'),
('83.194.41.79',	1344909992,	1,	'sebbu'),
('83.194.47.37',	1359821469,	1,	'Visiteur'),
('83.194.49.160',	1362513197,	1,	'Visiteur'),
('82.241.53.88',	1362513557,	1,	'Visiteur'),
('83.194.33.93',	1363814484,	1,	'Visiteur'),
('41.249.91.88',	1363814545,	1,	'Visiteur');

DROP TABLE IF EXISTS `priv_msg`;
CREATE TABLE `priv_msg` (
  `mid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `uid1` bigint(20) unsigned NOT NULL DEFAULT '0',
  `uid2` bigint(20) unsigned NOT NULL DEFAULT '0',
  `sujet` varchar(255) NOT NULL DEFAULT '',
  `message` longtext NOT NULL,
  `time` int(14) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`mid`),
  KEY `uid1` (`uid1`),
  KEY `uid2` (`uid2`),
  KEY `sujet` (`sujet`),
  KEY `time` (`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `skins`;
CREATE TABLE `skins` (
  `sid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `nom` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='skins du forum';

INSERT INTO `skins` (`sid`, `nom`) VALUES
(0,	'Skin par d&eacute;faut'),
(1,	'skin de test');

DROP TABLE IF EXISTS `smile`;
CREATE TABLE `smile` (
  `smile` varchar(255) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL DEFAULT '',
  `titre` varchar(255) NOT NULL DEFAULT '',
  UNIQUE KEY `smile` (`smile`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `smile` (`smile`, `image`, `titre`) VALUES
(':D',	'icon_mrgreen.gif',	'Gnarc !'),
(':-D',	'biggerGrin.gif',	'Gnaaaarc !'),
(':non:',	'ripeer.gif',	'Pas du tout !'),
(':mdr:',	'laugh.gif',	'lol'),
(':8',	'lunettes1.gif',	'Cool'),
(':craint:',	'frown.gif',	'Mais '),
(':pleure:',	'pleure.gif',	'Ouiiiiiiiiin !!'),
(':mad2:',	'mad2.gif',	'Totalement malade...'),
(':oops:',	'icon_redface.gif',	'Embarassed'),
(':roll:',	'icon_rolleyes.gif',	'Arf !'),
(':incline:',	'bowdown.gif',	'Je m\'incline...'),
(':yes:',	'yaisse.gif',	'Trop top gars !'),
(':chinois:',	'chinese.gif',	'Je suis d\'accord !'),
(':fumer:',	'hat.gif',	'Mouais...'),
(':love:',	'love.gif',	'Love !'),
(':keskidit:',	'keskidit2.gif',	'Kes ki dit ?'),
(':byebye:',	'byebye.gif',	'Bye bye !'),
(':fou:',	'fou.gif',	'Fou !!!'),
(':eek2:',	'eek2.gif',	'Hallucinant !!!'),
(':bravo:',	'bravo.gif',	'Bravo !!!'),
(':reflechis:',	'reflechis.gif',	'je reflechis...'),
(':dors:',	'dors2.gif',	'ZzZz...'),
(':cartonjaune:',	'cartonjaune.gif',	'carton jaune'),
(':cartonrouge:',	'cartonrouge.gif',	'carton rouge'),
(':mad:',	'mad_pci.gif',	'T malade ???'),
(':smack:',	'smack.gif',	'Smaaaaack !'),
(':ouioui:',	'ouioui.gif',	'Totalement d\'accord'),
(':censored:',	'censored.gif',	'censur&eacute;'),
(':mellow:',	'mellow.gif',	'mellow'),
(':huh:',	'huh.gif',	'huh'),
('^_^',	'happy.gif',	'^_^'),
(':o',	'ohmy.gif',	':o'),
(';)',	'wink.gif',	';)'),
(':P',	'tongue.gif',	':P'),
(':lol:',	'laugh.gif',	'lol'),
('B)',	'cool.gif',	'B)'),
(':rolleyes:',	'rolleyes.gif',	'rolleyes'),
('-_-',	'sleep.gif',	'-_-'),
('&lt;_&lt;',	'dry.gif',	'&lt;_&lt;'),
(':)',	'smile.gif',	':)'),
(':wub:',	'wub.gif',	'wub'),
(':angry:',	'mad.gif',	'angry'),
(':(',	'sad.gif',	':('),
(':unsure:',	'unsure.gif',	'unsure'),
(':wacko:',	'wacko.gif',	'wacko'),
(':blink:',	'blink.gif',	'blink'),
(':ph34r:',	'ph34r.gif',	'ph34r'),
(':-(',	'sad.gif',	':-('),
(':wink:',	'wink.gif',	'wink');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `login` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(255) NOT NULL DEFAULT '',
  `pass` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `show_email` enum('yes','no') NOT NULL DEFAULT 'yes',
  `site` varchar(255) NOT NULL DEFAULT '',
  `commentaire` mediumtext NOT NULL,
  `signature` mediumtext NOT NULL,
  `avatar` varchar(255) NOT NULL DEFAULT '',
  `aim` varchar(255) NOT NULL DEFAULT '',
  `msn` varchar(255) NOT NULL DEFAULT '',
  `yahoo` varchar(255) NOT NULL DEFAULT '',
  `icq` varchar(255) NOT NULL DEFAULT '',
  `status` varchar(20) NOT NULL DEFAULT '',
  `regkey` varchar(64) NOT NULL DEFAULT '',
  `grade` varchar(255) NOT NULL DEFAULT '',
  `sid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `opt` varchar(255) NOT NULL DEFAULT '',
  `lastvisite_time` int(14) NOT NULL DEFAULT '0',
  `MP` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `login` (`login`),
  KEY `username` (`username`),
  KEY `pass` (`pass`),
  KEY `sid` (`sid`),
  KEY `lastvisite_time` (`lastvisite_time`),
  KEY `grade` (`grade`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `users` (`uid`, `login`, `username`, `pass`, `email`, `show_email`, `site`, `commentaire`, `signature`, `avatar`, `aim`, `msn`, `yahoo`, `icq`, `status`, `regkey`, `grade`, `sid`, `opt`, `lastvisite_time`, `MP`) VALUES
(1,	'sebbu',	'sebbu',	MD5('pass'),	'zsbe17fr@yahoo.fr',	'yes',	'http://www.sebbu.fr/',	'voil&agrave;',	'sebbu',	'avatars/sebbu.gif',	'cdefg55',	'zsbe17fr@yahoo.fr',	'zsbe17fr',	'169807976',	'active',	'',	'administrateur',	1,	'',	16,	0),
(0,	'Visiteur',	'Visiteur',	'',	'',	'no',	'',	'',	'',	'',	'',	'',	'',	'',	'not registered',	'',	'visiteur',	0,	'',	0,	0);

-- 2013-05-04 11:26:33
