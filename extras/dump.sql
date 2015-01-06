-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 06, 2015 at 01:37 PM
-- Server version: 5.5.40
-- PHP Version: 5.4.36-0+deb7u1

CREATE DATABASE `gm`;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `gm`
--

USE `gm`;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_users` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `ganre` varchar(255) NOT NULL,
  `hashed_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_users` (`id_users`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `id_users`, `filename`, `title`, `ganre`, `hashed_name`) VALUES
(25, 2, 'Lana Del Rey - Playground [Another Lonely Day].mp3', 'Lana Del Rey - Playground', 'Lyrics', 'b376543e6ef0c608e11d5b50fd73bcf4.mp3'),
(26, 2, 'Lana Del Rey - You Can Be The Boss.mp3', 'Lana Del Rey - You Can Be The Boss', 'Lyrics', '504b10372ea27098d76ccde962e9efeb.mp3'),
(27, 2, 'Lana Del Rey - Is It Wrong.mp3', 'Lana Del Rey - Is It Wrong', 'Jazz', 'f8e79ee41f73a2597e0ae0348f487907.mp3');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login`, `password`) VALUES
(1, 'admin', '$2y$13$FLDJrQrs38Ya1/bh4SfjJuQCib8g79BcNCVETYp/88aGrrKYcIbsC'),
(2, 'test', '$2y$13$KRk.hWbeg089ObNiNB96zOSqmNYCV07guDMSE4pzgo/HeMOrjVDg.'),
(8, 'test2', '$2y$13$Y4iruDa.GfhRgbpYdEre.eIC8sBiIc1A2rSzHTvMNge79O2OH.wnq');
