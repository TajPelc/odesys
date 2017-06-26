-- phpMyAdmin SQL Dump
-- version 4.6.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 26, 2017 at 02:45 PM
-- Server version: 5.6.33-0ubuntu0.14.04.1
-- PHP Version: 7.0.19-1+deb.sury.org~trusty+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `odesys-v3`
--

-- --------------------------------------------------------

--
-- Table structure for table `alternative`
--

CREATE TABLE `alternative` (
  `alternative_id` bigint(20) NOT NULL,
  `rel_model_id` bigint(20) NOT NULL,
  `title` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `score` double NOT NULL DEFAULT '0',
  `weightedScore` double NOT NULL DEFAULT '0',
  `color` varchar(7) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `criteria`
--

CREATE TABLE `criteria` (
  `criteria_id` bigint(20) NOT NULL,
  `rel_model_id` bigint(20) NOT NULL,
  `position` int(11) NOT NULL,
  `title` varchar(60) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `decision`
--

CREATE TABLE `decision` (
  `decision_id` bigint(20) NOT NULL,
  `rel_user_id` bigint(20) NOT NULL,
  `title` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `last_edit` datetime NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `view_privacy` tinyint(4) DEFAULT '0',
  `opinion_privacy` tinyint(4) DEFAULT '0',
  `deleted` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `decision_model`
--

CREATE TABLE `decision_model` (
  `model_id` bigint(20) NOT NULL,
  `rel_decision_id` bigint(20) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created` datetime NOT NULL,
  `last_edit` datetime NOT NULL,
  `updated` tinyint(4) NOT NULL DEFAULT '0',
  `criteria_complete` tinyint(4) NOT NULL DEFAULT '0',
  `alternatives_complete` tinyint(4) NOT NULL DEFAULT '0',
  `evaluation_complete` tinyint(4) NOT NULL DEFAULT '0',
  `analysis_complete` tinyint(4) NOT NULL DEFAULT '0',
  `no_alternatives` int(11) NOT NULL DEFAULT '0',
  `no_criteria` int(11) NOT NULL DEFAULT '0',
  `no_evaluation` int(11) NOT NULL DEFAULT '0',
  `description` text COLLATE utf8_unicode_ci,
  `preferred_alternative` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `evaluation`
--

CREATE TABLE `evaluation` (
  `rel_criteria_id` bigint(20) NOT NULL,
  `rel_alternative_id` bigint(20) NOT NULL,
  `grade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `identity`
--

CREATE TABLE `identity` (
  `identity_id` varchar(21) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `service` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rel_user_id` bigint(21) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notification_id` bigint(20) NOT NULL,
  `rel_user_id` bigint(20) NOT NULL,
  `type` int(11) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `opinion`
--

CREATE TABLE `opinion` (
  `opinion_id` bigint(20) NOT NULL,
  `rel_user_id` bigint(20) NOT NULL,
  `rel_decision_id` bigint(20) NOT NULL,
  `opinion` text COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

CREATE TABLE `token` (
  `id` int(11) UNSIGNED NOT NULL,
  `action` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `identity` char(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `token` char(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `expire_time` int(10) UNSIGNED DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` bigint(20) NOT NULL,
  `created` datetime NOT NULL,
  `lastvisit` datetime DEFAULT NULL,
  `config` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alternative`
--
ALTER TABLE `alternative`
  ADD PRIMARY KEY (`alternative_id`),
  ADD KEY `fk_table1_project1` (`rel_model_id`);

--
-- Indexes for table `criteria`
--
ALTER TABLE `criteria`
  ADD PRIMARY KEY (`criteria_id`),
  ADD KEY `fk_criteria_project1` (`rel_model_id`);

--
-- Indexes for table `decision`
--
ALTER TABLE `decision`
  ADD PRIMARY KEY (`decision_id`),
  ADD KEY `fk_decision_user1` (`rel_user_id`);

--
-- Indexes for table `decision_model`
--
ALTER TABLE `decision_model`
  ADD PRIMARY KEY (`model_id`),
  ADD KEY `fk_model_decision1` (`rel_decision_id`),
  ADD KEY `fk_decision_model_alternative1` (`preferred_alternative`);

--
-- Indexes for table `evaluation`
--
ALTER TABLE `evaluation`
  ADD PRIMARY KEY (`rel_criteria_id`,`rel_alternative_id`),
  ADD KEY `fk_evaluation_criteria1` (`rel_criteria_id`),
  ADD KEY `fk_evaluation_table11` (`rel_alternative_id`);

--
-- Indexes for table `identity`
--
ALTER TABLE `identity`
  ADD UNIQUE KEY `identity_id_UNIQUE` (`identity_id`),
  ADD KEY `fk_identity_user1` (`rel_user_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `fk_notification_user1` (`rel_user_id`);

--
-- Indexes for table `opinion`
--
ALTER TABLE `opinion`
  ADD PRIMARY KEY (`opinion_id`),
  ADD KEY `fk_opinions_user1` (`rel_user_id`),
  ADD KEY `fk_opinions_decision1` (`rel_decision_id`);

--
-- Indexes for table `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alternative`
--
ALTER TABLE `alternative`
  MODIFY `alternative_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6420;
--
-- AUTO_INCREMENT for table `criteria`
--
ALTER TABLE `criteria`
  MODIFY `criteria_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7704;
--
-- AUTO_INCREMENT for table `decision`
--
ALTER TABLE `decision`
  MODIFY `decision_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1784;
--
-- AUTO_INCREMENT for table `decision_model`
--
ALTER TABLE `decision_model`
  MODIFY `model_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1786;
--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notification_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `opinion`
--
ALTER TABLE `opinion`
  MODIFY `opinion_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `token`
--
ALTER TABLE `token`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=511;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `alternative`
--
ALTER TABLE `alternative`
  ADD CONSTRAINT `fk_table1_project1` FOREIGN KEY (`rel_model_id`) REFERENCES `decision_model` (`model_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `criteria`
--
ALTER TABLE `criteria`
  ADD CONSTRAINT `fk_criteria_project1` FOREIGN KEY (`rel_model_id`) REFERENCES `decision_model` (`model_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `decision`
--
ALTER TABLE `decision`
  ADD CONSTRAINT `fk_decision_user1` FOREIGN KEY (`rel_user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `decision_model`
--
ALTER TABLE `decision_model`
  ADD CONSTRAINT `fk_decision_model_alternative1` FOREIGN KEY (`preferred_alternative`) REFERENCES `alternative` (`alternative_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_model_decision1` FOREIGN KEY (`rel_decision_id`) REFERENCES `decision` (`decision_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `evaluation`
--
ALTER TABLE `evaluation`
  ADD CONSTRAINT `fk_evaluation_criteria1` FOREIGN KEY (`rel_criteria_id`) REFERENCES `criteria` (`criteria_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_evaluation_table11` FOREIGN KEY (`rel_alternative_id`) REFERENCES `alternative` (`alternative_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `identity`
--
ALTER TABLE `identity`
  ADD CONSTRAINT `fk_identity_user1` FOREIGN KEY (`rel_user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `fk_notification_user1` FOREIGN KEY (`rel_user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `opinion`
--
ALTER TABLE `opinion`
  ADD CONSTRAINT `fk_opinions_decision1` FOREIGN KEY (`rel_decision_id`) REFERENCES `decision` (`decision_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_opinions_user1` FOREIGN KEY (`rel_user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
