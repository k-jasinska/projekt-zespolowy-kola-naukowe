-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Wersja serwera:               10.3.11-MariaDB - mariadb.org binary distribution
-- Serwer OS:                    Win64
-- HeidiSQL Wersja:              9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Zrzut struktury bazy danych pz_projekt
CREATE DATABASE IF NOT EXISTS `pz_projekt` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_polish_ci */;
USE `pz_projekt`;

-- Zrzut struktury tabela pz_projekt.account_types
CREATE TABLE IF NOT EXISTS `account_types` (
  `id_type` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id_type`),
  UNIQUE KEY `account_types_un` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Data exporting was unselected.
-- Zrzut struktury tabela pz_projekt.achievements
CREATE TABLE IF NOT EXISTS `achievements` (
  `id_achievements` int(11) NOT NULL AUTO_INCREMENT,
  `id_group_achievements` int(11) NOT NULL,
  `id_member` int(11) NOT NULL,
  PRIMARY KEY (`id_achievements`),
  KEY `achievements_member_fk` (`id_member`),
  CONSTRAINT `achievements_member_fk` FOREIGN KEY (`id_member`) REFERENCES `member` (`id_member`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Data exporting was unselected.
-- Zrzut struktury tabela pz_projekt.adding_requests
CREATE TABLE IF NOT EXISTS `adding_requests` (
  `id_adding` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_group` int(11) NOT NULL,
  PRIMARY KEY (`id_adding`),
  KEY `adding_requests_users_fk` (`id_user`),
  KEY `adding_requests_groups_fk` (`id_group`),
  CONSTRAINT `adding_requests_groups_fk` FOREIGN KEY (`id_group`) REFERENCES `groups` (`id_group`) ON UPDATE CASCADE,
  CONSTRAINT `adding_requests_users_fk` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Data exporting was unselected.
-- Zrzut struktury tabela pz_projekt.aplication_state
CREATE TABLE IF NOT EXISTS `aplication_state` (
  `id_aplication_state` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id_aplication_state`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Data exporting was unselected.
-- Zrzut struktury tabela pz_projekt.applications
CREATE TABLE IF NOT EXISTS `applications` (
  `id_application` int(11) NOT NULL AUTO_INCREMENT,
  `id_sender` int(11) NOT NULL,
  `id_reciever` int(11) NOT NULL,
  `id_state` int(11) NOT NULL,
  `file` varchar(1000) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id_application`),
  KEY `applications_users_fk` (`id_sender`),
  KEY `applications_users_fk_1` (`id_reciever`),
  KEY `applications_aplication_state_fk` (`id_state`),
  CONSTRAINT `applications_aplication_state_fk` FOREIGN KEY (`id_state`) REFERENCES `aplication_state` (`id_aplication_state`) ON UPDATE CASCADE,
  CONSTRAINT `applications_users_fk` FOREIGN KEY (`id_sender`) REFERENCES `users` (`id_user`) ON UPDATE CASCADE,
  CONSTRAINT `applications_users_fk_1` FOREIGN KEY (`id_reciever`) REFERENCES `users` (`id_user`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Data exporting was unselected.
-- Zrzut struktury tabela pz_projekt.authorization_tokens
CREATE TABLE IF NOT EXISTS `authorization_tokens` (
  `id_token` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `selector` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `token` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `expires` datetime DEFAULT NULL,
  PRIMARY KEY (`id_token`),
  KEY `authorization_tokens_users_fk` (`id_user`),
  CONSTRAINT `authorization_tokens_users_fk` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Data exporting was unselected.
-- Zrzut struktury tabela pz_projekt.events
CREATE TABLE IF NOT EXISTS `events` (
  `id_event` int(11) NOT NULL AUTO_INCREMENT,
  `id_owner` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `text` varchar(2000) COLLATE utf8_polish_ci DEFAULT NULL,
  `date` datetime NOT NULL,
  `event_date` date DEFAULT NULL,
  PRIMARY KEY (`id_event`),
  KEY `events_users_fk` (`id_owner`),
  CONSTRAINT `events_users_fk` FOREIGN KEY (`id_owner`) REFERENCES `users` (`id_user`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Data exporting was unselected.
-- Zrzut struktury tabela pz_projekt.groups
CREATE TABLE IF NOT EXISTS `groups` (
  `id_group` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `id_coordinator` int(11) NOT NULL,
  `description` varchar(1000) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id_group`),
  KEY `groups_users_fk` (`id_coordinator`),
  CONSTRAINT `groups_users_fk` FOREIGN KEY (`id_coordinator`) REFERENCES `users` (`id_user`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Data exporting was unselected.
-- Zrzut struktury tabela pz_projekt.group_achievements
CREATE TABLE IF NOT EXISTS `group_achievements` (
  `id_group_achievement` int(11) NOT NULL,
  `id_group` int(11) NOT NULL,
  `name` int(11) NOT NULL,
  `descryption` varchar(100) COLLATE utf8_polish_ci DEFAULT NULL,
  `image` varchar(1000) COLLATE utf8_polish_ci DEFAULT NULL,
  PRIMARY KEY (`id_group_achievement`),
  KEY `group_achievements_groups_fk` (`id_group`),
  CONSTRAINT `group_achievements_groups_fk` FOREIGN KEY (`id_group`) REFERENCES `groups` (`id_group`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Data exporting was unselected.
-- Zrzut struktury tabela pz_projekt.group_events
CREATE TABLE IF NOT EXISTS `group_events` (
  `id_group_events` int(11) NOT NULL AUTO_INCREMENT,
  `id_group` int(11) NOT NULL,
  `id_event` int(11) NOT NULL,
  PRIMARY KEY (`id_group_events`),
  KEY `group_events_groups_fk` (`id_group`),
  KEY `group_events_events_fk` (`id_event`),
  CONSTRAINT `group_events_events_fk` FOREIGN KEY (`id_event`) REFERENCES `events` (`id_event`) ON UPDATE CASCADE,
  CONSTRAINT `group_events_groups_fk` FOREIGN KEY (`id_group`) REFERENCES `groups` (`id_group`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Data exporting was unselected.
-- Zrzut struktury tabela pz_projekt.member
CREATE TABLE IF NOT EXISTS `member` (
  `id_member` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_group` int(11) NOT NULL,
  PRIMARY KEY (`id_member`),
  KEY `member_groups_fk` (`id_group`),
  KEY `member_users_fk` (`id_user`),
  CONSTRAINT `member_groups_fk` FOREIGN KEY (`id_group`) REFERENCES `groups` (`id_group`) ON UPDATE CASCADE,
  CONSTRAINT `member_users_fk` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Data exporting was unselected.
-- Zrzut struktury tabela pz_projekt.member_rights
CREATE TABLE IF NOT EXISTS `member_rights` (
  `id_member_right` int(11) NOT NULL AUTO_INCREMENT,
  `id_member` int(11) NOT NULL,
  `id_right` int(11) NOT NULL,
  PRIMARY KEY (`id_member_right`),
  KEY `member_rights_rights_fk` (`id_right`),
  KEY `member_rights_member_fk` (`id_member`),
  CONSTRAINT `member_rights_member_fk` FOREIGN KEY (`id_member`) REFERENCES `member` (`id_member`) ON UPDATE CASCADE,
  CONSTRAINT `member_rights_rights_fk` FOREIGN KEY (`id_right`) REFERENCES `rights` (`id_right`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Data exporting was unselected.
-- Zrzut struktury tabela pz_projekt.messages
CREATE TABLE IF NOT EXISTS `messages` (
  `id_message` int(11) NOT NULL AUTO_INCREMENT,
  `id_user_from` int(11) NOT NULL,
  `id_user_to` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf8_polish_ci NOT NULL DEFAULT 'no title',
  `message` varchar(2000) COLLATE utf8_polish_ci DEFAULT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id_message`),
  KEY `messages_users_fk` (`id_user_from`),
  KEY `messages_users_fk_1` (`id_user_to`),
  CONSTRAINT `messages_users_fk` FOREIGN KEY (`id_user_from`) REFERENCES `users` (`id_user`) ON UPDATE CASCADE,
  CONSTRAINT `messages_users_fk_1` FOREIGN KEY (`id_user_to`) REFERENCES `users` (`id_user`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Data exporting was unselected.
-- Zrzut struktury tabela pz_projekt.news
CREATE TABLE IF NOT EXISTS `news` (
  `id_news` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `text` varchar(1000) COLLATE utf8_polish_ci DEFAULT NULL,
  `href` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_news`),
  KEY `news_users_fk` (`id_user`),
  CONSTRAINT `news_users_fk` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Data exporting was unselected.
-- Zrzut struktury tabela pz_projekt.posts
CREATE TABLE IF NOT EXISTS `posts` (
  `id_post` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_group` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `text` varchar(2000) COLLATE utf8_polish_ci DEFAULT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id_post`),
  KEY `posts_users_fk` (`id_user`),
  KEY `posts_groups_fk` (`id_group`),
  CONSTRAINT `posts_groups_fk` FOREIGN KEY (`id_group`) REFERENCES `groups` (`id_group`) ON UPDATE CASCADE,
  CONSTRAINT `posts_users_fk` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Data exporting was unselected.
-- Zrzut struktury tabela pz_projekt.reactions
CREATE TABLE IF NOT EXISTS `reactions` (
  `id_reaction` int(11) NOT NULL AUTO_INCREMENT,
  `id_event` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_reaction_type` int(11) NOT NULL,
  PRIMARY KEY (`id_reaction`),
  KEY `reactions_users_fk` (`id_user`),
  KEY `reactions_events_fk` (`id_event`),
  KEY `reactions_reaction_types_fk` (`id_reaction_type`),
  CONSTRAINT `reactions_events_fk` FOREIGN KEY (`id_event`) REFERENCES `events` (`id_event`) ON UPDATE CASCADE,
  CONSTRAINT `reactions_reaction_types_fk` FOREIGN KEY (`id_reaction_type`) REFERENCES `reaction_types` (`id_reaction_type`) ON UPDATE CASCADE,
  CONSTRAINT `reactions_users_fk` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Data exporting was unselected.
-- Zrzut struktury tabela pz_projekt.reaction_types
CREATE TABLE IF NOT EXISTS `reaction_types` (
  `id_reaction_type` int(11) NOT NULL AUTO_INCREMENT,
  `id_event` int(11) DEFAULT NULL,
  `description` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `image` varchar(1000) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id_reaction_type`),
  KEY `reaction_types_events_fk` (`id_event`),
  CONSTRAINT `reaction_types_events_fk` FOREIGN KEY (`id_event`) REFERENCES `events` (`id_event`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Data exporting was unselected.
-- Zrzut struktury tabela pz_projekt.rights
CREATE TABLE IF NOT EXISTS `rights` (
  `id_right` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id_right`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Data exporting was unselected.
-- Zrzut struktury tabela pz_projekt.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id_s` int(11) NOT NULL AUTO_INCREMENT,
  `id_session` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `id_user` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  PRIMARY KEY (`id_s`),
  KEY `sessions_users_fk` (`id_user`),
  CONSTRAINT `sessions_users_fk` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Data exporting was unselected.
-- Zrzut struktury tabela pz_projekt.users
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `id_state` int(11) NOT NULL,
  `email` varchar(40) COLLATE utf8_polish_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `surname` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `id_type` int(11) NOT NULL,
  `password` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `users_un` (`email`),
  KEY `users_user_state_fk` (`id_state`),
  KEY `users_account_types_fk` (`id_type`),
  CONSTRAINT `users_account_types_fk` FOREIGN KEY (`id_type`) REFERENCES `account_types` (`id_type`) ON UPDATE CASCADE,
  CONSTRAINT `users_user_state_fk` FOREIGN KEY (`id_state`) REFERENCES `user_state` (`ID_USER_STATE`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Data exporting was unselected.
-- Zrzut struktury tabela pz_projekt.user_state
CREATE TABLE IF NOT EXISTS `user_state` (
  `ID_USER_STATE` int(11) NOT NULL,
  `NAME` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  PRIMARY KEY (`ID_USER_STATE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
