-- phpMyAdmin SQL Dump
-- version 3.1.2deb1ubuntu0.2
-- http://www.phpmyadmin.net
--
-- Gostitelj: localhost
-- Čas nastanka: 11 Okt 2010 ob 06:44 PM
-- Različica strežnika: 5.0.75
-- Različica PHP: 5.2.6-3ubuntu4.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Podatkovna baza: `hackslash`
--

-- --------------------------------------------------------

--
-- Struktura tabele `alternative`
--

CREATE TABLE IF NOT EXISTS `alternative` (
  `alternative_id` bigint(20) unsigned NOT NULL auto_increment,
  `rel_project_id` bigint(20) unsigned NOT NULL,
  `title` varchar(60) character set utf8 collate utf8_unicode_ci NOT NULL,
  `description` text character set utf8 collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`alternative_id`),
  KEY `rel_project_id` (`rel_project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=115 ;

-- --------------------------------------------------------

--
-- Struktura tabele `criteria`
--

CREATE TABLE IF NOT EXISTS `criteria` (
  `criteria_id` bigint(20) unsigned NOT NULL auto_increment,
  `rel_project_id` bigint(20) unsigned NOT NULL,
  `position` int(11) NOT NULL,
  `title` varchar(60) collate utf8_unicode_ci NOT NULL,
  `worst` varchar(30) collate utf8_unicode_ci NOT NULL,
  `best` varchar(30) collate utf8_unicode_ci NOT NULL,
  `description` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`criteria_id`),
  KEY `rel_project_id` (`rel_project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=306 ;

-- --------------------------------------------------------

--
-- Struktura tabele `evaluation`
--

CREATE TABLE IF NOT EXISTS `evaluation` (
  `evaluation_id` bigint(20) unsigned NOT NULL auto_increment,
  `rel_project_id` bigint(20) NOT NULL,
  `rel_criteria_id` bigint(20) unsigned NOT NULL,
  `rel_alternative_id` bigint(20) unsigned NOT NULL,
  `grade` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`evaluation_id`),
  KEY `rel_project_id` (`rel_criteria_id`,`rel_alternative_id`),
  KEY `rel_alternative_id` (`rel_alternative_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=346 ;

-- --------------------------------------------------------

--
-- Struktura tabele `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `project_id` bigint(20) unsigned NOT NULL auto_increment,
  `rel_user_id` bigint(20) NOT NULL,
  `title` varchar(200) collate utf8_unicode_ci NOT NULL,
  `description` text collate utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `finished` int(1) NOT NULL,
  `url` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=35 ;

-- --------------------------------------------------------

--
-- Struktura tabele `token`
--

CREATE TABLE IF NOT EXISTS `token` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `action` varchar(100) character set utf8 collate utf8_unicode_ci default NULL,
  `identity` char(32) character set utf8 collate utf8_unicode_ci NOT NULL,
  `token` char(32) character set utf8 collate utf8_unicode_ci default NULL,
  `data` text character set utf8 collate utf8_unicode_ci,
  `expire_time` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabele `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL auto_increment,
  `username` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `salt` varchar(128) character set utf8 collate utf8_unicode_ci NOT NULL,
  `email` varchar(128) NOT NULL,
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Omejitve tabel za povzetek stanja
--

--
-- Omejitve za tabelo `alternative`
--
ALTER TABLE `alternative`
  ADD CONSTRAINT `alternative_ibfk_1` FOREIGN KEY (`rel_project_id`) REFERENCES `project` (`project_id`);

--
-- Omejitve za tabelo `criteria`
--
ALTER TABLE `criteria`
  ADD CONSTRAINT `criteria_ibfk_1` FOREIGN KEY (`rel_project_id`) REFERENCES `project` (`project_id`);

--
-- Omejitve za tabelo `evaluation`
--
ALTER TABLE `evaluation`
  ADD CONSTRAINT `evaluation_ibfk_1` FOREIGN KEY (`rel_criteria_id`) REFERENCES `criteria` (`criteria_id`),
  ADD CONSTRAINT `evaluation_ibfk_2` FOREIGN KEY (`rel_alternative_id`) REFERENCES `alternative` (`alternative_id`);
