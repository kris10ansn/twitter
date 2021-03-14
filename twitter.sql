-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 14, 2021 at 11:10 PM
-- Server version: 5.7.31
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `twitter`
--
CREATE DATABASE IF NOT EXISTS `twitter` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `twitter`;

-- --------------------------------------------------------

--
-- Table structure for table `follow`
--

DROP TABLE IF EXISTS `follow`;
CREATE TABLE IF NOT EXISTS `follow` (
  `follower_id` int(11) NOT NULL,
  `followed_id` int(11) NOT NULL,
  PRIMARY KEY (`follower_id`,`followed_id`),
  KEY `fk_follow_followed_id_idx` (`followed_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `follow`
--

INSERT INTO `follow` (`follower_id`, `followed_id`) VALUES
(11, 10),
(12, 10),
(10, 11),
(10, 12),
(10, 13);

-- --------------------------------------------------------

--
-- Table structure for table `hashtagged`
--

DROP TABLE IF EXISTS `hashtagged`;
CREATE TABLE IF NOT EXISTS `hashtagged` (
  `post_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`post_id`,`name`),
  KEY `fk_hashtagged_post_idx` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hashtagged`
--

INSERT INTO `hashtagged` (`post_id`, `name`) VALUES
(46, 'tutorial'),
(48, 'kommentarene'),
(49, 'tetrys');

-- --------------------------------------------------------

--
-- Table structure for table `like`
--

DROP TABLE IF EXISTS `like`;
CREATE TABLE IF NOT EXISTS `like` (
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`post_id`),
  KEY `fk_like_post_id_idx` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `like`
--

INSERT INTO `like` (`user_id`, `post_id`) VALUES
(10, 46),
(12, 46),
(13, 46),
(10, 49),
(12, 49),
(10, 52),
(12, 52),
(13, 52),
(14, 52),
(14, 53);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reply_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_post_1` (`user_id`),
  KEY `fk_post_reply_id_idx` (`reply_id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `user_id`, `text`, `created_at`, `reply_id`) VALUES
(46, 10, 'Velkommen @[11]stian til denne sosiale platformen. Du kan prøve å legge ut noe på &#34;Home&#34; tabben eller se hva andre (meg) har lagt ut under &#34;Explore&#34;. Følg, like og kommenter. #tutorial', '2021-03-14 21:46:05', NULL),
(48, 10, 'Som du kan se kan du se på #kommentarene til ethvert innlegg', '2021-03-14 21:48:52', 46),
(49, 12, 'Jeg elsker #tetrys https://chrome.google.com/webstore/detail/tetrys/bnchicpgbdgahiecgofdabidjihblaff', '2021-03-14 21:52:51', NULL),
(52, 13, 'Doge spelled backwards is Egod', '2021-03-14 22:34:49', NULL),
(53, 14, 'I am @[14]php. I was used in this project', '2021-03-14 22:38:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `biography` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Hello, World!',
  `favorite_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  KEY `fk_user_favorite_user_idx` (`favorite_user`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `username`, `firstname`, `lastname`, `password`, `created_at`, `biography`, `favorite_user`) VALUES
(10, 'kristian.nessa@protonmail.com', 'kristian', 'Kristian', 'Silli Nessa', '$2y$10$TGRaKGfzuJJcgpysG4u.UuFOJ8GqNV0IixpTJ13uGiYhDrilBkIl6', '2021-03-14 21:32:00', 'Elev på Sandnes Videregående skole&#13;&#10;&#13;&#10;https://github.com/kris10ansn/', 11),
(11, 'stian.bu.solgaard@skole.rogfk.no', 'stian', 'Stian', 'Bu Solgård', '$2y$10$HM7Vj8ZgKxl2v0u3wjriVezbH6NjDniDv/XmYaXbZSmKRzIOBs43y', '2021-03-14 21:33:09', 'Lektor på Sandnes videregående skole', NULL),
(12, 'anonym@kristian.fan', 'anonymkristianfan', 'Anonym', 'Kristian Fan', '$2y$10$uNG2Tf72gZJqVM61EqlNk.lMO2s5prVZVULWfbocew7tT8mDURTCG', '2021-03-14 21:52:11', 'Stor fan av @[10]kristian', 10),
(13, 'elonmusk@muskmail.com', 'elonmusk', 'Elon', 'Musk', '$2y$10$d.aRCEcQE.GVxCFZEvV5heAf7Wp/XUMJmfpluDGp/RcCBSLYh1XYq', '2021-03-14 22:32:27', 'Space X, Tesla, Hyperloop, The Boring company. I&#39;m an entrepreneur', NULL),
(14, 'php@email.com', 'php', 'PHP', 'Hypertext Preprocessor', '$2y$10$GmOxIsJ3kZfYw.dgXa6rduLiiSIirWPckm0Z7qLWDHa9nCNwzGpPC', '2021-03-14 22:38:43', 'PHP is a general-purpose scripting language especially suited to web development. My name is recursive, deal with it', 14);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `follow`
--
ALTER TABLE `follow`
  ADD CONSTRAINT `fk_follow_followed_id` FOREIGN KEY (`followed_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_follow_follower_id` FOREIGN KEY (`follower_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `hashtagged`
--
ALTER TABLE `hashtagged`
  ADD CONSTRAINT `fk_hashtagged_post` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `like`
--
ALTER TABLE `like`
  ADD CONSTRAINT `fk_like_post_id` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_like_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `fk_post_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_post_reply_id` FOREIGN KEY (`reply_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_favorite_user` FOREIGN KEY (`favorite_user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
