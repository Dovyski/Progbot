-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 11, 2013 at 06:36 PM
-- Server version: 5.5.20
-- PHP Version: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `codebot`
--

-- --------------------------------------------------------

--
-- Table structure for table `challenges`
--

CREATE TABLE IF NOT EXISTS `challenges` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fk_category` int(11) unsigned NOT NULL,
  `date` int(11) NOT NULL,
  `description` text NOT NULL,
  `name` varchar(255) NOT NULL,
  `level` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `level` (`level`),
  KEY `fk_category` (`fk_category`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE IF NOT EXISTS `programs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fk_user` int(11) unsigned NOT NULL,
  `fk_challenge` int(11) unsigned NOT NULL,
  `date` int(11) NOT NULL,
  `code` text NOT NULL,
  `code_history` text NOT NULL,
  `last_update` int(11) NOT NULL,
  `grade` int(11) NOT NULL DEFAULT '-1',
  `locked` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user` (`fk_user`,`fk_challenge`),
  KEY `fk_challenge` (`fk_challenge`),
  KEY `fk_user_2` (`fk_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`),
  KEY `password` (`password`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `programs`
--
ALTER TABLE `programs`
  ADD CONSTRAINT `programs_ibfk_2` FOREIGN KEY (`fk_challenge`) REFERENCES `challenges` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `programs_ibfk_1` FOREIGN KEY (`fk_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
