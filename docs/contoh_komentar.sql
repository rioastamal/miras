-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 07, 2011 at 12:56 PM
-- Server version: 5.1.37
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `berita21`
--

-- --------------------------------------------------------

--
-- Table structure for table `artikel_komentar`
--

CREATE TABLE IF NOT EXISTS `artikel_komentar` (
  `artikel_id` int(8) unsigned NOT NULL,
  `komentar_id` int(8) unsigned NOT NULL,
  PRIMARY KEY (`artikel_id`,`komentar_id`),
  KEY `fk_artikel_has_komentar_komentar1` (`komentar_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `artikel_komentar`
--

INSERT INTO `artikel_komentar` (`artikel_id`, `komentar_id`) VALUES
(1, 1),
(1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `komentar`
--

CREATE TABLE IF NOT EXISTS `komentar` (
  `komentar_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `komentar_nama` varchar(25) NOT NULL,
  `komentar_email` varchar(50) NOT NULL,
  `komentar_isi` text NOT NULL,
  `komentar_tgl` datetime NOT NULL,
  PRIMARY KEY (`komentar_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `komentar`
--

INSERT INTO `komentar` (`komentar_id`, `komentar_nama`, `komentar_email`, `komentar_isi`, `komentar_tgl`) VALUES
(1, 'hastin', 'hastin@susugede.com', 'kok iso'' sih....,gede.... :))', '2011-06-14 17:03:16'),
(2, 'yegi', 'yegi@menenk.com', 'silent rweek...., ojok banter" :))', '2011-07-05 17:04:05');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `artikel_komentar`
--
ALTER TABLE `artikel_komentar`
  ADD CONSTRAINT `fk_artikel_has_komentar_artikel` FOREIGN KEY (`artikel_id`) REFERENCES `artikel` (`artikel_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_artikel_has_komentar_komentar1` FOREIGN KEY (`komentar_id`) REFERENCES `komentar` (`komentar_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
